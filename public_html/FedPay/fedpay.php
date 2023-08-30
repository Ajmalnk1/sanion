<?php
 
class Fedpay extends \ArrayObject
{
    /**
     * Construct a new array object
     */
    function __construct( $input ){
        parent::__construct( $input , self::ARRAY_AS_PROPS);
        $this->setPriceInPissa();
        $this->setPrefixTranId();
        $this->setHash();
    }
 
    /**
     * Amount to mix in hash logic, we ajax call from client side to pass hash key
     *
     * @param type $amount
     */
    private function setHash()
    {
        $p = $this;
        $string = implode('|', array(
            $p['user_code'] ,
            $p['pass_code'] ,
            $p['tran_id'] ,
            $p['amount'] ,
            $p['charge_code'] ,
            $p['hash_key']
        ));
        $this['hash_value'] = base64_encode(sha1( $string , true ) );
    }
 
    /**
     * Amount to mix in hash logic, we ajax call from client side to pass hash key
     *
     * @param type $amount
     */
    private function setPrefixTranId()
    {
        $this['tran_id'] = $this['user_code'] . $this['tran_id'];
    }
 
    /**
     * Amount to mix in hash logic, we ajax call from client side to pass hash key
     *
     * @param type $amount
     */
    private function setPriceInPissa()
    {
        $this['amount'] = floatval( $this['amount'] ) * 100 ;
    }
 
}