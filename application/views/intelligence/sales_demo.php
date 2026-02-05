<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Sales Command Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Orbitron:400,700|Roboto:300,400,700">
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-color: #3b82f6; /* Blue */
            --success-color: #10b981; /* Green */
            --warning-color: #f59e0b; /* Orange */
            --danger-color: #ef4444; /* Red */
            --glass-border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 20%);
            color: var(--text-primary);
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Header / Ticker */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: var(--glass-border);
            margin-bottom: 20px;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--accent-color);
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        .timestamp {
            font-family: 'Orbitron', sans-serif;
            color: var(--text-secondary);
        }

        /* Grid Layout */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: auto 1fr;
            gap: 20px;
            flex: 1;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: var(--glass-border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: var(--text-secondary);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .card-sub {
            font-size: 14px;
            color: var(--success-color);
            margin-top: 5px;
        }

        /* Hero Card (Sales Today) */
        .hero-card {
            grid-column: span 2;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(30, 41, 59, 0.7));
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-value {
            font-size: 64px;
            font-weight: 700;
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            font-family: 'Orbitron', sans-serif;
        }

        /* List Styling */
        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .product-name {
            font-weight: 500;
        }
        
        .product-meta {
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* Animations */
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .live-dot {
            width: 10px;
            height: 10px;
            background-color: var(--danger-color);
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: pulse 2s infinite;
        }
        
        /* Full Screen Button */
        .fullscreen-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .fullscreen-btn:hover {
            background: rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <span class="live-dot"></span> SALES COMMAND CENTER
        </div>
        <div class="timestamp" id="live-clock">--:--:--</div>
    </div>

    <div class="grid-container">
        <!-- Hero: Sales Today -->
        <div class="card hero-card">
            <div>
                <div class="card-title"><i class="fa fa-shopping-cart"></i> Sales Today</div>
                <div class="hero-value">Rs <?= number_format($today_sales, 0) ?></div>
                <div class="card-sub"><i class="fa fa-arrow-up"></i> Live Tracking</div>
            </div>
            <div style="text-align: right;">
                <div class="card-title">Invoices Generated</div>
                <div class="card-value"><?= $today_count ?></div>
            </div>
        </div>

        <!-- Monthly Sales -->
        <div class="card">
            <div class="card-title"><i class="fa fa-calendar"></i> This Month</div>
            <div class="card-value">Rs <?= number_format($month_sales, 0) ?></div>
            <div class="card-sub">Goal Progress: 65%</div>
            <!-- Simple Progress Bar -->
            <div style="background: rgba(255,255,255,0.1); height: 6px; border-radius: 3px; margin-top: 15px;">
                <div style="background: var(--success-color); width: 65%; height: 100%; border-radius: 3px; box-shadow: 0 0 10px var(--success-color);"></div>
            </div>
        </div>

        <!-- Conversion (Placeholder) -->
        <div class="card">
            <div class="card-title"><i class="fa fa-users"></i> Conversion Rate</div>
            <div class="card-value">24.5%</div>
            <div class="card-sub" style="color: var(--warning-color);"><i class="fa fa-minus"></i> Stable</div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 10px;">Avg Basket: Rs 4,500</div>
        </div>

        <!-- Recent Transactions Feed -->
        <div class="card" style="grid-column: span 2; grid-row: span 2; overflow-y: hidden;">
            <div class="card-title"><i class="fa fa-clock-o"></i> Recent Live Transactions</div>
            <div id="transaction-list">
                <?php foreach(array_slice($recent_transactions, 0, 7) as $txn): ?>
                <div class="list-item">
                    <div>
                        <div class="product-name"><?= $txn['account'] ?></div>
                        <div class="product-meta"><?= date('H:i', strtotime($txn['date'])) ?> • <?= $txn['method'] ?></div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: bold; color: var(--success-color);">+ Rs <?= number_format($txn['credit'], 2) ?></div>
                        <div class="product-meta">ID: #<?= $txn['id'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Top Products -->
        <div class="card" style="grid-column: span 2; grid-row: span 2;">
            <div class="card-title"><i class="fa fa-star"></i> Top Moving Products (30 Days)</div>
            <?php foreach($top_products as $prod): ?>
            <div class="list-item">
                <div>
                    <div class="product-name"><?= $prod['product_name'] ?></div>
                    <div class="product-meta">Qty Sold: <?= $prod['qty'] ?></div>
                </div>
                <div style="font-weight: bold;">
                    Rs <?= number_format($prod['subtotal'], 2) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>

    <button class="fullscreen-btn" onclick="toggleFullScreen()"><i class="fa fa-expand"></i></button>

    <script>
        // Live Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('live-clock').textContent = now.toLocaleTimeString();
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Simulated Refresh (Reload page every 60s)
        setTimeout(function() {
            window.location.reload();
        }, 60000);

        // Full Screen Toggle
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }
    </script>
</body>
</html>
