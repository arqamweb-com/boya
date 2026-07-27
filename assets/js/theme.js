(function () {
  'use strict';

  /* ── 0. First-paint loader ────────────────────────────────── */
  var siteLoader = document.getElementById('boya-site-loader');
  if (siteLoader) {
    function hideSiteLoader() {
      if (siteLoader.classList.contains('is-hidden')) return;
      siteLoader.classList.add('is-hidden');
      window.setTimeout(function () {
        if (siteLoader && siteLoader.parentNode) {
          siteLoader.parentNode.removeChild(siteLoader);
        }
      }, 320);
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', hideSiteLoader, { once: true });
    } else {
      window.requestAnimationFrame(hideSiteLoader);
    }

    window.setTimeout(hideSiteLoader, 2500);
  }

  /* ── 1. Scroll-aware header ───────────────────────────────── */
  var header = document.getElementById('site-header');
  if (header) {
    function updateHeader() {
      var inner = header.querySelector('div > div');
      if (window.scrollY > 20) {
        header.classList.add('scrolled');
        header.classList.remove('bg-white/80', 'backdrop-blur-sm');
        header.classList.add('glass', 'shadow-[var(--shadow-soft)]');
        if (inner) inner.classList.add('shadow-elegant');
      } else {
        header.classList.remove('scrolled', 'glass', 'shadow-[var(--shadow-soft)]');
        header.classList.add('bg-white/80', 'backdrop-blur-sm');
        if (inner) inner.classList.remove('shadow-elegant');
      }
    }
    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();
  }

  /* ── 2. Mobile menu toggle ────────────────────────────────── */
  var mobileBtn = document.getElementById('mobile-menu-btn');
  var mobileMenu = document.getElementById('mobile-menu');
  var menuIcon = document.getElementById('menu-icon');
  var closeIcon = document.getElementById('close-icon');

  if (mobileBtn && mobileMenu) {
    mobileBtn.addEventListener('click', function () {
      var isOpen = !mobileMenu.classList.contains('hidden');
      mobileMenu.classList.toggle('hidden');
      if (menuIcon) menuIcon.classList.toggle('hidden');
      if (closeIcon) closeIcon.classList.toggle('hidden');
      mobileBtn.setAttribute('aria-expanded', String(!isOpen));
    });
  }

  /* ── 2b. Mobile submenu accordion toggles ─────────────────── */
  if (mobileMenu) {
    var submenuToggles = mobileMenu.querySelectorAll('.boya-submenu-toggle');
    submenuToggles.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var item = btn.closest('.boya-mobile-item');
        if (!item) return;
        var submenu = item.querySelector('.boya-mobile-submenu');
        if (!submenu) return;
        var isOpen = !submenu.classList.contains('hidden');
        submenu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', String(!isOpen));
      });
    });
  }

  /* ── 3. Hero slideshow ────────────────────────────────────── */
  var slides = document.querySelectorAll('.hero-slide');
  var dots = document.querySelectorAll('.hero-dot');
  var slideLabel = document.getElementById('hero-slide-label');
  var slideLabels = ['دهانات سيارات', 'دهانات خشب', 'دهانات إنشائية', 'منتجات صناعية'];
  var currentSlide = 0;
  var slideTimer;

  function setHeroSlide(idx) {
    slides.forEach(function (s, i) {
      s.classList.toggle('opacity-100', i === idx);
      s.classList.toggle('opacity-0', i !== idx);
    });
    dots.forEach(function (d, i) {
      if (i === idx) {
        d.classList.add('w-6', 'bg-white');
        d.classList.remove('w-2', 'bg-white/40');
      } else {
        d.classList.remove('w-6', 'bg-white');
        d.classList.add('w-2', 'bg-white/40');
      }
    });
    if (slideLabel) slideLabel.textContent = slideLabels[idx] || '';
    currentSlide = idx;
  }

  window.setHeroSlide = setHeroSlide;

  if (slides.length > 1) {
    function advanceSlide() {
      setHeroSlide((currentSlide + 1) % slides.length);
    }
    slideTimer = setInterval(advanceSlide, 3500);
    dots.forEach(function (d, i) {
      d.addEventListener('click', function () {
        clearInterval(slideTimer);
        setHeroSlide(i);
        slideTimer = setInterval(advanceSlide, 3500);
      });
    });
  }

  /* ── 4. Scroll reveal ─────────────────────────────────────── */
  function showRevealElement(el) {
    el.classList.remove('opacity-0', 'translate-y-8', 'blur-[2px]');
    el.classList.add('opacity-100', 'translate-y-0', 'blur-0');
    el.style.transition = 'opacity 0.7s ease, transform 0.7s ease, filter 0.7s ease';
  }

  var revealObserver = null;
  if ('IntersectionObserver' in window) {
    revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          showRevealElement(entry.target);
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
  }

  // Exposed so content injected after load (e.g. AJAX-filtered products)
  // gets the same reveal treatment.
  function scanReveal(root) {
    (root || document).querySelectorAll('.opacity-0.translate-y-8').forEach(function (el) {
      if (revealObserver) {
        revealObserver.observe(el);
      } else {
        el.classList.remove('opacity-0', 'translate-y-8', 'blur-[2px]');
      }
    });
  }

  window.boyaScanReveal = scanReveal;
  scanReveal(document);

  /* ── 5. Animated counters ─────────────────────────────────── */
  function easeOutQuart(t) {
    return 1 - Math.pow(1 - t, 4);
  }

  function animateCounter(el, target, duration) {
    var start = performance.now();
    var isPlus = String(target).charAt(0) === '+';
    var numTarget = parseInt(String(target).replace(/\D/g, ''), 10);
    var suffix = numTarget >= 1000 ? 'K' : '';
    var displayTarget = numTarget >= 1000 ? Math.round(numTarget / 1000) : numTarget;

    function tick(now) {
      var elapsed = now - start;
      var progress = Math.min(elapsed / duration, 1);
      var eased = easeOutQuart(progress);
      var current = Math.round(eased * displayTarget);
      el.textContent = (isPlus ? '+' : '') + current + suffix;
      if (progress < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  if ('IntersectionObserver' in window) {
    var counterObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          var target = el.getAttribute('data-count');
          if (target) animateCounter(el, target, 1800);
          counterObserver.unobserve(el);
        }
      });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count]').forEach(function (el) {
      counterObserver.observe(el);
    });
  }

  /* ── 6. FAQ Accordion ─────────────────────────────────────── */
  document.querySelectorAll('[data-accordion-item]').forEach(function (item) {
    var trigger = item.querySelector('[data-accordion-trigger]');
    var content = item.querySelector('[data-accordion-content]');
    var icon = item.querySelector('[data-accordion-icon]');

    if (!trigger || !content) return;

    trigger.addEventListener('click', function () {
      var isOpen = content.classList.contains('grid-rows-[1fr]');

      document.querySelectorAll('[data-accordion-content]').forEach(function (c) {
        c.classList.remove('grid-rows-[1fr]', 'opacity-100');
        c.classList.add('grid-rows-[0fr]', 'opacity-0');
      });
      document.querySelectorAll('[data-accordion-item]').forEach(function (i) {
        i.classList.remove('border-brand-orange', 'bg-secondary/40', 'shadow-[var(--shadow-soft)]');
        i.classList.add('border-border', 'bg-card');
        var ic = i.querySelector('[data-accordion-icon]');
        if (ic) {
          ic.classList.remove('bg-brand-orange', 'text-white', 'rotate-45');
          ic.classList.add('bg-secondary', 'text-foreground');
        }
      });

      if (!isOpen) {
        content.classList.remove('grid-rows-[0fr]', 'opacity-0');
        content.classList.add('grid-rows-[1fr]', 'opacity-100');
        item.classList.remove('border-border', 'bg-card');
        item.classList.add('border-brand-orange', 'bg-secondary/40', 'shadow-[var(--shadow-soft)]');
        if (icon) {
          icon.classList.remove('bg-secondary', 'text-foreground');
          icon.classList.add('bg-brand-orange', 'text-white', 'rotate-45');
        }
      }
    });
  });

  /* ── 7. Search overlay ────────────────────────────────────── */
  var searchOverlay = document.getElementById('search-overlay');
  var searchToggle  = document.getElementById('search-toggle');
  var closeSearch   = document.getElementById('close-search');
  var searchInput   = document.getElementById('search-input');

  function openSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.remove('opacity-0', 'pointer-events-none');
    searchOverlay.setAttribute('aria-hidden', 'false');
    if (searchToggle) searchToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    setTimeout(function () { if (searchInput) searchInput.focus(); }, 100);
  }

  function closeSearchFn() {
    if (!searchOverlay) return;
    searchOverlay.classList.add('opacity-0', 'pointer-events-none');
    searchOverlay.setAttribute('aria-hidden', 'true');
    if (searchToggle) searchToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (searchToggle) searchToggle.addEventListener('click', openSearch);
  if (closeSearch)  closeSearch.addEventListener('click', closeSearchFn);
  if (searchOverlay) {
    searchOverlay.addEventListener('click', function (e) {
      if (e.target === searchOverlay) closeSearchFn();
    });
  }

  /* ── 8. Slide cart ────────────────────────────────────────── */
  var slideCart    = document.getElementById('slide-cart');
  var cartOverlay  = document.getElementById('cart-overlay');
  var cartToggle   = document.getElementById('cart-toggle');
  var closeCartBtn = document.getElementById('close-cart');

  function openCart() {
    if (!slideCart) return;
    slideCart.classList.remove('translate-x-full');
    slideCart.setAttribute('aria-hidden', 'false');
    if (cartOverlay) {
      cartOverlay.classList.remove('opacity-0', 'pointer-events-none');
    }
    if (cartToggle) cartToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeCart() {
    if (!slideCart) return;
    slideCart.classList.add('translate-x-full');
    slideCart.setAttribute('aria-hidden', 'true');
    if (cartOverlay) {
      cartOverlay.classList.add('opacity-0', 'pointer-events-none');
    }
    if (cartToggle) cartToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (cartToggle)   cartToggle.addEventListener('click', openCart);
  if (closeCartBtn) closeCartBtn.addEventListener('click', closeCart);
  if (cartOverlay)  cartOverlay.addEventListener('click', closeCart);

  // Open cart automatically after AJAX add-to-cart
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.ajax_add_to_cart');
    if (btn) {
      document.body.addEventListener('added_to_cart', function handler() {
        openCart();
        document.body.removeEventListener('added_to_cart', handler);
      });
    }
  });

  // WooCommerce added_to_cart jQuery event bridge (if jQuery is present)
  if (typeof jQuery !== 'undefined') {
    jQuery(document.body).on('added_to_cart', function () {
      openCart();
    });
  }

  // Escape key closes both overlays
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeSearchFn();
      closeCart();
    }
  });

  /* ── 9. Product gallery thumbnails + lightbox ─────────────── */
  var productGallery = document.querySelector('.boya-product-gallery');
  var productMainImage = document.getElementById('boya-product-main-image');
  var productThumbs = document.querySelectorAll('[data-boya-product-thumb]');

  if (productGallery && productMainImage) {
    var galleryImages = [];
    try {
      galleryImages = JSON.parse(productGallery.getAttribute('data-boya-gallery') || '[]');
    } catch (e) {
      galleryImages = [];
    }
    if (!galleryImages.length) {
      galleryImages = [{ full: productMainImage.getAttribute('src'), alt: productMainImage.getAttribute('alt') || '' }];
    }

    var currentIndex = 0;

    function syncMainImage(index, animate) {
      var item = galleryImages[index];
      if (!item) return;
      if (animate && productMainImage.getAttribute('src') !== item.full) {
        productMainImage.style.opacity = '0';
        window.setTimeout(function () {
          productMainImage.setAttribute('src', item.full);
          productMainImage.setAttribute('alt', item.alt || '');
          productMainImage.style.opacity = '1';
        }, 120);
      } else {
        productMainImage.setAttribute('src', item.full);
        productMainImage.setAttribute('alt', item.alt || '');
      }
    }

    function setActiveThumb(index) {
      productThumbs.forEach(function (item, i) {
        var on = i === index;
        item.classList.toggle('is-active', on);
        item.classList.toggle('border-brand-orange', on);
        item.classList.toggle('border-border', !on);
        item.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
    }

    /* Thumbnails: swap main image + track current index */
    productThumbs.forEach(function (thumb, idx) {
      thumb.addEventListener('click', function () {
        currentIndex = idx;
        syncMainImage(idx, true);
        setActiveThumb(idx);
      });
    });

    /* Build the lightbox overlay (Astra-style fullscreen viewer) */
    var lb = document.createElement('div');
    lb.className = 'boya-lightbox' + (galleryImages.length < 2 ? ' boya-lightbox--single' : '');
    lb.setAttribute('role', 'dialog');
    lb.setAttribute('aria-label', 'معرض صور المنتج');
    lb.setAttribute('aria-hidden', 'true');
    lb.innerHTML =
      '<button type="button" class="boya-lightbox__btn boya-lightbox__close" aria-label="إغلاق">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
      '</button>' +
      '<button type="button" class="boya-lightbox__btn boya-lightbox__prev" aria-label="السابق">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>' +
      '</button>' +
      '<figure class="boya-lightbox__figure"><img class="boya-lightbox__img" src="" alt=""/></figure>' +
      '<button type="button" class="boya-lightbox__btn boya-lightbox__next" aria-label="التالي">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>' +
      '</button>' +
      '<div class="boya-lightbox__counter"></div>';
    document.body.appendChild(lb);

    var lbImg = lb.querySelector('.boya-lightbox__img');
    var lbCounter = lb.querySelector('.boya-lightbox__counter');

    function renderLightbox() {
      var item = galleryImages[currentIndex] || galleryImages[0];
      lbImg.setAttribute('src', item.full);
      lbImg.setAttribute('alt', item.alt || '');
      lbCounter.textContent = (currentIndex + 1) + ' / ' + galleryImages.length;
    }

    function openLightbox() {
      renderLightbox();
      lb.classList.add('is-open');
      lb.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      lb.classList.remove('is-open');
      lb.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    function step(dir) {
      currentIndex = (currentIndex + dir + galleryImages.length) % galleryImages.length;
      renderLightbox();
      syncMainImage(currentIndex, false);
      setActiveThumb(currentIndex);
    }

    productMainImage.addEventListener('click', openLightbox);
    lb.querySelector('.boya-lightbox__close').addEventListener('click', closeLightbox);
    lb.querySelector('.boya-lightbox__prev').addEventListener('click', function () { step(-1); });
    lb.querySelector('.boya-lightbox__next').addEventListener('click', function () { step(1); });
    lb.addEventListener('click', function (e) {
      if (e.target === lb || e.target.classList.contains('boya-lightbox__figure')) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('is-open')) return;
      if (e.key === 'Escape') closeLightbox();
      else if (e.key === 'ArrowRight') step(-1);
      else if (e.key === 'ArrowLeft') step(1);
    });

    /* Touch swipe */
    var touchStartX = null;
    lb.addEventListener('touchstart', function (e) { touchStartX = e.changedTouches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
      if (touchStartX === null) return;
      var dx = e.changedTouches[0].clientX - touchStartX;
      if (Math.abs(dx) > 40) step(dx < 0 ? 1 : -1);
      touchStartX = null;
    }, { passive: true });
  }

  /* ── 10. WooCommerce review stars ─────────────────────────── */
  function getReviewStarValue(star) {
    var classMatch = String(star.className || '').match(/star-(\d)/);
    if (classMatch) return parseInt(classMatch[1], 10);

    var textMatch = String(star.textContent || '').match(/\d/);
    return textMatch ? parseInt(textMatch[0], 10) : 0;
  }

  function paintReviewStars(starsWrap, value, preview) {
    if (!starsWrap) return;

    starsWrap.querySelectorAll('a').forEach(function (star) {
      var starValue = getReviewStarValue(star);
      var className = preview ? 'is-preview' : 'is-filled';
      var otherClass = preview ? 'is-filled' : 'is-preview';

      star.classList.remove(otherClass);
      star.classList.toggle(className, starValue > 0 && starValue <= value);
    });
  }

  function syncReviewStars(starsWrap) {
    if (!starsWrap) return;

    var ratingSelect = document.getElementById('rating');
    var selectedValue = ratingSelect ? parseInt(ratingSelect.value || '0', 10) : 0;
    var activeStar = starsWrap.querySelector('a.active');

    if (!selectedValue && activeStar) {
      selectedValue = getReviewStarValue(activeStar);
    }

    paintReviewStars(starsWrap, selectedValue || 0, false);
  }

  function setupReviewStars() {
    var starsWrap = document.querySelector('.comment-form-rating .stars');
    if (!starsWrap || starsWrap.getAttribute('data-boya-stars-ready') === 'true') return Boolean(starsWrap);

    starsWrap.setAttribute('data-boya-stars-ready', 'true');
    syncReviewStars(starsWrap);

    starsWrap.querySelectorAll('a').forEach(function (star) {
      star.addEventListener('mouseenter', function () {
        starsWrap.querySelectorAll('a').forEach(function (item) {
          item.classList.remove('is-preview');
        });
        paintReviewStars(starsWrap, getReviewStarValue(star), true);
      });

      star.addEventListener('click', function () {
        window.setTimeout(function () {
          starsWrap.querySelectorAll('a').forEach(function (item) {
            item.classList.remove('is-preview');
          });
          syncReviewStars(starsWrap);
        }, 0);
      });
    });

    starsWrap.addEventListener('mouseleave', function () {
      starsWrap.querySelectorAll('a').forEach(function (star) {
        star.classList.remove('is-preview');
      });
      syncReviewStars(starsWrap);
    });

    var ratingSelect = document.getElementById('rating');
    if (ratingSelect) {
      ratingSelect.addEventListener('change', function () {
        syncReviewStars(starsWrap);
      });
    }

    return true;
  }

  if (!setupReviewStars()) {
    window.setTimeout(setupReviewStars, 300);
  }

  /* ── 11. Contact form feedback ────────────────────────────── */
  var params = new URLSearchParams(window.location.search);
  var feedback = document.getElementById('contact-feedback');
  if (feedback) {
    var status = params.get('contact');
    if (status === 'success') {
      feedback.innerHTML = '<div class="mt-4 p-4 rounded-2xl bg-brand-green/10 border border-brand-green/30 text-brand-green font-bold text-sm text-center">تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.</div>';
      history.replaceState(null, '', window.location.pathname);
    } else if (status === 'error') {
      feedback.innerHTML = '<div class="mt-4 p-4 rounded-2xl bg-brand-red/10 border border-brand-red/30 text-brand-red font-bold text-sm text-center">حدث خطأ أثناء الإرسال. يرجى المحاولة مرة أخرى.</div>';
      history.replaceState(null, '', window.location.pathname);
    }
  }

  /* ── 12. Products page: AJAX category/tag filter ──────────── */
  var filterForm = document.getElementById('boya-product-filters');
  var resultsBox = document.getElementById('boya-products-results');

  if (filterForm && resultsBox && window.boyaProductFilter) {
    var cfg = window.boyaProductFilter;
    var catSelect = filterForm.querySelector('#boya-filter-cat');
    var tagSelect = filterForm.querySelector('#boya-filter-tag');
    var brandInput = filterForm.querySelector('[data-boya-brand]');
    var brandId = brandInput ? parseInt(brandInput.value, 10) || 0 : 0;
    var resetBtn = filterForm.querySelector('[data-boya-filter-reset]');
    var requestToken = 0;

    function currentValue(select) {
      return select ? parseInt(select.value, 10) || 0 : 0;
    }

    function buildUrl(cat, tag, paged) {
      var base = cfg.baseUrl;

      // Brand archives keep pretty /brands/<slug>/page/N/ URLs.
      if (cfg.pathPaging && paged > 1) {
        base = base.replace(/\/+$/, '') + '/page/' + paged + '/';
      }

      var url = new URL(base, window.location.origin);
      if (cat) url.searchParams.set('pcat', cat);
      if (tag) url.searchParams.set('ptag', tag);
      if (!cfg.pathPaging && paged > 1) url.searchParams.set('paged', paged);
      return url.toString();
    }

    function pagedFromLink(href) {
      var url = new URL(href, window.location.origin);
      var fromQuery = parseInt(url.searchParams.get('paged'), 10);
      if (fromQuery) return fromQuery;

      var fromPath = url.pathname.match(/\/page\/(\d+)/);
      return fromPath ? parseInt(fromPath[1], 10) || 1 : 1;
    }

    function loadProducts(paged, pushUrl) {
      var cat = currentValue(catSelect);
      var tag = currentValue(tagSelect);
      var token = ++requestToken;

      if (resetBtn) resetBtn.hidden = !(cat || tag);
      resultsBox.setAttribute('aria-busy', 'true');

      var body = new URLSearchParams();
      body.set('action', 'boya_filter_products');
      body.set('nonce', cfg.nonce);
      body.set('cat', cat);
      body.set('tag', tag);
      body.set('brand', brandId);
      body.set('paged', paged || 1);

      fetch(cfg.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: body.toString()
      })
        .then(function (res) {
          if (!res.ok) throw new Error('HTTP ' + res.status);
          return res.json();
        })
        .then(function (payload) {
          // A slower earlier request must not overwrite a newer one.
          if (token !== requestToken) return;
          if (!payload || !payload.success || !payload.data) throw new Error('bad payload');

          resultsBox.innerHTML = payload.data.html;
          resultsBox.setAttribute('aria-busy', 'false');
          if (window.boyaScanReveal) window.boyaScanReveal(resultsBox);

          if (pushUrl !== false) {
            history.replaceState(null, '', buildUrl(cat, tag, payload.data.paged));
          }
        })
        .catch(function () {
          if (token !== requestToken) return;
          resultsBox.setAttribute('aria-busy', 'false');
          // Fall back to a normal page load so the user is never stuck.
          window.location.href = buildUrl(cat, tag, paged || 1);
        });
    }

    filterForm.addEventListener('submit', function (e) {
      e.preventDefault();
      loadProducts(1);
    });

    filterForm.querySelectorAll('[data-boya-filter]').forEach(function (select) {
      select.addEventListener('change', function () {
        loadProducts(1);
      });
    });

    if (resetBtn) {
      resetBtn.addEventListener('click', function () {
        if (catSelect) catSelect.value = '0';
        if (tagSelect) tagSelect.value = '0';
        loadProducts(1);
      });
    }

    // Pagination inside the results container is swapped out on every load,
    // so listen on the container instead of the links themselves.
    resultsBox.addEventListener('click', function (e) {
      var link = e.target.closest('.boya-pagination a');
      if (!link) return;

      var paged = pagedFromLink(link.href);
      e.preventDefault();
      loadProducts(paged);

      var top = resultsBox.getBoundingClientRect().top + window.pageYOffset - 120;
      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  }

})();
