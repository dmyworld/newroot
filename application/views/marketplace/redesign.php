<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timber Marketplace - Buy Premium Timber Direct | TimberPro</title>
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Premium Timber Marketplace - TimberPro">
    <meta property="og:description" content="Buy and sell premium timber directly. 500+ active listings from verified sellers across Sri Lanka.">
    <meta property="og:image" content="<?= base_url('assets/images/marketplace-og.jpg') ?>">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Premium Timber Marketplace">
    <meta name="twitter:description" content="Direct timber trading platform with 2,500+ verified users">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f5f7fa; }
        
        /* Hero Carousel */
        .marketplace-hero {
            position: relative;
            height: 500px;
            overflow: hidden;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        
        .hero-swiper {
            width: 100%;
            height: 100%;
        }
        
        .hero-slide {
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(30, 60, 114, 0.95), rgba(42, 82, 152, 0.7));
            display: flex;
            align-items: center;
            padding: 0 50px;
        }
        
        .hero-content h1 {
            font-size: 56px;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }
        
        .hero-content p {
            font-size: 22px;
            color: rgba(255,255,255,0.95);
            margin-bottom: 25px;
        }
        
        .hero-search {
            display: flex;
            gap: 10px;
            max-width: 600px;
        }
        
        .hero-search input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .hero-search button {
            padding: 15px 40px;
            background: #13ec5b;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .hero-search button:hover {
            background: #0fc94d;
            transform: scale(1.05);
        }
        
        /* Stats Bar */
        .stats-bar {
            background: white;
            padding: 30px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stats-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
            padding: 10px 20px;
        }
        
        .stat-item h3 {
            font-size: 42px;
            font-weight: 700;
            color: #2a5298;
            margin-bottom: 5px;
        }
        
        .stat-item p {
            font-size: 16px;
            color: #666;
        }
        
        /* Main Container */
        .marketplace-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }
        
        /* Filters Sidebar */
        .filters-sidebar {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .filter-section {
            margin-bottom: 25px;
        }
        
        .filter-section h3 {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-section h3 i {
            color: #2a5298;
        }
        
        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .filter-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            cursor: pointer;
            border-radius: 6px;
            transition: background 0.2s;
        }
        
        .filter-option:hover {
            background: #f5f7fa;
        }
        
        .filter-option input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .filter-option label {
            flex: 1;
            cursor: pointer;
            font-size: 14px;
        }
        
        .price-range {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .price-range input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .filter-btn {
            width: 100%;
            padding: 10px;
            background: #2a5298;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-btn:hover {
            background: #1e3c72;
        }
        
        .reset-filters {
            width: 100%;
            padding: 8px;
            background: transparent;
            color: #666;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 14px;
        }
        
        /* Listings Area */
        .listings-area {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .listings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .listings-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }
        
        .view-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .view-toggle {
            display: flex;
            gap: 5px;
            background: #f5f7fa;
            padding: 5px;
            border-radius: 8px;
        }
        
        .view-toggle button {
            padding: 8px 12px;
            background: transparent;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            color: #666;
            transition: all 0.2s;
        }
        
        .view-toggle button.active {
            background: white;
            color: #2a5298;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .sort-dropdown {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }
        
        /* Listings Grid */
        .listings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }
        
        .listing-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s;
            position: relative;
        }
        
        .listing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .listing-image {
            position: relative;
            height: 220px;
            background-size: cover;
            background-position: center;
            background-color: #f0f0f0;
        }
        
        .listing-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(19, 236, 91, 0.95);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .listing-badge.featured {
            background: rgba(255, 165, 0, 0.95);
        }
        
        .listing-actions {
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            background: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }
        
        .action-btn i {
            color: #666;
        }
        
        .action-btn.share i {
            color: #13ec5b;
        }
        
        .action-btn.favorite i {
            color: #ff4757;
        }
        
        .listing-content {
            padding: 20px;
        }
        
        .listing-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .listing-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #666;
        }
        
        .meta-item i {
            color: #2a5298;
        }
        
        .listing-price {
            font-size: 28px;
            font-weight: 700;
            color: #13ec5b;
            margin-bottom: 12px;
        }
        
        .listing-description {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            max-height: 60px;
            overflow: hidden;
        }
        
        .listing-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        .seller-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .seller-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #2a5298;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
        
        .seller-name {
            font-size: 13px;
            color: #666;
        }
        
        .view-btn {
            padding: 10px 20px;
            background: #2a5298;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .view-btn:hover {
            background: #1e3c72;
            transform: scale(1.05);
        }
        
        /* Share Modal */
        .share-modal, .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .share-modal.active, .modal-overlay.active {
            display: flex;
        }
        
        .share-content, .modal-content {
            background: white;
            padding: 35px;
            border-radius: 16px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .share-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .share-header h3 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #666;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }
        
        .close-modal:hover {
            background: #f5f7fa;
        }
        
        .share-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .share-btn {
            padding: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
        }
        
        .share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .share-btn i {
            font-size: 20px;
        }
        
        .share-btn.facebook {
            background: #1877f2;
            color: white;
        }
        
        .share-btn.twitter {
            background: #1da1f2;
            color: white;
        }
        
        .share-btn.linkedin {
            background: #0077b5;
            color: white;
        }
        
        .share-btn.whatsapp {
            background: #25d366;
            color: white;
        }
        
        .share-btn.telegram {
            background: #0088cc;
            color: white;
        }
        
        .share-btn.email {
            background: #ea4335;
            color: white;
        }
        
        .share-link-box {
            background: #f5f7fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .share-link-box p {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .share-link-input {
            display: flex;
            gap: 10px;
        }
        
        .share-link-input input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .copy-btn {
            padding: 12px 20px;
            background: #2a5298;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .copy-btn:hover {
            background: #1e3c72;
        }
        
        .copy-btn.copied {
            background: #13ec5b;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .marketplace-container {
                grid-template-columns: 1fr;
            }
            
            .filters-sidebar {
                position: static;
            }
        }
        
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 36px;
            }
            
            .hero-content p {
                font-size: 16px;
            }
            
            .listings-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<!-- Hero Carousel -->
