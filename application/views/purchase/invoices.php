<style>
/* Modern Purchase Invoices Page Styling */
.purchase-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 20px 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.purchase-header-card h4 {
    color: #fff;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.purchase-header-card .btn-add-new {
    background: #fff;
    color: #667eea;
    border: none;
    padding: 8px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.purchase-header-card .btn-add-new:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    background: #f8f9ff;
}

.filter-section {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.filter-section .filter-label {
    font-weight: 600;
    color: #4a5568;
    font-size: 13px;
    margin-bottom: 5px;
    display: block;
}

.filter-section .form-control {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 12px;
    transition: all 0.3s;
}

.filter-section .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-search {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: #fff;
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    color: #fff;
}

.btn-reset {
    background: #fff;
    border: 2px solid #e2e8f0;
    color: #4a5568;
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-reset:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
}

.table-card {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

#po_wrapper {
    background: transparent;
}

#po thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    padding: 15px 10px;
}

#po tbody td {
    padding: 12px 10px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

#po tbody tr {
    transition: all 0.2s;
}

#po tbody tr:hover {
    background-color: #f8f9ff;
    transform: scale(1.01);
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
}

.status-paid {
    background: #d4edda;
    color: #155724;
}

.status-due {
    background: #fff3cd;
    color: #856404;
}

.status-partial {
    background: #d1ecf1;
    color: #0c5460;
}

.status-canceled {
    background: #f8d7da;
    color: #721c24;
}

.action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    margin: 0 2px;
    transition: all 0.2s;
    border: none;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.btn-view {
    background: #667eea;
    color: #fff;
}

.btn-edit {
    background: #48bb78;
    color: #fff;
}

.btn-delete {
    background: #f56565;
    color: #fff;
}

.dataTables_wrapper .dataTables_filter input {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 6px 12px;
}

.dataTables_wrapper .dataTables_length select {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 6px 12px;
}

.dt-buttons .btn {
    background: #667eea;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    margin-right: 8px;
}

.dt-buttons .btn:hover {
    background: #5568d3;
}
</style>

<div class="content-body">
    <!-- Header Card -->
    <div class="purchase-header-card">
        <h4>
            <span><i class="fa fa-shopping-cart mr-2"></i><?php echo $this->lang->line('Purchase Order') ?></span>
            <a href="<?php echo base_url('pos_invoices/purchasecreate') ?>" class="btn btn-add-new">
                <i class="fa fa-plus-circle mr-1"></i><?php echo $this->lang->line('Add new') ?>
            </a>
        </h4>
    </div>

    <!-- Notification Alert -->
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="filter-label"><i class="fa fa-calendar mr-1"></i><?php echo $this->lang->line('Date') ?> From</label>
                <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date" autocomplete="off" data-toggle="datepicker"/>
            </div>
            <div class="col-md-3">
                <label class="filter-label"><i class="fa fa-calendar mr-1"></i><?php echo $this->lang->line('Date') ?> To</label>
                <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date" autocomplete="off" data-toggle="datepicker"/>
            </div>
            <div class="col-md-2">
                <label class="filter-label"><i class="fa fa-info-circle mr-1"></i>Status</label>
                <select name="status_filter" id="status_filter" class="form-control">
                    <option value="">All Status</option>
                    <option value="paid">Paid</option>
                    <option value="due">Due</option>
                    <option value="partial">Partial</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" name="search" id="search" class="btn btn-search mr-2">
                    <i class="fa fa-search mr-1"></i>Search
                </button>
                <button type="button" name="reset" id="reset" class="btn btn-reset">
                    <i class="fa fa-refresh mr-1"></i>Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <table id="po" class="table table-hover table-striped zero-configuration" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 5%"><?php echo $this->lang->line('No') ?></th>
                    <th style="width: 12%">Order #</th>
                    <th style="width: 20%"><?php echo $this->lang->line('Supplier') ?></th>
                    <th style="width: 12%"><?php echo $this->lang->line('Date') ?></th>
                    <th style="width: 15%"><?php echo $this->lang->line('Amount') ?></th>
                    <th style="width: 12%"><?php echo $this->lang->line('Status') ?></th>
                    <th style="width: 24%" class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th><?php echo $this->lang->line('No') ?></th>
                    <th>Order #</th>
                    <th><?php echo $this->lang->line('Supplier') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h4 class="modal-title"><i class="fa fa-trash mr-2"></i><?php echo $this->lang->line('Delete Order') ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0"><i class="fa fa-warning text-warning mr-2"></i><?php echo $this->lang->line('delete this order') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="purchase/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete-confirm">
                    <i class="fa fa-trash mr-1"></i>Delete
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">
                    <i class="fa fa-times mr-1"></i>Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    let dataTable;
    
    var status = "<?php echo (isset($status) ? $status : '') ?>";
    var branch_id = "<?php echo (isset($branch_id) ? $branch_id : '') ?>";
    var start_date = "<?php echo (isset($start_date) ? $start_date : '') ?>";
    var end_date = "<?php echo (isset($end_date) ? $end_date : '') ?>";

    if (start_date != '') $('#start_date').val(start_date);
    if (end_date != '') $('#end_date').val(end_date);
    if (status != '') $('#status_filter').val(status);

    function draw_data(start_date = '', end_date = '', status = '', branch_id = '') {
        if (dataTable) {
            dataTable.destroy();
        }
        
        dataTable = $('#po').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [[1, 'desc']],
            'ajax': {
                'url': "<?php echo site_url('purchase/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    status: status,
                    loc: branch_id
                }
            },
            'columnDefs': [
                {
                    'targets': [0, 6],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o mr-1"></i>Export Excel',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o mr-1"></i>Export CSV',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o mr-1"></i>Export PDF',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                }
            ],
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            }
        });
    }
    
    // Initial load
    draw_data(start_date, end_date, status, branch_id);

    // Search button
    $('#search').click(function () {
        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();
        const status = $('#status_filter').val();
        
        if (start_date !== '' && end_date !== '') {
            draw_data(start_date, end_date, status, ''); // Clear branch filter on manual search
        } else if (status !== '') {
            draw_data('', '', status, '');
        } else {
            alert("Please select date range or status to filter");
        }
    });
    
    // Reset button
    $('#reset').click(function () {
        $('#start_date').val('');
        $('#end_date').val('');
        $('#status_filter').val('');
        draw_data();
    });
    
    // Allow Enter key on date inputs
    $('#start_date, #end_date, #status_filter').keypress(function(e) {
        if (e.which == 13) {
            $('#search').click();
        }
    });
});
</script>
