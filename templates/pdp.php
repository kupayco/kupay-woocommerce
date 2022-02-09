<?php


function kupay_render_pdp(){
	
	global $product;

	$kupayUrl = KUPAY_IFRAME_URL;

	$appId = get_option("kupay_options_app_id");
    $productId = $product->get_id();
	$productName = $product->get_name();

	$productImageUrl = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
	$productPrice = $product->get_price();
	$requiresProcessing = true;
	$origin = "PDP";
	$currency = "EUR";
	$deliveryCost = 0;

    echo '<input type="hidden" id="kupay-woocommerce-version" name="kupay-woocommerce-version" value="' . esc_attr(KUPAY_WOOCOMMERCE_VERSION) . '">';
	echo '<input type="hidden" id="kupay-url" name="kupay-url" value="' . esc_url($kupayUrl) . '">';
	echo '<input type="hidden" id="kupay-app-id" name="kupay-app-id" value="' . esc_attr($appId) . '">';
	echo '<input type="hidden" id="kupay-product-id" name="kupay-product-id" value="' . esc_attr($productId) . '">';
	echo '<input type="hidden" id="kupay-product-name" name="kupay-product-name" value="' . esc_attr($productName) . '">';
	echo '<input type="hidden" id="kupay-product-image-url" name="kupay-product-image-url" value="' . esc_attr($productImageUrl) . '">';
	echo '<input type="hidden" id="kupay-product-price" name="kupay-product-price" value="' . esc_attr($productPrice) . '">';
	echo '<input type="hidden" id="kupay-requires-processing" name="kupay-requires-processing" value="' . esc_attr($requiresProcessing) . '">';
	echo '<input type="hidden" id="kupay-origin" name="kupay-origin" value="' . esc_attr($origin) . '">';
	echo '<input type="hidden" id="kupay-currency" name="kupay-currency" value="' . esc_attr($currency) . '">';
	echo '<input type="hidden" id="kupay-delivery-cost" name="kupay-delivery-cost" value="' . esc_attr($deliveryCost) . '">';
	
	echo '<kupay class="kupay-buy kupay-buy-pdp" onclick="kupayPDPCheckout()">COMPRAR EN 1-CLICK</kupay>';

    echo '<style>' . get_option("kupay_options_pdp_style") .  '</style>';

}