<div class="marketplace-hero">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <?php $featured = isset($featured_lots) ? array_slice($featured_lots, 0, 5) : []; ?>
            <?php if(empty($featured)): ?>
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1550537687-c91072c4792d?w=1920');">
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h1>🌲 Premium Timber Marketplace</h1>
                        <p>Buy and sell timber directly from verified suppliers across Sri Lanka</p>
                        <div class="hero-search">
                            <input type="text" placeholder="Search timber types, species, or location..." id="heroSearch">
                            <button><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <?php foreach($featured as $item): ?>
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1550537687-c91072c4792d?w=1920');">
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h1><?= htmlspecialchars($item['name'] ?? 'Premium Timber') ?></h1>
                        <p><?= htmlspecialchars($item['location'] ?? 'Sri Lanka') ?> • <?= number_format($item['volume'] ?? 0) ?> ft³</p>
                        <div class="hero-search">
                            <button onclick="window.location.href='<?= base_url('marketplace/view/'.$item['type'].'/'.$item['id']) ?>'">View Details →</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="stats-container">
        <div class="stat-item">
            <h3><?= count($lots) ?></h3>
            <p>Active Listings</p>
        </div>
        <div class="stat-item">
            <h3>2,500+</h3>
            <p>Verified Sellers</p>
        </div>
        <div class="stat-item">
            <h3>$2.5M+</h3>
            <p>Total Transactions</p>
        </div>
        <div class="stat-item">
            <h3>4.8★</h3>
            <p>Average Rating</p>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="marketplace-container">
    <!-- Filters Sidebar -->
    <aside class="filters-sidebar">
        <div class="filter-section">
            <h3><i class="fa fa-sliders"></i> Filters</h3>
        </div>
        
        <div class="filter-section">
            <h3><i class="fa fa-tag"></i> Price Range</h3>
            <div class="price-range">
                <input type="number" placeholder="Min" id="priceMin">
                <input type="number" placeholder="Max" id="priceMax">
            </div>
        </div>
        
        <div class="filter-section">
            <h3><i class="fa fa-tree"></i> Timber Type</h3>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="type_logs" value="logs">
                    <label for="type_logs">Logs</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type_standing" value="standing">
                    <label for="type_standing">Standing Trees</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="type_sawn" value="sawn">
                    <label for="type_sawn">Sawn Timber</label>
                </div>
            </div>
        </div>
        
        <div class="filter-section">
            <h3><i class="fa fa-map-marker-alt"></i> Location</h3>
            <div class="filter-options">
                <div class="filter-option">
                    <input type="checkbox" id="loc_western" value="Western">
                    <label for="loc_western">Western Province</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="loc_southern" value="Southern">
                    <label for="loc_southern">Southern Province</label>
                </div>
                <div class="filter-option">
                    <input type="checkbox" id="loc_central" value="Central">
                    <label for="loc_central">Central Province</label>
                </div>
            </div>
        </div>
        
        <button class="filter-btn" onclick="applyFilters()"><i class="fa fa-check"></i> Apply Filters</button>
        <button class="reset-filters" onclick="resetFilters()"><i class="fa fa-redo"></i> Reset</button>
    </aside>
    
    <!-- Listings Area -->
    <main class="listings-area">
        <div class="listings-header">
            <h2>All Listings <span id="resultCount">(<?= count($lots) ?>)</span></h2>
            <div class="view-controls">
                <div class="view-toggle">
                    <button class="active" onclick="setView('grid')"><i class="fa fa-th-large"></i></button>
                    <button onclick="setView('list')"><i class="fa fa-list"></i></button>
                </div>
                <select class="sort-dropdown" onchange="sortListings(this.value)">
                    <option value="newest">Newest First</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="volume">Volume</option>
                </select>
            </div>
        </div>
        
        <div class="listings-grid" id="listingsGrid">
            <?php foreach($lots as $item): ?>
            <div class="listing-card" data-type="<?= $item['type'] ?>" data-price="<?= $item['price'] ?? 0 ?>" data-location="<?= $item['location'] ?? '' ?>">
                <div class="listing-image" style="background-image: url('https://images.unsplash.com/photo-1550537687-c91072c4792d?w=600');">
                    <?php if($item['featured'] ?? false): ?>
                    <span class="listing-badge featured">★ FEATURED</span>
                    <?php else: ?>
                    <span class="listing-badge">AVAILABLE</span>
                    <?php endif; ?>
                    
                    <div class="listing-actions">
                        <button class="action-btn favorite" title="Add to Favorites">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="action-btn share" onclick="openShareModal('<?= $item['id'] ?>', '<?= $item['type'] ?>')" title="Share Listing">
                            <i class="fa fa-share-alt"></i>
                        </button>
                    </div>
                </div>
                
                <div class="listing-content">
                    <h3 class="listing-title"><?= htmlspecialchars($item['name'] ?? 'Timber Lot') ?></h3>
                    
                    <div class="listing-meta">
                        <span class="meta-item">
                            <i class="fa fa-cube"></i>
                            <?= number_format($item['volume'] ?? 0) ?> ft³
                        </span>
                        <span class="meta-item">
                            <i class="fa fa-map-marker-alt"></i>
                            <?= htmlspecialchars($item['location'] ?? 'N/A') ?>
                        </span>
                        <span class="meta-item">
                            <i class="fa fa-calendar"></i>
                            <?= date('M d', strtotime($item['created_at'] ?? 'now')) ?>
                        </span>
                    </div>
                    
                    <div class="listing-price">
                        LKR <?= number_format($item['price'] ?? 0) ?>
                    </div>
                    <p class="listing-description"><?= htmlspecialchars($item['description'] ?? 'Premium quality timber lot available for immediate purchase.') ?></p>
                                    
                    <div class="d-flex gap-2 mb-3">
                        <button class="btn btn-sm btn-outline-primary flex-fill" onclick="openChatModal(<?= $item['seller_id'] ?? 0 ?>, '<?= htmlspecialchars($item['lot_name'] ?? $item['name']) ?>')"><i class="fa fa-comments"></i> Chat with Seller</button>
                        <button class="btn btn-sm btn-outline-success flex-fill" onclick="openOfferModal('<?= $item['id'] ?>', '<?= $item['type'] ?>', '<?= htmlspecialchars($item['lot_name'] ?? $item['name']) ?>')"><i class="fa fa-gavel"></i> Make an Offer</button>
                    </div>

                    <div class="listing-footer">
                        <div class="seller-info">
                            <div class="seller-avatar">
                                <?= strtoupper(substr($item['seller_name'] ?? 'S', 0, 1)) ?>
                            </div>
                            <span class="seller-name"><?= htmlspecialchars($item['seller_name'] ?? 'Seller') ?></span>
                        </div>
                        <?php if($is_logged_in): ?>
                        <button class="view-btn" onclick="window.location.href='<?= base_url('marketplace/view/'.$item['type'].'/'.$item['id']) ?>'">
                            View Details
                        </button>
                        <?php else: ?>
                        <button class="view-btn" onclick="window.location.href='<?= base_url('user') ?>'">
                            Login to View
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<!-- Share Modal -->
<div class="share-modal" id="shareModal">
    <div class="share-content">
        <div class="share-header">
            <h3>Share This Listing</h3>
            <button class="close-modal" onclick="closeShareModal()">×</button>
        </div>
        
        <div class="share-buttons">
            <button class="share-btn facebook" onclick="shareOn('facebook')">
                <i class="fab fa-facebook-f"></i> Facebook
            </button>
            <button class="share-btn twitter" onclick="shareOn('twitter')">
                <i class="fab fa-twitter"></i> Twitter
            </button>
            <button class="share-btn linkedin" onclick="shareOn('linkedin')">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </button>
            <button class="share-btn whatsapp" onclick="shareOn('whatsapp')">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </button>
            <button class="share-btn telegram" onclick="shareOn('telegram')">
                <i class="fab fa-telegram-plane"></i> Telegram
            </button>
            <button class="share-btn email" onclick="shareOn('email')">
                <i class="fa fa-envelope"></i> Email
            </button>
        </div>
        
        <div class="share-link-box">
            <p>Or copy link:</p>
            <div class="share-link-input">
                <input type="text" id="shareUrl" readonly>
                <button class="copy-btn" onclick="copyLink()">
                    <i class="fa fa-copy"></i> Copy
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
// Initialize Swiper
const swiper = new Swiper('.hero-swiper', {
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});

