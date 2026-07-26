# دليل قوائم بويا ستور (Menu Guide)

ملف مرجعي: التقسيمة الكاملة لقوائم الثيم + ألوان الموقع الرسمية.
الهدف: لما يُطلب "اعمل نفس التقسيمة دي في المينو" يتم إنتاج نفس الشكل بنفس
الكلاسات والألوان دون تخمين.

> كل القوائم ديناميكية من **المظهر → القوائم (Appearance → Menus)**.
> الكود في `inc/menus.php` والاستدعاءات في `header.php` و `footer.php`.

---

## 1. مواقع القوائم (Menu Locations)

| المفتاح (location) | المكان | الـ Walker | الـ Fallback لو مفيش قائمة |
|---|---|---|---|
| `primary_menu`    | قائمة الهيدر (ديسكتوب) | `Boya_Header_Walker` | `boya_primary_menu_fallback` — 7 روابط افتراضية |
| `mobile_menu`     | قائمة الموبايل المنسدلة | `Boya_Mobile_Walker` | `boya_mobile_menu_fallback` — يعيد استخدام `primary_menu` ثم الروابط الافتراضية |
| `footer_sections` | عمود "الأقسام" بالفوتر | `Boya_Footer_Walker` | `boya_footer_sections_fallback` — أقسام WooCommerce الحية |
| `footer_brands`   | عمود "العلامات التجارية" | `Boya_Footer_Walker` | `boya_footer_brands_fallback` — تصنيف البراندات الحي |
| `footer_links`    | عمود "روابط مهمة" | `Boya_Footer_Walker` | `boya_footer_links_fallback` — 5 روابط ثابتة |

التسجيل في `inc/menus.php` عبر `register_nav_menus()`.

---

## 2. ألوان الموقع الرسمية (Design Tokens)

كلها متغيرات CSS معرّفة في `assets/css/styles.css` (نظام oklch). استخدم
المتغيّر أو كلاس Tailwind المقابل — **لا تستخدم قيم لون ثابتة (hex).**

| المتغيّر | الكلاس | القيمة | الاستخدام |
|---|---|---|---|
| `--brand-orange` | `text-brand-orange` / `bg-brand-orange` | `oklch(70% .19 50)` | اللون الأساسي / الـ hover / النشِط |
| `--brand-navy`   | `bg-brand-navy` / `text-brand-navy` | `oklch(32% .07 240)` | خلفية الفوتر والـ top bar |
| `--brand-red`    | `bg-brand-red` | `oklch(62% .23 25)` | بادچ الخصم / تنبيهات |
| `--brand-blue`   | `text-brand-blue` | `oklch(46% .2 265)` | تمييز ثانوي |
| `--brand-green`  | `bg-brand-green` | `oklch(62% .18 145)` | واتساب / "جديد" |
| `--brand-purple` | — | `oklch(45% .18 310)` | لمسات تدرّج الفوتر |
| `--brand-yellow` | `text-brand-yellow` | `oklch(88% .18 95)` | نجوم التقييم |
| `--foreground`   | `text-foreground` | `oklch(15% .02 240)` | لون النص الأساسي |
| `--background`   | — | `oklch(98% .005 240)` | خلفية الصفحة |
| `--card`         | `bg-card` | `oklch(100% 0 0)` | خلفية الكروت/الدروب داون |
| `--secondary`    | `bg-secondary` / `hover:bg-secondary` | `oklch(95% .01 240)` | خلفية hover خفيفة |
| `--muted-foreground` | `text-muted-foreground` | `oklch(50% .02 240)` | نص ثانوي |
| `--border`       | `border-border` | `oklch(90% .01 240)` | حدود |
| `--gradient-warm`| `bg-[image:var(--gradient-warm)]` | `linear-gradient(135deg, red→orange)` | خط التحديد تحت لينك الهيدر |

**ألوان نصوص الفوتر** (على خلفية navy): النص `text-white/70`، الـ hover
`hover:text-brand-orange`، العناوين `text-white`.

---

## 3. الماركب والكلاسات لكل قائمة

> لازم أي قائمة جديدة تطلع بنفس الكلاسات بالظبط. منطق الحالة النشِطة يأتي
> من كلاسات ووردبريس: `current-menu-item` / `current-menu-parent` /
> `current-menu-ancestor`.

