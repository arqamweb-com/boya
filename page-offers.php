<?php
/**
 * Template Name: Offers Page
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
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">عروض حصرية</div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      أفضل <span class="text-gradient-warm">العروض والخصومات</span>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      لا تفوّت تشكيلتنا الحصرية من العروض على أبرز منتجاتنا الأكثر طلبًا.
    </p>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Offer Banners -->
<section id="offers" class="py-24">
  <div class="container mx-auto px-6">
    <div class="grid lg:grid-cols-3 gap-6 mb-20">
      <div class="lg:col-span-2 relative overflow-hidden rounded-[2rem] p-10 lg:p-14 text-white min-h-[400px] flex flex-col justify-between"
           style="background:linear-gradient(135deg,var(--brand-navy),var(--brand-blue) 60%,var(--brand-purple))">
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-brand-orange/40 blur-3xl animate-blob"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-brand-red/30 blur-3xl animate-blob" style="animation-delay:5s"></div>
        <div class="relative">
          <div class="inline-block px-3 py-1 rounded-full bg-white/10 backdrop-blur text-xs font-bold mb-4">عرض حصري لفترة محدودة</div>
          <h3 class="text-4xl lg:text-6xl font-black leading-tight mb-4">
            خصم يصل إلى <span class="text-gradient-warm">40%</span><br />على دهانات السيارات
          </h3>
          <p class="text-white/70 max-w-md">على جميع منتجات الفئة الذهبية من أفضل العلامات التجارية العالمية</p>
        </div>
        <div class="relative flex flex-wrap items-center gap-4">
          <a href="#sale-products" class="group px-7 py-3.5 rounded-full bg-white text-brand-navy font-bold flex items-center gap-2 hover:scale-105 transition-transform">تسوق الآن</a>
          <div class="flex flex-wrap items-center gap-2">
            <div class="px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/15 text-xs font-bold">منتجات أصلية</div>
            <div class="px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/15 text-xs font-bold">شحن سريع</div>
            <div class="px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/15 text-xs font-bold">ضمان الجودة</div>
          </div>
        </div>
      </div>
      <div class="grid grid-rows-2 gap-6">
        <div class="relative overflow-hidden rounded-[2rem] p-8 text-white" style="background:linear-gradient(135deg,var(--brand-red),var(--brand-orange))">
          <div class="absolute -top-12 -left-12 w-48 h-48 rounded-full bg-white/15 blur-2xl"></div>
          <div class="relative">
            <div class="text-xs font-bold opacity-90 mb-2">شحن مجاني</div>
            <h4 class="text-2xl font-black mb-3 leading-tight">للطلبات فوق 500 ج.م</h4>
          </div>
        </div>
        <div class="relative overflow-hidden rounded-[2rem] p-8 text-white" style="background:linear-gradient(135deg,var(--brand-green),var(--brand-blue))">
          <div class="absolute -bottom-12 -right-12 w-48 h-48 rounded-full bg-white/15 blur-2xl"></div>
          <div class="relative">
            <div class="text-xs font-bold opacity-90 mb-2">باقة المحترفين</div>
            <h4 class="text-2xl font-black mb-3 leading-tight">أسعار خاصة للمقاولين</h4>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-sm font-bold">تواصل معنا الآن</a>
          </div>
        </div>
      </div>
    </div>

    <!-- On-sale products from WooCommerce -->
    <div id="sale-products">
      <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-12">
        <div>
          <div class="text-sm font-bold text-brand-red mb-1 tracking-wider">عروض اليوم</div>
          <h2 class="text-3xl md:text-4xl font-black">منتجات <span class="text-gradient-warm">مخفّضة الآن</span></h2>
        </div>
        <a href="<?php echo esc_url(home_url('/products')); ?>" class="text-sm font-bold text-brand-navy hover:text-brand-orange transition-colors">
          عرض كل المنتجات ←
        </a>
      </div>

      <?php
      // Get on-sale product IDs first
      $sale_ids = function_exists('wc_get_product_ids_on_sale') ? wc_get_product_ids_on_sale() : [];

      $sale_args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'total_sales',
        'order'          => 'DESC',
      ];

      if (!empty($sale_ids)) {
        $sale_args['post__in'] = $sale_ids;
      }
      // If no products on sale, fall back to popular products
      $sale_query = new WP_Query($sale_args);
      ?>

      <?php if ($sale_query->have_posts()): ?>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
        <?php while ($sale_query->have_posts()): $sale_query->the_post();
          $product = wc_get_product(get_the_ID());
          if ($product) boya_render_product_card($product);
        endwhile; wp_reset_postdata(); ?>
      </div>
      <?php else: ?>
      <div class="text-center py-12 text-muted-foreground">
        <p>لا توجد منتجات مخفّضة حالياً. تابعونا قريباً!</p>
      </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<?php get_footer(); ?>
