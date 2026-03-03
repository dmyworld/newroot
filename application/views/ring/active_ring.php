<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card" style="background:#0f172a; border:1px solid #1e293b; border-radius:30px; padding:40px; box-shadow:0 30px 60px rgba(0,0,0,0.5);">
                    <div style="position:relative; width:180px; height:180px; margin:0 auto 30px;">
                        <svg width="180" height="180" viewBox="0 0 180 180">
                            <circle cx="90" cy="90" r="80" stroke="#1e293b" stroke-width="8" fill="none" />
                            <circle id="timer-circle" cx="90" cy="90" r="80" stroke="#3b82f6" stroke-width="8" fill="none"
                                    stroke-dasharray="502" stroke-dashoffset="0" transform="rotate(-90 90 90)" 
                                    style="transition: stroke-dashoffset 1s linear;" />
                        </svg>
                        <div id="countdown" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:3.5rem; font-weight:800; color:white;">30</div>
                    </div>

                    <h2 class="text-white font-weight-bold mb-2">Ringing Nearby Providers...</h2>
                    <p style="color:#94a3b8; font-size:1.1rem;">Your request for <strong>"<?= $request->title ?>"</strong> is being broadcasted within a <?= $request->radius_km ?>km radius.</p>
                    
                    <div class="d-flex align-items-center justify-content-center mt-4">
                        <div class="spinner-grow text-primary mr-2" role="status" style="width:1rem; height:1rem;"></div>
                        <span style="color:#3b82f6; font-weight:600; letter-spacing:1px;">SEARCHING FOR BEST MATCH</span>
                    </div>

                    <div id="simulation-box" class="mt-5 p-3" style="background:rgba(59,130,246,0.1); border:1px dashed rgba(59,130,246,0.3); border-radius:15px; display:none;">
                        <h5 class="text-white mb-2">Provider Found!</h5>
                        <p class="small text-muted mb-3">A nearby transport provider has seen your request.</p>
                        <a href="<?= site_url('ring/accept/' . $request->id) ?>" class="btn btn-success px-4" style="border-radius:20px;">
                            <i class="fas fa-check-circle mr-1"></i> Simulate Provider Acceptance
                        </a>
                    </div>

                    <div class="mt-5">
                        <a href="<?= site_url('ring') ?>" class="text-muted" style="text-decoration:none;">
                            <i class="fas fa-times-circle mr-1"></i> Cancel Request
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let timeLeft = 30;
    const countdownEl = document.getElementById('countdown');
    const timerCircle = document.getElementById('timer-circle');
    const totalLength = 502; // circumference of circle r=80

    const timer = setInterval(() => {
        timeLeft--;
        if (timeLeft >= 0) {
            countdownEl.innerText = timeLeft;
            const offset = totalLength - (timeLeft / 30) * totalLength;
            timerCircle.style.strokeDashoffset = offset;
        }

        if (timeLeft === 25) {
            // Show simulation button after 5 seconds
            document.getElementById('simulation-box').style.display = 'block';
        }

        if (timeLeft <= 0) {
            clearInterval(timer);
            // Redirect back to dashboard if no one accepts
            window.location.href = "<?= site_url('ring') ?>";
        }
    }, 1000);
</script>
