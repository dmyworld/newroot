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
    
    .table-premium a {
        color: var(--psy-text-primary);
        font-weight: 700;
        text-decoration: none;
    }
    .table-premium a:hover {
        text-decoration: underline;
        color: var(--psy-accent-primary);
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
    <div class="page-header-glass">
        <div class="page-title">
                <h5><?php echo $this->lang->line('Add New Product Category') ?></h5>
                <hr>
                <?php if ($this->aauth->get_user()->roleid != 1) { ?>
                    <div class="alert alert-info">
                        <strong>Note:</strong> New categories require approval from a Super Admin before becoming visible to everyone.
                    </div>
                <?php } ?>
        </div>
        <div class="header-actions">
            <!-- Updated buttons to Glass/Premium styles -->
            <a href="<?php echo base_url('productcategory/add') ?>" class="btn-premium mr-2">
                 <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add new') . ' ' . $this->lang->line('Category') ?>
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

    <!-- User Guide -->
    <div class="premium-card mb-4" style="border-left: 4px solid var(--psy-accent-success);">
        <div class="card-header p-3 pointer" data-toggle="collapse" data-target="#guideCat" aria-expanded="false" style="cursor: pointer; background: white; border-bottom: none;">
            <h6 class="mb-0 text-psy-primary font-weight-bold"><i class="fa fa-info-circle mr-2 text-success"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
        </div>
        <div id="guideCat" class="collapse">
            <div class="card-body p-3 pt-0">
                <ul class="nav nav-tabs" role="tablist" style="border-bottom: 2px solid var(--psy-border);">
                    <li class="nav-item"><a class="nav-link active small p-2 font-weight-bold text-primary" data-toggle="tab" href="#eng_cat">🇬🇧 English</a></li>
                    <li class="nav-item"><a class="nav-link small p-2 font-weight-bold text-primary" data-toggle="tab" href="#sin_cat">🇱🇰 Sinhala</a></li>
                    <li class="nav-item"><a class="nav-link small p-2 font-weight-bold text-primary" data-toggle="tab" href="#tam_cat">IN Tamil</a></li>
                </ul>
                <div class="tab-content pt-3">
                    <div id="eng_cat" class="tab-pane active">
                        <h6 class="text-primary mt-1 small font-weight-bold">Product Categories</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>Create:</strong> Use 'Add New Category' to organize items (e.g., Electronics, Furniture).</li>
                            <li><strong>Sub-Categories:</strong> Create sub-groups for better classification.</li>
                            <li><strong>Reports:</strong> Click the 'Pie Chart' icon to see sales reports for specific categories.</li>
                        </ol>
                    </div>
                    <div id="sin_cat" class="tab-pane fade">
                        <h6 class="text-primary mt-1 small font-weight-bold">නිෂ්පාදන වර්ග (Categories)</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>නිර්මාණය:</strong> භාණ්ඩ වර්ගීකරණය කිරීමට 'Add New Category' භාවිතා කරන්න.</li>
                            <li><strong>උප වර්ග:</strong> වඩා හොඳ වර්ගීකරණයක් සඳහා උප කාණ්ඩ සාදන්න.</li>
                            <li><strong>වාර්තා:</strong> විකුණුම් වාර්තා බැලීමට 'Pie Chart' අයිකනය ක්ලික් කරන්න.</li>
                        </ol>
                    </div>
                    <div id="tam_cat" class="tab-pane fade">
                        <h6 class="text-primary mt-1 small font-weight-bold">தயாரிப்பு வகைகள்</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>உருவாக்கு:</strong> பொருட்களை ஒழுங்கமைக்க 'Add New Category' ஐப் பயன்படுத்தவும்.</li>
                            <li><strong>துணை வகைகள்:</strong> சிறந்த வகைப்பாட்டிற்காக துணைக் குழுக்களை உருவாக்கவும்.</li>
                            <li><strong>அறிக்கைகள்:</strong> விற்பனை அறிக்கைகளைக் காண 'Pie Chart' ஐகானைக் கிளிக் செய்யவும்.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Guide -->

    <div class="premium-card">
        <div class="premium-card-header">
             <h5 class="premium-card-title">
                <i class="fa fa-list-alt text-primary mr-2"></i><?php echo $this->lang->line('Category') ?> List
            </h5>
        </div>
        <div class="table-responsive">
            <table id="catgtable" class="table table-premium">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Total Products') ?></th>
                    <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                    <th> Worth (Retail / Wholesale)</th>
                    <th>Status</th>
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
                    $status = ($row['approved'] == 1) ? '<span class="badge-psy badge-psy-success">Approved</span>' : '<span class="badge-psy badge-psy-warning">Pending</span>';
                    
                    echo "<tr>
                <td>$i</td>
                <td><a href='" . base_url("productcategory/view?id=$cid") . "' >$title</a></td>
                <td><span class='badge-psy badge-psy-info'>$total Items</span></td>
                <td><span class='badge-psy badge-psy-warning'>$qty Units</span></td>
                <td>$salessum / <span class='text-muted'>$worthsum</span></td>
                <td>$status</td>
                <td>
                    <a href='" . base_url("productcategory/view?id=$cid") . "' class='btn btn-outline-primary btn-sm rounded'><i class='fa fa-eye'></i></a>&nbsp; 
                    <a class='btn btn-outline-info btn-sm rounded' href='" . base_url() . "productcategory/report_product?id=" . $cid . "' target='_blank'> <span class='fa fa-pie-chart'></span></a>&nbsp;  ";
                    
                    if ($this->aauth->get_user()->roleid == 1 && $row['approved'] == 0) {
                        echo "<a href='#' data-object-id='$cid' class='btn btn-outline-success btn-sm rounded approve-cat' title='Approve'><i class='fa fa-check'></i></a>&nbsp;";
                    }

                    echo "<a href='" . base_url("productcategory/edit?id=$cid") . "' class='btn btn-outline-warning btn-sm rounded'><i class='fa fa-pencil'></i></a>&nbsp;
                    <a href='#' data-object-id='" . $cid . "' class='btn btn-outline-danger btn-sm rounded delete-object' title='Delete'><i class='fa fa-trash'></i></a>
                </td></tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //datatables
        $('#catgtable').DataTable({
            responsive: true, dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    className: 'btn-premium btn-sm mb-2'
                }
            ],
        });
        });

        $(document).on('click', ".approve-cat", function (e) {
            e.preventDefault();
            var id = $(this).attr('data-object-id');
            var obj = $(this);
            jQuery.ajax({
                url: "<?php echo base_url('productcategory/approve') ?>",
                type: 'POST',
                data: {id: id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        obj.closest('tr').find('.badge-psy-warning').removeClass('badge-psy-warning').addClass('badge-psy-success').text('Approved');
                        obj.remove();
                    }
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
                <p><?php echo $this->lang->line('delete this product category') ?></strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="productcategory/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>