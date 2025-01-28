<?php 

  class DiscountCode extends Db_object {

    protected static $dbTable = "discount_codes";
    protected static $dbTableFields = array('id', 'code', 'discount_percent', 'valid_until');

    public $id;
    public $code;
    public $discount_percent;
    public $valid_until;

  }
