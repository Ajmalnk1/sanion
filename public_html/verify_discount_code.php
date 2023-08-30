<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'ipdo/config.php';
    include 'ipdo/class.lpdo.php';
    $db = new ipdo($config['Database']);
    $table_referrals = 'referrals';
    $raw = json_decode(file_get_contents('php://input'), true);
    $couponCode = $raw['couponCode'];
    if(($couponCode != "" && $couponCode != " ")) {
        $condition = array('code' => $couponCode, 'status' => 'active', 'count' => array(0, '>'));
        $rs = $db->get_rows($table_referrals, $condition);
        if(count($rs) > 0) {
            $coupon_code_from_db = $rs[0]["code"];
        }
        if($couponCode == $coupon_code_from_db) {   
            $cc_md5 = md5($couponCode);
            $s_array = array("status"=>"success", "code"=>"$cc_md5");
            $data = json_encode($s_array);
        } else {
            $v_array = array("status"=>"not_valid");
            $data = json_encode($v_array);
        }
    } else {
        $f_array = array("status"=>"validation_failed");
        $data = json_encode($f_array);
    }
} else {
    $data = "POST Req";
}
echo ($data);