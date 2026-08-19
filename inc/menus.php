<?php
/**
 * Dynamic navigation menus for Boya Store.
 *
 * Registers WordPress menu locations and provides custom walkers + fallbacks
 * so the header and footer menus render with the theme's existing HTML
 * structure and CSS classes. When no menu is assigned to a location, the
 * matching fallback reproduces the theme's original (hardcoded / taxonomy)
 * output so nothing breaks out of the box.
 */
defined('ABSPATH') || exit;

/* ── Register menu locations ────────────────────────────────── */
add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary_menu'    => __('القائمة الرئيسية (الهيدر)', 'arqamweb'),
        'mobile_menu'     => __('قائمة الموبايل', 'arqamweb'),
        'footer_sections' => __('الفوتر — عمود الأقسام', 'arqamweb'),
        'footer_brands'   => __('الفوتر — عمود العلامات التجارية', 'arqamweb'),
        'footer_links'    => __('الفوتر — عمود الروابط المهمة', 'arqamweb'),
    ]);
});

/* ── Minimal dropdown styling (only affects generated submenus) ─ */
function boya_menu_inline_css() {
    return <<<'CSS'
.boya-has-dropdown{position:relative}
.boya-has-dropdown>.boya-dropdown{position:absolute;top:100%;right:0;min-width:220px;background:var(--card);border:1px solid color-mix(in oklab, var(--border) 60%, transparent);border-radius:1rem;box-shadow:var(--shadow-elegant);padding:.5rem;display:flex;flex-direction:column;gap:.125rem;opacity:0;visibility:hidden;transform:translateY(.5rem);transition:opacity .25s,transform .25s,visibility .25s;z-index:60}
.boya-has-dropdown:hover>.boya-dropdown{opacity:1;visibility:visible;transform:translateY(0)}
.boya-dropdown a{display:block;padding:.55rem .85rem;border-radius:.75rem;font-size:.95rem;font-weight:600;color:color-mix(in oklab, var(--foreground) 80%, transparent);transition:color .2s,background-color .2s;text-decoration:none}
.boya-dropdown a:hover,.boya-dropdown a.is-active{color:var(--brand-orange);background:var(--secondary)}
.boya-mobile-submenu:not(.hidden){display:flex;flex-direction:column;gap:.25rem}
.boya-submenu-toggle svg{transition:transform .25s}
.boya-submenu-toggle[aria-expanded="true"] svg{transform:rotate(180deg)}
CSS;
}

/* ════════════════════════════════════════════════════════════════
   WALKERS
   ════════════════════════════════════════════════════════════════ */

/**
 * Header (desktop) walker — renders flat <a> links matching the original
 * markup, and exposes child items as a hover dropdown to preserve hierarchy.
 */
class Boya_Header_Walker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<div class="boya-dropdown">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</div>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes      = (array) $item->classes;
        $is_active    = in_array('current-menu-item', $classes, true)
                     || in_array('current-menu-parent', $classes, true)
                     || in_array('current-menu-ancestor', $classes, true);
        $has_children = in_array('menu-item-has-children', $classes, true);
        $url          = !empty($item->url) ? esc_url($item->url) : '#';
        $label        = esc_html($item->title);

        if ($depth === 0) {
            if ($has_children) {
                $output .= '<div class="boya-has-dropdown">';
            }
            $link_class = 'relative px-4 py-2 text-base font-semibold transition-colors group hover:text-foreground ' . ($is_active ? 'text-brand-orange' : 'text-foreground/80');
            $span_class = 'absolute bottom-0 right-1/2 translate-x-1/2 h-0.5 bg-[image:var(--gradient-warm)] transition-all duration-300 ' . ($is_active ? 'w-2/3' : 'w-0 group-hover:w-2/3');
            $output    .= '<a href="' . $url . '" class="' . esc_attr($link_class) . '">'
                        . $label
                        . '<span class="' . esc_attr($span_class) . '"></span>'
                        . '</a>';
        } else {
            $output .= '<a href="' . $url . '" class="' . ($is_active ? 'is-active' : '') . '">' . $label . '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth === 0 && in_array('menu-item-has-children', (array) $item->classes, true)) {
            $output .= '</div>';
        }
    }
}

/**
 * Mobile walker — flat <a> links matching the original mobile markup, with
 * child items rendered as an indented block to preserve hierarchy.
 */
class Boya_Mobile_Walker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        // Collapsed by default; toggled open via the parent's button.
        $output .= '<div class="boya-mobile-submenu ps-4 hidden">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</div>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes      = (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes, true);
        $url          = !empty($item->url) ? esc_url($item->url) : '#';
        $label        = esc_html($item->title);
        $class        = 'px-4 py-3 text-base font-semibold text-foreground/80 hover:text-brand-orange hover:bg-secondary rounded-xl transition-colors';
        if ($depth > 0) {
            $class .= ' text-sm';
        }

        if ($has_children) {
            $output .= '<div class="boya-mobile-item">'
                     . '<div class="flex items-center gap-1">'
                     . '<a href="' . $url . '" class="' . esc_attr($class) . ' flex-1">' . $label . '</a>'
                     . '<button type="button" class="boya-submenu-toggle shrink-0 p-3 rounded-xl text-foreground/70 hover:text-brand-orange hover:bg-secondary transition-colors" aria-expanded="false" aria-label="' . esc_attr__('فتح/إغلاق القائمة الفرعية', 'arqamweb') . '">'
                     . '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>'
                     . '</button>'
                     . '</div>';
        } else {
            $output .= '<a href="' . $url . '" class="' . esc_attr($class) . '">' . $label . '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if (in_array('menu-item-has-children', (array) $item->classes, true)) {
            $output .= '</div>';
        }
    }
}

