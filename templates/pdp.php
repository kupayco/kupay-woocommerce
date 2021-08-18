<?php


function insert_pdp_kupay_checkout(){

	$href = 'kupayCheckout()';
	$class = 'ingle_add_to_cart_button-12 button alt';
	$id = 'kupay_pdp_checkout';
	$style = 'display: inline-block; margin-top: 12px;';
	$button_text = __( "Buy in 1-Click with KuPay" );

	echo '<br><a rel="no-follow" onclick="'.$href.'" class="'.$class.'" id="'.$id.'" style="'.$style.'">'.$button_text.'</a>';

}

function build_redirect_to_place_order_page_url(): string{
	return get_site_url() . '/checkout/order-received/' . '48' . '?key=' . 'wc_order_wJovWGCr2fl5n';
}