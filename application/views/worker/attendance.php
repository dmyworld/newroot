<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Workforce Attendance & Payroll</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="attendanceTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Daily Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['username']) ?>)</td>
                            <td><?= $this->locations->get_location_name($row['loc']) ?></td>
                            <td><?= date('Y-m-d') ?></td>
                            <td>08:00 AM</td>
                            <td>05:00 PM</td>
                            <td>LKR <?= number_format($row['salary']) ?></td>
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
    $('#attendanceTable').DataTable({
        'responsive': true
    });
});
</script>
