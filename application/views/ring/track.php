<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card" style="background:#0f172a; border:1px solid #334155; border-radius:20px; overflow:hidden; box-shadow:0 30px 60px rgba(0,0,0,0.5);">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h3 class="text-white mb-0">Live Tracking: <span class="text-primary"><?= $request->title ?></span></h3>
                            <p class="mb-0 text-muted">Provider: <strong class="text-white"><?= $request->provider_name ?></strong> is on the way.</p>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-success px-3 py-2" style="border-radius:10px; font-size:1rem;">
                                <i class="fas fa-shipping-fast mr-1"></i> IN TRANSIT
                            </span>
                        </div>
                    </div>

                    <div id="map-tracking" style="height:450px; background:#1e293b; position:relative; display:flex; align-items:center; justify-content:center;">
                        <!-- Simulated Map Background -->
                        <div style="position:absolute; inset:0; opacity:0.3; background:url('https://maps.googleapis.com/maps/api/staticmap?center=6.9271,79.8612&zoom=13&size=1200x600&key=MOCK_KEY') center center no-repeat; background-size:cover;"></div>
                        
                        <!-- Pulse Effect for Provider -->
                        <div id="provider-pulse" style="position:absolute; width:40px; height:40px; background:rgba(59,130,246,0.3); border-radius:50%; z-index:2; transition: all 1s linear;">
                            <div style="position:absolute; top:10px; left:10px; width:20px; height:20px; background:#3b82f6; border:3px solid white; border-radius:50%; box-shadow:0 0 10px rgba(59,130,246,0.8);"></div>
                        </div>

                        <!-- Pulse Effect for Destination -->
                        <div style="position:absolute; top:40%; left:60%; width:40px; height:40px; z-index:1;">
                            <i class="fas fa-map-marker-alt" style="color:#ef4444; font-size:2rem; position:absolute; bottom:0; left:50%; transform:translateX(-50%);"></i>
                        </div>
                    </div>

                    <div class="card-footer p-4 border-0" style="background:rgba(15,23,42,0.8);">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <p class="text-muted small mb-0 font-weight-bold">ESTIMATED ARRIVAL</p>
                                <h4 class="text-white">12 Minutes</h4>
                            </div>
                            <div class="col-md-4" style="border-left:1px solid #334155; border-right:1px solid #334155;">
                                <p class="text-muted small mb-0 font-weight-bold">CURRENT SPEED</p>
                                <h4 class="text-white">42 km/h</h4>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted small mb-0 font-weight-bold">DISTANCE REMAINING</p>
                                <h4 class="text-white">3.8 km</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simulate movement
    const pulse = document.getElementById('provider-pulse');
    let posX = 10;
    let posY = 80;

    const moveInterval = setInterval(() => {
        posX += 1;
        posY -= 0.8;
        pulse.style.left = posX + '%';
        pulse.style.top = posY + '%';

        if (posX > 80) clearInterval(moveInterval);
    }, 2000);
</script>
