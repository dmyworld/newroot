<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Payroll Reports</h5>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Payslips</h5>
                                <p class="card-text">Generate individual payslips for employees.</p>
                                <a href="<?php echo base_url('payrollreport/payslips'); ?>" class="btn btn-primary">View Report</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Payroll Register</h5>
                                <p class="card-text">Comprehensive summary of payroll runs.</p>
                                <a href="<?php echo base_url('payrollreport/payslips'); ?>" class="btn btn-primary">View Report</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Tax Reports</h5>
                                <p class="card-text">Deductions and tax liability summaries.</p>
                                <a href="<?php echo base_url('payrollreport/tax_report'); ?>" class="btn btn-primary">View Report</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Labor Costing</h5>
                                <p class="card-text">Job code hours and cost analysis.</p>
                                <a href="<?php echo base_url('payrollreport/job_costing'); ?>" class="btn btn-primary">View Report</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Visual Dashboard</h5>
                                <p class="card-text">Trends and graphical insights.</p>
                                <a href="<?php echo base_url('payrollreport/dashboard'); ?>" class="btn btn-primary">View Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
