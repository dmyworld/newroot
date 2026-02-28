<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-body">
    <!-- Demo Mode Banner -->
    <?php if(isset($sample_mode) && $sample_mode): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-info-circle"></i> Demo Mode Active!</strong>
                You are currently viewing <strong>sample data</strong> to explore the report capabilities. Real data will appear as your inventory activity grows.
                <a href="<?= current_url() . '?branch_id=' . $current_branch ?>" class="btn btn-sm btn-outline-primary ml-2">Back to Real Data</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header with Filters -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-gradient-x-danger">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="text-white mb-0"><i class="fa fa-archive"></i> Dead Stock Analysis</h3>
                            <p class="text-white mb-0 small">Identify and manage non-moving inventory</p>
                        </div>
                        <div class="col-md-6">
                            <form method="get" class="text-right">
                                <select name="branch_id" class="form-control d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="0">All Branches</option>
                                    <?php if(isset($locations)) { foreach ($locations as $loc) { ?>
                                        <option value="<?= $loc['id'] ?>" <?= ($current_branch == $loc['id']) ? 'selected' : '' ?>>
                                            <?= $loc['cname'] ?>
                                        </option>
                                    <?php } } ?>
                                </select>
                                <a href="<?= base_url('dashboard') ?>" class="btn btn-white btn-sm ml-2">
                                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-danger font-weight-bold"><?= $summary['dead_stock_count'] ?></h2>
                    <p class="mb-0">Dead Stock Items</p>
                    <small class="text-muted">No sales in 90+ days</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-danger font-weight-bold"><?= amountExchange($summary['dead_stock_value'], 0, $this->aauth->get_user()->loc) ?></h2>
                    <p class="mb-0">Dead Stock Value</p>
                    <small class="text-muted">Locked capital</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-warning font-weight-bold"><?= $summary['slow_moving_count'] ?></h2>
                    <p class="mb-0">Slow Moving Items</p>
                    <small class="text-muted">< 3 sales in 60 days</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-warning font-weight-bold"><?= amountExchange($summary['slow_moving_value'], 0, $this->aauth->get_user()->loc) ?></h2>
                    <p class="mb-0">Slow Moving Value</p>
                    <small class="text-muted">At-risk inventory</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Dead Stock Items Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="card-title text-white mb-0">
                        <i class="fa fa-times-circle"></i> Dead Stock Items (No Sales in 90+ Days)
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="dead-stock-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Warehouse</th>
                                    <th>Qty on Hand</th>
                                    <th>Unit Price</th>
                                    <th>Dead Stock Value</th>
                                    <th>Last Sale Date</th>
                                    <th>Days Since Sale</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dead_stock_items)): ?>
                                    <?php foreach ($dead_stock_items as $item): ?>
                                        <tr>
                                            <td><?= $item['product_code'] ?></td>
                                            <td><?= $item['product_name'] ?></td>
                                            <td><?= $item['warehouse_name'] ?></td>
                                            <td class="text-right"><?= number_format($item['qty'], 2) ?></td>
                                            <td class="text-right"><?= amountExchange($item['price'], 0, $this->aauth->get_user()->loc) ?></td>
                                            <td class="text-right text-danger font-weight-bold">
                                                <?= amountExchange($item['dead_stock_value'], 0, $this->aauth->get_user()->loc) ?>
                                            </td>
                                            <td><?= $item['last_sale_date'] ? date('M d, Y', strtotime($item['last_sale_date'])) : 'Never' ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-danger"><?= $item['days_since_sale'] ?? '∞' ?> days</span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('products/view?id=' . $item['id']) ?>" class="btn btn-sm btn-info" title="View Product">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-success py-4">
                                            <i class="fa fa-check-circle fa-4x mb-2"></i>
                                            <p class="lead">No dead stock found! Excellent inventory management.</p>
                                            <?php if(!isset($sample_mode) || !$sample_mode): ?>
                                            <p class="text-muted small">Want to see how this report looks with data?</p>
                                            <a href="<?= current_url() ?>?sample=1" class="btn btn-danger btn-lg mt-1">
                                                <i class="fa fa-flask"></i> Try Demo Mode with Sample Data
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slow Moving Items Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4 class="card-title text-white mb-0">
                        <i class="fa fa-clock-o"></i> Slow Moving Items (< 3 Sales in 60 Days)
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="slow-moving-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Qty on Hand</th>
                                    <th>Unit Price</th>
                                    <th>Stock Value</th>
                                    <th>Sales Count (60d)</th>
                                    <th>Days Since Sale</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($slow_moving_items)): ?>
                                    <?php foreach ($slow_moving_items as $item): ?>
                                        <tr>
                                            <td><?= $item['product_code'] ?></td>
                                            <td><?= $item['product_name'] ?></td>
                                            <td class="text-right"><?= number_format($item['qty'], 2) ?></td>
                                            <td class="text-right"><?= amountExchange($item['price'], 0, $this->aauth->get_user()->loc) ?></td>
                                            <td class="text-right text-warning font-weight-bold">
                                                <?= amountExchange($item['stock_value'], 0, $this->aauth->get_user()->loc) ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-warning"><?= $item['sales_count'] ?> sales</span>
                                            </td>
                                            <td class="text-center"><?= $item['days_since_sale'] ?? 'N/A' ?> days</td>
                                            <td>
                                                <a href="<?= base_url('products/view?id=' . $item['id']) ?>" class="btn btn-sm btn-info" title="View Product">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-success">
                                            <i class="fa fa-thumbs-up fa-3x mb-2"></i>
                                            <p class="mb-0">All products are selling well! No slow-moving items detected.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-gradient-x-primary">
                    <h4 class="card-title text-white mb-0">
                        <i class="fa fa-lightbulb-o"></i> Recommendations
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-danger"><i class="fa fa-exclamation-triangle"></i> For Dead Stock:</h5>
                            <ul>
                                <li>Consider aggressive discounting (50-70% off)</li>
                                <li>Bundle with fast-moving items</li>
                                <li>Donate for tax benefits</li>
                                <li>Return to supplier if possible</li>
                                <li>Liquidate through clearance sales</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-warning"><i class="fa fa-clock-o"></i> For Slow-Moving Items:</h5>
                            <ul>
                                <li>Run promotional campaigns (20-30% off)</li>
                                <li>Improve product placement/visibility</li>
                                <li>Create combo offers</li>
                                <li>Stop reordering until stock clears</li>
                                <li>Market to specific customer segments</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTables for better sorting/filtering
    if ($.fn.DataTable) {
        $('#dead-stock-table').DataTable({
            "order": [[ 5, "desc" ]], // Sort by value descending
            "pageLength": 25,
            "dom": 'Bfrtip',
            "buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
        });
        
        $('#slow-moving-table').DataTable({
            "order": [[ 5, "asc" ]], // Sort by sales count ascending
            "pageLength": 25,
            "dom": 'Bfrtip',
            "buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    }
});
</script>
