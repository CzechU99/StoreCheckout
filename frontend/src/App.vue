<script setup>
  import UserData from "@/components/UserData.vue";
  import Popups from '@/components/Popups.vue';
  import DiscountCode from '@/components/DiscountCode.vue';
  import ShippingAndPayments from './components/ShippingAndPayments.vue';
  import ShoppingCart from "./components/ShoppingCart.vue";
  import Order from "./components/Order.vue";
  import Captcha from "./components/Captcha.vue";
</script>

<template>
  
  <!-- <Captcha /> -->

  <div class="container">

    <div class="column">
      <UserData />
    </div>

    <div class="column">
      <ShippingAndPayments />
      <DiscountCode />
    </div>

    <div class="column">
      <ShoppingCart />
      <Order />
    </div>

    <Popups />

  </div>

</template>

<script>



</script>