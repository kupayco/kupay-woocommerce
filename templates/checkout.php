<?php

function kupay_render_checkout(){
	$values = null;
  
	foreach( $_COOKIE as $key => $value ) {
	  	if( stripos( $key, 'wp_woocommerce_session_' ) === false ) {
			continue;
	  	}
	  	$values = explode( '||', $value );
	}
  
	$session_id = $values[0];
	
	$kupayUrl = KUPAY_IFRAME_URL;

	$appId = get_option("kupay_options_app_id");
	$requiresProcessing = true;
	$origin = "CHECKOUT";
    $currency = "EUR";
	$deliveryCost = 0;
	$cartID = $session_id;
	$cartTotal = (float) WC()->cart->total;

    echo '<input type="hidden" id="kupay-woocommerce-version" name="kupay-woocommerce-version" value="' . esc_attr(KUPAY_WOOCOMMERCE_VERSION) . '">';
	echo '<input type="hidden" id="kupay-url" name="kupay-url" value="' . esc_url($kupayUrl) . '">';
	echo '<input type="hidden" id="kupay-app-id" name="kupay-app-id" value="' . esc_attr($appId) . '">';
	echo '<input type="hidden" id="kupay-requires-processing" name="kupay-requires-processing" value="' . esc_attr($requiresProcessing) . '">';
	echo '<input type="hidden" id="kupay-origin" name="kupay-origin" value="' . esc_attr($origin) . '">';
	echo '<input type="hidden" id="kupay-currency" name="kupay-currency" value="' . esc_attr($currency) . '">';
	echo '<input type="hidden" id="kupay-delivery-cost" name="kupay-delivery-cost" value="' . esc_attr($deliveryCost) . '">';
	echo '<input type="hidden" id="kupay-cart-id" name="kupay-cart-id" value="' . esc_attr($cartID) . '">';
	echo '<input type="hidden" id="kupay-cart-total" name="kupay-cart-total" value="' . esc_attr($cartTotal) . '">';
	
	echo '<kupay class="kupay-buy kupay-buy-checkout" onclick="kupayCartCheckout()">COMPRAR EN 1-CLICK</kupay>';

    echo '<style>' . get_option("kupay_options_checkout_style") .  '</style>';

}