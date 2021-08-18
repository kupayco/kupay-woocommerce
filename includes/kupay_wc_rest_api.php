<?php

const KUPAYWC_BASE_ROUTE = 'kupay/wc';

function register_checkout_route()
{

	$namespace = KUPAYWC_BASE_ROUTE;
	$route     = 'checkout';

	register_rest_route($namespace, $route, array(
		'methods'   => WP_REST_Server::CREATABLE,
		'callback'  => 'kupay_product_checkout',
		'permission_callback' => '__return_true'
	));
}

add_action('rest_api_init', 'register_checkout_route');