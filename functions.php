<?php
defined('ABSPATH') || exit;

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/menus.php';

/* ── Disable WooCommerce single-result search redirect ──────── */
add_filter('woocommerce_redirect_single_search_result', '__return_false');

/* ── Flexible Arabic product search ─────────────────────────── */
/**
 * Character-form map used to normalise Arabic text so that different
 * spellings match each other (ي/ى, ة/ه, hamza forms, tatweel, tashkeel).
 * When $strip_long_vowels is true, the long vowels (ا و ي) are also removed
 * so that e.g. "فيلر" matches "فلر" and "بولي" matches "بولى".
 */
function boya_arabic_search_map($strip_long_vowels = true) {
    $map = [
        'ـ' => '',              // tatweel (kashida)
        'أ' => 'ا', 'إ' => 'ا', // hamza on/under alef
        'آ' => 'ا', 'ٱ' => 'ا', // madda / wasla alef
        'ؤ' => 'و',             // hamza on waw
        'ئ' => 'ي',             // hamza on ya
        'ى' => 'ي',             // alef maqsura -> ya
        'ة' => 'ه',             // ta marbuta -> ha
        'ء' => '',              // standalone hamza
    ];
    if ($strip_long_vowels) {
        $map['ا'] = '';
        $map['و'] = '';
        $map['ي'] = '';
    }
    return $map;
}

/** Normalise an Arabic string in PHP (mirror of the SQL expression below). */
function boya_normalize_arabic($text, $strip_long_vowels = true) {
    // Strip tashkeel (harakat) and the superscript alef.
    $text = preg_replace('/[\x{064B}-\x{0652}\x{0670}]/u', '', $text);
    // Apply the map sequentially (chained), matching the nested SQL REPLACE()
    // so that e.g. "ى" → "ي" → "" resolves identically on both sides.
    foreach (boya_arabic_search_map($strip_long_vowels) as $from => $to) {
        $text = str_replace($from, $to, $text);
    }
    return $text;
}

/** Build a nested REPLACE() SQL expression that normalises a DB column. */
function boya_sql_normalize_arabic($column, $strip_long_vowels = true) {
    $expr = $column;
    foreach (boya_arabic_search_map($strip_long_vowels) as $from => $to) {
        $expr = "REPLACE($expr, '" . $from . "', '" . $to . "')";
    }
    return $expr;
}

add_filter('posts_search', function ($search, $wp_query) {
    global $wpdb;

    // Frontend product searches only.
    if (is_admin() || !$wp_query->is_main_query() || !$wp_query->is_search()) {
        return $search;
    }
    $post_types = (array) $wp_query->get('post_type');
    if (!in_array('product', $post_types, true)) {
        return $search;
    }

    $s = trim((string) $wp_query->get('s'));
    if ($s === '') {
        return $search;
    }

    $terms = preg_split('/\s+/', $s, -1, PREG_SPLIT_NO_EMPTY);
    if (empty($terms)) {
        return $search;
    }

    $title   = boya_sql_normalize_arabic("{$wpdb->posts}.post_title");
    $excerpt = boya_sql_normalize_arabic("{$wpdb->posts}.post_excerpt");
    $content = boya_sql_normalize_arabic("{$wpdb->posts}.post_content");

    $clauses = [];
    foreach ($terms as $term) {
        $norm = boya_normalize_arabic($term);
        if ($norm === '') {
            // Term is only long vowels/marks — fall back to the raw term.
            $norm = $term;
        }
        $like = '%' . $wpdb->esc_like($norm) . '%';
        $clauses[] = $wpdb->prepare(
            "($title LIKE %s OR $excerpt LIKE %s OR $content LIKE %s)",
            $like,
            $like,
            $like
        );
    }

    if (empty($clauses)) {
        return $search;
    }

    // All terms must match (mirrors WordPress default AND behaviour).
    return ' AND (' . implode(' AND ', $clauses) . ') ';
}, 10, 2);

/* ── Checkout fields ───────────────────────────────────────── */
add_filter('woocommerce_checkout_fields', function ($fields) {
    unset($fields['billing']['billing_postcode']);
    unset($fields['shipping']['shipping_postcode']);

    if (isset($fields['billing']['billing_company'])) {
        $fields['billing']['billing_company']['label']       = 'اسم المؤسسة/المحل';
        $fields['billing']['billing_company']['placeholder'] = 'اكتب اسم المؤسسة أو المحل';
        $fields['billing']['billing_company']['required']    = true;
        $fields['billing']['billing_company']['priority']    = 35;
        $fields['billing']['billing_company']['class']       = ['form-row-wide'];
        $fields['billing']['billing_company']['clear']       = true;
    } else {
        $fields['billing']['billing_company'] = [
            'type'        => 'text',
            'label'       => 'اسم المؤسسة/المحل',
            'placeholder' => 'اكتب اسم المؤسسة أو المحل',
            'required'    => true,
            'class'       => ['form-row-wide'],
            'clear'       => true,
            'priority'    => 35,
        ];
    }

    if (isset($fields['billing']['billing_phone'])) {
        $fields['billing']['billing_phone']['label']       = 'رقم الموبايل';
        $fields['billing']['billing_phone']['placeholder'] = 'اكتب رقم الموبايل';
        $fields['billing']['billing_phone']['required']    = true;
        $fields['billing']['billing_phone']['priority']    = 25;
        $fields['billing']['billing_phone']['class']       = ['form-row-wide'];
    }

    return $fields;
}, 1000);

add_filter('woocommerce_form_field_args', function ($args, $key) {
    if ($key !== 'billing_phone') {
        return $args;
    }

    $args['label']       = 'رقم الموبايل';
    $args['placeholder'] = 'اكتب رقم الموبايل';
    $args['required']    = true;

    $args['custom_attributes'] = isset($args['custom_attributes']) && is_array($args['custom_attributes'])
        ? $args['custom_attributes']
        : [];
    $args['custom_attributes']['required']      = 'required';
    $args['custom_attributes']['aria-required'] = 'true';

    return $args;
}, 1000, 2);

add_action('woocommerce_after_checkout_validation', function ($data, $errors) {
    if (trim((string) ($data['billing_phone'] ?? '')) === '') {
        $errors->add('billing_phone_required', 'من فضلك اكتب رقم الموبايل.');
    }
}, 10, 2);

/* Also drop the postcode from the address display/edit forms */
add_filter('woocommerce_default_address_fields', function ($fields) {
    unset($fields['postcode']);
    return $fields;
});

