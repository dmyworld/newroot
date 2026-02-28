<style>
    .hp-manage-body { padding: 1.5rem; background: #f4f7fa; }
    .glass-card {
        background: #fff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-header-luxury {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 1.5rem 2rem;
        color: #fff;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-header-luxury h4 { color: #fff; font-weight: 700; margin: 0; font-size: 1.3rem; }
    
    .table thead th {
        background: #f8fafc;
        color: #4a5568;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table tbody tr:hover { background-color: #f8faff; }
    
    .badge-luxury {
        padding: 0.5em 1em;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
    .st-pending { background-color: #fee2e2; color: #ef4444; }
    .st-active { background-color: #dcfce7; color: #10b981; }
    .st-completed { background-color: #e0e7ff; color: #6366f1; }
    .st-defaulted { background-color: #fef3c7; color: #f59e0b; }

    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-view { background-color: #eff6ff; color: #3b82f6; }
    .btn-view:hover { background-color: #3b82f6; color: #fff; }
</style>

<div class="content-body hp-manage-body">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="glass-card">
        <div class="card-header card-header-luxury">
            <h4><i class="ft-list"></i> Managed HP Contracts</h4>
            <a href="<?= base_url('hp/create') ?>" class="btn btn-light btn-sm font-weight-bold">
                <i class="ft-plus"></i> New Contract
            </a>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="hp_table" class="table table-hover table-responsive-sm w-100" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Agreed Value</th>
                        <th>Plan Details</th>
                        <th>Current Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#hp_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'responsive': true,
            'ajax': {
                'url': "<?php echo site_url('hp/contract_list') ?>",
                'type': 'POST',
                'data': {'<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'}
            },
            'columnDefs': [
                { 'targets': [0], 'orderable': false },
                { 'targets': [5], 'className': 'text-right' }
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-outline-success btn-sm',
                    text: '<i class="fa fa-file-excel-o"></i> Export',
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search contracts...",
                lengthMenu: "_MENU_"
            }
        });
    });
</script>
