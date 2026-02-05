<div class="content-body">
    <!-- Top Stats -->
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card bg-gradient-x-info-cyan">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body white text-left">
                                <h3 class="font-large-1 white">Payroll Dashboard</h3>
                                <span>Overview</span>
                            </div>
                            <div class="align-self-center">
                                <i class="icon-speedometer white font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-6 col-12">
            <div class="row">
                 <div class="col-xl-4 col-sm-4 col-12"> 
                    <a href="<?php echo base_url('payrollprocessing'); ?>" class="card btn btn-outline-primary btn-block p-2 d-flex justify-content-center align-items-center" style="height: 100px;">
                        <i class="icon-control-play font-large-1 mb-1"></i>
                        <span>Run Payroll</span>
                    </a>
                 </div>
                  <div class="col-xl-4 col-sm-4 col-12"> 
                    <a href="<?php echo base_url('payrollreport/payslips'); ?>" class="card btn btn-outline-info btn-block p-2 d-flex justify-content-center align-items-center" style="height: 100px;">
                        <i class="icon-docs font-large-1 mb-1"></i>
                        <span>Payslips</span>
                    </a>
                 </div>
                  <div class="col-xl-4 col-sm-4 col-12"> 
                    <a href="<?php echo base_url('payrollreport/tax_report'); ?>" class="card btn btn-outline-secondary btn-block p-2 d-flex justify-content-center align-items-center" style="height: 100px;">
                        <i class="icon-pie-chart font-large-1 mb-1"></i>
                        <span>Tax Report</span>
                    </a>
                 </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-12 col-12">
            <div class="card">
                <div class="card-header">
                     <h4 class="card-title">Payroll Trend (Last 6 Months)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <canvas id="payrollTrendChart" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-12">
             <div class="card">
                <div class="card-header">
                     <h4 class="card-title">Recent Activity</h4>
                </div>
                <div class="card-content">
                     <div class="card-body">
                         <div class="widget-timeline">
                             <!-- Dynamic Timeline could go here -->
                             <p class="text-muted text-center p-2">No recent alerts</p>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/vendors/js/charts/chart.min.js"></script>
<script>
    $(document).ready(function() {
        var ctx = document.getElementById("payrollTrendChart").getContext("2d");
        
        var labels = <?php echo json_encode(array_column($stats['trend'], 'end_date')); ?>;
        var dataAmount = <?php echo json_encode(array_column($stats['trend'], 'total_amount')); ?>;
        var dataTax = <?php echo json_encode(array_column($stats['trend'], 'total_tax')); ?>;

        var config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Net Pay",
                    data: dataAmount,
                    backgroundColor: "#666EE8",
                    borderColor: "#666EE8",
                    borderWidth: 1
                }, {
                    label: "Tax",
                    data: dataTax,
                    backgroundColor: "#FF4961",
                    borderColor: "#FF4961",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                 scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: { display: false }
                    }],
                    yAxes: [{
                        stacked: true,
                         gridLines: { color: "#f3f3f3" }
                    }]
                },
                legend: { position: 'bottom' }
            }
        };

        new Chart(ctx, config);
    });
</script>
                    <div class="card-body">
                        <canvas id="payrollTrendChart" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-12">
            <div class="card">
                 <div class="card-header">
                    <h4 class="card-title">Quick Actions</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                         <a href="<?php echo base_url('payrollprocessing'); ?>" class="btn btn-primary btn-block mb-1">Run New Payroll</a>
                         <a href="<?php echo base_url('payrollreport/payslips'); ?>" class="btn btn-secondary btn-block mb-1">View Recent Payslips</a>
                         <a href="<?php echo base_url('payrollreport/tax_report'); ?>" class="btn btn-info btn-block mb-1">Tax Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/vendors/js/charts/chart.min.js"></script>
<script>
    $(document).ready(function() {
        var ctx = document.getElementById("payrollTrendChart").getContext("2d");
        
        var labels = <?php echo json_encode(array_column($stats['trend'], 'end_date')); ?>;
        var dataAmount = <?php echo json_encode(array_column($stats['trend'], 'total_amount')); ?>;
        var dataTax = <?php echo json_encode(array_column($stats['trend'], 'total_tax')); ?>;

        var config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Net Pay",
                    data: dataAmount,
                    backgroundColor: "rgba(22, 211, 154, 0.5)",
                    borderColor: "rgba(22, 211, 154, 1)",
                    borderWidth: 1
                }, {
                    label: "Tax",
                    data: dataTax,
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                 scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        };

        new Chart(ctx, config);
    });
</script>