/* ── Address field order: المنطقة ثم المدينة ─────────────────────
 * WooCommerce defaults put city (70) before state (80); we want the reverse.
 * Pin the two priorities at the latest possible moment so the order holds on
 * checkout, in the my-account address forms, and in the locale data the
 * checkout JS re-sorts with.
 */
const BOYA_ADDRESS_ORDER = ['state' => 70, 'city' => 80];

function boya_force_address_order(array $fields, string $prefix = ''): array
{
    foreach (BOYA_ADDRESS_ORDER as $field => $priority) {
        if (isset($fields[$prefix . $field])) {
            $fields[$prefix . $field]['priority'] = $priority;
        }
    }

    return $fields;
}

add_filter('woocommerce_checkout_fields', function ($fields) {
    foreach (['billing', 'shipping'] as $section) {
        if (isset($fields[$section])) {
            $fields[$section] = boya_force_address_order($fields[$section], $section . '_');
        }
    }

    return $fields;
}, PHP_INT_MAX);

add_filter('woocommerce_billing_fields', function ($fields) {
    return boya_force_address_order($fields, 'billing_');
}, PHP_INT_MAX);

add_filter('woocommerce_shipping_fields', function ($fields) {
    return boya_force_address_order($fields, 'shipping_');
}, PHP_INT_MAX);

add_filter('woocommerce_default_address_fields', function ($fields) {
    return boya_force_address_order($fields);
}, PHP_INT_MAX);

/* Locale data drives the client-side re-sort in WooCommerce's address-i18n.js */
add_filter('woocommerce_get_country_locale', function ($locale) {
    foreach ($locale as $country => $fields) {
        $locale[$country] = boya_force_address_order($fields);
    }

    return $locale;
}, PHP_INT_MAX);

add_filter('woocommerce_get_country_locale_default', function ($fields) {
    return boya_force_address_order($fields);
}, PHP_INT_MAX);

add_filter('woocommerce_get_country_locale_base', function ($fields) {
    return boya_force_address_order($fields);
}, PHP_INT_MAX);

/* ── Required/optional overrides ─────────────────────────────────
 * اسم المؤسسة/المحل إجباري، البريد الإلكتروني اختياري.
 * Applied at PHP_INT_MAX so a checkout-field-editor plugin can't flip them
 * back, mirroring how billing_phone is forced further down this file.
 */
const BOYA_FIELD_REQUIRED = ['billing_company' => true, 'billing_email' => false];

function boya_force_field_requirements(array $fields, string $prefix = ''): array
{
    foreach (BOYA_FIELD_REQUIRED as $key => $required) {
        $key = $prefix === '' ? $key : str_replace('billing_', $prefix, $key);

        if (isset($fields[$key])) {
            $fields[$key]['required'] = $required;
        }
    }

    return $fields;
}

add_filter('woocommerce_checkout_fields', function ($fields) {
    if (isset($fields['billing'])) {
        $fields['billing'] = boya_force_field_requirements($fields['billing']);
    }

    return $fields;
}, PHP_INT_MAX);

add_filter('woocommerce_billing_fields', function ($fields) {
    return boya_force_field_requirements($fields);
}, PHP_INT_MAX);

/* Force at render time (wins over any field-editor plugin) */
add_filter('woocommerce_form_field_args', function ($args, $key) {
    if (!array_key_exists($key, BOYA_FIELD_REQUIRED)) {
        return $args;
    }

    $args['required'] = BOYA_FIELD_REQUIRED[$key];

    $args['custom_attributes'] = isset($args['custom_attributes']) && is_array($args['custom_attributes'])
        ? $args['custom_attributes']
        : [];

    if ($args['required']) {
        $args['custom_attributes']['required']      = 'required';
        $args['custom_attributes']['aria-required'] = 'true';
    } else {
        unset($args['custom_attributes']['required'], $args['custom_attributes']['aria-required']);
    }

    return $args;
}, PHP_INT_MAX, 2);

/* Server-side enforcement: block submission without the store name */
add_action('woocommerce_after_checkout_validation', function ($data, $errors) {
    if (trim((string) ($data['billing_company'] ?? '')) === '') {
        $errors->add('billing_company_required', 'من فضلك اكتب اسم المؤسسة أو المحل.');
    }
}, 10, 2);

/* ── Remove WooCommerce default layout wrappers ─────────────── */
add_action('after_setup_theme', function () {
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    remove_action('woocommerce_sidebar',             'woocommerce_get_sidebar', 10);
});

/* ── Theme support ──────────────────────────────────────────── */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 96,
        'width'       => 260,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('menus');
    // WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

function boya_get_site_logo_url() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
        if ($logo_url) {
            return $logo_url;
        }
    }

    return 'https://www.arqamweb.com/wp-content/uploads/2026/05/BOYA-LOGO-WEB.png';
}

function boya_get_site_logo_alt() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
        if ($logo_alt) {
            return $logo_alt;
        }
    }

    return get_bloginfo('name') ?: 'Boya Store';
}

