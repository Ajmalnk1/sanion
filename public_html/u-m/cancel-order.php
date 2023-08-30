<?php
include '../ipdo/session.php';
include '../ipdo/config.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
include '../ipdo/class.lpdo.php';
require '../class/class.coupon.php';
$db = new ipdo($config['Database']);
$table_orders = 'orders';
$table_product_orders = "product_orders";
$table_cancel_order_hsp = 'cancel_order_hsp';
$table_referrals = 'referrals';

$result = isLoggedIn();

if($result) {
    if(isset($_GET["order_id"]) && ($_GET["order_id"]) != ' ' && ($_GET["order_id"]) != '') {
        $order_id = $_GET["order_id"];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // verify all details are there
            if(isset($_POST["name"]) && isset($_POST["account_number"]) && isset($_POST["ifsc_code"]) && isset($_POST["bank_name"]) && isset($_POST["otp"])) {
                // check the otp generated for the order from HSP table
                $otp = $_POST["otp"];
                if($otp == $_SESSION["HSP_CODE"]) {
                    // make the order status as inactive
                        $r2 = $db->save($table_orders, array('order_status' => 'Order Cancelled'), array('id' => $order_id));
                    // make the referral code status for that order id as inactive
                        $r3 = $db->save($table_referrals, array('status' => 'Order Cancelled'), array('order_id' => $order_id));
                    // send sms
                        $msg = "Order Cancelled: Order ID ".$order_id." , -SANION";
                        $url = "http://speedsms.123coimbatore.com/api.php?username=sanion&password=372838&to=".$_SESSION["mobile"]."&from=SANION&message=".urlencode($msg);
                        $ret = file($url);
                    // send mail to the admin team
                        $o_c_msg = "Order Cancellation Details: <br><br> Order ID: $order_id, <br>Name: ".$_POST["name"].",<br>Account Number: ".$_POST["account_number"].",<br>IFSC Code: ".$_POST["ifsc_code"].",<br>Bank Name: ".$_POST["bank_name"]."";
                        require '../class/class.phpmailer.php';
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
                        $mail->AddAddress($from_name);
                        $mail->addBCC($bcc_email_to);
                        $mail->addBCC($bcc_email_to2);
                        $mail->WordWrap = 50;
                        $mail->IsHTML(true);
                        $mail->Subject = "Order Cancelled";
                        $message_body = $o_c_msg;
                        $mail->Body = $message_body;
                        $mail->Send();
                    // Make session order cancelled
                    $_SESSION["order_cancel_status"] = "Done";
                    $success = 0;
                } else {
                    $error = 1;
                }
            } else {
                $error = 0;
            }
        }
        
        if(!isset($_SESSION["HSP_SENT"]) && $_SESSION["HSP_SENT"] != "YES") {
            // generate HSP for that order cancellation
            $option = array("length" => "10", "numbers" => "true", "mixed_case" => "true");
            $generated_hsp = coupon::generate($option);
                // store hsp in cancel_order_hsp
                $_update_condition = array('order_id' => $order_id);
                $data = array('order_id' => $order_id, 'hsp' => $generated_hsp);
                $r = $db->save($table_cancel_order_hsp, $data, $_update_condition);
                if($r > 0) {
                    $_SESSION["HSP_CODE"] = $generated_hsp;
                    // send HSP to regitered mobile number
                    $msg = "HSP: ".$generated_hsp." , -SANION";
                    $url = "http://speedsms.123coimbatore.com/api.php?username=sanion&password=372838&to=".$_SESSION["mobile"]."&from=SANION&message=".urlencode($msg);
                    $ret = file($url);
                }
            $_SESSION["HSP_SENT"] = "YES";
        }
    }
} else {
    header("Location: login.php");
}
?>
<!doctype html>
<html class="no-js h-100" lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cancel - Orders</title>
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
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 80px;" src="https://www.sanionindia.com/media/logo.png" alt="Shards Dashboard">
                  <span class="d-none d-md-inline ml-1"></span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <div class="nav-wrapper">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="index.php">
                  <i data-vi="bag" data-vi-size="20"></i>
                  <span>Orders</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="change-password.php">
                  <i data-vi="lock" data-vi-size="20"></i>
                  <span>Change Password</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="profile.php">
                  <i data-vi="user" data-vi-size="20"></i>
                  <span>Profile</span>
                </a>
              </li>
            </ul>
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <div class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
              </div>

              <ul class="navbar-nav border-left flex-row ">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!--<img class="user-avatar rounded-circle mr-2" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIlhSi6ThmxOKDymY1VV1y0yjebUPehjJsCsy306lsHmaB0qj4" alt="User Avatar">-->
                    <i data-vi="user" data-vi-size="45"></i>
                    <span class="d-none d-md-inline-block">Welcome: <?php echo $_SESSION["f_name"]; ?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item text-danger" href="login.php?logout">
                      <i data-vi="export" data-vi-size="20"></i> Logout </a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 col-md-7 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Cancel</span>
                <h3 class="page-title">Order</h3>
                <?php if(!isset($_SESSION["order_cancel_status"]) && $_SESSION["order_cancel_status"] != "Done") { ?>
                <p class="mt-2 mb-0">All the details are required to cancel your order, once you filled this form, our executive will call you and process the refunds if applicable.</p>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col">
                <div class="card card-small h-100">
                  <div class="card-body d-flex flex-column">
                    <form method="POST" action="cancel-order.php?order_id=<?php echo $_GET["order_id"]; ?>">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="name">Name:</label>
                                <input type="text" placeholder="Enter your name" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="acc_no">Account Number:</label>
                                <input type="text" placeholder="Enter your account number" class="form-control" id="acc_no" name="account_number" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ifsc">IFSC Code:</label>
                                <input type="text" placeholder="Enter your IFSC code" class="form-control" id="ifsc" name="ifsc_code" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="b_name">Bank Name:</label>
                                <input type="text" placeholder="Enter your bank name" class="form-control" id="b_name" name="bank_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="hsp">Enter High Security Password (we have sent to the registered mobile number):</label>
                                <input type="password" placeholder="Enter your HS password" class="form-control" id="hsp" name="otp" required>
                            </div>
                        </div>
                        <button type="submit" class="btn cs-btn btn-primary">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Default Light Table -->
            <?php; } else { echo "<p class='mt-2 mb-0'>Your Order has been cancelled</p></div></div>"; } ?>
          </div>
          <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            <span class="copyright ml-auto my-auto mr-2">Copyright &copy; 2018
              <a href="https://thetwostones.com" rel="nofollow">Two Stones</a>
            </span>
          </footer>
        </main>
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
        if(isset($error) && $error == 0) {
            echo "swal('Oops!', 'All fields are mandatory.', 'error');";
        }
        if(isset($error) && $error == 1) {
            echo "swal('Oops!', 'Entered HSP is In-Valid', 'error');";
        }
        if(isset($success) && $success == 0) {
            echo "swal('Done!', 'Order Cancelled', 'success');";
        }
    ?>
    </script>
  </body>
</html>