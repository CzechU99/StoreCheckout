<?php 

  class ShippingAddress extends Db_object {

    protected static $dbTable = "shipping_addresses";
    protected static $dbTableFields = array('id', 'user_id', 'address', 'city', 'postal_code');

    public $id;
    public $user_id;
    public $address;
    public $city;
    public $postal_code;

  }
