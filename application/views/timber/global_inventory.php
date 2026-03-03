<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Global Timber Inventory Report</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Log Inventory by Location</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-blue bg-lighten-4">
                                    <th>Location</th>
                                    <th>Volume (Cubic Feet)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_logs = 0;
                                foreach ($inventory['logs'] as $row): 
                                    $loc_name = 'Unknown';
                                    foreach($locations as $l) if($l['id'] == $row['loc']) $loc_name = $l['cname'];
                                    $total_logs += $row['vol'];
                                ?>
                                <tr>
                                    <td><?= $loc_name ?></td>
                                    <td><?= number_format($row['vol'], 2) ?> CF</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-grey bg-lighten-3">
                                    <th>Total Global Logs</th>
                                    <th><?= number_format($total_logs, 2) ?> CF</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Sawn Inventory by Location</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-green bg-lighten-4">
                                    <th>Location</th>
                                    <th>Volume (Cubic Feet)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_sawn = 0;
                                foreach ($inventory['sawn'] as $row): 
                                    $loc_name = 'Unknown';
                                    foreach($locations as $l) if($l['id'] == $row['loc']) $loc_name = $l['cname'];
                                    $total_sawn += $row['vol'];
                                ?>
                                <tr>
                                    <td><?= $loc_name ?></td>
                                    <td><?= number_format($row['vol'], 2) ?> CF</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-grey bg-lighten-3">
                                    <th>Total Global Sawn</th>
                                    <th><?= number_format($total_sawn, 2) ?> CF</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
