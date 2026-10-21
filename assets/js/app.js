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
  navLinks.forEach(link => link.addEventListener('click', closeMenu));
  nav?.querySelector('.mobile-contact-link')?.addEventListener('click', closeMenu);

  const updateScroll = () => {
    const max = document.documentElement.scrollHeight - innerHeight;
    if (progress) progress.style.width = `${max > 0 ? (scrollY / max) * 100 : 0}%`;
    backToTop?.classList.toggle('hidden', scrollY < 500);
    backToTop?.classList.toggle('grid', scrollY >= 500);
    let current = 'home';
    sections.forEach(section => { if (scrollY >= section.offsetTop - 180) current = section.id; });
    navLinks.forEach(link => link.classList.toggle('active', link.hash === `#${current}`));
  };
  addEventListener('scroll', updateScroll, { passive: true });
  addEventListener('resize', () => { if (innerWidth >= 768) closeMenu(); });
  updateScroll();

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
    document.querySelector('#project-modal-description').textContent = project.dataset.description || '';
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
  }));
  projectDialogClose?.addEventListener('click', () => projectDialog?.close());
  projectDialog?.addEventListener('click', event => {
    if (event.target === projectDialog) projectDialog.close();
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
  }));

  const roles = ['Web Developer', 'Full Stack Developer', 'UI Designer'];
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
