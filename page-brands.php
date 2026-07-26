<?php
/**
 * Template Name: Brands Page
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
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">شركاء النجاح</div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      أرقى <span class="text-gradient-warm">العلامات التجارية العالمية</span>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      نفخر بكوننا الوكلاء المعتمدين لأشهر علامات الدهانات حول العالم
    </p>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Brands Grid -->
<section id="brands" class="py-24 bg-secondary/40 relative overflow-hidden">
  <div class="container mx-auto px-6">
    <div class="text-center mb-16">
      <div class="text-sm font-bold text-brand-blue mb-3 tracking-wider">شركاء النجاح</div>
      <h2 class="text-4xl md:text-5xl font-black mb-4">
        أرقى <span class="text-gradient-warm">العلامات التجارية</span> العالمية
      </h2>
      <p class="text-muted-foreground max-w-2xl mx-auto">نفخر بكوننا الوكلاء المعتمدين لأشهر علامات الدهانات حول العالم</p>
    </div>

    <?php
    $brands_tax = boya_get_brands_taxonomy();
    $brands     = $brands_tax ? get_terms(['taxonomy' => $brands_tax, 'hide_empty' => false, 'number' => 24]) : [];
    ?>

    <?php if (!empty($brands) && !is_wp_error($brands)) : ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
      <?php foreach ($brands as $brand) :
        $image_url  = boya_term_image($brand, 'medium');
        $term_link  = get_term_link($brand);
      ?>
      <a href="<?php echo esc_url($term_link); ?>"
         class="group relative aspect-[3/2] rounded-2xl bg-white border border-border/60 flex flex-col items-center justify-center gap-4 overflow-hidden p-6 transition-all duration-500 hover:-translate-y-1 hover:shadow-[var(--shadow-elegant)] opacity-0 translate-y-8 blur-[2px]">
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
             style="background:radial-gradient(circle at center,var(--brand-orange),transparent 70%);filter:blur(40px)"></div>
        <?php if ($image_url): ?>
        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($brand->name); ?>" loading="lazy"
             class="relative max-h-24 lg:max-h-28 max-w-[85%] object-contain transition-transform duration-500 group-hover:scale-110" />
        <?php endif; ?>
        <div class="absolute bottom-0 right-0 left-0 h-1 origin-right scale-x-0 group-hover:scale-x-100 transition-transform duration-500"
             style="background:var(--brand-orange)"></div>
      </a>
      <?php endforeach; ?>
    </div>

    <?php else: // No brands taxonomy installed ?>
    <div class="text-center py-16 text-muted-foreground">
      <?php if (!$brands_tax): ?>
      <p class="mb-2 font-bold">لم يتم العثور على تاكسونومي للعلامات التجارية.</p>
      <p class="text-sm">يرجى تثبيت إضافة <strong>YITH WooCommerce Brands</strong> أو إنشاء تاكسونومي باسم <code>product_brand</code>.</p>
      <?php else: ?>
      <p>لا توجد علامات تجارية حتى الآن. يرجى إضافتها من لوحة التحكم.</p>
      <?php endif; ?>
      <?php if (current_user_can('manage_options') && $brands_tax): ?>
      <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=' . $brands_tax . '&post_type=product')); ?>"
         class="mt-4 inline-block px-6 py-3 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
        إضافة علامات تجارية →
      </a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
