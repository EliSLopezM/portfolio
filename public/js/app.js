/* app.js — Portfolio Eli Santiago López */

document.addEventListener('DOMContentLoaded', () => {

  /* ── NAV: scroll effect ── */
  const navbar = document.getElementById('navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });
  }

  /* ── NAV: mobile toggle ── */
  const toggle   = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');
  if (toggle && navLinks) {
    toggle.addEventListener('click', () => navLinks.classList.toggle('open'));
    navLinks.querySelectorAll('a').forEach(a =>
      a.addEventListener('click', () => navLinks.classList.remove('open'))
    );
  }

  /* ── NAV: active link on scroll ── */
  const sections = document.querySelectorAll('section[id]');
  const links    = document.querySelectorAll('.nav-link');

  if (sections.length && links.length) {
    const obs = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const id = entry.target.id;
        links.forEach(l => {
          const href = l.getAttribute('href') || '';
          const match = href.includes('#' + id) || href.endsWith('/' + id);
          l.classList.toggle('active', match);
        });
      });
    }, { threshold: 0.35, rootMargin: '-58px 0px 0px 0px' });
    sections.forEach(s => obs.observe(s));
  }

  /* ── FADE-IN on scroll ── */
  const fadeEls = document.querySelectorAll(
    '.project-card, .stack-item, .timeline-item, .stat-item, .cert-card'
  );
  const fadeObs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        fadeObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

  fadeEls.forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(18px)';
    el.style.transition = `opacity 0.45s ${i * 0.04}s ease, transform 0.45s ${i * 0.04}s ease`;
    fadeObs.observe(el);
  });

  /* ── LANG BAR animation ── */
  document.querySelectorAll('.lang-fill').forEach(el => {
    const w = el.style.width;
    el.style.width = '0';
    const lo = new IntersectionObserver(entries => {
      if (entries[0].isIntersecting) {
        el.style.transition = 'width 0.9s ease';
        el.style.width = w;
        lo.disconnect();
      }
    }, { threshold: 0.5 });
    lo.observe(el);
  });

  /* ── CERTIFICATIONS CAROUSEL (auto-scroll) ── */
  const track    = document.getElementById('certTrack');
  const viewport = document.getElementById('certViewport');
  const dotsWrap = document.getElementById('certDots');
  const prevBtn  = document.getElementById('certPrev');
  const nextBtn  = document.getElementById('certNext');

  if (track && prevBtn && nextBtn) {
    const cards   = Array.from(track.querySelectorAll('.cert-card'));
    const total   = cards.length;
    if (total === 0) return;

    const cardW   = () => cards[0].offsetWidth + 20;
    const visible = () => Math.max(1, Math.floor((viewport ? viewport.offsetWidth : 800) / cardW()));
    const maxIdx  = () => Math.max(0, total - visible());
    let current   = 0;
    let autoTimer = null;

    if (dotsWrap) {
      for (let i = 0; i <= maxIdx(); i++) {
        const dot = document.createElement('button');
        dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
        dot.addEventListener('click', () => { goTo(i); resetAuto(); });
        dotsWrap.appendChild(dot);
      }
    }

    function goTo(idx) {
      current = Math.max(0, Math.min(idx, maxIdx()));
      track.style.transform = `translateX(-${current * cardW()}px)`;
      if (prevBtn) prevBtn.disabled = current === 0;
      if (nextBtn) nextBtn.disabled = current >= maxIdx();
      if (dotsWrap) {
        dotsWrap.querySelectorAll('.carousel-dot').forEach((d, i) =>
          d.classList.toggle('active', i === current)
        );
      }
    }

    function autoNext() {
      goTo(current >= maxIdx() ? 0 : current + 1);
    }

    function startAuto() { autoTimer = setInterval(autoNext, 3000); }
    function resetAuto()  { clearInterval(autoTimer); startAuto(); }

    prevBtn.addEventListener('click', () => { goTo(current - 1); resetAuto(); });
    nextBtn.addEventListener('click', () => { goTo(current + 1); resetAuto(); });

    track.addEventListener('mouseenter', () => clearInterval(autoTimer));
    track.addEventListener('mouseleave', () => startAuto());

    let startX = 0;
    track.addEventListener('touchstart', e => { startX = e.touches[0].clientX; clearInterval(autoTimer); }, { passive: true });
    track.addEventListener('touchend', e => {
      const diff = startX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) goTo(diff > 0 ? current + 1 : current - 1);
      startAuto();
    });

    goTo(0);
    startAuto();
  }

  /* ── EMAIL MODAL ── */
  const emailBtn   = document.getElementById('emailBtn');
  const emailModal = document.getElementById('emailModal');
  const emailClose = document.getElementById('emailModalClose');

  if (emailBtn && emailModal) {
    emailBtn.addEventListener('click', () => emailModal.classList.add('open'));
    emailClose.addEventListener('click', () => emailModal.classList.remove('open'));
    emailModal.addEventListener('click', e => {
      if (e.target === emailModal) emailModal.classList.remove('open');
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') emailModal.classList.remove('open');
    });
  }

  /* ── COUNTRY PICKER ── */
  document.querySelectorAll('[data-country-picker]').forEach(picker => {
    const button = picker.querySelector('.country-picker-button');
    const menu = picker.querySelector('.country-picker-menu');
    const isoInput = picker.querySelector('input[name="phone_country_iso"]');
    const codeInput = picker.querySelector('input[name="phone_country_code"]');
    const label = picker.querySelector('[data-country-label]');
    const flag = picker.querySelector('[data-country-flag]');
    const options = picker.querySelectorAll('.country-option');

    function selectCountry(option) {
      const country = option.dataset.country.toLowerCase();
      isoInput.value = option.dataset.country;
      codeInput.value = option.dataset.code;
      label.textContent = option.dataset.label;
      flag.className = `fi fi-${country} country-flag`;
      options.forEach(item => item.setAttribute('aria-selected', item === option ? 'true' : 'false'));
    }

    const initial = [...options].find(option => option.dataset.country === isoInput.value) || options[0];
    if (initial) selectCountry(initial);

    button.addEventListener('click', () => {
      const isOpen = picker.classList.toggle('is-open');
      button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      if (isOpen) menu.focus();
    });
    options.forEach(option => option.addEventListener('click', () => {
      selectCountry(option);
      picker.classList.remove('is-open');
      button.setAttribute('aria-expanded', 'false');
      button.focus();
    }));
    document.addEventListener('click', event => {
      if (!picker.contains(event.target)) {
        picker.classList.remove('is-open');
        button.setAttribute('aria-expanded', 'false');
      }
    });
  });

  /* ── CURSOR PERSONALIZADO ── */
  const dot  = document.getElementById('cursorDot');
  const ring = document.getElementById('cursorRing');

  if (dot && ring) {
    document.body.classList.add('has-custom-cursor');
    document.addEventListener('mousemove', e => {
      dot.style.left  = e.clientX + 'px';
      dot.style.top   = e.clientY + 'px';
      ring.style.left = e.clientX + 'px';
      ring.style.top  = e.clientY + 'px';
    });
    document.querySelectorAll('a, button, .btn, .project-card, .stack-item').forEach(el => {
      el.addEventListener('mouseenter', () => ring.classList.add('hover'));
      el.addEventListener('mouseleave', () => ring.classList.remove('hover'));
    });
  }

});

