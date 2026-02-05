<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Transfer System</title>
    
    <!-- Bootstrap 4 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            font-weight: 600;
        }
        
        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
        }
        
        #notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            display: none;
        }
        
        .step {
            margin-bottom: 30px;
            display: none;
        }
        
        .step.active {
            display: block;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #6c757d;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        
        .step.active .step-number {
            background: #007bff;
        }
        
        .selected-product {
            transition: all 0.3s;
        }
        
        .selected-product:hover {
            background-color: #f8f9fa;
        }
        
        .qty-btn {
            min-width: 40px;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0,0,0,.1);
            border-radius: 50%;
            border-top-color: #007bff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .stat-card {
            text-align: center;
            padding: 15px;
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Notification -->
        <div id="notification" class="alert alert-dismissible">
            <button type="button" class="close" onclick="hideNotification()">&times;</button>
            <span class="message"></span>
        </div>
        
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h4 mb-0">
                                    <i class="fas fa-exchange-alt mr-2"></i>
                                    Stock Transfer System
                                </h1>
                                <small>Transfer products between warehouses</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-light">
                                    <i class="fas fa-calendar mr-1"></i> <?= date('F j, Y') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-8">
                <!-- Transfer Form -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-truck-loading mr-2"></i>
                            New Stock Transfer
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Step 1: Warehouses -->
                        <div class="step active" id="step1">
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-number">1</div>
                                <h5 class="mb-0">Select Warehouses</h5>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-arrow-down text-danger mr-2"></i>
                                        From Warehouse *
                                    </label>
                                    <select class="form-control" id="from_warehouse" required>
                                        <option value="">Select Source Warehouse</option>
                                        <?php foreach ($warehouses as $warehouse): ?>
                                            <option value="<?= $warehouse['id'] ?>">
                                                <?= htmlspecialchars($warehouse['title']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted" id="from_info"></small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-arrow-up text-success mr-2"></i>
                                        To Warehouse *
                                    </label>
                                    <select class="form-control" id="to_warehouse" required>
                                        <option value="">Select Destination Warehouse</option>
                                        <?php foreach ($warehouses as $warehouse): ?>
                                            <option value="<?= $warehouse['id'] ?>">
                                                <?= htmlspecialchars($warehouse['title']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted" id="to_info"></small>
                                </div>
                            </div>
                            
                            <div class="alert alert-warning" id="same_warehouse_alert" style="display: none;">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Source and destination cannot be the same
                            </div>
                            
                            <div class="text-right">
                                <button class="btn btn-primary" onclick="goToStep(2)">
                                    Next <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 2: Products -->
                        <div class="step" id="step2">
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-number">2</div>
                                <h5 class="mb-0">Add Products</h5>
                            </div>
                            
                            <!-- Product Search -->
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-search mr-2"></i>
                                        Search Product
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control" 
                                               id="product_search" 
                                               placeholder="Enter product code..."
                                               autocomplete="off">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" id="search_btn">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div id="search_results" class="mt-3"></div>
                                </div>
                            </div>
                            
                            <!-- Selected Products -->
                            <div class="card">
                                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Selected Products
                                        <span class="badge badge-light ml-2" id="selected_count">0</span>
                                    </h6>
                                    <button class="btn btn-sm btn-light" onclick="clearSelection()">
                                        <i class="fas fa-trash mr-1"></i> Clear All
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="selected_products" class="mb-3">
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-box-open fa-3x mb-3"></i>
                                            <p>No products selected yet</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Quick Quantity</label>
                                                <div class="btn-group w-100">
                                                    <button type="button" class="btn btn-outline-secondary qty-btn" data-qty="1">1</button>
                                                    <button type="button" class="btn btn-outline-secondary qty-btn" data-qty="5">5</button>
                                                    <button type="button" class="btn btn-outline-secondary qty-btn" data-qty="10">10</button>
                                                    <button type="button" class="btn btn-outline-secondary qty-btn" data-qty="25">25</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Transfer Date</label>
                                                <input type="date" class="form-control" id="transfer_date" 
                                                       value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn btn-secondary" onclick="goToStep(1)">
                                            <i class="fas fa-arrow-left mr-2"></i> Back
                                        </button>
                                        <button class="btn btn-primary" onclick="goToStep(3)">
                                            Review <i class="fas fa-arrow-right ml-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 3: Review -->
                        <div class="step" id="step3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-number">3</div>
                                <h5 class="mb-0">Review & Complete</h5>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">
                                        <i class="fas fa-clipboard-check mr-2"></i>
                                        Review Transfer Details
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <h6>From Warehouse:</h6>
                                            <p class="font-weight-bold" id="review_from"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>To Warehouse:</h6>
                                            <p class="font-weight-bold" id="review_to"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive mb-4">
                                        <table class="table table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Code</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="review_products"></tbody>
                                            <tfoot>
                                                <tr class="table-active">
                                                    <td colspan="5" class="text-right font-weight-bold">Total Value:</td>
                                                    <td class="font-weight-bold" id="review_total">$0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Notes (Optional)</label>
                                        <textarea class="form-control" id="transfer_notes" rows="2" 
                                                  placeholder="Add any notes about this transfer..."></textarea>
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Please review all details before processing.
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-secondary" onclick="goToStep(2)">
                                            <i class="fas fa-arrow-left mr-2"></i> Back
                                        </button>
                                        <button class="btn btn-success btn-lg" onclick="processTransfer()" id="process_btn">
                                            <i class="fas fa-exchange-alt mr-2"></i> Process Transfer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 4: Complete -->
                        <div class="step" id="step4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-number">4</div>
                                <h5 class="mb-0">Transfer Complete</h5>
                            </div>
                            
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-check-circle fa-5x text-success"></i>
                                </div>
                                <h3 class="mb-3">Transfer Completed!</h3>
                                <p class="text-muted mb-4" id="completion_message"></p>
                                <div class="mb-4">
                                    <h4 id="transfer_number"></h4>
                                    <p class="text-muted" id="transfer_time"></p>
                                </div>
                                <div>
                                    <button class="btn btn-primary mr-2" onclick="printReceipt()">
                                        <i class="fas fa-print mr-2"></i> Print Receipt
                                    </button>
                                    <button class="btn btn-success" onclick="startNewTransfer()">
                                        <i class="fas fa-plus mr-2"></i> New Transfer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Stats -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Quick Stats
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon text-primary">
                                        <i class="fas fa-warehouse fa-2x"></i>
                                    </div>
                                    <h4 class="stat-number mt-2"><?= count($warehouses) ?></h4>
                                    <p class="stat-label">Warehouses</p>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon text-success">
                                        <i class="fas fa-boxes fa-2x"></i>
                                    </div>
                                    <h4 class="stat-number mt-2" id="total_items">0</h4>
                                    <p class="stat-label">Items to Transfer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Transfer Info -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle mr-2"></i>
                            Transfer Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Transfer No:</strong> TRF-<?= $last_transfer_id ?></p>
                        <p><strong>Date:</strong> <?= date('Y-m-d') ?></p>
                        <p><strong>User:</strong> <?= $this->session->userdata('username') ?? 'System' ?></p>
                    </div>
                </div>
                
                <!-- Recent Transfers -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-history mr-2"></i>
                            Recent Transfers
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recent_transfers)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recent_transfers as $transfer): ?>
                                    <a href="<?= base_url('stock_transfer/view/' . $transfer['tid']) ?>" 
                                       class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <small class="font-weight-bold">TRF-<?= $transfer['tid'] ?></small>
                                            <small class="text-muted"><?= $transfer['invoicedate'] ?></small>
                                        </div>
                                        <small class="text-muted">
                                            <?= $transfer['from_warehouse'] ?> → <?= $transfer['to_warehouse'] ?>
                                        </small>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No recent transfers</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-muted">
                    <small>
                        &copy; <?= date('Y') ?> Stock Transfer System
                    </small>
                </p>
            </div>
        </div>
    </div>
    
    <!-- jQuery & Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Global variables
    let selectedProducts = [];
    let productsData = {};
    let currentStep = 1;
    const baseUrl = "<?= base_url() ?>";
    const lastTransferId = <?= $last_transfer_id ?>;
    
    $(document).ready(function() {
        console.log('Stock Transfer System Loaded');
        
        // Event listeners
        $('#search_btn').click(searchProduct);
        $('#product_search').keypress(function(e) {
            if (e.which == 13) {
                searchProduct();
                return false;
            }
        });
        
        $('.qty-btn').click(function() {
            const qty = $(this).data('qty');
            setAllQuantities(qty);
        });
        
        $('#from_warehouse, #to_warehouse').change(function() {
            validateWarehouses();
            updateWarehouseInfo();
        });
        
        // Initialize
        updateSelectedProductsList();
    });
    
    // Step navigation - SIMPLE VERSION
    function goToStep(step) {
        console.log('Going to step:', step);
        
        // Validation before moving to step 2
        if (step == 2) {
            const from = $('#from_warehouse').val();
            const to = $('#to_warehouse').val();
            
            if (!from || !to) {
                showNotification('Please select both warehouses', 'warning');
                return;
            }
            
            if (from == to) {
                $('#same_warehouse_alert').show();
                return;
            }
        }
        
        // Validation before moving to step 3
        if (step == 3) {
            if (selectedProducts.length == 0) {
                showNotification('Please add at least one product', 'warning');
                return;
            }
        }
        
        // Hide all steps
        $('.step').removeClass('active').hide();
        
        // Show selected step
        $('#step' + step).addClass('active').show();
        
        currentStep = step;
        
        // Update review if step 3
        if (step == 3) {
            updateReview();
        }
    }
    
    function validateWarehouses() {
        const from = $('#from_warehouse').val();
        const to = $('#to_warehouse').val();
        
        if (from && to && from == to) {
            $('#same_warehouse_alert').show();
        } else {
            $('#same_warehouse_alert').hide();
        }
    }
    
    function updateWarehouseInfo() {
        const from = $('#from_warehouse').val();
        const to = $('#to_warehouse').val();
        
        if (from) {
            $.get(baseUrl + 'stock_transfer/get_warehouse_info/' + from, function(response) {
                if (response.success) {
                    $('#from_info').text(response.products_count + ' products available');
                }
            });
        }
        
        if (to) {
            $.get(baseUrl + 'stock_transfer/get_warehouse_info/' + to, function(response) {
                if (response.success) {
                    $('#to_info').text(response.products_count + ' products available');
                }
            });
        }
    }
    
    // Product search
    function searchProduct() {
        const code = $('#product_search').val().trim();
        const warehouseId = $('#from_warehouse').val();
        
        if (!code) {
            showNotification('Please enter product code', 'warning');
            return;
        }
        
        if (!warehouseId) {
            showNotification('Please select source warehouse first', 'warning');
            return;
        }
        
        $('#search_results').html(`
            <div class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Searching...</p>
            </div>
        `);
        
        $.ajax({
            url: baseUrl + 'stock_transfer/search_product',
            type: 'POST',
            data: {
                warehouse_id: warehouseId,
                product_code: code
            },
            success: function(response) {
                if (response.success) {
                    displayProduct(response.product);
                } else {
                    $('#search_results').html(`
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> ${response.message}
                        </div>
                    `);
                }
            },
            error: function() {
                $('#search_results').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times"></i> Error searching product
                    </div>
                `);
            }
        });
    }
    
    function displayProduct(product) {
        productsData[product.pid] = product;
        
        const html = `
            <div class="product-card">
                <div class="row">
                    <div class="col-md-7">
                        <h6 class="font-weight-bold">${escapeHtml(product.product_name)}</h6>
                        <p class="mb-1">
                            <span class="badge badge-info">${escapeHtml(product.product_code)}</span>
                            <span class="badge badge-light ml-1">${escapeHtml(product.warehouse_name)}</span>
                        </p>
                        <p class="mb-1">
                            <span class="${product.qty > 0 ? 'text-success' : 'text-danger'}">
                                <i class="fas fa-box"></i> Stock: ${product.qty} ${product.unit}
                            </span>
                        </p>
                        <p class="mb-0 text-muted">
                            Price: $${product.product_price}
                        </p>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group mb-2">
                            <label>Quantity:</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="qty_${product.pid}" 
                                   value="1" 
                                   min="1" 
                                   max="${product.qty}">
                        </div>
                        <button class="btn btn-success btn-block" onclick="addProduct(${product.pid})">
                            <i class="fas fa-plus"></i> Add to Transfer
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#search_results').html(html);
    }
    
    // Add product function - make it global
    window.addProduct = function(productId) {
        const product = productsData[productId];
        if (!product) return;
        
        const qty = parseInt($(`#qty_${productId}`).val()) || 1;
        
        // Check if already added
        if (selectedProducts.some(p => p.id == productId)) {
            showNotification('Product already in transfer list', 'warning');
            return;
        }
        
        // Check stock
        if (qty > product.qty) {
            showNotification(`Insufficient stock. Available: ${product.qty}`, 'danger');
            return;
        }
        
        // Add to selected products
        selectedProducts.push({
            id: productId,
            name: product.product_name,
            code: product.product_code,
            price: product.product_price,
            qty: qty,
            maxQty: product.qty,
            unit: product.unit
        });
        
        updateSelectedProductsList();
        showNotification('Product added to transfer list', 'success');
        
        // Clear search
        $('#product_search').val('');
        $('#search_results').html('');
    };
    
    function updateSelectedProductsList() {
        const container = $('#selected_products');
        const count = $('#selected_count');
        
        if (selectedProducts.length == 0) {
            container.html(`
                <div class="text-center text-muted py-4">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <p>No products selected yet</p>
                </div>
            `);
            count.text('0');
            $('#total_items').text('0');
            return;
        }
        
        let html = '<div class="table-responsive"><table class="table table-sm">';
        html += `
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Code</th>
                    <th>Stock</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        `;
        
        let totalItems = 0;
        let totalValue = 0;
        
        selectedProducts.forEach((product, index) => {
            const itemTotal = product.price * product.qty;
            totalItems += product.qty;
            totalValue += itemTotal;
            
            html += `
                <tr class="selected-product" id="row_${product.id}">
                    <td>${index + 1}</td>
                    <td class="font-weight-bold">${escapeHtml(product.name)}</td>
                    <td><span class="badge badge-light">${escapeHtml(product.code)}</span></td>
                    <td>
                        <span class="badge ${product.maxQty > 10 ? 'badge-success' : 'badge-warning'}">
                            ${product.maxQty} ${product.unit}
                        </span>
                    </td>
                    <td>
                        <div class="input-group input-group-sm" style="width: 120px;">
                            <input type="number" 
                                   class="form-control qty-input" 
                                   value="${product.qty}" 
                                   min="1" 
                                   max="${product.maxQty}"
                                   data-id="${product.id}"
                                   onchange="updateProductQuantity(${product.id}, this.value)">
                            <div class="input-group-append">
                                <span class="input-group-text">${escapeHtml(product.unit)}</span>
                            </div>
                        </div>
                    </td>
                    <td>$${product.price}</td>
                    <td class="font-weight-bold">$${itemTotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeProduct(${product.id})">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        html += `
            </tbody>
            <tfoot>
                <tr class="table-active">
                    <td colspan="5" class="text-right font-weight-bold">Total:</td>
                    <td colspan="3" class="font-weight-bold">
                        $${totalValue.toFixed(2)} (${totalItems} items)
                    </td>
                </tr>
            </tfoot>
        </table></div>`;
        
        container.html(html);
        count.text(selectedProducts.length);
        $('#total_items').text(totalItems);
    }
    
    // Make these functions global
    window.updateProductQuantity = function(productId, newQty) {
        newQty = parseInt(newQty) || 1;
        const product = selectedProducts.find(p => p.id == productId);
        if (!product) return;
        
        // Validate max quantity
        if (newQty > product.maxQty) {
            newQty = product.maxQty;
            showNotification(`Maximum quantity is ${product.maxQty}`, 'warning');
        } else if (newQty < 1) {
            newQty = 1;
        }
        
        product.qty = newQty;
        updateSelectedProductsList();
    };
    
    window.removeProduct = function(productId) {
        selectedProducts = selectedProducts.filter(p => p.id != productId);
        updateSelectedProductsList();
        showNotification('Product removed from transfer list', 'info');
    };
    
    function setAllQuantities(qty) {
        selectedProducts.forEach(product => {
            product.qty = Math.min(qty, product.maxQty);
        });
        updateSelectedProductsList();
        showNotification(`All quantities set to ${qty}`, 'info');
    }
    
    function clearSelection() {
        if (selectedProducts.length == 0) return;
        
        if (confirm('Are you sure you want to clear all selected products?')) {
            selectedProducts = [];
            updateSelectedProductsList();
            showNotification('All products cleared', 'info');
        }
    }
    
    // Review functions
    function updateReview() {
        // Update warehouse info
        const fromName = $('#from_warehouse option:selected').text();
        const toName = $('#to_warehouse option:selected').text();
        
        $('#review_from').text(fromName);
        $('#review_to').text(toName);
        
        // Update products table
        const tbody = $('#review_products');
        let html = '';
        let totalValue = 0;
        
        selectedProducts.forEach((product, index) => {
            const itemTotal = product.price * product.qty;
            totalValue += itemTotal;
            
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${escapeHtml(product.name)}</td>
                    <td><span class="badge badge-light">${escapeHtml(product.code)}</span></td>
                    <td>${product.qty} ${product.unit}</td>
                    <td>$${product.price}</td>
                    <td>$${itemTotal.toFixed(2)}</td>
                </tr>
            `;
        });
        
        tbody.html(html);
        $('#review_total').text('$' + totalValue.toFixed(2));
    }
    
    // Process transfer
    function processTransfer() {
        if (selectedProducts.length == 0) {
            showNotification('Please add products to transfer', 'warning');
            return;
        }
        
        const fromWarehouse = $('#from_warehouse').val();
        const toWarehouse = $('#to_warehouse').val();
        
        if (!fromWarehouse || !toWarehouse) {
            showNotification('Please select both warehouses', 'warning');
            return;
        }
        
        if (fromWarehouse == toWarehouse) {
            showNotification('Source and destination cannot be the same', 'warning');
            return;
        }
        
        // Confirm
        if (!confirm('Process this transfer? This action cannot be undone.')) {
            return;
        }
        
        // Prepare data
        const products = [];
        const quantities = [];
        
        selectedProducts.forEach(product => {
            products.push(product.id);
            quantities.push(product.qty);
        });
        
        const transferData = {
            from_warehouse: fromWarehouse,
            to_warehouse: toWarehouse,
            invocieno: lastTransferId,
            invoicedate: $('#transfer_date').val(),
            notes: $('#transfer_notes').val(),
            products: products,
            quantities: quantities
        };
        
        // Show loading
        const btn = $('#process_btn');
        const originalText = btn.html();
        btn.prop('disabled', true)
           .html('<span class="loading"></span> Processing...');
        
        // Send request
        $.ajax({
            url: baseUrl + 'stock_transfer/process_transfer',
            type: 'POST',
            data: transferData,
            success: function(response) {
                if (response.success) {
                    showCompletion(response);
                } else {
                    showNotification(response.message, 'danger');
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                showNotification('Transfer failed. Please try again.', 'danger');
                btn.prop('disabled', false).html(originalText);
            }
        });
    }
    
    function showCompletion(response) {
        $('#completion_message').text(response.message);
        $('#transfer_number').text('Transfer #' + (response.transfer_no || lastTransferId));
        $('#transfer_time').text('Completed: ' + new Date().toLocaleString());
        
        // Go to step 4
        goToStep(4);
    }
    
    function startNewTransfer() {
        // Reset everything
        selectedProducts = [];
        productsData = {};
        
        $('#from_warehouse').val('');
        $('#to_warehouse').val('');
        $('#product_search').val('');
        $('#transfer_notes').val('');
        $('#search_results').html('');
        
        updateSelectedProductsList();
        
        // Go to step 1
        goToStep(1);
        
        showNotification('Ready for new transfer', 'info');
    }
    
    function printReceipt() {
        window.print();
    }
    
    // Notification system
    function showNotification(message, type = 'info') {
        const notify = $('#notification');
        const icon = {
            'success': 'check-circle',
            'danger': 'exclamation-triangle',
            'warning': 'exclamation-circle',
            'info': 'info-circle'
        }[type];
        
        notify.removeClass('alert-success alert-danger alert-warning alert-info')
             .addClass('alert-' + type)
             .find('.message')
             .html(`<i class="fas fa-${icon}"></i> ${message}`);
             
        notify.fadeIn();
        
        // Auto hide after 5 seconds
        setTimeout(hideNotification, 5000);
    }
    
    function hideNotification() {
        $('#notification').fadeOut();
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
    </script>
</body>
</html>