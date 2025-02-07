<template>

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
    }
  }

</script>