<div class="max-w-5xl mx-auto px-6 py-20">
    
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row items-end justify-between gap-8 mb-16">
        <div class="max-w-2xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-100 mb-6">
                <i class="fa fa-map-marked-alt text-xs"></i>
                <span>Landowner Support Program</span>
            </div>
            <h1 class="text-4xl lg:text-5xl font-black text-slate-900 leading-[1.1] tracking-tight">
                Turn your land into a <br>
                <span class="text-green-600">Verified Sanctuary.</span>
            </h1>
        </div>
        <p class="text-lg text-slate-500 font-body lg:max-w-xs">
            Register your land to receive free saplings and rewards for every tree that thrives under your care.
        </p>
    </div>

    <!-- Main Registration Box -->
    <div class="bg-white rounded-[40px] shadow-2xl shadow-slate-100 border border-slate-100 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Information Sidebar -->
            <div class="lg:col-span-4 bg-slate-50 p-10 lg:p-12 border-r border-slate-100 space-y-12">
                <div>
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-6">The Process</h3>
                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-xs font-black text-green-600 shadow-sm border border-slate-100">1</div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Register</h4>
                                <p class="text-xs text-slate-400 mt-1">Submit your location and land details for review.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-xs font-black text-slate-900 shadow-sm border border-slate-100">2</div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Verification</h4>
                                <p class="text-xs text-slate-400 mt-1">A local coordinator verifies the site via GPS.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-xs font-black text-slate-900 shadow-sm border border-slate-100">3</div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Planting</h4>
                                <p class="text-xs text-slate-400 mt-1">Saplings are delivered and planted by our team.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-green-600 rounded-3xl p-6 text-white shadow-xl shadow-green-100">
                    <h4 class="font-black text-sm mb-2 italic">Did you know?</h4>
                    <p class="text-xs text-white/80 leading-relaxed font-body">
                        Verified landowners receive maintenance payouts after 6, 12, and 24 months of tree survival.
                    </p>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="lg:col-span-8 p-10 lg:p-16">
                <form action="<?= site_url('greenfuture/submit_planting') ?>" method="post" class="space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Target District</label>
                            <input type="text" name="district" required class="custom-input" placeholder="e.g. Matara">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Province</label>
                            <input type="text" name="province" required class="custom-input" placeholder="e.g. Southern">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Trees Requested</label>
                            <input type="number" name="trees_requested" required class="custom-input" placeholder="Min 10 Saplings">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Preferred Species</label>
                            <select name="tree_species" class="custom-select">
                                <option value="teak">Teak (Thekka)</option>
                                <option value="mahogany">Mahogany</option>
                                <option value="fruit">Fruit Trees (Mixed)</option>
                                <option value="native">Native Rainforest Species</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Land Layout & GPS Notes</label>
                        <textarea name="land_description" rows="4" class="custom-input" placeholder="Describe the environment (Flat, Hilly, near River) and any specific access instructions..."></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black py-6 rounded-3xl shadow-2xl transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                            <i class="fa fa-paper-plane text-xs"></i> SUBMIT PROPOSAL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-input {
        @apply w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-green-500/10 transition-all placeholder:text-slate-300;
    }
    .custom-select {
        @apply w-full bg-slate-50 border-none rounded-2xl px-6 py-5 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-green-500/10 transition-all cursor-pointer;
    }
</style>
