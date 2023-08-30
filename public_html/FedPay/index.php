<?php
require './fedpay.php';
 
// Test
// $fields = new Fedpay( array(
//     'user_code' => 'WAGGT',
//     'pass_code' => 'WAGG1448#',
//     'hash_key' => 'W5A54365G294G32T',
//     'tran_id'  => '_testMode_' .time(),
//     'amount' => '10.50',
//     'charge_code' => 'A',
// ));

// Prod
$fields = new Fedpay( array(
    'user_code' => 'WAGGL',
    'pass_code' => 'WAGGL1448#',
    'hash_key' => '78VTRCJOI08HG453',
    'tran_id'  => time(),
    'amount' => '01.00',
    'charge_code' => 'A',
));

 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fed sample epay</title>
    </head>
    <body>
        You are going pay <?php echo number_format( $fields['amount']/100 , 2 ); ?> Rs
        <form action="https://epay.federalbank.co.in/FedPaymentsV1/Payments.ashx" method="post" name="merchantForm">
            <input type="hidden" value="<?php echo $fields['user_code']; ?>" name="user_code">
            <input type="hidden" value="<?php echo $fields['pass_code']; ?>" name="pass_code">
            <input type="hidden" value="<?php echo $fields['tran_id']; ?>" name="tran_id">
            <input type="hidden" value="<?php echo $fields['amount']; ?>" name="amount">
            <input type="hidden" value="<?php echo $fields['charge_code']; ?>" name="charge_code">
            <input type="hidden" value="<?php echo $fields['hash_value']; ?>" name="hash_value">
            <input type="hidden" value="<?php echo "https://www.sanionindia.com/FedPay/return.php?order_id=someid"; ?>" name="reserve10">
            <input type="submit" value="Pay now" />
        </form>
    </body>
</html>