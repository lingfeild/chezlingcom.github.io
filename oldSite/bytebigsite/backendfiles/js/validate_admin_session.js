$(document).ready(function() {
    $.post('backendfiles/php/backend/validate_session.php', {}, function(data) {
        if (data == false) {
            document.location.href = "index.html";
        }
    });
});