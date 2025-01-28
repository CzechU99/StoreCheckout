<?php 

  class Product extends Db_object {

    protected static $dbTable = "products";
    protected static $dbTableFields = array('id', 'name', 'price', 'created_at');

    public $id;
    public $name;
    public $price;
    public $created_at;

  }
