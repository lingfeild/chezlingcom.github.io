$('#contact-submit').on('click', function() {
    var name = $("#fullname").val();
    var email = $("#email2").val();
    var subject = $("#subject").val();
    var message = $("#message").val();
    var email2 = $("#email3").val();
    var verification = $("#verification2").val();
    verification = verification.toUpperCase();
    var error = false;
    if (verification == sum2) {
        $("#verification2").css("border-color", "green");
    } else {
        error = true;
        $("#verification2").css("border-color", "red");
    }
    var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (emailReg.test(email) == false || $.trim(email) == " ") {
        error = true;
        $("#email2").css("border-color", "red");
    } else {
        $("#email2").css("border-color", "green");
    }
    if ($.trim(name) == "") {
        error = true;
        $("#fullname").css("border-color", "red");
    } else {
        $("#fullname").css("border-color", "green");
    }
    if ($.trim(subject) == "") {
        error = true;
        $("#subject").css("border-color", "red");
    } else {
        $("#subject").css("border-color", "green");
    }
    if ($.trim(message) == "") {
        error = true;
        $("#message").css("border-color", "red");
    } else {
        $("#message").css("border-color", "green");
    }
    if (error == true) {
        return false;
    }
    var key;
    $.post('backendfiles/php/verification.php', {
        name: name,
        duration: 5
    }, function(result) {
        key = result;
        var formdata = $("#contact-form").serialize();
        formdata = formdata + "&key=" + key + "&sum=" + sum2;
        $.post('backendfiles/php/user/contact.php', formdata, function(response) {
            if (response.trim() == "sent") {
                $('#contact-submit').val("Sent!");
                $('#contact-submit').html("Sent!");
                $('#contact-submit').prop("disabled", true);
            } else {
                $('#contact-submit').val("Error!");
                $('#contact-submit').html("Error!");
                $('#contact-submit').prop("disabled", true);
            }
        });
    });
    return false;
});
$(document).ready(function() {
    var name = "";
    var key;
    var $input = $(this).find("input[name=key]");
    $.post('backendfiles/php/verification.php', {
        name: name,
        duration: 300
    }, function(result) {
        key = result;
        $input.val(key);
    });
});