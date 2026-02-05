<div class="content-body">
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('Monthly Payroll Cost') ?> (<?php echo date('Y'); ?>)</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div id="monthly-cost-chart" class="height-400"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('Department Cost Distribution') ?></h4>
                     <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                             <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                 <div class="card-content collapse show">
                    <div class="card-body">
                        <div id="dept-dist-chart" class="height-400"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    // Monthly Cost Chart
    $.ajax({
        url: '<?php echo base_url("payrollanalytics/monthly_trends_data"); ?>',
        dataType: 'json',
        success: function(data) {
            Morris.Area({
                element: 'monthly-cost-chart',
                data: data,
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Total Gross Cost'],
                pointSize: 2,
                hideHover: 'auto',
                resize: true,
                lineColors: ['#3b82f6'],
                fillOpacity: 0.5,
                 behaveLikeLine: true,
            });
        }
    });

    // Dept Distribution Chart
    $.ajax({
        url: '<?php echo base_url("payrollanalytics/dept_distribution_data"); ?>',
        dataType: 'json',
        success: function(data) {
            Morris.Donut({
                element: 'dept-dist-chart',
                data: data,
                resize: true,
                colors: ['#00B5B8', '#FF7588', '#FFC107', '#3b82f6', '#10b981']
            });
        }
    });
});
</script>
