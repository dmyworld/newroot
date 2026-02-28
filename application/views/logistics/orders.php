<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Logistics & Transport Orders</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="logisticsOrdersTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Pickup</th>
                            <th>Dropoff</th>
                            <th>Vehicle</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $row): ?>
                        <tr>
                            <td>#<?= $row['id'] ?> (Ref: <?= $row['order_id'] ?>)</td>
                            <td><?= htmlspecialchars($row['pickup_loc']) ?></td>
                            <td><?= htmlspecialchars($row['delivery_loc']) ?></td>
                            <td><?= htmlspecialchars($row['vehicle_no']) ?> (<?= htmlspecialchars($row['driver_name']) ?>)</td>
                            <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                            <td><span class="badge badge-info"><?= strtoupper($row['status']) ?></span></td>
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
    $('#logisticsOrdersTable').DataTable({
        'responsive': true
    });
});
</script>
