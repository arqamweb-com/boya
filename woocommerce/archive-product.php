<?php
/**
 * Product archive template override — shop page, product search, category archives.
 * Overrides: woocommerce/templates/archive-product.php
 */
defined('ABSPATH') || exit;

get_header();

global $wp_query;

$is_search    = is_search();
$search_query = get_search_query();
$queried      = get_queried_object();
$result_count = isset($wp_query->found_posts) ? (int) $wp_query->found_posts : 0;
$paged        = max(1, (int) get_query_var('paged'), (int) ($_GET['paged'] ?? 0));
$is_brand_archive = $queried instanceof WP_Term && function_exists('boya_is_brand_taxonomy') && boya_is_brand_taxonomy($queried->taxonomy);

// Brand archives get the same category/tag filter as the products page,
// scoped to the products of this brand only.
$brand_id      = $is_brand_archive ? (int) $queried->term_id : 0;
// NOTE: `cat`/`tag` are reserved WordPress query vars and 404 a taxonomy
// archive, so the filter uses `pcat`/`ptag` instead.
$active_cat    = isset($_GET['pcat']) ? absint($_GET['pcat']) : 0;
$active_tag    = isset($_GET['ptag']) ? absint($_GET['ptag']) : 0;
$brand_cats    = [];
$brand_tags    = [];

if ($is_brand_archive) {
    $brand_cats = boya_brand_filter_terms($brand_id, 'product_cat');
    $brand_tags = boya_brand_filter_terms($brand_id, 'product_tag');

    // Drop selections that don't belong to this brand.
    $cat_ids = wp_list_pluck($brand_cats, 'term_id');
    $tag_ids = wp_list_pluck($brand_tags, 'term_id');
    if ($active_cat && !in_array($active_cat, $cat_ids, true)) $active_cat = 0;
    if ($active_tag && !in_array($active_tag, $tag_ids, true)) $active_tag = 0;
}

// Page title
if ($is_search && $search_query) {
    $page_label   = 'نتائج البحث';
    $page_title   = 'بحثك عن <span class="text-gradient-warm">"' . esc_html($search_query) . '"</span>';
    $page_sub     = 'اعثر بسرعة على المنتجات الأصلية والعلامات التجارية المناسبة لاحتياجك.';
} elseif ($is_brand_archive) {
    $page_label   = 'العلامة التجارية';
    $page_title   = esc_html($queried->name);
    $page_sub     = $queried->description ?: 'منتجات أصلية من علامة ' . esc_html($queried->name) . '.';
} elseif (is_product_category() && $queried) {
    $page_label   = 'تصفح القسم';
    $page_title   = esc_html($queried->name);
    $page_sub     = $queried->description ?: 'تشكيلة متنوعة من المنتجات في هذا القسم.';
} elseif (is_product_tag() && $queried) {
    $page_label   = 'وسم المنتج';
    $page_title   = esc_html($queried->name);
    $page_sub     = $queried->description ?: 'منتجات موسومة بـ ' . esc_html($queried->name);
} else {
    $page_label   = 'متجرنا';
    $page_title   = 'تشكيلتنا الكاملة من <span class="text-gradient-warm">المنتجات</span>';
    $page_sub     = 'منتجات أصلية 100% من أفضل العلامات التجارية، بأسعار تنافسية.';
}
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
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow"><?php echo esc_html($page_label); ?></div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight"><?php echo wp_kses_post($page_title); ?></h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed"><?php echo esc_html($page_sub); ?></p>

    <?php if ($is_search): ?>
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="boya-search-form mt-10 max-w-2xl mx-auto">
      <input type="hidden" name="post_type" value="product" />
      <input type="search"
             name="s"
             value="<?php echo esc_attr($search_query); ?>"
             placeholder="اكتب اسم المنتج أو العلامة التجارية..."
             class="boya-search-input"
             aria-label="كلمة البحث" />
      <button type="submit" class="boya-search-submit">بحث</button>
    </form>
    <?php endif; ?>
  </div>

  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Products Section -->
