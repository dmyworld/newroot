<div class="content-body">
    <div class="card bg-transparent border-0">
        <div class="card-header bg-transparent pb-0 flex justify-between items-center">
            <div>
                <h1 class="font-black text-2xl uppercase tracking-tighter text-slate-800">
                    Live <span class="text-primary italic">Attendance</span> & Payroll
                </h1>
                <p class="text-slate-500 font-medium mt-1">Real-time status of your location's professional workforce.</p>
            </div>
            <div class="flex gap-2">
                <div class="px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">System Live</span>
                </div>
            </div>
        </div>

        <div class="card-content mt-8">
            <div class="card bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="attendanceTable" class="w-full text-left">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Professional</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Location</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-center">Status</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Last Punch</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-right">Daily Accrual</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php foreach ($attendance as $row): 
                                $is_active = (!empty($row['tfrom']) && empty($row['tto']));
                                $has_finished = (!empty($row['tto']));
                                
                                $status_text = 'Offline';
                                $status_class = 'bg-slate-100 text-slate-400';
                                if($is_active) {
                                    $status_text = 'On-Shift';
                                    $status_class = 'bg-green-100 text-green-600';
                                } else if($has_finished) {
                                    $status_text = 'Completed';
                                    $status_class = 'bg-blue-100 text-blue-600';
                                }

                                // Estimate pay for today
                                $diff = 0;
                                if($row['tfrom'] && $row['tto']) {
                                    $diff = (strtotime($row['tto']) - strtotime($row['tfrom'])) / 3600;
                                } else if($row['tfrom']) {
                                    $diff = (time() - strtotime($row['tfrom'])) / 3600;
                                }
                                $rate = 500; // Default or fetch from profile
                                $accrual = $diff * $row['salary']; // Using salary field as rate if appropriately set
                            ?>
                            <tr class="hover:bg-slate-50/50 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="font-black text-slate-800 italic group-hover:text-primary transition-colors">
                                        <?= htmlspecialchars($row['name']) ?>
                                    </div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">@<?= htmlspecialchars($row['username']) ?></div>
                                </td>
                                <td class="px-8 py-6 text-slate-500 font-bold text-sm">
                                    <i class="ft-map-pin mr-2 opacity-30 text-primary"></i>
                                    <?= $this->locations->get_location_name($row['loc']) ?>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-flex items-center px-3 py-1 <?= $status_class ?> text-[10px] font-black rounded-full uppercase tracking-tighter">
                                        <?= $status_text ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <?php if($row['tfrom']): ?>
                                        <div class="text-xs font-black text-slate-700 italic"><?= $row['tfrom'] ?></div>
                                        <div class="text-[9px] font-bold text-slate-300 uppercase mt-1">Involved at <?= $row['adate'] ?></div>
                                    <?php else: ?>
                                        <div class="text-slate-300 italic text-sm">No log today</div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="font-black text-slate-900 italic">LKR <?= number_format($accrual, 0) ?></div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1"><?= number_format($diff, 1) ?> Hours tracked</div>
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

<script type="text/javascript">
$(document).ready(function () {
    $('#attendanceTable').DataTable({
        'responsive': true,
        'order': [[2, 'desc']],
        "dom": '<"p-8 pb-0"f>t<"p-8 pt-4 flex justify-between"ip>'
    });
});
</script>
