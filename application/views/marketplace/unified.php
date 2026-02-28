<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Buy Timber & Hire Workers | TimberPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f5f7fa; }
        
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
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
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
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .tab-nav {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            border-bottom: 3px solid #e0e0e0;
            justify-content: center;
        }
        
        .tab-btn {
            background: none;
            border: none;
            padding: 15px 40px;
            font-size: 20px;
            cursor: pointer;
            color: #666;
            border-bottom: 4px solid transparent;
            transition: all 0.3s;
            font-weight: 700;
            position: relative;
            top: 3px;
        }
        
        .tab-btn.active {
            color: #13ec5b;
            border-bottom-color: #13ec5b;
        }
        
        .tab-btn:hover {
            color: #13ec5b;
        }
        
        .tab-btn i {
            margin-right: 8px;
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
        
        iframe {
            width: 100%;
            min-height: 800px;
            border: none;
            border-radius: 12px;
            background: white;
        }
    </style>
</head>
<body>

<div class="marketplace-hero">
    <h1><i class="fa fa-shopping-cart"></i> TimberPro Marketplace</h1>
    <p>Buy Premium Timber • Hire Skilled Professionals • Direct Transactions</p>
    
    <div class="stats-bar">
        <div class="stat-item">
            <h3>500+</h3>
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
        <div class="stat-item">
            <h3>150+</h3>
            <p>Skilled Workers</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="tab-nav">
        <button class="tab-btn active" onclick="switchTab('timber')">
            <i class="fa fa-tree"></i> Timber Marketplace
        </button>
        <button class="tab-btn" onclick="switchTab('workers')">
            <i class="fa fa-users"></i> Find Workers
        </button>
    </div>

    <!-- TIMBER TAB -->
    <div id="timber-tab" class="tab-content active">
        <iframe src="<?= base_url('marketplace/timber_view') ?>"></iframe>
    </div>

    <!-- WORKERS TAB -->
    <div id="workers-tab" class="tab-content">
        <iframe src="<?= base_url('worker') ?>"></iframe>
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
