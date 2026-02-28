<style>
    /* Premium Overall Shop Adjustments */
    .marketplace-hero { height: 400px !important; }
    .marketplace-container { max-width: 100% !important; margin: 0 !important; padding: 20px 40px !important; }
    
    /* Horizontal Filter Overhaul */
    .horizontal-filter-wrapper {
        margin: -40px 40px 30px 40px;
        position: relative;
        z-index: 105;
    }

    .horizontal-filter-bar {
        display: flex;
        align-items: center;
        gap: 20px;
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 15px 30px !important;
        border-radius: 100px !important; /* Pill shape */
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        padding-right: 20px;
    }

    .filter-group:last-child { border-right: none; padding-right: 0; }
    
    .group-search { flex: 1; border-right: none; }
    .group-search .premium-search-box { width: 100%; margin: 0; }
    .group-search .premium-search-box input { 
        background: transparent !important; 
        border: none !important; 
        font-size: 1rem !important;
    }

    /* Dropdown Filter */
    .dropdown-filter { position: relative; }
    .dropdown-toggle {
        background: none;
        border: none;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    .dropdown-toggle:hover { color: #1e3c72; }
    .dropdown-toggle i:last-child { font-size: 0.7rem; opacity: 0.5; }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 15px);
        left: 0;
        background: white;
        min-width: 220px;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        display: none;
        z-index: 200;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .dropdown-filter:hover .dropdown-menu { display: block; }

    .price-range-horizontal {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .price-range-horizontal input {
        width: 100px;
        padding: 8px 12px;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 8px;
        font-size: 0.85rem;
        background: rgba(255,255,255,0.5);
    }

    .group-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .reset-icon-btn {
        background: #f1f5f9;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }
    .reset-icon-btn:hover { background: #fee2e2; color: #ef4444; }

    .active-filter-badge {
        background: #1e3c72;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    /* Premium Card Redesign */
    .full-width-listings { grid-column: span 2; }
    .premium-card {
        border-radius: 24px !important;
        border: none !important;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .premium-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }

    .premium-card .listing-image {
        height: 240px !important;
        border-radius: 20px !important;
        margin: 12px;
        overflow: hidden;
    }

    .card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    }

    .verified-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(16, 185, 129, 0.95);
        color: white;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    .glass-action-btn {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s;
    }
    .glass-action-btn:hover { background: white; color: #ef4444; }

    .price-pill {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: white;
        color: #1e3c72;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 800;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-size: 1.1rem;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .unit-price-mini {
        font-size: 0.65rem;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .cat-badge {
        font-size: 0.65rem;
        font-weight: 800;
        color: #2a5298;
        background: rgba(42, 82, 152, 0.1);
        padding: 4px 8px;
        border-radius: 6px;
    }

    .grade-badge {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
    }
    .Grade-A { background: #fee2e2; color: #991b1b; }
    .Grade-B { background: #fef3c7; color: #92400e; }
    .Grade-C { background: #dcfce7; color: #166534; }

    .listing-top-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .listing-stats {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    .listing-stats .stat {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: #64748b;
    }
    .listing-stats .stat i { color: #1e3c72; opacity: 0.6; }

    .seller-brief {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .seller-initials {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        background: #1e3c72;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
    }
    .s-name { font-weight: 600; font-size: 0.85rem; color: #1e293b; display: block; }
    .s-rating { font-size: 0.75rem; color: #fbbf24; }
    .rev-count { color: #94a3b8; font-weight: 400; }

    .premium-view-btn {
        background: #1e3c72;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .premium-view-btn:hover { background: #2a5298; box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3); }

    .listing-badge, .listing-price, .listing-description, .verified-badge { display: none; }

    /* Model Selector Styles */
    .model-selector {
        display: flex;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 4px;
        gap: 4px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
    }
    .model-btn {
        padding: 8px 18px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 700;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        line-height: 1.1;
    }
    .model-btn .m-code { font-size: 0.6rem; text-transform: uppercase; opacity: 0.6; margin-bottom: 2px; }
    .model-btn.active {
        background: #1e40af;
        color: white;
        box-shadow: 0 4px 10px rgba(30, 64, 175, 0.2);
    }
    .model-btn:hover:not(.active) {
        background: white;
        color: #1e40af;
    }

    .horizontal-filter-wrapper {
        margin: 20px 0;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .horizontal-filter-bar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 10px 30px;
        gap: 25px;
        min-height: 75px;
        display: flex;
        align-items: center;
        width: fit-content;
        max-width: 100%;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);

        scrollbar-width: none;
    }
    .horizontal-filter-bar::-webkit-scrollbar { display: none; }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 15px;
        white-space: nowrap;
    }

    .premium-search-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 280px;
        transition: all 0.2s;
    }
    .premium-search-box:focus-within {
        background: white;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    .premium-search-box i { color: #10b981; font-size: 0.9rem; }
    .premium-search-box input {
        background: transparent;
        border: none;
        color: #1e293b;
        font-size: 0.85rem;
        outline: none;
        width: 100%;
    }
    .premium-search-box input::placeholder { color: #94a3b8; }

    .dropdown-toggle {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .dropdown-toggle:hover {
        border-color: #1e40af;
        color: #1e40af;
        background: #f8fafc;
    }
    .dropdown-toggle i:first-child { color: #1e40af; opacity: 0.8; }
    .dropdown-toggle i:last-child { font-size: 0.65rem; opacity: 0.4; margin-left: 4px; }

    .price-range-horizontal {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 6px 14px;
        gap: 10px;
    }
    .price-range-horizontal input {
        background: transparent;
        border: none;
        color: #1e293b;
        width: 85px;
        font-size: 0.85rem;
        outline: none;
        font-weight: 600;
    }
    .price-range-horizontal span { color: #94a3b8; font-weight: 400; }

    .reset-icon-btn {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #ef4444;
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    .reset-icon-btn:hover {
        background: #ef4444;
        color: white;
        transform: rotate(-15deg);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    /* Dropdown UI Fixes */
    .dropdown-filter { position: relative; }
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 110%;
        left: 0;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        padding: 15px;
        z-index: 1000;
        min-width: 220px;
        backdrop-filter: none;
    }
    .dropdown-filter:hover .dropdown-menu { display: block; }
    
    .district-grid {
        grid-template-columns: repeat(3, 1fr);
        width: 550px !important;
        gap: 10px;
    }
    .dropdown-filter:hover .dropdown-menu.district-grid {
        display: grid !important;
    }

    .active-filter-badge {
        background: #10b981;
        color: white;
        min-width: 20px;
        height: 20px;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: -6px;
        right: -6px;
        border: 2px solid white;
    }
</style>





    <!-- Horizontal Filters Bar -->
    <div class="horizontal-filter-wrapper">
        <div class="horizontal-filter-bar">
            <!-- Model Category Selector (Phased Models A, B, C, D) -->
            <div class="model-selector">
                <button class="model-btn active" onclick="switchModel('all', this)">
                    <span class="m-code">Model O</span>
                    <span class="m-name">All Products</span>
                </button>
                <button class="model-btn" onclick="switchModel('standing', this)">
                    <span class="m-code">Model A</span>
                    <span class="m-name">Standing Trees</span>
                </button>
                <button class="model-btn" onclick="switchModel('logs', this)">
                    <span class="m-code">Model B</span>
                    <span class="m-name">Log Matrix</span>
                </button>
                <button class="model-btn" onclick="switchModel('sawn', this)">
                    <span class="m-code">Model C</span>
                    <span class="m-name">Sawn Timber</span>
                </button>
                <button class="model-btn" onclick="switchModel('machinery', this)">
                    <span class="m-code">Model D</span>
                    <span class="m-name">Machinery</span>
                </button>
            </div>

            <!-- Search & District -->
            <div class="filter-group group-main">
                <div class="premium-search-box">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="Search Listings..." id="sidebarSearch" onkeyup="applyFilters()">
                </div>
                
                <div class="dropdown-filter">
                    <button class="dropdown-toggle"><i class="fa fa-map-marker-alt"></i> Location <i class="fa fa-chevron-down"></i></button>
                    <div class="dropdown-menu district-grid">
                        <label class="premium-checkbox">
                            <input type="checkbox" id="loc_all" value="all" checked onchange="toggleAllDistricts(this)">
                            <span class="checkmark"></span>
                            <span class="label-text">All Island</span>
                        </label>
                        <hr>
                        <?php 
                        foreach($districts as $dis):
                        ?>
                        <label class="premium-checkbox">
                            <input type="checkbox" class="location-filter" value="<?= strtolower($dis) ?>" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text"><?= $dis ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Material/Machinery Properties (Dynamic) -->
            <div class="filter-group" id="timber-filters">
                <div class="dropdown-filter">
                    <button class="dropdown-toggle"><i class="fa fa-tree"></i> Species <i class="fa fa-chevron-down"></i></button>
                    <div class="dropdown-menu">
                        <?php 
                        $common_species = ['Teak', 'Mahogany', 'Satinwood', 'Alstonia', 'Ginisapu', 'Jak', 'Mango', 'Nedun']; 
                        foreach($common_species as $sp):
                        ?>
                        <label class="premium-checkbox">
                            <input type="checkbox" class="species-filter" value="<?= strtolower($sp) ?>" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text"><?= $sp ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="dropdown-filter">
                    <button class="dropdown-toggle"><i class="fa fa-ribbon"></i> Grade <i class="fa fa-chevron-down"></i></button>
                    <div class="dropdown-menu">
                        <label class="premium-checkbox">
                            <input type="checkbox" class="grade-filter" value="A" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text">Grade A (Premium)</span>
                        </label>
                        <label class="premium-checkbox">
                            <input type="checkbox" class="grade-filter" value="B" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text">Grade B (Standard)</span>
                        </label>
                        <label class="premium-checkbox">
                            <input type="checkbox" class="grade-filter" value="C" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text">Grade C (Local)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Machinery Specific Filters -->
            <div class="filter-group" id="machinery-filters" style="display: none;">
                <div class="dropdown-filter">
                    <button class="dropdown-toggle"><i class="fa fa-cogs"></i> Equipment Type <i class="fa fa-chevron-down"></i></button>
                    <div class="dropdown-menu">
                        <?php 
                        $machinery_types = ['Portable Sawmill', 'Chainsaw', 'Log Loader', 'Timber Tractor', 'Wood Chipper', 'Planner Machine']; 
                        foreach($machinery_types as $mt):
                        ?>
                        <label class="premium-checkbox">
                            <input type="checkbox" class="machinery-type-filter" value="<?= strtolower(str_replace(' ', '_', $mt)) ?>" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text"><?= $mt ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Pricing & Quality -->
            <div class="filter-group group-right">
                <div class="price-range-horizontal">
                    <input type="number" placeholder="Min LKR" id="priceMin" onchange="applyFilters()">
                    <span>-</span>
                    <input type="number" placeholder="Max LKR" id="priceMax" onchange="applyFilters()">
                </div>

                <div class="dropdown-filter">
                    <button class="dropdown-toggle"><i class="fa fa-filter-list"></i> More <i class="fa fa-chevron-down"></i></button>
                    <div class="dropdown-menu right-aligned">
                        <label class="small-header">Quality & State</label>
                        <label class="premium-checkbox">
                            <input type="checkbox" id="cond_seasoned" value="seasoned" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text">Seasoned</span>
                        </label>
                        <label class="premium-checkbox">
                            <input type="checkbox" id="cond_treated" value="treated" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text">CCA Treated</span>
                        </label>
                        <hr>
                        <label class="small-header">Trust Level</label>
                        <label class="premium-checkbox">
                            <input type="checkbox" id="trust_verified" value="1" onchange="applyFilters()">
                            <span class="checkmark"></span>
                            <span class="label-text text-success"><i class="fa fa-check-circle"></i> Verified Only</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="filter-group group-actions">
                <button class="reset-icon-btn" onclick="resetFilters()" title="Reset Filters">
                    <i class="fa fa-redo"></i>
                </button>
                <div class="active-filter-badge" id="activeFilterCount" title="Active filters">0</div>
            </div>
        </div>
    </div>

    <!-- Listings Area -->
    <main class="listings-area full-width-listings">
        <div class="listings-header">
            <h2>All Listings <span id="resultCount">(<?= count($lots) ?>)</span></h2>
            <div class="view-controls">
                <div class="view-toggle">
                    <button class="active" onclick="setView('grid', this)"><i class="fa fa-th-large"></i></button>
                    <button onclick="setView('list', this)"><i class="fa fa-list"></i></button>
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
            <div class="listing-card premium-card" 
                 data-type="<?= $item['lot_type'] ?? 'logs' ?>" 
                 data-price="<?= $item['selling_price'] ?? 0 ?>" 
                 data-location="<?= strtolower($item['location'] ?? '') ?>"
                 data-species="<?= strtolower($item['species'] ?? '') ?>"
                 data-grade="<?= $item['grade'] ?? '' ?>"
                 data-verified="<?= !empty($item['permit_verified']) ? '1' : '0' ?>"
                 data-moisture="<?= !empty($item['moisture_content']) ? 'seasoned' : '' ?>"
                 data-treated="<?= !empty($item['is_treated']) ? 'treated' : '' ?>">
                <div class="listing-image" style="background-image: url('<?= !empty($item['thumbnail']) ? base_url($item['thumbnail']) : 'https://images.unsplash.com/photo-1550537687-c91072c4792d?w=600' ?>');">
                    <div class="card-overlay"></div>
                    <?php if(!empty($item['permit_verified'])): ?>
                        <div class="verified-tag">
                            <i class="fa fa-check-shield"></i> VERIFIED PERMIT
                        </div>
                    <?php endif; ?>
                    
                    <div class="listing-actions">
                        <button class="glass-action-btn" title="Save Listing">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="glass-action-btn" title="Share Listing" onclick="openShareModal('<?= $item['id'] ?>', '<?= $item['type'] ?>', '<?= addslashes($item['name']) ?>', '<?= $item['selling_price'] ?>', '<?= addslashes($item['location']) ?>', '<?= htmlspecialchars($item['thumbnail']) ?>')">
                            <i class="fa fa-share-nodes"></i>
                        </button>
                    </div>

                    <div class="price-pill">
                        LKR <?= number_format($item['total_price'] ?? ($item['price'] ?? 0)) ?>
                        <?php if(!empty($item['selling_price']) && $item['selling_price'] > 0): ?>
                            <div class="unit-price-mini">LKR <?= number_format($item['selling_price']) ?> / 
                                <?php 
                                    $u = $item['unit_type'] ?? 'ft³'; 
                                    if($item['lot_type'] == 'machinery') $u = 'pc';
                                    echo $u;
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="listing-content">
                    <div class="listing-top-meta">
                        <span class="cat-badge"><?= strtoupper($item['lot_type'] ?? 'log') ?></span>
                        <span class="grade-badge Grade-<?= $item['grade'] ?? 'NA' ?>">Grade <?= $item['grade'] ?? 'N/A' ?></span>
                    </div>
                    <h3 class="listing-title"><?= htmlspecialchars($item['name'] ?? 'Timber Lot') ?></h3>
                    
                    <div class="listing-stats">
                        <div class="stat">
                            <i class="fa fa-expand-arrows-alt"></i>
                            <span>
                                <?php 
                                    if(($item['lot_type'] ?? '') == 'machinery') {
                                        echo ($item['qty'] ?? 1) . ' Pcs';
                                    } else {
                                        echo number_format($item['volume'] ?? 0) . ' ' . ($item['unit_type'] ?? 'ft³');
                                    }
                                ?>
                            </span>
                        </div>
                        <div class="stat">
                            <i class="fa fa-map-marker-alt"></i>
                            <span><?= htmlspecialchars($item['location'] ?? 'N/A') ?></span>
                        </div>
                    </div>
                    
                    <div class="listing-footer">
                        <div class="seller-brief">
                            <div class="seller-initials">
                                <?= strtoupper(substr($item['seller_name'] ?? 'S', 0, 1)) ?>
                            </div>
                            <div class="seller-details">
                                <span class="s-name"><?= htmlspecialchars($item['seller_name'] ?? 'Supplier') ?></span>
                                <div class="s-rating">
                                    <i class="fa fa-star"></i> 4.9 <span class="rev-count">(12)</span>
                                </div>
                            </div>
                        </div>
                        <button class="premium-view-btn" onclick="window.location.href='<?= base_url('shop/view/'.$item['type'].'/'.$item['id']) ?>'">
                            DETAILS <i class="fa fa-arrow-right"></i>
                        </button>
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

<script>
// Initialize Swiper
const swiperEl = document.querySelector('.hero-swiper');
if (swiperEl && typeof Swiper !== 'undefined') {
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
}

// Global variables for share modal
let currentShareListing = null;
let currentShareType = null;
let currentShareData = {};

// Open share modal
function openShareModal(id, type, name, price, location, thumb) {
    currentShareListing = id;
    currentShareType = type;
    currentShareData = {
        name: name,
        price: price,
        location: location,
        thumb: thumb,
        url: '<?= base_url() ?>shop/view/' + type + '/' + id
    };
    
    document.getElementById('shareUrl').value = currentShareData.url;
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
    const data = currentShareData;
    const formattedPrice = new Intl.NumberFormat('en-LK').format(data.price);
    const title = `🌲 ${data.name} - TimberPro Marketplace`;
    const hashtags = "#TimberPro #SriLanka #TimberTrade #WoodWorking";
    
    // Generate post text
    let text = `${title}\n\n`;
    text += `📍 Location: ${data.location}\n`;
    text += `💰 Price: LKR ${formattedPrice}\n\n`;
    text += `Check it out here: ${data.url}\n\n`;
    text += `${hashtags}`;

    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(data.url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(data.url)}&text=${encodeURIComponent(text)}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(data.url)}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
            break;
        case 'telegram':
            shareUrl = `https://t.me/share/url?url=${encodeURIComponent(data.url)}&text=${encodeURIComponent(text)}`;
            break;
        case 'email':
            shareUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(text)}`;
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
    fetch('<?= base_url('shop/track_share') ?>', {
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

// Product Model State
let currentProductModel = 'all';

function switchModel(model, element) {
    currentProductModel = model;
    
    // Update active UI state
    document.querySelectorAll('.model-btn').forEach(btn => btn.classList.remove('active'));
    element.classList.add('active');
    
    // Toggle relevant sub-filter groups
    const timberFilters = document.getElementById('timber-filters');
    const machineryFilters = document.getElementById('machinery-filters');
    
    if (model === 'machinery') {
        timberFilters.style.display = 'none';
        machineryFilters.style.display = 'flex';
    } else {
        timberFilters.style.display = 'flex';
        machineryFilters.style.display = 'none';
    }
    
    applyFilters();
}

// Filter and sort functions
    function applyFilters() {
        const search = document.getElementById('sidebarSearch').value.toLowerCase();
        const minPrice = parseFloat(document.getElementById('priceMin').value) || 0;
        const maxPrice = parseFloat(document.getElementById('priceMax').value) || Infinity;
        const verifiedOnly = document.getElementById('trust_verified').checked;
        const seasonedOnly = document.getElementById('cond_seasoned').checked;
        const treatedOnly = document.getElementById('cond_treated').checked;

        // Get selected species
        const selectedSpecies = Array.from(document.querySelectorAll('.species-filter:checked')).map(cb => cb.value);
        // Get selected grades
        const selectedGrades = Array.from(document.querySelectorAll('.grade-filter:checked')).map(cb => cb.value);
        // Get selected location/district
        const selectedDistricts = Array.from(document.querySelectorAll('.location-filter:checked')).map(cb => cb.value);
        // Get selected machinery types
        const selectedMachinery = Array.from(document.querySelectorAll('.machinery-type-filter:checked')).map(cb => cb.value);

        const cards = document.querySelectorAll('#listingsGrid .listing-card');
        let visibleCount = 0;
        let activeFilterCount = 0;

        if (search) activeFilterCount++;
        if (minPrice > 0 || maxPrice < Infinity) activeFilterCount++;
        if (verifiedOnly) activeFilterCount++;
        if (seasonedOnly) activeFilterCount++;
        if (treatedOnly) activeFilterCount++;
        if (currentProductModel !== 'all') activeFilterCount++;
        activeFilterCount += selectedSpecies.length;
        activeFilterCount += selectedGrades.length;
        activeFilterCount += selectedDistricts.length;
        activeFilterCount += selectedMachinery.length;

        document.getElementById('activeFilterCount').textContent = activeFilterCount;

        cards.forEach(card => {
            const type = card.dataset.type;
            const title = card.querySelector('.listing-title').textContent.toLowerCase();
            const price = parseFloat(card.dataset.price);
            const species = card.dataset.species;
            const grade = card.dataset.grade;
            const location = card.dataset.location;
            const subType = card.dataset.subtype || ''; // machinery type
            const isVerified = card.dataset.verified === '1';
            const moisture = card.dataset.moisture;
            const treated = card.dataset.treated;

            const modelMatch = currentProductModel === 'all' || type === currentProductModel;
            const searchMatch = title.includes(search);
            const priceMatch = price >= minPrice && price <= maxPrice;
            const speciesMatch = selectedSpecies.length === 0 || selectedSpecies.includes(species);
            const gradeMatch = selectedGrades.length === 0 || selectedGrades.includes(grade);
            const locationMatch = selectedDistricts.length === 0 || selectedDistricts.includes(location);
            const machineryMatch = selectedMachinery.length === 0 || selectedMachinery.includes(subType);
            const verifiedMatch = !verifiedOnly || isVerified;
            const moistureMatch = !seasonedOnly || moisture === 'seasoned';
            const treatedMatch = !treatedOnly || treated === 'treated';

            if (modelMatch && searchMatch && priceMatch && speciesMatch && gradeMatch && locationMatch && machineryMatch && verifiedMatch && moistureMatch && treatedMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('resultCount').textContent = `(${visibleCount})`;
    }

    function toggleAllDistricts(source) {
        const checkboxes = document.querySelectorAll('.location-filter');
        checkboxes.forEach(cb => cb.checked = false);
        if (source.checked) {
            // "All" is active, effectively no filters
        }
        applyFilters();
    }

    // Auto-uncheck "All Island" if a specific district is picked
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('location-filter') && e.target.checked) {
            document.getElementById('loc_all').checked = false;
        }
    });

    function resetFilters() {
        document.getElementById('sidebarSearch').value = '';
        document.getElementById('priceMin').value = '';
        document.getElementById('priceMax').value = '';
        document.getElementById('trust_verified').checked = false;
        document.getElementById('cond_seasoned').checked = false;
        document.getElementById('cond_treated').checked = false;
        document.getElementById('loc_all').checked = true;
        
        document.querySelectorAll('.species-filter, .grade-filter, .location-filter, .machinery-type-filter').forEach(cb => cb.checked = false);
        
        // Reset model
        currentProductModel = 'all';
        document.querySelectorAll('.model-btn').forEach(btn => btn.classList.remove('active'));
        const allBtn = document.querySelector('.model-btn[onclick*="all"]');
        if (allBtn) allBtn.classList.add('active');
        
        // Reset dynamic visibility
        const timberFilters = document.getElementById('timber-filters');
        const machineryFilters = document.getElementById('machinery-filters');
        if (timberFilters) timberFilters.style.display = 'flex';
        if (machineryFilters) machineryFilters.style.display = 'none';
        
        // Close all menus
        document.querySelectorAll('.dropdown-filter').forEach(f => f.classList.remove('active'));
        document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
        
        applyFilters();
    }

    // Dropdown Toggle Logic removed in favor of CSS Hover (as requested)

    // Close dropdown on checkbox change (optional, but requested by some for "stays closed" behavior)
    // Actually, usually users want to pick multiple. So we keep it open for multi-select.

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

function setView(view, element) {
    const grid = document.getElementById('listingsGrid');
    const buttons = document.querySelectorAll('.view-toggle button');
    
    if (buttons && element) {
        buttons.forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
    }
    
    if (view === 'list') {
        grid.style.gridTemplateColumns = '1fr';
        grid.classList.add('list-view');
    } else {
        grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(320px, 1fr))';
        grid.classList.remove('list-view');
    }
}

// Hero search
const heroSearch = document.getElementById('heroSearch');
if (heroSearch) {
    heroSearch.addEventListener('keyup', function(e) {
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
}

// Close modal on outside click
document.getElementById('shareModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeShareModal();
    }
});
</script>
