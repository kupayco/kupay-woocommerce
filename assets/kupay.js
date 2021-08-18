function kupayCheckout(){
    let product = {
        id: document.getElementsByName("add-to-cart")[0].value.toString(),
        image_url: document.getElementsByClassName("woocommerce-product-gallery__image")[0].attributes["data-thumb"].value.toString(),
        quantity: document.getElementsByClassName("input-text qty text")[0].valueAsNumber
    }

    let store = {
        id: '12345'
    }
    let customer = {
        email: "jaf@kupay.co",
        first_name: "Jaf",
        last_name: "Aguiar Gonçalves",
        shipping_data: {
            address: "Calle de Rafael de Riego, 34, 2C",
            addressDescription: "2C",
            zipCode: "28045",
            city: "Madrid",
            country: "Spain",
            state: "Madrid"
        },
        billing_info: {
            first_name: "Jaf",
            last_name: "Aguiar Gonçalves",
            billing_address: {
                name: "Calle de Rafael de Riego, 34, 2C",
                details: "2C",
                province: "Madrid",
                city: "Madrid",
                zip_code: "28045"
            }
        },
        payment_data: {
            cardBrandName: "Hardocded",
            cardBrandLogo: "https://logoeps.com/wp-content/uploads/2014/08/39196-visa-pay-logo-icon-vector-icon-vector-eps.png",
            description: "Termina en 1111 - Expira el 062"
        }
    }

    let data = {
        product: product,
        customer: customer,
        store: store
    };

    fetch("/wordpress/wp-json/kupay/wc/checkout", {
        method: "POST",
        body: JSON.stringify(data)
    }).then(res => {
        console.log("Request complete! response:", res);
    });
}