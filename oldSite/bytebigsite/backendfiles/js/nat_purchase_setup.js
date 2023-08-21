$(document).ready(function() {
    $.post('backendfiles/php/user/nat_purchase_setup.php', {}, function(data) {
        if (data == false) {
            document.location.href = "index.html";
            return;
        }
        var player_data = JSON.parse(data);
        userid = player_data['userid'];
        firstname = player_data['firstname'];
        lastname = player_data['lastname'];
        tier = player_data['tier'];
        show_correct_tiers(tier);
        tlimit = player_data['transaction_limit'];
        dlimit = player_data['remaining_daily_limit'];
        mlimit = player_data['remaining_monthly_limit'];
        monthend = player_data['min_date'];
        is_vip = player_data['is_vip'];
        key = player_data['key'];
        order_id = player_data['order_id'];
        document.getElementById("tier-display").innerHTML = tier;
        document.getElementById("daily-display").innerHTML = dlimit;
        document.getElementById("monthly-display").innerHTML = mlimit;
        document.getElementById("monthend-display").innerHTML = monthend;
        document.getElementById("userID2").innerHTML = userid;

        $.getScript("js/nat_form.js", function() {
        });
        $.getScript("backendfiles/js/exchange.js", function() {
        });
        $.getScript("backendfiles/js/amount_validation.js", function() {
        });
    });
});

function show_correct_tiers(tier) {
    if (tier == 1) {
        document.getElementById("tier1mainbox").style.display = "none";
    }
    if (tier == 2) {
        document.getElementById("tier1mainbox").style.display = "none";
        document.getElementById("tier2mainbox").style.display = "none";
        document.getElementById("hidethis").style.display = "none";
    }
    if (tier == 3) {
        document.getElementById("tier1mainbox").style.display = "none";
        document.getElementById("tier2mainbox").style.display = "none";
        document.getElementById("tier3mainbox").style.display = "none";
    }
    $("#tier_choice").prop('required', true);
}