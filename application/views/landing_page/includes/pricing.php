<?php
$packages = [
    [
        'name' => 'Starter',
        'price' => 'Rs. 99,000',
        'period' => '/month',
        'description' => 'Perfect for small timber businesses getting started',
        'features' => ['Up to 1,000 inventory items', 'Single location support', 'Basic reporting', 'Email support', '5 user accounts', 'Mobile app access'],
        'icon' => 'RocketLaunchIcon',
        'popular' => false
    ],
    [
        'name' => 'Professional',
        'price' => 'Rs. 199,000',
        'period' => '/month',
        'description' => 'Ideal for growing timber operations',
        'features' => ['Up to 10,000 inventory items', 'Multi-location support', 'Advanced analytics', 'Priority support', '20 user accounts', 'API access', 'Custom reports', 'Supplier portal'],
        'icon' => 'BuildingOfficeIcon',
        'popular' => true
    ],
    [
        'name' => 'Enterprise',
        'price' => 'Custom',
        'period' => 'pricing',
        'description' => 'For large-scale timber businesses',
        'features' => ['Unlimited inventory items', 'Unlimited locations', 'AI-powered insights', 'Dedicated support', 'Unlimited users', 'White-label option', 'Custom integrations', 'On-site training', 'SLA guarantee'],
        'icon' => 'BuildingLibraryIcon',
        'popular' => false
    ]
];
?>
<section id="pricing" class="py-16 lg:py-24 bg-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent/10 border border-accent/20 rounded-full mb-6">
                <?php echo getIcon('CurrencyDollarIcon', 'w-5 h-5 text-accent'); ?>
                <span class="font-body text-sm font-medium text-accent">Transparent Pricing</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4">
                Choose Your Perfect Plan
            </h2>
            <p class="font-body text-lg text-muted-foreground max-w-3xl mx-auto mb-8">
                Flexible pricing designed for Sri Lankan timber businesses of all sizes. All plans include implementation support.
            </p>

            <button onclick="toggleCalculator()" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-primary-foreground font-body font-semibold rounded-lg hover:bg-primary/90 transition-all duration-250">
                <?php echo getIcon('CalculatorIcon', 'w-5 h-5'); ?>
                <span id="calc-toggle-text">Show Pricing Calculator</span>
            </button>
        </div>

        <div id="pricing-calculator" class="bg-card rounded-2xl p-8 border border-border mb-12 hidden">
            <h3 class="font-body text-xl font-semibold text-foreground mb-6 text-center">
                Calculate Your Custom Quote
            </h3>

            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block font-body text-sm font-medium text-foreground mb-2">Business Size</label>
                    <select id="calc-size" onchange="calculatePrice()" class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="small">Small (1-10 employees)</option>
                        <option value="medium" selected>Medium (11-50 employees)</option>
                        <option value="large">Large (51-200 employees)</option>
                        <option value="enterprise">Enterprise (200+ employees)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-body text-sm font-medium text-foreground mb-2">Inventory Volume</label>
                    <select id="calc-volume" onchange="calculatePrice()" class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="low">Low (&lt; 1,000 items)</option>
                        <option value="moderate" selected>Moderate (1,000-5,000 items)</option>
                        <option value="high">High (5,000-20,000 items)</option>
                        <option value="very-high">Very High (20,000+ items)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-body text-sm font-medium text-foreground mb-2">Number of Locations</label>
                    <select id="calc-locations" onchange="calculatePrice()" class="w-full px-4 py-3 bg-background border border-border rounded-lg font-body text-foreground focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="single" selected>Single Location</option>
                        <option value="multiple">2-5 Locations</option>
                        <option value="many">6+ Locations</option>
                    </select>
                </div>
            </div>

            <div class="bg-primary/5 rounded-xl p-6 border-2 border-primary/20">
                <div class="text-center">
                    <div class="font-body text-sm text-muted-foreground mb-2">Estimated Monthly Investment</div>
                    <div id="calc-result" class="font-headline text-4xl font-bold text-primary mb-2">
                        Rs. 150,000
                    </div>
                    <div class="font-body text-sm text-muted-foreground mb-4">
                        Includes implementation support and training
                    </div>
                    <button class="px-6 py-3 bg-accent text-accent-foreground font-cta font-bold rounded-lg shadow-cta hover:bg-accent/90 transition-all duration-250">
                        Request Detailed Quote
                    </button>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($packages as $pkg): ?>
            <div class="bg-card rounded-2xl overflow-hidden border-2 transition-all duration-250 <?php echo $pkg['popular'] ? 'border-primary shadow-xl scale-105' : 'border-border hover:border-primary/30'; ?>">
                <?php if ($pkg['popular']): ?>
                <div class="bg-primary text-primary-foreground text-center py-2 font-body text-sm font-semibold">
                    Most Popular
                </div>
                <?php endif; ?>

                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center <?php echo $pkg['popular'] ? 'bg-primary/10' : 'bg-muted'; ?>">
                            <?php echo getIcon($pkg['icon'], 'w-6 h-6 ' . ($pkg['popular'] ? 'text-primary' : 'text-foreground')); ?>
                        </div>
                        <div>
                            <h3 class="font-body text-xl font-semibold text-foreground"><?php echo $pkg['name']; ?></h3>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="font-headline text-4xl font-bold text-foreground"><?php echo $pkg['price']; ?></span>
                            <span class="font-body text-sm text-muted-foreground"><?php echo $pkg['period']; ?></span>
                        </div>
                        <div class="font-body text-sm text-muted-foreground mt-2"><?php echo $pkg['description']; ?></div>
                    </div>

                    <ul class="space-y-3 mb-8">
                        <?php foreach ($pkg['features'] as $feature): ?>
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-5 h-5 bg-success/10 rounded-full flex items-center justify-center mt-0.5">
                                <?php echo getIcon('CheckIcon', 'w-3.5 h-3.5 text-success'); ?>
                            </div>
                            <span class="font-body text-sm text-foreground"><?php echo $feature; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <button class="w-full px-6 py-3 rounded-lg font-body font-semibold transition-all duration-250 <?php echo $pkg['popular'] ? 'bg-accent text-accent-foreground shadow-cta hover:bg-accent/90' : 'bg-muted text-foreground hover:bg-primary/10'; ?>">
                        Get Started
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-12 bg-gradient-to-r from-primary/10 via-accent/10 to-primary/10 rounded-2xl p-8 border border-primary/20">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-error/10 border border-error/20 rounded-full mb-4">
                    <?php echo getIcon('ClockIcon', 'w-5 h-5 text-error'); ?>
                    <span class="font-body text-sm font-medium text-error">Limited Time Offer</span>
                </div>
                <h3 class="font-headline text-2xl font-bold text-foreground mb-2">
                    Get 20% Off Implementation
                </h3>
                <p class="font-body text-base text-muted-foreground mb-6">
                    Book your demo this month and save Rs. 50,000 on implementation costs. Only 5 slots remaining!
                </p>
                <button class="px-8 py-4 bg-accent text-accent-foreground font-cta font-bold text-lg rounded-lg shadow-cta hover:bg-accent/90 transition-all duration-250">
                    Claim Your Discount
                </button>
            </div>
        </div>
    </div>
</section>

<script>
function toggleCalculator() {
    const calc = document.getElementById('pricing-calculator');
    const text = document.getElementById('calc-toggle-text');
    if (calc.classList.contains('hidden')) {
        calc.classList.remove('hidden');
        text.innerText = 'Hide Pricing Calculator';
    } else {
        calc.classList.add('hidden');
        text.innerText = 'Show Pricing Calculator';
    }
}

function calculatePrice() {
    const size = document.getElementById('calc-size').value;
    const volume = document.getElementById('calc-volume').value;
    const locations = document.getElementById('calc-locations').value;
    
    const basePrice = 150000;
    let multiplier = 1;

    if (size === 'large') multiplier *= 1.5;
    if (size === 'enterprise') multiplier *= 2.5;

    if (volume === 'high') multiplier *= 1.3;
    if (volume === 'very-high') multiplier *= 1.6;

    if (locations === 'multiple') multiplier *= 1.4;
    if (locations === 'many') multiplier *= 1.8;

    const finalPrice = Math.round(basePrice * multiplier);
    document.getElementById('calc-result').innerText = 'Rs. ' + finalPrice.toLocaleString('en-LK');
}
</script>
