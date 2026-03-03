<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <h2 class="content-header-title mb-0">Escrow #<?= $escrow['escrow_ref'] ?></h2>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">Vault Details</h4></div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="text-muted d-block small">Purpose</label>
                                <strong><?= htmlspecialchars($escrow['purpose']) ?></strong>
                            </div>
                            <div class="col-6">
                                <label class="text-muted d-block small">Status</label>
                                <span class="badge badge-pill badge-<?= $escrow['status'] == 'held' ? 'info' : 'success' ?>"><?= strtoupper($escrow['status']) ?></span>
                            </div>
                        </div>
                        <div class="row mb-2">
                             <div class="col-6">
                                <label class="text-muted d-block small">Payer ID</label>
                                <strong>User #<?= $escrow['payer_user_id'] ?></strong>
                            </div>
                            <div class="col-6">
                                <label class="text-muted d-block small">Payee ID</label>
                                <strong>User #<?= $escrow['payee_user_id'] ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label class="text-muted d-block small">Gross Amount</label>
                                <h4 class="text-secondary">Rs. <?= number_format($escrow['amount'], 2) ?></h4>
                            </div>
                            <div class="col-4">
                                <label class="text-muted d-block small">Platform Fee (2%)</label>
                                <h4 class="text-danger">Rs. <?= number_format($escrow['fee'], 2) ?></h4>
                            </div>
                            <div class="col-4">
                                <label class="text-muted d-block small">Net to Release</label>
                                <h4 class="text-success font-weight-bold">Rs. <?= number_format($escrow['net_amount'], 2) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Ledger -->
                <div class="card">
                    <div class="card-header"><h5 class="card-title">Immutable Transaction Ledger</h5></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Action</th>
                                        <th>Amount</th>
                                        <th>Performed By</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($transactions as $tx): ?>
                                        <tr>
                                            <td><?= date('d M, H:i', strtotime($tx['created_at'])) ?></td>
                                            <td><span class="text-uppercase small"><?= $tx['action'] ?></span></td>
                                            <td>Rs. <?= number_format($tx['amount'], 2) ?></td>
                                            <td>User #<?= $tx['performed_by'] ?></td>
                                            <td><?= htmlspecialchars($tx['note']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">Manage Funds</h4></div>
                    <div class="card-body">
                        <?php if($escrow['status'] == 'held'): ?>
                            <div class="alert alert-warning small py-1">
                                <i class="ft-alert-circle mr-1"></i>
                                Releasing funds will trigger a transfer to the Payee's linked bank account or wallet.
                            </div>
                            <a href="<?= site_url('escrow/release/'.$escrow['id']) ?>" class="btn btn-success btn-block mb-1" onclick="return confirm('Release funds to payee?')">
                                <i class="ft-unlock mr-1"></i> Release Funds
                            </a>
                            <a href="<?= site_url('escrow/refund/'.$escrow['id']) ?>" class="btn btn-outline-danger btn-block btn-sm" onclick="return confirm('Refund funds to payer?')">
                                Request Refund / Dispute
                            </a>
                        <?php else: ?>
                            <div class="text-center py-2">
                                <i class="ft-check-circle text-success font-large-3"></i>
                                <h5 class="mt-1">Order Settled</h5>
                                <p class="text-muted small">This escrow vault is closed and funds have been moved.</p>
                            </div>
                        <?php endif; ?>

                        <hr>
                        <a href="<?= site_url('escrow') ?>" class="btn btn-block btn-outline-secondary mt-1">Back to Vault</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
