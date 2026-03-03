<?php defined('BASEPATH') OR exit; ?>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Ring Service Dashboard</h3>
        </div>
        <div class="content-header-right col-md-6 col-12 mb-2 text-right">
            <a href="<?= site_url('ring/create') ?>" class="btn btn-primary" style="background:#3b82f6; border:none;border-radius:10px;">
                <i class="fas fa-plus mr-1"></i> New Service Request
            </a>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card" style="background:#0f172a; border:1px solid #1e293b; border-radius:15px; color:white;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead>
                                    <tr style="border-bottom:2px solid #334155;">
                                        <th>Date</th>
                                        <th>Service Type</th>
                                        <th>Request Title</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $r): ?>
                                    <tr style="border-bottom:1px solid #1e293b;">
                                        <td><?= date('d M, H:i', strtotime($r['created_at'])) ?></td>
                                        <td class="text-capitalize"><?= str_replace('_', ' ', $r['request_type']) ?></td>
                                        <td><strong><?= $r['title'] ?></strong></td>
                                        <td>LKR <?= number_format($r['budget'], 2) ?></td>
                                        <td>
                                            <?php 
                                            $badge_class = 'badge-secondary';
                                            if ($r['status'] == 'ringing') $badge_class = 'badge-primary';
                                            if ($r['status'] == 'accepted') $badge_class = 'badge-success';
                                            if ($r['status'] == 'expired') $badge_class = 'badge-danger';
                                            ?>
                                            <span class="badge <?= $badge_class ?>" style="padding:8px 12px; border-radius:8px;">
                                                <?= strtoupper($r['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($r['status'] == 'ringing'): ?>
                                                <a href="<?= site_url('ring/active/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary" style="border-radius:8px;">View Ring</a>
                                            <?php elseif ($r['status'] == 'accepted'): ?>
                                                <a href="<?= site_url('ring/track/' . $r['id']) ?>" class="btn btn-sm btn-info" style="border-radius:8px;">Live Track</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($requests)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No service requests found. Start your first ring!</td>
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
