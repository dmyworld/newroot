<div class="max-w-7xl mx-auto px-6 py-12">
    
    <!-- PAGE HEADER -->
    <div class="flex flex-wrap items-center justify-between gap-6 mb-12">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Planting Records</h2>
            <p class="text-slate-500 text-sm mt-1">Real-time transparency of reforestation efforts across Sri Lanka.</p>
        </div>
        <div class="flex gap-3">
            <a href="<?= site_url('greenfuture/plant') ?>" 
               class="px-6 py-3 bg-green-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-green-700 transition-all shadow-lg shadow-green-100">
               <i class="fa fa-plus mr-2"></i> New Request
            </a>
            <a href="<?= site_url('greenfuture') ?>" 
               class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-slate-50 transition-all">
               ← Dashboard
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="mb-8 bg-green-500 text-white px-6 py-4 rounded-2xl font-bold shadow-lg shadow-green-100 flex items-center">
        <i class="fa fa-check-circle mr-3"></i> <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>

    <!-- FILTERS BAR -->
    <div class="bg-white rounded-[32px] p-6 border border-slate-100 shadow-xl shadow-slate-100 mb-8">
        <form method="GET" class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="district" value="<?= htmlspecialchars($this->input->get('district')) ?>" 
                       class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-green-500/20" 
                       placeholder="Filter by District...">
            </div>
            <div class="w-48">
                <select name="status" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-green-500/20">
                    <option value="">All Statuses</option>
                    <?php foreach(['pending', 'approved', 'planted', 'rejected'] as $st): ?>
                    <option value="<?= $st ?>" <?= $this->input->get('status')==$st?'selected':'' ?>><?= ucfirst($st) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="bg-slate-900 text-white px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">
                Filter
            </button>
            <a href="<?= site_url('greenfuture/planting_list') ?>" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600">Reset</a>
        </form>
    </div>

    <!-- DATA TABLE -->
    <div class="bg-white rounded-[40px] shadow-2xl shadow-slate-100 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Drive Info</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Species</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Progress</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Verifications</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($requests)): ?>
                    <tr><td colspan="6" class="px-8 py-20 text-center text-slate-400 font-bold text-sm italic">No records found matching filters.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($requests as $r): ?>
                    <tr class="hover:bg-slate-50/10 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="font-black text-slate-900 mb-1">REQ-<?= str_pad($r['id'], 5, '0', STR_PAD_LEFT) ?></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= htmlspecialchars($r['district']) ?>, <?= htmlspecialchars($r['province'] ?? '') ?></div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-50 border border-slate-100 rounded-lg text-xs font-bold text-slate-700">
                                <i class="fa fa-seedling text-green-500"></i>
                                <?= htmlspecialchars($r['tree_species']) ?>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <?php $pct = ($r['trees_planted'] / max(1, $r['trees_requested'])) * 100; ?>
                                    <div class="h-full bg-green-500 rounded-full" style="width: <?= $pct ?>%"></div>
                                </div>
                                <span class="text-xs font-black text-slate-900"><?= $r['trees_planted'] ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                <?php foreach(['GN'=>'grama_niladhari_cert', 'SB'=>'sabhapathi_cert'] as $label => $key): ?>
                                    <?php if (!empty($r[$key])): ?>
                                        <a href="<?= base_url($r[$key]) ?>" target="_blank" 
                                           class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-[10px] font-black hover:bg-green-600 hover:text-white transition-all shadow-sm" 
                                           title="Verified: <?= $label ?>">
                                            <?= $label ?>
                                        </a>
                                    <?php else: ?>
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-300 flex items-center justify-center text-[10px] font-black cursor-not-allowed" title="Pending: <?= $label ?>">
                                            <?= $label ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <?php 
                            $theme = ['pending'=>'bg-amber-100 text-amber-600','approved'=>'bg-blue-100 text-blue-600','planted'=>'bg-green-600 text-white','rejected'=>'bg-red-100 text-red-600'][$r['status']] ?? 'bg-slate-100 text-slate-600';
                            ?>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.1em] <?= $theme ?> shadow-sm shadow-black/5">
                                <?= $r['status'] ?>
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="window.location.href='#uploadModal<?= $r['id'] ?>'" 
                                        class="p-2.5 bg-white border border-slate-200 text-slate-400 rounded-xl hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 transition-all shadow-sm">
                                    <i class="fa fa-upload text-sm"></i>
                                </button>
                                <?php if ($is_admin): ?>
                                    <?php if($r['status'] === 'pending'): ?>
                                    <a href="<?= site_url('greenfuture/approve_planting/'.$r['id']) ?>" 
                                       onclick="return confirm('Approve this request?')"
                                       class="p-2.5 bg-white border border-slate-200 text-slate-400 rounded-xl hover:text-green-600 hover:border-green-100 hover:bg-green-50 transition-all shadow-sm">
                                        <i class="fa fa-check text-sm"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('greenfuture/payout/'.$r['id']) ?>" 
                                       class="p-2.5 bg-white border border-slate-200 text-slate-400 rounded-xl hover:text-amber-600 hover:border-amber-100 hover:bg-amber-50 transition-all shadow-sm">
                                        <i class="fa fa-dollar-sign text-sm"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
