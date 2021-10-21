<?php

function kupay_create_settings_menu(){

	$page_title = 'Kupay Settings';
	$menu_title = 'Kupay';
	$capability = 'manage_options';
	$menu_slug  = 'kupay-info';
	$function   = 'kupay_create_settings_page';
	$icon_url   = 'dashicons-lock';
	$position   = 4;

	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

	register_setting( 'kupay_options_group', 'kupay_options_app_id');
	register_setting( 'kupay_options_group', 'kupay_options_test_mode');

}

function kupay_create_settings_page(){
	?>
	<div>
		<h2>Kupay Settings</h2>

		<form method="post" action="options.php">

            <?php settings_fields( 'kupay_options_group' ); ?>

            <label for="kupay_options_app_id"><b>APP ID</b></label>
            <input type="text" id="kupay_options_app_id" name="kupay_options_app_id" value="<?php echo esc_html(get_option('kupay_options_app_id')); ?>"/>

            <br>
            <br>

			<label for="kupay_options_test_mode_checkbox"><b>Test Mode </b></label>
			<input type="checkbox" id="kupay_options_test_mode_checkbox" name="kupay_options_test_mode[kupay_options_test_mode_checkbox]" value="1" <?php echo esc_html(checked( 1, get_option( 'kupay_options_test_mode' )['kupay_options_test_mode_checkbox'], false )) ?> '/>
			
			<?php submit_button(); ?>

		</form>
	</div>
	<?php
}