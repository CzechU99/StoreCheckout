<?php require_once('includes/init.php'); ?>

<html>
<head>

  <link rel="stylesheet" href="public/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Noto+Sans+Hatran&family=Noto+Sans+Wancho&display=swap" rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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

      <div class="login_button" @click="toggleLoginPopup">Logowanie</div>
      <div class="login_info">Masz już konto? Kliknij żeby się zalogować.</div>

      <div class="checkbox_div">
        <input type="checkbox" @click="toggleRegisterInputs" v-model="createAccount" class="data_create_account">
        <span class="checkbox_div_text">Stwórz nowe konto</span>
      </div>

      <div class="account_data">

        <input type="email" v-model="orderData.user.email" class="data_input data_users" placeholder="E-mail *">
        <input type="password" class="data_input dp_none" v-model="orderData.user.password" :style="{ display: registerInputsDisplay }" v-if="showRegisterInputs" placeholder="Hasło" :disabled="!createAccount">
        <input type="password" class="data_input dp_none" v-model="orderData.user.plainPassword" :style="{ display: registerInputsDisplay }" v-if="showRegisterInputs" placeholder="Potwierdź hasło" :disabled="!createAccount">

      </div>
      
      
      <div class="user_data">

        <input type="text" v-model="orderData.user.name" class="data_input data_users" placeholder="Imię *">
        <input type="text" v-model="orderData.user.surname" class="data_input data_users" placeholder="Nazwisko *">
        
        <select class="data_input data_users" v-model="orderData.user.country">
          <option>Polska</option>
          <option>Niemcy</option>
        </select>

        <input type="text" v-model="orderData.user.address" class="data_input data_users" placeholder="Adres *">
        <input type="text" v-model="orderData.user.postalCode" class="data_input postal_code data_users" placeholder="Kod pocztowy *">
        <input type="text" v-model="orderData.user.city" class="data_input city data_users" placeholder="Miasto *">
        <input type="text" v-model="orderData.user.phone" class="data_input data_users" placeholder="Telefon *">

      </div>

      <div class="checkbox_div">
        <input type="checkbox" v-model="differentAddress" @click="toggleDifferentAddress">
        <span class="checkbox_div_text">Dostawa pod inny adres</span>
      </div>

      <div class="user_data dp_none" v-if="showDifferentAddressInputs" :style="{ display: differentAddressInputsDisplay }">

        <input type="text" v-model="orderData.shippingAddress.address" class="data_input" placeholder="Adres *" :disabled="!differentAddress">
        <input type="text" v-model="orderData.shippingAddress.postalCode" class="data_input postal_code" placeholder="Kod pocztowy *" :disabled="!differentAddress">
        <input type="text" v-model="orderData.shippingAddress.city" class="data_input city" placeholder="Miasto *" :disabled="!differentAddress">

      </div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="public/images/delivery.png">
        <span class="box_info_text">2. METODA DOSTAWY</span>
      </div>

      <div class="delivery_methods">

        <div v-for="shippingMethod in shippingMethods" :key="shippingMethod.id" class="delivery_option">
          <input type="radio" v-model="orderData.shippingMethod" :value="shippingMethod.id" name="delivery_option" @change="handleShippingMethodChange"/>
          <img :src="'public/images/' + shippingMethod.name + '.png'" />
          <span class="delivery_option_text">{{ shippingMethod.name }}<span v-if="shippingMethod.name.includes('Paczkomaty')"> 24/7</span></span>
          <span class="delivery_option_prize">{{ formatPrice(shippingMethod.price) }} zł</span>
        </div>

      </div>

      <div class="box_info">
        <img src="public/images/payment.png">
        <span class="box_info_text">3. METODA PŁATNOŚCI</span>
      </div>

      <div class="payment_methods" v-if="orderData.shippingMethod != null">

        <div v-for="paymentMethod in paymentMethods" :key="paymentMethod.id" class="payment_option">
          <input type="radio" v-model="orderData.paymentMethod" :value="paymentMethod.id" name="payment_option"/>
          <img :src="'public/images/' + paymentMethod.name + '.png'" />
          <span class="payment_option_text">{{ paymentMethod.name }}</span>
        </div>

      </div>

      <div class="discount_button" @click="toggleDiscountCode">Dodaj kod rabatowy</div>

      <input type="text" v-model="orderData.discountCode" class="data_input discount_input" v-if="showDiscountCode" placeholder="Kod rabatowy" :disabled="!showDiscountCode" :style="{ display: discountCodeDisplay }">

      <div class="activate_discount_button dp_none" v-if="showDiscountCode" :style="{ display: discountCodeDisplay }">Zrealizuj kod rabatowy</div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="public/images/summary.png">
        <span class="box_info_text">4. PODSUMOWANIE</span>
      </div>

      <div class="products_list">

        <div class='product' v-for="item in shoppingCartDetails.shoppingCart" :key="item.product.id">
          <img :src="'public/ProductsImages/'+ item.product.id +'.png'" class='product_img'>
          <div class='product_info'>
            <span class='product_name'>{{item.product.name}}</span>
            <span class='product_prize'>{{formatPrice(item.product.price)}}</span>
            <span class='product_amount'>Ilość: {{item.quantity}}</span>
          </div>
        </div>

      </div>

      <div class="summary">

        <div class="summary_top">

          <span class="subtotal_text">Suma częściowa</span>
          <span class="subtotal_prize">{{formatPrice(shoppingCartDetails.subtotalPrice)}} zł</span>

        </div>

        <div class="summary_bottom">

          <span class="together_text">Łącznie</span>
          <span class="together_prize">{{formatPrice(shoppingCartDetails.totalPrice)}} zł</span>

        </div>

      </div>

      <textarea class="data_input textarea_input" v-model="orderData.comment" placeholder="Komentarz"></textarea>

      <div class="checkbox_div">
        <input type="checkbox" class="data_newsletter" v-model="orderData.user.newsletter">
        <span class="checkbox_div_text">Zapisz się, aby otrzymywać newsletter</span>
      </div>

      <div class="checkbox_div">
        <input type="checkbox">
        <span class="checkbox_div_text">Zapoznałam/em się z <a href="">Regulaminem</a> zakupów</span>
      </div>

      <div class="accept_button" @click="saveOrder">POTWIERDŹ ZAKUP</div>

    </div>

    <div class="popup_login" v-if="showLoginPopup" @click="toggleLoginPopup" :style="{ display: loginPopupDisplay }">

      <div class='login_form' @click.stop>
        <div class="close_popup" @click="toggleLoginPopup">&#10006;</div>
        <div class="login_text">ZALOGUJ SIĘ</div>
        <input type="text" class="data_input" placeholder="E-mail">
        <input type="text" class="data_input" placeholder="Hasło">
        <div class="accept_button">LOGIN</div>
      </div>

    </div>

    <div class="popup_numer_zamowienia" v-if="showOrderPopup" @click="toggleOrderPopup" :style="{ display: orderPopupDisplay }">

      <div class='order_info' @click.stop>
        <div class="close_popup" @click="toggleOrderPopup">&#10006;</div>
        <div class="login_text">DZIĘKUJEMY ZA ZAMÓWIENIE!</div>
        <div class="order_message">Twój numer zamówienia to: {{orderNumber}}</div>
        <div class="accept_button" @click="toggleOrderPopup">OK</div>
      </div>

    </div>

  </div>

  <script type="module" src="public/vue.js"></script>
  <script type="text/javascript" src="public/scripts.js"></script>

</body>

</html>
