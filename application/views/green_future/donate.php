<?php $this->load->view('green_future/hero_premium'); ?>
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="text-center mb-16">
        <div class="w-20 h-20 bg-green-100 rounded-3xl flex items-center justify-center text-green-600 mx-auto mb-8 text-3xl">
            <i class="fa-solid fa-seedling"></i>
        </div>
        <h1 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight mb-4">Empower Our Green Mission</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">100% of your contribution directly funds reforestation, sapling care, and biodiversity protection across Sri Lanka.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Left: Impact Info -->
        <div class="lg:col-span-5 space-y-8">
            <div class="bg-slate-900 rounded-[32px] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-200">
                <i class="fa fa-quote-left absolute top-4 right-4 text-white/5 text-6xl"></i>
                <h3 class="text-xl font-bold mb-6">Why Donate?</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i class="fa fa-check-circle text-green-400 mt-1"></i>
                        <span class="text-sm text-slate-300">Funds the planting of endemic and commercial saplings.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa fa-check-circle text-green-400 mt-1"></i>
                        <span class="text-sm text-slate-300">Supports local families through 'Maintenance Payouts'.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa fa-check-circle text-green-400 mt-1"></i>
                        <span class="text-sm text-slate-300">Helps monitor growth using blockchain & verified GPS tags.</span>
                    </li>
                </ul>
            </div>

            <div class="bg-green-50 rounded-3xl p-6 border border-green-100 italic text-sm text-green-800 text-center">
                "We don't inherit the earth from our ancestors, we borrow it from our children."
            </div>
        </div>

        <!-- Right: The Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-[40px] shadow-2xl shadow-slate-100 border border-slate-100 p-8 md:p-12">
                <form action="<?= site_url('greenfuture/submit_donation') ?>" method="post" class="space-y-8">
                    
                    <!-- Quick Select -->
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Select Amount (LKR)</label>
                        <div class="grid grid-cols-3 gap-3">
                            <?php foreach([500, 2000, 5000] as $amt): ?>
                            <button type="button" onclick="setAmt(<?= $amt ?>)" 
                                    class="amt-btn py-4 rounded-2xl border-2 border-slate-50 text-sm font-black text-slate-400 hover:border-green-100 transition-all">
                                Rs. <?= number_format($amt) ?>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Input Amount -->
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Or Custom Amount</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 font-bold">LKR</span>
                            <input type="number" name="amount" id="amount" required 
                                   class="w-full bg-slate-50 border-none rounded-2xl pl-16 pr-6 py-6 text-3xl font-black text-slate-900 focus:ring-4 focus:ring-green-500/10 transition-all" 
                                   placeholder="0">
                        </div>
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Message (Optional)</label>
                        <textarea name="note" rows="2" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-green-500/10 placeholder:text-slate-300" placeholder="In honor of... / For our future..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-6 rounded-3xl shadow-xl shadow-green-200 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                        <i class="fa fa-heart animate-pulse"></i> SECURE CONTRIBUTION
                    </button>
                    
                    <div class="flex items-center justify-center gap-2 text-slate-400">
                        <i class="fa fa-lock text-[10px]"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Encrypted & Secure Transaction</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .amt-btn.active {
        @apply border-green-600 bg-green-50 text-green-600 shadow-lg shadow-green-100;
    }
</style>

<script>
    function setAmt(val) {
        document.getElementById('amount').value = val;
        document.querySelectorAll('.amt-btn').forEach(btn => {
            btn.classList.remove('active');
            if(btn.textContent.includes(val.toLocaleString())) btn.classList.add('active');
        });
    }
</script>
