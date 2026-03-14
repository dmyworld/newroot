<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h5>Commission Summary Report</h5>
            <hr>
        </div>
        <div class="header-actions">
            <button class="btn-premium btn-secondary-glass" onclick="window.print()"><i class="fa fa-print"></i> Export PDF</button>
        </div>
    </div>

    <div class="premium-card">
        <div class="card-body">
            <form method="get" action="<?php echo base_url('service_reports/commissions') ?>">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" name="start" class="form-control" value="<?php echo $this->input->get('start') ?>">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="end" class="form-control" value="<?php echo $this->input->get('end') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="premium-card mt-2">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Commission Received</th>
                </tr>
                </thead>
                <tbody>
                <?php $total = 0; foreach ($summary as $row) { 
                    $total += $row['total_commission'];
                    ?>
                    <tr>
                        <td><?php echo $row['day'] ?></td>
                        <td><?php echo number_format($row['total_commission'], 2) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <th>Grand Total</th>
                        <th><?php echo number_format($total, 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
