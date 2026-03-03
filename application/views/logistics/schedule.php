<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Advanced Logistics Schedule</h4>
            <div class="heading-elements">
                <a href="<?php echo base_url('logistics/new_order') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Transport Order</a>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <select class="form-control" id="filterLocation">
                            <option value="">All Locations</option>
                            <?php foreach ($locations as $loc): ?>
                                <option value="<?= $loc['id'] ?>"><?= $loc['cname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div id="calendar-container">
                    <!-- For simplicity, we use a enhanced table view that acts as a schedule -->
                    <table id="scheduleTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Dispatch Date</th>
                                <th>Vehicle / Driver</th>
                                <th>Route (Pickup -> Delivery)</th>
                                <th>Ref #</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    var table = $('#scheduleTable').DataTable({
        "processing": true,
        "ajax": {
            "url": "<?php echo site_url('logistics/ajax_schedule_data') ?>",
            "type": "POST",
            "data": function(d) {
                d.loc = $('#filterLocation').val();
                d.<?=$this->security->get_csrf_token_name()?> = '<?=$this->security->get_csrf_hash()?>';
            },
            "dataSrc": ""
        },
        "order": [[0, "desc"]],
        "columns": [
            { 
                "data": "created_at",
                "render": function(data) {
                    return moment(data).format('YYYY-MM-DD HH:mm');
                }
            },
            { 
                "data": null,
                "render": function(data) {
                    return '<strong>' + data.vehicle_no + '</strong><br><small>' + data.driver_name + '</small>';
                }
            },
            { 
                "data": null,
                "render": function(data) {
                    return data.pickup_loc + ' <i class="fa fa-arrow-right"></i> ' + data.delivery_loc;
                }
            },
            { "data": "order_id" },
            { 
                "data": "status",
                "render": function(data) {
                    var cls = 'info';
                    if(data == 'delivered') cls = 'success';
                    if(data == 'in_transit') cls = 'warning';
                    return '<span class="badge badge-' + cls + '">' + data.toUpperCase() + '</span>';
                }
            },
            {
                "data": "id",
                "render": function(data) {
                    return '<a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';
                }
            }
        ]
    });

    $('#filterLocation').change(function() {
        table.ajax.reload();
    });
});
</script>
