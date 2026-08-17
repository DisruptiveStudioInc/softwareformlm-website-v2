let recaptchaPromise;

export function loadRecaptcha(siteKey) {
  if (!siteKey) {
    return Promise.reject(new Error('A reCAPTCHA site key is required.'));
  }

  if (window.grecaptcha?.execute) {
    return window.grecaptcha.ready(() => window.grecaptcha);
  }

  if (!recaptchaPromise) {
    recaptchaPromise = new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.src = `https://www.google.com/recaptcha/api.js?render=${encodeURIComponent(siteKey)}`;
      script.async = true;
      script.onload = () => window.grecaptcha.ready(() => resolve(window.grecaptcha));
      script.onerror = () => {
        recaptchaPromise = undefined;
        reject(new Error('reCAPTCHA could not be loaded.'));
      };
      document.head.appendChild(script);
    });
  }

  return recaptchaPromise;
}
