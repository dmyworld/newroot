<style>
    /* ============================================
       TIMBER ERP PROFESSIONAL DESIGN SYSTEM v2.1
       Refined Palette & Layout
    ============================================ */
    
    :root {
        /* Timber Brand Colors - Deep & Professional */
        --timber-walnut: #5D4037;   /* Deep Brown */
        --timber-oak: #D4AF37;      /* Metallic Gold/Oak */
        --timber-forest: #2E7D32;   /* Rich Green */
        --timber-charcoal: #37474F; /* Dark Blue-Grey */
        
        /* Background & Surface tones */
        --bg-warm-cream: #FAF9F6;
        --bg-paper-white: #FFFFFF;
        --bg-soft-gray: #F5F7FA;
        
        /* Status Indicators */
        --status-critical: #D32F2F;
        --status-warning: #FFA000;
        --status-info: #1976D2;
        --status-success: #388E3C;
        
        /* UI Elements */
        --shadow-soft: 0 4px 20px rgba(0,0,0,0.05);
        --shadow-lifted: 0 10px 25px rgba(93, 64, 55, 0.1);
        --glass-border: 1px solid rgba(255,255,255,0.6);
        --radius-std: 12px;
        --radius-lg: 20px;
    }

    body {
        background-color: var(--bg-soft-gray);
        font-family: 'Montserrat', sans-serif;
        color: var(--timber-charcoal);
    }

    .content-body {
        padding: 2rem;
        background: radial-gradient(circle at 10% 10%, rgba(212, 175, 55, 0.05) 0%, transparent 40%);
    }

    /* GLASSMORPHIC HEADER */
    .page-header-glass {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: var(--glass-border);
        box-shadow: var(--shadow-soft);
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
        background: linear-gradient(90deg, var(--timber-walnut), var(--timber-oak));
    }

    .page-title h2 {
        color: var(--timber-walnut);
        font-weight: 800;
        letter-spacing: -0.5px;
        margin: 0;
        font-size: 2rem;
        text-transform: uppercase;
    }

    .page-title p {
        color: #795548;
        font-weight: 500;
        margin: 0;
        font-size: 0.95rem;
    }

    /* PREMIUM BUTTONS */
    .btn-premium {
        background: linear-gradient(135deg, var(--timber-walnut), #4E342E);
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(93, 64, 55, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(93, 64, 55, 0.4);
        background: linear-gradient(135deg, #4E342E, var(--timber-walnut));
        color: #fff;
    }

    /* METRIC CARDS */
    .metric-card {
        background: #fff;
        border-radius: var(--radius-std);
        padding: 1.5rem;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lifted);
    }

    .metric-card.critical { border-bottom: 4px solid var(--status-critical); }
    .metric-card.warning { border-bottom: 4px solid var(--status-warning); }
    .metric-card.info { border-bottom: 4px solid var(--status-info); }
    .metric-card.success { border-bottom: 4px solid var(--status-success); }

    .metric-icon {
        width: 50px; height: 50px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .bg-light-critical { background: #FFEBEE; color: var(--status-critical); }
    .bg-light-warning { background: #FFF8E1; color: var(--status-warning); }
    .bg-light-info { background: #E3F2FD; color: var(--status-info); }
    .bg-light-success { background: #E8F5E9; color: var(--status-success); }

    .metric-value { font-size: 2.2rem; font-weight: 800; color: var(--timber-charcoal); line-height: 1.2; }
    .metric-label { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: #888; font-weight: 600; }

    /* FILTERS PANEL */
    .filter-panel {
        background: #fff;
        border-radius: var(--radius-std);
        padding: 1.5rem;
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
        border-left: 5px solid var(--timber-oak);
    }
    
    .filter-header {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--timber-walnut);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-control-timber {
        border: 2px solid #EEE;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        height: auto;
        font-size: 0.95rem;
        transition: all 0.3s;
        background: #FAFAFA;
    }
    
    .form-control-timber:focus {
        border-color: var(--timber-oak);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        background: #fff;
    }

    /* DATA TABLE & LIST */
    .timber-table-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lifted);
        padding: 0;
        overflow: hidden;
    }

    .table-responsive { overflow-x: auto; }

    .table-timber {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-timber thead th {
        background: linear-gradient(to right, var(--timber-walnut), #4E342E);
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        padding: 1.2rem 1.5rem;
        border: none;
    }

    .table-timber tbody tr {
        transition: all 0.2s;
    }

    .table-timber tbody tr:nth-child(even) { background-color: #FAFAFA; }
    
    .table-timber tbody tr:hover {
        background-color: #FFF8E1; /* Light Gold tint */
        transform: scale(1.005);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        z-index: 5;
        position: relative;
    }

    .table-timber td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #F0F0F0;
        color: #555;
        font-weight: 500;
    }

    .product-name {
        font-weight: 700;
        color: var(--timber-walnut);
        font-size: 1rem;
        display: block;
        margin-bottom: 2px;
        text-decoration: none;
    }
    
    .product-sku {
        font-family: 'Roboto Mono', monospace;
        font-size: 0.8rem;
        color: #999;
        background: #F5F5F5;
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* ACTIONS MENU */
    .action-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center; justify-content: center;
        transition: all 0.2s;
        border: none;
        margin: 0 2px;
    }
    
    .action-btn.edit { background: #E3F2FD; color: #1976D2; }
    .action-btn.edit:hover { background: #1976D2; color: #fff; }
    
    .action-btn.cut { background: #FFF3E0; color: #F57C00; }
    .action-btn.cut:hover { background: #F57C00; color: #fff; }

    .action-btn.alert { background: #FFEBEE; color: #D32F2F; }
    .action-btn.alert:hover { background: #D32F2F; color: #fff; }

    /* STOCK INDICATORS */
    .stock-indicator-wrapper {
        min-width: 120px;
    }
    
    .stock-progress {
        height: 6px;
        border-radius: 3px;
        background: #EEE;
        margin-top: 6px;
        overflow: hidden;
    }
    
    .stock-bar { height: 100%; border-radius: 3px; }

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
    <div class="card bg-white border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white font-weight-bold ml-2 pt-3" data-toggle="collapse" href="#helpGuide" role="button" aria-expanded="false" aria-controls="helpGuide" style="cursor: pointer; border-bottom: none;">
            <i class="ft-book mr-1 text-primary"></i> User Guide / උපදෙස් / பயனர் வழிகாட்டி <i class="ft-chevron-down float-right mr-3"></i>
        </div>
        <div class="collapse" id="helpGuide">
            <div class="card-body pt-0 ml-2 mr-2">
                <ul class="nav nav-tabs nav-underline" id="guideTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="eng-tab" data-toggle="tab" href="#eng" role="tab" style="color: var(--timber-walnut);">English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sin-tab" data-toggle="tab" href="#sin" role="tab" style="color: var(--timber-walnut);">සිංහල</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tam-tab" data-toggle="tab" href="#tam" role="tab" style="color: var(--timber-walnut);">தமிழ்</a>
                    </li>
                </ul>
                <div class="tab-content border-0 p-3" id="guideTabContent">
                    <div class="tab-pane fade show active" id="eng" role="tabpanel">
                        <h6 class="text-primary mt-2">How to Manage Alerts</h6>
                        <ol>
                            <li><strong>Monitor Levels:</strong> View products with stock levels below their Alert Quantity.</li>
                            <li><strong>Status Indicators:</strong>
                                <ul>
                                    <li><span class="badge badge-danger">CRITICAL</span> Stock is critically low. Immediate reorder needed.</li>
                                    <li><span class="badge badge-warning">WARNING</span> Stock is approaching zero. Plan restock.</li>
                                </ul>
                            </li>
                            <li><strong>Manage:</strong> Use the "Manage" column to update alert thresholds or initiate stock transfers.</li>
                        </ol>
                        <p class="text-muted"><small><strong>Note:</strong> Keeping stock above alert levels ensures smooth operations and prevents checkout blockages.</small></p>
                    </div>
                    <div class="tab-pane fade" id="sin" role="tabpanel">
                        <h6 class="text-primary mt-2">අනතුරු ඇඟවීම් (Alerts) කළමනාකරණය කරන ආකාරය</h6>
                        <ol>
                            <li><strong>මට්ටම් නිරීක්ෂණය:</strong> අනතුරු ඇඟවීමේ ප්‍රමාණයට (Alert Quantity) වඩා අඩු තොග ඇති නිෂ්පාදන පරීක්ෂා කරන්න.</li>
                            <li><strong>තත්ත්ව දර්ශක:</strong>
                                <ul>
                                    <li><span class="badge badge-danger">CRITICAL</span> තොග ඉතා අඩු මට්ටමක පවතී. වහාම ඇණවුම් කිරීම අවශ්‍ය වේ.</li>
                                    <li><span class="badge badge-warning">WARNING</span> තොග අවසන් වීමට ආසන්නයි. නැවත පුරවන්න (Restock).</li>
                                </ul>
                            </li>
                            <li><strong>කළමනාකරණය:</strong> අනතුරු ඇඟවීමේ සීමාවන් යාවත්කාලීන කිරීමට හෝ තොග මාරු කිරීම් ආරම්භ කිරීමට "Manage" තීරුව භාවිතා කරන්න.</li>
                        </ol>
                        <p class="text-muted"><small><strong>සටහන:</strong> අනතුරු ඇඟවීමේ මට්ටමට වඩා ඉහළින් තොග පවත්වා ගැනීමෙන් බාධාවකින් තොරව මෙහෙයුම් සිදු කළ හැක.</small></p>
                    </div>
                    <div class="tab-pane fade" id="tam" role="tabpanel">
                        <h6 class="text-primary mt-2">எச்சரிக்கைகளை எவ்வாறு நிர்வகிப்பது</h6>
                        <ol>
                            <li><strong>நிலைகளைக் கண்காணிக்கவும்:</strong> எச்சரிக்கை அளவிற்குக் கீழே உள்ள பங்கு நிலைகளைக் கொண்ட தயாரிப்புகளைப் பார்க்கவும்.</li>
                            <li><strong>நிலை குறிகாட்டிகள்:</strong>
                                <ul>
                                    <li><span class="badge badge-danger">CRITICAL</span> இருப்பு மிகவும் குறைவாக உள்ளது. உடனடி மறு ஆர்டர் தேவை.</li>
                                    <li><span class="badge badge-warning">WARNING</span> இருப்பு பூஜ்ஜியத்தை நெருங்குகிறது. மறுசீரமைக்கத் திட்டமிடவும்.</li>
                                </ul>
                            </li>
                            <li><strong>நிர்வகித்தல்:</strong> எச்சரிக்கை வரம்புகளைப் புதுப்பிக்க அல்லது பங்கு மாற்றங்களைத் தொடங்க "Manage" பத்தியைப் பயன்படுத்தவும்.</li>
                        </ol>
                        <p class="text-muted"><small><strong>குறிப்பு:</strong> எச்சரிக்கை அளவிற்கு மேலே இருப்பை வைத்திருப்பது மென்மையான செயல்பாடுகளை உறுதி செய்கிறது.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-5">
        <div class="col-xl-3 col-lg-6 col-12 mb-3">
            <div class="metric-card critical">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="metric-value" id="critical-count">0</div>
                        <div class="metric-label">Critical (< 10)</div>
                    </div>
                    <div class="metric-icon bg-light-critical"><i class="ft-alert-octagon"></i></div>
                </div>
                <div class="progress mt-3" style="height: 4px;"><div class="progress-bar bg-danger" id="critical-progress" style="width: 0%"></div></div>
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
                <div class="progress mt-3" style="height: 4px;"><div class="progress-bar bg-warning" id="warning-progress" style="width: 0%"></div></div>
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
                <div class="progress mt-3" style="height: 4px;"><div class="progress-bar bg-info" id="info-progress" style="width: 0%"></div></div>
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
                <div class="progress mt-3" style="height: 4px;"><div class="progress-bar bg-success" id="normal-progress" style="width: 0%"></div></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-5">
        <div class="col-lg-5 mb-4">
            <div class="timber-table-card p-4 h-100">
                <h5 class="text-bold-600 mb-4 text-center">Stock Level Distribution</h5>
                <div style="height: 250px;">
                    <canvas id="alertDoughnutChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mb-4">
            <div class="timber-table-card p-4 h-100">
                <h5 class="text-bold-600 mb-4">Alerts by Warehouse</h5>
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
                <label>Warehouse</label>
                <select class="form-control form-control-timber" id="warehouse-filter">
                    <option value="all">All Warehouses</option>
                    <?php foreach ($warehouses as $warehouse): ?>
                        <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label>Category</label>
                <select class="form-control form-control-timber" id="category-filter">
                    <option value="all">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label>Subcategory</label>
                <select class="form-control form-control-timber" id="subcategory-filter">
                    <option value="all">All Subcategories</option>
                </select>
            </div>
            <!-- NEW UNIT FILTER -->
            <div class="col-md-3 mb-3">
                <label>Measurement Unit</label>
                <select class="form-control form-control-timber" id="unit-filter">
                    <option value="all">All Units</option>
                    <?php foreach ($units as $unit): ?>
                        <option value="<?php echo $unit['code']; ?>"><?php echo $unit['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label>Alert Level</label>
                <select class="form-control form-control-timber" id="alert-level-filter">
                    <option value="all">All Levels</option>
                    <option value="critical">Critical</option>
                    <option value="warning">Warning</option>
                    <option value="info">Low Stock</option>
                    <option value="normal">Healthy</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label>Inventory Logic</label>
                <select class="form-control form-control-timber" id="minus-qty-filter">
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
            <div class="card bg-white shadow-sm border-0">
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
            <div class="card bg-white shadow-sm border-0">
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
            <div class="card bg-white shadow-sm border-0">
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
    <div class="timber-table-card">
        <div id="notify" class="alert alert-success m-3" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        
        <div class="table-responsive">
            <table id="alerts-table" class="table table-timber">
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
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header bg-primary text-white" style="border-radius: 20px 20px 0 0; background: linear-gradient(135deg, var(--timber-walnut), var(--timber-oak));">
                <h5 class="modal-title font-weight-bold">Adjust Threshold</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
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
                            <div class="h4" id="edit-current-qty-text">0</div>
                        </div>
                        <div class="col-6">
                             <label class="font-weight-bold small text-uppercase text-muted">Current Alert</label>
                             <input type="text" class="form-control form-control-sm" id="edit-current-alert" readonly style="background:none; border:none; font-weight:bold;">
                        </div>
                    </div>
                    <hr>
                    
                    <div class="form-group mt-3">
                        <label class="font-weight-bold">New Threshold</label>
                        <input type="number" class="form-control form-control-lg" id="edit-new-alert" name="alert_qty" step="0.001" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Reason for Change</label>
                        <textarea class="form-control" id="edit-reason" name="reason" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-premium">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #37474F, #455A64); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title"><i class="ft-info mr-2"></i>Product Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
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
    Chart.defaults.color = '#5D4037';
    
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
                            case 'critical': badgeClass='badge-danger'; text='CRITICAL'; break;
                            case 'warning': badgeClass='badge-warning'; text='WARNING'; break;
                            case 'info': badgeClass='badge-info'; text='LOW STOCK'; break;
                            default: badgeClass='badge-success'; text='GOOD'; break;
                        }
                        return '<span class="badge ' + badgeClass + ' px-3 py-2">' + text + '</span>';
                    }
                },
                { 
                    data: 'actions',
                    className: 'text-right' // Actions already formatted in controller, but we restyled them in CSS
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
                 labels: ['Critical', 'Warning', 'Low', 'Good'],
                 datasets: [{
                     data: [data.critical, data.warning, data.low, data.normal],
                     backgroundColor: ['#D32F2F', '#FFA000', '#1976D2', '#388E3C']
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
                    { label: 'Critical', data: data.map(i => i.critical), backgroundColor: '#D32F2F', borderRadius: 5 },
                    { label: 'Warning', data: data.map(i => i.warning), backgroundColor: '#FFA000', borderRadius: 5 }
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
                            <div class="bg-gradient-x-primary p-4 text-white position-relative" style="background: linear-gradient(135deg, var(--timber-walnut), var(--timber-oak));">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="font-weight-bold text-white mb-0">${p.product_name}</h3>
                                        <div class="mt-2">
                                            <span class="badge badge-light text-dark font-medium-1 mr-2"><i class="ft-tag"></i> ${show(p.product_code)}</span>
                                            <span class="badge badge-${p.status_class} font-medium-1"><i class="ft-activity"></i> ${p.alert_status}</span>
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
                                        <a class="nav-link active font-weight-bold" data-toggle="tab" href="#tab-overview"><i class="ft-layers"></i> Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold" data-toggle="tab" href="#tab-pricing"><i class="ft-dollar-sign"></i> Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold" data-toggle="tab" href="#tab-specs"><i class="ft-maximize"></i> Dimensions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold" data-toggle="tab" href="#tab-system"><i class="ft-server"></i> System Data</a>
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
                                            <div class="bg-white p-3 rounded shadow-sm text-center border-bottom-primary border-3">
                                                <h6 class="text-muted text-uppercase small">Retail Price</h6>
                                                <h2 class="text-success font-weight-bold mb-0">${money(p.product_price)}</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="bg-white p-3 rounded shadow-sm text-center border-bottom-info border-3">
                                                <h6 class="text-muted text-uppercase small">Purchase Price</h6>
                                                <h2 class="text-info font-weight-bold mb-0">${money(p.fproduct_price)}</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="bg-white p-3 rounded shadow-sm text-center border-bottom-warning border-3">
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