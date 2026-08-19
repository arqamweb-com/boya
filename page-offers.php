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
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow"><?php esc_html_e('عروض حصرية', 'arqamweb'); ?></div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      <?php esc_html_e('أفضل', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('العروض والخصومات', 'arqamweb'); ?></span>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      <?php esc_html_e('لا تفوّت تشكيلتنا الحصرية من العروض على أبرز منتجاتنا الأكثر طلبًا.', 'arqamweb'); ?>
    </p>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<?php get_template_part('template-parts/components/sections/section', 'offers'); ?>

<?php get_footer(); ?>
