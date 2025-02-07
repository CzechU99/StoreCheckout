<?php 

  class PaymentShipping extends Db_object {

    protected static $dbTable = "payment_shipping";
    protected static $dbTableFields = array('payment_method_id','shipping_method_id');

    public $payment_method_id;
    public $shipping_method_id;

  }
