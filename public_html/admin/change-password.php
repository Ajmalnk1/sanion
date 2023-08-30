<?php
include '../ipdo/session.php';
include '../ipdo/config.php';
include '../ipdo/class.lpdo.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
$db = new ipdo($config['Database']);
$table_users = 'users';

// change password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION["email"];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    // fetch user details
    $condition = array('email' => $email, 'password' => $old_password);
    $rs = $db->get_rows('admin_users', $condition);
    if(count($rs) > 0) {
        
        $data = array('password' => $new_password);
        $r = $db->save('admin_users', $data, array('email' => $email));
        if($r > 0) {
            $success = "0";
        } else {
            $error = "2";
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <a class="navbar-brand" href="#">
    <img src="http://www.thetwostones.com/wp-content/uploads/2017/05/twostones.svg" alt="Logo" style="width:120px;">
  </a>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">Sanion | Administrative Index</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add_affiliate.php">Add / View Affiliate</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="view_affiliate_sales.php">View Affiliate Sales</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="change-password.php">Change Password</a>
    </li>
    <li class="nav-item mt-2 ml-3">
      <a class="nav-link badge badge-danger text-white" href="login.php?logout">Log  Out</a>
    </li>
  </ul>
</nav>
<br>
<div class="container">
  <h3>Change Password</h3>
  <p>Here you can change the administrator password.</p>            
      <form class="row" method="post" action="change-password.php">
  <div class="col-md-4 form-group">
    <label for="old_password">Old Password<span class="text-danger">*</span>:</label>
    <input type="password" class="form-control" id="old_password" name="old_password">
  </div>
  <div class="col-md-3 form-group">
    <label for="new_password">New Password<span class="text-danger">*</span>:</label>
    <input type="password" class="form-control" id="new_password" name="new_password">
  </div>
  <div class="col-md-4 form-group form-check">
    <button type="submit" style="margin-top: 1.9rem!important" class="btn btn-primary">Change</button>
  </div>
</form>
</div>

    <script>
    <?php
        
        if(isset($success) && $success == "0") {
            echo "swal('Done!', 'New Password updated successfully.', 'success');";
        }
        if(isset($error) && $error == "0") {
            echo "swal('Oops!', 'Email ID or Password is Not Correct', 'error');";
        }
        if(isset($error) && $error == "1") {
            echo "swal('Oops!', 'Old password is not matched', 'error');";
        }
        if(isset($error) && $error == "2") {
            echo "swal('Oops!', 'Error in updating the new password', 'error');";
        }
    ?>
</script>

</body>
</html>
