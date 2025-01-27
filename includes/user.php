<?php 

  class User extends Db_object {

    protected static $dbTable = "users";
    protected static $dbTableFields = array('id', 'email', 'password', 'name', 'surname', 'phone', 'address', 'city', 'postal_code', 'newsletter', 'created_at');

    public $id;
    public $email;
    public $password;
    public $name;
    public $surname;
    public $phone;
    public $address;
    public $city;
    public $postal_code;
    public $newsletter;
    public $created_at;

  }
