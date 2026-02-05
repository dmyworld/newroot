<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">High Risk Churn Candidates</h4>
            <div class="heading-elements">
                <span class="badge badge-danger">Inactve > 6 Months</span>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="alert alert-warning mb-2" role="alert">
                    <strong>Strategy:</strong> Reach out to these customers with a special reactivation offer.
                </div>
                <table class="table table-striped zero-configuration">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="text-right">Last Purchase Date</th>
                            <th class="text-right">Days Inactive</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $now = time();
                        foreach($churn_risk as $row) { 
                             $last_date = strtotime($row['last_purchase']);
                             $days_inactive = floor(($now - $last_date) / (60 * 60 * 24));
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                             <td><?= $row['phone'] ?></td>
                            <td class="text-right"><?= dateformat($row['last_purchase']) ?></td>
                            <td class="text-right"><span class="badge badge-danger"><?= $days_inactive ?> days</span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
