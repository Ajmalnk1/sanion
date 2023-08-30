<?php
session_start();
if($_SESSION["ref"] == "" || $_SESSION["ref"] == " ") {
    $_SESSION["ref"] = "";
    $_SESSION["products_list"] = null;
    $_SESSION["user_details"] = null;
    $_SESSION["address_details"] = null;
    $_SESSION["affiliate_sales"] = "NO";
} else {
    $_SESSION["products_list"] = null;
    $_SESSION["user_details"] = null;
    $_SESSION["address_details"] = null;
}
?>

<?php
include 'ipdo/config.php';
include 'ipdo/class.lpdo.php';
$db = new ipdo($config['Database']);

$loggedInStatus = isLoggedIn();
if($loggedInStatus) {
    $_SESSION["user_details"] = $_SESSION["user_details_log"];
    $_SESSION["address_details"] = $_SESSION["address_details_log"];
}


if(isset($_GET["ref"]) && $_GET["ref"] != "") {
    $_SESSION["affiliate_code_as_it_is"] = $_GET["ref"];
    $condition_for_ref_code = array('code' => $_GET["ref"]);
    $ref_name_from_db = $db->get_rows('affiliate', $condition_for_ref_code);
    if(count($ref_name_from_db) > 0) {
        $_SESSION["ref"] = $ref_name_from_db[0]["name"];
        $_SESSION["affiliate_sales"] = "YES";
    } else {
        $_SESSION["ref"] = "";
    }
} else {
    if($_SESSION["ref"] == "" || $_SESSION["ref"] == " ") {
        $_SESSION["ref"] = "";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
  $post_count = (count($_POST)/2)-1;
  $prod_count_validate = 0;
  $prod_arr_num = 0;

  for($i=1; $i<=$post_count+1; $i++)
  { 
    $products[$i-1]["Product"] = $_POST["product".$i];
    $products[$i-1]["Quantity"] = $_POST["quantity".$i];
    $products[$i-1]["Cost"] = $_POST["cost".$i];
  }  
  if(isset($_POST["sub1"]))  {
    $sub_plan = $_POST["sub1"];   
  } else if (isset($_POST["sub2"])) {
    $sub_plan = $_POST["sub2"];    
  } else if (isset($_POST["sub3"])) {
    $sub_plan = $_POST["sub3"];    
  }

  for($j=0; $j<=(count($products)); $j++)
  {        
    $prod_count_validate +=  ($products[$j]["Quantity"]) == ' ' || ($products[$j]["Quantity"]) == '' ? 0 : $products[$j]["Quantity"];
  } 

  $products_list = array();
  for($j=0; $j<=(count($products)); $j++)
  {    
    if($prod_count_validate > 0) {
      $each_prod_count = $products[$j]["Quantity"];
      if($each_prod_count > 0) {        
        $products_list[$prod_arr_num]["Product"] = $products[$j]["Product"];
        $products_list[$prod_arr_num]["Quantity"] = $products[$j]["Quantity"];
        $products_list[$prod_arr_num]["Cost"] = $products[$j]["Cost"];
        $prod_arr_num = $prod_arr_num + 1;
      }
    }
  }
  $_SESSION["products_list"] = $products_list;
  $_SESSION["subscription_plan"] = $sub_plan;
  $flag = "end";
  if($flag == "end"){
      
    $li_count = count($products_list);
    for($i=0; $i<$li_count; $i++) {
        $total_cost_for_sp = $total_cost_for_sp+(($products_list[$i]["Quantity"])*($products_list[$i]["Cost"]));
    }
    $total_cost_for_sp = $total_cost_for_sp*(12)*($sub_plan);
    
    if($sub_plan == "1") {
        if($total_cost_for_sp >= 1000) {
            if($loggedInStatus) {
                echo "<script> location.replace('http://www.sanionindia.com/summary.php'); </script>";
            } else {
                echo "<script> location.replace('http://www.sanionindia.com/user-details.php'); </script>";
            }
        } else {
            echo "<script> alert('Total amount should be greater than INR 1000 to place your subscription.'); </script>";
        }
    }
    
    if($sub_plan == "3") {
        if($total_cost_for_sp >= 3000) {
            if($loggedInStatus) {
                echo "<script> location.replace('http://www.sanionindia.com/summary.php'); </script>";
            } else {
                echo "<script> location.replace('http://www.sanionindia.com/user-details.php'); </script>";
            }
        } else {
            echo "<script> alert('Total amount should be greater than INR 3000 to place your subscription.'); </script>";
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
  <title>Subscribe | Sanion</title>

  <meta name="author" content="Jothika">
  <meta name="contact" content="">
  <meta name="title" content="Sanion">
  <meta name="keywords" content="">
  <meta name="description" content="Sanion">

  <link href="media/favicon/bevent_faviconew.png" rel="shortcut icon" type="image/png">
  <link rel="apple-touch-icon-precomposed" href="media/favicon/bevent_faviconew.png">
  <link rel="canonical" href="http://www.sanion.com/">

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/owl.carousel.min.js"></script>

  <link rel="stylesheet" type="text/css" href="dist/css/min_css/subscribe.css">
   <link rel="stylesheet" type="text/css" href="dist/css/min_css/about.css">
  <link rel="stylesheet" type="text/css" href="dist/css/min_css/carousel.min.css">

  <script type="text/javascript" src="app/js/main.js"></script>
  <script type="text/javascript" src="app/js/subscribe.js"></script>
  <style>
  #submit-btn1:disabled {
        font-family: Muli,sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #868686;
    letter-spacing: .9px;
    background-color: #ebecec;
    padding: 8px 25px;
    text-align: center;
    border: 1px solid #ebecec !important;
    border-radius: 100px;
    cursor: pointer;
  }
  #submit-btn2:disabled {
        font-family: Muli,sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #868686;
    letter-spacing: .9px;
    background-color: #ebecec;
    padding: 8px 25px;
    text-align: center;
    border: 1px solid #ebecec !important;
    border-radius: 100px;
    cursor: pointer;
  }
    @media (min-width: 1281px) {
    #main_wrapper .fifth_container .fifth_inner .fifth_content .subscribe .inner .sub_content .one {
          left: 205px !important;
      }
    }
  </style>
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
            <li class="about"><a class="menu" href="trial-pack.php">TRIAL PACK</a></li>
            <li class="about"><a class="menu" href="chrdindia.org">CHRD</a></li>
            <li class="about"><a class="menu" href="contact-us.html">CONTACT</a></li>

          </ul>


          <ul class="socila_menu nav_menu">


            <li class="about"><a class="social" href="#"><img src="media/facebook_icon.png"></a></li>
            <li class="about"><a class="social" href="#"><img src="media/insta_icon.png"></a></li>
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
            <li class="about"><a class="menu" href="subscribe.html">SUBSCRIBE</a></li>
            <li class="about"><a class="menu" href="trial-pack.php">TRIAL PACK</a></li>
            <li class="about"><a class="menu" href="chrdindia.org">CHRD</a></li>
            <li class="about"><a class="menu" href="contact-us.html">CONTACT</a></li>


        <li class="about">
        

        <li class="about"><a class="social" href="#"><img src="media/facebook_icon.png"></a></li>
        <li class="about"><a class="social" href="#"><img src="media/insta_icon.png"></a></li>
      </ul>
    </div>

  </div>
  <section>
    <div id="main_wrapper">
      <div class="zoom">
        <div class="fifth_container subs">
          <div class="over"></div>
          <div class="fifth_inner" style="padding-top: 10%;">
            <!-- <div class="butterfly">
    <img src="media/butter_fly.png">
   
          </div>
            <div class="butterflyone">
    <img src="media/butter_fly.png">

          </div>-->
            <div class="fifth_content">
              <div class="top_content">
                <h1>Your days, Your Choice</h1>
                <button class="anion select" href="#">Anion</button>
                <button class="herbal" href="#">Herbal</button>

              </div>
              <form id='form-id' action="http://www.sanionindia.com/subscribe.php<?php if(isset($_SESSION["ref"]) && isset($_SESSION["affiliate_code_as_it_is"])) { echo "?ref=".$_SESSION["affiliate_code_as_it_is"]; } ?>"  method="post">
              <div class="bottom_content herbalcon">
                <div class="bottom_inner">
<?php
include 'config.php';

$sql = "SELECT * FROM product_details where product_name='Herbal'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {  
  while($row = mysqli_fetch_assoc($result)) {
    $output.= "<div class='size'>";
    $output.= "<h1>".$row["size"]."</h1>";
    $output.= "<p>₹ ".$row["cost"]."   </p>";
    $output.= "<div class='image'>";
    $output.= "<img src='media/".$row["id"].".png'>";
    $output.= "</div>";
    $output.= "<div class='con'>";
    $output.= "<div id='field2'>";
    $output.= "<input hidden type='text' name='product".$row["id"]."' value='".$row["product_name"]." - ".$row["size"]."'>";
    $output.= "<button type='button' id='sub2' class='sub' style='background-color: #fff;
    border-radius: 100px;border: 1px solid #bbb;height: 40px;width: 40px;font-size: 20px;'>-</button>";
    $output.= "<input type='text' id='".$row["id"]."' value='0' name='quantity".$row["id"]."' class='field' style='border: none;width: 50px;margin-left: 30px;font-size: 35px;color: #7a63a7;font-weight: 500;' />";
    $output.= "<button type='button' id='add2' class='add' style='background-color: #fff;
    border-radius: 100px;border: 1px solid #bbb;height: 40px;width: 40px;font-size: 20px;'>+</button>";
    $output.= "<input hidden type='text' name='cost".$row["id"]."' value='".$row["cost"]."'>";
    $output.= "</div>";
    $output.= "</div>";
    $output.= "</div>";

  }
  echo $output;   
}  

?>
                    </div>
              </div>
              <div class="bottom_content anioncon">
                <div class="bottom_inner">
                                      <?php
include 'config.php';

$sql = "SELECT * FROM product_details where product_name='Anion'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {  
  while($row = mysqli_fetch_assoc($result)) {
    $output2.= "<div class='size'>";
    $output2.= "<h1>".$row["size"]."</h1>";
    $output2.= "<p>₹ ".$row["cost"]."   </p>";
    $output2.= "<div class='image'>";
    $output2.= "<img src='media/".$row["id"].".png'>";
    $output2.= "</div>";
    $output2.= "<div class='con'>";
    $output2.= "<div id='field2'>";
    $output2.= "<input hidden type='text' name='product".$row["id"]."' value='".$row["product_name"]." - ".$row["size"]."'>";
    $output2.= "<button type='button' id='sub2' class='sub' style='background-color: #fff;
    border-radius: 100px;border: 1px solid #bbb;height: 40px;width: 40px;font-size: 20px;'>-</button>";
    $output2.= "<input type='text' id='".$row["id"]."' value='0' name='quantity".$row["id"]."' class='field' style='border: none;width: 50px;margin-left: 30px;font-size: 35px;color: #7a63a7;font-weight: 500;' />";
    $output2.= "<button type='button' id='add2' class='add' style='background-color: #fff;
    border-radius: 100px;border: 1px solid #bbb;height: 40px;width: 40px;font-size: 20px;'>+</button>";
    $output2.= "<input hidden type='text' name='cost".$row["id"]."' value='".$row["cost"]."'>";
    $output2.= "</div>";
    $output2.= "</div>";
    $output2.= "</div>";

  }
  echo $output2;   
}  

