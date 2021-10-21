<?php

function create_settings_menu(){

	$page_title = 'Kupay Settings';
	$menu_title = 'Kupay';
	$capability = 'manage_options';
	$menu_slug  = 'kupay-info';
	$function   = 'create_settings_page';
	$icon_url   = 'dashicons-lock';
	$position   = 4;

	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

	register_setting( 'kupay_options_group', 'kupay_options_app_id');
	register_setting( 'kupay_options_group', 'kupay_options_enable_for_single_product');
	register_setting( 'kupay_options_group', 'kupay_options_custom_css_pdp');
	register_setting( 'kupay_options_group', 'kupay_options_custom_css_cart');
	register_setting( 'kupay_options_group', 'kupay_options_custom_css_checkout');
	register_setting( 'kupay_options_group', 'kupay_options_test_mode');
	register_setting( 'kupay_options_group', 'sandbox_theme_input_examples');

}

function create_settings_page(){
	?>
	<div>
		<h2>Kupay Settings</h2>

		<form method="post" action="options.php">

            <?php settings_fields( 'kupay_options_group' ); ?>

            <label for="kupay_options_app_id"><b>APP ID</b></label>
            <input type="text" id="kupay_options_app_id" name="kupay_options_app_id" value="<?php echo get_option('kupay_options_app_id'); ?>"/>

            <br>
            <br>

			<?php 

				$options = get_option( 'kupay_options_test_mode' );

				$html = '<label for="kupay_options_test_mode_checkbox"><b>Test Mode </b></label>';
				$html .= '<input type="checkbox" id="kupay_options_test_mode_checkbox" name="kupay_options_test_mode[kupay_options_test_mode_checkbox]" value="1"' . checked( 1, $options['kupay_options_test_mode_checkbox'], false ) . '/>';
				

				echo $html;
			
			
			submit_button(); ?>

		</form>
	</div>
	<?php
}