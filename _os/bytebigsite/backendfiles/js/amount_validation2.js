$(document).on('keyup', '#purchase_amount_before_fees', function() {
    var amount = document.getElementById("purchase_amount_before_fees").value;
    document.getElementById("payout_amount").value = (amount / PURCHASE_EXCHANGE_RATE).toFixed(8);
    document.getElementById("purchase_amount").value = (amount * margin).toFixed(2);
    document.getElementById("purchase_amount2").innerHTML = "Subtotal: <span id='number'>$" + (amount * 1).toFixed(2) + "</span><br/> Fees: <span id='number'>$" + (amount * (margin - 1)).toFixed(2) + "</span><br/> Total: <span id='number'>$" + (amount * margin).toFixed(2) + "</span>";
    document.getElementById("bname").innerHTML = "<i>Your $" + (amount * 1).toFixed(2) + " purchase will be sent directly to your " + bname + " account!";
    $('#payout_instrument_number').trigger("keyup");
});
$(document).on('keyup', '#purchase_amount', function() {
    var amount = document.getElementById("purchase_amount").value;
    document.getElementById("payout_amount").value = ((amount / margin) / PURCHASE_EXCHANGE_RATE).toFixed(8);
    document.getElementById("purchase_amount_before_fees").value = (amount / margin).toFixed(2);
    document.getElementById("purchase_amount2").innerHTML = "Subtotal: <span id='number'>$" + (amount / margin).toFixed(2) + "</span><br/> Fees: <span id='number'>$" + (amount - (amount / margin)).toFixed(2) + "</span><br/> Total: <span id='number'>$" + (amount * 1).toFixed(2) + "</span>";
    document.getElementById("bname").innerHTML = "<i>Your $" + (amount / margin).toFixed(2) + " purchase will be sent directly to your " + bname + " account!";
    $('#payout_instrument_number').trigger("keyup");
});
$(document).on('keyup', '#payout_instrument_number', function() {
    var amount = document.getElementById("purchase_amount").value;
    var error = 0;
    if (amount == "") {
        $('div#purchase_amount-error').text("Caution: Amount Required!");
        error++;
    } else {
        $('div#purchase_amount-error').text("");
    }
    if (error != 0) {
        $('input[type="submit"]').prop('disabled', true);
    } else {
        $('input[type="submit"]').prop('disabled', false);
    }
});
$(document).on('change', '#purchase_amount, #payout_amount, #purchase_amount_before_fees', function() {
    var amount = document.getElementById("payout_amount").value;
    document.getElementById("payout_amount").value = (amount / 1).toFixed(8);
    var amount = document.getElementById("purchase_amount").value;
    document.getElementById("purchase_amount").value = (amount / 1).toFixed(2);
    var amount = document.getElementById("purchase_amount_before_fees").value;
    document.getElementById("purchase_amount_before_fees").value = (amount / 1).toFixed(2);
});