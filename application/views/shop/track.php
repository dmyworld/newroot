<div class="max-w-3xl mx-auto px-4 py-20">
    <div class="text-center mb-12">
        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mx-auto mb-6 text-2xl">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Track Your Order</h1>
        <p class="text-slate-500">Enter your order ID below to see its current progress in our ecosystem.</p>
    </div>

    <!-- Tracking Input -->
    <div class="bg-white rounded-[32px] shadow-2xl shadow-blue-100/50 border border-slate-100 p-8 mb-10">
        <form method="GET" action="<?= base_url('shop/track') ?>" class="flex flex-col sm:flex-row gap-4">
            <input name="order_number" value="<?= htmlspecialchars($order_number ?? '') ?>"
                   class="flex-1 bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20" 
                   placeholder="Order Number (e.g. TPS-2026-XXXX)" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-2xl shadow-lg transition-all active:scale-95">
                Track Status
            </button>
        </form>
    </div>

    <?php if ($order_number && !$order): ?>
        <div class="bg-red-50 border border-red-100 rounded-3xl p-8 text-center">
            <div class="text-red-500 text-3xl mb-4"><i class="fa fa-circle-exclamation"></i></div>
            <h3 class="text-lg font-bold text-red-900 mb-1">Order Not Found</h3>
            <p class="text-sm text-red-600">Please check the ID and try again, or contact support.</p>
        </div>

    <?php elseif ($order): ?>
        <?php
            $statuses = ['quote','confirmed','processing','ready','delivered'];
            $current_idx = array_search($order['status'], $statuses);
            if ($current_idx === false) $current_idx = -1;
            
            $status_theme = [
                'quote'      => ['bg-slate-100', 'text-slate-600'],
                'confirmed'  => ['bg-blue-100', 'text-blue-600'],
                'processing' => ['bg-amber-100', 'text-amber-600'],
                'ready'      => ['bg-green-100', 'text-green-600'],
                'delivered'  => ['bg-emerald-100', 'text-emerald-600'],
                'cancelled'  => ['bg-red-100', 'text-red-600'],
            ][$order['status']] ?? ['bg-slate-100', 'text-slate-600'];
        ?>
        <div class="bg-white rounded-[32px] shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden">
            <!-- Order Header -->
            <div class="px-10 py-8 bg-slate-900 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div>
                  <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Current Status for</span>
                  <h2 class="text-2xl font-black text-white"><?= htmlspecialchars($order['order_number']) ?></h2>
                </div>
                <div class="<?= $status_theme[0] ?> <?= $status_theme[1] ?> px-6 py-2 rounded-full font-black text-xs uppercase tracking-widest border border-white/10">
                    <?= strtoupper($order['status']) ?>
                </div>
            </div>

            <!-- Progress Map -->
            <?php if ($order['status'] !== 'cancelled'): ?>
            <!-- Live Tracker (Phase 6.4) -->
            <div class="p-10 border-b border-slate-50 bg-slate-50/30">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Live Delivery Map</h3>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] font-bold text-green-600 uppercase">Live - Signal Strong</span>
                    </div>
                </div>
                
                <div id="tracking-map" class="w-full h-80 bg-slate-200 rounded-[2rem] overflow-hidden mb-8 border-4 border-white shadow-inner relative">
                    <!-- Placeholder for Google Maps -->
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-100 italic text-slate-400 text-sm">
                        <div class="text-center">
                            <i class="fa fa-map-marked-alt text-4xl mb-3 block opacity-20"></i>
                            Waiting for vehicle GPS signal...
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <!-- Progress Line -->
                    <div class="absolute top-4 left-10 right-10 h-1 bg-slate-100 rounded-full">
                        <div class="h-full bg-blue-600 rounded-full transition-all duration-1000" 
                             style="width: <?= ($current_idx / (count($statuses)-1)) * 100 ?>%"></div>
                    </div>
                    
                    <!-- Steps -->
                    <div class="relative flex justify-between">
                        <?php foreach($statuses as $idx => $st): ?>
                        <div class="flex flex-col items-center">
                            <div class="w-9 h-9 rounded-full mb-3 flex items-center justify-center text-xs transition-all duration-500
                                 <?= $idx <= $current_idx ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white text-slate-300 border-2 border-slate-100' ?>">
                                <?php if($idx < $current_idx): ?><i class="fa fa-check"></i><?php else: ?><?= $idx + 1 ?><?php endif; ?>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest <?= $idx <= $current_idx ? 'text-slate-900' : 'text-slate-300' ?>">
                                <?= $st ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Info Board -->
            <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-50/50">
                <div class="space-y-6">
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Customer Name</span>
                        <div class="font-bold text-slate-900 border-l-4 border-blue-500 pl-4 py-1"><?= htmlspecialchars($order['customer_name']) ?></div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Contact Method</span>
                        <div class="font-bold text-slate-900 border-l-4 border-slate-200 pl-4 py-1"><?= htmlspecialchars($order['customer_phone']) ?></div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Specifics</span>
                        <div class="font-bold text-slate-900 border-l-4 border-slate-200 pl-4 py-1">
                            <?= $order['quantity'] ?> <?= $order['unit'] ?> of <?= htmlspecialchars($order['species'] ?: 'Timber') ?>
                        </div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Ordered On</span>
                        <div class="font-bold text-slate-900 border-l-4 border-slate-200 pl-4 py-1">
                            <?= date('d M Y, g:i A', strtotime($order['created_at'])) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-10 bg-white text-center">
                <a href="<?= base_url('shop') ?>" class="text-blue-600 font-bold hover:underline">← Return to Marketplace</a>
            </div>
        </div>
    <?php endif ?>
</div>