/* ── Lightweight first-paint loader ─────────────────────────── */
add_action('wp_head', function () {
    ?>
    <style id="boya-loader-css">
      .boya-site-loader{position:fixed;inset:0;z-index:2147483647;display:grid;place-items:center;background:var(--background,#fff);transition:opacity .24s ease,visibility .24s ease;contain:layout paint style}
      .boya-site-loader.is-hidden{opacity:0;visibility:hidden;pointer-events:none}
      .boya-site-loader__mark{position:relative;display:grid;place-items:center;width:min(44vw,12rem);aspect-ratio:1}
      .boya-site-loader__mark::before{content:"";position:absolute;inset:0;border-radius:999px;border:3px solid rgba(15,23,42,.08);border-block-start-color:var(--brand-orange,#f16722);animation:boya-loader-spin .75s linear infinite}
      .boya-site-loader__logo{width:min(30vw,7.5rem);height:min(18vw,5rem);background:center/contain no-repeat var(--boya-loader-logo)}
      .boya-site-loader__text{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap}
      @keyframes boya-loader-spin{to{transform:rotate(360deg)}}
      @media (prefers-reduced-motion:reduce){.boya-site-loader__mark::before{animation:none}}
    </style>
    <?php
}, 1);

/* ── Enqueue assets ─────────────────────────────────────────── */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'boya-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'boya-store-styles',
        get_template_directory_uri() . '/assets/css/styles.css',
        ['boya-google-fonts'],
        filemtime(get_template_directory() . '/assets/css/styles.css')
    );
    wp_add_inline_style('boya-store-styles', boya_menu_inline_css());
    wp_add_inline_style('boya-store-styles', boya_product_inline_css());
    wp_enqueue_script(
        'boya-store-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        [],
        filemtime(get_template_directory() . '/assets/js/theme.js'),
        true
    );

    // AJAX product filtering (products page + single brand archive).
    $boya_brand_taxonomies = boya_get_brand_taxonomies();
    $boya_is_brand_archive = $boya_brand_taxonomies && is_tax($boya_brand_taxonomies);

    if (is_page_template('page-products.php') || $boya_is_brand_archive) {
        $boya_filter_base = home_url('/products');

        if ($boya_is_brand_archive) {
            $boya_brand_term  = get_queried_object();
            $boya_brand_link  = ($boya_brand_term instanceof WP_Term) ? boya_brand_term_link($boya_brand_term) : '';
            $boya_filter_base = $boya_brand_link ?: $boya_filter_base;
        }

        wp_localize_script('boya-store-theme', 'boyaProductFilter', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('boya_filter_products'),
            'baseUrl'     => $boya_filter_base,
            // Brand archives paginate with /page/N/ instead of ?paged=N.
            'pathPaging'  => (bool) $boya_is_brand_archive,
        ]);
    }

    // Force cart fragments on all pages so the mini-cart stays fresh
    if (function_exists('WC')) {
        wp_enqueue_script('wc-cart-fragments');
    }

    // Blaze Slider (front page testimonials only).
    if (is_front_page()) {
        wp_enqueue_style(
            'blaze-slider',
            'https://cdn.jsdelivr.net/npm/blaze-slider@1.9.3/dist/blaze.css',
            [],
            '1.9.3'
        );
        wp_add_inline_style('blaze-slider', boya_slider_inline_css());

        wp_enqueue_script(
            'blaze-slider',
            'https://cdn.jsdelivr.net/npm/blaze-slider@1.9.3/dist/blaze-slider.min.js',
            [],
            '1.9.3',
            true
        );
        wp_add_inline_script('blaze-slider', boya_slider_init_js());
    }
});

