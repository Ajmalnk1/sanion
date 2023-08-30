<?php
//echo "<pre>";
//print_r($_GET);
if($_GET["order_id"] != "" && $_GET["user_id"] != "") {
    
    include '../config.php';
    $conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
    $order_id = $_GET["order_id"];
    $user_id = $_GET["user_id"];
    $order_details = array();
    $user_details = array();
    $product_details = array();
    $prod_count = 0;
    
    $sql = "SELECT * FROM orders where id='$order_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $order_details["trans_id"] = $row["trans_id"];
            $order_details["quantity"] = $row["quantity"];
            $order_details["amount"] = $row["amount"];
            $order_details["subscription_plan"] = $row["subscription_plan"];
            $order_details["subscribed_date"] = $row["subscribed_date"];
            $order_details["expiry_date"] = $row["exipry_date"];
            $order_details["amount"] = $row["amount"];
        }
    }
    
    $sql2 = "SELECT * FROM users where id='$user_id'";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        while($row2 = mysqli_fetch_assoc($result2)) {
            $user_details["f_name"] = $row2["f_name"];
            $user_details["l_name"] = $row2["l_name"];
            $user_details["email"] = $row2["email"];
            $user_details["dob"] = $row2["dob"];
            $user_details["mobile"] = $row2["mobile"];
            $user_details["shipping_add1"] = $row2["shipping_add1"];
            $user_details["shipping_add2"] = $row2["shipping_add2"];
            $user_details["shipping_city"] = $row2["shipping_city"];
            $user_details["shipping_state"] = $row2["shipping_state"];
            $user_details["shipping_pin_code"] = $row2["shipping_pin_code"];
        }
    }
    
    $sql3 = "SELECT * FROM product_orders where order_id='$order_id'";
    $result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0) {
        while($row3 = mysqli_fetch_assoc($result3)) {
            $product_details[$prod_count]["id"] = $row3["id"];
            $product_details[$prod_count]["name"] = $row3["name"];
            $product_details[$prod_count]["quantity"] = $row3["quantity"];
            $product_details[$prod_count]["amount"] = $row3["amount"];
            $prod_count = $prod_count+1;
        }
    }
    
    $sql4 = "SELECT * FROM referrals where order_id='$order_id'";
    $result4 = mysqli_query($conn, $sql4);
    if (mysqli_num_rows($result4) > 0) {
        while($row4 = mysqli_fetch_assoc($result4)) {
            $referral_details["subscription_plan"] = $row4["subscription_plan"];
            $referral_details["code"] = $row4["code"];
            $referral_details["count"] = $row4["count"];
            $referral_details["created_at"] = $row4["created_at"];
            $referral_details["used_1"] = $row4["used_1"];
            $referral_details["used_2"] = $row4["used_2"];
            $referral_details["used_3"] = $row4["used_3"];
            $referral_details["used_4"] = $row4["used_4"];
            $referral_details["used_5"] = $row4["used_5"];
        }
    }
    
} else {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sanion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/cs.css">
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
      <a class="nav-link">Sanion | Administrative Account</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add_affiliate.php">Add / View Affiliate</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="view_affiliate_sales.php">View Affiliate Sales</a>
    </li>
  </ul>
</nav>
<br>
<div class="container">
    <a href="index.php" role="button" class="btn btn-sm btn-warning mb-3">Go Back</a>
    <div class="row">
        <div class="col-md-6">
            <div class="card cs-card">
              <div class="card-body">
                  <h4 style="text-decoration: underline">Order Details</h4>
                  <span>
                      <b>Order ID: </b><?php echo $order_id; ?><br>
                      <b>Transaction ID: </b><?php echo $order_details["trans_id"]; ?><br>
                      <b>Quantity: </b><?php echo $order_details["quantity"]; ?><br>
                      <b>Amount: </b><?php echo $order_details["amount"]; ?>.00 INR<br>
                      <b>Subscription Plan: </b><?php echo $order_details["subscription_plan"]; ?><br>
                      <b>Subscribed Date: </b><?php echo $order_details["subscribed_date"]; ?><br>
                      <b>Expiry Date: </b><?php echo $order_details["expiry_date"]; ?>
                  </span>
              </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card cs-card">
              <div class="card-body">
                  <h4 style="text-decoration: underline">User Details</h4>
                  <span>
                      <b>User ID: </b><?php echo $user_id; ?><br>
                      <b>First Name: </b><?php echo $user_details["f_name"]; ?><br>
                      <b>Last Name: </b><?php echo $user_details["l_name"]; ?><br>
                      <b>E-Mmail: </b><?php echo $user_details["email"]; ?><br>
                      <b>Mobile: </b><?php echo $user_details["mobile"]; ?><br>
                      <b>DOB: </b><?php echo $user_details["dob"]; ?><br>&nbsp;
                  </span>
              </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="card cs-card">
              <div class="card-body">
                  <h4 style="text-decoration: underline">Benefit Details</h4>
                  <span>
                      <b>Subscription Plan: </b><?php echo $referral_details["subscription_plan"]; if($referral_details["subscription_plan"] == 3){ $div_by = 5; } else if($referral_details["subscription_plan"] == 2){ $div_by = 2; } else if($referral_details["subscription_plan"] == 1){ $div_by = 1; } else { $div_by = "err"; } ?><br>
                      <b>Code: </b><?php echo $referral_details["code"]; ?><br>
                      <b>Count Available: </b><?php echo $referral_details["count"]."/".$div_by; ?><br>
                      <b>Code Created At: </b><?php echo $referral_details["created_at"]; ?><br>
                      <b>1st Used: </b><?php echo $referral_details["used_1"]; ?><br>
                      <b>2nd Used: </b><?php echo $referral_details["used_2"]; ?><br>
                      <b>3rd Used: </b><?php echo $referral_details["used_3"]; ?><br>
                      <b>4th Used: </b><?php echo $referral_details["used_4"]; ?><br>
                      <b>5th Used: </b><?php echo $referral_details["used_4"]; ?><br>
                  </span>
              </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card cs-card">
              <div class="card-body">
                  <h4 style="text-decoration: underline">Shipping Details</h4>
                  <span>
                      <b>Shipping Add 1: </b><?php echo $user_details["shipping_add1"]; ?><br>
                      <b>Shipping Add 2: </b><?php echo $user_details["shipping_add2"]; ?><br>
                      <b>Shipping City: </b><?php echo $user_details["shipping_city"]; ?><br>
                      <b>Shipping State: </b><?php echo $user_details["shipping_state"]; ?><br>
                      <b>Shipping Pincode: </b><?php echo $user_details["shipping_pin_code"]; ?>
                  </span>
              </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card cs-card">
              <div class="card-body">
                  <h4 style="text-decoration: underline">Product Details</h4>
                  
                    <table class="table mb-0">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          
                            $output = "";
                            if((count($product_details)) > 0) {
                                $count = count($product_details);
                                for($i=0; $i<=$count; $i++) {
                                    $output.= "<tr><td>";
                                    $output.= $product_details[$i]["name"];
                                    $output.= "</td><td>";
                                    $output.= $product_details[$i]["quantity"];
                                    $output.= "</td><td>";
                                    $output.= $product_details[$i]["amount"];
                                    $output.= "</td><tr>";
                                }
                                echo $output;
                            }
                          
                          ?>
                        </tbody>
                    </table>
                  
              </div>
            </div>
        </div>
    </div>
    <br>
    
<?php 
// echo "<pre>"; 
// print_r($order_details); 
// echo "<br>";
// print_r($user_details); 
// echo "<br>";
// print_r($product_details); 
?>
</div>
</body>
</html>
