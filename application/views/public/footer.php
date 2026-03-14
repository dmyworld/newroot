<footer class="bg-slate-950 text-slate-400 py-20 mt-20 relative overflow-hidden">
    <!-- Decorative background element -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-success/30 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
            <!-- Brand & Mission -->
            <div class="space-y-8">
                <div>
                    <a href="<?= base_url() ?>" class="text-2xl font-extrabold tracking-tighter text-white">
                        Timber<span class="text-success">Pro</span>
                    </a>
                    <p class="mt-6 text-sm leading-relaxed text-slate-400 max-w-sm">
                        Sri Lanka's premier timber ecosystem, revolutionizing transparency and sustainability in forestry through advanced AI and digital integration.
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="#" class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white hover:bg-success hover:scale-110 transition-all duration-300"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white hover:bg-success hover:scale-110 transition-all duration-300"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white hover:bg-success hover:scale-110 transition-all duration-300"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white hover:bg-success hover:scale-110 transition-all duration-300"><i class="fa-brands fa-x-twitter text-sm"></i></a>
                </div>
            </div>

            <!-- Solutions & Ecosystem -->
            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-[0.2em] mb-8">Ecosystem</h4>
                <ul class="space-y-4">
                    <li><a href="<?= base_url('shop') ?>" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all"><?= $t['nav_marketplace'] ?></a></li>
                    <li><a href="<?= base_url('worker') ?>" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all"><?= $t['nav_workforce'] ?></a></li>
                    <li><a href="<?= base_url('greenfuture') ?>" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all"><?= $t['nav_green'] ?></a></li>
                    <li><a href="<?= base_url('shop/calculator') ?>" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all"><?= $t['nav_calculator'] ?></a></li>
                </ul>
            </div>

            <!-- Platform -->
            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-[0.2em] mb-8">Platform</h4>
                <ul class="space-y-4">
                    <li><a href="<?= base_url('hub/login') ?>" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all">Business Dashboard</a></li>
                    <li><a href="<?= base_url('shop/track') ?>" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all">Order Tracking</a></li>
                    <li><a href="#" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all">API Access</a></li>
                    <li><a href="#" class="text-sm hover:text-white hover:translate-x-1 inline-block transition-all">AI Solutions</a></li>
                </ul>
            </div>

            <!-- Contact & Support -->
            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-[0.2em] mb-8">Connect</h4>
                <div class="space-y-6">
                    <div class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-success group-hover:bg-success group-hover:text-white transition-all"><i class="fa-solid fa-phone text-xs"></i></div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Call Support</div>
                            <div class="text-sm text-slate-300 font-bold">071 234 5678</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-success group-hover:bg-success group-hover:text-white transition-all"><i class="fa-solid fa-envelope text-xs"></i></div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Email Us</div>
                            <div class="text-sm text-slate-300 font-bold">support@timberpro.lk</div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <a href="<?= base_url('user') ?>" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-slate-900 text-slate-300 border border-slate-800 hover:border-slate-700 hover:bg-slate-800 hover:text-white transition-all text-xs font-bold">
                            <i class="fa-solid fa-lock text-[10px]"></i>
                            Staff Control Center
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-20 pt-8 border-t border-slate-900 flex flex-col md:flex-row items-center justify-between gap-6 text-[11px] font-bold text-slate-600 uppercase tracking-widest">
            <p>© <?= date('Y') ?> TimberPro Ecosystem. Engineered by D Business Solutions.</p>
            <div class="flex gap-8">
                <a href="#" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Governance</a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
