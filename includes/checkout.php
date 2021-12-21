<?php

/**
 * @param $kupay_request
 *
 * @return array
 * @throws Exception
 */
function kupay_build_pdp_order_data($kupay_request): array {

	if ( is_null( WC()->cart ) ) {
		wc_load_cart();
	}

	$product_detail = wc_get_product($kupay_request['product']['id']);

    $product_variant_detail = null;
    if(!empty($kupay_request['product']['variantId'])){
        $product_variant_detail = new WC_Product_Variation( $kupay_request['product']['variantId']);
    }


	WC()->cart->add_to_cart( $kupay_request['product']['id'], $kupay_request['product']['quantity'], $kupay_request['product']['variantId']);

	kupay_calculate_cart_shipping( $kupay_request['customer']['shippingData'] );

	$image_id  = $product_detail->get_image_id();
	$image_url = wp_get_attachment_image_url( $image_id, 'full' );

    $shipping_methods = kupay_get_shipping_methods( $kupay_request['customer']['shippingData'] );

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
				'price' => $product_variant_detail != null ? (float) $product_variant_detail->get_price() : (float) $product_detail->get_price(),
				'quantity' => $kupay_request['product']['quantity'],
                'variantId' => $product_variant_detail != null ? $product_variant_detail->get_id() : '',
                'variantDescription' => $product_variant_detail != null ? $product_variant_detail->get_description() : ''
			]
		],
		'totalsData' => [
			'subtotal' => (float) WC()->cart->get_subtotal(),
			'shippingCost' => (float)  WC()->cart->get_shipping_total(),
			'taxes' => (float)  WC()->cart->get_total_tax(),
			'total' => (float) WC()->cart->total
		],
        'shippingMethods' => $shipping_methods
	];
}

/**
 * @param $kupay_request
 *
 * @return array
 */
function kupay_get_shipping_methods($kupay_request): array {

    $shipping_methods = [];

    foreach ( WC()->cart->get_shipping_packages() as $package_id => $package ) {
        
        foreach ( WC()->session->get( 'shipping_for_package_'.$package_id )['rates'] as $shipping_rate_id => $shipping_rate ) {
            $rate_id     = $shipping_rate->get_id();
            $method_id   = $shipping_rate->get_method_id();
            $instance_id = $shipping_rate->get_instance_id();
            $label_name  = $shipping_rate->get_label();
            $cost        = $shipping_rate->get_cost();
            $tax_cost    = $shipping_rate->get_shipping_tax();
            $taxes       = $shipping_rate->get_taxes();

            array_push($shipping_methods, [
                'rateId' => $rate_id,
                'methodId' => $method_id,
                'instanceId' => $instance_id,
                'label' => $label_name,
                'cost' => $cost,
                'taxCost' => $tax_cost,
                'taxes' => $taxes
            ]);
        }
    }

    return $shipping_methods;
}

/**
 * @param $kupay_request
 *
 * @return array
 */
