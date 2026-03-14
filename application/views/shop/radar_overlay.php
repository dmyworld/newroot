<!-- Radar Search Overlay (Phase 6.3) -->
<div id="radar-search-overlay" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/90 backdrop-blur-xl">
    <div class="relative w-full max-w-lg p-10 text-center">
        
        <!-- Radar Animation -->
        <div class="relative w-64 h-64 mx-auto mb-12">
            <!-- Pulsing Rings -->
            <div class="absolute inset-0 rounded-full border border-blue-500/30 animate-[ping_3s_linear_infinite]"></div>
            <div class="absolute inset-0 rounded-full border border-blue-500/20 animate-[ping_4s_linear_infinite_1s]"></div>
            
            <!-- Rotating Sweep -->
            <div class="absolute inset-0 rounded-full border-2 border-slate-700">
                <div class="absolute top-0 left-1/2 w-[2px] h-1/2 bg-gradient-to-t from-blue-600 to-transparent origin-bottom animate-[spin_4s_linear_infinite]"></div>
            </div>
            
            <!-- Center Dot (User) -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                <div class="w-8 h-8 bg-blue-600 rounded-2xl flex items-center justify-center shadow-[0_0_30px_rgba(37,99,235,0.6)] border-4 border-slate-900">
                    <i class="fa fa-user text-white text-xs"></i>
                </div>
            </div>

            <!-- Dynamic Worker Dots (Populated via JS) -->
            <div id="radar-worker-container"></div>
        </div>

        <!-- Status & Countdown -->
        <h2 class="text-3x font-black text-white mb-2 tracking-tight">Searching for Experts...</h2>
        <p id="radar-status-text" class="text-blue-400 font-bold uppercase tracking-widest text-xs mb-8">Locating closest Carpenter nearby</p>
        
        <div class="bg-slate-800/50 rounded-3xl p-6 border border-slate-700 flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500">
                    <i class="fa fa-clock text-xl"></i>
                </div>
                <div class="text-left">
                    <span class="block text-white font-black text-lg" id="radar-timer">30</span>
                    <span class="block text-slate-500 text-[10px] uppercase font-bold">Seconds Remaining</span>
                </div>
            </div>
            <button id="cancel-dispatch" class="px-6 py-3 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white rounded-xl font-black text-xs transition-all uppercase tracking-widest">
                Cancel Search
            </button>
        </div>

        <!-- Tips / Anticipation -->
        <div class="bg-white/5 rounded-2xl p-4 text-slate-400 text-sm italic">
            "Did you know? Proximity ensures faster service and lower transport costs."
        </div>
    </div>
</div>

<style>
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes ping {
        0% { transform: scale(1); opacity: 0.5; }
        100% { transform: scale(3); opacity: 0; }
    }
</style>

<script>
    const DispatchEngine = {
        requestId: null,
        pollingInterval: null,
        timerInterval: null,
        
        start: function(serviceId, lat, lng, address) {
            $('#radar-search-overlay').removeClass('hidden').addClass('flex');
            $('#radar-timer').text('30');
            this.updateStatus("Finding closest experts nearby...");
            
            $.post('<?= base_url("dispatch/start_search") ?>', {
                service_id: serviceId,
                lat: lat,
                lng: lng,
                address: address
            }, (res) => {
                const data = JSON.parse(res);
                if(data.status === 'searching' || data.status === 'fallback') {
                    this.requestId = data.request_id;
                    this.startPolling();
                } else {
                    alert(data.message || "Failed to start search");
                    this.stop();
                }
            });
        },
        
        startPolling: function() {
            this.pollingInterval = setInterval(() => {
                $.get('<?= base_url("dispatch/poll_status/") ?>' + this.requestId, (res) => {
                    const data = JSON.parse(res);
                    if(data.status === 'accepted') {
                        this.onAccepted(data.provider);
                    } else if(data.status === 'pining_next') {
                        this.updateStatus("Next expert pinged: " + data.provider_name);
                        $('#radar-timer').text(data.remaining);
                    } else if(data.status === 'searching') {
                        $('#radar-timer').text(data.remaining);
                    } else if(data.status === 'no_providers_left') {
                        this.updateStatus("No one available. Expand search?");
                        this.stopPolling();
                    }
                });
            }, 2000);
        },
        
        onAccepted: function(provider) {
            this.stopPolling();
            this.updateStatus("Expert Found: " + provider.display_name);
            $('#radar-search-overlay').html(`
                <div class="bg-white rounded-[3rem] p-10 max-w-sm w-full text-center shadow-2xl animate-[fadeIn_0.5s_ease-out]">
                    <div class="w-32 h-32 mx-auto mb-6 relative">
                        <img src="${provider.photo ? '<?= base_url() ?>' + provider.photo : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' + provider.display_name}" class="w-full h-full rounded-[2.5rem] object-cover border-4 border-blue-100 shadow-xl">
                        <div class="absolute -bottom-2 -right-2 bg-green-500 w-10 h-10 rounded-2xl flex items-center justify-center text-white border-4 border-white">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-1">${provider.display_name}</h2>
                    <p class="text-blue-500 font-bold text-[10px] uppercase tracking-widest mb-6">Expert is enroute to you</p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase mb-1">ETA</span>
                            <span class="text-lg font-black text-slate-900">12 Mins</span>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Price</span>
                            <span class="text-lg font-black text-slate-900">Rs. ${provider.pay_rate}</span>
                        </div>
                    </div>

                    <button onclick="location.href='<?= base_url('worker/track/') ?>' + this.requestId" class="w-full bg-blue-600 text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-100">
                        TRACK ENROUTE
                    </button>
                </div>
            `);
        },
        
        updateStatus: function(text) {
            $('#radar-status-text').fadeOut(200, function() {
                $(this).text(text).fadeIn(200);
            });
        },
        
        stopPolling: function() {
            clearInterval(this.pollingInterval);
        },
        
        stop: function() {
            this.stopPolling();
            $('#radar-search-overlay').addClass('hidden').removeClass('flex');
            if(this.requestId) {
                $.post('<?= base_url("dispatch/cancel/") ?>' + this.requestId);
            }
        }
    };

    $(document).on('click', '#cancel-dispatch', function() {
        DispatchEngine.stop();
    });
</script>
