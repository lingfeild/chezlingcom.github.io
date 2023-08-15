$(document).ready(function() {
    $.post('backendfiles/php/user/validate_session.php', {}, function(data) {
        if (data == false) {
            document.location.href = "index.html";
        }
        userid = data;
        document.getElementById("userID2").innerHTML = userid;
    });
});