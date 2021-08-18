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
require_once('includes/checkout.php');
require_once('includes/kupay_api_client.php');
require_once('includes/kupay_wc_rest_api.php');
require_once('assets/assets.php');
require_once('templates/pdp.php');

// Assets
add_action( 'wp_enqueue_scripts', 'enqueue_js' );
add_action( 'wp_enqueue_scripts', 'enqueue_css' );

// Settings
add_action('admin_menu', 'create_settings_menu');

// Templates
add_action( 'woocommerce_after_add_to_cart_button', 'insert_pdp_kupay_checkout', 20);