// Global variables for share modal
let currentShareListing = null;
let currentShareType = null;

// Open share modal
function openShareModal(id, type) {
    currentShareListing = id;
    currentShareType = type;
    const url = '<?= base_url() ?>marketplace/view/' + type + '/' + id;
    document.getElementById('shareUrl').value = url;
    document.getElementById('shareModal').classList.add('active');
    
    // Track share modal open
    trackShare('modal_open', type, id);
}

// Close share modal
function closeShareModal() {
    document.getElementById('shareModal').classList.remove('active');
}

// Share on platform
function shareOn(platform) {
    const url = document.getElementById('shareUrl').value;
    const title = 'Premium Timber Available - TimberPro Marketplace';
    const text = '🌲 Check out this premium timber listing on TimberPro! Direct from verified sellers.';
    
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}&hashtags=TimberTrade,SriLanka,Timber`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
            break;
        case 'telegram':
            shareUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
            break;
        case 'email':
            shareUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(text + '\n\n' + url)}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=500');
        trackShare(platform, currentShareType, currentShareListing);
    }
}

// Copy link to clipboard
function copyLink() {
    const input = document.getElementById('shareUrl');
    input.select();
    document.execCommand('copy');
    
    const btn = event.target.closest('.copy-btn');
    btn.classList.add('copied');
    btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
    
    setTimeout(() => {
        btn.classList.remove('copied');
        btn.innerHTML = '<i class="fa fa-copy"></i> Copy';
    }, 2000);
    
    trackShare('copy_link', currentShareType, currentShareListing);
}

// Track share action
function trackShare(platform, type, id) {
    fetch('<?= base_url('marketplace/track_share') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            platform: platform,
            listing_type: type,
            listing_id: id
        })
    });
}

// Native Web Share API (mobile)
if (navigator.share) {
    document.querySelectorAll('.action-btn.share').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.stopPropagation();
            const card = btn.closest('.listing-card');
            const title = card.querySelector('.listing-title').textContent;
            const url = card.querySelector('.view-btn').getAttribute('onclick').match(/\'([^\']+)\'/)[1];
            
            try {
                await navigator.share({
                    title: title,
                    text: '🌲 Check out this timber listing!',
                    url: url
                });
            } catch(err) {
                // Fallback to modal
                openShareModal(url.split('/').pop(), url.split('/')[url.split('/').length - 2]);
            }
        });
    });
}

// Filter and sort functions
function applyFilters() {
    const priceMin = parseInt(document.getElementById('priceMin').value) || 0;
    const priceMax = parseInt(document.getElementById('priceMax').value) || Infinity;
    const types = Array.from(document.querySelectorAll('[id^="type_"]:checked')).map(cb => cb.value);
    const locations = Array.from(document.querySelectorAll('[id^="loc_"]:checked')).map(cb => cb.value);
    
    const cards = document.querySelectorAll('.listing-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const price = parseInt(card.dataset.price);
        const type = card.dataset.type;
        const location = card.dataset.location;
        
        const priceMatch = price >= priceMin && price <= priceMax;
        const typeMatch = types.length === 0 || types.includes(type);
        const locationMatch = locations.length === 0 || locations.some(loc => location.includes(loc));
        
        if (priceMatch && typeMatch && locationMatch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    document.getElementById('resultCount').textContent = `(${visibleCount})`;
}

function resetFilters() {
    document.getElementById('priceMin').value = '';
    document.getElementById('priceMax').value = '';
    document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(cb => cb.checked = false);
    applyFilters();
}

function sortListings(sortBy) {
    const grid = document.getElementById('listingsGrid');
    const cards = Array.from(grid.querySelectorAll('.listing-card'));
    
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'price_low':
                return parseInt(a.dataset.price) - parseInt(b.dataset.price);
            case 'price_high':
                return parseInt(b.dataset.price) - parseInt(a.dataset.price);
            default:
                return 0;
        }
    });
    
    cards.forEach(card => grid.appendChild(card));
}

function setView(view) {
    const grid = document.getElementById('listingsGrid');
    const buttons = document.querySelectorAll('.view-toggle button');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('button').classList.add('active');
    
    if (view === 'list') {
        grid.style.gridTemplateColumns = '1fr';
    } else {
        grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
    }
}

// Hero search
document.getElementById('heroSearch').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.listing-card').forEach(card => {
            const title = card.querySelector('.listing-title').textContent.toLowerCase();
            const location = card.dataset.location.toLowerCase();
            if (title.includes(query) || location.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});

// Close modal on outside click
document.getElementById('shareModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeShareModal();
    }
});
</script>

<!-- Chat Modal -->
<div id="chatModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Chat with Seller</h5>
            <button class="close-btn" onclick="closeChatModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p id="chatListingName" class="text-muted small mb-2"></p>
            <form id="chatForm">
                <input type="hidden" name="seller_id" id="chatSellerId">
                <input type="hidden" name="listing_name" id="chatListingRef">
                <div class="form-group mb-3">
                    <label>Your Message</label>
                    <textarea name="message" class="form-control" rows="4" placeholder="Hi, I'm interested in this lot. Is it still available?" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
        </div>
    </div>
</div>

<!-- Offer Modal -->
<div id="offerModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Make a Quick Offer</h5>
            <button class="close-btn" onclick="closeOfferModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p id="offerListingName" class="text-muted small mb-2"></p>
            <form id="offerForm">
                <input type="hidden" name="id" id="offerListingId">
                <input type="hidden" name="type" id="offerListingType">
                <div class="form-group mb-3">
                    <label>Offer Amount (LKR)</label>
                    <input type="number" name="amount" class="form-control form-control-lg" placeholder="Enter your offer" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Submit Offer</button>
            </form>
        </div>
    </div>
</div>

<script>
// Chat Logic
function openChatModal(sellerId, listingName) {
    if (!<?= $is_logged_in ? 'true' : 'false' ?>) {
        window.location.href = '<?= base_url('user') ?>';
        return;
    }
    document.getElementById('chatSellerId').value = sellerId;
    document.getElementById('chatListingRef').value = listingName;
    document.getElementById('chatListingName').textContent = "Inquiry about: " + listingName;
    document.getElementById('chatModal').classList.add('active');
}

function closeChatModal() {
    document.getElementById('chatModal').classList.remove('active');
}

$('#chatForm').submit(function(e) {
    e.preventDefault();
    $.post('<?= base_url('marketplace/contact_seller') ?>', $(this).serialize(), function(res) {
        alert(res.message);
        if(res.status === 'Success') closeChatModal();
    }, 'json');
});

// Offer Logic
function openOfferModal(id, type, listingName) {
    if (!<?= $is_logged_in ? 'true' : 'false' ?>) {
        window.location.href = '<?= base_url('user') ?>';
        return;
    }
    document.getElementById('offerListingId').value = id;
    document.getElementById('offerListingType').value = type;
    document.getElementById('offerListingName').textContent = "Making offer for: " + listingName;
    document.getElementById('offerModal').classList.add('active');
}

function closeOfferModal() {
    document.getElementById('offerModal').classList.remove('active');
}

$('#offerForm').submit(function(e) {
    e.preventDefault();
    $.post('<?= base_url('marketplace/submit_offer') ?>', $(this).serialize(), function(res) {
        alert(res.message);
        if(res.status === 'Success') closeOfferModal();
    }, 'json');
});

// Existing functions
// Global variables for share modal
let currentShareListing = null;
let currentShareType = null;

// Open share modal
function openShareModal(id, type) {
    currentShareListing = id;
    currentShareType = type;
    const url = '<?= base_url() ?>marketplace/view/' + type + '/' + id;
    document.getElementById('shareUrl').value = url;
    document.getElementById('shareModal').classList.add('active');
    
    // Track share modal open
    trackShare('modal_open', type, id);
}

// Close share modal
function closeShareModal() {
    document.getElementById('shareModal').classList.remove('active');
}

// Share on platform
function shareOn(platform) {
    const url = document.getElementById('shareUrl').value;
    const title = 'Premium Timber Available - TimberPro Marketplace';
    const text = '🌲 Check out this premium timber listing on TimberPro! Direct from verified sellers.';
    
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}&hashtags=TimberTrade,SriLanka,Timber`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
            break;
        case 'telegram':
            shareUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
            break;
        case 'email':
            shareUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(text + '\n\n' + url)}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=500');
        trackShare(platform, currentShareType, currentShareListing);
    }
}

