<?php defined('BASEPATH') OR exit; ?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">
                        <i class="fas fa-check-double mr-1" style="color:#22c55e;"></i>
                        Migration Verification
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">

                <!-- Score Card -->
                <div class="card mb-3" style="background:rgba(15,23,42,0.95);border:1px solid <?= $failed===0 ? 'rgba(34,197,94,0.3)' : 'rgba(239,68,68,0.3)' ?>;border-radius:16px;">
                    <div class="card-body text-center py-4">
                        <div style="font-size:3.5rem;font-weight:900;color:<?= $failed===0 ? '#22c55e' : '#ef4444' ?>;">
                            <?= $passed ?> / <?= count($checks) ?>
                        </div>
                        <div style="color:#94a3b8;font-size:1rem;margin-top:4px;">
                            <?php if ($failed === 0): ?>
                                <i class="fas fa-party-horn mr-1" style="color:#22c55e;"></i>
                                All tables and columns verified successfully!
                            <?php else: ?>
                                <i class="fas fa-triangle-exclamation mr-1" style="color:#ef4444;"></i>
                                <?= $failed ?> item(s) not found — please run the migration first.
                            <?php endif; ?>
                        </div>
                        <?php if ($failed > 0): ?>
                        <a href="<?= site_url('blueprint_migrate/run') ?>" class="btn mt-3"
                           style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;font-weight:700;border-radius:10px;border:none;padding:10px 24px;">
                            <i class="fas fa-play mr-1"></i> Run Migration Now
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Check Results -->
                <div class="card" style="background:rgba(15,23,42,0.9);border:1px solid rgba(59,130,246,0.15);border-radius:16px;">
                    <div class="card-header" style="background:transparent;border-bottom:1px solid rgba(59,130,246,0.15);padding:14px 20px;">
                        <h6 class="mb-0 text-white"><i class="fas fa-list mr-2" style="color:#3b82f6;"></i>Check Details</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="max-height:55vh;overflow-y:auto;">
                            <?php foreach ($checks as $c): ?>
                            <div class="d-flex align-items-center mb-1 px-3 py-2"
                                 style="border-radius:8px;background:<?= $c['ok'] ? 'rgba(34,197,94,0.07)' : 'rgba(239,68,68,0.08)' ?>;">
                                <i class="fas <?= $c['ok'] ? 'fa-check-circle' : 'fa-times-circle' ?> mr-3"
                                   style="color:<?= $c['ok'] ? '#22c55e' : '#ef4444' ?>;font-size:1rem;min-width:20px;"></i>
                                <span style="color:<?= $c['ok'] ? '#86efac' : '#fca5a5' ?>;font-family:monospace;font-size:0.85rem;">
                                    <?= htmlspecialchars($c['label']) ?>
                                </span>
                                <span class="ml-auto badge" style="background:<?= $c['ok'] ? 'rgba(34,197,94,0.2)' : 'rgba(239,68,68,0.2)' ?>;color:<?= $c['ok'] ? '#22c55e' : '#ef4444' ?>;border-radius:6px;font-size:0.7rem;">
                                    <?= $c['ok'] ? 'EXISTS' : 'MISSING' ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="<?= site_url('blueprint_migrate') ?>"
                       class="btn"
                       style="background:rgba(59,130,246,0.15);color:#93c5fd;font-weight:700;border-radius:10px;border:1px solid rgba(59,130,246,0.3);padding:10px 24px;">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Migration Page
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
