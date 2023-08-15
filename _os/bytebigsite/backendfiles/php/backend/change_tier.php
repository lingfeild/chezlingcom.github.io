<?php
session_start();

include_once __DIR__ . "/../include.php";

$nat_user_handler = new NatUserHandler();

$userid   = $_POST['userid'];
$new_tier = $_POST['new_tier'];

$nat_user_handler->change_tier($userid, $new_tier);

$user_email = $nat_user_handler->get_user_email($userid);

$date = date("Y-m-d");

ob_start();
include __DIR__."/../../../templates/change_tier_email.php";
// The template files hold HTML templates, with PHP variables (ex: $userid, $new_tier)
// This pulls the file in and cleaning the Object Buffer treats it like a string.

// Ex: templates/change_tier_email.php
/*
<hr style="background-color:#306727; height: 2px; margin: 20px 0px 50px;"><div style="font-weight:300; margin-top: 10px; margin-bottom:0px; font-size:18px; text-decoration:underline">Tier Change at <?=SITE_NAME?><br/><br/></div><div style="font-weight:200; margin-bottom:10px; font-size:14px;"> <?=$userid?>, your tier change has been accepted at <?=SITE_NAME?>! As of <?=$date?> your new tier is now set to <?=$new_tier?>! <br/><br/> Sincerely, <br/> <?=SITE_NAME?></div>
 */
//
$email_text = ob_get_clean();

$subject = "Change of Tier at " . SITE_NAME;

send_email($user_email, $subject, $email_text);

echo (true);
exit;
