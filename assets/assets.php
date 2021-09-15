<?php

function enqueue_kupay_js(){
	wp_enqueue_script( 'kupay-react',  plugins_url() . '/kupay-woocommerce/assets/vendor/react/react.development.js', [], false, true );
	wp_enqueue_script( 'kupay-react-dom',  plugins_url() . '/kupay-woocommerce/assets/vendor/react/react-dom.development.js' , [], false, true );
	wp_enqueue_script( 'kupay',  plugins_url() . '/kupay-woocommerce/assets/kupay.js' , [], false, true );
	wp_enqueue_script( 'kupay-order-data',  plugins_url() . '/kupay-woocommerce/assets/kupay-order-data.js' , [], false, true );
}