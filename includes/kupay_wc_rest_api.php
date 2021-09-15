<?php

const KUPAYWC_BASE_ROUTE = 'kupay/wc';


function register_kupay_pdp_order_create_route(){
	$namespace = KUPAYWC_BASE_ROUTE;
	$route     = 'order/create';

	register_rest_route($namespace, $route, array(
		'methods'   => WP_REST_Server::CREATABLE,
		'callback'  => 'kupay_pdp_order_create',
		'permission_callback' => '__return_true'
	));
}

function register_kupay_pdp_order_checkout_route()
{

	$namespace = KUPAYWC_BASE_ROUTE;
	$route     = 'order/checkout';

	register_rest_route($namespace, $route, array(
		'methods'   => WP_REST_Server::CREATABLE,
		'callback'  => 'kupay_pdp_order_checkout',
		'permission_callback' => '__return_true'
	));
}

add_action('rest_api_init', 'register_kupay_pdp_order_create_route');
add_action('rest_api_init', 'register_kupay_pdp_order_checkout_route');