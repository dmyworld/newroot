<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5 class="title"> Machine Master <a
                    href="<?php echo base_url('machines/create') ?>"
                    class="btn btn-primary btn-sm rounded">
                <?php echo $this->lang->line('Add new') ?>
            </a>
        </h5>
        <hr>
        <table id="machine_table" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Capacity (per hr)</th>
                <th>Cycle Days</th>
                <th>Next Maint.</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Capacity (per hr)</th>
                <th>Cycle Days</th>
                <th>Next Maint.</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#machine_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'responsive': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('machines/get_list')?>",
                'type': 'POST',
                'data': {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
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
                <p><?php echo $this->lang->line('delete this location') ?></strong></p> 
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="machines/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
