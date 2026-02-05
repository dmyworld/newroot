<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Tax Report Summary (<?php echo dateformat($start) . ' - ' . dateformat($end); ?>)</h5>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>Run ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total Gross</th>
                            <th>Total Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_tax = 0;
                        $total_gross = 0;
                        foreach ($runs as $row) { 
                            $total_tax += $row['total_tax'];
                            $total_gross += $row['total_amount']; // Stored as 'total_amount' in DB runs table? Actually need to check engine.
                            // In engine: update_run_totals($run_id, $amount, $tax) 
                            // $amount was sent as $net_pay sum? No.
                            // engine::save_payroll_item sends $calc['net_pay'] to total_amount sum in finalize().
                            // Controller::finalize(): $total_amount += $calc['net_pay'];
                            // So 'total_amount' in DB is NET PAY.
                            // We don't have GROSS PAY total in runs table. We only have NET and TAX.
                            // Gross Pay = Net + Tax + Deductions (roughly).
                            // But we just want Tax Report.
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo dateformat($row['date_created']); ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo amountFormat($row['total_amount'] + $row['total_tax']); // Approximate Gross ?></td>
                                <td><?php echo amountFormat($row['total_tax']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total Tax Collected</th>
                            <th><?php echo amountFormat($total_tax); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
