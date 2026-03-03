<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="content-header-title mb-0">Request #<?= $request['id'] ?></h2>
                <div>
                    <span class="badge badge-pill badge-<?= $request['status'] == 'pending' ? 'warning' : ($request['status'] == 'accepted' ? 'success' : 'info') ?> px-2 py-1">
                        <?= strtoupper($request['status']) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <!-- Details -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-1"><?= htmlspecialchars($request['title']) ?></h4>
                        <div class="d-flex mb-2 text-muted small">
                            <span class="mr-2"><i class="ft-tag mr-1"></i> <?= ucfirst($request['request_type']) ?></span>
                            <span><i class="ft-clock mr-1"></i> <?= date('d M Y, H:i', strtotime($request['created_at'])) ?></span>
                        </div>
                        <p class="card-text border-top pt-2">
                            <?= nl2br(htmlspecialchars($request['description'])) ?>
                        </p>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label class="text-muted small d-block">Budget</label>
                                <strong>Rs. <?= number_format($request['budget'], 2) ?></strong>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small d-block">Location</label>
                                <strong>District ID: <?= $request['requester_loc'] ?></strong>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small d-block">Accepted At</label>
                                <strong><?= $request['accepted_at'] ? date('H:i, d M', strtotime($request['accepted_at'])) : '—' ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Log -->
                <div class="card mt-2">
                    <div class="card-header"><h5 class="card-title mb-0">Ring Activity Log</h5></div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php foreach($ring_logs as $log): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <span class="text-capitalize"><?= $log['action'] ?></span> 
                                        <small class="text-muted">by User #<?= $log['provider_user_id'] ?: 'System' ?></small>
                                    </div>
                                    <small><?= date('H:i:s', strtotime($log['action_at'] ?: $log['notified_at'])) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="col-md-4">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <?php if($request['status'] == 'pending'): ?>
                            <a href="<?= site_url('ring/accept/'.$request['id']) ?>" class="btn btn-success btn-block py-1 mb-1">
                                <i class="ft-check mr-1"></i> Accept This Request
                            </a>
                            <a href="<?= site_url('ring/cancel/'.$request['id']) ?>" class="btn btn-outline-danger btn-block btn-sm">
                                Cancel Request
                            </a>
                        <?php elseif($request['status'] == 'accepted'): ?>
                            <div class="alert alert-success py-1">
                                <i class="ft-user mr-1"></i> Provider Assigned
                            </div>
                            <p class="small text-muted mb-2">Live tracking is now active if applicable.</p>
                            <button class="btn btn-primary btn-block mb-1"><i class="ft-message-square mr-1"></i> Chat with Requester</button>
                        <?php endif; ?>
                        
                        <a href="<?= site_url('ring') ?>" class="btn btn-outline-secondary btn-block mt-2">
                            <i class="ft-arrow-left mr-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