### أ) الهيدر — `primary_menu` (روابط مسطّحة + دروب داون عند hover)

العنصر الأساسي:
```html
<a href="URL" class="relative px-4 py-2 text-base font-semibold transition-colors group hover:text-foreground {نشِط: text-brand-orange | عادي: text-foreground/80}">
  LABEL
  <span class="absolute bottom-0 right-1/2 translate-x-1/2 h-0.5 bg-[image:var(--gradient-warm)] transition-all duration-300 {نشِط: w-2/3 | عادي: w-0 group-hover:w-2/3}"></span>
</a>
```
لو فيه أبناء: يُلفّ في `<div class="boya-has-dropdown">` ويُضاف بعد اللينك
`<div class="boya-dropdown">…روابط أبناء…</div>` (يظهر عند hover — CSS في
`boya_menu_inline_css()`). لينك الابن: `<a class="{نشِط: is-active}">LABEL</a>`.

### ب) الموبايل — `mobile_menu` (أكورديون بزرار)

عنصر بدون أبناء:
```html
<a href="URL" class="px-4 py-3 text-base font-semibold text-foreground/80 hover:text-brand-orange hover:bg-secondary rounded-xl transition-colors">LABEL</a>
```
عنصر له أبناء (زرار يفتح/يقفل):
```html
<div class="boya-mobile-item">
  <div class="flex items-center gap-1">
    <a href="URL" class="px-4 py-3 text-base font-semibold text-foreground/80 hover:text-brand-orange hover:bg-secondary rounded-xl transition-colors flex-1">LABEL</a>
    <button type="button" class="boya-submenu-toggle shrink-0 p-3 rounded-xl text-foreground/70 hover:text-brand-orange hover:bg-secondary transition-colors" aria-expanded="false" aria-label="فتح/إغلاق القائمة الفرعية">
      <svg ...><polyline points="6 9 12 15 18 9"></polyline></svg>
    </button>
  </div>
  <div class="boya-mobile-submenu pr-4 hidden"> …روابط أبناء… </div>
</div>
```
الأبناء أعمق ياخدوا `text-sm`. الفتح/القفل في `assets/js/theme.js` (قسم 2b).

### ج) الفوتر — `footer_*` (قائمة عمودية)

التغليف: `items_wrap = '<ul class="space-y-3">%3$s</ul>'`. العنصر:
```html
<li><a href="URL" class="text-white/70 hover:text-brand-orange transition-colors text-sm inline-block rtl:hover:-translate-x-1">LABEL</a></li>
```
قائمة فرعية (نادرة): `<ul class="space-y-2 pr-3 mt-2">…</ul>`.

---

## 4. شكل استدعاء `wp_nav_menu` (انسخه كما هو)

```php
// هيدر
wp_nav_menu([
  'theme_location' => 'primary_menu',
  'container'      => false,
  'items_wrap'     => '%3$s',
  'depth'          => 2,
  'walker'         => new Boya_Header_Walker(),
  'fallback_cb'    => 'boya_primary_menu_fallback',
]);

// موبايل: نفس ده مع theme_location=mobile_menu + Boya_Mobile_Walker + boya_mobile_menu_fallback

// فوتر (لأي عمود)
wp_nav_menu([
  'theme_location' => 'footer_links',          // أو footer_sections / footer_brands
  'container'      => false,
  'items_wrap'     => '<ul class="space-y-3">%3$s</ul>',
  'depth'          => 2,
  'walker'         => new Boya_Footer_Walker(),
  'fallback_cb'    => 'boya_footer_links_fallback',
]);
```

---

## 5. تعليمات عند إضافة موقع قائمة جديد

1. سجّل الموقع في `register_nav_menus()` داخل `inc/menus.php`.
2. اختر الـ Walker المناسب (هيدر/موبايل/فوتر) أو اعمل واحد جديد يلتزم بالكلاسات أعلاه.
3. اكتب دالة `fallback` تعيد نفس الماركب لما مفيش قائمة مسندة.
4. نادِ `wp_nav_menu()` في القالب بنفس الـ args.
5. استخدم متغيّرات/كلاسات الألوان من القسم 2 فقط — ممنوع hex ثابت.
6. اعمل `php -l` للملفات المعدّلة و `node --check assets/js/theme.js`.
