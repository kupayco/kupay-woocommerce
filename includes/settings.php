<?php

function create_settings_menu(){

	$page_title = 'Kupay Settings';
	$menu_title = 'Kupay';
	$capability = 'manage_options';
	$menu_slug  = 'kupay-info';
	$function   = 'create_settings_page';
	$icon_url   = 'dashicons-media-code';
	$position   = 4;

	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

	register_setting( 'kupay_options_group', 'kupay_options_app_id');
	register_setting( 'kupay_options_group', 'kupay_options_enable_pdp');
	register_setting( 'kupay_options_group', 'kupay_options_enable_cart');

}

function create_settings_page(){
	?>
	<div>
		<h2>Kupay Settings</h2>

		<form method="post" action="options.php">

            <?php settings_fields( 'kupay_options_group' ); ?>

			<label for="kupay_options_app_id">App ID</label>
			<input type="text" id="kupay_options_app_id" name="kupay_options_app_id" value="<?php echo get_option('kupay_options_app_id'); ?>" />

            <br>

            <label for="kupay_options_app_key">App Key</label>
            <input type="text" id="kupay_options_app_key" name="kupay_options_app_key" value="<?php echo get_option('kupay_options_app_key'); ?>" />

			<?php  submit_button(); ?>
		</form>
	</div>
	<?php
}