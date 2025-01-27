<?php 

  class ShippingMethod extends Db_object {

    protected static $dbTable = "shipping_methods";
    protected static $dbTableFields = array('id', 'name', 'price');

    public $id;
    public $name;
    public $price;

    public function getPriceWithComma(){
      if(floor($this->price) == $this->price) {
        return $this->price .= ',00';
      }else {
        return str_replace('.', ',', $this->price);
      }
    }

  }
