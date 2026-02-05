<style>
    /* Premium Theme Colors */
    :root {
        --primary: #4f46e5;
        --critical: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --success: #10b981;
        --dark: #1f2937;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-700: #374151;
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .content-body {
        padding: 2rem;
        background-color: var(--gray-50);
        min-height: 100vh;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title h2 {
        font-weight: 800;
        color: var(--dark);
        margin: 0;
    }

    .test-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: var(--shadow-md);
        background: white;
        transition: transform 0.2s;
        height: 100%;
        overflow: hidden;
    }

    .test-card:hover {
        transform: translateY(-5px);
    }

    .test-card .card-body {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .test-icon {
        width: 64px;
        height: 64px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
    }

    .bg-critical-soft { background-color: #fee2e2; color: #b91c1c; }
    .bg-warning-soft { background-color: #fef3c7; color: #b45309; }
    .bg-primary-soft { background-color: #e0e7ff; color: #4338ca; }

    .test-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 700;
        width: 100%;
        border: none;
        transition: all 0.2s;
    }

    .test-btn:active { transform: scale(0.98); }

    .result-area {
        background-color: #1e293b;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 1rem;
        font-family: 'Fira Code', 'Courier New', monospace;
        font-size: 0.875rem;
        margin-top: 2rem;
        box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06);
        min-height: 300px;
        max-height: 500px;
        overflow-y: auto;
    }

    .result-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #334155;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.5rem;
    }

    .status-success { background-color: #10b981; box-shadow: 0 0 8px #10b981; }
</style>

<div class="content-body">
    <div class="page-header">
        <div class="page-title">
            <h2>System Health & Diagnostics</h2>
            <p class="text-muted">Validate alert logic and inventory data integrity</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-4">
            <div class="test-card">
                <div class="card-body">
                    <div class="test-icon bg-critical-soft">
                        <i class="ft-alert-octagon"></i>
                    </div>
                    <h5 class="font-weight-bold">Critical Check</h5>
                    <p class="text-muted mb-4">Analyzes all products with zero or negative stock. Verifies alert trigger logic for critical shortages.</p>
                    <button class="test-btn btn-danger btn-test" data-type="critical">
                        Verify Logic
                    </button>
                    <div class="mt-3 small" id="mini-res-critical"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="test-card">
                <div class="card-body">
                    <div class="test-icon bg-warning-soft">
                        <i class="ft-alert-circle"></i>
                    </div>
                    <h5 class="font-weight-bold">Warning Level</h5>
                    <p class="text-muted mb-4">Tests threshold detection for items that have dipped below their safety stock levels.</p>
                    <button class="test-btn btn-warning btn-test" data-type="warning">
                        Run Probe
                    </button>
                    <div class="mt-3 small" id="mini-res-warning"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="test-card">
                <div class="card-body">
                    <div class="test-icon bg-primary-soft">
                        <i class="ft-activity"></i>
                    </div>
                    <h5 class="font-weight-bold">Full Audit</h5>
                    <p class="text-muted mb-4">Performs a comprehensive scan of the entire inventory table and alert settings.</p>
                    <button class="test-btn btn-primary btn-test" style="background-color: var(--primary);" data-type="all">
                        Execute Full Audit
                    </button>
                    <div class="mt-3 small" id="mini-res-all"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="result-area">
                <div class="result-header">
                    <div class="d-flex align-items-center">
                        <span class="status-dot status-success"></span>
                        <span class="font-weight-bold">DIAGNOSTIC_OUTPUT.LOG</span>
                    </div>
                    <div class="small text-muted" id="timestamp">Ready</div>
                </div>
                <div id="result-log">
                    <div class="text-muted">Initializing diagnostic environment...</div>
                    <div class="text-muted">Waiting for user input...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-test').click(function() {
        var type = $(this).data('type');
        var button = $(this);
        var resId = '#mini-res-' + type;
        
        button.prop('disabled', true).html('<i class="ft-refresh-cw spinner"></i> Testing...');
        $(resId).html('');
        $('#timestamp').text(new Date().toLocaleTimeString());
        
        var log = $('#result-log');
        log.append('<div class="text-info">> Running ' + type.toUpperCase() + ' diagnostic...</div>');
        
        $.ajax({
            url: '<?php echo base_url("products_alert/run_alert_test"); ?>',
            type: 'POST',
            data: {
                test_type: type,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(response) {
                var data = JSON.parse(response);
                $(resId).html('<span class="text-success font-weight-bold"><i class="ft-check"></i> ' + data.message + '</span>');
                
                log.append('<div class="text-success">>> SUCCESS: ' + data.message + '</div>');
                if (data.data) {
                    log.append('<div class="text-warning">' + JSON.stringify(data.data, null, 2) + '</div>');
                }
                log.scrollTop(log[0].scrollHeight);
            },
            error: function() {
                $(resId).html('<span class="text-danger font-weight-bold">Test Failed</span>');
                log.append('<div class="text-danger">>> ERROR: Connection failed.</div>');
            },
            complete: function() {
                button.prop('disabled', false).html('Run Test');
            }
        });
    });
});
</script>