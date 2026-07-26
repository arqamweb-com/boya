<?php
/**
 * Template Name: About Page
 */
get_header();
$images = get_template_directory_uri() . '/assets/images';
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
    <div class="inline-block text-sm font-bold mb-4 tracking-wider text-brand-yellow">من نحن</div>
    <h1 class="text-4xl md:text-6xl font-black leading-tight">
      قصة شغف <span class="text-gradient-warm">بالألوان والإتقان</span>
    </h1>
    <p class="text-lg text-white/70 max-w-2xl mx-auto mt-6 leading-relaxed">
      بويا ستور — وجهتك الموثوقة لأفضل دهانات السيارات والإنشاءات والأخشاب والمنتجات الصناعية في مصر.
    </p>
  </div>
  <div class="absolute bottom-0 left-0 right-0">
    <svg viewBox="0 0 1440 80" class="w-full" preserveAspectRatio="none">
      <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" class="fill-background" />
    </svg>
  </div>
</section>

<!-- About Section -->
<section id="about" class="py-24 lg:py-32 relative overflow-hidden">
  <div class="container mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <div class="relative aspect-[4/5] rounded-[2.5rem] overflow-hidden shadow-[var(--shadow-elegant)]">
          <img src="<?php echo esc_url($images . '/about-factory.jpg'); ?>" alt="مصنع بويا ستور" width="800" height="1000" loading="lazy" class="w-full h-full object-cover" />
          <div class="absolute inset-0 bg-gradient-to-tr from-brand-navy/40 to-transparent"></div>
        </div>
        <div class="absolute -bottom-8 -left-8 bg-white rounded-3xl p-6 shadow-[var(--shadow-elegant)] max-w-xs">
          <div class="grid grid-cols-2 gap-4">
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-red)">+20</div><div class="text-xs text-muted-foreground mt-0.5">سنة خبرة</div></div>
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-orange)">+50K</div><div class="text-xs text-muted-foreground mt-0.5">عميل</div></div>
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-green)">+15K</div><div class="text-xs text-muted-foreground mt-0.5">منتج</div></div>
            <div class="p-3 rounded-2xl bg-secondary/60"><div class="text-2xl font-black" style="color:var(--brand-blue)">+8</div><div class="text-xs text-muted-foreground mt-0.5">علامة</div></div>
          </div>
        </div>
        <div class="absolute -top-6 -right-6 w-40 h-40 rounded-full opacity-30" style="background:var(--gradient-rainbow);filter:blur(60px)"></div>
      </div>
      <div class="space-y-8">
        <div>
          <div class="text-sm font-bold text-brand-purple mb-3 tracking-wider">من نحن</div>
          <h2 class="text-4xl md:text-5xl font-black leading-tight mb-6">
            قصة شغف<span class="block text-gradient-warm">بالألوان والإتقان</span>
          </h2>
          <p class="text-muted-foreground leading-relaxed text-lg">
            منذ تأسيس بويا ستور، التزمنا بتقديم أرقى منتجات الدهانات للعملاء في جمهورية مصر العربية. نعمل مع أكبر العلامات التجارية العالمية لنوفر حلولاً متكاملة للمحترفين والهواة على حدٍ سواء.
          </p>
        </div>
        <div class="space-y-4">
          <div class="flex gap-4 p-5 rounded-2xl hover:bg-secondary/50 transition-colors">
            <div class="shrink-0 p-3 rounded-xl h-fit" style="background:color-mix(in oklab,var(--brand-red) 12%,transparent);color:var(--brand-red)">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
            </div>
            <div><h4 class="font-bold mb-1">رسالتنا</h4><p class="text-sm text-muted-foreground">توفير أفضل الحلول والمنتجات في عالم الدهانات بمعايير عالمية.</p></div>
          </div>
          <div class="flex gap-4 p-5 rounded-2xl hover:bg-secondary/50 transition-colors">
            <div class="shrink-0 p-3 rounded-xl h-fit" style="background:color-mix(in oklab,var(--brand-blue) 12%,transparent);color:var(--brand-blue)">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div><h4 class="font-bold mb-1">رؤيتنا</h4><p class="text-sm text-muted-foreground">أن نكون الوجهة الأولى والأكثر ثقة لكل ما يخص الدهانات في المنطقة.</p></div>
          </div>
          <div class="flex gap-4 p-5 rounded-2xl hover:bg-secondary/50 transition-colors">
            <div class="shrink-0 p-3 rounded-xl h-fit" style="background:color-mix(in oklab,var(--brand-green) 12%,transparent);color:var(--brand-green)">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div><h4 class="font-bold mb-1">قيمنا</h4><p class="text-sm text-muted-foreground">الجودة، الأمانة، الاحترافية، والابتكار المستمر في خدمة عملائنا.</p></div>
          </div>
        </div>
        <div>
          <a href="<?php echo esc_url(home_url('/contact')); ?>" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full bg-brand-navy text-white font-bold hover:bg-brand-orange transition-colors">
            تواصل معنا <span class="inline-block group-hover:-translate-x-1 transition-transform">←</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Values Section -->
