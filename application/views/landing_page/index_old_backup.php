<?php
$pageTitle = "Sri Lanka's Most Powerful Profit Protection ERP | TimberPro";
$metaDescription = "Stop losing money to theft, fraud & wastage. TimberPro ERP: 15 powerful modules + Premium Marketplace. Join 1000+ businesses protecting profits. Free trial.";
include 'includes/header.php';
?>
<?php include_once 'includes/icons.php'; ?>

<?php include 'includes/nav.php'; ?>

<main class="overflow-x-hidden">
    <!-- Enhanced Hero Section -->
    <section id="hero" class="min-h-screen bg-gradient-to-b from-[rgb(20,21,24)] via-[rgb(31,32,36)] to-[rgb(20,21,24)] text-white pt-32 pb-20 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-[#13ec5b] rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#13ec5b] rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <!-- Main Headline -->
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Stop Losing Money.<br>
                    <span class="text-[#13ec5b]">Start Building Your Empire.</span>
                </h1>
                
                <!-- Subheadline -->
                <p class="text-xl md:text-2xl text-gray-300 mb-4 max-w-4xl mx-auto leading-relaxed">
                    Sri Lanka's first <strong class="text-white">Profit Protection ERP</strong> designed to prevent stock loss, stop staff fraud, and connect you directly to premium buyers.
                </p>
                
                <!-- Fear Appeal -->
                <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-4 max-w-2xl mx-auto mb-8">
                    <p class="text-red-300 font-semibold">
                        ⚠️ Are you losing <span class="text-red-400 text-xl">LKR 50,000+</span> monthly to theft, wastage & fraud?
                    </p>
                </div>

                <!-- Primary CTAs -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="<?php echo base_url('hub/register_seller'); ?>" class="group px-10 py-5 bg-[#13ec5b] text-black font-bold text-xl rounded-lg shadow-2xl hover:bg-[#10d050] transition-all transform hover:scale-105 relative overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            REGISTER AS SELLER
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </a>
                    
                    <a href="<?php echo base_url('hub/register_buyer'); ?>" class="px-10 py-5 bg-transparent text-white font-bold text-xl rounded-lg border-2 border-white hover:bg-white hover:text-black transition-all transform hover:scale-105">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            REGISTER AS BUYER
                        </span>
                    </a>
                </div>

                <!-- Secondary Links -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center text-sm">
                    <a href="<?php echo base_url('hub/login'); ?>" class="text-gray-400 hover:text-white underline">
                        Already a member? Login to Hub →
                    </a>
                    <span class="hidden sm:inline text-gray-600">|</span>
                    <button onclick="scrollToSection('contact')" class="text-gray-400 hover:text-[#13ec5b] underline">
                        Request Free Demo
                    </button>
                </div>

                <!-- Social Proof -->
                <div class="mt-12 flex flex-col sm:flex-row gap-8 justify-center items-center text-center">
                    <div>
                        <div class="text-4xl font-bold text-[#13ec5b]">1,000+</div>
                        <div class="text-gray-400 text-sm">Active Businesses</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-[#13ec5b]">LKR 50M+</div>
                        <div class="text-gray-400 text-sm">Losses Prevented</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-[#13ec5b]">15</div>
                        <div class="text-gray-400 text-sm">Power Modules</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-[#13ec5b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <?php include 'includes/problem.php'; ?>
    <?php include 'includes/solution.php'; ?>
    <?php include 'includes/modules.php'; ?>
    <?php include 'includes/roi_calculator.php'; ?>
    <?php include 'includes/technical_authority.php'; ?>
    <?php include 'includes/demo.php'; ?>
    <?php include 'includes/comparison.php'; ?>
    <?php include 'includes/video_modal.php'; ?>
    <?php include 'includes/benefits.php'; ?>
    <?php include 'includes/clients.php'; ?>
    <?php include 'includes/pricing.php'; ?>
    <?php include 'includes/faq.php'; ?>
    <?php include 'includes/contact.php'; ?>
    <?php include 'includes/floating.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
