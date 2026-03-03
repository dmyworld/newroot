<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Fleet & Logistics Management</h4>
            <div class="heading-elements">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addVehicleModal"><i class="fa fa-plus"></i> Add Vehicle/Driver</button>
                <a href="<?php echo base_url('logistics/new_order') ?>" class="btn btn-success btn-sm"><i class="fa fa-truck"></i> New Transport Order</a>
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
                <table id="fleetTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Vehicle #</th>
                            <th>Driver</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fleet as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['vehicle_no']) ?></td>
                            <td><?= htmlspecialchars($row['driver_name']) ?></td>
                            <td><?= htmlspecialchars($row['vehicle_type']) ?></td>
                            <td><?= htmlspecialchars($row['capacity']) ?></td>
                            <td><?= $this->locations->get_location_name($row['loc']) ?></td>
                            <td><span class="badge badge-success"><?= strtoupper($row['status']) ?></span></td>
                            <td>
                                <a href="<?= base_url('logistics/view_vehicle/'.$row['id']) ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="addVehicleModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Vehicle/Driver</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="vehicle_form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vehicle_no">Vehicle Number</label>
                        <input type="text" class="form-control" name="vehicle_no" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_type">Vehicle Type</label>
                        <input type="text" class="form-control" name="vehicle_type" placeholder="E.g. Lorry, Tractor, Crane" required>
                    </div>
                    <div class="form-group">
                        <label for="driver_name">Driver Name</label>
                        <input type="text" class="form-control" name="driver_name" required>
                    </div>
                    <div class="form-group">
                        <label for="driver_phone">Driver Phone</label>
                        <input type="text" class="form-control" name="driver_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity (Tons/Vol)</label>
                        <input type="text" class="form-control" name="capacity">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit_vehicle">Save Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#fleetTable').DataTable({
        'responsive': true
    });

    $("#vehicle_form").submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash()?>';

        $.ajax({
            url: "<?php echo site_url('logistics/save_vehicle') ?>",
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
});
</script>
