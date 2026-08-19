<?php
/**
 * My Account page template override.
 */
defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$first_name   = ($current_user && $current_user->exists()) ? ($current_user->first_name ?: $current_user->display_name) : '';
$title_name   = is_user_logged_in() && $first_name ? $first_name : __('تسجيل الدخول', 'arqamweb');
$menu_items   = function_exists('wc_get_account_menu_items') ? wc_get_account_menu_items() : [];

$icons = [
  'dashboard'       => '<path d="M3 13h8V3H3v10Z"/><path d="M13 21h8V11h-8v10Z"/><path d="M13 3v6h8V3h-8Z"/><path d="M3 21h8v-6H3v6Z"/>',
  'orders'          => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>',
  'downloads'       => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/>',
  'edit-address'    => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
  'payment-methods' => '<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>',
  'edit-account'    => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
  'customer-logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
];
?>

<div>
    <?php if (is_user_logged_in()) : ?>
    <div class="grid lg:grid-cols-4 gap-8 items-start">
      <aside class="lg:col-span-1">
        <nav class="bg-card rounded-3xl border border-border/60 shadow-[var(--shadow-soft)] p-4 space-y-1">
          <?php foreach ($menu_items as $endpoint => $label) :
            $is_dashboard = $endpoint === 'dashboard' && !is_wc_endpoint_url();
            $is_active    = $is_dashboard || ($endpoint !== 'dashboard' && is_wc_endpoint_url($endpoint));
            $icon         = $icons[$endpoint] ?? '<circle cx="12" cy="12" r="9"/>';
          ?>
          <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"
             class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-colors <?php echo $is_active ? 'bg-brand-navy text-white' : 'text-foreground hover:bg-secondary'; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
            <?php echo esc_html($label); ?>
          </a>
          <?php endforeach; ?>
        </nav>
      </aside>

      <div class="lg:col-span-3 bg-card rounded-3xl border border-border/60 shadow-[var(--shadow-soft)] p-6 md:p-8">
        <?php do_action('woocommerce_account_content'); ?>
      </div>
    </div>
    <?php else : ?>
    <div class="max-w-2xl mx-auto bg-card rounded-3xl border border-border/60 shadow-[var(--shadow-soft)] p-6 md:p-8">
      <?php do_action('woocommerce_account_content'); ?>
    </div>
    <?php endif; ?>
</div>
