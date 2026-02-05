<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Customer Lifetime Value (Top 50)</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped zero-configuration">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th class="text-right">Transaction Count</th>
                            <th class="text-right">Lifetime Revenue</th>
                            <th class="text-right">Avg Order Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clv_data as $row) { 
                             $avg = $row['txn_count'] > 0 ? $row['lifetime_value'] / $row['txn_count'] : 0;
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                             <td class="text-right"><?= $row['txn_count'] ?></td>
                            <td class="text-right font-weight-bold text-success"><?= amountFormat($row['lifetime_value']) ?></td>
                            <td class="text-right"><?= amountFormat($avg) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
