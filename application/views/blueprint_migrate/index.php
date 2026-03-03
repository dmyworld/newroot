<?php defined('BASEPATH') OR exit; ?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">
                        <i class="fas fa-database mr-1" style="color:#3b82f6;"></i>
                        Blueprint Migration Runner
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-9">

                <!-- Info Card -->
                <div class="card" style="background:rgba(15,23,42,0.9);border:1px solid rgba(59,130,246,0.2);border-radius:16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div style="width:56px;height:56px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-right:16px;">
                                <i class="fas fa-code-branch text-white" style="font-size:1.6rem;"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-white">Timber Pro Blueprint Migration</h4>
                                <p class="mb-0" style="color:#94a3b8;">Adds new tables &amp; columns required by the blueprint. Safe to re-run.</p>
                            </div>
                        </div>

                        <hr style="border-color:rgba(59,130,246,0.15);">

                        <h6 class="text-white mb-3"><i class="fas fa-list-check mr-1" style="color:#22c55e;"></i> What this migration will do:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <ul style="color:#94a3b8;list-style:none;padding:0;">
                                    <li class="mb-1"><span style="color:#22c55e;">+</span> Create <strong class="text-white">15 new tables</strong> (tp_* prefix)</li>
                                    <li class="mb-1"><span style="color:#22c55e;">+</span> Ring System (service requests, live tracking)</li>
                                    <li class="mb-1"><span style="color:#22c55e;">+</span> Escrow Vault (secure payment holding)</li>
                                    <li class="mb-1"><span style="color:#22c55e;">+</span> AI Marketing Subscriptions (packages, logs)</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul style="color:#94a3b8;list-style:none;padding:0;">
                                    <li class="mb-1"><span style="color:#22c55e;">+</span> Green Future (donations, tree planting, payouts)</li>
                                    <li class="mb-1"><span style="color:#22c55e;">+</span> Referral Program (codes &amp; logs)</li>
                                    <li class="mb-1"><span style="color:#22c55e;">+</span> Provider Insurance (policies &amp; claims)</li>
                                    <li class="mb-1"><span style="color:#3b82f6;">~</span> Alter 5 existing tables with new columns</li>
                                </ul>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0" style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.3);border-radius:10px;color:#93c5fd;">
                            <i class="fas fa-shield-alt mr-1"></i>
                            <strong>Safe to re-run:</strong> All statements use <code>IF NOT EXISTS</code> guards. Existing data will not be modified.
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card mt-0" style="background:rgba(15,23,42,0.9);border:1px solid rgba(59,130,246,0.2);border-radius:16px;">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <a href="<?= site_url('blueprint_migrate/run') ?>"
                                   class="btn btn-block py-3"
                                   style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;font-weight:700;font-size:1.1rem;border-radius:12px;border:none;box-shadow:0 4px 20px rgba(59,130,246,0.4);"
                                   onclick="this.innerText='⏳ Running migration...'; this.style.pointerEvents='none';">
                                    <i class="fas fa-play mr-2"></i> Run Migration Now
                                </a>
                                <p class="text-muted text-center mt-2 mb-0" style="font-size:0.8rem;">Executes all SQL statements and shows a report</p>
                            </div>
                            <div class="col-md-6">
                                <a href="<?= site_url('blueprint_migrate/verify') ?>"
                                   class="btn btn-block py-3"
                                   style="background:rgba(34,197,94,0.15);color:#22c55e;font-weight:700;font-size:1.1rem;border-radius:12px;border:1px solid rgba(34,197,94,0.3);">
                                    <i class="fas fa-check-circle mr-2"></i> Verify Migration
                                </a>
                                <p class="text-muted text-center mt-2 mb-0" style="font-size:0.8rem;">Check that all tables and columns exist</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
