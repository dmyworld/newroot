<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Transfer Summary #<?php echo $transfer['tid']; ?></h5>
            <div class="heading-elements">
                <a href="<?php echo base_url('transfers/transfer_summary?id=' . $transfer['tid'] . '&d=1'); ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-download"></i> Download PDF
                </a>
                <a href="<?php echo base_url('transfers/transfer_summary?id=' . $transfer['tid']); ?>" class="btn btn-info btn-sm" target="_blank">
                    <i class="fa fa-print"></i> Print PDF
                </a>
                <a href="<?php echo base_url('transfers/transfer_list'); ?>" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <!-- Transfer Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Transfer Information</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Transfer ID:</strong> #<?php echo $transfer['tid']; ?></p>
                                <p><strong>Transfer Date:</strong> <?php echo date('F j, Y', strtotime($transfer['invoicedate'])); ?></p>
                                <p><strong>Status:</strong> <span class="badge badge-success"><?php echo ucfirst($transfer['status']); ?></span></p>
                                <?php if (isset($employee)): ?>
                                <p><strong>Processed By:</strong> <?php echo htmlspecialchars($employee['name']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Warehouse Information</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>From Warehouse:</strong> <?php echo $from_warehouse_name; ?></p>
                                <p><strong>To Warehouse:</strong> <?php echo $to_warehouse_name; ?></p>
                                <p><strong>Total Items:</strong> <?php echo $transfer['items']; ?></p>
                                <p><strong>Reference:</strong> <?php echo $transfer['refer']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($transfer['notes'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Transfer Notes</h6>
                    </div>
                    <div class="card-body">
                        <?php echo htmlspecialchars($transfer['notes']); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-header">
                        <h6>Transferred Products</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Product Code</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $index => $product): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                                            <td><?php echo number_format($product['qty'], 2); ?></td>
                                            <td><span class="badge badge-success">Transferred</span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No products found for this transfer</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>