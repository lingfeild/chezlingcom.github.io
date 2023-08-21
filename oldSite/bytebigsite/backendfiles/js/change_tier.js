$(document).ready(function() {
    $('#change_tier-button').prop('disabled', true);
    $('#vuser-button').prop('disabled', true);
});
$('#userid').on('change', function() {
    var userid = $('input#userid').val();
    $.post('backendfiles/php/backend/useridcheck.php', {
        userid: userid
    }, function(response) {
        if (response == 1 || response == 2 || response == 3) {
            $("#current_tier").prop("readonly", false);
            $("#current_tier").val(response);
            $("#current_tier").prop("readonly", true);
            $('#change_tier-button').prop('disabled', false);
            $("#change_tier-error").text("");
        } else {
            $("#change_tier-error").text("Invalid User ID");
            $("#current_tier").prop("readonly", false);
            $("#current_tier").val("");
            $("#current_tier").prop("readonly", true);
            $('#change_tier-button').prop('disabled', true);
        }
    });
    return false;
});
$('#userid2').on('change', function() {
    var userid = $('input#userid2').val();
    $.post('backendfiles/php/backend/useridcheck.php', {
        userid: userid
    }, function(response) {
        if (response == 1 || response == 2 || response == 3) {
            $('#vuser-button').prop('disabled', false);
            $("#vuser-error").text("");
        } else {
            $("#vuser-error").text("Invalid User ID");
            $('#vuser-button').prop('disabled', true);
        }
    });
    return false;
});
$('form.ajax3').on('submit', function() {
    var userid = $('input#userid').val();
    var new_tier = $('input#new_tier').val();
    if ($.trim(new_tier) == "") {
        $('div#change_tier-error').text("Please input a New Tier");
        return false;
    }
    $.post('backendfiles/php/backend/change_tier.php', {
        userid: userid,
        new_tier: new_tier
    }, function(response) {
        if (response == false) {
            $('div#change_tier-error').text("ERROR!");
            return false;
        }
        if (response == true) {
            window.alert('The tier has been changed.');
            document.location.href = "adchangetier.php";
        }
    });
    return false;
});
$('form.ajax6').on('submit', function() {
    var userid = $('input#userid2').val();
    $.post('backendfiles/php/backend/verify_user.php', {
        userid: userid
    }, function(response) {
        if (response == false) {
            $('div#vuser-error').text("ERROR!");
            return false;
        }
        if (response == true) {
            window.alert('The username has now been verified, an email has been sent to the user.');
            document.location.href = "adchangetier.php";
        }
    });
    return false;
});
$('form.ajax11').on('submit', function() {
    var userid = $('input#userid3').val();
    var reason = $('textarea#reason').val();
    $.post('backendfiles/php/backend/deny_user.php', {
        userid: userid,
        reason: reason
    }, function(response) {
        if (response == false) {
            $('div#duser-error').text("ERROR!");
            return false;
        }
        if (response == true) {
            window.alert('The username has now been denied, an email has been sent to the user.');
            document.location.href = "adchangetier.php";
        }
    });
    return false;
});
$('#userid3').on('change', function() {
    var userid = $('input#userid3').val();
    $.post('backendfiles/php/backend/useridcheck.php', {
        userid: userid
    }, function(response) {
        if (response == 1 || response == 2 || response == 3) {
            $('#duser-button').prop('disabled', false);
            $("#duser-error").text("");
        } else {
            $("#duser-error").text("Invalid User ID");
            $('#duser-button').prop('disabled', true);
        }
    });
    return false;
});