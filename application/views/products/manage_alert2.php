<style>
    /* ============================================
       BLUE & LIFE GREEN - PSYCHOLOGICAL THEME
       Based on Owner Dashboard (Style 9)
    ============================================ */
    
    :root {
        /* Blue & Green Palette */
        --psy-bg-page: #eff6ff; /* Alice Blue (Page BG) */
        --psy-bg-card: #ffffff;
        --psy-text-primary: #1e3a8a; /* Navy Blue 900 */
        --psy-text-secondary: #334155; /* Slate 700 (Neutral) */
        --psy-accent-primary: #2563eb; /* Royal Blue */
        --psy-accent-success: #16a34a; /* Life Green */
        --psy-accent-danger: #ef4444; /* Red (Standard Danger) */
        --psy-accent-warning: #f59e0b; /* Amber */
        --psy-border: #bfdbfe; /* Blue 200 */
        --psy-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.1), 0 2px 4px -1px rgba(30, 58, 138, 0.06);
        --psy-glass: rgba(255, 255, 255, 0.95);
        
        --radius-std: 8px;
        --radius-lg: 12px;
    }

    /* Force overrides for Global Dark Mode leaks */
    html, body, .app-content, .content-wrapper, .content-body {
        background-color: var(--psy-bg-page) !important;
        color: var(--psy-text-primary) !important;
        font-family: 'Montserrat', sans-serif;
    }

    .content-body {
        padding: 2rem;
    }

    /* GLASSMORPHIC HEADER match Dashboard */
    .page-header-glass {
        background: #ffffff;
        border: 1px solid var(--psy-border);
        box-shadow: var(--psy-shadow);
        border-radius: var(--radius-lg);
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .page-header-glass::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, var(--psy-accent-primary), var(--psy-accent-success));
    }

    .page-title h2 {
        color: var(--psy-text-primary);
        font-weight: 800;
        letter-spacing: -0.5px;
        margin: 0;
        font-size: 1.8rem;
        text-transform: uppercase;
    }
    
    .page-title p {
        color: var(--psy-text-secondary);
        font-weight: 500;
        margin: 0;
        font-size: 0.95rem;
    }

    /* PREMIUM BUTTONS MATCHING DASHBOARD */
    .btn-premium {
        background: white;
        color: var(--psy-accent-primary);
        border: 1px solid var(--psy-border);
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        background: var(--psy-bg-page);
        border-color: var(--psy-accent-primary);
        color: var(--psy-accent-primary);
        box-shadow: var(--psy-shadow);
    }

    /* PREMIUM CARDS */
    .premium-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--psy-border);
        box-shadow: var(--psy-shadow);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    /* METRIC CARDS - UPDATED TO NEW THEME */
    .metric-card {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        border: 1px solid var(--psy-border);
        box-shadow: var(--psy-shadow);
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
        height: 100%;
    }

    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(30, 58, 138, 0.1);
    }

    .metric-card.critical { border-bottom: 4px solid var(--psy-accent-danger); }
    .metric-card.warning { border-bottom: 4px solid var(--psy-accent-warning); }
    .metric-card.info { border-bottom: 4px solid var(--psy-accent-primary); }
    .metric-card.success { border-bottom: 4px solid var(--psy-accent-success); }

    .metric-icon {
        width: 48px; height: 48px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .bg-light-critical { background: #fee2e2; color: var(--psy-accent-danger); } /* Red 100 */
    .bg-light-warning { background: #fef3c7; color: var(--psy-accent-warning); } /* Amber 100 */
    .bg-light-info { background: #dbeafe; color: var(--psy-accent-primary); } /* Blue 100 */
    .bg-light-success { background: #dcfce7; color: var(--psy-accent-success); } /* Green 100 */

    .metric-value { font-size: 2rem; font-weight: 800; color: var(--psy-text-primary); line-height: 1.2; }
    .metric-label { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--psy-text-secondary); font-weight: 600; }

    /* FILTERS PANEL */
    .filter-panel {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--psy-shadow);
        border: 1px solid var(--psy-border);
        margin-bottom: 2rem;
        border-left: 5px solid var(--psy-accent-primary);
    }
    
    .filter-header {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--psy-text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-input-glass {
        border: 1px solid var(--psy-border);
        border-radius: 6px;
        padding: 0.6rem 1rem;
        height: auto;
        font-size: 0.95rem;
        background: #f8fafc; /* Slate 50 */
        color: var(--psy-text-secondary);
        transition: all 0.2s;
    }
    
    .filter-input-glass:focus {
        border-color: var(--psy-accent-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
    }

    /* DATA TABLE & LIST */
    .table-responsive { overflow-x: auto; }

    .table-premium {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-premium thead th {
        background: #f8fafc;
        color: var(--psy-text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid var(--psy-border);
        border-top: none;
    }

    .table-premium tbody tr {
        transition: all 0.2s;
    }

    .table-premium tbody tr:hover {
        background-color: #f1f5f9; /* Slate 100 */
        transform: scale(1.002);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        z-index: 5;
        position: relative;
    }

    .table-premium td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: var(--psy-text-secondary);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .product-name {
        font-weight: 700;
        color: var(--psy-text-primary);
        font-size: 1rem;
        display: block;
        margin-bottom: 2px;
        text-decoration: none;
    }
    .product-name:hover { color: var(--psy-accent-primary); text-decoration: underline; }
    
    .product-sku {
        font-family: 'Roboto Mono', monospace;
        font-size: 0.75rem;
        color: var(--psy-text-secondary);
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
    }

    /* ACTIONS MENU */
    .action-btn {
        width: 32px; height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center; justify-content: center;
        transition: all 0.2s;
        border: 1px solid transparent;
        margin: 0 2px;
    }
    
    .bg-primary-soft { background: #dbeafe; color: var(--psy-accent-primary); border-color: #bfdbfe; }
    .bg-primary-soft:hover { background: var(--psy-accent-primary); color: white; border-color: var(--psy-accent-primary); }
    
    .bg-warning-soft { background: #fef3c7; color: var(--psy-accent-warning); border-color: #fde68a; }
    .bg-warning-soft:hover { background: var(--psy-accent-warning); color: white; border-color: var(--psy-accent-warning); }
    
    .bg-info-soft { background: #e0f2fe; color: #0ea5e9; border-color: #bae6fd; } /* Sky Blue */
    .bg-info-soft:hover { background: #0ea5e9; color: white; border-color: #0ea5e9; }

    /* STOCK INDICATORS */
    .stock-indicator-wrapper {
        min-width: 120px;
    }
    
    .stock-progress {
        height: 6px;
        border-radius: 3px;
        background: #e2e8f0;
        margin-top: 6px;
        overflow: hidden;
    }
    
    .stock-bar { height: 100%; border-radius: 3px; }

    /* Badges */
    .badge-psy {
        padding: 0.4em 0.8em;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .badge-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .badge-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-info { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
    .badge-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

    /* Modals */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .modal-header {
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        padding: 1.5rem;
    }
    
</style>

<div class="content-body">
    
    <!-- Header -->
    <div class="page-header-glass">
        <div class="page-title">
            <h2>Inventory Alert</h2>
            <p>Monitor stock levels, set thresholds, and optimize inventory flow.</p>
        </div>
        <div class="header-actions">
            <button class="btn-premium" id="export-csv">
                <i class="ft-download"></i> Export Analytics
            </button>
        </div>
    </div>

    <!-- User Guide -->
    <div class="premium-card mb-4" style="border-left: 4px solid var(--psy-accent-success);">
        <div class="card-header p-3 pointer" data-toggle="collapse" data-target="#helpGuide" aria-expanded="false" style="cursor: pointer; background: white; border-bottom: none;">
            <h6 class="mb-0 text-psy-primary font-weight-bold"><i class="fa fa-info-circle mr-2 text-success"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் வழிகாட்டி" ?> <small class="text-muted float-right">(Click to view)</small></h6>
        </div>
        <div class="collapse" id="helpGuide">
            <div class="card-body p-3 pt-0">
                <ul class="nav nav-tabs" role="tablist" style="border-bottom: 2px solid var(--psy-border);">
                    <li class="nav-item">
                        <a class="nav-link active small p-2 font-weight-bold" data-toggle="tab" href="#eng" role="tab" style="color: var(--psy-text-primary);">🇬🇧 English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small p-2 font-weight-bold" data-toggle="tab" href="#sin" role="tab" style="color: var(--psy-text-primary);">🇱🇰 Sinhala</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small p-2 font-weight-bold" data-toggle="tab" href="#tam" role="tab" style="color: var(--psy-text-primary);">IN Tamil</a>
                    </li>
                </ul>
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" id="eng" role="tabpanel">
                        <h6 class="text-primary mt-1 small font-weight-bold">How to Manage Alerts</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>Monitor Levels:</strong> View products with stock levels below their Alert Quantity.</li>
                            <li><strong>Status Indicators:</strong>
                                <ul>
                                    <li><span class="badge badge-psy badge-danger">CRITICAL</span> Stock is critically low. Immediate reorder needed.</li>
                                    <li><span class="badge badge-psy badge-warning">WARNING</span> Stock is approaching zero. Plan restock.</li>
                                </ul>
                            </li>
                            <li><strong>Manage:</strong> Use the "Manage" column to update alert thresholds or initiate stock transfers.</li>
                        </ol>
                        <p class="text-muted mt-2 mb-0"><small><strong>Note:</strong> Keeping stock above alert levels ensures smooth operations and prevents checkout blockages.</small></p>
                    </div>
                    <div class="tab-pane fade" id="sin" role="tabpanel">
                        <h6 class="text-primary mt-1 small font-weight-bold">අනතුරු ඇඟවීම් (Alerts) කළමනාකරණය කරන ආකාරය</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>මට්ටම් නිරීක්ෂණය:</strong> අනතුරු ඇඟවීමේ ප්‍රමාණයට (Alert Quantity) වඩා අඩු තොග ඇති නිෂ්පාදන පරීක්ෂා කරන්න.</li>
                            <li><strong>තත්ත්ව දර්ශක:</strong>
                                <ul>
                                    <li><span class="badge badge-psy badge-danger">CRITICAL</span> තොග ඉතා අඩු මට්ටමක පවතී. වහාම ඇණවුම් කිරීම අවශ්‍ය වේ.</li>
                                    <li><span class="badge badge-psy badge-warning">WARNING</span> තොග අවසන් වීමට ආසන්නයි. නැවත පුරවන්න (Restock).</li>
                                </ul>
                            </li>
                            <li><strong>කළමනාකරණය:</strong> අනතුරු ඇඟවීමේ සීමාවන් යාවත්කාලීන කිරීමට හෝ තොග මාරු කිරීම් ආරම්භ කිරීමට "Manage" තීරුව භාවිතා කරන්න.</li>
                        </ol>
                        <p class="text-muted mt-2 mb-0"><small><strong>සටහන:</strong> අනතුරු ඇඟවීමේ මට්ටමට වඩා ඉහළින් තොග පවත්වා ගැනීමෙන් බාධාවකින් තොරව මෙහෙයුම් සිදු කළ හැක.</small></p>
                    </div>
                    <div class="tab-pane fade" id="tam" role="tabpanel">
                        <h6 class="text-primary mt-1 small font-weight-bold">எச்சரிக்கைகளை எவ்வாறு நிர்வகிப்பது</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>நிலைகளைக் கண்காணிக்கவும்:</strong> எச்சரிக்கை அளவிற்குக் கீழே உள்ள பங்கு நிலைகளைக் கொண்ட தயாரிப்புகளைப் பார்க்கவும்.</li>
                            <li><strong>நிலை குறிகாட்டிகள்:</strong>
                                <ul>
                                    <li><span class="badge badge-psy badge-danger">CRITICAL</span> இருப்பு மிகவும் குறைவாக உள்ளது. உடனடி மறு ஆர்டர் தேவை.</li>
                                    <li><span class="badge badge-psy badge-warning">WARNING</span> இருப்பு பூஜ்ஜியத்தை நெருங்குகிறது. மறுசீரமைக்கத் திட்டமிடவும்.</li>
                                </ul>
                            </li>
                            <li><strong>நிர்வகித்தல்:</strong> எச்சரிக்கை வரம்புகளைப் புதுப்பிக்க அல்லது பங்கு மாற்றங்களைத் தொடங்க "Manage" பத்தியைப் பயன்படுத்தவும்.</li>
                        </ol>
                        <p class="text-muted mt-2 mb-0"><small><strong>குறிப்பு:</strong> எச்சரிக்கை அளவிற்கு மேலே இருப்பை வைத்திருப்பது மென்மையான செயல்பாடுகளை உறுதி செய்கிறது.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-12 mb-3">
            <div class="metric-card critical">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="metric-value" id="critical-count">0</div>
                        <div class="metric-label">Critical (< 10)</div>
                    </div>
                    <div class="metric-icon bg-light-critical"><i class="ft-alert-octagon"></i></div>
                </div>
                <div class="progress mt-3" style="height: 4px; background-color: #fee2e2;"><div class="progress-bar bg-danger" id="critical-progress" style="width: 0%"></div></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 mb-3">
            <div class="metric-card warning">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="metric-value" id="warning-count">0</div>
                        <div class="metric-label">Warning (10-20)</div>
                    </div>
                    <div class="metric-icon bg-light-warning"><i class="ft-alert-circle"></i></div>
                </div>
                <div class="progress mt-3" style="height: 4px; background-color: #fef3c7;"><div class="progress-bar bg-warning" id="warning-progress" style="width: 0%"></div></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 mb-3">
            <div class="metric-card info">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="metric-value" id="info-count">0</div>
                        <div class="metric-label">Low Stock (20-30)</div>
                    </div>
                    <div class="metric-icon bg-light-info"><i class="ft-info"></i></div>
                </div>
                <div class="progress mt-3" style="height: 4px; background-color: #dbeafe;"><div class="progress-bar bg-info" id="info-progress" style="width: 0%"></div></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 mb-3">
            <div class="metric-card success">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="metric-value" id="normal-count">0</div>
                        <div class="metric-label">Healthy (> 30)</div>
                    </div>
                    <div class="metric-icon bg-light-success"><i class="ft-check-circle"></i></div>
                </div>
                <div class="progress mt-3" style="height: 4px; background-color: #dcfce7;"><div class="progress-bar bg-success" id="normal-progress" style="width: 0%"></div></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-5 mb-4">
            <div class="premium-card p-4 h-100">
                <h5 class="text-bold-600 mb-4 text-center text-primary">Stock Level Distribution</h5>
                <div style="height: 250px;">
                    <canvas id="alertDoughnutChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mb-4">
            <div class="premium-card p-4 h-100">
                <h5 class="text-bold-600 mb-4 text-primary">Alerts by Warehouse</h5>
                <div style="height: 250px;">
                    <canvas id="alertBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filter Panel -->
    <div class="filter-panel">
        <div class="filter-header">
            <i class="ft-sliders"></i> Advanced Inventory Search
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="text-muted small font-weight-bold">Warehouse</label>
                <select class="form-control filter-input-glass" id="warehouse-filter">
                    <option value="all">All Warehouses</option>
                    <?php foreach ($warehouses as $warehouse): ?>
                        <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="text-muted small font-weight-bold">Category</label>
                <select class="form-control filter-input-glass" id="category-filter">
                    <option value="all">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="text-muted small font-weight-bold">Subcategory</label>
                <select class="form-control filter-input-glass" id="subcategory-filter">
                    <option value="all">All Subcategories</option>
                </select>
            </div>
            <!-- NEW UNIT FILTER -->
            <div class="col-md-3 mb-3">
                <label class="text-muted small font-weight-bold">Measurement Unit</label>
                <select class="form-control filter-input-glass" id="unit-filter">
                    <option value="all">All Units</option>
                    <?php foreach ($units as $unit): ?>
                        <option value="<?php echo $unit['code']; ?>"><?php echo $unit['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="text-muted small font-weight-bold">Alert Level</label>
                <select class="form-control filter-input-glass" id="alert-level-filter">
                    <option value="all">All Levels</option>
                    <option value="critical">Critical</option>
                    <option value="warning">Warning</option>
                    <option value="info">Low Stock</option>
                    <option value="normal">Healthy</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="text-muted small font-weight-bold">Inventory Logic</label>
                <select class="form-control filter-input-glass" id="minus-qty-filter">
                    <option value="all">Show All</option>
                    <option value="yes">Negative Stock Only</option>
                    <option value="no">Positive Stock Only</option>
                </select>
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-end">
                <button class="btn btn-premium w-100 justify-content-center" id="apply-filters">
                    <i class="ft-search"></i> Apply Filters
                </button>
            </div>
        </div>
    </div>
    
    <!-- Stock Volume Breakdown -->
    <div class="row mb-3">
        <div class="col-xl-4 col-md-4 col-12">
            <div class="card bg-white shadow-sm border-0" style="border-radius: var(--radius-std);">
                <div class="card-content">
                    <div class="card-body py-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h3 class="font-weight-bold text-dark mb-0" id="total-pieces">0</h3>
                                <span class="text-muted text-uppercase small letter-spacing-1">Total Pieces</span>
                            </div>
                            <div class="align-self-center">
                                <i class="ft-box font-large-2 text-primary opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12">
            <div class="card bg-white shadow-sm border-0" style="border-radius: var(--radius-std);">
                <div class="card-content">
                    <div class="card-body py-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h3 class="font-weight-bold text-dark mb-0" id="total-sqft">0.00</h3>
                                <span class="text-muted text-uppercase small letter-spacing-1">Total Sq. Ft.</span>
                            </div>
                            <div class="align-self-center">
                                <i class="ft-grid font-large-2 text-info opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12">
            <div class="card bg-white shadow-sm border-0" style="border-radius: var(--radius-std);">
                <div class="card-content">
                    <div class="card-body py-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h3 class="font-weight-bold text-dark mb-0" id="total-cubic">0.00</h3>
                                <span class="text-muted text-uppercase small letter-spacing-1">Total Cubic Ft.</span>
                            </div>
                            <div class="align-self-center">
                                <i class="ft-layers font-large-2 text-success opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="premium-card">
        <div id="notify" class="alert alert-success m-3" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        
        <div class="table-responsive">
            <table id="alerts-table" class="table table-premium">
                <thead>
                    <tr>
                        <th>Product Details</th>
                        <th>Location</th>
                        <th>Stock Level</th>
                        <th>Deficit</th>
                        <th>Status</th>
                        <th class="text-right">Manage</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Refined Modal -->
<div class="modal fade" id="editAlertModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-primary">Adjust Threshold</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="editAlertForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="edit-pid" name="pid">
                    <div class="text-center mb-4">
                        <h5 class="font-weight-bold" id="edit-product-name-text">Product</h5>
                        <div class="badge badge-light mt-1" id="edit-product-code-text">SKU</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <label class="font-weight-bold small text-uppercase text-muted">Current Stock</label>
                            <div class="h4 text-primary" id="edit-current-qty-text">0</div>
                        </div>
                        <div class="col-6">
                             <label class="font-weight-bold small text-uppercase text-muted">Current Alert</label>
                             <input type="text" class="form-control form-control-sm" id="edit-current-alert" readonly style="background:none; border:none; font-weight:bold; color: #ef4444;">
                        </div>
                    </div>
                    <hr>
                    
                    <div class="form-group mt-3">
                        <label class="font-weight-bold">New Threshold</label>
                        <input type="number" class="form-control form-control-lg filter-input-glass" id="edit-new-alert" name="alert_qty" step="0.001" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Reason for Change</label>
                        <textarea class="form-control filter-input-glass" id="edit-reason" name="reason" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 pr-4">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-premium">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-primary"><i class="ft-info mr-2"></i>Product Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0" id="productDetailsContent"></div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    var alertsTable;
    var doughnutChart, barChart;
    
    // Theme Defaults for Charts
    Chart.defaults.font.family = "'Montserrat', sans-serif";
    Chart.defaults.color = '#334155';
    
    loadStatistics();
    loadCharts();
    initDataTable();
    
    // Filter Events
    $('#category-filter').change(function() { loadSubcategories($(this).val()); });
    $('#apply-filters').click(function() { reloadDataTable(); });
    
    // View Details Event
    $(document).on('click', '.view-details, .product-title-link', function() {
        openDetailsModal($(this).data('pid'));
    });
    
    // Edit Alert Event
    $(document).on('click', '.edit-alert', function() {
        openEditModal($(this).data('pid'));
    });
    
    $('#editAlertForm').submit(function(e) {
        e.preventDefault();
        updateAlert();
    });
    
    $('#export-csv').click(exportCSV);

    // Initial Loaders
    function loadStatistics() {
        $.ajax({
            url: '<?php echo base_url("products_alert/get_alert_statistics"); ?>',
            type: 'POST',
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                warehouse: $('#warehouse-filter').val(),
                category: $('#category-filter').val(),
                subcategory: $('#subcategory-filter').val(),
                alert_level: $('#alert-level-filter').val(),
                minus_qty: $('#minus-qty-filter').val(),
                unit: $('#unit-filter').val()
            },
            dataType: 'json',
            success: function(data) {
                $('#critical-count').text(data.critical_count || 0);
                $('#warning-count').text(data.warning_count || 0);
                $('#info-count').text(data.info_count || 0);
                $('#normal-count').text(data.normal_count || 0);
                
                // Update Stock Totals
                $('#total-pieces').text(parseFloat(data.total_pieces || 0).toLocaleString());
                $('#total-sqft').text(parseFloat(data.total_sqft || 0).toFixed(2));
                $('#total-cubic').text(parseFloat(data.total_cubic || 0).toFixed(2));
                
                var total = (parseInt(data.critical_count)||0) + (parseInt(data.warning_count)||0) + (parseInt(data.info_count)||0) + (parseInt(data.normal_count)||0);
                if(total > 0) {
                    $('#critical-progress').css('width', (data.critical_count/total*100) + '%');
                    $('#warning-progress').css('width', (data.warning_count/total*100) + '%');
                    $('#info-progress').css('width', (data.info_count/total*100) + '%');
                    $('#normal-progress').css('width', (data.normal_count/total*100) + '%');
                } else {
                     $('#critical-progress').css('width', '0%');
                     $('#warning-progress').css('width', '0%');
                     $('#info-progress').css('width', '0%');
                     $('#normal-progress').css('width', '0%');
                }
            }
        });
    }

    function initDataTable() {
        alertsTable = $('#alerts-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: {
                url: '<?php echo base_url("products_alert/manage_alert_ajax_list"); ?>',
                type: 'POST',
                data: function(d) {
                    d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
                    d.warehouse = $('#warehouse-filter').val();
                    d.category = $('#category-filter').val();
                    d.subcategory = $('#subcategory-filter').val();
                    d.alert_level = $('#alert-level-filter').val();
                    d.minus_qty = $('#minus-qty-filter').val();
                    d.unit = $('#unit-filter').val(); // Send Unit Filter
                }
            },
            columns: [
                { 
                    data: 'product_name',
                    render: function(data, type, row) {
                        return '<a href="#" class="product-name product-title-link" data-pid="' + row.pid + '">' + data + '</a>' +
                               '<span class="product-sku">' + (row.product_code || 'N/A') + '</span> ' +
                               '<span class="text-muted small ml-1">' + (row.category || '') + '</span>';
                    }
                },
                { data: 'warehouse', className: 'text-muted' },
                { 
                    data: 'current_qty', 
                    render: function(data, type, row) {
                        // Visual Stock Bar
                        var pct = 0;
                        var color = 'bg-secondary';
                        if(row.alert_level === 'critical') { pct=20; color='bg-danger'; }
                        else if(row.alert_level === 'warning') { pct=50; color='bg-warning'; }
                        else if(row.alert_level === 'info') { pct=75; color='bg-info'; }
                        else { pct=100; color='bg-success'; }
                        
                        return '<div class="stock-indicator-wrapper">' +
                               '<div class="font-weight-bold text-dark">' + data + ' <span class="small text-muted">' + (row.unit || '') + '</span></div>' +
                               '<div class="stock-progress"><div class="stock-bar ' + color + '" style="width:' + pct + '%"></div></div>' +
                               '<div class="d-flex justify-content-between small text-muted mt-1"><span>Threshold: ' + row.alert_qty + '</span></div>' +
                               '</div>';
                    }
                },
                { 
                    data: 'difference',
                    render: function(data) {
                        var cls = data < 0 ? 'text-danger font-weight-bold' : 'text-success';
                        var icon = data < 0 ? 'ft-arrow-down' : 'ft-arrow-up';
                        return '<span class="' + cls + '"><i class="'+icon+'"></i> ' + Math.abs(data) + '</span>';
                    }
                },
                { 
                    data: 'status',
                    render: function(data, type, row) {
                        var badgeClass = '';
                        var text = '';
                        switch(row.alert_level) {
                            case 'critical': badgeClass='badge-psy badge-danger'; text='CRITICAL'; break;
                            case 'warning': badgeClass='badge-psy badge-warning'; text='WARNING'; break;
                            case 'info': badgeClass='badge-psy badge-info'; text='LOW STOCK'; break;
                            default: badgeClass='badge-psy badge-success'; text='HEALTHY'; break;
                        }
                        return '<span class="badge ' + badgeClass + '">' + text + '</span>';
                    }
                },
                { 
                    data: 'actions',
                    className: 'text-right' // Actions already formatted in controller
                }
            ],
            dom: '<"d-flex justify-content-between align-items-center mx-3 mt-3"l>rt<"d-flex justify-content-between align-items-center mx-3 my-3"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search products..."
            }
        });
    }
    
    function reloadDataTable() {
        alertsTable.ajax.reload();
        loadStatistics();
        loadCharts();
    }

    function loadSubcategories(catId) {
        if (catId != 'all') {
            $.get('<?php echo base_url("products/sub_cat?id="); ?>' + catId, function(data) {
                var subs = JSON.parse(data);
                var options = '<option value="all">All Subcategories</option>';
                subs.forEach(function(sub) { options += '<option value="' + sub.id + '">' + sub.title + '</option>'; });
                $('#subcategory-filter').html(options);
            });
        }
    }
    
    function exportCSV() {
        var form = $('<form>', { method: 'POST', action: '<?php echo base_url("products_alert/export_alerts_csv"); ?>' });
        // Add all filter inputs
        form.append($('<input>', { type: 'hidden', name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>' }));
        form.append($('<input>', { type: 'hidden', name: 'warehouse', value: $('#warehouse-filter').val() }));
        form.append($('<input>', { type: 'hidden', name: 'category', value: $('#category-filter').val() }));
        form.append($('<input>', { type: 'hidden', name: 'subcategory', value: $('#subcategory-filter').val() }));
        form.append($('<input>', { type: 'hidden', name: 'alert_level', value: $('#alert-level-filter').val() }));
        form.append($('<input>', { type: 'hidden', name: 'minus_qty', value: $('#minus-qty-filter').val() }));
        form.append($('<input>', { type: 'hidden', name: 'unit', value: $('#unit-filter').val() })); // Export Unit
        
        $('body').append(form);
        form.submit();
        form.remove();
    }

    // Load Charts Logic (Simplified for brevity but kept functional)
    function loadCharts() {
        $.ajax({
            url: '<?php echo base_url("products_alert/get_chart_data"); ?>',
            type: 'POST',
            data: {
                warehouse: $('#warehouse-filter').val(),
                category: $('#category-filter').val(),
                unit: $('#unit-filter').val(),
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'json',
            success: function(data) {
                // ... Update chart instances ...
                // Reusing similar logic as before but with new colors
                createDoughnut(data.doughnut);
                createBar(data.bar);
            }
        });
    }
    
    function createDoughnut(data) {
         var ctx = document.getElementById('alertDoughnutChart').getContext('2d');
         if(doughnutChart) doughnutChart.destroy();
         doughnutChart = new Chart(ctx, {
             type: 'doughnut',
             data: {
                 labels: ['Critical', 'Warning', 'Low', 'Healthy'],
                 datasets: [{
                     data: [data.critical, data.warning, data.low, data.normal],
                     backgroundColor: ['#ef4444', '#f59e0b', '#2563eb', '#16a34a']
                 }]
             },
             options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'right' } } }
         });
    }
    
    function createBar(data) {
        var ctx = document.getElementById('alertBarChart').getContext('2d');
        if(barChart) barChart.destroy();
        barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(i => i.warehouse),
                datasets: [
                    { label: 'Critical', data: data.map(i => i.critical), backgroundColor: '#ef4444', borderRadius: 4 },
                    { label: 'Warning', data: data.map(i => i.warning), backgroundColor: '#f59e0b', borderRadius: 4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { x: { stacked: true }, y: { stacked: true } } }
        });
    }
    
    // Modal Helpers
    function openDetailsModal(pid) {
        $('#viewDetailsModal').modal('show');
        $('#productDetailsContent').html('<div class="p-5 text-center"><i class="ft-refresh-cw spinner font-large-2 text-primary"></i></div>');
        
        $.post('<?php echo base_url("products_alert/get_product_details"); ?>', {
            pid: pid,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }, function(res){
             try {
                 var data = JSON.parse(res);
                 if(data.success) {
                     var p = data.data;
                     
                     // Helper to safe display
                     const show = (val) => (val && val !== '0' && val !== '0.00' && val !== 'null') ? val : '<span class="text-muted small">N/A</span>';
                     const money = (val) => parseFloat(val || 0).toFixed(2);
                     
                     // RAW Data rendering for "System" tab (excluding known fields to avoid clutter)
                     let rawRows = '';
                     const exclude = ['pid','product_name','qty','product_code','product_price','fproduct_price','taxrate','disrate','product_des','alert','image','warehouse','pcat','sub_id','unit','barcode','merge','sub','expiry','product_des','valid','series','pwith','pthickness','pquick','pquick_code','warehouse_name','category_name','subcategory_name','alert_status','status_class'];
                     
                     for (const [key, value] of Object.entries(p)) {
                         if(!exclude.includes(key)) {
                             rawRows += `<tr><td class="text-muted small text-uppercase">${key.replace(/_/g, ' ')}</td><td class="font-weight-bold text-dark">${value}</td></tr>`;
                         }
                     }

                     var html = `
                        <div class="d-flex flex-column h-100">
                            <!-- Hero Section -->
                            <div class="p-4 text-white position-relative" style="background: linear-gradient(135deg, var(--psy-accent-primary), var(--psy-text-primary)); border-radius: 6px 6px 0 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="font-weight-bold text-white mb-0">${p.product_name}</h3>
                                        <div class="mt-2">
                                            <span class="badge badge-light text-primary font-medium-1 mr-2"><i class="ft-tag"></i> ${show(p.product_code)}</span>
                                            <span class="badge badge-${p.status_class} font-medium-1 text-white border-0"><i class="ft-activity"></i> ${p.alert_status}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <h1 class="display-4 font-weight-bold text-white mb-0">${parseFloat(p.qty).toFixed(2)}</h1>
                                        <div class="text-uppercase small opacity-75">${p.unit || 'Units'} In Stock</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tabs Navigation -->
                            <div class="bg-white border-bottom">
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active font-weight-bold text-primary" data-toggle="tab" href="#tab-overview"><i class="ft-layers"></i> Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold text-primary" data-toggle="tab" href="#tab-pricing"><i class="ft-dollar-sign"></i> Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold text-primary" data-toggle="tab" href="#tab-specs"><i class="ft-maximize"></i> Dimensions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold text-primary" data-toggle="tab" href="#tab-system"><i class="ft-server"></i> System Data</a>
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Tabs Content -->
                            <div class="tab-content flex-grow-1 bg-light">
                                
                                <!-- Overview Tab -->
                                <div class="tab-pane active p-4" id="tab-overview">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="card shadow-sm h-100 border-0">
                                                <div class="card-body">
                                                    <h6 class="text-uppercase text-muted letter-spacing-1 mb-3">Classification</h6>
                                                    <table class="table table-borderless table-sm mb-0">
                                                        <tr><td width="40%" class="text-muted"><i class="ft-folder mr-2"></i>Category</td><td class="font-weight-bold text-dark">${show(p.category_name)}</td></tr>
                                                        <tr><td class="text-muted"><i class="ft-grid mr-2"></i>Subcategory</td><td class="font-weight-bold text-dark">${show(p.subcategory_name)}</td></tr>
                                                        <tr><td class="text-muted"><i class="ft-map-pin mr-2"></i>Warehouse</td><td class="font-weight-bold text-dark">${show(p.warehouse_name)}</td></tr>
                                                        <tr><td class="text-muted"><i class="ft-box mr-2"></i>Barcode</td><td class="font-weight-bold text-dark">${show(p.barcode)}</td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card shadow-sm h-100 border-0">
                                                <div class="card-body">
                                                    <h6 class="text-uppercase text-muted letter-spacing-1 mb-3">Inventory Status</h6>
                                                    <table class="table table-borderless table-sm mb-0">
                                                        <tr><td width="50%" class="text-muted">Current Stock</td><td class="font-weight-bold text-dark">${p.qty}</td></tr>
                                                        <tr><td class="text-muted">Alert Threshold</td><td class="font-weight-bold text-danger">${p.alert}</td></tr>
                                                        <tr><td class="text-muted">Expiry Date</td><td class="font-weight-bold text-dark">${show(p.expiry)}</td></tr>
                                                        <tr><td class="text-muted">Re-order Status</td><td><span class="badge badge-pill badge-${p.status_class}">${p.alert_status}</span></td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card shadow-sm border-0">
                                                <div class="card-body">
                                                    <h6 class="text-uppercase text-muted letter-spacing-1 mb-2">Description</h6>
                                                    <p class="text-dark mb-0">${show(p.product_des)}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing Tab -->
                                <div class="tab-pane p-4" id="tab-pricing">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="bg-white p-3 rounded shadow-sm text-center border-bottom border-success">
                                                <h6 class="text-muted text-uppercase small">Retail Price</h6>
                                                <h2 class="text-success font-weight-bold mb-0">${money(p.product_price)}</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="bg-white p-3 rounded shadow-sm text-center border-bottom border-info">
                                                <h6 class="text-muted text-uppercase small">Purchase Price</h6>
                                                <h2 class="text-info font-weight-bold mb-0">${money(p.fproduct_price)}</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="bg-white p-3 rounded shadow-sm text-center border-bottom border-warning">
                                                <h6 class="text-muted text-uppercase small">Tax Rate</h6>
                                                <h2 class="text-warning font-weight-bold mb-0">${show(p.taxrate)}%</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card shadow-sm border-0 mt-3">
                                        <div class="card-body">
                                            <h6 class="text-uppercase text-muted letter-spacing-1 mb-3">Financial Details</h6>
                                            <table class="table table-striped mb-0">
                                                <tr><td>Discount Rate</td><td class="text-right font-weight-bold">${money(p.disrate)}%</td></tr>
                                                <tr><td>Tax Mode</td><td class="text-right font-weight-bold">${p.taxrate > 0 ? 'Taxable' : 'Non-Taxable'}</td></tr>
                                                <tr><td>Code Type</td><td class="text-right font-weight-bold">${show(p.code_type)}</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dimensions Tab -->
                                <div class="tab-pane p-4" id="tab-specs">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-white shadow-sm border-0">
                                                <div class="card-header bg-transparent font-weight-bold text-uppercase small text-muted">Measurements</div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            Width <span class="badge badge-primary badge-pill">${show(p.pwith)}</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            Thickness <span class="badge badge-primary badge-pill">${show(p.pthickness)}</span>
                                                        </li>
                                                         <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            Length/Height <span class="badge badge-primary badge-pill">${show(p.plength)}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-white shadow-sm border-0">
                                                <div class="card-header bg-transparent font-weight-bold text-uppercase small text-muted">Calculations</div>
                                                <div class="card-body">
                                                    <table class="table table-sm">
                                                        <tr><td>Quick Code</td><td class="text-right font-weight-bold">${show(p.pquick_code)}</td></tr>
                                                        <tr><td>Quick Factor</td><td class="text-right font-weight-bold">${show(p.pquick)}</td></tr>
                                                        <tr><td>Unit Type</td><td class="text-right font-weight-bold">${show(p.unit)}</td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- System Tab -->
                                <div class="tab-pane p-4" id="tab-system">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped mb-0">
                                                    <thead class="bg-light">
                                                        <tr><th>Field Name</th><th>Database Value</th></tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr><td class="text-muted small text-uppercase">System ID</td><td class="font-weight-bold text-dark">#${p.pid}</td></tr>
                                                        ${rawRows}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                     `;
                     $('#productDetailsContent').html(html);
                 } else {
                     $('#productDetailsContent').html('<div class="alert alert-danger m-3">' + data.message + '</div>');
                 }
             } catch(e) {
                 console.error(e);
                 $('#productDetailsContent').html('<div class="alert alert-danger m-3">Data Error: ' + e.message + '</div>');
             }
        }).fail(function(){
            $('#productDetailsContent').html('<div class="alert alert-danger m-3">Connection Error</div>');
        });
    }
    
    function openEditModal(pid) {
        // ... Reusing logic mostly, just ensuring ID matches ...
         $.post('<?php echo base_url("products_alert/get_product_details"); ?>', {
            pid: pid,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }, function(data) {
            var res = JSON.parse(data);
            if (res.success) {
                var p = res.data;
                $('#edit-pid').val(pid);
                $('#edit-product-name-text').text(p.product_name);
                $('#edit-product-code-text').text(p.product_code);
                $('#edit-current-qty-text').text(p.qty);
                $('#edit-current-alert').val(p.alert);
                $('#edit-new-alert').val(p.alert);
                $('#editAlertModal').modal('show');
            }
        });
    }
    
    function updateAlert() {
        $.post('<?php echo base_url("products_alert/update_alert_qty"); ?>', 
            $('#editAlertForm').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>', 
            function(data) {
                var res = JSON.parse(data);
                if (res.success) {
                    $('#editAlertModal').modal('hide');
                    reloadDataTable();
                    $('#notify .message').html(res.message);
                    $('#notify').fadeIn().delay(3000).fadeOut();
                } else {
                    alert(res.message);
                }
            }
        );
    }
});
</script>