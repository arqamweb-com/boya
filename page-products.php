<?php
/**
 * Template Name: Products Page
 */
get_header();
?>

<!-- Page Header -->
<section class="relative overflow-hidden bg-brand-navy text-white">
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-red/40 blur-3xl animate-blob"></div>
    <div class="absolute top-20 -left-32 w-[500px] h-[500px] rounded-full bg-brand-blue/40 blur-3xl animate-blob" style="animation-delay:4s"></div>
    <div class="absolute bottom-0 right-1/3 w-[400px] h-[400px] rounded-full bg-brand-orange/30 blur-3xl animate-blob" style="animation-delay:8s"></div>
  </div>
  <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(white 1px,transparent 1px),linear-gradient(90deg,white 1px,transparent 1px);background-size:60px 60px"></div>
  <div class="container mx-auto px-6 pt-20 pb-28 lg:pt-28 lg:pb-36 relative text-center">
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow"><?php esc_html_e('متجرنا', 'arqamweb'); ?></div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      <?php esc_html_e('تشكيلتنا الكاملة من', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('المنتجات', 'arqamweb'); ?></span>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      <?php esc_html_e('منتجات أصلية 100% من أفضل العلامات التجارية، بأسعار تنافسية وتوصيل سريع لكافة محافظات الجمهورية.', 'arqamweb'); ?>
    </p>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Products Grid -->
<section id="products" class="py-24 lg:py-32">
  <div class="container mx-auto px-6">

    <?php
    $paged        = max(1, (int) get_query_var('paged'), (int) ($_GET['paged'] ?? 0));
    // `pcat`/`ptag` instead of `cat`/`tag`: the latter are reserved WordPress
    // query vars. Old links still work.
    $active_cat   = absint($_GET['pcat'] ?? $_GET['cat'] ?? 0);
    $active_tag   = absint($_GET['ptag'] ?? $_GET['tag'] ?? 0);
    $filter_cats  = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
    $filter_tags  = get_terms(['taxonomy' => 'product_tag', 'hide_empty' => true]);
    $filter_cats  = is_wp_error($filter_cats) ? [] : $filter_cats;
    $filter_tags  = is_wp_error($filter_tags) ? [] : $filter_tags;

    if ($active_cat && !term_exists($active_cat, 'product_cat')) $active_cat = 0;
    if ($active_tag && !term_exists($active_tag, 'product_tag')) $active_tag = 0;
    ?>

    <!-- Filter bar -->
    <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-12">
      <div>
        <div class="text-sm font-bold text-brand-red mb-1 tracking-wider"><?php esc_html_e('منتجاتنا', 'arqamweb'); ?></div>
        <h2 class="text-3xl md:text-4xl font-black">
          <?php esc_html_e('الأكثر', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('رواجاً', 'arqamweb'); ?></span> <?php esc_html_e('هذا الشهر', 'arqamweb'); ?>
        </h2>
      </div>

      <?php if ($filter_cats || $filter_tags): ?>
      <form class="boya-product-filters" id="boya-product-filters" method="get"
            action="<?php echo esc_url(home_url('/products')); ?>">
        <?php if ($filter_cats): ?>
        <div class="boya-filter-field">
          <label for="boya-filter-cat"><?php esc_html_e('القسم', 'arqamweb'); ?></label>
          <div class="boya-filter-select">
            <select id="boya-filter-cat" name="pcat" data-boya-filter>
              <option value="0"><?php esc_html_e('كل الأقسام', 'arqamweb'); ?></option>
              <?php foreach ($filter_cats as $fc): ?>
              <option value="<?php echo esc_attr($fc->term_id); ?>" <?php selected($active_cat, $fc->term_id); ?>>
                <?php echo esc_html($fc->name); ?> (<?php echo esc_html($fc->count); ?>)
              </option>
              <?php endforeach; ?>
            </select>
            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($filter_tags): ?>
        <div class="boya-filter-field">
          <label for="boya-filter-tag"><?php esc_html_e('الوسم', 'arqamweb'); ?></label>
          <div class="boya-filter-select">
            <select id="boya-filter-tag" name="ptag" data-boya-filter>
              <option value="0"><?php esc_html_e('كل الوسوم', 'arqamweb'); ?></option>
              <?php foreach ($filter_tags as $ft): ?>
              <option value="<?php echo esc_attr($ft->term_id); ?>" <?php selected($active_tag, $ft->term_id); ?>>
                <?php echo esc_html($ft->name); ?> (<?php echo esc_html($ft->count); ?>)
              </option>
              <?php endforeach; ?>
            </select>
            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
          </div>
        </div>
        <?php endif; ?>

        <button type="button" class="boya-filter-reset" data-boya-filter-reset
                <?php echo ($active_cat || $active_tag) ? '' : 'hidden'; ?>>
          <?php esc_html_e('إعادة تعيين', 'arqamweb'); ?>
        </button>

        <noscript><button type="submit" class="boya-filter-submit"><?php esc_html_e('تصفية', 'arqamweb'); ?></button></noscript>
      </form>
      <?php endif; ?>
    </div>

    <div id="boya-products-results" class="boya-products-results" aria-live="polite" aria-busy="false">
      <?php boya_render_products_results($active_cat, $active_tag, $paged); ?>
    </div>

  </div>
</section>

<?php get_footer(); ?>
