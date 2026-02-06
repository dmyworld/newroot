<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Manage POS Invoices') ?> <a
                        href="<?php echo base_url('pos_invoices/create') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?></a></h4>
                                    <?php $id = $_GET['id'] ?? null;
                        
                        if ($id == 'v2'): ?>
                              <a href="<?php echo base_url('pos_invoices') ?>">Go Back</a>
                        <?php else: ?>
                              <a href="<?php echo base_url('pos_invoices?id=v2') ?>">V2</a>
                        <?php endif; ?>
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
            <div class="card-body">
                <div class="row">

                    <div class="col-md-2"><?php echo $this->lang->line('Invoice Date') ?></div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date"
                               class="date30 form-control form-control-sm" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                               data-toggle="datepicker" autocomplete="off"/>
                    </div>

                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"/>
                    </div>

                </div>
                <hr>
                <table id="invoices" class="table table-striped table-bordered  dataex-res-constructor">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th> #</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th>Due</th>
                        <th>Payment</th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th> #</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th>Due</th>
                        <th>Payment</th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header bg-gradient-danger" style="background: linear-gradient(87deg, #f5365c 0, #f56036 100%) !important; color: white;">
                <h4 class="modal-title text-white">
                    <i class="fa fa-exclamation-triangle mr-1"></i> <?php echo $this->lang->line('Delete Invoice') ?>
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="text-danger display-1 mb-2"><i class="fa fa-times-circle-o"></i></div>
                <h5 class="font-weight-bold text-dark mb-1"><?php echo $this->lang->line('Are you sure?') ?></h5>
                <p class="text-muted mb-0" style="font-size: 1.1rem;"><?php echo $this->lang->line('delete this invoice') ?>?</p>
                <p class="text-muted small mt-2">This action cannot be undone and will permanently remove the invoice data.</p>
            </div>
            <div class="modal-footer bg-light rounded-bottom">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="pos_invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-secondary px-4 font-weight-bold">
                    <?php echo $this->lang->line('Cancel') ?>
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-danger px-4 font-weight-bold shadow-sm" id="delete-confirm">
                    <i class="fa fa-trash mr-1"></i> <?php echo $this->lang->line('Delete') ?>
                </button>
            </div>
        </div>
    </div>
</div>


<?php
if (($_GET['id'] ?? null) == 'v2') {
    ?>
    
    

<script type="text/javascript">
    $(document).ready(function () {
        var status = "<?php echo (isset($status) ? $status : '') ?>";
        var branch_id = "<?php echo (isset($branch_id) ? $branch_id : '') ?>";
        var start_date = "<?php echo (isset($start_date) ? $start_date : '') ?>";
        var end_date = "<?php echo (isset($end_date) ? $end_date : '') ?>";

        if (start_date != '') $('#start_date').val(start_date);
        if (end_date != '') $('#end_date').val(end_date);

        draw_data(start_date, end_date, status, branch_id);

        function draw_data(start_date = '', end_date = '', status = '', branch_id = '') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('pos_invoices/ajax_list_v2')?>",
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
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
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
        }

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date, '', '');
            } else {
                alert("Date range is Required");
            }
        });
    });
</script>


    
   <?php
    
    
    
    
} else {
    
    ?>
    
    

<script type="text/javascript">
    $(document).ready(function () {
        var status = "<?php echo (isset($status) ? $status : '') ?>";
        var branch_id = "<?php echo (isset($branch_id) ? $branch_id : '') ?>";
        var start_date = "<?php echo (isset($start_date) ? $start_date : '') ?>";
        var end_date = "<?php echo (isset($end_date) ? $end_date : '') ?>";

        if (start_date != '') $('#start_date').val(start_date);
        if (end_date != '') $('#end_date').val(end_date);

        draw_data(start_date, end_date, status, branch_id);

        function draw_data(start_date = '', end_date = '', status = '', branch_id = '') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('pos_invoices/ajax_list')?>",
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
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
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
        }

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date, '', '');
            } else {
                alert("Date range is Required");
            }
        });
    });
</script>



    
   <?php 
}
?>

