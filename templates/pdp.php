<?php


function insert_pdp_kupay_checkout($redirect_page){

	global $product;

	$href = '?add-to-cart=' . esc_attr( $product->get_id() ) . '&quantity=12';
	$href = '#';
	$class = 'single_add_to_cart_button-12 button alt';
	$id = 'kupay_pdp_checkout';
	$style = 'display: inline-block; margin-top: 12px;';
	$button_text = __( "Buy in 1-Click with KuPay" );

	echo '<br><a rel="no-follow" href="'.$href.'" class="'.$class.'" id="'.$id.'" style="'.$style.'">'.$button_text.'</a>';

}