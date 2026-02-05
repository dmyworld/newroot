<style>

/* Alert Status Styles */
.alert-status {
    min-width: 150px;
}

.progress {
    background-color: #f1f1f1;
    border-radius: 3px;
}

.progress-bar {
    border-radius: 3px;
}

/* Test Results */
.test-result {
    min-height: 50px;
}

/* Table Styles */
#alerts-table_wrapper {
    padding: 10px;
}

#alerts-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

/* Modal Styles */
.modal-content {
    border-radius: 10px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0;
}

/* Badge Styles */
.badge-danger {
    background-color: #ff4757;
}

.badge-warning {
    background-color: #ffa502;
}

.badge-info {
    background-color: #2ed573;
}

.badge-success {
    background-color: #3742fa;
} 
</style>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Manage Stock Alerts</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            
            <div class="card-body">
                <!-- Statistics Cards -->
                <div class="row mb-3">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="danger" id="critical-count">0</h3>
                                            <span>Critical Alerts</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="ft-alert-triangle danger font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="warning" id="warning-count">0</h3>
                                            <span>Warning Alerts</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="ft-alert-circle warning font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="info" id="info-count">0</h3>
                                            <span>Low Stock</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="ft-info info font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="success" id="normal-count">0</h3>
                                            <span>Normal Stock</span>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="ft-check-circle success font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Alert Distribution</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="alertDoughnutChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Alert by Warehouse</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="alertBarChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Filters</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Warehouse</label>
                                            <select class="form-control" id="warehouse-filter">
                                                <option value="all">All Warehouses</option>
                                                <?php foreach ($warehouses as $warehouse): ?>
                                                    <option value="<?php echo $warehouse['id']; ?>">
                                                        <?php echo $warehouse['title']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" id="category-filter">
                                                <option value="all">All Categories</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo $category['id']; ?>">
                                                        <?php echo $category['title']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Subcategory</label>
                                            <select class="form-control" id="subcategory-filter">
                                                <option value="all">All Subcategories</option>
                                                <!-- Loaded via AJAX -->
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Alert Level</label>
                                            <select class="form-control" id="alert-level-filter">
                                                <option value="all">All Levels</option>
                                                <option value="critical">Critical</option>
                                                <option value="warning">Warning</option>
                                                <option value="info">Low</option>
                                                <option value="normal">Normal</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Minus Quantity</label>
                                            <select class="form-control" id="minus-qty-filter">
                                                <option value="all">All</option>
                                                <option value="yes">Minus Only</option>
                                                <option value="no">Non-Minus</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-primary btn-block" id="apply-filters">
                                                <i class="ft-filter"></i> Apply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>From Date</label>
                                            <input type="date" class="form-control" id="start-date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>To Date</label>
                                            <input type="date" class="form-control" id="end-date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Search</label>
                                            <input type="text" class="form-control" id="search-input" 
                                                   placeholder="Product name/code">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-secondary btn-block" id="reset-filters">
                                                <i class="ft-refresh-cw"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Alerts Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Stock Alerts (100 items per page)</h4>
                                <button class="btn btn-success btn-sm float-right" id="export-csv">
                                    <i class="ft-download"></i> Export CSV
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="alerts-table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Code</th>
                                            <th>Warehouse</th>
                                            <th>Category</th>
                                            <th>Current Qty</th>
                                            <th>Alert Qty</th>
                                            <th>Difference</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Alert Modal -->
