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
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
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
                            <h6 class="text-primary mt-1 small">Dashboard Overview</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Stats:</strong> View daily income, expenses, and profit at a glance.</li>
                                <li><strong>Charts:</strong> Analyze sales and product performance trends over the last 30 days.</li>
                                <li><strong>Tasks:</strong> Keep track of your pending tasks and deadlines.</li>
                            </ol>
                        </div>
                        <div id="sin_dash" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">උ시කරණ පුවරුව (Dashboard)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>සංඛ්‍යාලේඛන:</strong> දෛනික ආදායම, වියදම් සහ ලාභය එක බැල්මකින් බලන්න.</li>
                                <li><strong>ප්‍රස්ථාර:</strong> පසුගිය දින 30 තුළ විකුණුම් සහ නිෂ්පාදන කාර්ය සාධන ප්‍රවණතා විශ්ලේෂණය කරන්න.</li>
                                <li><strong>කාර්යයන්:</strong> ඔබගේ විභාග වෙමින් පවතින කාර්යයන් සහ නියමිත දින නිරීක්ෂණය කරන්න.</li>
                            </ol>
                        </div>
                        <div id="tam_dash" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">டாஷ்போர்டு கண்ணோட்டம்</h6>
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

    <!-- Global Control Bar -->
    <div class="col-12 mb-2">
        <div class="card bg-gradient-x-primary border-0">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="text-white mb-0"><i class="fa fa-tachometer"></i> Executive Command Center</h5>
                        <p class="text-white small mb-0">Dashboard Controls</p>
                    </div>
                    <div class="col-md-9">
                        <form method="get" id="dashboard-filter-form">
                            <div class="row align-items-center">
                                <!-- Branch Selector -->
                                <div class="col-md-2">
                                    <label class="text-white small mb-1">Branch</label>
                                    <select name="branch_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="0">All Branches</option>
                                        <?php if(isset($locations)) { foreach ($locations as $loc) { ?>
                                            <option value="<?= $loc['id'] ?>" <?= (isset($current_branch) && $current_branch == $loc['id']) ? 'selected' : '' ?>>
                                                <?= $loc['cname'] ?>
                                            </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                
                                <!-- User Role Selector -->
                                <div class="col-md-2">
                                    <label class="text-white small mb-1">User Role</label>
                                    <select name="user_role" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">All Roles</option>
                                        <option value="5" <?= (isset($_GET['user_role']) && $_GET['user_role'] == '5') ? 'selected' : '' ?>>Admin</option>
                                        <option value="4" <?= (isset($_GET['user_role']) && $_GET['user_role'] == '4') ? 'selected' : '' ?>>Manager</option>
                                        <option value="3" <?= (isset($_GET['user_role']) && $_GET['user_role'] == '3') ? 'selected' : '' ?>>Staff</option>
                                        <option value="2" <?= (isset($_GET['user_role']) && $_GET['user_role'] == '2') ? 'selected' : '' ?>>Sales</option>
                                    </select>
                                </div>
                                
                                <!-- Date Range -->
                                <div class="col-md-3">
                                    <label class="text-white small mb-1">Date Range</label>
                                    <div class="input-group input-group-sm">
                                        <input type="date" name="start_date" class="form-control form-control-sm" 
                                               value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01') ?>" 
                                               placeholder="Start Date">
                                        <span class="input-group-text bg-white px-1">to</span>
                                        <input type="date" name="end_date" class="form-control form-control-sm" 
                                               value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d') ?>" 
                                               placeholder="End Date">
                                    </div>
                                </div>
                                
                                <!-- Quick Filters -->
                                <div class="col-md-3">
                                    <label class="text-white small mb-1">Quick Filter</label>
                                    <select name="quick_filter" class="form-control form-control-sm" id="quick-filter">
                                        <option value="">Custom Range</option>
                                        <option value="today" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'today') ? 'selected' : '' ?>>Today</option>
                                        <option value="yesterday" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'yesterday') ? 'selected' : '' ?>>Yesterday</option>
                                        <option value="this_week" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'this_week') ? 'selected' : '' ?>>This Week</option>
                                        <option value="this_month" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'this_month') ? 'selected' : '' ?>>This Month</option>
                                        <option value="last_month" <?= (isset($_GET['quick_filter']) && $_GET['quick_filter'] == 'last_month') ? 'selected' : '' ?>>Last Month</option>
                                    </select>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="col-md-2 text-right">
                                    <label class="text-white small mb-1 d-block">&nbsp;</label>
                                    <button type="submit" class="btn btn-sm btn-white text-primary">
                                        <i class="fa fa-filter"></i> Apply
                                    </button>
                                    <a href="<?= base_url('intelligence') ?>" class="btn btn-sm btn-white text-primary" title="Intelligence Hub">
                                        <i class="fa fa-line-chart"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
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


    <!-- Business Health Bar -->
    <div class="col-12 mb-2">
        <?php 
        $health_score = isset($business_health['score']) ? $business_health['score'] : 85; 
        $health_color = ($health_score > 80) ? 'success' : (($health_score > 60) ? 'warning' : 'danger');
        ?>
        <div class="card">
            <div class="card-body p-2">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-bold-600"><i class="fa fa-heartbeat text-danger"></i> Business Health Score</span>
                    <span class="text-bold-600 <?= 'text-'.$health_color ?>"><?= $health_score ?>/100</span>
                </div>
                <div class="progress progress-xl" style="height: 15px;">
                    <div class="progress-bar bg-<?= $health_color ?> progress-bar-striped progress-bar-animated" role="progressbar" 
                         style="width: <?= $health_score ?>%" aria-valuenow="<?= $health_score ?>" aria-valuemin="0" aria-valuemax="100">
                        <strong><?= $health_score ?>%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Executive KPI Block -->
    <div class="col-12">
        <div class="row match-height">
             <!-- Net Profit KPI -->
             <div class="col-xl-4 col-lg-6 col-12">
                <div class="card bg-gradient-success text-white">
                    <div class="card-body p-2">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white mb-0"><?= amountExchange($todayprofit, 0, $this->aauth->get_user()->loc) ?></h4>
                                <span class="small">Net Profit <?php 
                                    if(isset($start_date) && isset($end_date)) {
                                        if($start_date == $end_date) echo '(' . date('M d', strtotime($start_date)) . ')';
                                        else echo '(' . date('M d', strtotime($start_date)) . ' - ' . date('M d', strtotime($end_date)) . ')';
                                    } else { echo '(Today)'; }
                                ?></span>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-money font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cash Flow KPI -->
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card bg-gradient-info text-white">
                    <div class="card-body p-2">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white mb-0"><?= amountExchange($todayinexp['credit'] - $todayinexp['debit'], 0, $this->aauth->get_user()->loc) ?></h4>
                                <span class="small">Net Cash Flow <?php 
                                    if(isset($start_date) && isset($end_date)) {
                                        if($start_date == $end_date) echo '(' . date('M d', strtotime($start_date)) . ')';
                                        else echo '(' . date('M d', strtotime($start_date)) . ' - ' . date('M d', strtotime($end_date)) . ')';
                                    } else { echo '(Today)'; }
                                ?></span>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-exchange font-large-2 float-right"></i>
                            </div>
                        </div>
                         <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Customer Growth KPI -->
            <div class="col-xl-4 col-lg-12 col-12">
                <div class="card bg-gradient-warning text-white">
                    <div class="card-body p-2">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white mb-0">+<?= isset($todaynewcustomers) ? $todaynewcustomers : 0 ?></h4>
                                <span class="small">New Customers <?php 
                                    if(isset($start_date) && isset($end_date)) {
                                        if($start_date == $end_date) echo '(' . date('M d', strtotime($start_date)) . ')';
                                        else echo '(' . date('M d', strtotime($start_date)) . ' - ' . date('M d', strtotime($end_date)) . ')';
                                    } else { echo '(Today)'; }
                                ?></span>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-users font-large-2 float-right"></i>
                            </div>
                        </div>
                         <div class="progress mt-1 mb-0" style="height: 7px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dead Stock Identifier Widget -->
    <div class="col-12 mb-2">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-x-danger">
                <h5 class="text-white mb-0"><i class="fa fa-archive"></i> Dead Stock Identifier</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $dead_stock = isset($dead_stock_summary) ? $dead_stock_summary : array(
                        'dead_stock_value' => 0,
                        'dead_stock_count' => 0,
                        'slow_moving_count' => 0,
                        'slow_moving_value' => 0
                    );
                    
                    // Determine severity color based on value
                    $severity_class = 'success';
                    $severity_text = 'Under Control';
                    $severity_icon = 'fa-check-circle';
                    
                    if ($dead_stock['dead_stock_value'] > 500000) {
                        $severity_class = 'danger';
                        $severity_text = 'Critical';
                        $severity_icon = 'fa-exclamation-triangle';
                    } elseif ($dead_stock['dead_stock_value'] > 200000) {
                        $severity_class = 'warning';
                        $severity_text = 'High Risk';
                        $severity_icon = 'fa-exclamation-circle';
                    }
                    ?>
                    
                    <!-- Dead Stock Value -->
                    <div class="col-md-6 col-12">
                        <div class="text-center p-3 bg-light-<?= $severity_class ?> rounded">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fa <?= $severity_icon ?> text-<?= $severity_class ?> font-large-1 mr-1"></i>
                                <span class="badge badge-<?= $severity_class ?>"><?= $severity_text ?></span>
                            </div>
                            <h2 class="text-<?= $severity_class ?> font-weight-bold mb-1">
                                <?= amountExchange($dead_stock['dead_stock_value'], 0, $this->aauth->get_user()->loc) ?>
                            </h2>
                            <p class="text-muted mb-0">
                                <strong>Dead Stock Value</strong><br>
                                <small><?= $dead_stock['dead_stock_count'] ?> products with no sales in 90+ days</small>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Slow Moving Items -->
                    <div class="col-md-6 col-12">
                        <div class="text-center p-3 bg-light-info rounded">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fa fa-clock-o text-info font-large-1 mr-1"></i>
                                <span class="badge badge-info">Slow Moving</span>
                            </div>
                            <h2 class="text-info font-weight-bold mb-1">
                                <?= $dead_stock['slow_moving_count'] ?>
                            </h2>
                            <p class="text-muted mb-0">
                                <strong>Slow Moving Products</strong><br>
                                <small>Value: <?= amountExchange($dead_stock['slow_moving_value'], 0, $this->aauth->get_user()->loc) ?></small>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Button -->
                <div class="text-center mt-3">
                    <a href="<?= base_url('intelligence/dead_stock') ?>" class="btn btn-sm btn-danger">
                        <i class="fa fa-list"></i> View Detailed Dead Stock Report
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fast-Moving Stock Identifier Widget -->
    <div class="col-12 mb-2">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-x-success">
                <h5 class="text-white mb-0"><i class="fa fa-rocket"></i> Fast-Moving Stock Identifier</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $fast_moving = isset($fast_moving_summary) ? $fast_moving_summary : array(
                        'fast_moving_value' => 0,
                        'fast_moving_count' => 0,
                        'total_sales' => 0,
                        'avg_sales_per_product' => 0
                    );
                    
                    // Determine performance level
                    $performance_class = 'info';
                    $performance_text = 'Moderate';
                    $performance_icon = 'fa-info-circle';
                    
                    if ($fast_moving['fast_moving_count'] > 20) {
                        $performance_class = 'success';
                        $performance_text = 'Excellent';
                        $performance_icon = 'fa-check-circle';
                    } elseif ($fast_moving['fast_moving_count'] > 10) {
                        $performance_class = 'success';
                        $performance_text = 'Good';
                        $performance_icon = 'fa-thumbs-up';
                    } elseif ($fast_moving['fast_moving_count'] < 5) {
                        $performance_class = 'warning';
                        $performance_text = 'Low';
                        $performance_icon = 'fa-exclamation-circle';
                    }
                    ?>
                    
                    <!-- Fast-Moving Items Count -->
                    <div class="col-md-6 col-12">
                        <div class="text-center p-3 bg-light-<?= $performance_class ?> rounded">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fa <?= $performance_icon ?> text-<?= $performance_class ?> font-large-1 mr-1"></i>
                                <span class="badge badge-<?= $performance_class ?>"><?= $performance_text ?> Performance</span>
                            </div>
                            <h2 class="text-<?= $performance_class ?> font-weight-bold mb-1">
                                <?= $fast_moving['fast_moving_count'] ?>
                            </h2>
                            <p class="text-muted mb-0">
                                <strong>Fast-Moving Products</strong><br>
                                <small>10+ sales in last 30 days</small>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Fast-Moving Stock Value -->
                    <div class="col-md-6 col-12">
                        <div class="text-center p-3 bg-light-primary rounded">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fa fa-money text-primary font-large-1 mr-1"></i>
                                <span class="badge badge-primary">High Velocity</span>
                            </div>
                            <h2 class="text-primary font-weight-bold mb-1">
                                <?= amountExchange($fast_moving['fast_moving_value'], 0, $this->aauth->get_user()->loc) ?>
                            </h2>
                            <p class="text-muted mb-0">
                                <strong>Fast-Moving Stock Value</strong><br>
                                <small>Total sales: <?= number_format($fast_moving['total_sales']) ?> transactions</small>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Metrics -->
                <?php if ($fast_moving['fast_moving_count'] > 0): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-success mb-0">
                            <i class="fa fa-line-chart"></i> 
                            <strong>Average Performance:</strong> 
                            <?= number_format($fast_moving['avg_sales_per_product'], 1) ?> sales per product
                            <span class="float-right">
                                <i class="fa fa-info-circle"></i> These products drive your revenue
                            </span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Action Button -->
                <div class="text-center mt-3">
                    <a href="<?= base_url('intelligence/fast_moving_stock') ?>" class="btn btn-sm btn-success">
                        <i class="fa fa-bar-chart"></i> View Detailed Fast-Moving Stock Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Metrics Intelligence Section -->
    <style>
        .fin-intel-card { transition: all 0.3s ease; border-radius: 15px !important; border: none; }
        .fin-intel-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important; }
        .fin-metric-tile { padding: 15px; border-radius: 12px; height: 100%; border: 1px solid rgba(0,0,0,0.05); }
        .gradient-light-success { background: linear-gradient(135deg, rgba(40,208,148,0.1) 0%, rgba(40,208,148,0.05) 100%); }
        .gradient-light-danger { background: linear-gradient(135deg, rgba(255,73,97,0.1) 0%, rgba(255,73,97,0.05) 100%); }
        .gradient-light-info { background: linear-gradient(135deg, rgba(30,159,242,0.1) 0%, rgba(30,159,242,0.05) 100%); }
        .gradient-light-warning { background: linear-gradient(135deg, rgba(255,145,73,0.1) 0%, rgba(255,145,73,0.05) 100%); }
    </style>
    <div class="col-xl-12 col-lg-12">
        <div class="card border-0 shadow-lg" style="border-radius: 15px;">
            <div class="card-header bg-gradient-x-info" style="border-radius: 15px 15px 0 0;">
                <h4 class="card-title text-white"><i class="fa fa-calculator"></i> FINANCIAL METRICS INTELLIGENCE <span class="badge badge-pill badge-info ml-1" style="font-size: 10px; background: rgba(255,255,255,0.2);">LIVE ANALYTICS</span></h4>
            </div>
            <div class="card-body">
                <!-- Top Row: Core Financial KPIs -->
                <div class="row match-height mb-3">
                    <!-- Net Profit -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-metric-tile gradient-light-success">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="text-uppercase font-small-3 text-bold-600 mb-0">Total Profit</h6>
                                <i class="fa fa-line-chart text-success"></i>
                            </div>
                            <h2 class="text-bold-700 text-success mb-0"><?= amountExchange($todayprofit, 0, $this->aauth->get_user()->loc) ?></h2>
                            <p class="text-muted font-small-2 mb-0">Monthly target: <?= amountExchange($goals['netincome'], 0, $this->aauth->get_user()->loc) ?></p>
                        </div>
                    </div>
                    <!-- Net Cash Flow -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-metric-tile gradient-light-info">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="text-uppercase font-small-3 text-bold-600 mb-0">Net Cash Flow</h6>
                                <i class="fa fa-exchange text-info"></i>
                            </div>
                            <h2 class="text-bold-700 text-info mb-0"><?= amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) ?></h2>
                            <p class="text-muted font-small-2 mb-0">In: <?= amountExchange($tt_inc, 0, $this->aauth->get_user()->loc) ?> | Out: <?= amountExchange($tt_exp, 0, $this->aauth->get_user()->loc) ?></p>
                        </div>
                    </div>
                    <!-- Cash in Hand -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-metric-tile gradient-light-warning">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="text-uppercase font-small-3 text-bold-600 mb-0">Cash in Hand</h6>
                                <i class="fa fa-money text-warning"></i>
                            </div>
                            <h2 class="text-bold-700 text-warning mb-0"><?= amountExchange($cash_in_hand, 0, $this->aauth->get_user()->loc) ?></h2>
                            <p class="text-muted font-small-2 mb-0">Primary liquidity pool</p>
                        </div>
                    </div>
                    <!-- Bank balance proxy -->
                    <div class="col-xl-3 col-md-6 col-12 mb-2">
                        <div class="fin-metric-tile bg-light">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="text-uppercase font-small-3 text-bold-600 mb-0">Bank Balance</h6>
                                <i class="fa fa-university text-dark"></i>
                            </div>
                            <h2 class="text-bold-700 text-dark mb-0"><?= amountExchange($financial_metrics['income']['Bank'] - $financial_metrics['expense']['Bank'], 0, $this->aauth->get_user()->loc) ?></h2>
                            <p class="text-muted font-small-2 mb-0">Digital assets & clears</p>
                        </div>
                    </div>
                </div>

                <!-- Middle Row: Liabilities -->
                <div class="row match-height mb-3">
                    <div class="col-xl-6 col-12 mb-2">
                        <div class="card fin-intel-card bg-lighten-5" style="border-left: 5px solid #1e9ff2; background-color: #f7fbff;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="text-bold-600 mb-0 text-primary">CUSTOMER RECEIVABLES</h6>
                                    <div class="badge badge-primary">DUE</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="mb-0 text-bold-700"><?= amountExchange($customer_due, 0, $this->aauth->get_user()->loc) ?></h2>
                                    <div class="btn-group">
                                        <a href="<?= base_url('invoices?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-info rounded-left"><i class="fa fa-file-text-o"></i></a>
                                        <a href="<?= base_url('pos_invoices?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-primary rounded-right"><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <p class="small text-muted mb-0 mt-1"><i class="fa fa-info-circle"></i> Outstanding payments expected from customers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12 mb-2">
                        <div class="card fin-intel-card bg-lighten-5" style="border-left: 5px solid #ff4961; background-color: #fffafa;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="text-bold-600 mb-0 text-danger">SUPPLIER PAYABLES</h6>
                                    <div class="badge badge-danger">PENDING</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="mb-0 text-bold-700"><?= amountExchange($supplier_due, 0, $this->aauth->get_user()->loc) ?></h2>
                                    <div class="btn-group">
                                        <a href="<?= base_url('purchase?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-danger rounded-left"><i class="fa fa-truck"></i></a>
                                        <a href="<?= base_url('purchase/list?status=due&branch_id='.(isset($current_branch)?$current_branch:0)) ?>" class="btn btn-sm btn-dark rounded-right"><i class="fa fa-tree"></i></a>
                                    </div>
                                </div>
                                <p class="small text-muted mb-0 mt-1"><i class="fa fa-info-circle"></i> Total liability due to suppliers & logs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Income Breakdown -->
                    <div class="col-md-6 col-12">
                        <h6 class="text-bold-600 mb-2 text-uppercase font-small-3" style="letter-spacing: 1px;"><i class="fa fa-arrow-up text-success"></i> Income Breakdown</h6>
                        <div class="list-group list-group-flush">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom-light">
                                <span class="small font-weight-bold"><i class="fa fa-money text-success mr-1"></i> Cash Income</span>
                                <span class="text-bold-700"><?= amountExchange($financial_metrics['income']['Cash'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom-light">
                                <span class="small font-weight-bold"><i class="fa fa-university text-info mr-1"></i> Bank Income</span>
                                <span class="text-bold-700"><?= amountExchange($financial_metrics['income']['Bank'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="small font-weight-bold"><i class="fa fa-id-card-o text-warning mr-1"></i> Cheque Income</span>
                                <span class="text-bold-700"><?= amountExchange($financial_metrics['income']['Cheque'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="bg-light p-2 mt-1 rounded d-flex justify-content-between align-items-center">
                                <span class="text-bold-700">TOTAL INCOME</span>
                                <span class="text-bold-700 text-success" style="font-size: 1.2rem;"><?= amountExchange($financial_metrics['income']['Total'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Expense Breakdown -->
                    <div class="col-md-6 col-12">
                        <h6 class="text-bold-600 mb-2 text-uppercase font-small-3" style="letter-spacing: 1px;"><i class="fa fa-arrow-down text-danger"></i> Expense Breakdown</h6>
                        <div class="list-group list-group-flush">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom-light">
                                <span class="small font-weight-bold"><i class="fa fa-money text-danger mr-1"></i> Cash Expense</span>
                                <span class="text-bold-700"><?= amountExchange($financial_metrics['expense']['Cash'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom-light">
                                <span class="small font-weight-bold"><i class="fa fa-university text-info mr-1"></i> Bank Expense</span>
                                <span class="text-bold-700"><?= amountExchange($financial_metrics['expense']['Bank'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="small font-weight-bold"><i class="fa fa-id-card-o text-warning mr-1"></i> Cheque Expense</span>
                                <span class="text-bold-700"><?= amountExchange($financial_metrics['expense']['Cheque'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="bg-light p-2 mt-1 rounded d-flex justify-content-between align-items-center">
                                <span class="text-bold-700">TOTAL EXPENSE</span>
                                <span class="text-bold-700 text-danger" style="font-size: 1.2rem;"><?= amountExchange($financial_metrics['expense']['Total'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-primary bg-darken-2">
                        <i class="fa fa-file-text-o text-bold-200  font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-primary white media-body">
                        <h5><?php echo $this->lang->line('today') . $this->lang->line('invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> <?= $todayin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-secondary bg-darken-2">
                        <i class="icon-notebook font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-secondary white media-body">
                        <h5><?= $this->lang->line('this') . $this->lang->line('month') . $this->lang->line('invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?= $monthin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-accent bg-darken-2">
                        <i class="icon-basket-loaded font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-accent white media-body">
                        <h5><?= $this->lang->line('today') . $this->lang->line('sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i><?= amountExchange($todaysales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-dark bg-darken-2">
                        <i class="icon-wallet font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-dark white media-body">
                        <h5><?php echo $this->lang->line('this') . $this->lang->line('month') . $this->lang->line('sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i> <?= amountExchange($monthsales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('in_last _30') ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="products-sales" class="height-300"></div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-primary"><?= amountExchange($todayinexp['credit'], 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today') . $this->lang->line('income') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-primary" role="progressbar" style="width: 100%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-secondary"><?= amountExchange($todayinexp['debit'], 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today') . $this->lang->line('expenses') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-secondary" role="progressbar" style="width: 40%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-accent"><?= amountExchange($todayprofit, 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today') . $this->lang->line('Profit') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-accent" role="progressbar" style="width: 60%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-accent"><?= amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('revenue') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-accent" role="progressbar" style="width: 35%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <!-- Intelligence Zone Widget -->
        <div class="card">
            <div class="card-header bg-gradient-x-purple-blue">
                <h4 class="card-title text-white"><i class="fa fa-lightbulb-o"></i> <?= $this->lang->line('intelligence_zone') ?: 'Intelligence Zone' ?></h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <?php if (isset($system_insights) && !empty($system_insights)): ?>
                        <div class="list-group">
                            <?php foreach ($system_insights as $insight): 
                                $bg_class = 'bg-light-info';
                                $icon = 'fa-info-circle';
                                if ($insight['priority'] == 'high') {
                                    $bg_class = 'bg-light-danger';
                                    $icon = 'fa-exclamation-triangle text-danger';
                                } elseif ($insight['priority'] == 'medium') {
                                    $bg_class = 'bg-light-warning';
                                    $icon = 'fa-bell text-warning';
                                } else {
                                    $icon = 'fa-check-circle text-success';
                                }
                            ?>
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start mb-1 <?= $bg_class ?>" style="border-radius: 5px;">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 text-bold-500"><i class="fa <?= $icon ?>"></i> <?= ucwords(str_replace('_', ' ', $insight['insight_type'])) ?></h5>
                                        <small><?= date('H:i', strtotime($insight['created_at'])) ?></small>
                                    </div>
                                    <p class="mb-1 small"><?= $insight['message'] ?></p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-2">
                            <i class="fa fa-smile-o fa-3x text-muted"></i>
                            <p class="mt-1">No critical insights for today.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Buyers</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content px-1">
                <div id="recent-buyers" class="media-list height-450  mt-1 position-relative">
                    <?php
                    if (isset($recent_buy[0]['csd'])) {

                        foreach ($recent_buy as $item) {

                            echo '       <a href="' . base_url('customers/view?id=' . $item['csd']) . '" class="media border-0">
                        <div class="media-left pr-1">
                            <span class="avatar avatar-md avatar-online"><img class="media-object rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $item['picture'] . '">
                            <i></i>
                            </span>
                        </div>
                        <div class="media-body w-100">
                            <h6 class="list-group-item-heading">' . $item['name'] . ' <span class="font-medium-4 float-right pt-1">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</span></h6>
                            <p class="list-group-item-text mb-0"><span class="badge  st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></p>
                        </div>
                    </a>';

                        }
                    } elseif ($recent_buy == 'sql') {
                        echo ' <div class="media-body w-100">  <h5 class="list-group-item-heading bg-danger white">Critical SQL Strict Mode Error: </h5>Please Disable Strict SQL Mode for in database  settings.</div>';
                    }

                    ?>


                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent_invoices') ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <p><span class="float-right"> <a
                                    href="<?php echo base_url() ?>invoices/create"
                                    class="btn btn-timber-primary btn-sm rounded"><?php echo $this->lang->line('Add Sale') ?></a>
                                <a
                                        href="<?php echo base_url() ?>invoices"
                                        class="btn btn-timber-secondary btn-sm rounded"><?php echo $this->lang->line('Manage Invoices') ?></a>
                                <a
                                        href="<?php echo base_url() ?>pos_invoices"
                                        class="btn btn-timber-accent btn-sm rounded"><?php echo $this->lang->line('POS') ?></a></span>
                    </p>
                </div>
            </div>
            <div class="card-content">

                <div class="">
                    <table id="recent-orders" class="table table-hover mb-1">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Invoices') ?>#</th>
                            <th><?php echo $this->lang->line('Customer') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                            <th><?php echo $this->lang->line('Due') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($recent as $item) {
                            $page = 'subscriptions';
                            $t = 'Sub ';
                            if ($item['i_class'] == 0) {
                                $page = 'invoices';
                                $t = '';
                            } elseif ($item['i_class'] == 1) {
                                $page = 'pos_invoices';
                                $t = 'POS ';
                            }
                            echo '    <tr>
                                <td class="text-truncate"><a href="' . base_url() . $page . '/view?id=' . $item['id'] . '">' . $t . '#' . $item['tid'] . '</a></td>
                             
                                <td class="text-truncate"> ' . $item['name'] . '</td>
                                <td class="text-truncate"><span class="badge  st-' . $item['status'] . ' st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></td><td class="text-truncate">' . dateformat($item['invoicedate']) . '</td>
                                <td class="text-truncate">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</td>
                            </tr>';
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Staff Professional Intelligence Section -->
    <style>
        .staff-intel-card { transition: all 0.3s ease; border-radius: 12px !important; overflow: hidden; }
        .staff-intel-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .progress-thin { height: 4px !important; border-radius: 10px; }
        .monitor-display { background: #1e293b; color: #38bdf8; border-radius: 10px; padding: 15px; border: 1px solid #334155; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .table-score { vertical-align: middle !important; }
    </style>
    <div class="col-xl-12 col-lg-12">
        <div class="card border-0 shadow-lg" style="border-radius: 15px;">
            <div class="card-header bg-gradient-x-secondary" style="border-radius: 15px 15px 0 0;">
                <h4 class="card-title text-white"><i class="fa fa-braille"></i> STAFF PROFESSIONAL INTELLIGENCE <span class="badge badge-pill badge-primary ml-1" style="font-size: 10px; background: rgba(255,255,255,0.2);">AI DRIVEN</span></h4>
            </div>
            <div class="card-body">
                <div class="row match-height">
                    <!-- Staff Trust Analytics -->
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <div class="card bg-white border-0 h-100 staff-intel-card shadow-sm">
                            <div class="card-body">
                                <h6 class="text-bold-600 mb-2 text-uppercase" style="letter-spacing: 1px;"><i class="fa fa-shield text-success"></i> Trust Analytics</h6>
                                <?php if(isset($staff_scores_list) && !empty($staff_scores_list)): ?>
                                    <?php foreach(array_slice($staff_scores_list, 0, 3) as $staff): 
                                        $color = ($staff['trust_score'] > 80) ? 'success' : (($staff['trust_score'] > 50) ? 'warning' : 'danger');
                                        $dot = ($staff['trust_score'] > 80) ? 'bg-success' : (($staff['trust_score'] > 50) ? 'bg-warning' : 'bg-danger');
                                    ?>
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="small font-weight-bold text-dark"><span class="status-dot <?= $dot ?>"></span> <?= $staff['username'] ?></span>
                                            <span class="text-bold-600" style="color: <?= ($color == 'success') ? '#28d094' : (($color == 'warning') ? '#ff9149' : '#ff4961') ?>;"><?= round($staff['trust_score']) ?>%</span>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-<?= $color ?>" style="width: <?= $staff['trust_score'] ?>%"></div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-3">
                                        <i class="fa fa-user-o fa-2x text-muted opacity-50"></i>
                                        <p class="text-muted small mt-2">No active staff analytics</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Behaviour Intelligence Engine -->
                    <div class="col-xl-4 col-md-6 col-12 mb-2">
                        <div class="card bg-white border-0 h-100 staff-intel-card shadow-sm">
                            <div class="card-body">
                                <h6 class="text-bold-600 mb-2 text-uppercase" style="letter-spacing: 1px;"><i class="fa fa-microchip text-info"></i> Behaviour Engine</h6>
                                <?php 
                                    $total_overrides = isset($staff_scores_list) ? array_sum(array_column($staff_scores_list, 'overrides')) : 0;
                                    $adj_freq = isset($loss_stats['stock_leak']['count']) ? $loss_stats['stock_leak']['count'] : 0;
                                    $canceled_bills_pct = isset($loss_stats['billing_error']['percentage']) ? $loss_stats['billing_error']['percentage'] : 0;
                                ?>
                                <div class="list-group list-group-flush">
                                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom-light">
                                        <span class="small"><i class="fa fa-tags text-warning mr-1"></i> Price Overrides</span>
                                        <span class="badge badge-warning badge-sm badge-pill"><?= $total_overrides ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom-light">
                                        <span class="small"><i class="fa fa-cubes text-info mr-1"></i> Stock Adjustments</span>
                                        <span class="badge badge-info badge-sm badge-pill"><?= $adj_freq ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center py-1">
                                        <span class="small"><i class="fa fa-file-excel-o text-danger mr-1"></i> Cancelled Bills Rate</span>
                                        <span class="badge badge-danger badge-sm badge-pill"><?= $canceled_bills_pct ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cashier Dashboard Monitor -->
                    <div class="col-xl-4 col-md-12 col-12 mb-2">
                        <div class="card border-0 h-100 staff-intel-card bg-white shadow-sm">
                            <div class="card-body">
                                <h6 class="text-bold-600 mb-2 text-uppercase font-small-3" style="letter-spacing: 1px;"><i class="fa fa-television text-purple"></i> Cashier terminal Monitor</h6>
                                <?php 
                                    $error_rate = isset($loss_stats['billing_error']['percentage']) ? (float)$loss_stats['billing_error']['percentage'] : 0;
                                    $accuracy = 100 - $error_rate;
                                ?>
                                <div class="monitor-display">
                                    <div class="text-center mb-1">
                                        <h2 class="text-bold-700 mb-0" style="color: #38bdf8;"><?= number_format($accuracy, 1) ?>%</h2>
                                        <small class="text-uppercase" style="color: #64748b; letter-spacing: 2px;">ACCURACY INDEX</small>
                                    </div>
                                    <div class="row text-center mt-1">
                                        <div class="col-6" style="border-right: 1px solid #334155;">
                                            <p class="mb-0 small text-white">SPEED</p>
                                            <span class="text-success badge badge-pill" style="background: rgba(40,208,148,0.1); border: 1px solid #28d094;">HIGH</span>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-0 small text-white">ERRORS</p>
                                            <span class="text-<?= ($error_rate > 5) ? 'danger' : 'success' ?>"><?= ($error_rate > 5) ? 'CRITICAL' : 'OPTIMAL' ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                        <span>Status: Operational</span>
                                        <span class="text-primary"><i class="fa fa-refresh fa-spin p-0"></i> Live Data</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>

                <div class="row match-height mt-1">
                    <!-- Staff Performance Scoreboard -->
                    <div class="col-xl-8 col-lg-12 col-12 mb-2">
                        <div class="card border-0 h-100 staff-intel-card bg-white shadow-sm">
                            <div class="card-header p-2 bg-light bg-lighten-4">
                                <h6 class="mb-0 text-bold-600 text-uppercase font-small-3" style="letter-spacing: 1px;"><i class="fa fa-list-ol text-primary"></i> Staff Performance Leaderboard</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr class="text-uppercase font-small-2 text-muted">
                                            <th class="border-0">Staff Member</th>
                                            <th class="text-center border-0">Sales</th>
                                            <th class="text-center border-0">Errors</th>
                                            <th class="text-center border-0">Returns</th>
                                            <th class="text-center border-0">Status</th>
                                            <th class="text-center border-0">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-small-3">
                                        <?php if(isset($staff_scores_list) && !empty($staff_scores_list)): ?>
                                            <?php foreach($staff_scores_list as $staff): 
                                                $score_color = ($staff['trust_score'] > 80) ? 'success' : (($staff['trust_score'] > 50) ? 'warning' : 'danger');
                                                $traffic_dot = ($staff['trust_score'] > 80) ? 'bg-success' : (($staff['trust_score'] > 50) ? 'bg-warning' : 'bg-danger');
                                            ?>
                                            <tr>
                                                <td class="text-bold-600 table-score"><img src="<?= base_url() ?>assets/images/portrait/small/avatar-s-1.png" class="rounded-circle mr-1" width="24"> <?= $staff['username'] ?></td>
                                                <td class="text-center table-score"><?= amountExchange($staff['sales'], 0, $this->aauth->get_user()->loc) ?></td>
                                                <td class="text-center table-score font-weight-bold text-<?= ($staff['errors'] > 5) ? 'danger' : 'muted' ?>"><?= $staff['errors'] ?></td>
                                                <td class="text-center table-score"><?= $staff['returns'] ?></td>
                                                <td class="text-center table-score"><span class="status-dot <?= $traffic_dot ?>"></span></td>
                                                <td class="text-center table-score"><span class="badge badge-<?= $score_color ?>" style="min-width: 45px; opacity: 0.9;"><?= round($staff['trust_score']) ?>%</span></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">Analytical engines standby. Awaiting staff data flows...</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Fraud Alert Center -->
                    <div class="col-xl-4 col-lg-12 col-12 mb-2">
                        <div class="card bg-gradient-x-danger h-100 staff-intel-card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="white mb-2 text-uppercase font-small-3" style="letter-spacing: 1px;"><i class="fa fa-warning"></i> Fraud Alert Center</h6>
                                <div class="bg-white p-2" style="border-radius: 10px; border-left: 5px solid #ff4b2b; box-shadow: inset 0 0 10px rgba(0,0,0,0.05);">
                                    <?php if(isset($risk_alerts) && !empty($risk_alerts)): 
                                        $alert = $risk_alerts[0]; // Most recent alert
                                    ?>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge badge-danger badge-pill">CRITICAL</span>
                                            <small class="text-muted"><?= date('M d, H:i') ?></small>
                                        </div>
                                        <h5 class="text-bold-700 text-danger mb-1"><?= $alert['type'] ?> detected</h5>
                                        <div class="d-flex justify-content-between mb-1 small text-dark">
                                            <span><strong>Staff:</strong> Admin</span>
                                            <span><strong>ID:</strong> #RX-99</span>
                                        </div>
                                        <hr class="my-1 opacity-25">
                                        <p class="font-small-3 mb-0 text-dark" style="line-height: 1.4;"><strong>Insight:</strong> <?= $alert['message'] ?></p>
                                    <?php else: ?>
                                        <div class="text-center py-2">
                                            <div class="mb-1"><i class="fa fa-shield text-success fa-2x"></i></div>
                                            <h5 class="text-bold-700 text-success mb-1">NO THREATS</h5>
                                            <p class="font-small-2 mb-0 text-muted">Awaiting signal anomalies...</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-right mt-2">
                                    <button class="btn btn-sm btn-link white text-uppercase font-small-2 p-0" style="text-decoration: underline;">Full Security Audit <i class="fa fa-chevron-right ml-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header bg-gradient-x-cyan">
                <h4 class="card-title text-white"><i class="fa fa-map-marker"></i> Branch Performance Heatmap</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <?php if(isset($branches) && !empty($branches)): ?>
                            <?php foreach($branches as $branch): 
                                // Calculate heat color based on profit
                                $profit = $branch['total_sales'] - $branch['total_expenses'];
                                $heat_class = 'bg-light';
                                $text_class = 'text-dark';
                                
                                if($profit > 100000) { $heat_class = 'bg-success text-white'; $text_class='text-white'; }
                                elseif($profit > 50000) { $heat_class = 'bg-info text-white'; $text_class='text-white'; }
                                elseif($profit > 0) { $heat_class = 'bg-warning text-white'; $text_class='text-white'; }
                                else { $heat_class = 'bg-danger text-white'; $text_class='text-white'; }
                            ?>
                            <div class="col-xl-3 col-md-6 col-12 mb-2">
                                <div class="card <?= $heat_class ?> border-0 shadow" style="cursor: pointer;" onclick="window.location.href='?branch_id=<?= $branch['id'] ?>'">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h4 class="<?= $text_class ?> mb-0"><?= $branch['name'] ?></h4>
                                                <span class="<?= $text_class ?> small">Sales: <?= amountExchange($branch['total_sales'], 0, $this->aauth->get_user()->loc) ?></span>
                                            </div>
                                            <div class="align-self-center">
                                                <h3 class="<?= $text_class ?>"><?= amountExchange($profit, 0, $this->aauth->get_user()->loc) ?></h3>
                                                <small class="<?= $text_class ?>">Net Profit</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <p class="text-muted">No branch data available for heatmap.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header bg-gradient-danger">
                <h4 class="card-title text-white"><i class="ft-alert-triangle"></i> <?= $this->lang->line('loss_control') ?: 'Loss Control Center' ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    // Calculate traffic light status for each loss type
                    $stock_leak_pct = isset($loss_stats['stock_leak']['percentage']) ? $loss_stats['stock_leak']['percentage'] : 0;
                    $billing_error_count = isset($loss_stats['billing_error']['count']) ? $loss_stats['billing_error']['count'] : 0;
                    $return_abuse_pct = isset($loss_stats['return_abuse']['percentage']) ? $loss_stats['return_abuse']['percentage'] : 0;
                    
                    // Determine status colors
                    function getLossStatus($percentage, $type = 'percentage') {
                        if ($type == 'count') {
                            if ($percentage > 10) return 'danger';
                            if ($percentage > 5) return 'warning';
                            return 'success';
                        }
                        if ($percentage >= 5) return 'danger';
                        if ($percentage >= 2) return 'warning';
                        return 'success';
                    }
                    
                    $stock_status = getLossStatus($stock_leak_pct);
                    $billing_status = getLossStatus($billing_error_count, 'count');
                    $return_status = getLossStatus($return_abuse_pct);
                    ?>
                    
                    <!-- Stock Leak Indicator -->
                    <div class="col-md-4 col-sm-12">
                        <div class="text-center mb-2">
                            <div class="loss-traffic-light bg-<?= $stock_status ?>" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <h2 class="text-white mb-0"><?= number_format($stock_leak_pct, 1) ?>%</h2>
                            </div>
                            <h5 class="mt-2"><?= $this->lang->line('stock_leak') ?: 'Stock Leak' ?></h5>
                            <p class="text-muted">
                                <small>
                                    <?php if ($stock_status == 'danger'): ?>
                                        <i class="ft-alert-circle text-danger"></i> Critical - Immediate action required
                                    <?php elseif ($stock_status == 'warning'): ?>
                                        <i class="ft-alert-triangle text-warning"></i> Warning - Monitor closely
                                    <?php else: ?>
                                        <i class="ft-check-circle text-success"></i> Under control
                                    <?php endif; ?>
                                </small>
                            </p>
                            <span class="badge badge-<?= $stock_status ?>">
                                Rs <?= number_format($loss_stats['stock_leak']['amount'] ?? 0, 0) ?> Lost
                            </span>
                        </div>
                    </div>
                    
                    <!-- Billing Errors Indicator -->
                    <div class="col-md-4 col-sm-12">
                        <div class="text-center mb-2">
                            <div class="loss-traffic-light bg-<?= $billing_status ?>" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <h2 class="text-white mb-0"><?= $billing_error_count ?></h2>
                            </div>
                            <h5 class="mt-2"><?= $this->lang->line('billing_errors') ?: 'Billing Errors' ?></h5>
                            <p class="text-muted">
                                <small>
                                    <?php if ($billing_status == 'danger'): ?>
                                        <i class="ft-alert-circle text-danger"></i> Too many errors
                                    <?php elseif ($billing_status == 'warning'): ?>
                                        <i class="ft-alert-triangle text-warning"></i> Elevated errors
                                    <?php else: ?>
                                        <i class="ft-check-circle text-success"></i> Minimal errors
                                    <?php endif; ?>
                                </small>
                            </p>
                            <span class="badge badge-<?= $billing_status ?>">
                                <?= $billing_error_count ?> Errors Today
                            </span>
                        </div>
                    </div>
                    
                    <!-- Return Abuse Indicator -->
                    <div class="col-md-4 col-sm-12">
                        <div class="text-center mb-2">
                            <div class="loss-traffic-light bg-<?= $return_status ?>" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <h2 class="text-white mb-0"><?= number_format($return_abuse_pct, 1) ?>%</h2>
                            </div>
                            <h5 class="mt-2"><?= $this->lang->line('return_abuse') ?: 'Return Abuse' ?></h5>
                            <p class="text-muted">
                                <small>
                                    <?php if ($return_status == 'danger'): ?>
                                        <i class="ft-alert-circle text-danger"></i> Suspicious pattern
                                    <?php elseif ($return_status == 'warning'): ?>
                                        <i class="ft-alert-triangle text-warning"></i> Watch for abuse
                                    <?php else: ?>
                                        <i class="ft-check-circle text-success"></i> Normal returns
                                    <?php endif; ?>
                                </small>
                            </p>
                            <span class="badge badge-<?= $return_status ?>">
                                <?= $loss_stats['return_abuse']['count'] ?? 0 ?> Returns
                            </span>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <!-- Total Estimated Monthly Loss -->
                <div class="row">
                    <div class="col-12 text-center">
                        <h5 class="text-danger">
                            <i class="ft-trending-down"></i> <?= $this->lang->line('estimated_monthly_loss') ?: 'Estimated Monthly Hidden Loss' ?>
                        </h5>
                        <?php
                        $total_monthly_loss = ($loss_stats['stock_leak']['amount'] ?? 0) * 30 + 
                                            ($loss_stats['billing_error']['amount'] ?? 0) * 30 + 
                                            ($loss_stats['return_abuse']['amount'] ?? 0);
                        ?>
                        <h2 class="text-danger font-weight-bold">
                            Rs <?= number_format($total_monthly_loss, 2) ?>
                        </h2>
                        <p class="text-muted">
                            <small>Based on current daily loss patterns. <?= $this->lang->line('loss_prevented') ?: 'Loss Prevented' ?>: Rs <?= number_format($loss_stats['prevented_loss'] ?? 0, 2) ?></small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


   <div class="col-xl-4 col-lg-12">
        <div class="card">
             <div class="card-header">
                <h4 class="card-title">Quick Actions</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <a href="<?php echo base_url('invoices/create') ?>" class="btn btn-timber-primary btn-block mb-1"><i class="ft-file-plus"></i> New Invoice</a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url('quote/create') ?>" class="btn btn-timber-secondary btn-block mb-1"><i class="ft-file-text"></i> New Quote</a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url('products/add') ?>" class="btn btn-timber-accent btn-block mb-1"><i class="ft-box"></i> Add Product</a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url('customers/create') ?>" class="btn btn-timber-dark btn-block mb-1"><i class="ft-user-plus"></i> Add Client</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="row">
    <div class="col-12">
        <div class="card-group">
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-primary"><?php $ipt = sprintf("%0.0f", ($tt_inc * 100) / $goals['income']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class=" font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('income') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($tt_inc, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['income'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-money primary font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-primary" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-secondary"><?php $ipt = sprintf("%0.0f", ($tt_exp * 100) / $goals['expense']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('expenses') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($tt_exp, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['expense'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-external-link red font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-secondary" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-accent"><?php $ipt = sprintf("%0.0f", ($monthsales * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('sales') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($monthsales, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['sales'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-flag blue font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-accent" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-dark"><?php $ipt = sprintf("%0.0f", (($tt_inc - $tt_exp) * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('net_income') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['netincome'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-inbox purple font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-dark" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card" id="transactions">

            <div class="card-body">
                <h4><?php echo $this->lang->line('cashflow') ?></h4>
                <p><?php echo $this->lang->line('graphical_presentation') ?></p>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                           href="#sales"
                           aria-expanded="true"><?php echo $this->lang->line('income') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                           href="#transactions1"
                           aria-expanded="false"><?php echo $this->lang->line('expenses') ?></a>
                    </li>


                </ul>
                <div class="tab-content pt-1">
                    <div role="tabpanel" class="tab-pane active" id="sales" aria-expanded="true"
                         data-toggle="tab">
                        <div id="dashboard-income-chart"></div>

                    </div>
                    <div class="tab-pane" id="transactions1" data-toggle="tab" aria-expanded="false">
                        <div id="dashboard-expense-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 



    <div class="col-xl-4 col-lg-12">
        <div class="card">
             <div class="card-header">
                <h4 class="card-title">My Pending Tasks</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php if (isset($tasks) && is_array($tasks)): ?>
                        <?php foreach ($tasks as $task): ?>
                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="ft-check-square text-timber-primary"></i> 
                                    <?= $task['name'] ?>
                                </span>
                                <span class="badge bg-timber-secondary badge-pill"><?= date('M d', strtotime($task['duedate'])) ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-muted">No pending tasks.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>





</div>
<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent') ?> <a
                            href="<?php echo base_url() ?>transactions"
                            class="btn btn-timber-primary btn-sm rounded"><?php echo $this->lang->line('Transactions') ?></a>
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
                                <td class="text-truncate"><a href="' . base_url() . 'transactions/view?id=' . $item['id'] . '">' . dateformat($item['date']) . '</a></td>
                                <td class="text-truncate"> ' . $item['account'] . '</td>
                                <td class="text-truncate">' . amountExchange($item['debit'], 0, $this->aauth->get_user()->loc) . '</td>
                                <td class="text-truncate">' . amountExchange($item['credit'], 0, $this->aauth->get_user()->loc) . '</td>                    
                                <td class="text-truncate">' . $this->lang->line($item['method']) . '</td>
                            </tr>';

                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
      <div class="col-xl-4 col-lg-12">
        <div class="card">
             <div class="card-header">
                <h4 class="card-title">Advanced Timber Calculator</h4>
                <ul class="nav nav-pills mt-2 nav-justified" id="timberCalcTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-log-ft" data-toggle="pill" href="#mode-log-ft" role="tab" aria-selected="true" onclick="setCalcMode('log-ft')">Log (ft³)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-plank-ft" data-toggle="pill" href="#mode-plank-ft" role="tab" aria-selected="false" onclick="setCalcMode('plank-ft')">Plank (ft³)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-log-m" data-toggle="pill" href="#mode-log-m" role="tab" aria-selected="false" onclick="setCalcMode('log-m')">Log (m³)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-plank-m" data-toggle="pill" href="#mode-plank-m" role="tab" aria-selected="false" onclick="setCalcMode('plank-m')">Plank (m³)</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form id="timber-calc-form">
                    <div class="tab-content">
                        <!-- Mode 1: Log Cubic Feet -->
                        <div class="tab-pane fade show active" id="mode-log-ft" role="tabpanel">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-ft-d" placeholder="Mid Diameter (in)">
                                    <small class="form-text text-muted">Mid-Diameter (in)</small>
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-ft-l" placeholder="Length (ft)">
                                    <small class="form-text text-muted">Length (ft)</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mode 2: Plank Cubic Feet -->
                        <div class="tab-pane fade" id="mode-plank-ft" role="tabpanel">
                             <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-ft-t" placeholder="T (in)">
                                    <small class="form-text text-muted">Thick (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-ft-w" placeholder="W (in)">
                                    <small class="form-text text-muted">Width (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-ft-l" placeholder="L (ft)">
                                    <small class="form-text text-muted">Length (ft)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Mode 3: Log Cubic Meter -->
                        <div class="tab-pane fade" id="mode-log-m" role="tabpanel">
                             <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-m-d" placeholder="Mid Diameter (cm)">
                                    <small class="form-text text-muted">Mid-Diameter (cm)</small>
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-m-l" placeholder="Length (m)">
                                    <small class="form-text text-muted">Length (m)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Mode 4: Plank Cubic Meter -->
                        <div class="tab-pane fade" id="mode-plank-m" role="tabpanel">
                             <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-m-t" placeholder="T (in)">
                                    <small class="form-text text-muted">Thick (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-m-w" placeholder="W (in)">
                                    <small class="form-text text-muted">Width (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-m-l" placeholder="L (m)">
                                    <small class="form-text text-muted">Length (m)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-timber-primary btn-block" onclick="calculateTimber()">Calculate Volume</button>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12 text-center">
                            <h4 id="calc-result" class="text-timber-primary font-weight-bold mt-1">-</h4>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var currentMode = 'log-ft';

        function setCalcMode(mode) {
            currentMode = mode;
            document.getElementById('calc-result').innerText = "-";
        }

        function calculateTimber() {
            var result = 0;
            var unit = "";

            if (currentMode === 'log-ft') {
                // Log Cubic Feet: V = (π * (D/24)^2) * L
                var d = parseFloat(document.getElementById('log-ft-d').value) || 0;
                var l = parseFloat(document.getElementById('log-ft-l').value) || 0;
                if(d > 0 && l > 0) {
                     // D is in inches, L is in feet. Radius in feet = (d/12)/2 = d/24
                    var r_ft = d / 24.0;
                    result = Math.PI * Math.pow(r_ft, 2) * l;
                    unit = "ft³ (Logs)";
                }
            } else if (currentMode === 'plank-ft') {
                // Plank Cubic Feet: (T_in * W_in * L_ft) / 144
                var t = parseFloat(document.getElementById('plank-ft-t').value) || 0;
                var w = parseFloat(document.getElementById('plank-ft-w').value) || 0;
                var l = parseFloat(document.getElementById('plank-ft-l').value) || 0;
                if(t > 0 && w > 0 && l > 0) {
                    result = (t * w * l) / 144.0;
                    unit = "ft³ (Planks)";
                }
            } else if (currentMode === 'log-m') {
                // Log Cubic Meters: V = (π * (D_cm/200)^2) * L_m
                var d = parseFloat(document.getElementById('log-m-d').value) || 0; // cm
                var l = parseFloat(document.getElementById('log-m-l').value) || 0; // m
                if(d > 0 && l > 0) {
                    // Radius in meters = (d/100)/2 = d/200
                    var r_m = d / 200.0;
                    result = Math.PI * Math.pow(r_m, 2) * l;
                    unit = "m³ (Logs)";
                }
            } else if (currentMode === 'plank-m') {
                // Plank Cubic Meters: (T_in * W_in * L_m) converted
                var t = parseFloat(document.getElementById('plank-m-t').value) || 0; // in
                var w = parseFloat(document.getElementById('plank-m-w').value) || 0; // in
                var l = parseFloat(document.getElementById('plank-m-l').value) || 0; // m
                if(t > 0 && w > 0 && l > 0) {
                    // Convert inches to meters: * 0.0254
                    var t_m = t * 0.0254;
                    var w_m = w * 0.0254;
                    result = t_m * w_m * l;
                    unit = "m³ (Planks)";
                }
            }

            if (result > 0) {
                document.getElementById('calc-result').innerText = result.toFixed(3) + " " + unit;
            } else {
                 document.getElementById('calc-result').innerText = "Invalid Input";
            }
        }
    </script>
  

















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
            pointSize: 0,
            pointStrokeColors: ['#2E7D32', '#795548', '#FFC107'],
            smooth: true,
            gridLineColor: '#E4E7ED',
            numLines: 6,
            gridtextSize: 14,
            lineWidth: 0,
            fillOpacity: 0.9,
            hideHover: 'auto',
            lineColors: ['#2E7D32', '#795548']
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
                '#2E7D32',
            ],
            pointFillColors: [
                '#2E7D32',
            ],
            fillOpacity: 0.4,
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
                '#795548',
            ],
            pointFillColors: [
                '#8D6E63',
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
        colors: ['#2E7D32', '#795548'],
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
        <a href="<?= base_url('pos_invoices/create') ?>" target="_blank" title="New Sale">
            <span class="material-icons"><i class="fa fa-shopping-cart"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('stock_transfer') ?>" target="_blank" title="Stock Transfer">
            <span class="material-icons"><i class="fa fa-truck"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('tickets') ?>" target="_blank" title="Flag Issue">
            <span class="material-icons"><i class="fa fa-flag"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('reports') ?>" target="_blank" title="Detailed Report">
            <span class="material-icons"><i class="fa fa-bar-chart"></i></span>
        </a>
    </div>
    <div class="sub-button shadow">
        <a href="<?= base_url('transactions') ?>" target="_blank" title="Approve Transactions">
            <span class="material-icons"><i class="fa fa-check-square-o"></i></span>
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
    background: #673AB7; /* Deep Purple */
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