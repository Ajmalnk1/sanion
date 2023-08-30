var app = new Vue({
  el: '#app',
  data: {
    couponCode: '',
    errr: false,
    suc: false,
    inv: false,
    couponCode_cookie_value: ''
  },
  created: function () {
    // //set cookie to take amount value // this will set in previous state // here is just temp
    // if(!this.$cookies.isKey("amount")) {
    //     this.$cookies.set("amount","1850",60 * 60 * 1); // exp after 1hr
    // }
    
    if(this.$cookies.isKey("discountAmount") && this.$cookies.isKey("couponCode")) {
        document.getElementById("amnt").innerHTML = (this.$cookies.get("discountAmount"));
        this.suc = true;
        document.getElementById("cc_to_post").value = (this.$cookies.get("couponCode_value"));
        document.getElementById("c_c").placeholder = (this.$cookies.get("couponCode_value"));
    }
  },
  methods: {
      validateCoupon (submitEvent) {
          
          this.$cookies.set("couponCode_value",(document.getElementById("c_c").value),60 * 60 * 1); // exp after 1hr
          
            axios.post('https://www.sanionindia.com/verify_discount_code_for_affiliate.php', {
                couponCode: submitEvent.target.elements.cc.value
            })
            .then(function (response) {
                
                if(response.data["status"] == "validation_failed"){
                    app.errr = true;
                    app.suc = false;
                    app.inv = false;
                    
                    this.$cookies.set("couponCode","",1); // exp after 1sec
                    this.$cookies.set("discountAmount",(this.$cookies.get("amount")),60 * 60 * 1); // exp after 1hr
                    document.getElementById("amnt").innerHTML = (this.$cookies.get("amount"));
                    document.getElementById("c_c").placeholder = (this.$cookies.get("couponCode_value"));
                    document.getElementById("cc_to_post").value = '';
                    
                    setTimeout(function() {
                        app.errr = false;
                        app.inv = false;
                    }, 2000);
                }
                
                if(response.data["status"] == "not_valid"){
                    app.inv = true;
                    app.errr = false;
                    app.suc = false;
                    
                    this.$cookies.set("couponCode","",1); // exp after 1sec
                    this.$cookies.set("discountAmount",(this.$cookies.get("amount")),60 * 60 * 1); // exp after 1hr
                    document.getElementById("amnt").innerHTML = (this.$cookies.get("amount"));
                    document.getElementById("c_c").placeholder = (this.$cookies.get("couponCode_value"));
                    document.getElementById("cc_to_post").value = '';
                    
                    setTimeout(function() {
                        app.errr = false;
                        app.inv = false;
                    }, 2000);
                }
                
                if(response.data["status"] == "success") {
                    app.suc = true;
                    app.errr = false;
                    app.inv = false;
                    
                    var temp_amnt = (this.$cookies.get("amount"))-((this.$cookies.get("amount"))/100*5);
                    document.getElementById("amnt").innerHTML = (temp_amnt);
                    
                    this.couponCode_cookie_value = response.data["code"];
                    this.$cookies.set("couponCode",this.couponCode_cookie_value,60 * 60 * 1); // exp after 1hr
                    this.$cookies.set("discountAmount",temp_amnt,60 * 60 * 1); // exp after 1hr
                    document.getElementById("cc_to_post").value = (this.$cookies.get("couponCode_value"));
                }
                
                if(response.data == "error") {
                    app.errr = true;
                    app.inv = false;
                    app.suc = false;
                    this.$cookies.set("couponCode","",1); // exp after 1sec
                    console.log(response);
                    document.getElementById("cc_to_post").value = '';
                }
            })
            .catch(function (error) {
                console.log(error);
            });
      }
  }
});