<section class="py-24 bg-secondary/40">
  <div class="container mx-auto px-6">
    <div class="text-center mb-16">
      <div class="text-sm font-bold text-brand-orange mb-3 tracking-wider">لماذا بويا ستور؟</div>
      <h2 class="text-4xl md:text-5xl font-black">ما يميزنا عن <span class="text-gradient-warm">الآخرين</span></h2>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php
      $values = [
        ['title'=>'جودة عالمية','desc'=>'نختار منتجاتنا من أكبر العلامات التجارية الموثوقة عالميًا.','color'=>'var(--brand-red)'],
        ['title'=>'أصلية 100%','desc'=>'نضمن لك منتجات أصلية بفاتورة وضمان رسمي.','color'=>'var(--brand-green)'],
        ['title'=>'توصيل سريع','desc'=>'نوصل لكافة محافظات الجمهورية في أسرع وقت ممكن.','color'=>'var(--brand-orange)'],
        ['title'=>'خبراء متخصصون','desc'=>'فريق دعم فني متخصص للإجابة على كل استفساراتك.','color'=>'var(--brand-blue)'],
        ['title'=>'أحدث المنتجات','desc'=>'نواكب أحدث التقنيات في عالم الدهانات والمنتجات الصناعية.','color'=>'var(--brand-purple)'],
        ['title'=>'ثقة العملاء','desc'=>'آلاف العملاء يثقون بنا منذ سنوات لتغطية احتياجاتهم.','color'=>'var(--brand-navy)'],
      ];
      foreach ($values as $v): ?>
      <div class="group bg-card rounded-3xl p-8 border border-border/60 shadow-[var(--shadow-soft)] hover:shadow-[var(--shadow-elegant)] hover:-translate-y-1 transition-all duration-500 opacity-0 translate-y-8 blur-[2px]">
        <div class="inline-flex p-4 rounded-2xl mb-5 transition-transform group-hover:scale-110 group-hover:-rotate-6" style="background:color-mix(in oklab,<?php echo esc_attr($v['color']); ?> 12%,transparent);color:<?php echo esc_attr($v['color']); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
        </div>
        <h3 class="text-xl font-black mb-2 text-brand-navy"><?php echo esc_html($v['title']); ?></h3>
        <p class="text-muted-foreground leading-relaxed"><?php echo esc_html($v['desc']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-24">
  <div class="container mx-auto px-6">
    <div class="relative overflow-hidden rounded-[2.5rem] p-10 lg:p-16 text-white text-center" style="background:linear-gradient(135deg,var(--brand-navy),var(--brand-blue) 60%,var(--brand-purple))">
      <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-brand-orange/30 blur-3xl animate-blob"></div>
      <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-brand-red/20 blur-3xl animate-blob" style="animation-delay:4s"></div>
      <div class="relative">
        <h3 class="text-3xl md:text-5xl font-black mb-4 leading-tight">
          جاهز لبدء <span class="text-gradient-warm">مشروعك القادم؟</span>
        </h3>
        <p class="text-white/80 max-w-2xl mx-auto mb-8">
          تواصل معنا اليوم واحصل على استشارة مجانية من خبراء بويا ستور.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3">
          <a href="<?php echo esc_url(home_url('/contact')); ?>" class="px-8 py-4 rounded-full bg-white text-brand-navy font-bold hover:scale-105 transition-transform">تواصل معنا</a>
          <a href="<?php echo esc_url(home_url('/products')); ?>" class="px-8 py-4 rounded-full border-2 border-white/30 hover:bg-white/10 font-bold transition-colors">تصفح المنتجات</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
