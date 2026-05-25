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

  /* ── CURSOR PERSONALIZADO ── */
  const dot  = document.getElementById('cursorDot');
  const ring = document.getElementById('cursorRing');

  if (dot && ring) {
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