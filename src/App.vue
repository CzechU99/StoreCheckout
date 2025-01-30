<script setup>
import axios from 'axios'
</script>

<template>
  
  <div class="container">

    <div class="column">

      <div class="box_info">
        <img src="/src/images/user.png">
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
          @input="validInput('null', 'null', 'email', 'emailError', 'emailRegex', 'true')" 
          v-model="orderData.user.email" 
          class="data_input" 
          placeholder="E-mail *"
        >
        <div class="input_info" v-if="formErrors.emailError">{{formErrors.emailError}}</div>

        <input 
          type="password" 
          @input="validInput('null', 'null', 'password', 'passwordError', 'passwordRegex', 'true'); 
            validPasswordAndPlainPassword()" 
          class="data_input" 
          v-model="orderData.user.password" 
          v-if="formStyle.showRegisterInputs" placeholder="Hasło *" 
          :disabled="!formConfig.createAccount"
        >
        <div class="input_info" v-if="formErrors.passwordError">{{formErrors.passwordError}}</div>

        <input 
          type="password" 
          @input="validInput('null', 'null', 'plainPassword', 'plainPasswordError', 'passwordRegex', 'true'); 
            validPasswordAndPlainPassword()" 
          class="data_input" 
          v-model="orderData.user.plainPassword" 
          v-if="formStyle.showRegisterInputs" 
          placeholder="Potwierdź hasło *" 
          :disabled="!formConfig.createAccount"
        >
        <div class="input_info" v-if="formErrors.plainPasswordError">{{formErrors.plainPasswordError}}</div>

      </div>
      
      <div class="user_data">

        <input 
          type="text" 
          @input="validInput('3', '25', 'name', 'nameError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.name" 
          class="data_input" 
          placeholder="Imię *"
        >
        <div class="input_info" v-if="formErrors.nameError">{{formErrors.nameError}}</div>

        <input 
          type="text" 
          @input="validInput('3', '25', 'surname', 'surnameError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.surname" 
          class="data_input" 
          placeholder="Nazwisko *"
        >
        <div class="input_info" v-if="formErrors.surnameError">{{formErrors.surnameError}}</div>
        
        <select class="data_input" v-model="orderData.user.country">
          <option>Polska</option>
          <option>Niemcy</option>
        </select>

        <input 
          type="text" 
          @input="validInput('3', '30', 'address', 'addressError', 'bigFirstLetter', 'true')" 
          v-model="orderData.user.address" 
          class="data_input" 
          placeholder="Adres *"
        >
        <div class="input_info" v-if="formErrors.addressError">{{formErrors.addressError}}</div>

        <input 
          type="text" 
          @input="validInput('null', 'null', 'postalCode', 'postalCodeError', 'postalCodeRegex', 'true')" 
          v-model="orderData.user.postalCode" 
          class="data_input postal_code" 
          placeholder="Kod pocztowy *"
        >

        <input 
          type="text" 
          @input="validInput('null', 'null', 'city', 'cityError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.city" 
          class="data_input city" 
          placeholder="Miasto *"
        >
        <div class="input_info" v-if="formErrors.postalCodeError">{{formErrors.postalCodeError}}</div>
        <div class="input_info" v-if="formErrors.cityError">{{formErrors.cityError}}</div>

        <input 
          type="text" 
          @input="validInput('null', 'null', 'phone', 'phoneError', 'phoneRegex', 'true')" 
          v-model="orderData.user.phone" 
          class="data_input" 
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
        class="user_data" 
        v-if="formStyle.showDifferentAddressInputs" 
      >

        <input 
          type="text" 
          @input="validInput('3', '30', 'shippingAddress', 'shippingAddressError', 'bigFirstLetter', 'true')" 
          v-model="orderData.user.shippingAddress" 
          class="data_input" 
          placeholder="Adres *" 
          :disabled="!formConfig.differentAddress"
        >
        <div class="input_info" v-if="formErrors.shippingAddressError">{{formErrors.shippingAddressError}}</div>

        <input 
          type="text" 
          @input="validInput('null', 'null', 'shippingPostalCode', 'shippingPostalCodeError', 'postalCodeRegex', 'true')" 
          v-model="orderData.user.shippingPostalCode" 
          class="data_input postal_code"
          placeholder="Kod pocztowy *" 
          :disabled="!formConfig.differentAddress"
        >

        <input 
          type="text" 
          @input="validInput('null', 'null', 'shippingCity', 'shippingCityError', 'onlyLettersRegex', 'true')" 
          v-model="orderData.user.shippingCity" 
          class="data_input city" 
          placeholder="Miasto *" 
          :disabled="!formConfig.differentAddress"
        >
        <div class="input_info" v-if="formErrors.shippingPostalCodeError">{{formErrors.shippingPostalCodeError}}</div>
        <div class="input_info" v-if="formErrors.shippingCityError">{{formErrors.shippingCityError}}</div>

      </div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="/src/images/delivery.png">
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
          <img :src="'/src/images/' + shippingMethod.name + '.png'" />
          <span class="delivery_option_text">
            {{ shippingMethod.name }}
            <span v-if="shippingMethod.name.includes('Paczkomaty')"> 24/7</span>
          </span>
          <span class="delivery_option_prize">{{ formatPrice(shippingMethod.price) }} zł</span>
        </div>

      </div>
      <div class="input_info" v-if="formErrors.shippingMethodError">{{formErrors.shippingMethodError}}</div>

      <div class="box_info">
        <img src="/src/images/payment.png">
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
          <img :src="'/src/images/' + paymentMethod.name + '.png'" />
          <span class="payment_option_text">{{ paymentMethod.name }}</span>
        </div>

      </div>
      <div class="input_info" v-if="formErrors.paymentMethodError">{{formErrors.paymentMethodError}}</div>

      <div 
        class="discount_button" 
        @click="toggleDiscountCode(); fetchDiscountCodes(); clearErrorInfo('discountCodeError')"
      >Dodaj kod rabatowy</div>

      <input 
        type="text" 
        v-model="orderData.discountCode" 
        class="data_input discount_input" 
        v-if="formStyle.showDiscountCode" 
        placeholder="Kod rabatowy" 
      >

      <div 
        class="delete_code" 
        @click="deleteDiscountCode()" 
        v-if="orderData.discountCodeId"
      >&#10006;</div>

      <div 
        class="input_info discount_code" 
        v-if="formStyle.showDiscountCode && formConfig.discountCodeError != null" 
      >{{formConfig.discountCodeError}}</div>

      <div 
        class="activate_discount_button" 
        @click="addDiscountCode" 
        v-if="formStyle.showDiscountCode" 
      >Zrealizuj kod rabatowy</div>

    </div>

    <div class="column">

      <div class="box_info">
        <img src="/src/images/summary.png">
        <span class="box_info_text">4. PODSUMOWANIE</span>
      </div>

      <div class="products_list">

        <div class='product' v-for="item in formConfig.shoppingCartDetails.shoppingCart" :key="item.product.id">
          <img :src="'/src/images/productsImages/'+ item.product.id +'.png'" class='product_img'>
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
    >

      <div class='order_info' @click.stop>
        <div class="close_popup" @click="toggleVisibility('showOrderPopup')">&#10006;</div>
        <div class="order_message">{{formConfig.orderPopupText}}</div>
        <div class="accept_button" @click="toggleVisibility('showOrderPopup')">OK</div>
      </div>

    </div>

  </div>

