<?php

/**
 * @param $kupay_request
 *
 * @return array
 * @throws Exception
 */
function build_pdp_order_data($kupay_request): array {

	if ( is_null( WC()->cart ) ) {
		wc_load_cart();
	}

	$product_detail = WC()->product_factory->get_product($kupay_request['product']['id']);

	WC()->cart->add_to_cart( $kupay_request['product']['id'], $kupay_request['product']['quantity']);

	kupay_calculate_cart_shipping( $kupay_request['customer']['shipping_data'] );

	$image_id  = $product_detail->get_image_id();
	$image_url = wp_get_attachment_image_url( $image_id, 'full' );

	return
	[
		'origin' => 'PDP',
		'state' => 'ORDER_CREATED',
		'user' => $kupay_request['customer']['email'],
		'deliveryData' => [
			'cost' => (float) WC()->cart->get_shipping_total(),
			'date' => json_encode(WC()->cart->get_shipping_packages())
		],
		'productData' => [
			0 => [
				'description' => $product_detail->get_short_description(),
				'id' => (string) $product_detail->get_id(),
				'imageUrl' => $image_url,
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

/**
 * @param $kupay_request
 *
 * @return array
 */
function build_cart_order_data($kupay_request): array {

	if ( is_null( WC()->cart ) ) {
		wc_load_cart();
	}

	$items = WC()->cart->get_cart();

	$product_data = [];

	foreach ($items as $item){

		$product_detail = WC()->product_factory->get_product($item['product_id']);
		$image_id  = $product_detail->get_image_id();
		$image_url = wp_get_attachment_image_url( $image_id, 'full' );

		$product_data[] = [
			'description' => $product_detail->get_short_description(),
			'id' => (string) $product_detail->get_id(),
			'imageUrl' => $image_url,
			'name' => $product_detail->get_name(),
			'price' => (float) $product_detail->get_price(),
			'quantity' => $item['quantity'],
		];
	}

	kupay_calculate_cart_shipping( $kupay_request['customer']['shipping_data'] );

	return
		[
			'origin' => $kupay_request['origin'],
			'state' => 'ORDER_CREATED',
			'user' => $kupay_request['customer']['email'],
			'deliveryData' => [
				'cost' => (float) WC()->cart->get_shipping_total(),
			],
			'productData' => $product_data,
			'totalsData' => [
				'subtotal' => (float) WC()->cart->get_subtotal(),
				'shippingCost' => (float)  WC()->cart->get_shipping_total(),
				'taxes' => (float)  WC()->cart->get_total_tax(),
				'total' => (float) WC()->cart->total
			],

		];

}

/**
 * @param $shipping_data
 */
function kupay_calculate_cart_shipping( $shipping_data ): void {

	WC()->customer->set_props(
		array(
			'shipping_postcode'  => $shipping_data['zipCode'],
			'shipping_city'      => $shipping_data['city'],
			'shipping_address_1' => $shipping_data['address'],
			'shipping_address_2' => $shipping_data['addressDescription'],
		)
	);

	WC()->customer->save();
	WC()->cart->calculate_shipping();
	WC()->cart->calculate_totals();
}

/**
 * @param WP_REST_Request $kupay_request
 *
 * @throws Exception
 */
function kupay_order_create(WP_REST_Request $kupay_request): WP_REST_Response {

	try{

		$wp_rest_response = new WP_REST_Response();
		$wp_rest_response->set_status(200);
		$wp_rest_response->header('Kupay-API-KEY', get_option('kupay_options_api_key'));

		$kupay_request = json_decode($kupay_request->get_body(), true);

		if(!empty($kupay_request)){

			if(!empty($kupay_request['origin'])){
				if($kupay_request['origin'] == "CART" || $kupay_request['origin'] == "CHECKOUT"){

					$data = build_cart_order_data($kupay_request);

					$wp_rest_response->set_data($data);


					return new WP_REST_Response($data, 200, );

				}
			}

			return new WP_REST_Response(build_pdp_order_data($kupay_request));

		}
	} catch ( Exception $e ) {

		wp_send_json([
			'code'=> 500,
			'message' => $e->getMessage()
		]);
	}




}

/**
 * @param WP_REST_Request $kupay_request
 */
function kupay_order_checkout(WP_REST_Request $kupay_request): void {

	try {

		$kupay_request = json_decode($kupay_request->get_body(), true);
		checkout_order_in_woocommerce( $kupay_request );

		wp_send_json($kupay_request);

	} catch ( Exception $e ) {

		wp_send_json([
			'code'=> 500,
			'message' => $e->getMessage()
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