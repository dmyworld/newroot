<section id="hero" class="relative min-h-screen pt-20 overflow-hidden bg-gray-900">
    <div class="absolute inset-0 z-0">
        <img src="assets/images/hero-background.png" alt="Timber Grid Background" class="object-cover w-full h-full opacity-40">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        <!-- Glassmorphism Orbs -->
        <div class="absolute top-20 left-20 w-72 h-72 bg-primary/30 rounded-full blur-3xl mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-accent/20 rounded-full blur-3xl mix-blend-screen animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full backdrop-blur-md shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                    <?php echo getIcon('SparklesIcon', 'w-5 h-5 text-accent'); ?>
                    <span class="font-body text-sm font-medium text-gray-200 tracking-wide">The First ERP Designed for the Human Brain</span>
                </div>

                <h1 class="font-headline text-4xl sm:text-5xl lg:text-7xl font-bold text-white leading-tight tracking-tight drop-shadow-lg">
                    Stop Managing Data. <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-foreground via-white to-gray-300">Start Commanding</span>
                    Your Business.
                </h1>

                <p class="font-body text-lg sm:text-xl text-gray-300 leading-relaxed max-w-xl">
                    The only ERP & POS system scientifically optimized to reduce owner stress and increase staff sales performance by 35% using behavioral psychology.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">
                    <?php
                    $valueProps = [
                        ['icon' => 'ClipboardDocumentCheckIcon', 'text' => '💼 Cheque Registry'],
                        ['icon' => 'BanknotesIcon', 'text' => 'PAYROLL INTELLIGENCE'],
                        ['icon' => 'WrenchScrewdriverIcon', 'text' => 'Carpentry MANUFACTURING INTEL'],
                        ['icon' => 'UserGroupIcon', 'text' => 'STAFF INTELLIGENCE NETWORK'],
                        ['icon' => 'GlobeAsiaAustraliaIcon', 'text' => 'GLOBAL OPERATIONS CENTER'],
                        ['icon' => 'ShieldExclamationIcon', 'text' => 'LOSS PREVENTION & THREAT MONITOR']
                    ];
                    foreach ($valueProps as $prop) {
                        echo '<div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-white/5 border border-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    ' . getIcon($prop['icon'], 'w-4 h-4 text-accent') . '
                                </div>
                                <span class="font-body text-sm font-medium text-gray-200 uppercase tracking-wider">' . $prop['text'] . '</span>
                            </div>';
                    }
                    ?>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button onclick="scrollToSection('contact')" class="group relative px-8 py-4 bg-accent text-accent-foreground font-cta font-bold text-lg rounded-xl shadow-[0_0_20px_rgba(218,165,32,0.4)] hover:shadow-[0_0_30px_rgba(218,165,32,0.6)] hover:bg-accent/90 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        <div class="relative flex items-center justify-center gap-2">
                            <?php echo getIcon('RocketLaunchIcon', 'w-6 h-6'); ?>
                            <span>Deploy Your Command Center</span>
                        </div>
                    </button>
                    <button onclick="openVideoModal()" class="px-8 py-4 bg-white/5 text-white font-body font-semibold text-lg rounded-xl border border-white/10 hover:bg-white/10 hover:border-white/20 backdrop-blur-sm transition-all duration-250 flex items-center justify-center gap-2">
                        <?php echo getIcon('PlayCircleIcon', 'w-6 h-6 text-gray-300'); ?>
                        <span>Watch Intelligence Demo</span>
                    </button>
                </div>

                <!-- Trust Signals / Metrics -->
                 <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/10">
                    <div class="text-center">
                        <div class="font-headline text-3xl font-bold text-white">40%</div>
                        <div class="font-body text-xs text-gray-400 mt-1 uppercase tracking-wide">Cognitive Load Reduction</div>
                    </div>
                    <div class="text-center">
                        <div class="font-headline text-3xl font-bold text-accent">35%</div>
                        <div class="font-body text-xs text-gray-400 mt-1 uppercase tracking-wide">Sales Performance Boost</div>
                    </div>
                     <div class="text-center">
                        <div class="font-headline text-3xl font-bold text-white">200ms</div>
                        <div class="font-body text-xs text-gray-400 mt-1 uppercase tracking-wide">Decision Speed</div>
                    </div>
                </div>
            </div>

            <!-- Visualization / Graphic -->
            <div class="relative perspective-1000">
                <div class="relative rounded-2xl overflow-hidden shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10 bg-gray-900/80 backdrop-blur-xl transform rotate-y-12 hover:rotate-y-0 transition-all duration-700 ease-out">
                    <!-- Placeholder for Hero Command Center Image -->
                    <img src="assets/images/hero-dashboard.png" alt="Psychological Command Center Interface" class="w-full h-auto opacity-90 hover:opacity-100 transition-opacity duration-300">
                    
                    <!-- Overlay UI Elements mimicking specific features -->
                    <div class="absolute top-6 right-6 bg-black/60 backdrop-blur-md p-4 rounded-xl border border-white/10 shadow-lg animate-fade-in-up">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-success/20 rounded-full flex items-center justify-center animate-pulse">
                                <?php echo getIcon('HeartIcon', 'w-5 h-5 text-success'); ?>
                            </div>
                            <div>
                                <div class="font-body text-xs text-gray-400 uppercase">Business Pulse</div>
                                <div class="font-headline text-lg font-bold text-white">Healthy</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-6 left-6 bg-black/60 backdrop-blur-md p-4 rounded-xl border border-white/10 shadow-lg animate-fade-in-up" style="animation-delay: 0.3s;">
                         <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-accent/20 rounded-full flex items-center justify-center">
                                <?php echo getIcon('TrophyIcon', 'w-5 h-5 text-accent'); ?>
                            </div>
                            <div>
                                <div class="font-body text-xs text-gray-400 uppercase">Staff Performance</div>
                                <div class="font-headline text-lg font-bold text-white">+15% vs Last Week</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decor elements -->
                <div class="absolute -z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-tr from-primary/20 via-transparent to-accent/20 blur-3xl rounded-full"></div>
            </div>
        </div>
    </div>
</section>
