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

function kupay() {
	echo "<p id='kupay'>Kupay!</p>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'kupay' );


