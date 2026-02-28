<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-body">
    <!-- Demo Mode Banner -->
    <?php if(isset($sample_mode) && $sample_mode): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-info-circle"></i> Demo Mode Active!</strong>
                You are currently viewing <strong>sample data</strong> to explore the report capabilities. Real data will appear as your sales activity grows.
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
            <div class="card bg-gradient-x-success">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="text-white mb-0"><i class="fa fa-rocket"></i> Fast-Moving Stock Analysis</h3>
                            <p class="text-white mb-0 small">High-velocity products driving your revenue</p>
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
                    <h2 class="text-success font-weight-bold"><?= $summary['fast_moving_count'] ?></h2>
                    <p class="mb-0">Fast-Moving Products</p>
                    <small class="text-muted">10+ sales in 30 days</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-success font-weight-bold"><?= amountExchange($summary['fast_moving_value'], 0, $this->aauth->get_user()->loc) ?></h2>
                    <p class="mb-0">Stock Value</p>
                    <small class="text-muted">High-velocity inventory</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-primary font-weight-bold"><?= number_format($summary['total_sales']) ?></h2>
                    <p class="mb-0">Total Transactions</p>
                    <small class="text-muted">Last 30 days</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-info font-weight-bold"><?= number_format($summary['avg_sales_per_product'], 1) ?></h2>
                    <p class="mb-0">Avg Sales/Product</p>
                    <small class="text-muted">Performance metric</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Fast-Moving Items Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title text-white mb-0">
                        <i class="fa fa-line-chart"></i> Fast-Moving Products (10+ Sales in Last 30 Days)
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="fast-moving-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Qty on Hand</th>
                                    <th>Unit Price</th>
                                    <th>Stock Value</th>
                                    <th>Sales (30d)</th>
                                    <th>Qty Sold</th>
                                    <th>Avg/Sale</th>
                                    <th>Last Sale</th>
                                    <th>Reorder Point</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($fast_moving_items)): ?>
                                    <?php 
                                    $rank = 1;
                                    foreach ($fast_moving_items as $item): 
                                        // Determine if stock is low
                                        $stock_status = '';
                                        $stock_class = 'text-success';
                                        
                                        if ($item['qty'] <= $item['reorder_point']) {
                                            $stock_status = '<i class="fa fa-exclamation-triangle"></i> Low Stock';
                                            $stock_class = 'text-danger';
                                        } elseif ($item['qty'] <= ($item['reorder_point'] * 1.5)) {
                                            $stock_status = '<i class="fa fa-info-circle"></i> Reorder Soon';
                                            $stock_class = 'text-warning';
                                        } else {
                                            $stock_status = '<i class="fa fa-check-circle"></i> In Stock';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php if ($rank <= 3): ?>
                                                    <span class="badge badge-warning font-medium-1">#<?= $rank ?></span>
                                                <?php else: ?>
                                                    <?= $rank ?>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $item['product_code'] ?></td>
                                            <td><strong><?= $item['product_name'] ?></strong></td>
                                            <td class="text-right <?= $stock_class ?>">
                                                <?= number_format($item['qty'], 2) ?>
                                                <?php if ($item['qty'] <= $item['reorder_point']): ?>
                                                    <i class="fa fa-exclamation-triangle text-danger"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-right"><?= amountExchange($item['price'], 0, $this->aauth->get_user()->loc) ?></td>
                                            <td class="text-right text-success font-weight-bold">
                                                <?= amountExchange($item['stock_value'], 0, $this->aauth->get_user()->loc) ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success font-medium-1"><?= $item['sales_count'] ?> sales</span>
                                            </td>
                                            <td class="text-right"><?= number_format($item['total_qty_sold'], 2) ?></td>
                                            <td class="text-right"><?= number_format($item['avg_qty_per_sale'], 2) ?></td>
                                            <td class="text-center">
                                                <?= $item['last_sale_date'] ? date('M d, Y', strtotime($item['last_sale_date'])) : 'N/A' ?>
                                                <br>
                                                <small class="text-muted"><?= $item['days_since_sale'] ?? 0 ?> days ago</small>
                                            </td>
                                            <td class="text-center">
                                                <?= number_format($item['reorder_point'], 0) ?>
                                                <br>
                                                <small class="<?= $stock_class ?>"><?= $stock_status ?></small>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('products/view?id=' . $item['id']) ?>" class="btn btn-sm btn-info" title="View Product">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php 
                                    $rank++;
                                    endforeach; 
                                    ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" class="text-center text-warning py-4">
                                            <i class="fa fa-info-circle fa-4x mb-2"></i>
                                            <p class="lead">No fast-moving products found. Products need 5+ sales in the last 30 days to qualify.</p>
                                            <?php if(!isset($sample_mode) || !$sample_mode): ?>
                                            <p class="text-muted small">Want to see how this report looks with data?</p>
                                            <a href="<?= current_url() ?>?sample=1" class="btn btn-success btn-lg mt-1">
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

    <!-- Insights & Recommendations -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-gradient-x-success">
                    <h4 class="card-title text-white mb-0">
                        <i class="fa fa-lightbulb-o"></i> Stock Management Tips
                    </h4>
                </div>
                <div class="card-body">
                    <h5 class="text-success"><i class="fa fa-check-circle"></i> Keep These Best Sellers Moving:</h5>
                    <ul>
                        <li><strong>Monitor Stock Levels:</strong> Ensure adequate inventory to prevent stockouts</li>
                        <li><strong>Optimize Reorder Points:</strong> Set alerts before reaching critical levels</li>
                        <li><strong>Negotiate Better Pricing:</strong> High volume = better supplier deals</li>
                        <li><strong>Prime Placement:</strong> Display prominently in-store/online</li>
                        <li><strong>Bundle Opportunities:</strong> Pair with complementary products</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-header bg-gradient-x-primary">
                    <h4 class="card-title text-white mb-0">
                        <i class="fa fa-line-chart"></i> Revenue Maximization
                    </h4>
                </div>
                <div class="card-body">
                    <h5 class="text-primary"><i class="fa fa-money"></i> Strategies for Top Performers:</h5>
                    <ul>
                        <li><strong>Loyalty Programs:</strong> Reward repeat customers who buy these items</li>
                        <li><strong>Upselling:</strong> Train staff to recommend premium alternatives</li>
                        <li><strong>Cross-Selling:</strong> Suggest related products at checkout</li>
                        <li><strong>Volume Discounts:</strong> Encourage bulk purchases</li>
                        <li><strong>Stock Forecasting:</strong> Use sales data to predict future demand</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stock Alerts -->
    <?php 
    $low_stock_items = array_filter($fast_moving_items, function($item) {
        return $item['qty'] <= $item['reorder_point'];
    });
    ?>
    
    <?php if (!empty($low_stock_items)): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Urgent: Low Stock Alert!</h4>
                <p>The following fast-moving products are at or below reorder point. Immediate action required to prevent stockouts:</p>
                <ul class="mb-0">
                    <?php foreach ($low_stock_items as $item): ?>
                        <li>
                            <strong><?= $item['product_name'] ?></strong> (<?= $item['product_code'] ?>) - 
                            Current: <?= number_format($item['qty'], 2) ?>, 
                            Reorder Point: <?= number_format($item['reorder_point'], 0) ?>,
                            Sales: <?= $item['sales_count'] ?> in 30 days
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable for better sorting/filtering
    if ($.fn.DataTable) {
        $('#fast-moving-table').DataTable({
            "order": [[ 6, "desc" ]], // Sort by sales count descending
            "pageLength": 25,
            "dom": 'Bfrtip',
            "buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    }
});
</script>
