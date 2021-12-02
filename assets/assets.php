<?php

function kupay_enqueue_kupay_js(){
	wp_enqueue_script( 'kupay',  KUPAY_STATIC_URL . '/woocommerce.js' , [], null, true );
}

function kupay_enqueue_kupay_css(){
	wp_enqueue_style ('style', KUPAY_STATIC_URL . '/woocommerce.css');
}
