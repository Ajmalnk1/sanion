<?php
include '../ipdo/session.php';
include '../config.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
// check user logged in 
function isLoggedIn()
{
	if(isset($_SESSION["user_id"])) {
	    return true;
	} else {
	    return false;
	}
}

$result = isLoggedIn();

if($result) {
    $output = "";
    $sql = "SELECT * FROM orders";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $output.= "<tr><td>";
            $output.= $row["id"];
            $output.= "</td><td>";
            $output.= $row["quantity"];
            $output.= "</td><td>";
            $output.= $row["amount"];
            $output.= "</td><td>";
            $output.= $row["subscription_plan"];
            $output.= "</td><td>";
            $output.= $row["created_at"];
            $output.= "</td><td><a href='detailed-view.php?order_id=".$row["id"]."&user_id=".$row["user_id"]."' role='button' class='btn btn-primary btn-sm'>View</a></td><tr>";
        }
    } else {
        $output = "";
    }
} else {
    header("Location: login.php");
    
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
</head>
<body>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <a class="navbar-brand" href="#">
    <img src="http://www.thetwostones.com/wp-content/uploads/2017/05/twostones.svg" alt="Logo" style="width:120px;">
  </a>
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="index.php">Sanion | Administrative Index</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add_affiliate.php">Add / View Affiliate</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="view_affiliate_sales.php">View Affiliate Sales</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="change-password.php">Change Password</a>
    </li>
    <li class="nav-item mt-2 ml-3">
      <a class="nav-link badge badge-danger text-white" href="login.php?logout">Log  Out</a>
    </li>
  </ul>
</nav>
<br>
<div class="container">
  <h3>Active Orders</h3>
  <p>List of Active and Successful orders</p>            
  <table class="table">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Quantity</th>
        <th>Amount</th>
        <th>Subscription Plan</th>
        <th>Created Date & Time</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if($output != "") { echo $output; } ?>
    </tbody>
  </table>
  <p style='text-align: center'><?php if($output == "") { echo "No Orders"; } ?></p>
  
</div>

</body>
</html>


