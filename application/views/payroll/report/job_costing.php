<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Labor Costing by Job Code (<?php echo dateformat($start) . ' - ' . dateformat($end); ?>)</h5>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped table-bordered zero-configuration" id="costTable">
                    <thead>
                        <tr>
                            <th>Job Code</th>
                            <th>Description</th>
                            <th>Total Hours</th>
                            <th>Employee Count</th>
                            <th>Est. Cost (Hours x Avg Rate)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_hours = 0;
                        foreach ($costs as $row) { 
                            $total_hours += $row['total_hours'];
                            // Placeholder for cost estimation logic since we don't have rate per hour per job in this summary return easily without complex query
                            // We will assuming a standard rate or leave column for user to interpret for now.
                            // Better: Let's assume a global avg rate or just show hours.
                            // For simplicity in this iteration, we show hours and a placeholder for cost.
                        ?>
                            <tr>
                                <td><?php echo $row['code'] ?: 'Unassigned'; ?></td>
                                <td><?php echo $row['title'] ?: 'General / N/A'; ?></td>
                                <td><?php echo number_format($row['total_hours'], 2); ?></td>
                                <td><?php echo $row['employee_count']; ?></td>
                                <td> - </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right">Total Hours</th>
                            <th><?php echo number_format($total_hours, 2); ?></th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
