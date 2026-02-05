<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Stock Transfer') ?></h5>
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
            <div id="error-notify" class="alert alert-danger" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="error-message"></div>
            </div>
            <div class="card-body">
                
                <!-- User Guide -->
                <div class="card bg-light border-light mb-3">
                    <div class="card-header font-weight-bold" data-toggle="collapse" href="#helpGuide" role="button" aria-expanded="false" aria-controls="helpGuide" style="cursor: pointer;">
                        <i class="fa fa-book"></i> User Guide / උපදෙස් / பயனர் வழிகாட்டி <i class="fa fa-angle-down float-right"></i>
                    </div>
                    <div class="collapse" id="helpGuide">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="guideTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="eng-tab" data-toggle="tab" href="#eng" role="tab">English</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sin-tab" data-toggle="tab" href="#sin" role="tab">සිංහල</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tam-tab" data-toggle="tab" href="#tam" role="tab">தமிழ்</a>
                                </li>
                            </ul>
                            <div class="tab-content border-left border-right border-bottom p-3 bg-white" id="guideTabContent">
                                <div class="tab-pane fade show active" id="eng" role="tabpanel">
                                    <h6 class="text-primary mt-2">How to Transfer Stock</h6>
                                    <ol>
                                        <li><strong>Source & Destination:</strong> Select 'Transfer From' (Source) and 'Transfer To' (Destination) warehouses.</li>
                                        <li><strong>Select Products:</strong> Choose products available in the source warehouse.</li>
                                        <li><strong>Quantities:</strong> Enter the quantity to transfer. Ensure it does not exceed available stock.</li>
                                        <li><strong>Submit:</strong> Click 'Stock Transfer' to move items immediately.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>Note:</strong> Stock will be deducted from the source and added to the destination immediately.</small></p>
                                </div>
                                <div class="tab-pane fade" id="sin" role="tabpanel">
                                    <h6 class="text-primary mt-2">තොග මාරු කරන ආකාරය (Stock Transfer)</h6>
                                    <ol>
                                        <li><strong>මූලාශ්‍රය සහ ගමනාන්තය:</strong> 'Transfer From' (මූලාශ්‍රය) සහ 'Transfer To' (ගමනාන්තය) ගබඩා තෝරන්න.</li>
                                        <li><strong>නිෂ්පාදන තෝරන්න:</strong> මූලාශ්‍ර ගබඩාවේ ඇති නිෂ්පාදන තෝරන්න.</li>
                                        <li><strong>ප්‍රමාණ:</strong> මාරු කළ යුතු ප්‍රමාණය ඇතුළත් කරන්න. එය පවතින තොගයට වඩා වැඩි නොවන බවට වග බලා ගන්න.</li>
                                        <li><strong>ඉදිරිපත් කරන්න:</strong> අයිතම වහාම මාරු කිරීමට 'Stock Transfer' ක්ලික් කරන්න.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>සටහන:</strong> තොග වහාම මූලාශ්‍ර ගබඩාවෙන් අඩු වී ගමනාන්ත ගබඩාවට එකතු වේ.</small></p>
                                </div>
                                <div class="tab-pane fade" id="tam" role="tabpanel">
                                    <h6 class="text-primary mt-2">இருப்பை எவ்வாறு மாற்றுவது (Stock Transfer)</h6>
                                    <ol>
                                        <li><strong>மூலம் மற்றும் இலக்கு:</strong> 'Transfer From' (மூலம்) மற்றும் 'Transfer To' (இலக்கு) கிடங்குகளைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>தயாரிப்புகளைத் தேர்வுசெய்க:</strong> மூலக் கிடங்கில் உள்ள தயாரிப்புகளைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>அளவுகள்:</strong> மாற்ற வேண்டிய அளவை உள்ளிடவும். இது கிடைக்கக்கூடிய இருப்பை விட அதிகமாக இல்லை என்பதை உறுதிப்படுத்தவும்.</li>
                                        <li><strong>சமர்ப்பிக்கவும்:</strong> பொருட்களை உடனடியாக மாற்ற 'Stock Transfer' என்பதை அழுத்தவும்.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>குறிப்பு:</strong> இருப்பு மூலத்திலிருந்து கழிக்கப்பட்டு உடனடியாக இலக்கில் சேர்க்கப்படும்.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url('products/stock_transfer'); ?>">
                    <input type="hidden" name="act" value="add_product">
                    <input type="hidden" name="invocieno" value="<?php echo $lasttransfer + 1 ?>">
                    
                    <!-- Transfer Date -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="invoicedate">Transfer Date</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control round required" 
                                   placeholder="Transfer Date" 
                                   name="invoicedate"
                                   id="invoicedate"
                                   data-toggle="datepicker"
                                   autocomplete="off"
                                   required>
                        </div>
                    </div>
                    
                    <!-- Transfer From Warehouse -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="wfrom">
                            <?php echo $this->lang->line('Transfer From') ?>
                        </label>
                        <div class="col-sm-6">
                            <select id="wfrom" name="from_warehouse" class="form-control required">
                                <option value="">Select Source Warehouse</option>
                                <?php foreach ($warehouse as $row): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['title']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Product Selection -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="products_l">
                            <?php echo $this->lang->line('Products') ?>
                        </label>
                        <div class="col-sm-8">
                            <select id="products_l" name="products_l[]" 
                                    class="form-control required" 
                                    multiple="multiple"
                                    disabled>
                                <option value="">Please select warehouse first</option>
                            </select>
                            <small class="text-muted">Select products from the source warehouse</small>
                        </div>
                    </div>
                    
                    <!-- Product Quantities -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            <?php echo $this->lang->line('Quantities') ?>
                        </label>
                        <div class="col-sm-8" id="quantity-container">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> 
                                Select products from above to enter quantities
                            </div>
                        </div>
                    </div>
                    
                    <!-- Transfer To Warehouse -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="to_warehouse">
                            <?php echo $this->lang->line('Transfer To') ?>
                        </label>
                        <div class="col-sm-6">
                            <select name="to_warehouse" class="form-control required">
                                <option value="">Select Destination Warehouse</option>
                                <?php foreach ($warehouse as $row): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['title']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Hidden Container for Dynamic Inputs -->
                    <div id="dynamic-inputs" style="display: none;"></div>
                    
                    <!-- Submit Button -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Stock Transfer') ?>"
                                   data-loading-text="Processing...">
                            <input type="hidden" value="products/stock_transfer" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script type="text/javascript">
