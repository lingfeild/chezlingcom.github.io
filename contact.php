<?php
    //we need to get our variables first
    
	$name = $_POST['name']; 
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$email2 = $_POST['email2'];
	$verification = $_POST['verification'];
	$sum = $_POST['sum'];

	$name2 = trim($name); 

	$key = $_POST['key'];
	$secretkey = 'feifeigo';  
	$duration = 5;
	
	$i = ceil( time() / ($duration) );
	$keya = md5( $i . $name2. $secretkey ); 
	
	$key2 = substr($keya, -12, 10);
	
	$ip=0;
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}	
	
	if(trim($name) == "" || trim($email) == "" || trim($subject) == "" || trim($message) == "" || trim($email2) != "" || trim($verification) == "" || $verification != $sum || !filter_var($email, FILTER_VALIDATE_EMAIL) || $key != $key2){
		echo 1;
		exit();
	}
			
	$formcontent="From: $name \n Email: $email \n Subject: $subject \n Message: $message \n IP: $ip";
	
  $recipient = "lingfeild@hotmail.com";
	$subject = $subject;
	$mailheader = "From: $recipient \r\n";
    
    if (mail($recipient, $subject, $formcontent, $mailheader)){
        echo 1; // we are sending this text to the ajax request telling it that the mail is sent..      
    }else{
        echo 2;// ... or this one to tell it that it wasn't sent    
    }
?>