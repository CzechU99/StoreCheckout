<template>

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
      this.fetchShoppingCart();
    },
    methods: {
      
      formatPrice(price){
        price = parseFloat(price);
        if(price % 1 === 0) {
          return price + ',00';
        }
        return price.toFixed(2).toString().replace('.', ',');
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