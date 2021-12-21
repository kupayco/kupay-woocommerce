async function kupayRefundOrder() {
    let order = document.getElementById('kupay-refund-order');
    let appId = document.getElementById('kupay-app-id');
    let url = document.getElementById('kupay-api-url');

    if(order) {
        url = url.value + '/order/refund';
        appId = appId.value;
        order = JSON.parse(order.value);
        const storeOrderId = order.id;
        const orderId = getKupayOrderId(order.meta_data);

        console.log('appId', appId);
        console.log('url', url);
        console.log('storeOrderId', storeOrderId);
        console.log('orderId', orderId);

        const data = {
            appId: String(appId),
            storeOrderId: String(storeOrderId),
            orderId: String(orderId),
        }

        let response = await fetch(url, {
            method: 'PUT',
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data)
        });

        response = await response.json();

        console.log('response', response);

    } else {
        console.log('Order doesn\'t exists!');
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