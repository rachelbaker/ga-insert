<?php
/*
Plugin Name: Google Analytics Insert
Plugin URI: http://www.rachelbaker.me
Description: Inserts the optimized Google Analytics snippet from the HTML5 Boilerplate.
Version: 1.0
Author: Rachel Baker
Author URI: http://www.rachelbaker.me
Author Email: rachel@rachelbaker.me

License:
    Google Analytics Insert
    Copyright (C) 2012  Rachel Baker, Plugged In Consulting, Inc.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

class GAInsert {

	function __construct() {

		load_plugin_textdomain( 'ga-insert', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		add_action( 'init', array( &$this, 'init' ) );
		add_action('admin_menu', array(&$this, 'admin_menu'));
		//register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

	} // end constructor

	public function init() {
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'admin_init', array( &$this,'register_options') );
	}

	function admin_menu() {
		add_options_page('GA Insert Options','GA Insert Options','manage_options','ga-insert-options',array($this, 'view_options'));
	}

	function view_options() {
		include 'views/admin.php';
	}

	function register_options() {
		register_setting( 'gainsert_plugin_options', 'gainsert_options', array(&$this, 'validate') );
	}

	function validate($input) {
		$input['id'] =  wp_filter_nohtml_kses($input['id']);
		return $input;
	}

	public function get_ga_id() {
		$options = get_option( 'gainsert_options' );
		$ga_id = $options['id'];
		return $ga_id;
	}

	public function deactivate( $network_wide ) {
		 delete_option('gainsert_options');
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'ga_js', plugins_url( 'ga-insert/js/ga.js' ) );
		$ga_id = $this->get_ga_id();
		wp_localize_script('ga_js', 'gainsert_vars', array(
			'id' => $ga_id
			)
		);
	}


} new GAInsert();