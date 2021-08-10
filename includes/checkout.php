<?php

use Automattic\WooCommerce\Client;

// to update shipping cost on cart review WC_AJAX::update_order_review();
function build_order_data(): array {

	return [
		'payment_method' => 'bacs',
		'payment_method_title' => 'Direct Bank Transfer',
		'set_paid' => true,
		'billing' => [
			'first_name' => 'Jaf',
			'last_name' => 'Gonçalves',
			'address_1' => 'Rafael de Riego 34',
			'address_2' => '',
			'city' => 'Madrid',
			'state' => 'MA',
			'postcode' => '28045',
			'country' => 'ES',
			'email' => 'jaf@kupay.co',
			'phone' => '+34651326460'
		],

		'shipping' => [
			'first_name' => 'Jaf',
			'last_name' => 'Gonçalves',
			'address_1' => 'General Martinez Campos 36',
			'address_2' => '',
			'city' => 'Madrid',
			'state' => 'MA',
			'postcode' => '28045',
			'country' => 'ES'
		],

		'line_items' => [
			[
				'product_id' => 11,
				'quantity' => 2
			]
		]
	];

}

function checkout_pdp(){

	$woocommerce = new Client( 'http://localhost:8888/wordpress', 'ck_b2adad5d1130ced882084877ad7b4e6cef85b319', 'cs_6aa33442647b52cf9d30e0b77d394527141d7a07' );
	$order = $woocommerce->post('orders', build_order_data());

	$href = redirect_to_place_order_page_url('48', 'wc_order_wJovWGCr2fl5n');
	$class = 'ingle_add_to_cart_button-12 button alt';
	$id = 'kupay_pdp_checkout';
	$style = 'display: inline-block; margin-top: 12px;';
	$button_text = __( "Buy in 1-Click with KuPay" );

	echo '<br><a rel="no-follow" href="'.$href.'" class="'.$class.'" id="'.$id.'" style="'.$style.'">'.$button_text.'</a>';

}

function redirect_to_place_order_page_url($order_id, $order_key): string{
	return get_site_url() . '/checkout/order-received/' . $order_id . '?key=' . $order_key;
}
