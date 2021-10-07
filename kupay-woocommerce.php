<?php
/**
 * @package Kupay
 * @version 0.0.1
 */
/*
Plugin Name: Kupay WooCommerce
Plugin URI: http://kupay.co
Description: Kupay WooCommerce Plugin
Author: Kupay
Version: 0.0.1
Author URI: https://github.com/kupayco
*/

// Requires
require_once ('vendor/autoload.php');
require_once('includes/settings.php');
require_once('includes/cart.php');
require_once('includes/checkout.php');
require_once('includes/kupay_wc_rest_api.php');
require_once('assets/assets.php');
require_once('templates/pdp.php');
require_once('templates/cart.php');

// Assets
add_action( 'wp_enqueue_scripts', 'enqueue_kupay_js' );
add_action( 'wp_enqueue_scripts', 'enqueue_kupay_css' );

// Settings
add_action('admin_menu', 'create_settings_menu');

// Templates
add_action( 'woocommerce_after_add_to_cart_button', 'insert_pdp_kupay_checkout', 20);
add_action( 'woocommerce_proceed_to_checkout', 'insert_cart_kupay_checkout', 10 );
add_action( 'woocommerce_before_checkout_form', 'insert_cart_kupay_checkout', 10 );
add_action('woocommerce_add_to_cart', 'identify_kupay_cart');

$kupay_iframe_url = "https://checkout.kupay.co/#/order-received";

if(get_option( 'kupay_options_test_mode' )){

    $kupay_iframe_url = "http://localhost:3001/#/order-received";

}

define("KUPAY_IFRAME_URL", $kupay_iframe_url);