?>
                </div>
              </div>
             <!-- <button class="cal">Calculate</button>-->
              <div class="button">
                <h1>No.of pads selected per month</h1>
                <button class="year"> <span class="quan">0</span>
                <!--  <p class="color">PER MONTH</p>-->
                </button>
              </div>
              <div class="subscribe">
                <div class="inner">
                  <div class="sub_content">
                    <!--<a href="book.html">-->
                      <p style="color: red" id='err-msg'></p>
                    <!--</a>-->
                    <!--<a href="book.html">-->
                      <div class="one two">
                        <div class="sub_inner">
                          <div class="subs">
                            <div class="con">
                              <p>Subscribe for</p>
                              <h1>1 Year</h1>

                            </div>
                            <div class="image small">
                              <img class="arr" src="media/right-arrow.png">
                            </div>
                            <div class="con">
                              <p>Refer & Get another</p>
                              <h1>1 Year free</h1>
                            </div>
                           <!-- <div class="image">
                              <img src="media/left_arrow.png">
                            </div>-->

                          </div>
                          <div class="cost">
                            <p class="rupee"> <!--<span class="pisa"><img src="media/rupee.png"></span>--><span class="four">0</span></p>
                          </div>
                          <div class="pay">
                              <button class="payy" type="submit" value="1" id="submit-btn1" name="sub1">Subscribe for 1 Year</button>
                            </div>
                        </div>
                      </div>
                    <!--</a>-->
                    <!--<a href="book.html">-->
                      <div class="one three">
                        <div class="sub_inner">
                          <div class="subs">
                            <div class="con">
                              <p>Subscribe for</p>
                              <h1>3 Years</h1>

                            </div>
                            <div class="image small">
                              <img class="arr" src="media/right-arrow.png">
                            </div>
                            <div class="con">
                              <p>Refer & Get another</p>
                              <h1>5 Years free</h1>
                            </div>
                            
                           <!-- <div class="image">
                              <img src="media/left_arrow.png">
                            </div>-->

                          </div>
                          <div class="cost">
                            <p class="rupee"><!--<span class="pisa"><img src="media/rupee.png"></span>--><span class="six">0</span></p>
                          </div>
                          <div class="pay">
                              <button class="payy" type="submit" value="3" id="submit-btn3" name="sub3">Subscribe for 3 Years</button>
                            </div>
                        </div>
                      </div>
                      </form>
                    <!--</a>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--fifth-end-->

                <div class="testimonial_container">
          <div class="testimonial_inner">
           
             <div class="top_content">
              
                <h1>Testimonials</h1>
              </div>
              <div class="bottom_content owl-carousel owl-theme owl-testimonial">
                <div class="bottom_inner">
                  <div class="content">
                
                    <p>I really liked it. It's a best deal I ever received in this product. It's has been delivered in15 hours. Wow.... Thank u so much SANION</p>
                    <h1>Victoria</h1>
 
                    <h3>Web Designer</h3>
                   
                  </div>
                </div>
                  <div class="bottom_inner">
                  <div class="content">
                                      
                    <p>It absorbs good. even after a long time u cannot sense any odour. It does not sog much, it remains firm for around six hours,which I think is good enough.</p>

