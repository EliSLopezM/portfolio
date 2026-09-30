/* Me gusta + compartir/copiar enlace en los blogs. */
(function () {
  var box = document.querySelector('.post-engage');
  if (!box) return;
  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content;

  var like = box.querySelector('.pe-like');
  like.addEventListener('click', function () {
    like.disabled = true;
    fetch(box.getAttribute('data-like-url'), { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }, credentials: 'same-origin' })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
      .then(function (d) {
        like.classList.toggle('is-liked', d.liked);
        like.setAttribute('aria-pressed', d.liked ? 'true' : 'false');
        like.querySelector('.pe-like-count').textContent = d.likes.toLocaleString('es-CO');
      })
      .catch(function () {})
      .then(function () { like.disabled = false; });
  });

  var copy = box.querySelector('.pe-copy');
  copy.addEventListener('click', function () {
    var url = copy.getAttribute('data-copy'), label = copy.textContent;
    var done = function () { copy.textContent = '¡Enlace copiado!'; setTimeout(function () { copy.textContent = label; }, 1800); };
    if (navigator.clipboard) { navigator.clipboard.writeText(url).then(done, function () { window.prompt('Copia el enlace:', url); }); }
    else { window.prompt('Copia el enlace:', url); }
  });

  var native = box.querySelector('.pe-native');
  if (navigator.share) {
    native.hidden = false;
    native.addEventListener('click', function () {
      navigator.share({ title: box.getAttribute('data-title'), text: box.getAttribute('data-excerpt'), url: box.getAttribute('data-url') }).catch(function () {});
    });
  }
})();
