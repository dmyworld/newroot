<style>
    .hp-dashboard {
        padding: 1.5rem;
    }
    .hp-header {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }
    .hp-header h2 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .hp-header p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.1rem;
    }
    .stat-card {
        border-radius: 20px;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
        height: 160px;
        margin-bottom: 1.5rem;
    }
    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    .stat-card .card-body {
        padding: 1.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 2;
        position: relative;
    }
    .stat-card i {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 6rem;
        opacity: 0.2;
        transform: rotate(-15deg);
        transition: all 0.3s ease;
    }
    .stat-card:hover i {
        transform: rotate(0deg) scale(1.1);
        opacity: 0.3;
    }
    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        color: #fff;
    }
    .stat-card .label {
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.9);
    }

    /* Gradients */
    .bg-gradient-total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-active { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .bg-gradient-due { background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%); }
    .bg-gradient-completed { background: linear-gradient(135deg, #9d50bb 0%, #6e48aa 100%); }

    .action-card {
        background: #fff;
        border-radius: 15px;
        border: 1px solid #e1e8ef;
        padding: 1.5rem;
        height: 100%;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    .action-card:hover {
        border-color: #667eea;
        background: #f8f9ff;
    }
    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        font-size: 1.5rem;
    }
    .action-details h5 {
        margin: 0;
        font-weight: 700;
        color: #2d3748;
    }
    .action-details p {
        margin: 0;
        color: #718096;
        font-size: 0.9rem;
    }
</style>

<div class="content-body hp-dashboard">
    <div class="hp-header bg-gradient-total">
        <h2>Hire Purchase Performance</h2>
        <p>Monitor your installment plans, track collections, and manage contracts in real-time.</p>
    </div>

    <div class="row">
        <!-- Total Contracts -->
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card stat-card bg-gradient-total">
                <div class="card-body">
                    <div class="label">Total Contracts</div>
                    <h3><?= number_format($stats['total_contracts']) ?></h3>
                    <i class="ft-file-text"></i>
                </div>
            </div>
        </div>

        <!-- Active Plans -->
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card stat-card bg-gradient-active">
                <div class="card-body">
                    <div class="label">Active Plans</div>
                    <h3><?= number_format($stats['active_contracts']) ?></h3>
                    <i class="ft-activity"></i>
                </div>
            </div>
        </div>

        <!-- Due installments -->
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card stat-card bg-gradient-due">
                <div class="card-body">
                    <div class="label">Installments Due</div>
                    <h3><?= number_format($stats['due_installments']) ?></h3>
                    <i class="ft-alert-circle"></i>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card stat-card bg-gradient-completed">
                <div class="card-body">
                    <div class="label">Completed</div>
                    <h3><?= number_format($stats['completed_contracts']) ?></h3>
                    <i class="ft-check-square"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6 mb-2">
            <a href="<?= base_url('hp/create') ?>" class="text-decoration-none">
                <div class="action-card">
                    <div class="action-icon bg-light-primary text-primary">
                        <i class="ft-plus-circle"></i>
                    </div>
                    <div class="action-details">
                        <h5>Create New Contract</h5>
                        <p>Set up a new installment plan for a customer.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-2">
            <a href="<?= base_url('hp/manage') ?>" class="text-decoration-none">
                <div class="action-card">
                    <div class="action-icon bg-light-info text-info">
                        <i class="ft-list"></i>
                    </div>
                    <div class="action-details">
                        <h5>Manage Contracts</h5>
                        <p>View detailed schedules and process payments.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
