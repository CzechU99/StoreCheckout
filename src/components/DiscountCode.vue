<template>

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
    @click="addDiscountCode()" 
    v-if="formStyle.showDiscountCode" 
  >Zrealizuj kod rabatowy</div>

</template>

<script>

import { useOrderStore } from '@/stores/orderStore';
import { storeToRefs } from 'pinia';
import axios from 'axios';

  export default{
    setup(){
      const orderDataStore = useOrderStore();
      const { formConfig, formStyle, formErrors, regexRules, orderData } = storeToRefs(orderDataStore);

      return { formConfig, formStyle, formErrors, regexRules, orderData };
    },
    methods: {
      
      toggleDiscountCode(){
        if(!this.orderData.discountCodeId){
          this.formStyle.showDiscountCode = !this.formStyle.showDiscountCode;
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
      clearErrorInfo(errorName = null){
        this.formErrors[errorName] = null;
        this.formConfig[errorName] = null;
      },
      deleteDiscountCode(){
        document.getElementsByClassName('discount_input')[0].style.width = '100%';
        document.getElementsByClassName('discount_input')[0].disabled = false;
        this.orderData.discountCode = null;
        this.orderData.discountCodeId = null;
        this.orderData.discountPercentage = null;
        this.fetchShoppingCart();
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
      async fetchShoppingCart(){
        try {
          const response = await axios.get("http://localhost/storecheckout/api/getShoppingCart.php");
          this.formConfig.shoppingCartDetails = response.data; 
        } catch (error) {
          console.error("Błąd podczas ładowania koszyka:", error);
        }
      },

    }
  }

</script>