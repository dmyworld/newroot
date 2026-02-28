<?php
$testimonials = [
    [
        'id' => '1',
        'name' => 'Rajitha Perera',
        'position' => 'Managing Director',
        'company' => 'Lanka Timber Industries',
        'businessType' => 'Timber Yard Owner',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_1297d0c2e-1763301704225.png',
        'alt' => 'Professional Sri Lankan businessman in navy suit smiling confidently in modern office',
        'quote' => 'TimberPro ERP transformed our operations completely. We reduced inventory errors by 85% and saved Rs. 2.4M in the first year alone. The system pays for itself within months.',
        'rating' => 5,
        'result' => 'Rs. 2.4M saved annually'
    ],
    [
        'id' => '2',
        'name' => 'Chaminda Silva',
        'position' => 'Operations Manager',
        'company' => 'Ceylon Wood Exports',
        'businessType' => 'Imported Timber Dealer',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_11dc858ac-1766820019142.png',
        'alt' => 'Middle-aged Asian businessman in white shirt working at desk with laptop in bright office',
        'quote' => 'The real-time inventory tracking is a game-changer. We can now manage multiple warehouses effortlessly and our order processing time dropped from 4 hours to 90 minutes. Container tracking is seamless.',
        'rating' => 5,
        'result' => '60% faster processing'
    ],
    [
        'id' => '3',
        'name' => 'Nimal Fernando',
        'position' => 'CEO',
        'company' => 'Mahogany Traders Ltd',
        'businessType' => 'Sawmill Operator',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_1cd333be8-1766577390453.png',
        'alt' => 'Senior Asian executive in dark suit with arms crossed standing in corporate office',
        'quote' => 'Compliance was our biggest headache. TimberPro handles all regulatory requirements automatically. We have had zero violations in 18 months and passed every audit with flying colors. The sawmill module optimized our production.',
        'rating' => 5,
        'result' => 'Zero compliance issues'
    ],
    [
        'id' => '4',
        'name' => 'Priya Jayawardena',
        'position' => 'Finance Director',
        'company' => 'Teak Masters Lanka',
        'businessType' => 'Timber Yard Owner',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_15d131d9d-1763295813046.png',
        'alt' => 'Professional businesswoman in formal attire reviewing financial documents in modern office',
        'quote' => 'The financial reporting and VAT compliance features are outstanding. We generate all our tax reports with one click. The system has eliminated manual errors and our accountant loves it.',
        'rating' => 5,
        'result' => '100% tax accuracy'
    ],
    [
        'id' => '5',
        'name' => 'Asanka Wijesinghe',
        'position' => 'Warehouse Manager',
        'company' => 'Island Wood Solutions',
        'businessType' => 'Furniture Manufacturer',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_1015e0af9-1763298612934.png',
        'alt' => 'Warehouse manager in casual business attire standing in timber storage facility',
        'quote' => 'Managing raw material inventory for furniture production was chaotic before TimberPro. Now we track every piece of timber from arrival to finished product. Wastage reduced by 30% in 6 months.',
        'rating' => 5,
        'result' => '30% wastage reduction'
    ],
    [
        'id' => '6',
        'name' => 'Dinesh Rathnayake',
        'position' => 'Owner',
        'company' => 'Colombo Timber Co',
        'businessType' => 'Imported Timber Dealer',
        'image' => 'https://img.rocket.new/generatedImages/rocket_gen_img_12ed6acf0-1763294415576.png',
        'alt' => 'Business owner in smart casual attire standing in timber showroom',
        'quote' => 'The import management module is brilliant. Container tracking, customs documentation, landed cost calculations - everything automated. We handle 3x more imports with the same team size.',
        'rating' => 5,
        'result' => '3x import capacity'
    ]
];

$clientLogos = [
    ['name' => 'Lanka Timber Industries', 'logo' => 'BuildingOfficeIcon'],
    ['name' => 'Ceylon Wood Exports', 'logo' => 'TruckIcon'],
    ['name' => 'Mahogany Traders Ltd', 'logo' => 'CubeIcon'],
    ['name' => 'Teak Masters Lanka', 'logo' => 'HomeModernIcon'],
    ['name' => 'Colombo Timber Co', 'logo' => 'BuildingStorefrontIcon'],
    ['name' => 'Island Wood Solutions', 'logo' => 'GlobeAltIcon']
];

$recentBookings = [
    ['company' => 'Timber Solutions Lanka', 'time' => '2 minutes ago'],
    ['company' => 'Wood Craft Industries', 'time' => '15 minutes ago'],
    ['company' => 'Premium Timber Co', 'time' => '28 minutes ago']
];

// PHP to JS data transfer
echo "<script>
    var testimonialsData = " . json_encode($testimonials) . ";
    var recentBookingsData = " . json_encode($recentBookings) . ";
</script>";
?>

