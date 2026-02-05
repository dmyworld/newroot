<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">Tools & Assets <a href="<?php echo base_url('assetmanager/add') ?>"
                                                       class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <table id="assets_table" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>Asset Name</th>
                        <th>Serial #</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($assets_list as $row) { ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['serial']; ?></td>
                            <td>
                                <?php 
                                    $badge = 'badge-success';
                                    if($row['status'] == 'In Use') $badge = 'badge-warning';
                                    if($row['status'] == 'Damaged') $badge = 'badge-danger';
                                ?>
                                <span class="badge <?php echo $badge; ?>"><?php echo $row['status']; ?></span>
                            </td>
                            <td><?php echo $row['employee_name']; ?></td>
                            <td><?php echo amountExchange($row['value'], 0, $this->aauth->get_user()->loc) ?></td>
                            <td>
                                <a href="#" data-object-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Asset Name</th>
                        <th>Serial #</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#assets_table').DataTable({
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true
                },
                {
                    extend: 'csvHtml5',
                    footer: true
                }
            ]
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
                <p><?php echo $this->lang->line('delete_this_confirm') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="assetmanager/delete">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
