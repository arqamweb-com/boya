<?php
/**
 * Cart page template override.
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<div class="boya-cart-page">
  <?php if (WC()->cart->is_empty()) : ?>
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
  <?php else : ?>

    <div class="boya-cart-layout">
      <div class="boya-cart-main">
        <div class="boya-section-heading">
          <span><?php
            $boya_cart_count = (int) WC()->cart->get_cart_contents_count();
            printf(
              /* translators: %s: number of products in the cart */
              esc_html(_n('%s منتج في السلة', '%s منتجات في السلة', $boya_cart_count, 'arqamweb')),
              esc_html(number_format_i18n($boya_cart_count))
            );
          ?></span>
          <h2><?php esc_html_e('راجع المنتجات والكميات', 'arqamweb'); ?></h2>
        </div>

        <form class="woocommerce-cart-form boya-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
          <?php do_action('woocommerce_before_cart_table'); ?>
          <?php do_action('woocommerce_before_cart_contents'); ?>

          <div class="boya-cart-items">
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
              $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
              $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
              $visible    = apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key);

              if (!($_product instanceof WC_Product) || !$_product->exists() || $cart_item['quantity'] <= 0 || !$visible) {
                continue;
              }

              $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
              $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
              $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', ['class' => 'boya-cart-item__image']), $cart_item, $cart_item_key);

              if ($_product->is_sold_individually()) {
                $min_quantity = 1;
                $max_quantity = 1;
              } else {
                $min_quantity = 0;
                $max_quantity = $_product->get_max_purchase_quantity();
              }

              $quantity = woocommerce_quantity_input([
                'input_name'   => "cart[{$cart_item_key}][qty]",
                'input_value'  => $cart_item['quantity'],
                'max_value'    => $max_quantity,
                'min_value'    => $min_quantity,
                'product_name' => $product_name,
                'classes'      => ['input-text', 'qty', 'text'],
              ], $_product, false);
              ?>

              <article class="boya-cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                <div class="boya-cart-item__media">
                  <?php if ($product_permalink) : ?>
                    <a href="<?php echo esc_url($product_permalink); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                  <?php else : ?>
                    <?php echo wp_kses_post($thumbnail); ?>
                  <?php endif; ?>
                </div>

                <div class="boya-cart-item__body">
                  <h3 class="boya-cart-item__title">
                    <?php if ($product_permalink) : ?>
                      <a href="<?php echo esc_url($product_permalink); ?>"><?php echo wp_kses_post($product_name); ?></a>
                    <?php else : ?>
                      <?php echo wp_kses_post($product_name); ?>
                    <?php endif; ?>
                  </h3>

                  <div class="boya-cart-item__meta">
                    <?php
                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                    echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                      echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                    }
                    ?>
                  </div>
                </div>

                <div class="boya-cart-item__details">
                  <div class="boya-cart-item__cell">
                    <span><?php esc_html_e('السعر', 'arqamweb'); ?></span>
                    <strong><?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                  </div>
                  <div class="boya-cart-item__cell boya-cart-item__cell--qty">
                    <span><?php esc_html_e('الكمية', 'arqamweb'); ?></span>
                    <?php echo apply_filters('woocommerce_cart_item_quantity', $quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                  </div>
                  <div class="boya-cart-item__cell">
                    <span><?php esc_html_e('الإجمالي', 'arqamweb'); ?></span>
                    <strong><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                  </div>
                </div>

                <div class="boya-cart-item__remove">
                  <?php
                  echo apply_filters(
                    'woocommerce_cart_item_remove_link',
                    sprintf(
                      '<a role="button" href="%s" class="boya-remove-item" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                      esc_url(wc_get_cart_remove_url($cart_item_key)),
                      esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                      esc_attr($product_id),
                      esc_attr($_product->get_sku())
                    ),
                    $cart_item_key
                  ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  ?>
                </div>
              </article>
            <?php endforeach; ?>
          </div>

          <?php do_action('woocommerce_cart_contents'); ?>

          <div class="boya-cart-actions">
            <?php if (wc_coupons_enabled()) : ?>
              <div class="boya-coupon">
                <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                <input type="text" name="coupon_code" class="boya-coupon-input" id="coupon_code" value="" placeholder="<?php esc_attr_e('كود الخصم', 'arqamweb'); ?>"/>
                <button type="submit" class="boya-btn boya-btn--secondary" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('تطبيق الكود', 'arqamweb'); ?></button>
                <?php do_action('woocommerce_cart_coupon'); ?>
              </div>
            <?php endif; ?>

            <button type="submit" class="boya-btn boya-btn--outline" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
              <?php esc_html_e('تحديث السلة', 'arqamweb'); ?>
            </button>
            <?php do_action('woocommerce_cart_actions'); ?>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
          </div>

          <?php do_action('woocommerce_after_cart_contents'); ?>
          <?php do_action('woocommerce_after_cart_table'); ?>
        </form>
      </div>

      <aside class="boya-order-summary">
        <div class="boya-order-summary__head">
          <span><?php esc_html_e('ملخص الطلب', 'arqamweb'); ?></span>
          <strong><?php
            $boya_cart_count = (int) WC()->cart->get_cart_contents_count();
            printf(
              /* translators: %s: number of products in the cart */
              esc_html(_n('%s منتج', '%s منتجات', $boya_cart_count, 'arqamweb')),
              esc_html(number_format_i18n($boya_cart_count))
            );
          ?></strong>
        </div>

        <div class="boya-order-summary__rows">
          <div class="boya-order-summary__row">
            <span><?php esc_html_e('المجموع الفرعي', 'arqamweb'); ?></span>
            <strong><?php echo WC()->cart->get_cart_subtotal(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </div>

          <?php do_action('woocommerce_cart_totals_before_shipping'); ?>

          <div class="boya-order-summary__row">
            <span><?php esc_html_e('الشحن', 'arqamweb'); ?></span>
            <strong>
              <?php
              if (WC()->cart->needs_shipping()) {
                echo wp_kses_post(WC()->cart->get_cart_shipping_total() ?: __('يُحسب عند إتمام الشراء', 'arqamweb'));
              } else {
                echo esc_html__('لا يوجد شحن', 'arqamweb');
              }
              ?>
            </strong>
          </div>

          <?php do_action('woocommerce_cart_totals_after_shipping'); ?>

          <?php if (WC()->cart->get_coupons()) : ?>
            <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
              <div class="boya-order-summary__row boya-order-summary__row--discount">
                <span><?php esc_html_e('خصم', 'arqamweb'); ?> <mark><?php echo esc_html(strtoupper($code)); ?></mark></span>
                <strong>-<?php echo wp_kses_post(wc_price(WC()->cart->get_coupon_discount_amount($code, WC()->cart->display_cart_ex_tax))); ?></strong>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <?php do_action('woocommerce_cart_totals_before_order_total'); ?>

          <div class="boya-order-summary__row boya-order-summary__row--total">
            <span><?php esc_html_e('الإجمالي', 'arqamweb'); ?></span>
            <strong><?php echo WC()->cart->get_cart_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </div>

          <?php do_action('woocommerce_cart_totals_after_order_total'); ?>
        </div>

        <div class="boya-order-summary__checkout">
          <?php do_action('woocommerce_proceed_to_checkout'); ?>
        </div>

        <a href="<?php echo esc_url(home_url('/products')); ?>" class="boya-order-summary__continue"><?php esc_html_e('متابعة التسوق', 'arqamweb'); ?></a>
      </aside>
    </div>

  <?php endif; ?>
</div>

<?php
do_action('woocommerce_after_cart');
