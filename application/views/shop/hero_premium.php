<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden bg-slate-900 pt-20">
    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-transparent to-green-600 animate-pulse"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop')] bg-cover bg-center mix-blend-overlay"></div>
    </div>
    
    <!-- Floating Glass Cards -->
    <div class="absolute top-1/4 left-10 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl animate-blob"></div>
    <div class="absolute bottom-1/4 right-10 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 mb-8 animate-fade-in-up">
            <span class="flex h-2 w-2 rounded-full bg-success"></span>
            <span class="text-white text-xs font-bold uppercase tracking-wider">Sri Lanka's #1 Timber Marketplace</span>
        </div>
        
        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight">
            The Ultimate <span class="bg-gradient-to-r from-blue-400 to-green-400 bg-clip-text text-transparent">Marketplace</span><br>
            for Wood & Professionals
        </h1>
        
        <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto mb-10 leading-relaxed">
            Connect with verified sawmillers, skilled professionals, and premium hardware suppliers. All your timber needs, simplified in one powerful ecosystem.
        </p>
        
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 max-w-5xl mx-auto">
            <button onclick="switchTab('timber')" class="group flex flex-col items-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa fa-tree text-2xl"></i>
                </div>
                <span class="text-white font-bold text-sm tracking-wide">Timber</span>
            </button>
            <button onclick="switchTab('hardware')" class="group flex flex-col items-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center text-green-400 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa fa-tools text-2xl"></i>
                </div>
                <span class="text-white font-bold text-sm tracking-wide">Hardware</span>
            </button>
            <button onclick="switchTab('services')" class="group flex flex-col items-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center text-amber-400 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa fa-user-gear text-2xl"></i>
                </div>
                <span class="text-white font-bold text-sm tracking-wide">Workers</span>
            </button>
            <button onclick="switchTab('quotes')" class="group flex flex-col items-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa fa-file-invoice-dollar text-2xl"></i>
                </div>
                <span class="text-white font-bold text-sm tracking-wide">Quotes</span>
            </button>
            <button onclick="switchTab('jobs')" class="group flex flex-col items-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center text-red-400 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa fa-briefcase text-2xl"></i>
                </div>
                <span class="text-white font-bold text-sm tracking-wide">Jobs</span>
            </button>
        </div>
    </div>
</section>

<style>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animate-pulse {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>
