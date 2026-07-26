<?php
defined('ABSPATH') || exit;

/* ── Auto-create pages on theme activation ──────────────────── */
add_action('after_switch_theme', 'boya_setup_pages');

function boya_setup_pages() {
    if (get_option('boya_store_setup_done') === '1.0.0') {
        return;
    }

    $pages = [
        ['title' => 'الرئيسية',                         'slug' => 'home',          'template' => 'front-page.php'],
        ['title' => 'من نحن',                            'slug' => 'about',         'template' => 'page-about.php'],
        ['title' => 'العلامات التجارية',                  'slug' => 'brands',        'template' => 'page-brands.php'],
        ['title' => 'الأقسام',                           'slug' => 'categories',    'template' => 'page-categories.php'],
        ['title' => 'تواصل معنا',                        'slug' => 'contact',       'template' => 'page-contact.php'],
        ['title' => 'العروض',                            'slug' => 'offers',        'template' => 'page-offers.php'],
        ['title' => 'المنتجات',                          'slug' => 'products',      'template' => 'page-products.php'],
        ['title' => 'سياسة الاسترجاع والاستبدال',         'slug' => 'return-policy', 'template' => 'page-return-policy.php'],
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
            __('بويا ستور: لم يتم إعداد الثيم بعد. <a href="%s">اضغط هنا للإعداد</a>', 'boya-store'),
            ['a' => ['href' => []]]
        ),
        esc_url(admin_url('themes.php?page=boya-store-setup'))
    );
    echo '</p></div>';
});

/* ── Theme setup admin page ─────────────────────────────────── */
add_action('admin_menu', function () {
    add_theme_page(
        'Boya Store Setup',
        'Boya Store Setup',
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
    echo '<h1>Boya Store Theme Settings</h1>';

    if (isset($_POST['boya_run_setup']) && check_admin_referer('boya_setup_nonce')) {
        boya_setup_pages();
        echo '<div class="notice notice-success"><p>تم الإعداد بنجاح!</p></div>';
    }

    echo '<h2>حالة الصفحات</h2><ul>';
    foreach ($pages_to_check as $slug) {
        $exists = get_page_by_path($slug) ? '✅ موجودة' : '❌ غير موجودة';
        echo '<li><strong>' . esc_html($slug) . '</strong>: ' . esc_html($exists) . '</li>';
    }
    echo '</ul>';

    echo '<h2>إعدادات أخرى</h2><ul>';
    echo '<li><strong>الصفحة الرئيسية:</strong> ' . ($show_on_front === 'page' && $front_id ? '✅ مضبوطة' : '❌ غير مضبوطة') . '</li>';
    echo '<li><strong>هيكل الروابط:</strong> ' . ($permalink ? '✅ ' . esc_html($permalink) : '❌ غير مضبوط') . '</li>';
    echo '</ul>';

    echo '<h2>تعليمات التثبيت</h2><ol>';
    echo '<li>WP Admin → Appearance → Themes → Add New → Upload → boya-store-theme.zip</li>';
    echo '<li>Activate the theme</li>';
    echo '<li>Appearance → Boya Store Setup → Run Setup</li>';
    echo '<li>Settings → Permalinks → Save Changes</li>';
    echo '</ol>';

    echo '<form method="post">';
    wp_nonce_field('boya_setup_nonce');
    echo '<input type="hidden" name="boya_run_setup" value="1">';
    submit_button('تشغيل الإعداد');
    echo '</form>';
    echo '</div>';
}
