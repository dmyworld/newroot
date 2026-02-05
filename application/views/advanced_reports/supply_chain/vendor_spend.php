<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Vendor Spend Scorecards (Top 50)</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <?php if(empty($vendor_data)) { ?>
                    <div class="alert alert-info">
                        No purchase data found. Ensure the 'Purchase Orders' module is being used.
                    </div>
                <?php } else { ?>
                <table class="table table-striped zero-configuration">
                    <thead>
                        <tr>
                            <th>Vendor Name</th>
                            <th class="text-right">Order Count</th>
                            <th class="text-right">Total Spend</th>
                            <th class="text-right">Avg Order Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($vendor_data as $row) { 
                             $avg = $row['order_count'] > 0 ? $row['total_spend'] / $row['order_count'] : 0;
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td class="text-right"><?= $row['order_count'] ?></td>
                            <td class="text-right font-weight-bold text-danger"><?= amountFormat($row['total_spend']) ?></td>
                            <td class="text-right"><?= amountFormat($avg) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
