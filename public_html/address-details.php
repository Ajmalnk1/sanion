<?php
session_start();

setcookie("amount", "", time() - 3600, "/");
setcookie("couponCode", "", time() - 3600, "/");
setcookie("couponCode_value", "", time() - 3600, "/");
setcookie("discountAmount", "", time() - 3600, "/");

if(isset($_SESSION["products_list"]) && isset($_SESSION["user_details"])) {
    include 'config.php';
    $sub_plan = $_SESSION["subscription_plan"];
    $user_details = $_SESSION["user_details"];
    $email = $user_details["email"];
    $mobile = $user_details["mobile"];
    $address_details = array();
    
    $sql = "SELECT * FROM users where email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $address_flag = true; // address is there in DB
        while($row = mysqli_fetch_assoc($result)) {
            $_SESSION["user_details"]["f_name"] = $row["f_name"];
            $_SESSION["user_details"]["l_name"] = $row["l_name"];
            $_SESSION["user_details"]["email"] = $row["email"];
            $_SESSION["user_details"]["mobile"] = $row["mobile"];
            $_SESSION["user_details"]["dob"] = $row["dob"];
            $address_details["shipping_add1"] = $row["shipping_add1"];
            $address_details["shipping_add2"] = $row["shipping_add2"];
            $address_details["shipping_city"] = $row["shipping_city"];
            $address_details["shipping_state"] = $row["shipping_state"];
            $address_details["shipping_pin_code"] = $row["shipping_pin_code"];
            $_SESSION["user_details"]["user_id"] = $row["id"];
        }
    } else {
        $address_flag = false; // address is not there in DB
    }

} else {
    session_unset();
    echo "session not available, go back to subscription page<br><br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address_details["shipping_add1"] = $_POST["shipping_add1"];
    $address_details["shipping_add2"] = $_POST["shipping_add2"];
    $address_details["shipping_city"] = $_POST["shipping_city"];
    $address_details["shipping_state"] = $_POST["shipping_state"];
    $address_details["shipping_pin_code"] = $_POST["shipping_pin_code"];
    if($address_flag == true) {
        if($address_details["shipping_add1"] == "" || $address_details["shipping_add2"] == "" || $address_details["shipping_city"] == "" || $address_details["shipping_state"] == "" || $address_details["shipping_pin_code"] == "") {
            echo "<p style='color: red'>Kindly fill all the mandatory feilds</p>";
        } else {
            $_SESSION["address_details"] = $address_details;
            $sql2 = "UPDATE users SET 
            shipping_add1='".$address_details["shipping_add1"]."',
            shipping_add2='".$address_details["shipping_add2"]."',
            shipping_city='".$address_details["shipping_city"]."',
            shipping_state='".$address_details["shipping_state"]."',
            shipping_pin_code='".$address_details["shipping_pin_code"]."'
            WHERE email='$email' and mobile='$mobile'";
            if (mysqli_query($conn, $sql2)) {
                
                if($sub_plan == "1" || $sub_plan == "2" || $sub_plan == "3") {
                    header('Location: http://www.sanionindia.com/summary.php');
                } else if ($sub_plan == "0") {
                    header('Location: http://www.sanionindia.com/trial-summary.php');
                }
                
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    } else if ($address_flag == false) {
        $_SESSION["address_details"] = $address_details;
        if($address_details["shipping_add1"] == "" || $address_details["shipping_add2"] == "" || $address_details["shipping_city"] == "" || $address_details["shipping_state"] == "" || $address_details["shipping_pin_code"] == "") {
            echo "<p style='color: red'>Kindly fill all the mandatory feilds</p>";
        } else {
        $sql3 = "INSERT INTO users (id, f_name, l_name, email, password, mobile, dob, shipping_add1, shipping_add2, shipping_city, shipping_state, shipping_pin_code)
                VALUES (NULL, '".$_SESSION["user_details"]["f_name"]."', '".$_SESSION["user_details"]["l_name"]."', '".$_SESSION["user_details"]["email"]."', '".$_SESSION["user_details"]["password"]."', '".$_SESSION["user_details"]["mobile"]."', '".$_SESSION["user_details"]["dob"]."', '".$_SESSION["address_details"]["shipping_add1"]."', '".$_SESSION["address_details"]["shipping_add2"]."', '".$_SESSION["address_details"]["shipping_city"]."', '".$_SESSION["address_details"]["shipping_state"]."', '".$_SESSION["address_details"]["shipping_pin_code"]."')";
            if (mysqli_query($conn, $sql3)) {
                $user_id = mysqli_insert_id($conn);
                $_SESSION["user_details"]["user_id"] = $user_id;
                //echo "Updated successfully";
                
                if($sub_plan == "1" || $sub_plan == "2" || $sub_plan == "3") {
                    header('Location: http://www.sanionindia.com/summary.php');
                } else if ($sub_plan == "0") {
                    header('Location: http://www.sanionindia.com/trial-summary.php');
                }
                
            } else {
                echo "Error inserting record: " . mysqli_error($conn). "<br>" . $sql3;
                //print_r($sql3);
            }
        }
    }
}

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
  <script type="text/javascript" src="app/js/main.js"></script>
  <script type="text/javascript">
    var myCalendar;

    function doOnLoad() {
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
<body style="overflow-x:hidden; ">
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
                  <li class="about"><a class="menu"href="u-m/">Login</a></li>
         
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
            <h1>Please provide your details for subscribing</h1>
          </div>

<form action="http://www.sanionindia.com/address-details.php"  method="post">
<div class="section_one section">

<div class="form request">
    <h1>Shipping Address</h1>
            <div class="form-group row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" type="text" placeholder="Address 1 *" id="Address" name="shipping_add1" value="<?php if($address_flag == true){ echo $address_details["shipping_add1"]; } ?>" required>
              </div>
            </div>
              <div class="form-group row">
             <div class="col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" type="text" placeholder="Address 2 *" id="Address" name="shipping_add2" value="<?php if($address_flag == true){ echo $address_details["shipping_add2"]; } ?>" required>
              </div>
            </div>
          
             <div class="form-group row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" type="text" placeholder="District *" id="city" name="shipping_city" value="<?php if($address_flag == true){ echo $address_details["shipping_city"]; } ?>" required/>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" type="text" placeholder="State *" id="state" name="shipping_state" value="<?php if($address_flag == true){ echo $address_details["shipping_state"]; } ?>" required/>
              </div>
            </div>
             <div class="form-group row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" type="number" placeholder="Pincode *" id="tel" name="shipping_pin_code" value="<?php if($address_flag == true){ echo $address_details["shipping_pin_code"]; } ?>" required/>
              </div>
            </div>
          
            <input style="display: inline-block;
    border-radius: 30px;
    border: none;
    font-size: 15px;
    font-family: Muli,sans-serif;
    letter-spacing: .6px;
    color: #fff;
    font-weight: 600;
    margin-bottom: 35px;
    position: relative;
    padding: 14px 40px;
    cursor: pointer;
    background-color: #9f70ad;
    outline: 0;" type="submit" value="Next">
           
</div>
          </form>
</div>
        </div>

     
  <div class="newslettter_container">
          <div class="news_inner">
            <div class="news left">
              <div class="inner">
              <p>Call US</p>
              <h1>+91 98098 89999
</h1>
</div>
            </div>
            <div class="news center">
               <div class="inner">
              <p>Email US</p>
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
           <img src="media/rupay.png">
           <img src="media/visa.png">
            <img src="media/mastercard.png">
          

         </div>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>