</template>

<script>

  export default {
    data(){
      return{
        formConfig: {
          createAccount: false,
          differentAddress: false,
          shippingMethods: [],
          paymentMethods: [],
          shoppingCartDetails: [],
          isCaptchaSolved: false,
          orderPopupText: null,
          validCodes: [],
          discountCodeError: null,
        },
        formStyle: {
          showLoginPopup: false,
          showRegisterInputs: false,
          showDifferentAddressInputs: false,
          showDiscountCode: false,
          showOrderPopup: false,
        }, 
        formErrors: {
          emailError: '',
          passwordError: null,
          plainPasswordError: null,
          nameError: '',
          surnameError: '',
          addressError: '',
          postalCodeError: '',
          cityError: '',
          phoneError: '',
          shippingAddressError: null,
          shippingCityError: null,
          shippingPostalCodeError: null,
          shippingMethodError: '',
          paymentMethodError: '',
          termsAcceptError: '',
        },
        regexRules: {
          emailRegex: /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
          passwordRegex: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/,
          onlyLettersRegex: /^[A-Z][a-z]*$/,
          bigFirstLetter: /^[A-Z].*$/,
          postalCodeRegex: /^\d{2}-\d{3}$/,
          phoneRegex: /^\+?\d{7,15}$/,
        },
        orderData: {
          termsAccept: false,
          shippingMethod: null,
          paymentMethod: null,
          comment: null,
          createdAt: new Date().toISOString(),
          discountCode: null,
          discountCodeId: null,
          discountPercentage: null,
          user: {
            email: null,
            password: null,
            plainPassword: null,
            name: null,
            surname: null,
            country: 'Polska',
            address: null,
            postalCode: null,
            city: null,
            phone: null,
            newsletter: null,
            shippingAddress: null,
            shippingCity: null,
            shippingPostalCode: null,
          }
        },
      };
    },
    mounted(){
      this.fetchData();
      this.fetchShoppingCart();
      window.onCaptchaSuccess = this.onCaptchaSuccess;
    },
    methods: {
      toggleVisibility(field) {
        this.formStyle[field] = !this.formStyle[field];
      },
      toggleDiscountCode(){
        if(!this.orderData.discountCodeId){
          this.formStyle.showDiscountCode = !this.formStyle.showDiscountCode;
        }
      },
      async fetchData(){
        try {
          const [shippingResponse, paymentResponse] = await Promise.all([
            axios.get("http://localhost/storecheckout/api/getShippingMethods.php"),
            axios.get("http://localhost/storecheckout/api/getPaymentMethods.php"),
          ]);
          this.formConfig.shippingMethods = shippingResponse.data;
          this.formConfig.paymentMethods = paymentResponse.data;
        } catch (error) {
          console.error("Błąd podczas ładowania danych:", error);
        }
      },
      async fetchDiscountCodes(){
        try {
          const response = await axios.get("http://localhost/storecheckout/api/getDiscountCodes.php");
          this.formConfig.validCodes = response.data; 
        } catch (error) {
          console.error("Błąd podczas ładowania kodów zniżkowych:", error);
        }
      },
      async fetchShoppingCart(){
        try {
          const response = await axios.get("http://localhost/storecheckout/api/getShoppingCart.php");
          this.formConfig.shoppingCartDetails = response.data; 
        } catch (error) {
          console.error("Błąd podczas ładowania koszyka:", error);
        }
      },
      handleShippingMethodChange(){
        const selectedShippingMethod = this.formConfig.shippingMethods.find(
          (method) => method.id === this.orderData.shippingMethod
        );
        this.formConfig.paymentMethods = selectedShippingMethod ? selectedShippingMethod.payments : [];
        this.orderData.paymentMethod = null;
        if (!this.orderData.shippingMethod){
          this.formConfig.paymentMethods = [];
        }
      },
      formatPrice(price){
        price = parseFloat(price);
        if(price % 1 === 0) {
          return price + ',00';
        }
        return price.toFixed(2).toString().replace('.', ',');
      },
      onCaptchaSuccess(){
        document.getElementById('captchaOverlay').style.display = 'none';

        const token = grecaptcha.getResponse();
        this.formConfig.isCaptchaSolved = true;
        console.log('CAPTCHA rozwiązany:', token);
      },
      saveOrder(){

        this.checkTermsAccepted();
        this.checkShippedMethod();
        this.checkPaymentMethod();

        if(!this.checkFormValidation()) {
          return; 
        }

        const dataToSave = {
          orderData: this.orderData,
          shoppingCart: this.formConfig.shoppingCartDetails,
          createAccount: this.formConfig.createAccount,
          otherShippingAddress: this.formConfig.differentAddress,
        };

        fetch('http://localhost/StoreCheckout/php/controllers/OrderController.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(dataToSave), 
        })
          .then((response) => response.json())
          .then((data) => {
            if(data.status === 'success'){
              this.formStyle.showOrderPopup = true;
              this.formConfig.orderPopupText = data.orderNumber;
            }else if(data.status === 'validError'){
              this.formStyle.showOrderPopup = true;
              this.formConfig.orderPopupText = data.message;
              console.log(data.errors);
            }
          })
          .catch((error) => {
            console.error('Wystąpił błąd podczas składania zamówienia:', error);
          });

      },
      addDiscountCode(){

        const matchingCode = this.formConfig.validCodes.find(
          (codeDetails) => this.orderData.discountCode === codeDetails.code
        );

        if (matchingCode) {
          this.orderData.discountCodeId = matchingCode.id;
          this.orderData.discountPercentage = matchingCode.discount_percent;
          this.formConfig.discountCodeError = null;
          document.getElementsByClassName('discount_input')[0].style.width = '80%';
          document.getElementsByClassName('discount_input')[0].disabled = true;

          this.formConfig.shoppingCartDetails.subtotalPrice = 0;
          this.formConfig.shoppingCartDetails.totalPrice = 0; 

          this.formConfig.shoppingCartDetails.shoppingCart.forEach(product => {
            const discount = (this.orderData.discountPercentage / 100) * product.product.price;
            product.product.price = parseFloat((product.product.price - discount).toFixed(2));
            
            this.formConfig.shoppingCartDetails.subtotalPrice += product.product.price;
            this.formConfig.shoppingCartDetails.totalPrice += product.product.price * product.quantity; 
          });

        } else {
          this.formConfig.discountCodeError = "Podany kod jest nieaktywny!";
          this.orderData.discountCode = null;
        }

      },
      deleteDiscountCode(){
        document.getElementsByClassName('discount_input')[0].style.width = '100%';
        document.getElementsByClassName('discount_input')[0].disabled = false;
        this.orderData.discountCode = null;
        this.orderData.discountCodeId = null;
        this.orderData.discountPercentage = null;
        this.fetchShoppingCart();
      },
      validInput(min = null, max = null, inputName = null, errorName = null, regex = null, required = null){
        if(required && !this.orderData.user[inputName]){
          return this.formErrors[errorName] = "Pole nie może być puste.";
        }
        if(regex){
          const pattern = this.regexRules[regex];
          if(pattern && !this.orderData.user[inputName].match(pattern)){
            return this.formErrors[errorName] = "Pole ma nieprawidłowy format.";
          }
        }
        if(min && this.orderData.user[inputName].length < min){
          return this.formErrors[errorName] = "Minimalna długość wynosi " + min + " znaki.";
        }
        if(max && this.orderData.user[inputName].length > max){
          return this.formErrors[errorName] = "Maksymalna długość wynosi " + max + " znaki.";
        }
        return this.formErrors[errorName] = null;
      },
      checkTermsAccepted(){
        this.orderData.termsAccept == true ? this.formErrors.termsAcceptError = null : this.formErrors.termsAcceptError = 'Musisz zaakceptować regulamin.';
      },
      checkShippedMethod(){
        this.orderData.shippingMethod != null ? this.formErrors.shippingMethodError = null : this.formErrors.shippingMethodError = 'Musisz wybrać metodę dostawy.';
      },
      checkPaymentMethod(){
        if(this.orderData.shippingMethod != null){
          this.orderData.paymentMethod != null ? this.formErrors.paymentMethodError = null : this.formErrors.paymentMethodError = 'Musisz wybrać sposób płatności.';
        }
      },
      clearErrorInfo(errorName = null){
        this.formErrors[errorName] = null;
        this.formConfig[errorName] = null;
      },
      clearShippingAddress(){
        if(this.formStyle.showDifferentAddressInputs){
          this.orderData.user.shippingAddress = null;
          this.orderData.user.shippingCity = null;
          this.orderData.user.shippingPostalCode = null;
          this.formErrors.shippingAddressError = '';
          this.formErrors.shippingCityError = '';
          this.formErrors.shippingPostalCodeError = '';
        }else{
          this.formErrors.shippingAddressError = null;
          this.formErrors.shippingCityError =null;
          this.formErrors.shippingPostalCodeError = null;
        }
      },
      clearCreateAccount(){
        if(this.formStyle.showRegisterInputs){
          this.orderData.user.password = null;
          this.orderData.user.plainPassword = null;
          this.formErrors.passwordError = '';
          this.formErrors.plainPasswordError = '';
        }else{
          this.formErrors.passwordError = null;
          this.formErrors.plainPasswordError = null;
        }
      },
      validPasswordAndPlainPassword(){
        if(this.formStyle.showRegisterInputs){
          if(this.orderData.user.password !== this.orderData.user.plainPassword){
            this.formErrors.plainPasswordError = "Hasła muszą być takie same!";
          }else{
            this.formErrors.plainPasswordError = null;
          }
        }
      },
      checkFormValidation(){
        let isValid = true;
        for(let field in this.formErrors){
          if(this.formErrors[field] != null){
            this.formStyle.showOrderPopup = true;
            this.formConfig.orderPopupText = "Uzupełnij lub popraw swoje dane!";
            isValid = false;
            break;
          }
        }
        return isValid;
      }
    },
  }

</script>