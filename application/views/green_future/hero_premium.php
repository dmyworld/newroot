<!-- PREMIUM GREENFUTURE HERO SECTION -->
<div class="relative min-h-[600px] flex items-center justify-center overflow-hidden bg-slate-900 font-sans">
    
    <!-- Nature Inspired Background -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2560&auto=format&fit=crop" 
             class="w-full h-full object-cover opacity-50 scale-105 animate-[pulse_8s_ease-in-out_infinite]" alt="Forest">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/40 to-[#eff6ff]"></div>
    </div>

    <!-- Animated Particles (Floating Leaves/Dust) -->
    <div class="absolute inset-0 z-10 pointer-events-none opacity-30">
        <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-green-400 rounded-full blur-xl animate-float"></div>
        <div class="absolute top-1/2 right-1/3 w-6 h-6 bg-emerald-500 rounded-full blur-xl animate-float-delayed"></div>
        <div class="absolute bottom-1/4 left-1/2 w-3 h-3 bg-lime-300 rounded-full blur-xl animate-float"></div>
    </div>

    <!-- Content Wrapper -->
    <div class="relative z-20 max-w-7xl mx-auto px-6 pt-20 pb-16 text-center">
        
        <!-- Live Fund Ticker (Glassmorphism) -->
        <div class="inline-flex items-center space-x-3 px-6 py-2 bg-white/10 backdrop-blur-2xl border border-white/20 rounded-full mb-8 transform transition-all hover:scale-105">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
            </span>
            <span class="text-xs font-bold text-white uppercase tracking-[0.2em]">Green Future Fund:</span>
            <span class="text-xs font-black text-green-400">LKR <?= number_format($fund_balance ?? 0) ?></span>
        </div>

        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-[1.1] tracking-tight">
            Nurturing Tomorrow's <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-emerald-400 to-lime-300">
                Green Legacy.
            </span>
        </h1>

        <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto mb-10 leading-relaxed font-body">
            Every cubic foot of timber traded through TimberPro contributes to reforestation. Join us in planting a billion trees and restoring Sri Lanka's forest cover.
        </p>

        <!-- CTA Hub (Premium Design) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?= site_url('greenfuture/donate') ?>" 
               class="group relative px-10 py-5 bg-green-600 text-white font-black rounded-2xl shadow-2xl shadow-green-900/20 transition-all duration-300 hover:bg-green-500 hover:-translate-y-1 active:scale-95 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <i class="fa fa-heart mr-3 text-red-400 animate-pulse"></i> DONATE NOW
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </a>
            
            <a href="<?= site_url('greenfuture/plant') ?>" 
               class="px-10 py-5 bg-white/10 backdrop-blur-md border border-white/20 text-white font-black rounded-2xl transition-all duration-300 hover:bg-white/20 hover:-translate-y-1 active:scale-95">
                REQUEST PLANTING
            </a>
        </div>

        <!-- Social Proof Stats (Subtle) -->
        <div class="mt-16 grid grid-cols-2 lg:grid-cols-4 gap-8 max-w-4xl mx-auto border-t border-white/10 pt-10">
            <div class="text-center">
                <div class="text-2xl font-black text-white"><?= number_format($stats['total_planted'] ?? 0) ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Trees Planted</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-black text-white"><?= $stats['total_donors'] ?? 0 ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Global Donors</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-black text-white"><?= $stats['maintenance_active'] ?? 0 ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Active Projects</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-black text-white"><?= number_format($stats['total_requested'] ?? 0) ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pending Drives</div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-20px) scale(1.1); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    @keyframes float-delayed {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-30px) scale(1.2); }
    }
    .animate-float-delayed { animation: float-delayed 8s ease-in-out infinite; }
</style>
