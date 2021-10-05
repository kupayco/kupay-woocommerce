<?php

function enqueue_kupay_js(){
	wp_enqueue_script( 'kupay',  plugins_url() . '/kupay-woocommerce/assets/kupay.js' , [], false, true );
}

function enqueue_kupay_css(){
	wp_enqueue_style ('style', plugins_url() . '/kupay-woocommerce/assets/kupay.css');
}