function kupay_build_cart_order_data($kupay_request): array {


	$session = new WC_Session_Handler();
	$session_data = $session->get_session($kupay_request['cartId']);

	$cart_data = unserialize( $session_data['cart'] );

    $applied_coupons = unserialize($session_data['coupon_discount_totals']);

	if ( is_null( $cart_data ) ) {
		throw new Exception("No cart data has been found!");
	}

	if ( is_null( WC()->cart ) ) {
		wc_load_cart();
	}

	$product_data = [];

	foreach ($cart_data as $key => $value){
		$product_detail = wc_get_product( $value['product_id']);

		$product_variant_detail = null;
        if($value['variation_id'] != 0){
            $product_variant_detail = new WC_Product_Variation($value['variation_id']);
        }
	
		$image_id  = $product_detail->get_image_id();
		$image_url = wp_get_attachment_image_url( $image_id, 'full' );

		$product_data[] = [
			'description' => $product_detail->get_short_description(),
			'id' => (string) $product_detail->get_id(),
			'imageUrl' => $image_url,
			'name' => $product_detail->get_name(),
			'price' => $product_variant_detail != null ? (float) $product_variant_detail->get_price() : (float) $product_detail->get_price(),
			'quantity' => $value['quantity'],
            'variantId' => $product_variant_detail != null ? $product_variant_detail->get_id() : '',
            'variantDescription' => $product_variant_detail != null ? $product_variant_detail->get_description() : ''
		];

		if($kupay_request['origin'] == "CART" || $kupay_request['origin']['CHECKOUT']){
			WC()->cart->add_to_cart($value['product_id'], $value['quantity'], $value['variation_id']);
		}

		WC()->cart->calculate_fees();
		WC()->cart->calculate_totals();
		
	}

	$coupon_data = [];

    foreach($applied_coupons as $key => $value){

        WC()->cart->add_discount($key);

        $coupon_data[] = [
            'code' => $key,
            'value' => $value
        ];
    }

	kupay_calculate_cart_shipping( $kupay_request['customer']['shipping_data']);

    $shipping_methods = kupay_get_shipping_methods( $kupay_request['customer']['shippingData'] );

	return
		[
			'origin' => $kupay_request['origin'],
			'state' => 'ORDER_CREATED',
			'user' => $kupay_request['customer']['email'],
			'deliveryData' => [
				'cost' => (float) WC()->cart->get_shipping_total(),
			],
            'couponData' => $coupon_data,
			'productData' => $product_data,
			'totalsData' => [
				'subtotal' => (float) WC()->cart->get_subtotal(),
				'shippingCost' => (float)  WC()->cart->get_shipping_total(),
				'taxes' => (float)  WC()->cart->get_total_tax(),
				'total' => (float) WC()->cart->total
			],
            'shippingMethods' => $shipping_methods
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
    if(!empty($shipping_data["provinceCode"])) $data["shipping_state"] = $shipping_data["provinceCode"];
    if(!empty($shipping_data["countryCode"])) $data["shipping_country"] = $shipping_data["countryCode"];

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
function kupay_order_create(WP_REST_Request $kupay_request) {

	try{
		$wp_rest_response = new WP_REST_Response();
		$wp_rest_response->set_status(200);
		$wp_rest_response->header('KUPAY-API-KEY', get_option('kupay_options_api_key'));
		$kupay_request = json_decode($kupay_request->get_body(), true);

		if(!empty($kupay_request)){

			if(!empty($kupay_request['origin'])){

				if($kupay_request['origin'] == "CART" || $kupay_request['origin'] == "CHECKOUT"){

					$data = kupay_build_cart_order_data($kupay_request);
					$wp_rest_response->set_data($data);

					return new WP_REST_Response($data, 200, );
				}
			}
			return new WP_REST_Response(kupay_build_pdp_order_data($kupay_request));
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
function kupay_order_checkout(WP_REST_Request $kupay_request) {

	try {

		$kupay_request = json_decode($kupay_request->get_body(), true);
		$order = kupay_checkout_order_in_woocommerce( $kupay_request );

		$kupay_request['storeOrderId'] = $order->get_id();

		wp_send_json($kupay_request);

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
function kupay_order_refund(WP_REST_Request $kupay_request) {
    try {

        $kupay_request = json_decode($kupay_request->get_body(), true);
        $order = new WC_Order($kupay_request['storeOrderId']);

        $order->update_status('refunded');

        wp_send_json([
            'code'=> 200,
            'message' => 'Status updated'
        ]);

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
function kupay_checkout_order_in_woocommerce($kupay_request){

	$order = wc_create_order();

	$order->add_meta_data("kupay_order_id", $kupay_request['orderId']);
	$order->set_customer_id(kupay_create_customer($kupay_request));

	foreach ($kupay_request['productData'] as $product_data){


        if(!empty($product_data['variantId'])){

            $args = array();
            $product_variation = new WC_Product_Variation($product_data['variantId']);

            foreach($product_variation->get_variation_attributes() as $attribute=>$attribute_value){
                $args['variation'][$attribute] = $attribute_value;
                $args['variation_id'] = $product_data['variantId'];
            }

            $order->add_product( $product_variation, $product_data['quantity'], $args);
        }
        else{

            $order->add_product( wc_get_product($product_data['id']), $product_data['quantity']);

        }

	}

	foreach ($kupay_request['couponData'] as $coupon_data){

        $coupon = new WC_Coupon($coupon_data['code']);

        $order->apply_coupon($coupon);
        $order->calculate_totals();
        $order->save();

    }

	$shipping_address = kupay_create_shipping_address($kupay_request);
	$billing_address = kupay_create_billing_address($kupay_request);

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

	return $order;

}

function kupay_create_customer($kupay_request){
	return wc_create_new_customer( $kupay_request['customer']['email'], $kupay_request['customer']['email']);
}

function kupay_create_shipping_address($kupay_request){
	return array(
		'first_name' => $kupay_request['customer']['firstName'],
		'last_name'  => $kupay_request['customer']['lastName'],
		'email'      => $kupay_request['customer']['email'],
		'address_1'  => $kupay_request['customer']['shippingData']['address'],
		'address_2'  => $kupay_request['customer']['shippingData']['addressDescription'],
		'city'       => $kupay_request['customer']['shippingData']['city'],
		'state'      => $kupay_request['customer']['shippingData']['provinceCode'],
		'postcode'   => $kupay_request['customer']['shippingData']['zipCode'],
		'country'    => $kupay_request['customer']['shippingData']['countryCode'],
		'phone'    => $kupay_request['customer']['shippingData']['phone']
	);
}

function kupay_create_billing_address($kupay_request){
	return array(
		'first_name' => $kupay_request['customer']['firstName'],
		'last_name'  => $kupay_request['customer']['lastName'],
		'email'      => $kupay_request['customer']['email'],
		'address_1'  => $kupay_request['customer']['billingData']['address'],
		'address_2'  => $kupay_request['customer']['billingData']['addressDescription'],
		'city'       => $kupay_request['customer']['billingData']['city'],
		'state'      => $kupay_request['customer']['billingData']['provinceCode'],
		'postcode'   => $kupay_request['customer']['billingData']['zipCode'],
		'country'    => $kupay_request['customer']['billingData']['countryCode'],
		'phone'    => $kupay_request['customer']['billingData']['phone']
	);
}