$(document).ready(function() {
    // Store product quantities to preserve them when products are re-rendered
    var productQuantities = {};
    
    // Initialize datepicker
    $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    
    // Initialize select2 for products
    $("#products_l").select2({
        placeholder: "Select products...",
        allowClear: true,
        width: '100%'
    });
    
    // When source warehouse changes
    $("#wfrom").on('change', function() {
        var warehouse_id = $(this).val();
        var productsSelect = $("#products_l");
        
        // Clear products selection but keep quantities in memory
        productsSelect.val(null).trigger('change');
        $('#quantity-container').empty();
        productQuantities = {}; // Reset quantities for new warehouse
        
        if (!warehouse_id) {
            // Disable products selection
            productsSelect.prop('disabled', true);
            productsSelect.html('<option value="">Select source warehouse first</option>');
            productsSelect.select2({
                placeholder: "Please select source warehouse first",
                disabled: true
            });
            
            $('#quantity-container').html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> Please select source warehouse first</div>');
            return;
        }
        
        // Enable products selection
        productsSelect.prop('disabled', false);
        
        // Initialize select2 with AJAX search for selected warehouse
        productsSelect.select2({
            placeholder: "Type to search products...",
            allowClear: true,
            multiple: true,
            width: '100%',
            ajax: {
                url: baseurl + 'products/stock_transfer_products',
                dataType: 'json',
                type: 'POST',
                delay: 300,
                data: function(params) {
                    return {
                        search: params.term,
                        warehouse_id: warehouse_id,
                        page: params.page || 1,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': crsf_hash
                    };
                },
                processResults: function(data) {
                    if (!data || data.length === 0) {
                        return {
                            results: []
                        };
                    }
                    
                    return {
                        results: $.map(data, function(item) {
                            // Create display text with product info
                            var displayText = item.product_name;
                            
                            // Add product code if available
                            if (item.product_code && item.product_code.trim() !== '') {
                                displayText += ' [' + item.product_code + ']';
                            }
                            
                            // Add stock quantity
                            var stockQty = parseFloat(item.qty || 0);
                            displayText += ' - Stock: ' + stockQty.toFixed(2);
                            
                            return {
                                text: displayText,
                                id: item.pid,
                                stock: stockQty
                            };
                        })
                    };
                },
                cache: true
            }
        });
        
        // When products are selected/deselected
        productsSelect.on('change', function() {
            updateProductsTable();
        });
        
        // Trigger change to show initial state
        productsSelect.trigger('change');
    });
    
    // Function to update products table with preserved quantities
    function updateProductsTable() {
        var productsSelect = $("#products_l");
        var selectedProducts = productsSelect.val();
        var container = $('#quantity-container');
        var dynamicContainer = $('#dynamic-inputs');
        var warehouse_id = $("#wfrom").val();
        
        if (!warehouse_id) {
            container.html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> Please select source warehouse first</div>');
            return;
        }
        
        // Clear previous content but preserve quantity values from inputs
        saveCurrentQuantities();
        
        container.empty();
        dynamicContainer.empty();
        
        if (!selectedProducts || selectedProducts.length === 0) {
            container.html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> No products selected</div>');
            return;
        }
        
        // Get selected options data
        var selectedData = productsSelect.select2('data');
        
        // Create table for quantity inputs
        var html = '<div class="table-responsive">';
        html += '<table class="table table-bordered table-sm table-hover">';
        html += '<thead class="thead-light">';
        html += '<tr>';
        html += '<th width="15%">Product ID</th>';
        html += '<th width="35%">Product Name</th>';
        html += '<th width="25%">Available Stock</th>';
        html += '<th width="25%">Transfer Quantity</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        
        $.each(selectedData, function(index, product) {
            if (!product || !product.id) return;
            
            var productId = product.id;
            var productName = product.text.split(' - Stock:')[0]; // Extract name
            var availableStock = product.stock || 0;
            var availableStockInt = Math.floor(availableStock); // Get integer part only
            
            // Get preserved quantity or default to 1
            var preservedQty = productQuantities[productId] || 1;
            // Ensure quantity is integer and doesn't exceed available stock
            var initialQty = Math.min(Math.floor(preservedQty), availableStockInt);
            if (initialQty <= 0) initialQty = 1;
            
            html += '<tr data-product-id="' + productId + '">';
            html += '<td>' + productId + '</td>';
            html += '<td>' + productName + '</td>';
            html += '<td class="text-success"><strong>' + availableStock.toFixed(2) + '</strong></td>';
            html += '<td>';
            html += '<div class="input-group input-group-sm">';
            html += '<input type="number" class="form-control product-quantity" ';
            html += 'name="products_qty[' + productId + ']" ';
            html += 'min="1" ';
            html += 'max="' + availableStockInt + '" ';
            html += 'step="1" ';
            html += 'value="' + initialQty + '" ';
            html += 'required ';
            html += 'data-product-id="' + productId + '" ';
            html += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57" ';
            html += 'placeholder="Enter quantity">';
            html += '<div class="input-group-append">';
            html += '<span class="input-group-text">Qty</span>';
            html += '</div>';
            html += '</div>';
            html += '<small class="form-text text-muted">Max: ' + availableStockInt + ' (whole numbers only)</small>';
            html += '</td>';
            html += '</tr>';
            
            // Add hidden input for product ID
            $('<input>').attr({
                type: 'hidden',
                name: 'products_l[]',
                value: productId
            }).appendTo(dynamicContainer);
        });
        
        html += '</tbody>';
        html += '</table>';
        html += '</div>';
        
        container.html(html);
        
        // Add validation for quantity inputs
        $('.product-quantity').on('input', function() {
            validateQuantityInput($(this));
        });
        
        // Prevent decimal input
        $('.product-quantity').on('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter
            if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && (e.ctrlKey || e.metaKey)) ||
                (e.keyCode === 67 && (e.ctrlKey || e.metaKey)) ||
                (e.keyCode === 86 && (e.ctrlKey || e.metaKey)) ||
                (e.keyCode === 88 && (e.ctrlKey || e.metaKey)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
            }
            
            // Ensure that it is a number and stop the keypress if not
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        
        // Initialize validation for all inputs
        $('.product-quantity').each(function() {
            validateQuantityInput($(this));
        });
    }
    
    // Function to save current quantity values before table refresh
    function saveCurrentQuantities() {
        $('.product-quantity').each(function() {
            var productId = $(this).data('product-id');
            var qtyValue = parseInt($(this).val());
            
            if (productId && !isNaN(qtyValue) && qtyValue > 0) {
                productQuantities[productId] = qtyValue;
            }
        });
    }
    
    // Function to validate quantity input
    function validateQuantityInput(input) {
        var max = parseInt(input.attr('max'));
        var value = parseInt(input.val());
        
        if (isNaN(value) || value <= 0) {
            input.addClass('is-invalid');
            input.next('.input-group-append').find('.input-group-text').addClass('bg-danger text-white');
            return false;
        }
        
        if (value > max) {
            input.addClass('is-invalid');
            input.next('.input-group-append').find('.input-group-text').addClass('bg-danger text-white');
            return false;
        }
        
        // Ensure value is integer (not decimal)
        if (value % 1 !== 0) {
            input.val(Math.floor(value));
            value = Math.floor(value);
        }
        
        // Save the quantity when user changes it
        var productId = input.data('product-id');
        if (productId) {
            productQuantities[productId] = value;
        }
        
        input.removeClass('is-invalid');
        input.next('.input-group-append').find('.input-group-text').removeClass('bg-danger text-white');
        return true;
    }
    
    // Form submission
    $('#data_form').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        if (!validateForm()) {
            return false;
        }
        
        // Show loading
        var submitBtn = $('#submit-data');
        var originalText = submitBtn.val();
        submitBtn.prop('disabled', true).val('Processing...');
        
        // Clear previous messages
        $('#notify, #error-notify').hide().find('.message, .error-message').empty();
        
        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action') || $('#action-url').val(),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'Success') {
                    // Show success message
                    $('#notify .message').html('<strong>Success!</strong> ' + response.message);
                    $('#notify').fadeIn();
                    
                    // Reset form after 2 seconds
                    setTimeout(function() {
                        $('#data_form')[0].reset();
                        $('#products_l').val(null).trigger('change');
                        $('#quantity-container').html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> Select products to enter quantities</div>');
                        $('#notify').fadeOut();
                        productQuantities = {}; // Clear stored quantities
                        
                        // Update transfer number if needed
                        if (response.transfer_id) {
                            $('input[name="invocieno"]').val(parseInt(response.transfer_id) + 1);
                        }
                    }, 2000);
                } else {
                    // Show error message
                    $('#error-notify .error-message').html('<strong>Error:</strong> ' + response.message);
                    $('#error-notify').fadeIn();
                }
                
                submitBtn.prop('disabled', false).val(originalText);
            },
            error: function(xhr, status, error) {
                var errorMsg = 'An error occurred. Please try again.';
                
                try {
                    var jsonResponse = JSON.parse(xhr.responseText);
                    if (jsonResponse.message) {
                        errorMsg = jsonResponse.message;
                    }
                } catch (e) {
                    errorMsg = xhr.responseText || error;
                }
                
                $('#error-notify .error-message').html('<strong>Error:</strong> ' + errorMsg);
                $('#error-notify').fadeIn();
                
                submitBtn.prop('disabled', false).val(originalText);
            }
        });
    });
    
    // Form validation function
    function validateForm() {
        var isValid = true;
        var errorMessages = [];
        
        // Check required fields
        if (!$('#invoicedate').val()) {
            errorMessages.push('Transfer date is required');
            isValid = false;
        }
        
        if (!$('#wfrom').val()) {
            errorMessages.push('Source warehouse is required');
            isValid = false;
        }
        
        if (!$('select[name="to_warehouse"]').val()) {
            errorMessages.push('Destination warehouse is required');
            isValid = false;
        }
        
        var selectedProducts = $('#products_l').val();
        if (!selectedProducts || selectedProducts.length === 0) {
            errorMessages.push('At least one product must be selected');
            isValid = false;
        }
        
        // Check quantities
        $('.product-quantity').each(function() {
            if (!validateQuantityInput($(this))) {
                var productId = $(this).data('product-id');
                var max = parseInt($(this).attr('max'));
                var value = parseInt($(this).val());
                
                if (isNaN(value) || value <= 0) {
                    errorMessages.push('Product ID ' + productId + ': Quantity must be a whole number greater than 0');
                } else if (value > max) {
                    errorMessages.push('Product ID ' + productId + ': Transfer quantity cannot exceed available integer stock of ' + max);
                }
                
                isValid = false;
            }
        });
        
        // Show errors if any
        if (errorMessages.length > 0) {
            $('#error-notify .error-message').html('<strong>Validation Error:</strong><br>' + errorMessages.join('<br>'));
            $('#error-notify').fadeIn();
        }
        
        return isValid;
    }
    
    // Auto-focus on date field
    $('#invoicedate').focus();
});
</script>

