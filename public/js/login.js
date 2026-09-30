/* Login: obtiene un token reCAPTCHA v3 justo antes de enviar. */
(function () {
  var form = document.getElementById('loginForm');
  if (!form) return;
  var key = form.getAttribute('data-sitekey');
  form.addEventListener('submit', function (e) {
    if (!key || form.dataset.ready === '1') return;
    e.preventDefault();
    var btn = form.querySelector('button[type=submit]'); btn.disabled = true;
    if (!window.grecaptcha) { form.dataset.ready = '1'; form.submit(); return; }
    grecaptcha.ready(function () {
      grecaptcha.execute(key, { action: 'login' }).then(function (token) {
        document.getElementById('recaptchaToken').value = token;
        form.dataset.ready = '1'; form.submit();
      }).catch(function () { btn.disabled = false; alert('No se pudo cargar reCAPTCHA. Recarga la página.'); });
    });
  });
})();
