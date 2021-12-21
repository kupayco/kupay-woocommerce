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

function renew_save_again($post_id, $post, $update){
    global $kupay_api_url;
    $slug = 'shop_order';
    if(is_admin()){
        // If this isn't a 'woocommercer order' post, don't update it.
        if ( $slug != $post->post_type ) {
            return;
        }
        if(isset($_POST['kupay-refund-order']) && $_POST['kupay-refund-order']){
            $order = $_POST['kupay-refund-order'];

            $kupay_order_id = getOrderId($order['meta_data']);
            $store_order_id = $order['id'];
            $app_id = get_option("kupay_options_app_id");
            $url = $kupay_api_url . '/order/refund';

            //TODO: POST TO API
            $postdata = http_build_query(
                array(
                    'orderId' => $kupay_order_id,
                    'storeOrderId' => $store_order_id,
                    'appId' => $app_id
                )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $context = stream_context_create($opts);
            $result = file_get_contents($url, false, $context);

            $order['status'] = 'refunded';

            echo $result;
        }
    }
}

function getOrderId($order_meta_data) {
    $kupay_order_id = '';

    foreach ($order_meta_data as $item) {
        if($item['key'] === 'kupay_order_id') {
            $kupay_order_id = $item['value'];
        }
    }

    return $kupay_order_id;
}