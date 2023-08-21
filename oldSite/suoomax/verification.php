<?php
	
	$secretkey = '123aabbcc321'; 
	$duration = 5;
   
   	$posted = trim($_POST['name']);
	
   	$i = ceil(time() / ($duration) );
	$keya = md5($i . $posted. $secretkey );
	
	$key = substr($keya, -12, 10);
	
	echo($key);   
?>