<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Manage Stock Transfers 
                <a href="<?php echo base_url('products/manage_transfer') ?>" class="btn btn-primary btn-sm rounded">
                    Add New Transfer
                </a>
            </h4>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-2"><label>From Date:</label></div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date" class="form-control form-control-sm datepicker" autocomplete="off"/>
                    </div>
                    <div class="col-md-2"><label>To Date:</label></div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm datepicker" autocomplete="off"/>
                    </div>
                    <div class="col-md-4">
                        <button type="button" name="search" id="search" class="btn btn-info btn-sm">Search</button>
                        <button type="button" name="reset" id="reset" class="btn btn-secondary btn-sm">Reset</button>
                        <button type="button" name="export_all" id="export_all" class="btn btn-success btn-sm">Export All with Items</button>
                    </div>
                </div>
                
                <table id="stocktransfer" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transfer #</th>
                            <th>From Warehouse</th>
                            <th>To Warehouse</th>
                            <th>Date</th>
                            <th>Items Count</th>
                            <th>Total Qty</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Items Modal -->
<div class="modal fade" id="itemsModal" tabindex="-1" role="dialog" aria-labelledby="itemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="itemsModalLabel">Transfer Items - <span id="transferIdDisplay"></span></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>From:</strong> <span id="modalFromWarehouse"></span>
                    </div>
                    <div class="col-md-4">
                        <strong>To:</strong> <span id="modalToWarehouse"></span>
                    </div>
                    <div class="col-md-4">
                        <strong>Date:</strong> <span id="modalDate"></span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="itemsTable">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th class="text-center">Quantity</th>
                                
                                <th class="text-center">Length</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Width</th>
                                <th class="text-center">Thickness</th>
                                <th class="text-center">Quick Calc</th>
                                <th class="text-center">Quick Code</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            <!-- Items will be loaded here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11" class="text-center">
                                    <i class="fa fa-spinner fa-spin fa-2x" id="itemsLoading"></i>
                                    <span id="itemsEmpty" style="display:none;">No items found</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="exportCurrentItems">Export This Transfer</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Transfer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this transfer?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="products/delete_transfer">
                <button type="button" class="btn btn-danger" id="delete-confirm">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Global variables
    var currentTransferId = null;
    var currentTransferData = null;
    
    // Initialize datepicker if available
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    }
    
    // Set default dates (last 30 days)
    var endDate = new Date();
    var startDate = new Date();
    startDate.setDate(startDate.getDate() - 30);
    
    $('#start_date').val(formatDate(startDate));
    $('#end_date').val(formatDate(endDate));
    
    // Initialize DataTable
    var table = $('#stocktransfer').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('products/manage_transfer_ajax_list2')?>",
            "type": "POST",
            "data": function(d) {
                d.<?=$this->security->get_csrf_token_name()?> = '<?=$this->security->get_csrf_hash()?>';
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            },
            "error": function(xhr, error, thrown) {
                console.error('DataTables AJAX error:', error, thrown);
                alert('Error loading data. Please check console for details.');
            }
        },
        "columns": [
            {
                "data": "id", 
                "className": "text-center",
                "width": "5%"
            },
            {
                "data": "tid", 
                "className": "text-center",
                "width": "8%"
            },
            {
                "data": "from_warehouse",
                "width": "15%"
            },
            {
                "data": "to_warehouse",
                "width": "15%"
            },
            {
                "data": "invoicedate",
                "className": "text-center",
                "width": "10%",
                "render": function(data) {
                    return data ? new Date(data).toLocaleDateString('en-GB') : '';
                }
            },
            {
                "data": "items_count",
                "className": "text-center",
                "width": "8%",
                "render": function(data) {
                    return '<span class="badge badge-info" style="font-size:12px;">' + (data || 0) + '</span>';
                }
            },
            {
                "data": "items",
                "className": "text-center",
                "width": "8%",
                "render": function(data) {
                    return parseFloat(data || 0).toFixed(2);
                }
            },
            {
                "data": "refer",
                "width": "10%"
            },
            {
                "data": "status",
                "className": "text-center",
                "width": "10%",
                "render": function(data) {
                    if (!data || data === '') {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                    var badgeClass = data === 'Delivered' ? 'badge-success' : 'badge-warning';
                    return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                }
            },
            {
                "data": "id",
                "orderable": false,
                "className": "text-center",
                "width": "11%",
                "render": function(data, type, row) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                           '<button type="button" class="btn btn-info view-items" data-id="' + data + '" data-tid="' + row.tid + '" title="View Items"><i class="fa fa-list"></i></button>' +
                           '<a href="<?php echo base_url("products/transfer_view?id=")?>' + data + '" class="btn btn-success" title="View"><i class="fa fa-eye"></i></a>' +
                           '<button type="button" class="btn btn-danger delete-object" data-object-id="' + data + '" title="Delete"><i class="fa fa-trash"></i></button>' +
                           '</div>';
                }
            }
        ],
        "order": [[0, "desc"]],
        "responsive": true,
        "dom": '<"top"<"row"<"col-sm-6"B><"col-sm-6"f>>>rt<"bottom"<"row"<"col-sm-6"l><"col-sm-6"p>><"row"<"col-sm-12"i>>>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Stock Transfers',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    modifier: {
                        page: 'all'
                    }
                },
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    
                    // Add header styles
                    $('row:first c', sheet).attr('s', '2');
                    
                    // Add borders to all cells
                    $('c', sheet).attr('s', '55');
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Stock Transfers',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    modifier: {
                        page: 'all'
                    }
                },
                orientation: 'landscape'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                className: 'btn btn-info btn-sm',
                title: 'Stock Transfers',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    modifier: {
                        page: 'all'
                    }
                }
            }
        ],
        "language": {
            "emptyTable": "No transfers found",
            "processing": '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br><span>Loading...</span></div>',
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "zeroRecords": "No matching records found",
            "paginate": {
                "first": '<i class="fa fa-angle-double-left"></i>',
                "last": '<i class="fa fa-angle-double-right"></i>',
                "next": '<i class="fa fa-angle-right"></i>',
                "previous": '<i class="fa fa-angle-left"></i>'
            }
        },
        "drawCallback": function(settings) {
            // Update row numbers after each draw
            $('#stocktransfer tbody tr').each(function(i) {
                $('td:eq(0)', this).html(i + 1 + settings._iDisplayStart);
            });
        }
    });
    
    // Search button
    $('#search').click(function() {
        table.ajax.reload();
    });
    
    // Reset button
    $('#reset').click(function() {
        var endDate = new Date();
        var startDate = new Date();
        startDate.setDate(startDate.getDate() - 30);
        $('#start_date').val(formatDate(startDate));
        $('#end_date').val(formatDate(endDate));
        table.ajax.reload();
    });
    
    // Export All with Items button
    $('#export_all').click(function() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        
        // Show loading
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Exporting...');
        $(this).prop('disabled', true);
        
        // Create form and submit
        var form = $('<form>', {
            'method': 'post',
            'action': '<?php echo base_url("products/export_transfers_with_items")?>',
            'target': '_blank'
        });
        
        form.append($('<input>', {
            'type': 'hidden',
            'name': '<?=$this->security->get_csrf_token_name()?>',
            'value': '<?=$this->security->get_csrf_hash()?>'
        }));
        
        form.append($('<input>', {
            'type': 'hidden',
            'name': 'start_date',
            'value': start_date
        }));
        
        form.append($('<input>', {
            'type': 'hidden',
            'name': 'end_date',
            'value': end_date
        }));
        
        $('body').append(form);
        form.submit();
        form.remove();
        
        // Reset button
        setTimeout(function() {
            $('#export_all').html('Export All with Items');
            $('#export_all').prop('disabled', false);
        }, 2000);
    });
    
    // View items button
    $('#stocktransfer').on('click', '.view-items', function() {
        currentTransferId = $(this).data('id');
        var transferTid = $(this).data('tid');
        var rowData = table.row($(this).closest('tr')).data();
        
        console.log('Opening items for transfer ID:', currentTransferId, 'TID:', transferTid, 'Data:', rowData);
        
        if (!rowData) {
            alert('Error: Could not load transfer data');
            return;
        }
        
        currentTransferData = rowData;
        
        // Update modal header
        $('#transferIdDisplay').text('Transfer #' + transferTid);
        $('#modalFromWarehouse').text(rowData.from_warehouse);
        $('#modalToWarehouse').text(rowData.to_warehouse);
        $('#modalDate').text(new Date(rowData.invoicedate).toLocaleDateString('en-GB'));
        
        // Show loading
        $('#itemsLoading').show();
        $('#itemsEmpty').hide();
        $('#itemsTableBody').html('');
        
        // Show modal immediately
        $('#itemsModal').modal('show');
        
        // Load items via AJAX
        $.ajax({
            url: '<?php echo base_url('products/get_transfer_items/')?>' + currentTransferId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Items response:', response);
                
                $('#itemsLoading').hide();
                
                if (response.success && response.items && response.items.length > 0) {
                    var html = '';
                    var totalQty = 0;
                    var totalValue = 0;
                    
                    $.each(response.items, function(index, item) {
                        var qty = parseFloat(item.qty || 0);
                        var price = parseFloat(item.price || 0);
                        var value = qty * price;
                        
                        totalQty += qty;
                        totalValue += value;
                        
                        html += '<tr>' +
                            '<td class="text-center">' + (index + 1) + '</td>' +
                            '<td>' + (item.product || 'N/A') + '</td>' +
                            '<td>' + (item.code || 'N/A') + '</td>' +
                            '<td class="text-center">' + qty.toFixed(4) + '</td>' +
                            '<td class="text-center">' + (item.product_des ? parseFloat(item.product_des).toFixed(2) : 'N/A') + '</td>' +
                            '<td class="text-center">' + (item.unit || 'N/A') + '</td>' +
                            '<td class="text-center">' + (item.pwith || 'N/A') + '</td>' +
                            '<td class="text-center">' + (item.pthickness ? parseFloat(item.pthickness).toFixed(4) : 'N/A') + '</td>' +
                            '<td class="text-center">' + (item.pquick ? parseFloat(item.pquick).toFixed(4) : 'N/A') + '</td>' +
                            '<td class="text-center">' + (item.pquick_code || 'N/A') + '</td>' +
                            '</tr>';
                    });
                    
                    // Add totals row
                    html += '<tr class="table-info font-weight-bold">' +
                        '<td colspan="3" class="text-right">TOTAL:</td>' +
                        '<td class="text-center">' + totalQty.toFixed(4) + '</td>' +
                        '<td colspan="6"></td>' +
                        '</tr>';
                    
                    $('#itemsTableBody').html(html);
                } else {
                    $('#itemsEmpty').show();
                    $('#itemsEmpty').text(response.message || 'No items found for this transfer');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                $('#itemsLoading').hide();
                $('#itemsEmpty').show();
                $('#itemsEmpty').html('Error loading items. Please try again.<br><small>' + error + '</small>');
            }
        });
    });
    
    // Export current transfer items
    $('#exportCurrentItems').click(function() {
        if (!currentTransferId) {
            alert('No transfer selected');
            return;
        }
        
        // Create form and submit
        var form = $('<form>', {
            'method': 'post',
            'action': '<?php echo base_url("products/export_single_transfer")?>',
            'target': '_blank'
        });
        
        form.append($('<input>', {
            'type': 'hidden',
            'name': '<?=$this->security->get_csrf_token_name()?>',
            'value': '<?=$this->security->get_csrf_hash()?>'
        }));
        
        form.append($('<input>', {
            'type': 'hidden',
            'name': 'transfer_id',
            'value': currentTransferId
        }));
        
        $('body').append(form);
        form.submit();
        form.remove();
    });
    
    // Delete button
    $('#stocktransfer').on('click', '.delete-object', function() {
        var objectId = $(this).data('object-id');
        $('#object-id').val(objectId);
        $('#delete_model').modal('show');
    });
    
    // Delete confirmation
    $('#delete-confirm').click(function() {
        var objectId = $('#object-id').val();
        
        $.ajax({
            url: '<?php echo base_url('products/delete_transfer')?>',
            type: 'POST',
            data: {
                id: objectId,
                <?=$this->security->get_csrf_token_name()?>: '<?=$this->security->get_csrf_hash()?>'
            },
            dataType: 'json',
            success: function(response) {
                $('#delete_model').modal('hide');
                
                if (response.success) {
                    // Refresh the table
                    table.ajax.reload();
                    
                    // Show success message
                    showNotification('success', response.message);
                } else {
                    showNotification('error', response.message);
                }
            },
            error: function() {
                $('#delete_model').modal('hide');
                showNotification('error', 'Failed to delete transfer');
            }
        });
    });
    
    // Helper function to format date
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }
    
    // Helper function to show notifications
    function showNotification(type, message) {
        $('#notify').removeClass('alert-success alert-danger').addClass('alert-' + (type === 'success' ? 'success' : 'danger')).show();
        $('#notify .message').html('<strong>' + (type === 'success' ? 'Success:' : 'Error:') + '</strong> ' + message);
        
        setTimeout(function() {
            $('#notify').fadeOut();
        }, 5000);
    }
    
    // Close notification when X is clicked
    $('#notify .close').click(function() {
        $('#notify').fadeOut();
    });
    
    // Clear modal data when modal is closed
    $('#itemsModal').on('hidden.bs.modal', function() {
        currentTransferId = null;
        currentTransferData = null;
        $('#itemsTableBody').html('');
        $('#itemsLoading').show();
        $('#itemsEmpty').hide();
    });
});
</script>