<?php 

  defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
  define('SITE_ROOT', DS . 'xampp' . DS . 'htdocs' . DS . 'smartbees');
  defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'includes');

  require_once("new_config.php");
  require_once("database.php");
  require_once("db_object.php");
  require_once("user.php");
  require_once("shipping_address.php");
  require_once("shipping_method.php");
  require_once("product.php");
  require_once("payment_method.php");
  require_once("order.php");
  require_once("order_details.php");
  require_once("discount_code.php");
  require_once("shopping_cart.php");
  require_once("payment_shipping.php");

  //shopping cart init - ([productId, productId], [productQuantity, productQuantity])
  $shoppingCart = new ShoppingCart([1, 2], [1, 3]);

  