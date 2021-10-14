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

	$product_detail = wc_get_product($kupay_request['product']['id']);
	WC()->cart->add_to_cart( $kupay_request['product']['id'], $kupay_request['product']['quantity']);
	kupay_calculate_cart_shipping( $kupay_request['customer']['shippingData'] );
	$image_id  = $product_detail->get_image_id();
	$image_url = wp_get_attachment_image_url( $image_id, 'full' );

	return
	[
		'origin' => 'PDP',
		'state' => 'ORDER_CREATED',
		'user' => $kupay_request['customer']['email'],
		'deliveryData' => [
			'shippingMethod' => '',
			'cost' => (float) WC()->cart->get_shipping_total()
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

	$session = new WC_Session_Handler();
	$session_data = $session->get_session($kupay_request['cartid']);
	$cart_data = unserialize( $session_data['cart'] );

	if ( is_null( $cart_data ) ) {
		throw new Exception("No cart data has been found!");
	}

	if ( is_null( WC()->cart ) ) {
		wc_load_cart();
	}

	$product_data = [];

	foreach ($cart_data as $key => $value){
		$product_detail = wc_get_product( $value['product_id']);
	
		$image_id  = $product_detail->get_image_id();
		$image_url = wp_get_attachment_image_url( $image_id, 'full' );

		$product_data[] = [
			'description' => $product_detail->get_short_description(),
			'id' => (string) $product_detail->get_id(),
			'imageUrl' => $image_url,
			'name' => $product_detail->get_name(),
			'price' => (float) $product_detail->get_price(),
			'quantity' => $value['quantity'],
		];

		if($kupay_request['origin'] == "CART" || $kupay_request['PDP']){
			WC()->cart->add_to_cart($value['product_id'], $value['quantity']);
		}

		WC()->cart->calculate_fees();
		WC()->cart->calculate_totals();
		
	}

	kupay_calculate_cart_shipping( $kupay_request['customer']['shipping_data']);

	return
		[
			'remoteHost' => $_SERVER['SERVER_NAME'],
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

	$data = [];
	
	if(!empty($shipping_data["zipCode"])) $data["shipping_postcode"] = $shipping_data["zipCode"];
	if(!empty($shipping_data["city"])) $data["shipping_city"] = $shipping_data["city"];
	if(!empty($shipping_data["address"])) $data["shipping_address_1"] = $shipping_data["address"];
	if(!empty($shipping_data["addressDescription"])) $data["shipping_address_2"] = $shipping_data["addressDescription"];

	WC()->customer->set_props($data);
	WC()->customer->save();
	WC()->cart->calculate_shipping();
	
	WC()->cart->calculate_fees();
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
		$wp_rest_response->header('KUPAY-API-KEY', get_option('kupay_options_api_key'));
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

	$order = wc_create_order();

	$order->add_meta_data("kupay_order_id", $kupay_request['orderId']);

	$order->set_customer_id(create_customer($kupay_request));

	foreach ($kupay_request['productData'] as $product_data){
		$order->add_product( wc_get_product($product_data['id']), $product_data['quantity']);
	}

	$shipping_address = create_shipping_address($kupay_request);
	$billing_address = create_billing_address($kupay_request);

	$order->set_address( $shipping_address, 'shipping' );
	$order->set_address( $billing_address);

	$item = new WC_Order_Item_Shipping();
	$item->set_total($kupay_request['totalsData']['shippingCost']);
	$item->calculate_taxes($shipping_address);

	$order->add_item($item);
	$order->calculate_shipping();
	
	$order->set_total($kupay_request['totalsData']['total']);
	$order->calculate_taxes();
	$order->calculate_totals();

	$order->set_status("processing");
	$order->set_payment_method_title("Kupay - One-Click Checkout");
	$order->save();

}

function create_customer($kupay_request){
	return wc_create_new_customer( $kupay_request['customer']['email'], $kupay_request['customer']['email']);
}

function create_shipping_address($kupay_request){
	return array(
		'first_name' => $kupay_request['customer']['firstName'],
		'last_name'  => $kupay_request['customer']['lastName'],
		'email'      => $kupay_request['customer']['email'],
		'address_1'  => $kupay_request['customer']['shippingData']['address'],
		'address_2'  => $kupay_request['customer']['shippingData']['addressDescription'],
		'city'       => $kupay_request['customer']['shippingData']['city'],
		'state'      => $kupay_request['customer']['shippingData']['zipCode'],
		'postcode'   => $kupay_request['customer']['shippingData']['state'],
		'country'    => $kupay_request['customer']['shippingData']['country'],
		'phone'    => $kupay_request['customer']['shippingData']['phone']
	);
}

function create_billing_address($kupay_request){
	return array(
		'first_name' => $kupay_request['customer']['firstName'],
		'last_name'  => $kupay_request['customer']['lastName'],
		'email'      => $kupay_request['customer']['email'],
		'address_1'  => $kupay_request['customer']['billinData']['address'],
		'address_2'  => $kupay_request['customer']['billinData']['addressDescription'],
		'city'       => $kupay_request['customer']['billinData']['city'],
		'state'      => $kupay_request['customer']['billinData']['zipCode'],
		'postcode'   => $kupay_request['customer']['billinData']['state'],
		'country'    => $kupay_request['customer']['billinData']['country'],
		'phone'    => $kupay_request['customer']['billinData']['phone']
	);
}