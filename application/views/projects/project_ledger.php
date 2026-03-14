<div class="card-body">
    <h5>Project Financial Ledger</h5>
    <div class="row mt-2">
        <div class="col-md-4">
            <div class="card bg-success white">
                <div class="card-body text-center">
                    <h2 class="white"><?php echo amountExchange_s($pnl['income'], 0, $this->aauth->get_user()->loc) ?></h2>
                    <span>Total Income</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger white">
                <div class="card-body text-center">
                    <h2 class="white"><?php echo amountExchange_s($pnl['expense'], 0, $this->aauth->get_user()->loc) ?></h2>
                    <span>Total Expense</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card <?php echo $pnl['profit'] >= 0 ? 'bg-info' : 'bg-warning' ?> white">
                <div class="card-body text-center">
                    <h2 class="white"><?php echo amountExchange_s($pnl['profit'], 0, $this->aauth->get_user()->loc) ?></h2>
                    <span>Net Project Balance</span>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered mt-3">
        <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Type</th>
            <th class="text-right">Debit</th>
            <th class="text-right">Credit</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($ledger as $row) {
            echo '<tr>
                <td>' . $row['date'] . '</td>
                <td>' . $row['note'] . '</td>
                <td>' . $row['type'] . '</td>
                <td class="text-right text-danger">' . ($row['debit'] > 0 ? amountExchange_s($row['debit'], 0, $this->aauth->get_user()->loc) : '-') . '</td>
                <td class="text-right text-success">' . ($row['credit'] > 0 ? amountExchange_s($row['credit'], 0, $this->aauth->get_user()->loc) : '-') . '</td>
            </tr>';
        } ?>
        </tbody>
    </table>
</div>
