<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Consolidated Financials (Multi-Location)</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Start Date</label>
                            <input type="date" name="start" class="form-control" value="<?= $start ?>">
                        </div>
                        <div class="col-md-4">
                            <label>End Date</label>
                            <input type="date" name="end" class="form-control" value="<?= $end ?>">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary">Update Report</button>
                        </div>
                    </div>
                </form>
                <hr>
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>Location</th>
                            <th class="text-right">Total Income</th>
                            <th class="text-right">Total Expenses</th>
                            <th class="text-right">Net Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_inc = 0; $grand_exp = 0; $grand_prof = 0;
                        foreach($financials as $row) { 
                            $grand_inc += $row['income'];
                            $grand_exp += $row['expense'];
                            $grand_prof += $row['profit'];
                            
                            $prof_class = $row['profit'] >= 0 ? 'success' : 'danger';
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td class="text-right"><?= amountFormat($row['income']) ?></td>
                            <td class="text-right"><?= amountFormat($row['expense']) ?></td>
                            <td class="text-right"><span class="badge badge-<?= $prof_class ?>"><?= amountFormat($row['profit']) ?></span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                         <tr class="font-weight-bold">
                            <td>GRAND TOTAL</td>
                            <td class="text-right"><?= amountFormat($grand_inc) ?></td>
                            <td class="text-right"><?= amountFormat($grand_exp) ?></td>
                             <td class="text-right"><?= amountFormat($grand_prof) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
