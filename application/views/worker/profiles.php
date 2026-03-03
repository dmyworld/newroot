<div class="content-body">
    <div class="card bg-transparent border-0">
        <div class="card-header bg-transparent pb-0">
            <h1 class="font-black text-2xl uppercase tracking-tighter text-slate-800">
                Professional <span class="text-primary">Workforce</span> Hub
            </h1>
            <p class="text-slate-500 font-medium italic">Audit, verify and hire specialized talent across your locations.</p>
        </div>
        
        <div class="card-content mt-8">
            <div class="row">
                <?php foreach ($profiles as $row): 
                    $initials = strtoupper(substr($row['display_name'], 0, 2));
                    $status_color = 'bg-primary';
                    if($row['status'] == 'busy') $status_color = 'bg-warning';
                    if($row['status'] == 'unavailable') $status_color = 'bg-danger';
                ?>
                <div class="col-xl-4 col-md-6 col-sm-12">
                    <div class="card group shadow-sm border-0 bg-white" style="border-radius: 2rem; overflow: hidden; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                        <div class="card-body p-0">
                            <!-- Header / Cover -->
                            <div class="p-8 pb-12 bg-light bg-opacity-30 relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent"></div>
                                <div class="relative z-10 flex justify-between items-start">
                                    <div class="w-20 h-20 rounded-2xl bg-white shadow-xl flex items-center justify-center text-primary text-2xl font-black overflow-hidden border border-white">
                                        <?php if(!empty($row['photo'])): ?>
                                            <img src="<?= base_url($row['photo']) ?>" alt="<?= $row['display_name'] ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <?= $initials ?>
                                        <?php endif; ?>
                                    </div>
                                    <span class="badge <?= $status_color ?> bg-opacity-10 text-primary border-0 rounded-pill px-3 py-2 font-black text-[10px] uppercase tracking-widest">
                                        <?= strtoupper($row['availability'] ?? 'Available') ?>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Body -->
                            <div class="p-8 -mt-8 relative z-10 bg-white rounded-[2rem]">
                                <h4 class="font-black text-xl text-slate-800 mb-1 group-hover:text-primary transition-colors">
                                    <?= htmlspecialchars($row['display_name']) ?>
                                </h4>
                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-6">
                                    <i class="fa fa-envelope mr-1 text-primary"></i> <?= htmlspecialchars($row['email']) ?>
                                </p>
                                
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="p-4 bg-slate-50 rounded-2xl">
                                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-1">Experience</p>
                                        <p class="font-black text-slate-800 italic"><?= $row['experience_years'] ?> Yrs</p>
                                    </div>
                                    <div class="p-4 bg-slate-50 rounded-2xl">
                                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-1">Rate / Hr</p>
                                        <p class="font-black text-primary italic">LKR <?= number_format($row['hourly_rate'], 0) ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center text-slate-500 font-bold text-sm mb-8">
                                    <i class="fa fa-map-marker-alt mr-2 text-danger"></i>
                                    <?= $row['location'] ?>
                                </div>

                                <div class="flex gap-2">
                                    <a href="<?= base_url('worker/view/' . $row['id']) ?>" class="flex-1 btn btn-light-primary font-black rounded-xl py-4 border-0">
                                        View Profile
                                    </a>
                                    <?php if($row['availability'] == 'available'): ?>
                                        <button onclick="hireDirect(<?= $row['id'] ?>, '<?= $row['display_name'] ?>')" class="flex-[1.5] btn btn-primary font-black rounded-xl py-4 shadow-lg shadow-blue-100 border-0 transition-transform active:scale-95">
                                            Quick Hire
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-light-primary { background: #eff6ff; color: #2563eb; }
    .btn-light-primary:hover { background: #dbeafe; }
</style>

<script>
function hireDirect(id, name) {
    if(confirm('Are you sure you want to hire ' + name + '? They will be added to your employee list.')) {
        const formData = new FormData();
        formData.append('worker_id', id);
        formData.append('salary', '0'); // Will be updated in employee profile if needed
        
        fetch('<?= base_url("worker/hire") ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            window.location.reload();
        });
    }
}
</script>
