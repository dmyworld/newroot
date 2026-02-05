<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>System Activity Logs (Last 50)</h4>
            <p class="text-muted">Audit trail of critical system actions.</p>
        </div>
        <div class="card-content">
            <div class="card-body">
                <?php if(empty($logs)) { ?>
                    <div class="alert alert-info">
                        No activity logs found. Ensure logging is enabled in System Settings.
                    </div>
                <?php } else { ?>
                <table class="table table-striped zero-configuration">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>User ID</th>
                            <th>Action / Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($logs as $row) { ?>
                        <tr>
                            <td><?= $row['created'] ?? $row['date'] ?></td>
                            <td><?= $row['user_id'] ?? $row['userid'] ?></td>
                            <td><?= $row['note'] ?? $row['action'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
