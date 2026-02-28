<script type="text/javascript">
    var dataVisits = [
        <?php $tt_inc = 0;foreach ($incomechart as $row) {
        $tt_inc += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . "},";
    }
        ?>
    ];
    var dataVisits2 = [
        <?php $tt_exp = 0; foreach ($expensechart as $row) {
        $tt_exp += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . "},";
    }
        ?>];

</script>

<div class="row">

     <!-- User Guide -->
    <div class="col-12">
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #28a745;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideDash" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-psy-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideDash" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_dash">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_dash">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_dash">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_dash" class="tab-pane active">
                            <h6 class="text-psy-highlight mt-1 small">Dashboard Overview</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Stats:</strong> View daily income, expenses, and profit at a glance.</li>
                                <li><strong>Charts:</strong> Analyze sales and product performance trends over the last 30 days.</li>
                                <li><strong>Tasks:</strong> Keep track of your pending tasks and deadlines.</li>
                            </ol>
                        </div>
                        <div id="sin_dash" class="tab-pane fade">
                            <h6 class="text-psy-highlight mt-1 small">උ시කරණ පුවරුව (Dashboard)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>සංඛ්‍යාලේඛන:</strong> දෛනික ආදායම, වියදම් සහ ලාභය එක බැල්මකින් බලන්න.</li>
                                <li><strong>ප්‍රස්ථාර:</strong> පසුගිය දින 30 තුළ විකුණුම් සහ නිෂ්පාදන කාර්ය සාධන ප්‍රවණතා විශ්ලේෂණය කරන්න.</li>
                                <li><strong>කාර්යයන්:</strong> ඔබගේ විභාග වෙමින් පවතින කාර්යයන් සහ නියමිත දින නිරීක්ෂණය කරන්න.</li>
                            </ol>
                        </div>
                        <div id="tam_dash" class="tab-pane fade">
                            <h6 class="text-psy-highlight mt-1 small">டாஷ்போர்டு கண்ணோட்டம்</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>புள்ளிவிவரங்கள்:</strong> தினசரி வருமானம், செலவுகள் மற்றும் லாபத்தை ஒரே பார்வையில் பார்க்கலாம்.</li>
                                <li><strong>வரைபடங்கள்:</strong> கடந்த 30 நாட்களில் விற்பனை மற்றும் தயாரிப்பு செயல்திறன் போக்குகளைப் பகுப்பாய்வு செய்யுங்கள்.</li>
                                <li><strong>பணிகள்:</strong> உங்கள் நிலுவையில் உள்ள பணிகள் மற்றும் காலக்கெடுவைக் கண்காணிக்கவும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Guide -->

    <!-- Psychological Color Palette Definitions -->
    <!-- Scientific Light Mode Palette Definitions -->
    <style>
        /* Blue & Life Green Theme Variables */
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
        }
        
        /* Force overrides for Global Dark Mode leaks */
        html, body, .app-content, .content-wrapper, .content-body {
            background-color: var(--psy-bg-page) !important;
            color: var(--psy-text-primary) !important;
        }

        body {

        /* Text Utilities */
        .text-psy-label { color: var(--psy-text-secondary) !important; font-weight: 500; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em; } /* 0.75rem -> 0.8rem */ 
        .text-psy-muted { color: #475569 !important; }
        .text-psy-value { color: var(--psy-text-primary) !important; font-weight: 700; }
        .text-psy-highlight { color: var(--psy-accent-primary) !important; }
        .text-psy-success { color: var(--psy-accent-success) !important; }
        .text-psy-warning { color: var(--psy-accent-warning) !important; }
        .text-psy-danger { color: var(--psy-accent-danger) !important; }
        .text-psy-info { color: var(--psy-accent-primary) !important; }
        .text-money-symbol { color: var(--psy-text-secondary); font-weight: normal; margin-right: 2px; }

        /* Typography */
        .font-psy-small-1 { font-size: 0.8rem; } /* 0.75 -> 0.8 */
        .font-psy-small-2 { font-size: 0.9rem; } /* 0.875 -> 0.9 */
        .font-psy-small-3 { font-size: 1.05rem; font-weight: 600; } /* 1.0 -> 1.05 */
        
        /* Widget Headers */
        h4, h5, h6 { color: var(--psy-text-primary) !important; font-weight: 600; }
        .card-header { background-color: white !important; border-bottom: 1px solid var(--psy-border) !important; }

        /* Progress Bars */
        .progress { background-color: #f1f5f9 !important; }
        .progress-bar { opacity: 1 !important; box-shadow: none !important; }

        /* Icon Colors - Clinical/Scientific */
        .ft-activity, .ft-layers, .ft-cpu, .icon-basket-loaded, .icon-wallet, .icon-graph, .icon-users {
            color: var(--psy-text-secondary); /* Neutral icons by default */
        }
    </style>
        

    <!-- Executive Command Center HUD -->
    <style>
        .command-center-hud { 
            background: #ffffff; 
            border-radius: 8px; 
            box-shadow: var(--psy-shadow); 
            border: 1px solid var(--psy-border); 
            color: var(--psy-text-primary); 
            position: relative; 
            overflow: hidden;
        }
        .hud-stat-box {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 8px 12px;
            border: 1px solid var(--psy-border);
            transition: all 0.3s ease;
        }
        .hud-stat-box:hover {
            background: #f1f5f9;
            border-color: var(--psy-accent-primary);
        }
        .hud-label {
            font-size: 0.7rem; /* Increased from 0.65rem */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--psy-text-secondary);
            display: block;
            margin-bottom: 2px;
            font-weight: 600;
        }
        .hud-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--psy-text-primary);
        }
        .filter-input-glass {
            background: #ffffff !important;
            border: 1px solid var(--psy-border) !important;
            color: var(--psy-text-primary) !important;
            font-size: 0.85rem;
            border-radius: 4px;
        }
        .filter-input-glass:focus {
            background: #ffffff !important;
            border-color: var(--psy-accent-primary) !important;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        }
        .btn-glass {
            background: var(--psy-bg-page);
            border: 1px solid var(--psy-border);
            color: var(--psy-text-primary);
            transition: all 0.2s;
            font-weight: 600;
        }
        .btn-glass:hover {
            background: #e2e8f0;
            color: var(--psy-text-primary);
            transform: translateY(-1px);
        }
    </style>
    <div class="col-12 mb-3">
        <div class="command-center-hud p-3">
            <div class="row align-items-center">
                <!-- Title & Status -->
                <div class="col-lg-3 border-right border-secondary mb-2 mb-lg-0">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <div class="bg-primary bg-lighten-4 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="fa fa-connectdevelop text-primary font-medium-3"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-psy-value font-weight-bold mb-0">COMMAND CENTER</h6>
                            <div class="d-flex align-items-center mt-1">
                                <span class="status-dot bg-success mr-1"></span>
                                <span class="small text-success">SYSTEM ONLINE</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Context Widget -->
                <div class="col-lg-3 mb-2 mb-lg-0">
                    <div class="d-flex">
                        <div class="hud-stat-box mr-2 w-50">
                            <span class="hud-label"><i class="fa fa-building-o mr-1"></i> Active Branch</span>
                            <span class="hud-value text-truncate d-block">
                                <?php 
                                    $branch_name = "All Branches";
                                    if(isset($locations)) {
                                        foreach($locations as $loc) {
                                            if(isset($current_branch) && $current_branch == $loc['id']) {
                                                $branch_name = $loc['cname'];
                                                break;
                                            }
                                        }
                                    }
                                    echo $branch_name;
                                ?>
                            </span>
                        </div>
                        <div class="hud-stat-box w-50">
                            <span class="hud-label"><i class="fa fa-calendar-check-o mr-1"></i> Data Range</span>
                            <span class="hud-value text-truncate d-block">
                                <?php 
                                    if(isset($start_date) && isset($end_date)) {
                                        if($start_date == $end_date) echo date('M d', strtotime($start_date));
                                        else echo date('M d', strtotime($start_date)) . ' - ' . date('M d', strtotime($end_date));
                                    } else {
                                        echo "Today";
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Controls Form -->
                <div class="col-lg-6">
                     <form method="get" id="dashboard-filter-form">
                        <div class="row gutters-tiny">
                            <!-- Branch Select -->
                            <div class="col-md-4 mb-1 mb-md-0">
                                <label class="hud-label pl-1">Target Branch</label>
                                <select name="branch_id" class="form-control form-control-sm filter-input-glass" onchange="this.form.submit()">
                                    <option value="0">Global View (All)</option>
                                    <?php if(isset($locations)) { foreach ($locations as $loc) { ?>
                                        <option value="<?= $loc['id'] ?>" <?= (isset($current_branch) && $current_branch == $loc['id']) ? 'selected' : '' ?>>
                                            <?= $loc['cname'] ?>
                                        </option>
                                    <?php } } ?>
                                </select>
                            </div>
                            
                            <!-- Quick Range -->
                            <div class="col-md-3 mb-1 mb-md-0">
                                <label class="hud-label pl-1">Timeframe</label>
                                <select name="quick_filter" class="form-control form-control-sm filter-input-glass" id="quick-filter">
                                    <option value="">Custom...</option>
                                    <option value="today" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'today') ? 'selected' : '' ?>>Today</option>
                                    <option value="yesterday" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'yesterday') ? 'selected' : '' ?>>Yesterday</option>
                                    <option value="this_week" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'this_week') ? 'selected' : '' ?>>This Week</option>
                                    <option value="this_month" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'this_month') ? 'selected' : '' ?>>This Month</option>
                                </select>
                            </div>
                            
                            <!-- Custom Date Inputs (Hidden by default or smaller) -->
                             <div class="col-md-3 mb-1 mb-md-0">
                                <label class="hud-label pl-1">Start / End</label>
                                <div class="d-flex">
                                     <input type="date" name="start_date" class="form-control form-control-sm filter-input-glass mr-1 p-1" 
                                           value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01') ?>">
                                     <input type="date" name="end_date" class="form-control form-control-sm filter-input-glass p-1" 
                                           value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d') ?>">
                                </div>
                            </div>
                            
                            <!-- Apply -->
                            <div class="col-md-2 text-right">
                                <label class="hud-label d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-sm btn-glass btn-block">
                                    <i class="fa fa-refresh"></i> Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Quick Filter Auto-Date Population
    document.getElementById('quick-filter').addEventListener('change', function() {
        const today = new Date();
        let startDate, endDate;
        
        switch(this.value) {
            case 'today':
                startDate = endDate = today.toISOString().split('T')[0];
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                startDate = endDate = yesterday.toISOString().split('T')[0];
                break;
            case 'this_week':
                const weekStart = new Date(today);
                weekStart.setDate(today.getDate() - today.getDay());
                startDate = weekStart.toISOString().split('T')[0];
                endDate = today.toISOString().split('T')[0];
                break;
            case 'this_month':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                endDate = today.toISOString().split('T')[0];
                break;
            case 'last_month':
                const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                startDate = lastMonth.toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), today.getMonth(), 0).toISOString().split('T')[0];
                break;
            default:
                return; // Custom - don't change dates
        }
        
        if(startDate && endDate) {
            document.querySelector('input[name="start_date"]').value = startDate;
            document.querySelector('input[name="end_date"]').value = endDate;
            document.getElementById('dashboard-filter-form').submit();
        }
    });
    </script>


    <!-- Vital Signs Monitor (Premium Redesign) -->
    <style>
        .vital-card {
            background: #ffffff;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--psy-shadow);
            border: 1px solid var(--psy-border);
        }
        .vital-icon-box {
            width: 50px; height: 50px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: #f1f5f9;
            box-shadow: none;
        }
        .heartbeat-anim { animation: heartbeat 2s ease-in-out infinite both; }
        @keyframes heartbeat {
            0% { transform: scale(1); }
            10% { transform: scale(1.1); }
            20% { transform: scale(1); }
            100% { transform: scale(1); }
        }
        .vital-progress-bg {
            height: 10px;
            background: #f1f5f9;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }
        .vital-progress-bar {
            height: 100%;
            border-radius: 5px;
            position: relative;
            transition: width 1.0s ease-out;
            box-shadow: none;
        }
    </style>
    <div class="col-12 mb-2">
        <?php 
        $health_score = isset($business_health['score']) ? $business_health['score'] : 85; 
        
        // Dynamic Color Logic
        if ($health_score >= 80) {
            $h_color = '#10b981'; // Emerald 500
            $h_bg = 'rgba(16, 185, 129, 0.2)';
            $h_text = 'OPTIMIZED';
            $h_icon = 'fa-heartbeat';
        } elseif ($health_score >= 60) {
            $h_color = '#f59e0b'; // Amber 500
            $h_bg = 'rgba(245, 158, 11, 0.2)';
            $h_text = 'STABLE';
            $h_icon = 'fa-medkit';
        } else {
            $h_color = '#ef4444'; // Red 500
            $h_bg = 'rgba(239, 68, 68, 0.2)';
            $h_text = 'CRITICAL';
            $h_icon = 'fa-exclamation-triangle';
        }
        ?>
        <div class="vital-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Left: Status & Icon -->
                <div class="d-flex align-items-center">
                    <div class="vital-icon-box mr-3" style="border: 1px solid var(--psy-border); color: <?= $h_color ?>;">
                        <i class="fa <?= $h_icon ?> font-large-1 heartbeat-anim"></i>
                    </div>
                    <div>
                        <h6 class="text-psy-value text-uppercase font-weight-bold mb-0" style="letter-spacing: 0.5px;">System Vital Signs</h6>
                        <span class="badge badge-pill mt-1" style="background: <?= $h_bg ?>; color: <?= $h_color ?>; border: 1px solid <?= $h_color ?>; font-weight: 600;">
                            <?= $h_text ?>
                        </span>
                    </div>
                </div>

                <!-- Center: Progress Bar -->
                <div class="flex-grow-1 mx-4 d-none d-md-block">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-psy-label font-small-3">Health Index Score</span>
                        <span class="font-weight-bold text-psy-value" style="font-size: 1.1rem; color: <?= $h_color ?> !important;"><?= $health_score ?>/100</span>
                    </div>
                    <div class="vital-progress-bg">
                        <div class="vital-progress-bar" style="width: <?= $health_score ?>%; background-color: <?= $h_color ?>; color: <?= $h_color ?>;"></div>
                    </div>
                </div>

                <!-- Right: Action -->
                <div>
                     <a href="#" class="btn btn-sm btn-white border">
                        <i class="fa fa-file-text-o mr-1"></i> Report
                    </a>
                </div>
            </div>
            <!-- Mobile Progress Bar Fallback -->
            <div class="d-block d-md-none mt-3">
                 <div class="d-flex justify-content-between mb-1">
                    <span class="text-psy-label font-small-3">Health Index Score</span>
                    <span class="font-weight-bold text-psy-value" style="font-size: 1.1rem; color: <?= $h_color ?> !important;"><?= $health_score ?>/100</span>
                </div>
                <div class="vital-progress-bg">
                    <div class="vital-progress-bar" style="width: <?= $health_score ?>%; background-color: <?= $h_color ?>; color: <?= $h_color ?>;"></div>
                </div>
            </div>
        </div>
    </div>


    
    <!-- Stock & Inventory Intelligence Section (Premium Redesign) -->
    <style>
        .stock-intel-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--psy-border);
            box-shadow: var(--psy-shadow);
            position: relative;
            overflow: hidden;
        }
        .stock-intel-header {
            background: #f8f9fa;
            border-bottom: 1px solid var(--psy-border);
            padding: 15px 20px;
        }
        .stock-metric-box {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--psy-border);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stock-metric-box:hover {
            transform: translateY(-2px);
            background: #fdfdfd;
            border-color: var(--psy-accent-primary);
            box-shadow: var(--psy-shadow);
        }
        .stock-metric-box.retail { border-bottom: 3px solid #0ea5e9; } /* Sky */
        .stock-metric-box.wholesale { border-bottom: 3px solid #f59e0b; } /* Amber */
        .stock-metric-box.cost { border-bottom: 3px solid #ef4444; } /* Red */

        .metric-icon-bg {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 80px;
            opacity: 0.05;
            color: var(--psy-text-primary);
            transform: rotate(-15deg);
        }
        .metric-value-lg { font-size: 1.8rem; font-weight: 700; color: var(--psy-text-primary); letter-spacing: -0.5px; }
        .metric-label-sm { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--psy-text-secondary); font-weight: 600; display: block; margin-bottom: 5px; } /* Increased from 0.75rem */
        
        .intel-panel {
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid var(--psy-border);
            height: 100%;
            transition: all 0.3s;
        }
        .intel-panel:hover { background: #ffffff; border-color: var(--psy-accent-primary); }
        .intel-panel.dead-stock { border-left: 4px solid #ef4444; }
        .intel-panel.fast-stock { border-left: 4px solid #10b981; }
        
        .glow-text { text-shadow: none; }
    </style>
    <div class="col-xl-12 col-lg-12">
        <div class="stock-intel-card mb-3">
            <div class="stock-intel-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-psy-value font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.2px;">
                    <i class="fa fa-cubes text-psy-highlight mr-2"></i>STOCK & INVENTORY INTELLIGENCE
                </h4>
                <span class="badge badge-pill badge-primary">REAL-TIME</span>
            </div>
            
            <div class="card-body p-3">
                <!-- Inventory Valuation Row -->
                <div class="row match-height mb-3">
                    <div class="col-12 mb-2">
                        <h6 class="text-psy-label font-small-3 text-uppercase" style="letter-spacing: 1px;">
                            <i class="fa fa-calculator mr-1"></i> Valuation Overview <small>(<?= date('M d, Y') ?>)</small>
                        </h6>
                    </div>
                    
                    <!-- Retail Value -->
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <div class="stock-metric-box retail">
                            <i class="fa fa-shopping-cart metric-icon-bg"></i>
                            <span class="metric-label-sm">Retail Value</span>
                            <div class="metric-value-lg text-info"><?= amountExchange($inventory_valuation['retail_value'], 0, $this->aauth->get_user()->loc) ?></div>
                            <p class="font-small-2 text-psy-muted mb-0 mt-1">Projected Market Return</p>
                        </div>
                    </div>
                    
                    <!-- Wholesale Value -->
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <div class="stock-metric-box wholesale">
                            <i class="fa fa-truck metric-icon-bg"></i>
                            <span class="metric-label-sm">Wholesale Value</span>
                            <div class="metric-value-lg text-warning"><?= amountExchange($inventory_valuation['wholesale_value'], 0, $this->aauth->get_user()->loc) ?></div>
                            <p class="font-small-2 text-psy-muted mb-0 mt-1">Bulk Price Baseline</p>
                        </div>
                    </div>
                    
                    <!-- Cost Value -->
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <div class="stock-metric-box cost">
                             <i class="fa fa-database metric-icon-bg"></i>
                            <span class="metric-label-sm">Asset Cost</span>
                            <div class="metric-value-lg text-danger"><?= amountExchange($inventory_valuation['cost_value'], 0, $this->aauth->get_user()->loc) ?></div>
                             <p class="font-small-2 text-psy-muted mb-0 mt-1">Capital Investment</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Panels -->
                <div class="row match-height">
                    <!-- Dead Stock -->
                    <div class="col-xl-6 col-12 mb-2">
                         <div class="intel-panel dead-stock p-3">
                             <?php
                                $dead_stock = isset($dead_stock_summary) ? $dead_stock_summary : array('dead_stock_value' => 0, 'dead_stock_count' => 0, 'slow_moving_count' => 0, 'slow_moving_value' => 0);
                                $ds_severity = ($dead_stock['dead_stock_value'] > 200000) ? 'text-danger' : 'text-warning';
                             ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="text-dark font-weight-bold mb-0">DEAD STOCK IDENTIFIER</h6>
                                    <span class="font-small-2 text-psy-secondary">Capital Stagnation Alert</span>
                                </div>
                                <div class="bg-light-danger rounded p-2">
                                    <i class="fa fa-archive text-danger font-medium-3"></i>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-6 border-right border-secondary">
                                    <span class="font-small-2 text-psy-label d-block">Stagnant Value</span>
                                    <h4 class="<?= $ds_severity ?> font-weight-bold mb-0"><?= amountExchange($dead_stock['dead_stock_value'], 0, $this->aauth->get_user()->loc) ?></h4>
                                </div>
                                <div class="col-6 pl-3">
                                    <span class="font-small-2 text-psy-label d-block">Idle SKU Count</span>
                                    <h4 class="text-dark font-weight-bold mb-0"><?= $dead_stock['dead_stock_count'] ?></h4>
                                </div>
                            </div>
                            
                            <div class="progress mb-2" style="height: 6px; background: #e2e8f0;">
                                <div class="progress-bar bg-danger" style="width: 35%"></div>
                            </div>
                             
                            <a href="<?= base_url('intelligence/dead_stock') ?>" class="btn btn-outline-danger btn-sm btn-block mt-2">
                                <i class="fa fa-list mr-1"></i> View Stagnation Report
                            </a>
                        </div>
                    </div>

                    <!-- Fast Moving -->
                    <div class="col-xl-6 col-12 mb-2">
                        <div class="intel-panel fast-stock p-3">
                             <?php
                                $fast_moving = isset($fast_moving_summary) ? $fast_moving_summary : array('fast_moving_value' => 0, 'fast_moving_count' => 0, 'total_sales' => 0, 'avg_sales_per_product' => 0);
                             ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="text-dark font-weight-bold mb-0">HIGH VELOCITY STOCK</h6>
                                    <span class="font-small-2 text-psy-secondary">Top Performance Vectors</span>
                                </div>
                                <div class="bg-success bg-lighten-4 rounded p-2">
                                    <i class="fa fa-rocket text-success font-medium-3"></i>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-6 border-right border-secondary">
                                    <span class="font-small-2 text-psy-label d-block">Active Value</span>
                                    <h4 class="text-success font-weight-bold mb-0"><?= amountExchange($fast_moving['fast_moving_value'], 0, $this->aauth->get_user()->loc) ?></h4>
                                </div>
                                <div class="col-6 pl-3">
                                    <span class="font-small-2 text-psy-label d-block">Sales Velocity</span>
                                    <h4 class="text-psy-value font-weight-bold mb-0"><?= number_format($fast_moving['avg_sales_per_product'], 1) ?> <small class="font-small-1">avg/p</small></h4>
                                </div>
                            </div>
                            
                            <div class="progress mb-2" style="height: 6px; background: rgba(255,255,255,0.1);">
                                <div class="progress-bar bg-success" style="width: 65%"></div>
                            </div>
                             
                            <a href="<?= base_url('intelligence/fast_moving_stock') ?>" class="btn btn-outline-success btn-sm btn-block mt-2">
                                <i class="fa fa-bolt mr-1"></i> View Performance Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Metrics Intelligence Section (Premium Redesign) -->
    <style>
        .fin-card {
            background: var(--psy-bg-card);
            border-radius: 16px;
            border: 1px solid var(--psy-border);
            box-shadow: var(--psy-shadow);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .fin-header {
            background: linear-gradient(90deg, #f8fafc 0%, #eff6ff 100%);
            border-bottom: 1px solid var(--psy-border);
            padding: 18px 24px;
        }
        
        /* KPI Boxes */
        .fin-kpi-box {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--psy-border);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .fin-kpi-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(30, 58, 138, 0.15);
            border-color: var(--psy-accent-primary);
        }
        .kpi-icon-bg {
            position: absolute;
            right: -10px;
            bottom: -15px;
            font-size: 70px;
            opacity: 0.04;
            color: var(--psy-text-primary);
            transform: rotate(-10deg);
            transition: all 0.3s ease;
        }
        .fin-kpi-box:hover .kpi-icon-bg {
            opacity: 0.08;
            transform: rotate(0deg) scale(1.1);
        }
        
        /* Liability Panels */
        .fin-liab-panel {
            background: #f8fafc;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--psy-border);
            height: 100%;
            position: relative;
            z-index: 1;
        }
        .fin-liab-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
            z-index: -1;
            border-radius: 12px;
        }
        
        /* Breakdown Lists */
        .fin-breakdown-list {
            padding: 24px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--psy-border);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .fin-breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px dotted var(--psy-border);
        }
        .fin-breakdown-item:last-child { border-bottom: none; }
        
        .prog-mini {
            height: 4px;
            border-radius: 2px;
            margin-top: 6px;
            background: #f1f5f9;
            overflow: hidden;
        }
        .prog-mini-bar {
            height: 100%;
            border-radius: 2px;
        }
        
        .glass-footer {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(0,0,0,0.05);
            padding: 15px;
            margin: 0 -24px -24px -24px;
            margin-top: auto;
        }
    </style>
    
    <div class="col-xl-12 col-lg-12">
        <div class="fin-card mb-4">
            <div class="fin-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-lighten-4 rounded-circle p-2 mr-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-calculator text-primary font-medium-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-psy-value font-weight-bold" style="font-size: 1.2rem; letter-spacing: -0.2px;">FINANCIAL METRICS INTELLIGENCE</h4>
                        <span class="font-small-2 text-psy-muted">Unified Liquidity & Cash Flow Analytics</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="badge badge-pill badge-glow badge-success px-2 py-1" style="font-weight: 600;">LIVE ANALYTICS</span>
                </div>
            </div>
            
            <div class="card-body p-4">
                <!-- Top Row: Core Financial KPIs -->
                <div class="row match-height mb-4">
                    <!-- Net Profit -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-kpi-box" style="border-top: 4px solid var(--psy-accent-success);">
                            <i class="fa fa-line-chart kpi-icon-bg"></i>
                            <span class="text-psy-label mb-1">Total Profit</span>
                            <h2 class="text-psy-success font-weight-bold mb-1"><?= amountExchange($todayprofit, 0, $this->aauth->get_user()->loc) ?></h2>
                            <div class="progress mt-2" style="height: 4px; background: #ecfdf5;">
                                <div class="progress-bar bg-success" style="width: 75%"></div>
                            </div>
                            <p class="font-small-2 text-psy-muted mt-2 mb-0">Target: <span class="text-dark font-weight-bold"><?= amountExchange($goals['netincome'], 0, $this->aauth->get_user()->loc) ?></span></p>
                        </div>
                    </div>
                    <!-- Net Cash Flow -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-kpi-box" style="border-top: 4px solid var(--psy-accent-primary);">
                            <i class="fa fa-exchange kpi-icon-bg"></i>
                            <span class="text-psy-label mb-1">Net Cash Flow</span>
                            <h2 class="text-psy-info font-weight-bold mb-1"><?= amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) ?></h2>
                            <div class="d-flex justify-content-between font-small-2 mt-2">
                                <span class="text-success"><i class="fa fa-caret-up"></i> In</span>
                                <span class="text-danger"><i class="fa fa-caret-down"></i> Out</span>
                            </div>
                            <div class="progress mt-1" style="height: 4px;">
                                <div class="progress-bar bg-success" style="width: 50%"></div>
                                <div class="progress-bar bg-danger" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Cash in Hand -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-kpi-box" style="border-top: 4px solid var(--psy-accent-warning);">
                             <i class="fa fa-money kpi-icon-bg"></i>
                            <span class="text-psy-label mb-1">Cash in Hand</span>
                            <h2 class="text-psy-warning font-weight-bold mb-1"><?= amountExchange($cash_in_hand, 0, $this->aauth->get_user()->loc) ?></h2>
                            <p class="font-small-2 text-psy-muted mt-auto mb-0"><i class="fa fa-shield mr-1"></i> Reserve Liquidity</p>
                        </div>
                    </div>
                    <!-- Bank Balance -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-kpi-box" style="border-top: 4px solid #6366f1;">
                            <i class="fa fa-university kpi-icon-bg"></i>
                            <span class="text-psy-label mb-1">Bank Balance</span>
                            <h2 style="color: #6366f1;" class="font-weight-bold mb-1"><?= amountExchange($bank_balance, 0, $this->aauth->get_user()->loc) ?></h2>
                            <p class="font-small-2 text-psy-muted mt-auto mb-0"><i class="fa fa-check-circle mr-1"></i> Digital Clearance</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Income Breakdown -->
                    <div class="col-xl-6 col-12 mb-3">
                        <div class="fin-breakdown-list h-100" style="border-left: 5px solid var(--psy-accent-success); border-radius: 12px;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="text-psy-success font-weight-bold mb-0 text-uppercase tracking-wider">
                                    <i class="fa fa-level-up mr-2"></i> Income Vectors
                                </h6>
                                <i class="fa fa-ellipsis-h text-muted"></i>
                            </div>
                            
                            <?php 
                            $inc_total = max($financial_metrics['income']['Total'], 1);
                            $inc_data = [
                                ['label' => 'Cash', 'val' => $financial_metrics['income']['Cash'], 'color' => 'bg-success', 'icon' => 'fa-money'],
                                ['label' => 'Bank', 'val' => $financial_metrics['income']['Bank'], 'color' => 'bg-info', 'icon' => 'fa-university'],
                                ['label' => 'Cheque', 'val' => $financial_metrics['income']['Cheque'], 'color' => 'bg-warning', 'icon' => 'fa-pencil-square-o']
                            ];
                            foreach($inc_data as $item):
                                $pct = ($item['val'] / $inc_total) * 100;
                            ?>
                            <div class="fin-breakdown-item">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-psy-muted font-small-3"><i class="fa <?= $item['icon'] ?> mr-2"></i> <?= $item['label'] ?></span>
                                        <span class="text-dark font-weight-bold font-small-3"><?= amountExchange($item['val'], 0, $this->aauth->get_user()->loc) ?></span>
                                    </div>
                                    <div class="prog-mini">
                                        <div class="prog-mini-bar <?= $item['color'] ?>" style="width: <?= $pct ?>%"></div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <div class="glass-footer d-flex justify-content-between align-items-center">
                                <span class="text-psy-success font-small-2 font-weight-bold">AGGR REVENUE</span>
                                <span class="text-psy-success font-large-1 font-weight-bold"><?= amountExchange($financial_metrics['income']['Total'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Expense Breakdown -->
                    <div class="col-xl-6 col-12 mb-3">
                        <div class="fin-breakdown-list h-100" style="border-left: 5px solid var(--psy-accent-primary); border-radius: 12px;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="text-psy-info font-weight-bold mb-0 text-uppercase tracking-wider">
                                    <i class="fa fa-level-down mr-2"></i> Outflow Dynamics
                                </h6>
                                <i class="fa fa-ellipsis-h text-muted"></i>
                            </div>

                            <?php 
                            $exp_total = max($financial_metrics['expense']['Total'], 1);
                            $exp_data = [
                                ['label' => 'Cash', 'val' => $financial_metrics['expense']['Cash'], 'color' => 'bg-danger', 'icon' => 'fa-money'],
                                ['label' => 'Bank', 'val' => $financial_metrics['expense']['Bank'], 'color' => 'bg-info', 'icon' => 'fa-university'],
                                ['label' => 'Cheque', 'val' => $financial_metrics['expense']['Cheque'], 'color' => 'bg-warning', 'icon' => 'fa-pencil-square-o']
                            ];
                            foreach($exp_data as $item):
                                $pct = ($item['val'] / $exp_total) * 100;
                            ?>
                            <div class="fin-breakdown-item">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-psy-muted font-small-3"><i class="fa <?= $item['icon'] ?> mr-2"></i> <?= $item['label'] ?></span>
                                        <span class="text-dark font-weight-bold font-small-3"><?= amountExchange($item['val'], 0, $this->aauth->get_user()->loc) ?></span>
                                    </div>
                                    <div class="prog-mini">
                                        <div class="prog-mini-bar <?= $item['color'] ?>" style="width: <?= $pct ?>%"></div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <div class="glass-footer d-flex justify-content-between align-items-center">
                                <span class="text-psy-info font-small-2 font-weight-bold">AGGR OUTFLOW</span>
                                <span class="text-psy-info font-large-1 font-weight-bold"><?= amountExchange($financial_metrics['expense']['Total'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Receivables / Payables -->
                <div class="row match-height mt-3">
                    <div class="col-xl-6 col-12 mb-2">
                        <div class="fin-liab-panel shadow-sm" style="border-right: 4px solid var(--psy-accent-primary); border-radius: 16px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="text-info font-weight-bold mb-0">RECEIVABLES</h6>
                                    <span class="font-small-1 text-psy-muted">Awaiting Settlement</span>
                                </div>
                                <span class="badge badge-primary bg-lighten-4 text-info font-small-1 px-2 py-1">COLLECTION</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="text-psy-value font-weight-bold mb-0"><?= amountExchange($customer_due, 0, $this->aauth->get_user()->loc) ?></h2>
                                <div class="btn-group shadow-sm">
                                    <a href="<?= base_url('invoices?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-white text-info border-right"><i class="fa fa-file-text"></i></a>
                                    <a href="<?= base_url('pos_invoices?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-white text-primary"><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12 mb-2">
                        <div class="fin-liab-panel shadow-sm" style="border-right: 4px solid var(--psy-accent-danger); border-radius: 16px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="text-danger font-weight-bold mb-0">PAYABLES</h6>
                                    <span class="font-small-1 text-psy-muted">Outstanding Obligations</span>
                                </div>
                                <span class="badge badge-danger bg-lighten-4 text-danger font-small-1 px-2 py-1">LIABILITY</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="text-psy-value font-weight-bold mb-0"><?= amountExchange($supplier_due, 0, $this->aauth->get_user()->loc) ?></h2>
                                <div class="btn-group shadow-sm">
                                    <a href="<?= base_url('purchase?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-white text-danger border-right"><i class="fa fa-truck"></i></a>
                                    <a href="<?= base_url('purchase/list?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-white text-dark"><i class="fa fa-cubes"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Advanced Accounting Section (Dual Entry) -->
    <style>
        .acc-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--psy-border);
            box-shadow: 0 10px 30px rgba(30,58,138,0.05);
            position: relative;
            overflow: hidden;
            margin-bottom: 2.5rem;
        }
        .acc-header {
            background: linear-gradient(to right, #ffffff, #f1f5f9);
            border-bottom: 1px solid var(--psy-border);
            padding: 24px;
        }
        .acc-balance-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .acc-balance-box {
            flex: 1;
            min-width: 200px;
            background: #ffffff;
            border-radius: 14px;
            padding: 28px 20px;
            border: 1px solid var(--psy-border);
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .acc-balance-box:hover {
            transform: translateY(-5px);
            border-color: var(--psy-accent-primary);
            box-shadow: 0 15px 25px -5px rgba(30, 58, 138, 0.1);
        }
        .acc-balance-box::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            border-radius: 14px 14px 0 0;
        }
        .acc-balance-box.assets::after { background: var(--psy-accent-success); }
        .acc-balance-box.liabilities::after { background: var(--psy-accent-danger); }
        .acc-balance-box.equity::after { background: var(--psy-accent-primary); }
        
        .journal-table-container {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        .journal-table { width: 100%; font-size: 0.9rem; border-collapse: separate; border-spacing: 0; }
        .journal-table th { 
            background: #f8fafc; 
            color: #64748b; 
            font-weight: 600; 
            padding: 16px 20px; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 1px;
            border-bottom: 2px solid #edf2f7;
        }
        .journal-table td { 
            padding: 18px 20px; 
            border-bottom: 1px solid #f8fafc; 
            vertical-align: middle; 
            color: var(--psy-text-primary);
            transition: background 0.2s;
        }
        .journal-table tr:hover td { background: #f0f7ff; }
        .journal-table tr:last-child td { border-bottom: none; }
        
        .journal-badge { 
            padding: 5px 12px; 
            border-radius: 6px; 
            font-weight: 700; 
            font-size: 0.8rem; 
            display: inline-block; 
            min-width: 80px; 
            text-align: right; 
        }
        .journal-badge.cr { background: #ecfdf5; color: #059669; border: 1px solid #d1fae5; }
        .journal-badge.dr { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
    </style>
    
    <div class="col-xl-12 col-lg-12">
        <div class="acc-card">
            <div class="acc-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-lighten-4 rounded p-2 mr-3">
                        <i class="fa fa-book text-info font-medium-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-psy-value font-weight-bold" style="font-size: 1.2rem; letter-spacing: -0.2px;">ADVANCED ACCOUNTING & LEDGER</h4>
                        <span class="font-small-2 text-psy-muted">Automated Dual Entry Core</span>
                    </div>
                </div>
                <span class="badge badge-pill badge-primary px-3 py-1">DUAL ENTRY SYSTEM</span>
            </div>
            
            <div class="card-body p-4">
                <!-- Financial Position Summary -->
                <div class="d-flex align-items-center mb-4">
                    <div style="width: 30px; height: 1px; background: var(--psy-accent-primary); margin-right: 15px;"></div>
                    <h6 class="text-psy-label text-uppercase mb-0 tracking-widest">Statement of Condition</h6>
                </div>
                
                <div class="acc-balance-container">
                    <div class="acc-balance-box assets">
                        <span class="font-small-2 text-psy-muted text-uppercase mb-2 d-block">Total Assets</span>
                        <h3 class="text-psy-success font-weight-bold mb-1"><?= amountExchange($financial_position['assets'], 0, $this->aauth->get_user()->loc) ?></h3>
                        <div class="badge badge-success bg-lighten-4 text-success font-small-1">CONTROLLED ASSETS</div>
                    </div>
                    <div class="acc-balance-box liabilities">
                        <span class="font-small-2 text-psy-muted text-uppercase mb-2 d-block">Total Liabilities</span>
                        <h3 class="text-psy-danger font-weight-bold mb-1"><?= amountExchange($financial_position['liabilities'], 0, $this->aauth->get_user()->loc) ?></h3>
                        <div class="badge badge-danger bg-lighten-4 text-danger font-small-1">OBLIGATIONS</div>
                    </div>
                    <div class="acc-balance-box equity">
                        <span class="font-small-2 text-psy-muted text-uppercase mb-2 d-block">Equity (Net Worth)</span>
                        <h3 class="text-psy-info font-weight-bold mb-1"><?= amountExchange($financial_position['equity'], 0, $this->aauth->get_user()->loc) ?></h3>
                        <div class="badge badge-primary bg-lighten-4 text-info font-small-1">RETAINED VALUE</div>
                    </div>
                </div>
                
                <!-- Recent Journal Entries -->
                <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
                    <div class="d-flex align-items-center">
                        <div style="width: 30px; height: 1px; background: var(--psy-accent-primary); margin-right: 15px;"></div>
                        <h6 class="text-psy-label text-uppercase mb-0 tracking-widest">Recent Journal Entries</h6>
                    </div>
                    <a href="<?= base_url('transactions') ?>" class="btn btn-sm btn-link text-primary font-weight-bold">View Ledger <i class="fa fa-angle-right"></i></a>
                </div>

                <div class="journal-table-container">
                    <table class="journal-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Account Mapping</th>
                                <th>Narrative</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($recent_journal_entries) && !empty($recent_journal_entries)): ?>
                                <?php foreach($recent_journal_entries as $entry): ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark"><?= date('M d, Y', strtotime($entry['date'])) ?></div>
                                        <div class="font-small-1 text-muted"><?= date('h:i A', strtotime($entry['date'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2 rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fa fa-folder-open-o text-muted font-small-2"></i>
                                            </div>
                                            <div>
                                                <div class="text-dark font-weight-bold font-small-3"><?= isset($entry['account_name']) ? $entry['account_name'] : '-' ?></div>
                                                <div class="font-small-1 text-muted">ID: <?= isset($entry['account_number']) ? $entry['account_number'] : '#' . $entry['acid'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="font-small-2 text-psy-muted" style="max-width: 250px;"><?= $entry['note'] ?></td>
                                    <td class="text-right">
                                        <?php if($entry['debit'] > 0): ?>
                                            <div class="journal-badge dr"><?= amountExchange($entry['debit'], 0, $this->aauth->get_user()->loc) ?></div>
                                        <?php else: ?>
                                            <span class="text-muted font-small-3">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <?php if($entry['credit'] > 0): ?>
                                            <div class="journal-badge cr"><?= amountExchange($entry['credit'], 0, $this->aauth->get_user()->loc) ?></div>
                                        <?php else: ?>
                                            <span class="text-muted font-small-3">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center p-5">
                                        <i class="fa fa-inbox font-large-2 text-muted mb-2 d-block"></i>
                                        <div class="text-muted">No accounting movement detected for the current period.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Strategic Business Analysis Section (Indicators) -->
    <style>
        .strat-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--psy-border);
            box-shadow: var(--psy-shadow);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .strat-header {
            background: #f8f9fa;
            border-bottom: 1px solid var(--psy-border);
            padding: 15px 20px;
        }
        .strat-indicator-box {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--psy-border);
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }
        .strat-indicator-box:hover {
            transform: translateY(-3px);
            box-shadow: var(--psy-shadow);
            border-color: var(--psy-accent-primary);
        }
        .indicator-value { font-size: 1.8rem; font-weight: 700; color: var(--psy-text-primary); line-height: 1.2; }
        .indicator-label { font-size: 0.8rem; text-transform: uppercase; color: var(--psy-text-secondary); letter-spacing: 0.5px; font-weight: 600; margin-bottom: 10px; display: block; }
        .indicator-sub { font-size: 0.75rem; color: var(--psy-muted); margin-top: 5px; display: block; }
        
        .indicator-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 5px;
        }
        .badge-good { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-warn { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge-crit { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
    </style>

    <div class="col-xl-12 col-lg-12">
        <div class="strat-card">
             <div class="strat-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-psy-value font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.2px;">
                    <i class="fa fa-crosshairs text-psy-highlight mr-2"></i>STRATEGIC BUSINESS ANALYSIS
                </h4>
                <span class="badge badge-pill badge-warning">KEY RATIOS</span>
            </div>
            
            <div class="card-body p-4">
                <div class="row match-height">
                    <!-- Net Profit Margin -->
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="strat-indicator-box">
                            <span class="indicator-label"><i class="fa fa-percent mr-1"></i> Net Profit Margin</span>
                            <?php 
                                $margin = isset($strategic_indicators['net_profit_margin']) ? $strategic_indicators['net_profit_margin'] : 0;
                                $m_class = ($margin > 20) ? 'badge-good' : (($margin > 10) ? 'badge-warn' : 'badge-crit');
                                $m_text = ($margin > 20) ? 'Healthy' : (($margin > 10) ? 'Monitor' : 'Critical');
                            ?>
                            <div class="indicator-value text-dark"><?= number_format($margin, 1) ?>%</div>
                            <span class="indicator-badge <?= $m_class ?>"><?= $m_text ?></span>
                            <span class="indicator-sub">Profit per sales unit</span>
                        </div>
                    </div>
                    
                    <!-- Current Ratio -->
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="strat-indicator-box">
                            <span class="indicator-label"><i class="fa fa-balance-scale mr-1"></i> Liquidity Ratio</span>
                             <?php 
                                $cr = isset($strategic_indicators['current_ratio']) ? $strategic_indicators['current_ratio'] : 0;
                                $c_class = ($cr > 1.5) ? 'badge-good' : (($cr > 1.0) ? 'badge-warn' : 'badge-crit');
                                $c_text = ($cr > 1.5) ? 'Strong' : (($cr > 1.0) ? 'Stable' : 'Risk');
                            ?>
                            <div class="indicator-value text-dark"><?= number_format($cr, 2) ?></div>
                             <span class="indicator-badge <?= $c_class ?>"><?= $c_text ?></span>
                            <span class="indicator-sub">Assets covering liabilities</span>
                        </div>
                    </div>
                    
                    <!-- ROE -->
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="strat-indicator-box">
                             <span class="indicator-label"><i class="fa fa-line-chart mr-1"></i> Return on Equity</span>
                             <?php 
                                $roe = isset($strategic_indicators['roe']) ? $strategic_indicators['roe'] : 0;
                            ?>
                            <div class="indicator-value text-primary"><?= number_format($roe, 1) ?>%</div>
                            <span class="indicator-sub">Return on owner investment</span>
                        </div>
                    </div>
                    
                    <!-- AOV -->
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="strat-indicator-box">
                             <span class="indicator-label"><i class="fa fa-shopping-cart mr-1"></i> Avg Order Value</span>
                             <?php 
                                $aov = isset($strategic_indicators['avg_order_value']) ? $strategic_indicators['avg_order_value'] : 0;
                            ?>
                            <div class="indicator-value text-success"><?= amountExchange($aov, 0, $this->aauth->get_user()->loc) ?></div>
                            <span class="indicator-sub">Revenue per invoice</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- System Intelligence Engine (Payroll & Carpentry) -->
    <style>
        .system-intel-engine { background: #0f172a; border-radius: 20px; color: #f8fafc; overflow: hidden; position: relative; }
        .system-intel-engine::before { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899); }
        .intel-monitor { background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(51, 65, 85, 0.5); border-radius: 12px; padding: 15px; transition: all 0.3s ease; }
        .intel-monitor:hover { border-color: #3b82f6; background: rgba(30, 41, 59, 0.9); }
        .glow-text-info { text-shadow: 0 0 10px rgba(59, 130, 246, 0.5); color: #60a5fa; }
        .glow-text-success { text-shadow: 0 0 10px rgba(34, 197, 94, 0.5); color: #4ade80; }
        .glow-text-warning { text-shadow: 0 0 10px rgba(245, 158, 11, 0.5); color: #fbbf24; }
        .glow-text-danger { text-shadow: 0 0 10px rgba(239, 68, 68, 0.5); color: #f87171; }
        .metric-label { font-size: 10px; text-uppercase: uppercase; letter-spacing: 1px; color: #94a3b8; font-weight: 600; }
        .dept-tag { padding: 2px 8px; border-radius: 4px; background: rgba(59, 130, 246, 0.2); color: #93c5fd; font-size: 11px; margin-right: 5px; margin-bottom: 5px; display: inline-block; }
    </style>
    
    <!-- System Intelligence Engine (Premium Redesign) -->
    <style>
        .sys-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--psy-border);
            box-shadow: var(--psy-shadow);
            position: relative;
            overflow: hidden;
        }
        .sys-header {
            background: #f8f9fa;
            border-bottom: 1px solid var(--psy-border);
            padding: 15px 20px;
        }
        
        /* HUD Panels */
        .sys-hud-panel {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--psy-border);
            height: 100%;
            position: relative;
        }
        
        .metric-label-hud {
            font-size: 0.75rem; /* Increased from 0.7rem */
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--psy-text-secondary);
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        /* Progress Bars */
        .progress-hud {
            height: 6px;
            background: #f1f5f9;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .dept-tag {
            background: #f1f5f9;
            border: 1px solid var(--psy-border);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            color: var(--psy-text-secondary);
            font-weight: 500;
        }
    </style>

    <div class="col-xl-12 col-lg-12 mb-3">
        <div class="sys-card mt-2">
            <div class="sys-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-psy-value font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                    <i class="fa fa-microchip text-info mr-2"></i>SYSTEM INTELLIGENCE ENGINE
                </h4>
                <div class="d-flex align-items-center">
                    <span class="badge badge-pill badge-info mr-2">V2.0 PRO</span>
                    <span class="status-dot bg-success mr-1"></span> <small class="text-success font-weight-bold" style="letter-spacing: 1px; font-size: 0.65rem;">ONLINE</small>
                </div>
            </div>
            
            <div class="card-body p-3">
                <div class="row match-height">
                    <!-- Payroll Intelligence HUD -->
                    <div class="col-xl-6 col-lg-12 mb-2">
                        <div class="sys-hud-panel" style="border-left: 2px solid #06b6d4;">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h6 class="text-info font-weight-bold mb-0" style="letter-spacing: 0.5px;"><i class="fa fa-users mr-1"></i> PAYROLL INTELLIGENCE</h6>
                                    <p class="font-small-1 text-psy-muted mb-0 mt-1">Monthly Liability & Compliance Flow</p>
                                </div>
                                <div class="text-right">
                                    <span class="metric-label-hud">Cycle Status</span>
                                    <div class="badge badge-pill <?= ($payroll_intel['pending_approvals'] > 0) ? 'badge-warning' : 'badge-success' ?> mt-1">
                                        <?= ($payroll_intel['pending_approvals'] > 0) ? '<i class="fa fa-exclamation-circle"></i> PENDING AUDIT' : '<i class="fa fa-check-circle"></i> SYNCHRONIZED' ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-6 border-right border-light">
                                    <span class="metric-label-hud">Est. Gross Payout</span>
                                    <h3 class="text-info font-weight-bold mb-0"><?= amountExchange($payroll_intel['monthly_gross'], 0, $this->aauth->get_user()->loc) ?></h3>
                                    <small class="text-psy-muted font-small-1"><?= date('F Y') ?> Projection</small>
                                </div>
                                <div class="col-6 pl-3">
                                    <span class="metric-label-hud">Approval Queue</span>
                                    <h3 class="text-warning font-weight-bold mb-0"><?= $payroll_intel['pending_approvals'] ?> <small class="font-small-3">RUNS</small></h3>
                                    <small class="text-psy-muted font-small-1">Awaiting Executive Action</small>
                                </div>
                            </div>
                            
                            <div class="pt-2 border-top border-light">
                                <span class="metric-label-hud mb-3">Resource Cost Distribution</span>
                                <?php if(!empty($payroll_intel['dept_distribution'])): ?>
                                    <?php foreach($payroll_intel['dept_distribution'] as $dept): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="dept-tag"><?= $this->intelligence_model->get_dept_name($dept['dept']) ?></span>
                                            <span class="font-small-2 font-weight-bold text-info"><?= amountExchange($dept['total_gross'], 0, $this->aauth->get_user()->loc) ?></span>
                                        </div>
                                        <div class="progress progress-hud mb-3">
                                            <?php 
                                            $total_g = $payroll_intel['monthly_gross'] > 0 ? $payroll_intel['monthly_gross'] : 1;
                                            $pct = ($dept['total_gross'] / $total_g) * 100;
                                            ?>
                                            <div class="progress-bar bg-info" style="width: <?= $pct ?>%"></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="font-small-2 text-psy-muted italic text-center py-2">Awaiting payroll data for current cycle...</p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mt-3">
                                <a href="<?= base_url('payrollprocessing') ?>" class="btn btn-sm btn-outline-info btn-block shadow-none" style="border-style: dashed;">
                                    LAUNCH PAYROLL CONTROL MODULE <i class="fa fa-external-link ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>

</div>
    <!-- Sales Analytics & Recent Buyers (Premium Redesign) -->
    <style>
        .analytics-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--psy-border);
            box-shadow: var(--psy-shadow);
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        /* Mini Stat Tiles */
        .stat-tile-mini {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            border: 1px solid var(--psy-border);
            transition: all 0.3s ease;
        }
        .stat-tile-mini:hover {
            transform: translateY(-2px);
            background: #fdfdfd;
            border-color: var(--psy-accent-primary);
        }
        .stat-label { font-size: 0.75rem; text-transform: uppercase; color: var(--psy-text-secondary); letter-spacing: 1px; font-weight: 600; } /* Increased from 0.7rem */
        
        /* Recent Buyers List */
        .buyer-item {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 8px;
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        .buyer-item:hover {
            background: #f8f9fa;
            border-color: var(--psy-border);
            text-decoration: none;
        }
        .avatar-glow {
            position: relative;
            display: inline-block;
        }
        .avatar-glow img {
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .buyer-name { color: var(--psy-text-primary); font-weight: 600; font-size: 0.9rem; }
        .buyer-amt { color: var(--psy-accent-primary); font-weight: 700; }
        
        .badge-outline-success { border: 1px solid #10b981; color: #10b981; background: #ecfdf5; }
        .badge-outline-warning { border: 1px solid #f59e0b; color: #f59e0b; background: #fffbeb; }
        .badge-outline-danger { border: 1px solid #ef4444; color: #ef4444; background: #fef2f2; }
    </style>

    <div class="row match-height">
        <!-- Sales Analytics Chart -->
        <div class="col-xl-8 col-lg-12 mb-3">
            <div class="analytics-card">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 pb-2">
                    <div>
                        <h4 class="mb-0 text-psy-value font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                            <i class="fa fa-line-chart text-warning mr-2"></i>SALES ANALYTICS
                        </h4>
                        <p class="font-small-1 text-psy-muted mb-0 mt-1"><?php echo $this->lang->line('in_last _30') ?></p>
                    </div>
                    <div>
                         <a data-action="reload" class="btn btn-sm btn-outline-secondary border-0"><i class="ft-rotate-cw"></i></a>
                    </div>
                </div>
                
                <div class="card-content">
                    <div class="card-body pt-0">
                        <div id="products-sales" class="height-300"></div>
                    </div>
                    
                    <div class="p-3 border-top border-light" style="background: #f8f9fa;">
                        <div class="row">
                            <!-- Income -->
                            <div class="col-xl-3 col-lg-6 col-12 mb-2 mb-xl-0">
                                <div class="stat-tile-mini">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="stat-label">Income</span>
                                        <i class="fa fa-arrow-up text-success"></i>
                                    </div>
                                    <h4 class="text-psy-value font-weight-bold mb-1"><?= amountExchange($todayinexp['credit'], 0, $this->aauth->get_user()->loc) ?></h4>
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                    </div>
                                    <small class="text-psy-muted font-small-1 mt-1 d-block">Today's Inflow</small>
                                </div>
                            </div>
                            <!-- Expense -->
                            <div class="col-xl-3 col-lg-6 col-12 mb-2 mb-xl-0">
                                <div class="stat-tile-mini">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="stat-label">Expense</span>
                                        <i class="fa fa-arrow-down text-danger"></i>
                                    </div>
                                    <h4 class="text-psy-value font-weight-bold mb-1"><?= amountExchange($todayinexp['debit'], 0, $this->aauth->get_user()->loc) ?></h4>
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 40%"></div>
                                    </div>
                                    <small class="text-psy-muted font-small-1 mt-1 d-block">Today's Outflow</small>
                                </div>
                            </div>
                            <!-- Profit -->
                            <div class="col-xl-3 col-lg-6 col-12 mb-2 mb-xl-0">
                                <div class="stat-tile-mini" style="border-color: rgba(16, 185, 129, 0.2); background: rgba(16, 185, 129, 0.05);">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="stat-label text-success">Profit</span>
                                        <i class="fa fa-trophy text-success"></i>
                                    </div>
                                    <h4 class="text-main-green font-weight-bold mb-1"><?= amountExchange($todayprofit, 0, $this->aauth->get_user()->loc) ?></h4>
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%; box-shadow: 0 0 5px rgba(16,185,129,0.5);"></div>
                                    </div>
                                    <small class="text-success font-small-1 mt-1 d-block">Net Gain</small>
                                </div>
                            </div>
                            <!-- Revenue -->
                            <div class="col-xl-3 col-lg-6 col-12">
                                <div class="stat-tile-mini">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="stat-label">Revenue</span>
                                        <i class="fa fa-pie-chart text-info"></i>
                                    </div>
                                    <h4 class="text-psy-value font-weight-bold mb-1"><?= amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) ?></h4>
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 35%"></div>
                                    </div>
                                    <small class="text-psy-muted font-small-1 mt-1 d-block">Total Volume</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Buyers List -->
        <div class="col-xl-4 col-lg-12 mb-3">
            <div class="analytics-card">
                <div class="card-header bg-transparent border-bottom border-light d-flex justify-content-between align-items-center pt-3 pb-2">
                    <div>
                        <h4 class="mb-0 text-dark font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                            <i class="fa fa-shopping-bag text-danger mr-2"></i>RECENT BUYERS
                        </h4>
                        <p class="font-small-1 text-psy-muted mb-0 mt-1">Live Transaction Feed</p>
                    </div>
                    <a data-action="reload" class="btn btn-sm btn-outline-secondary border-0"><i class="ft-rotate-cw"></i></a>
                </div>
                
                <div class="card-content px-3 pb-3">
                    <div id="recent-buyers" class="media-list height-450 mt-1 position-relative custom-scroll">
                        <?php
                        if (isset($recent_buy[0]['csd'])) {
                            foreach ($recent_buy as $item) {
                                $status_class = 'badge-outline-success';
                                if($item['status'] == 'pending') $status_class = 'badge-outline-warning';
                                if($item['status'] == 'canceled') $status_class = 'badge-outline-danger';
                                
                                echo '
                                <a href="' . base_url('customers/view?id=' . $item['csd']) . '" class="buyer-item text-decoration-none">
                                    <div class="mr-3 avatar-glow">
                                        <img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $item['picture'] . '" width="45" height="45" alt="User">
                                    </div>
                                    <div class="media-body w-100">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 buyer-name">' . $item['name'] . '</h6>
                                            <span class="buyer-amt">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-pill font-small-1 ' . $status_class . '">' . $this->lang->line(ucwords($item['status'])) . '</span>
                                            <small class="text-psy-muted font-small-1"><i class="fa fa-clock-o"></i> Just now</small>
                                        </div>
                                    </div>
                                </a>';
                            }
                        } elseif ($recent_buy == 'sql') {
                            echo '<div class="alert alert-danger mb-2" role="alert"><i class="fa fa-exclamation-triangle mr-1"></i> Critical SQL Strict Mode Error. Please disable strict mode.</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Consolidated Premium Widget Styles -->
    <style>
        /* Shared Container Styles */
        .premium-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--psy-border);
            box-shadow: var(--psy-shadow);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        /* Loss Control Specific Red Theme Override */
        .premium-card.loss-control {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            box-shadow: var(--psy-shadow);
        }

        /* Common Glass Panels -> Clean Panels */
        .glass-panel, .staff-panel, .heatmap-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--psy-border);
            transition: all 0.3s ease;
        }

        /* Branch Heatmap Specifics */
        .heatmap-item { cursor: pointer; position: relative; overflow: hidden; background: #ffffff; }
        .heatmap-item:hover { transform: translateY(-3px); box-shadow: var(--psy-shadow); }
        .geo-marker { position: absolute; top: 10px; right: 10px; opacity: 0.1; font-size: 3rem; color: var(--psy-text-primary); }
        
        /* Heatmap Status Colors */
        .heat-critical { border-left: 4px solid #ef4444 !important; }
        .heat-warning { border-left: 4px solid #f59e0b !important; }
        .heat-good { border-left: 4px solid #38bdf8 !important; }
        .heat-excellent { border-left: 4px solid #10b981 !important; }

        /* Staff Intelligence Specifics */
        .fraud-alert-panel {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            position: relative;
            height: 100%;
        }
        .digital-monitor {
            background: #f0f9ff;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #bae6fd;
            font-family: 'Courier New', monospace;
            color: #0284c7;
            margin-top: 10px;
        }

        /* Loss Control Specifics */
        .loss-header {
            background: #fef2f2;
            border-bottom: 1px solid #fecaca;
            padding: 15px;
        }
        .hud-ring {
            width: 120px; height: 120px; border-radius: 50%; margin: 0 auto;
            position: relative; display: flex; align-items: center; justify-content: center;
            border: 4px solid #e2e8f0;
            background: #ffffff;
        }
        .hud-content { z-index: 2; text-align: center; }
        .loss-counter { font-family: 'Courier New', monospace; letter-spacing: 2px; color: #dc2626; }
        
        /* Alert States */
        .alert-safe { border-color: #4ade80; }
        .alert-warning { border-color: #fbbf24; }
        .alert-danger { border-color: #f87171; }

        /* Cashflow Specifics */
        .nav-pills-neon { background: #f1f5f9; padding: 5px; border-radius: 30px; border: 1px solid var(--psy-border); }
        .nav-pills-neon .nav-link {
            border-radius: 25px; color: var(--psy-text-secondary); border: 1px solid transparent; transition: all 0.3s ease;
            font-weight: 600; text-transform: uppercase; letter-spacing: 1px; padding: 8px 20px;
        }
        .nav-pills-neon .nav-link.active {
            background: #ffffff; color: var(--psy-accent-primary); border-color: var(--psy-border); box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .chart-grid-bg {
            background-color: #ffffff;
            border-radius: 10px; padding: 10px;
        }
    </style>

    <!-- Staff Intelligence Widget -->
    <div class="col-xl-12 col-lg-12 mb-4">
        <div class="premium-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 text-dark font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                    <i class="fa fa-users text-info mr-2"></i>STAFF INTELLIGENCE NETWORK
                </h4>
                <span class="badge badge-pill badge-primary">AI DRIVEN</span>
            </div>
            
            <div class="row match-height">
                <!-- Trust Analytics -->
                <div class="col-xl-4 col-md-6 col-12 mb-3">
                    <div class="staff-panel">
                        <h6 class="text-psy-label text-uppercase font-small-3 mb-3" style="letter-spacing: 1px;"><i class="fa fa-shield text-success mr-1"></i> Trust Scores</h6>
                        <?php if(isset($staff_scores_list) && !empty($staff_scores_list)): ?>
                            <?php foreach(array_slice($staff_scores_list, 0, 3) as $staff): 
                                $color = ($staff['trust_score'] > 80) ? 'success' : (($staff['trust_score'] > 50) ? 'warning' : 'danger');
                            ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-dark font-weight-bold"><i class="fa fa-circle text-<?= $color ?> font-small-1 mr-1"></i> <?= $staff['username'] ?></span>
                                    <span class="text-<?= $color ?> font-weight-bold"><?= round($staff['trust_score']) ?>%</span>
                                </div>
                                <div class="progress" style="height: 6px; background: #f1f5f9;">
                                    <div class="progress-bar bg-<?= $color ?>" style="width: <?= $staff['trust_score'] ?>%;"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4 text-psy-muted">No active staff data</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Behaviour Engine -->
                <div class="col-xl-4 col-md-6 col-12 mb-3">
                    <div class="staff-panel">
                        <h6 class="text-psy-label text-uppercase font-small-3 mb-3" style="letter-spacing: 1px;"><i class="fa fa-microchip text-info mr-1"></i> Behavior Metrics</h6>
                        <?php 
                            $total_overrides = isset($staff_scores_list) ? array_sum(array_column($staff_scores_list, 'overrides')) : 0;
                            $adj_freq = isset($loss_stats['stock_leak']['count']) ? $loss_stats['stock_leak']['count'] : 0;
                            $canceled_bills_pct = isset($loss_stats['billing_error']['percentage']) ? $loss_stats['billing_error']['percentage'] : 0;
                        ?>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between align-items-center mb-2 p-2" style="background: #ffffff; border-radius: 8px; border: 1px solid var(--psy-border);">
                                <span class="text-dark font-small-3"><i class="fa fa-tags text-warning mr-2"></i>Price Overrides</span>
                                <span class="badge badge-warning text-white"><?= $total_overrides ?></span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center mb-2 p-2" style="background: #ffffff; border-radius: 8px; border: 1px solid var(--psy-border);">
                                <span class="text-dark font-small-3"><i class="fa fa-cubes text-info mr-2"></i>Stock Adjustments</span>
                                <span class="badge badge-info text-white"><?= $adj_freq ?></span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center p-2" style="background: #ffffff; border-radius: 8px; border: 1px solid var(--psy-border);">
                                <span class="text-dark font-small-3"><i class="fa fa-file-excel-o text-danger mr-2"></i>Cancel Rate</span>
                                <span class="badge badge-danger text-white"><?= $canceled_bills_pct ?>%</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Cashier Monitor -->
                <div class="col-xl-4 col-md-12 col-12 mb-3">
                    <div class="staff-panel">
                        <h6 class="text-psy-label text-uppercase font-small-3 mb-1" style="letter-spacing: 1px;"><i class="fa fa-desktop text-purple mr-1"></i> Terminal Status</h6>
                        <?php 
                            $error_rate = isset($loss_stats['billing_error']['percentage']) ? (float)$loss_stats['billing_error']['percentage'] : 0;
                            $accuracy = 100 - $error_rate;
                        ?>
                        <div class="digital-monitor text-center">
                            <h2 class="mb-0 font-weight-bold"><?= number_format($accuracy, 1) ?>%</h2>
                            <small class="text-uppercase opacity-75">System Accuracy</small>
                            <div class="row mt-2 pt-2 border-top border-info-light" style="border-color: #bae6fd !important;">
                                <div class="col-6 border-right" style="border-color: #bae6fd !important;">
                                    <small class="d-block text-psy-muted">Latency</small>
                                    <span class="text-success font-weight-bold">LOW</span>
                                </div>
                                <div class="col-6">
                                    <small class="d-block text-psy-muted">Errors</small>
                                    <span class="text-<?= ($error_rate > 5) ? 'danger' : 'success' ?> font-weight-bold"><?= ($error_rate > 5) ? 'CRIT' : 'NOM' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>

            <div class="row match-height">
                <!-- Staff Leaderboard -->
                <div class="col-xl-8 col-lg-12 col-12 mb-3 mb-xl-0">
                    <div class="staff-panel p-0">
                        <div class="p-3 border-bottom border-light">
                            <h6 class="mb-0 text-dark text-uppercase font-small-3"><i class="fa fa-list-ol text-primary mr-2"></i> Performance Leaderboard</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-glass mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Staff</th>
                                        <th class="text-center border-top-0">Sales</th>
                                        <th class="text-center border-top-0">Errors</th>
                                        <th class="text-center border-top-0">Returns</th>
                                        <th class="text-center border-top-0">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($staff_scores_list) && !empty($staff_scores_list)): ?>
                                        <?php foreach($staff_scores_list as $staff): 
                                            $score_color = ($staff['trust_score'] > 80) ? 'success' : (($staff['trust_score'] > 50) ? 'warning' : 'danger');
                                        ?>
                                        <tr>
                                            <td class="text-dark font-weight-bold">
                                                <img src="<?= base_url() ?>assets/images/portrait/small/avatar-s-1.png" class="rounded-circle mr-2" width="24"> 
                                                <?= $staff['username'] ?>
                                            </td>
                                            <td class="text-center text-info"><?= amountExchange($staff['sales'], 0, $this->aauth->get_user()->loc) ?></td>
                                            <td class="text-center text-<?= ($staff['errors'] > 5) ? 'danger' : 'muted' ?>"><?= $staff['errors'] ?></td>
                                            <td class="text-center text-psy-muted"><?= $staff['returns'] ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-outline-<?= $score_color ?>"><?= round($staff['trust_score']) ?>%</span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="5" class="text-center text-psy-muted py-3">No active data</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Fraud Alert Center -->
                <div class="col-xl-4 col-lg-12 col-12">
                    <div class="fraud-alert-panel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-danger mb-0 font-weight-bold"><i class="fa fa-warning mr-1"></i> THREAT LEVEL</h6>
                            <span class="badge badge-danger badge-pill shadow-lg fraud-pulse">ACTIVE</span>
                        </div>
                        
                        <div class="bg-white p-3 rounded mb-3" style="border: 1px solid rgba(239, 68, 68, 0.2);">
                            <?php if(isset($risk_alerts) && !empty($risk_alerts)): 
                                $alert = $risk_alerts[0];
                            ?>
                                <small class="text-danger d-block mb-1">LATEST INCIDENT • <?= date('H:i') ?></small>
                                <h5 class="text-dark font-weight-bold mb-2"><?= $alert['type'] ?></h5>
                                <p class="text-psy-muted font-small-3 mb-0"><?= $alert['message'] ?></p>
                            <?php else: ?>
                                <div class="text-center py-2">
                                    <i class="fa fa-check-circle text-success fa-2x mb-2 opacity-75"></i>
                                    <h5 class="text-dark">System Secure</h5>
                                    <small class="text-psy-muted">No active threats detected.</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <button class="btn btn-outline-danger btn-block btn-sm shadow-none"><i class="fa fa-search mr-1"></i> RUN SECURITY AUDIT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Branch Performance Heatmap Widget -->
    <div class="col-xl-12 col-lg-12 mb-4">
        <div class="premium-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 text-dark font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                    <i class="fa fa-globe text-primary mr-2"></i>GLOBAL OPERATIONS CENTER
                </h4>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-filter"></i> Region</button>
                    <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-refresh"></i> Sync</button>
                </div>
            </div>
            
            <div class="row match-height">
                <?php if(isset($branches) && !empty($branches)): ?>
                    <?php foreach($branches as $branch): 
                        // Calculate heat color based on profit
                        $profit = $branch['total_sales'] - $branch['total_expenses'];
                        $heat_class = 'heat-critical'; // Default
                        $status_icon = 'fa-exclamation-triangle text-danger';
                        $status_text = 'CRITICAL';
                        $status_text_color = 'text-danger';
                        
                        if($profit > 100000) { 
                            $heat_class = 'heat-excellent'; 
                            $status_icon = 'fa-trophy text-success';
                            $status_text = 'EXCELLENT';
                            $status_text_color = 'text-success';
                        }
                        elseif($profit > 50000) { 
                            $heat_class = 'heat-good'; 
                            $status_icon = 'fa-check-circle text-info';
                            $status_text = 'OPTIMAL';
                            $status_text_color = 'text-info';
                        }
                        elseif($profit > 0) { 
                            $heat_class = 'heat-warning'; 
                            $status_icon = 'fa-level-up text-warning';
                            $status_text = 'STABLE';
                            $status_text_color = 'text-warning';
                        }
                    ?>
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="heatmap-item <?= $heat_class ?>" onclick="window.location.href='?branch_id=<?= $branch['id'] ?>'">
                            <i class="fa fa-map-marker geo-marker text-dark opacity-10"></i>
                            
                             <div class="d-flex justify-content-between mb-2 position-relative">
                                <h5 class="text-dark font-weight-bold mb-0 text-uppercase"><?= $branch['name'] ?></h5>
                                <span class="badge badge-light border"><?= $branch['id'] ?></span>
                            </div>
                            
                            <div class="row mb-2 position-relative">
                                <div class="col-6 border-right border-light">
                                    <small class="text-psy-muted d-block font-small-2">REVENUE</small>
                                    <span class="text-dark font-weight-bold"><?= amountExchange($branch['total_sales'], 0, $this->aauth->get_user()->loc) ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="text-psy-muted d-block font-small-2">NET PROFIT</small>
                                    <span class="<?= $status_text_color ?> font-weight-bold"><?= amountExchange($profit, 0, $this->aauth->get_user()->loc) ?></span>
                                </div>
                            </div>
                            
                            <div class="position-relative pt-2 border-top border-light d-flex justify-content-between align-items-center">
                                <span class="font-small-2 text-psy-muted"><i class="<?= $status_icon ?> mr-1"></i> Status: <?= $status_text ?></span>
                                <i class="fa fa-chevron-right text-psy-muted opacity-50"></i>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-globe fa-3x text-psy-muted mb-2 opacity-25"></i>
                        <p class="text-psy-muted opacity-50">No global branch data established.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Loss Control Widget -->
    <div class="col-xl-12 col-lg-12 mb-4">
        <div class="premium-card loss-control">

            <div class="loss-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-danger font-weight-bold" style="letter-spacing: 1px;">
                    <i class="ft-alert-triangle text-danger mr-2"></i>LOSS PREVENTION & THREAT MONITOR
                </h4>
                <div class="badge badge-outline-danger">DEFCON 1</div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <?php
                    // Calculate traffic light status for each loss type
                    $stock_leak_pct = isset($loss_stats['stock_leak']['percentage']) ? $loss_stats['stock_leak']['percentage'] : 0;
                    $billing_error_count = isset($loss_stats['billing_error']['count']) ? $loss_stats['billing_error']['count'] : 0;
                    $return_abuse_pct = isset($loss_stats['return_abuse']['percentage']) ? $loss_stats['return_abuse']['percentage'] : 0;
                    
                    // Determine status colors for new classes
                    function getLossAlertClass($percentage, $type = 'percentage') {
                        if ($type == 'count') {
                            if ($percentage > 10) return 'alert-danger';
                            if ($percentage > 5) return 'alert-warning';
                            return 'alert-safe';
                        }
                        if ($percentage >= 5) return 'alert-danger';
                        if ($percentage >= 2) return 'alert-warning';
                        return 'alert-safe';
                    }
                    
                    $stock_class = getLossAlertClass($stock_leak_pct);
                    $billing_class = getLossAlertClass($billing_error_count, 'count');
                    $return_class = getLossAlertClass($return_abuse_pct);
                    
                    // Simple logic for icon/text color
                    function getStatusColor($class) {
                        if(strpos($class, 'danger') !== false) return 'danger';
                        if(strpos($class, 'warning') !== false) return 'warning';
                        return 'success';
                    }
                    ?>
                    
                    <!-- Stock Leak Indicator -->
                    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                        <div class="text-center">
                            <div class="hud-ring <?= $stock_class ?> mb-3">
                                <div class="hud-content">
                                    <h2 class="text-danger mb-0 font-weight-bold"><?= number_format($stock_leak_pct, 1) ?>%</h2>
                                    <small class="text-psy-muted">LEAKAGE</small>
                                </div>
                            </div>
                            <h5 class="text-dark text-uppercase font-small-3"><?= $this->lang->line('stock_leak') ?: 'Stock Leak' ?></h5>
                            <span class="badge badge-<?= getStatusColor($stock_class) ?> mt-1">
                                Rs <?= number_format($loss_stats['stock_leak']['amount'] ?? 0, 0) ?> Lost
                            </span>
                        </div>
                    </div>
                    
                    <!-- Billing Errors Indicator -->
                    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                        <div class="text-center">
                            <div class="hud-ring <?= $billing_class ?> mb-3">
                                <div class="hud-content">
                                    <h2 class="text-danger mb-0 font-weight-bold"><?= $billing_error_count ?></h2>
                                    <small class="text-psy-muted">ERRORS</small>
                                </div>
                            </div>
                            <h5 class="text-dark text-uppercase font-small-3"><?= $this->lang->line('billing_errors') ?: 'Billing Errors' ?></h5>
                            <span class="badge badge-<?= getStatusColor($billing_class) ?> mt-1">
                                <?= $billing_error_count ?> Incidents
                            </span>
                        </div>
                    </div>
                    
                    <!-- Return Abuse Indicator -->
                    <div class="col-md-4 col-sm-12">
                        <div class="text-center">
                            <div class="hud-ring <?= $return_class ?> mb-3">
                                <div class="hud-content">
                                    <h2 class="text-danger mb-0 font-weight-bold"><?= number_format($return_abuse_pct, 1) ?>%</h2>
                                    <small class="text-psy-muted">ABUSE</small>
                                </div>
                            </div>
                            <h5 class="text-dark text-uppercase font-small-3"><?= $this->lang->line('return_abuse') ?: 'Return Abuse' ?></h5>
                            <span class="badge badge-<?= getStatusColor($return_class) ?> mt-1">
                                <?= $loss_stats['return_abuse']['count'] ?? 0 ?> Returns
                            </span>
                        </div>
                    </div>
                </div>
                
                <hr style="border-color: rgba(255,255,255,0.1);">
                
                <!-- Total Estimated Monthly Loss -->
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="p-3" style="background: rgba(254, 226, 226, 0.5); border-radius: 10px; border: 1px dashed rgba(239, 68, 68, 0.4);">
                            <h6 class="text-danger text-uppercase mb-2" style="letter-spacing: 2px;">
                                <i class="ft-activity"></i> ESTIMATED MONTHLY HIDDEN LOSS
                            </h6>
                            <?php
                            $total_monthly_loss = ($loss_stats['stock_leak']['amount'] ?? 0) * 30 + 
                                                ($loss_stats['billing_error']['amount'] ?? 0) * 30 + 
                                                ($loss_stats['return_abuse']['amount'] ?? 0);
                            ?>
                            <h1 class="loss-counter text-danger mb-0">
                                Rs <?= number_format($total_monthly_loss, 2) ?>
                            </h1>
                            <small class="text-psy-muted d-block mt-1">
                                PROJECTED IMPACT • <span class="text-success">PREVENTED: Rs <?= number_format($loss_stats['prevented_loss'] ?? 0, 2) ?></span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


 


</div>




    <!-- Cashflow Analytics Widget -->
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
            <div class="premium-card" id="transactions">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                        <div class="mb-3 mb-md-0">
                            <h4 class="text-dark font-weight-bold mb-0 text-uppercase" style="letter-spacing: 1px;">
                                <i class="ft-activity text-info mr-2"></i><?= $this->lang->line('cashflow') ?>
                            </h4>
                            <small class="text-psy-muted"><?= $this->lang->line('graphical_presentation') ?></small>
                        </div>
                        
                        <ul class="nav nav-pills-neon">
                            <li class="nav-item">
                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#sales" aria-expanded="true">
                                    <i class="ft-arrow-up-right mr-1"></i><?= $this->lang->line('income') ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#transactions1" aria-expanded="false">
                                    <i class="ft-arrow-down-left mr-1"></i><?= $this->lang->line('expenses') ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="sales" aria-expanded="true" data-toggle="tab">
                            <div class="chart-grid-bg">
                                <div id="dashboard-income-chart"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="transactions1" data-toggle="tab" aria-expanded="false">
                            <div class="chart-grid-bg">
                                <div id="dashboard-expense-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 








</div>
<div class="row match-height">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent') ?> <a
                            href="<?php echo base_url() ?>transactions"
                            class="btn btn-primary btn-sm rounded"><?php echo $this->lang->line('Transactions') ?></a>
                </h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover mb-1">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?>#</th>
                            <th><?php echo $this->lang->line('Account') ?></th>
                            <th><?php echo $this->lang->line('Debit') ?></th>
                            <th><?php echo $this->lang->line('Credit') ?></th>

                            <th><?php echo $this->lang->line('Method') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($recent_payments as $item) {

                            echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'transactions/view?id=' . $item['id'] . '" class="text-primary font-weight-bold">' . dateformat($item['date']) . '</a></td>
                                <td class="text-truncate text-dark"> ' . $item['account'] . '</td>
                                <td class="text-truncate text-danger font-weight-bold">' . amountExchange($item['debit'], 0, $this->aauth->get_user()->loc) . '</td>
                                <td class="text-truncate text-success font-weight-bold">' . amountExchange($item['credit'], 0, $this->aauth->get_user()->loc) . '</td>                    
                                <td class="text-truncate text-muted">' . $this->lang->line($item['method']) . '</td>
                            </tr>';

                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
  

















</div>
<script type="text/javascript">
    $(window).on("load", function () {
        $('#recent-buyers').perfectScrollbar({
            wheelPropagation: true
        });
        /********************************************
         *               PRODUCTS SALES              *
         ********************************************/
        var sales_data = [
            <?php foreach ($countmonthlychart as $row) {
            echo "{ y: '" . $row['date'] . "', sales: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . ", invoices: " . intval($row['ttlid']) . "},";
        } ?>
        ];
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        Morris.Area({
            element: 'products-sales',
            data: sales_data,
            xkey: 'y',
            ykeys: ['sales', 'invoices'],
            labels: ['sales', 'invoices'],
            behaveLikeLine: true,
            xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                var day = x.getDate();
                var month = months[x.getMonth()];
                return day + ' ' + month;
            },
            resize: true,
            pointSize: 4,
            pointStrokeColors: ['#ffffff', '#ffffff', '#ffffff'],
            pointFillColors: ['#2563eb', '#16a34a', '#eab308'],
            smooth: true,
            gridLineColor: '#e2e8f0',
            numLines: 6,
            gridtextSize: 12,
            gridTextColor: '#64748b',
            lineWidth: 2,
            fillOpacity: 0.1,
            hideHover: 'auto',
            lineColors: ['#2563eb', '#16a34a']
        });


    });
</script>
<script type="text/javascript">
    function drawIncomeChart(dataVisits) {
        $('#dashboard-income-chart').empty();
        Morris.Area({
            element: 'dashboard-income-chart',
            data: dataVisits,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 40',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#16a34a',
            ],
            pointFillColors: [
                '#16a34a',
            ],
            fillOpacity: 0.1,
        });
    }

    function drawExpenseChart(dataVisits2) {

        $('#dashboard-expense-chart').empty();
        Morris.Area({
            element: 'dashboard-expense-chart',
            data: dataVisits2,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 0',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#ef4444',
            ],
            pointFillColors: [
                '#ef4444',
            ]
        });
    }

    drawIncomeChart(dataVisits);
    drawExpenseChart(dataVisits2);
    $('#dashboard-sales-breakdown-chart').empty();
    Morris.Donut({
        element: 'dashboard-sales-breakdown-chart',
        data: [{
            label: "<?php echo $this->lang->line('Income') ?>",
            value: <?= intval(amountExchange_s($tt_inc, 0, $this->aauth->get_user()->loc)); ?> },
            {
                label: "<?php echo $this->lang->line('Expenses') ?>",
                value: <?= intval(amountExchange_s($tt_exp, 0, $this->aauth->get_user()->loc)); ?> }
        ],
        resize: true,
        colors: ['#16a34a', '#ef4444'],
        gridTextSize: 6,
        gridTextWeight: 400
    });
    $('a[data-toggle=tab').on('shown.bs.tab', function (e) {
        window.dispatchEvent(new Event('resize'));
    });
</script>

<!-- Owner Decision FAB -->
<div class="fab-container">
    <div class="fab shadow">
        <div class="fab-content">
            <span class="material-icons"><i class="fa fa-plus"></i></span>
        </div>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('pos_invoices/create') ?>" target="_blank" title="POS">
            <span class="material-icons"><i class="fa fa-shopping-cart"></i></span>
        </a>
    </div>
        <div class="sub-button shadow">
        <a href="<?= base_url('ChequeManager') ?>" target="_blank" title="ChequeManager">
            <span class="material-icons"><i class="fa fa-money"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('products_alert/manage_alert2') ?>" target="_blank" title="Inventory Alert">
            <span class="material-icons"><i class="fa fa-exclamation-triangle"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('invoices/create') ?>" target="_blank" title="Timber Treatment">
            <span class="material-icons"><i class="fa fa-tree"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('products/stock_transfer') ?>" target="_blank" title="Stock Transfer">
            <span class="material-icons"><i class="fa fa-truck"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('purchase/newprocessing') ?>" target="_blank" title="Trunks Processing">
            <span class="material-icons"><i class="fa fa-cogs"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('carpentry_dashboard') ?>" target="_blank" title="Carpentry">
            <span class="material-icons"><i class="fa fa-gavel"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('payrolltimesheets') ?>" target="_blank" title="Payroll Timesheets">
            <span class="material-icons"><i class="fa fa-clock-o"></i></span>
        </a>
    </div>
</div>

<style>
.fab-container {
    position: fixed;
    bottom: 50px;
    right: 30px;
    z-index: 999;
    cursor: pointer;
}

.fab {
    width: 60px;
    height: 60px;
    background: #0f172a; /* Scientific Dark Blue */
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1000;
}

.fab:hover {
    transform: rotate(45deg);
    background: #512DA8;
}

.fab-content {
    color: white;
    font-size: 24px;
}

.sub-button {
    width: 50px;
    height: 50px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    bottom: 5px;
    right: 5px;
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 998;
}

.sub-button a {
    color: #555;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

.sub-button:hover {
    background: #f0f0f0;
}

/* Hover Effect to Show Buttons */
.fab-container:hover .sub-button:nth-child(2) {
    bottom: 80px;
    opacity: 1;
}

.fab-container:hover .sub-button:nth-child(3) {
    bottom: 140px;
    opacity: 1;
}

.fab-container:hover .sub-button:nth-child(4) {
    bottom: 200px;
    opacity: 1;
}

.fab-container:hover .sub-button:nth-child(5) {
    bottom: 260px;
    opacity: 1;
}
.fab-container:hover .sub-button:nth-child(6) {
    bottom: 320px;
    opacity: 1;
}
.fab-container:hover .sub-button:nth-child(7) {
    bottom: 380px;
    opacity: 1;
}
.fab-container:hover .sub-button:nth-child(8) {
    bottom: 440px;
    opacity: 1;
}

/* Tooltips */
.sub-button a[title]:hover::after {
    content: attr(title);
    position: absolute;
    right: 60px;
    background: #333;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
}
</style>