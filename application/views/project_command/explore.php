<div class="content-body">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Project: <?php echo $project['project_name']; ?></h4>
                    <span class='badge badge-info'>Status: <?php echo $project['status']; ?></span>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Start Date:</strong> <?php echo dateformat($project['start_date']); ?></p>
                                <p><strong>End Date:</strong> <?php echo dateformat($project['end_date']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Budget:</strong> <?php echo amountExchange($project['total_budget'], 0, $this->aauth->get_user()->loc); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Table -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tasks</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Task</th>
                                <th>Assigned To</th>
                                <th>Est. Hours</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tasks as $task) { ?>
                                <tr>
                                    <td><?php echo $task['task_name']; ?></td>
                                    <td><?php echo $task['employee_name']; ?></td>
                                    <td><?php echo $task['estimated_hours']; ?></td>
                                    <td><span class="badge badge-secondary"><?php echo $task['status']; ?></span></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Finance Health Card -->
            <div class="card bg-light">
                <div class="card-header">
                    <h4 class="card-title">Financial Health</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <?php 
                        $total_cost = 0;
                        foreach($finances as $fin) $total_cost += $fin['amount'];
                        
                        // Use Estimated totals passed from controller
                        $est_total = isset($totals['estimated_total']) ? $totals['estimated_total'] : 0;
                        $projected_profit = $project['total_budget'] - $est_total;
                        
                        $color = $projected_profit >= 0 ? 'text-success' : 'text-danger';
                        ?>
                        <div class="mb-2">
                            <h6>Budget Utilization (Estimated)</h6>
                            <div class="progress" style="height: 20px;">
                                <?php $pct = ($project['total_budget'] > 0) ? ($est_total / $project['total_budget']) * 100 : 0; ?>
                                <div class="progress-bar <?php echo $pct > 90 ? 'bg-danger' : 'bg-primary'; ?>" style="width: <?php echo $pct; ?>%"><?php echo round($pct); ?>%</div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-6">Est. Labor:</div>
                            <div class="col-6 text-right"><?php echo amountExchange($totals['estimated_labor'], 0, $this->aauth->get_user()->loc); ?></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-6">Est. Material:</div>
                            <div class="col-6 text-right"><?php echo amountExchange($totals['estimated_material'], 0, $this->aauth->get_user()->loc); ?></div>
                        </div>
                        <div class="row mb-2" style="border-top:1px solid #eee; padding-top:5px;">
                            <div class="col-6"><strong>Total Est. Cost:</strong></div>
                            <div class="col-6 text-right"><?php echo amountExchange($est_total, 0, $this->aauth->get_user()->loc); ?></div>
                        </div>
                        
                        <p>Projected Profit: <strong class="<?php echo $color; ?>"><?php echo amountExchange($projected_profit, 0, $this->aauth->get_user()->loc); ?></strong></p>
                        <p class="text-muted"><small>Actual Incurred (WIP): <?php echo amountExchange($total_cost, 0, $this->aauth->get_user()->loc); ?></small></p>
                        <hr>
                        <a href="<?php echo base_url('project_command/milestones?id='.$project['id']); ?>" class="btn btn-warning btn-block mb-1"><i class="fa fa-flag-checkered"></i> Milestones</a>
                        <a href="<?php echo base_url('project_command/documents?id='.$project['id']); ?>" class="btn btn-primary btn-block mb-1"><i class="fa fa-folder-open"></i> Documents</a>
                        <a href="<?php echo base_url('project_command/gantt?id='.$project['id']); ?>" class="btn btn-success btn-block mb-1"><i class="fa fa-tasks"></i> Interactive Gantt Chart</a>
                        <a href="<?php echo base_url('project_command/pdf_report?id='.$project['id']); ?>" class="btn btn-info btn-block"><i class="fa fa-file-pdf-o"></i> Download P/L Analysis PDF</a>
                    </div>
                </div>
            </div>

            <!-- Reserved Materials -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Reserved Materials</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($reservations as $res) { ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $res['product_name']; ?>
                                    <span class="badge badge-primary badge-pill"><?php echo $res['qty']; ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
