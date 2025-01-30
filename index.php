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

      <div class="login_button" @click="toggleVisibility('showLoginPopup')">Logowanie</div>
      <div class="login_info">Masz już konto? Kliknij żeby się zalogować.</div>

      <div class="checkbox_div">
        <input 
          type="checkbox" 
          @click="toggleVisibility('showRegisterInputs'); 
            clearCreateAccount()" 
          v-model="formConfig.createAccount" 
          class="data_create_account"
        >
        <span class="checkbox_div_text">Stwórz nowe konto</span>
      </div>

      <div class="account_data"> 

        <input 
          type="email" 
          @keyup="validInput('null', 'null', 'email', 'emailError', 'emailRegex', 'true')" 
          v-model="orderData.user.email" 
          class="data_input data_users" 
          placeholder="E-mail *"
        >
        <div class="input_info" v-if="formErrors.emailError">{{formErrors.emailError}}</div>

        <input 
          type="password" 
          @keyup="validInput('null', 'null', 'password', 'passwordError', 'passwordRegex', 'true'); 
            validPasswordAndPlainPassword()" 
          class="data_input dp_none" 
          v-model="orderData.user.password" 
          :style="{ display: formStyle.showRegisterInputsDisplay }" 
          v-if="formStyle.showRegisterInputs" placeholder="Hasło *" 
          :disabled="!formConfig.createAccount"
        >
        <div class="input_info" v-if="formErrors.passwordError">{{formErrors.passwordError}}</div>

        <input 
          type="password" 
          @keyup="validInput('null', 'null', 'plainPassword', 'plainPasswordError', 'passwordRegex', 'true'); 
            validPasswordAndPlainPassword()" 
          class="data_input dp_none" 
          v-model="orderData.user.plainPassword" 
          :style="{ display: formStyle.showRegisterInputsDisplay }" 
          v-if="formStyle.showRegisterInputs" 
          placeholder="Potwierdź hasło *" 
          :disabled="!formConfig.createAccount"
        >
        <div class="input_info" v-if="formErrors.plainPasswordError">{{formErrors.plainPasswordError}}</div>

      </div>
      
      <div class="user_data">

        <input 
          type="text" 
          @keyup="validInput('3', '25', 'name', 'nameError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.name" 
          class="data_input data_users" 
          placeholder="Imię *"
        >
        <div class="input_info" v-if="formErrors.nameError">{{formErrors.nameError}}</div>

        <input 
          type="text" 
          @keyup="validInput('3', '25', 'surname', 'surnameError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.surname" 
          class="data_input data_users" 
          placeholder="Nazwisko *"
        >
        <div class="input_info" v-if="formErrors.surnameError">{{formErrors.surnameError}}</div>
        
        <select class="data_input data_users" v-model="orderData.user.country">
          <option>Polska</option>
          <option>Niemcy</option>
        </select>

        <input 
          type="text" 
          @keyup="validInput('3', '30', 'address', 'addressError', 'bigFirstLetter', 'true')" 
          v-model="orderData.user.address" 
          class="data_input data_users" 
          placeholder="Adres *"
        >
        <div class="input_info" v-if="formErrors.addressError">{{formErrors.addressError}}</div>

        <input 
          type="text" 
          @keyup="validInput('null', 'null', 'postalCode', 'postalCodeError', 'postalCodeRegex', 'true')" 
          v-model="orderData.user.postalCode" 
          class="data_input postal_code data_users" 
          placeholder="Kod pocztowy *"
        >

        <input 
          type="text" 
          @keyup="validInput('null', 'null', 'city', 'cityError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.city" 
          class="data_input city data_users" 
          placeholder="Miasto *"
        >
        <div class="input_info" v-if="formErrors.postalCodeError">{{formErrors.postalCodeError}}</div>
        <div class="input_info" v-if="formErrors.cityError">{{formErrors.cityError}}</div>

        <input 
          type="text" 
          @keyup="validInput('null', 'null', 'phone', 'phoneError', 'phoneRegex', 'true')" 
          v-model="orderData.user.phone" 
          class="data_input data_users" 
          placeholder="Telefon *"
        >
        <div class="input_info" v-if="formErrors.phoneError">{{formErrors.phoneError}}</div>

      </div>

      <div class="checkbox_div">
        <input 
          type="checkbox" 
          v-model="formConfig.differentAddress" 
          @click="toggleVisibility('showDifferentAddressInputs'); 
            clearShippingAddress()"
        >
        <span class="checkbox_div_text">Dostawa pod inny adres</span>
      </div>

      <div 
        class="user_data dp_none" 
        v-if="formStyle.showDifferentAddressInputs" 
        :style="{ display: formStyle.showDifferentAddressInputsDisplay }"
      >

        <input 
          type="text" 
          @keyup="validInput('3', '30', 'shippingAddress', 'shippingAddressError', 'bigFirstLetter', 'true')" 
          v-model="orderData.user.shippingAddress" 
          class="data_input" 
          placeholder="Adres *" 
          :disabled="!formConfig.differentAddress"
        >
        <div class="input_info" v-if="formErrors.shippingAddressError">{{formErrors.shippingAddressError}}</div>

        <input 
          type="text" 
          @keyup="validInput('null', 'null', 'shippingPostalCode', 'shippingPostalCodeError', 'postalCodeRegex', 'true')" 
          v-model="orderData.user.shippingPostalCode" 
          class="data_input postal_code"
          placeholder="Kod pocztowy *" 
          :disabled="!formConfig.differentAddress"
        >

        <input 
          type="text" 
          @keyup="validInput('null', 'null', 'shippingCity', 'shippingCityError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.shippingCity" 
          class="data_input city" 
          placeholder="Miasto *" 
          :disabled="!formConfig.differentAddress"
        >
        <div class="input_info" v-if="formErrors.shippingCityError">{{formErrors.shippingCityError}}</div>
        <div class="input_info" v-if="formErrors.shippingCityError">{{formErrors.shippingCityError}}</div>

      </div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="public/images/delivery.png">
        <span class="box_info_text">2. METODA DOSTAWY</span>
      </div>

      <div class="delivery_methods">

        <div 
          v-for="shippingMethod in formConfig.shippingMethods" 
          :key="shippingMethod.id" 
          class="delivery_option"
        >
          <input 
            type="radio" 
            @click="clearErrorInfo('shippingMethodError')" 
            v-model="orderData.shippingMethod" 
            :value="shippingMethod.id" 
            name="delivery_option" 
            @change="handleShippingMethodChange"
          />
          <img :src="'public/images/' + shippingMethod.name + '.png'" />
          <span class="delivery_option_text">
            {{ shippingMethod.name }}
            <span v-if="shippingMethod.name.includes('Paczkomaty')"> 24/7</span>
          </span>
          <span class="delivery_option_prize">{{ formatPrice(shippingMethod.price) }} zł</span>
        </div>

      </div>
      <div class="input_info" v-if="formErrors.shippingMethodError">{{formErrors.shippingMethodError}}</div>

      <div class="box_info">
        <img src="public/images/payment.png">
        <span class="box_info_text">3. METODA PŁATNOŚCI</span>
      </div>

      <div class="payment_methods" v-if="orderData.shippingMethod != null">

        <div 
          v-for="paymentMethod in formConfig.paymentMethods" 
          :key="paymentMethod.id" 
          class="payment_option"
        >
          <input 
            type="radio" 
            @click="clearErrorInfo('paymentMethodError')" 
            v-model="orderData.paymentMethod" 
            :value="paymentMethod.id" 
            name="payment_option"
          />
          <img :src="'public/images/' + paymentMethod.name + '.png'" />
          <span class="payment_option_text">{{ paymentMethod.name }}</span>
        </div>

      </div>
      <div class="input_info" v-if="formErrors.paymentMethodError">{{formErrors.paymentMethodError}}</div>

      <div 
        class="discount_button" 
        @click="toggleVisibility('showDiscountCode'); 
          fetchDiscountCodes(); 
          clearErrorInfo('discountCodeError')"
      >Dodaj kod rabatowy</div>

      <input 
        type="text" 
        v-model="orderData.discountCode" 
        class="data_input discount_input" 
        v-if="formStyle.showDiscountCode" 
        placeholder="Kod rabatowy" 
        :style="{ display: formStyle.showDiscountCodeDisplay }"
      >

      <div 
        class="delete_code" 
        @click="deleteDiscountCode()" 
        v-if="orderData.discountCodeId"
      >&#10006;</div>

      <div 
        class="input_info discount_code" 
        v-if="formStyle.showDiscountCode && formErrors.discountCodeError != null" 
        :style="{ display: formStyle.showDiscountCodeDisplay }"
      >{{formErrors.discountCodeError}}</div>

      <div 
        class="activate_discount_button dp_none" 
        @click="addDiscountCode" 
        v-if="formStyle.showDiscountCode" 
        :style="{ display: formStyle.showDiscountCodeDisplay }"
      >Zrealizuj kod rabatowy</div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="public/images/summary.png">
        <span class="box_info_text">4. PODSUMOWANIE</span>
      </div>

      <div class="products_list">

        <div class='product' v-for="item in formConfig.shoppingCartDetails.shoppingCart" :key="item.product.id">
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
          <span class="subtotal_prize">{{formatPrice(formConfig.shoppingCartDetails.subtotalPrice)}} zł</span>

        </div>

        <div class="summary_bottom">

          <span class="together_text">Łącznie</span>
          <span class="together_prize">{{formatPrice(formConfig.shoppingCartDetails.totalPrice)}} zł</span>

        </div>

      </div>

      <textarea 
        class="data_input textarea_input" 
        v-model="orderData.comment" 
        placeholder="Komentarz"
      ></textarea>

      <div class="checkbox_div">
        <input type="checkbox" class="data_newsletter" v-model="orderData.user.newsletter">
        <span class="checkbox_div_text">Zapisz się, aby otrzymywać newsletter</span>
      </div>

      <div class="checkbox_div">
        <input type="checkbox" @click="clearErrorInfo('termsAcceptError')" v-model="orderData.termsAccept">
        <span class="checkbox_div_text">Zapoznałam/em się z <a href="">Regulaminem</a> zakupów</span>
      </div>
      <div class="input_info" v-if="formErrors.termsAcceptError">{{formErrors.termsAcceptError}}</div>

      <div class="accept_button" @click="saveOrder">POTWIERDŹ ZAKUP</div>

    </div>

    <div 
      class="popup_login" 
      v-if="formStyle.showLoginPopup" 
      @click="toggleVisibility('showLoginPopup')" 
      :style="{ display: formStyle.showLoginPopupDisplay }"
    >

      <div class='login_form' @click.stop>
        <div class="close_popup" @click="toggleVisibility('showLoginPopup')">&#10006;</div>
        <div class="login_text">ZALOGUJ SIĘ</div>
        <input type="text" class="data_input" placeholder="E-mail">
        <input type="text" class="data_input" placeholder="Hasło">
        <div class="accept_button">LOGIN</div>
      </div>

    </div>

    <div 
      class="popup_numer_zamowienia" 
      v-if="formStyle.showOrderPopup" 
      @click="toggleVisibility('showOrderPopup')" 
      :style="{ display: formStyle.showOrderPopupDisplay }"
    >

      <div class='order_info' @click.stop>
        <div class="close_popup" @click="toggleVisibility('showOrderPopup')">&#10006;</div>
        <div class="order_message">{{formConfig.orderPopupText}}</div>
        <div class="accept_button" @click="toggleVisibility('showOrderPopup')">OK</div>
      </div>

    </div>

  </div>

  <script type="module" src="./public/vue.js"></script>

</body>

</html>