<section class="py-16 lg:py-24 bg-gray-900 text-white relative overflow-hidden">
    <!-- Decor Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/10 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full mb-6 backdrop-blur-sm">
                    <?php echo getIcon('CommandLineIcon', 'w-5 h-5 text-accent'); ?>
                    <span class="font-body text-sm font-medium text-gray-300">Engineering Excellence</span>
                </div>
                <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                    Built on Logic. <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-foreground to-gray-300">Optimized for Speed.</span>
                </h2>
                <p class="font-body text-lg text-gray-400 mb-8 leading-relaxed">
                    While the interface is designed for humans, the core is built for machines. 
                    We use the lightweight <strong>CodeIgniter</strong> framework to ensure that every click results in action in under 200 milliseconds.
                </p>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center border border-white/10">
                            <?php echo getIcon('BoltIcon', 'w-6 h-6 text-accent'); ?>
                        </div>
                        <div>
                            <h3 class="font-headline text-xl font-bold text-white mb-1">Zero-Lag Performance</h3>
                            <p class="font-body text-sm text-gray-400">Micro-optimized queries ensure your dashboard loads instantly, even with 100,000+ SKUs.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center border border-white/10">
                            <?php echo getIcon('LockClosedIcon', 'w-6 h-6 text-accent'); ?>
                        </div>
                        <div>
                            <h3 class="font-headline text-xl font-bold text-white mb-1">Ironclad Security (RBAC)</h3>
                            <p class="font-body text-sm text-gray-400">Granular Role-Based Access Control means cashiers can't see profits, and warehouse staff can't change prices.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center border border-white/10">
                            <?php echo getIcon('ServerIcon', 'w-6 h-6 text-accent'); ?>
                        </div>
                        <div>
                            <h3 class="font-headline text-xl font-bold text-white mb-1">Scalable Architecture</h3>
                            <p class="font-body text-sm text-gray-400">Built to grow from a single yard to a nationwide network without rewriting a single line of code.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl bg-gray-800/50 backdrop-blur-xl p-6">
                    <!-- Fake Code Terminal Visual -->
                    <div class="flex items-center gap-2 mb-4 border-b border-white/5 pb-4">
                        <div class="w-3 h-3 rounded-full bg-error"></div>
                        <div class="w-3 h-3 rounded-full bg-warning"></div>
                        <div class="w-3 h-3 rounded-full bg-success"></div>
                        <div class="ml-4 font-mono text-xs text-gray-500">server_status.log</div>
                    </div>
                    <div class="font-mono text-xs sm:text-sm text-gray-300 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-success">➜ system_check</span>
                            <span class="text-gray-500">0.01s</span>
                        </div>
                        <div class="text-gray-500">Running diagnostics...</div>
                        <div class="flex justify-between border-b border-white/5 pb-1">
                            <span>Database Connection</span>
                            <span class="text-success">CONNECTED (CodeIgniter Query Builder)</span>
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-1">
                            <span>Response Time</span>
                            <span class="text-accent">145ms</span>
                        </div>
                         <div class="flex justify-between border-b border-white/5 pb-1">
                            <span>Memory Usage</span>
                            <span class="text-success">LOW (2.4MB)</span>
                        </div>
                         <div class="flex justify-between pb-1">
                            <span>Security Protocol</span>
                            <span class="text-success">RBAC ACTIVE</span>
                        </div>
                         <div class="mt-4 p-3 bg-black/30 rounded border-l-2 border-accent text-accent">
                            > "Speed is a feature. CodeIgniter ensures we never keep the human brain waiting."
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
