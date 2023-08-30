<?php
session_start();

if(isset($_SESSION["products_list"]) && isset($_SESSION["user_details"]) && isset($_SESSION["address_details"]) && isset($_SESSION["subscription_plan"]) && isset($_SESSION["amount"]) && isset($_SESSION["order_id"])) {
    $url_order_id = $_SESSION["order_id"];
    require 'FedPay/fedpay.php';
    $fields = new Fedpay( array(
        'user_code' => 'WAGGL',
        'pass_code' => 'WAGGL1448#',
        'hash_key' => '78VTRCJOI08HG453',
        'tran_id'  => time(),
        'amount' => $_SESSION["amount"],
        'charge_code' => 'A',
    ));
    $_SESSION["tran_id_for_payment"] = $fields['tran_id'];

$log_val =  json_encode($_SESSION);


function wh_log($log_msg)
{
    $log_filename = "log";
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}

wh_log($log_val);

} else {
    header('Location: subscribe.php');
}
?>
Please wait while we are transferring you to payment gateway provider .....
<form action="http://epay.federalbank.co.in/FedPaymentsV1/Payments.ashx" method="post" name="merchantForm" id="payment">
    <input type="hidden" value="<?php echo $fields['user_code']; ?>" name="user_code">
    <input type="hidden" value="<?php echo $fields['pass_code']; ?>" name="pass_code">
    <input type="hidden" value="<?php echo $fields['tran_id']; ?>" name="tran_id">
    <input type="hidden" value="<?php echo $fields['amount']; ?>" name="amount">
    <input type="hidden" value="<?php echo $fields['charge_code']; ?>" name="charge_code">
    <input type="hidden" value="<?php echo $fields['hash_value']; ?>" name="hash_value">
    <input type="hidden" value="<?php echo 'http://www.sanionindia.com/payment_return.php?order_id='.$url_order_id; ?>" name="reserve10">
    <input hidden type="submit" value="Pay now" />
</form>

<script type="text/javascript">
    document.getElementById('payment').submit(); // SUBMIT FORM
</script>