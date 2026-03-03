<?php $this->load->view('green_future/hero_premium'); ?>

<div class="max-w-7xl mx-auto px-6 py-12">
    
    <!-- DASHBOARD ACTIONS -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-12">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight flex items-center">
            <i class="fa fa-chart-line text-green-600 mr-3"></i> Initiative Dashboard
        </h2>
        
        <div class="flex flex-wrap gap-3">
             <a href="<?= site_url('greenfuture/apply_maintenance') ?>" 
                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fa fa-camera mr-2 text-amber-500"></i> Maintenance Apply
             </a>
             <?php if ($is_admin): ?>
                 <a href="<?= site_url('greenfuture/maintenance') ?>" 
                    class="px-5 py-2.5 bg-slate-900 text-white font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-colors shadow-lg">
                    <i class="fa fa-cog mr-2 text-green-400"></i> Admin Panel
                 </a>
             <?php endif; ?>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="mb-8 bg-green-500 text-white px-6 py-4 rounded-2xl font-bold flex items-center shadow-lg shadow-green-200">
        <i class="fa fa-check-circle mr-3"></i> <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>

    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        
        <!-- Fund Card -->
        <div class="bg-white rounded-[32px] p-8 border border-green-100 shadow-xl shadow-green-50/50 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 text-xl">
                    <i class="fa fa-sack-dollar"></i>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Fund Balance</div>
                <div class="text-3xl font-black text-slate-900 mb-4">Rs. <?= number_format($fund_balance, 0) ?></div>
                <div class="flex text-[9px] font-bold text-slate-400 gap-3 border-t border-slate-50 pt-4">
                    <span>IN: <?= number_format($breakdown['manual'] + $breakdown['invoice'], 0) ?></span>
                    <span class="text-slate-300">|</span>
                    <span>OUT: <?= number_format($breakdown['payouts'] + $breakdown['maint'], 0) ?></span>
                </div>
            </div>
        </div>

        <!-- Trees Card -->
        <div class="bg-white rounded-[32px] p-8 border border-emerald-100 shadow-xl shadow-emerald-50/50 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 text-xl">
                    <i class="fa fa-tree"></i>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Impact Made</div>
                <div class="text-3xl font-black text-slate-900 mb-4"><?= number_format($stats['total_planted']) ?> <span class="text-sm font-bold text-slate-400">Trees</span></div>
                <div class="flex text-[9px] font-bold text-slate-400 gap-3 border-t border-slate-50 pt-4">
                    <span>TARGET: 1B</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-emerald-500 font-black">PROG: <?= number_format(($stats['total_planted']/1000000)*100, 4) ?>%</span>
                </div>
            </div>
        </div>

        <!-- Donors Card -->
        <div class="bg-white rounded-[32px] p-8 border border-blue-100 shadow-xl shadow-blue-50/50 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 text-xl">
                    <i class="fa fa-users"></i>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Global Community</div>
                <div class="text-3xl font-black text-slate-900 mb-4"><?= $stats['total_donors'] ?> <span class="text-sm font-bold text-slate-400">Heroes</span></div>
                <div class="text-[9px] font-bold text-slate-400 border-t border-slate-50 pt-4 uppercase">
                    Joined in last 30 days: <span class="text-blue-600">8 new</span>
                </div>
            </div>
        </div>

        <!-- Maintenance Card -->
        <div class="bg-white rounded-[32px] p-8 border border-amber-100 shadow-xl shadow-amber-50/50 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-6 text-xl">
                    <i class="fa fa-hand-holding-heart"></i>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Social Responsibility</div>
                <div class="text-3xl font-black text-slate-900 mb-4"><?= $stats['maintenance_active'] ?> <span class="text-sm font-bold text-slate-400">Claims</span></div>
                <div class="text-[9px] font-bold text-slate-400 border-t border-slate-50 pt-4 uppercase">
                    Payouts: <span class="text-amber-600">Rs. <?= number_format($stats['total_payouts'], 0) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN DASHBOARD PANELS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left: Recent Donors -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-[40px] shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-black text-slate-900 uppercase tracking-wider text-xs flex items-center">
                        <i class="fa fa-heart text-red-500 mr-2"></i> Recent Contributions
                    </h3>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        <?php if (empty($recent_donors)): ?>
                            <div class="py-12 text-center">
                                <i class="fa fa-leaf text-slate-200 text-4xl mb-4"></i>
                                <p class="text-slate-400 font-bold text-sm">Waiting for the first impact...</p>
                            </div>
                        <?php endif; ?>
                        <?php foreach($recent_donors as $row): ?>
                        <div class="flex items-center p-4 bg-slate-50/50 rounded-2xl border border-transparent hover:border-green-100 hover:bg-white transition-all group">
                            <div class="w-10 h-10 <?= $row['donation_type'] === 'invoice_percent' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' ?> rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <i class="fa <?= $row['donation_type'] === 'invoice_percent' ? 'fa-file-invoice' : 'fa-hand-holding-heart' ?> text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-black text-slate-900">Rs. <?= number_format($row['amount'], 2) ?></div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                    <?= date('M d', strtotime($row['created_at'])) ?> • <?= htmlspecialchars($row['donation_type']) ?>
                                </div>
                            </div>
                            <?php if(!empty($row['note'])): ?>
                                <div class="text-[10px] text-slate-300 italic max-w-[100px] truncate"><?= htmlspecialchars($row['note']) ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Auto-donation Alert -->
            <?php if ($inv_percent > 0): ?>
            <div class="bg-gradient-to-br from-green-600 to-emerald-700 p-8 rounded-[40px] text-white shadow-xl shadow-green-100 relative overflow-hidden">
                <i class="fa fa-percent absolute -bottom-4 -right-4 text-white/10 text-8xl"></i>
                <div class="relative z-10">
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-white/70 mb-2">Automated Impact</div>
                    <h4 class="text-xl font-black mb-3"><?= $inv_percent ?>% Pledge Active</h4>
                    <p class="text-sm text-white/80 leading-relaxed font-body">
                        A portion of every marketplace transaction is automatically diverted to this fund to support Sri Lanka's green cover.
                    </p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right: Planting Drives -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-[40px] shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden h-full">
                <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-black text-slate-900 uppercase tracking-wider text-xs flex items-center">
                        <i class="fa fa-seedling text-emerald-500 mr-2"></i> Active Planting Drives
                    </h3>
                    <a href="<?= site_url('greenfuture/planting_list') ?>" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">View All</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Location</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Species</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Progress</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if (empty($recent_plants)): ?>
                                <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold text-sm italic">No active drives recorded recently.</td></tr>
                            <?php endif; ?>
                            <?php foreach($recent_plants as $row): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="font-black text-slate-900 text-sm"><?= htmlspecialchars($row['district']) ?></div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mt-1 italic">Verified Drive</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-bold text-slate-700 text-xs"><?= htmlspecialchars($row['tree_species']) ?></div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-1.5 w-24 bg-slate-100 rounded-full overflow-hidden">
                                            <?php $pct = ($row['trees_planted'] / max(1, $row['trees_requested'])) * 100; ?>
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: <?= $pct ?>%"></div>
                                        </div>
                                        <span class="text-[10px] font-black text-slate-900"><?= $row['trees_planted'] ?></span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <?php
                                    $theme = [
                                        'pending'  => 'bg-amber-100 text-amber-600',
                                        'approved' => 'bg-blue-100 text-blue-600',
                                        'planted'  => 'bg-green-600 text-white',
                                        'rejected' => 'bg-red-100 text-red-600'
                                    ][$row['status']] ?? 'bg-slate-100 text-slate-600';
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest <?= $theme ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- NATURE ACCENTS -->
<div class="fixed bottom-0 right-0 p-12 pointer-events-none opacity-5 flex flex-col items-center">
    <i class="fa fa-tree text-9xl text-green-900"></i>
    <span class="font-black text-4xl mt-4">GREEN FUTURE</span>
</div>
