$('#btc_numberz').on('keypress', function(e) {
    return e.metaKey || // cmd/ctrl
        e.which <= 0 || // arrow keys
        e.which == 8 || // delete key
        /[0-9,.]/.test(String.fromCharCode(e.which)); // numbers
});
$('#currency_number').on('keypress', function(e) {
    return e.metaKey || // cmd/ctrl
        e.which <= 0 || // arrow keys
        e.which == 8 || // delete key
        /[0-9,.]/.test(String.fromCharCode(e.which)); // numbers
});
$('#currency_number').on('keyup', function(e) {
    if (document.getElementById('currencyz').value == 1) {
        var curr = document.getElementById('currency_number').value;
        document.getElementById('btc_numberz').value = (curr / PURCHASE_EXCHANGE_RATE).toFixed(6);
    }
});
$('#currencyz').on('change', function(e) {
    if (document.getElementById('currencyz').value == 1) {
        var curr = document.getElementById('btc_numberz').value;
        document.getElementById('currency_number').value = (curr * PURCHASE_EXCHANGE_RATE).toFixed(2);
    }
});
$('#btc_numberz').on('keyup', function(e) {
    if (document.getElementById('currencyz').value == 1) {
        var curr = document.getElementById('btc_numberz').value;
        document.getElementById('currency_number').value = (curr * PURCHASE_EXCHANGE_RATE).toFixed(2);
    }
});