<style>
.product-quantity {
    text-align: center;
}

.table th {
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
}

.table td {
    vertical-align: middle;
}

.input-group-sm .input-group-text {
    font-size: 12px;
}

.select2-container--default .select2-selection--multiple {
    min-height: 38px;
    border: 1px solid #ced4da;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.alert {
    margin-bottom: 15px;
}
</style>

<!--  <script type="text/javascript">
    $("#products_l").select2();
    let productCache = {};
    
    $("#wfrom").on('change', function () {
        var tips = $('#wfrom').val();
        $("#products_l").select2({
            tags: [],
            ajax: {
                url: baseurl + 'products/stock_transfer_products?wid=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {
                    return {
                        product: product,
                        '<?//=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    // Cache product data for later use
                    data.forEach(item => {
                        productCache[item.pid] = item;
                    });
                    
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.product_name + ' (Stock: ' + (item.qty || 0) + ')',
                                id: item.pid
                            }
                        })
                    };
                },
            }
        });
    });
    
    // Handle product selection
    $('#products_l').on('change', function() {
        const selected = $(this).val();
        const table = $('#quantityTable');
        const tbody = $('#quantityTableBody');
        const noProductsMsg = $('#no-products-message');
        
        if (selected && selected.length > 0) {
            table.show();
            noProductsMsg.hide();
            tbody.empty();
            
            selected.forEach(function(productId) {
                const product = productCache[productId];
                if (product) {
                    const row = `
                        <tr data-product-id="${productId}">
                            <td>${product.product_name}</td>
                            <td>${product.qty || 0}</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control transfer-qty" 
                                           name="products_qty[${productId}]" 
                                           min="1" 
                                           max="${product.qty || ''}"
                                           value="1"
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">units</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                }
            });
        } else {
            table.hide();
            noProductsMsg.show();
        }
    });
    
    // Remove product from list
    $(document).on('click', '.remove-product', function() {
        const row = $(this).closest('tr');
        const productId = row.data('product-id');
        
        // Remove from select2
        const currentValues = $('#products_l').val();
        const newValues = currentValues.filter(id => id != productId);
        $('#products_l').val(newValues).trigger('change');
        
        row.remove();
    });
</script>-->
