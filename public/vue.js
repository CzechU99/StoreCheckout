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
        orderPopupText: null,
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
        discountCodeError: null,
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

      fetch('includes/add_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataToSave), 
      })
        .then((response) => response.json())
        .then((data) => {
          if(data.status === 'success'){
            this.formStyle.showOrderPopup = true;
            this.formStyle.showOrderPopupDisplay = this.formStyle.showOrderPopupDisplay === 'none' ? 'block' : 'none';
            this.formConfig.orderPopupText = data.orderNumber;
          }else if(data.status === 'validError'){
            this.formStyle.showOrderPopup = true;
            this.formStyle.showOrderPopupDisplay = this.formStyle.showOrderPopupDisplay === 'none' ? 'block' : 'none';
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
        this.formErrors.discountCodeError = null;
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
          this.formStyle.showOrderPopupDisplay = this.formStyle.showOrderPopupDisplay === 'none' ? 'block' : 'none';
          this.formConfig.orderPopupText = "Uzupełnij wszystkie dane!";
          isValid = false;
          break;
        }
      }
      return isValid;
    }
  },

})

app.mount('.container')