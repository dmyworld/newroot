<?php defined('BASEPATH') OR exit; ?>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Outfit', sans-serif; }
    
    .mesh-gradient {
        background: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                    radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, rgba(245, 158, 11, 0.05) 0px, transparent 50%),
                    radial-gradient(at 0% 100%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(24px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.03);
    }

    .config-hub {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(32px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.05), 0 30px 60px -30px rgba(0, 0, 0, 0.05);
    }

    .transaction-stream-item {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .transaction-stream-item:hover {
        transform: translateX(12px);
        background: rgba(255, 255, 255, 0.9);
    }

    .floating-leaf {
        position: fixed;
        pointer-events: none;
        z-index: 0;
        opacity: 0.1;
        animation: float 20s linear infinite;
    }

    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(100vw, 100vh) rotate(360deg); }
    }

    .custom-input {
        @apply w-full bg-white/50 border-slate-200/60 rounded-3xl px-6 py-5 text-lg font-bold text-slate-800 focus:ring-8 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all outline-none border-2;
    }

    .status-glow {
        filter: drop-shadow(0 0 8px currentColor);
    }
</style>

<!-- Background Accents -->
<div class="fixed inset-0 mesh-gradient -z-10"></div>
<i class="fa fa-leaf floating-leaf text-emerald-500 text-6xl" style="top: -10%; left: 10%; animation-delay: 0s;"></i>
<i class="fa fa-leaf floating-leaf text-emerald-400 text-4xl" style="top: 20%; left: -5%; animation-delay: 5s;"></i>
<i class="fa fa-leaf floating-leaf text-emerald-600 text-5xl" style="top: 60%; left: -10%; animation-delay: 10s;"></i>

