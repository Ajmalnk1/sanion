<?php
include '../ipdo/config.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
include '../ipdo/class.lpdo.php';
$db = new ipdo($config['Database']);
$table_users = 'users';
echo "<pre>";

$pwd = "manobala";
$email = "test@manobala.co.in";
$mobile = "8883829940";

$password = password_hash($pwd, PASSWORD_DEFAULT);

$data = array(
    'f_name' => 'F Test User',
    'l_name' => 'L Test User',
    'email' => $email,
    'password' => $password,
    'mobile' => $mobile,
    'dob' => '2018-10-24',
    'shipping_add1' => 'A1',
    'shipping_add2' => 'A2',
    'shipping_city' => 'C',
    'shipping_state' => 'S',
    'shipping_pin_code' => '121345'
    );

// check if user is already registered
$condition = array('email' => $email);
$rs = $db->get_rows($table_users, $condition);

if(count($rs) > 0) {
    echo "User already registered";
} else {
    // Register User
    $r = $db->insert($table_users, $data);
    print_r($r);
}