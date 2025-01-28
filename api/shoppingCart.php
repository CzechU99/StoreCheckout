<?php

  require_once __DIR__ . '/../includes/init.php';

  header('Content-Type: application/json');

  echo json_encode($shoppingCart);
