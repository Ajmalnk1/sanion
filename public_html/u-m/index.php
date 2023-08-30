<?php
include '../ipdo/session.php';
include '../ipdo/config.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
include '../ipdo/class.lpdo.php';
$db = new ipdo($config['Database']);
$table_users = 'orders';

$result = isLoggedIn();

if($result) {
    $condition = array('user_id' => $_SESSION["user_id"], 'tran_status' => 'S', 'order_status' => 'Payment Completed');
    $rs = $db->get_rows($table_users, $condition);
    if(count($rs) > 0) {
        for($i=0; $i < count($rs); $i++ ){
            $output_table.= "<tr>";
            $output_table.= "<td>";
            $output_table.= $i+1;
            $output_table.= "</td>";
            $output_table.= "<td>";
            $output_table.= $rs[$i]["id"];
            $output_table.= "</td>";
            $output_table.= "<td>";
            $output_table.= $rs[$i]["quantity"];
            $output_table.= "</td>";
            $output_table.= "<td>";
            $output_table.= $rs[$i]["amount"];
            $output_table.= "</td>";
            $output_table.= "<td>";
            $output_table.= $rs[$i]["subscription_plan"];
            $output_table.= "</td>";
            $output_table.= "<td><a href='view-order.php?order_id=".$rs[$i]["id"]."'><i data-vi='eye' data-vi-size='35'></i></a> &nbsp; <a href='cancel-order.php?order_id=".$rs[$i]["id"]."'><i data-vi='close' data-vi-size='35'></i></a></td>";
            $output_table.= "</tr>";
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
    <title>Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://unpkg.com/vivid-icons" type="text/javascript"></script>
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
                <span class="text-uppercase page-subtitle">View / Cancel</span>
                <h3 class="page-title">Orders</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Active Orders</h6>
                  </div>
                  <div class="card-body p-0 pb-3 text-center">
                    <div class="table-responsive">
                    <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">Order ID</th>
                          <th scope="col" class="border-0">Quantity</th>
                          <th scope="col" class="border-0">Amount</th>
                          <th scope="col" class="border-0">Subscription Plan</th>
                          <th scope="col" class="border-0">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($output_table)) { echo $output_table; }  ?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Default Light Table -->
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
  </body>
</html>