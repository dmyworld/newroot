<style>
    /* ============================================
       TIMBER ERP PROFESSIONAL DESIGN SYSTEM v2.1
       Refined Palette & Layout
    ============================================ */
    
    :root {
        /* Timber Brand Colors - Deep & Professional */
        --timber-walnut: #5D4037;   /* Deep Brown */
        --timber-oak: #D4AF37;      /* Metallic Gold/Oak */
        --timber-forest: #2E7D32;   /* Rich Green */
        --timber-charcoal: #37474F; /* Dark Blue-Grey */
        
        /* Background & Surface tones */
        --bg-warm-cream: #FAF9F6;
        --bg-paper-white: #FFFFFF;
        --bg-soft-gray: #F5F7FA;
        
        /* Status Indicators */
        --status-critical: #D32F2F;
        --status-warning: #FFA000;
        --status-info: #1976D2;
        --status-success: #388E3C;
        
        /* UI Elements */
        --shadow-soft: 0 4px 20px rgba(0,0,0,0.05);
        --shadow-lifted: 0 10px 25px rgba(93, 64, 55, 0.1);
        --glass-border: 1px solid rgba(255,255,255,0.6);
        --radius-std: 12px;
        --radius-lg: 20px;
    }

    body {
        background-color: var(--bg-soft-gray);
        font-family: 'Montserrat', sans-serif;
        color: var(--timber-charcoal);
    }

    .content-body {
        padding: 2rem;
        background: radial-gradient(circle at 10% 10%, rgba(212, 175, 55, 0.05) 0%, transparent 40%);
    }

    /* GLASSMORPHIC HEADER */
    .page-header-glass {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: var(--glass-border);
        box-shadow: var(--shadow-soft);
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
        background: linear-gradient(90deg, var(--timber-walnut), var(--timber-oak));
    }

    .page-title h2 {
        color: var(--timber-walnut);
        font-weight: 800;
        letter-spacing: -0.5px;
        margin: 0;
        font-size: 2rem;
        text-transform: uppercase;
    }

    /* PREMIUM BUTTONS */
    .btn-premium {
        background: linear-gradient(135deg, var(--timber-walnut), #4E342E);
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(93, 64, 55, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(93, 64, 55, 0.4);
        background: linear-gradient(135deg, #4E342E, var(--timber-walnut));
        color: #fff;
    }

    /* DATA TABLE & LIST */
    .timber-table-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lifted);
        padding: 0;
        overflow: hidden;
    }

    .table-responsive { overflow-x: auto; }

    .table-timber {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-timber thead th {
        background: linear-gradient(to right, var(--timber-walnut), #4E342E);
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        padding: 1.2rem 1.5rem;
        border: none;
    }

    .table-timber tbody tr {
        transition: all 0.2s;
    }

    .table-timber tbody tr:nth-child(even) { background-color: #FAFAFA; }
    
    .table-timber tbody tr:hover {
        background-color: #FFF8E1; /* Light Gold tint */
        transform: scale(1.005);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        z-index: 5;
        position: relative;
    }

    .table-timber td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #F0F0F0;
        color: #555;
        font-weight: 500;
    }
    
    .table-timber a {
        color: var(--timber-walnut);
        font-weight: 700;
        text-decoration: none;
    }

    /* Modals */
    .modal-content {
        border-radius: 20px;
        border: none;
    }
    .modal-header {
        background: linear-gradient(135deg, var(--timber-walnut), var(--timber-oak));
        color: white;
        border-radius: 20px 20px 0 0;
    }
    .close {
        color: white;
        text-shadow: none;
        opacity: 1;
    }
</style>

<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h2><?php echo $this->lang->line('Product Category') ?></h2>
        </div>
        <div class="header-actions">
            <a href="<?php echo base_url('productcategory/add') ?>" class="btn-premium mr-1">
                 <?php echo $this->lang->line('Add new') . ' ' . $this->lang->line('Category') ?>
            </a>
            <a href="<?php echo base_url('productcategory/category_products_add') ?>" class="btn-premium mr-1" style="background: linear-gradient(135deg, #5D4037, #8D6E63);">
                Add Timber Products
            </a> 
            <a href="<?php echo base_url('productcategory/add_sub') ?>" class="btn-premium" style="background: linear-gradient(135deg, #1976D2, #1565C0);">
                <?php echo $this->lang->line('Add new') . ' - ' . $this->lang->line('Sub') . ' ' . $this->lang->line('Category') ?>
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <!-- User Guide -->
    <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #5D4037;">
        <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideCat" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
            <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
        </div>
        <div id="guideCat" class="collapse">
            <div class="card-body p-2">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_cat">🇬🇧 English</a></li>
                    <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_cat">🇱🇰 Sinhala</a></li>
                    <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_cat">IN Tamil</a></li>
                </ul>
                <div class="tab-content border p-2 bg-white">
                    <div id="eng_cat" class="tab-pane active">
                        <h6 class="text-primary mt-1 small">Product Categories</h6>
                        <ol class="small pl-3 mb-0">
                            <li><strong>Create:</strong> Use 'Add New Category' to organize items (e.g., Electronics, Furniture).</li>
                            <li><strong>Sub-Categories:</strong> Create sub-groups for better classification.</li>
                            <li><strong>Reports:</strong> Click the 'Pie Chart' icon to see sales reports for specific categories.</li>
                        </ol>
                    </div>
                    <div id="sin_cat" class="tab-pane fade">
                        <h6 class="text-primary mt-1 small">නිෂ්පාදන වර්ග (Categories)</h6>
                        <ol class="small pl-3 mb-0">
                            <li><strong>නිර්මාණය:</strong> භාණ්ඩ වර්ගීකරණය කිරීමට 'Add New Category' භාවිතා කරන්න.</li>
                            <li><strong>උප වර්ග:</strong> වඩා හොඳ වර්ගීකරණයක් සඳහා උප කාණ්ඩ සාදන්න.</li>
                            <li><strong>වාර්තා:</strong> විකුණුම් වාර්තා බැලීමට 'Pie Chart' අයිකනය ක්ලික් කරන්න.</li>
                        </ol>
                    </div>
                    <div id="tam_cat" class="tab-pane fade">
                        <h6 class="text-primary mt-1 small">தயாரிப்பு வகைகள்</h6>
                        <ol class="small pl-3 mb-0">
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

    <div class="timber-table-card">
        <div class="table-responsive">
            <table id="catgtable" class="table table-timber">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Total Products') ?></th>
                    <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                    <th>Worth (Retail  / Wholesale ) Price)</th>
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
                <td><a href='" . base_url("productcategory/view?id=$cid") . "' >$title</a></td>
                <td>$total</td>
                <td>$qty</td>
                <td>$salessum/$worthsum</td>
                <td>
                    <a href='" . base_url("productcategory/view?id=$cid") . "' class='btn btn-success btn-sm rounded shadow-sm'><i class='fa fa-eye'></i> " . $this->lang->line('View') . "</a>&nbsp; 
                    <a class='btn btn-info btn-sm rounded shadow-sm' href='" . base_url() . "productcategory/report_product?id=" . $cid . "' target='_blank'> <span class='fa fa-pie-chart'></span>" . $this->lang->line('Sales') . "</a>&nbsp;  
                    <a href='" . base_url("productcategory/edit?id=$cid") . "' class='btn btn-warning btn-sm rounded shadow-sm'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;
                    <a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-sm rounded shadow-sm delete-object' title='Delete'><i class='fa fa-trash'></i></a>
                </td></tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Total Products') ?></th>
                    <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                    <th>Worth (Retail  / Wholesale ) Price)</th>
                    <th><?php echo $this->lang->line('Action') ?></th>
                </tr>
                </tfoot>
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
                    }
                }
            ],
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
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>