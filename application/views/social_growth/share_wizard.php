<?php defined('BASEPATH') OR exit('No direct script access allowed');
$lot             = $lot ?? [];
$ad_id           = $ad_id ?? 0;
$ad_type         = $ad_type ?? 'logs';
$posters         = $posters ?? [];
$video           = $video ?? null;
$share_status    = $share_status ?? [];
$fb_connected    = $fb_connected ?? false;
$yt_connected    = $yt_connected ?? false;
$tt_connected    = $tt_connected ?? false;
$caption         = $caption ?? '';
$hashtags        = $hashtags ?? '';
$wa_msg          = $wa_msg ?? '';
$referral_tokens = $referral_tokens ?? [];
$shop_url        = $shop_url ?? site_url('shop');
$has_media       = $has_media ?? false;
$badges          = $badges ?? [];
$insights        = $insights ?? [];

$platforms = [
    'facebook'  => ['label' => 'Facebook',  'icon' => 'fa-facebook-f', 'color' => '#1877F2', 'bg' => 'rgba(24, 119, 242, 0.05)'],
    'whatsapp'  => ['label' => 'WhatsApp Status',  'icon' => 'fa-whatsapp',  'color' => '#25D366', 'bg' => 'rgba(37, 211, 102, 0.05)'],
    'youtube'   => ['label' => 'YouTube Shorts',   'icon' => 'fa-youtube',   'color' => '#FF0000', 'bg' => 'rgba(255, 0, 0, 0.05)'],
    'tiktok'    => ['label' => 'TikTok',    'icon' => 'fa-tiktok',    'color' => '#000000', 'bg' => 'rgba(0, 0, 0, 0.05)'],
];
$species  = $lot['species'] ?? 'Timber';
$price    = number_format($lot['selling_price'] ?? 0);
$location = $lot['location'] ?? 'Sri Lanka';
?>

<!-- Premium Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">

<style>
:root {
    --elite-emerald: #064e3b;
    --elite-green: #10b981;
    --elite-gold: #f59e0b;
    --emerald-grad: linear-gradient(135deg, #064e3b 0%, #059669 100%);
    --gold-grad: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
    --glass-bg: rgba(255, 255, 255, 0.9);
    --glass-border: rgba(255, 255, 255, 0.5);
}

.wizard-wrapper {
    font-family: 'Outfit', sans-serif;
    background-color: #fcfcf9;
    background-image: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.03) 0, transparent 50%), 
                      radial-gradient(at 100% 100%, rgba(245, 158, 11, 0.03) 0, transparent 50%);
    min-height: 100vh;
    padding: 40px 0;
}

.title-font { font-family: 'Libre Baskerville', serif; }

.sg-wizard-container { max-width: 960px; margin: 0 auto; padding: 0 24px; }