<div class="modal fade" id="editAlertModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Alert Quantity</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editAlertForm">
                <div class="modal-body">
                    <input type="hidden" id="edit-pid" name="pid">
                    <div class="form-group">
                        <label>Product</label>
                        <input type="text" class="form-control" id="edit-product-name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Current Quantity</label>
                        <input type="text" class="form-control" id="edit-current-qty" readonly>
                    </div>
                    <div class="form-group">
                        <label>Current Alert Quantity</label>
                        <input type="text" class="form-control" id="edit-current-alert" readonly>
                    </div>
                    <div class="form-group">
                        <label>New Alert Quantity</label>
                        <input type="number" class="form-control" id="edit-new-alert" name="alert_qty" 
                               step="0.001" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Reason for Change</label>
                        <textarea class="form-control" id="edit-reason" name="reason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Alert</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize variables
    var alertsTable;
    var doughnutChart, barChart;
    
    // Load statistics
    loadStatistics();
    
    // Load charts
    loadCharts();
    
    // Initialize DataTable
    initDataTable();
    
    // Category change event
    $('#category-filter').change(function() {
        loadSubcategories($(this).val());
    });
    
    // Apply filters
    $('#apply-filters').click(function() {
        reloadDataTable();
    });
    
    // Reset filters
    $('#reset-filters').click(function() {
        resetFilters();
        reloadDataTable();
    });
    
    // Export CSV
    $('#export-csv').click(function() {
        exportCSV();
    });
    
    // Edit alert button click
    $(document).on('click', '.edit-alert', function() {
        var pid = $(this).data('pid');
        openEditModal(pid);
    });
    
    // Submit edit form
    $('#editAlertForm').submit(function(e) {
        e.preventDefault();
        updateAlert();
    });
    
    // Functions
    function loadStatistics() {
        $.ajax({
            url: '<?php echo base_url("products_alert/get_alert_statistics"); ?>',
            type: 'GET',
            success: function(response) {
                var data = JSON.parse(response);
                $('#critical-count').text(data.critical_count || 0);
                $('#warning-count').text(data.warning_count || 0);
                $('#info-count').text(data.info_count || 0);
                $('#normal-count').text(data.normal_count || 0);
            }
        });
    }
    
    function loadCharts() {
        $.ajax({
            url: '<?php echo base_url("products_alert/get_chart_data"); ?>',
            type: 'POST',
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(response) {
                var data = JSON.parse(response);
                createDoughnutChart(data.doughnut);
                createBarChart(data.bar);
            }
        });
    }
    
    function createDoughnutChart(data) {
        var ctx = document.getElementById('alertDoughnutChart').getContext('2d');
        
        if (doughnutChart) {
            doughnutChart.destroy();
        }
        
        doughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Critical', 'Warning', 'Low', 'Normal'],
                datasets: [{
                    data: [
                        data.critical || 0,
                        data.warning || 0,
                        data.low || 0,
                        data.normal || 0
                    ],
                    backgroundColor: [
                        '#ff4757', // Critical - red
                        '#ffa502', // Warning - orange
                        '#2ed573', // Low - green
                        '#3742fa'  // Normal - blue
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                }
            }
        });
    }
    
    function createBarChart(data) {
        var ctx = document.getElementById('alertBarChart').getContext('2d');
        var warehouses = [];
        var criticalData = [];
        var warningData = [];
        
        data.forEach(function(item) {
            warehouses.push(item.warehouse || 'Unknown');
            criticalData.push(item.critical || 0);
            warningData.push(item.warning || 0);
        });
        
        if (barChart) {
            barChart.destroy();
        }
        
        barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: warehouses,
                datasets: [
                    {
                        label: 'Critical',
                        data: criticalData,
                        backgroundColor: '#ff4757'
                    },
                    {
                        label: 'Warning',
                        data: warningData,
                        backgroundColor: '#ffa502'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    function initDataTable() {
        alertsTable = $('#alerts-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            ajax: {
                url: '<?php echo base_url("products_alert/manage_alert_ajax_list"); ?>',
                type: 'POST',
                data: function(d) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                    d.warehouse = $('#warehouse-filter').val();
                    d.category = $('#category-filter').val();
                    d.subcategory = $('#subcategory-filter').val();
                    d.alert_level = $('#alert-level-filter').val();
                    d.minus_qty = $('#minus-qty-filter').val();
                    d.start_date = $('#start-date').val();
                    d.end_date = $('#end-date').val();
                    d.search = $('#search-input').val();
                }
            },
            columns: [
                { data: 'product_name' },
                { data: 'product_code' },
                { data: 'warehouse' },
                { data: 'category' },
                { data: 'current_qty' },
                { data: 'alert_qty' },
                { data: 'difference' },
                { data: 'status' },
                { data: 'actions' }
            ],
            order: [[4, 'asc']], // Sort by current quantity ascending
            columnDefs: [
                {
                    targets: [4, 5, 6], // Quantity columns
                    className: 'text-right'
                },
                {
                    targets: [7], // Status column
                    className: 'text-center'
                },
                {
                    targets: [8], // Actions column
                    className: 'text-center',
                    orderable: false
                }
            ]
        });
    }
    
    function reloadDataTable() {
        alertsTable.ajax.reload();
        loadStatistics();
        loadCharts();
    }
    
    function resetFilters() {
        $('#warehouse-filter').val('all');
        $('#category-filter').val('all');
        $('#subcategory-filter').val('all');
        $('#alert-level-filter').val('all');
        $('#minus-qty-filter').val('all');
        $('#start-date').val('');
        $('#end-date').val('');
        $('#search-input').val('');
    }
    
    function loadSubcategories(categoryId) {
        if (categoryId && categoryId != 'all') {
            $.ajax({
                url: '<?php echo base_url("products/sub_cat?id="); ?>' + categoryId,
                type: 'GET',
                success: function(response) {
                    var subcategories = JSON.parse(response);
                    var options = '<option value="all">All Subcategories</option>';
                    
                    subcategories.forEach(function(sub) {
                        options += '<option value="' + sub.id + '">' + sub.title + '</option>';
                    });
                    
                    $('#subcategory-filter').html(options);
                }
            });
        } else {
            $('#subcategory-filter').html('<option value="all">All Subcategories</option>');
        }
    }
    
    function exportCSV() {
        var form = $('<form>', {
            method: 'POST',
            action: '<?php echo base_url("products_alert/export_alerts_csv"); ?>',
            style: 'display: none;'
        });
        
        form.append($('<input>', {
            type: 'hidden',
            name: '<?php echo $this->security->get_csrf_token_name(); ?>',
            value: '<?php echo $this->security->get_csrf_hash(); ?>'
        }));
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'warehouse',
            value: $('#warehouse-filter').val()
        }));
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'category',
            value: $('#category-filter').val()
        }));
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'subcategory',
            value: $('#subcategory-filter').val()
        }));
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'alert_level',
            value: $('#alert-level-filter').val()
        }));
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'minus_qty',
            value: $('#minus-qty-filter').val()
        }));
        
        $('body').append(form);
        form.submit();
        form.remove();
    }
    
    function openEditModal(pid) {
        // Get product details
        $.ajax({
            url: '<?php echo base_url("products_alert/get_product_details"); ?>',
            type: 'POST',
            data: {
                pid: pid,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(response) {
                var data = JSON.parse(response);
                
                $('#edit-pid').val(pid);
                $('#edit-product-name').val(data.product_name);
                $('#edit-current-qty').val(data.qty);
                $('#edit-current-alert').val(data.alert);
                $('#edit-new-alert').val(data.alert);
                
                $('#editAlertModal').modal('show');
            }
        });
    }
    
    function updateAlert() {
        $.ajax({
            url: '<?php echo base_url("products_alert/update_alert_qty"); ?>',
            type: 'POST',
            data: $('#editAlertForm').serialize(),
            success: function(response) {
                var data = JSON.parse(response);
                
                if (data.success) {
                    $('#editAlertModal').modal('hide');
                    reloadDataTable();
                    
                    // Show success message
                    $('#notify').removeClass('alert-danger').addClass('alert-success');
                    $('#notify .message').html(data.message);
                    $('#notify').show().delay(3000).fadeOut();
                } else {
                    alert(data.message);
                }
            }
        });
    }
});
</script>