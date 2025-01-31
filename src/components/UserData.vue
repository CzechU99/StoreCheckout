<template>

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

</template>

<script>
import { useOrderStore } from '@/stores/orderStore';
import { storeToRefs } from 'pinia';

  export default{
    setup(){
      const orderDataStore = useOrderStore();
      const { formConfig, formStyle, formErrors, regexRules, orderData } = storeToRefs(orderDataStore);

      return { formConfig, formStyle, formErrors, regexRules, orderData };
    },
    methods: {
      toggleVisibility(field) {
        this.formStyle[field] = !this.formStyle[field];
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
    },
  }

</script>