<!-- WhatsApp FAB -->
<a href="https://wa.me/201038314148" target="_blank" rel="noreferrer"
   class="fixed bottom-6 end-6 z-40 h-14 w-14 rounded-full bg-brand-green text-white flex items-center justify-center shadow-[var(--shadow-elegant)] hover:scale-110 transition-transform"
   aria-label="<?php esc_attr_e('تواصل واتساب', 'arqamweb'); ?>">
  <span class="absolute inset-0 rounded-full bg-brand-green animate-ping opacity-30"></span>
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 relative"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" /></svg>
</a>

<footer class="relative bg-brand-navy text-white overflow-hidden">
  <div class="absolute inset-0 opacity-40" style="background: radial-gradient(circle at 20% 20%, color-mix(in oklab, var(--brand-blue) 50%, transparent), transparent 55%), radial-gradient(circle at 80% 80%, color-mix(in oklab, var(--brand-purple) 45%, transparent), transparent 55%), radial-gradient(circle at 50% 100%, color-mix(in oklab, var(--brand-orange) 35%, transparent), transparent 60%)"></div>
  <div class="absolute inset-0 opacity-[0.06]" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 28px 28px"></div>
  <div class="absolute -top-32 right-1/4 w-96 h-96 rounded-full bg-brand-orange/10 blur-3xl"></div>
  <div class="absolute -bottom-32 left-1/4 w-96 h-96 rounded-full bg-brand-blue/20 blur-3xl"></div>

  <div class="container mx-auto px-6 pt-20 pb-8 relative">
    <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
      <div class="lg:col-span-2">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img src="https://boyastore-eg.com/wp-content/uploads/2026/08/BOYA-LOGO-WEB-WHITE.png" alt="<?php esc_attr_e('بويا ستور', 'arqamweb'); ?>" class="h-14 mb-5" />
        </a>
        <p class="text-white/70 leading-relaxed mb-6 max-w-sm">
          <?php esc_html_e('وجهتك الأولى لأفضل دهانات السيارات، الإنشاءات، الأخشاب والمنتجات الصناعية من أرقى العلامات التجارية العالمية.', 'arqamweb'); ?>
        </p>
        <div class="flex gap-3">
			<a href="https://www.facebook.com/boya.store1/" target="_blank"
			   class="h-10 w-10 rounded-full bg-white/10 hover:bg-brand-orange flex items-center justify-center transition-colors"
			   aria-label="Facebook">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
					 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
				</svg>
			</a>
			<a href="https://www.instagram.com/boyastore2/" target="_blank"
			   class="h-10 w-10 rounded-full bg-white/10 hover:bg-brand-orange flex items-center justify-center transition-colors"
			   aria-label="Instagram">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
					 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
					<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
					<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
				</svg>
			</a>
		</div>
      </div>

      <!-- Sections column -->
      <div>
        <h4 class="font-black mb-5 text-lg"><?php esc_html_e('الأقسام', 'arqamweb'); ?></h4>
        <?php
        wp_nav_menu([
          'theme_location' => 'footer_sections',
          'container'      => false,
          'items_wrap'     => '<ul class="space-y-3">%3$s</ul>',
          'depth'          => 2,
          'walker'         => new Boya_Footer_Walker(),
          'fallback_cb'    => 'boya_footer_sections_fallback',
        ]);
        ?>
      </div>

      <!-- Brands column -->
      <div>
        <h4 class="font-black mb-5 text-lg"><?php esc_html_e('العلامات التجارية', 'arqamweb'); ?></h4>
        <?php
        wp_nav_menu([
          'theme_location' => 'footer_brands',
          'container'      => false,
          'items_wrap'     => '<ul class="space-y-3">%3$s</ul>',
          'depth'          => 2,
          'walker'         => new Boya_Footer_Walker(),
          'fallback_cb'    => 'boya_footer_brands_fallback',
        ]);
        ?>
      </div>

      <!-- Links column -->
      <div>
        <h4 class="font-black mb-5 text-lg"><?php esc_html_e('روابط مهمة', 'arqamweb'); ?></h4>
        <?php
        wp_nav_menu([
          'theme_location' => 'footer_links',
          'container'      => false,
          'items_wrap'     => '<ul class="space-y-3">%3$s</ul>',
          'depth'          => 2,
          'walker'         => new Boya_Footer_Walker(),
          'fallback_cb'    => 'boya_footer_links_fallback',
        ]);
        ?>
      </div>
    </div>

    <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-white/60">
      <div><?php esc_html_e('© 2026 بويا ستور. جميع الحقوق محفوظة.', 'arqamweb'); ?></div>
      <div class="flex items-center gap-3 flex-wrap justify-center">
        <span><?php esc_html_e('طرق الدفع:', 'arqamweb'); ?></span>
        <div class="h-9 px-3 rounded-md bg-white flex items-center" title="<?php esc_attr_e('فوري', 'arqamweb'); ?>">
          <img src="https://iconape.com/wp-content/files/gz/336170/svg/336170.svg" alt="Fawry" class="h-6 w-auto object-contain" />
        </div>
        <div class="h-9 px-3 rounded-md bg-white flex items-center text-brand-navy text-xs font-bold" title="<?php esc_attr_e('كاش عند الاستلام', 'arqamweb'); ?>">
          <?php esc_html_e('كاش عند الاستلام', 'arqamweb'); ?>
        </div>
        <div class="h-9 px-3 rounded-md bg-white flex items-center" title="Visa">
          <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/Visa_Inc._logo_%282005%E2%80%932014%29.svg" alt="Visa" class="h-4 w-auto" />
        </div>
      </div>
    </div>

    <div class="mt-6 text-center text-xs text-white/40">
      <?php esc_html_e('الموقع من تصميم وبرمجة', 'arqamweb'); ?>
      <a href="https://www.arqamweb.com" target="_blank" rel="noreferrer"
         class="font-bold hover:opacity-80 transition-opacity underline underline-offset-2"
         style="color: #f16722;"><?php esc_html_e('أرقام ويب', 'arqamweb'); ?></a>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
