<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="flex flex-col md:flex-row items-center gap-12">
        
        <!-- Left Illustration/Text -->
        <div class="flex-1 space-y-8">
            <div class="inline-flex items-center space-x-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-widest border border-blue-100">
                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                <span>Islandwide Service</span>
            </div>
            
            <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                Get Bids from <span class="text-blue-600">Verified</span> Suppliers.
            </h1>
            
            <p class="text-lg text-slate-500 leading-relaxed">
                Post your timber or hardware requirements and let our netowrk of verified suppliers compete to give you the best price.
            </p>

            <div class="grid grid-cols-2 gap-6 pt-4">
                <div class="space-y-2">
                    <div class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl flex items-center justify-center text-blue-600">
                        <i class="fa fa-shield-alt"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Safe & Verified</h4>
                    <p class="text-xs text-slate-400">All suppliers are identity-checked.</p>
                </div>
                <div class="space-y-2">
                    <div class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl flex items-center justify-center text-blue-600">
                        <i class="fa fa-lightning-ray"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Instant Alerts</h4>
                    <p class="text-xs text-slate-400">Suppliers get notified instantly.</p>
                </div>
            </div>
        </div>

        <!-- Right Side: The Form Card -->
        <div class="flex-1 w-full">
            <div class="bg-white rounded-[40px] shadow-2xl shadow-blue-100/50 border border-slate-100 p-8 lg:p-10">
                <form action="<?= base_url('shop/save_quote_request') ?>" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Requirement Title</label>
                        <input type="text" name="title" required class="custom-input" placeholder="e.g. Need 500ft of 2x2 Mahogany Battens">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Category</label>
                            <select name="category" class="custom-select" required>
                                <option value="timber">Timber</option>
                                <option value="hardware">Hardware</option>
                                <option value="services">Services</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Budget (LKR)</label>
                            <input type="number" name="budget" class="custom-input" placeholder="Optional">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Location / District</label>
                        <select name="district" class="custom-select" required>
                            <option value="">Select District</option>
                            <?php foreach($districts as $d): ?>
                            <option value="<?= $d ?>"><?= $d ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Detailed Description</label>
                        <textarea name="description" rows="4" required class="custom-input" placeholder="Specify dimensions, species, quantity, and quality requirements..."></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-5 rounded-2xl shadow-xl shadow-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                            Submit Request Hub
                        </button>
                        <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-tighter mt-4 italic">
                            By submitting, you agree to our Marketplace Terms.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-input {
        @apply w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-slate-300;
    }
    .custom-select {
        @apply w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer;
    }
</style>
