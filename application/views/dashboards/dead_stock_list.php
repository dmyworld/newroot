<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-warning text-orange"></i> Dead Stock Intelligence
            <small>Products with no sales in last 45+ days</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Dead Stock</li>
        </ol>
    </section>

    <section class="content">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-cubes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Dead Stock Items</span>
                        <span class="info-box-number"><?= count($dead_stock_list) ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Value Locked</span>
                        <span class="info-box-number">
                            Rs <?= number_format(array_sum(array_map(function($item) {
                                return $item['qty'] * $item['product_price'];
                            }, $dead_stock_list)), 2) ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-orange">
                    <span class="info-box-icon"><i class="fa fa-archive"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Quantity</span>
                        <span class="info-box-number">
                            <?= array_sum(array_column($dead_stock_list, 'qty')) ?> units
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-gray">
                    <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Days Threshold</span>
                        <span class="info-box-number">45+ Days</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dead Stock Table -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list"></i> Dead Stock Products</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-sm btn-success" onclick="exportTableToExcel()">
                        <i class="fa fa-file-excel-o"></i> Export to Excel
                    </button>
                </div>
            </div>
            <div class="box-body">
                <?php if (count($dead_stock_list) > 0): ?>
                    <table id="deadStockTable" class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-yellow">
                                <th>#</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Value</th>
                                <th>Days Stagnant</th>
                                <th>Last Sale</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $threshold_date = date('Y-m-d', strtotime('-45 days'));
                            foreach ($dead_stock_list as $item): 
                                $total_value = $item['qty'] * $item['product_price'];
                                $last_sale = isset($item['last_sale']) ? $item['last_sale'] : 'Never';
                                $days_stagnant = $last_sale != 'Never' ? 
                                    (int)((strtotime('now') - strtotime($last_sale)) / 86400) : 
                                    'Unknown';
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $item['pid'] ?></td>
                                    <td><strong><?= $item['product_name'] ?></strong></td>
                                    <td><span class="label label-warning"><?= $item['qty'] ?> units</span></td>
                                    <td>Rs <?= number_format($item['product_price'], 2) ?></td>
                                    <td><strong>Rs <?= number_format($total_value, 2) ?></strong></td>
                                    <td>
                                        <span class="badge bg-red">
                                            <?= $days_stagnant ?> <?= $days_stagnant != 'Unknown' ? 'days' : '' ?>
                                        </span>
                                    </td>
                                    <td><?= $last_sale != 'Never' ? date('d M Y', strtotime($last_sale)) : 'Never' ?></td>
                                    <td>
                                        <a href="<?= base_url('products/edit?id=' . $item['pid']) ?>" 
                                           class="btn btn-xs btn-primary" title="Edit Product">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-xs btn-success" 
                                                onclick="showDiscountSuggestion('<?= $item['product_name'] ?>', <?= $item['product_price'] ?>)"
                                                title="Discount Suggestion">
                                            <i class="fa fa-tags"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray">
                                <th colspan="3" class="text-right">TOTAL:</th>
                                <th><?= array_sum(array_column($dead_stock_list, 'qty')) ?> units</th>
                                <th></th>
                                <th>Rs <?= number_format(array_sum(array_map(function($item) {
                                    return $item['qty'] * $item['product_price'];
                                }, $dead_stock_list)), 2) ?></th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <div class="alert alert-success">
                        <h4><i class="icon fa fa-check"></i> Great News!</h4>
                        No dead stock found. All products are moving well!
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recommendations Box -->
        <?php if (count($dead_stock_list) > 0): ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-lightbulb-o"></i> AI Recommendations</h3>
                </div>
                <div class="box-body">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-check text-green"></i> <strong>Offer Discounts:</strong> Consider 10-20% discount on items stagnant for 60+ days</li>
                        <li><i class="fa fa-check text-green"></i> <strong>Bundle Products:</strong> Create combo offers with fast-moving items</li>
                        <li><i class="fa fa-check text-green"></i> <strong>Seasonal Sale:</strong> Run clearance campaigns for seasonal products</li>
                        <li><i class="fa fa-check text-green"></i> <strong>Review Suppliers:</strong> Adjust purchase quantities for slow-movers</li>
                        <li><i class="fa fa-check text-green"></i> <strong>Transfer Stock:</strong> Move items to better-performing branches</li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<!-- Discount Suggestion Modal -->
<div class="modal fade" id="discountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-tags"></i> Discount Suggestion</h4>
            </div>
            <div class="modal-body">
                <h4 id="productName"></h4>
                <p><strong>Original Price:</strong> <span id="originalPrice"></span></p>
                <hr>
                <h5>Suggested Discounts:</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Discount %</th>
                            <th>New Price</th>
                            <th>Your Savings</th>
                        </tr>
                    </thead>
                    <tbody id="discountTable"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#deadStockTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 25,
        "order": [[6, 'desc']], // Sort by days stagnant
        "responsive": true
    });
});

function showDiscountSuggestion(productName, price) {
    $('#productName').text(productName);
    $('#originalPrice').text('Rs ' + parseFloat(price).toFixed(2));
    
    let discounts = [10, 15, 20, 25, 30];
    let tableHtml = '';
    
    discounts.forEach(function(discount) {
        let newPrice = price * (1 - discount/100);
        let savings = price - newPrice;
        tableHtml += '<tr>' +
            '<td><span class="label label-success">' + discount + '%</span></td>' +
            '<td><strong>Rs ' + newPrice.toFixed(2) + '</strong></td>' +
            '<td class="text-green">Rs ' + savings.toFixed(2) + '</td>' +
            '</tr>';
    });
    
    $('#discountTable').html(tableHtml);
    $('#discountModal').modal('show');
}

function exportTableToExcel() {
    let table = document.getElementById("deadStockTable");
    let html = table.outerHTML;
    let url = 'data:application/vnd.ms-excel,' + escape(html);
    let downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    downloadLink.href = url;
    downloadLink.download = 'dead_stock_report_' + new Date().getTime() + '.xls';
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>

<style>
.info-box-number {
    font-size: 20px !important;
}
</style>
