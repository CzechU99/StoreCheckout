document.getElementById('register_checkbox').addEventListener('change', function(){
  const passwordInput = document.getElementById('password_input');
  const plainPasswordInput = document.getElementById('plain_password_input');

  if(this.checked){
    passwordInput.style.display = 'block';
    passwordInput.disabled = false;
    plainPasswordInput.style.display = 'block';
    plainPasswordInput.disabled = false;
  }else{
    passwordInput.style.display = 'none';
    passwordInput.disabled = true;
    plainPasswordInput.style.display = 'none';
    plainPasswordInput.disabled = true;
  }
});

document.getElementById('second_address_checkbox').addEventListener('change', function(){
  const secondAddress = document.getElementById('second_address_input');
  const secondPostalCode = document.getElementById('second_postal_code_input');
  const secondCity = document.getElementById('second_city_input');

  if(this.checked){
    secondAddress.style.display = 'block';
    secondAddress.disabled = false;
    secondPostalCode.style.display = 'block';
    secondPostalCode.disabled = false;
    secondCity.style.display = 'block';
    secondCity.disabled = false;
  }else{
    secondAddress.style.display = 'none';
    secondAddress.disabled = true;
    secondPostalCode.style.display = 'none';
    secondPostalCode.disabled = true;
    secondCity.style.display = 'none';
    secondCity.disabled = true;
  }
});

document.getElementsByClassName('delivery_methods_input')[0].addEventListener('change', function(){
  const payuPaymentOption = document.getElementsByClassName('payment_option')[0];
  const walletPaymentOption = document.getElementsByClassName('payment_option')[1];
  const chequePaymentOption = document.getElementsByClassName('payment_option')[2];

  const payuPaymentButton = document.getElementsByClassName('payment_radio_btn')[0];
  const walletPaymentButton = document.getElementsByClassName('payment_radio_btn')[1];
  const chequePaymentButton = document.getElementsByClassName('payment_radio_btn')[2];

  if(this.checked){
    payuPaymentOption.style.display = 'block';
    payuPaymentButton.disabled = false;
    payuPaymentButton.checked = false;
    walletPaymentOption.style.display = 'block';
    walletPaymentButton.disabled = false;
    walletPaymentButton.checked = false;
    chequePaymentOption.style.display = 'block';
    chequePaymentButton.disabled = false;
    chequePaymentButton.checked = false;
  } 
});

document.getElementsByClassName('delivery_methods_input')[1].addEventListener('change', function(){
  const payuPaymentOption = document.getElementsByClassName('payment_option')[0];
  const walletPaymentOption = document.getElementsByClassName('payment_option')[1];
  const chequePaymentOption = document.getElementsByClassName('payment_option')[2];

  const payuPaymentButton = document.getElementsByClassName('payment_radio_btn')[0];
  const walletPaymentButton = document.getElementsByClassName('payment_radio_btn')[1];
  const chequePaymentButton = document.getElementsByClassName('payment_radio_btn')[2];

  if(this.checked){
    payuPaymentOption.style.display = 'block';
    payuPaymentButton.disabled = false;
    payuPaymentButton.checked = false;
    walletPaymentOption.style.display = 'none';
    walletPaymentButton.disabled = true;
    walletPaymentButton.checked = false;
    chequePaymentOption.style.display = 'block';
    chequePaymentButton.disabled = false;
    chequePaymentButton.checked = false;
  } 
});

document.getElementsByClassName('delivery_methods_input')[2].addEventListener('change', function(){
  const payuPaymentOption = document.getElementsByClassName('payment_option')[0];
  const walletPaymentOption = document.getElementsByClassName('payment_option')[1];
  const chequePaymentOption = document.getElementsByClassName('payment_option')[2];

  const payuPaymentButton = document.getElementsByClassName('payment_radio_btn')[0];
  const walletPaymentButton = document.getElementsByClassName('payment_radio_btn')[1];
  const chequePaymentButton = document.getElementsByClassName('payment_radio_btn')[2];

  if(this.checked){
    payuPaymentOption.style.display = 'none';
    payuPaymentButton.disabled = true;
    payuPaymentButton.checked = false;
    walletPaymentOption.style.display = 'block';
    walletPaymentButton.disabled = false;
    walletPaymentButton.checked = false;
    chequePaymentOption.style.display = 'none';
    chequePaymentButton.disabled = true;
    chequePaymentButton.checked = false;
  } 
});

document.getElementsByClassName('discount_button')[0].addEventListener('click', function(){
  const discountButton = document.getElementsByClassName('discount_button')[0];
  const discountCodeInput = document.getElementsByClassName('discount_input')[0];
  const activateDiscountButton = document.getElementsByClassName('activate_discount_button')[0];

  if(!discountButton.classList.contains('clicked')){
    discountButton.classList.add('clicked');
    discountButton.style.color = 'white';
    discountButton.style.backgroundColor = '#A89F8F';
    discountCodeInput.style.display = 'block'; 
    discountCodeInput.disabled = false; 
    activateDiscountButton.style.display = 'block';
  }else{
    discountButton.classList.remove('clicked');
    discountCodeInput.style.display = 'none'; 
    discountButton.style.color = '#A89F8F';
    discountButton.style.backgroundColor = 'white';
    discountCodeInput.disabled = true; 
    activateDiscountButton.style.display = 'none';
  }
});

