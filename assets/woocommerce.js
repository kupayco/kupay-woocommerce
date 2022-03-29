var popupWindow = null;

function observeCartButton() {
    if(popupWindow && popupWindow.closed) {
        window.document.querySelector("kupay-backdrop").dispatchEvent(new Event("remove-kupay-backdrop"));
        popupWindow = null
    }
    const addToCartButton = document.querySelector(
        ".single_add_to_cart_button"
    );

    const kupayBuyButton = document.querySelector(".kupay-buy");

    setInterval(function () {
        if (addToCartButton !== null && addToCartButton.classList.contains("disabled")) {
            kupayBuyButton.classList.add("kupay-buy-disabled");
        } else {
            kupayBuyButton.classList.remove("kupay-buy-disabled");
        }
    }, 300);
}

observeCartButton();

function handleMessage(e) {
    // e.data hold the message from child
    if (e.data && e.data.orderConfirmed) {
        window.removeEventListener("message", handleMessage);
        // window.location.href = `${window.location.origin}/checkout/order-received`;
    }
}

function kupayBuildIframe(iframeUrl) {
    buildBackDrop();
    window.addEventListener("message", handleMessage, false);

    const w = 450;
    const h = 1000;
    var left = screen.width / 2 - w / 2;
    var top = screen.height / 2 - h / 2;

    popupWindow = window.open(
        iframeUrl,
        "Kupay Checkout",
        "_self, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=" +
            w +
            ", height=" +
            h +
            ", top=" +
            top +
            ", left=" +
            left
    );

    const backdrop = document.createElement('kupay-backdrop')
    backdrop.addEventListener("focus-kupay-window", () => {
        window.open("", "Kupay Checkout").focus()
    });
    backdrop.addEventListener("remove-kupay-backdrop", () => {
        backdrop.remove()
    });
    document.querySelector("body").appendChild(backdrop);
}

