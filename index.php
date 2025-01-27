<?php require_once('includes/init.php'); ?>

<html>
<head>

  <link rel="stylesheet" href="public/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Noto+Sans+Hatran&family=Noto+Sans+Wancho&display=swap" rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>

  <!-- <div id="captchaOverlay">
    <div id="captchaBox">
      <div class="g-recaptcha"
          data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
          data-callback="onCaptchaSuccess"
          data-size="normal">
      </div>
    </div>
  </div> -->

  <div class="container">

    <div class="column">

      <div class="box_info">
        <img src="public/images/user.png">
        <span class="box_info_text">1. TWOJE DANE</span>
      </div>

      <div class="login_button">Logowanie</div>
      <div class="login_info">Masz już konto? Kliknij żeby się zalogować.</div>

      <div class="checkbox_div">
        <input type="checkbox" id="register_checkbox" class="data_create_account">
        <span class="checkbox_div_text">Stwórz nowe konto</span>
      </div>

      <div class="account_data">

        <input type="email" class="data_input data_users" placeholder="E-mail *">
        <input type="password" class="data_input" id="password_input" placeholder="Hasło" disabled>
        <input type="password" class="data_input" id="plain_password_input" placeholder="Potwierdź hasło" disabled>

      </div>
      
      
      <div class="user_data">

        <input type="text" class="data_input data_users" placeholder="Imię *">
        <input type="text" class="data_input data_users" placeholder="Nazwisko *">
        
        <select class="data_input data_users">
          <option>Polska</option>
          <option>Niemcy</option>
        </select>

        <input type="text" class="data_input data_users" placeholder="Adres *">
        <input type="text" class="data_input postal_code data_users" placeholder="Kod pocztowy *">
        <input type="text" class="data_input city data_users" placeholder="Miasto *">
        <input type="text" class="data_input data_users" placeholder="Telefon *">

      </div>

      <div class="checkbox_div">
        <input type="checkbox" id="second_address_checkbox">
        <span class="checkbox_div_text">Dostawa pod inny adres</span>
      </div>

      <div class="user_data">

        <input type="text" class="data_input data_second_address" id="second_address_input" placeholder="Adres *" disabled>
        <input type="text" class="data_input data_second_address postal_code" id="second_postal_code_input" placeholder="Kod pocztowy *" disabled>
        <input type="text" class="data_input data_second_address city" id="second_city_input" placeholder="Miasto *" disabled>

      </div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="public/images/delivery.png">
        <span class="box_info_text">2. METODA DOSTAWY</span>
      </div>

      <div class="delivery_methods">

        <?php 
        
          $deliveryMethods = new ShippingMethod();
          foreach($deliveryMethods->find_all() as $deliveryMethod){

            echo "<div class='delivery_option'>";
              echo "<input type='radio' class='delivery_methods_input' value=". $deliveryMethod->id ." name='delivery_option'>";
              echo "<img src='public/images/". $deliveryMethod->name .".png'>";
              echo "<span class='delivery_option_text'>". $deliveryMethod->name ." 24/7</span>";
              echo "<span class='delivery_option_prize'>". $deliveryMethod->getPriceWithComma() ."</span>";
            echo "</div>";

          }
        
        ?>

      </div>

      <div class="box_info">
        <img src="public/images/payment.png">
        <span class="box_info_text">3. METODA PŁATNOŚCI</span>
      </div>

      <div class="payment_methods">

        <?php 
        
          $paymentsMethod = new PaymentMethod();
          foreach($paymentsMethod->find_all() as $paymentMethod){

            echo "<div class='payment_option' id='payu_payment_option'>";
            echo "<input type='radio' class='payment_radio_btn' value=". $paymentMethod->id ." name='payment_option' disabled>";
              echo "<img src='public/images/". $paymentMethod->name .".png'>";
              echo "<span class='payment_option_text'>". $paymentMethod->name ."</span>";
            echo "</div>";

          }
        
        ?>

      </div>

      <div class="discount_button">Dodaj kod rabatowy</div>

      <input type="text" class="data_input discount_input" placeholder="Kod rabatowy" disabled>

      <div class="activate_discount_button">Zrealizuj kod rabatowy</div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="public/images/summary.png">
        <span class="box_info_text">4. PODSUMOWANIE</span>
      </div>

      <div data-products='<?php echo $shoppingCart->shoppingCartJson ?>' class="products_list">

        <?php 

          foreach($shoppingCart->shoppingCart as $index => $product){

            echo "<div class='product'>";
              echo "<img src='public/ProductsImages/". $product['product']->id .".png' class='product_img'>";
              echo "<div class='product_info'>";
                echo "<span class='product_name'>". $product['product']->name ."</span>";
                echo "<span class='product_prize'>". $product['product']->getPriceWithComma() ."</span>";
                echo "<span class='product_amount'>Ilość: ". $product['quantity'] ."</span>";
              echo "</div>";
            echo "</div>";

          };
        
        ?>

      </div>

      <div class="summary">

        <div class="summary_top">

          <span class="subtotal_text">Suma częściowa</span>
          <span class="subtotal_prize"><?php echo $shoppingCart->getSubtotalPrice() ?> zł</span>

        </div>

        <div class="summary_bottom">

          <span class="together_text">Łącznie</span>
          <span class="together_prize"><?php echo $shoppingCart->getTotalPrice() ?> zł</span>

        </div>

      </div>

      <textarea class="data_input textarea_input data_comment" placeholder="Komentarz"></textarea>

      <div class="checkbox_div">
        <input type="checkbox" class="data_newsletter">
        <span class="checkbox_div_text">Zapisz się, aby otrzymywać newsletter</span>
      </div>

      <div class="checkbox_div">
        <input type="checkbox">
        <span class="checkbox_div_text">Zapoznałam/em się z <a href="">Regulaminem</a> zakupów</span>
      </div>

      <div class="accept_button" id="save_data">POTWIERDŹ ZAKUP</div>

    </div>

  </div>

  <div class="popup_login">

    <div class='login_form'>
      <div class="close_popup">&#10006;</div>
      <div class="login_text">ZALOGUJ SIĘ</div>
      <input type="text" class="data_input" placeholder="E-mail">
      <input type="text" class="data_input" placeholder="Hasło">
      <div class="accept_button">LOGIN</div>
    </div>

  </div>

  <div class="popup_numer_zamowienia">

    <div class='order_info'>
      <div class="close_popup">&#10006;</div>
      <div class="login_text">DZIĘKUJEMY ZA ZAMÓWIENIE!</div>
      <div class="order_message"></div>
      <div class="accept_button">OK</div>
    </div>

  </div>

  <script type="text/javascript" src="public/scripts.js"></script>

</body>

</html>
