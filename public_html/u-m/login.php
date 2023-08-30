<?php
include '../ipdo/session.php';
include '../ipdo/config.php';
include '../ipdo/class.lpdo.php';
$db = new ipdo($config['Database']);
$table_users = 'users';

// login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // fetch user details
        $condition = array('email' => $email);
        $rs = $db->get_rows($table_users, $condition);
        if(count($rs) > 0) {
            
            $_SESSION["user_details_log"]["user_id"] = $rs[0]["id"];
            $_SESSION["user_details_log"]["f_name"] = $rs[0]["f_name"];
            $_SESSION["user_details_log"]["l_name"] = $rs[0]["l_name"];
            $_SESSION["user_details_log"]["email"] = $rs[0]["email"];
            $_SESSION["user_details_log"]["mobile"] = $rs[0]["mobile"];
            $_SESSION["user_details_log"]["dob"] = $rs[0]["dob"];
            
            $_SESSION["address_details_log"]["shipping_add1"] = $rs[0]["shipping_add1"];
            $_SESSION["address_details_log"]["shipping_add2"] = $rs[0]["shipping_add2"];
            $_SESSION["address_details_log"]["shipping_city"] = $rs[0]["shipping_city"];
            $_SESSION["address_details_log"]["shipping_state"] = $rs[0]["shipping_state"];
            $_SESSION["address_details_log"]["shipping_pin_code"] = $rs[0]["shipping_pin_code"];
            
            $f_name = $rs[0]["f_name"];
            $mobile = $rs[0]["mobile"];
            $temp_id = $rs[0]["id"];
            $temp_password = $rs[0]["password"];
            if (password_verify($pwd, $temp_password)) {
                $_SESSION["f_name"] = $f_name;
                $_SESSION["user_id"] = $temp_id;
                $_SESSION["email"] = $email;
                $_SESSION["mobile"] = $mobile;
                header('Location: index.php');
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

// logout
if(isset($_GET["logout"])) {
    session_unset();
    session_destroy();
}
?>
<!doctype html>
<html class="no-js h-100" lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://unpkg.com/vivid-icons" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body class="h-100">
      
      
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
                <h4 class="card-title text-center">Login</h4>
                <h6 class="card-subtitle mb-2 text-muted text-center">&emsp;Log in to gain access to your account.&emsp;</h6>
                <span class="card-text">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email ID:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd" name="password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn cs-btn btn-primary">Submit</button>
                            <p class="mt-2">Forgot password ? <a href="forgot-password.php">Click Here</a></p>
                        </div>
                    </form>
                </span>
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
        if(isset($_GET["password_reset_done"])) {
            echo "swal('Done!', 'New Password is sent to the registered mobile number', 'success');";
        }
        if(isset($_GET["logout"])) {
            echo "swal('Done!', 'Logged Out Successfully.', 'success');";
        }
        if(isset($error) && $error == "0") {
            echo "swal('Oops!', 'Enter a valid email id.', 'error');";
        }
        if(isset($error) && $error == "1") {
            echo "swal('Oops!', 'Entered Email Id is not registered in our accounts', 'error');";
        }
        if(isset($error) && $error == "2") {
            echo "swal('Oops!', 'Password is In-Valid.', 'error');";
        }
    ?>
</script>
  </body>
</html>