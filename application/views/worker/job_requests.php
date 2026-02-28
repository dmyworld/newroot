<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Job Request Hub (Marketplace Inbound)</h4>
            <div class="heading-elements">
                <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Find Open Jobs</button>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="jobRequestsTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Customer</th>
                            <th>Title</th>
                            <th>Budget</th>
                            <th>District</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $row): ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['customer_id'] ? $this->_get_customer_name($row['customer_id']) : 'Guest') ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td>LKR <?= number_format($row['budget']) ?></td>
                            <td><?= htmlspecialchars($row['district'] ?? 'N/A') ?></td>
                            <td><span class="badge badge-warning"><?= strtoupper($row['status']) ?></span></td>
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
    $('#jobRequestsTable').DataTable({
        'responsive': true
    });
});
</script>
