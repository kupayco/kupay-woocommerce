<?php


function insert_pdp_kupay_checkout(){
	

	// echo '<br><button id="kupay-checkout" onclick="kupay_checkout()">Buy in One Click</button>';

	global $product;

	$kupayUrl = KUPAY_IFRAME_URL;

	$appId = get_option("kupay_options_app_id");
    $productId = $product->get_id();
	$productName = $product->get_name();
	$productQuantity = 1;
	$productImageUrl = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
	$productPrice = $product->get_price();
	$requiresProcessing = true;
	$origin = "PDP";
	$currency = get_option("kupay_options_currency");
	$deliveryCost = 0;

	echo '<input type="hidden" id="kupay-url" name="kupay-url" value="' . $kupayUrl . '">';
	echo '<input type="hidden" id="kupay-app-id" name="kupay-app-id" value="' . $appId . '">';
	echo '<input type="hidden" id="kupay-product-id" name="kupay-product-id" value="' . $productId . '">';
	echo '<input type="hidden" id="kupay-product-name" name="kupay-product-name" value="' . $productName . '">';
	echo '<input type="hidden" id="kupay-product-quantity" name="kupay-product-quantity" value="' . $productQuantity . '">';
	echo '<input type="hidden" id="kupay-product-image-url" name="kupay-product-image-url" value="' . $productImageUrl . '">';
	echo '<input type="hidden" id="kupay-product-price" name="kupay-product-price" value="' . $productPrice . '">';
	echo '<input type="hidden" id="kupay-requires-processing" name="kupay-requires-processing" value="' . $requiresProcessing . '">';
	echo '<input type="hidden" id="kupay-origin" name="kupay-origin" value="' . $origin . '">';
	echo '<input type="hidden" id="kupay-currency" name="kupay-currency" value="' . $currency . '">';
	echo '<input type="hidden" id="kupay-delivery-cost" name="kupay-delivery-cost" value="' . $deliveryCost . '">';
	
	echo '<br>';
	echo '<kupay class="kupayBuy kupayBuyPdp" onclick="kupayPDPCheckout()">COMPRAR EN 1-CLICK</kupay>';

}