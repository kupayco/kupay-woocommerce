function kupayBuildIframe(iframeUrl){

    const w = 450;
    const h = 1000;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    
    window.open(iframeUrl, "Kupay Checkout", '_self, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

}

function kupayPDPCheckout(){

    var iframeUrl = document.getElementById("kupay-url").value;

    iframeUrl += "?appId=" + document.getElementById("kupay-app-id").value;
    iframeUrl += "&productId=" + document.getElementById("kupay-product-id").value;
    iframeUrl += "&productName=" + document.getElementById("kupay-product-name").value;
    iframeUrl += "&productQuantity=" + document.getElementsByClassName("input-text qty text").quantity.valueAsNumber;
    iframeUrl += "&productImageUrl=" + "";
    iframeUrl += "&productPrice=" + document.getElementById("kupay-product-price").value;
    iframeUrl += "&requiresProcessing=" + document.getElementById("kupay-requires-processing").value;
    iframeUrl += "&origin=" + document.getElementById("kupay-origin").value;
    iframeUrl += "&currency=" + document.getElementById("kupay-currency").value;
    iframeUrl += "&deliveryCost=" + document.getElementById("kupay-delivery-cost").value;

    kupayBuildIframe(iframeUrl);

}

function kupayCartCheckout(){

    var iframeUrl = document.getElementById("kupay-url").value;

    iframeUrl += "?appId=" + document.getElementById("kupay-app-id").value;
    iframeUrl += "&requiresProcessing=" + document.getElementById("kupay-requires-processing").value;
    iframeUrl += "&origin=" + document.getElementById("kupay-origin").value;
    iframeUrl += "&currency=" + document.getElementById("kupay-currency").value;
    iframeUrl += "&deliveryCost=" + document.getElementById("kupay-delivery-cost").value;
    iframeUrl += "&cartId=" + document.getElementById("kupay-cart-id").value;

    kupayBuildIframe(iframeUrl);

}

document.getElementsByClassName("kupay-buy")[0].innerHTML = "COMPRAR EN 1-CLICK";