<style>
    /* ============================================
       BLUE & LIFE GREEN - PSYCHOLOGICAL THEME
       Based on Owner Dashboard (Style 9)
    ============================================ */
    
    :root {
        /* Blue & Green Palette */
        --psy-bg-page: #eff6ff; /* Alice Blue (Page BG) */
        --psy-bg-card: #ffffff;
        --psy-text-primary: #1e3a8a; /* Navy Blue 900 */
        --psy-text-secondary: #334155; /* Slate 700 (Neutral) */
        --psy-accent-primary: #2563eb; /* Royal Blue */
        --psy-accent-success: #16a34a; /* Life Green */
        --psy-accent-danger: #ef4444; /* Red (Standard Danger) */
        --psy-accent-warning: #f59e0b; /* Amber */
        --psy-border: #bfdbfe; /* Blue 200 */
        --psy-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.1), 0 2px 4px -1px rgba(30, 58, 138, 0.06);
        --psy-glass: rgba(255, 255, 255, 0.95);
        
        --radius-std: 8px;
        --radius-lg: 12px;
    }

    /* Force overrides for Global Dark Mode leaks */
    html, body, .app-content, .content-wrapper, .content-body {
        background-color: var(--psy-bg-page) !important;
        color: var(--psy-text-primary) !important;
        font-family: 'Montserrat', sans-serif;
    }

    .content-body {
        padding: 2rem;
    }

    /* GLASSMORPHIC HEADER match Dashboard */
    .page-header-glass {
        background: #ffffff;
        border: 1px solid var(--psy-border);
        box-shadow: var(--psy-shadow);
        border-radius: var(--radius-lg);
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .page-header-glass::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, var(--psy-accent-primary), var(--psy-accent-success));
    }

    .page-title h2 {
        color: var(--psy-text-primary);
        font-weight: 800;
        letter-spacing: -0.5px;
        margin: 0;
        font-size: 1.8rem;
        text-transform: uppercase;
    }

    /* PREMIUM BUTTONS MATCHING DASHBOARD */
    .btn-premium {
        background: white;
        color: var(--psy-accent-primary);
        border: 1px solid var(--psy-border);
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        background: var(--psy-bg-page);
        border-color: var(--psy-accent-primary);
        color: var(--psy-accent-primary);
        box-shadow: var(--psy-shadow);
    }
    
    .btn-premium.btn-success-glass {
        color: var(--psy-accent-success);
        border-color: #bbf7d0; /* Green 200 */
        background: #f0fdf4; /* Green 50 */
    }
    .btn-premium.btn-success-glass:hover {
        background: #dcfce7;
        border-color: var(--psy-accent-success);
    }

    .btn-premium.btn-primary-glass {
        color: var(--psy-accent-primary);
        border-color: var(--psy-border);
        background: #eff6ff; 
    }
    .btn-premium.btn-primary-glass:hover {
        background: #dbeafe;
        border-color: var(--psy-accent-primary);
    }

    /* PREMIUM CARDS */
    .premium-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--psy-border);
        box-shadow: var(--psy-shadow);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .premium-card-header {
        background: #f8f9fa;
        border-bottom: 1px solid var(--psy-border);
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .premium-card-title {
        margin-bottom: 0;
        color: var(--psy-text-primary);
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    /* DATA TABLE & LIST */
    .table-responsive { overflow-x: auto; }

    .table-premium {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-premium thead th {
        background: #f8fafc;
        color: var(--psy-text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid var(--psy-border);
        border-top: none;
    }

    .table-premium tbody tr {
        transition: all 0.2s;
    }

    .table-premium tbody tr:hover {
        background-color: #f1f5f9; /* Slate 100 */
        transform: scale(1.002);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        z-index: 5;
        position: relative;
    }

    .table-premium td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: var(--psy-text-secondary);
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .table-premium td h5 {
        color: var(--psy-text-primary);
        font-weight: 600;
        margin: 0;
        font-size: 1rem;
    }

    /* Badge & Labels */
    .badge-psy {
        padding: 0.4em 0.8em;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .badge-psy-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-psy-info { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-psy-warning { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

    /* Filter Inputs */
    .filter-input-glass {
        background: #ffffff !important;
        border: 1px solid var(--psy-border) !important;
        color: var(--psy-text-primary) !important;
        font-size: 0.9rem;
        border-radius: 6px;
        padding: 0.6rem 1rem;
        height: auto;
    }
    .filter-input-glass:focus {
        border-color: var(--psy-accent-primary) !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Modals */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        padding: 1.5rem;
    }
    .modal-title {
        color: var(--psy-text-primary);
        font-weight: 700;
    }
    .close {
        color: var(--psy-text-secondary);
        opacity: 0.7;
    }
    .close:hover { opacity: 1; }
</style>

<div class="content-body">
    
    <!-- HEADER -->
    <div class="page-header-glass">
        <div class="page-title">
            <h2><?php echo $this->lang->line('Products') ?></h2>
        </div>
        <div class="header-actions">
            <!-- Note: Replaced gradients with new premium glass styles -->
            <a href="<?php echo base_url('products/add') ?>" class="btn-premium mr-2">
                 <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add new') ?>
            </a>
            <a href="<?php echo base_url('productcategory/category_products_add') ?>" class="btn-premium btn-success-glass mr-2">
                <i class="fa fa-tree"></i> Add Timber Products
            </a> 
            <a href="<?php echo base_url('productcategory/add_sub') ?>" class="btn-premium btn-primary-glass">
                <i class="fa fa-folder-open"></i> <?php echo $this->lang->line('Add new') . ' - ' . $this->lang->line('Sub') . ' ' . $this->lang->line('Category') ?>
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <!-- SUB CATEGORIES TABLE -->
    <?php if (isset($cat[0])) { ?>
        <div class="premium-card mb-5">
            <div class="premium-card-header">
                <h5 class="premium-card-title">
                    <i class="fa fa-folder text-warning mr-2"></i><?php echo $this->lang->line('Sub') ?> <?php echo $this->lang->line('Categories') ?>
                </h5>
            </div>
            <div class="table-responsive">
                <table id="catgtable" class="table table-premium">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Total Products') ?></th>
                        <th><?php echo $this->lang->line('Total') ?> <?php echo $this->lang->line('Stock Quantity') ?></th>
                        <th>Worth (Sales/Cost)</th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($cat as $row) {
                        $cid = $row['id'];
                        $title = $row['title'];
                        $total = $row['pc'];

                        $qty = +$row['qty'];
                        $salessum = amountExchange($row['salessum'], 0, $this->aauth->get_user()->loc);
                        $worthsum = amountExchange($row['worthsum'], 0, $this->aauth->get_user()->loc);
                        echo "<tr>
                <td>$i</td>
                <td><a href='" . base_url("productcategory/view?id=$cid&sub=true") . "' class='font-weight-bold text-primary'>$title</a></td>
                <td><span class='badge-psy badge-psy-info'>$total Items</span></td>
                <td><span class='badge-psy badge-psy-warning'>$qty Units</span></td>
                <td>$salessum / <span class='text-muted'>$worthsum</span></td>
                <td>
                    <a href='" . base_url("productcategory/view?id=$cid&sub=true") . "' class='btn btn-outline-primary btn-sm rounded'><i class='fa fa-eye'></i></a>&nbsp; 
                    <a class='btn btn-outline-info btn-sm rounded' href='" . base_url() . "productcategory/report_product?id=" . $cid . "&sub=true' target='_blank'> <span class='fa fa-pie-chart'></span></a>&nbsp; 
                    <a href='" . base_url("productcategory/edit?id=$cid") . "' class='btn btn-outline-warning btn-sm rounded'><i class='fa fa-pencil'></i></a>&nbsp;
                    <a href='#' data-object-id='" . $cid . "' class='btn btn-outline-danger btn-sm rounded delete-object2' title='Delete'><i class='fa fa-trash'></i></a>
                </td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>


    <!-- FILTER SECTION -->
    <div class="premium-card mb-4" style="border-left: 4px solid var(--psy-accent-primary);">
        <div class="card-body">
            <h5 class="card-title text-primary mb-3"><i class="fa fa-filter"></i> <?php echo $this->lang->line('Filter') ?> & Search</h5>
            <div class="row">
                <div class="col-md-3">
                    <label for="warehouse_id" class="text-uppercase font-weight-bold text-muted small"><?php echo $this->lang->line('Warehouse') ?></label>
                    <select id="warehouse_id" class="form-control filter-input-glass">
                        <option value="0"><?php echo $this->lang->line('All') ?></option>
                        <?php foreach ($warehouse as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" id="filter" class="btn btn-primary btn-block shadow-sm font-weight-bold" style="padding: 0.6rem;"><i class="fa fa-search"></i> <?php echo $this->lang->line('Search') ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN PRODUCTS TABLE -->
    <div class="premium-card">
        <div class="premium-card-header">
             <h5 class="premium-card-title">
                <i class="fa fa-cubes text-info mr-2"></i><?php echo $this->lang->line('Products') ?> List
            </h5>
            <div class="card-actions">
                <!-- Optional: Add table actions like export here if needed -->
            </div>
        </div>
        <div class="table-responsive">
            <table id="productstable" class="table table-premium">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Stock') ?></th>
                    <th> Q Trunks Stock </th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('Category') ?></th>
                    <th><?php echo $this->lang->line('Warehouse') ?></th>
                    <th><?php echo $this->lang->line('Price') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    var table;
    $(document).ready(function () {
        //datatables
        table = $('#productstable').DataTable({
            "processing": true,
            "serverSide": true, 
            "order": [], 
            responsive: true,
            "ajax": {
                "url": "<?php if (isset($sub)) { $t = '1'; } else { $t = '0'; } echo site_url('products/product_list') . '?id=' . $id . '&sub=' . $t;  ?>",
                "type": "POST",
                'data': function (d) {
                    d.wid = $('#warehouse_id').val();
                    d.<?=$this->security->get_csrf_token_name()?> = crsf_hash;
                }
            },
            "columnDefs": [
                {
                    "targets": [0], 
                    "orderable": false, 
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    },
                    className: 'btn-premium btn-sm mb-2'
                }
            ],
            "drawCallback": function( settings ) {
                // Apply any JS side styling if needed after table draw
            }
        });

        $('#filter').click(function () {
            table.ajax.reload();
        });
        
        $(document).on('click', ".view-object", function (e) {
            e.preventDefault();
            $('#view-object-id').val($(this).attr('data-object-id'));

            $('#view_model').modal({backdrop: 'static', keyboard: false});

            var actionurl = $('#view-action-url').val();
            $.ajax({
                url: baseurl + actionurl,
                data: 'id=' + $('#view-object-id').val() + '&' + crsf_token + '=' + crsf_hash,
                type: 'POST',
                dataType: 'html',
                success: function (data) {
                    $('#view_object').html(data);
                }
            });
        });
    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this product') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="products/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="view-object-id" value="">
<input type="hidden" id="view-action-url" value="products/view_over">

<div id="view_model" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('View') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="view_object">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="view-object-id" value="">
                <input type="hidden" id="view-action-url" value="products/view_over">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><?php echo $this->lang->line('Close') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="delete_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this product category') ?></strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id2" value="">
                <input type="hidden" id="action-url2" value="productcategory/delete_i_sub">
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete-confirm2"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>