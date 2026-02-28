<?php include 'includes/header.php'; ?>
<?php include_once 'includes/icons.php'; ?>
<?php include 'includes/nav.php'; ?>

<?php
$features = [
    [
        'id' => 'dashboard',
        'title' => 'Unified Dashboard',
        'subtitle' => 'Real-Time Business Intelligence',
        'description' => 'Get a complete overview of your timber operation with our powerful analytics dashboard. Monitor inventory levels, track sales performance, analyze supplier metrics, and view profit margins—all in real-time from a single, intuitive interface.',
        'icon' => 'ChartPieIcon',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_1608da274-1764671261525.png',
        'alt' => 'Modern business analytics dashboard displaying colorful charts, graphs, and key performance indicators on computer screen',
        'capabilities' => [
            [
                'title' => 'Live Inventory Tracking',
                'description' => 'Monitor stock levels across all locations with automatic updates and low-stock alerts',
                'icon' => 'CubeIcon',
            ],
            [
                'title' => 'Sales Analytics',
                'description' => 'Track revenue, identify trends, and analyze customer purchasing patterns',
                'icon' => 'ChartBarIcon',
            ],
            [
                'title' => 'Supplier Performance',
                'description' => 'Evaluate supplier reliability, delivery times, and quality metrics',
                'icon' => 'TruckIcon',
            ],
            [
                'title' => 'Profit Margin Analysis',
                'description' => 'Calculate margins by product, category, or supplier with real-time updates',
                'icon' => 'CurrencyDollarIcon',
            ],
        ],
        'benefits' => [
            'Make data-driven decisions with real-time insights',
            'Identify profitable products and optimize inventory',
            'Spot trends before they become problems',
            'Reduce time spent on manual reporting by 80%',
        ],
    ],
    [
        'id' => 'inventory',
        'title' => 'Inventory Management',
        'subtitle' => 'Real-Time Monitoring & Stock Level Management',
        'description' => 'Monitor your timber inventory in real-time with our advanced alert dashboard. Get instant notifications for low stock, track inventory movements across locations, and maintain optimal stock levels with automated reorder alerts. Our intelligent system prevents stockouts while minimizing excess inventory costs.',
        'icon' => 'CubeIcon',
        'image' => 'assets/images/Real-time_monitoring_and_stock_level_management-1767527180530.jpg',
        'alt' => 'Real-time inventory monitoring dashboard showing stock level alerts, low stock warnings, and automated reorder notifications for timber management',
        'capabilities' => [
            [
                'title' => 'Real-Time Stock Monitoring',
                'description' => 'Live dashboard displaying current stock levels with color-coded alerts for critical, low, and optimal inventory',
                'icon' => 'ChartBarIcon',
            ],
            [
                'title' => 'Automated Alert System',
                'description' => 'Instant notifications via dashboard, email, or SMS when stock reaches critical thresholds',
                'icon' => 'BellAlertIcon',
            ],
            [
                'title' => 'Multi-Location Tracking',
                'description' => 'Monitor inventory across warehouses, yards, and retail locations from a single interface',
                'icon' => 'MapPinIcon',
            ],
            [
                'title' => 'Smart Reorder Points',
                'description' => 'AI-powered recommendations for reorder quantities based on sales velocity and lead times',
                'icon' => 'ArrowPathIcon',
            ],
        ],
        'benefits' => [
            'Prevent stockouts with proactive low-stock alerts',
            'Reduce excess inventory carrying costs by 35%',
            'Make informed purchasing decisions with real-time data',
            'Eliminate manual stock checks saving 15+ hours weekly',
        ],
    ],
    [
        'id' => 'pos',
        'title' => 'Point of Sale System',
        'subtitle' => 'Integrated Sales & Inventory Sync',
        'description' => 'Process sales seamlessly with our integrated POS system designed specifically for timber operations. Every transaction automatically updates inventory, generates receipts, and syncs with your accounting—eliminating manual data entry and reducing errors.',
        'icon' => 'ShoppingCartIcon',
        'image' => 'assets/images/bandicam_2026-01-04_10-17-45-974-1767502259829.jpg',
        'alt' => 'TimberPro POS interface showing point-of-sale system with timber inventory management and sales processing',
        'capabilities' => [
            [
                'title' => 'Real-Time Sales Processing',
                'description' => 'Fast checkout with barcode scanning, custom pricing, and multiple payment methods',
                'icon' => 'BoltIcon',
            ],
            [
                'title' => 'Inventory Sync',
                'description' => 'Automatic stock deduction and real-time availability updates across all channels',
                'icon' => 'ArrowsRightLeftIcon',
            ],
            [
                'title' => 'Customer Management',
                'description' => 'Track customer history, preferences, and credit accounts in one place',
                'icon' => 'UserGroupIcon',
            ],
            [
                'title' => 'Receipt Generation',
                'description' => 'Professional invoices with company branding, tax calculations, and digital delivery',
                'icon' => 'DocumentTextIcon',
            ],
        ],
        'benefits' => [
            'Process sales 60% faster than manual systems',
            'Eliminate inventory discrepancies from manual entry',
            'Build customer loyalty with purchase history tracking',
            'Accept multiple payment methods including credit terms',
        ],
    ],
    [
        'id' => 'suppliers',
        'title' => 'Supplier Tracking',
        'subtitle' => 'Manage Local & International Relationships',
        'description' => 'Streamline supplier management with comprehensive tracking for both local Sri Lankan suppliers and international importers. Manage orders, track deliveries, monitor payment schedules, and evaluate performance—all from one centralized system.',
        'icon' => 'TruckIcon',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_152d0c62e-1766861073063.png',
        'alt' => 'Business professionals shaking hands in timber warehouse with stacked wood materials in background',
        'capabilities' => [
            [
                'title' => 'Supplier Database',
                'description' => 'Centralized records with contact info, pricing, terms, and performance history',
                'icon' => 'BuildingOfficeIcon',
            ],
            [
                'title' => 'Order Management',
                'description' => 'Create, track, and manage purchase orders with delivery scheduling',
                'icon' => 'ClipboardDocumentListIcon',
            ],
            [
                'title' => 'Payment Tracking',
                'description' => 'Monitor outstanding payments, credit terms, and payment history',
                'icon' => 'BanknotesIcon',
            ],
            [
                'title' => 'Performance Metrics',
                'description' => 'Evaluate suppliers on delivery time, quality, pricing, and reliability',
                'icon' => 'ChartBarSquareIcon',
            ],
        ],
        'benefits' => [
            'Negotiate better terms with data-backed insights',
            'Reduce late deliveries by 50% with proactive tracking',
            'Identify the most reliable and cost-effective suppliers',
            'Streamline import documentation and customs processes',
        ],
    ],
    [
        'id' => 'compliance',
        'title' => 'Compliance Reporting',
        'subtitle' => 'Automated Regulatory & Business Reports',
        'description' => 'Stay compliant with Sri Lankan timber regulations and generate business insights automatically. Our system creates audit-ready reports, tracks export documentation, maintains compliance records, and provides complete audit trails for regulatory requirements.',
        'icon' => 'DocumentChartBarIcon',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_10d14e6df-1765560034581.png',
        'alt' => 'Professional business reports and financial documents with charts and graphs spread on desk',
        'capabilities' => [
            [
                'title' => 'Automated Reports',
                'description' => 'Generate financial, inventory, and compliance reports with one click',
                'icon' => 'DocumentDuplicateIcon',
            ],
            [
                'title' => 'Compliance Tracking',
                'description' => 'Monitor adherence to timber regulations, permits, and certifications',
                'icon' => 'ClipboardDocumentCheckIcon',
            ],
            [
                'title' => 'Export Documentation',
                'description' => 'Prepare customs forms, shipping documents, and certificates of origin',
                'icon' => 'GlobeAltIcon',
            ],
            [
                'title' => 'Audit Trails',
                'description' => 'Complete transaction history with timestamps, user actions, and change logs',
                'icon' => 'FingerPrintIcon',
            ],
        ],
        'benefits' => [
            'Ensure 100% regulatory compliance automatically',
            'Reduce report preparation time from days to minutes',
            'Pass audits with confidence using complete documentation',
            'Avoid penalties with proactive compliance monitoring',
        ],
    ],
];
?>

