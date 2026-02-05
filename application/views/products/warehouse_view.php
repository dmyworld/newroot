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
            <h2><?php echo $this->lang->line('Products') ?></h2>
        </div>
        <div class="header-actions">
            <a href="<?php echo base_url('products/add') ?>" class="btn-premium">
                <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add new') ?>
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="timber-table-card">
        <div class="table-responsive">
            <table id="productstable" class="table table-timber">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Stock') ?></th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('Category') ?></th>
                    <th><?php echo $this->lang->line('Price') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Stock') ?></th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('Category') ?></th>
                    <th><?php echo $this->lang->line('Price') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </tfoot>
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
                "url": "<?php echo site_url('products/warehouseproduct_list') . '?id=' . $_GET['id']; ?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
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
                        columns: [1, 2, 3, 4, 5]
                    }
                }
            ],
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
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="view_model" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('View') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="view_object">
                <p></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="view-object-id" value="">
                <input type="hidden" id="view-action-url" value="products/view_over">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><?php echo $this->lang->line('Close') ?></button>
            </div>
        </div>
    </div>
</div>