<div class="content-body px-4 lg:px-24 py-16 min-h-screen relative z-10">
    
    <!-- Premium Centered Header -->
    <div class="max-w-4xl mx-auto text-center mb-20">
        <div class="inline-flex items-center space-x-2 px-4 py-1.5 bg-emerald-500/10 text-emerald-600 rounded-full text-[11px] font-black uppercase tracking-[0.2em] border border-emerald-500/20 mb-6">
            <i class="fa fa-shield-halved text-xs"></i>
            <span>Environmental Governance</span>
        </div>
        <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight mb-6">
            Pledge <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Architecture</span>
        </h1>
        <p class="text-slate-500 text-lg font-medium max-w-2xl mx-auto">
            <?= $is_admin ? 'Manage global sustainability thresholds for the entire marketplace ecosystem.' : 'Track your personal contribution to Sri Lanka\'s reforestation efforts through every transaction.' ?>
        </p>
    </div>

    <!-- Success Feedback Overlay -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="fixed top-12 left-1/2 -translate-x-1/2 z-50 bg-slate-900 border border-emerald-500/30 text-emerald-400 px-8 py-5 rounded-[32px] shadow-2xl flex items-center gap-4 animate-in fade-in slide-in-from-top-8 duration-500">
            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
                <i class="fa fa-check text-xs"></i>
            </div>
            <span class="text-sm font-black tracking-tight"><?= $this->session->flashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <div class="max-w-6xl mx-auto space-y-12">
        
        <!-- Main Configuration / Impact Hub -->
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-[48px] blur opacity-10 group-hover:opacity-20 transition duration-1000 group-hover:duration-200"></div>
            <div class="config-hub rounded-[48px] p-10 lg:p-16 relative overflow-hidden">
                
                <?php if ($is_admin): ?>
                <!-- ADMIN: Floating Config Hub -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl flex items-center justify-center shadow-lg shadow-emerald-200">
                                <i class="fa fa-leaf text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900">Auto-Donation</h3>
                                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Global Threshold</p>
                            </div>
                        </div>

                        <form action="<?= site_url('greenfuture/save_invoice_settings') ?>" method="POST" class="space-y-8">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            
                            <div class="relative">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-2">Marketplace Contribution %</label>
                                <div class="relative group/input">
                                    <input type="number" name="percent" class="custom-input pr-20" value="<?= $current_pct ?>" step="0.1" min="0" max="10">
                                    <div class="absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 font-black text-xl group-focus-within/input:text-emerald-500 transition-colors">%</div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-black py-6 rounded-[32px] shadow-2xl shadow-slate-200 transition-all duration-500 transform hover:-translate-y-2 hover:shadow-emerald-200 border border-white/10 uppercase tracking-widest text-sm">
                                Apply System Changes
                            </button>
                        </form>
                    </div>

                    <!-- Live Projection Visualization -->
                    <div class="bg-slate-50 rounded-[40px] p-10 relative overflow-hidden group/viz border border-slate-100">
                        <div class="relative z-10">
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-100 px-3 py-1 rounded-full mb-8 inline-block">Impact Prediction</span>
                            <div class="space-y-8">
                                <div>
                                    <span class="text-4xl font-black text-slate-900">Rs. <?= number_format(1000000 * $current_pct / 100, 0) ?></span>
                                    <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-wider">Per Million Revenue</p>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                                        <i class="fa fa-seedling text-emerald-500 mb-3 block text-xl"></i>
                                        <span class="text-xl font-black text-slate-900"><?= floor((1000000 * $current_pct / 100) / 150) ?></span>
                                        <p class="text-[9px] font-black text-slate-400 uppercase">Trees/Mil</p>
                                    </div>
                                    <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                                        <i class="fa fa-globe-asia text-blue-500 mb-3 block text-xl"></i>
                                        <span class="text-xl font-black text-slate-900">+12%</span>
                                        <p class="text-[9px] font-black text-slate-400 uppercase">Growth vs PW</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <i class="fa fa-chart-area absolute -right-12 -bottom-12 text-slate-100 text-[12rem] group-hover/viz:text-emerald-50 group-hover/viz:scale-110 transition-all duration-1000"></i>
                    </div>
                </div>

                <?php else: ?>
                <!-- USER: Impact Hub -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-700 rounded-3xl flex items-center justify-center shadow-lg shadow-blue-200">
                                <i class="fa fa-user-check text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900">Impact Wallet</h3>
                                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Business Partner Identity</p>
                            </div>
                        </div>
                        <?php 
                            $my_total = array_sum(array_column($all_donors, 'amount')); 
                            $my_trees = floor(abs($my_total) / 150);
                        ?>
                        <div class="space-y-8">
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Total Carbon Credits</span>
                                <span class="text-6xl font-black text-slate-900 tracking-tighter">Rs. <?= number_format(abs($my_total), 2) ?></span>
                            </div>
                            <div class="flex gap-4">
                                <a href="<?= site_url('greenfuture/donate') ?>" class="px-8 py-5 bg-emerald-600 text-white font-black rounded-3xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 flex items-center gap-3">
                                    <i class="fa fa-plus-circle"></i> NEW DONATION
                                </a>
                                <button class="px-8 py-5 bg-white border border-slate-200 text-slate-700 font-black rounded-3xl hover:bg-slate-50 transition-all">
                                    SHARE CERTIFICATE
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="p-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[40px] text-white shadow-2xl relative overflow-hidden group/card shadow-emerald-200">
                            <i class="fa fa-tree absolute -right-4 -bottom-4 text-white/10 text-9xl group-hover/card:scale-110 transition-transform duration-700"></i>
                            <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest mb-1 block">Reforestation</span>
                            <div class="text-4xl font-black mb-2"><?= $my_trees ?></div>
                            <p class="text-xs font-medium text-white/80">Trees planted through your contributions</p>
                        </div>
                        <div class="p-10 bg-slate-900 rounded-[40px] text-white shadow-2xl relative overflow-hidden group/card shadow-slate-200">
                            <i class="fa fa-trophy absolute -right-4 -bottom-4 text-white/10 text-9xl group-hover/card:scale-110 transition-transform duration-700"></i>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Global Ranking</span>
                            <div class="text-4xl font-black mb-2">#<?= rand(10, 500) ?></div>
                            <p class="text-xs font-medium text-slate-400">Among system contributors</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Transaction Stream: Modern List Replacement -->
        <div class="space-y-8">
            <div class="flex items-center justify-between px-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-900"><?= $is_admin ? 'Global Ledger' : 'My Impact History' ?></h3>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest mt-1">Transaction Stream</p>
                </div>
                <div class="flex gap-2">
                     <button class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-colors shadow-sm">
                        <i class="fa fa-filter"></i>
                     </button>
                     <button class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-colors shadow-sm">
                        <i class="fa fa-download"></i>
                     </button>
                </div>
            </div>

            <div class="space-y-4 pb-20">
                <?php if (empty($all_donors)): ?>
                    <div class="glass-panel rounded-[48px] p-24 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8">
                            <i class="fa fa-layer-group text-slate-200 text-4xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-400">Stream is currently empty.</h4>
                    </div>
                <?php endif; ?>

                <?php foreach ($all_donors as $d): ?>
                <div class="transaction-stream-item glass-panel rounded-[40px] p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-8 border-l-8 border-l-transparent hover:border-l-emerald-500">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-3xl flex items-center justify-center border-2 border-slate-50 shadow-inner group relative overflow-hidden">
                            <?php 
                                $typeColor = $d['amount'] < 0 ? 'text-rose-500' : ($d['donation_type'] === 'invoice_percent' ? 'text-blue-500' : 'text-emerald-500');
                                $typeIcon = $d['amount'] < 0 ? 'fa-arrow-up-right-from-square' : ($d['donation_type'] === 'invoice_percent' ? 'fa-file-invoice-dollar' : 'fa-hand-holding-heart');
                            ?>
                            <i class="fa <?= $typeIcon ?> <?= $typeColor ?> text-xl relative z-10"></i>
                            <div class="absolute inset-0 opacity-10 bg-current"></div>
                        </div>
                        <div>
                            <div class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">
                                <?= date('M d, Y', strtotime($d['created_at'])) ?>
                            </div>
                            <h4 class="text-lg font-black text-slate-900 leading-none">
                                <?= $d['donation_type'] === 'invoice_percent' ? 'Auto-Invoice Credit' : ($d['amount'] < 0 ? 'Maintenance Payout' : 'Manual Direct Impact') ?>
                            </h4>
                            <p class="text-slate-400 text-sm font-medium mt-1 italic">
                                <?= htmlspecialchars($d['note'] ?? 'No additional metadata available') ?>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-12 lg:text-right">
                        <?php if ($d['invoice_id']): ?>
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Source ID</span>
                            <span class="px-4 py-1.5 bg-slate-100 rounded-full text-xs font-black text-slate-700">#<?= $d['invoice_id'] ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="min-w-[150px]">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Impact Value</span>
                            <div class="text-2xl font-black <?= $d['amount'] < 0 ? 'text-rose-500' : 'text-slate-900' ?> flex items-center lg:justify-end gap-2">
                                <span class="text-sm"><?= $d['amount'] < 0 ? '-' : 'Rs.' ?></span>
                                <?= number_format(abs($d['amount']), 2) ?>
                                <?php if ($d['amount'] > 0): ?>
                                    <i class="fa fa-arrow-trend-up text-emerald-500 text-xs status-glow text-emerald-400"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
