<?php

  require_once __DIR__ . '/../php/config/init.php';

  header('Content-Type: application/json');

  $shippingMethods = ShippingMethod::find_all(); 

  $sql = 
    "SELECT sm.id, sm.name, sm.price, pm.id as payment_id, pm.name as pm_name 
    FROM shipping_methods sm 
    JOIN payment_shipping ps ON sm.id = ps.shipping_methods_id 
    JOIN payment_methods pm ON ps.payment_method_id = pm.id;";

  $results = $database->query($sql);

  $finalShippingMethods = [];

  foreach($shippingMethods as $method){
    $finalShippingMethods[] = [
      'id' => $method->id,
      'name' => $method->name,
      'price' => $method->price,
      'payments' => []
    ];
  }

  foreach($results as $row){
    foreach($finalShippingMethods as &$method){
      if($method['id'] == $row['id']){
        $method['payments'][] = [
          'id' => $row['payment_id'],
          'name' => $row['pm_name']
        ];
      }
    }
  }

  echo json_encode($finalShippingMethods); 
