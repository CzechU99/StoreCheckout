const app = Vue.createApp({

  data(){
    return{
      showLoginPopup: false,
      loginPopupDisplay: 'none',
      showRegisterInputs: false,
      registerInputsDisplay: 'none',
      showDifferentAddressInputs: false,
      differentAddressInputsDisplay: 'none',
      showDiscountCode: false,
      discountCodeDisplay: 'none',
      showOrderPopup: false,
      orderPopupDisplay: 'none',
      createAccount: false,
      differentAddress: false,
      shippingMethods: [],
      paymentMethods: [],
      shoppingCartDetails: [],
      isCaptchaSolved: false,
      orderNumber: null,
      orderData: {
        shippingMethod: null,
        paymentMethod: null,
        comment: null,
        createdAt: new Date().toISOString(),
        discountCode: null,
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
          newsletter: null
        },
        shippingAddress: {
          address: null,
          city: null,
          postalCode: null 
        },
      },
    };
  },
  mounted(){
    this.fetchShippingMethods();
    this.fetchPaymentMethods();
    this.fetchShoppingCart();
    window.onCaptchaSuccess = this.onCaptchaSuccess;
  },
  methods: {
    toggleLoginPopup(){
      this.showLoginPopup = !this.showLoginPopup;
      this.loginPopupDisplay = this.loginPopupDisplay === 'none' ? 'block' : 'none';
    },
    toggleRegisterInputs(){
      this.showRegisterInputs = !this.showRegisterInputs;
      this.registerInputsDisplay = this.registerInputsDisplay === 'none' ? 'block' : 'none';
    },
    toggleDifferentAddress(){
      this.showDifferentAddressInputs = !this.showDifferentAddressInputs;
      this.differentAddressInputsDisplay = this.differentAddressInputsDisplay === 'none' ? 'block' : 'none';
    },
    toggleDiscountCode(){
      this.showDiscountCode = !this.showDiscountCode;
      this.discountCodeDisplay = this.discountCodeDisplay === 'none' ? 'block' : 'none';
    },
    toggleOrderPopup(){
      this.showOrderPopup = !this.showOrderPopup;
      this.orderPopupDisplay = this.orderPopupDisplay === 'none' ? 'block' : 'none';
    },
    async fetchShippingMethods(){
      try {
        const response = await axios.get("http://localhost/storeCheckout/api/shippingMethods.php");
        this.shippingMethods = response.data; 
      } catch (error) {
        console.error("Błąd podczas ładowania metod dostawy:", error);
      }
    },
    async fetchPaymentMethods(){
      try {
        const response = await axios.get("http://localhost/storeCheckout/api/paymentMethods.php");
        this.paymentMethods = response.data; 
      } catch (error) {
        console.error("Błąd podczas ładowania metod dostawy:", error);
      }
    },
    async fetchShoppingCart(){
      try {
        const response = await axios.get("http://localhost/storeCheckout/api/shoppingCart.php");
        this.shoppingCartDetails = response.data; 
      } catch (error) {
        console.error("Błąd podczas ładowania metod dostawy:", error);
      }
    },
    handleShippingMethodChange(){
      const selectedShippingMethod = this.shippingMethods.find(
        (method) => method.id === this.orderData.shippingMethod
      );
      this.paymentMethods = selectedShippingMethod ? selectedShippingMethod.payments : [];
      this.orderData.paymentMethod = null;
      if (!this.orderData.shippingMethod){
        this.paymentMethods = [];
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
      this.isCaptchaSolved = true;
      console.log('CAPTCHA rozwiązany:', token);
    },
    saveOrder(){

      const dataToSave = {
        orderData: this.orderData,
        shoppingCart: this.shoppingCartDetails,
        createAccount: this.showRegisterInputs,
        otherShippingAddress: this.showDifferentAddressInputs,
      };

      fetch('includes/add_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataToSave), 
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === 'success') {
            this.showOrderPopup = true;
            this.orderPopupDisplay = this.orderPopupDisplay === 'none' ? 'block' : 'none';
            this.orderNumber = data.orderNumber;
          }
        })
        .catch((error) => {
          console.error('Wystąpił błąd podczas składania zamówienia:', error);
        });

    },
  },

})

app.mount('.container')
