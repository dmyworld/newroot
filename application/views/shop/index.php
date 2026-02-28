<?php
$lots = $lots ?? [];
$featured_lots = $featured_lots ?? [];
$workers = $workers ?? [];
$hardware = $hardware ?? [];
$jobs = $jobs ?? [];
$quote_requests = $quote_requests ?? [];
$is_logged_in = $is_logged_in ?? false;
$usernm = $usernm ?? '';

$districts = ['Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo', 'Galle', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara', 'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar', 'Matale', 'Matara', 'Moneragala', 'Mullaitivu', 'Nuwara Eliya', 'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TimberPro Ecosystem | Marketplace' ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            --accent-gradient: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.3);
            --premium-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f0f4f8;
            color: #2d3436;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .ecosystem-header {
            background: var(--primary-gradient);
            padding: 60px 20px 100px;
            text-align: center;
            color: white;
            position: relative;
        }

        .ecosystem-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .search-container {
            max-width: 800px;
            margin: -40px auto 0;
            position: relative;
            z-index: 10;
        }

        .smart-search-bar {
            background: white;
            border-radius: 50px;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            box-shadow: var(--premium-shadow);
            border: 1px solid var(--glass-border);
        }

        .smart-search-bar input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 1.1rem;
            padding: 0 15px;
        }

        .smart-search-bar i {
            color: #2a5298;
            font-size: 1.2rem;
        }

        .ecosystem-tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .eco-tab-btn {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 12px 25px;
            border-radius: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .eco-tab-btn.active {
            background: #2a5298;
            color: white;
            border-color: #2a5298;
            transform: translateY(-5px);
        }

        .eco-tab-btn i { font-size: 1.2rem; }

        .tab-content {
            display: none;
            padding: 40px 5%;
            animation: fadeIn 0.5s ease;
        }

        .tab-content.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .eco-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            border: 1px solid #eee;
        }

        .eco-card:hover { transform: translateY(-10px); }

        .card-img {
            height: 200px;
            background: #eee;
            position: relative;
        }

        .card-img img { width: 100%; height: 100%; object-fit: cover; }

        .card-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
        }

        .card-body { padding: 20px; }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1e3c72;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #636e72;
            margin-bottom: 15px;
        }

        .card-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2ecc71;
        }

        .card-btn {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #f1f2f6;
            color: #1e3c72;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .card-btn:hover { background: #2a5298; color: white; }

        /* Quotation Hub Styles */
        .hub-banner {
            background: var(--accent-gradient);
            padding: 40px;
            border-radius: 30px;
            color: white;
            text-align: center;
            margin-bottom: 40px;
        }

        .request-card {
            background: #fff;
            border-left: 5px solid #00b09b;
        }

        .installment-badge {
            background: #e17055;
            color: white;
            padding: 2px 8px;
            border-radius: 5px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

    </style>
</head>
<body>

<?php $this->load->view('shop/header'); ?>

<header class="ecosystem-header">
    <h1>TimberPro Ecosystem</h1>
    <p>The Ultimate Marketplace for Timber, Hardware, & Professionals</p>
    
    <div class="ecosystem-tabs">
        <button class="eco-tab-btn active" onclick="switchTab('timber')"><i class="fa fa-tree"></i> Timber</button>
        <button class="eco-tab-btn" onclick="switchTab('hardware')"><i class="fa fa-tools"></i> Hardware</button>
        <button class="eco-tab-btn" onclick="switchTab('services')"><i class="fa fa-person-digging"></i> Professionals</button>
        <button class="eco-tab-btn" onclick="switchTab('quotes')"><i class="fa fa-file-invoice-dollar"></i> Quote Hub</button>
        <button class="eco-tab-btn" onclick="switchTab('jobs')"><i class="fa fa-clipboard-list"></i> Job Board</button>
    </div>
</header>

<div class="search-container">
    <div class="smart-search-bar">
        <i class="fa fa-search"></i>
        <input type="text" id="smartSearch" placeholder="Search across the entire ecosystem..." onkeyup="doSmartSearch()">
        <div id="searchSuggestions"></div>
    </div>
</div>

<!-- TIMBER TAB -->
<div id="timber-tab" class="tab-content active">
    <div class="section-grid">
        <?php foreach($lots as $lot): ?>
        <div class="eco-card">
            <div class="card-img">
                <img src="<?= !empty($lot['thumbnail']) ? base_url($lot['thumbnail']) : 'https://placehold.co/400x300?text=Timber' ?>" alt="Timber">
                <span class="card-tag"><?= strtoupper($lot['lot_type'] ?? 'Logs') ?></span>
                <?php if($lot['is_verified'] ?? false): ?><span class="card-tag" style="left: auto; right: 15px; background: #2ecc71;"><i class="fa fa-check-circle"></i> VERIFIED</span><?php endif; ?>
            </div>
            <div class="card-body">
                <div class="card-title"><?= htmlspecialchars($lot['name'] ?? 'Timber Lot') ?></div>
                <div class="card-meta">
                    <span><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($lot['location'] ?? 'Sri Lanka') ?></span>
                    <span><i class="fa fa-cube"></i> <?= $lot['volume_cuft'] ?? 'N/A' ?> cuft</span>
                </div>
                <div class="card-price">LKR <?= number_format($lot['price'] ?? 0) ?></div>
                <button class="card-btn" onclick="window.location.href='<?= base_url('shop/view/'.($lot['type']??'logs').'/'.$lot['id']) ?>'">View Details</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- HARDWARE TAB -->
<div id="hardware-tab" class="tab-content">
    <div class="section-grid">
        <?php foreach($hardware as $p): ?>
        <div class="eco-card">
            <div class="card-img">
                <img src="https://placehold.co/400x300?text=<?= urlencode($p['product_name']) ?>" alt="Product">
                <span class="card-tag"><?= htmlspecialchars($p['category_name'] ?? 'General') ?></span>
                <?php if($p['installment_support'] ?? false): ?><span class="installment-badge">Installments</span><?php endif; ?>
            </div>
            <div class="card-body">
                <div class="card-title"><?= htmlspecialchars($p['product_name']) ?></div>
                <div class="card-meta">
                    <span>In Stock: <?= (int)$p['qty'] ?></span>
                </div>
                <div class="card-price">LKR <?= number_format($p['sell_price']) ?></div>
                <button class="card-btn">Buy Now</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- PROFESSIONALS TAB -->
<div id="services-tab" class="tab-content">
    <div class="section-grid">
        <?php foreach($workers as $w): ?>
        <div class="eco-card">
            <div class="card-img">
                <div style="height: 100%; display: flex; align-items: center; justify-content: center; background: #2a5298; color: white; font-size: 3rem; font-weight: 700;">
                    <?= strtoupper(substr($w['display_name'] ?? 'P', 0, 1)) ?>
                </div>
                <span class="card-tag"><?= htmlspecialchars($w['category_name'] ?? 'Expert') ?></span>
            </div>
            <div class="card-body">
                <div class="card-title"><?= htmlspecialchars($w['display_name'] ?? 'Unnamed Pro') ?></div>
                <div class="card-meta">
                    <span><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($w['location'] ?? 'Global') ?></span>
                </div>
                <div class="card-price">LKR <?= number_format($w['pay_rate'] ?? 0) ?> <small>/ <?= $w['pay_type'] ?? 'hr' ?></small></div>
                <button class="card-btn">Hire Pro</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- QUOTATION HUB -->
<div id="quotes-tab" class="tab-content">
    <div class="hub-banner">
        <h2>Quotation Request Hub</h2>
        <p>Post your requirements and get competitive bids from verified suppliers islandwide.</p>
        <button class="card-btn" style="width: auto; padding: 15px 40px; background: white;">POST A REQUEST</button>
    </div>
    <div class="section-grid">
        <?php foreach($quote_requests as $req): ?>
        <div class="eco-card request-card">
            <div class="card-body">
                <div class="card-title"><?= htmlspecialchars($req['title']) ?></div>
                <p style="font-size: 0.9rem; color: #666;"><?= substr($req['description'], 0, 100) ?>...</p>
                <div class="card-meta" style="margin-top: 20px;">
                    <span><i class="fa fa-user"></i> <?= htmlspecialchars($req['username'] ?? 'User') ?></span>
                    <span><i class="fa fa-clock"></i> <?= date('M d', strtotime($req['created_at'])) ?></span>
                </div>
                <button class="card-btn">Submit Quote</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- JOB BOARD -->
<div id="jobs-tab" class="tab-content">
    <div class="hub-banner" style="background: var(--primary-gradient);">
        <h2>Workforce Job Board</h2>
        <p>Browse timber harvesting, carpentry, and transport jobs posted by customers.</p>
    </div>
    <div class="section-grid">
        <?php foreach($jobs as $job): ?>
        <div class="eco-card">
            <div class="card-body">
                <div class="card-title"><?= htmlspecialchars($job['job_title']) ?></div>
                <div class="card-meta">
                    <span style="color: #e67e22; font-weight: 700;"><i class="fa fa-wallet"></i> Budget: LKR <?= number_format($job['budget']) ?></span>
                </div>
                <div class="card-meta">
                    <span><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($job['district']) ?></span>
                    <span><i class="fa fa-tag"></i> <?= strtoupper($job['status']) ?></span>
                </div>
                <button class="card-btn">Apply for Job</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php $this->load->view('shop/footer'); ?>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.eco-tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    event.currentTarget.classList.add('active');
    document.getElementById(tabName + '-tab').classList.add('active');
}

function doSmartSearch() {
    const q = document.getElementById('smartSearch').value;
    if (q.length < 2) return;

    fetch('<?= base_url('shop/smart_search') ?>?q=' + q)
        .then(r => r.json())
        .then(data => {
            console.log("Search Results:", data);
            // Dynamic UI update logic could go here
        });
}
</script>
</body>
</html>
