<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Net Promoter Score (NPS) Analysis <a href="<?= base_url('advanced_reports/export_csv/nps') ?>" class="btn btn-primary btn-sm float-right"><i class="fa fa-download"></i> Export CSV</a></h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Note:</strong> Since no survey data is currently available, this report estimates sentiment based on <strong>Spending Habits</strong> (Promoters) and <strong>Returns/Cancellations</strong> (Detractors).
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-success"><i class="fa fa-smile-o"></i> Potential Promoters (Top Spenders)</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Total Spend</th>
                                <th>Inv. Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($nps_data['promoters'])): ?>
                                <?php foreach ($nps_data['promoters'] as $row): ?>
                                    <tr>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= amountFormat($row['total_spend']) ?></td>
                                        <td><?= $row['trans_count'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3">No potential promoters found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="text-danger"><i class="fa fa-frown-o"></i> Potential Detractors (Returns)</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Return Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($nps_data['detractors'])): ?>
                                <?php foreach ($nps_data['detractors'] as $row): ?>
                                    <tr>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['return_count'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="2">No major detractors found (based on returns).</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
