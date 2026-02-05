<div class="content-body">
    
    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-wallet primary font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3><?php echo count($payroll_list); ?></h3>
                                <span>Total Payroll Runs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-calendar warning font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3><?php echo date('F'); ?></h3>
                                <span>Current Month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="card">
        <div class="card-header bg-gradient-x-purple-blue white">
            <h5 class="card-title white">Payroll History</h5>
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
                <p class="card-text">View and manage past payroll records.</p>
                <div class="table-responsive">
                    <table id="payroll_table" class="table table-striped table-bordered zero-configuration">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Month/Year</th>
                            <th>Basic Salary</th>
                            <th>Net Pay</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=1;
                        foreach ($payroll_list as $row) {
                            $month_name = date("F", mktime(0, 0, 0, $row['month'], 10));
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><span class="font-weight-bold"><?php echo $row['emp_name']; ?></span></td>
                                <td><?php echo $month_name . ' ' . $row['year']; ?></td>
                                 <td><?php echo amountExchange($row['basic_salary'], 0, $this->aauth->get_user()->loc) ?></td>
                                 <td class="indigo font-weight-bold"><?php echo amountExchange($row['net_pay'], 0, $this->aauth->get_user()->loc) ?></td>
                                <td><?php echo dateformat($row['payment_date']); ?></td>
                                <td><span class="badge badge-success"><?php echo $row['status']; ?></span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info rounded" title="View Payslip"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#payroll_table').DataTable({
            'order': [[0, 'desc']],
            'responsive': true
        });
    });
</script>
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
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <table id="payroll_table" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Month/Year</th>
                        <th>Basic Salary</th>
                        <th>Net Pay</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    foreach ($payroll_list as $row) {
                        $month_name = date("F", mktime(0, 0, 0, $row['month'], 10));
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['emp_name']; ?></td>
                            <td><?php echo $month_name . ' ' . $row['year']; ?></td>
                             <td><?php echo amountExchange($row['basic_salary'], 0, $this->aauth->get_user()->loc) ?></td>
                             <td><?php echo amountExchange($row['net_pay'], 0, $this->aauth->get_user()->loc) ?></td>
                            <td><?php echo dateformat($row['payment_date']); ?></td>
                            <td><span class="badge badge-success"><?php echo $row['status']; ?></span></td>
                            <td>
                                <!-- Actions like view payslip can be added here -->
                                <button class="btn btn-sm btn-info"><i class="fa fa-print"></i> Payslip</button>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Month/Year</th>
                        <th>Basic Salary</th>
                        <th>Net Pay</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#payroll_table').DataTable({
            'order': [[0, 'desc']]
        });
    });
</script>
