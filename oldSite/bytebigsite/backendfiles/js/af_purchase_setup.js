$(document).ready(function() {
    $.post('backendfiles/php/user/af_purchase_setup.php', {
        p: getUrlParameter('p')
    }, function(data) {
        if (data == false) {
            document.location.href = "index.html";
            return;
        }
        var player_data = JSON.parse(data);
        fname = player_data['fname'];
        lname = player_data['lname'];        
        playerid = player_data['playerid'];
        userid = player_data['userid'];
        margin = player_data['margin'];
        order_id = player_data['order_id'];
        reference_id = player_data['reference_id'];
        key = player_data['key'];
        bname = player_data['bname'];
        
        PURCHASE_EXCHANGE_RATE = player_data['btc_rate'];
        PURCHASE_EXCHANGE_CURRENCY = player_data['btc_rate_currency'];
        PAYOUT_CURRENCY = player_data['payout_currency_code'];
        document.getElementById('exchangetop').innerHTML = "1 " + PAYOUT_CURRENCY + " = $" + (PURCHASE_EXCHANGE_RATE * 1).toFixed(2) + " " + PURCHASE_EXCHANGE_CURRENCY;

        tier = player_data['tier'];
        tlimit = player_data['transaction_limit'];
        dlimit = player_data['remaining_daily_limit'];
        mlimit = player_data['remaining_monthly_limit'];
        monthend = player_data['min_date'];

        document.getElementById("tier-display").innerHTML = tier;
        document.getElementById("daily-display").innerHTML = dlimit;
        document.getElementById("monthly-display").innerHTML = mlimit;
        document.getElementById("monthend-display").innerHTML = monthend;

        $.getScript("js/af_form.js", function() {
        });
        $.getScript("backendfiles/js/exchange2.js", function() {
        });
        $.getScript("backendfiles/js/amount_validation2.js", function() {
        });
    });
});

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};