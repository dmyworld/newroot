<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Project Profitability Summary</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="alert alert-icon-left alert-arrow-left alert-info alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-info"></i></span>
                    <strong>Note:</strong> Profitability calculation requires transactions and invoices to be strictly linked to Projects.
                </div>
                <table class="table table-striped zero-configuration">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th class="text-right">Budget</th>
                            <th class="text-right">Invoiced (Income)</th>
                            <th class="text-right">Expenses</th>
                            <th class="text-right">Profit / (Loss)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($projects as $row) { 
                             $profit = $row['invoiced'] - $row['expenses'];
                             $prof_class = $profit >= 0 ? 'success' : 'danger';
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td class="text-right"><?= amountFormat($row['budget']) ?></td>
                            <td class="text-right"><?= amountFormat($row['invoiced']) ?></td>
                            <td class="text-right"><?= amountFormat($row['expenses']) ?></td>
                            <td class="text-right"><span class="font-weight-bold text-<?= $prof_class ?>"><?= amountFormat($profit) ?></span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
