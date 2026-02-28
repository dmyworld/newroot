<?php
$benefits = [
    [
        'id' => 'cost',
        'title' => 'Operational Cost Reduction',
        'metric' => '40%',
        'description' => 'Reduce operational costs through automation, better inventory management, and streamlined processes',
        'icon' => 'CurrencyDollarIcon',
        'color' => 'success',
        'progress' => 40,
        'caseStudy' => ['company' => 'Lanka Timber Industries', 'result' => 'Saved Rs. 2.4M annually in operational costs', 'timeline' => 'Within 6 months of implementation']
    ],
    [
        'id' => 'speed',
        'title' => 'Faster Inventory Processing',
        'metric' => '60%',
        'description' => 'Process inventory updates, orders, and reports 60% faster with automated workflows',
        'icon' => 'BoltIcon',
        'color' => 'accent',
        'progress' => 60,
        'caseStudy' => ['company' => 'Ceylon Wood Exports', 'result' => 'Reduced order processing time from 4 hours to 90 minutes', 'timeline' => 'Immediate improvement after go-live']
    ],
    [
        'id' => 'compliance',
        'title' => 'Full Regulatory Compliance',
        'metric' => '100%',
        'description' => 'Maintain complete compliance with Sri Lankan timber regulations and export requirements',
        'icon' => 'ShieldCheckIcon',
        'color' => 'primary',
        'progress' => 100,
        'caseStudy' => ['company' => 'Mahogany Traders Ltd', 'result' => 'Zero compliance violations in 18 months', 'timeline' => 'Continuous compliance monitoring']
    ]
];

function getBenefitColors($color) {
    switch ($color) {
        case 'success':
            return ['bg' => 'bg-success/10', 'text' => 'text-success', 'border' => 'border-success/20', 'bg_plain' => 'bg-success'];
        case 'accent':
            return ['bg' => 'bg-accent/10', 'text' => 'text-accent', 'border' => 'border-accent/20', 'bg_plain' => 'bg-accent'];
        case 'primary':
        default:
            return ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'border' => 'border-primary/20', 'bg_plain' => 'bg-primary'];
    }
}
?>
<section id="benefits" class="py-16 lg:py-24 bg-muted">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-6">
                <?php echo getIcon('SparklesIcon', 'w-5 h-5 text-primary'); ?>
                <span class="font-body text-sm font-medium text-primary">Proven Results</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4">
                Measurable Impact on Your Bottom Line
            </h2>
            <p class="font-body text-lg text-muted-foreground max-w-3xl mx-auto">
                Join hundreds of Sri Lankan timber businesses already experiencing dramatic improvements in efficiency and profitability.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($benefits as $benefit): 
                $colors = getBenefitColors($benefit['color']);
            ?>
            <div class="bg-card rounded-2xl border border-border overflow-hidden hover:shadow-xl transition-all duration-250">
                <div class="p-8">
                    <div class="w-16 h-16 <?php echo $colors['bg']; ?> rounded-xl flex items-center justify-center mb-6">
                        <?php echo getIcon($benefit['icon'], 'w-8 h-8 ' . $colors['text']); ?>
                    </div>

                    <div class="mb-6">
                        <div class="font-headline text-5xl font-bold <?php echo $colors['text']; ?> mb-2">
                             <span class="benefit-progress-text" data-target="<?php echo $benefit['progress']; ?>">0</span>%
                        </div>
                        <h3 class="font-body text-xl font-semibold text-foreground mb-2"><?php echo $benefit['title']; ?></h3>
                        <p class="font-body text-sm text-muted-foreground"><?php echo $benefit['description']; ?></p>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-body text-xs text-muted-foreground">Progress</span>
                            <span class="font-body text-xs font-semibold <?php echo $colors['text']; ?>"><span class="benefit-progress-small-text" data-target="<?php echo $benefit['progress']; ?>">0</span>%</span>
                        </div>
                        <div class="w-full h-2 bg-muted rounded-full overflow-hidden">
                            <div class="h-full <?php echo $colors['bg_plain']; ?> transition-all duration-1000 benefit-progress-bar" style="width: 0%" data-target="<?php echo $benefit['progress']; ?>"></div>
                        </div>
                    </div>

                    <button onclick="toggleBenefit('<?php echo $benefit['id']; ?>')" class="w-full px-4 py-3 rounded-lg border-2 <?php echo $colors['border'] . ' ' . $colors['text']; ?> font-body font-semibold text-sm hover:<?php echo $colors['bg']; ?> transition-all duration-250 flex items-center justify-between">
                        <span>View Case Study</span>
                        <div class="benefit-chevron" id="benefit-chevron-<?php echo $benefit['id']; ?>">
                            <?php echo getIcon('ChevronDownIcon', 'w-5 h-5'); ?>
                        </div>
                    </button>
                </div>

                <div id="benefit-details-<?php echo $benefit['id']; ?>" class="px-8 pb-8 border-t <?php echo $colors['border']; ?> hidden">
                    <div class="pt-6 space-y-4">
                        <div>
                            <div class="font-body text-xs text-muted-foreground mb-1">Client</div>
                            <div class="font-body text-sm font-semibold text-foreground"><?php echo $benefit['caseStudy']['company']; ?></div>
                        </div>
                        <div>
                            <div class="font-body text-xs text-muted-foreground mb-1">Result</div>
                            <div class="font-body text-sm font-semibold text-foreground"><?php echo $benefit['caseStudy']['result']; ?></div>
                        </div>
                        <div>
                            <div class="font-body text-xs text-muted-foreground mb-1">Timeline</div>
                            <div class="font-body text-sm font-semibold text-foreground"><?php echo $benefit['caseStudy']['timeline']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
