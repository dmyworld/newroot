<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <h2 class="content-header-title mb-0">
                <i class="ft-shield mr-1" style="color:#3b82f6;"></i>
                Escrow Vault
            </h2>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <!-- Summary -->
            <?php foreach($summary as $row): ?>
            <div class="col-md-3">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="<?= $row['status'] == 'held' ? 'info' : ($row['status'] == 'released' ? 'success' : 'warning') ?>">
                                        Rs. <?= number_format($row['total_amount'], 2) ?>
                                    </h3>
                                    <h6><?= strtoupper($row['status']) ?> (<?= $row['cnt'] ?>)</h6>
                                </div>
                                <div>
                                    <i class="ft-layers <?= $row['status'] == 'held' ? 'info' : ($row['status'] == 'released' ? 'success' : 'warning') ?> font-large-2 float-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Currently Held Funds</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Purpose</th>
                                <th>Amount</th>
                                <th>Platform Fee</th>
                                <th>Net to Payee</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($held)): ?>
                                <tr><td colspan="8" class="text-center">No funds currently in escrow.</td></tr>
                            <?php else: foreach($held as $row): ?>
                                <tr>
                                    <td class="text-bold-600"><?= $row['escrow_ref'] ?></td>
                                    <td><?= htmlspecialchars($row['purpose']) ?></td>
                                    <td>Rs. <?= number_format($row['amount'], 2) ?></td>
                                    <td>Rs. <?= number_format($row['fee'], 2) ?></td>
                                    <td class="text-success">Rs. <?= number_format($row['net_amount'], 2) ?></td>
                                    <td><span class="badge badge-info"><?= strtoupper($row['status']) ?></span></td>
                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= site_url('escrow/view/'.$row['id']) ?>" class="btn btn-sm btn-primary">Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
