$(document).on('change', '#tier_choice', function() {
    tierz = $("#tier_choice:checked").val();
    if (tierz == 2) {
        $("#file3").prop('required', true);
        $("#file5").prop('required', false);
        $("#file6").prop('required', false);
        document.getElementById("tier2b").style.borderColor = "#bdc3c7";
        document.getElementById("tier1b").style.borderColor = "#bdc3c7";
        document.getElementById("tier3b").style.borderColor = "#bdc3c7";
    } else if (tierz == 3) {
        $("#file3").prop('required', false);
        if (tier == 1) {
            $("#file5").prop('required', true);
        } else {
            $("#file5").prop('required', false);
        }
        $("#file6").prop('required', true);
        document.getElementById("tier3b").style.borderColor = "#bdc3c7";
        document.getElementById("tier2b").style.borderColor = "#bdc3c7";
        document.getElementById("tier1b").style.borderColor = "#bdc3c7";
    }
});
$(document).on('keyup', '#payout_amount', function() {
    margin = 1.3;
    if (is_vip == true) {
        margin = 1.1;
    }
    var amount = document.getElementById("payout_amount").value;
    document.getElementById("purchase_amount").value = (amount * PURCHASE_EXCHANGE_RATE * margin).toFixed(2);
    var amount = document.getElementById("purchase_amount").value;
    document.getElementById("purchase_amount2").innerHTML = "Subtotal: <span id='number'>$" + (amount / margin).toFixed(2) + "</span><br/> Fees: <span id='number'>$" + ((amount / margin) * (margin - 1)).toFixed(2) + "</span><br/> Total: <span id='number'>$" + (amount * 1).toFixed(2) + "</span>";
    $('#payout_instrument_number').trigger("keyup");
});
$(document).on('keyup', '#purchase_amount', function() {
    margin = 1.3;
    if (is_vip == true) {
        margin = 1.1;
    }
    var amount = document.getElementById("purchase_amount").value;
    document.getElementById("payout_amount").value = (amount / (PURCHASE_EXCHANGE_RATE * margin)).toFixed(6);
    document.getElementById("purchase_amount2").innerHTML = "Subtotal: <span id='number'>$" + (amount / margin).toFixed(2) + "</span><br/> Fees: <span id='number'>$" + ((amount / margin) * (margin - 1)).toFixed(2) + "</span><br/> Total: <span id='number'>$" + (amount * 1).toFixed(2) + "</span>";
    $('#payout_instrument_number').trigger("keyup");
});
$(document).on('keyup', '#payout_instrument_number', function() {
    var amount = document.getElementById("purchase_amount").value;
    var wallet = document.getElementById("payout_instrument_number").value;
    var error = 0;
    if (wallet.length < 34 || wallet.length > 34) {
        $('div#bitcoinwallet-error').text("Caution: Bitcoin Wallet must be 34 characters");
        error++;
    } else {
        var email = 0;
        $.post('backendfiles/php/user/checkwallet.php', {
            wallet: wallet
        }, function(data) {
            if (data == 'OK') {
                $('div#bitcoinwallet-error').text("");
            } else {
                $('div#bitcoinwallet-error').text("Invalid Bitcoin Address");
                $('input[type="submit"]').prop('disabled', true);
            }
        });
    }
    if (amount == "") {
        $('div#amount-error').text("Caution: Amount Required!");
        error++;
    } else if (parseFloat(amount) > parseFloat(dlimit) || parseFloat(amount) > parseFloat(mlimit)) {
        $('div#amount-error').text("Caution: Exceding Purchasing Limit!");
        error++;
    } else {
        $('div#amount-error').text("");
    }
    if (error != 0) {
        $('input[type="submit"]').prop('disabled', true);
    } else {
        $('input[type="submit"]').prop('disabled', false);
    }
});
$(document).on('change', '#payout_amount, #purchase_amount', function() {
    var amount = document.getElementById("payout_amount").value;
    document.getElementById("payout_amount").value = (amount / 1).toFixed(8);
    var amount = document.getElementById("purchase_amount").value;
    document.getElementById("purchase_amount").value = (amount / 1).toFixed(2);
});