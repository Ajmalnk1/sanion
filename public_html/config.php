<?php
error_reporting(0); 
// // Dev
// $servername = "localhost";
// $username = "root";
// $password = '';
// $dbname = "sanion";

// Prod
$servername = "localhost";
$username = "u860301413_sanionindia_us";
$password = '7uTmBKRIP]';
$dbname = "u860301413_sanionindia_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    //die("Connection failed: " . mysqli_connect_error());
}

// email config
$host = 'mail.sanionindia.com';
$mail_username = 'support@sanionindia.com';
$mail_password = '_xo=V2J%mgB{';
$from = 'support@sanionindia.com';
$from_name = 'Sanion';
$bcc_email_to = 'log@sanionindia.com';
$bcc_email_to2 = 'notification@sanionindia.com';
$s_template = "";

// Admin
$admin_base_url = "http://www.sanionindia.com/admin/";