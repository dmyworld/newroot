<div class="content-body">
    <div class="row pt-2 align-items-center">
        <div class="col-md-8">
            <h2 class="font-weight-bold" style="color: #1b4f72;">Business Vitality Report</h2>
            <p class="text-muted">Real-time health indicators for your locations.</p>
        </div>
        <div class="col-md-4 text-right">
            <span class="badge badge-pill badge-primary p-2">Location ID: <?= $this->aauth->get_user()->loc ?></span>
        </div>
    </div>

    <!-- Health Meters Row -->
    <div class="row mt-3">
        <!-- Liquidity Meter -->
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 rounded-lg text-center p-4">
                <h5 class="text-muted mb-3 uppercase small font-weight-bold">Liquidity Status</h5>
                <div class="cash-meter mb-2">
                    <h2 class="font-weight-bold text-dark mb-0"><?= amountExchange($liquidity,0,$this->aauth->get_user()->loc) ?></h2>
                    <span class="text-success small"><i class="fa fa-caret-up"></i> Cash Flow Healthy</span>
                </div>
                <div class="progress mt-3" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: 75%"></div>
                </div>
                <p class="text-muted small mt-2">Available operating capital across accounts.</p>
            </div>
        </div>

        <!-- Inventory Health -->
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 rounded-lg p-4">
                <h5 class="text-muted mb-3 uppercase small font-weight-bold text-center">Inventory Alerts</h5>
                <div class="d-flex justify-content-around align-items-center">
                    <div class="text-center">
                        <div class="badge-ring border-warning p-3 d-inline-block rounded-circle mb-1" style="border: 4px solid #f39c12;">
                            <h3 class="m-0 font-weight-bold text-warning"><?= $inventory['amber'] ?></h3>
                        </div>
                        <span class="d-block small text-muted">Low Stock</span>
                    </div>
                    <div class="text-center">
                        <div class="badge-ring border-danger p-3 d-inline-block rounded-circle mb-1" style="border: 4px solid #e74c3c;">
                            <h3 class="m-0 font-weight-bold text-danger"><?= $inventory['red'] ?></h3>
                        </div>
                        <span class="d-block small text-muted">Out of Stock</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Operational Pulse (Placeholder for other metrics) -->
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 rounded-lg p-4 bg-primary white">
                <h5 class="white mb-3 uppercase small font-weight-bold text-center">Operational Pulse</h5>
                <div class="text-center py-2">
                    <i class="fa fa-heartbeat fa-3x mb-2 text-white opacity-80"></i>
                    <h3 class="font-weight-bold">STABLE</h3>
                    <p class="small mb-0 opacity-80">All services functional.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Overruns Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                    <h4 class="card-title font-weight-bold" style="color: #e67e22;"><i class="fa fa-exclamation-triangle mr-2"></i> Budget Overrun Alerts (Project Health)</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Project Name</th>
                                    <th>Budgeted Amount</th>
                                    <th>Total Expense</th>
                                    <th>Excess Amount</th>
                                    <th>Risk Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($overruns)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center p-4">
                                            <i class="fa fa-smile-o text-success fa-2x mb-2 d-block"></i>
                                            <span class="text-muted">No budget overruns detected. All projects within limits.</span>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($overruns as $p): ?>
                                        <tr>
                                            <td class="font-weight-bold"><?= $p['name'] ?></td>
                                            <td><?= amountExchange($p['budget'],0,$this->aauth->get_user()->loc) ?></td>
                                            <td class="text-danger"><?= amountExchange($p['expense'],0,$this->aauth->get_user()->loc) ?></td>
                                            <td class="text-danger font-weight-bold">+ <?= amountExchange($p['excess'],0,$this->aauth->get_user()->loc) ?></td>
                                            <td><span class="badge badge-danger">CRITICAL</span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.opacity-80 { opacity: 0.8; }
.badge-ring { width: 70px; height: 70px; line-height: 40px; }
</style>
