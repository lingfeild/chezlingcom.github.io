<?php
function send_email($email, $subject, $email_text)
{
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:' . SITE_EMAIL;

    $pic = SITE_URL . "/assets/img/logo.png";

    ob_start();
    include __DIR__."/../../../templates/email_header.php";
    // The template files hold HTML templates, with PHP variables (ex: $userid, $new_tier)
    // This pulls the file in and cleaning the Object Buffer treats it like a string.
    // See backend/change_tier.php for example
    $header = ob_get_clean();

    ob_start();
    include __DIR__."/../../../templates/email_footer.php";
    $footer = ob_get_clean();

    $compiled_email = $header . $email_text . $footer;

    $sendmessage = "<div>" . $compiled_email . "</div>";
    $sendmessage = wordwrap($sendmessage);

    mail($email, $subject, $sendmessage, $headers);
}

function send_email_with_attachments($subject, $message, $tier_choice, $is_new_user, $files)
{
    require_once __DIR__."/../../assets/PHPMailer-master/class.phpmailer.php";

    $email           = new PHPMailer();
    $email->From     = SITE_EMAIL;
    $email->FromName = SITE_NAME;
    $email->Subject  = $subject;
    $email->Body     = $message;
    $email->AddAddress(SITE_EMAIL);

    if ($is_new_user) {
        if ($tier_choice == 1) {
            $email->AddAttachment($files['uploaded_file1']['tmp_name'], $files['uploaded_file1']['name']);
        } elseif ($tier_choice == 2) {
            $email->AddAttachment($files['uploaded_file2']['tmp_name'], $files['uploaded_file2']['name']);
            $email->AddAttachment($files['uploaded_file3']['tmp_name'], $files['uploaded_file3']['name']);
        } elseif ($tier_choice == 3) {
            $email->AddAttachment($files['uploaded_file4']['tmp_name'], $files['uploaded_file4']['name']);
            $email->AddAttachment($files['uploaded_file5']['tmp_name'], $files['uploaded_file5']['name']);
            $email->AddAttachment($files['uploaded_file6']['tmp_name'], $files['uploaded_file6']['name']);
        }
    }
    if (!$is_new_user) {
        if ($tier_choice == 2) {
            $email->AddAttachment($files['uploaded_file3']['tmp_name'], $files['uploaded_file3']['name']);
        } elseif ($tier_choice == 3) {
            $email->AddAttachment($files['uploaded_file5']['tmp_name'], $files['uploaded_file5']['name']);
            $email->AddAttachment($files['uploaded_file6']['tmp_name'], $files['uploaded_file6']['name']);
        }
    }
    $sent = $email->Send();
}
