<?php
$pageTitle = "Best ERP System in Sri Lanka for Business Owners | TimberPro";
$metaDescription = "Looking for the best ERP system in Sri Lanka? TimberPro ERP offers billing, stock, fraud prevention & profit protection. Free demo available.";
include 'includes/header.php';
include_once 'includes/icons.php';
include 'includes/nav.php';
?>

<main class="overflow-x-hidden">
    <!-- SEO Hero Section -->
    <section class="relative pt-32 pb-20 bg-gray-900 text-white overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-primary/20"></div>
            <!-- Glass Orbs -->
            <div class="absolute top-20 right-20 w-96 h-96 bg-primary/20 rounded-full blur-3xl mix-blend-screen opacity-50"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center lg:text-left">
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Best ERP System in Sri Lanka <br>
                <span class="text-accent">for Business Owners</span>
            </h1>
            <p class="font-body text-xl text-gray-300 mb-8 max-w-2xl">
                The only ERP system in Sri Lanka that combines POS, Inventory, and Profit Protection into one simple platform.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 lg:justify-start justify-center">
                <button onclick="scrollToSection('contact')" class="px-8 py-4 bg-accent text-accent-foreground font-cta font-bold rounded-xl shadow-lg hover:bg-accent/90 transition-all">
                    Get Free Demo
                </button>
            </div>
        </div>
    </section>

    <?php include 'includes/problem.php'; ?>
    <?php include 'includes/solution.php'; ?>
    <?php include 'includes/technical_authority.php'; ?>
    <?php include 'includes/comparison.php'; ?>
    <?php include 'includes/pricing.php'; ?>
    <?php include 'includes/faq.php'; ?>
    <?php include 'includes/contact.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
