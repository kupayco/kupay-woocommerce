<?php

function kupay_render_cart(){
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
	$origin = "CART";
	$currency = get_option("kupay_options_currency");
	$deliveryCost = 0;
	$cartID = $session_id;

	echo '<input type="hidden" id="kupay-url" name="kupay-url" value="' .  esc_url($kupayUrl) . '">';
	echo '<input type="hidden" id="kupay-app-id" name="kupay-app-id" value="' . esc_attr($appId) . '">';
	echo '<input type="hidden" id="kupay-requires-processing" name="kupay-requires-processing" value="' . esc_attr($requiresProcessing) . '">';
	echo '<input type="hidden" id="kupay-origin" name="kupay-origin" value="' . esc_attr($origin) . '">';
	echo '<input type="hidden" id="kupay-currency" name="kupay-currency" value="' . esc_attr($currency) . '">';
	echo '<input type="hidden" id="kupay-delivery-cost" name="kupay-delivery-cost" value="' . esc_attr($deliveryCost) . '">';
	echo '<input type="hidden" id="kupay-cart-id" name="kupay-cart-id" value="' . esc_attr($cartID) . '">';
	
	echo '<kupay class="kupay-buy kupay-buy-cart" onclick="kupayCartCheckout()">COMPRAR EN 1-CLICK</kupay>';

}