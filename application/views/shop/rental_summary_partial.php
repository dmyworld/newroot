<div class="space-y-3 p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
    <div class="flex justify-between items-center text-sm">
        <span class="text-slate-500 font-medium">Rental Period</span>
        <span class="text-slate-900 font-bold"><?= $days ?> Days</span>
    </div>
    <div class="flex justify-between items-center text-sm">
        <span class="text-slate-500 font-medium">Base Price</span>
        <span class="text-slate-900 font-bold">LKR <?= number_format($base_price) ?></span>
    </div>
    <?php if($discount > 0): ?>
    <div class="flex justify-between items-center text-sm">
        <span class="text-emerald-600 font-medium">Loyalty Discount</span>
        <span class="text-emerald-600 font-bold">- LKR <?= number_format($discount) ?></span>
    </div>
    <?php endif; ?>
    <div class="flex justify-between items-center text-sm border-t border-emerald-200 pt-2">
        <span class="text-slate-500 font-medium">Security Deposit</span>
        <span class="text-slate-900 font-bold">LKR <?= number_format($deposit) ?></span>
    </div>
    <?php if($insurance): ?>
    <div class="flex justify-between items-center text-[10px] text-emerald-500 font-black uppercase tracking-widest">
        <span><i class="fa fa-shield-check"></i> Damage Protection Included</span>
        <span>-50% Deposit</span>
    </div>
    <?php endif; ?>
    <div class="flex justify-between items-center pt-2">
        <span class="text-lg font-black text-emerald-700">Total Due Now</span>
        <span class="text-lg font-black text-emerald-700">LKR <?= number_format($total_price + $deposit) ?></span>
    </div>
</div>
