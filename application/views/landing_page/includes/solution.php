<?php
$features = [
    [
        'id' => 'command-center',
        'title' => 'The Owner\'s Command Center',
        'description' => 'Don\'t guess. Know. Our dashboard aggregates 1,000 data points into a single Business Health Score.',
        'icon' => 'PresentationChartLineIcon',
        'image' => 'assets/images/dashboard-1767529141730.jpg',
        'alt' => 'Executive Command Center Dashboard',
        'psych_trigger' => 'Hick\'s Law (Simplicity)',
        'capabilities' => ['Business Health Score', 'Pulse, Risk, & Profit View', '3-Second Decision Time', 'Cognitive Load Reduction'],
        'benefits' => ['See your business health in 3 seconds', 'Eliminate analysis paralysis', 'Focus only on what matters']
    ],
    [
        'id' => 'dopamine-pos',
        'title' => 'Dopamine-Driven POS',
        'description' => 'Turn your cashiers into top performers. Our POS uses positive reinforcement loops—celebrating sales milestones.',
        'icon' => 'SparklesIcon',
        'image' => 'assets/images/point_of_sale_system.jpg',
        'alt' => 'Gamified Point of Sale Interface',
        'psych_trigger' => 'Gamification & Reward',
        'capabilities' => ['Sale Celebration Animations', 'Instant "Win" Notifications', 'Upsell Nudges', 'Staff Performance Leaderboards'],
        'benefits' => ['Increase staff motivation naturally', 'Turn sales into a game', 'Boost upsell conversion by 35%']
    ],
    [
        'id' => 'loss-aversion',
        'title' => 'Loss-Aversion Inventory',
        'description' => 'Stop bleeding capital. We don\'t just show "Dead Stock". We show you exactly how much money you are losing every hour.',
        'icon' => 'ShieldExclamationIcon',
        'image' => 'assets/images/advanced_inventory_search.jpg',
        'alt' => 'Inventory Loss Prevention Dashboard',
        'psych_trigger' => 'Loss Aversion',
        'capabilities' => ['Capital Bleed Calculator', 'Idle Stock Alerts', 'Theft Pattern Detection', 'Expiry Nudges'],
        'benefits' => ['Recover "Dead" Capital immediately', 'Prevent silent profit leaks', 'Trigger immediate liquidation action']
    ]
];
?>
<section id="solutions" class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-6">
                <?php echo getIcon('CpuChipIcon', 'w-5 h-5 text-primary'); ?>
                <span class="font-body text-sm font-medium text-primary tracking-wide">The "AI Prow" Difference</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                Built on Business Logic, <br>Powered by <span class="text-primary">Psychology</span>.
            </h2>
            <p class="font-body text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Most software is a utility. Ours is a proactive tool that uses behavioral science to nudge you and your staff toward better decisions.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mb-16">
            <?php foreach ($features as $index => $feature): ?>
                <button onclick="switchSolution(<?php echo $index; ?>)"
                    class="solution-btn p-8 rounded-2xl border-2 transition-all duration-300 text-left group <?php echo $index === 0 ? 'bg-gray-900 text-white border-gray-900 shadow-xl scale-105' : 'bg-white text-gray-900 border-gray-100 hover:border-primary/30 hover:shadow-lg'; ?>"
                    data-index="<?php echo $index; ?>">
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="solution-icon-container w-14 h-14 rounded-xl flex items-center justify-center transition-colors <?php echo $index === 0 ? 'bg-white/10' : 'bg-primary/5 group-hover:bg-primary/10'; ?>">
                            <div class="solution-icon <?php echo $index === 0 ? 'text-accent' : 'text-primary'; ?>">
                                <?php echo getIcon($feature['icon'], 'w-8 h-8'); ?>
                            </div>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider <?php echo $index === 0 ? 'text-gray-400' : 'text-primary'; ?>">
                            <?php echo $feature['psych_trigger']; ?>
                        </span>
                    </div>
                    
                    <h3 class="font-headline text-xl font-bold mb-3"><?php echo $feature['title']; ?></h3>
                    <p class="solution-desc font-body text-sm leading-relaxed <?php echo $index === 0 ? 'text-gray-300' : 'text-gray-500'; ?>">
                        <?php echo $feature['description']; ?>
                    </p>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="bg-gray-50 rounded-3xl overflow-hidden shadow-2xl border border-gray-200">
            <?php foreach ($features as $index => $feature): ?>
                <div id="solution-content-<?php echo $index; ?>" class="solution-content grid lg:grid-cols-2 gap-0 <?php echo $index === 0 ? '' : 'hidden'; ?>">
                    <div class="relative h-[500px] lg:h-auto overflow-hidden group">
                        <img src="<?php echo $feature['image']; ?>" alt="<?php echo $feature['alt']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8 text-white">
                             <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full mb-3 border border-white/10">
                                <?php echo getIcon('SparklesIcon', 'w-4 h-4 text-accent'); ?>
                                <span class="text-xs font-medium">Psychological Trigger: <?php echo $feature['psych_trigger']; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 lg:p-16 flex flex-col justify-center bg-white">
                        <div class="mb-8">
                            <h3 class="font-headline text-3xl font-bold text-gray-900 mb-4"><?php echo $feature['title']; ?></h3>
                            <p class="font-body text-lg text-gray-600 leading-relaxed"><?php echo $feature['description']; ?></p>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <h4 class="font-body text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Capabilities</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <?php foreach ($feature['capabilities'] as $cap): ?>
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center">
                                                <?php echo getIcon('CheckIcon', 'w-3 h-3 text-primary'); ?>
                                            </div>
                                            <span class="font-body text-sm font-medium text-gray-700"><?php echo $cap; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div>
                                <h4 class="font-body text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Key Benefits</h4>
                                <div class="space-y-3">
                                    <?php foreach ($feature['benefits'] as $benefit): ?>
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-5 h-5 bg-accent/10 rounded-full flex items-center justify-center">
                                                <?php echo getIcon('ArrowTrendingUpIcon', 'w-3 h-3 text-accent'); ?>
                                            </div>
                                            <span class="font-body text-sm font-medium text-gray-700"><?php echo $benefit; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-10">
                            <button onclick="switchSolution(<?php echo ($index > 0 ? $index - 1 : count($features) - 1); ?>)" class="group w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-300 border border-gray-200 hover:border-primary" aria-label="Previous feature">
                                <?php echo getIcon('ChevronLeftIcon', 'w-6 h-6 text-gray-400 group-hover:text-white'); ?>
                            </button>
                            <button onclick="switchSolution(<?php echo ($index < count($features) - 1 ? $index + 1 : 0); ?>)" class="group w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-300 border border-gray-200 hover:border-primary" aria-label="Next feature">
                                <?php echo getIcon('ChevronRightIcon', 'w-6 h-6 text-gray-400 group-hover:text-white'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
