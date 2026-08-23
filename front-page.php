<?php
/**
 * Template Name: Front Page
 */
get_header();
$images = get_template_directory_uri() . '/assets/images';
?>

<!-- Hero Section -->
<section id="home" class="relative overflow-hidden bg-brand-navy text-white">
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-red/40 blur-3xl animate-blob"></div>
    <div class="absolute top-40 -left-32 w-[500px] h-[500px] rounded-full bg-brand-blue/50 blur-3xl animate-blob" style="animation-delay:4s"></div>
    <div class="absolute bottom-0 right-1/3 w-[400px] h-[400px] rounded-full bg-brand-orange/30 blur-3xl animate-blob" style="animation-delay:8s"></div>
  </div>
  <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(white 1px,transparent 1px),linear-gradient(90deg,white 1px,transparent 1px);background-size:60px 60px"></div>

  <div class="container mx-auto px-6 pt-16 pb-24 lg:pt-24 lg:pb-32 relative">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div class="space-y-8 animate-fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-dark text-sm">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-brand-yellow"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" /><path d="M5 3v4" /><path d="M19 17v4" /><path d="M3 5h4" /><path d="M17 19h4" /></svg>
          <span><?php esc_html_e('الوجهة الأولى لدهانات السيارات والإنشاءات', 'arqamweb'); ?></span>
        </div>

        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-[1.1]">
          <?php esc_html_e('ألوان تصنع', 'arqamweb'); ?>
          <span class="block mt-2">
            <span class="text-gradient-warm"><?php esc_html_e('فرقاً حقيقياً', 'arqamweb'); ?></span>
          </span>
          <?php esc_html_e('في عالمك', 'arqamweb'); ?>
        </h1>

        <p class="text-lg text-white/70 max-w-xl leading-relaxed">
          <?php esc_html_e('بويا ستور — وجهتك الموثوقة لأفضل دهانات السيارات، الإنشاءات، الأخشاب والمنتجات الصناعية من أرقى العلامات التجارية العالمية.', 'arqamweb'); ?>
        </p>

        <div class="flex flex-wrap gap-4">
          <a href="<?php echo esc_url(home_url('/products')); ?>" class="group relative overflow-hidden px-8 py-4 rounded-full bg-white text-brand-navy font-bold shadow-[var(--shadow-elegant)] hover:scale-105 transition-transform inline-flex items-center gap-2">
            <?php esc_html_e('تسوق الآن', 'arqamweb'); ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 boya-arrow"><path d="m9 18 6-6-6-6" /></svg>
          </a>
          <a href="<?php echo esc_url(home_url('/brands')); ?>" class="px-8 py-4 rounded-full border-2 border-white/20 hover:bg-white/10 font-bold transition-colors">
            <?php esc_html_e('استكشف العلامات التجارية', 'arqamweb'); ?>
          </a>
        </div>

        <div class="flex flex-wrap gap-8 pt-6 border-t border-white/10">
          <div>
            <div class="text-3xl font-black text-gradient-warm" data-count="15000">+15K</div>
            <div class="text-sm text-white/60 mt-1"><?php esc_html_e('منتج متوفر', 'arqamweb'); ?></div>
          </div>
          <div>
            <div class="text-3xl font-black text-gradient-warm" data-count="8">+8</div>
            <div class="text-sm text-white/60 mt-1"><?php esc_html_e('علامات عالمية', 'arqamweb'); ?></div>
          </div>
          <div>
            <div class="text-3xl font-black text-gradient-warm" data-count="50000">+50K</div>
            <div class="text-sm text-white/60 mt-1"><?php esc_html_e('عميل سعيد', 'arqamweb'); ?></div>
          </div>
        </div>
      </div>

      <div class="relative">
        <div class="relative aspect-square rounded-[2.5rem] overflow-hidden shadow-[var(--shadow-elegant)]" id="hero-slideshow">
          <img src="<?php echo esc_url($images . '/hero-auto.jpg'); ?>" alt="<?php esc_attr_e('دهانات سيارات', 'arqamweb'); ?>" width="600" height="600" class="absolute inset-0 w-full h-full object-cover scale-110 transition-opacity duration-1000 opacity-100 hero-slide" />
          <img src="<?php echo esc_url($images . '/hero-wood.jpg'); ?>" alt="<?php esc_attr_e('دهانات خشب', 'arqamweb'); ?>" width="600" height="600" class="absolute inset-0 w-full h-full object-cover scale-110 transition-opacity duration-1000 opacity-0 hero-slide" />
          <img src="<?php echo esc_url($images . '/hero-construction.jpg'); ?>" alt="<?php esc_attr_e('دهانات إنشائية', 'arqamweb'); ?>" width="600" height="600" class="absolute inset-0 w-full h-full object-cover scale-110 transition-opacity duration-1000 opacity-0 hero-slide" />
          <img src="<?php echo esc_url($images . '/hero-industrial.jpg'); ?>" alt="<?php esc_attr_e('منتجات صناعية', 'arqamweb'); ?>" width="600" height="600" class="absolute inset-0 w-full h-full object-cover scale-110 transition-opacity duration-1000 opacity-0 hero-slide" />
          <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/60 via-transparent to-transparent"></div>
          <div class="absolute top-6 right-6 glass-dark px-4 py-2 rounded-full text-sm font-bold text-white" id="hero-slide-label"><?php esc_html_e('دهانات سيارات', 'arqamweb'); ?></div>
          <div class="absolute bottom-6 right-6 left-6 flex items-center justify-center">
            <div class="flex gap-1.5" id="hero-dots">
              <button onclick="setHeroSlide(0)" aria-label="<?php esc_attr_e('دهانات سيارات', 'arqamweb'); ?>" class="h-2 rounded-full transition-all w-6 bg-white hero-dot"></button>
              <button onclick="setHeroSlide(1)" aria-label="<?php esc_attr_e('دهانات خشب', 'arqamweb'); ?>" class="h-2 rounded-full transition-all w-2 bg-white/40 hero-dot"></button>
              <button onclick="setHeroSlide(2)" aria-label="<?php esc_attr_e('دهانات إنشائية', 'arqamweb'); ?>" class="h-2 rounded-full transition-all w-2 bg-white/40 hero-dot"></button>
              <button onclick="setHeroSlide(3)" aria-label="<?php esc_attr_e('منتجات صناعية', 'arqamweb'); ?>" class="h-2 rounded-full transition-all w-2 bg-white/40 hero-dot"></button>
            </div>
          </div>
        </div>

        <!-- Floating cards -->
        <div class="absolute -bottom-6 -right-6 glass text-foreground p-4 rounded-2xl shadow-[var(--shadow-elegant)] animate-float">
          <div class="flex items-center gap-3">
            <div class="p-2 rounded-xl bg-brand-green/15 text-brand-green">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>
            </div>
            <div>
              <div class="text-xs text-muted-foreground"><?php esc_html_e('منتجات', 'arqamweb'); ?></div>
              <div class="font-bold text-sm"><?php esc_html_e('أصلية 100%', 'arqamweb'); ?></div>
            </div>
          </div>
        </div>
        <div class="absolute -top-6 -left-6 glass text-foreground p-4 rounded-2xl shadow-[var(--shadow-elegant)] animate-float" style="animation-delay:2s">
          <div class="flex items-center gap-3">
            <div class="p-2 rounded-xl bg-brand-orange/15 text-brand-orange">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><rect x="1" y="3" width="15" height="13" /><polygon points="16 8 20 8 23 11 23 16 16 16 16 8" /><circle cx="5.5" cy="18.5" r="2.5" /><circle cx="18.5" cy="18.5" r="2.5" /></svg>
            </div>
            <div>
              <div class="text-xs text-muted-foreground"><?php esc_html_e('شحن', 'arqamweb'); ?></div>
              <div class="font-bold text-sm"><?php esc_html_e('سريع وآمن', 'arqamweb'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Categories Section -->
<section id="categories" class="py-24 lg:py-32 relative">
  <div class="container mx-auto px-6">
    <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-16">
      <div class="max-w-xl">
        <div class="inline-block text-sm font-bold text-brand-orange mb-3 tracking-wider"><?php esc_html_e('أقسامنا', 'arqamweb'); ?></div>
        <h2 class="text-4xl md:text-5xl font-black leading-tight">
          <?php esc_html_e('تشكيلة', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('متكاملة', 'arqamweb'); ?></span> <?php esc_html_e('لكل احتياجاتك', 'arqamweb'); ?>
        </h2>
      </div>
      <p class="text-muted-foreground max-w-md">
        <?php esc_html_e('من دهانات السيارات إلى المنتجات الصناعية، نوفر كل ما تحتاجه بأعلى معايير الجودة العالمية.', 'arqamweb'); ?>
      </p>
    </div>

    <?php
    $accent_colors = ['var(--brand-red)','var(--brand-yellow)','var(--brand-orange)','var(--brand-blue)'];
    $uncategorized = get_term_by('slug', 'uncategorized', 'product_cat');
    $hp_cats = get_terms([
      'taxonomy'   => 'product_cat',
      'hide_empty' => false,
      'parent'     => 0,
      'number'     => 4,
      'exclude'    => $uncategorized ? [$uncategorized->term_id] : [],
    ]);
    ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php if (!empty($hp_cats) && !is_wp_error($hp_cats)) :
        foreach ($hp_cats as $ci => $hcat) :
          $img_url = boya_term_image($hcat, 'large');
          $accent  = $accent_colors[$ci % count($accent_colors)];
          $cnt_txt = $hcat->count > 0
            ? sprintf(
                /* translators: %s: number of products in the category */
                _n('%s منتج', '%s منتجات', $hcat->count, 'arqamweb'),
                number_format_i18n($hcat->count)
              )
            : '';
      ?>
      <a href="<?php echo esc_url(get_term_link($hcat)); ?>"
         class="group relative aspect-[3/4] rounded-3xl overflow-hidden cursor-pointer shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-elegant)] transition-all duration-500 hover:-translate-y-2">
        <?php if ($img_url): ?>
        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($hcat->name); ?>" loading="lazy"
             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
        <?php else: ?>
        <div class="absolute inset-0" style="background:linear-gradient(135deg,<?php echo esc_attr($accent); ?>,color-mix(in oklab,<?php echo esc_attr($accent); ?> 50%,var(--brand-navy)))"></div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
        <?php if ($cnt_txt): ?><div class="absolute top-4 start-4 px-3 py-1 rounded-full glass text-xs font-bold text-foreground"><?php echo esc_html($cnt_txt); ?></div><?php endif; ?>
        <div class="absolute bottom-0 right-0 left-0 p-6 text-white">
          <h3 class="text-2xl font-black mb-1"><?php echo esc_html($hcat->name); ?></h3>
          <?php if ($hcat->description): ?><p class="text-sm text-white/80 mb-4"><?php echo esc_html(wp_trim_words($hcat->description, 6)); ?></p><?php endif; ?>
          <div class="flex items-center gap-2 text-sm font-bold opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all duration-500">
            <?php esc_html_e('استكشف القسم', 'arqamweb'); ?>
            <svg class="boya-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6" /></svg>
          </div>
        </div>
      </a>
      <?php endforeach; else: ?>
      <div class="col-span-4 text-center py-8 text-muted-foreground"><?php esc_html_e('أضف أقسام المنتجات من WooCommerce لتظهر هنا.', 'arqamweb'); ?></div>
      <?php endif; ?>
    </div>

    <div class="flex justify-center mt-12">
      <a href="<?php echo esc_url(home_url('/categories')); ?>" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
        <?php esc_html_e('عرض كل الأقسام', 'arqamweb'); ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 boya-arrow"><path d="m9 18 6-6-6-6" /></svg>
      </a>
    </div>
  </div>
</section>

<!-- Brands Section -->
<section id="brands" class="py-24 bg-secondary/40 relative overflow-hidden">
  <div class="container mx-auto px-6">
    <div class="text-center mb-16">
      <div class="text-sm font-bold text-brand-blue mb-3 tracking-wider"><?php esc_html_e('شركاء النجاح', 'arqamweb'); ?></div>
      <h2 class="text-4xl md:text-5xl font-black mb-4">
        <?php esc_html_e('أرقى', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('العلامات التجارية', 'arqamweb'); ?></span> <?php esc_html_e('العالمية', 'arqamweb'); ?>
      </h2>
      <p class="text-muted-foreground max-w-2xl mx-auto"><?php esc_html_e('نفخر بكوننا الوكلاء المعتمدين لأشهر علامات الدهانات حول العالم', 'arqamweb'); ?></p>
    </div>
    <?php
    $hp_brands_tax = boya_get_brands_taxonomy();
    $hp_brands = $hp_brands_tax ? get_terms(['taxonomy' => $hp_brands_tax, 'hide_empty' => false, 'number' => 8]) : [];
    ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
      <?php if (!empty($hp_brands) && !is_wp_error($hp_brands)) :
        foreach ($hp_brands as $hbrand) :
          $bimg = boya_term_image($hbrand, 'medium');
          $blink = get_term_link($hbrand);
      ?>
      <a href="<?php echo esc_url($blink); ?>"
         class="group relative aspect-[3/2] rounded-2xl bg-white border border-border/60 flex flex-col items-center justify-center gap-4 overflow-hidden p-6 transition-all duration-500 hover:-translate-y-1 hover:shadow-[var(--shadow-elegant)]">
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at center,var(--brand-orange),transparent 70%);filter:blur(40px)"></div>
        <?php if ($bimg): ?><img src="<?php echo esc_url($bimg); ?>" alt="<?php echo esc_attr($hbrand->name); ?>" loading="lazy" class="relative max-h-24 lg:max-h-28 max-w-[85%] object-contain transition-transform duration-500 group-hover:scale-110" /><?php endif; ?>
        <div class="absolute bottom-0 right-0 left-0 h-1 origin-right scale-x-0 group-hover:scale-x-100 transition-transform duration-500" style="background:var(--brand-orange)"></div>
      </a>
      <?php endforeach; else: ?>
      <div style="grid-column:1/-1" class="text-center py-8 text-muted-foreground text-sm"><?php esc_html_e('أضف العلامات التجارية من WooCommerce لتظهر هنا.', 'arqamweb'); ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Products Section -->
<section id="products" class="py-24 lg:py-32">
  <div class="container mx-auto px-6">
    <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-16">
      <div>
        <div class="text-sm font-bold text-brand-red mb-3 tracking-wider"><?php esc_html_e('منتجات مميزة', 'arqamweb'); ?></div>
        <h2 class="text-4xl md:text-5xl font-black">
          <?php esc_html_e('الأكثر', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('رواجاً', 'arqamweb'); ?></span> <?php esc_html_e('هذا الشهر', 'arqamweb'); ?>
        </h2>
      </div>
      <a href="<?php echo esc_url(home_url('/products')); ?>" class="group inline-flex items-center gap-2 text-sm font-bold text-brand-navy hover:text-brand-orange transition-colors">
        <?php esc_html_e('عرض كل المنتجات الرائجة', 'arqamweb'); ?>
        <span class="h-px w-8 bg-current group-hover:w-12 transition-all"></span>
      </a>
    </div>

    <?php $hp_products = boya_get_products(['posts_per_page' => 4]); ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
      <?php if ($hp_products->have_posts()) :
        while ($hp_products->have_posts()) : $hp_products->the_post();
          $product = wc_get_product(get_the_ID());
          if ($product) boya_render_product_card($product);
        endwhile;
        wp_reset_postdata();
      else: ?>
      <div style="grid-column:1/-1" class="text-center py-8 text-muted-foreground text-sm"><?php esc_html_e('أضف منتجات WooCommerce لتظهر هنا.', 'arqamweb'); ?></div>
      <?php endif; ?>
    </div>

    <div class="flex justify-center mt-14">
      <a href="<?php echo esc_url(home_url('/products')); ?>" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
        <?php esc_html_e('عرض كل المنتجات', 'arqamweb'); ?>
        <span class="boya-arrow" aria-hidden="true">→</span>
      </a>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-gradient-to-b from-secondary/40 to-background">
  <div class="container mx-auto px-6">
    <div class="text-center max-w-2xl mx-auto mb-16">
      <div class="text-sm font-bold text-brand-green mb-3 tracking-wider"><?php esc_html_e('لماذا بويا ستور', 'arqamweb'); ?></div>
      <h2 class="text-4xl md:text-5xl font-black mb-4"><?php esc_html_e('خبرة', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('تستحق الثقة', 'arqamweb'); ?></span></h2>
      <p class="text-muted-foreground"><?php esc_html_e('نقدم لك تجربة شراء متكاملة من البداية للنهاية', 'arqamweb'); ?></p>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php
      $feats = [
        ['title'=>__('جودة موثوقة', 'arqamweb'),'desc'=>__('منتجات معتمدة من أرقى المصانع العالمية', 'arqamweb'),'color'=>'var(--brand-green)','icon'=>'shield-check'],
        ['title'=>__('تشكيلة واسعة', 'arqamweb'),'desc'=>__('أكثر من 15,000 منتج لكافة الاحتياجات', 'arqamweb'),'color'=>'var(--brand-orange)','icon'=>'package'],
        ['title'=>__('توصيل سريع', 'arqamweb'),'desc'=>__('شحن سريع وآمن لجميع مناطق الجمهورية', 'arqamweb'),'color'=>'var(--brand-red)','icon'=>'truck'],
        ['title'=>__('دعم احترافي', 'arqamweb'),'desc'=>__('فريق متخصص لمساعدتك على مدار الساعة', 'arqamweb'),'color'=>'var(--brand-blue)','icon'=>'headphones'],
        ['title'=>__('منتجات أصلية', 'arqamweb'),'desc'=>__('ضمان الأصالة 100% من الوكلاء المعتمدين', 'arqamweb'),'color'=>'var(--brand-purple)','icon'=>'award'],
        ['title'=>__('أسعار تنافسية', 'arqamweb'),'desc'=>__('أفضل الأسعار مع عروض حصرية متجددة', 'arqamweb'),'color'=>'var(--brand-yellow)','icon'=>'sparkles'],
      ];
      $feat_icons = [
        'shield-check' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'package'      => '<line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
        'truck'        => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
        'headphones'   => '<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>',
        'award'        => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
        'sparkles'     => '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/>',
      ];
      foreach ($feats as $f): ?>
      <div class="group relative p-8 rounded-3xl bg-card border border-border/60 hover:border-transparent transition-all duration-500 hover:-translate-y-2 hover:shadow-[var(--shadow-elegant)] overflow-hidden opacity-0 translate-y-8 blur-[2px]">
        <div class="absolute top-0 right-0 w-32 h-32 rounded-full blur-3xl opacity-0 group-hover:opacity-40 transition-opacity duration-500" style="background:<?php echo esc_attr($f['color']); ?>"></div>
        <div class="relative inline-flex p-4 rounded-2xl mb-5 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-6" style="background:color-mix(in oklab,<?php echo esc_attr($f['color']); ?> 12%,transparent);color:<?php echo esc_attr($f['color']); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7"><?php echo $feat_icons[$f['icon']]; ?></svg>
        </div>
        <h3 class="text-xl font-black mb-2 relative"><?php echo esc_html($f['title']); ?></h3>
        <p class="text-muted-foreground text-sm leading-relaxed relative"><?php echo esc_html($f['desc']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_template_part('template-parts/components/sections/section', 'offers'); ?>

<!-- About Section -->
<section id="about" class="py-24 lg:py-32 relative overflow-hidden">
  <div class="container mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <div class="relative aspect-[4/5] rounded-[2.5rem] overflow-hidden shadow-[var(--shadow-elegant)]">
          <img src="<?php echo esc_url($images . '/about-factory.jpg'); ?>" alt="<?php esc_attr_e('مصنع بويا ستور', 'arqamweb'); ?>" width="800" height="1000" loading="lazy" class="w-full h-full object-cover" />
          <div class="absolute inset-0 bg-gradient-to-tr from-brand-navy/40 to-transparent"></div>
        </div>
        <div class="absolute -bottom-8 -end-8 bg-white rounded-3xl p-6 shadow-[var(--shadow-elegant)] max-w-xs">
          <div class="grid grid-cols-2 gap-4">
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-red)">+20</div><div class="text-xs text-muted-foreground mt-0.5"><?php esc_html_e('سنة خبرة', 'arqamweb'); ?></div></div>
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-orange)">+50K</div><div class="text-xs text-muted-foreground mt-0.5"><?php esc_html_e('عميل', 'arqamweb'); ?></div></div>
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-green)">+15K</div><div class="text-xs text-muted-foreground mt-0.5"><?php esc_html_e('منتج', 'arqamweb'); ?></div></div>
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-blue)">+8</div><div class="text-xs text-muted-foreground mt-0.5"><?php esc_html_e('علامة', 'arqamweb'); ?></div></div>
          </div>
        </div>
        <div class="absolute -top-6 -right-6 w-40 h-40 rounded-full opacity-30" style="background:var(--gradient-rainbow);filter:blur(60px)"></div>
      </div>

      <div class="space-y-8">
        <div>
          <div class="text-sm font-bold text-brand-purple mb-3 tracking-wider"><?php esc_html_e('من نحن', 'arqamweb'); ?></div>
          <h2 class="text-4xl md:text-5xl font-black leading-tight mb-6">
            <?php esc_html_e('قصة شغف', 'arqamweb'); ?><span class="block text-gradient-warm"><?php esc_html_e('بالألوان والإتقان', 'arqamweb'); ?></span>
          </h2>
          <p class="text-muted-foreground leading-relaxed text-lg">
            <?php esc_html_e('منذ تأسيس بويا ستور، التزمنا بتقديم أرقى منتجات الدهانات للعملاء في جمهورية مصر العربية. نعمل مع أكبر العلامات التجارية العالمية لنوفر حلولاً متكاملة للمحترفين والهواة على حدٍ سواء.', 'arqamweb'); ?>
          </p>
        </div>
        <div class="space-y-4">
          <div class="flex gap-4 p-5 rounded-2xl hover:bg-secondary/50 transition-colors">
            <div class="shrink-0 p-3 rounded-xl h-fit" style="background:color-mix(in oklab,var(--brand-red) 12%,transparent);color:var(--brand-red)">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
            </div>
            <div><h4 class="font-bold mb-1"><?php esc_html_e('رسالتنا', 'arqamweb'); ?></h4><p class="text-sm text-muted-foreground"><?php esc_html_e('توفير أفضل الحلول والمنتجات في عالم الدهانات بمعايير عالمية.', 'arqamweb'); ?></p></div>
          </div>
          <div class="flex gap-4 p-5 rounded-2xl hover:bg-secondary/50 transition-colors">
            <div class="shrink-0 p-3 rounded-xl h-fit" style="background:color-mix(in oklab,var(--brand-blue) 12%,transparent);color:var(--brand-blue)">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div><h4 class="font-bold mb-1"><?php esc_html_e('رؤيتنا', 'arqamweb'); ?></h4><p class="text-sm text-muted-foreground"><?php esc_html_e('أن نكون الوجهة الأولى والأكثر ثقة لكل ما يخص الدهانات في المنطقة.', 'arqamweb'); ?></p></div>
          </div>
          <div class="flex gap-4 p-5 rounded-2xl hover:bg-secondary/50 transition-colors">
            <div class="shrink-0 p-3 rounded-xl h-fit" style="background:color-mix(in oklab,var(--brand-green) 12%,transparent);color:var(--brand-green)">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div><h4 class="font-bold mb-1"><?php esc_html_e('قيمنا', 'arqamweb'); ?></h4><p class="text-sm text-muted-foreground"><?php esc_html_e('الجودة، الأمانة، الاحترافية، والابتكار المستمر في خدمة عملائنا.', 'arqamweb'); ?></p></div>
          </div>
        </div>
        <div>
          <a href="<?php echo esc_url(home_url('/about')); ?>" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
            <?php esc_html_e('عرض المزيد', 'arqamweb'); ?> <span class="boya-arrow" aria-hidden="true">→</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="py-24 lg:py-32 bg-secondary/40 relative overflow-hidden">
  <div class="container mx-auto px-6">
    <div class="text-center max-w-2xl mx-auto mb-16">
      <div class="text-sm font-bold text-brand-orange mb-3 tracking-wider"><?php esc_html_e('آراء عملائنا', 'arqamweb'); ?></div>
      <h2 class="text-4xl md:text-5xl font-black"><?php esc_html_e('يثق بنا', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('المحترفون', 'arqamweb'); ?></span></h2>
    </div>
    <?php
    $testimonials = [
      ['name'=>__('أحمد المالكي', 'arqamweb'),'role'=>__('مقاول دهانات', 'arqamweb'),'text'=>__('تعاملت مع بويا ستور لسنوات وأشهد أنهم الأفضل في السوق من ناحية الجودة والسعر والخدمة.', 'arqamweb'),'color'=>'var(--brand-red)'],
      ['name'=>__('خالد العتيبي', 'arqamweb'),'role'=>__('ورشة سيارات', 'arqamweb'),'text'=>__('منتجات أصلية 100% وتوصيل سريع جداً. فريق الدعم محترف ويساعد في اختيار المنتج المناسب.', 'arqamweb'),'color'=>'var(--brand-orange)'],
      ['name'=>__('سعد الحربي', 'arqamweb'),'role'=>__('نجار محترف', 'arqamweb'),'text'=>__('أفضل تشكيلة من دهانات الأخشاب وجدتها. النتائج رائعة والعملاء سعداء دائماً بالنهائيات.', 'arqamweb'),'color'=>'var(--brand-green)'],
      ['name'=>__('محمود فؤاد', 'arqamweb'),'role'=>__('صاحب شركة ديكور', 'arqamweb'),'text'=>__('الجودة ثابتة في كل طلب، والألوان مطابقة تماماً للكتالوج. شركاء نجاح حقيقيون لمشاريعنا.', 'arqamweb'),'color'=>'var(--brand-blue)'],
      ['name'=>__('ياسر عبد الله', 'arqamweb'),'role'=>__('فني دهانات', 'arqamweb'),'text'=>__('أسعار منافسة وخامات ممتازة. التعامل سهل والطلب يوصل في ميعاده من غير أي تأخير.', 'arqamweb'),'color'=>'var(--brand-purple)'],
      ['name'=>__('كريم سمير', 'arqamweb'),'role'=>__('مقاول تشطيبات', 'arqamweb'),'text'=>__('خدمة عملاء تفهم شغلك وترشّحلك المنتج المناسب. وفّرت عليّ وقت ومجهود كبير في مشاريعي.', 'arqamweb'),'color'=>'var(--brand-green)'],
    ];
    ?>
    <div class="blaze-slider boya-testimonials-slider">
      <div class="blaze-container">
        <div class="blaze-track-container">
          <div class="blaze-track">
            <?php foreach ($testimonials as $t): ?>
            <div class="group relative p-8 rounded-3xl bg-card border border-border/60 hover:shadow-[var(--shadow-elegant)] transition-shadow duration-500">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute top-6 end-6 h-8 w-8 opacity-10" style="color:<?php echo esc_attr($t['color']); ?>"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
              <div class="flex gap-1 mb-4">
                <?php for ($i=0;$i<5;$i++): ?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 fill-brand-yellow text-brand-yellow"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg><?php endfor; ?>
              </div>
              <p class="text-foreground/90 leading-relaxed mb-6">"<?php echo esc_html($t['text']); ?>"</p>
              <div class="flex items-center gap-3 pt-5 border-t border-border/60">
                <div class="h-12 w-12 rounded-full flex items-center justify-center text-white font-black shrink-0" style="background:linear-gradient(135deg,<?php echo esc_attr($t['color']); ?>,color-mix(in oklab,<?php echo esc_attr($t['color']); ?> 60%,var(--brand-navy)))">
                  <?php echo esc_html(mb_substr($t['name'], 0, 1)); ?>
                </div>
                <div>
                  <div class="font-bold"><?php echo esc_html($t['name']); ?></div>
                  <div class="text-xs text-muted-foreground"><?php echo esc_html($t['role']); ?></div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="boya-slider-controls">
          <button type="button" class="blaze-prev" aria-label="<?php esc_attr_e('السابق', 'arqamweb'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="boya-arrow"><polyline points="15 18 9 12 15 6"/></svg>
          </button>
          <div class="blaze-pagination"></div>
          <button type="button" class="blaze-next" aria-label="<?php esc_attr_e('التالي', 'arqamweb'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="boya-arrow"><polyline points="9 18 15 12 9 6"/></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="py-24 lg:py-32">
  <div class="container mx-auto px-6">
    <div class="grid lg:grid-cols-12 gap-12">
      <div class="lg:col-span-4">
        <div class="text-sm font-bold text-brand-blue mb-3 tracking-wider"><?php esc_html_e('الأسئلة الشائعة', 'arqamweb'); ?></div>
        <h2 class="text-4xl md:text-5xl font-black mb-4 leading-tight">
          <?php esc_html_e('إجابات على', 'arqamweb'); ?><span class="block text-gradient-warm"><?php esc_html_e('استفساراتك', 'arqamweb'); ?></span>
        </h2>
        <p class="text-muted-foreground"><?php esc_html_e('كل ما تحتاج معرفته قبل اتخاذ قرار الشراء.', 'arqamweb'); ?></p>
      </div>
      <div class="lg:col-span-8 space-y-3">
        <?php
        $faqs = [
          ['q'=>__('هل المنتجات أصلية ومضمونة؟', 'arqamweb'),'a'=>__('نعم، جميع منتجاتنا أصلية 100% ومستوردة مباشرة من الوكلاء المعتمدين للعلامات التجارية العالمية، مع ضمان الجودة على كافة المنتجات.', 'arqamweb')],
          ['q'=>__('كم تستغرق مدة التوصيل؟', 'arqamweb'),'a'=>__('نوفر خدمة توصيل سريعة خلال 24-48 ساعة داخل المدن الرئيسية، و3-5 أيام عمل لباقي مناطق الجمهورية.', 'arqamweb')],
          ['q'=>__('هل توفرون استشارات فنية مجانية؟', 'arqamweb'),'a'=>__('نعم، فريقنا المتخصص متاح لتقديم الاستشارات الفنية المجانية لمساعدتك في اختيار المنتجات الأنسب لمشروعك.', 'arqamweb')],
          ['q'=>__('ما هي طرق الدفع المتاحة؟', 'arqamweb'),'a'=>__('نقبل الدفع عبر البطاقات الائتمانية (Visa / Mastercard)، التحويل البنكي، والدفع عند الاستلام لطلبات محددة.', 'arqamweb')],
          ['q'=>__('هل لديكم برنامج للمقاولين والمحترفين؟', 'arqamweb'),'a'=>__('نعم، نقدم باقة المحترفين بأسعار خاصة، دعم مخصص، وإمكانية الطلب بكميات كبيرة مع خصومات تنافسية.', 'arqamweb')],
        ];
        foreach ($faqs as $i => $f): ?>
        <div class="rounded-2xl border transition-all duration-300 overflow-hidden border-border bg-card" data-accordion-item>
          <button data-accordion-trigger class="w-full flex items-center justify-between gap-6 p-6 text-start">
            <span class="font-bold text-lg"><?php echo esc_html($f['q']); ?></span>
            <span class="shrink-0 h-9 w-9 rounded-full flex items-center justify-center transition-all duration-300 bg-secondary text-foreground" data-accordion-icon>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </span>
          </button>
          <div data-accordion-content class="grid grid-rows-[0fr] transition-all duration-500 opacity-0">
            <div class="overflow-hidden">
              <p class="px-6 pb-6 text-muted-foreground leading-relaxed"><?php echo esc_html($f['a']); ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-24 lg:py-32 bg-secondary/40">
  <div class="container mx-auto px-6">
    <div class="text-center max-w-2xl mx-auto mb-16">
      <div class="text-sm font-bold text-brand-green mb-3 tracking-wider"><?php esc_html_e('تواصل معنا', 'arqamweb'); ?></div>
      <h2 class="text-4xl md:text-5xl font-black"><?php esc_html_e('دعنا', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('نساعدك', 'arqamweb'); ?></span> <?php esc_html_e('اليوم', 'arqamweb'); ?></h2>
    </div>
    <div class="grid lg:grid-cols-5 gap-8">
      <div class="lg:col-span-2 space-y-4">
        <?php
        $contacts = [
          ['icon'=>'phone','title'=>__('اتصل بنا', 'arqamweb'),'value'=>"01038304949\n01038314148\n0237532216",'color'=>'var(--brand-red)'],
          ['icon'=>'message-circle','title'=>__('واتساب', 'arqamweb'),'value'=>'01038314148','color'=>'var(--brand-green)','cta'=>__('ابدأ المحادثة', 'arqamweb')],
          ['icon'=>'mail','title'=>__('البريد الإلكتروني', 'arqamweb'),'value'=>'info@boyastore-eg.com','color'=>'var(--brand-blue)'],
          ['icon'=>'map-pin','title'=>__('العنوان', 'arqamweb'),'value'=>__('34 ش محمد حمزة البطران، متفرع من الفريق علي فهمي، المنصورية - الهرم', 'arqamweb'),'color'=>'var(--brand-orange)'],
          ['icon'=>'clock','title'=>__('مواعيد التسليم', 'arqamweb'),'value'=>__("الطلبات من 6 صباحًا إلى 3 عصرًا تُسلّم في نفس اليوم.\nمن 4 عصرًا إلى 12 منتصف الليل تُسلّم في اليوم التالي.", 'arqamweb'),'color'=>'var(--brand-purple)'],
        ];
        $contact_icons = [
          'phone'          => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.85 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.96 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>',
          'message-circle' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
          'mail'           => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
          'map-pin'        => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
          'clock'          => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        ];
        foreach ($contacts as $c): ?>
        <div class="group p-6 rounded-3xl bg-card border border-border/60 hover:shadow-[var(--shadow-elegant)] hover:-translate-y-1 transition-all duration-300">
          <div class="flex items-start gap-4">
            <div class="shrink-0 p-3 rounded-2xl transition-transform group-hover:scale-110 group-hover:-rotate-6" style="background:color-mix(in oklab,<?php echo esc_attr($c['color']); ?> 12%,transparent);color:<?php echo esc_attr($c['color']); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $contact_icons[$c['icon']]; ?></svg>
            </div>
            <div class="flex-1 min-w-0">
              <div class="text-xs text-muted-foreground mb-1"><?php echo esc_html($c['title']); ?></div>
              <div class="font-bold break-words whitespace-pre-line"><?php echo esc_html($c['value']); ?></div>
              <?php if (!empty($c['cta'])): ?>
              <a href="https://wa.me/201038314148" class="inline-block mt-2 text-xs font-bold" style="color:<?php echo esc_attr($c['color']); ?>"><?php echo esc_html($c['cta']); ?> <span class="boya-arrow" aria-hidden="true">→</span></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

     <div class="lg:col-span-3 bg-card rounded-3xl p-8 shadow-[var(--shadow-soft)] border border-border/60 space-y-4">
        <h3 class="text-2xl font-black mb-2"><?php esc_html_e('أرسل لنا رسالة', 'arqamweb'); ?></h3>
        <p class="text-muted-foreground text-sm mb-6"><?php esc_html_e('سنرد عليك في أقرب وقت ممكن', 'arqamweb'); ?></p>

          <div>
              <?php echo do_shortcode('[contact-form-7 id="14a5d4d" title="Contact Us"]'); ?>
          </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
