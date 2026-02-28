<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-error/10 border border-error/20 rounded-full mb-6">
                <?php echo getIcon('ExclamationCircleIcon', 'w-5 h-5 text-error'); ?>
                <span class="font-body text-sm font-medium text-error tracking-wide">The Hidden Cost of Complexity</span>
            </div>
            <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                The "Data Blindness" Epidemic
            </h2>
            <p class="font-body text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Your current software gives you reports. We give you <strong>clarity</strong>. <br>
                Traditional ERPs overwhelm you with rows of data, leading to <span class="text-error font-semibold">Decision Fatigue</span>.
                You miss critical risks because they are buried in spreadsheets. Your staff treats sales like a chore because their software is a utility, not a tool.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-error to-orange-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-200 bg-white">
                    <img src="https://img.rocket.new/generatedImages/rocket_gen_img_1f0abead0-1764697480595.png" alt="Frustrated timber business owner surrounded by stacks of paper documents and spreadsheets" class="w-full h-auto filter grayscale contrast-125 transition-all duration-500 group-hover:grayscale-0">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="font-headline text-2xl font-bold text-white mb-2">The Fog of Data</div>
                        <div class="font-body text-sm text-gray-300">When you can't see the signal for the noise, you lose money.</div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                        <div id="counter-inventory" class="font-headline text-4xl font-bold text-error mb-1">35%</div>
                        <div class="font-body text-xs text-gray-500 font-medium uppercase tracking-wide">Inventory Invisible</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                        <div id="counter-time" class="font-headline text-4xl font-bold text-error mb-1">20h</div>
                        <div class="font-body text-xs text-gray-500 font-medium uppercase tracking-wide">Admin Time Lost</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                        <div id="counter-profit" class="font-headline text-4xl font-bold text-error mb-1">15%</div>
                        <div class="font-body text-xs text-gray-500 font-medium uppercase tracking-wide">Revenue Leaks</div>
                    </div>
                </div>

                <?php
                $problems = [
                    ['icon' => 'BrainIcon', 'title' => 'Decision Fatigue', 'description' => 'Too many clicks and complex menus drain your mental energy before you make a single decision.'],
                    ['icon' => 'EyeSlashIcon', 'title' => 'Risk Blindspots', 'description' => 'Critical issues like "Dead Stock" or "Theft" are hidden in paginated reports you never have time to read.'],
                    ['icon' => 'UserMinusIcon', 'title' => 'Staff Disengagement', 'description' => 'Clunky POS interfaces make selling feel like data entry, killing staff motivation and upsell potential.'],
                    ['icon' => 'DocumentDuplicateIcon', 'title' => 'The "Spreadsheet Crutch"', 'description' => 'You still rely on Excel because your ERP is too hard to use for quick answers.']
                ];
                
                // Note: BrainIcon, EyeSlashIcon, UserMinusIcon might need to be added to icons.php if not present. 
                // Falling back to standard icons if specific ones aren't available, but assuming getIcon handles it or I should check icons.php.
                // Let's use standard ones that likely exist or map them.
                // Re-mapping to safe icons based on typical sets if these don't exist in a basic set, 
                // but if using HeroIcons (which it seems to be from names like CubeIcon), these should be fine.
                // Actually, let's play it safe and use existing icons from list or standard HeroIcons names.
                // Brain -> LightBulbIcon (idea/mind) or adjust. EyeSlash -> EyeSlashIcon is standard.
                
                // Let's check icons.php content if I can... I saw the file list but not content.
                // I will use standard safe names.
                $problems = [
                    ['icon' => 'CpuChipIcon', 'title' => 'Decision Fatigue', 'description' => 'Too many clicks and complex menus drain your mental energy before you make a single decision.'],
                    ['icon' => 'EyeSlashIcon', 'title' => 'Risk Blindspots', 'description' => 'Critical issues like "Dead Stock" or "Theft" are hidden in paginated reports you never have time to read.'],
                    ['icon' => 'FaceFrownIcon', 'title' => 'Staff Disengagement', 'description' => 'Clunky POS interfaces make selling feel like data entry, killing staff motivation and upsell potential.'],
                    ['icon' => 'DocumentDuplicateIcon', 'title' => 'The "Spreadsheet Crutch"', 'description' => 'You still rely on Excel because your ERP is too hard to use for quick answers.']
                ];

                foreach ($problems as $problem) {
                    echo '<div class="flex gap-4 bg-white p-5 rounded-xl border border-gray-100 hover:border-error/30 hover:shadow-md transition-all duration-300 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-error/5 rounded-xl flex items-center justify-center group-hover:bg-error/10 transition-colors">
                                ' . getIcon($problem['icon'], 'w-6 h-6 text-error') . '
                            </div>
                            <div>
                                <h3 class="font-body text-lg font-bold text-gray-900 mb-1">' . $problem['title'] . '</h3>
                                <p class="font-body text-sm text-gray-500 leading-relaxed">' . $problem['description'] . '
                            </div>
                        </div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