function buildBackDrop() {
    const template = document.createElement("template");
    const lang = document.documentElement.lang.replace(/[\s\S]{0,3}$/, '')
    const translations = {
        en: {
            message: "No longer see the Kupay window?",
            focusBtn: "Click here" 
        },
        es: {
            message: "¿Ya no ves la ventana de Kupay?",
            focusBtn: "Haga clic aquí" 
        },
        pt: {
            message: "Não está vendo a janela da Kupay?",
            focusBtn: "Clique aqui" 
        }
    }
    template.innerHTML = `
        <style>
            :host {
                display: block;
            }
            :host div.kupay-backdrop {
                z-index: 999;
                position: fixed; 
                top: -1000px; 
                bottom: -1000px; 
                left: -1000px; 
                right: -1000px;
                background-color: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
            :host div.kupay-backdrop__message {
                font-family: Poppins,'Open Sans',Lato, sans-serif;
                font-style: normal;
                font-weight: normal;
                font-size: 18px;
                line-height: 16px;
                text-align: center;
                color: #FFFFFF;
            }
            :host div.kupay-backdrop__message .kupay-backdrop__logo {
                margin-bottom: 32px;
            }
        
            :host div.kupay-backdrop__message .kupay-backdrop__focus-to-kupay-window {
                color: #dfe7fb;
                text-decoration: underline;
                cursor: pointer;
            }
        </style>
        <div class="kupay-backdrop">
            <div class="kupay-backdrop__message">
                <div class="kupay-backdrop__logo">
                    <img alt="Kupay Logo" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQ0IiBoZWlnaHQ9IjU1IiB2aWV3Qm94PSIwIDAgMTQ0IDU1IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8ZyBjbGlwLXBhdGg9InVybCgjY2xpcDBfMTEyXzEwODMpIj4KPHBhdGggZD0iTTUwLjM4MDEgNDMuMjQ0MkM0OS43MjY2IDQzLjI0NDIgNDguMTk3NyA0My4yNDQyIDM2LjU0MjIgMzYuNTM3MkMzNi40NTA2IDM2LjQ4NSAzNi4zNjA2IDM2LjQzMjcgMzYuMjY5IDM2LjM3ODlDMzUuMTY2OSAzNy40MjAzIDM0LjEyMzkgMzguMzgyNSAzMy4xNzI0IDM5LjIzNTVDMjguNjk4OSA0My4yNDI2IDI4LjAyMDYgNDMuMjQyNiAyNy41MjU1IDQzLjI0MjZDMjUuMzg2NSA0My4yNDI2IDIzLjUxMTUgNDEuMzI5MiAyMy41MTE1IDM5LjE1VjE1Ljg0OTdDMjMuNTExNSAxNC4yMDM5IDI0LjU4MDkgMTEuNzU3MiAyNy41MjU1IDExLjc1NzJDMjguMDQwOCAxMS43NTcyIDI4Ljc0NyAxMS43NTcyIDMzLjIzNzYgMTUuODE4MUMzNC4xNjU4IDE2LjY1ODQgMzUuMTg4NyAxNy42MTEyIDM2LjI3NTIgMTguNjQ3N0MzNi4zODM5IDE4LjU4NiAzNi40OTEgMTguNTIyNyAzNi41OTk2IDE4LjQ2MUM0OC4yOTIzIDExLjc1NTYgNDkuNzU0NSAxMS43NTU2IDUwLjM4MDEgMTEuNzU1NkM1Mi44NjA1IDExLjc1NTYgNTQuMzk0IDEzLjg3OTQgNTQuMzk0IDE1Ljg0ODJDNTQuMzk0IDE2LjUyODcgNTQuMDgzNiAxNy42MTI3IDUwLjM3MjMgMjEuODc2MkM0OC45NDc0IDIzLjUxMjYgNDcuMTUxNSAyNS40NjIzIDQ1LjE0NzYgMjcuNTU0NUM0Ny4xNDM3IDI5LjY1MTQgNDguOTQ1OCAzMS42MTcgNTAuMzkyNSAzMy4yNzU1QzU0LjM5NCAzNy44NjUgNTQuMzk0IDM4LjYzODkgNTQuMzk0IDM5LjE1MTZDNTQuMzk0IDQxLjQwODQgNTIuNTkzNSA0My4yNDQyIDUwLjM4MDEgNDMuMjQ0MlpNMzguMDM4NSAzNC42ODg3QzQ4LjI1NTEgNDAuNTUwNiA1MC4xMSA0MC44NzgyIDUwLjM4MDEgNDAuODg0NUM1MS4xNzE3IDQwLjg4NDUgNTIuMDE3NiA0MC4yMzU3IDUyLjA3NTEgMzkuMjU3NkM1MS43MzgyIDM4LjQ0NzQgNDkuMTc4NyAzNS4xNjk5IDQzLjUyMjQgMjkuMjMzNkM0My4wMTE4IDI5Ljc1NzQgNDIuNDkwMiAzMC4yODYgNDEuOTYyNSAzMC44MTc4QzQwLjYzMjIgMzIuMTU2NiAzOS4zMDk4IDMzLjQ2MDcgMzguMDM4NSAzNC42ODg3Wk0yNS44MjQzIDMwLjE2ODlWMzkuMTUzMkMyNS44MjQzIDM5LjkxOTIgMjYuNTA0MSA0MC44MDU0IDI3LjM5OTcgNDAuODgxNEMyOC4xNjY1IDQwLjUyMjEgMzAuNjYwOSAzOC40MzQ3IDM0LjE1NjUgMzUuMTU3MkMzMC4yNTI3IDMyLjg3MDQgMjYuODY1OCAzMC44MDUxIDI1LjgyNDMgMzAuMTY4OVpNMjYuNzEwNiAyNy45NTY1QzI3LjAwNyAyOC4xMzg1IDMxLjE2MjMgMzAuNjkxMiAzNS45MzIyIDMzLjQ3MDJDMzcuMzE4MyAzMi4xMzkyIDM4LjgyMzkgMzAuNjYxMSA0MC40MTAzIDI5LjA2MjdDNDAuOTI4NyAyOC41Mzg5IDQxLjQyNyAyOC4wMzQgNDEuOTAzNSAyNy41NDgyQzQxLjQyMDggMjcuMDUxMiA0MC45MjEgMjYuNTM4NSA0MC4zOTk0IDI2LjAwODNDMzguODAzNyAyNC4zODYyIDM3LjMwMjggMjIuODk1NCAzNS45MjI5IDIxLjU1NjVDMzIuOTI4NyAyMy4yOTEgMjkuNzU5MSAyNS4xNzkgMjYuNzA5IDI3LjA0NDlDMjYuNTAyNiAyNy4xODI2IDI2LjI4MzcgMjcuMzQ4OCAyNi4xMDM2IDI3LjUwMDdDMjYuMjgzNyAyNy42NTI2IDI2LjUwNDEgMjcuODE4OCAyNi43MTA2IDI3Ljk1NjVaTTM4LjAzMDggMjAuMzQ0M0MzOS4zMTYgMjEuNTk5MiA0MC42NjE3IDIyLjkzOTcgNDIuMDIxNSAyNC4zMjI5QzQyLjUzMjEgMjQuODQxOSA0My4wMzUgMjUuMzU3OSA0My41MzAyIDI1Ljg2OUM0OS45MzQ2IDE5LjIwMDEgNTEuODU5MyAxNi4zODc4IDUyLjA3NjYgMTUuNzczOEM1Mi4wMzc4IDE0Ljk2MDMgNTEuMzY1NyAxNC4xMTY4IDUwLjM3ODUgMTQuMTE2OEM0OS4zMDEzIDE0LjE2MTEgNDQuMjI1NiAxNi44MDg4IDM4LjAzMDggMjAuMzQ0M1pNMjcuNDA3NSAxNC4xMTg0QzI2LjU3NCAxNC4xNTE2IDI2LjI2MzUgMTQuNTM0NiAyNi4wODY2IDE0Ljg3MDFDMjUuODM4MiAxNS4zMzg2IDI1LjgyNTggMTUuODU0NSAyNS44MjU4IDE1Ljg1OTJWMjQuODM0QzI2Ljg2MjcgMjQuMjAyNiAzMC4yNTU4IDIyLjE0ODQgMzQuMTY0MiAxOS44Njk1QzMwLjYzMTQgMTYuNTI1NSAyOC4xNjE5IDE0LjQ1MjMgMjcuNDA3NSAxNC4xMTg0WiIgZmlsbD0idXJsKCNwYWludDBfbGluZWFyXzExMl8xMDgzKSIvPgo8cGF0aCBkPSJNNzAuMjA3OSAxOS44NlYyOC4zNDQyQzcwLjIwNzkgMjguMzk5NiA3MC4yNzQ3IDI4LjQyNDkgNzAuMzEwNCAyOC4zODU0TDc0LjA2MiAyNC4yNDg1Qzc0LjExNjQgMjQuMTg4NCA3NC4xOTQgMjQuMTUzNiA3NC4yNzQ3IDI0LjE1MzZINzcuNzc5NkM3OC4wMzQxIDI0LjE1MzYgNzguMTY2MSAyNC40NjM4IDc3Ljk5MDcgMjQuNjUzN0w3NC4wNTEyIDI4LjkyMTlDNzQuMDMyNiAyOC45NDI1IDc0LjAzMSAyOC45NzQxIDc0LjA0NjUgMjguOTk2M0w3OC41MjYyIDM1LjAzMjJDNzguNjcwNSAzNS4yMjY5IDc4LjUzMzkgMzUuNTA3IDc4LjI5NDkgMzUuNTA3SDc0Ljc3OTJDNzQuNjkwNyAzNS41MDcgNzQuNjA4NCAzNS40NjQzIDc0LjU1NTYgMzUuMzkzTDcxLjY4NTYgMzEuNTE0MUM3MS42ODU2IDMxLjUxMjYgNzEuNjg0MSAzMS41MTI2IDcxLjY4MjUgMzEuNTE0MUw3MC4yMDY0IDMzLjEwNjJWMzMuMTA3OFYzNS4yMTU4QzcwLjIwNjQgMzUuMzc3MiA3MC4wNzc2IDM1LjUwODYgNjkuOTE5MiAzNS41MDg2SDY2Ljk2MzhDNjYuODA0IDM1LjUwODYgNjYuNjczNiAzNS4zNzU2IDY2LjY3MzYgMzUuMjEyNlYxOS44NjQ4QzY2LjY3MzYgMTkuNzAxOCA2Ni44MDQgMTkuNTY4OCA2Ni45NjM4IDE5LjU2ODhINjkuOTIyM0M3MC4wODA3IDE5LjU3MDQgNzAuMjA3OSAxOS43MDAyIDcwLjIwNzkgMTkuODZaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNODcuODc1IDM1LjIwNzlWMzMuODQwNUM4Ny44NzUgMzMuNzgyIDg3LjgwMDUgMzMuNzU4MiA4Ny43Njk0IDMzLjgwODlDODcuMDM1MyAzNC45OCA4NS44MTgzIDM1LjcwOTUgODMuOTc1OSAzNS43MjU0QzgxLjY5NzIgMzUuNzQ0NCA3OS44NDU1IDMzLjg1IDc5Ljg0NTUgMzEuNTI2OFYyNC40NDk1Qzc5Ljg0NTUgMjQuMjg2NSA3OS45NzU4IDI0LjE1MzYgODAuMTM1NyAyNC4xNTM2SDgzLjA4NDlDODMuMjQ2MyAyNC4xNTM2IDgzLjM3ODMgMjQuMjg4MSA4My4zNzgzIDI0LjQ1MjdWMzAuNzAzOEM4My4zNzgzIDMxLjk5MjEgODQuNjg1MiAzMi41NjAyIDg1LjU0MDUgMzIuNTYwMkM4Ni41ODk4IDMyLjU2MDIgODcuODc1IDMyLjAxNDIgODcuODc1IDMwLjI2NzFWMjQuNDQ3OUM4Ny44NzUgMjQuMjg0OSA4OC4wMDM4IDI0LjE1MzYgODguMTYzNyAyNC4xNTM2SDkxLjExNDRDOTEuMjc1OSAyNC4xNTM2IDkxLjQwNzggMjQuMjg4MSA5MS40MDc4IDI0LjQ1MjdWMzUuMjExQzkxLjQwNzggMzUuMzc0IDkxLjI3NzQgMzUuNTA3IDkxLjExNzUgMzUuNTA3SDg4LjE2ODNDODguMDA2OSAzNS41MDg1IDg3Ljg3NSAzNS4zNzQgODcuODc1IDM1LjIwNzlaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNOTMuODg4NCAyNC4xNTVIOTYuOTU3MUM5Ny4wODYgMjQuMTU1IDk3LjE5MTUgMjQuMjYxMSA5Ny4xOTE1IDI0LjM5NFYyNS42NjAxQzk3LjE5MTUgMjUuNzIwMiA5Ny4yNjc2IDI1Ljc0MjQgOTcuMjk4NiAyNS42OTE3Qzk3Ljk1NTIgMjQuNjAyOSA5OS4wNDc5IDIzLjkzODIgMTAwLjgzMSAyMy45MzgyQzEwMy40ODcgMjMuOTM4MiAxMDUuOTcxIDI2LjM2MTIgMTA1Ljk3MSAyOS44MzMzQzEwNS45NzEgMzMuMzA1NSAxMDMuNDg3IDM1LjcyODQgMTAwLjgzMSAzNS43Mjg0Qzk5LjAwNiAzNS43Mjg0IDk3LjkwODYgMzUuMDg3NSA5Ny4yNzM4IDM0LjA1NTdDOTcuMjUwNSAzNC4wMTc3IDk3LjE5MTUgMzQuMDM1MSA5Ny4xOTE1IDM0LjA4MVYzOS42MzlDOTcuMTkxNSAzOS43NzAzIDk3LjA4NzUgMzkuODc2NCA5Ni45NTg3IDM5Ljg3NjRIOTMuODlDOTMuNzYyNyAzOS44NzY0IDkzLjY1ODcgMzkuNzcwMyA5My42NTg3IDM5LjY0MDZWMjQuMzkwOUM5My42NTcyIDI0LjI1OTUgOTMuNzYxMiAyNC4xNTUgOTMuODg4NCAyNC4xNTVaTTk5Ljg2NzUgMzIuNTYwMUMxMDEuNDc0IDMyLjU2MDEgMTAyLjQzOCAzMS41NTUyIDEwMi40MzggMjkuODMxOEMxMDIuNDM4IDI4LjEwNjcgMTAxLjQ3NCAyNy4xMDE4IDk5Ljg2NzUgMjcuMTAxOEM5OC4yNjEgMjcuMTAxOCA5Ny4xOSAyOC4xMDY3IDk3LjE5IDI5LjgzMThDOTcuMTkgMzEuNTU2OCA5OC4yNjEgMzIuNTYwMSA5OS44Njc1IDMyLjU2MDFaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTEzLjc4OCAyOC45MTM4SDExNC42NDRWMjguNzM5OEMxMTQuNjQ0IDI3LjUzODYgMTEzLjc2NiAyNi44ODM0IDExMi40NiAyNi44ODM0QzExMS4wNTkgMjYuODgzNCAxMTAuNDQ0IDI3LjMyODEgMTA5Ljg2MiAyNy44Mzc3QzEwOS43MzYgMjcuOTQ2OSAxMDkuNTQ3IDI3LjkyOTUgMTA5LjQ0MyAyNy43OTY1TDEwNy45NyAyNS45MTAxQzEwNy44NjkgMjUuNzgxOSAxMDcuODkxIDI1LjU5NTIgMTA4LjAxNiAyNS40OTA3QzEwOS4xODUgMjQuNTMxNyAxMTAuNTUgMjMuOTM1MSAxMTIuODAyIDIzLjkzNTFDMTE1Ljg2NCAyMy45MzUxIDExOC4xNzcgMjUuNTk1MiAxMTguMTc3IDI4LjMwMTRWMzUuMjEwOUMxMTguMTc3IDM1LjM3MzkgMTE4LjA0NyAzNS41MDY5IDExNy44ODcgMzUuNTA2OUgxMTQuOTM1QzExNC43NzMgMzUuNTA2OSAxMTQuNjQzIDM1LjM3MzkgMTE0LjY0MyAzNS4yMDkzVjM0LjI0MjRDMTE0LjY0MyAzNC4xODU0IDExNC41NzMgMzQuMTYwMSAxMTQuNTM5IDM0LjIwNDRDMTEzLjc5NyAzNS4xNDc2IDExMi41NzUgMzUuNzI1MyAxMTEuMDAzIDM1LjcyNTNDMTA4Ljg4MyAzNS43MjUzIDEwNy4yMTIgMzQuNjExMSAxMDcuMjEyIDMyLjIzMjVDMTA3LjIxMiAyOS4yODU4IDEwOS43ODMgMjguOTEzOCAxMTMuNzg4IDI4LjkxMzhaTTExMi4yODggMzMuMjE1M0MxMTMuNTMgMzMuMjE1MyAxMTQuNjQ0IDMyLjg4NzcgMTE0LjY0NCAzMS4xNDA1VjMxLjAwNDRDMTE0LjY0NCAzMC45NzEyIDExNC42MTggMzAuOTQ0MyAxMTQuNTg1IDMwLjk0NDNIMTE0LjQzQzExMS42NjcgMzAuOTQ0MyAxMTAuOTYxIDMxLjMxNjIgMTEwLjk2MSAzMi4wNzlDMTEwLjk1OSAzMi44MjI4IDExMS41ODIgMzMuMjE1MyAxMTIuMjg4IDMzLjIxNTNaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTIyLjkzNSAyNC4zNTNMMTI1LjM4MyAzMS40MjM5QzEyNS40MDEgMzEuNDc2MSAxMjUuNDczIDMxLjQ3NjEgMTI1LjQ5IDMxLjQyMzlMMTI3LjkzNyAyNC4zNTNDMTI3Ljk3OCAyNC4yMzQzIDEyOC4wODggMjQuMTU1MSAxMjguMjExIDI0LjE1NTFIMTMxLjEyM0MxMzEuMzI0IDI0LjE1NTEgMTMxLjQ2NCAyNC4zNTkzIDEzMS4zOTQgMjQuNTUyNEwxMjYuOTM1IDM2LjgxODlDMTI2LjI3IDM4LjkxNDMgMTI0Ljc1MSA0MC4wOTMzIDEyMi44NDUgNDAuMDkzM0MxMjEuNzA3IDQwLjA5MzMgMTIwLjM0NiAzOS41OTk1IDExOS42OTggMzguOTMxN0MxMTkuNjE2IDM4Ljg0NjIgMTE5LjU5NiAzOC43MTggMTE5LjY0NCAzOC42MDg4TDEyMC41MjMgMzYuNTc1MkMxMjAuNTk5IDM2LjM5OCAxMjAuODE4IDM2LjM0NzMgMTIwLjk2OCAzNi40NjZDMTIxLjM4NCAzNi43OTY4IDEyMS44MDUgMzYuOTI2NSAxMjIuMzA5IDM2LjkyNjVDMTIyLjg4MiAzNi45MjY1IDEyMy42NjcgMzYuNjQ4IDEyNC4wMzUgMzUuNjYyMUMxMjQuMDQxIDM1LjY0NjIgMTI0LjA0IDM1LjYyODggMTI0LjAzNCAzNS42MTQ2TDExOS4zOTkgMjQuNTY2NkMxMTkuMzE3IDI0LjM3MiAxMTkuNDU4IDI0LjE1MzYgMTE5LjY2NiAyNC4xNTM2SDEyMi42NkMxMjIuNzg0IDI0LjE1NTEgMTIyLjg5NCAyNC4yMzQzIDEyMi45MzUgMjQuMzUzWiIgZmlsbD0id2hpdGUiLz4KPC9nPgo8ZGVmcz4KPGxpbmVhckdyYWRpZW50IGlkPSJwYWludDBfbGluZWFyXzExMl8xMDgzIiB4MT0iMjQuNjkzOCIgeTE9IjQxLjk5NDUiIHgyPSI1My43NDgiIHkyPSIxMy40OTgiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj4KPHN0b3Agc3RvcC1jb2xvcj0iIzNGMzBEMSIvPgo8c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM4N0Y4RTAiLz4KPC9saW5lYXJHcmFkaWVudD4KPGNsaXBQYXRoIGlkPSJjbGlwMF8xMTJfMTA4MyI+CjxyZWN0IHdpZHRoPSIxMDcuOTAxIiBoZWlnaHQ9IjMxLjQ4ODUiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyMy41MTE1IDExLjc1NTYpIi8+CjwvY2xpcFBhdGg+CjwvZGVmcz4KPC9zdmc+Cg==">
                </div>
                <div>
                    <p>${translations[lang || 'es'].message}</p>
                    <p>
                    <a id="focusToKupayWindow" class="kupay-backdrop__focus-to-kupay-window">${translations[lang || 'es'].focusBtn}</a>
                    </p>
                </div>
            </div>
        </div>
    `
    class KupayBackdrop extends HTMLElement {
        constructor() {
            super();
            const wrapper = this.attachShadow({ mode: "open" });
            wrapper.appendChild(template.content.cloneNode(true));
            const buttonFocus = wrapper.getElementById("focusToKupayWindow")
            if(buttonFocus) buttonFocus.addEventListener("click",  () => {
                this.dispatchEvent(new Event("focus-kupay-window"))
            })
        }
    }

    window.customElements.define('kupay-backdrop', KupayBackdrop);
}