/* ── Blaze Slider control styling ───────────────────────────── */
function boya_slider_inline_css() {
    return <<<'CSS'
.boya-testimonials-slider .blaze-track{align-items:stretch}
.boya-testimonials-slider .blaze-track > *{height:auto}
.boya-slider-controls{display:flex;align-items:center;justify-content:center;gap:1rem;margin-top:2.75rem}
.boya-slider-controls button.blaze-prev,.boya-slider-controls button.blaze-next{height:2.75rem;width:2.75rem;border-radius:999px;border:1px solid var(--border,#e5e7eb);background:var(--card,#fff);color:var(--brand-navy,#0f172a);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background-color .2s,color .2s,border-color .2s,transform .2s}
.boya-slider-controls button.blaze-prev:hover,.boya-slider-controls button.blaze-next:hover{background:var(--brand-orange,#f16722);color:#fff;border-color:var(--brand-orange,#f16722);transform:translateY(-2px)}
.boya-slider-controls .blaze-pagination{display:flex;align-items:center;gap:.5rem}
.boya-slider-controls .blaze-pagination button{height:.55rem;width:.55rem;padding:0;border-radius:999px;border:0;background:color-mix(in oklab,var(--brand-navy,#0f172a) 22%,transparent);cursor:pointer;transition:width .25s ease,background-color .25s ease}
.boya-slider-controls .blaze-pagination button.active{width:1.6rem;background:var(--brand-orange,#f16722)}
CSS;
}

/* ── Blaze Slider init ──────────────────────────────────────── */
function boya_slider_init_js() {
    return <<<'JS'
(function () {
    function initTestimonials() {
        var el = document.querySelector('.boya-testimonials-slider');
        if (!el || typeof BlazeSlider === 'undefined' || el.dataset.blazeReady) {
            return;
        }
        el.dataset.blazeReady = '1';
        new BlazeSlider(el, {
            all: {
                enableAutoplay: true,
                autoplayInterval: 4500,
                transitionDuration: 450,
                slidesToShow: 3,
                slideGap: '24px',
                loop: true
            },
            '(max-width: 900px)': { slidesToShow: 2 },
            '(max-width: 600px)': { slidesToShow: 1 }
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTestimonials);
    } else {
        initTestimonials();
    }
})();
JS;
}

/* ── Strip WP body classes to avoid Tailwind conflicts ─────── */
add_filter('body_class', function ($classes) {
    $keep = ['logged-in', 'admin-bar', 'rtl'];
    return array_intersect($classes, $keep);
});

/* ── Remove WP head clutter ─────────────────────────────────── */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
});

/* ── Remove block editor CSS (prevents Tailwind conflicts) ──── */
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
}, 100);

/* ── Helper: current page slug ──────────────────────────────── */
function boya_current_slug() {
    if (is_front_page()) {
        return 'home';
    }
    $obj = get_queried_object();
    if ($obj && isset($obj->post_name)) {
        return $obj->post_name;
    }
    return '';
}

/* ── Contact form handler ───────────────────────────────────── */
add_action('admin_post_nopriv_boya_contact', 'boya_handle_contact');
add_action('admin_post_boya_contact', 'boya_handle_contact');

function boya_handle_contact() {
    if (
        !isset($_POST['boya_contact_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['boya_contact_nonce'])), 'boya_contact_form')
    ) {
        wp_safe_redirect(esc_url(home_url('/contact?contact=error')));
        exit;
    }

    $name    = sanitize_text_field(wp_unslash($_POST['contact_name'] ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['contact_phone'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['contact_email'] ?? ''));
    $subject = sanitize_text_field(wp_unslash($_POST['contact_subject'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['contact_message'] ?? ''));

    $to      = 'info@boyastore-eg.com';
    $headers = ['Content-Type: text/html; charset=UTF-8'];
    if ($email) {
        $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
    }

    $body = '<p><strong>الاسم:</strong> ' . esc_html($name) . '</p>'
          . '<p><strong>الجوال:</strong> ' . esc_html($phone) . '</p>'
          . '<p><strong>البريد:</strong> ' . esc_html($email) . '</p>'
          . '<p><strong>الموضوع:</strong> ' . esc_html($subject) . '</p>'
          . '<p><strong>الرسالة:</strong><br>' . nl2br(esc_html($message)) . '</p>';

    $sent = wp_mail($to, 'رسالة جديدة من بويا ستور: ' . $subject, $body, $headers);

    if ($sent) {
        wp_safe_redirect(esc_url(home_url('/contact?contact=success')));
    } else {
        wp_safe_redirect(esc_url(home_url('/contact?contact=error')));
    }
    exit;
}

/* ════════════════════════════════════════════════════════════════
   WOOCOMMERCE INTEGRATION
   ════════════════════════════════════════════════════════════════ */

/* ── Cart fragments: refresh mini-cart + count + footer on AJAX ─ */
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    if (!function_exists('WC') || !WC()->cart) return $fragments;

    $count    = WC()->cart->get_cart_contents_count();
    $is_empty = WC()->cart->is_empty();

    // Header badge
    $fragments['.boya-cart-count'] =
        '<span class="boya-cart-count absolute -top-1 -left-1 h-5 w-5 rounded-full bg-brand-red text-white text-[10px] font-bold flex items-center justify-center' .
        ($count === 0 ? ' !hidden' : '') . '">' . $count . '</span>';

    // Count label inside cart panel header
    $fragments['.boya-cart-count-label'] =
        '<span class="boya-cart-count-label mt-1">' . $count . ' منتج في السلة</span>';

    // Mini-cart items
    ob_start();
    woocommerce_mini_cart();
    $fragments['div.boya-mini-cart'] = '<div class="boya-mini-cart p-6">' . ob_get_clean() . '</div>';

    // Cart footer — always present so WooCommerce can find and replace it
    if ($is_empty) {
        $fragments['div.boya-cart-footer'] = '<div class="boya-cart-footer hidden p-5 space-y-3 shrink-0"></div>';
    } else {
        $subtotal     = WC()->cart->get_cart_subtotal();
        $cart_url     = esc_url(wc_get_cart_url());
        $checkout_url = esc_url(wc_get_checkout_url());
        $fragments['div.boya-cart-footer'] =
            '<div class="boya-cart-footer p-5 space-y-3 shrink-0">' .
            '<div class="boya-cart-total flex items-center justify-between font-black text-lg"><span>الإجمالي</span><span>' . $subtotal . '</span></div>' .
            '<a href="' . $cart_url . '" class="boya-cart-secondary-btn">عرض السلة</a>' .
            '<a href="' . $checkout_url . '" class="boya-cart-primary-btn">إتمام الشراء</a>' .
            '</div>';
    }

    return $fragments;
});

/* ── Detect installed brands taxonomy ───────────────────────── */
function boya_get_brands_taxonomy() {
    static $found = null;
    if ($found !== null) return $found;
    foreach (['product_brand', 'yith_product_brand', 'pwb-brand', 'pa_brand', 'brand'] as $tax) {
        if (taxonomy_exists($tax)) { $found = $tax; return $found; }
    }
    return null;
}

/* ── Stable frontend brand URLs ─────────────────────────────── */
function boya_get_brand_taxonomies() {
    $taxonomies = [];
    foreach (['product_brand', 'yith_product_brand', 'pwb-brand', 'pa_brand', 'brand'] as $tax) {
        if (taxonomy_exists($tax)) {
            $taxonomies[] = $tax;
        }
    }
    return $taxonomies;
}

function boya_is_brand_taxonomy($taxonomy) {
    return $taxonomy && in_array($taxonomy, boya_get_brand_taxonomies(), true);
}

function boya_brand_term_link($term) {
    if (!($term instanceof WP_Term) || !boya_is_brand_taxonomy($term->taxonomy)) {
        return '';
    }
    return home_url(user_trailingslashit('brands/' . $term->slug));
}

add_filter('term_link', function ($termlink, $term, $taxonomy) {
    if (!boya_is_brand_taxonomy($taxonomy)) {
        return $termlink;
    }

    $brand_link = boya_brand_term_link($term);
    return $brand_link ?: $termlink;
}, 10, 3);

add_action('init', function () {
    $taxonomy = boya_get_brands_taxonomy();
    if (!$taxonomy) {
        return;
    }

    add_rewrite_rule(
        '^brands/([^/]+)/page/([0-9]+)/?$',
        'index.php?taxonomy=' . $taxonomy . '&term=$matches[1]&paged=$matches[2]',
        'top'
    );

    add_rewrite_rule(
        '^brands/([^/]+)/?$',
        'index.php?taxonomy=' . $taxonomy . '&term=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^العلامة التجارية/([^/]+)/?$',
        'index.php?taxonomy=' . $taxonomy . '&term=$matches[1]',
        'top'
    );

    $rewrite_version = '2026-06-18-brand-links-v2';
    if (get_option('boya_store_rewrite_version') !== $rewrite_version) {
        flush_rewrite_rules();
        update_option('boya_store_rewrite_version', $rewrite_version);
    }
}, 99);

add_action('template_redirect', function () {
    $queried = get_queried_object();
    if (!($queried instanceof WP_Term) || !boya_is_brand_taxonomy($queried->taxonomy)) {
        return;
    }

    $brand_link = boya_brand_term_link($queried);
    if (!$brand_link) {
        return;
    }

    $request_path = trim((string) wp_parse_url(wp_unslash($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
    $brand_path   = trim((string) wp_parse_url($brand_link, PHP_URL_PATH), '/');

    // Allow paginated brand URLs (brands/slug/page/N/) without redirecting
    if ($request_path !== $brand_path && strpos($request_path, $brand_path . '/page/') !== 0) {
        wp_safe_redirect($brand_link, 301);
        exit;
    }
});

/* ── Get product code (ACF field with custom-field fallback) ── */
function boya_get_product_code($product_id) {
    if (function_exists('get_field')) {
        $code = get_field('product_code', $product_id);
    } else {
        $code = get_post_meta($product_id, 'product_code', true);
    }
    if (is_array($code)) {
        $code = reset($code);
    }
    return trim((string) $code);
}

/* ── Inline CSS: product-code badge + single-product lightbox ── */
function boya_product_inline_css() {
    return <<<'CSS'

.quantity.boya-qty-ready{
  display:inline-flex;
  align-items:center;
  overflow:hidden;
  border:1px solid var(--border,#e5e7eb);
  border-radius:999px;
  background:var(--card,#fff);
}

.quantity.boya-qty-ready input.qty{
  width:3.5rem;
  height:2.5rem;
  border:0;
  text-align:center;
  font-weight:800;
  background:transparent;
  appearance:textfield;
  -moz-appearance:textfield;
}

.quantity.boya-qty-ready input.qty::-webkit-outer-spin-button,
.quantity.boya-qty-ready input.qty::-webkit-inner-spin-button{
  -webkit-appearance:none;
  margin:0;
}

.boya-qty-btn{
  width:2.5rem;
  height:2.5rem;
  border:0;
  background:transparent;
  color:var(--brand-navy,#0f172a);
  font-size:1.25rem;
  font-weight:900;
  line-height:1;
  cursor:pointer;
}

.boya-qty-btn:hover{
  background:color-mix(in oklab, var(--brand-orange,#f16722) 12%, transparent);
  color:var(--brand-orange,#f16722);
}

/* Auto-update cart: hide the now-redundant manual "تحديث السلة" button. */
.boya-cart-form button[name="update_cart"]{
  display:none;
}

/* Loading state while the AJAX cart update is in flight. */
.boya-cart-page.boya-cart-updating{
  position:relative;
  opacity:.6;
  pointer-events:none;
  transition:opacity .15s ease;
}

.boya-cart-page.boya-cart-updating::after{
  content:"";
  position:absolute;
  top:50%;
  left:50%;
  width:2.25rem;
  height:2.25rem;
  margin:-1.125rem 0 0 -1.125rem;
  border:3px solid color-mix(in oklab, var(--brand-navy,#0f172a) 15%, transparent);
  border-top-color:var(--brand-orange,#f16722);
  border-radius:50%;
  animation:boya-cart-spin .7s linear infinite;
}

@keyframes boya-cart-spin{
  to{ transform:rotate(360deg); }
}



.boya-card-code-badge,.boya-product-code-badge{position:absolute;top:1rem;left:1rem;z-index:10;background:var(--brand-orange);color:#fff;font-weight:700;font-size:.75rem;line-height:1;display:inline-flex;align-items:center;min-height:2rem;padding:.4rem .75rem;border-radius:999px;box-shadow:0 10px 25px color-mix(in oklab, var(--brand-navy) 25%, transparent);pointer-events:none}
.boya-product-code-badge{z-index:3}
.boya-cat-pill{display:inline-flex;align-items:center;gap:.4rem;min-height:2.25rem;padding:.45rem .85rem;border-radius:999px;font-size:.8125rem;font-weight:900;text-decoration:none;background:color-mix(in oklab, var(--brand-blue) 12%, var(--card));color:var(--brand-blue);border:1px solid color-mix(in oklab, var(--brand-blue) 22%, transparent);transition:background-color .2s,color .2s}
.boya-cat-pill:hover{background:var(--brand-blue);color:#fff}
.boya-cat-pill svg{flex-shrink:0}
#boya-product-main-image{cursor:zoom-in}
/* Show the full product uncropped inside the square stage. */
.boya-product-gallery__stage{padding:clamp(1rem,3vw,2rem)}
.boya-product-gallery__stage img{object-fit:contain}
.boya-lightbox{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1.5rem;background:color-mix(in oklab, var(--brand-navy) 96%, transparent);backdrop-filter:blur(12px);opacity:0;visibility:hidden;transition:opacity .3s,visibility .3s}
.boya-lightbox.is-open{opacity:1;visibility:visible}
.boya-lightbox__figure{margin:0;max-width:min(90vw,1100px);max-height:86vh;display:flex;align-items:center;justify-content:center}
.boya-lightbox__img{max-width:100%;max-height:86vh;object-fit:contain;border-radius:1rem;box-shadow:var(--shadow-elegant);background:var(--card);transition:opacity .2s}
.boya-lightbox__btn{position:absolute;height:3rem;width:3rem;border-radius:999px;background:rgba(255,255,255,.12);color:#fff;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:background-color .2s,transform .2s}
.boya-lightbox__btn:hover{background:rgba(255,255,255,.24)}
.boya-lightbox__close{top:1.5rem;left:1.5rem}
.boya-lightbox__prev{right:1.5rem;top:50%;transform:translateY(-50%)}
.boya-lightbox__next{left:1.5rem;top:50%;transform:translateY(-50%)}
.boya-lightbox__counter{position:absolute;bottom:1.5rem;left:50%;transform:translateX(-50%);color:#fff;font-weight:700;font-size:.9rem;background:rgba(255,255,255,.14);padding:.4rem 1rem;border-radius:999px}
.boya-lightbox--single .boya-lightbox__prev,.boya-lightbox--single .boya-lightbox__next,.boya-lightbox--single .boya-lightbox__counter{display:none}

/* ── Products page filters ─────────────────────────────────── */
.boya-product-filters{display:flex;flex-wrap:wrap;align-items:flex-end;gap:.75rem}
.boya-filter-field{display:flex;flex-direction:column;gap:.4rem;min-width:11rem}
.boya-filter-field label{font-size:.75rem;font-weight:900;letter-spacing:.02em;color:var(--muted-foreground,#64748b)}
.boya-filter-select{position:relative;display:block}
.boya-filter-select select{appearance:none;-webkit-appearance:none;width:100%;min-height:2.875rem;padding:.6rem 1.1rem;padding-inline-end:2.5rem;border-radius:999px;border:1px solid var(--border,#e5e7eb);background:var(--card,#fff);color:var(--foreground,#0f172a);font-family:inherit;font-size:.875rem;font-weight:700;line-height:1.4;cursor:pointer;transition:border-color .2s,box-shadow .2s}
.boya-filter-select select:hover{border-color:color-mix(in oklab, var(--brand-navy) 35%, transparent)}
.boya-filter-select select:focus-visible{outline:none;border-color:var(--brand-orange);box-shadow:0 0 0 3px color-mix(in oklab, var(--brand-orange) 25%, transparent)}
.boya-filter-select svg{position:absolute;inset-inline-end:1rem;top:50%;transform:translateY(-50%);width:1rem;height:1rem;pointer-events:none;color:var(--brand-navy,#1e293b)}
.boya-filter-reset,.boya-filter-submit{min-height:2.875rem;padding:.6rem 1.25rem;border-radius:999px;border:1px solid var(--border,#e5e7eb);background:var(--secondary,#f1f5f9);color:var(--foreground,#0f172a);font-family:inherit;font-size:.8125rem;font-weight:900;cursor:pointer;transition:background-color .2s,color .2s}
.boya-filter-reset:hover,.boya-filter-submit:hover{background:var(--brand-navy,#1e293b);color:#fff}
.boya-filter-reset[hidden]{display:none}

.boya-products-results{position:relative;min-height:8rem;transition:opacity .25s ease}
.boya-products-results[aria-busy="true"]{opacity:.45;pointer-events:none}
.boya-products-results[aria-busy="true"]::after{content:"";position:absolute;top:3rem;inset-inline-start:50%;width:2.5rem;height:2.5rem;margin-inline-start:-1.25rem;border-radius:999px;border:3px solid color-mix(in oklab, var(--brand-navy) 12%, transparent);border-block-start-color:var(--brand-orange,#f16722);animation:boya-loader-spin .75s linear infinite}
@media (prefers-reduced-motion:reduce){.boya-products-results[aria-busy="true"]::after{animation:none}}
CSS;
}

/* ── Get category thumbnail URL ─────────────────────────────── */
function boya_term_image($term, $size = 'large') {
    $id = get_term_meta($term->term_id, 'thumbnail_id', true);
    if (!$id) $id = get_term_meta($term->term_id, 'brand_image', true);
    if ($id) return wp_get_attachment_image_url($id, $size);
    return function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src() : '';
}

/* ── Render a single WooCommerce product card ───────────────── */
function boya_render_product_card($product) {
    if (!($product instanceof WC_Product) || !$product->is_visible()) return;

    $id      = $product->get_id();
    $name    = $product->get_name();
    $link    = get_permalink($id);
    $image   = get_the_post_thumbnail_url($id, 'full') ?: wc_placeholder_img_src();
    $on_sale = $product->is_on_sale();
    $price   = (float) $product->get_price();
    $regular = (float) $product->get_regular_price();
    $sale    = (float) $product->get_sale_price();
    $rating  = (float) $product->get_average_rating();
    $code    = boya_get_product_code($id);

    // Brand term
    $brand = '';
    $tax   = boya_get_brands_taxonomy();
    if ($tax) {
        $terms = get_the_terms($id, $tax);
        if ($terms && !is_wp_error($terms)) $brand = $terms[0]->name;
    }

    // Badge
    $badge = '';
    $badge_color = 'var(--brand-orange)';
    if ($on_sale && $regular > 0) {
        $pct         = round((($regular - $sale) / $regular) * 100);
        $badge       = 'خصم ' . $pct . '%';
        $badge_color = 'var(--brand-red)';
    } elseif ($product->is_featured()) {
        $badge       = 'مميز';
        $badge_color = 'var(--brand-orange)';
    } elseif (function_exists('get_post_time') && (time() - (int) get_post_time('U', false, $id)) < (30 * DAY_IN_SECONDS)) {
        $badge       = 'جديد';
        $badge_color = 'var(--brand-green)';
    }

    // Add-to-cart
    $is_ajax  = $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock();
    $cart_url = esc_url($product->add_to_cart_url());
    ?>
    <div class="group relative bg-card rounded-3xl overflow-hidden border border-border/60 shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-elegant)] transition-all duration-500 hover:-translate-y-2 opacity-0 translate-y-8 blur-[2px]">
      <div class="relative aspect-square overflow-hidden bg-secondary">
        <a href="<?php echo esc_url($link); ?>">
          <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
        </a>
        <?php if ($code): ?>
        <span class="boya-card-code-badge"><?php echo esc_html($code); ?></span>
        <?php endif; ?>
        <?php if ($badge): ?>
        <span class="absolute top-4 right-4 px-3 py-1.5 rounded-full text-xs font-bold text-white shadow-lg" style="background:<?php echo esc_attr($badge_color); ?>"><?php echo esc_html($badge); ?></span>
        <?php endif; ?>

        <a href="<?php echo $cart_url; ?>"
           data-quantity="1"
           data-product_id="<?php echo esc_attr($id); ?>"
           data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
           class="add_to_cart_button<?php echo $is_ajax ? ' ajax_add_to_cart' : ''; ?> absolute bottom-4 left-4 right-4 py-3 rounded-2xl bg-brand-navy text-white font-bold text-sm flex items-center justify-center gap-2 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 hover:bg-brand-orange no-underline"
           aria-label="<?php echo esc_attr($product->add_to_cart_description()); ?>"
           rel="nofollow">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" /><line x1="3" y1="6" x2="21" y2="6" /><path d="M16 10a4 4 0 0 1-8 0" /></svg>
          <?php echo esc_html($product->add_to_cart_text()); ?>
        </a>
      </div>

      <div class="p-5">
        <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-bold text-brand-blue uppercase tracking-wider"><?php echo esc_html($brand); ?></span>
          <?php if ($rating > 0): ?>
          <div class="flex items-center gap-1 text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="h-3 w-3 text-brand-yellow"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span class="font-bold"><?php echo esc_html(number_format($rating, 1)); ?></span>
          </div>
          <?php endif; ?>
        </div>
        <h3 class="font-bold text-foreground mb-3 leading-tight">
          <a href="<?php echo esc_url($link); ?>" class="hover:text-brand-orange transition-colors"><?php echo esc_html($name); ?></a>
        </h3>
        <div class="flex items-baseline gap-2">
          <?php if ($on_sale && $sale > 0): ?>
            <span class="text-xl font-black text-brand-navy"><?php echo esc_html(number_format($sale, 0)); ?> ج.م</span>
            <span class="text-sm text-muted-foreground line-through"><?php echo esc_html(number_format($regular, 0)); ?> ج.م</span>
          <?php elseif ($price > 0): ?>
            <span class="text-xl font-black text-brand-navy"><?php echo esc_html(number_format($price, 0)); ?> ج.م</span>
          <?php else: ?>
            <span class="text-xl font-black text-brand-navy"><?php echo wp_kses_post($product->get_price_html()); ?></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php
}

/* ── WooCommerce products query helper ──────────────────────── */
function boya_get_products($args = []) {
    $defaults = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 4,
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    ];
    return new WP_Query(array_merge($defaults, $args));
}

/* ── Products page: category + tag filtering ─────────────────
 * Shared by page-products.php and the AJAX endpoint below, so a filtered
 * page load and an AJAX refresh always produce identical markup.
 */
const BOYA_PRODUCTS_PER_PAGE = 8;

function boya_products_filter_query($cat = 0, $tag = 0, $paged = 1, $brand = 0) {
    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => BOYA_PRODUCTS_PER_PAGE,
        'paged'          => max(1, (int) $paged),
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    ];

    $tax_query = [];

    if ($cat > 0) {
        $tax_query[] = [
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => [(int) $cat],
        ];
    }

    if ($tag > 0) {
        $tax_query[] = [
            'taxonomy' => 'product_tag',
            'field'    => 'term_id',
            'terms'    => [(int) $tag],
        ];
    }

    // Brand archives reuse this query, locked to a single brand term.
    $brand_tax = boya_get_brands_taxonomy();
    if ($brand > 0 && $brand_tax) {
        $tax_query[] = [
            'taxonomy' => $brand_tax,
            'field'    => 'term_id',
            'terms'    => [(int) $brand],
        ];
    }

    if ($tax_query) {
        // Both filters together narrow the results rather than widening them.
        $tax_query['relation'] = 'AND';
        $args['tax_query']     = $tax_query;
    }

    return new WP_Query($args);
}

/**
 * Category/tag terms that actually occur on a given brand's products,
 * with the per-brand product count (not the site-wide term count).
 *
 * @return array List of objects with term_id, name and count.
 */
function boya_brand_filter_terms($brand, $taxonomy) {
    $brand     = (int) $brand;
    $brand_tax = boya_get_brands_taxonomy();
    if (!$brand || !$brand_tax || !taxonomy_exists($taxonomy)) {
        return [];
    }

    $cache_key = 'boya_brand_terms_' . $brand . '_' . $taxonomy;
    $cached    = wp_cache_get($cache_key, 'boya');
    if (is_array($cached)) {
        return $cached;
    }

    $product_ids = get_posts([
        'post_type'              => 'product',
        'post_status'            => 'publish',
        'fields'                 => 'ids',
        'posts_per_page'         => -1,
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'              => [[
            'taxonomy' => $brand_tax,
            'field'    => 'term_id',
            'terms'    => [$brand],
        ]],
    ]);

    $terms = [];
    if ($product_ids) {
        $rows = wp_get_object_terms($product_ids, $taxonomy, ['fields' => 'all_with_object_id']);
        if (!is_wp_error($rows)) {
            foreach ($rows as $row) {
                if (!isset($terms[$row->term_id])) {
                    $terms[$row->term_id] = (object) [
                        'term_id' => (int) $row->term_id,
                        'name'    => $row->name,
                        'count'   => 0,
                    ];
                }
                $terms[$row->term_id]->count++;
            }
        }
    }

    $terms = array_values($terms);
    usort($terms, function ($a, $b) {
        return strnatcasecmp($a->name, $b->name);
    });

    wp_cache_set($cache_key, $terms, 'boya', 5 * MINUTE_IN_SECONDS);

    return $terms;
}

/**
 * Echo the grid + pagination + empty state for the products page.
 */
function boya_render_products_results($cat = 0, $tag = 0, $paged = 1, $brand = 0) {
    $paged = max(1, (int) $paged);
    $query = boya_products_filter_query($cat, $tag, $paged, $brand);

    if (!$query->have_posts()) {
        ?>
        <div class="text-center py-16 text-muted-foreground">
          <?php if ($cat > 0 || $tag > 0): ?>
          <p class="font-bold mb-2">لا توجد منتجات مطابقة لاختيارك.</p>
          <p class="text-sm">جرّب قسماً أو وسماً مختلفاً.</p>
          <?php else: ?>
          <p>لا توجد منتجات حتى الآن.</p>
          <?php if (current_user_can('manage_options')): ?>
          <a href="<?php echo esc_url(admin_url('post-new.php?post_type=product')); ?>"
             class="mt-4 inline-block px-6 py-3 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
            إضافة منتج →
          </a>
          <?php endif; ?>
          <?php endif; ?>
        </div>
        <?php
        wp_reset_postdata();
        return;
    }
    ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
      <?php while ($query->have_posts()) : $query->the_post();
        $product = wc_get_product(get_the_ID());
        if ($product) boya_render_product_card($product);
      endwhile; ?>
    </div>

    <?php
    if ((int) $query->max_num_pages > 1) :
        // Keep the active filters in the pagination links; JS intercepts the
        // clicks, but the links stay valid without JavaScript.
        $brand_term = $brand > 0 ? get_term((int) $brand) : null;
        $brand_link = ($brand_term instanceof WP_Term) ? boya_brand_term_link($brand_term) : '';
        $keep       = array_filter(['pcat' => (int) $cat, 'ptag' => (int) $tag]);

        if ($brand_link) {
            // Brand archives keep their pretty /brands/<slug>/page/N/ URLs.
            // The query string is appended by hand: add_query_arg() would read
            // the `#` of the %#% placeholder as a fragment separator.
            $base = trailingslashit($brand_link) . 'page/%#%/'
                  . ($keep ? '?' . http_build_query($keep) : '');
        } else {
            $base = home_url('/products');
            if ($keep) {
                $base = add_query_arg($keep, $base);
            }
            $base = add_query_arg('paged', '%#%', $base);
        }
    ?>
    <nav class="boya-pagination mt-14" aria-label="صفحات المنتجات">
      <?php echo paginate_links([
        'base'      => esc_url_raw($base),
        'format'    => '',
        'total'     => (int) $query->max_num_pages,
        'current'   => $paged,
        'prev_text' => 'السابق',
        'next_text' => 'التالي',
      ]); ?>
    </nav>
    <?php
    endif;

    wp_reset_postdata();
}

/**
 * AJAX: re-render the products grid for the selected category/tag.
 */
function boya_ajax_filter_products() {
    check_ajax_referer('boya_filter_products', 'nonce');

    $cat   = isset($_POST['cat']) ? absint($_POST['cat']) : 0;
    $tag   = isset($_POST['tag']) ? absint($_POST['tag']) : 0;
    $brand = isset($_POST['brand']) ? absint($_POST['brand']) : 0;
    $paged = isset($_POST['paged']) ? max(1, absint($_POST['paged'])) : 1;

    // Ignore terms that don't exist in the expected taxonomy.
    if ($cat && !term_exists($cat, 'product_cat')) {
        $cat = 0;
    }
    if ($tag && !term_exists($tag, 'product_tag')) {
        $tag = 0;
    }
    $brand_tax = boya_get_brands_taxonomy();
    if ($brand && (!$brand_tax || !term_exists($brand, $brand_tax))) {
        $brand = 0;
    }

    ob_start();
    boya_render_products_results($cat, $tag, $paged, $brand);

    wp_send_json_success([
        'html'  => ob_get_clean(),
        'cat'   => $cat,
        'tag'   => $tag,
        'brand' => $brand,
        'paged' => $paged,
    ]);
}
add_action('wp_ajax_boya_filter_products', 'boya_ajax_filter_products');
add_action('wp_ajax_nopriv_boya_filter_products', 'boya_ajax_filter_products');


/**
 * Force billing phone to be required at checkout.
 * Overrides Checkout Field Editor Pro (THWCFD) settings.
 */
add_filter('woocommerce_checkout_fields', function ($fields) {
    if (isset($fields['billing']['billing_phone'])) {
        $fields['billing']['billing_phone']['required'] = true;
    }
    return $fields;
}, PHP_INT_MAX);

add_filter('woocommerce_billing_fields', function ($fields) {
    if (isset($fields['billing_phone'])) {
        $fields['billing_phone']['required'] = true;
    }
    return $fields;
}, PHP_INT_MAX);

// Force at render time (wins over any field-editor plugin)
add_filter('woocommerce_form_field_args', function ($args, $key, $value) {
    if ($key === 'billing_phone') {
        $args['required'] = true;
    }
    return $args;
}, PHP_INT_MAX, 3);

// Server-side enforcement: block order submission without phone
add_action('woocommerce_after_checkout_validation', function ($data, $errors) {
    if (empty($data['billing_phone'])) {
        $errors->add('billing_phone_required', __('يرجى إدخال رقم الموبايل، فهو حقل إجباري.', 'boya-store'));
    }
}, 10, 2);


// Also force phone required in country-locale data (used by checkout JS,
// otherwise the field editor plugin flips the field back to optional client-side)
add_filter('woocommerce_get_country_locale', function ($locale) {
    foreach ($locale as $country => $fields) {
        if (isset($fields['phone'])) {
            $locale[$country]['phone']['required'] = true;
        }
    }
    return $locale;
}, PHP_INT_MAX);

add_filter('woocommerce_get_country_locale_default', function ($fields) {
    if (isset($fields['phone'])) {
        $fields['phone']['required'] = true;
    }
    return $fields;
}, PHP_INT_MAX);

add_filter('woocommerce_get_country_locale_base', function ($fields) {
    if (isset($fields['phone'])) {
        $fields['phone']['required'] = true;
    }
    return $fields;
}, PHP_INT_MAX);

/* ── Custom quantity plus/minus buttons ─────────────────────── */
add_action('wp_footer', function () {
    if (!function_exists('is_woocommerce')) {
        return;
    }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cartUpdateTimer = null;

            /**
             * Submit the cart form over AJAX and swap in the fresh markup so the
             * quantity change applies without the "تحديث السلة" button.
             */
            function ajaxUpdateCart(form) {
                var cartPage = document.querySelector('.boya-cart-page');
                if (!cartPage) {
                    return;
                }

                cartPage.classList.add('boya-cart-updating');

                var formData = new FormData(form);
                // Force WooCommerce to treat this POST as a cart update.
                formData.set('update_cart', 'Update cart');

                fetch(form.getAttribute('action') || window.location.href, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(function (response) { return response.text(); })
                    .then(function (html) {
                        var doc = new DOMParser().parseFromString(html, 'text/html');
                        var freshCart = doc.querySelector('.boya-cart-page');

                        if (freshCart) {
                            cartPage.replaceWith(freshCart);
                            setupQuantityButtons();
                        } else {
                            cartPage.classList.remove('boya-cart-updating');
                        }

                        if (window.jQuery) {
                            jQuery(document.body).trigger('updated_cart_totals');
                            jQuery(document.body).trigger('wc_fragment_refresh');
                        }
                    })
                    .catch(function () {
                        // On failure, fall back to a normal cart submit.
                        cartPage.classList.remove('boya-cart-updating');
                        form.submit();
                    });
            }

            function scheduleCartUpdate(input) {
                var form = input.closest('.woocommerce-cart-form');
                if (!form) {
                    return; // Not on the cart page (e.g. single product) — no auto-update.
                }

                if (cartUpdateTimer) {
                    clearTimeout(cartUpdateTimer);
                }

                cartUpdateTimer = setTimeout(function () {
                    ajaxUpdateCart(form);
                }, 550); // Debounce rapid +/- clicks into a single request.
            }

            function setupQuantityButtons() {
                document.querySelectorAll('.quantity').forEach(function (quantityWrap) {
                    if (quantityWrap.classList.contains('boya-qty-ready')) {
                        return;
                    }

                    const input = quantityWrap.querySelector('input.qty');
                    if (!input) {
                        return;
                    }

                    quantityWrap.classList.add('boya-qty-ready');

                    const minusBtn = document.createElement('button');
                    minusBtn.type = 'button';
                    minusBtn.className = 'boya-qty-btn boya-qty-minus';
                    minusBtn.textContent = '−';

                    const plusBtn = document.createElement('button');
                    plusBtn.type = 'button';
                    plusBtn.className = 'boya-qty-btn boya-qty-plus';
                    plusBtn.textContent = '+';

                    quantityWrap.insertBefore(minusBtn, input);
                    quantityWrap.appendChild(plusBtn);

                    function changeQuantity(direction) {
                        const step = parseFloat(input.getAttribute('step')) || 1;
                        const min = parseFloat(input.getAttribute('min')) || 0;
                        const maxAttr = input.getAttribute('max');
                        const max = maxAttr ? parseFloat(maxAttr) : null;
                        let value = parseFloat(input.value) || 0;

                        if (direction === 'plus') {
                            value += step;
                        } else {
                            value -= step;
                        }

                        if (value < min) {
                            value = min;
                        }

                        if (max !== null && value > max) {
                            value = max;
                        }

                        input.value = value;

                        input.dispatchEvent(new Event('change', { bubbles: true }));
                        input.dispatchEvent(new Event('input', { bubbles: true }));

                        // Auto-update the cart over AJAX (no "تحديث السلة" click needed).
                        scheduleCartUpdate(input);
                    }

                    minusBtn.addEventListener('click', function () {
                        changeQuantity('minus');
                    });

                    plusBtn.addEventListener('click', function () {
                        changeQuantity('plus');
                    });

                    // Also auto-update when the user types a quantity directly.
                    input.addEventListener('change', function () {
                        scheduleCartUpdate(input);
                    });
                });
            }

            setupQuantityButtons();

            document.body.addEventListener('updated_cart_totals', setupQuantityButtons);
            document.body.addEventListener('wc_fragments_refreshed', setupQuantityButtons);

            if (window.jQuery) {
                jQuery(document.body).on('updated_cart_totals wc_fragments_refreshed', setupQuantityButtons);
            }
        });
    </script>
    <?php
}, 99);