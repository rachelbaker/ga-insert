<!-- This file is used to markup the administration form of the plugin.. -->
<div class="wrap">
	<?php echo "<h2>".__('GA Insert Options')."</h2>";?>
	<form method="post" action="options.php">
		<?php settings_fields( 'gainsert_plugin_options' ); ?>
					<?php $options = get_option( 'gainsert_options' ); ?>
		<ul>
        <li><label for="id"><?php echo __('Tracking ID'); ?>: </label>
        	<input name="gainsert_options[id]" type="text" value="<?php echo $options['id']; ?>" />
        </li>

    </ul>
    <?php submit_button(); ?>
	</form>

</div>