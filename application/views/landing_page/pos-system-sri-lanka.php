<?php
$pageTitle = "POS System Sri Lanka | Smart Billing & Stock Control";
$metaDescription = "Modern POS system in Sri Lanka with real‑time inventory, staff control & fraud detection. Ideal for retail, hardware & timber businesses.";
include 'includes/header.php';
include_once 'includes/icons.php';
include 'includes/nav.php';
?>

<main class="overflow-x-hidden">
    <section class="relative pt-32 pb-20 bg-gray-900 text-white overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-accent/20"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center lg:text-left">
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                POS System in Sri Lanka <br>
                <span class="text-primary-foreground">Smart Billing & Stock Control</span>
            </h1>
            <p class="font-body text-xl text-gray-300 mb-8 max-w-2xl">
                Faster checkout, zero fraud, and instant inventory updates. The POS system that staff love to use.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 lg:justify-start justify-center">
                <button onclick="scrollToSection('contact')" class="px-8 py-4 bg-primary text-primary-foreground font-cta font-bold rounded-xl shadow-lg hover:bg-primary/90 transition-all">
                    See POS Demo
                </button>
            </div>
        </div>
    </section>

    <!-- Specific Content Highlight for POS -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-100">
                    <img src="assets/images/pos-interface.jpg" alt="POS System Interface Sri Lanka" class="w-full h-auto">
                </div>
                <div>
                     <h2 class="font-headline text-3xl font-bold text-gray-900 mb-4">Why our POS is different?</h2>
                     <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <?php echo getIcon('CheckCircleIcon', 'w-6 h-6 text-success'); ?>
                            <span class="text-gray-600"><strong>Dopamine-Driven design</strong> to keep cashiers engaged.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <?php echo getIcon('CheckCircleIcon', 'w-6 h-6 text-success'); ?>
                            <span class="text-gray-600"><strong>Fraud Prevention</strong> features built-in (no unauthorized discounts).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <?php echo getIcon('CheckCircleIcon', 'w-6 h-6 text-success'); ?>
                            <span class="text-gray-600"><strong>Works Offline</strong> so you never miss a sale.</span>
                        </li>
                     </ul>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/solution.php'; ?>
    <?php include 'includes/benefits.php'; ?>
    <?php include 'includes/contact.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