function kupayPDPCheckout() {
    let variantId = "";

    if (document.getElementsByClassName("variation_id").length) {
        variantId = document.getElementsByClassName("variation_id")[0].value;
    }

    var iframeUrl = document.getElementById("kupay-url").value;

    iframeUrl += "?appId=" + document.getElementById("kupay-app-id").value;
    iframeUrl +=
        "&productId=" + document.getElementById("kupay-product-id").value;
    iframeUrl +=
        "&productName=" + document.getElementById("kupay-product-name").value;
    iframeUrl +=
        "&productQuantity=" +
        document.getElementsByClassName("input-text qty text").quantity
            .valueAsNumber;
    iframeUrl += "&productImageUrl=" + "";
    iframeUrl +=
        "&productPrice=" + document.getElementById("kupay-product-price").value;
    iframeUrl +=
        "&requiresProcessing=" +
        document.getElementById("kupay-requires-processing").value;
    iframeUrl += "&origin=" + document.getElementById("kupay-origin").value;
    iframeUrl += "&currency=" + document.getElementById("kupay-currency").value;
    iframeUrl +=
        "&deliveryCost=" + document.getElementById("kupay-delivery-cost").value;
    iframeUrl += "&variantId=" + variantId;

    kupayBuildIframe(iframeUrl);
}

