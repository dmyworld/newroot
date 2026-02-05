<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Multi-Period Analysis (Year over Year)</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-right">Current Year (<?= date('Y') ?>)</th>
                            <th class="text-right">Last Year (<?= date('Y')-1 ?>)</th>
                            <th class="text-right">Growth %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $months = [
                            1=>'January', 2=>'February', 3=>'March', 4=>'April', 
                            5=>'May', 6=>'June', 7=>'July', 8=>'August', 
                            9=>'September', 10=>'October', 11=>'November', 12=>'December'
                        ];

                        foreach($analysis as $mon => $data) { 
                            $cy = $data['current'];
                            $ly = $data['last'];
                            $growth = 0;
                            if($ly > 0) {
                                $growth = (($cy - $ly) / $ly) * 100;
                            } else if ($cy > 0) {
                                $growth = 100;
                            }
                            
                            $growth_class = $growth >= 0 ? 'text-success' : 'text-danger';
                        ?>
                        <tr>
                            <td><?= $months[$mon] ?></td>
                            <td class="text-right"><?= amountFormat($cy) ?></td>
                            <td class="text-right"><?= amountFormat($ly) ?></td>
                            <td class="text-right <?= $growth_class ?>"><?= number_format($growth, 1) ?>%</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
