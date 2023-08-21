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
    $.post('backendfiles/php/backend/login.php', {
        userid: userid,
        password: password
    }, function(data) {
        data = JSON.parse(data);
        if (data.is_valid == false) {
            $('div#login-error').text("Incorrect Credentials");
            return false;
        } else if (data.is_valid == true) {
            if (data.is_admin == 1) {
                document.location.href = "adchangetier.php";
            } else if (data.is_admin == 0) {
                document.location.href = "bitexchanger.php";
            }
        }
    });
    return false;
});