/* ======== Elite Steps Bar ======== */
.sg-steps-bar { 
    display: flex; 
    gap: 8px; 
    margin-bottom: 40px; 
    background: rgba(255,255,255,0.5); 
    padding: 8px; 
    border-radius: 24px; 
    border: 1px solid rgba(0,0,0,0.03);
}
.sg-step { 
    flex: 1; 
    padding: 14px; 
    text-align: center; 
    border-radius: 18px; 
    color: #94a3b8; 
    font-weight: 700; 
    font-size: .85rem; 
    transition: all .4s cubic-bezier(0.4, 0, 0.2, 1); 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    gap: 4px;
}
.sg-step.active { 
    background: #fff; 
    color: var(--elite-emerald); 
    box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
}
.sg-step.done { 
    background: var(--elite-green); 
    color: #fff; 
}
.sg-step .step-num { 
    width: 24px; 
    height: 24px; 
    border-radius: 50%; 
    display: inline-flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 0.75rem; 
    background: rgba(0,0,0,0.05); 
    font-weight: 800; 
}
.sg-step.active .step-num { background: var(--elite-emerald); color: #fff; }
.sg-step.done .step-num   { background: rgba(255,255,255,0.2); color: #fff; }

.sg-panel { display: none; animation: eliteFadeIn .5s ease; }
.sg-panel.active { display: block; }

@keyframes eliteFadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

/* ======== Glass Cards ======== */
.elite-card {
    background: var(--glass-bg);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(6, 78, 59, 0.03);
}

/* Progress bar */
.gen-progress-wrap { background: #f1f5f9; border-radius: 50px; height: 10px; overflow: hidden; margin: 20px 0; }
.gen-progress-bar  { height: 100%; background: var(--emerald-grad); border-radius: 50px; transition: width .5s cubic-bezier(0.4, 0, 0.2, 1); }

/* Poster carousel */
.poster-carousel { display: flex; gap: 16px; overflow-x: auto; padding: 10px 5px 20px; scroll-snap-type: x mandatory; }
.poster-slide { 
    flex: 0 0 240px; 
    scroll-snap-align: start; 
    border-radius: 18px; 
    overflow: hidden; 
    box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
    position: relative; 
    cursor: pointer; 
    transition: all .3s; 
    border: 3px solid transparent;
}
.poster-slide:hover { transform: translateY(-5px) scale(1.02); }
.poster-slide.selected { border-color: var(--elite-green); box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
.poster-slide img { width: 100%; height: 320px; object-fit: cover; display: block; }
.poster-slot-badge { position: absolute; top: 12px; left: 12px; background: rgba(0,0,0,0.6); color: #fff; font-size: .65rem; padding: 4px 10px; border-radius: 20px; font-weight: 700; text-transform: uppercase; }

/* Platform Elite Rows */
.elite-platform-row { 
    display: flex; 
    align-items: center; 
    background: #fff; 
    border: 1px solid #f1f5f9; 
    border-radius: 20px; 
    padding: 20px 24px; 
    margin-bottom: 16px; 
    gap: 20px; 
    transition: all .3s; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.01);
}
.elite-platform-row:hover { border-color: var(--elite-green); transform: translateX(5px); }
.elite-platform-row.done-row { border-color: var(--elite-green); background: #fdfdfd; }

.platform-icon { 
    width: 55px; 
    height: 55px; 
    border-radius: 16px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 1.6rem; 
    color: #fff; 
    flex-shrink: 0; 
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}
.platform-label { flex: 1; }
.platform-label strong { display: block; font-size: 1.1rem; color: #1e293b; letter-spacing: -0.5px; }
.platform-label small  { color: #64748b; font-weight: 500; }

.btn-share-elite { 
    padding: 12px 28px; 
    border-radius: 14px; 
    font-weight: 700; 
    font-size: .85rem; 
    border: none; 
    cursor: pointer; 
    transition: all .3s; 
    letter-spacing: 0.5px;
}
.btn-share-pending { background: #f1f5f9; color: #475569; }
.btn-share-pending:hover { background: #e2e8f0; }

.btn-share-done { background: var(--elite-green); color: #fff; cursor: default; }

/* Caption Box Elite */
.elite-caption-box { 
    background: rgba(16, 185, 129, 0.05); 
    border: 1px dashed var(--elite-green); 
    border-radius: 20px; 
    padding: 25px; 
    position: relative; 
}

.btn-elite-primary {
    background: var(--emerald-grad);
    color: #fff;
    border: none;
    padding: 16px 40px;
    border-radius: 16px;
    font-weight: 700;
    box-shadow: 0 8px 25px rgba(6, 78, 59, 0.2);
    transition: all .3s;
}
.btn-elite-primary:hover:not(:disabled) { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(6, 78, 59, 0.3); color: #fff; }
.btn-elite-primary:disabled { opacity: 0.5; cursor: not-allowed; }

/* Live Card Elite */
.live-card-elite { 
    background: var(--emerald-grad); 
    color: #fff; 
    border-radius: 30px; 
    padding: 60px 40px; 
    text-align: center; 
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(6, 78, 59, 0.3);
}
.live-card-elite::after {
    content: '\f1bb'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
    position: absolute; bottom: -30px; right: -20px; font-size: 15rem; opacity: 0.08;
}

.live-badge { font-size: 5rem; color: var(--elite-gold); margin-bottom: 20px; filter: drop-shadow(0 0 15px rgba(245, 158, 11, 0.4)); }

/* Toast & Utilities */
.badge-toast-elite { 
    background: #fff; border-radius: 20px; padding: 20px; 
    box-shadow: 0 15px 40px rgba(0,0,0,0.15); border: 1px solid #f1f5f9;
}
</style>

<div class="wizard-wrapper">
    <div class="sg-wizard-container">

        <!-- Premium Navigation Title -->
        <div class="text-center mb-5">
            <span class="stat-label mb-2 d-block">Market Activation</span>
            <h1 class="title-font" style="font-weight: 800; color: var(--elite-emerald); letter-spacing: -1.5px;">Elite Listing Wizard</h1>
            <p class="text-muted fw-bold"><?= htmlspecialchars("{$species} • LKR {$price} • {$location}") ?></p>
        </div>

        <!-- Steps Bar Elite -->
        <div class="sg-steps-bar mb-5">
            <div class="sg-step active" id="step-btn-1">
                <div class="step-num">1</div>
                <div>Creative Engine</div>
            </div>
            <div class="sg-step" id="step-btn-2">
                <div class="step-num">2</div>
                <div>Global Sharing</div>
            </div>
            <div class="sg-step" id="step-btn-3">
                <div class="step-num">3</div>
                <div>Activation</div>
            </div>
        </div>

        <!-- STEP 1: GENERATE MEDIA -->
        <div class="sg-panel active" id="step-1">
            <div class="elite-card text-center">
                <div class="mb-4">
                    <h4 class="title-font fw-bold text-dark">Crafting Your Visual Narrative</h4>
                    <p class="text-muted small">We're using AI to enhance your photos and generate professional marketing assets.</p>
                </div>

                <div id="gen-loading" style="<?= $has_media ? 'display:none;' : '' ?>">
                    <div class="gen-progress-wrap">
                        <div class="gen-progress-bar" id="gen-progress" style="width: 0%"></div>
                    </div>
                    <p class="gen-status-msg" id="gen-status">Initializing Creative Engine...</p>
                    <button class="btn-elite-primary mt-3" onclick="startGeneration()" id="start-gen-btn">
                        <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Ignite Media Engine
                    </button>
                </div>

                <div id="gen-results" style="<?= $has_media ? '' : 'display:none;' ?>">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6 text-start">
                            <h6 class="fw-bold text-dark mb-1">Professional Posters</h6>
                            <p class="text-muted small">Choose the best look for your advertisements.</p>
                            <div class="poster-carousel" id="poster-list">
                                <?php foreach ($posters as $idx => $p): ?>
                                    <div class="poster-slide shadow-sm" onclick="previewPoster('<?= base_url($p['file_path']) ?>')">
                                        <div class="poster-slot-badge">Concept #<?= $idx + 1 ?></div>
                                        <img src="<?= base_url($p['file_path']) ?>" loading="lazy">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark mb-3">Cinema Short <span class="badge bg-gold-grad ms-1" style="font-size:0.6rem;">VOICE-OVER</span></h6>
                            <?php if ($video): ?>
                                <div class="rounded-4 overflow-hidden shadow-lg border-2 border-white">
                                    <video width="100%" controls class="d-block" style="max-height: 320px; background: #000;">
                                        <source src="<?= base_url($video['file_path']) ?>" type="video/mp4">
                                    </video>
                                </div>
                            <?php else: ?>
                                <div class="p-5 rounded-4 bg-light border border-dashed text-muted">
                                    <i class="fa-solid fa-video-slash fa-2x mb-2 opacity-50"></i>
                                    <p class="small m-0">Dynamic cinematic video is being finalized.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="elite-caption-box text-start mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                             <h6 class="fw-bold text-success m-0"><i class="fa-solid fa-sparkles me-1 text-warning"></i> AI Generated Narrative</h6>
                             <button class="btn btn-sm btn-white border rounded-pill shadow-sm" onclick="copyCaption()">
                                 <i class="fa-solid fa-copy me-1"></i> Copy Text
                             </button>
                        </div>
                        <div id="caption-text" class="text-dark small lh-base"><?= nl2br(htmlspecialchars($caption . " " . $hashtags)) ?></div>
                    </div>

                    <button class="btn-elite-primary" onclick="goToStep(2)">
                        Proceed to Distribution <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- STEP 2: SHARE -->
        <div class="sg-panel" id="step-2">
            <div class="elite-card">
                <div class="mb-4 text-center">
                    <h4 class="title-font fw-bold text-dark">Global Distribution Network</h4>
                    <p class="text-muted small">Activate your listing across major social hubs to maximize visibility.</p>
                </div>

                <div class="row g-4 mb-4">
                    <?php foreach ($platforms as $key => $p): 
                        $is_done = ($share_status[$key] ?? '') === 'success';
                    ?>
                    <div class="col-md-6">
                        <div class="elite-platform-row <?= $is_done ? 'done-row' : '' ?>" id="row-<?= $key ?>">
                            <div class="platform-icon shadow" style="background: <?= $p['color'] ?>;">
                                <i class="fab <?= $p['icon'] ?>"></i>
                            </div>
                            <div class="platform-label">
                                <strong><?= $p['label'] ?></strong>
                                <small id="status-text-<?= $key ?>"><?= $is_done ? 'Verified & Active' : 'Waiting for broadcast' ?></small>
                            </div>
                            <div id="btn-wrap-<?= $key ?>">
                                <?php if ($is_done): ?>
                                    <span class="text-success fs-4"><i class="fa-solid fa-circle-check"></i></span>
                                <?php else: ?>
                                    <button class="btn-share-elite btn-share-pending" onclick="triggerShare('<?= $key ?>')">
                                        Broadcast
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="p-4 rounded-4 bg-light border-start border-4 border-warning mb-4">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="fs-2">💡</div>
                        <div class="small">
                            <strong>Did you know?</strong> Posts with professional hashtags like <span class="text-success font-weight-bold">#TimberPro</span> and <span class="text-success font-weight-bold">#VerifiedSellers</span> correlate with 40% faster sales.
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button class="btn-elite-primary" id="finish-btn" <?= count(array_filter($share_status, fn($s) => $s === 'success')) < 4 ? 'disabled' : '' ?> onclick="goToStep(3)">
                        Finalize Activation <i class="fa-solid fa-check-double ms-2"></i>
                    </button>
                    <div class="mt-2 text-muted small" id="finish-hint">Broadcast to all 4 platforms to activate listing.</div>
                </div>
            </div>
        </div>

        <!-- STEP 3: SUCCESS -->
        <div class="sg-panel" id="step-3">
            <div class="live-card-elite">
                <div class="live-badge">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2 class="title-font fw-bold mb-3" style="font-size: 3rem; letter-spacing: -2px;">Listing Activated!</h2>
                <p class="lead mb-5 opacity-75">Your advertisement has been processed by the Social Engine and is now live to all global buyers.</p>
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= site_url('shop/view/'.$ad_type.'/'.$ad_id) ?>" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-success shadow">
                         View Live Listing
                    </a>
                    <a href="<?= site_url('social_growth/my_insights') ?>" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold">
                         Track Impressions
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Scripts remain identical in logic but with tiny UI adjustments for the new IDs -->
<div id="badge-container"></div>
<div id="confetti-container" class="confetti-wrap"></div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
let currentStep = 1;
const adId = <?= $ad_id ?>;
const adType = '<?= $ad_type ?>';

function goToStep(s) {
    document.querySelectorAll('.sg-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sg-step').forEach(btn => btn.classList.remove('active'));
    
    document.getElementById('step-' + s).classList.add('active');
    document.getElementById('step-btn-' + s).classList.add('active');
    
    for(let i=1; i<s; i++) document.getElementById('step-btn-' + i).classList.add('done');
    currentStep = s;
}

function startGeneration() {
    const btn = document.getElementById('start-gen-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Sythesizing Assets...';
    
    let progress = 0;
    const bar = document.getElementById('gen-progress');
    const msg = document.getElementById('gen-status');
    
    const interval = setInterval(() => {
        progress += (100 - progress) * 0.1;
        bar.style.width = progress + '%';
        
        if (progress > 20) msg.textContent = 'Enhancing texture and lighting...';
        if (progress > 50) msg.textContent = 'Generating AI narration...';
        if (progress > 80) msg.textContent = 'Finalizing render...';
    }, 400);

    fetch('<?= site_url('social_growth/generate_media/') ?>' + adId)
    .then(r => r.json())
    .then(d => {
        clearInterval(interval);
        if (d.status === 'Success') {
            bar.style.width = '100%';
            msg.textContent = 'Creative synthesis complete!';
            location.reload(); // Quickest way to show results
        } else {
            alert(d.message);
            btn.disabled = false;
            btn.innerHTML = 'Retry Media Engine';
        }
    });
}

function triggerShare(platform) {
    const btnWrap = document.getElementById('btn-wrap-' + platform);
    const originalContent = btnWrap.innerHTML;
    btnWrap.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-muted fs-4"></i>';

    // special handling for client-side deep links
    if (platform === 'whatsapp') {
        const waUrl = '<?= "https://wa.me/?text=" . $wa_msg ?>';
        window.open(waUrl, '_blank');
    }

    fetch('<?= site_url('social_growth/do_share/') ?>' + platform + '/' + adId, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ad_type=' + adType
    })
    .then(r => r.json())
    .then(d => {
        if (d.status === 'Success') {
            markShareDone(platform, d);
            if (d.new_badges && d.new_badges.length > 0) {
                d.new_badges.forEach(b => showBadgeToast(b));
                triggerConfetti();
            }
        } else {
            alert(d.message);
            btnWrap.innerHTML = originalContent;
        }
    });
}

function markShareDone(platform, data) {
    const row = document.getElementById('row-' + platform);
    const wrap = document.getElementById('btn-wrap-' + platform);
    const status = document.getElementById('status-text-' + platform);

    row.classList.add('done-row');
    wrap.innerHTML = '<span class="text-success fs-4 animate__animated animate__bounceIn"><i class="fa-solid fa-circle-check"></i></span>';
    status.textContent = 'Verified & Active';
    status.classList.add('text-success', 'fw-bold');

    checkActivation();
}

function checkActivation() {
    fetch('<?= site_url('social_growth/verify_share/') ?>' + adId)
    .then(r => r.json())
    .then(d => {
        if (d.total_done >= 4) {
             document.getElementById('finish-btn').disabled = false;
             document.getElementById('finish-hint').innerHTML = '<i class="fa-solid fa-star text-warning"></i> Listing is ready for global activation!';
             triggerConfetti();
        }
    });
}

function triggerConfetti() {
    confetti({
        particleCount: 150,
        spread: 70,
        origin: { y: 0.6 },
        colors: ['#064e3b', '#10b981', '#f59e0b', '#ffffff']
    });
}

function showBadgeToast(badge) {
    const container = document.getElementById('badge-container');
    const toast = document.createElement('div');
    toast.className = 'badge-toast-elite stagger-load';
    toast.style.position = 'fixed';
    toast.style.bottom = '30px';
    toast.style.right = '30px';
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <div class="d-flex align-items-center gap-3">
             <div class="fs-1">${badge.icon || '🏆'}</div>
             <div>
                <strong class="text-dark d-block">Badge Unlocked: ${badge.name}!</strong>
                <small class="text-muted">${badge.description}</small>
             </div>
        </div>
    `;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 6000);
}

function copyCaption() {
    const text = "<?= addslashes($caption . ' ' . $hashtags) ?>";
    navigator.clipboard.writeText(text).then(() => {
        alert('Marketing copy copied to clipboard!');
    });
}

function previewPoster(url) {
    window.open(url, '_blank');
}
</script>
