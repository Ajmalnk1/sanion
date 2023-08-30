<?php
include '../ipdo/session.php';
include '../ipdo/config.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
include '../ipdo/class.lpdo.php';
$db = new ipdo($config['Database']);
$table_users = 'users';

$result = isLoggedIn();
if($result) {
    $condition = array('email' => $_SESSION["email"]);
    
    // change user details
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST["f_name"]) &&	!empty($_POST["l_name"]) &&	 !empty($_POST["mobile"])  &&	!empty($_POST["shipping_add1"]) &&	!empty($_POST["shipping_add2"]) &&	!empty($_POST["shipping_city"]) &&	!empty($_POST["shipping_state"]) &&	!empty($_POST["shipping_pin_code"])) {
            $data = array(
                'f_name' => $_POST["f_name"],
                'l_name' => $_POST["l_name"],
                'mobile' => $_POST["mobile"],
                'shipping_add1' => $_POST["shipping_add1"],
                'shipping_add2' => $_POST["shipping_add2"],
                'shipping_city' => $_POST["shipping_city"],
                'shipping_state' => $_POST["shipping_state"],
                'shipping_pin_code' => $_POST["shipping_pin_code"]
            );
            $r2 = $db->save($table_users, $data, $condition);
            $success = "0";
        } else {
            $error = "0";
        }
    }
    
    // view user details
    $r = $db->get_rows($table_users, $condition);
    if(count($r) > 0) {
        $user_details = array();
        $user_details["f_name"] = $r[0]["f_name"];
        $user_details["l_name"] = $r[0]["l_name"];
        $user_details["email"] = $r[0]["email"];
        $user_details["mobile"] = $r[0]["mobile"];
        $user_details["shipping_add1"] = $r[0]["shipping_add1"];
        $user_details["shipping_add2"] = $r[0]["shipping_add2"];
        $user_details["shipping_city"] = $r[0]["shipping_city"];
        $user_details["shipping_state"] = $r[0]["shipping_state"];
        $user_details["shipping_pin_code"] = $r[0]["shipping_pin_code"];
    }
    
} else {
    header("Location: login.php");
}
?>
<!doctype html>
<html class="no-js h-100" lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Profile</title>
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
                <a class="nav-link" href="index.php">
                  <i data-vi="bag" data-vi-size="20"></i>
                  <span>Orders</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="change-password.php">
                  <i data-vi="lock" data-vi-size="20"></i>
                  <span>Change Password</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="profile.php">
                  <i data-vi="user" data-vi-size="20"></i>
                  <span>Profile</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="../subscribe.php">
                  <i data-vi="cart" data-vi-size="20"></i>
                  <span>Purchase Subscription</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="../trial-pack.php">
                  <i data-vi="bag" data-vi-size="20"></i>
                  <span>Purchase Trial Pack</span>
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
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">View/Modify</span>
                <h3 class="page-title">Profile</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
                <div class="col-md-8">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Account Details</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col">
                          <form method="POST" action="profile.php">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="feFirstName">First Name</label>
                                <input type="text" class="form-control" id="feFirstName" value="<?php echo $user_details["f_name"] ?>" name="f_name"> </div>
                              <div class="form-group col-md-6">
                                <label for="feLastName">Last Name</label>
                                <input type="text" class="form-control" id="feLastName" value="<?php echo $user_details["l_name"] ?>" name="l_name"> </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="feEmailAddress">Email</label>
                                <input disabled type="email" class="form-control" id="feEmailAddress" value="<?php echo $user_details["email"] ?>" name="email"> </div>
                              <div class="form-group col-md-6">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" value="<?php echo $user_details["mobile"] ?>" name="mobile"> </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="feAddress">Address 1</label>
                                <input type="text" class="form-control" id="feAddress" value="<?php echo $user_details["shipping_add1"] ?>" name="shipping_add1"> </div>
                              <div class="form-group col-md-6">
                                <label for="feAddress2">Address 2</label>
                                <input type="text" class="form-control" id="feAddress2" value="<?php echo $user_details["shipping_add2"] ?>" name="shipping_add2"> </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-5">
                                <label for="feInputCity">City</label>
                                <input type="text" class="form-control" id="feInputCity" value="<?php echo $user_details["shipping_city"] ?>" name="shipping_city"> </div>
                              <div class="form-group col-md-4">
                                <label for="feInputState">State</label>
                                <input type="text" class="form-control" id="feInputState" value="<?php echo $user_details["shipping_state"] ?>" name="shipping_state"> </div>
                              <div class="form-group col-md-2">
                                <label for="inputZip">Zip</label>
                                <input type="text" class="form-control" id="inputZip" value="<?php echo $user_details["shipping_pin_code"] ?>" name="shipping_pin_code"> </div>
                            </div>
                            <button type="submit" class="btn btn-accent">Update Account</button>
                          </form>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
                
          </div>
          <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            <span class="copyright ml-auto my-auto mr-2">Copyright as © 2018
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
        
        if(isset($success) && $success == "0") {
            echo "swal('Done!', 'Profile updated successfully.', 'success');";
        }
        if(isset($error) && $error == "0") {
            echo "swal('Oops!', 'All fields are mandatory', 'error');";
        }
        if(isset($error) && $error == "1") {
            echo "swal('Oops!', 'Entered Email is In-Valid', 'error');";
        }
    ?>
</script>
  </body>
</html>