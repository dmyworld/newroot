<?php
$pageTitle = "ERP Software Price in Sri Lanka | TimberPro ERP";
$metaDescription = "Affordable ERP software price in Sri Lanka. Setup Rs 150,000. Monthly Rs 15,000. Free demo available.";
include 'includes/header.php';
include_once 'includes/icons.php';
include 'includes/nav.php';
?>

<main class="overflow-x-hidden">
    <section class="relative pt-32 pb-20 bg-gray-900 text-white overflow-hidden">
        <div class="absolute inset-0 z-0">
             <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Transparent ERP Pricing <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-warning">No Hidden Fees.</span>
            </h1>
            <p class="font-body text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                We believe in simple, flat-rate pricing. You get the full "Command Center" from Day 1.
            </p>
        </div>
    </section>

    <?php include 'includes/pricing.php'; ?>
    
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-headline text-3xl font-bold text-gray-900 mb-6">Return on Investment (ROI) Calculator</h2>
            <p class="text-gray-600 mb-8">If TimberPro saves you just <strong>1 log per month</strong> from theft, it creates a 100% ROI.</p>
            
            <div class="bg-green-50 p-8 rounded-2xl border border-green-100">
                <div class="grid grid-cols-2 gap-4 text-left">
                    <div>
                        <div class="text-sm text-gray-500">Average Monthly Loss (Theft/Errors)</div>
                        <div class="font-bold text-2xl text-red-500">Rs. 150,000+</div>
                    </div>
                     <div>
                        <div class="text-sm text-gray-500">TimberPro Monthly Cost</div>
                        <div class="font-bold text-2xl text-green-600">Rs. 15,000</div>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-green-200">
                    <div class="font-bold text-xl text-gray-800">Net Monthly Savings: <span class="text-green-600">Rs. 135,000</span></div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/faq.php'; ?>
    <?php include 'includes/contact.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
