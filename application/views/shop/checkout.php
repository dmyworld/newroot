<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="bg-white rounded-[40px] shadow-2xl shadow-blue-100/50 border border-slate-100 p-8 lg:p-10">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Checkout: <?= htmlspecialchars($lot['name'] ?? $lot['species'] ?? 'Lot') ?></h2>
        
        <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100">
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-bold text-slate-500 uppercase">Total Amount</span>
                <span class="text-2xl font-black text-blue-600">LKR <?= number_format($lot['total_price'] ?? ($lot['price'] ?? 0)) ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-bold text-slate-500 uppercase">Location</span>
                <span class="text-sm font-bold text-slate-900"><?= htmlspecialchars($lot['location'] ?? 'Sri Lanka') ?></span>
            </div>
        </div>

        <form action="<?= base_url('shop/submit_quote') ?>" method="POST" class="space-y-6">
            <input type="hidden" name="lot_id" value="<?= $lot['id'] ?>">
            <input type="hidden" name="lot_type" value="<?= $lot_type ?>">
            <input type="hidden" name="project_id" value="<?= $project_id ?? 0 ?>">
            <input type="hidden" name="species" value="<?= htmlspecialchars($lot['species'] ?? '') ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Your Name</label>
                    <input type="text" name="customer_name" required class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20" placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Phone Number</label>
                    <input type="text" name="customer_phone" required class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20" placeholder="+94 77 123 4567">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Delivery Address (Optional)</label>
                <textarea name="delivery_address" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20" placeholder="Enter delivery address..."></textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-5 rounded-2xl shadow-xl shadow-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                    Confirm Order
                </button>
            </div>
        </form>
    </div>
</div>
