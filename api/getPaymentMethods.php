<?php

  require_once __DIR__ . '/../src/config/init.php';

  header('Content-Type: application/json');

  $paymentMethods = PaymentMethod::find_all();

  echo json_encode($paymentMethods);
