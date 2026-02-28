<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Fleet & Logistics Management</h4>
            <div class="heading-elements">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addVehicleModal"><i class="fa fa-plus"></i> Add Vehicle/Driver</button>
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

<script type="text/javascript">
$(document).ready(function () {
    $('#fleetTable').DataTable({
        'responsive': true
    });
});
</script>
