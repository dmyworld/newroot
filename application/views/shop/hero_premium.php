<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden bg-slate-900 pt-20">
    <!-- Slider Container -->
    <div id="hero-slider" class="absolute inset-0 w-full h-full">
        <!-- Slide 1: Timber Marketplace -->
        <div class="slide absolute inset-0 transition-all duration-1000 opacity-100 scale-100 z-10" data-index="0">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-slate-900 to-green-900 opacity-80"></div>
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop')] bg-cover bg-center mix-blend-overlay"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col items-center justify-center text-center">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 mb-8 animate-fade-in-up">
                    <span class="flex h-2 w-2 rounded-full bg-success"></span>
                    <span class="text-white text-xs font-bold uppercase tracking-wider">Premium Timber Marketplace</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                    The Ultimate <span class="bg-gradient-to-r from-blue-400 to-green-400 bg-clip-text text-transparent">Lumber</span> Hub
                </h1>
                <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto mb-10 leading-relaxed">
                    Source verified logs, sawn timber, and standing crops directly from verified sawmills and growers across Sri Lanka.
                </p>
                <div class="flex gap-4">
                    <button onclick="switchTab('timber')" class="bg-blue-600 text-white font-black px-10 py-4 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20">Explore Listings</button>
                    <button onclick="switchTab('quotes')" class="bg-white/10 backdrop-blur-md text-white border border-white/20 font-black px-10 py-4 rounded-2xl hover:bg-white/20 transition-all">Request Quote</button>
                </div>
            </div>
        </div>

        <!-- Slide 2: Pros Marketplace -->
        <div class="slide absolute inset-0 transition-all duration-1000 opacity-0 scale-110 z-0" data-index="1">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-slate-900 to-blue-900 opacity-80"></div>
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1581578731522-7772659e99a8?auto=format&fit=crop&q=80&w=2000')] bg-cover bg-center mix-blend-overlay"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col items-center justify-center text-center">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 mb-8">
                    <span class="flex h-2 w-2 rounded-full bg-blue-500"></span>
                    <span class="text-white text-xs font-bold uppercase tracking-wider">Top-Tier Professionals</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                    Hire the <span class="bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">Best Pros</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                    From master carpenters to logistics experts. Find verified professionals to handle your timber projects with precision.
                </p>
                <div class="flex gap-4">
                    <button onclick="switchMacroTab('services')" class="bg-indigo-600 text-white font-black px-10 py-4 rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20">Find Experts</button>
                    <button onclick="window.location.href='<?= base_url('hub/register') ?>'" class="bg-white text-slate-900 font-black px-10 py-4 rounded-2xl hover:bg-slate-100 transition-all">Join as Pro</button>
                </div>
            </div>
        </div>

        <!-- Slide 3: Smart Tools -->
        <div class="slide absolute inset-0 transition-all duration-1000 opacity-0 scale-110 z-0" data-index="2">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 opacity-80"></div>
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1541888941259-792739460a3b?auto=format&fit=crop&q=80&w=2000')] bg-cover bg-center mix-blend-overlay"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col items-center justify-center text-center">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 mb-8">
                    <span class="flex h-2 w-2 rounded-full bg-amber-500"></span>
                    <span class="text-white text-xs font-bold uppercase tracking-wider">Integrated Smart Tools</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                    Precision <span class="bg-gradient-to-r from-amber-400 to-orange-400 bg-clip-text text-transparent">Calculations</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Use our industrial-grade calculator to estimate log volume, sawn yield, and project costs in seconds.
                </p>
                <div class="flex gap-4">
                    <a href="<?= base_url('shop/calculator') ?>" class="bg-amber-600 text-white font-black px-10 py-4 rounded-2xl hover:bg-amber-700 transition-all shadow-xl shadow-amber-500/20">Open Calculator</a>
                    <a href="<?= base_url('shop/track') ?>" class="bg-white/10 backdrop-blur-md text-white border border-white/20 font-black px-10 py-4 rounded-2xl hover:bg-white/20 transition-all">Track Order</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slider Controls -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex space-x-3 z-30">
        <button onclick="setSlide(0)" class="slider-dot w-3 h-3 rounded-full bg-white transition-all ring-offset-2 ring-transparent ring-4" data-index="0"></button>
        <button onclick="setSlide(1)" class="slider-dot w-3 h-3 rounded-full bg-white/30 transition-all ring-offset-2 ring-transparent ring-4" data-index="1"></button>
        <button onclick="setSlide(2)" class="slider-dot w-3 h-3 rounded-full bg-white/30 transition-all ring-offset-2 ring-transparent ring-4" data-index="2"></button>
    </div>
</section>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    
    function setSlide(index) {
        slides.forEach((s, i) => {
            if (i === index) {
                s.classList.add('opacity-100', 'scale-100', 'z-10');
                s.classList.remove('opacity-0', 'scale-110', 'z-0');
            } else {
                s.classList.remove('opacity-100', 'scale-100', 'z-10');
                s.classList.add('opacity-0', 'scale-110', 'z-0');
            }
        });
        
        dots.forEach((d, i) => {
            if (i === index) {
                d.classList.add('bg-white', 'scale-125');
                d.classList.remove('bg-white/30');
            } else {
                d.classList.remove('bg-white', 'scale-125');
                d.classList.add('bg-white/30');
            }
        });
        currentSlide = index;
    }

    function nextSlide() {
        let next = (currentSlide + 1) % slides.length;
        setSlide(next);
    }

    // Auto-play
    setInterval(nextSlide, 5000);
</script>

<style>
    .slider-dot.bg-white { @apply ring-blue-500/50; }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.8s ease forwards; }
</style>
