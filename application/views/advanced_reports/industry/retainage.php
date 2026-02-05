<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Construction Retainage Estimator (10%) <a href="<?= base_url('advanced_reports/export_csv/retainage') ?>" class="btn btn-primary btn-sm float-right"><i class="fa fa-download"></i> Export CSV</a></h4>
        </div>
        <div class="card-body">
            <p><strong>Scenario:</strong> 10% Retainage held on invoices over 5,000.</p>
            <table class="table table-striped table-bordered zero-configuration">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Invoice Total</th>
                        <th>Est. Retainage (10%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($retainage_data)): ?>
                        <?php foreach ($retainage_data as $row): ?>
                            <tr>
                                <td>#<?= $row['tid'] ?></td>
                                <td><?= dateformat($row['invoicedate']) ?></td>
                                <td><?= $row['customer'] ?></td>
                                <td><?= amountFormat($row['total']) ?></td>
                                <td class="text-danger"><?= amountFormat($row['retainage_amount']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No qualifying large invoices found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
