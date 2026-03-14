<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Roles') ?> 
                <?php if ($this->aauth->get_user()->roleid == 1): ?>
                <a href="<?php echo base_url('employee/role_add') ?>" class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
                <?php endif; ?>
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
            <div class="card-body">
                <table id="roletable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Master Role</th>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 1;
                    $current_user_role_id = $this->aauth->get_user()->roleid;

                    foreach ($master_roles as $master) {
                        // Render Master Role row
                        echo "<tr>
                            <td>" . $master['name'] . " (Master Role)</td>
                            <td>$i</td>
                            <td><strong>" . $master['name'] . "</strong></td>
                            <td>";

                        // Master can ONLY be edited by Super Admin (1)
                        if ($current_user_role_id == 1) {
                            echo "<a href='" . base_url("employee/role_edit?id=" . $master['id']) . "' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>";
                        }
                        
                        echo "</td>
                        </tr>";
                        $i++;

                        // Render Sub Roles
                        foreach ($master['sub_roles'] as $sub) {
                            echo "<tr>
                                <td>" . $master['name'] . " (Master Role)</td>
                                <td>$i</td>
                                <td>" . $sub['name'] . "</td>
                                <td>";

                            // Super admin OR the parent master role can edit this sub-role
                            if ($current_user_role_id == 1 || $current_user_role_id == $master['id']) {
                                echo "<a href='" . base_url("employee/role_edit?id=" . $sub['id']) . "' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>";
                            }
                                    
                            // Only Super Admins can delete
                            if ($current_user_role_id == 1 && $sub['id'] != 1) {
                                echo " &nbsp; <a href='#' data-object-id='" . $sub['id'] . "' class='btn btn-danger btn-xs delete-object'><i class='fa fa-trash'></i> " . $this->lang->line('Delete') . "</a>";
                            }
                            
                            echo "</td>
                            </tr>";
                            $i++;
                        }
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
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?> Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Role? This cannot be undone. You can only delete roles that have zero active users assigned.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="employee/delete_role">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#roletable').DataTable({
            responsive: true,
            "columnDefs": [
                { "visible": false, "targets": 0 }
            ],
            "order": [[0, 'asc']],
            "displayLength": 50,
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;

                api.column(0, {page: 'current'}).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group text-white text-bold-500 bg-blue"><td colspan="3">' + group + '</td></tr>'
                        );
                        last = group;
                    }
                });
            }
        });
    });
</script>
