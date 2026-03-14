<?php
$worker = $worker ?? [];
$is_logged_in = $is_logged_in ?? false;
$current_user_id = $current_user_id ?? 0;
$is_owner = ($is_logged_in && ($current_user_id == ($worker['user_id'] ?? 0)));
$initials = strtoupper(substr($worker['display_name'] ?? 'W', 0, 2));
$status_color = ($worker['availability'] === 'available') ? '#10b981' : '#ef4444';
$skills = json_decode($worker['skills'] ?? '[]', true);
$portfolio = json_decode($worker['portfolio'] ?? '[]', true);
?>

<style>
    :root {
        --premium-blue: #1e3c72;
        --premium-green: #10b981;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --text-main: #1e293b;
        --text-sub: #64748b;
    }

    .worker-detail-container {
        padding: 40px;
        max-width: 1400px;
        margin: 0 auto;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .glass-panel-premium {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 32px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-bottom: 40px;
    }

    .worker-hero-grid {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 60px;
    }

    @media (max-width: 1024px) {
        .worker-hero-grid {
            grid-template-columns: 1fr;
        }
    }

    .profile-stage {
        width: 100%;
        height: 500px;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        position: relative;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-stage img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-initials {
        font-size: 100px;
        font-weight: 900;
        color: var(--premium-blue);
        letter-spacing: -2px;
    }

    .badge-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .premium-badge {
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .badge-blue { background: rgba(30, 60, 114, 0.1); color: var(--premium-blue); }
    .badge-green { background: rgba(16, 185, 129, 0.1); color: var(--premium-green); }
    .badge-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

    .hero-title {
        font-size: 3rem;
        font-weight: 900;
        color: var(--text-main);
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .hero-meta {
        font-size: 1.1rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .pricing-engine {
        background: #f8fafc;
        padding: 30px;
        border-radius: 24px;
        margin-bottom: 40px;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .total-price-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .price-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-sub);
        text-transform: uppercase;
    }

    .price-value-main {
        font-size: 2.8rem;
        font-weight: 900;
        color: var(--premium-blue);
        line-height: 1;
    }

    .skill-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .skill-tag {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 8px 18px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-main);
        transition: all 0.3s;
    }

    .skill-tag:hover {
        border-color: var(--premium-blue);
        transform: translateY(-2px);
    }

    .btn-action-primary {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border: none;
        padding: 20px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.3s;
        box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
    }

    .btn-action-primary:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(30, 60, 114, 0.4);
    }

    .secondary-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 15px;
    }

    .btn-outline-premium {
        background: white;
        border: 2px solid #e2e8f0;
        padding: 15px;
        border-radius: 18px;
        font-weight: 700;
        color: var(--text-main);
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-outline-premium:hover {
        border-color: var(--premium-blue);
        color: var(--premium-blue);
    }

    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .portfolio-item {
        border-radius: 20px;
        overflow: hidden;
        height: 200px;
        cursor: pointer;
        position: relative;
    }

    .portfolio-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .portfolio-item:hover img {
        transform: scale(1.1);
    }

    /* Availability Pulse */
    .status-pulse {
        position: relative;
        display: inline-block;
        width: 12px;
        height: 12px;
        background: <?= $status_color ?>;
        border-radius: 50%;
        margin-right: 8px;
    }

    <?php if($worker['availability'] === 'available'): ?>
    .status-pulse::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: inherit;
        opacity: 0.8;
        animation: pulse 1.5s cubic-bezier(0.24, 0, 0.38, 1) infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(2.5); opacity: 0; }
    }
    <?php endif; ?>
</style>

