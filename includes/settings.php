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
<!-- 
            <label for="kupay_options_enable_for_single_product"><b>ENABLE FOR SINGLE PRODUCT (Enter product ID)</b></label><br>
            <input type="text" id="kupay_options_enable_for_single_product" name="kupay_options_enable_for_single_product"> <?php echo get_option('kupay_options_enable_for_single_product'); ?> </input>

            <br>
            <br>

            <label for="kupay_options_custom_css_pdp"><b>Custom CSS for Product Detail Page</b></label><br>
            <textarea  rows="4" cols="50" id="kupay_options_custom_css_pdp" name="kupay_options_custom_css_pdp"> <?php echo get_option('kupay_options_custom_css_pdp'); ?> </textarea>

            <br>
            <br>

            <label for="kupay_options_custom_css_cart"><b>Custom CSS for Cart Page</b></label><br>
            <textarea  rows="4" cols="50" id="kupay_options_custom_css_cart" name="kupay_options_custom_css_cart"> <?php echo get_option('kupay_options_custom_css_cart'); ?> </textarea>

            <br>
            <br>

            <label for="kupay_options_custom_css_checkout"><b>Custom CSS for Checkout Page</b></label><br>
            <textarea  rows="4" cols="50" id="kupay_options_custom_css_checkout" name="kupay_options_custom_css_checkout"> <?php echo get_option('kupay_options_custom_css_checkout'); ?> </textarea>

			<br>
			<br> -->

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