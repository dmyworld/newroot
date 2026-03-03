<footer class="bg-[#111827] text-gray-400 py-16 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Brand -->
            <div class="space-y-6">
                <img src="<?= base_url('assets/images/timberpro_logo_new.png'); ?>" alt="TimberPro" class="h-10 w-auto brightness-0 invert">
                <p class="text-sm leading-relaxed">
                    Sri Lanka's premier timber ecosystem, connecting businesses, protecting profits, and building a greener future through sustainable forestry and CSR.
                </p>
                <div class="flex space-x-5">
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-facebook text-xl"></i></a>
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-whatsapp text-xl"></i></a>
                    <a href="#" class="hover:text-white transition-colors"><i class="fa-brands fa-linkedin text-xl"></i></a>
                </div>
            </div>

            <!-- Marketplace Links -->
            <div>
                <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Marketplace</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="<?= base_url('shop?type=logs') ?>" class="hover:text-white transition-colors">Round Logs</a></li>
                    <li><a href="<?= base_url('shop?type=sawn') ?>" class="hover:text-white transition-colors">Sawn Timber</a></li>
                    <li><a href="<?= base_url('shop/calculator') ?>" class="hover:text-white transition-colors">Wood Calculator</a></li>
                    <li><a href="<?= base_url('shop/track') ?>" class="hover:text-white transition-colors">Order Tracking</a></li>
                </ul>
            </div>

            <!-- CSR Links -->
            <div>
                <h4 class="text-success font-bold uppercase tracking-wider text-sm mb-6">Green Future</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="<?= base_url('greenfuture') ?>" class="hover:text-white transition-colors">CSR Dashboard</a></li>
                    <li><a href="<?= base_url('greenfuture/donate') ?>" class="hover:text-white transition-colors">Donate Now</a></li>
                    <li><a href="<?= base_url('greenfuture/plant') ?>" class="hover:text-white transition-colors">Request Planting</a></li>
                    <li><a href="<?= base_url('greenfuture/apply_maintenance') ?>" class="hover:text-white transition-colors">Maintenance Fund</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Contact & Support</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-primary"></i> 071 234 5678</li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-primary"></i> support@timberpro.lk</li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-location-dot text-primary"></i> Galle road, Colombo 03</li>
                    <li class="pt-4"><a href="<?= base_url('user') ?>" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition-all">Staff Login</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-16 pt-8 text-center text-xs">
            <p>© <?= date('Y') ?> TimberPro Ecosystem. All rights reserved. Powered by D Business Solutions.</p>
        </div>
    </div>
</footer>
</body>
</html>
