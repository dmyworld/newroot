<div class="content-body">
    <div class="max-w-7xl mx-auto py-12 px-4 md:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div data-aos="fade-right">
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase mb-2">
                    Earnings <span class="text-primary italic">& Payroll</span>
                </h1>
                <p class="text-slate-500 font-medium">Detailed breakdown for <?= date('F Y', strtotime("$year-$month-01")) ?></p>
            </div>
            
            <div class="flex gap-4" data-aos="fade-left">
                <form class="flex gap-2">
                    <select name="month" class="px-4 py-3 bg-white border border-slate-100 rounded-xl font-bold text-sm outline-none focus:border-primary transition-colors">
                        <?php for($m=1; $m<=12; $m++): ?>
                            <option value="<?= sprintf('%02d', $m) ?>" <?= $month == sprintf('%02d', $m) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0,0,0,$m,1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                    <select name="year" class="px-4 py-3 bg-white border border-slate-100 rounded-xl font-bold text-sm outline-none focus:border-primary transition-colors">
                        <?php for($y=date('Y'); $y>=2025; $y--): ?>
                            <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-black text-sm hover:bg-black transition-all">Filter</button>
                </form>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12" data-aos="fade-up">
            <div class="card bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-blue-50 border-0 group hover:-translate-y-2 transition-all duration-500">
                <div class="w-12 h-12 bg-primary bg-opacity-10 text-primary rounded-xl flex items-center justify-center mb-6">
                    <i class="fa fa-clock text-xl"></i>
                </div>
                <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.2em] mb-2">Tracked Time</p>
                <h2 class="text-4xl font-black text-slate-800 tracking-tighter italic">
                    <?= number_format($earnings['total_hours'], 1) ?> <span class="text-lg font-bold text-slate-400 non-italic">Hrs</span>
                </h2>
                <div class="mt-6 flex items-center text-xs font-bold text-slate-400">
                    <span class="w-2 h-2 bg-primary rounded-full mr-2"></span>
                    From <?= $earnings['logs_count'] ?> verified sessions
                </div>
            </div>

            <div class="card bg-primary rounded-[2.5rem] p-10 shadow-2xl shadow-blue-200 border-0 text-white relative overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="w-12 h-12 bg-white bg-opacity-20 text-white rounded-xl flex items-center justify-center mb-6">
                    <i class="fa fa-coins text-xl"></i>
                </div>
                <p class="text-blue-200 font-black uppercase text-[10px] tracking-[0.2em] mb-2">Projected Earnings</p>
                <h2 class="text-4xl font-black tracking-tighter italic">
                    LKR <?= number_format($earnings['total_earnings'], 0) ?>
                </h2>
                <div class="mt-6 flex items-center text-xs font-bold text-blue-100 italic">
                    Rate: LKR <?= number_format($earnings['hourly_rate'], 0) ?> / Hr
                </div>
            </div>

            <div class="card bg-slate-900 rounded-[2.5rem] p-10 shadow-2xl shadow-slate-200 border-0 text-white group hover:-translate-y-2 transition-all duration-500">
                <div class="w-12 h-12 bg-white bg-opacity-10 text-white rounded-xl flex items-center justify-center mb-6">
                    <i class="fa fa-calendar-check text-xl"></i>
                </div>
                <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.2em] mb-2">Payout Schedule</p>
                <h2 class="text-3xl font-black tracking-tighter italic">Last Friday</h2>
                <div class="mt-6 flex items-center text-xs font-bold text-slate-500">
                    <i class="fa fa-info-circle mr-2"></i> Monthly reconciliation cycle
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="card bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-xl font-black text-slate-800 lowercase tracking-tighter">Detailed Session Log</h3>
                <button class="text-primary font-bold text-sm hover:underline"><i class="fa fa-download mr-1"></i> Export PDF</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-10 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date / Session ID</th>
                            <th class="px-10 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Duration</th>
                            <th class="px-10 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Est. Earnings</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach($history as $row): 
                            $from = strtotime($row['tfrom']);
                            $to = $row['tto'] ? strtotime($row['tto']) : false;
                            $diff = $to ? ($to - $from) / 3600 : 0;
                            $row_earnings = $diff * $earnings['hourly_rate'];
                        ?>
                        <tr class="hover:bg-slate-50 group transition-all">
                            <td class="px-10 py-6">
                                <div class="font-black text-slate-800 italic"><?= $row['adate'] ?></div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                                    <?= $row['tfrom'] ?> - <?= $row['tto'] ?: 'Active' ?>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <div class="inline-flex px-4 py-2 bg-slate-50 rounded-xl font-black text-slate-600 text-sm italic group-hover:bg-white transition-colors">
                                    <?= number_format($diff, 2) ?> Hrs
                                </div>
                            </td>
                            <td class="px-10 py-6 text-right font-black text-slate-900 italic">
                                LKR <?= number_format($row_earnings, 0) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($history)): ?>
                        <tr>
                            <td colspan="3" class="px-10 py-20 text-center text-slate-400 font-bold italic">No sessions recorded in this period</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
