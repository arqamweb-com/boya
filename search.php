<?php
get_header();

global $wp_query;

$search_query      = get_search_query();
$post_type_param   = isset($_GET['post_type']) ? sanitize_key(wp_unslash((string) $_GET['post_type'])) : '';
$is_product_search = $post_type_param === 'product';
$result_count      = isset($wp_query->found_posts) ? (int) $wp_query->found_posts : 0;
$paged             = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
$products_url      = add_query_arg(['s' => $search_query, 'post_type' => 'product'], home_url('/'));
$all_url           = add_query_arg(['s' => $search_query], home_url('/'));
?>

<!-- Search Header -->
<section class="relative overflow-hidden bg-brand-navy text-white">
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-red/40 blur-3xl animate-blob"></div>
    <div class="absolute top-20 -left-32 w-[500px] h-[500px] rounded-full bg-brand-blue/40 blur-3xl animate-blob" style="animation-delay:4s"></div>
    <div class="absolute bottom-0 right-1/3 w-[400px] h-[400px] rounded-full bg-brand-orange/30 blur-3xl animate-blob" style="animation-delay:8s"></div>
  </div>
  <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(white 1px,transparent 1px),linear-gradient(90deg,white 1px,transparent 1px);background-size:60px 60px"></div>

  <div class="container mx-auto px-6 pt-20 pb-28 lg:pt-28 lg:pb-36 relative text-center">
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">نتائج البحث</div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      <?php if ($search_query): ?>
        بحثك عن <span class="text-gradient-warm">"<?php echo esc_html($search_query); ?>"</span>
      <?php else: ?>
        ابحث في <span class="text-gradient-warm">منتجات بويا ستور</span>
      <?php endif; ?>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      اعثر بسرعة على المنتجات الأصلية، العلامات التجارية، والأقسام المناسبة لاحتياجك.
    </p>

    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="boya-search-form mt-10 max-w-2xl mx-auto">
      <input type="hidden" name="post_type" value="product" />
      <input type="search"
             name="s"
             value="<?php echo esc_attr($search_query); ?>"
             placeholder="اكتب اسم المنتج أو العلامة التجارية..."
             class="boya-search-input"
             aria-label="كلمة البحث" />
      <button type="submit" class="boya-search-submit">
        بحث
      </button>
    </form>
  </div>

  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Search Results -->
