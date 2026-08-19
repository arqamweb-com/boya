<?php
/**
 * Empty cart template override.
 */
defined('ABSPATH') || exit;
?>

<div class="boya-empty-state">
  <div class="boya-empty-state__icon" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
      <line x1="3" y1="6" x2="21" y2="6"/>
      <path d="M16 10a4 4 0 0 1-8 0"/>
    </svg>
  </div>

  <h2><?php esc_html_e('سلتك فارغة حالياً', 'arqamweb'); ?></h2>
  <p><?php esc_html_e('ابدأ بتصفح منتجات بويا ستور وأضف المنتجات المناسبة لاحتياجك.', 'arqamweb'); ?></p>

  <div class="boya-empty-state__actions">
    <a href="<?php echo esc_url(home_url('/products')); ?>" class="boya-btn boya-btn--primary"><?php esc_html_e('تصفح المنتجات', 'arqamweb'); ?></a>
    <a href="<?php echo esc_url(home_url('/categories')); ?>" class="boya-btn boya-btn--ghost"><?php esc_html_e('عرض الأقسام', 'arqamweb'); ?></a>
  </div>
</div>
