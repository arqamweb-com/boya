<!DOCTYPE html>
<html lang="ar" dir="rtl" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$boya_logo_url = boya_get_site_logo_url();
$boya_logo_alt = boya_get_site_logo_alt();
?>

<div id="boya-site-loader" class="boya-site-loader" role="status" aria-live="polite">
  <span class="boya-site-loader__mark" aria-hidden="true">
    <span
      class="boya-site-loader__logo"
      style="--boya-loader-logo: url('<?php echo esc_url($boya_logo_url); ?>');"
    ></span>
  </span>
  <span class="boya-site-loader__text">جاري تحميل الموقع</span>
</div>
<noscript><style>#boya-site-loader{display:none!important}</style></noscript>

<!-- Top bar -->
<div class="hidden md:block bg-brand-navy text-white text-sm">
  <div class="container mx-auto px-6 py-2.5 flex items-center justify-between">
    <div class="flex items-center gap-6 opacity-95">
      <span class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.85 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.96 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
        01038304949
      </span>
      <span>توصيل سريع لكافة مناطق الجمهورية</span>
    </div>
    <div class="flex items-center gap-4 opacity-95">
      <span>منتجات أصلية 100%</span>
      <span class="h-3 w-px bg-white/20"></span>
      <span>دعم فني 24/7</span>
    </div>
  </div>
</div>

<!-- Main header -->
<header id="site-header" class="sticky top-0 z-50 transition-all duration-500 bg-white/80 backdrop-blur-sm">
  <div class="container mx-auto px-6 py-4 flex items-center gap-8">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 shrink-0">
      <img
        src="<?php echo esc_url($boya_logo_url); ?>"
        alt="<?php echo esc_attr($boya_logo_alt); ?>"
        class="h-12 w-auto"
        loading="eager"
        decoding="async"
        fetchpriority="high"
      />
    </a>

    <nav class="hidden lg:flex items-center gap-1 flex-1">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary_menu',
        'container'      => false,
        'items_wrap'     => '%3$s',
        'depth'          => 2,
        'walker'         => new Boya_Header_Walker(),
        'fallback_cb'    => 'boya_primary_menu_fallback',
      ]);
      ?>
    </nav>

    <div class="flex items-center gap-1">

      <!-- Search toggle -->
      <button id="search-toggle" class="p-2.5 rounded-full hover:bg-secondary transition-colors cursor-pointer" aria-label="بحث" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" /></svg>
      </button>

      <!-- My Account -->
      <a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('myaccount')) : esc_url(home_url('/my-account')); ?>"
         class="p-2.5 rounded-full hover:bg-secondary transition-colors" aria-label="حسابي">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="12" cy="7" r="4" /></svg>
      </a>

      <!-- Cart toggle -->
      <?php $cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0; ?>
      <button id="cart-toggle" class="p-2.5 rounded-full hover:bg-secondary transition-colors relative cursor-pointer" aria-label="سلة التسوق" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" /><line x1="3" y1="6" x2="21" y2="6" /><path d="M16 10a4 4 0 0 1-8 0" /></svg>
        <span class="boya-cart-count absolute -top-1 -left-1 h-5 w-5 rounded-full bg-brand-red text-white text-[10px] font-bold flex items-center justify-center<?php echo $cart_count === 0 ? ' hidden' : ''; ?>"><?php echo esc_html($cart_count); ?></span>
      </button>

      <!-- Mobile menu button -->
      <button id="mobile-menu-btn" class="lg:hidden p-2.5 rounded-full hover:bg-secondary transition-colors" aria-expanded="false" aria-label="القائمة">
        <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="18" x2="21" y2="18" /></svg>
        <svg id="close-icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
      </button>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden lg:hidden border-t border-border/60 bg-white/95 backdrop-blur-sm">
    <nav class="container mx-auto px-6 py-4 flex flex-col gap-1">
      <?php
      wp_nav_menu([
        'theme_location' => 'mobile_menu',
        'container'      => false,
        'items_wrap'     => '%3$s',
        'depth'          => 2,
        'walker'         => new Boya_Mobile_Walker(),
        'fallback_cb'    => 'boya_mobile_menu_fallback',
      ]);
      ?>
    </nav>
  </div>
