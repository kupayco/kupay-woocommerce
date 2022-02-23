<?php

const KUPAY_WC_BASE_ROUTE = "kupay/wc";

function kupay_register_order_create_route(){
	$namespace = KUPAY_WC_BASE_ROUTE;
	$route     = 'order/create';

	register_rest_route($namespace, $route, array(
		'methods'   => WP_REST_Server::CREATABLE,
		'callback'  => 'kupay_order_create',
//		'permission_callback' => 'kupay_is_request_authorized'
	));
}

function kupay_register_checkout_route()
{
	$namespace = KUPAY_WC_BASE_ROUTE;
	$route     = 'order/checkout';

	register_rest_route($namespace, $route, array(
		'methods'   => WP_REST_Server::CREATABLE,
		'callback'  => 'kupay_order_checkout',
//		'permission_callback' => 'kupay_is_request_authorized'
	));
}

function kupay_register_refund_route()
{
    $namespace = KUPAY_WC_BASE_ROUTE;
    $route     = 'order/refund';

    register_rest_route($namespace, $route, array(
        'methods'   => WP_REST_Server::CREATABLE,
        'callback'  => 'kupay_order_refund',
//        'permission_callback' => 'kupay_is_request_authorized'
    ));
}

function kupay_is_request_authorized(WP_REST_Request $kupay_request){
	return $kupay_request->get_header("authorization") == trim(get_option('kupay_options_app_id'));
}

add_action('rest_api_init', 'kupay_register_order_create_route');
add_action('rest_api_init', 'kupay_register_checkout_route');
add_action('rest_api_init', 'kupay_register_refund_route');