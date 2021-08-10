<?php
/**
 * @package Kupay
 * @version 0.0.1
 */
/*
Plugin Name: Kupay
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
require_once('assets/assets.php');

add_action( 'wp_enqueue_scripts', 'enqueue_js' );
add_action( 'wp_enqueue_scripts', 'enqueue_css' );

add_action('admin_menu', 'create_settings_menu');
add_action( 'woocommerce_after_add_to_cart_button', 'checkout_pdp', 20);


// Templates
require_once('templates/checkout-template.php');

