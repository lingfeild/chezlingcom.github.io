$('#contact-submit').on('click', function() {
		
	var name = $("#name").val();
	var email = $("#email").val();
	var subject = $("#subject").val();
	var message = $("#message").val();
	var email2 = $("#email2").val();
	var verification = $("#verification").val();
	
	var error = false;
	
	if(parseFloat(verification) == sum){
		$("#verification").css("border-color","green");
	}else{
		error = true;
		$("#verification").css("border-color","red");
	}
	
	var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			
	if(emailReg.test(email) == false || $.trim(email) == " ")
	{
		error = true;
		$("#email").css("border-color","red");
	}
	else{
		$("#email").css("border-color","green");
	}
	
	if($.trim(name) == "")
	{
		error = true;
		$("#name").css("border-color","red");
	}
	else{
		$("#name").css("border-color","green");
	}
	
	if($.trim(subject) == "")
	{
		error = true;
		$("#subject").css("border-color","red");
	}
	else{
		$("#subject").css("border-color","green");
	}

	if($.trim(message) == "")
	{
		error = true;
		$("#message").css("border-color","red");
	}
	else{
		$("#message").css("border-color","green");
	}	
	
	if(error == true)
	{
		return false;	
	}
	
	var key;
	
	$.post('verification.php',{name: name}, function(result){
		
		key = result;
		$.post('contact.php',{name: name, email: email, subject: subject, message: message, email2:email2, verification: verification, sum: sum, key: key}, function(response){
			
			if(response == 1){
				$('#contact-submit').prop("disabled", true);
				$('#contact-submit').val("Sent!");
			}		

			else
			{
				$('#contact-submit').prop("disabled", true);
				$('#contact-submit').val("Error!");				
			}
				
						
		});		
	});
	
	return false;
		
});