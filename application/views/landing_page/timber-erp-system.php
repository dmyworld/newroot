<?php
$pageTitle = "Timber ERP System | Wood Industry Business Software Sri Lanka";
$metaDescription = "Complete ERP solution for timber yards & wood businesses. Stock, billing, fraud control & multi‑branch management.";
include 'includes/header.php';
include_once 'includes/icons.php';
include 'includes/nav.php';
?>

<main class="overflow-x-hidden">
    <section class="relative pt-32 pb-20 bg-gray-900 text-white overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-black"></div>
            <!-- Wood Texture overlay opacity could go here -->
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full mb-6 backdrop-blur-sm">
                 <?php echo getIcon('TreeIcon', 'w-5 h-5 text-green-400 tree-icon'); ?> <!-- Assuming TreeIcon exists or similar -->
                 <span class="text-green-300 text-sm font-semibold tracking-wide uppercase">Built for Sawmills & Timber Yards</span>
            </div>
            <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Timber ERP System <br>
                <span class="text-green-500">in Sri Lanka</span>
            </h1>
            <p class="font-body text-xl text-gray-300 mb-8 max-w-2xl">
                calculate Board Feet (BF) automatically. Manage sawing, planing, and treatment costs. The only software that speaks "Timber".
            </p>
            <div class="flex flex-col sm:flex-row gap-4 lg:justify-start justify-center">
                <button onclick="scrollToSection('contact')" class="px-8 py-4 bg-green-600 text-white font-cta font-bold rounded-xl shadow-lg hover:bg-green-700 transition-all">
                    Get Timber Demo
                </button>
            </div>
        </div>
    </section>

    <!-- Specific Timber Features -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                     <h2 class="font-headline text-3xl font-bold text-gray-900 mb-6">Why General ERPs Fail in Timber?</h2>
                     <p class="text-gray-600 mb-6">
                         Standard software doesn't understand that a log enters in Cubic Meters and leaves in Linear Feet. We do.
                     </p>
                     <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xs">1</span>
                            <span class="text-gray-700"><strong>Unit Conversion Engine:</strong> Auto-convert Logs (CBM) -> Sawn Timber (SqFt/LinFt).</span>
                        </li>
                        <li class="flex items-start gap-3">
                             <span class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xs">2</span>
                            <span class="text-gray-700"><strong>Off-Cut Management:</strong> Track waste and turn "firewood" into profit.</span>
                        </li>
                        <li class="flex items-start gap-3">
                             <span class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xs">3</span>
                            <span class="text-gray-700"><strong>Species Grading:</strong> Separate Teak, Mahogany, and Jack prices automatically.</span>
                        </li>
                     </ul>
                </div>
                 <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-100">
                    <img src="assets/images/hero-dashboard.png" alt="Timber ERP Interface" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/solution.php'; ?>
    <?php include 'includes/benefits.php'; ?>
    <?php include 'includes/contact.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
