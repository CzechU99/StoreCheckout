<?php

  require_once __DIR__ . '/../includes/init.php';

  header('Content-Type: application/json');

  $discountCode = new DiscountCode();
  $discountCodes = $discountCode->find_all();

  $validCodes = [];

  foreach($discountCodes as $code){
    if($code->valid_until >= date('Y-m-d H:i:s')){
      array_push($validCodes, $code);
    }
  }

  echo json_encode($validCodes);
