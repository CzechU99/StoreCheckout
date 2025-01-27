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
        <input type="checkbox" id="register_checkbox">
        <span class="checkbox_div_text">Stwórz nowe konto</span>
      </div>

      <div class="account_data">

        <input type="email" class="data_input" placeholder="E-mail *">
        <input type="password" class="data_input" id="password_input" placeholder="Hasło" disabled>
        <input type="password" class="data_input" id="plain_password_input" placeholder="Potwierdź hasło" disabled>

      </div>
      
      
      <div class="user_data">

        <input type="text" class="data_input" placeholder="Imię *">
        <input type="text" class="data_input" placeholder="Nazwisko *">
        
        <select class="data_input">
          <option>Polska</option>
          <option>Niemcy</option>
        </select>

        <input type="text" class="data_input" placeholder="Adres *">
        <input type="text" class="data_input postal_code" placeholder="Kod pocztowy *">
        <input type="text" class="data_input city" placeholder="Miasto *">
        <input type="text" class="data_input" placeholder="Telefon *">

      </div>

      <div class="checkbox_div">
        <input type="checkbox" id="second_address_checkbox">
        <span class="checkbox_div_text">Dostawa pod inny adres</span>
      </div>

      <div class="user_data">

        <input type="text" class="data_input" id="second_address_input" placeholder="Adres *" disabled>
        <input type="text" class="data_input postal_code" id="second_postal_code_input" placeholder="Kod pocztowy *" disabled>
        <input type="text" class="data_input city" id="second_city_input" placeholder="Miasto *" disabled>

      </div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="public/images/delivery.png">
        <span class="box_info_text">2. METODA DOSTAWY</span>
      </div>

      <div class="delivery_methods">

        <div class="delivery_option">
          <input type="radio" id="paczkomaty_radio_btn" name="delivery_option">
          <img src="public/images/inpost.png">
          <span class="delivery_option_text">Paczkomaty 24/7</span>
          <span class="delivery_option_prize">10,99 zł</span>
        </div>

        <div class="delivery_option">
          <input type="radio" id="dpd_radio_btn" name="delivery_option">
          <img src="public/images/dpd.png">
          <span class="delivery_option_text">Kurier DPD</span>
          <span class="delivery_option_prize">18,00 zł</span>
        </div>

        <div class="delivery_option">
          <input type="radio" id="dpd_pobranie_radio_btn" name="delivery_option">
          <img src="public/images/dpd.png">
          <span class="delivery_option_text">Kurier DPD pobranie</span>
          <span class="delivery_option_prize">22,00 zł</span>
        </div>

      </div>

      <div class="box_info">
        <img src="public/images/payment.png">
        <span class="box_info_text">3. METODA PŁATNOŚCI</span>
      </div>

      <div class="payment_methods">

        <div class="payment_option" id="payu_payment_option">
          <input type="radio" id="payu_radio_btn" name="payment_option" disabled>
          <img src="public/images/payu.png">
          <span class="payment_option_text">PayU</span>
        </div>

        <div class="payment_option" id="pobranie_payment_option">
          <input type="radio" id="pobranie_radio_btn" name="payment_option" disabled>
          <img src="public/images/wallet.png">
          <span class="payment_option_text">Płatność przy odbiorze</span>
        </div>

        <div class="payment_option" id="przelew_payment_option">
          <input type="radio" id="przelew_radio_btn" name="payment_option" disabled>
          <img src="public/images/cheque.png">
          <span class="payment_option_text">Przelew bankowy - zwykły</span>
        </div>

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

      <div class="products_list">

        <div class="product">

          <img src="public/ProductsImages/1.png" class="product_img">

          <div class="product_info">

            <span class="product_name">Testowy produkt</span>
            <span class="product_prize">115,00 zł</span>
            <span class="product_amount">Ilość: 1</span>
            
          </div>

        </div>

      </div>

      <div class="summary">

        <div class="summary_top">

          <span class="subtotal_text">Suma częściowa</span>
          <span class="subtotal_prize">115,00 zł</span>

        </div>

        <div class="summary_bottom">

          <span class="together_text">Łącznie</span>
          <span class="together_prize">115,00 zł</span>

        </div>

      </div>

      <textarea class="data_input textarea_input" placeholder="Komentarz"></textarea>

      <div class="checkbox_div">
        <input type="checkbox">
        <span class="checkbox_div_text">Zapisz się, aby otrzymywać newsletter</span>
      </div>

      <div class="checkbox_div">
        <input type="checkbox">
        <span class="checkbox_div_text">Zapoznałam/em się z <a href="">Regulaminem</a> zakupów</span>
      </div>

      <div class="accept_button">POTWIERDŹ ZAKUP</div>

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

  <script type="text/javascript" src="public/scripts.js"></script>

</body>

</html>






