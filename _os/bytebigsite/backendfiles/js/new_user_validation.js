$('#email').on('change', function() {
    var email = $('#email').val();
    $.post('backendfiles/php/user/email_validation.php', {
        email: email
    }, function(data) {
        if (data == false) {
            $('div#email-error').text("Caution: Email already in use!");
            $('button#newuser').prop('disabled', true)
        } else if (data == true) {
            $('div#email-error').text("");
            if ($('div#bitaddress-error').html() == "") {
                $('button#newuser').prop('disabled', false)
            }
        }
    });
});
$('form.ajax').on('submit', function() {
    var userid = $('input#userid').val();
    var password = $('input#password').val();
    if ($.trim(userid) == "" && $.trim(password) == "") {
        $('div#login-error').text("Please input a Username and Password");
        return false;
    } else if ($.trim(userid) == "") {
        $('div#login-error').text("Please input a Username");
        return false;
    } else if ($.trim(password) == "") {
        $('div#login-error').text("Please input a Password");
        return false;
    }
    $.post('backendfiles/php/user/login.php', {
        userid: userid,
        password: password
    }, function(data) {
        if (data == false) {
            $('div#login-error').text("Incorrect Credentials");
            return false;
        } else if (data == true) {
            document.location.href = "index.php";
        }
    });
    return false;
});
$(document).ready(function() {
    $.get("https://ipinfo.io", function(response) {
        var user_country = response.country;
        if (['AU', 'BR', 'CA', 'CN', 'JP', 'MX', 'US'].indexOf(user_country) < 0) {
            user_country = 'US'
        }
        $("#country").val(user_country);
        $('#statez_AUS').hide();
        $('#statez_CAN').hide();
        $('#statez_US').hide();
        $('#statez_row').hide();

        if (user_country === 'AU') {
            $('#statez_AUS').show();
        } else if (user_country === 'CA') {
            $('#statez_CAN').show();
        } else if (user_country === 'US') {
            $('#statez_US').show();
        } else {
            $('#statez_row').show();
        }

        if (user_country === 'BR') {
            $('#ctr_BRA').show();
        } else if (user_country === 'US') {
            $('#ctr_USA').show();
        }
    }, "jsonp");
});
$('#country').on('change', function() {
    var country = $('#country').val();
    switch (country) {
        case 'AU':
            $('#statez_CAN').hide();
            $('#statez_row').hide();
            $('#statez_AUS').show();
            $('#statez_US').hide();
            break;
        case 'BR':
            $('#statez_CAN').hide();
            $('#statez_row').show();
            $('#statez_AUS').hide();
            $('#statez_US').hide();
            break;
        case 'CA':
            $('#statez_CAN').show();
            $('#statez_row').hide();
            $('#statez_AUS').hide();
            $('#statez_US').hide();
            break;
        case 'CN':
            $('#statez_CAN').hide();
            $('#statez_row').show();
            $('#statez_AUS').hide();
            $('#statez_US').hide();
            break;
        case 'JP':
            $('#statez_CAN').hide();
            $('#statez_row').show();
            $('#statez_AUS').hide();
            $('#statez_US').hide();
            break;
        case 'MX':
            $('#statez_CAN').hide();
            $('#statez_row').show();
            $('#statez_AUS').hide();
            $('#statez_US').hide();
            break;
        case 'US':
            $('#statez_CAN').hide();
            $('#statez_row').hide();
            $('#statez_AUS').hide();
            $('#statez_US').show();
            break;
        default:
            $('#statez_CAN').hide();
            $('#statez_row').hide();
            $('#statez_AUS').hide();
            $('#statez_US').show();
            break;
    }
});
$('#userid2').on('change keyup paste', function() {
    var userid = $('input#userid2').val();
    $.post('backendfiles/php/backend/useridcheck.php', {
        userid: userid
    }, function(response) {
        if (response == 1 || response == 2 || response == 3) {
            $('#fmp-button').prop('disabled', false);
            $("#fmp-error").text("");
        } else {
            $("#fmp-error").text("Invalid User ID");
            $('#fmp-button').prop('disabled', true);
        }
    });
    return false;
});
$('form.ajax9').on('submit', function() {
    var userid = $('input#userid2').val();
    $.post('backendfiles/php/user/fmp.php', {
        userid: userid
    }, function(response) {
        if (response == false) {
            $('div#vuser-error').text("ERROR!");
            return false;
        }
        if (response == true) {
            window.alert('Your Password has now been reset. A new password has been sent to the email attached to this account.');
            document.location.href = "index.html";
        }
    });
    return false;
});
$(document).ready(function() {
    $('#fmp-button').prop('disabled', true);
});