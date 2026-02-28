<?php
$loc = $this->aauth->get_user()->loc;
?>
<style>
    .performance-container {
        padding: 2rem;
        background: #f4f7fe;
        min-height: 100vh;
    }
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
    .card-header {
        background: transparent;
        border-bottom: 1px solid #edf2f7;
        padding: 1.5rem;
    }
    .card-title {
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }
    .metric-row {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .metric-card {
        flex: 1;
        min-width: 250px;
        background: #fff;
        padding: 1.5rem;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-left: 5px solid #3b82f6;
    }
    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1a202c;
    }
    .metric-label {
        color: #718096;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="content-body performance-container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hire Purchase Analytics & Performance</h4>
                </div>
                <div class="card-body">
                    <div class="metric-row">
                        <div class="metric-card" style="border-left-color: #3b82f6;">
                            <span class="metric-label">Total Volume</span>
                            <span class="metric-value"><?= number_format($stats['total_contracts']) ?></span>
                        </div>
                        <div class="metric-card" style="border-left-color: #10b981;">
                            <span class="metric-label">Active Portfolio</span>
                            <span class="metric-value"><?= number_format($stats['active_contracts']) ?></span>
                        </div>
                        <div class="metric-card" style="border-left-color: #f59e0b;">
                            <span class="metric-label">Pending Collection</span>
                            <span class="metric-value"><?= number_format($stats['due_installments']) ?></span>
                        </div>
                        <div class="metric-card" style="border-left-color: #8b5cf6;">
                            <span class="metric-label">Completion Rate</span>
                            <span class="metric-value"><?= ($stats['total_contracts'] > 0) ? round(($stats['completed_contracts'] / $stats['total_contracts']) * 100, 1) : 0 ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- More detailed performance charts can be added here using a library like Chartist or Chart.js -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Monthly Collection Trend</h4>
                </div>
                <div class="card-body" style="height: 300px; display: flex; align-items: center; justify-content: center; background: #fafafa; border-radius: 10px;">
                    <span class="text-muted">Analytics Engine Initializing... [Trend Data Visualization Placeholder]</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Status Distribution</h4>
                </div>
                <div class="card-body" style="height: 300px; display: flex; align-items: center; justify-content: center; background: #fafafa; border-radius: 10px;">
                    <span class="text-muted">[Distribution Chart Placeholder]</span>
                </div>
            </div>
        </div>
    </div>
</div>
