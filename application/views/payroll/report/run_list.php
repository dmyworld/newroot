<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Select a Payroll Run</h5>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date Created</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($runs as $row) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo dateformat($row['date_created']); ?></td>
                                <td><?php echo dateformat($row['start_date']); ?></td>
                                <td><?php echo dateformat($row['end_date']); ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><a href="<?php echo base_url('payrollreport/payslips?id=' . $row['id']); ?>" class="btn btn-primary btn-sm">View Details</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
