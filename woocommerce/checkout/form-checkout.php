<?php
/**
 * Checkout form — partial template (no get_header/get_footer).
 * Rendered inside [woocommerce_checkout] shortcode via page.php.
 *
 * @var WC_Checkout $checkout
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) : ?>
  <div class="bg-card rounded-3xl border border-border/60 p-8 shadow-[var(--shadow-soft)] text-center">
    <p class="text-muted-foreground">
      <?php echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'))); ?>
    </p>
  </div>
<?php return; endif; ?>

<form name="checkout" method="post"
      class="checkout woocommerce-checkout boya-checkout"
      action="<?php echo esc_url(wc_get_checkout_url()); ?>"
      enctype="multipart/form-data"
      aria-label="<?php echo esc_attr__('Checkout', 'woocommerce'); ?>">

  <div class="boya-checkout-steps" aria-label="خطوات إتمام الطلب">
    <div class="boya-checkout-step is-active">
      <span>1</span>
      <strong>بياناتك</strong>
    </div>
    <div class="boya-checkout-step">
      <span>2</span>
      <strong>الشحن</strong>
    </div>
    <div class="boya-checkout-step">
      <span>3</span>
      <strong>الدفع</strong>
    </div>
  </div>

  <div class="boya-checkout-grid">

    <!-- ── Right column: billing + shipping ───────────────── -->
    <div class="boya-checkout-fields">

      <?php if ($checkout->get_checkout_fields()) : ?>
        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div id="customer_details">

          <section class="boya-checkout-card boya-checkout-card--accent">
            <h3 class="boya-checkout-card-title">
              <span class="boya-checkout-card-title__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                </svg>
              </span>
              <span>
                <small>الخطوة الأولى</small>
                بيانات الفاتورة والتوصيل
              </span>
            </h3>
            <?php do_action('woocommerce_checkout_billing'); ?>
          </section>

          <section class="boya-checkout-card" id="boya-shipping-card">
            <h3 class="boya-checkout-card-title">
              <span class="boya-checkout-card-title__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"/>
                  <rect x="9" y="11" width="14" height="10" rx="1"/>
                  <circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                </svg>
              </span>
              <span>
                <small>الخطوة الثانية</small>
                عنوان الشحن
              </span>
            </h3>
            <?php do_action('woocommerce_checkout_shipping'); ?>
          </section>

          <!-- Additional fields -->
          <?php do_action('woocommerce_checkout_after_customer_details'); ?>

        </div>

      <?php endif; ?>

    </div>

    <!-- ── Left column: order summary + payment ───────────── -->
    <aside class="boya-checkout-summary" id="order_review" aria-labelledby="order_review_heading">

      <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

      <section class="boya-checkout-card boya-checkout-summary-card">
        <h3 id="order_review_heading" class="boya-checkout-card-title">
          <span class="boya-checkout-card-title__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
          </span>
          <span>
            <small>الخطوة الثالثة</small>
            ملخص طلبك والدفع
          </span>
        </h3>
        <?php do_action('woocommerce_checkout_before_order_review'); ?>
        <div class="woocommerce-checkout-review-order">
          <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>
        <?php do_action('woocommerce_checkout_after_order_review'); ?>
      </section>

    </aside>

  </div><!-- .boya-checkout-grid -->

  <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