function kupayCartCheckout() {
    var iframeUrl = document.getElementById("kupay-url").value;

    iframeUrl += "?appId=" + document.getElementById("kupay-app-id").value;
    iframeUrl +=
        "&requiresProcessing=" +
        document.getElementById("kupay-requires-processing").value;
    iframeUrl += "&origin=" + document.getElementById("kupay-origin").value;
    iframeUrl += "&currency=" + document.getElementById("kupay-currency").value;
    iframeUrl +=
        "&deliveryCost=" + document.getElementById("kupay-delivery-cost").value;
    iframeUrl += "&cartId=" + document.getElementById("kupay-cart-id").value;
    iframeUrl +=
        "&cartTotal=" + document.getElementById("kupay-cart-total").value;

    kupayBuildIframe(iframeUrl);
}

if (document.getElementsByClassName("kupay-buy").length > 0) {
    document.getElementsByClassName("kupay-buy")[0].innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2.15 2.14"><defs><style>.cls-1{fill:#576ab0;}.cls-2{fill:#4855a1;}.cls-3{fill:#6485c3;}.cls-4{fill:#70a4d9;}.cls-5{fill:#8ccfd6;}</style></defs><title>Recurso 4</title><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="cls-1" d="M0,1.14V.43C.07.43.09.51.15.51s0,.2,0,.3,0,.06.08,0a.11.11,0,0,1,.1.1l0,0S.2,1,.2,1.07s.06.05.09.07l.44.26a.16.16,0,0,0,.24,0l.11.09S1,1.51,1,1.56l.38.21a.16.16,0,0,0,.07.12s0,.05,0,.07l-.3-.15a1,1,0,0,0-.29-.13S.77,1.62.71,1.63s0-.06,0-.08l-.52-.3C.1,1.23.08,1.15,0,1.14Z"/><path class="cls-2" d="M.86,1.68a5.82,5.82,0,0,1-.53.46H.23A.37.37,0,0,1,0,1.91V1.14c.08,0,.1.09.16.11v.58A.13.13,0,0,0,.23,2c.06,0,.09,0,.12-.05s.24-.19.36-.29S.81,1.67.86,1.68Z"/><path class="cls-3" d="M1.79,2.14c-.1-.08-.24-.1-.34-.18s0-.05,0-.07a.16.16,0,0,1-.07-.12L1.77,2a.15.15,0,0,0,.2,0L2.1,2c0,.1-.13.11-.21.15Z"/><path class="cls-3" d="M.15.51C.09.51.07.43,0,.43V.2C.05.17,0,.1.1.07S.18.13.23.15A.22.22,0,0,0,.15.28Z"/><path class="cls-4" d="M.23.15C.18.13.16.07.1.07a.22.22,0,0,1,.32,0,3.61,3.61,0,0,1,.3.25c.11.12.21.17.35.06s.08.06.09.11l-.1.06s0,0,0,.08l.3.29a.06.06,0,0,0,.09,0L1.53.83s.05.09.11.09c-.14.15-.13.15,0,.31a5.15,5.15,0,0,1,.43.5A.19.19,0,0,1,2.1,2L2,1.93a.08.08,0,0,0,0-.11,5.23,5.23,0,0,0-.54-.61s0,0-.06,0l-.08-.11A1.61,1.61,0,0,0,1,.79C.92.69.83.65.72.73L.66.61s.11,0,0-.09A1.58,1.58,0,0,0,.23.15Z"/><path class="cls-5" d="M1.64.92c-.06,0-.07-.06-.11-.09.12-.16.29-.3.4-.47S2,.27,2,.2s-.11-.05-.18,0L1.16.49S1.1.41,1.07.38A3.3,3.3,0,0,1,1.8,0a.23.23,0,0,1,.29.09.21.21,0,0,1,0,.29A3.17,3.17,0,0,1,1.64.92Z"/><path class="cls-3" d="M.23.86A2.3,2.3,0,0,1,.66.61L.72.73.33,1A.11.11,0,0,0,.23.86Z"/><path class="cls-3" d="M1.36,1.2a3.7,3.7,0,0,1-.28.28L1,1.39l.31-.3Z"/></g></g></svg>
    `;
    document.getElementsByClassName("kupay-buy")[0].innerHTML +=
        "COMPRAR EN 1 CLICK";
}

console.log("KUPAY_WOOCOMMERCE_VERSION: ", document.getElementById("kupay-woocommerce-version").value)