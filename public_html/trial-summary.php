<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form | Sanion</title>

  <meta name="author" content="Jothika">
  <meta name="contact" content="">
  <meta name="title" content="Sanion">
  <meta name="keywords" content="">
  <meta name="description" content="Sanion">

  <link href="media/favicon/bevent_faviconew.png" rel="shortcut icon" type="image/png">
  <link rel="apple-touch-icon-precomposed" href="media/favicon/bevent_faviconew.png">
  <link rel="canonical" href="http://www.sanionindia.com/">

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/owl.carousel.min.js"></script>

  <link rel="stylesheet" type="text/css" href="dist/css/min_css/form.css">
  <link rel="stylesheet" type="text/css" href="dist/css/min_css/dhtmlxcalendar.css" />
  <link rel="stylesheet" type="text/css" href="dist/css/min_css/carousel.min.css">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="http://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
  <link href="http://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
  <link href="css/odometer-theme-minimal.css" rel="stylesheet" type="text/css">

  <script type="text/javascript">
    function swalFun() {
      <?php
      if(isset($_SESSION["products_list"]) && isset($_SESSION["user_details"]) && isset($_SESSION["address_details"]) && isset($_SESSION["subscription_plan"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          include 'config.php';
          $quantity_total = 0;
          $cost_total = 0;
          $order_id_created = 0;
          $referral_code = "";
          $order_id = 'SANION_'.time();
          $products = $_SESSION["products_list"];
          $user_id = $_SESSION["user_details"]["user_id"];
          $sub_plan = $_SESSION["subscription_plan"];
          $mobile = $_SESSION["user_details"]["mobile"];

          if($sub_plan == 1) {
            $expiry_date = date('Y-m-d', strtotime('+1 years'));
          } else if ($sub_plan == 2) {
            $expiry_date = date('Y-m-d', strtotime('+2 years'));
          } else if ($sub_plan == 3) {
            $expiry_date = date('Y-m-d', strtotime('+3 years'));
          } else if ($sub_plan == 0) {
            $expiry_date = date('Y-m-d', strtotime('+1 month'));
          }

          for($j=0; $j<=(count($products)); $j++)
          {        
            $quantity_total +=  ($products[$j]["Quantity"]) == ' ' || ($products[$j]["Quantity"]) == '' ? 0 : $products[$j]["Quantity"]; 
            $cost_total +=  ($products[$j]["Cost"]) == ' ' || ($products[$j]["Cost"]) == '' ? 0 : ($products[$j]["Cost"])*($products[$j]["Quantity"]); 
          }

          $_SESSION["amount"] = $cost_total;

          $sql = "INSERT INTO orders (id, user_id, quantity, amount, subscription_plan, exipry_date, order_status) 
          VALUES ('".$order_id."', '".$user_id."', '".$quantity_total."', '".$cost_total."', '".$sub_plan."', '".$expiry_date."', 'dropped')";
          if (mysqli_query($conn, $sql)) {
            $_SESSION["order_id"] = $order_id;
            $order_id_created = mysqli_insert_id($conn);
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }

          for($i=0; $i<(count($products)); $i++) {
            $name = $products[$i]["Product"];
            $quantity = $products[$i]["Quantity"];
            $cost = $products[$i]["Cost"];
            $sql2 = "INSERT INTO product_orders (id, order_id, name, quantity, amount) 
            VALUES (NULL, '$order_id', '$name', '$quantity', '".($cost*$quantity)."')";
            if (mysqli_query($conn, $sql2)) {
            } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          }


          if(isset($referral_code) && $referral_code != "" && $referral_code != " "){
            $sql = "SELECT * FROM referrals where code='$referral_code' and count > 0 and status='active'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
                $genrated_for = $row["genrated_for"];
                $order_id_db = $row["order_id"];
                $subscription_plan = $row["subscription_plan"];
                $db_count = $row["count"];
                $used_1 = $row["used_1"];
                $used_2 = $row["used_2"];
                $used_3 = $row["used_3"];
                $used_4 = $row["used_4"];
                $used_5 = $row["used_5"];
                $affiliate_code = $row["affiliate_code"];
              }
                
                $_SESSION["ref"] = $affiliate_code;
                $_SESSION["referral"]["code"] = $referral_code;
                $_SESSION["referral"]["order_id"] = $order_id_db;
                $_SESSION["referral"]["subscription_plan"] = $subscription_plan;
                $_SESSION["referral"]["used_1"] = $used_1;
                $_SESSION["referral"]["used_2"] = $used_2;
                $_SESSION["referral"]["used_3"] = $used_3;
                $_SESSION["referral"]["used_4"] = $used_4;
                $_SESSION["referral"]["used_5"] = $used_5;
                $_SESSION["referral"]["count"] = $db_count;
                $_SESSION["amount"] = ($_SESSION["amount"])-((($_SESSION["amount"])/100)*5);
                $sp = "";
                $sp.= "var myVar = setInterval(myTimer, 3000);";
                $sp.= "function myTimer() { \n
                  location.replace('http://www.sanionindia.com/payment.php'); \n
                } \n";
                $sp.= "swal('Success!', 'Extra 5% Discount, \\n Referral Code is Valid! \\n Kindly wait for 5 seconds, we are redirecting you to payment page.', 'success'); \n";
                echo $sp;             
            } else {
              echo "swal('Oops!', 'Code Expired / Invalid', 'error'); \n";
            }
          } else {
            $sp = "";
            $sp.= "var myVar = setInterval(myTimer, 3000);";
            $sp.= "function myTimer() { \n
              location.replace('http://www.sanionindia.com/payment.php'); \n
            } \n";
            $sp.= "swal('Success!', 'Evrything is Good! \\n Kindly wait for 5 seconds, we are redirecting you to payment page.', 'success'); \n";
            echo $sp;
          }
        }
      } else {
        echo "location.replace('http://www.sanionindia.com/subscribe.php'); \n";
      }

      ?>
    }
  </script>

  <script type="text/javascript" src="app/js/main.js"></script>
  <script type="text/javascript">
    var myCalendar;

    function doOnLoad() {
      swalFun();
      myCalendar = new dhtmlXCalendarObject(["afromdate"]);
      myCalendar.setWeekStartDay(7);
      myCalendar.hideTime();
    }
  </script>
  <script>
    $(function() {
      $("#datepicker").datepicker();
    });
  </script>
