<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Settings') ?? 'Role-Based Settings' ?>
                <a href="<?php echo base_url('role_settings/add') ?>" class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?? 'Add New' ?>
                </a>
            </h5>
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
            
            <?php if($this->session->flashdata('message')): ?>
                <?php echo $this->session->flashdata('message'); ?>
            <?php endif; ?>

            <div class="card-body">
                <table id="srtable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Setting Key</th>
                        <th>Value</th>
                        <th>Access Level</th>
                        <th>Allowed Roles</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; foreach ($settings as $row) {
                        echo "<tr>
                            <td>$i</td>
                            <td>{$row['setting_key']}</td>
                            <td>" . (strlen($row['setting_value']) > 50 ? substr($row['setting_value'],0,50).'...' : $row['setting_value']) . "</td>
                            <td>" . ucfirst(str_replace('_', ' ', $row['access_level'])) . "</td>
                            <td>{$row['allowed_roles']}</td>
                            <td>
                                <a href='" . base_url("role_settings/edit?id={$row['id']}") . "' class='btn btn-warning btn-xs'><i class='icon-pencil'></i> Edit</a>
                                <a href='#' data-object-id='" . $row['id'] . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a>
                            </td>
                        </tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Setting</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this setting?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="role_settings/delete">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>
