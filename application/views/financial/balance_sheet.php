<div class="content-body">
    <div class="card">
        <div class="card-header bg-gradient-x-purple-blue white">
            <h4 class="card-title">Balance Sheet</h4>
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
                <form action="<?php echo base_url('financial/balance_sheet'); ?>" method="get" class="form-inline mb-2 bg-light p-2 rounded">
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
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <span class="ml-2 text-muted small">As of: <?php echo date('d-M-Y H:i'); ?></span>
                </form>

                <div class="row">
                    <!-- Assets Section -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-primary white">
                                    <tr>
                                        <th>Assets</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_assets = 0;
                                    foreach ($report['assets'] as $row) {
                                        $total_assets += $row['lastbal'];
                                        echo '<tr>
                                                <td>' . $row['holder'] . '</td>
                                                <td class="text-right">' . amountFormat_s($row['lastbal']) . '</td>
                                              </tr>';
                                    }
                                    if(empty($report['assets'])) echo '<tr><td colspan="2" class="text-center">No asset accounts found</td></tr>';
                                    ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>Total Assets</th>
                                        <th class="text-right text-primary"><?php echo amountFormat_s($total_assets); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Liabilities & Equity Section -->
                    <div class="col-md-6">
                        <!-- Liabilities -->
                        <div class="table-responsive mb-2">
                            <table class="table table-hover">
                                <thead class="bg-warning white">
                                    <tr>
                                        <th>Liabilities</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_liabilities = 0;
                                    foreach ($report['liabilities'] as $row) {
                                        $total_liabilities += $row['lastbal'];
                                        echo '<tr>
                                                <td>' . $row['holder'] . '</td>
                                                <td class="text-right">' . amountFormat_s($row['lastbal']) . '</td>
                                              </tr>';
                                    }
                                    if(empty($report['liabilities'])) echo '<tr><td colspan="2" class="text-center">No liability accounts found</td></tr>';
                                    ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>Total Liabilities</th>
                                        <th class="text-right text-warning"><?php echo amountFormat_s($total_liabilities); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Equity -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-info white">
                                    <tr>
                                        <th>Equity</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_equity = 0;
                                    foreach ($report['equity'] as $row) {
                                        $total_equity += $row['lastbal'];
                                        echo '<tr>
                                                <td>' . $row['holder'] . '</td>
                                                <td class="text-right">' . amountFormat_s($row['lastbal']) . '</td>
                                              </tr>';
                                    }
                                    if(empty($report['equity'])) echo '<tr><td colspan="2" class="text-center">No equity accounts found</td></tr>';
                                    ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>Total Equity</th>
                                        <th class="text-right text-info"><?php echo amountFormat_s($total_equity); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Equation Check -->
                <div class="row mt-2">
                    <div class="col-md-8 offset-md-2">
                        <div class="card <?php echo (round($total_assets, 2) == round($total_liabilities + $total_equity, 2)) ? 'bg-success' : 'bg-danger'; ?> white">
                            <div class="card-body text-center p-1">
                                <h3>Assets = Liabilities + Equity</h3>
                                <h4><?php echo amountFormat_s($total_assets); ?> = <?php echo amountFormat_s($total_liabilities); ?> + <?php echo amountFormat_s($total_equity); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-x-purple-blue {
        background-image: linear-gradient(to right, #673AB7 0%, #3F51B5 100%);
    }
</style>
