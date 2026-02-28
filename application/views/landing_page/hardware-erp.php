<?php
$pageTitle = "Hardware Store ERP System Sri Lanka | POS + Inventory";
$metaDescription = "ERP system for hardware stores with POS, stock control, fraud alerts & profit dashboards. Perfect for multi‑branch operations.";
include 'includes/header.php';
include_once 'includes/icons.php';
include 'includes/nav.php';
?>

<main class="overflow-x-hidden">
    <section class="relative pt-32 pb-20 bg-gray-900 text-white overflow-hidden">
        <div class="absolute inset-0 z-0">
             <div class="absolute inset-0 bg-gradient-to-r from-orange-900/80 to-black"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center lg:text-left">
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Hardware Store ERP System <br>
                <span class="text-orange-500">Sri Lanka</span>
            </h1>
            <p class="font-body text-xl text-gray-300 mb-8 max-w-2xl">
                Handle 50,000+ SKUs with ease. From cement bags to tiny screws, track every item and prevent pilferage.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 lg:justify-start justify-center">
                <button onclick="scrollToSection('contact')" class="px-8 py-4 bg-orange-600 text-white font-cta font-bold rounded-xl shadow-lg hover:bg-orange-700 transition-all">
                    View Hardware Demo
                </button>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
             <div class="grid md:grid-cols-3 gap-8 text-center">
                 <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                     <div class="text-orange-600 mb-4 flex justify-center"><?php echo getIcon('TagIcon', 'w-10 h-10'); ?></div>
                     <h3 class="font-bold text-xl mb-2">Barcode & Label Printing</h3>
                     <p class="text-gray-600">Print shelf-edge labels and sticky barcodes directly from the system.</p>
                 </div>
                 <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                     <div class="text-orange-600 mb-4 flex justify-center"><?php echo getIcon('TruckIcon', 'w-10 h-10'); ?></div>
                     <h3 class="font-bold text-xl mb-2">Supplier Management</h3>
                     <p class="text-gray-600">Track credit periods, returns, and best prices from multiple hardware suppliers.</p>
                 </div>
                 <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                     <div class="text-orange-600 mb-4 flex justify-center"><?php echo getIcon('CurrencyRupeeIcon', 'w-10 h-10'); ?></div>
                     <h3 class="font-bold text-xl mb-2">Credit Sales Tracking</h3>
                     <p class="text-gray-600">Manage contractor credit lines and collect payments on time with SMS reminders.</p>
                 </div>
             </div>
        </div>
    </section>

    <?php include 'includes/problem.php'; ?>
    <?php include 'includes/solution.php'; ?>
    <?php include 'includes/contact.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
