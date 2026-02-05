<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="ft-file-text"></i> My Payslips</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <p class="mb-3">View and download your pay slips below.</p>
                
                <!-- Payslips Table -->
                <table id="payslips_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Period</th>
                            <th>Pay Date</th>
                            <th>Gross Pay</th>
                            <th>Deductions</th>
                            <th>Net Pay</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payslips)): ?>
                            <?php foreach ($payslips as $slip): ?>
                                <tr>
                                    <td><?= date('M d', strtotime($slip['start_date'])) ?> - <?= date('M d, Y', strtotime($slip['end_date'])) ?></td>
                                    <td><?= date('M d, Y', strtotime($slip['end_date'])) ?></td>
                                    <td><?= amountFormat($slip['gross_pay']) ?></td>
                                    <td><?= amountFormat($slip['epf_employee'] + $slip['loan_deduction'] + $slip['other_deductions']) ?></td>
                                    <td><strong><?= amountFormat($slip['net_pay']) ?></strong></td>
                                    <td>
                                        <?php if ($slip['status'] == 'Draft'): ?>
                                            <span class="label label-default">Draft</span>
                                        <?php elseif ($slip['status'] == 'Finalized'): ?>
                                            <span class="label label-success">Finalized</span>
                                        <?php else: ?>
                                            <span class="label label-warning"><?= $slip['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($slip['status'] != 'Draft'): ?>
                                            <a href="<?= base_url('payrollreport/view_payslip/' . $slip['id']) ?>" class="btn btn-sm btn-info" target="_blank">
                                                <i class="ft-eye"></i> View
                                            </a>
                                            <a href="<?= base_url('payrollreport/view_payslip/' . $slip['id'] . '/1') ?>" class="btn btn-sm btn-primary">
                                                <i class="ft-download"></i> Download
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Not available</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <i class="ft-info"></i> No payslips available yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#payslips_table').DataTable({
        "order": [[1, "desc"]],
        "pageLength": 25
    });
});
</script>
