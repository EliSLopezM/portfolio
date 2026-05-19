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
  const toggle = document.getElementById('navToggle');
  const navLinks = document.querySelector('.nav-links');
  if (toggle && navLinks) {
    toggle.addEventListener('click', () => {
      navLinks.classList.toggle('open');
    });
    /* Cierra el menú al hacer click en un link */
    navLinks.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => navLinks.classList.remove('open'));
    });
  }

  /* ── SMOOTH scroll active link ── */
  const sections = document.querySelectorAll('section[id]');
  const links    = document.querySelectorAll('.nav-links a');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        links.forEach(l => l.classList.remove('active'));
        const target = document.querySelector(`.nav-links a[href="#${entry.target.id}"]`);
        if (target) target.classList.add('active');
      }
    });
  }, { threshold: 0.4 });
  sections.forEach(s => observer.observe(s));

  /* ── FADE-IN on scroll ── */
  const fadeEls = document.querySelectorAll('.project-card, .stack-item, .timeline-item, .stat-item');
  const fadeObs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        fadeObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  fadeEls.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.transition = 'opacity 0.45s ease, transform 0.45s ease';
    fadeObs.observe(el);
  });

  /* ── LANG BAR animation ── */
  const langFills = document.querySelectorAll('.lang-fill');
  const langObs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const w  = el.style.width;
        el.style.width = '0';
        requestAnimationFrame(() => {
          el.style.transition = 'width 0.8s ease';
          el.style.width = w;
        });
        langObs.unobserve(el);
      }
    });
  }, { threshold: 0.5 });
  langFills.forEach(el => langObs.observe(el));

});
