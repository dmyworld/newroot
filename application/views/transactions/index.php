<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters">
                <div class="col-md-12 text-center pt-4 pb-2">
                    <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('Transactions') ?></h2>
                    <p class="text-white-50 mb-0">Track Income, Expenses & Transfers</p>
                </div>
            </div>
            
            <!-- Artistic Tabs -->
            <ul class="nav nav-tabs nav-justified border-0 mt-3" id="transactionTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active py-3 filter-tab" href="#" data-type="" style="border:none; border-bottom: 4px solid #FFC107; color: #fff; background: rgba(255,255,255,0.1);">
                        <i class="fa fa-list mr-1"></i> <?php echo $this->lang->line('All') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 filter-tab" href="#" data-type="income" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-arrow-down mr-1 text-success"></i> <?php echo $this->lang->line('Income') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 filter-tab" href="#" data-type="expense" style="border:none; color: rgba(255,255,255,0.7);">
                         <i class="fa fa-arrow-up mr-1 text-danger"></i> <?php echo $this->lang->line('Expenses') ?>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
             <div class="row mb-2">
                <div class="col-12 text-right">
                     <a href="<?php echo base_url('transactions/add') ?>" class="btn btn-outline-primary btn-md rounded shadow-sm font-weight-bold">
                        <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add new') ?>
                    </a>
                </div>
            </div>

            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

            <div class="table-responsive">
                <table id="trans_table" class="table table-hover table-striped mb-0 text-dark" cellspacing="0" width="100%">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="border-top-0"><?php echo $this->lang->line('Date') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Account') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Debit') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Credit') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Payer') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Method') ?></th>
                            <th class="border-top-0"><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot class="bg-light text-muted">
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Account') ?></th>
                            <th><?php echo $this->lang->line('Debit') ?></th>
                            <th><?php echo $this->lang->line('Credit') ?></th>
                            <th><?php echo $this->lang->line('Payer') ?></th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Tab Styling */
.nav-tabs .nav-link:hover {
    border: none;
    color: #fff !important;
    background: rgba(255,255,255,0.2);
}
.nav-tabs .nav-link.active {
    background: transparent;
    color: #FFC107 !important;
    border-bottom: 4px solid #FFC107 !important;
}
.table td {
    vertical-align: middle;
}
</style>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            responsive: true,
            "ajax": {
                "url": "<?php echo site_url('transactions/translist')?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csvHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ],
        });

        // Tab Filtering Logic
        $('.filter-tab').click(function(e){
            e.preventDefault();
            
            // UI Handling
            $('.filter-tab').removeClass('active');
            $('.filter-tab').css('border-bottom', 'none'); 
            $('.filter-tab').css('color', 'rgba(255,255,255,0.7)');
            
            $(this).addClass('active');
            $(this).css('border-bottom', '4px solid #FFC107');
             $(this).css('color', '#fff');

            // Data Handling
            var type = $(this).data('type');
            var newUrl = "<?php echo site_url('transactions/translist')?>?type=" + type;
            
            table.ajax.url(newUrl).load();
        });
    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>