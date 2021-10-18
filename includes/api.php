<?php

const KUPAYWC_BASE_ROUTE = "kupay/wc";
const STORE_API_KEY = "f3fa1961-bd35-4480-9761-f2bdbbb6f195";
const KUPAY_API_FULL_DOMAIN = "api.kupay.co";


function register_kupay_order_create_route(){
	$namespace = KUPAYWC_BASE_ROUTE;
	$route     = 'order/create';

	register_rest_route($namespace, $route, array(
		'methods'   => WP_REST_Server::CREATABLE,
		'callback'  => 'kupay_order_create',
		'permission_callback' => 'is_request_authorized'
	));
}

function register_kupay_checkout_route()
{
	$namespace = KUPAYWC_BASE_ROUTE;
	$route     = 'order/checkout';

	register_rest_route($namespace, $route, array(
		'methods'   => WP_REST_Server::CREATABLE,
		'callback'  => 'kupay_order_checkout',
		'permission_callback' => 'is_request_authorized'
	));
}

function is_request_authorized(WP_REST_Request $kupay_request){
	return $kupay_request->get_header("authorization") == get_option('kupay_options_app_id');
}

add_action('rest_api_init', 'register_kupay_order_create_route');
add_action('rest_api_init', 'register_kupay_checkout_route');