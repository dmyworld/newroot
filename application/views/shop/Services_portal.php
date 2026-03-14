<?php $this->load->view('shop/hero_premium'); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- 1. TOP SERVICE CATEGORIES -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Browse Expert Services</h2>
            <a href="#" class="text-blue-600 font-bold text-sm hover:underline">View All Categories</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <?php 
            $colors = [
                'bg-amber-100 text-amber-600', 'bg-green-100 text-green-600', 'bg-blue-100 text-blue-600',
                'bg-purple-100 text-purple-600', 'bg-rose-100 text-rose-600', 'bg-slate-100 text-slate-600',
                'bg-emerald-100 text-emerald-600', 'bg-indigo-100 text-indigo-600', 'bg-cyan-100 text-cyan-600',
                'bg-orange-100 text-orange-600', 'bg-pink-100 text-pink-600', 'bg-yellow-100 text-yellow-600'
            ];
            foreach($service_cats as $index => $sc): 
                $color = $colors[$index % count($colors)];
            ?>
            <div onclick="startLiveSearch(<?= $sc['id'] ?>, '<?= htmlspecialchars($sc['title']) ?>')" class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 flex flex-col items-center text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 cursor-pointer">
                <div class="w-20 h-20 <?= $color ?> rounded-3xl flex items-center justify-center text-3xl mb-5 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                    <i class="fa <?= $sc['icon'] ?: 'fa-cog' ?>"></i>
                </div>
                <span class="text-xs font-black text-slate-900 uppercase tracking-tight leading-tight"><?= htmlspecialchars($sc['title']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php $this->load->view('shop/radar_overlay'); ?>

    <script>
        function startLiveSearch(serviceId, name) {
            const loc = <?= json_encode($this->session->userdata('user_location') ?? ['lat' => 6.9271, 'lng' => 79.8612, 'name' => 'Colombo']) ?>;
            DispatchEngine.start(serviceId, loc.lat, loc.lng, loc.name);
        }
    </script>

    <!-- 2. NEARBY SERVICE PROVIDERS -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Top Rated Pros Near You</h2>
                <p class="text-slate-500 text-sm mt-1">Based on your current location: <span class="text-blue-600 font-bold"><?= $this->session->userdata('user_location')['name'] ?? 'Sri Lanka' ?></span></p>
            </div>
            <div class="flex space-x-2">
                <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-colors"><i class="fa fa-chevron-left"></i></button>
                <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-colors"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($workers as $w): ?>
            <div class="group bg-white rounded-[2rem] border border-slate-100 p-8 hover:shadow-2xl transition-all duration-500 flex flex-col items-center text-center">
                <div class="relative mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-3xl p-1 shadow-xl group-hover:rotate-6 transition-transform overflow-hidden font-black">
                        <?php if(!empty($w['photo'])): ?>
                            <img src="<?= base_url($w['photo']) ?>" class="w-full h-full rounded-[22px] bg-white object-cover">
                        <?php else: ?>
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= urlencode($w['display_name']) ?>" class="w-full h-full rounded-[22px] bg-white object-cover">
                        <?php endif; ?>
                    </div>
                </div>

                <h3 class="text-xl font-black text-slate-900 mb-1"><?= htmlspecialchars($w['display_name']) ?></h3>
                <div class="flex items-center justify-center space-x-2 mb-6">
                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest"><?= htmlspecialchars($w['category_name'] ?? 'Expert') ?></span>
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                    <span class="text-[10px] font-black <?= $w['is_verified'] ? 'text-green-500' : 'text-slate-400' ?> uppercase tracking-widest"><?= $w['is_verified'] ? 'Verified' : 'Member' ?></span>
                </div>

                <div class="w-full bg-slate-50 rounded-2xl p-4 mb-6 group-hover:bg-blue-50 transition-colors border border-slate-100 flex items-center justify-between">
                    <div class="text-left">
                        <span class="block text-[10px] text-slate-400 font-bold uppercase mb-0.5">Rating</span>
                        <div class="flex text-amber-400 text-xs">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-alt"></i>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-[10px] text-slate-400 font-bold uppercase mb-0.5">Rate</span>
                        <span class="text-lg font-black text-slate-900">Rs. <?= number_format($w['pay_rate']) ?></span>
                    </div>
                </div>

                <button onclick="window.location.href='<?= base_url('worker/view/'.$w['id']) ?>'" class="w-full bg-slate-900 text-white font-black py-4 rounded-2xl shadow-xl shadow-slate-100 hover:bg-blue-600 transition-all duration-300">
                    HIRE PRO
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 3. SERVICES PROMOTION BANNER -->
    <section class="mb-16 rounded-[3rem] overflow-hidden relative min-h-[400px] flex items-center bg-slate-900">
        <img src="https://images.unsplash.com/photo-1513519245088-0e12902e15ca?auto=format&fit=crop&q=80&w=2000" class="absolute inset-0 w-full h-full object-cover opacity-50">
        <div class="relative z-10 px-12 md:px-20 max-w-2xl">
            <span class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-6 inline-block">Business Growth</span>
            <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">Are you a professional service provider?</h2>
            <p class="text-slate-300 text-lg mb-10 leading-relaxed font-medium">Join the TimberPro network and reach thousands of customers looking for your expertise. From transport to quality control.</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#" class="bg-white text-slate-900 font-black px-10 py-5 rounded-2xl text-center hover:bg-blue-50 transition-colors shadow-2xl">Register as Pro</a>
                <a href="#" class="bg-white/10 backdrop-blur-md text-white border border-white/20 font-black px-10 py-5 rounded-2xl text-center hover:bg-white/20 transition-colors">How it Works</a>
            </div>
        </div>
    </section>

</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    section { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) backwards; }
</style>
