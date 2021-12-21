alert('working!');

function kupayRefundOrder() {
    const order = document.getElementById('kupay-refund-order');

    if(order) {
        console.log('order', JSON.parse(order.value));
    } else {
        alert('Order doesn\'t exists');
    }
}