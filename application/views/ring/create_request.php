<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background:#0f172a; border:1px solid #1e293b; border-radius:20px; box-shadow:0 20px 50px rgba(0,0,0,0.3);">
                    <div class="card-header border-0 pb-0 pt-4 px-4 text-center">
                        <div style="width:64px; height:64px; background:linear-gradient(135deg, #3b82f6, #002366); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 15px;">
                            <i class="fas fa-satellite-dish text-white" style="font-size:1.8rem;"></i>
                        </div>
                        <h2 class="text-white font-weight-bold">Initiate Service Ring</h2>
                        <p style="color:#94a3b8;">Broadcast your request to nearby providers in real-time.</p>
                    </div>

                    <div class="card-body p-4">
                        <form action="<?= site_url('ring/save_request') ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-white mb-1"><i class="fas fa-tools mr-1" style="color:#3b82f6;"></i> Service Type</label>
                                    <select name="service_type" class="form-control" style="background:#1e293b; border:1px solid #334155; color:white; border-radius:10px;">
                                        <option value="timber_delivery">Timber Delivery (Transport)</option>
                                        <option value="sawmill_service">Sawmill / Processing</option>
                                        <option value="labour">Skilled Labour</option>
                                        <option value="machinery">Heavy Machinery / JCB</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-white mb-1"><i class="fas fa-wallet mr-1" style="color:#f59e0b;"></i> Estimated Budget (LKR)</label>
                                    <input type="number" name="budget" class="form-control" placeholder="e.g. 15000" style="background:#1e293b; border:1px solid #334155; color:white; border-radius:10px;" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-white mb-1">Request Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Urgent Teak Log Delivery to Kandy" style="background:#1e293b; border:1px solid #334155; color:white; border-radius:10px;" required>
                            </div>

                            <div class="mb-3">
                                <label class="text-white mb-1">Detailed Instructions</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Specify requirements, dimensions, or urgency..." style="background:#1e293b; border:1px solid #334155; color:white; border-radius:10px;"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="text-white mb-1"><i class="fas fa-map-marker-alt mr-1" style="color:#ef4444;"></i> GPS Location (Source/Target)</label>
                                <div id="map-mock" style="height:250px; background:#1e293b; border:1px solid #334155; border-radius:12px; position:relative; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                                    <div class="text-center">
                                        <i class="fas fa-map-marked-alt text-muted mb-2" style="font-size:3rem;"></i>
                                        <p class="text-muted small">Select location on map (Mock UI)</p>
                                        <button type="button" class="btn btn-sm btn-outline-primary px-3" style="border-radius:20px;">Use Current Location</button>
                                    </div>
                                    <input type="hidden" name="lat" value="6.9271">
                                    <input type="hidden" name="lng" value="79.8612">
                                    <input type="hidden" name="radius" value="15">
                                </div>
                                <p class="text-muted mt-2 mb-0" style="font-size:0.8rem;">Broadcasting to a 15km radius from your selected point.</p>
                            </div>

                            <button type="submit" class="btn btn-block py-3 mt-4" style="background:linear-gradient(135deg, #3b82f6, #1d4ed8); color:white; font-weight:700; font-size:1.1rem; border-radius:15px; border:none; box-shadow:0 10px 30px rgba(59,130,246,0.3);">
                                <i class="fas fa-broadcast-tower mr-1"></i> Start 30s Ring Broadcast
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function useCurrentLocation() {
        const btn = event.currentTarget || document.querySelector('[onclick="useCurrentLocation()"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Locating...';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    document.getElementsByName('lat')[0].value = position.coords.latitude;
                    document.getElementsByName('lng')[0].value = position.coords.longitude;
                    btn.innerHTML = '<i class="fas fa-check"></i> Located!';
                    btn.classList.replace('btn-outline-primary', 'btn-success');
                    
                    // Update mock UI
                    const mapMock = document.getElementById('map-mock');
                    mapMock.querySelector('p').innerText = `Location Locked: ${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}`;
                    mapMock.querySelector('i').style.color = '#4ade80';
                },
                (error) => {
                    alert("Error getting location: " + error.message);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            );
        } else {
            alert("Geolocation is not supported by this browser.");
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    // Attach to button
    document.querySelector('button[type="button"]').setAttribute('onclick', 'useCurrentLocation()');
</script>
