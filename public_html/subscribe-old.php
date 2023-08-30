<?php
session_start();
session_unset(); 
?>

<?php
include 'ipdo/config.php';
include 'ipdo/class.lpdo.php';
$db = new ipdo($config['Database']);

if(isset($_GET["ref"]) && $_GET["ref"] != "") {
    $condition_for_ref_code = array('code' => $_GET["ref"]);
    $ref_name_from_db = $db->get_rows('affiliate', $condition_for_ref_code);
    if(count($ref_name_from_db) > 0) {
        $_SESSION["ref"] = $ref_name_from_db[0]["name"];
    } else {
        $_SESSION["ref"] = $_GET["ref"];
    }
} else {
  $_SESSION["ref"] = "";
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
    if($total_cost_for_sp > 1000) {
        echo "<script> location.replace('http://www.sanionindia.com/user-details.php'); </script>";
    } else {
        echo "<script> alert('Total amount should be greater than INR 1000 to place your subscription.'); </script>";
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
  <link rel="canonical" href="http://www.sanionindia.com/">

  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/owl.carousel.min.js"></script>

  <link rel="stylesheet" type="text/css" href="dist/css/min_css/subscribe.css">
  <link rel="stylesheet" type="text/css" href="dist/css/min_css/carousel.min.css">

  <script type="text/javascript" src="app/js/main.js"></script>
  <script type="text/javascript" src="app/js/subscribe.js"></script>

  <style>
  .btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
    background-color: #ebecec;
  }
  .btn-circle.btn-lg {
    width: 50px;
    height: 50px;
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 25px;
  }
  .btn-circle.btn-xl {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    font-size: 24px;
    line-height: 1.33;
    border-radius: 35px;
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
      <div class="fifth_container subs">
        <div class="over"></div>
        <div class="fifth_inner">
          <div class="fifth_content">
            <div class="top_content">
              <h1>Your days, Your Choice</h1>
              <button class="anion select" href="#">Anion</button>
              <button class="herbal" href="#">Herbal</button>

            </div>
            <form action="http://www.sanionindia.com/subscribe.php<?php if(isset($_SESSION["ref"])) { echo "?ref=".$_SESSION["ref"]; } ?>"  method="post">
              <div class="bottom_content herbalcon">
                <div class="bottom_inner">

                  <?php
                  include 'config.php';

                  $sql = "SELECT * FROM product_details where product_name='Herbal'";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {  
                    while($row = mysqli_fetch_assoc($result)) {
                      $output.= "<div class='size'>";
                      $output.= "<div class='image'>";
                      $output.= "<img src='media/".$row["id"].".png'>";
                      $output.= "</div>";
                      $output.= "<div class='con'>";
                      $output.= "<h1>".$row["size"]."</h1>";
                      $output.= "<p>₹ ".$row["cost"]."   </p>";
                      $output.= "<div>";
                      $output.= "<input hidden type='text' name='product".$row["id"]."' value='".$row["product_name"]." - ".$row["size"]."'>";
                      $output.= "<button type='button' id='sub2' class='sub' style='background-color: #fff;    border-radius: 100px;    border: 1px solid #bbb;    height: 40px;    width: 40px;    font-size: 20px;'>-</button>";
                      $output.= "<input type='text' id='".$row["id"]."' value='0' name='quantity".$row["id"]."' class='field' style='border: none;    width: 50px;    margin-left: 30px;    font-size: 35px;    color: #9f70ad;    font-weight: 500;' />";
                      $output.= "<button type='button' id='add2' class='add' style='background-color: #fff;    border-radius: 100px;    border: 1px solid #bbb;    height: 40px;    width: 40px;    font-size: 20px;'>+</button>";
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
                      $output2.= "<div class='image'>";
                      $output2.= "<img src='media/".$row["id"].".png'>";
                      $output2.= "</div>";
                      $output2.= "<div class='con'>";
                      $output2.= "<h1>".$row["size"]."</h1>";
                      $output2.= "<p>₹ ".$row["cost"]."   </p>";
                      $output2.= "<div>";
                      $output2.= "<input hidden type='text' name='product".$row["id"]."' value='".$row["product_name"]." - ".$row["size"]."'>";
                      $output2.= "<button type='button' id='sub2' class='sub' style='background-color: #fff;    border-radius: 100px;    border: 1px solid #bbb;    height: 40px;    width: 40px;    font-size: 20px;'>-</button>";
                      $output2.= "<input type='text' id='".$row["id"]."' value='0' name='quantity".$row["id"]."' class='field' style='border: none;    width: 50px;    margin-left: 30px;    font-size: 35px;    color: #9f70ad;    font-weight: 500;' />";
                      $output2.= "<button type='button' id='add2' class='add' style='background-color: #fff;    border-radius: 100px;    border: 1px solid #bbb;    height: 40px;    width: 40px;    font-size: 20px;'>+</button>";
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
              <div class="button">
                <h1>No.of pads selected per month</h1>
                <button class="year"> <span class="quan">0</span>
                  <!--<p class="color">PER MONTH</p>-->
                </button>
              </div>

              <!--<button class="cal">Calculate</button>-->

              <div class="subscribe">
                <div class="inner">
                  <div class="sub_content">
                    <!--<a href="book.html">-->
                      <div class="one">
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
                              <p>Get</p>
                              <h1>5% Discount</h1>
                            </div>
                            <div class="image">
                              <!--<button type="submit" value="1" name="sub1" class="btn btn-default btn-circle btn-lg"><i class="fa fa-long-arrow-right"></i></button>-->
                              <!--<button type="submit" value="1" name="sub1">Sub 1</button>-->
                              <!--<img src="media/left_arrow.png">-->
                            </div>
                          </div>
                          <div class="cost">
                            <p class="rupee">Cost of 1 Year <span class="pisa"><img src="media/rupee.png"></span><span class="onee">0</span>

                            </p>
                            <span>(Incl. of 5% discount)</span>
                            <div class="pay">
                              <button class="payy" type="submit" value="1" name="sub1" >Subscribe & Pay</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--</a>-->
                      <!--<a href="book.html">-->
                        <div class="one two">
                          <div class="sub_inner">
                            <div class="subs">
                              <div class="con">
                                <p>Subscribe for</p>
                                <h1>2 Years</h1>

                              </div>
                              <div class="image small">
                                <img class="arr" src="media/right-arrow.png">
                              </div>
                              <div class="con">
                                <p>Refer & Get another</p>
                                <h1>2 Years</h1>
                              </div>
                              <div class="image">
                                <!--<button type="submit" value="2" name="sub2" class="btn btn-default btn-circle btn-lg"><i class="fa fa-long-arrow-right"></i></button>-->
                                <!--<img src="media/left_arrow.png">-->
                              </div>

                            </div>
                            <div class="cost">
                              <p class="rupee">Cost of 2 Years <span class="pisa"><img src="media/rupee.png"></span><span class="four">0</span></p>
                              <div class="pay">
                                <button class="payy" type="submit" value="2" name="sub2" >Subscribe & Pay</button>
                              </div>
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
                                  <h1>5 Years</h1>
                                </div>
                                <div class="image">
                                  <!--<button type="submit" value="3" name="sub3" class="btn btn-default btn-circle btn-lg"><i class="fa fa-long-arrow-right"></i></button>-->
                                  <!--<img src="media/left_arrow.png">-->
                                
                              </div>

                            </div>
                            <div class="cost">
                              <p class="rupee">Cost of 3 Years <span class="pisa"><img src="media/rupee.png"></span><span class="six">0</span></p>
                              <div class="pay">
                                <button class="payy" type="submit" value="3" name="sub3" >Subscribe & Pay</button>
                              </div>
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

            <div class="newslettter_container">
              <div class="news_inner">
                <div class="news left">
                  <div class="inner">
                    <p>Call Us</p>
                    <h1>+91 98098 89999
                    </h1>
                  </div>
                </div>
                <div class="news center">
                  <div class="inner">
                    <p>Email Us</p>
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
                <p>Copyright © 2018 Sanion <span>-</span> All Rights Reserved.</p>
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

