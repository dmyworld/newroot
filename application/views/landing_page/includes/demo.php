<?php
$demoScreens = [
    [
        'id' => 'dashboard',
        'title' => 'Main Dashboard Interface',
        'description' => 'Real-time overview of your entire timber operation at a glance',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_1608da274-1764671261525.png',
        'alt' => 'Modern business analytics dashboard',
        'highlights' => ['Live inventory levels across all locations', 'Sales performance metrics', 'Profit margins by species', 'Supplier performance tracking']
    ],
    [
        'id' => 'pos',
        'title' => 'POS Transaction Screen',
        'description' => 'Fast and accurate point-of-sale for timber businesses',
        'image' => 'assets/images/bandicam_2026-01-04_10-17-45-974-1767502259829.jpg',
        'alt' => 'TimberPro POS interface',
        'highlights' => ['Volume-based pricing calculations', 'Custom cutting specifications', 'Customer discount management', 'Instant receipt generation']
    ],
    [
        'id' => 'inventory',
        'title' => 'Inventory Management View',
        'description' => 'Comprehensive stock control with species-specific tracking',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_12ce4ac9b-1764658762607.png',
        'alt' => 'Warehouse inventory management system',
        'highlights' => ['Track by species, grade, and size', 'Batch and lot management', 'Low stock alerts', 'Multi-location visibility']
    ],
    [
        'id' => 'account',
        'title' => 'Account Statement',
        'description' => 'Detailed customer transaction history and financial records',
        'image' => 'assets/images/Account_Statement-1768587078259.jpg',
        'alt' => 'TimberPro account statement interface',
        'highlights' => ['Complete transaction history', 'Credit limit tracking', 'Payment status monitoring', 'Aging analysis reports']
    ],
    [
        'id' => 'reporting',
        'title' => 'Reporting Dashboard',
        'description' => 'Comprehensive business intelligence and compliance reports',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_10d14e6df-1765560034581.png',
        'alt' => 'Professional business reports',
        'highlights' => ['Profit analysis by product', 'Stock aging reports', 'VAT/GST compliance', 'Custom report builder']
    ]
];
?>
<section class="py-16 lg:py-24 bg-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-6">
                <?php echo getIcon('ComputerDesktopIcon', 'w-5 h-5 text-primary'); ?>
                <span class="font-body text-sm font-medium text-primary">Live System Demo</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4">
                See TimberPro ERP in Action
            </h2>
            <p class="font-body text-lg text-muted-foreground max-w-3xl mx-auto">
                Explore our intuitive interface designed specifically for timber businesses in Sri Lanka.
            </p>
        </div>

        <div class="bg-card rounded-2xl overflow-hidden shadow-xl border border-border mb-8">
            <div class="relative">
                <div class="aspect-video bg-gradient-to-br from-primary/5 to-accent/5">
                    <?php foreach ($demoScreens as $index => $screen): ?>
                    <img id="demo-img-<?php echo $index; ?>" src="<?php echo $screen['image']; ?>" alt="<?php echo $screen['alt']; ?>" class="demo-img w-full h-full object-contain <?php echo $index === 0 ? '' : 'hidden'; ?>">
                    <?php endforeach; ?>
                </div>

                <div class="absolute top-4 right-4 flex gap-2">
                    <button onclick="toggleDemoAutoplay()" class="px-4 py-2 bg-card/90 backdrop-blur-sm rounded-lg border border-border hover:bg-card transition-all duration-250 flex items-center gap-2">
                        <div id="demo-play-icon" class="hidden"><?php echo getIcon('PlayIcon', 'w-4 h-4 text-primary'); ?></div>
                        <div id="demo-pause-icon"><?php echo getIcon('PauseIcon', 'w-4 h-4 text-primary'); ?></div>
                        <span id="demo-play-text" class="font-body text-sm font-medium text-foreground">Pause</span>
                    </button>
                </div>
            </div>

            <div class="p-8">
                <?php foreach ($demoScreens as $index => $screen): ?>
                <div id="demo-content-<?php echo $index; ?>" class="demo-content <?php echo $index === 0 ? '' : 'hidden'; ?>">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                            <?php echo getIcon('ComputerDesktopIcon', 'w-6 h-6 text-primary'); ?>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-headline text-2xl font-bold text-foreground mb-2">
                                <?php echo $screen['title']; ?>
                            </h3>
                            <p class="font-body text-base text-muted-foreground">
                                <?php echo $screen['description']; ?>
                            </p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-3 mb-6">
                        <?php foreach ($screen['highlights'] as $highlight): ?>
                            <div class="flex items-start gap-2">
                                <div class="flex-shrink-0 w-5 h-5 bg-success/10 rounded-full flex items-center justify-center mt-0.5">
                                    <?php echo getIcon('CheckIcon', 'w-3.5 h-3.5 text-success'); ?>
                                </div>
                                <span class="font-body text-sm text-foreground"><?php echo $highlight; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="flex items-center justify-between">
                    <div class="flex gap-2">
                        <?php foreach ($demoScreens as $index => $screen): ?>
                            <button onclick="switchDemoScreen(<?php echo $index; ?>)" class="demo-dot h-2 rounded-full transition-all duration-250 <?php echo $index === 0 ? 'w-8 bg-primary' : 'w-2 bg-border'; ?>" data-index="<?php echo $index; ?>" aria-label="View screen <?php echo $index + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <button onclick="scrollToSection('contact')" class="px-6 py-3 bg-accent text-accent-foreground font-cta font-bold rounded-lg shadow-cta hover:bg-accent/90 transition-all duration-250 flex items-center gap-2">
                        <?php echo getIcon('PlayIcon', 'w-5 h-5'); ?>
                        <span>View Live Demo</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-5 gap-4">
            <?php foreach ($demoScreens as $index => $screen): ?>
                <button onclick="switchDemoScreen(<?php echo $index; ?>)"
                    class="demo-thumb-btn p-4 rounded-xl border-2 transition-all duration-250 text-center <?php echo $index === 0 ? 'bg-primary text-primary-foreground border-primary' : 'bg-card text-foreground border-border hover:border-primary/30'; ?>"
                    data-index="<?php echo $index; ?>">
                    <div class="font-body text-sm font-semibold mb-1"><?php echo $screen['title']; ?></div>
                    <div class="demo-thumb-desc font-body text-xs <?php echo $index === 0 ? 'text-primary-foreground/80' : 'text-muted-foreground'; ?>">
                        <?php echo ucfirst($screen['id']); ?>
                    </div>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
