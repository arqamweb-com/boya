<?php get_header(); ?>

<div class="flex min-h-[60vh] items-center justify-center px-4 py-24">
  <div class="max-w-md text-center">
    <div class="text-8xl font-black text-gradient-warm mb-4">404</div>
    <h1 class="text-3xl font-black text-foreground mb-3">الصفحة غير موجودة</h1>
    <p class="text-muted-foreground mb-8">
      الصفحة التي تبحث عنها غير موجودة أو تم نقلها.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?php echo esc_url(home_url('/')); ?>"
         class="px-8 py-4 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
        العودة للرئيسية
      </a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>"
         class="px-8 py-4 rounded-full border-2 border-border hover:bg-secondary font-bold transition-colors">
        تواصل معنا
      </a>
    </div>
  </div>
</div>

<?php get_footer(); ?>
