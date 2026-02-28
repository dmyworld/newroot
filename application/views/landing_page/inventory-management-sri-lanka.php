<?php
$pageTitle = "Inventory Management System Sri Lanka | Prevent Stock Loss";
$metaDescription = "Powerful inventory management system in Sri Lanka to prevent stock theft, mismatch & dead stock. Book free demo today.";
include 'includes/header.php';
include_once 'includes/icons.php';
include 'includes/nav.php';
?>

<main class="overflow-x-hidden">
    <section class="relative pt-32 pb-20 bg-gray-900 text-white overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-blue-900/40"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center lg:text-left">
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Inventory Management System <br>
                <span class="text-blue-400">in Sri Lanka</span>
            </h1>
            <p class="font-body text-xl text-gray-300 mb-8 max-w-2xl">
                Stop losing money to "Dead Stock" and theft. Get 100% visibility over your warehouse and multiple branches.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 lg:justify-start justify-center">
                <button onclick="scrollToSection('contact')" class="px-8 py-4 bg-blue-600 text-white font-cta font-bold rounded-xl shadow-lg hover:bg-blue-700 transition-all">
                    Audit Your Stock
                </button>
            </div>
        </div>
    </section>

    <?php include 'includes/problem.php'; ?>
    
    <!-- Specific Content for Inventory -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-headline text-3xl font-bold text-gray-900 mb-4">Advanced Stock Control Features</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 text-blue-600">
                        <?php echo getIcon('CubeIcon', 'w-6 h-6'); ?>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Batch & Lot Tracking</h3>
                    <p class="text-gray-600 text-sm">Trace every item back to its source. Perfect for hardware and timber.</p>
                </div>
                 <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 text-blue-600">
                        <?php echo getIcon('BellAlertIcon', 'w-6 h-6'); ?>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Low Stock Alerts</h3>
                    <p class="text-gray-600 text-sm">Never run out of best-sellers. Get notified before you hit zero.</p>
                </div>
                 <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 text-blue-600">
                        <?php echo getIcon('ArrowPathIcon', 'w-6 h-6'); ?>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Multi-Location Sync</h3>
                    <p class="text-gray-600 text-sm">Manage warehouses and shops in one system real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/solution.php'; ?>
    <?php include 'includes/contact.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
