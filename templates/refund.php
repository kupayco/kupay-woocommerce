<?php

function action_woocommerce_order_item_add_action_buttons( $order )
{
    wp_enqueue_script( 'kupay',  KUPAY_STATIC_URL . '/refund.js' , [], null, true );

    global $kupay_api_url;
    $app_id = get_option('kupay_options_app_id');

    echo '<button type="button" onclick="kupayRefundOrder();" class="button generate-items">' . __( 'Refund with Kupay', 'hungred' ) . '</button>';
    echo '<input type="hidden" id="kupay-refund-order" name="kupay-refund-order" value="' . esc_attr($order) . '">';
    echo '<input type="hidden" id="kupay-app-id" name="kupay-app-id" value="' . esc_html($app_id) . '">';
    echo '<input type="hidden" id="kupay-api-url" name="kupay-api-url" value="' . esc_attr($kupay_api_url) . '">';
}