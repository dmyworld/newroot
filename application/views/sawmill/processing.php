<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Sawmill Processing Center</h4>
            <div class="heading-elements">
                <a href="<?php echo base_url('sawmill/new_job') ?>" class="btn btn-success btn-sm"><i class="fa fa-cogs"></i> New Processing Job</a>
                <a href="<?php echo base_url('sawmill/slabs_inventory') ?>" class="btn btn-info btn-sm"><i class="fa fa-cubes"></i> Slab Inventory</a>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <select class="form-control" id="filterSawmill">
                            <option value="">Select Sawmill (Location)</option>
                            <?php foreach ($locations as $loc): ?>
                                <option value="<?= $loc['id'] ?>"><?= $loc['cname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <table id="sawmillTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Job #</th>
                            <th>Log Source</th>
                            <th>Input Vol (cuft)</th>
                            <th>Output Vol (cuft)</th>
                            <th>Slabs (cuft)</th>
                            <th>Wastage %</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $row): ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>
                            <td><?= strtoupper($row['source_lot_type']) ?> #<?= $row['source_lot_id'] ?></td>
                            <td><?= number_format($row['input_qty'], 2) ?></td>
                            <td><?= number_format($row['output_qty'], 2) ?></td>
                            <td><?= number_format($row['slabs_qty'], 2) ?></td>
                            <td><?= number_format($row['wastage'], 1) ?>%</td>
                            <td><span class="badge badge-success">COMPLETED</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#sawmillTable').DataTable({
        'responsive': true
    });
});
</script>
