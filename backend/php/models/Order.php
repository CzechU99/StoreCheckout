<?php 

  class Order extends Db_object {

    protected static $dbTable = "orders";
    protected static $dbTableFields = array('id', 'user_id', 'total_price', 'created_at', 'comment', 'discount_code_id', 'shipping_method_id', 'payment_method_id');

    public $id;
    public $user_id;
    public $total_price;
    public $created_at;
    public $comment;
    public $discount_code_id;
    public $shipping_method_id;
    public $payment_method_id;

  }
