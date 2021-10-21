<?php
/**
 * @package Kupay
 * @version 1.0
 */
/*
Plugin Name: Kupay for WooCommerce
Plugin URI: http://kupay.co
Description: Kupay for WooCommerce
Author: Kupay
Version: 1.0
Author URI: https://github.com/kupayco
*/

// Requires
require_once('includes/settings.php');
require_once('includes/checkout.php');
require_once('includes/api.php');
require_once('assets/assets.php');
require_once('templates/pdp.php');
require_once('templates/cart.php');
require_once('templates/checkout.php');

// Assets
add_action( 'wp_enqueue_scripts', 'enqueue_kupay_js' );
add_action( 'wp_enqueue_scripts', 'enqueue_kupay_css' );

// Settings
add_action('admin_menu', 'create_settings_menu');

// Templates
add_action( 'woocommerce_before_add_to_cart_button', 'kupay_render_cart', 20);
add_action( 'woocommerce_proceed_to_checkout', 'kupay_render_cart', 10 );
add_action( 'woocommerce_before_checkout_form', 'kupay_render_checkout', 10 );

// IFrame URL
$kupay_iframe_url = "https://checkout.kupay.co/#/order-received";

if(get_option( 'kupay_options_test_mode' )){
    $kupay_iframe_url = "http://localhost:3001/#/order-received";
}

define("KUPAY_IFRAME_URL", $kupay_iframe_url);


// Statics URL
$kupay_static_url = "https://static.kupay.co";

if(get_option( 'kupay_options_test_mode' )){
    $kupay_static_url = plugins_url() . "/kupay-woocommerce/assets";
}

define("KUPAY_STATIC_URL", $kupay_static_url);








