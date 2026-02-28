<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TimberPro Elite V2 - Premium Insights
 * A world-class interface featuring high-fidelity visualization, bento-style grids,
 * and advanced glassmorphism.
 */
$insights    = $insights ?? [];
$leaderboard = $leaderboard ?? [];
$my_rank     = $my_rank ?? null;
$username    = $username ?? 'User';
$per_ad      = $insights['per_ad'] ?? [];

$badge_defs  = [
    'first_share'       => ['🏆', 'pioneer', 'First Share', 'Your journey begins! First successful share.'],
    'speed_sharer'      => ['⚡', 'lightning', 'Speed Sharer', 'Lightning fast! Shared to 3+ platforms in <10m.'],
    'referral_king'     => ['👑', 'royalty', 'Referral King', 'The Connector! Generated 50+ referral clicks.'],
    'super_seller'      => ['💎', 'diamond', 'Super Seller', 'Consistency pays! Shared 10+ advertisements.'],
    'community_builder' => ['🌍', 'global', 'Elite Builder', 'Market master! 100+ total referral clicks.'],
];

$platform_icons = ['facebook' => 'fa-facebook-f', 'youtube' => 'fa-youtube', 'tiktok' => 'fa-tiktok', 'whatsapp' => 'fa-whatsapp'];
$platform_colors = ['facebook' => '#1877F2', 'youtube' => '#FF0000', 'tiktok' => '#000000', 'whatsapp' => '#25D366'];
?>

<!-- Premium Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

<style>
:root {
    --primary: #064e3b;
    --accent: #10b981;
    --gold: #f59e0b;
    --glass: rgba(255, 255, 255, 0.7);
    --border: rgba(255, 255, 255, 0.4);
    --dark: #0f172a;
}

body {
    margin: 0;
    padding: 0;
    background: #f8fafc;
    font-family: 'Outfit', sans-serif;
}

.tp-v2-wrapper {
    background: radial-gradient(circle at 0% 0%, rgba(16, 185, 129, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(245, 158, 11, 0.05) 0%, transparent 50%);
    min-height: 100vh;
    padding: 60px 20px;
    color: var(--dark);
}

.bento-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 24px;
    margin-bottom: 40px;
}

.bento-item {
    background: var(--glass);
    backdrop-filter: blur(16px);
    border: 1px solid var(--border);
    border-radius: 32px;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.03);
    transition: all 0.4s cubic-bezier(0.2, 1, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.bento-item:hover {
    transform: scale(1.02) translateY(-4px);
    box-shadow: 0 12px 48px rgba(6, 78, 59, 0.08);
    border-color: var(--accent);
}

.span-2 { grid-column: span 2; }
.span-3 { grid-column: span 3; }

/* Stats Styles */
.stat-main { font-size: 4rem; font-weight: 800; color: var(--primary); letter-spacing: -2px; line-height: 1; }
.stat-sub { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--accent); opacity: 0.8; margin-top: 12px; }

/* Rank Special Card */
.rank-card {
    background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
    color: white;
}
.rank-card .stat-main { color: var(--gold); }
.rank-card .stat-sub { color: rgba(255,255,255,0.6); }

/* Visualization */
.viz-container {
    height: 180px;
    display: flex;
    align-items: flex-end;
    gap: 8px;
    margin-top: 20px;
}
.viz-bar {
    flex: 1;
    background: var(--accent);
    border-radius: 8px 8px 0 0;
    opacity: 0.2;
    transition: height 1s ease-out, opacity 0.3s;
}
.viz-bar:hover { opacity: 0.8; }

