function kupayRefundOrder() {
    let order = document.getElementById('kupay-refund-order');
    let appId = document.getElementById('kupay-app-id');
    let url = document.getElementById('kupay-api-url');

    if (order) {
        url = url.value + '/order/refund';
        appId = appId.value;
        order = JSON.parse(order.value);
        const storeOrderId = order.id;
        const orderId = getKupayOrderId(order.meta_data);

        const data = {
            appId: String(appId),
            storeOrderId: String(storeOrderId),
            orderId: String(orderId),
        }

        fetch(url, {
            method: 'PUT',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data)
        }).then(response => {
            return response.text();
        }).then(response => {
            alert(response);
        }).catch(err => alert(err.message));

    } else {
        throw new Error('Order doesn\'t exists!');
    }
}

function getKupayOrderId(orderMetaData) {
    let kupayOrderId = '';

    orderMetaData.forEach(metaData => {
        if(metaData.key === 'kupay_order_id') {
            kupayOrderId = metaData.value;
        }
    })

    return kupayOrderId;
}