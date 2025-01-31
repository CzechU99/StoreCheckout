<script setup>

  import { ref, onMounted } from 'vue';

  const isCaptchaSolved = ref(false);

  const onCaptchaSuccess = () => {
    const token = grecaptcha.getResponse();
    if(token){
      isCaptchaSolved.value = true;
      document.getElementById('captchaOverlay').style.display = 'none';
      console.log('CAPTCHA rozwiązany:', token);
    }
  };

  onMounted(() => {
    window.onCaptchaSuccess = onCaptchaSuccess;

    setTimeout(() => {
      if (window.grecaptcha) {
        window.grecaptcha.render(document.querySelector('.g-recaptcha'));
      } else {
        console.error("reCAPTCHA script not loaded");
      }
    }, 100);
  });

</script>

<template>

  <div id="captchaOverlay">
    <div id="captchaBox">
      <div class="g-recaptcha"
          data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
          data-callback="onCaptchaSuccess"
          data-size="normal">
      </div>
    </div>
  </div>

</template>

<script>

</script>