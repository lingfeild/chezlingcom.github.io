$('#contact-submit').on('click', function () {

  var name = $("#name").val();
  var email = $("#email").val();
  var subject = $("#subject").val();
  var message = $("#message").val();
  var email2 = $("#email2").val();
  var verification = $("#verification").val();

  var error = false;

  if (verification == sum) {
    $("#verification").css("background", "#bfffbf");
  } else {
    error = true;
    $("#verification").css("background", "#fcc");
  }

  var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

  if (emailReg.test(email) == false || $.trim(email) == " ") {
    error = true;
    $("#email").css("background", "#fcc");
    // #fcc - red
  }
  else {
    $("#email").css("background", "#bfffbf");
    // #bfffbf - green
  }

  if ($.trim(name) == "") {
    error = true;
    $("#name").css("background", "#fcc");
  }
  else {
    $("#name").css("background", "#bfffbf");
  }

  if ($.trim(subject) == "") {
    error = true;
    $("#subject").css("background", "#fcc");
  }
  else {
    $("#subject").css("background", "#bfffbf");
  }

  if ($.trim(message) == "") {
    error = true;
    $("#message").css("background", "#fcc");
  }
  else {
    $("#message").css("background", "#bfffbf");
  }

  if (error == true) {
    return false;
  }

  var key;

  $.post('verification.php', { name: name }, function (result) {

    key = result;
    $.post('contact.php', { name: name, email: email, subject: subject, message: message, email2: email2, verification: verification, sum: sum, key: key }, function (response) {

      if (response == 1) {
        // $('#contact-submit').prop("disabled", true);
        $('#contact-submit').html("Sent!");
      }

      else {
        // $('#contact-submit').prop("disabled", true);
        $('#contact-submit').html("Error!");
      }

    });
  });

  return false;

});