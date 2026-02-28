<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timber Marketplace - Buy & Sell Premium Timber</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        .marketplace-hero {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #13ec5b 100%);
            padding: 60px 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .marketplace-hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }
        
        .marketplace-hero p {
            font-size: 20px;
            opacity: 0.95;
        }
        
        .stats-bar {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            margin-top: 30px;
            border-radius: 12px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
            padding: 10px 20px;
        }
        
        .stat-item h3 {
            font-size: 36px;
            font-weight: 700;
            color: #13ec5b;
        }
        
        .stat-item p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .marketplace-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .tab-nav {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .tab-btn {
            background: none;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            cursor: pointer;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .tab-btn.active {
            color: #13ec5b;
            border-bottom-color: #13ec5b;
        }
        
        .tab-btn:hover {
            color: #13ec5b;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #13ec5b;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            z-index: 1;
        }
        
       .product-badge.verified {
            background: #2a5298;
        }
        
        .product-image {
            height: 180px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: 700;
        }
        
        .product-body {
            padding: 20px;
        }
        
        .product-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
        }
        
        .product-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
            color: #666;
        }
        
        .product-detail strong {
            color: #333;
        }
        
        .product-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background: #2a5298;
            color: white;
            flex: 1;
        }
        
        .btn-primary:hover {
            background: #1e3c72;
        }
        
        .btn-success {
            background: #13ec5b;
            color: white;
            flex: 1;
        }
        
        .btn-success:hover {
            background: #0fa84b;
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .login-prompt {
            background: rgba(19, 236, 91, 0.1);
            border: 2px solid #13ec5b;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
        }
        
        .login-prompt a {
            color: #13ec5b;
            font-weight: 700;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="marketplace-hero">
    <h1><i class="fa fa-shopping-cart"></i> Timber Marketplace</h1>
    <p>Connect Premium Buyers & Sellers • Direct Transactions • Verified Quality</p>
    
    <div class="stats-bar">
        <div class="stat-item">
            <h3><?= count($lots) ?></h3>
            <p>Active Listings</p>
        </div>
        <div class="stat-item">
            <h3>2,500+</h3>
            <p>Verified Users</p>
        </div>
        <div class="stat-item">
            <h3>$2.5M+</h3>
            <p>Transactions</p>
        </div>
    </div>
</div>

<div class="marketplace-container">
    <div class="tab-nav">
        <button class="tab-btn active" onclick="switchTab('sell')">
            <i class="fa fa-tags"></i> For Sale
        </button>
        <button class="tab-btn" onclick="switchTab('buy')">
            <i class="fa fa-shopping-basket"></i> Wanted / Requests
        </button>
    </div>

    <!-- FOR SALE TAB -->
    <div id="sell-tab" class="tab-content active">
        <?php if(empty($lots)): ?>
            <div class="empty-state">
                <i class="fa fa-inbox"></i>
                <h3>No Active Listings</h3>
                <p>Check back later for new timber opportunities</p>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach($lots as $lot): ?>
                    <div class="product-card">
                        <div class="product-badge verified">✓ VERIFIED</div>
                        <div class="product-image">
                            <?= strtoupper(substr($lot['lot_name'], 0, 3)) ?>
                        </div>
                        <div class="product-body">
                            <div class="product-title"><?= $lot['lot_name'] ?></div>
                            <div class="product-detail">
                                <span><strong>Volume:</strong></span>
                                <span><?= number_format($lot['total_cubic_feet'], 2) ?> ft³</span>
                            </div>
                            <div class="product-detail">
                                <span><strong>Posted:</strong></span>
                                <span><?= date('M d, Y', strtotime($lot['created_at'])) ?></span>
                            </div>
                            <div class="product-actions">
                                <?php if($is_logged_in): ?>
                                    <a href="<?= base_url('marketplace/view/logs/' . $lot['id']) ?>" class="btn btn-primary">
                                        <i class="fa fa-eye"></i> View & Buy
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('user') ?>" class="btn btn-success">
                                        <i class="fa fa-sign-in"></i> Login to Buy
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- WANTED / BUY REQUESTS TAB -->
    <div id="buy-tab" class="tab-content">
        <div class="empty-state">
            <i class="fa fa-search"></i>
            <h3>Buyer Requests Coming Soon</h3>
            <p>This feature allows buyers to post what they're looking for</p>
        </div>
        
        <?php if(!$is_logged_in): ?>
            <div class="login-prompt">
                <i class="fa fa-info-circle"></i> 
                <a href="<?= base_url('user') ?>">Login</a> or 
                <a href="<?= base_url('hub/register') ?>">Register</a> to post your timber requests and connect with sellers
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function switchTab(tab) {
    // Update buttons
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.tab-btn').classList.add('active');
    
    // Update content
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tab + '-tab').classList.add('active');
}
</script>

</body>
</html>