// Copy link to clipboard
function copyLink() {
    const input = document.getElementById('shareUrl');
    input.select();
    document.execCommand('copy');
    
    const btn = event.target.closest('.copy-btn');
    btn.classList.add('copied');
    btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
    
    setTimeout(() => {
        btn.classList.remove('copied');
        btn.innerHTML = '<i class="fa fa-copy"></i> Copy';
    }, 2000);
    
    trackShare('copy_link', currentShareType, currentShareListing);
}

// Track share action
function trackShare(platform, type, id) {
    fetch('<?= base_url('marketplace/track_share') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            platform: platform,
            listing_type: type,
            listing_id: id
        })
    });
}

// Native Web Share API (mobile)
if (navigator.share) {
    document.querySelectorAll('.action-btn.share').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.stopPropagation();
            const card = btn.closest('.listing-card');
            const title = card.querySelector('.listing-title').textContent;
            const url = card.querySelector('.view-btn').getAttribute('onclick').match(/\'([^\']+)\'/)[1];
            
            try {
                await navigator.share({
                    title: title,
                    text: '🌲 Check out this timber listing!',
                    url: url
                });
            } catch(err) {
                // Fallback to modal
                openShareModal(url.split('/').pop(), url.split('/')[url.split('/').length - 2]);
            }
        });
    });
}

