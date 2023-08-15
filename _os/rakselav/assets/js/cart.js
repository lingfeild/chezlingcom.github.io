$("#addToCart").click(function() {
    var productPrice = $('#product-price').html();
    var productName = $('#product-name').html();
    var multiplier = $("#multiplier").val();
    var href = window.location.pathname;
    var productAdditional = $("#product-additional").val();

    if(productAdditional == null){
        productAdditionalName = "";
        productAdditionalPrice = 0;
    } else {
        productAdditional = productAdditional.split(' €');
        productAdditionalName = productAdditional[0];
        productAdditionalPrice = productAdditional[1];
    }

    productTotalPrice = (parseFloat(productAdditionalPrice) + parseFloat(productPrice)).toFixed(2);

    produtCookie = productName + "=" + href + "&" + productName + "&" + productAdditionalName + "&" + multiplier + "&" + productTotalPrice;
    document.cookie = produtCookie;
    updateCartBadge();
});

function getAllCookies(indexToRemove = -1) {
    var pairs = document.cookie.split(";");
    var cookies = [];
    for (var i = 0; i < pairs.length; i++) {
        var pair = pairs[i].split("=");
        if (i == indexToRemove) {
            document.cookie = pair[0] + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
        } else if((pair[0]).trim() == "PHPSESSID"){

        } else if((pair[0]).trim() == "corpshopAmount") {

        } else {
            cookies.push(pair[1]);
        }
    }
    return cookies;
}

function updateCartArea(indexToRemove = -1) {
    cartList = "";
    cookies = getAllCookies(indexToRemove);
    updateCartBadge();
    if (cookies == undefined || cookies.length == 0 || cookies == "") {
        productTotal = 0;
        $('#purchase_amount').val(productTotal);
        productTotal = 'corpshopAmount' + "=" + productTotal;
        document.cookie = productTotal;
        $('#cartArea').html('<span class="product-total">Your total: $0.00</span>');
        return;
    }
    var productTotal = 0;
    for (var i = 0; i < cookies.length; i++) {
        if (cookies[i] != undefined && cookies[i] != "") {
            cookie = cookies[i].split("&");
            cartList += '<div class="header-cart-item-txt p-t-8">';
            cartList += '<a href="' + cookie[0] + '" class="header-cart-item-name m-b-18 hov-cl1 trans-04">';
            cartList += cookie[1] + '</a>';
            cartList += '<span class="header-cart-item-info">';
            if(cookie[2] != ""){
                cartList += ' + ' + cookie[2];
            }
            cartList += " - " + cookie[3] + 'x ' + cookie[4];
            cartList += "<button type='button' onClick='removeFromCart("+i+")'>X</button>";
            cartList += '</span></div></li>'

            productTotal += parseFloat(cookie[3]) * parseFloat(cookie[4]);
        }
    }
    productTotal = (productTotal).toFixed(2);
    $('#purchase_amount').val(productTotal);
    cartList += '<span class="product-total">Your total: $' + productTotal;
    cartList += '</span>';
    productTotal = 'corpshopAmount' + "=" + productTotal;
    document.cookie = productTotal;
    $('#cartArea').html(cartList);
}

function updateCartBadge() {
    const cartItems = getAllCookies();
    const shoppingCart = $('#shopping-cart');
    if (cartItems.length === 0){
        shoppingCart.removeAttr("data-count");
    } else {
        shoppingCart.attr("data-count", cartItems.length);
    }
}

function removeFromCart(indexToRemove) {
    updateCartArea(indexToRemove);
}

$(document).ready(function() {
    updateCartArea();
});

/////////////////////

let addBtn = document.getElementsByClassName("add-btn");
let minusBtn = document.getElementsByClassName("minus-btn");
let numberInput = document.getElementsByClassName("quantity-box");

for (let i = 0; i < addBtn.length; i++) {
  addBtn[i].addEventListener("click", function () {
    numberInput[i].value = parseInt(numberInput[i].value) + 1;
  });
  minusBtn[i].addEventListener("click", function () {
    if (numberInput[i].value > 1) {
      numberInput[i].value = parseInt(numberInput[i].value) - 1;
    } else {
      numberInput[i].value = 1;
    }
  });
}