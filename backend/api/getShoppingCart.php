<?php

  require_once __DIR__ . '/../php/config/init.php';

  header('Content-Type: application/json');

  echo json_encode($shoppingCart);