// Filter and sort functions
function applyFilters() {
    const priceMin = parseInt(document.getElementById('priceMin').value) || 0;
    const priceMax = parseInt(document.getElementById('priceMax').value) || Infinity;
    const types = Array.from(document.querySelectorAll('[id^="type_"]:checked')).map(cb => cb.value);
    const locations = Array.from(document.querySelectorAll('[id^="loc_"]:checked')).map(cb => cb.value);
    
    const cards = document.querySelectorAll('.listing-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const price = parseInt(card.dataset.price);
        const type = card.dataset.type;
        const location = card.dataset.location;
        
        const priceMatch = price >= priceMin && price <= priceMax;
        const typeMatch = types.length === 0 || types.includes(type);
        const locationMatch = locations.length === 0 || locations.some(loc => location.includes(loc));
        
        if (priceMatch && typeMatch && locationMatch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    document.getElementById('resultCount').textContent = `(${visibleCount})`;
}

function resetFilters() {
    document.getElementById('priceMin').value = '';
    document.getElementById('priceMax').value = '';
    document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(cb => cb.checked = false);
    applyFilters();
}

function sortListings(sortBy) {
    const grid = document.getElementById('listingsGrid');
    const cards = Array.from(grid.querySelectorAll('.listing-card'));
    
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'price_low':
                return parseInt(a.dataset.price) - parseInt(b.dataset.price);
            case 'price_high':
                return parseInt(b.dataset.price) - parseInt(a.dataset.price);
            default:
                return 0;
        }
    });
    
    cards.forEach(card => grid.appendChild(card));
}

function setView(view) {
    const grid = document.getElementById('listingsGrid');
    const buttons = document.querySelectorAll('.view-toggle button');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('button').classList.add('active');
    
    if (view === 'list') {
        grid.style.gridTemplateColumns = '1fr';
    } else {
        grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
    }
}

// Hero search
document.getElementById('heroSearch').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.listing-card').forEach(card => {
            const title = card.querySelector('.listing-title').textContent.toLowerCase();
            const location = card.dataset.location.toLowerCase();
            if (title.includes(query) || location.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});

// Close modal on outside click
document.getElementById('shareModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeShareModal();
    }
});
</script>

</body>
</html>
