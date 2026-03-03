<?php defined('BASEPATH') OR exit; ?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">
                        <i class="fas fa-terminal mr-1" style="color:#3b82f6;"></i>
                        Migration Results
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">

                <!-- Summary Bar -->
                <div class="card mb-2" style="background:rgba(15,23,42,0.95);border:1px solid rgba(59,130,246,0.2);border-radius:16px;">
                    <div class="card-body py-3 px-4">
                        <div class="row text-center">
                            <div class="col-3">
                                <div style="font-size:2rem;font-weight:800;color:#94a3b8;"><?= $total ?></div>
                                <div style="color:#64748b;font-size:0.8rem;">TOTAL STATEMENTS</div>
                            </div>
                            <div class="col-3">
                                <div style="font-size:2rem;font-weight:800;color:#22c55e;"><?= $success ?></div>
                                <div style="color:#64748b;font-size:0.8rem;">SUCCESSFUL</div>
                            </div>
                            <div class="col-3">
                                <div style="font-size:2rem;font-weight:800;color:#3b82f6;"><?= $skipped ?></div>
                                <div style="color:#64748b;font-size:0.8rem;">SKIPPED (EXISTS)</div>
                            </div>
                            <div class="col-3">
                                <div style="font-size:2rem;font-weight:800;color:<?= $errors > 0 ? '#ef4444' : '#22c55e' ?>;"><?= $errors ?></div>
                                <div style="color:#64748b;font-size:0.8rem;">ERRORS</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overall Status Alert -->
                <?php if ($errors === 0): ?>
                <div class="alert" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);border-radius:12px;color:#86efac;font-weight:600;">
                    <i class="fas fa-check-circle mr-2" style="color:#22c55e;"></i>
                    Migration completed successfully! <?= $success ?> statement(s) executed, <?= $skipped ?> skipped.
                </div>
                <?php else: ?>
                <div class="alert" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:12px;color:#fca5a5;font-weight:600;">
                    <i class="fas fa-exclamation-triangle mr-2" style="color:#ef4444;"></i>
                    Migration completed with <?= $errors ?> error(s). Review the log below.
                </div>
                <?php endif; ?>

                <!-- Results Log -->
                <div class="card" style="background:rgba(2,6,23,0.98);border:1px solid rgba(59,130,246,0.15);border-radius:16px;">
                    <div class="card-header" style="background:transparent;border-bottom:1px solid rgba(59,130,246,0.15);padding:16px 20px;">
                        <h6 class="mb-0 text-white"><i class="fas fa-scroll mr-2" style="color:#3b82f6;"></i>Execution Log</h6>
                    </div>
                    <div class="card-body p-0">
                        <div style="font-family:'Courier New',monospace;font-size:0.78rem;max-height:60vh;overflow-y:auto;padding:16px;">
                            <?php foreach ($results as $r): ?>
                                <div class="mb-1" style="padding:4px 10px;border-radius:6px;
                                    background:<?= $r['type']==='success' ? 'rgba(34,197,94,0.08)' : ($r['type']==='error' ? 'rgba(239,68,68,0.1)' : 'rgba(59,130,246,0.06)') ?>;
                                    color:<?= $r['type']==='success' ? '#86efac' : ($r['type']==='error' ? '#fca5a5' : '#93c5fd') ?>;">
                                    <?= htmlspecialchars($r['msg']) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-3 d-flex gap-3">
                    <a href="<?= site_url('blueprint_migrate/verify') ?>"
                       class="btn mr-2"
                       style="background:linear-gradient(135deg,#22c55e,#15803d);color:white;font-weight:700;border-radius:10px;border:none;padding:10px 24px;">
                        <i class="fas fa-check-circle mr-1"></i> Verify Tables
                    </a>
                    <a href="<?= site_url('blueprint_migrate') ?>"
                       class="btn"
                       style="background:rgba(59,130,246,0.15);color:#93c5fd;font-weight:700;border-radius:10px;border:1px solid rgba(59,130,246,0.3);padding:10px 24px;">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
