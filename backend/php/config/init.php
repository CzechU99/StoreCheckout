<?php 

  require_once __DIR__ . '/newDbConfig.php';
  require_once __DIR__ . '/Database.php';
  require_once __DIR__ . '/DbObject.php';
  require_once __DIR__ . '/ShoppingCart.php';
  require_once __DIR__ . '/../models/User.php';
  require_once __DIR__ . '/../models/ShippingAddress.php';
  require_once __DIR__ . '/../models/ShippingMethod.php';
  require_once __DIR__ . '/../models/Product.php';
  require_once __DIR__ . '/../models/PaymentMethod.php';
  require_once __DIR__ . '/../models/Order.php';
  require_once __DIR__ . '/../models/OrderDetails.php';
  require_once __DIR__ . '/../models/DiscountCode.php';
  require_once __DIR__ . '/../models/PaymentShipping.php';
  require_once __DIR__ . '/../functions/validation.php';

  global $database;
  $database = new Database();

  //shopping cart init - ([productId, productId], [productQuantity, productQuantity])
  $shoppingCart = new ShoppingCart([1, 2], [1, 3]);

  