<!DOCTYPE html>
<html lang="en">
<head>
  <title>Coupon</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link href="http://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
  <link href="css/odometer-theme-minimal.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="container mt-5" id="app">
    <div class="row">
        <div class="col-md-4">
            <p><b>Amount : INR <span class="odometer" id="amnt">1850</span></b></p>
            <form @submit.prevent="validateCoupon">
              <div class="form-group">
                <label for="c_c">Coupon Code (mano):</label>
                <input type="text" class="form-control" id="c_c" name="cc">
              </div>
              <transition name="custom-classes-transition" enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutRight">
                    <p v-if="errr" style="color: red; margin-bottom: 20px" >Please enter the coupon code</p>
                    <p v-if="suc" style="color: green; margin-bottom: 20px" >Coupon Code is Valid, Now Enjoy Extra 5% Discount.</p>
                    <p v-if="inv" style="color: red; margin-bottom: 20px" >Entered Coupon Code is In-Valid</p>
                </transition>
              <button type="submit" class="btn btn-primary">Validate</button>
            </form>
        </div>
    </div>
</div>
    <script src="http://cdn.jsdelivr.net/npm/vue"></script>
    <script src="http://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="http://unpkg.com/vue-cookies@1.5.7/vue-cookies.js"></script>
    <script src="js/odometer.min.js"></script>
    <script src="js/app.js?<?php echo time(); ?>"></script>
</body>
</html>
