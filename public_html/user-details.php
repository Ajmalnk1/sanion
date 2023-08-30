<?php
   session_start();
   
   if(isset($_SESSION["products_list"]) && (count($_SESSION["products_list"]) > 0)) {
       $product_list = array();
       $product_list = $_SESSION["products_list"];
       $f_name = $l_name = $email = $mobile = $dob = "";
       
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
           $f_name = $_POST["f_name"];
           $l_name = $_POST["l_name"];
           $email = $_POST["email"];
           $mobile = $_POST["mobile"];
           $dob = $_POST["dob"];
           $password = $_POST["password"];
           $confirm_password = $_POST["confirm-password"];
           
           if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
               if($f_name == "" || $l_name == "" || $email == "" || $mobile == "" || $dob == "" || $password == "" || $confirm_password == "") {
                   echo "<p style='color: red'>Kindly fill all the mandatory feilds</p>";
               } else {
                   if ($password == $confirm_password) {
                       $user_details = array();
                       $user_details["name"] = $f_name." ".$l_name;
                       $user_details["f_name"] = $f_name;
                       $user_details["l_name"] = $l_name;
                       $user_details["email"] = $email;
                       $user_details["mobile"] = $mobile;
                       $user_details["dob"] = $dob;
                       $user_details["password"] = password_hash($password, PASSWORD_DEFAULT);
                       //$user_details["gender"] = $gender;
                       $_SESSION["user_details"] = $user_details;
                       //print_r($_SESSION["user_details"]);
                       $flag = "end";
                   } else {
                       $error = "Password & Confirm Password not matching";
                   }
               }
               if($flag == "end"){ 
                echo "<script> location.replace('http://www.sanionindia.com/address-details.php'); </script>";
               }
           } else {
               $error = "Kindly fill the valid email id.";
           }
       }
       
   } else {
       session_unset();
       $product_list = array();
       $error = "Select Product from subscription page.";
       echo "<script> location.replace('http://www.sanionindia.com/subscribe.php'); </script>";
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
      <link href="http://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/owl.carousel.min.js"></script>
      <script src="http://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
      <link rel="stylesheet" type="text/css" href="dist/css/min_css/form.css">
      <link rel="stylesheet" type="text/css" href="dist/css/min_css/dhtmlxcalendar.css" />
      <link rel="stylesheet" type="text/css" href="dist/css/min_css/carousel.min.css">
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script type="text/javascript" src="app/js/main.js"></script>
      <script type="text/javascript" src="app/js/moment.js"></script>
      <script type="text/javascript" src="app/js/combodate.js"></script>
      <script>
         $(function() {
           $('#date').combodate({
             firstItem: 'name',
             minYear: 1950,
             maxYear: 2018
           });
         });
      </script>
      <style>
          #form_submit:disabled {
    display: inline-block;
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
    background-color: #bfa7c6 !important;
    outline: 0;
  }
      </style>
   </head>
   <body style="overflow-x:hidden;">
      <header>
         <div class="main_navigation">
            <div class="zoom">
               <div class="logo_holder">
                  <a href="index.html" class="logo">
                  <img src="media/logo.png" alt="sanion_logo">
                  </a>
               </div>
               <div class="mob_navigation">
                  <button class="butmenu mob_menu" data-ripple-color="#f5f5f5" id="onclick">
                     <span>
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px"
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
                     <h1>Please provide your details to sign up<small style='font-size: 50%'><p>If you're an existing customer, <a style='color: white; text-decoration: underline' href='/u-m'>Click Here</a> to Login</p></small></h1>
                  </div>
                  <div class="section_one section">
                     <form class="form request" action="http://www.sanionindia.com/user-details.php"  method="post">
                        <div class="form-group row">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <input class="form-control" type="text" placeholder="First Name *" id="f_name" name="f_name" value="<?php echo $f_name; ?>" required>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <input class="form-control" type="text" placeholder="Last Name *" id="l_name" name="l_name" value="<?php echo $l_name; ?>" required>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <!--  <input id="afromdate" class="form-control date afromdate" type="text" name="afromdate" placeholder="Select your Date" name="Date" />-->
                              <!--  <input type="text" class="form-control date afromdate" id="datepicker" placeholder="Select your Date *" name="dob" required>-->
                              <div class="ui calendar" id="example2"style=" display: inline-block;
                                 border-radius: 0;
                                 border: none;
                                 border-bottom: 1px solid #d3d3d3;
                                 font-size: 14px;
                                 font-family: Muli,sans-serif;
                                 letter-spacing: .6px;
                                 color: #000;
                                 font-weight: 600;
                                 margin-bottom: 35px;
                                 float: left;
                                 position: relative;
                                 width: 100%;
                                 ">
                                 <div class="dateDropdown">
                                    <label for="dateField1">Date of Birth:</label>
                                    <input class="date" type="text" id="date" data-format="DD-MM-YYYY" data-template="D MMM YYYY" name="dob" value="<?php echo $dob; ?>" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <input class="form-control" type="text" placeholder="Phone Number *" id="tel" name="mobile" pattern="[6789][0-9]{9}" title="Enter valid mobile number" value="<?php echo $mobile; ?>" required />
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <input class="form-control" type="email" placeholder="Email Address *" id="email" title="Enter valid Email" name="email" value="<?php echo $email; ?>" required />
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <input class="form-control" type="password" placeholder="Password *" id="password" title="Enter password" name="password" required />
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <input class="form-control" type="password" placeholder="Confirm Password *" id="c_password" title="Enter same password" name="confirm-password" required />
                              <p style="text-align: left; color: red;"><?php if($error != "") { echo $error; } ?></p>
                           </div>
                        </div>
                        <p class='float-left' style="color: red" id="err_para"></p>
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
                           outline: 0;" type="submit" value="Next" id="form_submit">
                     </form>
                  </div>
               </div>
               <div class="newslettter_container">
                  <div class="news_inner">
                     <div class="news left">
                        <div class="inner">
                           <p>Call Us</p>
                           <h1>+91 98098 89999</h1>
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
      <script>
        $(document).ready(function() {
            $("#form_submit").click(function() {
                if(($('#f_name').val()) == "") {
                    document.getElementById("err_para").innerHTML = "kindly fill the first name";
                } else {
                    if(($('#l_name').val()) == "") {
                        document.getElementById("err_para").innerHTML = "kindly fill the last name";
                    } else {
                        if(($('#date').val()) == "") {
                            document.getElementById("err_para").innerHTML = "kindly select the date of birth";
                        } else {
                            if(($('#tel').val()) == "") {
                                document.getElementById("err_para").innerHTML = "kindly fill the mobile number";
                            } else {
                                if(($('#email').val()) == "") {
                                    document.getElementById("err_para").innerHTML = "kindly fill the email id";
                                } else {
                                    if(($('#password').val()) == "") {
                                        document.getElementById("err_para").innerHTML = "kindly fill the password";
                                    } else {
                                        if(($('#c_password').val()) == "") {
                                            document.getElementById("err_para").innerHTML = "kindly fill the confirm password";
                                        } else {
                                            document.getElementById("err_para").innerHTML = "";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                // if(($('#date').val()) == "") {
                //     document.getElementById("err_para").innerHTML = "kindly select date of birth";
                // } else {
                //     document.getElementById("err_para").innerHTML = "";
                // }
            });
        });
        </script>
   </body>
</html>