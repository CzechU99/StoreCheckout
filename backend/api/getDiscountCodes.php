<?php

  require_once __DIR__ . '/../php/config/init.php';

  header('Content-Type: application/json');

  $discountCodes = DiscountCode::find_all();

  $validCodes = [];

  foreach($discountCodes as $code){
    if($code->valid_until >= date('Y-m-d H:i:s')){
      array_push($validCodes, $code);
    }
  }

  echo json_encode($validCodes);
