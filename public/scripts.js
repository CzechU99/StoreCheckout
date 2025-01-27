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

document.getElementById('paczkomaty_radio_btn').addEventListener('change', function(){
  const payuPaymentOption = document.getElementById('payu_payment_option');
  const walletPaymentOption = document.getElementById('pobranie_payment_option');
  const chequePaymentOption = document.getElementById('przelew_payment_option');

  const payuPaymentButton = document.getElementById('payu_radio_btn');
  const walletPaymentButton = document.getElementById('pobranie_radio_btn');
  const chequePaymentButton = document.getElementById('przelew_radio_btn');

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

document.getElementById('dpd_radio_btn').addEventListener('change', function(){
  const payuPaymentOption = document.getElementById('payu_payment_option');
  const walletPaymentOption = document.getElementById('pobranie_payment_option');
  const chequePaymentOption = document.getElementById('przelew_payment_option');

  const payuPaymentButton = document.getElementById('payu_radio_btn');
  const walletPaymentButton = document.getElementById('pobranie_radio_btn');
  const chequePaymentButton = document.getElementById('przelew_radio_btn');

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

document.getElementById('dpd_pobranie_radio_btn').addEventListener('change', function(){
  const payuPaymentOption = document.getElementById('payu_payment_option');
  const walletPaymentOption = document.getElementById('pobranie_payment_option');
  const chequePaymentOption = document.getElementById('przelew_payment_option');

  const payuPaymentButton = document.getElementById('payu_radio_btn');
  const walletPaymentButton = document.getElementById('pobranie_radio_btn');
  const chequePaymentButton = document.getElementById('przelew_radio_btn');

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

document.getElementsByClassName('login_form')[0].addEventListener('click', function(event){
  event.stopPropagation();
});

function onCaptchaSuccess() {
  // Ukryj CAPTCHA po pomyślnym rozwiązaniu
  document.getElementById('captchaOverlay').style.display = 'none';

  // Możesz również wysłać token do weryfikacji na serwer
  const token = grecaptcha.getResponse();
  console.log('CAPTCHA rozwiązany:', token);
}
