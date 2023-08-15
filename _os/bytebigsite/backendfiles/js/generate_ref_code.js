$('form.ajax').on('submit', function() {
    var email = $('input#email').val();
    var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (emailReg.test(email) == false || $.trim(email) == " ") {
        error = true;
        $("#email").css("border-color", "red");
        return false;
    } else {
        $("#email").css("border-color", "green");
    }
    $.post('backendfiles/php/backend/generate_ref_code.php', {
        email: email
    }, function(response) {
        if (response != "ERROR") {
            $('input#code').val(response);
            return true;
        }
    });
    return false;
});