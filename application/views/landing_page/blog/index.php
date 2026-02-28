<?php
$pageTitle = "Business Intelligence Blog | TimberPro Sri Lanka";
$metaDescription = "Expert advice on preventing stock loss, managing timber yards, and growing retail profits in Sri Lanka.";
$basePath = '../';
include '../includes/header.php';
include_once '../includes/icons.php';
// Custom Nav for Blog? Or just use main nav with path adjustment?
// Main nav likely has relative links too. I might need a specific nav for blog or update main nav.
// For now, let's include nav but I might need to fix links in nav.php too.
// I'll skip nav include and just put a simple "Back to Home" for now or fix Nav.
// Fixing Nav is better.
include '../includes/nav.php'; 
?>

<main class="overflow-x-hidden pt-24 pb-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="font-headline text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Profit Protection Journal</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Insights for Sri Lankan Business Owners on Growth, Security, and Efficiency.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Article 1 -->
            <a href="how-businesses-lose-profit.php" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                    <div class="absolute inset-0 bg-red-900/10 group-hover:bg-transparent transition-all"></div>
                    <!-- Placeholder Image -->
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <?php echo getIcon('ChartBarIcon', 'w-12 h-12'); ?>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-red-600 uppercase tracking-wide">Profit Leak</span>
                    <h2 class="font-headline text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">How Sri Lankan Businesses Lose 30% Profit Without Knowing</h2>
                    <p class="text-sm text-gray-600 line-clamp-3">Hidden stock loss, staff fraud, and poor inventory control are silent killers. Learn how to stop them.</p>
                    <div class="mt-4 flex items-center text-primary font-semibold text-sm">
                        Read Article <?php echo getIcon('ArrowRightIcon', 'w-4 h-4 ml-1'); ?>
                    </div>
                </div>
            </a>

            <!-- Article 2 -->
            <a href="best-erp-sri-lanka-guide.php" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                     <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <?php echo getIcon('ComputerDesktopIcon', 'w-12 h-12'); ?>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wide">Buyer's Guide</span>
                    <h2 class="font-headline text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">Best ERP System in Sri Lanka – Complete Buyer’s Guide</h2>
                    <p class="text-sm text-gray-600 line-clamp-3">What to look for, what to avoid, and how to choose the right software for your business.</p>
                    <div class="mt-4 flex items-center text-primary font-semibold text-sm">
                        Read Article <?php echo getIcon('ArrowRightIcon', 'w-4 h-4 ml-1'); ?>
                    </div>
                </div>
            </a>

             <!-- Article 3 -->
            <a href="pos-vs-erp.php" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                     <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <?php echo getIcon('ScaleIcon', 'w-12 h-12'); ?>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wide">Comparison</span>
                    <h2 class="font-headline text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">POS vs ERP – What Business Owners Must Know</h2>
                    <p class="text-sm text-gray-600 line-clamp-3">Billing software is not enough. Discover why successful businesses move from POS to ERP.</p>
                    <div class="mt-4 flex items-center text-primary font-semibold text-sm">
                        Read Article <?php echo getIcon('ArrowRightIcon', 'w-4 h-4 ml-1'); ?>
                    </div>
                </div>
            </a>
            
             <!-- Article 4 -->
            <a href="prevent-stock-theft-hardware.php" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                     <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <?php echo getIcon('ShieldCheckIcon', 'w-12 h-12'); ?>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-red-600 uppercase tracking-wide">Security</span>
                    <h2 class="font-headline text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">How to Prevent Stock Theft in Hardware Stores</h2>
                    <p class="text-sm text-gray-600 line-clamp-3">Practical tips to stop pilferage of small items and ensure inventory accuracy.</p>
                    <div class="mt-4 flex items-center text-primary font-semibold text-sm">
                        Read Article <?php echo getIcon('ArrowRightIcon', 'w-4 h-4 ml-1'); ?>
                    </div>
                </div>
            </a>
            
             <!-- Article 5 -->
            <a href="timber-business-erp.php" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                     <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <?php echo getIcon('TreeIcon', 'w-12 h-12'); ?>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Industry Focus</span>
                    <h2 class="font-headline text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">Timber Business Management Software – Why You Need ERP</h2>
                    <p class="text-sm text-gray-600 line-clamp-3">Managing CBM, Linear Feet, and waste. Why general software doesn't work for timber.</p>
                     <div class="mt-4 flex items-center text-primary font-semibold text-sm">
                        Read Article <?php echo getIcon('ArrowRightIcon', 'w-4 h-4 ml-1'); ?>
                    </div>
                </div>
            </a>
             <!-- And more... placeholders for now to keep file size manageable -->
        </div>
    </div>
</main>

<!-- Simple Footer for Blog to avoid relative path issues in main footer for now, or just include main footer -->
<?php include '../includes/footer.php'; ?>
