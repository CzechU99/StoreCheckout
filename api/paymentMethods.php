<?php

  require_once __DIR__ . '/../includes/init.php';

  header('Content-Type: application/json');

  $paymentMethod = new PaymentMethod();
  $paymentMethods = $paymentMethod->find_all();

  echo json_encode($paymentMethods);
