<?php
	
	$secretkey = '123Rakselav321';
	$duration = 30;
   
   	$posted = trim($_POST['name']);
	
   	$i = ceil(time() / ($duration) );
	$keya = md5($i . $posted. $secretkey );
	
	$key = substr($keya, -12, 10);
	
	echo($key); 
?>