<?php

  require_once('init.php');

  $data = file_get_contents('php://input');
  $orderData = json_decode($data, true);

  if($orderData){

    $userEmail = $orderData['orderData']['user']['email'];
    $userName = $orderData['orderData']['user']['name'];
    $userSurname = $orderData['orderData']['user']['surname'];
    $userCountry = $orderData['orderData']['user']['country'];
    $userAddress = $orderData['orderData']['user']['address'];
    $userPostalCode = $orderData['orderData']['user']['postalCode'];
    $userCity = $orderData['orderData']['user']['city'];
    $userPhone = $orderData['orderData']['user']['phone'];
    $userPassword = $orderData['orderData']['user']['password']; 
    $userPlainPassword = $orderData['orderData']['user']['plainPassword']; 
    $userNewsletter = $orderData['orderData']['user']['newsletter'];

    $shippingAddress = $orderData['orderData']['shippingAddress']['address'];
    $shippingCity = $orderData['orderData']['shippingAddress']['city'];
    $shippingPostalCode = $orderData['orderData']['shippingAddress']['postalCode'];

    $deliveryMethod = $orderData['orderData']['shippingMethod'];
    $paymentMethod = $orderData['orderData']['paymentMethod'];
    $comment = $orderData['orderData']['comment'];
    $createdAt = $orderData['orderData']['createdAt'];

    foreach($orderData['shoppingCart']['shoppingCart'] as $id => $product){
      $listOfProducts[$id] = [
          'id' => $product['product']['id'],
          'name' => $product['product']['name'],
          'price' => $product['product']['price'],
          'quantity' => $product['quantity'],
          'created_at' => $product['product']['created_at']
        ];
    }

    $user = new User();
    $user->email = $userEmail;
    $user->password = $userPassword;
    $user->name = $userName;
    $user->surname = $userSurname;
    $user->phone = $userPhone;
    $user->address = $userAddress;
    $user->city = $userCity;
    $user->postal_code = $userPostalCode;
    $user->newsletter = $userNewsletter;
    $user->created_at = $createdAt;

    $user->create();
    $user->id = $database->the_insert_id();

    $shippingAddress = new ShippingAddress();
    $shippingAddress->user_id = $user->id;
    $shippingAddress->address = $userAddress;
    $shippingAddress->city = $userCity;
    $shippingAddress->postal_code = $userPostalCode;

    $shippingAddress->create();
    $shippingAddress->id = $database->the_insert_id();

    $order = new Order();
    $order->user_id = $user->id;
    $order->total_price = $orderData['shoppingCart']['totalPrice'];
    $order->created_at = $createdAt;
    $order->comment = $comment;
    $order->discount_code_id = 1;
    $order->shipping_method_id = $deliveryMethod;
    $order->payment_method_id = $paymentMethod;

    $order->create();
    $order->id = $database->the_insert_id();

    foreach($listOfProducts as $id => $product){

      $orderDetails = new OrderDetails();
      $orderDetails->order_id = $order->id;
      $orderDetails->product_id = $product['id'];
      $orderDetails->quantity = $product['quantity'];
      $orderDetails->price = $product['price'];

      $orderDetails->create();
      $orderDetails->id = $database->the_insert_id();

    }

    $datePart = date('Ymd');
    $randomPart = rand(1000, 9999);
    $orderNumber = '#' . $datePart . '-' . $order->id . '-' . $randomPart;

    echo json_encode([
      'status' => 'success',
      'message' => 'Dane zamowienia zostaly przetworzone.',
      'orderNumber' => $orderNumber
    ]);

  }else{

    echo json_encode([
      'status' => 'error',
      'message' => 'Nieprawidłowe dane wejściowe.',
    ]);

  } 