</head>
<body style="overflow-x:hidden; " onload="doOnLoad();">
  <header>

    <div class="main_navigation">
      <div class="zoom">
        <div class="logo_holder">
          <a href="index.html" class="logo">

            <img src="media/logo.png" alt="sanion_logo">

          </a>
        </div>
        <div class="mob_navigation">
          <button class="butmenu mob_menu" data-ripple-color="#f5f5f5" id="onclick"><span><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px"
            viewBox="0 0 53 53" style="enable-background:new 0 0 53 53; fill:#fff;" xml:space="preserve">
            <g>
              <g>
                <path d="M2,13.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,13.5,2,13.5z"/>
                <path d="M2,28.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,28.5,2,28.5z"/>
                <path d="M2,43.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,43.5,2,43.5z"/>
              </g>
            </g>
          </svg>
        </span>
      </button>
    </div>
    <div class="navigation">
      <ul class="nav_menu">
        <li class="about"><a class="menu" href="about-us.html">ABOUT</a></li>
        <li class="about"><a class="menu" href="subscribe.php">SUBSCRIBE</a></li>
        <li class="about"><a class="menu" href="trial-pack.php">Trial Pack</a></li>
        <li class="about"><a class="menu" href="http://chrdindia.org/">CHRD</a></li>
        <li class="about"><a class="menu" href="contact-us.html">CONTACT</a></li>

      </ul>      
      <ul class="socila_menu nav_menu">
        <li class="about"><a class="social" href="http://www.facebook.com/sanionindia/"><img src="media/facebook_icon.png"></a></li>
        <li class="about"><a class="social" href="http://www.instagram.com/sanionindia/"><img src="media/insta_icon.png"></a></li>
      </ul>

    </div>
  </div>
</div>
</header>
<div class="sub_menumob">
  <div class="overlay"></div>
  <div class="sub_close">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17px" height="16px" viewBox="0 0 17 16" version="1.1">
      <g id="Mention-v4" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Menu-Mobile-Full-" transform="translate(-335.000000, -27.000000)" fill="#404040">
          <path d="M345.109087,34.8816263 L350.973348,29.2331915 C351.231304,28.9848437 351.373217,28.6537133 351.373217,28.3018872 C351.373217,27.9478437 351.231304,27.6174524 350.974087,27.3713219 C350.467043,26.8775828 349.573435,26.8753654 349.059739,27.3698437 L343.186609,33.0293654 L337.312739,27.3713219 C336.804217,26.8775828 335.912087,26.8753654 335.39913,27.3698437 C335.141913,27.6181915 335,27.9493219 335,28.3018872 C335,28.6537133 335.141913,28.9848437 335.39913,29.2324524 L341.263391,34.8816263 L335.39913,40.5308002 C335.141174,40.779148 335,41.1102785 335,41.4628437 C335,41.8154089 335.141913,42.1450611 335.39913,42.3926698 C335.65413,42.6395393 335.993391,42.7755393 336.353348,42.7755393 L336.357043,42.7755393 C336.718478,42.7755393 337.057739,42.6395393 337.312739,42.3926698 L343.186609,36.7338872 L349.059739,42.3926698 C349.315478,42.6395393 349.654739,42.7755393 350.013217,42.7755393 L350.016913,42.7755393 C350.379087,42.7755393 350.719087,42.6395393 350.972609,42.394148 C351.231304,42.1465393 351.373217,41.8154089 351.373217,41.4628437 C351.373957,41.1110176 351.232043,40.7806263 350.973348,40.5308002 L345.109087,34.8816263" id="stroke-x-1-copy"></path>
        </g>
      </g>
    </svg>
  </div>
  <div class="sub_one mob_list">
    <ul class="subcolumn_one">
      <li class="about"><a class="menu" href="about-us.html">ABOUT</a></li>
      <li class="about"><a class="menu" href="subscribe.php">SUBSCRIBE</a></li>
      <li class="about"><a class="menu" href="http://chrdindia.org/">CHRD</a></li>
      <li class="about"><a class="menu" href="contact-us.html">CONTACT</a></li>

      <li class="about"><a class="social" href="http://www.facebook.com/sanionindia/"><img src="media/facebook_icon.png"></a></li>
      <li class="about"><a class="social" href="http://www.instagram.com/sanionindia/"><img src="media/insta_icon.png"></a></li>
    </ul>
  </div>

