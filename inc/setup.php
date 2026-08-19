<?php
defined('ABSPATH') || exit;

/* ── Load theme translations ────────────────────────────────── */
add_action('after_setup_theme', function () {
    load_theme_textdomain('arqamweb', get_template_directory() . '/languages');
}, 5);

/* ── Auto-create pages on theme activation ──────────────────── */
add_action('after_switch_theme', 'boya_setup_pages');

function boya_setup_pages() {
    if (get_option('boya_store_setup_done') === '1.0.0') {
        return;
    }

    $pages = [
        ['title' => __('الرئيسية', 'arqamweb'),                        'slug' => 'home',          'template' => 'front-page.php'],
        ['title' => __('من نحن', 'arqamweb'),                           'slug' => 'about',         'template' => 'page-about.php'],
        ['title' => __('العلامات التجارية', 'arqamweb'),                 'slug' => 'brands',        'template' => 'page-brands.php'],
        ['title' => __('الأقسام', 'arqamweb'),                          'slug' => 'categories',    'template' => 'page-categories.php'],
        ['title' => __('تواصل معنا', 'arqamweb'),                       'slug' => 'contact',       'template' => 'page-contact.php'],
        ['title' => __('العروض', 'arqamweb'),                           'slug' => 'offers',        'template' => 'page-offers.php'],
        ['title' => __('المنتجات', 'arqamweb'),                         'slug' => 'products',      'template' => 'page-products.php'],
        ['title' => __('سياسة الاسترجاع والاستبدال', 'arqamweb'),        'slug' => 'return-policy', 'template' => 'page-return-policy.php'],
    ];

    $home_id = 0;

    foreach ($pages as $page) {
        $existing = get_page_by_path($page['slug']);
        if ($existing) {
            if ($page['slug'] === 'home') {
                $home_id = $existing->ID;
            }
            continue;
        }

        $id = wp_insert_post([
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ]);

        if (!is_wp_error($id)) {
            update_post_meta($id, '_wp_page_template', $page['template']);
            if ($page['slug'] === 'home') {
                $home_id = $id;
            }
        }
    }

    if ($home_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_id);
    }

    if (empty(get_option('permalink_structure'))) {
        update_option('permalink_structure', '/%postname%/');
    }

    flush_rewrite_rules();
    update_option('boya_store_setup_done', '1.0.0');
}

/* ── Admin notice if setup hasn't run ──────────────────────── */
add_action('admin_notices', function () {
    if (get_option('boya_store_setup_done') === '1.0.0') {
        return;
    }
    echo '<div class="notice notice-warning"><p>';
    printf(
        wp_kses(
            /* translators: %s: link to setup page */
            __('بويا ستور: لم يتم إعداد الثيم بعد. <a href="%s">اضغط هنا للإعداد</a>', 'arqamweb'),
            ['a' => ['href' => []]]
        ),
        esc_url(admin_url('themes.php?page=boya-store-setup'))
    );
    echo '</p></div>';
});

/* ── Theme setup admin page ─────────────────────────────────── */
add_action('admin_menu', function () {
    add_theme_page(
        __('إعداد بويا ستور', 'arqamweb'),
        __('إعداد بويا ستور', 'arqamweb'),
        'manage_options',
        'boya-store-setup',
        'boya_setup_admin_page'
    );
});

function boya_setup_admin_page() {
    $pages_to_check = ['home', 'about', 'brands', 'categories', 'contact', 'offers', 'products', 'return-policy'];
    $front_id       = (int) get_option('page_on_front');
    $show_on_front  = get_option('show_on_front');
    $permalink      = get_option('permalink_structure');

    echo '<div class="wrap" dir="rtl">';
    echo '<h1>' . esc_html__('إعدادات ثيم بويا ستور', 'arqamweb') . '</h1>';

    if (isset($_POST['boya_run_setup']) && check_admin_referer('boya_setup_nonce')) {
        boya_setup_pages();
        echo '<div class="notice notice-success"><p>' . esc_html__('تم الإعداد بنجاح!', 'arqamweb') . '</p></div>';
    }

    echo '<h2>' . esc_html__('حالة الصفحات', 'arqamweb') . '</h2><ul>';
    foreach ($pages_to_check as $slug) {
        $exists = get_page_by_path($slug)
            ? esc_html__('✅ موجودة', 'arqamweb')
            : esc_html__('❌ غير موجودة', 'arqamweb');
        echo '<li><strong>' . esc_html($slug) . '</strong>: ' . $exists . '</li>';
    }
    echo '</ul>';

    echo '<h2>' . esc_html__('إعدادات أخرى', 'arqamweb') . '</h2><ul>';
    echo '<li><strong>' . esc_html__('الصفحة الرئيسية:', 'arqamweb') . '</strong> '
        . ($show_on_front === 'page' && $front_id
            ? esc_html__('✅ مضبوطة', 'arqamweb')
            : esc_html__('❌ غير مضبوطة', 'arqamweb'))
        . '</li>';
    echo '<li><strong>' . esc_html__('هيكل الروابط:', 'arqamweb') . '</strong> '
        . ($permalink
            ? '✅ ' . esc_html($permalink)
            : esc_html__('❌ غير مضبوط', 'arqamweb'))
        . '</li>';
    echo '</ul>';

    echo '<h2>' . esc_html__('تعليمات التثبيت', 'arqamweb') . '</h2><ol>';
    echo '<li>' . esc_html__('لوحة التحكم ← المظهر ← القوالب ← أضف جديد ← رفع ← boya-store-theme.zip', 'arqamweb') . '</li>';
    echo '<li>' . esc_html__('تفعيل الثيم', 'arqamweb') . '</li>';
    echo '<li>' . esc_html__('المظهر ← إعداد بويا ستور ← تشغيل الإعداد', 'arqamweb') . '</li>';
    echo '<li>' . esc_html__('الإعدادات ← الروابط الدائمة ← حفظ التغييرات', 'arqamweb') . '</li>';
    echo '</ol>';

    echo '<form method="post">';
    wp_nonce_field('boya_setup_nonce');
    echo '<input type="hidden" name="boya_run_setup" value="1">';
    submit_button(__('تشغيل الإعداد', 'arqamweb'));
    echo '</form>';
    echo '</div>';
}