/**
 * Footer walker — renders the original <li><a>…</a></li> markup used by every
 * footer column, with optional nested lists for child items.
 */
class Boya_Footer_Walker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="space-y-2 ps-3 mt-2">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $url   = !empty($item->url) ? esc_url($item->url) : '#';
        $label = esc_html($item->title);
        $output .= '<li><a href="' . $url . '" class="text-white/70 hover:text-brand-orange transition-colors text-sm inline-block rtl:hover:-translate-x-1">' . $label . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}

/* ════════════════════════════════════════════════════════════════
   FALLBACKS (used only when a location has no assigned menu)
   ════════════════════════════════════════════════════════════════ */

/** Default header/mobile links — mirror the theme's original nav. */
function boya_default_nav_links() {
    return [
        '/'           => __('الرئيسية', 'arqamweb'),
        '/categories' => __('الأقسام', 'arqamweb'),
        '/brands'     => __('العلامات التجارية', 'arqamweb'),
        '/products'   => __('المنتجات', 'arqamweb'),
        '/offers'     => __('العروض', 'arqamweb'),
        '/about'      => __('من نحن', 'arqamweb'),
        '/contact'    => __('تواصل معنا', 'arqamweb'),
    ];
}

/** Header (desktop) fallback. */
function boya_primary_menu_fallback($args = []) {
    $current_slug = function_exists('boya_current_slug') ? boya_current_slug() : '';
    foreach (boya_default_nav_links() as $path => $label) {
        $slug      = ltrim($path, '/') ?: 'home';
        $is_active = ($current_slug === $slug);
        printf(
            '<a href="%1$s" class="relative px-4 py-2 text-base font-semibold transition-colors group hover:text-foreground %2$s">%3$s<span class="absolute bottom-0 right-1/2 translate-x-1/2 h-0.5 bg-[image:var(--gradient-warm)] transition-all duration-300 %4$s"></span></a>',
            esc_url(home_url($path)),
            $is_active ? 'text-brand-orange' : 'text-foreground/80',
            esc_html($label),
            $is_active ? 'w-2/3' : 'w-0 group-hover:w-2/3'
        );
    }
}

/**
 * Mobile fallback — reuse the assigned primary menu if there is one,
 * otherwise fall back to the default links.
 */
function boya_mobile_menu_fallback($args = []) {
    $locations = get_nav_menu_locations();
    if (!empty($locations['primary_menu'])) {
        wp_nav_menu([
            'menu'        => $locations['primary_menu'],
            'container'   => false,
            'items_wrap'  => '%3$s',
            'depth'       => 2,
            'walker'      => new Boya_Mobile_Walker(),
            'fallback_cb' => false,
        ]);
        return;
    }
    foreach (boya_default_nav_links() as $path => $label) {
        printf(
            '<a href="%1$s" class="px-4 py-3 text-base font-semibold text-foreground/80 hover:text-brand-orange hover:bg-secondary rounded-xl transition-colors">%2$s</a>',
            esc_url(home_url($path)),
            esc_html($label)
        );
    }
}

/** Shared footer link renderer. */
function boya_footer_link_item($url, $label) {
    printf(
        '<li><a href="%1$s" class="text-white/70 hover:text-brand-orange transition-colors text-sm inline-block rtl:hover:-translate-x-1">%2$s</a></li>',
        esc_url($url),
        esc_html($label)
    );
}

/** Footer "Sections" fallback — live product categories. */
function boya_footer_sections_fallback($args = []) {
    $excluded     = [];
    $uncategorized = taxonomy_exists('product_cat') ? get_term_by('slug', 'uncategorized', 'product_cat') : false;
    if ($uncategorized && !is_wp_error($uncategorized)) {
        $excluded[] = (int) $uncategorized->term_id;
    }

    $categories = taxonomy_exists('product_cat') ? get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'number'     => 6,
        'orderby'    => 'name',
        'order'      => 'ASC',
        'exclude'    => $excluded,
    ]) : [];

    echo '<ul class="space-y-3">';
    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            boya_footer_link_item(get_term_link($category), $category->name);
        }
    } else {
        boya_footer_link_item(home_url('/categories'), __('عرض الأقسام', 'arqamweb'));
    }
    echo '</ul>';
}

/** Footer "Brands" fallback — live brand taxonomy terms. */
function boya_footer_brands_fallback($args = []) {
    $tax    = function_exists('boya_get_brands_taxonomy') ? boya_get_brands_taxonomy() : null;
    $brands = $tax ? get_terms([
        'taxonomy'   => $tax,
        'hide_empty' => false,
        'number'     => 6,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]) : [];

    echo '<ul class="space-y-3">';
    if (!empty($brands) && !is_wp_error($brands)) {
        foreach ($brands as $brand) {
            boya_footer_link_item(get_term_link($brand), $brand->name);
        }
    } else {
        boya_footer_link_item(home_url('/brands'), __('عرض العلامات التجارية', 'arqamweb'));
    }
    echo '</ul>';
}

/** Footer "Important links" fallback — the original static list. */
function boya_footer_links_fallback($args = []) {
    $links = [
        '/about'         => __('من نحن', 'arqamweb'),
        '/contact'       => __('تواصل معنا', 'arqamweb'),
        '/products'      => __('المنتجات', 'arqamweb'),
        '/offers'        => __('العروض', 'arqamweb'),
        '/return-policy' => __('سياسة الاسترجاع والاستبدال', 'arqamweb'),
    ];
    echo '<ul class="space-y-3">';
    foreach ($links as $path => $label) {
        boya_footer_link_item(home_url($path), $label);
    }
    echo '</ul>';
}