document.getElementsByClassName('discount_button')[0].onmouseover = function(){
  if(this.classList.contains('clicked')){
    this.style.backgroundColor = 'white';
    this.style.color = '#A89F8F';
  }else{
    this.style.backgroundColor = '#A89F8F';
    this.style.color = 'white';
  }
}

document.getElementsByClassName('discount_button')[0].onmouseout = function(){
  if(this.classList.contains('clicked')){
    this.style.backgroundColor = '#A89F8F';
    this.style.color = 'white';
  }else{
    this.style.backgroundColor = 'white';
    this.style.color = '#A89F8F';
  }
}

document.getElementsByClassName('login_button')[0].addEventListener('click', function(){
  const popupLogin = document.getElementsByClassName('popup_login')[0];
  popupLogin.style.display = 'block';
});

document.getElementsByClassName('popup_login')[0].addEventListener('click', function(){
  const popupLogin = document.getElementsByClassName('popup_login')[0];
  popupLogin.style.display = 'none';
});

document.getElementsByClassName('close_popup')[0].addEventListener('click', function(){
  const popupLogin = document.getElementsByClassName('popup_login')[0];
  popupLogin.style.display = 'none';
});

document.getElementsByClassName('accept_button')[0].addEventListener('click', function(){
  const popupLogin = document.getElementsByClassName('popup_login')[0];
  popupLogin.style.display = 'none';
});

document.getElementsByClassName('login_form')[0].addEventListener('click', function(event){
  event.stopPropagation();
});

document.getElementsByClassName('accept_button')[1].addEventListener('click', function(){
  const popupOrder = document.getElementsByClassName('popup_numer_zamowienia')[0];
  popupOrder.style.display = 'none';
});

document.getElementsByClassName('popup_numer_zamowienia')[0].addEventListener('click', function(){
  const popupOrder = document.getElementsByClassName('popup_numer_zamowienia')[0];
  popupOrder.style.display = 'none';
});

document.getElementsByClassName('close_popup')[1].addEventListener('click', function(){
  const popupOrder = document.getElementsByClassName('popup_numer_zamowienia')[0];
  popupOrder.style.display = 'none';
});

document.getElementsByClassName('order_info')[0].addEventListener('click', function(event){
  event.stopPropagation();
});


function onCaptchaSuccess() {
  document.getElementById('captchaOverlay').style.display = 'none';

  const token = grecaptcha.getResponse();
  console.log('CAPTCHA rozwiązany:', token);
}

document.getElementById('save_data').addEventListener('click', function(){
  const inputsUser = document.getElementsByClassName('data_users'); 
  const inputsSecondAddress = document.getElementsByClassName('data_second_address'); 
  
  const inputCreateAccount = document.getElementsByClassName('data_create_account')[0].checked; 
  const inputNewsletter = document.getElementsByClassName('data_newsletter')[0].checked; 
  const inputShippindAddress = document.getElementById('second_address_checkbox').checked; 

  const orderComment = document.getElementsByClassName('data_comment')[0].value; 
  const orderDelivery = document.querySelector('input[name="delivery_option"]:checked').value; 
  const orderPayment = document.querySelector('input[name="payment_option"]:checked').value; 


  var [userEmail, userName, userSurname, userCountry, userAddress, userPostalCode, userCity, userPhone] = Array.from(inputsUser).map(input => input.value);

  if(inputShippindAddress){
    var [shippingAddress, shippingCity, shippingPostalCode] = Array.from(inputsSecondAddress).map(input => input.value);
  }else{
    var [shippingAddress, shippingCity, shippingPostalCode] = [userAddress, userCity, userPostalCode];
  }

  var userPassword = inputCreateAccount ? document.getElementById('password_input').value : null;
  var userPlainPassword = inputCreateAccount ? document.getElementById('plain_password_input').value : null;

  const orderData = {
    user: {
      email: userEmail,
      password: userPassword,
      plainPassword: userPlainPassword,
      name: userName,
      surname: userSurname,
      country: userCountry,
      address: userAddress,
      postal_code: userPostalCode,
      city: userCity,
      phone: userPhone,
      newsletter: inputNewsletter
    },
    shippingAddress: {
      address: shippingAddress,
      city: shippingCity,
      postal_code: shippingPostalCode 
    },
    deliveryMethod: orderDelivery,
    paymentMethod: orderPayment,
    comment: orderComment,
    created_at: new Date().toISOString(),
  };

  const productDiv = document.getElementsByClassName('products_list')[0];
  const productData = JSON.parse(productDiv.getAttribute('data-products'));

  orderData.products = productData;

  const xhr = new XMLHttpRequest();

  xhr.open('POST', 'includes/add_order.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');

  xhr.onload = function (){
    if(xhr.status === 200) {
    
      const response = JSON.parse(xhr.responseText);
      if(response.status === 'success'){
        const orderPopup = document.getElementsByClassName('popup_numer_zamowienia')[0];
        const orderMessage = document.getElementsByClassName('order_message')[0];

        orderMessage.textContent = `Twój numer zamówienia to: ${response.orderNumber}`;
        orderPopup.style.display = 'block';
      }
    
    } 
  };

  xhr.send(JSON.stringify(orderData));

});
