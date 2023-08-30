<?php
include '../ipdo/session.php';
include '../ipdo/config.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
include '../ipdo/class.lpdo.php';
require '../class/class.coupon.php';
$db = new ipdo($config['Database']);
$table_users = 'users';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // fetch user details
        $condition = array('email' => $email);
        $rs = $db->get_rows($table_users, $condition);
        if(count($rs) > 0) {
            $mobile = $rs[0]["mobile"];

            // generate pwd
            $option = array("length" => "10", "numbers" => "true", "mixed_case" => "true");
            $generated_password = coupon::generate($option);
            
            // hash and store it in db
            $hash_password = password_hash($generated_password, PASSWORD_DEFAULT);
            $result = $db->save($table_users, array('password' => $hash_password), array('email' => $email));
            if($result > 0) {
                // send sms
                $msg = "Password ".$generated_password." , -SANION";
                $url = "http://speedsms.123coimbatore.com/api.php?username=sanion&password=372838&to=$mobile&from=SANION&message=".urlencode($msg);
                $ret = file($url);
                header("Location: login.php?password_reset_done");
            } else {
                $error = "2";
            }
        } else {
            $error = "1";
        }
    } else {
        $error = "0";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sanion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://unpkg.com/vivid-icons" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm justify-content-center bg-light navbar-light">
    <a class="navbar-brand" href="#">
    <img src="https://www.sanionindia.com/media/logo.png" alt="Logo" style="width:100px;">
  </a>
</nav>
<br>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="card cs-card">
            <div class="card-body">
                <h4 class="card-title text-center">OTP Confirmation</h4>
                <h6 class="card-subtitle mb-2 text-muted text-center">&emsp;Kindly fill the Email ID, we will send you the password <br>to the registered mobile number.&emsp;</h6>
                <p class="card-text">
                    <form action="forgot-password.php" method="post">
                        <div class="form-group">
                            <label for="email">Email ID:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn cs-btn btn-primary">Submit</button>
                        </div>
                    </form>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="scripts/extras.1.1.0.min.js"></script>
    <script src="scripts/shards-dashboards.1.1.0.min.js"></script>
<script>
    <?php
        if(isset($error) && $error == "0") {
            echo "swal('Oops!', 'Enter a valid email id.', 'error');";
        }
        if(isset($error) && $error == "1") {
            echo "swal('Oops!', 'Entered Email Id is not registered in our accounts', 'error');";
        }
        if(isset($error) && $error == "2") {
            echo "swal('Oops!', 'Unknown error found, retry.', 'error');";
        }
    ?>
</script>
</body>
</html>