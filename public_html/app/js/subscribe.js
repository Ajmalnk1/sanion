$(document).ready(function() {
    $(".add").click(function() {
        var aa = 15,
            ab = 20,
            ac = 26,
            ad = 5;

        var ha = 10,
            hb = 15,
            hc = 20,
            hd = 3;

        var one = 12,
        two = 12,
            three = 36;

        var rega = $('#5').val(),
            xla = $('#6').val(),
            ona = $('#7').val(),
            pla = $('#8').val();

        var regh = $('#1').val(),
            xlh = $('#2').val(),
            onh = $('#3').val(),
            plh = $('#4').val();

        var temp1 = (rega * aa) + (xla * ab) + (ona * ac) + (pla * ad);
        var temp2 = (regh * ha) + (xlh * hb) + (onh * hc) + (plh * hd);
        
        var totala =  temp1 + temp2;
        
        
        $('.quan').html(parseInt(rega) + parseInt(xla) + parseInt(ona) + parseInt(pla) + parseInt(regh) + parseInt(xlh) + parseInt(onh) + parseInt(plh));

        //$('.onee').val((rega * aa) + (xla * ab) + (ona * ac) + (pla * ad) + (regh * ha) + (xlh * hb) + (onh * hc) + (plh * hd));
        
        var f1 = totala * two;
        var o1 = totala * one;
        var s1 = totala * three;
        
        $('.four').html(f1);
        $('.onee').html(o1);

        $('.six').html(s1);
    });
    $(".sub").click(function() {
        var aa = 15,
            ab = 20,
            ac = 26,
            ad = 5;

        var ha = 10,
            hb = 15,
            hc = 20,
            hd = 3;

        var one = 12,
        two = 12,
            three = 36;

        var rega = $('#5').val(),
            xla = $('#6').val(),
            ona = $('#7').val(),
            pla = $('#8').val();

        var regh = $('#1').val(),
            xlh = $('#2').val(),
            onh = $('#3').val(),
            plh = $('#4').val();

        var temp1 = (rega * aa) + (xla * ab) + (ona * ac) + (pla * ad);
        var temp2 = (regh * ha) + (xlh * hb) + (onh * hc) + (plh * hd);
        
        var totala =  temp1 + temp2;
        
        
        $('.quan').html(parseInt(rega) + parseInt(xla) + parseInt(ona) + parseInt(pla) + parseInt(regh) + parseInt(xlh) + parseInt(onh) + parseInt(plh));

        //$('.onee').val((rega * aa) + (xla * ab) + (ona * ac) + (pla * ad) + (regh * ha) + (xlh * hb) + (onh * hc) + (plh * hd));
        
        var f1 = totala * two;
        var o1 = totala * one;
        var s1 = totala * three;
        
        $('.four').html(f1);
        $('.onee').html(o1);

        $('.six').html(s1);
    });

});