<section class="py-24 lg:py-32">
  <div class="container mx-auto px-6">

    <!-- Bar: count + filters -->
    <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-12">
      <div>
        <div class="text-sm font-bold text-brand-red mb-2 tracking-wider">
          <?php echo $result_count > 0 ? esc_html(number_format_i18n($result_count)) . ' منتج' : ''; ?>
        </div>
        <h2 class="text-3xl md:text-4xl font-black">
          <?php if ($result_count > 0): ?>
            <?php echo $is_search ? 'النتائج <span class="text-gradient-warm">المطابقة</span>' : 'المنتجات <span class="text-gradient-warm">المتاحة</span>'; ?>
          <?php else: ?>
            لا توجد <span class="text-gradient-warm">نتائج</span>
          <?php endif; ?>
        </h2>
      </div>

      <?php
      // Category filter tabs (show on shop page, not on search)
      if (!$is_search && !$is_brand_archive):
        $filter_cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 5]);
        if (!is_wp_error($filter_cats) && !empty($filter_cats)):
      ?>
      <div class="flex flex-wrap gap-2">
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
           class="px-4 py-2 rounded-full text-sm font-bold transition-colors <?php echo !is_product_category() ? 'bg-brand-navy text-white' : 'bg-secondary text-foreground hover:bg-brand-navy hover:text-white'; ?>">
          الكل
        </a>
        <?php foreach ($filter_cats as $fc):
          $active = is_product_category($fc->slug);
        ?>
        <a href="<?php echo esc_url(get_term_link($fc)); ?>"
           class="px-4 py-2 rounded-full text-sm font-bold transition-colors <?php echo $active ? 'bg-brand-navy text-white' : 'bg-secondary text-foreground hover:bg-brand-navy hover:text-white'; ?>">
          <?php echo esc_html($fc->name); ?>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; endif; ?>

      <?php if ($is_search && $search_query): ?>
      <div class="flex flex-wrap gap-2">
        <a href="<?php echo esc_url(add_query_arg(['s' => $search_query, 'post_type' => 'product'], home_url('/'))); ?>"
           class="px-4 py-2 rounded-full text-sm font-bold bg-brand-navy text-white">
          المنتجات
        </a>
        <a href="<?php echo esc_url(add_query_arg('s', $search_query, home_url('/'))); ?>"
           class="px-4 py-2 rounded-full text-sm font-bold bg-secondary text-foreground hover:bg-brand-navy hover:text-white transition-colors">
          كل النتائج
        </a>
      </div>
      <?php endif; ?>

      <?php if ($is_brand_archive && ($brand_cats || $brand_tags)): ?>
      <form class="boya-product-filters" id="boya-product-filters" method="get"
            action="<?php echo esc_url(get_term_link($queried)); ?>">
        <input type="hidden" name="boya_brand" value="<?php echo esc_attr($brand_id); ?>" data-boya-brand />

        <?php if ($brand_cats): ?>
        <div class="boya-filter-field">
          <label for="boya-filter-cat">القسم</label>
          <div class="boya-filter-select">
            <select id="boya-filter-cat" name="pcat" data-boya-filter>
              <option value="0">كل الأقسام</option>
              <?php foreach ($brand_cats as $fc): ?>
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

        <?php if ($brand_tags): ?>
        <div class="boya-filter-field">
          <label for="boya-filter-tag">الوسم</label>
          <div class="boya-filter-select">
            <select id="boya-filter-tag" name="ptag" data-boya-filter>
              <option value="0">كل الوسوم</option>
              <?php foreach ($brand_tags as $ft): ?>
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
          إعادة تعيين
        </button>

        <noscript><button type="submit" class="boya-filter-submit">تصفية</button></noscript>
      </form>
      <?php endif; ?>
    </div>

    <?php if ($is_brand_archive): ?>

    <div id="boya-products-results" class="boya-products-results" aria-live="polite" aria-busy="false">
      <?php boya_render_products_results($active_cat, $active_tag, $paged, $brand_id); ?>
    </div>

    <?php elseif (have_posts()): ?>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
      <?php while (have_posts()): the_post();
        $product = wc_get_product(get_the_ID());
        if ($product) {
          boya_render_product_card($product);
        }
      endwhile; ?>
    </div>

    <!-- Pagination -->
    <?php if ((int) $wp_query->max_num_pages > 1): ?>
    <nav class="boya-pagination mt-14" aria-label="صفحات المنتجات">
      <?php echo paginate_links([
        'total'     => (int) $wp_query->max_num_pages,
        'current'   => $paged,
        'prev_text' => 'السابق',
        'next_text' => 'التالي',
      ]); ?>
    </nav>
    <?php endif; ?>

    <?php else: ?>

    <!-- Empty State -->
    <div class="relative overflow-hidden rounded-[2rem] bg-card border border-border/60 shadow-[var(--shadow-soft)] p-8 md:p-12 text-center">
      <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-brand-orange/10 blur-3xl"></div>
      <div class="relative max-w-2xl mx-auto">
        <div class="mx-auto mb-5 h-16 w-16 rounded-2xl bg-brand-orange/10 text-brand-orange flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" /></svg>
        </div>
        <?php if ($is_search): ?>
        <h3 class="text-2xl md:text-3xl font-black mb-3">لا توجد منتجات تطابق بحثك</h3>
        <p class="text-muted-foreground leading-relaxed mb-8">جرّب كلمة بحث مختلفة أو تصفح الأقسام.</p>
        <?php else: ?>
        <h3 class="text-2xl md:text-3xl font-black mb-3">لا توجد منتجات حالياً</h3>
        <p class="text-muted-foreground leading-relaxed mb-8">سيتم إضافة منتجات قريباً.</p>
        <?php endif; ?>
        <div class="flex flex-wrap justify-center gap-2">
          <a href="<?php echo esc_url(home_url('/products')); ?>" class="px-5 py-3 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">كل المنتجات</a>
          <a href="<?php echo esc_url(home_url('/categories')); ?>" class="px-5 py-3 rounded-full bg-secondary text-foreground font-bold hover:bg-brand-navy hover:text-white transition-colors">تصفح الأقسام</a>
        </div>
      </div>
    </div>

    <?php
    // Suggestions when no search results
    if ($is_search):
      $suggested = function_exists('boya_get_products') ? boya_get_products(['posts_per_page' => 4]) : null;
      if ($suggested && $suggested->have_posts()):
    ?>
    <div class="mt-20">
      <div class="flex items-end justify-between gap-6 mb-10">
        <div>
          <div class="text-sm font-bold text-brand-red mb-2 tracking-wider">اقتراحات</div>
          <h3 class="text-3xl md:text-4xl font-black">منتجات <span class="text-gradient-warm">الأكثر طلبًا</span></h3>
        </div>
        <a href="<?php echo esc_url(home_url('/products')); ?>" class="hidden md:inline-flex text-sm font-bold text-brand-navy hover:text-brand-orange transition-colors">عرض الكل</a>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
        <?php while ($suggested->have_posts()): $suggested->the_post();
          $product = wc_get_product(get_the_ID());
          if ($product) { boya_render_product_card($product); }
        endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
    <?php endif; endif; ?>

    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