</div>
<section>
  <div id="main_wrapper">
    <div class="zoom">
      <div class="form_container container-fluid">

        <div class="over"></div>
        <div class="over1"></div>
        <div class="head">
          <h1>Summary</h1>
        </div>

        <div class="section_one section " id="app">
            <div class="form request">
            <h1>Products in Cart</h1>

            <table>
              <tr>
                <th>S.No</th>
                <th>Item Name</th>
                <th>Quantity</th>
              </tr>
              <?php
              if(isset($_SESSION["products_list"])) {
                $total_pads = 0;
                $total_cost_for_sp = 0;
                $products_list = $_SESSION["products_list"];
                $li_count = count($products_list);
                for($i=0; $i<$li_count; $i++) {
                  $op.= "<tr><td>";
                  $op.= $i+1;
                  $op.= "</td><td>";
                  $op.= $products_list[$i]["Product"];
                  $op.= "</td><td>";
                  $op.= $products_list[$i]["Quantity"];
                  $op.= "</td></tr>";
                  $total_pads = $total_pads+$products_list[$i]["Quantity"];
                  $_SESSION["total_pads"] = $total_pads;
                  $total_cost_for_sp = $total_cost_for_sp+(($products_list[$i]["Quantity"])*($products_list[$i]["Cost"]));
                }
                
                $total_cost_for_sp = $total_cost_for_sp*(1);

                echo $op;
              }
              ?>
            </table>
            
            <h2>Total No.of pads = <span class="nopad"><?php if($total_pads != ""){ echo $total_pads; } ?></span></h2>
            <h3>Cost of purchase ₹ <span class="odometer" id="amnt"><?php if($total_cost_for_sp != ""){ echo $total_cost_for_sp; } ?></span></h3>
            <h4>
            
            
            <form action="http://www.sanionindia.com/trial-summary.php"  method="post">
                <input hidden id="cc_to_post" type="text" name="referral_code" />  
                <input style="display: inline-block;
            border-radius: 30px;
            font-size: 15px;
            font-family: Muli,sans-serif;
            letter-spacing: .6px;
            color: #000;
            font-weight: 600;
            margin-bottom: 35px;
            position: relative;
            border:1px solid #9f70ad;
            padding: 14px 40px;
            cursor: pointer;
            background-color: transparent;
            outline: 0;" type="submit" value="Proceed to Pay">
            </form>
            
            </h4>
            

            </div>
          
        </div>
      </div>


      <div class="newslettter_container">
        <div class="news_inner">
          <div class="news left">
            <div class="inner">
              <p>Do you have a Question</p>
              <h1>+91 98098 89999
              </h1>
            </div>
          </div>
          <div class="news center">
            <div class="inner">
              <p>Do you have a Question</p>
              <h1>support@sanionindia.com</h1>
            </div>
          </div>

        </div>
      </div>
      <!--news-end-->
    </div>
  </div>
</section>
<footer>
  <div class="footer_main">
    <div class="footer_content">
      <div class="content">
        <div class="inner">
          <p>Copyright © 2018 Sanion <span>-</span>  All Rights Reserved.</p>
        </div>
      </div>
      <div class="content">
        <div class="inner">
          <img src="media/logo.png">
        </div>
      </div>
      <div class="content">
        <div class="inner">
          <div class="social">
            <img src="media/paypal.png">
            <img src="media/visa.png">
            <img src="media/mastercard.png">
            <img src="media/discover.png">

          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<script src="http://cdn.jsdelivr.net/npm/vue"></script>
    <script src="http://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="http://unpkg.com/vue-cookies@1.5.7/vue-cookies.js"></script>
    <script src="js/odometer.min.js"></script>
    <script src="js/app.js?<?php echo time(); ?>"></script>
</body>
</html>