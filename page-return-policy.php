<?php
/**
 * Template Name: Return Policy Page
 */
get_header();
?>

<main class="container mx-auto px-6 py-16 lg:py-24 max-w-4xl">
  <div class="text-center mb-12">
    <div class="text-sm font-bold text-brand-orange mb-3 tracking-wider"><?php esc_html_e('سياساتنا', 'arqamweb'); ?></div>
    <h1 class="text-4xl md:text-5xl font-black">
      <?php esc_html_e('سياسة', 'arqamweb'); ?> <span class="text-gradient-warm"><?php esc_html_e('الاسترجاع والاستبدال', 'arqamweb'); ?></span>
    </h1>
    <p class="text-muted-foreground mt-4 max-w-2xl mx-auto"><?php esc_html_e('نحن في بويا ستور نحرص على رضا عملائنا وتقديم أفضل جودة من منتجات وأدوات الدهانات. لذلك نوفر سياسة مرنة للاسترجاع والاستبدال وفق الشروط التالية:', 'arqamweb'); ?></p>
  </div>

  <div class="bg-card rounded-3xl p-8 md:p-12 shadow-[var(--shadow-soft)] border border-border/60 space-y-10">

    <section class="space-y-3">
      <h2 class="text-2xl md:text-3xl font-black text-brand-navy"><?php esc_html_e('أولًا: مدة الاسترجاع والاستبدال', 'arqamweb'); ?></h2>
      <div class="text-foreground/80 leading-loose space-y-2">
        <p><?php esc_html_e('يحق للعميل طلب الاسترجاع أو الاستبدال خلال 14 يومًا من تاريخ استلام الطلب.', 'arqamweb'); ?></p>
      </div>
    </section>

    <section class="space-y-3">
      <h2 class="text-2xl md:text-3xl font-black text-brand-navy"><?php esc_html_e('ثانيًا: شروط الاسترجاع', 'arqamweb'); ?></h2>
      <div class="text-foreground/80 leading-loose space-y-2">
        <ul class="list-disc pr-6 space-y-2">
          <li><?php esc_html_e('أن يكون المنتج غير مستخدم وفي حالته الأصلية.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('أن يكون المنتج داخل التغليف الأصلي مع جميع الملحقات.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('تقديم فاتورة الشراء أو رقم الطلب.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('لا يتم قبول استرجاع المنتجات التي تم فتحها أو استخدامها، خاصةً المواد الكيميائية مثل الدهانات أو المذيبات.', 'arqamweb'); ?></li>
        </ul>
      </div>
    </section>

    <section class="space-y-3">
      <h2 class="text-2xl md:text-3xl font-black text-brand-navy"><?php esc_html_e('ثالثًا: شروط الاستبدال', 'arqamweb'); ?></h2>
      <div class="text-foreground/80 leading-loose space-y-2">
        <p><?php esc_html_e('يمكن استبدال المنتج في حالة:', 'arqamweb'); ?></p>
        <ul class="list-disc pr-6 space-y-2">
          <li><?php esc_html_e('وجود عيب صناعي.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('استلام منتج غير مطابق للطلب.', 'arqamweb'); ?></li>
        </ul>
        <p><?php esc_html_e('يتحمل المتجر تكاليف الشحن في حالة الخطأ أو العيب.', 'arqamweb'); ?></p>
        <p><?php esc_html_e('في حالة رغبة العميل في الاستبدال بدون وجود عيب، يتحمل العميل تكلفة الشحن.', 'arqamweb'); ?></p>
      </div>
    </section>

    <section class="space-y-3">
      <h2 class="text-2xl md:text-3xl font-black text-brand-navy"><?php esc_html_e('رابعًا: المنتجات غير القابلة للاسترجاع', 'arqamweb'); ?></h2>
      <div class="text-foreground/80 leading-loose space-y-2">
        <ul class="list-disc pr-6 space-y-2">
          <li><?php esc_html_e('الدهانات التي تم فتحها أو استخدامها.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('المنتجات المخصصة أو التي تم تجهيزها حسب الطلب.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('أي منتج تالف نتيجة سوء الاستخدام أو التخزين.', 'arqamweb'); ?></li>
        </ul>
      </div>
    </section>

    <section class="space-y-3">
      <h2 class="text-2xl md:text-3xl font-black text-brand-navy"><?php esc_html_e('خامسًا: استرداد المبالغ', 'arqamweb'); ?></h2>
      <div class="text-foreground/80 leading-loose space-y-2">
        <ul class="list-disc pr-6 space-y-2">
          <li><?php esc_html_e('يتم رد المبلغ خلال 5 إلى 10 أيام عمل بعد استلام وفحص المنتج.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('يتم الاسترداد بنفس وسيلة الدفع الأصلية.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('قد يتم خصم رسوم الشحن (إن وجدت) في حالات الاسترجاع غير الناتج عن خطأ من المتجر.', 'arqamweb'); ?></li>
        </ul>
      </div>
    </section>

    <section class="space-y-3">
      <h2 class="text-2xl md:text-3xl font-black text-brand-navy"><?php esc_html_e('سادسًا: إجراءات الاسترجاع', 'arqamweb'); ?></h2>
      <div class="text-foreground/80 leading-loose space-y-2">
        <ol class="list-decimal pr-6 space-y-2">
          <li>
            <?php
            printf(
              /* translators: 1: customer service phone link, 2: customer service email link */
              wp_kses(__('التواصل مع خدمة العملاء عبر %1$s أو %2$s.', 'arqamweb'), ['a' => ['href' => [], 'class' => []]]),
              '<a href="tel:0237532216" class="text-brand-orange font-bold hover:underline">0237532216</a>',
              '<a href="mailto:info@boyastore-eg.com" class="text-brand-orange font-bold hover:underline">info@boyastore-eg.com</a>'
            );
            ?>
          </li>
          <li><?php esc_html_e('إرسال رقم الطلب وصورة المنتج (إن لزم).', 'arqamweb'); ?></li>
          <li><?php esc_html_e('سيتم مراجعة الطلب والرد خلال 24–48 ساعة.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('ترتيب استلام المنتج من العميل أو توجيهه لأقرب نقطة شحن.', 'arqamweb'); ?></li>
        </ol>
      </div>
    </section>

    <section class="space-y-3">
      <h2 class="text-2xl md:text-3xl font-black text-brand-navy"><?php esc_html_e('سابعًا: ملاحظات هامة', 'arqamweb'); ?></h2>
      <div class="text-foreground/80 leading-loose space-y-2">
        <ul class="list-disc pr-6 space-y-2">
          <li><?php esc_html_e('يجب التأكد من المنتج عند الاستلام قبل الاستخدام.', 'arqamweb'); ?></li>
          <li><?php esc_html_e('المتجر غير مسؤول عن أي أضرار ناتجة عن سوء التطبيق أو الاستخدام الخاطئ للمنتجات.', 'arqamweb'); ?></li>
        </ul>
      </div>
    </section>

    <div class="pt-6 border-t border-border/60 text-center space-y-2">
      <h3 class="text-xl font-black"><?php esc_html_e('للتواصل', 'arqamweb'); ?></h3>
      <p><a href="tel:0237532216" class="text-brand-orange font-bold hover:underline">0237532216</a></p>
      <p><a href="mailto:info@boyastore-eg.com" class="text-brand-orange font-bold hover:underline">info@boyastore-eg.com</a></p>
    </div>
  </div>
</main>

<?php get_footer(); ?>
