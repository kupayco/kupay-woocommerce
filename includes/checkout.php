<?php

use Automattic\WooCommerce\Client;

// to update shipping cost on cart review WC_AJAX::update_order_review();
/**
 * @throws Exception
 */
function build_pdp_order_data($kupay_request): array {

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

	return
	[
		'store' => 12345,
		'state' => 'ORDER_CREATED',
		'user' => $kupay_request['customer']['email'],
		'deliveryData' => [
			'cost' => (float) WC()->cart->get_shipping_total(),
		],

		'productData' => [
			0 => [
				'description' => $product_detail->get_short_description(),
				'id' => (string) $product_detail->get_id(),
//				'image_url' => $kupay_request['product']['image_url'],
				'name' => $product_detail->get_name(),
				'price' => (float) $product_detail->get_price(),
				'quantity' => $kupay_request['product']['quantity'],
			]
		],
		'totalsData' => [
			'subtotal' => (float) WC()->cart->get_subtotal(),
			'shippingCost' => (float)  WC()->cart->get_shipping_total(),
			'taxes' => (float)  WC()->cart->get_total_tax(),
			'total' => (float) WC()->cart->total
		],

	];


}

function kupay_pdp_order_create(WP_REST_Request $kupay_request): void {

	$kupay_request = json_decode($kupay_request->get_body(), true);
	$kupay_order_data = build_pdp_order_data($kupay_request);

	header("Access-Control-Allow-Origin: *");
	wp_send_json($kupay_order_data);

}

function kupay_pdp_order_checkout(WP_REST_Request $kupay_request): void {

	try {

		$kupay_request = json_decode($kupay_request->get_body(), true);
		header("Access-Control-Allow-Origin: *");
		checkout_order_in_woocommerce( $kupay_request );

		wp_send_json($kupay_request);

	} catch ( Exception $e ) {

		wp_send_json([
			'code'=> 500,
			'message' => 'There was an error while checking out the order.'
		]);
	}


}

/**
 * @throws Exception
 */
function checkout_order_in_woocommerce($kupay_request) {


	$shipping_address = array(
		'first_name' => $kupay_request['userData']['firstName'],
		'last_name'  => $kupay_request['userData']['lastName'],
		'email'      => $kupay_request['userData']['email'],
		'address_1'  => $kupay_request['userData']['shippingAddress']['address'],
		'address_2'  => $kupay_request['userData']['shippingAddress']['address'],
		'city'       => $kupay_request['userData']['shippingAddress']['city'],
		'state'      => $kupay_request['userData']['shippingAddress']['zipCode'],
		'postcode'   => $kupay_request['userData']['shippingAddress']['state'],
		'country'    => $kupay_request['userData']['shippingAddress']['country']
	);

	$billing_address = array(
		'first_name' => $kupay_request['userData']['firstName'],
		'last_name'  => $kupay_request['userData']['lastName'],
		'email'      => $kupay_request['userData']['email'],
		'address_1'  => $kupay_request['userData']['billingAddress']['address'],
		'address_2'  => $kupay_request['userData']['billingAddress']['address'],
		'city'       => $kupay_request['userData']['billingAddress']['city'],
		'state'      => $kupay_request['userData']['billingAddress']['zipCode'],
		'postcode'   => $kupay_request['userData']['billingAddress']['state'],
		'country'    => $kupay_request['userData']['billingAddress']['country']
	);

	$order = wc_create_order();

	foreach ($kupay_request['productData'] as $product_data){
		$order->add_product( wc_get_product($product_data['id']), $product_data['quantity']);
	}

	$order->set_address( $shipping_address, 'shipping' );
	$order->set_address( $billing_address );
	$order->calculate_totals();
	$order->set_status("processing");
	$order->set_payment_method_title("Kupay - One-Click Checkout");
	$order->save();

}