<?php
/**
 * Template Name: Contact Page
 */
get_header();
?>

<!-- Page Header -->
<section class="relative overflow-hidden bg-brand-navy text-white">
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-red/40 blur-3xl animate-blob"></div>
    <div class="absolute top-20 -left-32 w-[500px] h-[500px] rounded-full bg-brand-blue/40 blur-3xl animate-blob" style="animation-delay:4s"></div>
    <div class="absolute bottom-0 right-1/3 w-[400px] h-[400px] rounded-full bg-brand-orange/30 blur-3xl animate-blob" style="animation-delay:8s"></div>
  </div>
  <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(white 1px,transparent 1px),linear-gradient(90deg,white 1px,transparent 1px);background-size:60px 60px"></div>
  <div class="container mx-auto px-6 pt-20 pb-28 lg:pt-28 lg:pb-36 relative text-center">
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow"><?php esc_html_e('تواصل معنا', 'arqamweb'); ?></div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      <?php esc_html_e('دعنا', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('نساعدك اليوم', 'arqamweb'); ?></span>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      <?php esc_html_e('نحن هنا للإجابة على كل أسئلتك ومساعدتك في اختيار المنتج المناسب لمشروعك.', 'arqamweb'); ?>
    </p>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-24 lg:py-32 bg-secondary/40">
  <div class="container mx-auto px-6">
    <div class="text-center max-w-2xl mx-auto mb-16">
      <div class="text-sm font-bold text-brand-green mb-3 tracking-wider"><?php esc_html_e('تواصل معنا', 'arqamweb'); ?></div>
      <h2 class="text-4xl md:text-5xl font-black"><?php esc_html_e('دعنا', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('نساعدك', 'arqamweb'); ?></span> <?php esc_html_e('اليوم', 'arqamweb'); ?></h2>
    </div>
    <div class="grid lg:grid-cols-5 gap-8">
      <div class="lg:col-span-2 space-y-4">
        <?php
        $contacts = [
          ['icon'=>'phone','title'=>__('اتصل بنا', 'arqamweb'),'value'=>"01038304949\n01038314148\n0237532216",'color'=>'var(--brand-red)'],
          ['icon'=>'message-circle','title'=>__('واتساب', 'arqamweb'),'value'=>'01038314148','color'=>'var(--brand-green)','cta'=>__('ابدأ المحادثة', 'arqamweb')],
          ['icon'=>'mail','title'=>__('البريد الإلكتروني', 'arqamweb'),'value'=>'info@boyastore-eg.com','color'=>'var(--brand-blue)'],
          ['icon'=>'map-pin','title'=>__('العنوان', 'arqamweb'),'value'=>__('34 ش محمد حمزة البطران، متفرع من الفريق علي فهمي، المنصورية - الهرم', 'arqamweb'),'color'=>'var(--brand-orange)'],
          ['icon'=>'clock','title'=>__('مواعيد التسليم', 'arqamweb'),'value'=>__("الطلبات من 6 صباحًا إلى 3 عصرًا تُسلّم في نفس اليوم.\nمن 4 عصرًا إلى 12 منتصف الليل تُسلّم في اليوم التالي.", 'arqamweb'),'color'=>'var(--brand-purple)'],
        ];
        $icons = [
          'phone'          => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.85 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.96 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>',
          'message-circle' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
          'mail'           => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
          'map-pin'        => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
          'clock'          => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        ];
        foreach ($contacts as $c): ?>
        <div class="group p-6 rounded-3xl bg-card border border-border/60 hover:shadow-[var(--shadow-elegant)] hover:-translate-y-1 transition-all duration-300">
          <div class="flex items-start gap-4">
            <div class="shrink-0 p-3 rounded-2xl transition-transform group-hover:scale-110 group-hover:-rotate-6" style="background:color-mix(in oklab,<?php echo esc_attr($c['color']); ?> 12%,transparent);color:<?php echo esc_attr($c['color']); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $icons[$c['icon']]; ?></svg>
            </div>
            <div class="flex-1 min-w-0">
              <div class="text-xs text-muted-foreground mb-1"><?php echo esc_html($c['title']); ?></div>
              <div class="font-bold break-words whitespace-pre-line"><?php echo esc_html($c['value']); ?></div>
              <?php if (!empty($c['cta'])): ?>
              <a href="https://wa.me/201038314148" class="inline-block mt-2 text-xs font-bold" style="color:<?php echo esc_attr($c['color']); ?>"><?php echo esc_html($c['cta']); ?> ←</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="lg:col-span-3 bg-card rounded-3xl p-8 shadow-[var(--shadow-soft)] border border-border/60 space-y-4">
        <h3 class="text-2xl font-black mb-2"><?php esc_html_e('أرسل لنا رسالة', 'arqamweb'); ?></h3>
        <p class="text-muted-foreground text-sm mb-6"><?php esc_html_e('سنرد عليك في أقرب وقت ممكن', 'arqamweb'); ?></p>

          <div>
              <?php echo do_shortcode('[contact-form-7 id="14a5d4d" title="Contact Us"]'); ?>
          </div>
      </div>
    </div>
  </div>
</section>

<!-- Map Section -->
<section class="pb-24">
  <div class="container mx-auto px-6">
    <div class="rounded-3xl overflow-hidden border border-border/60 shadow-[var(--shadow-soft)] aspect-[16/9] md:aspect-[21/9]">
      <iframe
        title="<?php esc_attr_e('موقع بويا ستور على الخريطة', 'arqamweb'); ?>"
        src="https://www.google.com/maps?q=34+%D8%B4+%D9%85%D8%AD%D9%85%D8%AF+%D8%AD%D9%85%D8%B2%D8%A9+%D8%A7%D9%84%D8%A8%D8%B7%D8%B1%D8%A7%D9%86%D8%8C+%D8%A7%D9%84%D9%85%D9%86%D8%B5%D9%88%D8%B1%D9%8A%D8%A9%D8%8C+%D8%A7%D9%84%D9%87%D8%B1%D9%85&output=embed"
        width="100%"
        height="100%"
        style="border:0"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

<?php get_footer(); ?>
