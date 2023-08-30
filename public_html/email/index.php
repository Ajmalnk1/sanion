<?php
$message = '';
require 'class/class.phpmailer.php';
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->Host = $host;
$mail->Port = '465';
$mail->SMTPAuth = true;
$mail->Username = $mail_username;
$mail->Password = $mail_password;
$mail->SMTPSecure = 'ssl';
$mail->From = $from;
$mail->FromName = $from_name;
$mail->AddAddress('manobala.s@hotmail.com');
$mail->addBCC($bcc_email_to);
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject = "Order successfully placed";
$message_body = "
";
$mail->Body = $message_body;
$mail->Send();
?>