<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Roles') ?> <a href="<?php echo base_url('employee/role_add') ?>"
                                                            class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
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
            <div class="card-body">
                <table id="roletable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 1;
                    foreach ($roles as $row) {
                        echo "<tr>
                            <td>$i</td>
                            <td>" . $row['name'] . "</td>
                            <td><a href='" . base_url("employee/role_edit?id=" . $row['id']) . "' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a></td>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#roletable').DataTable({responsive: true});
    });
</script>
