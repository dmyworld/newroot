<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Pending Deletions Review (Sprint 1)</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <p>Items listed here have been requested for deletion by staff. Owners can approve them to move to "Pending Final Review", and Super Admins can perform the final hard delete.</p>
                
                <div class="table-responsive mt-1">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Identification</th>
                                <th>Creator/Owner</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoices as $row) { ?>
                            <tr>
                                <td><span class="badge badge-info text-uppercase">Invoice</span></td>
                                <td>#<?php echo $row['tid'] ?> - <?php echo $row['invoicedate'] ?></td>
                                <td>ID: <?php echo $row['eid'] ?></td>
                                <td><span class="badge badge-warning">Review Needed</span></td>
                                <td>
                                    <a href="<?php echo base_url('reports/approve_deletion?id='.$row['id'].'&type=invoices') ?>" class="btn btn-success btn-sm"><i class="ft-check"></i> Approve</a>
                                    <a href="<?php echo base_url('reports/reject_deletion?id='.$row['id'].'&type=invoices') ?>" class="btn btn-danger btn-sm"><i class="ft-x"></i> Reject</a>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php foreach ($products as $row) { ?>
                            <tr>
                                <td><span class="badge badge-primary text-uppercase">Product</span></td>
                                <td><?php echo $row['product_name'] ?> (<?php echo $row['product_code'] ?>)</td>
                                <td>Current Loc: <?php echo $row['loc'] ?></td>
                                <td><span class="badge badge-warning">Review Needed</span></td>
                                <td>
                                    <a href="<?php echo base_url('reports/approve_deletion?id='.$row['id'].'&type=products') ?>" class="btn btn-success btn-sm"><i class="ft-check"></i> Approve</a>
                                    <a href="<?php echo base_url('reports/reject_deletion?id='.$row['id'].'&type=products') ?>" class="btn btn-danger btn-sm"><i class="ft-x"></i> Reject</a>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php foreach ($customers as $row) { ?>
                            <tr>
                                <td><span class="badge badge-secondary text-uppercase">Customer</span></td>
                                <td><?php echo $row['name'] ?> (<?php echo $row['email'] ?>)</td>
                                <td>ID: <?php echo $row['id'] ?></td>
                                <td><span class="badge badge-warning">Review Needed</span></td>
                                <td>
                                    <a href="<?php echo base_url('reports/approve_deletion?id='.$row['id'].'&type=customers') ?>" class="btn btn-success btn-sm"><i class="ft-check"></i> Approve</a>
                                    <a href="<?php echo base_url('reports/reject_deletion?id='.$row['id'].'&type=customers') ?>" class="btn btn-danger btn-sm"><i class="ft-x"></i> Reject</a>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php if(empty($invoices) && empty($products) && empty($customers)) { ?>
                            <tr>
                                <td colspan="5" class="text-center font-italic">No pending deletions at this stage.</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
