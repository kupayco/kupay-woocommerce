<?php

use Automattic\WooCommerce\Client;

// to update shipping cost on cart review WC_AJAX::update_order_review();
/**
 * @throws Exception
 */
function build_kupay_order_data($kupay_request): array {

	$product_detail = WC()->product_factory->get_product($kupay_request['product']['id']);

	wc_load_cart();
	WC()->cart->add_to_cart( $kupay_request['product']['id'], $kupay_request['product']['quantity']);

	WC()->customer->set_props(
		array(
			'shipping_postcode'  => $kupay_request['customer']['shipping_data']['zipCode'],
			'shipping_city'      => $kupay_request['customer']['shipping_data']['city'],
			'shipping_address_1' => $kupay_request['customer']['shipping_data']['address'],
			'shipping_address_2' => $kupay_request['customer']['shipping_data']['addressDescription'],
		)
	);


	WC()->customer->save();
	WC()->cart->calculate_shipping();
	WC()->cart->calculate_totals();


	WC()->checkout()->check_cart_items();

	return
	[
		'store_order_id' => null,
		'state' => 'ORDER_CREATED',
		'store' => $kupay_request['store']['id'],
		'user' => $kupay_request['customer']['email'],
		'delivery_data' => [
			'cost' => WC()->cart->get_shipping_total(),
		],
		'product_data' => [
			0 => [
				'description' => $product_detail->get_description(),
				'id' => $product_detail->get_id(),
				'image_url' => $kupay_request['product']['image_url'],
				'name' => $product_detail->get_name(),
				'price' => $product_detail->get_price(),
				'quantity' => $kupay_request['product']['quantity'],
			]
		],

	];

}


function kupay_product_checkout(WP_REST_Request $request){
	$kupay_request = json_decode($request->get_body(), true);

	$kupay_order_data = build_kupay_order_data($kupay_request);
	$kupay_order_response = create_order_in_kupay_api($kupay_order_data);

	if($kupay_order_response['status_code'] == '200' && $kupay_order_response['data']['payment_status'] == 'PAID'){

//		$woocommerce_order_data = build_woocommerce_order_data($kupay_order_response['data']);
		$woocommerce_order_response = checkout_order_in_woocommerce($kupay_order_data);

		if(!empty($woocommerce_order_response['id'])){
			checkout_order_in_kupay_api($kupay_order_data);
		}

	}

}

function create_order_in_kupay_api($order_data): array {
	$kupay_api_client = new KuPayApiClient();
	return $kupay_api_client->executePostRequest($order_data, 'order');
}

/**
 * @throws Exception
 */
function checkout_order_in_woocommerce($kupay_order_data): array {

	$order = wc_create_order();
	WC()->checkout()->create_order_line_items($order, WC()->cart);

	return [];

}

function checkout_order_in_kupay_api($kupay_order_data){
	$kupay_api_client = new KuPayApiClient();
	return $kupay_api_client->executePostRequest($kupay_order_data, 'order/' . $kupay_order_data['id']);

}