<div class="min-h-screen bg-background">
    <!-- Hero Section -->
    <section class="pt-32 pb-16 bg-gradient-to-br from-primary/5 via-background to-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-6">
                    <?php echo getIcon('SparklesIcon', 'w-5 h-5 text-primary'); ?>
                    <span class="font-body text-sm font-medium text-primary">Complete Feature Suite</span>
                </div>
                <h1 class="font-headline text-4xl sm:text-5xl lg:text-6xl font-bold text-foreground mb-6">
                    Everything You Need to Run Your Timber Business
                </h1>
                <p class="font-body text-xl text-muted-foreground mb-8">
                    TimberPro ERP provides five powerful modules that work together seamlessly to transform your timber operations. From real-time analytics to regulatory compliance, we've built everything specifically for Sri Lankan timber businesses.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <button onclick="scrollToSection('contact')" class="px-8 py-4 bg-accent text-accent-foreground font-cta font-bold text-lg rounded-lg shadow-cta hover:bg-accent/90 transition-all duration-250">
                        Request Demo
                    </button>
                    <button onclick="scrollToSection('pricing')" class="px-8 py-4 bg-card text-foreground font-body font-semibold text-lg rounded-lg border-2 border-border hover:border-primary transition-all duration-250">
                        View Pricing
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Device Mockups Section -->
            <div class="mb-32">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-6">
                        <?php echo getIcon('DevicePhoneMobileIcon', 'w-5 h-5 text-primary'); ?>
                        <span class="font-body text-sm font-medium text-primary">Cross-Platform Experience</span>
                    </div>
                    <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4">
                        Access Anywhere, On Any Device
                    </h2>
                    <p class="font-body text-lg text-muted-foreground">
                        TimberPro works seamlessly across desktop, laptop, and mobile devices. Manage your timber business from the office, warehouse, or on the go.
                    </p>
                </div>

                <!-- Desktop Mockup -->
                <div class="mb-20">
                    <div class="relative max-w-6xl mx-auto">
                        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-t-2xl p-3 shadow-2xl">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="bg-white rounded-lg overflow-hidden shadow-inner">
                                <img src="assets/images/login_page-1767529165751.jpg" alt="TimberPro secure login page displayed on desktop computer showing modern authentication interface with email and password fields" class="w-full h-auto">
                            </div>
                        </div>
                        <div class="h-6 bg-gradient-to-b from-gray-700 to-gray-800 rounded-b-2xl shadow-xl"></div>
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-48 h-2 bg-gray-600 rounded-full"></div>
                    </div>
                    <div class="text-center mt-8">
                        <h3 class="font-headline text-2xl font-bold text-foreground mb-2">Desktop Experience</h3>
                        <p class="font-body text-muted-foreground">Full-featured dashboard with comprehensive analytics and multi-tasking capabilities</p>
                    </div>
                </div>

                <!-- Laptop & Mobile Grid -->
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Laptop Mockup -->
                    <div>
                        <div class="relative">
                            <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-t-xl p-2 shadow-2xl">
                                <div class="bg-white rounded-lg overflow-hidden shadow-inner">
                                    <img src="assets/images/login_page-1767529165751.jpg" alt="TimberPro login interface on laptop showing portable secure access for timber business management" class="w-full h-auto">
                                </div>
                            </div>
                            <div class="h-3 bg-gradient-to-b from-gray-600 to-gray-700 rounded-b-xl"></div>
                            <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-32 h-1 bg-gray-500 rounded-full"></div>
                        </div>
                        <div class="mt-8">
                            <h3 class="font-headline text-xl font-bold text-foreground mb-2">Laptop Flexibility</h3>
                            <p class="font-body text-sm text-muted-foreground">Work from anywhere with full functionality on your portable device</p>
                        </div>
                    </div>

                    <!-- Mobile Mockup -->
                    <div class="flex justify-center">
                        <div>
                            <div class="relative w-[280px] mx-auto">
                                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-[2.5rem] p-3 shadow-2xl">
                                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-900 rounded-b-2xl"></div>
                                    <div class="bg-white rounded-[2rem] overflow-hidden shadow-inner">
                                        <img src="assets/images/login_page-1767529165751.jpg" alt="TimberPro mobile login screen showing responsive authentication interface on smartphone for on-the-go access" class="w-full h-auto">
                                    </div>
                                </div>
                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-16 h-1 bg-gray-600 rounded-full"></div>
                            </div>
                            <div class="mt-8 text-center">
                                <h3 class="font-headline text-xl font-bold text-foreground mb-2">Mobile Access</h3>
                                <p class="font-body text-sm text-muted-foreground">Check inventory, process sales, and monitor operations on the go</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature Highlights -->
                <div class="mt-16 grid sm:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <?php echo getIcon('ArrowsRightLeftIcon', 'w-8 h-8 text-primary'); ?>
                        </div>
                        <h4 class="font-body text-lg font-semibold text-foreground mb-2">Seamless Sync</h4>
                        <p class="font-body text-sm text-muted-foreground">Real-time data synchronization across all your devices</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <?php echo getIcon('ShieldCheckIcon', 'w-8 h-8 text-primary'); ?>
                        </div>
                        <h4 class="font-body text-lg font-semibold text-foreground mb-2">Secure Access</h4>
                        <p class="font-body text-sm text-muted-foreground">Enterprise-grade security on every platform</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <?php echo getIcon('BoltIcon', 'w-8 h-8 text-primary'); ?>
                        </div>
                        <h4 class="font-body text-lg font-semibold text-foreground mb-2">Lightning Fast</h4>
                        <p class="font-body text-sm text-muted-foreground">Optimized performance for instant response times</p>
                    </div>
                </div>
            </div>

            <div class="space-y-24">
                <?php foreach ($features as $index => $feature): ?>
                <div id="<?php echo $feature['id']; ?>" class="grid lg:grid-cols-2 gap-12 items-center <?php echo $index % 2 === 1 ? 'lg:flex-row-reverse' : ''; ?>">
                    <!-- Content -->
                    <div class="<?php echo $index % 2 === 1 ? 'lg:order-2' : ''; ?>">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center">
                                <?php echo getIcon($feature['icon'], 'w-7 h-7 text-primary'); ?>
                            </div>
                            <div>
                                <h2 class="font-headline text-3xl sm:text-4xl font-bold text-foreground">
                                    <?php echo $feature['title']; ?>
                                </h2>
                                <p class="font-body text-sm text-primary font-medium"><?php echo $feature['subtitle']; ?></p>
                            </div>
                        </div>

                        <p class="font-body text-lg text-muted-foreground mb-8"><?php echo $feature['description']; ?></p>

                        <!-- Capabilities -->
                        <div class="space-y-4 mb-8">
                            <h3 class="font-body text-xl font-semibold text-foreground mb-4">Key Capabilities</h3>
                            <?php foreach ($feature['capabilities'] as $capability): ?>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <?php echo getIcon($capability['icon'], 'w-5 h-5 text-primary'); ?>
                                </div>
                                <div>
                                    <h4 class="font-body text-base font-semibold text-foreground mb-1">
                                        <?php echo $capability['title']; ?>
                                    </h4>
                                    <p class="font-body text-sm text-muted-foreground"><?php echo $capability['description']; ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Benefits -->
                        <div class="bg-success/5 border border-success/20 rounded-xl p-6">
                            <h3 class="font-body text-lg font-semibold text-foreground mb-4 flex items-center gap-2">
                                <?php echo getIcon('CheckBadgeIcon', 'w-6 h-6 text-success'); ?>
                                Business Benefits
                            </h3>
                            <ul class="space-y-2">
                                <?php foreach ($feature['benefits'] as $benefit): ?>
                                <li class="flex items-start gap-2">
                                    <?php echo getIcon('CheckCircleIcon', 'w-5 h-5 text-success flex-shrink-0 mt-0.5'); ?>
                                    <span class="font-body text-sm text-foreground"><?php echo $benefit; ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="<?php echo $index % 2 === 1 ? 'lg:order-1' : ''; ?>">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-border">
                            <img src="<?php echo $feature['image']; ?>" alt="<?php echo $feature['alt']; ?>" class="w-full h-auto">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-transparent"></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-primary to-primary/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-headline text-3xl sm:text-4xl font-bold text-primary-foreground mb-4">
                Ready to Transform Your Timber Business?
            </h2>
            <p class="font-body text-lg text-primary-foreground/90 mb-8">
                See all these features in action with a personalized demo tailored to your business needs.
            </p>
            <button onclick="scrollToSection('contact')" class="inline-block px-8 py-4 bg-accent text-accent-foreground font-cta font-bold text-lg rounded-lg shadow-cta hover:bg-accent/90 transition-all duration-250">
                Schedule Your Demo Today
            </button>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/floating.php'; ?>
