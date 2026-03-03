<?php defined('BASEPATH') OR exit; ?>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Outfit', sans-serif; }
    
    .mesh-gradient {
        background: radial-gradient(at 0% 0%, rgba(245, 158, 11, 0.05) 0px, transparent 50%),
                    radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.05) 0px, transparent 50%),
                    radial-gradient(at 0% 100%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(24px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .glass-card:hover {
        transform: translateY(-12px) scale(1.02);
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.08);
    }

    .hover-zoom-img {
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .glass-card:hover .hover-zoom-img {
        transform: scale(1.1);
    }

    .side-drawer {
        transition: transform 0.6s cubic-bezier(0.85, 0, 0.15, 1);
    }

    .pill-glow {
        filter: drop-shadow(0 0 10px currentColor);
    }

    .floating-leaf {
        position: fixed;
        pointer-events: none;
        z-index: 0;
        opacity: 0.1;
        animation: float 25s linear infinite;
    }

    @keyframes float {
        0% { transform: translate(100vw, -10vh) rotate(0deg); }
        100% { transform: translate(-10vw, 110vh) rotate(360deg); }
    }
</style>

<!-- Background Accents -->
<div class="fixed inset-0 mesh-gradient -z-10"></div>
<i class="fa fa-leaf floating-leaf text-amber-500 text-6xl" style="top: 10%; left: 80%; animation-delay: 0s;"></i>
<i class="fa fa-leaf floating-leaf text-emerald-400 text-4xl" style="top: -5%; left: 40%; animation-delay: 7s;"></i>

<div class="content-body px-4 lg:px-20 py-16 min-h-screen relative z-10" x-data="{ openFilter: false }">
    
    <!-- Premium Header -->
    <div class="flex flex-col lg:flex-row items-center justify-between gap-10 mb-20 text-center lg:text-left">
        <div class="max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 bg-amber-500/10 text-amber-600 rounded-full text-[11px] font-black uppercase tracking-[0.2em] border border-amber-500/20 mb-6">
                <i class="fa fa-hand-holding-heart text-xs"></i>
                <span>Sanctuary Maintenance</span>
            </div>
            <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight mb-6">
                Stipend <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-emerald-600">Governance</span>
            </h1>
            <p class="text-slate-500 text-lg font-medium">
                <?= $is_admin ? 'Review and manage maintenance support requests from verified sanctuary owners nationwide.' : 'Securely track the progress of your maintenance fund applications and verified monthly payouts.' ?>
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <button @click="openFilter = true" class="w-16 h-16 bg-white border border-slate-200 rounded-[28px] flex items-center justify-center text-slate-400 hover:text-amber-500 transition-all shadow-xl shadow-slate-100/50 hover:shadow-amber-100 group">
                <i class="fa fa-sliders text-xl group-hover:scale-110 transition-transform"></i>
            </button>
            <a href="<?= site_url('greenfuture/apply_maintenance') ?>" 
               class="h-16 bg-slate-900 hover:bg-amber-600 text-white font-black px-10 rounded-[28px] shadow-2xl transition-all transform hover:-translate-y-2 flex items-center gap-3 uppercase tracking-widest text-xs">
                <i class="fa fa-plus-circle text-lg"></i> New Application
            </a>
        </div>
    </div>

    <!-- Active Filter Badge -->
    <?php if ($this->input->get('status')): ?>
    <div class="mb-10 flex justify-center lg:justify-start">
        <div class="px-6 py-3 bg-white/50 backdrop-blur-xl border border-amber-500/20 rounded-full flex items-center gap-4 shadow-sm">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Filter</span>
            <span class="px-4 py-1 bg-amber-500 text-white rounded-full text-[10px] font-black uppercase tracking-widest pill-glow">
                <?= $this->input->get('status') ?>
            </span>
            <a href="<?= site_url('greenfuture/maintenance') ?>" class="text-slate-300 hover:text-rose-500 transition-colors">
                <i class="fa fa-times-circle"></i>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Application Gallery: The Main Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
        <?php if (empty($applications)): ?>
        <div class="col-span-full py-32 text-center">
            <div class="w-32 h-32 bg-white/50 backdrop-blur rounded-[40px] flex items-center justify-center mx-auto mb-10 border border-slate-100">
                <i class="fa fa-ghost text-slate-200 text-5xl"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-300">No applications found</h3>
            <p class="text-slate-400 font-medium mt-2">Try adjusting your filters or start a new request.</p>
        </div>
        <?php endif; ?>

        <?php foreach ($applications as $a): ?>
        <div class="glass-card rounded-[48px] overflow-hidden flex flex-col relative">
            
            <!-- Image Header with Hover-Zoom -->
            <div class="h-64 relative overflow-hidden group/img">
                <?php if (!empty($a['photo_path'])): ?>
                    <img src="<?= base_url($a['photo_path']) ?>" class="w-full h-full object-cover hover-zoom-img">
                <?php else: ?>
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                        <i class="fa fa-camera text-slate-200 text-4xl"></i>
                    </div>
                <?php endif; ?>
                
                <!-- Floating Status Overlay -->
                <div class="absolute top-6 right-6">
                    <?php 
                        $themes = [
                            'pending' => 'bg-amber-500 text-white',
                            'verified' => 'bg-indigo-600 text-white',
                            'paid' => 'bg-emerald-500 text-white',
                            'rejected' => 'bg-rose-500 text-white'
                        ];
                        $st = $a['status'];
                    ?>
                    <span class="px-5 py-2 <?= $themes[$st] ?? 'bg-slate-500' ?> rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-xl pill-glow">
                        <?= $st ?>
                    </span>
                </div>

                <!-- Date Badge -->
                <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-2xl text-[10px] font-black text-slate-900 shadow-lg">
                    <?= date('d M Y', strtotime($a['created_at'])) ?>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-10 flex-1 flex flex-col">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-100/50 px-3 py-1 rounded-full mb-3 inline-block">Application #<?= $a['id'] ?></span>
                        <h4 class="text-2xl font-black text-slate-900 leading-tight"><?= htmlspecialchars($a['applicant_name']) ?></h4>
                        <div class="flex items-center gap-2 text-slate-400 font-bold text-xs mt-2 uppercase tracking-tighter">
                            <i class="fa fa-map-marker-alt text-rose-400"></i>
                            <?= htmlspecialchars($a['district']) ?>, <?= htmlspecialchars($a['province']) ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Tree Pool</span>
                        <div class="text-3xl font-black text-slate-900 leading-none"><?= $a['tree_count'] ?></div>
                    </div>
                </div>

                <!-- Description Snippet -->
                <div class="bg-slate-50 rounded-3xl p-6 mb-10 flex-1 border border-slate-100/50">
                    <p class="text-slate-500 text-xs font-medium leading-relaxed italic">
                        "<?= !empty($a['location_description']) ? htmlspecialchars(substr($a['location_description'], 0, 100)) . '...' : 'No detailed site description provided for this sanctuary location.' ?>"
                    </p>
                </div>

                <!-- Footer Actions & Info -->
                <div class="flex items-center justify-between mt-auto pt-8 border-t border-slate-100">
                    <div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Stipend Rate</span>
                        <span class="text-xl font-black text-emerald-600">Rs. <?= number_format($a['monthly_amount'], 0) ?></span>
                    </div>

                    <?php if ($is_admin): ?>
                    <div class="flex gap-2">
                        <?php if ($a['status'] === 'pending'): ?>
                        <button class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center hover:bg-indigo-600 transition-all shadow-xl hover:shadow-indigo-200 transform hover:-translate-y-1"
                                data-toggle="modal" data-target="#verifyModal<?= $a['id'] ?>">
                            <i class="fa fa-check-double"></i>
                        </button>
                        <?php endif; ?>
                        <?php if ($a['status'] === 'verified'): ?>
                        <a href="<?= site_url('greenfuture/pay_maintenance/'.$a['id']) ?>" 
                           onclick="return confirm('Process this monthly payout?')"
                           class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex items-center justify-center hover:bg-emerald-700 transition-all shadow-xl hover:shadow-emerald-200 transform hover:-translate-y-1">
                            <i class="fa fa-hand-holding-dollar"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-2xl group/status">
                        <i class="fa <?= $st === 'paid' ? 'fa-circle-check text-emerald-500' : 'fa-clock text-amber-500' ?> text-xs group-hover:animate-spin"></i>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest"><?= $st === 'paid' ? 'Secured' : 'In Review' ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Verification Modal -->
            <div class="modal fade" id="verifyModal<?= $a['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered lg:max-w-xl">
                    <div class="modal-content overflow-hidden border-0 rounded-[48px]" style="background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(32px); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <form action="<?= site_url('greenfuture/verify_maintenance/'.$a['id']) ?>" method="POST">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <div class="p-12">
                                <div class="flex items-center justify-between mb-10">
                                    <div>
                                        <h3 class="text-3xl font-black text-white leading-tight">Verification <span class="text-amber-500">Protocol</span></h3>
                                        <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-widest text-[10px]">Governance Panel #<?= $a['id'] ?></p>
                                    </div>
                                    <button type="button" class="w-12 h-12 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-rose-500 transition-all" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="space-y-8">
                                    <div class="flex items-center gap-6 bg-white/5 p-6 rounded-[32px] border border-white/10">
                                        <div class="w-16 h-16 rounded-2xl bg-amber-500/10 flex items-center justify-center border border-amber-500/30">
                                            <i class="fa fa-user-shield text-amber-500 text-2xl"></i>
                                        </div>
                                        <div>
                                            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Master Applicant</span>
                                            <span class="text-white font-black text-xl tracking-tight"><?= htmlspecialchars($a['applicant_name']) ?></span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="bg-white/5 p-6 rounded-[32px] border border-white/10">
                                            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Tree Cluster</span>
                                            <span class="text-emerald-400 font-black text-2xl"><?= $a['tree_count'] ?> Units</span>
                                        </div>
                                        <div class="bg-white/5 p-6 rounded-[32px] border border-white/10">
                                            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Regional Branch</span>
                                            <span class="text-white font-black text-lg"><?= htmlspecialchars($a['district']) ?></span>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 ml-2">Awarded Monthly Stipend (Rs.)</label>
                                        <input type="number" name="monthly_amount" 
                                               class="w-full bg-white/10 border-2 border-white/5 rounded-[32px] px-8 py-6 text-white text-3xl font-black focus:ring-8 focus:ring-emerald-500/10 focus:border-emerald-500/50 outline-none transition-all placeholder-white/20" 
                                               value="<?= $a['monthly_amount'] ?>" step="0.01" min="0" placeholder="0.00">
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-8 rounded-[36px] shadow-3xl shadow-emerald-900 transition-all transform hover:-translate-y-2 mt-12 uppercase tracking-widest text-sm border-t border-white/10">
                                    Authorize Payout Cycle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Side Drawer Filter: Implemented with simple Alpine-like logic or static hidden state -->
    <div x-show="openFilter" class="fixed inset-0 z-[100] overflow-hidden" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" @click="openFilter = false"></div>
        <div class="absolute inset-y-0 right-0 max-w-sm w-full bg-white shadow-3xl side-drawer flex flex-col p-12 overflow-y-auto">
            <div class="flex items-center justify-between mb-16">
                <h3 class="text-4xl font-black text-slate-900">Filters</h3>
                <button @click="openFilter = false" class="text-slate-300 hover:text-slate-900 transition-colors">
                    <i class="fa fa-times text-2xl"></i>
                </button>
            </div>

            <div class="space-y-12">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Application Status</label>
                    <div class="flex flex-col gap-3">
                        <?php foreach([''=>'All Streams','pending'=>'Pending Verification','verified'=>'Verified Pool','paid'=>'Completed Payouts','rejected'=>'Rejected Files'] as $val => $lbl): ?>
                            <a href="<?= site_url('greenfuture/maintenance') . ($val ? '?status='.$val : '') ?>"
                               class="px-8 py-5 rounded-3xl border-2 transition-all font-bold text-sm tracking-tight <?= ($this->input->get('status') == $val) ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-slate-50 bg-slate-50 text-slate-500 hover:border-slate-200' ?>">
                                <?= $lbl ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="pt-10 border-t border-slate-100 italic text-[10px] text-slate-400 font-bold leading-relaxed">
                    Filters are applied instantly. Use the 'All Streams' option to reset the view.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine-like Minimal JS for the Drawer -->
<script src="https://unpkg.com/alpinejs" defer></script>
