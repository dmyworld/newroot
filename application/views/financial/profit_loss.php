<div class="content-body">
    <div class="card">
        <div class="card-header bg-gradient-x-blue-cyan white">
            <h4 class="card-title">Profit & Loss Report (Income Statement)</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <!-- Filters -->
                <form action="<?php echo base_url('financial/profit_loss'); ?>" method="get" class="form-inline mb-2 bg-light p-2 rounded">
                    <div class="form-group mr-2">
                        <label class="mr-1 mt-0">Branch:</label>
                        <select name="loc" class="form-control form-control-sm">
                            <option value="0">All Branches</option>
                            <?php foreach ($locations as $loc) {
                                $selected = ($filter['loc'] == $loc['id']) ? 'selected' : '';
                                echo '<option value="' . $loc['id'] . '" '.$selected.'>' . $loc['cname'] . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <label class="mr-1 mt-0">From:</label>
                        <input type="text" name="s_date" class="form-control form-control-sm datepicker" value="<?php echo datefordisplay($filter['s_date']); ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label class="mr-1 mt-0">To:</label>
                        <input type="text" name="e_date" class="form-control form-control-sm datepicker" value="<?php echo datefordisplay($filter['e_date']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>

                <div class="row">
                    <!-- Income Section -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-success white">
                                    <tr>
                                        <th>Income Category</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_income = 0;
                                    foreach ($report['income'] as $row) {
                                        $total_income += $row['total'];
                                        echo '<tr>
                                                <td>' . $row['cat'] . '</td>
                                                <td class="text-right text-success">' . amountFormat_s($row['total']) . '</td>
                                              </tr>';
                                    }
                                    if(empty($report['income'])) echo '<tr><td colspan="2" class="text-center">No income records found</td></tr>';
                                    ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>Total Income</th>
                                        <th class="text-right text-success"><?php echo amountFormat_s($total_income); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Expense Section -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-danger white">
                                    <tr>
                                        <th>Expense Category</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_expense = 0;
                                    foreach ($report['expenses'] as $row) {
                                        $total_expense += $row['total'];
                                        echo '<tr>
                                                <td>' . $row['cat'] . '</td>
                                                <td class="text-right text-danger">' . amountFormat_s($row['total']) . '</td>
                                              </tr>';
                                    }
                                    if(empty($report['expenses'])) echo '<tr><td colspan="2" class="text-center">No expense records found</td></tr>';
                                    ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>Total Expenses</th>
                                        <th class="text-right text-danger"><?php echo amountFormat_s($total_expense); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Summary -->
                <div class="row mt-2">
                    <div class="col-md-4 offset-md-8">
                        <div class="card bg-gradient-directional-blue white">
                            <div class="card-body text-center">
                                <h3>Net Profit</h3>
                                <h1 class="display-4"><?php echo amountFormat_s($total_income - $total_expense); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-x-blue-cyan {
        background-image: linear-gradient(to right, #00B5B8 0%, #006064 100%);
    }
    .bg-gradient-directional-blue {
        background-image: linear-gradient(135deg, #2D3E50 0%, #000000 100%);
    }
</style>
