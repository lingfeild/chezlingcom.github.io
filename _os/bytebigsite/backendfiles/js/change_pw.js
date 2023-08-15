$('form.ajax6').on('submit', function() {
    var current_pw = $('input#current_pw').val();
    var new_pw = $('input#new_pw').val();
    var new_pw2 = $('input#new_pw2').val();
    if ($.trim(new_pw) == "" || $.trim(new_pw2) == "" || $.trim(current_pw) == "") {
        $('div#change_pw-error').text("Please Complete the Information");
        return false;
    } else if ($.trim(new_pw) != $.trim(new_pw2)) {
        $('div#change_pw-error').text("New Passwords Do Not Match!");
        return false;
    }
    $.post('backendfiles/php/user/change_pw.php', {
        current_pw: current_pw,
        new_pw: new_pw
    }, function(response) {
        if (response == false) {
            $('div#change_pw-error').text("Incorrect Current Password!");
            return false;
        }
        if (response == true) {
            window.alert("Your password has been successfully changed!");
            document.location.href = "index.html";
        }
    });
    return false;
});