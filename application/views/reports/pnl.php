<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="card-title">Profit & Loss Statement</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('reports/pnl') ?>" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Location (Branch)</label>
                            <select name="loc" class="form-control">
                                <option value="0">All Locations</option>
                                <?php foreach ($locations as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['cname'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="text" class="form-control datepicker" name="sdate" value="<?php echo date('Y-m-d', strtotime('-30 days')) ?>">
                        </div>
                        <div class="col-md-3">
                            <label>End Date</label>
                            <input type="text" class="form-control datepicker" name="edate" value="<?php echo date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mt-2">Generate Report</button>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-6 border-right">
                        <h5 class="text-success">Income</h5>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($report['income'] as $row) {
                                echo '<tr><td>' . $row['cat'] . '</td><td class="text-right">' . amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc) . '</td></tr>';
                            } ?>
                            <tr class="table-info">
                                <td><strong>Total Income</strong></td>
                                <td class="text-right"><strong><?php echo amountExchange_s($report['total_income'], 0, $this->aauth->get_user()->loc) ?></strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-danger">Expenses</h5>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($report['expenses'] as $row) {
                                echo '<tr><td>' . $row['cat'] . '</td><td class="text-right">' . amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc) . '</td></tr>';
                            } ?>
                            <tr class="table-info">
                                <td><strong>Total Expense</strong></td>
                                <td class="text-right"><strong><?php echo amountExchange_s($report['total_expense'], 0, $this->aauth->get_user()->loc) ?></strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-center bg-light p-3">
                        <h3>Net Profit: <span class="<?php echo $report['net_profit'] >= 0 ? 'text-success' : 'text-danger' ?>">
                            <?php echo amountExchange_s($report['net_profit'], 0, $this->aauth->get_user()->loc) ?>
                        </span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
