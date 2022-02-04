function kupayRefundOrder() {
    let order = document.getElementById('kupay-refund-order');
    let appId = document.getElementById('kupay-app-id');
    let url = document.getElementById('kupay-api-url');

    if (order && appId && url) {
        const confirmation = window.confirm(
            `You are about to refund this order. \nDo you wish to proceed ?`
        );
        if(confirmation) {
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
                location.reload();
            }).catch(err => alert(err.message));
        }

    } else {
        alert('Sorry, there has been an error');
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