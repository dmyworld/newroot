<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Logs Inventory (Untreated Raw Logs)</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="logsInventoryTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Log ID</th>
                            <th>Species</th>
                            <th>Location</th>
                            <th>Current Vol (cuft)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $row): ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['species']) ?></td>
                            <td><?= $this->locations->get_location_name($row['loc']) ?></td>
                            <td><?= number_format($row['total_cubic_feet'], 2) ?></td>
                            <td><span class="badge badge-success"><?= strtoupper($row['status']) ?></span></td>
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
    $('#logsInventoryTable').DataTable({
        'responsive': true
    });
});
</script>
