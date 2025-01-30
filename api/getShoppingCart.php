<?php

  require_once __DIR__ . '/../src/config/init.php';

  header('Content-Type: application/json');

  echo json_encode($shoppingCart);
