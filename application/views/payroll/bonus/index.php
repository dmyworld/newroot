<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Bonus Management') ?> <a href="<?php echo base_url('payrollbonus/create') ?>"
                                                         class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a></h5>
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
                <table id="details_table" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Employee') ?></th>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Type') ?></th>
                        <th><?php echo $this->lang->line('Effective Date') ?></th>
                        <th><?php echo $this->lang->line('Note') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
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
        $('#details_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('payrollbonus/ajax_list') ?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                }
            },
            'columnDefs': [
                {
                    'targets': [0, 7],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ],
        });
    });

    $(document).on('click', ".mark-paid", function (e) {
        e.preventDefault();
        var bonusId = $(this).attr('data-bonus-id');
        
        if(confirm('Mark this bonus as Paid?')) {
            $.ajax({
                url: '<?= base_url("payrollbonus/mark_as_paid") ?>',
                method: 'POST',
                data: { 
                    bonus_id: bonusId,
                    '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'Success') {
                        $('#details_table').DataTable().ajax.reload();
                        $('#notify').show().find('.message').html(response.message);
                        setTimeout(function(){ $('#notify').fadeOut(); }, 3000);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    $(document).on('click', ".delete-object", function (e) {
        e.preventDefault();
        $('#delete_model').modal({backdrop: 'static', keyboard: false});
        var objectid = $(this).attr('data-object-id');
        //$('#delete_model .delete-object_1').attr('data-object-id', objectid);
         $('#delete_object_id').val(objectid); // Pass to hidden field
    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this bonus') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delete_object_id" value=""/>
                <input type="hidden" id="action-url" value="payrollbonus/delete"/>
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