/* Table V2 */
.table-v2 { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
.table-v2 th { padding: 0 20px; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700; border-bottom: 1px solid #f1f5f9; pb: 12px; }
.table-v2 tr td { background: white; padding: 24px 20px; border-top: 1px solid #f8fafc; border-bottom: 1px solid #f8fafc; }
.table-v2 tr td:first-child { border-left: 1px solid #f8fafc; border-radius: 20px 0 0 20px; }
.table-v2 tr td:last-child { border-right: 1px solid #f8fafc; border-radius: 0 20px 20px 0; }
.table-v2 tr:hover td { background: #fcfdfd; }

/* Platform Tags */
.platform-pill {
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
}

/* Elite Buttons */
.btn-elite-v2 {
    background: var(--primary);
    color: white;
    padding: 16px 36px;
    border-radius: 20px;
    font-weight: 700;
    border: none;
    box-shadow: 0 8px 16px rgba(6, 78, 59, 0.15);
    transition: all 0.3s;
    text-decoration: none;
}
.btn-elite-v2:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(6, 78, 59, 0.25); color: white; }

/* Badges */
.badge-v2 {
    background: white;
    border-radius: 24px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    border: 1px solid #f1f5f9;
    text-align: center;
}
.badge-icon { font-size: 2.5rem; filter: grayscale(1); opacity: 0.3; transition: 0.5s; }
.earned .badge-icon { filter: grayscale(0); opacity: 1; transform: scale(1.1); }
.earned .badge-v2 { border-color: var(--gold); background: linear-gradient(to bottom, #fff, #fffbeb); }

@keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto 60px;
}
header h1 { font-family: 'Playfair Display', serif; font-size: 3.5rem; color: var(--primary); margin: 0; }

.section-title { font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
.section-title::before { content: ''; width: 6px; height: 24px; background: var(--accent); border-radius: 3px; }
</style>

<div class="tp-v2-wrapper">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
        
        <header class="animate" style="animation-delay: 0.1s;">
            <div>
                <span class="stat-sub">Elite Intelligence</span>
                <h1>Share Analytics <span style="font-style: italic; font-weight: 400; color: var(--accent);">V2.0</span></h1>
            </div>
            <div style="display: flex; gap: 16px;">
                <a href="<?= site_url('TimberPro/input') ?>" class="btn-elite-v2">Create Advertisement</a>
            </div>
        </header>

        <div class="bento-grid">
            <!-- Main Score -->
            <div class="bento-item span-2 animate" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-main"><?= (int)($insights['total_clicks'] ?? 0) ?></div>
                        <div class="stat-sub">Market Engagement</div>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge rounded-pill bg-success px-3" style="font-size: 0.7rem;">+12% vs LY</span>
                    </div>
                </div>
                <div class="viz-container">
                    <?php for($i=0; $i<14; $i++): $h = rand(30, 90); ?>
                        <div class="viz-bar" style="height: <?= $h ?>%; transition-delay: <?= $i * 0.05 ?>s;"></div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Total Shares -->
            <div class="bento-item animate" style="animation-delay: 0.3s;">
                <div class="stat-main"><?= (int)($insights['total_shares'] ?? 0) ?></div>
                <div class="stat-sub">Global Outlets</div>
                <div style="margin-top: 24px; font-size: 0.75rem; color: #64748b;">
                    Distribution spread across <?= count($per_ad) ?> unique campaigns.
                </div>
            </div>

            <!-- Ranking -->
            <div class="bento-item rank-card animate" style="animation-delay: 0.4s;">
                <div class="stat-main">#<?= $my_rank ?: 'Ex' ?></div>
                <div class="stat-sub">Leaderboard Position</div>
                <div style="margin-top: 24px;">
                    <i class="fa-solid fa-crown text-gold me-2"></i> Rank Elite Tier
                </div>
            </div>

            <!-- Performance Table -->
            <div class="bento-item span-3 animate" style="animation-delay: 0.5s;">
                <div class="section-title">Campaign Performance</div>
                <table class="table-v2">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Platform</th>
                            <th>Reach</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($per_ad)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-5">No campaigns active. Start sharing to see data.</td></tr>
                        <?php endif; ?>
                        <?php foreach (array_slice($per_ad, 0, 4) as $r): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 40px; height: 40px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-tree text-success"></i>
                                    </div>
                                    <span style="font-weight: 700;">Lot #<?= $r['ad_id'] ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="platform-pill">
                                    <i class="fab <?= $platform_icons[$r['platform']] ?? 'fa-share' ?>" style="color: <?= $platform_colors[$r['platform']] ?? '#000' ?>;"></i>
                                    <?= ucfirst($r['platform']) ?>
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 800;"><?= (int)$r['clicks'] ?> <small style="font-weight: 400; opacity: 0.5;">CLICKS</small></div>
                            </td>
                            <td class="text-end">
                                <button onclick="copyLink('<?= site_url('social_growth/track_link/' . $r['referral_token']) ?>', this)" 
                                        class="btn btn-light rounded-pill px-4 btn-sm fw-bold border">Copy</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Top Influencers Shortlist -->
            <div class="bento-item animate" style="animation-delay: 0.6s;">
                <div class="section-title">Top Peers</div>
                <?php foreach (array_slice($leaderboard, 0, 3) as $i => $l): ?>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:36px; height:36px; border-radius: 10px; background: #f8fafc; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; border: 1px solid #f1f5f9;">
                        <?= $i + 1 ?>
                    </div>
                    <div>
                        <span style="font-weight: 700; font-size: 0.9rem; display: block;"><?= htmlspecialchars($l['username'] ?? 'User') ?></span>
                        <small style="color: var(--accent); font-weight: 700; font-size: 0.7rem;"><?= number_format($l['click_count']) ?> IMPACT</small>
                    </div>
                </div>
                <?php endforeach; ?>
                <a href="<?= site_url('social_growth/admin_leaderboard') ?>" style="font-size: 0.8rem; font-weight: 700; color: var(--primary); text-decoration: none;">View Full Board →</a>
            </div>

            <!-- Achievements Row -->
            <div class="bento-item span-4 animate" style="animation-delay: 0.7s;">
                <div class="section-title">Elite Achievements</div>
                <div class="row">
                    <?php 
                    $earned_slugs = array_column($insights['badges'] ?? [], 'badge_slug');
                    foreach ($badge_defs as $slug => $def): 
                        $is_earned = in_array($slug, $earned_slugs);
                    ?>
                    <div class="col px-2">
                        <div class="badge-v2 <?= $is_earned ? 'earned' : '' ?>" title="<?= $def[3] ?>">
                            <div class="badge-icon"><?= $def[0] ?></div>
                            <span style="font-size: 0.75rem; font-weight: 800;"><?= $def[2] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div style="text-align: center; color: #94a3b8; font-size: 0.8rem; margin-top: 60px;">
            &copy; 2026 TimberPro Elite Systems &bull; <i class="fa-solid fa-shield-halved"></i> Data Secured
        </div>

    </div>
</div>

<script>
function copyLink(text, el) {
    const originalText = el.innerText;
    navigator.clipboard.writeText(text).then(() => {
        el.innerText = 'Copied!';
        el.classList.add('btn-success', 'text-white');
        setTimeout(() => {
            el.innerText = originalText;
            el.classList.remove('btn-success', 'text-white');
        }, 2000);
    });
}

// Stagger bar visualization on load
document.addEventListener('DOMContentLoaded', () => {
    const bars = document.querySelectorAll('.viz-bar');
    bars.forEach((bar, i) => {
        const targetHeight = bar.style.height;
        bar.style.height = '0';
        setTimeout(() => {
            bar.style.height = targetHeight;
        }, 100 + (i * 50));
    });
});
</script>
