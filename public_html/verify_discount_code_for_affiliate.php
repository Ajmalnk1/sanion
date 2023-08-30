<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'ipdo/config.php';
    include 'ipdo/class.lpdo.php';
    $db = new ipdo($config['Database']);
    $raw = json_decode(file_get_contents('php://input'), true);
    $couponCode = $raw['couponCode'];
    if(($couponCode != "" && $couponCode != " ")) {
        $rs2 = $db->get_rows('affiliate', array('code' => $couponCode));
        if(count($rs2) > 0) {
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