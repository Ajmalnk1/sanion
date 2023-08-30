<?php
include '../ipdo/session.php';
include '../config.php';
include '../ipdo/config.php';
include '../ipdo/class.lpdo.php';
$db = new ipdo($config['Database']);
$conn = mysqli_connect('localhost','u860301413_sanionindia_us', 'yI3_~vC-)@}','u860301413_sanionindia_db');
$output = "";
$sql = "SELECT * FROM affiliate";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $output.= "<tr><td>";
        $output.= $row["name"];
        $output.= "</td><td>";
        $output.= "Subscribe: <code>https://www.sanionindia.com/subscribe.php?ref=".$row["code"]."</code><br>or<br>Trial: <code>https://www.sanionindia.com/trial-pack.php?ref=".$row["code"]."</code>";
        $output.= "</td><td>";
        $output.= $row["timestamp"];
        $output.= "</td><td>";
        $output.= "<a href='add_affiliate.php?delete_id=".$row["id"]."'>Delete</a>";
        $output.= "</td><td></tr>";
    }
} else {
    $output = "";
}

if(isset($_GET["delete_id"])) {
    $db->delete('affiliate', array('id' => $_GET["delete_id"]));
    header("Location: add_affiliate.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["name"]) && isset($_POST["code"])){
    $result = $db->insert('affiliate', array('id' => 'NULL', 'name' => $_POST["name"], 'code' => $_POST["code"]));
    header("Location: add_affiliate.php");
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
    <li class="nav-item active">
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
  <h3>Affiliate Details</h3>
  <p>Add or View your affiliate's</p>            
  <form class="row" method="post" action="add_affiliate.php">
  <div class="col-md-4 form-group">
    <label for="name">Name<span class="text-danger">*</span>:</label>
    <input type="text" class="form-control" id="name" name="name"><br><span class="text-danger" style="font-size: 13px">Note: Don't Enter the Name & Code with whitespace.</span>
  </div>
  <div class="col-md-3 form-group">
    <label for="code">Code<span class="text-danger">*</span>:</label>
    <input type="text" class="form-control" id="code" name="code">
  </div>
  <div class="col-md-4 form-group form-check">
    <button type="submit" style="margin-top: 1.9rem!important" class="btn btn-primary">Add</button>
  </div>
</form>

  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Link</th>
        <th>Created Date & Time</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if($output != "") { echo $output; } ?>
    </tbody>
  </table>
  <p style='text-align: center'><?php if($output == "") { echo "No Affiliate's"; } ?></p>
</div>

</body>
</html>
