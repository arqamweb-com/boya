<?php
/**
 * Single product template override.
 */
defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();

    global $product;
    $product = wc_get_product(get_the_ID());

    if (!$product) {
        continue;
    }

    $product_id = $product->get_id();
    $name = $product->get_name();
    $main_image = get_the_post_thumbnail_url($product_id, 'large') ?: wc_placeholder_img_src('woocommerce_single');
    $gallery_ids = $product->get_gallery_image_ids();
    $rating = (float)$product->get_average_rating();
    $review_count = (int)$product->get_review_count();
    $sku = $product->get_sku();
    $product_code = boya_get_product_code($product_id);
    $short_desc = $product->get_short_description();
    $price_html = $product->get_price_html();
    $is_on_sale = $product->is_on_sale();
    $is_featured = $product->is_featured();
    $stock_status = $product->is_in_stock() ? __('متاح للشحن', 'arqamweb') : __('غير متاح حالياً', 'arqamweb');
    $stock_class = $product->is_in_stock() ? 'is-in-stock' : 'is-out-stock';
    $product_tags = get_the_terms($product_id, 'product_tag');

    $product_type = '';

    if ($product_tags && !is_wp_error($product_tags)) {
        $first_tag = $product_tags[0];
        $product_type = $first_tag->name;
    } else {
        $product_type = __('غير محدد', 'arqamweb');
    }


    $brand_tax = function_exists('boya_get_brands_taxonomy') ? boya_get_brands_taxonomy() : '';
    $brand_term = null;
    $primary_cat = null;
    $discount_pct = 0;

    $regular_price = (float)$product->get_regular_price();
    $sale_price = (float)$product->get_sale_price();

    if ($is_on_sale && $regular_price > 0 && $sale_price > 0 && $sale_price < $regular_price) {
        $discount_pct = (int)round((($regular_price - $sale_price) / $regular_price) * 100);
    }

    if ($brand_tax) {
        $brand_terms = get_the_terms($product_id, $brand_tax);
        if ($brand_terms && !is_wp_error($brand_terms)) {
            $brand_term = $brand_terms[0];
        }
    }

    $cat_terms = get_the_terms($product_id, 'product_cat');
    if ($cat_terms && !is_wp_error($cat_terms)) {
        $primary_cat = $cat_terms[0];
    }

    $gallery_items = [[
            'full' => $main_image,
            'thumb' => get_the_post_thumbnail_url($product_id, 'woocommerce_thumbnail') ?: $main_image,
            'alt' => $name,
    ]];

    foreach (array_slice($gallery_ids, 0, 6) as $attachment_id) {
        $thumb = wp_get_attachment_image_url($attachment_id, 'woocommerce_thumbnail');
        $full = wp_get_attachment_image_url($attachment_id, 'large') ?: wp_get_attachment_image_url($attachment_id, 'full');
        $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: $name;

        if ($thumb && $full) {
            $gallery_items[] = [
                    'full' => $full,
                    'thumb' => $thumb,
                    'alt' => $alt,
            ];
        }
    }

    do_action('woocommerce_before_single_product');
    ?>

    <main class="boya-product-page">
        <section class="boya-product-hero">
            <div class="container mx-auto px-6">
                <nav class="boya-product-breadcrumb" aria-label="<?php esc_attr_e('مسار المنتج', 'arqamweb'); ?>">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('الرئيسية', 'arqamweb'); ?></a>
                    <span>/</span>
                    <a href="<?php echo esc_url(home_url('/products')); ?>"><?php esc_html_e('المنتجات', 'arqamweb'); ?></a>
                    <?php if ($primary_cat) : ?>
                        <span>/</span>
                        <a href="<?php echo esc_url(get_term_link($primary_cat)); ?>"><?php echo esc_html($primary_cat->name); ?></a>
                    <?php endif; ?>
                </nav>

                <div class="boya-product-layout">
                    <?php
                    $lightbox_data = array_map(function ($image) {
                        return ['full' => $image['full'], 'alt' => $image['alt']];
                    }, $gallery_items);
                    ?>
                    <div class="boya-product-gallery opacity-0 translate-y-8 blur-[2px]"
                         data-boya-gallery="<?php echo esc_attr(wp_json_encode($lightbox_data)); ?>">
                        <div class="boya-product-gallery__stage">
                            <img id="boya-product-main-image"
                                 src="<?php echo esc_url($main_image); ?>"
                                 alt="<?php echo esc_attr($name); ?>"
                                 loading="eager"/>

                            <?php if ($product_code) : ?>
                                <span class="boya-product-code-badge"><?php echo esc_html($product_code); ?></span>
                            <?php endif; ?>

                            <div class="boya-product-gallery__badges">
                                <?php if ($is_on_sale) : ?>
                                    <span class="boya-product-badge boya-product-badge--sale">
                  <?php echo $discount_pct > 0 ? sprintf(
                      /* translators: %s: discount percentage */
                      esc_html__('خصم %s%%', 'arqamweb'),
                      esc_html($discount_pct)
                  ) : esc_html(__('عرض خاص', 'arqamweb')); ?>
                </span>
                                <?php endif; ?>
                                <?php if ($is_featured) : ?>
                                    <span class="boya-product-badge boya-product-badge--featured"><?php esc_html_e('منتج مميز', 'arqamweb'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (count($gallery_items) > 1) : ?>
                            <div class="boya-product-thumbs" aria-label="<?php esc_attr_e('صور المنتج', 'arqamweb'); ?>">
                                <?php foreach ($gallery_items as $index => $image) : ?>
                                    <button type="button"
                                            class="boya-product-thumb <?php echo $index === 0 ? 'is-active' : ''; ?>"
                                            data-boya-product-thumb
                                            data-full="<?php echo esc_url($image['full']); ?>"
                                            data-alt="<?php echo esc_attr($image['alt']); ?>"
                                            aria-label="<?php echo $index === 0
                                                ? esc_attr__('عرض الصورة الرئيسية', 'arqamweb')
                                                : esc_attr(sprintf(
                                                    /* translators: %s: gallery image number */
                                                    __('عرض صورة %s', 'arqamweb'),
                                                    $index + 1
                                                  )); ?>"
                                            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                        <img src="<?php echo esc_url($image['thumb']); ?>"
                                             alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy"/>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <aside class="boya-product-panel opacity-0 translate-y-8 blur-[2px]">
                        <div class="boya-product-kicker">
                            <?php if ($brand_term) : ?>
                                <a href="<?php echo esc_url(get_term_link($brand_term)); ?>"><?php echo esc_html($brand_term->name); ?></a>
                            <?php elseif ($primary_cat) : ?>
                                <a href="<?php echo esc_url(get_term_link($primary_cat)); ?>"><?php echo esc_html($primary_cat->name); ?></a>
                            <?php else : ?>
                                <span><?php esc_html_e('بويا ستور', 'arqamweb'); ?></span>
                            <?php endif; ?>
                        </div>

                        <h1 class="boya-product-title"><?php echo esc_html($name); ?></h1>

                        <div class="boya-product-status-row">
                            <span class="boya-stock-pill <?php echo esc_attr($stock_class); ?>"><?php echo esc_html($stock_status); ?></span>
                            <?php if ($primary_cat) : ?>
                                <a href="<?php echo esc_url(get_term_link($primary_cat)); ?>" class="boya-cat-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                                    </svg>
                                    <?php echo esc_html($primary_cat->name); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ($rating > 0) : ?>
                                <a href="#reviews" class="boya-rating-pill">
                <span class="boya-stars" aria-hidden="true">
                  <?php for ($i = 1; $i <= 5; $i++) : ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                           fill="<?php echo $i <= round($rating) ? 'currentColor' : 'none'; ?>" stroke="currentColor"
                           stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon
                                  points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <?php endfor; ?>
                </span>
                                    <?php echo esc_html(number_format($rating, 1)); ?>
                                    · <?php
                                    printf(
                                        /* translators: %s: number of reviews */
                                        esc_html(_n('%s تقييم', '%s تقييمات', $review_count, 'arqamweb')),
                                        esc_html(number_format_i18n($review_count))
                                    );
                                    ?>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="boya-product-price">
                            <?php echo wp_kses_post($price_html); ?>
                        </div>

                        <?php if ($short_desc) : ?>
                            <div class="boya-product-summary">
                                <?php echo wp_kses_post(wpautop($short_desc)); ?>
                            </div>
                        <?php endif; ?>

                        <div class="boya-product-actions">
                            <div class="boya-single-cart">
                                <?php woocommerce_template_single_add_to_cart(); ?>
                            </div>

                            <a href="<?php echo esc_url('https://wa.me/201038314148?text=' . rawurlencode(sprintf(
                                /* translators: 1: product name, 2: product URL */
                                __('أحتاج تفاصيل عن المنتج: %1$s - %2$s', 'arqamweb'),
                                $name,
                                get_permalink($product_id)
                            ))); ?>"
                               class="boya-whatsapp-product"
                               target="_blank"
                               rel="noreferrer">
                                <?php esc_html_e('استفسر عبر واتساب', 'arqamweb'); ?>
                            </a>
                        </div>

                        <dl class="boya-product-facts">
                            <?php if ($product_code) : ?>
                                <div>
                                    <dt><?php esc_html_e('كود المنتج', 'arqamweb'); ?></dt>
                                    <dd><?php echo esc_html($product_code); ?></dd>
                                </div>
                            <?php endif; ?>
                            <div>
                                <dt><?php esc_html_e('نوع المنتج', 'arqamweb'); ?></dt>
                                <dd><?php echo esc_html($product_type); ?></dd>
                            </div>
                            <?php if ($primary_cat) : ?>
                                <div>
                                    <dt><?php esc_html_e('القسم', 'arqamweb'); ?></dt>
                                    <dd>
                                        <a href="<?php echo esc_url(get_term_link($primary_cat)); ?>"><?php echo esc_html($primary_cat->name); ?></a>
                                    </dd>
                                </div>
                            <?php endif; ?>
                            <?php if ($brand_term) : ?>
                                <div>
                                    <dt><?php esc_html_e('العلامة التجارية', 'arqamweb'); ?></dt>
                                    <dd>
                                        <a href="<?php echo esc_url(get_term_link($brand_term)); ?>"><?php echo esc_html($brand_term->name); ?></a>
                                    </dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </aside>
                </div>

                <div class="boya-product-service-strip opacity-0 translate-y-8 blur-[2px]">
                    <div>
                        <span aria-hidden="true">✓</span>
                        <strong><?php esc_html_e('منتجات أصلية', 'arqamweb'); ?></strong>
                        <small><?php esc_html_e('توريد من علامات موثوقة', 'arqamweb'); ?></small>
                    </div>
                    <div>
                        <span aria-hidden="true">↺</span>
                        <strong><?php esc_html_e('استبدال مرن', 'arqamweb'); ?></strong>
                        <small><?php esc_html_e('حسب سياسة المتجر', 'arqamweb'); ?></small>
                    </div>
                    <div>
                        <span aria-hidden="true">☎</span>
                        <strong><?php esc_html_e('دعم فني', 'arqamweb'); ?></strong>
                        <small><?php esc_html_e('مساعدة في اختيار المنتج', 'arqamweb'); ?></small>
                    </div>
                    <div>
                        <span class="boya-arrow" aria-hidden="true">→</span>
                        <strong><?php esc_html_e('توصيل سريع', 'arqamweb'); ?></strong>
                        <small><?php esc_html_e('لكافة مناطق الجمهورية', 'arqamweb'); ?></small>
                    </div>
                </div>
            </div>
        </section>

        <section class="boya-product-details-section">
            <div class="container mx-auto px-6">
                <div class="boya-product-content-grid">
                    <div class="boya-product-tabs-card opacity-0 translate-y-8 blur-[2px]">
                        <?php woocommerce_output_product_data_tabs(); ?>
                    </div>

                    <aside class="boya-product-side-note opacity-0 translate-y-8 blur-[2px]">
                        <h2><?php esc_html_e('تحتاج مساعدة؟', 'arqamweb'); ?></h2>
                        <p><?php esc_html_e('لو المنتج مرتبط بدرجة لون أو نظام دهان معين، تواصل معنا قبل الطلب لتأكيد الاختيار المناسب.', 'arqamweb'); ?></p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('تواصل معنا', 'arqamweb'); ?></a>
                    </aside>
                </div>

                <?php
                $related_ids = wc_get_related_products($product_id, 4);
                if (!empty($related_ids)) :
                    $related_query = new WP_Query([
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'post__in' => $related_ids,
                            'orderby' => 'post__in',
                            'posts_per_page' => 4,
                    ]);

                    if ($related_query->have_posts()) :
                        ?>
                        <div class="boya-related-products opacity-0 translate-y-8 blur-[2px]">
                            <div class="boya-section-heading">
                                <span><?php esc_html_e('اختيارات قريبة', 'arqamweb'); ?></span>
                                <h2><?php esc_html_e('منتجات مشابهة', 'arqamweb'); ?></h2>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                                <?php
                                while ($related_query->have_posts()) :
                                    $related_query->the_post();
                                    $related_product = wc_get_product(get_the_ID());

                                    if ($related_product) {
                                        boya_render_product_card($related_product);
                                    }
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                endif;
                ?>
            </div>
        </section>
    </main>

    <?php
    do_action('woocommerce_after_single_product');
endwhile;

get_footer();