<div class="worker-detail-container">
    <!-- Header Section -->
    <div class="glass-panel-premium">
        <div class="worker-hero-grid">
            <!-- Left: Profile Photo -->
            <div class="profile-stage">
                <?php if(!empty($worker['photo'])): ?>
                    <img src="<?= base_url($worker['photo']) ?>" alt="<?= $worker['display_name'] ?>">
                <?php else: ?>
                    <span class="profile-initials"><?= $initials ?></span>
                <?php endif; ?>
            </div>

            <!-- Right: Workforce Info -->
            <div class="product-info-hub">
                <div class="badge-bar">
                    <span class="premium-badge badge-blue"><?= htmlspecialchars($worker['category_name']) ?></span>
                    <span class="premium-badge badge-green"><i class="fa fa-award"></i> <?= $worker['experience_years'] ?> Yrs Exp</span>
                    <span class="premium-badge badge-purple"><i class="fa fa-shield-check"></i> Verified Profile</span>
                </div>

                <h1 class="hero-title"><?= htmlspecialchars($worker['display_name']) ?></h1>
                
                <div class="hero-meta">
                    <span class="flex items-center"><i class="fa fa-map-marker-alt mr-2 text-primary"></i> <?= htmlspecialchars($worker['location']) ?></span>
                    <span class="flex items-center"><i class="fa fa-star mr-2 text-yellow-500"></i> <?= number_format($worker['average_rating'], 1) ?> (<?= $worker['total_ratings'] ?> Reviews)</span>
                    <span class="flex items-center"><div class="status-pulse"></div> <?= ucfirst($worker['availability']) ?></span>
                </div>

                <div class="pricing-engine">
                    <div class="total-price-row">
                        <span class="price-label">Workforce Rate</span>
                        <div class="price-value-main">LKR <?= number_format($worker['pay_rate']) ?> <small class="text-xs font-bold text-slate-400">/ <?= $worker['pay_type'] ?></small></div>
                    </div>
                </div>

                <!-- Bio / Skills -->
                <div class="mb-8">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Professional Bio</h4>
                    <p class="text-slate-600 leading-relaxed italic"><?= nl2br(htmlspecialchars($worker['bio'] ?? 'No bio provided.')) ?></p>
                    
                    <div class="skill-grid">
                        <?php foreach($skills as $skill): ?>
                            <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Master Actions -->
                <div class="master-action-box">
                    <?php if($is_logged_in): ?>
                        <?php if($is_owner): ?>
                            <a href="<?= base_url('worker/register') ?>" class="btn-action-primary">
                                <i class="fa fa-edit"></i> EDIT MY PROFILE
                            </a>
                            <button class="btn-outline-premium mt-4 w-full" onclick="toggleStatus()">
                                <i class="fa fa-toggle-on"></i> TOGGLE AVAILABILITY
                            </button>
                        <?php else: ?>
                            <button class="btn-action-primary" onclick="hireWorker(<?= $worker['id'] ?>)">
                                <i class="fa fa-handshake"></i> HIRE PROFESSIONAL NOW
                            </button>
                            <div class="secondary-actions">
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $worker['phone'] ?? '') ?>" target="_blank" class="btn-outline-premium">
                                    <i class="fab fa-whatsapp text-green-500"></i> WHATSAPP
                                </a>
                                <button class="btn-outline-premium" onclick="openReviewModal()">
                                    <i class="fa fa-star text-yellow-500"></i> LEAVE REVIEW
                                </button>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <button class="btn-action-primary" onclick="window.location.href='<?= base_url('hub/login') ?>'">
                            LOGIN TO HIRE PROFESSIONALS
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Section -->
    <?php if(!empty($portfolio)): ?>
    <div class="glass-panel-premium">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight"><i class="fa fa-images text-indigo-500 mr-2"></i> Project Portfolio</h2>
            <?php if($is_owner): ?>
                <button class="px-6 py-2 bg-slate-100 hover:bg-slate-200 rounded-xl font-bold text-sm transition-colors" onclick="$('#portfolio_upload').click()">+ Add Project</button>
                <form id="portfolio_form" style="display:none">
                    <input type="file" name="file" id="portfolio_upload" onchange="uploadPortfolio()">
                </form>
            <?php endif; ?>
        </div>
        
        <div class="portfolio-grid">
            <?php foreach($portfolio as $img): ?>
                <div class="portfolio-item group" onclick="window.open('<?= base_url($img) ?>', '_blank')">
                    <img src="<?= base_url($img) ?>" alt="Project">
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <i class="fa fa-expand text-white text-2xl"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Reviews Section -->
    <div class="glass-panel-premium">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-8"><i class="fa fa-comments text-amber-500 mr-2"></i> Client Testimonials</h2>
        
        <div class="space-y-6">
            <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 relative">
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100">
                    <i class="fa fa-quote-left text-blue-500"></i>
                </div>
                <div class="flex items-center space-x-2 mb-4">
                    <i class="fa fa-star text-yellow-500"></i>
                    <i class="fa fa-star text-yellow-500"></i>
                    <i class="fa fa-star text-yellow-500"></i>
                    <i class="fa fa-star text-yellow-500"></i>
                    <i class="fa fa-star text-yellow-500"></i>
                </div>
                <p class="text-slate-600 italic leading-relaxed">"Extremely satisfied with the level of expertise. The work was completed with high precision and within the promised timeline. Highly recommended for any complex timber projects."</p>
                <div class="mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">— Verified Marketplace Client</div>
            </div>
        </div>
    </div>
</div>

<script>
function hireWorker(id) {
    if(!confirm('Confirm hiring this professional?')) return;
    $.post('<?= base_url('worker/hire') ?>', {worker_id: id, salary: <?= $worker['pay_rate'] ?>}, function(res) {
        const data = JSON.parse(res);
        if(data.status === 'Success') {
            alert(data.message);
            window.location.href = '<?= base_url('employee') ?>';
        } else {
            alert(data.message);
        }
    });
}

function toggleStatus() {
    $.get('<?= base_url('worker/ajax_toggle_status') ?>', function(res) {
        const data = JSON.parse(res);
        if(data.status === 'Success') location.reload();
    });
}

function uploadPortfolio() {
    let formData = new FormData($('#portfolio_form')[0]);
    $.ajax({
        url: '<?= base_url('worker/portfolio_upload') ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            const data = JSON.parse(res);
            if(data.status === 'Success') location.reload();
            else alert(data.message);
        }
    });
}
</script>
