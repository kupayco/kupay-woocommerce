<?php

function enqueue_js(){

	wp_enqueue_script( 'boostrap',  plugins_url() . '/kupay-woocommerce/assets/vendor/bootstrap/bootstrap.bundle.min.js');
	wp_enqueue_script( 'kupay',  plugins_url() . '/kupay-woocommerce/assets/kupay.js' );

}

function enqueue_css(){

	wp_register_style( 'bootstrap', plugins_url() . '/kupay-woocommerce/assets/vendor/bootstrap/bootstrap.min.css');
	wp_enqueue_style( 'bootstrap' );

}