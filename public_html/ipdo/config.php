<?php
//error_reporting(0);
$config = array();
$config['Database'] = array();
$config['Database']['dbtype'] = 'mysql';
$config['Database']['dbname'] = 'u860301413_sanionindia_db';
$config['Database']['host'] = 'localhost';
$config['Database']['port'] = 3306;
$config['Database']['username'] = 'u860301413_sanionindia_us';
$config['Database']['password'] = 'yI3_~vC-)@}';
$config['Database']['charset'] = 'utf8';
$config['url']['root'] = 'http://www.sanionindia.com/';
$config['sms']['username'] = 'sanion';
$config['sms']['password'] = '372838';
$config['sms']['sender_id'] = 'SANION';

// email config
$host = 'mail.sanionindia.com';
$mail_username = 'support@sanionindia.com';
$mail_password = '_xo=V2J%mgB{';
$from = 'support@sanionindia.com';
$from_name = 'Sanion';
$bcc_email_to = 'log@sanionindia.com';
$s_template = "";


// check user logged in 
function isLoggedIn()
{
	if(isset($_SESSION["user_id"])) {
	    return true;
	} else {
	    return false;
	}
}
?>
