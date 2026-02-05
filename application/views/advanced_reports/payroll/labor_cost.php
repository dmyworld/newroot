<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Labor Cost Analysis (Last 12 Months)</h4>
            <p class="text-muted">Based on Transactions categorized as 'Employee', 'Salary', or 'Wages'</p>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-right">Total Labor Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        if(empty($labor_trends)) {
                            echo "<tr><td colspan='2' class='text-center text-muted'>No labor cost data found in transactions. Ensure payroll expenses are categorized under 'Employee', 'Salary', or 'Wages'.</td></tr>";
                        } else {
                            foreach($labor_trends as $row) { 
                                $grand_total += $row['total_cost'];
                            ?>
                            <tr>
                                <td><?= $row['month'] ?></td>
                                <td class="text-right"><?= amountFormat($row['total_cost']) ?></td>
                            </tr>
                            <?php } 
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td>TOTAL (Last 12 Mo)</td>
                            <td class="text-right"><?= amountFormat($grand_total) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
