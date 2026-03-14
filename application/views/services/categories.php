<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Service Categories</h5>
            <hr>
        </div>
        <div class="header-actions">
            <a href="<?php echo base_url('servicecategories/add') ?>" class="btn-premium mr-2">
                <i class="fa fa-plus-circle"></i> Add New Category
            </a>
            <a href="<?php echo base_url('servicecategories/add_sub') ?>" class="btn-premium btn-primary-glass">
                <i class="fa fa-folder-open"></i> Add Sub Category
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="premium-card">
        <div class="premium-card-header">
            <h5 class="premium-card-title">
                <i class="fa fa-list-alt text-primary mr-2"></i>Service Category List
            </h5>
        </div>
        <div class="table-responsive">
            <table id="catgtable" class="table table-premium">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Icon</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($cat as $row) {
                    $cid = $row['id'];
                    $title = $row['title'];
                    $type = ($row['c_type'] == 0) ? '<span class="badge-psy badge-psy-info">Main</span>' : '<span class="badge-psy badge-psy-success">Sub</span>';
                    $icon = $row['icon'];
                    
                    echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    <td>$type</td>
                    <td><img src='" . base_url("userfiles/service_categories/$icon") . "' style='width:40px;height:40px;' class='rounded'></td>
                    <td>
                        <a href='" . base_url("servicecategories/edit?id=$cid") . "' class='btn btn-outline-warning btn-sm rounded'><i class='fa fa-pencil'></i></a>&nbsp;
                        <a href='#' data-object-id='" . $cid . "' class='btn btn-outline-danger btn-sm rounded delete-object' title='Delete'><i class='fa fa-trash'></i></a>
                    </td></tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#catgtable').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    className: 'btn-premium btn-sm mb-2'
                }
            ],
        });
    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this service category?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="servicecategories/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>
