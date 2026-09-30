/* Dashboard: confirmaciones, selección masiva, orden por arrastre, copiar enlaces y editor. Sin inline JS (CSP). */
(function () {
  'use strict';
  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content;

  // ── Confirmación de acciones destructivas ──
  document.addEventListener('submit', function (e) {
    var msg = e.target.getAttribute('data-confirm');
    if (msg && !window.confirm(msg)) e.preventDefault();
  });

  // ── Seleccionar todos ──
  document.querySelectorAll('[data-select-all]').forEach(function (master) {
    master.addEventListener('change', function () {
      document.querySelectorAll(master.getAttribute('data-select-all')).forEach(function (c) { c.checked = master.checked; });
    });
  });

  // ── Copiar al portapapeles ──
  document.querySelectorAll('[data-copy]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var text = btn.getAttribute('data-copy'), label = btn.textContent;
      (navigator.clipboard ? navigator.clipboard.writeText(text) : Promise.reject()).catch(function () {
        var t = document.createElement('textarea'); t.value = text; document.body.appendChild(t); t.select(); document.execCommand('copy'); t.remove();
      }).then(function () { btn.textContent = '¡Copiado!'; setTimeout(function () { btn.textContent = label; }, 1500); });
    });
  });

  // ── Ordenar (arrastrar y botones ▲▼) ──
  document.querySelectorAll('[data-sortable]').forEach(function (list) {
    var url = list.getAttribute('data-sortable'), dragged = null;
    function save() {
      var ids = Array.prototype.map.call(list.children, function (li) { return li.getAttribute('data-id'); });
      fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }, body: JSON.stringify({ ids: ids }) })
        .then(function (r) { if (!r.ok) throw new Error(); }).catch(function () { alert('No se pudo guardar el orden. Recarga la página.'); });
    }
    function child(node) { while (node && node.parentElement !== list) node = node.parentElement; return node && node.hasAttribute && node.hasAttribute('data-id') ? node : null; }
    list.addEventListener('dragstart', function (e) {
      var li = child(e.target); if (!li) return;
      e.stopPropagation(); dragged = li; li.classList.add('dragging'); e.dataTransfer.effectAllowed = 'move'; e.dataTransfer.setData('text/plain', '');
    });
    list.addEventListener('dragend', function () { if (dragged) dragged.classList.remove('dragging'); dragged = null; });
    list.addEventListener('dragover', function (e) {
      if (!dragged) return; e.preventDefault();
      var target = child(e.target); if (!target || target === dragged) return;
      var r = target.getBoundingClientRect();
      var after = list.classList.contains('media-grid') ? e.clientX > r.left + r.width / 2 : e.clientY > r.top + r.height / 2;
      list.insertBefore(dragged, after ? target.nextSibling : target);
    });
    list.addEventListener('drop', function (e) { if (!dragged) return; e.preventDefault(); e.stopPropagation(); save(); });
    list.addEventListener('click', function (e) {
      var b = e.target.closest('[data-move]'); if (!b) return;
      var li = child(b); if (!li) return;
      if (b.getAttribute('data-move') === 'up' && li.previousElementSibling) list.insertBefore(li, li.previousElementSibling);
      else if (b.getAttribute('data-move') === 'down' && li.nextElementSibling) list.insertBefore(li.nextElementSibling, li);
      else return;
      save();
    });
  });

  // ── Aviso si la imagen elegida es más pequeña que el tamaño ideal ──
  document.querySelectorAll('input[type=file][data-w]').forEach(function (input) {
    input.addEventListener('change', function () {
      var warn = input.parentElement.querySelector('.img-warn'); if (!warn) return;
      warn.hidden = true; warn.textContent = '';
      Array.prototype.forEach.call(input.files, function (file) {
        var url = URL.createObjectURL(file), img = new Image();
        img.onload = function () {
          var w = +input.dataset.w, h = +input.dataset.h || 0;
          if (img.width < w || (h && img.height < h)) {
            warn.hidden = false;
            warn.textContent += '⚠ «' + file.name + '» mide ' + img.width + '×' + img.height + ' px: es menor que el ideal y se verá borrosa. ';
          }
          URL.revokeObjectURL(url);
        };
        img.src = url;
      });
    });
  });

  // ── Editor de blogs ──
  var area = document.getElementById('editorArea');
  if (!area) return;
  var field = document.getElementById('contentField'), form = area.closest('form');
  area.innerHTML = field.value;
  var sync = function () { field.value = area.innerHTML; };
  area.addEventListener('input', sync);
  form.addEventListener('submit', sync);
  function cmd(name, val) { area.focus(); document.execCommand(name, false, val || null); sync(); }
  var actions = {
    h2: function () { cmd('formatBlock', 'H2'); }, h3: function () { cmd('formatBlock', 'H3'); }, p: function () { cmd('formatBlock', 'P'); },
    bold: function () { cmd('bold'); }, italic: function () { cmd('italic'); }, ul: function () { cmd('insertUnorderedList'); }, ol: function () { cmd('insertOrderedList'); },
    quote: function () { cmd('formatBlock', 'BLOCKQUOTE'); }, clear: function () { cmd('removeFormat'); },
    link: function () { var u = prompt('URL (https://…)'); if (u && /^(https?:|mailto:)/i.test(u)) cmd('createLink', u); },
    table: function () {
      var r = parseInt(prompt('Filas', '3'), 10), c = parseInt(prompt('Columnas', '3'), 10);
      if (!(r > 0 && c > 0) || r > 30 || c > 10) return;
      var h = '<table><thead><tr>' + '<th>Título</th>'.repeat(c) + '</tr></thead><tbody>';
      for (var i = 1; i < r; i++) h += '<tr>' + '<td>&nbsp;</td>'.repeat(c) + '</tr>';
      cmd('insertHTML', h + '</tbody></table><p><br></p>');
    },
    image: function () { document.getElementById('inlineImage').click(); }
  };
  document.querySelectorAll('[data-cmd]').forEach(function (b) { b.addEventListener('click', function (e) { e.preventDefault(); actions[b.getAttribute('data-cmd')](); }); });

  var sizeSel = document.getElementById('imgSize'), selected = null;
  area.addEventListener('click', function (e) {
    if (selected) selected.classList.remove('sel');
    selected = e.target.tagName === 'IMG' ? e.target : null;
    if (selected) { selected.classList.add('sel'); sizeSel.value = selected.getAttribute('width') || ''; }
  });
  sizeSel.addEventListener('change', function () {
    if (!selected) return;
    if (sizeSel.value) selected.setAttribute('width', sizeSel.value); else selected.removeAttribute('width');
    selected.removeAttribute('height'); sync();
  });

  var input = document.getElementById('inlineImage');
  input.addEventListener('change', function () {
    if (!input.files[0]) return;
    var fd = new FormData(); fd.append('image', input.files[0]);
    fetch(input.getAttribute('data-url'), { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }, body: fd })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
      .then(function (d) {
        var alt = prompt('Texto alternativo de la imagen (SEO y accesibilidad)', '') || '';
        var w = sizeSel.value ? Math.min(+sizeSel.value, d.width || 9999) : '';
        cmd('insertHTML', '<img src="' + d.url + '" alt="' + alt.replace(/"/g, '&quot;') + '"' + (w ? ' width="' + w + '"' : '') + '><p><br></p>');
      })
      .catch(function () { alert('No se pudo subir la imagen (máx. 5 MB, JPG/PNG/WEBP/GIF).'); })
      .then(function () { input.value = ''; });
  });

  // ── SEO en vivo ──
  var seoUrl = form.getAttribute('data-seo-url'), timer;
  function el(id) { return document.getElementById(id); }
  function counter(inputId, max) { var i = el(inputId), c = el(inputId + 'Count'); if (!i || !c) return; var n = (i.value || i.placeholder || '').length; c.textContent = n + '/' + max; c.classList.toggle('warn', n > max); }
  function preview() {
    var t = el('meta_title').value || el('meta_title').placeholder, d = el('meta_description').value || el('meta_description').placeholder;
    el('pvTitle').textContent = t || 'Título del artículo'; el('pvDesc').textContent = d || '';
    counter('meta_title', 60); counter('meta_description', 160);
  }
  function suggest() {
    sync();
    fetch(seoUrl, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: JSON.stringify({ title: el('title').value, excerpt: el('excerpt').value, content: field.value, category: el('category').value }) })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
      .then(function (d) { el('meta_title').placeholder = d.title; el('meta_description').placeholder = d.description; el('keywords').placeholder = d.keywords; el('readTime').textContent = d.minutes + ' min de lectura'; preview(); })
      .catch(function () {});
  }
  ['title', 'excerpt', 'category'].forEach(function (id) { el(id).addEventListener('input', function () { clearTimeout(timer); timer = setTimeout(suggest, 600); }); });
  area.addEventListener('input', function () { clearTimeout(timer); timer = setTimeout(suggest, 900); });
  ['meta_title', 'meta_description'].forEach(function (id) { el(id).addEventListener('input', preview); });
  var apply = el('applySeo');
  if (apply) apply.addEventListener('click', function () { ['meta_title', 'meta_description', 'keywords'].forEach(function (id) { el(id).value = el(id).placeholder; }); preview(); });
  suggest();
})();
