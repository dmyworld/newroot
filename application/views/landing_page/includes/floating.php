
<!-- WhatsApp Button -->
<button onclick="openWhatsApp()" id="whatsapp-btn" class="fixed bottom-6 right-6 z-50 w-16 h-16 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-250 hover:scale-110 group hidden">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
    </svg>
    <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-pulse"></div>
    <div class="absolute bottom-full right-0 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-250">
        Chat with us on WhatsApp
    </div>
</button>

<!-- Mobile Conversion CTA Bar -->
<div id="mobile-cta-bar" class="fixed bottom-0 left-0 right-0 z-[90] md:hidden hidden">
    <div class="bg-card border-t border-border shadow-lg">
        <div class="px-4 py-3 flex items-center justify-between gap-3">
            <button onclick="window.location.href='tel:+94112345678'" class="flex-shrink-0 w-12 h-12 bg-secondary text-secondary-foreground rounded-lg flex items-center justify-center hover:bg-secondary/90 transition-all duration-250 shadow-cta" aria-label="Call us">
                <?php echo getIcon('PhoneIcon', 'w-6 h-6'); ?>
            </button>

            <button onclick="scrollToSection('contact')" class="flex-1 px-6 py-3 bg-accent text-accent-foreground font-cta font-bold text-base rounded-lg shadow-cta hover:bg-accent/90 transition-all duration-250 flex items-center justify-center gap-2">
                <span id="mobile-cta-text">Request Demo</span>
                <?php echo getIcon('ArrowRightIcon', 'w-5 h-5'); ?>
            </button>
        </div>
    </div>
</div>

<!-- Desktop Section Progress Indicator -->
<div id="section-indicator" class="hidden lg:block fixed right-6 top-1/2 -translate-y-1/2 z-[80] hidden">
    <div class="flex flex-col items-center gap-4">
        <?php
        $sections = [
            ['id' => 'hero', 'label' => 'Home'],
            ['id' => 'solutions', 'label' => 'Solutions'],
            ['id' => 'benefits', 'label' => 'Benefits'],
            ['id' => 'clients', 'label' => 'Clients'],
            ['id' => 'pricing', 'label' => 'Pricing'],
            ['id' => 'contact', 'label' => 'Contact']
        ];
        foreach ($sections as $section):
        ?>
        <button onclick="scrollToSection('<?php echo $section['id']; ?>')" class="group relative flex items-center" aria-label="Go to <?php echo $section['label']; ?>">
            <div id="indicator-dot-<?php echo $section['id']; ?>" class="indicator-dot w-3 h-3 rounded-full transition-all duration-300 bg-border hover:bg-primary/50 hover:scale-110"></div>
            <div class="absolute right-6 opacity-0 group-hover:opacity-100 transition-opacity duration-250 pointer-events-none">
                <div class="bg-card px-3 py-1.5 rounded-md shadow-card border border-border whitespace-nowrap">
                    <span class="font-body text-sm text-foreground font-medium">
                        <?php echo $section['label']; ?>
                    </span>
                </div>
            </div>
        </button>
        <?php endforeach; ?>
    </div>
</div>

<!-- Scroll To Top Button -->
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="scroll-to-top" class="fixed bottom-6 right-6 z-[80] w-12 h-12 md:w-14 md:h-14 bg-primary text-primary-foreground rounded-full shadow-cta hover:bg-primary/90 transition-all duration-250 flex items-center justify-center group hover:scale-110 hidden">
    <?php echo getIcon('ArrowUpIcon', 'w-6 h-6 group-hover:-translate-y-0.5 transition-transform duration-250'); ?>
</button>

<script>
// Floating Logic
window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    const hero = document.getElementById('hero');
    const heroHeight = hero ? hero.offsetHeight : 0;

    // WhatsApp Button
    // Show after 300px
    const whatsappBtn = document.getElementById('whatsapp-btn');
    if (scrollY > 300) {
        whatsappBtn.classList.remove('hidden');
    } else {
        whatsappBtn.classList.add('hidden');
    }

    // Mobile CTA Bar
    // Show after 50% of hero
    const mobileCta = document.getElementById('mobile-cta-bar');
    if(window.innerWidth < 768) {
        if (scrollY > heroHeight * 0.5) {
            mobileCta.classList.remove('hidden');
        } else {
            mobileCta.classList.add('hidden');
        }
    }

    // Scroll To Top
    // Show after hero
    const scrollBtn = document.getElementById('scroll-to-top');
    if (scrollY > heroHeight) {
        scrollBtn.classList.remove('hidden');
        // If scroll to top is visible, maybe move whatsapp button up?
        // But design has them overlapping z-index. Let's keep it simple.
    } else {
        scrollBtn.classList.add('hidden');
    }

    // Section Indicator & Mobile CTA Text Update
    const sections = ['hero', 'solutions', 'benefits', 'clients', 'pricing', 'contact'];
    const scrollPos = scrollY + window.innerHeight / 2;
    const scrollPosMob = scrollY + 100;

    let activeSection = '';
    
    // Desktop Indicator Logic
    if(window.innerWidth >= 1024) {
        const indicator = document.getElementById('section-indicator');
        if (scrollY > heroHeight * 0.3) {
            indicator.classList.remove('hidden');
        } else {
            indicator.classList.add('hidden');
        }
    }

    for (const sectionId of sections) {
        const element = document.getElementById(sectionId);
        if (element) {
            const offsetTop = element.offsetTop;
            const offsetHeight = element.offsetHeight;

            if (scrollPos >= offsetTop && scrollPos < offsetTop + offsetHeight) {
                // For desktop dots
                document.querySelectorAll('.indicator-dot').forEach(el => {
                    el.classList.remove('bg-primary', 'scale-125');
                    el.classList.add('bg-border');
                });
                const activeDot = document.getElementById('indicator-dot-' + sectionId);
                if(activeDot) {
                    activeDot.classList.remove('bg-border');
                    activeDot.classList.add('bg-primary', 'scale-125');
                }
            }

            // For Mobile CTA Text
            if (scrollPosMob >= offsetTop && scrollPosMob < offsetTop + offsetHeight) {
                const ctaText = document.getElementById('mobile-cta-text');
                if(ctaText) {
                    let text = 'Request Demo';
                    switch(sectionId) {
                        case 'hero': text = 'Request Demo'; break;
                        case 'solutions': text = 'Book Demo'; break;
                        case 'benefits': text = 'Get ROI Analysis'; break;
                        case 'clients': text = 'Request Demo'; break;
                        case 'pricing': text = 'Request Demo'; break;
                        case 'contact': text = 'Schedule Call'; break;
                    }
                    ctaText.innerText = text;
                }
            }
        }
    }
});

function openWhatsApp() {
    const phoneNumber = '94112345678';
    const message = encodeURIComponent("Hi, I'm interested in TimberPro ERP & POS System. I'd like to schedule a demo.");
    window.open(`https://wa.me/${phoneNumber}?text=${message}`, '_blank');
}
</script>