</header>

<!-- ══════════════════════════════════════════════════════════════
     SEARCH OVERLAY
     ══════════════════════════════════════════════════════════════ -->
<div id="search-overlay"
     class="fixed inset-0 z-[9999] bg-brand-navy/96 backdrop-blur-xl flex items-center justify-center px-6
            opacity-0 pointer-events-none transition-opacity duration-300"
     aria-hidden="true" role="dialog" aria-label="بحث">

  <button id="close-search"
          class="absolute top-6 left-6 h-12 w-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors"
          aria-label="إغلاق البحث">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
  </button>

  <div class="w-full max-w-2xl">
    <p class="text-white/50 text-center mb-6 text-sm tracking-widest">ابحث في منتجاتنا</p>
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
      <input type="hidden" name="post_type" value="product" />
      <input type="search" name="s" id="search-input" autocomplete="off"
             placeholder="اكتب اسم المنتج أو العلامة التجارية..."
             value="<?php echo get_search_query(); ?>"
             class="w-full px-6 py-5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/40 text-lg focus:outline-none focus:border-brand-orange transition-colors" />
      <button type="submit"
              class="absolute left-4 top-1/2 -translate-y-1/2 h-10 w-10 flex items-center justify-center text-white/60 hover:text-white transition-colors"
              aria-label="بحث">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" /></svg>
      </button>
    </form>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     SLIDE CART
     ══════════════════════════════════════════════════════════════ -->
<div id="cart-overlay"
     class="boya-cart-overlay fixed inset-0 z-[9997] backdrop-blur-sm
            opacity-0 pointer-events-none transition-opacity duration-300"
     aria-hidden="true">
</div>

<div id="slide-cart"
     class="boya-slide-cart fixed top-0 right-0 bottom-0 z-[9998] w-full max-w-sm flex flex-col
            translate-x-full transition-transform duration-300"
     aria-hidden="true" role="dialog" aria-label="سلة التسوق" dir="rtl">

  <!-- Cart header -->
  <div class="boya-cart-header flex items-center justify-between p-5 shrink-0">
    <div class="relative flex items-center gap-3">
      <span class="boya-cart-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" /><line x1="3" y1="6" x2="21" y2="6" /><path d="M16 10a4 4 0 0 1-8 0" /></svg>
      </span>
      <div>
        <h3 class="text-xl font-black">سلة التسوق</h3>
        <span class="boya-cart-count-label mt-1">
          <?php if (function_exists('WC') && WC()->cart): ?>
            <?php echo WC()->cart->get_cart_contents_count(); ?> منتج في السلة
          <?php endif; ?>
        </span>
      </div>
    </div>
    <button id="close-cart"
            class="boya-cart-close relative h-9 w-9 rounded-full flex items-center justify-center transition-colors"
            aria-label="إغلاق السلة">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
    </button>
  </div>

  <!-- Cart contents (refreshed by WooCommerce fragments) -->
  <div class="boya-cart-scroll flex-1 overflow-y-auto">
    <div class="boya-mini-cart p-6">
      <?php if (function_exists('WC') && WC()->cart): ?>
        <?php woocommerce_mini_cart(); ?>
      <?php else: ?>
        <div class="boya-mini-cart__fallback text-center py-12">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 opacity-30"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" /><line x1="3" y1="6" x2="21" y2="6" /><path d="M16 10a4 4 0 0 1-8 0" /></svg>
          <p>السلة فارغة</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Cart footer — always rendered; fragment replaces it when cart changes -->
  <?php $cart_empty = !function_exists('WC') || !WC()->cart || WC()->cart->is_empty(); ?>
  <div class="boya-cart-footer p-5 space-y-3 shrink-0<?php echo $cart_empty ? ' hidden' : ''; ?>">
    <?php if (!$cart_empty): ?>
    <div class="boya-cart-total flex items-center justify-between font-black text-lg">
      <span>الإجمالي</span>
      <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
    </div>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
       class="boya-cart-secondary-btn">
      عرض السلة
    </a>
    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
       class="boya-cart-primary-btn">
      إتمام الشراء
    </a>
    <?php endif; ?>
  </div>
</div>
