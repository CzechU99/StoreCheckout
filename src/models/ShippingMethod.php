<?php 

  class ShippingMethod extends Db_object {

    protected static $dbTable = "shipping_methods";
    protected static $dbTableFields = array('id', 'name', 'price');

    public $id;
    public $name;
    public $price;

  }