<section class="py-24 lg:py-32">
  <div class="container mx-auto px-6">

    <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-12">
      <div>
        <div class="text-sm font-bold text-brand-red mb-2 tracking-wider">
          <?php echo $result_count > 0 ? esc_html(number_format_i18n($result_count)) . ' نتيجة' : 'ابدأ البحث'; ?>
        </div>
        <h2 class="text-3xl md:text-4xl font-black">
          <?php echo $result_count > 0 ? 'النتائج <span class="text-gradient-warm">المطابقة</span>' : 'لا توجد <span class="text-gradient-warm">نتائج مطابقة</span>'; ?>
        </h2>
      </div>

      <?php if ($search_query): ?>
      <div class="flex flex-wrap gap-2">
        <a href="<?php echo esc_url($products_url); ?>"
           class="px-4 py-2 rounded-full text-sm font-bold transition-colors <?php echo $is_product_search ? 'bg-brand-navy text-white' : 'bg-secondary text-foreground hover:bg-brand-navy hover:text-white'; ?>">
          المنتجات
        </a>
        <a href="<?php echo esc_url($all_url); ?>"
           class="px-4 py-2 rounded-full text-sm font-bold transition-colors <?php echo !$is_product_search ? 'bg-brand-navy text-white' : 'bg-secondary text-foreground hover:bg-brand-navy hover:text-white'; ?>">
          كل النتائج
        </a>
      </div>
      <?php endif; ?>
    </div>

    <?php if ($search_query && have_posts()) : ?>
      <?php if ($is_product_search && function_exists('wc_get_product')) : ?>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
        <?php while (have_posts()) : the_post();
          $product = wc_get_product(get_the_ID());
          if ($product) {
            boya_render_product_card($product);
          }
        endwhile; ?>
      </div>
      <?php else : ?>
      <div class="grid lg:grid-cols-3 gap-6">
        <?php while (have_posts()) : the_post(); ?>
        <?php if (get_post_type() === 'product' && function_exists('wc_get_product')) :
          $product = wc_get_product(get_the_ID());
          if ($product) {
            boya_render_product_card($product);
          }
          continue;
        endif; ?>
        <?php
        $post_type_obj   = get_post_type_object(get_post_type());
        $post_type_label = $post_type_obj ? $post_type_obj->labels->singular_name : 'نتيجة';
        ?>
        <article class="group bg-card rounded-3xl border border-border/60 shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-elegant)] overflow-hidden transition-all duration-500 hover:-translate-y-1">
          <?php if (has_post_thumbnail()) : ?>
          <a href="<?php the_permalink(); ?>" class="block aspect-[16/9] overflow-hidden bg-secondary">
            <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105']); ?>
          </a>
          <?php endif; ?>
          <div class="p-6">
            <div class="text-xs font-bold text-brand-orange mb-2 tracking-wider">
              <?php echo esc_html($post_type_label); ?>
            </div>
            <h3 class="text-xl font-black leading-tight mb-3">
              <a href="<?php the_permalink(); ?>" class="hover:text-brand-orange transition-colors"><?php the_title(); ?></a>
            </h3>
            <p class="text-muted-foreground text-sm leading-relaxed mb-5">
              <?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?>
            </p>
            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-sm font-bold text-brand-navy hover:text-brand-orange transition-colors">
              عرض التفاصيل
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6" /></svg>
            </a>
          </div>
        </article>
        <?php endwhile; ?>
      </div>
      <?php endif; ?>

      <?php if ((int) $wp_query->max_num_pages > 1) : ?>
      <nav class="boya-pagination mt-14" aria-label="صفحات نتائج البحث">
        <?php
        echo paginate_links([
          'total'     => (int) $wp_query->max_num_pages,
          'current'   => $paged,
          'prev_text' => 'السابق',
          'next_text' => 'التالي',
        ]);
        ?>
      </nav>
      <?php endif; ?>

    <?php else : ?>
      <div class="relative overflow-hidden rounded-[2rem] bg-card border border-border/60 shadow-[var(--shadow-soft)] p-8 md:p-12 text-center">
        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-brand-orange/10 blur-3xl"></div>
        <div class="relative max-w-2xl mx-auto">
          <div class="mx-auto mb-5 h-16 w-16 rounded-2xl bg-brand-orange/10 text-brand-orange flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" /></svg>
          </div>
          <h3 class="text-2xl md:text-3xl font-black mb-3">جرّب كلمة بحث أخرى</h3>
          <p class="text-muted-foreground leading-relaxed mb-8">
            استخدم اسم المنتج، نوع الدهان، أو العلامة التجارية. يمكنك أيضًا تصفح الأقسام للوصول للمنتج المناسب.
          </p>
          <div class="flex flex-wrap justify-center gap-2">
            <a href="<?php echo esc_url(home_url('/products')); ?>" class="px-5 py-3 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">كل المنتجات</a>
            <a href="<?php echo esc_url(home_url('/categories')); ?>" class="px-5 py-3 rounded-full bg-secondary text-foreground font-bold hover:bg-brand-navy hover:text-white transition-colors">تصفح الأقسام</a>
          </div>
        </div>
      </div>

      <?php
      $suggested_products = function_exists('boya_get_products') ? boya_get_products(['posts_per_page' => 4]) : null;
      if ($suggested_products && $suggested_products->have_posts()) :
      ?>
      <div class="mt-20">
        <div class="flex items-end justify-between gap-6 mb-10">
          <div>
            <div class="text-sm font-bold text-brand-red mb-2 tracking-wider">اقتراحات سريعة</div>
            <h3 class="text-3xl md:text-4xl font-black">منتجات <span class="text-gradient-warm">الأكثر طلبًا</span></h3>
          </div>
          <a href="<?php echo esc_url(home_url('/products')); ?>" class="hidden md:inline-flex text-sm font-bold text-brand-navy hover:text-brand-orange transition-colors">عرض الكل</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
          <?php while ($suggested_products->have_posts()) : $suggested_products->the_post();
            $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
            if ($product) {
              boya_render_product_card($product);
            }
          endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
