<?php

function enqueue_js(){

	//vendors
	wp_enqueue_script( 'boostrap',  plugins_url() . '/kupay-woocommerce/assets/vendor/bootstrap/bootstrap.bundle.min.js');
	wp_enqueue_script( 'kupay',  plugins_url() . '/kupay-woocommerce/assets/kupay.js' );
	wp_enqueue_script( 'main',  plugins_url() . '/kupay-woocommerce/assets/main.js' );

}

function enqueue_css(){

	wp_register_style( 'bootstrap', plugins_url() . '/kupay-woocommerce/assets/vendor/bootstrap/bootstrap.min.css');
	wp_enqueue_style( 'bootstrap' );

}