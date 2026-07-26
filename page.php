<?php
/**
 * Generic page template — used for all pages without a specific template.
 * Covers: WooCommerce cart, checkout, my account, and any other WordPress pages.
 */
get_header();

$is_wc_page = function_exists('is_woocommerce') && ( is_cart() || is_checkout() || is_account_page() || is_woocommerce() );
?>

<?php if ($is_wc_page): ?>

<!-- WooCommerce page header -->
<section class="relative overflow-hidden bg-brand-navy text-white">
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-red/40 blur-3xl animate-blob"></div>
    <div class="absolute top-20 -left-32 w-[500px] h-[500px] rounded-full bg-brand-blue/40 blur-3xl animate-blob" style="animation-delay:4s"></div>
  </div>
  <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(white 1px,transparent 1px),linear-gradient(90deg,white 1px,transparent 1px);background-size:60px 60px"></div>
  <div class="container mx-auto px-6 pt-20 pb-28 lg:pt-24 lg:pb-32 relative text-center">
    <?php
    if (is_cart()):
      echo '<div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">التسوق</div>';
      echo '<h1 class="text-4xl md:text-5xl font-black">سلة <span class="text-gradient-warm">التسوق</span></h1>';
    elseif (is_checkout() && !is_order_received_page()):
      echo '<div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">الدفع</div>';
      echo '<h1 class="text-4xl md:text-5xl font-black">إتمام <span class="text-gradient-warm">الشراء</span></h1>';
    elseif (is_order_received_page()):
      echo '<div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">تم الطلب</div>';
      echo '<h1 class="text-4xl md:text-5xl font-black">شكراً على <span class="text-gradient-warm">طلبك!</span></h1>';
    elseif (is_account_page()):
      $name = wp_get_current_user()->first_name ?: wp_get_current_user()->display_name;
      echo '<div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">حسابي</div>';
      echo '<h1 class="text-4xl md:text-5xl font-black">مرحباً <span class="text-gradient-warm">' . esc_html($name) . '</span></h1>';
    else:
      the_title('<h1 class="text-4xl md:text-5xl font-black">', '</h1>');
    endif;
    ?>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<div class="py-16 lg:py-24">
  <div class="container mx-auto px-6">
    <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
  </div>
</div>

<?php else: ?>

<!-- Generic page fallback -->
<div class="container mx-auto px-6 py-24">
  <?php while (have_posts()): the_post(); ?>
  <h1 class="text-3xl font-black mb-8"><?php the_title(); ?></h1>
  <div class="prose max-w-none"><?php the_content(); ?></div>
  <?php endwhile; ?>
</div>

<?php endif; ?>

<?php get_footer(); ?>
