<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Master Service List</h5>
            <hr>
        </div>
        <div class="header-actions">
            <button type="button" class="btn-premium btn-success-glass mr-2" data-toggle="modal" data-target="#surge_modal">
                <i class="fa fa-bolt"></i> Surge Pricing
            </button>
            <button type="button" class="btn-premium btn-primary-glass mr-2" data-toggle="modal" data-target="#bulk_comm_modal">
                <i class="fa fa-percent"></i> Bulk Commission
            </button>
            <a href="<?php echo base_url('services/add') ?>" class="btn-premium mr-2">
                <i class="fa fa-plus-circle"></i> Add New Service
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
                <i class="fa fa-list-ul text-primary mr-2"></i>Service List
            </h5>
        </div>
        <div class="table-responsive">
            <table id="servicetable" class="table table-premium">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($services as $row) {
                    $sid = $row['id'];
                    $name = $row['service_name'];
                    $cat_name = $row['cat_name'];
                    $status_text = ($row['status'] == 1) ? 'Active' : 'Inactive';
                    $status_class = ($row['status'] == 1) ? 'badge-psy-success' : 'badge-psy-warning';
                    $status_btn = ($row['status'] == 1) ? 'fa-toggle-on text-success' : 'fa-toggle-off text-muted';
                    
                    echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$cat_name</td>
                    <td id='status-$sid'><span class='badge-psy $status_class'>$status_text</span></td>
                    <td>
                        <a href='#' class='btn btn-outline-info btn-sm rounded toggle-status' data-id='$sid'><i class='fa $status_btn'></i></a>&nbsp;
                        <a href='" . base_url("services/edit?id=$sid") . "' class='btn btn-outline-warning btn-sm rounded'><i class='fa fa-pencil'></i></a>&nbsp;
                        <a href='#' data-object-id='" . $sid . "' class='btn btn-outline-danger btn-sm rounded delete-object' title='Delete'><i class='fa fa-trash'></i></a>
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
        $('#servicetable').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    className: 'btn-premium btn-sm mb-2'
                }
            ],
        });

        $(document).on('click', ".toggle-status", function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var obj = $(this);
            $.ajax({
                url: "<?php echo base_url('services/status') ?>",
                type: 'POST',
                data: {id: id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {
                        if (data.new_status == 1) {
                            $('#status-' + id).html('<span class="badge-psy badge-psy-success">Active</span>');
                            obj.find('i').removeClass('fa-toggle-off text-muted').addClass('fa-toggle-on text-success');
                        } else {
                            $('#status-' + id).html('<span class="badge-psy badge-psy-warning">Inactive</span>');
                            obj.find('i').removeClass('fa-toggle-on text-success').addClass('fa-toggle-off text-muted');
                        }
                    }
                }
            });
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
                <p>Are you sure you want to delete this service?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="services/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>
