<?php
/**
 * Template Name: Categories Page
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
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow"><?php esc_html_e('أقسامنا', 'arqamweb'); ?></div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      <?php esc_html_e('تشكيلة', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('متكاملة لكل احتياجاتك', 'arqamweb'); ?></span>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      <?php esc_html_e('من دهانات السيارات إلى المنتجات الصناعية، نوفر كل ما تحتاجه بأعلى معايير الجودة العالمية.', 'arqamweb'); ?>
    </p>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Categories Grid -->
<section id="categories" class="py-24 lg:py-32 relative">
  <div class="container mx-auto px-6">
    <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-16">
      <div class="max-w-xl">
        <div class="inline-block text-sm font-bold text-brand-orange mb-3 tracking-wider"><?php esc_html_e('أقسامنا', 'arqamweb'); ?></div>
        <h2 class="text-4xl md:text-5xl font-black leading-tight">
          <?php esc_html_e('تشكيلة', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('متكاملة', 'arqamweb'); ?></span> <?php esc_html_e('لكل احتياجاتك', 'arqamweb'); ?>
        </h2>
      </div>
      <p class="text-muted-foreground max-w-md"><?php esc_html_e('من دهانات السيارات إلى المنتجات الصناعية، نوفر كل ما تحتاجه بأعلى معايير الجودة العالمية.', 'arqamweb'); ?></p>
    </div>

    <?php
    $accent_colors = [
      'var(--brand-red)', 'var(--brand-yellow)',
      'var(--brand-orange)', 'var(--brand-blue)',
      'var(--brand-green)', 'var(--brand-purple)',
    ];

    if (function_exists('get_terms')) :
      $uncategorized = get_term_by('slug', 'uncategorized', 'product_cat');
      $exclude_ids   = $uncategorized ? [$uncategorized->term_id] : [];

      $cats = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'number'     => 12,
        'exclude'    => $exclude_ids,
      ]);
    endif;

    if (!empty($cats) && !is_wp_error($cats)) :
    ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ($cats as $i => $cat) :
        $image_url = boya_term_image($cat, 'large');
        $accent    = $accent_colors[$i % count($accent_colors)];
        $count_txt = $cat->count > 0
          ? sprintf(
              /* translators: %s: number of products in the category */
              _n('%s منتج', '%s منتجات', $cat->count, 'arqamweb'),
              number_format_i18n($cat->count)
            )
          : '';
        $term_link = get_term_link($cat);
      ?>
      <a href="<?php echo esc_url($term_link); ?>"
         class="group relative aspect-[3/4] rounded-3xl overflow-hidden cursor-pointer shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-elegant)] transition-all duration-500 hover:-translate-y-2 opacity-0 translate-y-8 blur-[2px]">
        <?php if ($image_url): ?>
        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" loading="lazy"
             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
        <?php else: ?>
        <div class="absolute inset-0" style="background:linear-gradient(135deg,<?php echo esc_attr($accent); ?>,color-mix(in oklab,<?php echo esc_attr($accent); ?> 60%,var(--brand-navy)))"></div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
        <?php if ($count_txt): ?>
        <div class="absolute top-4 right-4 px-3 py-1 rounded-full glass text-xs font-bold text-foreground"><?php echo esc_html($count_txt); ?></div>
        <?php endif; ?>
        <div class="absolute bottom-0 right-0 left-0 p-6 text-white">
          <h3 class="text-2xl font-black mb-1"><?php echo esc_html($cat->name); ?></h3>
          <?php if ($cat->description): ?>
          <p class="text-sm text-white/80 mb-4"><?php echo esc_html(wp_trim_words($cat->description, 6)); ?></p>
          <?php endif; ?>
          <div class="flex items-center gap-2 text-sm font-bold opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all duration-500">
            <?php esc_html_e('استكشف القسم', 'arqamweb'); ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6" /></svg>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <?php else: // Fallback if WooCommerce categories are empty ?>
    <div class="text-center py-16 text-muted-foreground">
      <p><?php esc_html_e('لا توجد أقسام حتى الآن. يرجى إضافة أقسام المنتجات من لوحة التحكم في WooCommerce.', 'arqamweb'); ?></p>
      <?php if (current_user_can('manage_options')): ?>
      <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=product_cat&post_type=product')); ?>"
         class="mt-4 inline-block px-6 py-3 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
        <?php esc_html_e('إضافة أقسام', 'arqamweb'); ?> →
      </a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
