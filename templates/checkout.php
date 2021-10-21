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
	$currency = get_option("kupay_options_currency");
	$deliveryCost = 0;
	$cartID = $session_id;

	echo '<input type="hidden" id="kupay-url" name="kupay-url" value="' . $kupayUrl . '">';
	echo '<input type="hidden" id="kupay-app-id" name="kupay-app-id" value="' . $appId . '">';
	echo '<input type="hidden" id="kupay-requires-processing" name="kupay-requires-processing" value="' . $requiresProcessing . '">';
	echo '<input type="hidden" id="kupay-origin" name="kupay-origin" value="' . $origin . '">';
	echo '<input type="hidden" id="kupay-currency" name="kupay-currency" value="' . $currency . '">';
	echo '<input type="hidden" id="kupay-delivery-cost" name="kupay-delivery-cost" value="' . $deliveryCost . '">';
	echo '<input type="hidden" id="kupay-cart-id" name="kupay-cart-id" value="' . $cartID . '">';
	
	echo '<kupay class="kupay-buy kupay-buy-checkout" onclick="kupayCartCheckout()">COMPRAR EN 1-CLICK</kupay>';

}