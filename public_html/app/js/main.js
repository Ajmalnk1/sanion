$(document).ready(function() {
  $(".anion").click(function() {
    $(".anion").addClass('select');
    $(".herbal").removeClass('select');
    $(".disable").css('display', 'none');
  });

  $(".herbal").click(function() {
    $(".herbal").addClass('select');
    $(".anion").removeClass('select');
    $(".disable").css('display', 'block');
  });

   $('.mob_menu').click(function() {
    $('.sub_menumob').css("z-index", "5000");
    $('.sub_menumob').css("opacity", "1");
    $('.sub_menumob').css("transition", " 0.35s ease");
    $('.sub_menumob').css("top", "0");
    $('.sub_menumob').css("transition", " 0.35s ease");
  });

  $('.sub_close').click(function() {
    $('.sub_menumob').css("z-index", "0");
    $('.sub_menumob').css("opacity", "0");
    $('.sub_menumob').css("transition", " 0.05s ease");
    $('.sub_menumob').css("top", "-2000px");
    $('.sub_menumob').css("transition", " 0.05s ease");
  });

  $('.submenu').mouseleave(function() {
    $(this).css("top", "-600px");
    $(this).css("transition", " 1s ease");
  });

$(".anion").click(function() {
      $(".herbalcon").css('display', 'none');
      $(".anioncon").css('display', 'block');    
    });

$(".herbal").click(function() {
      $(".anioncon").css('display', 'none');
      $(".herbalcon").css('display', 'block');    
    });



  $(".nextfirst").click(function() {
      $(".section_one").css('display', 'none');
      $(".section_two").css('display', 'block');    
    });
     $(".nextsecond").click(function() {
      $(".section_two").css('display', 'none');
      $(".section_three").css('display', 'block');
        });

      $(".nextthird").click(function() {
      $(".section_three").css('display', 'none');
      $(".section_four").css('display', 'block');   
        });

         $(".prefirst").click(function() {
      $(".section_three").css('display', 'none');
      $(".section_two").css('display', 'none');
       $(".section_one").css('display', 'block');
      
    });
     $(".presecond").click(function() {
      $(".section_two").css('display', 'block');
      $(".section_one").css('display', 'none');
       $(".section_three").css('display', 'none');
      
    });
      $(".prethird").click(function() {
      $(".section_two").css('display', 'none');
      $(".section_one").css('display', 'none');
      $(".section_four").css('display', 'none');
       $(".section_three").css('display', 'block');
      
    });
    


      $('.add').click(function () {
    $(this).prev().val(+$(this).prev().val() + 1);
});
$('.sub').click(function () {
    if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
});

jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});


jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplussss').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminussss").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});




   $('.owl-testimonial').owlCarousel({
    loop: true,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 4000,
    navSpeed: 600,
    autoplaySpeed: 600,
    dotsSpeed: 600,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 1
      },
      1000: {
        items: 1
      },
      1200: {
        items: 1
      }
    }
  });

  });