<section id="clients" class="py-16 lg:py-24 bg-background relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, #2D5016 0px, transparent 1px, transparent 20px)"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent/10 border border-accent/20 rounded-full mb-6">
                <?php echo getIcon('StarIcon', 'w-5 h-5 text-accent'); ?>
                <span class="font-body text-sm font-medium text-accent">Trusted by Industry Leaders</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4">
                Join 150+ Successful Timber Businesses
            </h2>
            <p class="font-body text-lg text-muted-foreground max-w-3xl mx-auto">
                See why Sri Lanka's leading timber companies trust TimberPro ERP to power their operations.
            </p>
        </div>

        <div class="bg-card rounded-2xl shadow-xl border border-border overflow-hidden mb-12">
            <div class="grid lg:grid-cols-2 gap-0">
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <?php foreach ($testimonials as $index => $testimonial): ?>
                    <div id="testimonial-content-<?php echo $index; ?>" class="testimonial-content <?php echo $index === 0 ? '' : 'hidden'; ?>">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="relative w-20 h-20 rounded-full overflow-hidden border-4 border-primary">
                                <img src="<?php echo $testimonial['image']; ?>" alt="<?php echo $testimonial['alt']; ?>" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="font-body text-lg font-semibold text-foreground">
                                    <?php echo $testimonial['name']; ?>
                                </div>
                                <div class="font-body text-sm text-muted-foreground">
                                    <?php echo $testimonial['position']; ?>
                                </div>
                                <div class="font-body text-sm font-medium text-primary">
                                    <?php echo $testimonial['company']; ?>
                                </div>
                                <div class="font-body text-xs text-accent">
                                    <?php echo $testimonial['businessType']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-1 mb-6">
                            <?php for($i=0; $i<$testimonial['rating']; $i++): ?>
                                <?php echo getIcon('StarIcon', 'w-5 h-5 text-accent'); ?>
                            <?php endfor; ?>
                        </div>

                        <blockquote class="font-body text-lg text-foreground leading-relaxed mb-6">
                            "<?php echo $testimonial['quote']; ?>"
                        </blockquote>

                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-success/10 border border-success/20 rounded-lg">
                            <?php echo getIcon('CheckCircleIcon', 'w-5 h-5 text-success'); ?>
                            <span class="font-body text-sm font-semibold text-success">
                                <?php echo $testimonial['result']; ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="flex gap-2 mt-8">
                        <?php foreach ($testimonials as $index => $testimonial): ?>
                            <button onclick="changeTestimonial(<?php echo $index; ?>)" 
                                    class="testimonial-dot h-2 rounded-full transition-all duration-250 <?php echo $index === 0 ? 'w-8 bg-primary' : 'w-2 bg-border'; ?>"
                                    data-index="<?php echo $index; ?>" 
                                    aria-label="View testimonial <?php echo $index + 1; ?>">
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="relative h-96 lg:h-auto bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center p-8">
                    <div class="text-center">
                        <div class="font-headline text-6xl font-bold text-primary mb-4">150+</div>
                        <div class="font-body text-xl font-semibold text-foreground mb-2">Timber Businesses</div>
                        <div class="font-body text-sm text-muted-foreground">Powered by TimberPro ERP</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-card rounded-2xl p-8 border border-border">
            <h3 class="font-body text-xl font-semibold text-foreground text-center mb-8">
                Trusted by Sri Lanka's Leading Timber Companies
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php foreach ($clientLogos as $client): ?>
                    <div class="flex flex-col items-center justify-center p-4 rounded-lg hover:bg-muted transition-all duration-250">
                        <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-3">
                            <?php echo getIcon($client['logo'], 'w-8 h-8 text-primary'); ?>
                        </div>
                        <div class="font-body text-xs text-center text-muted-foreground"><?php echo $client['name']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Notification Toast -->
    <div id="booking-notification" class="fixed bottom-24 right-6 z-50 animate-slide-in-right hidden">
        <div class="bg-card rounded-lg shadow-xl border border-border p-4 max-w-sm">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-success/10 rounded-full flex items-center justify-center">
                    <?php echo getIcon('CheckCircleIcon', 'w-5 h-5 text-success'); ?>
                </div>
                <div class="flex-1">
                    <div id="booking-company" class="font-body text-sm font-semibold text-foreground mb-1">
                        Timber Solutions Lanka
                    </div>
                    <div id="booking-time" class="font-body text-xs text-muted-foreground">
                        Just requested a demo • 2 minutes ago
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Simple JS for Testimonials rotating
    let currentTestimonial = 0;
    const totalTestimonials = <?php echo count($testimonials); ?>;
    
    function changeTestimonial(index) {
        currentTestimonial = index;
        
        // Hide all contents
        document.querySelectorAll('.testimonial-content').forEach(el => el.classList.add('hidden'));
        // Show active
        document.getElementById('testimonial-content-' + index).classList.remove('hidden');
        
        // Update dots
        document.querySelectorAll('.testimonial-dot').forEach(el => {
            if(parseInt(el.dataset.index) === index) {
                el.classList.remove('w-2', 'bg-border');
                el.classList.add('w-8', 'bg-primary');
            } else {
                el.classList.remove('w-8', 'bg-primary');
                el.classList.add('w-2', 'bg-border');
            }
        });
    }

    // Auto rotate testimonials
    setInterval(() => {
        const next = (currentTestimonial + 1) % totalTestimonials;
        changeTestimonial(next);
    }, 6000);

    // Notification Logic
    // Using inline script here for section specific logic, but ideally could be in main.js
    // We already passed the php data
    let currentBooking = 0;
    const totalBookings = <?php echo count($recentBookings); ?>;
    
    setInterval(() => {
        const notification = document.getElementById('booking-notification');
        const companyEl = document.getElementById('booking-company');
        const timeEl = document.getElementById('booking-time');
        
        // Show
        notification.classList.remove('hidden');
        
        // Update Content
        if(typeof recentBookingsData !== 'undefined' && recentBookingsData.length > 0) {
            const booking = recentBookingsData[currentBooking];
            companyEl.innerText = booking.company;
            timeEl.innerText = 'Just requested a demo • ' + booking.time;
            
            currentBooking = (currentBooking + 1) % totalBookings;
        }

        // Hide after 4s
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 4000);
        
    }, 8000);
</script>
