<?php 

  class OrderDetails extends Db_object {

    protected static $dbTable = "order_details";
    protected static $dbTableFields = array('id', 'order_id', 'product_id', 'quantity', 'price');

    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $price;

  }
