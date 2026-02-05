<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Retail Traffic Analysis (Peak Sales Hours)</h4>
            <p class="text-muted">Analysis of transaction volume by hour of day (Last 30 Days).</p>
        </div>
        <div class="card-content">
            <div class="card-body">
                <?php if(empty($traffic)) { ?>
                     <div class="alert alert-warning">
                        No sales data found in the last 30 days to analyze.
                    </div>
                <?php } else { ?>
                <div class="row">
                    <div class="col-md-8">
                         <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Hour of Day</th>
                                        <th class="text-right">Transactions</th>
                                        <th class="text-right">Revenue</th>
                                        <th>Intensity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $max_count = 0;
                                    foreach($traffic as $t) if($t['transaction_count'] > $max_count) $max_count = $t['transaction_count'];
                                    
                                    foreach($traffic as $row) { 
                                        $percent = ($max_count > 0) ? round(($row['transaction_count'] / $max_count) * 100) : 0;
                                        $color_class = "gradient-pomegranate"; // default redish
                                        if($percent < 30) $color_class = "bg-success";
                                        elseif($percent < 70) $color_class = "bg-warning";
                                        else $color_class = "bg-danger";
                                    ?>
                                    <tr>
                                        <td><strong><?= $row['hour_of_day'] ?>:00 - <?= $row['hour_of_day'] ?>:59</strong></td>
                                        <td class="text-right"><?= $row['transaction_count'] ?></td>
                                        <td class="text-right"><?= amountFormat($row['revenue']) ?></td>
                                        <td>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar <?= $color_class ?>" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-gradient-x-info text-white">
                            <div class="card-body">
                                <h5><i class="fa fa-lightbulb-o"></i> Insight</h5>
                                <p class="mt-2">Use this data to optimize staff scheduling. Assign more staff during "red" peak hours to reduce wait times and increase sales conversion.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
