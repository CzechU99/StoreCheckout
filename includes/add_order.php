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

    $shippingAddress = $orderData['orderData']['user']['shippingAddress'];
    $shippingCity = $orderData['orderData']['user']['shippingCity'];
    $shippingPostalCode = $orderData['orderData']['user']['shippingPostalCode'];

    $deliveryMethod = $orderData['orderData']['shippingMethod'];
    $paymentMethod = $orderData['orderData']['paymentMethod'];
    $comment = $orderData['orderData']['comment'];
    $createdAt = $orderData['orderData']['createdAt'];
    $discountCodeId = $orderData['orderData']['discountCodeId'];
    $termsAccept = $orderData['orderData']['termsAccept'];

    foreach($orderData['shoppingCart']['shoppingCart'] as $id => $product){
      $listOfProducts[$id] = [
        'id' => $product['product']['id'],
        'name' => $product['product']['name'],
        'price' => $product['product']['price'],
        'quantity' => $product['quantity'],
        'created_at' => $product['product']['created_at']
      ];
    }

    $errors = [];

    $errors[] = validateField($userEmail, "e-mail", true, "/^[^@\s]+@[^@\s]+\.[^@\s]+$/");
    $errors[] = validateField($userName, "imię", true, "/^[a-zA-Z]+$/", 25, 3);
    $errors[] = validateField($userSurname, "nazwisko", true, "/^[a-zA-Z]+$/", 50, 3);
    $errors[] = validateField($userPhone, "telefon", true, "/^\+?\d{7,15}$/");
    $errors[] = validateField($userAddress, "adres", true, null, 100, 3);
    $errors[] = validateField($userCity, "miasto", true, null, 50, 3);
    $errors[] = validateField($userPostalCode, "kod pocztowy", true, "/^\d{2}-\d{3}$/");
    $errors[] = $orderData['createAccount'] ? validateField($userPassword, "hasło", true, "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/") : null;
    
    $errors[] = $orderData['otherShippingAddress'] ? validateField($shippingAddress, "adres", true, null, 100, 3) : null;
    $errors[] = $orderData['otherShippingAddress'] ? validateField($shippingCity, "miasto", true, null, 50, 3) : null;
    $errors[] = $orderData['otherShippingAddress'] ? validateField($shippingPostalCode, "kod pocztowy", true, "/^\d{2}-\d{3}$/") : null;

    $errors[] = validateField($deliveryMethod, "metoda dostawy", true);
    $errors[] = validateField($paymentMethod, "metoda płatności", true);
    $errors[] = validateField($termsAccept, "regulamin", true);

    $errors[] = $orderData['createAccount'] ? validPasswordAndPlainPassword($userPassword, $userPlainPassword) : null;

    $errors = array_filter($errors);

    if (!empty($errors)) {
      echo json_encode([
          'status' => 'validError',
          'message' => 'Błędy walidacji! Popraw dane i spróbuj jeszcze raz.',
          'errors' => $errors
      ]);
      exit;
    }

    try{

      $user = new User($database);
      $user->email = $userEmail;
      $user->password = $orderData['createAccount'] ? password_hash($userPassword, PASSWORD_DEFAULT) : null;
      $user->name = $userName;
      $user->surname = $userSurname;
      $user->phone = $userPhone;
      $user->address = $userAddress;
      $user->city = $userCity;
      $user->postal_code = $userPostalCode;
      $user->newsletter = $userNewsletter;
      $user->created_at = $createdAt;
      $user->save();

      $otherShippingAddress = new ShippingAddress();
      $otherShippingAddress->user_id = $user->id;
      $otherShippingAddress->address = $orderData['otherShippingAddress'] ? $shippingAddress : $userAddress;
      $otherShippingAddress->city = $orderData['otherShippingAddress'] ? $shippingCity : $userCity;
      $otherShippingAddress->postal_code = $orderData['otherShippingAddress'] ? $shippingPostalCode : $userPostalCode;
      $otherShippingAddress->save();

      $order = new Order();
      $order->user_id = $user->id;
      $order->total_price = $orderData['shoppingCart']['totalPrice'];
      $order->created_at = $createdAt;
      $order->comment = $comment;
      $order->discount_code_id = $discountCodeId ? $discountCodeId : 1;
      $order->shipping_method_id = $deliveryMethod;
      $order->payment_method_id = $paymentMethod;
      $order->save();

      foreach($listOfProducts as $id => $product){
        $orderDetails = new OrderDetails();
        $orderDetails->order_id = $order->id;
        $orderDetails->product_id = $product['id'];
        $orderDetails->quantity = $product['quantity'];
        $orderDetails->price = $product['price'];
        $orderDetails->save();
      }

      $datePart = date('Ymd');
      $randomPart = rand(1000, 9999);
      $orderNumber = '#' . $datePart . '-' . $order->id . '-' . $randomPart;

      echo json_encode([
        'status' => 'success',
        'message' => 'Zamowienie zostalo przetworzone.',
        'orderNumber' => 'Twój numer zamówienia to: ' . $orderNumber
      ]);

    }catch(Exception $e){
      echo json_encode([
        'status' => 'serverError',
        'message' => 'Wystąpił błąd serwera.'
      ]);
    }

  }else{

    echo json_encode([
      'status' => 'dataError',
      'message' => 'Nieprawidłowe dane wejściowe.',
    ]);

  } 
