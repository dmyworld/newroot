<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="content-header-title mb-0">
                    <i class="ft-bell mr-1" style="color:var(--timber-accent);"></i>
                    Ring System Dashboard
                </h2>
                <a href="<?= site_url('ring/create') ?>" class="btn btn-primary" style="border-radius:10px;">
                    <i class="ft-plus mr-1"></i> New Request
                </a>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <!-- Stats -->
            <div class="col-md-4">
                <div class="card bg-gradient-x-info white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-1"><i class="ft-clock font-large-1"></i></div>
                            <div>
                                <h4 class="white"><?= $stats['pending'] ?></h4>
                                <span>Pending Requests</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-x-success white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-1"><i class="ft-check-circle font-large-1"></i></div>
                            <div>
                                <h4 class="white"><?= $stats['accepted'] ?></h4>
                                <span>Active Engagements</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-x-primary white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="p-1"><i class="ft-award font-large-1"></i></div>
                            <div>
                                <h4 class="white"><?= $stats['completed'] ?></h4>
                                <span>Jobs Completed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- My Requests -->
            <div class="col-12 col-xl-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">My Service Requests</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($my_requests)): ?>
                                        <tr><td colspan="6" class="text-center text-muted">No requests found.</td></tr>
                                    <?php else: foreach($my_requests as $row): ?>
                                        <tr>
                                            <td>#<?= $row['id'] ?></td>
                                            <td><strong><?= htmlspecialchars($row['title']) ?></strong></td>
                                            <td><span class="badge badge-secondary"><?= ucfirst($row['request_type']) ?></span></td>
                                            <td>
                                                <span class="badge badge-<?= $row['status'] == 'pending' ? 'warning' : ($row['status'] == 'accepted' ? 'success' : 'info') ?>">
                                                    <?= ucfirst($row['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, H:i', strtotime($row['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= site_url('ring/view/'.$row['id']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nearby Open Requests (For Providers) -->
            <div class="col-12 col-xl-5">
                <div class="card" style="border: 1px dashed var(--timber-accent);">
                    <div class="card-header">
                        <h4 class="card-title"><i class="ft-map-pin mr-1 text-info"></i>Nearby Opportunities</h4>
                    </div>
                    <div class="card-body">
                        <?php if(empty($open_requests)): ?>
                            <p class="text-center text-muted py-2">No open requests in your location.</p>
                        <?php else: foreach($open_requests as $row): ?>
                            <div class="media mb-2 p-2 border-bottom">
                                <div class="media-body">
                                    <h5 class="media-heading mb-0"><?= htmlspecialchars($row['title']) ?></h5>
                                    <small class="text-muted"><?= ucfirst($row['request_type']) ?> • Budget: Rs. <?= number_format($row['budget'], 2) ?></small>
                                    <div class="mt-1">
                                        <a href="<?= site_url('ring/view/'.$row['id']) ?>" class="btn btn-sm btn-info">Inspect</a>
                                        <a href="<?= site_url('ring/accept/'.$row['id']) ?>" class="btn btn-sm btn-success">Accept Ring</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
