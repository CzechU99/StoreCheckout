const app = Vue.createApp({

  data(){
    return{
      formConfig: {
        createAccount: false,
        differentAddress: false,
        shippingMethods: [],
        paymentMethods: [],
        shoppingCartDetails: [],
        isCaptchaSolved: false,
        orderNumber: null,
        validCodes: [],
      },
      formStyle: {
        showLoginPopup: false,
        showLoginPopupDisplay: 'none',
        showRegisterInputs: false,
        showRegisterInputsDisplay: 'none',
        showDifferentAddressInputs: false,
        showDifferentAddressInputsDisplay: 'none',
        showDiscountCode: false,
        showDiscountCodeDisplay: 'none',
        showOrderPopup: false,
        showOrderPopupDisplay: 'none',
      }, 
      formErrors: {
        discountCodeError: '',
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
    this.fetchData();
    window.onCaptchaSuccess = this.onCaptchaSuccess;
  },
  methods: {
    toggleVisibility(field) {
      this.formStyle[field] = !this.formStyle[field];
      this.formStyle[`${field}Display`] = this.formStyle[`${field}Display`] === 'none' ? 'block' : 'none';
    },
    async fetchData(){
      try {
        const [shippingResponse, paymentResponse, cartResponse] = await Promise.all([
          axios.get("http://localhost/storeCheckout/api/shippingMethods.php"),
          axios.get("http://localhost/storeCheckout/api/paymentMethods.php"),
          axios.get("http://localhost/storeCheckout/api/shoppingCart.php")
        ]);
        this.formConfig.shippingMethods = shippingResponse.data;
        this.formConfig.paymentMethods = paymentResponse.data;
        this.formConfig.shoppingCartDetails = cartResponse.data;
      } catch (error) {
        console.error("Błąd podczas ładowania danych:", error);
      }
    },
    async fetchDiscountCodes(){
      try {
        const response = await axios.get("http://localhost/storeCheckout/api/discountCodes.php");
        this.formConfig.validCodes = response.data; 
      } catch (error) {
        console.error("Błąd podczas ładowania kodów zniżkowych:", error);
      }
    },
    async fetchShoppingCart(){
      try {
        const response = await axios.get("http://localhost/storeCheckout/api/shoppingCart.php");
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

      const dataToSave = {
        orderData: this.orderData,
        shoppingCart: this.formConfig.shoppingCartDetails,
        createAccount: this.formStyle.showRegisterInputs,
        otherShippingAddress: this.formStyle.showDifferentAddressInputs,
      };

      fetch('includes/add_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataToSave), 
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === 'success') {
            this.formStyle.showOrderPopup = true;
            this.formStyle.showOrderPopupDisplay = this.formStyle.showOrderPopupDisplay === 'none' ? 'block' : 'none';
            this.formConfig.orderNumber = data.orderNumber;
          }
        })
        .catch((error) => {
          console.error('Wystąpił błąd podczas składania zamówienia:', error);
        });

    },
    clearErrorInfo(){
      this.formErrors.discountCodeError = "";
    },
    addDiscountCode(){

      const matchingCode = this.formConfig.validCodes.find(
        (codeDetails) => this.orderData.discountCode === codeDetails.code
      );

      if (matchingCode) {
        this.orderData.discountCodeId = matchingCode.id;
        this.orderData.discountPercentage = matchingCode.discount_percent;
        this.formErrors.discountCodeError = "";
        document.getElementsByClassName('discount_input')[0].style.width = '80%';

        this.formConfig.shoppingCartDetails.subtotalPrice = 0;
        this.formConfig.shoppingCartDetails.totalPrice = 0; 

        this.formConfig.shoppingCartDetails.shoppingCart.forEach(product => {
          const discount = (this.orderData.discountPercentage / 100) * product.product.price;
          product.product.price = parseFloat((product.product.price - discount).toFixed(2));
          
          this.formConfig.shoppingCartDetails.subtotalPrice += product.product.price;
          this.formConfig.shoppingCartDetails.totalPrice += product.product.price * product.quantity; 
        });

      } else {
        this.formErrors.discountCodeError = "Podany kod jest nieaktywny!";
        this.orderData.discountCode = null;
      }

    },
    deleteDiscountCode(){
      document.getElementsByClassName('discount_input')[0].style.width = '100%';
      this.orderData.discountCode = null;
      this.orderData.discountCodeId = null;
      this.orderData.discountPercentage = null;
      this.fetchShoppingCart();
    },
  },

})

app.mount('.container')