<h1>Rani</h1>

 
                     <h3>House Wife</h3>
                    
                  </div>
                </div>
                 <div class="bottom_inner">
                  <div class="content">
                                      
                    <p>The product is currently the best in the market - suits most requirements.</p>

   
<h1>Smitha</h1>
 
                     <h3>B.Tech Student</h3>
                    
                  </div>
                </div>
         
               
              </div>
          </div>
        </div>
        <!--testimonial-end-->
        <div class="newslettter_container">
          <div class="news_inner">
            <div class="news left">
              <div class="inner">
                <p>Call Us</p>
                 <h1>+91 7994449934
</h1>
              </div>
            </div>
            <div class="news center">
              <div class="inner incenter">
                <p>Email Us</p>
              <h1>support@sanionindia.com</h1>
              </div>
            </div>
            <!--<div class="news right">
              <div class="inner">
                <p>Subscribe for offers & updates</p>
                <div class="form">
                  <form>
                    <div class="inputfield">
                      <input id="email" type="text" placeholder="Your Email" name="Email">
                    </div>
                    <input type="submit" id="send" class="send" name="Send" value="Subscribe">
                  </form>
                </div>
              </div>
            </div>-->

          </div>
        </div>
        <!--news-end-->
      </div>
    </div>
  </section>
 <footer>
  <div class="footer_main">
    <div class="footer_content">
      <div class="content desk">
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
      <div class="content dis">
        <div class="inner">
          <p>Copyright © 2018 Sanion <span>-</span>  All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </div>
</footer>

        <script>
        $(document).ready(function() {
            
            $('#submit-btn1').click(function() {  
                var a = $(".four").html();
                if(a > 1000) {
                    document.getElementById("form-id").submit();
                } else {
                    $("form").one("click", function(event) {
                      event.preventDefault();
                    });
                    document.getElementById("err-msg").innerHTML = "Total amount should be greater than INR 1000 to place your subscription";
                }
            });
            
            $('#submit-btn3').click(function() {    
                var b = $(".six").html();
                if(b > 3000) {
                    document.getElementById("form-id").submit();
                } else {
                    $("form").one("click", function(event) {
                      event.preventDefault();
                    });
                    document.getElementById("err-msg").innerHTML = "Total amount should be greater than INR 3000 to place your subscription.";
                }
            });
            
        });
        </script>

</body>

</html>
