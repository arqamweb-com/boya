<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<!-- Offers Section -->
<section id="offers" class="py-24">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 relative overflow-hidden rounded-[2rem] p-10 lg:p-14 text-white min-h-[400px] flex flex-col justify-between"
                 style="background:linear-gradient(135deg,var(--brand-navy),var(--brand-blue) 60%,var(--brand-purple))">
                <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-brand-orange/40 blur-3xl animate-blob"></div>
                <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-brand-red/30 blur-3xl animate-blob"
                     style="animation-delay:5s"></div>
                <div class="relative">
                    <div class="inline-block px-3 py-1 rounded-full bg-white/10 backdrop-blur text-xs font-bold mb-4">
                        تواصل
                        معنا
                    </div>
                    <h3 class="text-4xl lg:text-6xl font-black leading-tight mb-4">
                        اطلب كتالوج المنتجات الان من خلال الواتساب
                    </h3>
                    <p class="text-white/70 max-w-md">على جميع منتجات الفئة الذهبية من أفضل العلامات التجارية
                        العالمية</p>
                </div>
                <div class="relative flex flex-wrap items-center gap-4">
                    <a href="https://wa.me/201038314148" target="_blank"
                       class="group px-7 py-3.5 rounded-full bg-white text-brand-navy font-bold flex items-center gap-2 hover:scale-105 transition-transform">
                        واتساب
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="h-4 w-4 group-hover:-translate-x-1 transition-transform">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                    </a>
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/15 flex items-center gap-2 text-xs font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            منتجات أصلية
                        </div>
                        <div class="px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/15 flex items-center gap-2 text-xs font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="1" y="3" width="15" height="13"/>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                <circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                            شحن سريع
                        </div>
                        <div class="px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/15 flex items-center gap-2 text-xs font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"/>
                                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                            </svg>
                            ضمان الجودة
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-rows-2 gap-6">
                <div class="relative overflow-hidden rounded-[2rem] p-8 text-white"
                     style="background:linear-gradient(135deg,var(--brand-red),var(--brand-orange))">
                    <div class="absolute -top-12 -left-12 w-48 h-48 rounded-full bg-white/15 blur-2xl"></div>
                    <div class="relative">
                        <div class="text-xs font-bold opacity-90 mb-2">شحن</div>
                        <h4 class="text-2xl font-black mb-3 leading-tight">للاستفسار عن التوصيل <br/> تواصل خلال
                            الواتساب</h4>
                        <a href="https://wa.me/201038314148" target="_blank"
                           class="text-sm font-bold inline-flex items-center gap-1 hover:gap-2 transition-all">
                            تواصل معنا
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-[2rem] p-8 text-white"
                     style="background:linear-gradient(135deg,var(--brand-green),var(--brand-blue))">
                    <div class="absolute -bottom-12 -right-12 w-48 h-48 rounded-full bg-white/15 blur-2xl"></div>
                    <div class="relative">
                        <div class="text-xs font-bold opacity-90 mb-2">باقة المحترفين</div>
                        <h4 class="text-2xl font-black mb-3 leading-tight">أسعار خاصة للمقاولين</h4>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>"
                           class="text-sm font-bold inline-flex items-center gap-1 hover:gap-2 transition-all">
                            تواصل معنا الآن
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
