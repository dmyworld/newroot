<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .timber-dashboard { padding: 30px; }
        .lux-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: none; overflow: hidden; height: 100%; transition: all 0.3s; }
        .lux-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .gradient-blue { background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%); color: white; }
        .gradient-green { background: linear-gradient(135deg, #13ec5b 0%, #0fc94d 100%); color: white; }
        .stat-icon { font-size: 40px; opacity: 0.3; position: absolute; right: 20px; bottom: 20px; }
        .shortcut-btn { display: flex; align-items: center; gap: 15px; padding: 20px; border-radius: 12px; background: #f8f9fa; border: 1px solid #eee; text-decoration: none; color: #333; font-weight: 600; margin-bottom: 15px; transition: all 0.2s; }
        .shortcut-btn:hover { background: #eef2ff; border-color: #2a5298; color: #2a5298; }
        .shortcut-btn i { font-size: 24px; color: #2a5298; }
        .welcome-section { margin-bottom: 40px; }
        .welcome-section h2 { color: #2a5298; font-weight: 800; }
    </style>
</head>
<body>
<div class="timber-dashboard">
    <div class="welcome-section">
        <h2>Timber Pro Hub</h2>
        <p class="text-muted">Central Command for Timber Operations, Inventory, and Marketplace.</p>
    </div>

    <div class="row mb-4">
        <!-- Standing Trees -->
        <div class="col-md-3">
            <div class="lux-card gradient-blue p-4 position-relative">
                <p class="mb-0">Standing Trees</p>
                <h3 class="font-weight-bold"><?= number_format($stats['standing']['total_lots']) ?> Lots</h3>
                <i class="fa fa-tree stat-icon"></i>
            </div>
        </div>
        <!-- Logs -->
        <div class="col-md-3">
            <div class="lux-card gradient-green p-4 position-relative">
                <p class="mb-0">Logs Inventory</p>
                <h3 class="font-weight-bold"><?= number_format($stats['logs']['total_volume'], 2) ?> <small>CFT</small></h3>
                <p class="small mb-0 opacity-75"><?= $stats['logs']['total_lots'] ?> Lots</p>
                <i class="fa fa-cubes stat-icon"></i>
            </div>
        </div>
        <!-- Sawn -->
        <div class="col-md-3">
            <div class="lux-card gradient-blue p-4 position-relative">
                <p class="mb-0">Sawn Timber</p>
                <h3 class="font-weight-bold"><?= number_format($stats['sawn']['total_volume'], 2) ?> <small>CFT</small></h3>
                <p class="small mb-0 opacity-75"><?= $stats['sawn']['total_lots'] ?> Lots</p>
                <i class="fa fa-th stat-icon"></i>
            </div>
        </div>
        <!-- Marketplace -->
        <div class="col-md-3">
            <div class="lux-card gradient-green p-4 position-relative">
                <p class="mb-0">Marketplace Requests</p>
                <h3 class="font-weight-bold"><?= number_format($stats['requests']['total_requests']) ?> Active</h3>
                <i class="fa fa-shopping-cart stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="lux-card p-4">
                <h5 class="mb-4">Quick Shortcuts</h5>
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= base_url('TimberPro/input') ?>" class="shortcut-btn">
                            <i class="fa fa-plus-circle"></i>
                            <span>New Timber Input (A-D)</span>
                        </a>
                        <a href="<?= base_url('Calculator') ?>" class="shortcut-btn">
                            <i class="fa fa-calculator"></i>
                            <span>Advanced Timber Calculator</span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= base_url('Marketplace') ?>" class="shortcut-btn">
                            <i class="fa fa-store"></i>
                            <span>Browse Marketplace</span>
                        </a>
                        <a href="<?= base_url('TimberPro/bulk_upload') ?>" class="shortcut-btn">
                            <i class="fa fa-upload"></i>
                            <span>Bulk Data Upload</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="lux-card p-4">
                <h5 class="mb-4">Recent Alerts</h5>
                <div class="alert alert-info border-0" style="background: #eef2ff; color: #2a5298;">
                    <i class="fa fa-info-circle mr-2"></i> New log lot added to Branch Stock.
                </div>
                <div class="alert alert-success border-0" style="background: #dcfce7; color: #166534;">
                    <i class="fa fa-check-circle mr-2"></i> Marketplace inquiry received for "Teak Log Lot #102".
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
