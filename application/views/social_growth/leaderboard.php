<?php defined('BASEPATH') OR exit('No direct script access allowed');
$leaders = $leaders ?? [];
$badge_defs = [
    'first_share'       => ['<i class="fa-solid fa-medal text-bronze"></i>', 'First Share'],
    'speed_sharer'      => ['<i class="fa-solid fa-bolt-lightning text-info"></i>', 'Speed Sharer'],
    'referral_king'     => ['<i class="fa-solid fa-crown text-warning"></i>', 'Referral King'],
    'super_seller'      => ['<i class="fa-solid fa-trophy text-gold"></i>', 'Super Seller'],
    'community_builder' => ['<i class="fa-solid fa-gem text-primary"></i>', 'Elite Builder'],
];
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
}

.lb-page-wrapper {
    font-family: 'Outfit', sans-serif;
    background-color: #fcfcf9;
    background-image: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0, transparent 50%);
    min-height: 100vh;
    padding: 60px 0;
}

.title-font { font-family: 'Libre Baskerville', serif; }

.lb-container { max-width: 860px; margin: 0 auto; padding: 0 24px; }

.lb-hero-elite {
    background: var(--emerald-grad);
    color: #fff;
    border-radius: 30px;
    padding: 60px 40px;
    text-align: center;
    margin-bottom: 50px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 45px rgba(6, 78, 59, 0.2);
}
.lb-hero-elite::after {
    content: '\f091'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
    position: absolute; bottom: -20px; right: -20px; font-size: 15rem; opacity: 0.1;
}

.elite-card-lb {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.03);
}

.lb-row-elite {
    display: flex;
    align-items: center;
    padding: 24px 30px;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s;
    background: #fff;
}
.lb-row-elite:hover { background: #fafafa; transform: scale(1.01); z-index: 2; box-shadow: 0 5px 20px rgba(0,0,0,0.02); }
.lb-row-elite:last-child { border-bottom: none; }

.lb-rank-num {
    width: 60px;
    font-size: 1.8rem;
    font-weight: 800;
    color: #cbd5e1;
    text-align: center;
}
.lb-rank-num.top-rank { font-size: 2.2rem; }

.lb-avatar-elite {
    width: 55px;
    height: 55px;
    border-radius: 18px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--elite-emerald);
    margin: 0 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
}

.lb-info-elite { flex: 1; }
.lb-name-elite { font-weight: 800; font-size: 1.15rem; color: #1e293b; letter-spacing: -0.5px; }
.lb-stats-elite { display: flex; gap: 12px; margin-top: 4px; }
.lb-stat-pill { background: #f8fafc; padding: 4px 10px; border-radius: 10px; font-size: 0.7rem; font-weight: 700; color: #64748b; border: 1px solid #f1f5f9; }

.lb-badges-elite { display: flex; gap: 8px; margin-top: 10px; }
.badge-mini { font-size: 1.1rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1)); }

.btn-elite-action {
    background: var(--emerald-grad);
    color: #fff;
    border: none;
    padding: 14px 35px;
    border-radius: 16px;
    font-weight: 700;
    box-shadow: 0 8px 20px rgba(6, 78, 59, 0.2);
    transition: all 0.3s;
    text-decoration: none;
}
.btn-elite-action:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(6, 78, 59, 0.3); color:#fff; }

.text-gold { color: #f59e0b; }
.text-bronze { color: #cd7f32; }
</style>

<div class="lb-page-wrapper">
    <div class="lb-container">
        
        <div class="lb-hero-elite">
            <h5 class="title-font text-white-50 mb-2" style="font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">Hall of Authority</h5>
            <h1 class="title-font fw-bold mb-3" style="font-size: 3.2rem; letter-spacing: -2px;">Top Influencers</h1>
            <p class="lead opacity-75">Recognizing the key connectors driving global timber commerce.</p>
        </div>

        <div class="elite-card-lb stagger-load">
            <?php if (empty($leaders)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-users-viewfinder fa-3x mb-3 opacity-20"></i>
                <p>Establishing rankings. Start sharing to claim your spot!</p>
            </div>
            <?php endif; ?>

            <?php foreach ($leaders as $i => $l): 
                $rank = $i + 1;
                $is_me = ($l['user_id'] == $this->session->userdata('id'));
                $ranks = ['top-rank text-gold', 'top-rank text-secondary', 'top-rank text-bronze'];
            ?>
            <div class="lb-row-elite <?= $is_me ? 'bg-light' : '' ?>">
                <div class="lb-rank-num <?= $ranks[$i] ?? '' ?>">
                    <?= $rank <= 3 ? ['🥇','🥈','🥉'][$rank-1] : "#$rank" ?>
                </div>
                
                <div class="lb-avatar-elite <?= $is_me ? 'border-success' : '' ?>">
                    <?= strtoupper(substr($l['username'] ?? 'U', 0, 1)) ?>
                </div>
                
                <div class="lb-info-elite">
                    <div class="lb-name-elite d-flex align-items-center gap-2">
                        <?= htmlspecialchars($l['username'] ?? 'User') ?>
                        <?php if($is_me): ?>
                            <span class="badge bg-success rounded-pill" style="font-size: 0.6rem;">YOU</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="lb-stats-elite">
                        <span class="lb-stat-pill"><i class="fa-solid fa-share-nodes me-1"></i> <?= (int)$l['share_count'] ?> SHARES</span>
                        <span class="lb-stat-pill"><i class="fa-solid fa-arrow-pointer me-1"></i> <?= (int)$l['click_count'] ?> CLICKS</span>
                    </div>

                    <?php if (!empty($l['badges'])): ?>
                    <div class="lb-badges-elite">
                        <?php foreach ($l['badges'] as $b): ?>
                        <span class="badge-mini" title="<?= htmlspecialchars($badge_defs[$b['badge_slug']][1] ?? '') ?>"><?= $badge_defs[$b['badge_slug']][0] ?? '🎖️' ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="lb-status">
                    <?php if ($rank === 1): ?>
                        <i class="fa-solid fa-crown fa-2x text-gold"></i>
                    <?php elseif ($rank <= 3): ?>
                        <i class="fa-solid fa-star fa-xl text-gold opacity-50"></i>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?= site_url('social_growth/my_insights') ?>" class="btn-elite-action">
                <i class="fa-solid fa-chart-line me-2"></i> View My Personal Performance
            </a>
        </div>

    </div>
</div>
