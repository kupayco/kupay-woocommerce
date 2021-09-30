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

	register_setting( 'kupay_options_group', 'kupay_options_app_key');

}

function create_settings_page(){
	?>
	<div>
		<h2>Kupay Settings</h2>

		<form method="post" action="options.php">

            <?php settings_fields( 'kupay_options_group' ); ?>

            <label for="kupay_options_api_key">API-KEY</label>
            <input type="text" id="kupay_options_api_key" name="kupay_options_api_key" value="<?php echo get_option('kupay_options_api_key'); ?>" />

			<?php  submit_button(); ?>
		</form>
	</div>
	<?php
}