<?php

  require_once('init.php');

  $data = file_get_contents('php://input');
  $orderData = json_decode($data, true);

  if($orderData){

    $userEmail = $orderData['user']['email'];
    $userName = $orderData['user']['name'];
    $userSurname = $orderData['user']['surname'];
    $userCountry = $orderData['user']['country'];
    $userAddress = $orderData['user']['address'];
    $userPostalCode = $orderData['user']['postal_code'];
    $userCity = $orderData['user']['city'];
    $userPhone = $orderData['user']['phone'];
    $userPassword = $orderData['user']['password']; 
    $userPlainPassword = $orderData['user']['plainPassword']; 
    $userNewsletter = $orderData['user']['newsletter'];

    $shippingAddress = $orderData['shippingAddress']['address'];
    $shippingCity = $orderData['shippingAddress']['city'];
    $shippingPostalCode = $orderData['shippingAddress']['postal_code'];

    $deliveryMethod = $orderData['deliveryMethod'];
    $paymentMethod = $orderData['paymentMethod'];
    $comment = $orderData['comment'];
    $createdAt = $orderData['created_at'];

    foreach($orderData['products'] as $id => $product){
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
    $order->total_price = 115;
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
