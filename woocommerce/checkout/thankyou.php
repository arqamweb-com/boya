<?php
/**
 * Thank you page template override.
 *
 * @var WC_Order|false $order
 */
defined('ABSPATH') || exit;

if (!isset($order) || !$order) {
  $order_id = isset($_GET['order']) ? absint($_GET['order']) : 0;
  $order    = $order_id ? wc_get_order($order_id) : false;
}
?>

<div class="max-w-3xl mx-auto">
    <div class="woocommerce-order">
      <?php if ($order) : ?>
        <?php do_action('woocommerce_before_thankyou', $order->get_id()); ?>

        <?php if ($order->has_status('failed')) : ?>
          <div class="bg-card rounded-3xl border border-border/60 p-6 md:p-8 shadow-[var(--shadow-soft)] text-center">
            <p class="text-muted-foreground mb-6"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>
            <div class="flex flex-wrap justify-center gap-3">
              <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="px-6 py-3 rounded-full text-white font-black" style="background:var(--gradient-warm)"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
              <?php if (is_user_logged_in()) : ?>
              <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="px-6 py-3 rounded-full border-2 border-brand-navy text-brand-navy font-bold hover:bg-brand-navy hover:text-white transition-colors"><?php esc_html_e('My account', 'woocommerce'); ?></a>
              <?php endif; ?>
            </div>
          </div>
        <?php else : ?>

          <div class="grid sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-card rounded-2xl border border-border/60 p-5 shadow-[var(--shadow-soft)]">
              <div class="text-xs font-bold text-brand-orange mb-2 tracking-wider">تاريخ الطلب</div>
              <div class="font-black"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></div>
            </div>
            <div class="bg-card rounded-2xl border border-border/60 p-5 shadow-[var(--shadow-soft)]">
              <div class="text-xs font-bold text-brand-orange mb-2 tracking-wider">وسيلة الدفع</div>
              <div class="font-black"><?php echo wp_kses_post($order->get_payment_method_title() ?: 'غير محددة'); ?></div>
            </div>
            <?php if ($order->get_billing_email()) : ?>
            <div class="bg-card rounded-2xl border border-border/60 p-5 shadow-[var(--shadow-soft)]">
              <div class="text-xs font-bold text-brand-orange mb-2 tracking-wider">البريد الإلكتروني</div>
              <div class="font-black break-words"><?php echo esc_html($order->get_billing_email()); ?></div>
            </div>
            <?php endif; ?>
            <div class="bg-card rounded-2xl border border-border/60 p-5 shadow-[var(--shadow-soft)]">
              <div class="text-xs font-bold text-brand-orange mb-2 tracking-wider">الإجمالي</div>
              <div class="font-black text-brand-navy"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></div>
            </div>
          </div>

          <div class="bg-card rounded-3xl border border-border/60 p-6 md:p-8 shadow-[var(--shadow-elegant)]">
            <h2 class="text-2xl font-black mb-6">تفاصيل الطلب</h2>
            <div class="space-y-4">
              <?php foreach ($order->get_items() as $item_id => $item) :
                $product = $item->get_product();
                $image   = $product ? $product->get_image('woocommerce_thumbnail', ['class' => 'w-full h-full object-cover']) : '';
              ?>
              <div class="flex items-center gap-4 rounded-2xl border border-border/60 p-4">
                <div class="h-16 w-16 rounded-xl bg-secondary overflow-hidden shrink-0">
                  <?php echo $image ? wp_kses_post($image) : ''; ?>
                </div>
                <div class="flex-1 min-w-0">
                  <h3 class="font-bold leading-tight"><?php echo esc_html($item->get_name()); ?></h3>
                  <p class="text-sm text-muted-foreground">الكمية: <?php echo esc_html($item->get_quantity()); ?></p>
                </div>
                <div class="font-black text-brand-navy"><?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?></div>
              </div>
              <?php endforeach; ?>
            </div>

            <div class="mt-6 border-t border-border/60 pt-5 space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-muted-foreground">المجموع الفرعي</span>
                <span class="font-bold"><?php echo wp_kses_post(wc_price($order->get_subtotal(), ['currency' => $order->get_currency()])); ?></span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-muted-foreground">الشحن</span>
                <span class="font-bold"><?php echo wp_kses_post(wc_price($order->get_shipping_total(), ['currency' => $order->get_currency()])); ?></span>
              </div>
              <div class="flex items-center justify-between text-xl">
                <span class="font-black">الإجمالي</span>
                <span class="font-black text-brand-navy"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
              </div>
            </div>
          </div>

          <div class="flex flex-wrap justify-center gap-3 mt-8">
            <a href="<?php echo esc_url(home_url('/products')); ?>" class="px-7 py-3.5 rounded-full text-white font-black" style="background:var(--gradient-warm)">متابعة التسوق</a>
            <?php if (is_user_logged_in()) : ?>
            <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="px-7 py-3.5 rounded-full border-2 border-brand-navy text-brand-navy font-bold hover:bg-brand-navy hover:text-white transition-colors">تتبع طلبك</a>
            <?php endif; ?>
          </div>

        <?php endif; ?>

        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
      <?php else : ?>
        <div class="bg-card rounded-3xl border border-border/60 p-8 shadow-[var(--shadow-soft)] text-center">
          <h2 class="text-2xl font-black mb-3">تم استلام طلبك</h2>
          <p class="text-muted-foreground mb-6">شكراً لك. سنراجع الطلب ونرسل لك التفاصيل قريباً.</p>
          <a href="<?php echo esc_url(home_url('/products')); ?>" class="inline-flex px-7 py-3.5 rounded-full text-white font-black" style="background:var(--gradient-warm)">متابعة التسوق</a>
        </div>
      <?php endif; ?>
    </div>
</div>
