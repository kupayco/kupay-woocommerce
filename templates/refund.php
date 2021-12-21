<?php

function action_woocommerce_order_item_add_action_buttons( $order )
{
    echo '<button type="button" onclick="kupayRefundOrder();" class="button generate-items">' . __( 'Refund with Kupay', 'hungred' ) . '</button>';

    // indicate its taopix order generator button
    echo '<input type="hidden" id="kupay-refund-order" name="kupay-refund-order" value="' . esc_attr($order) . '">';
}