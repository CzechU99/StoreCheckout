<template>

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

  <div class="accept_button" @click="saveOrder()">POTWIERDŹ ZAKUP</div>

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
      
      clearErrorInfo(errorName = null){
        this.formErrors[errorName] = null;
        this.formConfig[errorName] = null;
      },
      saveOrder(){

        this.checkTermsAccepted();
        this.checkShippedMethod();
        this.checkPaymentMethod();

        if(!this.checkFormValidation()){
          for(const key in this.formErrors){
            if(this.formErrors[key] === ''){
              if(key != 'shippingCityError' && key != 'cityError' && key != 'paymentMethodError'){
                this.formErrors[key] = 'Uzupełnij dane!';
              }
              if(key == 'paymentMethodError' && this.orderData.shippingMethod != null){
                this.formErrors[key] = 'Uzupełnij dane!';
              }
            }
          }
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

    }
  }

</script>