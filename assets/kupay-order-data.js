function kupay_prepare_order_data(){
    let product = {
        id: document.getElementsByName("add-to-cart")[0].value.toString(),
        image_url: document.getElementsByClassName("woocommerce-product-gallery__image")[0].attributes["data-thumb"].value.toString(),
        quantity: document.getElementsByClassName("input-text qty text")[0].valueAsNumber
    }

    document.getElementById("kupay-buy").setAttribute("kupay-data-product", JSON.stringify(product));
}