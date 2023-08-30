<?php
include '../config.php';
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
$output = "";
$sql = "SELECT COUNT(affiliate_code) as sale_count, SUM(amount) as amount, affiliate_code FROM orders GROUP BY affiliate_code having COUNT(affiliate_code) > 0 ORDER by sale_count DESC";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        if ($row["affiliate_code"] == "" || $row["affiliate_code"] == " ") {
            $aff_name = "Others";
        } else {
            $aff_name = $row["affiliate_code"];
        }
        $output.= "<tr><td>";
        $output.= $aff_name;
        $output.= "</td><td>";
        $output.= $row["sale_count"];
        $output.= "</td><td>";
        $output.= $row["amount"];
        $output.= "</td><td></tr>";
    }
} else {
    $output = "";
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
    <li class="nav-item">
      <a class="nav-link" href="index.php">Sanion | Administrative Index</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add_affiliate.php">Add / View Affiliate</a>
    </li>
    <li class="nav-item active">
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
  <h3>Affiliate Sales</h3>
  <p>View your affiliate's Sales Count</p>            
  <table class="table">
    <thead>
      <tr>
        <th>Affiliate Name</th>
        <th>Sales Count</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php if($output != "") { echo $output; } ?>
    </tbody>
  </table>
  <p style='text-align: center'><?php if($output == "") { echo "No Sales"; } ?></p>
</div>

</body>
</html>
