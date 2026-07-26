<?php
/**
 * Cart page template override.
 */
defined('ABSPATH') || exit;

get_header();

do_action('woocommerce_before_cart');
?>
    <!-- Cart Header -->
    <section class="relative overflow-hidden bg-brand-navy text-white">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-red/40 blur-3xl animate-blob"></div>
            <div class="absolute top-20 -left-32 w-[500px] h-[500px] rounded-full bg-brand-blue/40 blur-3xl animate-blob" style="animation-delay:4s"></div>
            <div class="absolute bottom-0 right-1/3 w-[400px] h-[400px] rounded-full bg-brand-orange/30 blur-3xl animate-blob" style="animation-delay:8s"></div>
        </div>
        <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(white 1px,transparent 1px),linear-gradient(90deg,white 1px,transparent 1px);background-size:60px 60px"></div>
        <div class="container mx-auto px-6 pt-20 pb-28 lg:pt-28 lg:pb-36 relative text-center">
            <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">سلة التسوق</div>
            <h1 class="text-4xl md:text-6xl font-black leading-tight">مراجعة <span class="text-gradient-warm">طلبك</span></h1>
            <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">راجع المنتجات والكميات قبل الانتقال لإتمام الشراء.</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
                <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
            </svg>
        </div>
    </section>

    <section class="py-24">
        <div class="container mx-auto px-6">

            <?php if (WC()->cart->is_empty()) : ?>
                <div class="relative overflow-hidden rounded-[2rem] bg-card border border-border/60 shadow-[var(--shadow-soft)] p-8 md:p-12 text-center">
                    <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-brand-orange/10 blur-3xl"></div>
                    <div class="relative max-w-xl mx-auto">
                        <div class="mx-auto mb-5 h-16 w-16 rounded-2xl bg-brand-orange/10 text-brand-orange flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" /><line x1="3" y1="6" x2="21" y2="6" /><path d="M16 10a4 4 0 0 1-8 0" /></svg>
                        </div>
                        <h2 class="text-3xl font-black mb-3">سلتك فارغة حالياً</h2>
                        <p class="text-muted-foreground leading-relaxed mb-8">ابدأ بتصفح منتجات بويا ستور وأضف المنتجات المناسبة لاحتياجك.</p>
                        <a href="<?php echo esc_url(home_url('/products')); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded-full text-white font-black transition-all hover:scale-105 hover:shadow-[var(--shadow-glow-red)]" style="background:var(--gradient-warm)">تصفح المنتجات</a>
                    </div>
                </div>
            <?php else : ?>

                <div class="grid lg:grid-cols-3 gap-8 items-start">
                    <div class="lg:col-span-2">
                        <form class="woocommerce-cart-form space-y-4" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                            <?php do_action('woocommerce_before_cart_table'); ?>
                            <?php do_action('woocommerce_before_cart_contents'); ?>

                            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                                $visible    = apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key);

                                if (!($_product instanceof WC_Product) || !$_product->exists() || $cart_item['quantity'] <= 0 || !$visible) {
                                    continue;
                                }

                                $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', ['class' => 'w-full h-full object-cover']), $cart_item, $cart_item_key);

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
                                ], $_product, false);
                                ?>
                                <div class="bg-card rounded-2xl border border-border/60 p-4 flex flex-col md:flex-row md:items-center gap-4 shadow-[var(--shadow-soft)] opacity-0 translate-y-8 blur-[2px] <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                                    <div class="h-20 w-20 rounded-xl overflow-hidden bg-secondary shrink-0">
                                        <?php if ($product_permalink) : ?>
                                            <a href="<?php echo esc_url($product_permalink); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                        <?php else : ?>
                                            <?php echo wp_kses_post($thumbnail); ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-bold leading-tight">
                                            <?php if ($product_permalink) : ?>
                                                <a href="<?php echo esc_url($product_permalink); ?>" class="hover:text-brand-orange transition-colors"><?php echo wp_kses_post($product_name); ?></a>
                                            <?php else : ?>
                                                <?php echo wp_kses_post($product_name); ?>
                                            <?php endif; ?>
                                        </h3>
                                        <div class="mt-2 text-xs text-muted-foreground">
                                            <?php
                                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                                            echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:flex md:items-center gap-4 md:gap-6 w-full md:w-auto">
                                        <div>
                                            <div class="text-xs text-muted-foreground mb-1">السعر</div>
                                            <div class="font-black text-brand-navy"><?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-muted-foreground mb-1">الكمية</div>
                                            <?php echo apply_filters('woocommerce_cart_item_quantity', $quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </div>
                                        <div>
                                            <div class="text-xs text-muted-foreground mb-1">الإجمالي</div>
                                            <div class="font-black text-brand-navy"><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                                        </div>
                                        <div class="flex md:block items-end justify-end">
                                            <?php
                                            echo apply_filters(
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a role="button" href="%s" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-brand-red hover:bg-brand-red/10 transition-colors" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                    esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                                    esc_attr($product_id),
                                                    esc_attr($_product->get_sku())
                                                ),
                                                $cart_item_key
                                            ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php do_action('woocommerce_cart_contents'); ?>

                            <div class="bg-card rounded-2xl border border-border/60 p-4 shadow-[var(--shadow-soft)] flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
                                <?php if (wc_coupons_enabled()) : ?>
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                                        <input type="text" name="coupon_code" class="boya-coupon-input" id="coupon_code" value="" placeholder="كود الخصم" />
                                        <button type="submit" class="px-5 py-3 rounded-xl bg-secondary text-foreground font-bold hover:bg-brand-navy hover:text-white transition-colors" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">تطبيق الكود</button>
                                        <?php do_action('woocommerce_cart_coupon'); ?>
                                    </div>
                                <?php endif; ?>

                                <button type="submit" class="px-6 py-3 rounded-xl border-2 border-brand-navy text-brand-navy font-bold hover:bg-brand-navy hover:text-white transition-colors" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">تحديث السلة</button>
                                <?php do_action('woocommerce_cart_actions'); ?>
                                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                            </div>

                            <?php do_action('woocommerce_after_cart_contents'); ?>
                            <?php do_action('woocommerce_after_cart_table'); ?>
                        </form>
                    </div>

                    <aside class="bg-card rounded-3xl border border-border/60 p-6 shadow-[var(--shadow-elegant)] sticky top-32">
                        <h3 class="text-xl font-black mb-5">ملخص الطلب</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-muted-foreground">المجموع الفرعي</span>
                                <span class="font-black text-brand-navy"><?php echo WC()->cart->get_cart_subtotal(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-muted-foreground">الشحن</span>
                                <span class="font-bold"><?php echo wp_kses_post(WC()->cart->get_cart_shipping_total()); ?></span>
                            </div>
                            <div class="border-t border-border/60 pt-4 flex items-center justify-between">
                                <span class="font-black">الإجمالي</span>
                                <span class="text-2xl font-black text-brand-navy"><?php echo WC()->cart->get_cart_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                            </div>
                        </div>
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="mt-6 block w-full text-center px-8 py-4 rounded-full text-white font-black transition-all hover:scale-105 hover:shadow-[var(--shadow-glow-red)]" style="background:var(--gradient-warm)">إتمام الشراء</a>
                        <a href="<?php echo esc_url(home_url('/products')); ?>" class="mt-4 block text-center text-sm font-bold text-brand-navy hover:text-brand-orange transition-colors">متابعة التسوق</a>
                    </aside>
                </div>

            <?php endif; ?>
        </div>
    </section>

<?php
do_action('woocommerce_after_cart');

get_footer();
