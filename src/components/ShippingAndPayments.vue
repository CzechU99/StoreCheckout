<template>

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
    mounted(){
      this.fetchData();
    },
    methods: {
      
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
      clearErrorInfo(errorName = null){
        this.formErrors[errorName] = null;
        this.formConfig[errorName] = null;
      },

    }
  }

</script>