(() => {
  const root = document.documentElement;
  const introScreen = document.querySelector('#intro-screen');
  if (introScreen) {
    if (matchMedia('(prefers-reduced-motion: reduce)').matches) {
      introScreen.remove();
    } else {
      window.setTimeout(() => {
        introScreen.classList.add('is-leaving');
        window.setTimeout(() => introScreen.remove(), 750);
      }, 2200);
    }
  }
  const nav = document.querySelector('#site-nav');
  const menuButton = document.querySelector('#menu-button');
  const header = document.querySelector('#site-header');
  const progress = document.querySelector('.scroll-progress');
  const backToTop = document.querySelector('#back-to-top');
  const navLinks = [...document.querySelectorAll('.nav-link')];
  const sections = [...document.querySelectorAll('main section[id]')];

  const closeMenu = () => {
    nav?.classList.add('hidden');
    nav?.classList.remove('flex');
    menuButton?.setAttribute('aria-expanded', 'false');
    menuButton?.setAttribute('aria-label', 'Buka menu');
    if (menuButton) menuButton.innerHTML = '<i class="fa-solid fa-bars" aria-hidden="true"></i>';
  };
  menuButton?.addEventListener('click', () => {
    const expanded = menuButton.getAttribute('aria-expanded') === 'true';
    menuButton.setAttribute('aria-expanded', String(!expanded));
    menuButton.setAttribute('aria-label', expanded ? 'Buka menu' : 'Tutup menu');
    nav?.classList.toggle('hidden', expanded);
    nav?.classList.toggle('flex', !expanded);
    menuButton.innerHTML = `<i class="fa-solid fa-${expanded ? 'bars' : 'xmark'}" aria-hidden="true"></i>`;
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && menuButton?.getAttribute('aria-expanded') === 'true') closeMenu();
  });
  document.addEventListener('click', event => {
    if (menuButton?.getAttribute('aria-expanded') !== 'true') return;
    if (!nav?.contains(event.target) && !menuButton?.contains(event.target)) closeMenu();
  });
  navLinks.forEach(link => link.addEventListener('click', closeMenu));
  nav?.querySelector('.mobile-contact-link')?.addEventListener('click', closeMenu);

  const updateScroll = () => {
    const max = document.documentElement.scrollHeight - innerHeight;
    if (progress) progress.style.width = `${max > 0 ? (scrollY / max) * 100 : 0}%`;
    header?.classList.toggle('shadow-xl', scrollY > 20);
    header?.classList.toggle('shadow-lg', scrollY <= 20);
    header?.classList.toggle('shadow-blue-900/10', scrollY > 20);
    header?.classList.toggle('shadow-blue-900/5', scrollY <= 20);
    backToTop?.classList.toggle('hidden', scrollY < 500);
    backToTop?.classList.toggle('grid', scrollY >= 500);
  };
  addEventListener('scroll', updateScroll, { passive: true });
  addEventListener('resize', () => { if (innerWidth >= 1024) closeMenu(); });
  updateScroll();

  const setActiveNav = id => navLinks.forEach(link => link.classList.toggle('active', link.hash === `#${id}`));
  if ('IntersectionObserver' in window) {
    const navObserver = new IntersectionObserver(entries => {
      const activeEntry = entries.filter(entry => entry.isIntersecting).sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top)[0];
      if (activeEntry) setActiveNav(activeEntry.target.id);
    }, { rootMargin: '-25% 0px -65% 0px', threshold: 0 });
    sections.forEach(section => navObserver.observe(section));
  } else {
    const updateActiveNav = () => {
      const current = [...sections].filter(section => section.getBoundingClientRect().top <= innerHeight * 0.35).at(-1);
      if (current) setActiveNav(current.id);
    };
    addEventListener('scroll', updateActiveNav, { passive: true });
    updateActiveNav();
  }

  const revealItems = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
      if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
    }), { threshold: 0.12 });
    revealItems.forEach(item => observer.observe(item));
  } else revealItems.forEach(item => item.classList.add('is-visible'));

  const themeButtons = [...document.querySelectorAll('.theme-toggle')];
  const syncThemeButton = () => {
    const dark = root.classList.contains('dark');
    themeButtons.forEach(themeButton => {
      themeButton.innerHTML = `<i class="fa-solid fa-${dark ? 'sun' : 'moon'}" aria-hidden="true"></i>`;
      themeButton.setAttribute('aria-label', dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
    });
  };
  syncThemeButton();
  themeButtons.forEach(themeButton => themeButton.addEventListener('click', () => {
    root.classList.toggle('dark');
    try { localStorage.setItem('aziza-theme', root.classList.contains('dark') ? 'dark' : 'light'); } catch (error) { /* Penyimpanan dapat dinonaktifkan browser. */ }
    syncThemeButton();
  }));

  const projects = [...document.querySelectorAll('.project-card')];
  const filterButtons = [...document.querySelectorAll('.filter-btn')];
  const projectDialog = document.querySelector('#project-modal');
  const projectDialogClose = document.querySelector('#project-modal-close');
  let projectDetailTrigger = null;
  const setProjectLink = (link, url) => {
    if (!link) return;
    if (url) {
      link.href = url;
      link.classList.remove('hidden');
    } else {
      link.removeAttribute('href');
      link.classList.add('hidden');
    }
  };
  projects.forEach(project => project.addEventListener('click', () => {
    if (!projectDialog || typeof projectDialog.showModal !== 'function') return;
    projectDetailTrigger = project;
    document.querySelector('#project-modal-title').textContent = project.dataset.title || '';
    document.querySelector('#project-modal-role').textContent = project.dataset.role || '';
    document.querySelector('#project-modal-problem').textContent = project.dataset.problem || '';
    document.querySelector('#project-modal-solution').textContent = project.dataset.solution || '';
    document.querySelector('#project-modal-result').textContent = project.dataset.result?.trim() || 'Hasil dan dampak proyek ini belum didokumentasikan.';
    document.querySelector('#project-modal-category').textContent = project.dataset.categoryLabel || '';
    const image = document.querySelector('#project-modal-image');
    image.src = project.dataset.image || '';
    image.alt = `Tangkapan layar proyek ${project.dataset.title || ''}`;
    const techContainer = document.querySelector('#project-modal-tech');
    const techBadges = (project.dataset.tech || '').split(',').map(tech => tech.trim()).filter(Boolean).map(tech => {
      const badge = document.createElement('span');
      badge.className = 'rounded-md bg-slate-100 px-2.5 py-1 text-xs text-slate-700 dark:bg-slate-700 dark:text-slate-200';
      badge.textContent = tech;
      return badge;
    });
    techContainer.replaceChildren(...techBadges);
    setProjectLink(document.querySelector('#project-modal-github'), project.dataset.github);
    setProjectLink(document.querySelector('#project-modal-demo'), project.dataset.demo);
    setProjectLink(document.querySelector('#project-modal-figma'), project.dataset.figma);
    projectDialog.showModal();
    projectDialogClose?.focus();
  }));
  projectDialogClose?.addEventListener('click', () => projectDialog?.close());
  projectDialog?.addEventListener('click', event => {
    if (event.target === projectDialog) projectDialog.close();
  });
  projectDialog?.addEventListener('keydown', event => {
    if (event.key !== 'Tab') return;
    const focusable = [...projectDialog.querySelectorAll('button:not([hidden]), a:not([hidden])')].filter(item => item.offsetParent !== null);
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (event.shiftKey && (document.activeElement === first || !projectDialog.contains(document.activeElement))) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  });
  projectDialog?.addEventListener('close', () => projectDetailTrigger?.focus());
  filterButtons.forEach(button => button.addEventListener('click', () => {
    const filter = button.dataset.filter;
    filterButtons.forEach(item => {
      const active = item === button;
      item.classList.toggle('active', active);
      item.setAttribute('aria-pressed', String(active));
    });
    projects.forEach(project => {
      const show = filter === 'all' || project.dataset.category === filter;
      project.hidden = !show;
    });
    document.querySelectorAll('[data-project-group]').forEach(group => {
      group.hidden = ![...group.querySelectorAll('.project-card')].some(project => !project.hidden);
    });
  }));

  const contactForm = document.querySelector('#contact-form');
  const contactStatus = document.querySelector('#contact-form-status');
  contactForm?.addEventListener('submit', async event => {
    event.preventDefault();
    if (!contactForm.reportValidity()) return;
    const submitButton = contactForm.querySelector('[type="submit"]');
    if (submitButton) submitButton.disabled = true;
    contactForm.setAttribute('aria-busy', 'true');
    if (contactStatus) {
      contactStatus.className = 'rounded-2xl bg-blue-100 px-5 py-4 text-sm font-semibold text-blue-900 dark:bg-blue-900/40 dark:text-blue-100';
      contactStatus.textContent = 'Mengirim pesan…';
    }
    try {
      const response = await fetch(contactForm.action, {
        method: 'POST',
        body: new FormData(contactForm),
        headers: { Accept: 'application/json' }
      });
      if (!response.ok) throw new Error('Form submission failed');
      if (contactStatus) {
        contactStatus.className = 'rounded-2xl bg-emerald-100 px-5 py-4 text-sm font-semibold text-emerald-900 dark:bg-emerald-900/40 dark:text-emerald-100';
        contactStatus.textContent = 'Pesan berhasil dikirim. Terima kasih sudah menghubungi saya!';
      }
      contactForm.reset();
    } catch {
      if (contactStatus) {
        contactStatus.className = 'rounded-2xl bg-red-100 px-5 py-4 text-sm font-semibold text-red-900 dark:bg-red-900/40 dark:text-red-100';
        contactStatus.textContent = 'Pesan belum berhasil dikirim. Silakan coba lagi.';
      }
    } finally {
      if (submitButton) submitButton.disabled = false;
      contactForm.removeAttribute('aria-busy');
    }
  });

  const roles = ['Web Developer', 'UI/UX Designer', 'Pembuat Sistem Kasir & Stok'];
  const role = document.querySelector('.typed-role');
  if (role && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    let roleIndex = 0;
    const typeNext = () => {
      const text = roles[roleIndex % roles.length];
      roleIndex++;
      let position = 0;
      const type = () => {
        role.textContent = text.slice(0, position++);
        if (position <= text.length) setTimeout(type, 65);
        else setTimeout(erase, 1500);
      };
      const erase = () => {
        const current = role.textContent;
        if (current.length) { role.textContent = current.slice(0, -1); setTimeout(erase, 28); }
        else typeNext();
      };
      type();
    };
    setTimeout(typeNext, 1000);
  }
})();
