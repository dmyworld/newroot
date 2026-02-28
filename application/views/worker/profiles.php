<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Professional Workforce Profiles</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="profilesTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Experience</th>
                            <th>Location</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($profiles as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['display_name']) ?> (<?= htmlspecialchars($row['username']) ?>)</td>
                            <td><?= htmlspecialchars($row['category_id']) ?></td>
                            <td><?= htmlspecialchars($row['experience_years']) ?> Years</td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><span class="badge badge-success"><?= strtoupper($row['status'] ?? 'Active') ?></span></td>
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
    $('#profilesTable').DataTable({
        'responsive': true
    });
});
</script>