/* =============================================
   STACK TOGGLE JS — va en public/js/app.js
   Busca el bloque de stackToggle y reemplázalo
   ============================================= */

// Stack — Ver más / Ver menos
(function () {
    const btn      = document.getElementById('stackToggle');
    const cards    = document.querySelectorAll('.stack-card.stack-hidden');
    const iconGrid = btn ? btn.querySelector('.icon-grid') : null;
    const iconCol  = btn ? btn.querySelector('.icon-collapse') : null;
    const txtSpan  = btn ? btn.querySelector('.toggle-text') : null;

    if (!btn || !cards.length) return;

    let expanded = false;

    btn.addEventListener('click', function () {
        expanded = !expanded;

        cards.forEach(function (card, i) {
            if (expanded) {
                // Quitar clase que oculta + animar entrada escalonada
                card.classList.remove('stack-hidden');
                card.classList.remove('stack-reveal');
                setTimeout(function () {
                    card.classList.add('stack-reveal');
                }, i * 60);
            } else {
                // Volver a ocultar y limpiar animación
                card.classList.add('stack-hidden');
                card.classList.remove('stack-reveal');
            }
        });

        // Actualizar texto e iconos
        if (txtSpan)  txtSpan.textContent       = expanded ? 'Ver menos' : 'Ver más';
        if (iconGrid) iconGrid.style.display    = expanded ? 'none' : '';
        if (iconCol)  iconCol.style.display     = expanded ? ''     : 'none';

        btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');

        // Scroll suave hacia arriba al colapsar
        if (!expanded) {
            document.getElementById('stack')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
})();
/* ── CERT MODAL ── */
function openCertModal(card) {
    var modal  = document.getElementById('certModal');
    var iframe = document.getElementById('certModalIframe');
    var title  = document.getElementById('certModalTitle');
    var link   = document.getElementById('certModalDownload');
    if (!modal || !iframe) return;
    title.textContent = card.getAttribute('data-title') || 'Certificado';
    link.href         = card.getAttribute('data-pdf');
    iframe.src        = card.getAttribute('data-pdf') + '#toolbar=0&view=FitH';
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}
(function () {
    var modal    = document.getElementById('certModal');
    var closeBtn = document.getElementById('certModalClose');
    var iframe   = document.getElementById('certModalIframe');
    if (!modal) return;
    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(function () { if (iframe) iframe.src = ''; }, 300);
    }
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && modal.classList.contains('active')) closeModal(); });
})();

