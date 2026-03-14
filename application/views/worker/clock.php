<div class="content-body">
    <div class="max-w-4xl mx-auto py-12 px-4 relative">
        
        <!-- SOS Button -->
        <div class="absolute top-4 right-4 text-center z-50">
            <button onclick="triggerSOS()" class="btn btn-danger rounded-circle shadow-lg" style="width: 70px; height: 70px; font-size: 28px; animation: pulse-ring 1.5s infinite;">
                <i class="fa fa-exclamation-triangle"></i>
            </button>
            <div class="text-xs font-black text-danger mt-2 uppercase tracking-widest">SOS Panic</div>
        </div>

        <!-- Digital Clock & Hero -->
        <div class="text-center mb-16" data-aos="zoom-in">
            <div class="inline-flex items-center px-4 py-2 bg-primary bg-opacity-10 text-primary rounded-full text-xs font-black uppercase tracking-widest mb-6 border border-primary border-opacity-20">
                <i class="fa fa-clock mr-2"></i> Real-time Performance Tracking
            </div>
            <h1 id="currentTime" class="text-7xl md:text-8xl font-black text-slate-900 tracking-tighter mb-4 italic">00:00:00</h1>
            <p id="currentDate" class="text-xl text-slate-500 font-bold uppercase tracking-widest">Tuesday, 3rd March 2026</p>
        </div>

        <!-- Clocking Controls -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <?php 
                $is_clocked_in = (!empty($status) && empty($status['tto']));
            ?>
            
            <div class="card bg-white rounded-[3rem] shadow-2xl shadow-blue-100 overflow-hidden border-0 group transition-all duration-500 hover:-translate-y-2">
                <div class="p-10">
                    <div class="w-16 h-16 rounded-2xl bg-success bg-opacity-10 text-success flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">
                        <i class="fa fa-sign-in-alt"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">Shift Start</h3>
                    <p class="text-slate-500 font-medium mb-10">Mark your arrival and begin your tracked professional session.</p>
                    
                    <form method="post" action="<?= base_url('worker/clock') ?>" onsubmit="return attachGPS(this, event)">
                        <input type="hidden" name="action" value="clock_in">
                        <input type="hidden" name="lat" class="lat-input" value="">
                        <input type="hidden" name="lng" class="lng-input" value="">
                        <button type="submit" 
                                <?= $is_clocked_in ? 'disabled' : '' ?>
                                class="w-full py-5 <?= $is_clocked_in ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-success text-white shadow-lg shadow-green-200 hover:bg-green-600' ?> rounded-2xl font-black text-lg transition-all active:scale-95">
                            <?= $is_clocked_in ? 'Already Working' : 'Punch In Now' ?>
                        </button>
                    </form>
                </div>
                <?php if($is_clocked_in): ?>
                <div class="px-10 py-4 bg-green-50 text-green-600 text-sm font-bold flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3 animate-pulse"></span>
                    Started at: <?= $status['tfrom'] ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="card bg-white rounded-[3rem] shadow-2xl shadow-blue-100 overflow-hidden border-0 group transition-all duration-500 hover:-translate-y-2">
                <div class="p-10">
                    <div class="w-16 h-16 rounded-2xl bg-danger bg-opacity-10 text-danger flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">
                        <i class="fa fa-sign-out-alt"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">Shift End</h3>
                    <p class="text-slate-500 font-medium mb-10">Complete your session to finalize hours and calculate earnings.</p>
                    
                    <form method="post" action="<?= base_url('worker/clock') ?>" onsubmit="return attachGPS(this, event)">
                        <input type="hidden" name="action" value="clock_out">
                        <input type="hidden" name="lat" class="lat-input" value="">
                        <input type="hidden" name="lng" class="lng-input" value="">
                        <button type="submit" 
                                <?= !$is_clocked_in ? 'disabled' : '' ?>
                                class="w-full py-5 <?= !$is_clocked_in ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-danger text-white shadow-lg shadow-red-200 hover:bg-red-600' ?> rounded-2xl font-black text-lg transition-all active:scale-95">
                            <?= !$is_clocked_in ? 'Offline' : 'Punch Out' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Recent Logs -->
        <div class="card bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-xl font-black text-slate-800 lowercase tracking-tighter">Recent Session History</h3>
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Last 10 Entries</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-10 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date</th>
                            <th class="px-10 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Start</th>
                            <th class="px-10 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">End</th>
                            <th class="px-10 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach($history as $row): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-10 py-6 font-bold text-slate-700"><?= $row['adate'] ?></td>
                            <td class="px-10 py-6 text-slate-500 font-medium"><?= $row['tfrom'] ?></td>
                            <td class="px-10 py-6 text-slate-500 font-medium"><?= $row['tto'] ?: '--:--:--' ?></td>
                            <td class="px-10 py-6 text-right">
                                <?php if($row['tto']): ?>
                                    <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full uppercase tracking-tighter">Completed</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full uppercase tracking-tighter animate-pulse">In Progress</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-GB', { hour12: false });
        const dateStr = now.toLocaleDateString('en-GB', { 
            weekday: 'long', 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        });
        
        document.getElementById('currentTime').innerText = timeStr;
        document.getElementById('currentDate').innerText = dateStr;
    }
    
    setInterval(updateClock, 1000);
    updateClock();

    function attachGPS(form, event) {
        if (!navigator.geolocation) {
            console.warn('Geolocation not supported');
            return true;
        }
        
        event.preventDefault();
        const btn = form.querySelector('button[type="submit"]');
        const origText = btn.innerText;
        btn.innerText = 'Locating...';
        btn.disabled = true;

        navigator.geolocation.getCurrentPosition(function(pos) {
            form.querySelector('.lat-input').value = pos.coords.latitude;
            form.querySelector('.lng-input').value = pos.coords.longitude;
            form.submit();
        }, function(err) {
            console.warn('GPS Error: ' + err.message);
            form.submit();
        }, { enableHighAccuracy: true, timeout: 10000 });
        
        return false;
    }

    function triggerSOS() {
        Swal.fire({
            title: 'EMERGENCY SOS',
            text: "This will immediately alert administrators with your precise location. Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3b3b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'SEND SOS NOW'
        }).then((result) => {
            if (result.isConfirmed) {
                if (!navigator.geolocation) {
                    Swal.fire('Error', 'Browser does not support GPS tracking.', 'error');
                    return;
                }
                
                Swal.fire({
                    title: 'Retrieving Location...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                navigator.geolocation.getCurrentPosition(function(pos) {
                    $.post('<?= base_url('sos/trigger') ?>', {
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude
                    }, function(res) {
                        const data = JSON.parse(res);
                        if(data.status === 'Success') {
                            Swal.fire('SOS Sent!', 'Administrators have been alerted of your location.', 'success');
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    });
                }, function(err) {
                    Swal.fire('GPS Error', 'Ensure location services are enabled to send SOS.', 'error');
                }, { enableHighAccuracy: true, timeout: 10000 });
            }
        });
    }
</script>

<style>
    @keyframes pulse-ring {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(220, 53, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>
