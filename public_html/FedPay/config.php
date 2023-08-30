<?php
$servername = "localhost";
$username = "manobala_se";
$password = '!nv6Bl)2V+!j';
$dbname = "manobala_se";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>