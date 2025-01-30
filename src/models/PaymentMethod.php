<?php 

  class PaymentMethod extends Db_object {

    protected static $dbTable = "payment_methods";
    protected static $dbTableFields = array('id','name');

    public $id;
    public $name;

  }
