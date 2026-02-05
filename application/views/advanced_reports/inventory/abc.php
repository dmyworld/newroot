<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>ABC Inventory Analysis</h4>
            <div class="heading-elements">
                <span class="badge badge-success">Class A: Top 80%</span>
                <span class="badge badge-info">Class B: Next 15%</span>
                <span class="badge badge-warning">Class C: Bottom 5%</span>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped table-bordered zero-configuration" id="abcTable">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Class</th>
                            <th class="text-right">Units Sold</th>
                            <th class="text-right">Revenue Contrib.</th>
                            <th class="text-right">Share %</th>
                            <th class="text-right">Cumulative %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($abc_data as $row) { 
                            $class_color = 'warning';
                            if($row['class'] == 'A') $class_color = 'success';
                            if($row['class'] == 'B') $class_color = 'info';
                        ?>
                        <tr>
                            <td><?= $row['product_name'] ?></td>
                            <td><span class="badge badge-<?= $class_color ?>"><?= $row['class'] ?></span></td>
                            <td class="text-right"><?= $row['units_sold'] ?></td>
                            <td class="text-right font-weight-bold"><?= amountFormat($row['total_revenue']) ?></td>
                            <td class="text-right"><?= number_format($row['share'], 2) ?>%</td>
                            <td class="text-right"><?= number_format($row['cumulative_share'], 2) ?>%</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