/* ── CERTS SPOTLIGHT ── */
(function () {
    var track    = document.getElementById('certsTrack');
    var dotsWrap = document.getElementById('cscDots');
    var prevBtn  = document.getElementById('cscPrev');
    var nextBtn  = document.getElementById('cscNext');
    var filters  = document.querySelectorAll('.certs-filter-btn');

    if (!track) return;

    var allCards  = Array.from(track.querySelectorAll('.certs-spotlight-card'));
    var visible   = allCards.slice();
    var current   = 0;
    var autoTimer = null;
    var AUTO_DELAY = 5000;

    /* ── Renderizar ── */
    function render() {
        // Primero ocultar TODAS
        allCards.forEach(function(card) {
            card.classList.remove('active', 'adjacent');
            card.style.display = 'none';
        });

        // Mostrar solo las visibles con su posición
        visible.forEach(function(card, i) {
            var diff = i - current;
            card.style.display = '';
            if (diff === 0) {
                card.classList.add('active');
            } else if (Math.abs(diff) === 1) {
                card.classList.add('adjacent');
            } else {
                card.style.display = 'none'; // ocultar las que no son adyacentes
            }
        });

        // Dots
        if (dotsWrap) {
            Array.from(dotsWrap.children).forEach(function(dot, i) {
                dot.classList.toggle('active', i === current);
            });
        }
    }

    /* ── Rebuild dots ── */
    function buildDots() {
        if (!dotsWrap) return;
        dotsWrap.innerHTML = '';
        visible.forEach(function(_, i) {
            var dot = document.createElement('button');
            dot.className = 'csc-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', function() { goTo(i); resetAuto(); });
            dotsWrap.appendChild(dot);
        });
    }

    /* ── Navegar ── */
    function goTo(idx) {
        current = ((idx % visible.length) + visible.length) % visible.length;
        render();
    }

    /* ── Auto-scroll ── */
    function startAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(function() { goTo(current + 1); }, AUTO_DELAY);
    }
    function resetAuto() { startAuto(); }

    /* ── Filtros ── */
    filters.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filters.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var cat = btn.getAttribute('data-filter');
            visible = allCards.filter(function(card) {
                var cardCat = card.getAttribute('data-category') || 'curso';
                return cat === 'all' || cardCat === cat;
            });

            if (visible.length === 0) visible = allCards.slice(); // fallback
            current = 0;
            buildDots();
            render();
            resetAuto();
        });
    });

    /* ── Botones nav ── */
    if (prevBtn) prevBtn.addEventListener('click', function() { goTo(current - 1); resetAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', function() { goTo(current + 1); resetAuto(); });

    /* ── Click en tarjeta adyacente ── */
    allCards.forEach(function(card) {
        card.addEventListener('click', function() {
            var idx = visible.indexOf(card);
            if (idx !== -1 && idx !== current) { goTo(idx); resetAuto(); }
        });
    });

    /* ── Pausa al hover ── */
    track.addEventListener('mouseenter', function() { clearInterval(autoTimer); });
    track.addEventListener('mouseleave', startAuto);

    /* ── Touch swipe ── */
    var startX = 0;
    track.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX; clearInterval(autoTimer);
    }, { passive: true });
    track.addEventListener('touchend', function(e) {
        var diff = startX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 40) goTo(diff > 0 ? current + 1 : current - 1);
        startAuto();
    });

    /* ── Init ── */
    buildDots();
    render();
    startAuto();
})();

/* ── Nav Home Dropdown ── */
(function () {
    var btn      = document.getElementById('navHomeBtn');
    var dropdown = document.getElementById('navHomeDropdown');
    var wrap     = document.getElementById('navHomeWrap');
    if (!btn || !dropdown) return;

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        var open = dropdown.classList.toggle('open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
        if (!wrap.contains(e.target)) {
            dropdown.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            dropdown.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
})();

/* ── Procesos IA — carrusel horizontal automático ── */
(function () {
    var track = document.getElementById('iaTrack');
    if (!track) return;

    var AUTO_DELAY = 3200;
    var timer = null;

    function step() {
        var card = track.querySelector('.ia-card');
        if (!card) return;
        var style = window.getComputedStyle(track);
        var gap = parseFloat(style.columnGap || style.gap) || 20;
        var cardWidth = card.getBoundingClientRect().width + gap;
        var maxScroll = track.scrollWidth - track.clientWidth;

        if (track.scrollLeft >= maxScroll - 4) {
            track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            track.scrollBy({ left: cardWidth, behavior: 'smooth' });
        }
    }

    function start() {
        clearInterval(timer);
        timer = setInterval(step, AUTO_DELAY);
    }
    function stop() { clearInterval(timer); }

    track.addEventListener('mouseenter', stop);
    track.addEventListener('mouseleave', start);
    track.addEventListener('touchstart', stop, { passive: true });
    track.addEventListener('touchend', function () {
        clearInterval(timer);
        setTimeout(start, 2500);
    }, { passive: true });

    start();
})();