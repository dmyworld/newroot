<div class="content-body">
    <div class="row pt-2">
        <div class="col-12 text-center mb-3">
            <h2 class="text-uppercase font-weight-bold" style="letter-spacing: 2px; color: #2c3e50;">Live System Health Matrix</h2>
            <p class="text-muted">Global Performance & Financial Integrity Audit</p>
        </div>
    </div>

    <div class="row">
        <!-- Financial Integrity Card -->
        <div class="col-md-6 col-12">
            <div class="card bg-white shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-gradient-x-secondary white p-3 border-0">
                    <h4 class="card-title text-white"><i class="fa fa-university mr-2"></i> Zero-Error Financial Index</h4>
                </div>
                <div class="card-content p-4 text-center">
                    <?php if($integrity['mismatch'] == 0): ?>
                        <div class="status-gauge mb-3">
                            <i class="fa fa-check-circle text-success" style="font-size: 8rem;"></i>
                        </div>
                        <h3 class="success font-weight-bold">PERFECT EQUILIBRIUM</h3>
                        <p class="text-muted">All Debits and Credits match across the entire system. Audit trail is pristine.</p>
                    <?php else: ?>
                        <div class="status-gauge mb-3">
                            <i class="fa fa-warning text-danger" style="font-size: 8rem;"></i>
                        </div>
                        <h3 class="danger font-weight-bold">MISMATCH DETECTED</h3>
                        <p class="text-danger font-weight-bold" style="font-size: 1.5rem;">Gap: <?= amountExchange($integrity['mismatch'],0,$this->aauth->get_user()->loc) ?></p>
                        <p class="text-muted small">Immediate audit reconciliation required for transaction logs.</p>
                    <?php endif; ?>
                    
                    <div class="row mt-4">
                        <div class="col-6 border-right">
                            <h4 class="font-weight-bold"><?= amountExchange($integrity['total_debit'],0,$this->aauth->get_user()->loc) ?></h4>
                            <span class="text-muted small uppercase">Global Debits</span>
                        </div>
                        <div class="col-6">
                            <h4 class="font-weight-bold"><?= amountExchange($integrity['total_credit'],0,$this->aauth->get_user()->loc) ?></h4>
                            <span class="text-muted small uppercase">Global Credits</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Performance Card -->
        <div class="col-md-6 col-12">
            <div class="card bg-dark white shadow-lg border-0" style="border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, #2c3e50 0%, #000000 100%);">
                <div class="card-header border-0 bg-transparent p-3">
                    <h4 class="card-title text-white"><i class="fa fa-bolt mr-2 text-warning"></i> Engine Performance</h4>
                </div>
                <div class="card-content p-4">
                    <div class="metric-row border-bottom border-secondary pb-3 mb-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-hdd-o text-muted mr-2"></i> Database Load</span>
                        <span class="badge badge-pill badge-primary"><?= $performance['db_size'] ?></span>
                    </div>
                    <div class="metric-row border-bottom border-secondary pb-3 mb-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-tachometer text-muted mr-2"></i> Latency</span>
                        <span class="text-success font-weight-bold"><?= $performance['server_load'] ?> ms</span>
                    </div>
                    <div class="metric-row border-bottom border-secondary pb-3 mb-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-exclamation-triangle text-muted mr-2"></i> API Error Log (24h)</span>
                        <span class="badge badge-pill <?= $performance['api_errors_24h'] > 0 ? 'badge-danger' : 'badge-success' ?>"><?= $performance['api_errors_24h'] ?></span>
                    </div>
                    <div class="metric-row d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-microchip text-muted mr-2"></i> AI Core (Revid)</span>
                        <span class="text-info font-weight-bold dot-blink"><?= $performance['revid_ai_status'] ?></span>
                    </div>

                    <div class="mt-4 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                        <small class="text-muted uppercase d-block mb-1">Live Server Pulse</small>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar progress-bar-animated progress-bar-striped bg-warning" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dot-blink {
    animation: blinker 1.5s linear infinite;
}
@keyframes blinker {
    50% { opacity: 0.3; }
}
.bg-gradient-x-secondary {
    background-image: linear-gradient(to right, #434343 0%, #000000 100%);
}
</style>
