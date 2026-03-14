<?php
$summary = $summary ?? [];
$records = $records ?? [];
$pending_count = count(array_filter($records, fn($r) => $r['status'] === 'pending'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Commission Engine · Super Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.13.6/js/jquery.dataTables.min.js"></script>

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #f8fafc; font-family: 'Inter', -apple-system, sans-serif; color: #1e293b; }
.page-wrapper { max-width: 1400px; margin: 0 auto; padding: 32px 24px; }

/* Header */
.page-header { margin-bottom: 32px; }
.page-header h1 { font-size: 2rem; font-weight: 900; letter-spacing: -.04em; color: #0f172a; }
.page-header p  { color: #64748b; margin-top: 4px; font-size: .875rem; }

/* Summary Cards */
.summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px; }
.summary-card {
    background: #fff; border-radius: 20px; padding: 24px;
    border: 1.5px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
    transition: all .3s ease;
}
.summary-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(0,0,0,.08); }
.summary-card .label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .1em; color: #94a3b8; margin-bottom: 10px; }
.summary-card .value { font-size: 1.75rem; font-weight: 900; color: #0f172a; line-height: 1; }
.summary-card .value.green  { color: #059669; }
.summary-card .value.orange { color: #d97706; }
.summary-card .value.blue   { color: #2563eb; }
.summary-card .icon-wrap { width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; font-size: 18px; }
.icon-green  { background: #ecfdf5; color: #059669; }
.icon-orange { background: #fffbeb; color: #d97706; }
.icon-blue   { background: #eff6ff; color: #2563eb; }
.icon-purple { background: #f5f3ff; color: #7c3aed; }

/* Action Bar */
.action-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
.action-bar .btn-group button {
    padding: 10px 20px; border-radius: 12px; border: 1.5px solid #e2e8f0;
    font-weight: 800; font-size: 12px; cursor: pointer; transition: all .2s;
    background: #fff; color: #475569;
}
.action-bar .btn-group button.active { background: #1e293b; border-color: #1e293b; color: #fff; }
.action-bar .btn-group button:hover:not(.active) { border-color: #94a3b8; color: #1e293b; }
.btn-settle-all {
    background: linear-gradient(135deg, #059669, #10b981);
    color: #fff; border: none; padding: 11px 22px; border-radius: 14px;
    font-weight: 900; font-size: 13px; cursor: pointer;
    box-shadow: 0 4px 14px rgba(5,150,105,.3); transition: all .3s;
}
.btn-settle-all:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(5,150,105,.4); }

/* Table */
.table-card { background: #fff; border-radius: 24px; border: 1.5px solid #f1f5f9; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.04); }
.table-card-header { padding: 22px 28px; border-bottom: 1.5px solid #f8fafc; display: flex; align-items: center; justify-content: space-between; }
.table-card-header h3 { font-size: 1rem; font-weight: 900; color: #0f172a; }
.table-wrap { padding: 0 12px 20px; overflow-x: auto; }

table.dataTable thead th { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: #94a3b8; border-bottom: 1.5px solid #f1f5f9 !important; padding: 14px 12px; white-space: nowrap; }
table.dataTable tbody td { padding: 14px 12px; font-size: 13px; font-weight: 600; color: #334155; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
table.dataTable tbody tr:hover td { background: #f8fafc; }

.badge { padding: 4px 10px; border-radius: 999px; font-size: 10px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; display: inline-block; }
.badge-success   { background: #ecfdf5; color: #059669; }
.badge-warning   { background: #fffbeb; color: #d97706; }
.badge-secondary { background: #f1f5f9; color: #64748b; }

.btn-xs { padding: 5px 11px; border: none; border-radius: 9px; font-size: 11px; font-weight: 800; cursor: pointer; transition: all .2s; }
.btn-xs.btn-success { background: #ecfdf5; color: #059669; }
.btn-xs.btn-success:hover { background: #059669; color: #fff; }
.btn-xs.btn-secondary { background: #f1f5f9; color: #64748b; }
.btn-xs.btn-secondary:hover { background: #e2e8f0; }
.mr-1 { margin-right: 4px; }

/* Toast */
#toast { position: fixed; bottom: 28px; right: 28px; z-index: 9999; background: #0f172a; color: #fff; padding: 14px 22px; border-radius: 16px; font-size: 13px; font-weight: 700; box-shadow: 0 8px 28px rgba(0,0,0,.2); transform: translateY(80px); opacity: 0; transition: all .35s ease; pointer-events: none; }
#toast.show { transform: translateY(0); opacity: 1; }
</style>
</head>
<body>
<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
            <div style="width:48px;height:48px;background:linear-gradient(135deg,#7c3aed,#6366f1);border-radius:16px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;">
                <i class="fa fa-percentage"></i>
            </div>
            <div>
                <h1>Commission Engine</h1>
                <p>Automated platform revenue splits from all marketplace sales</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="icon-wrap icon-blue"><i class="fa fa-shopping-cart"></i></div>
            <div class="label">Total Sales Volume</div>
            <div class="value blue">Rs. <?= number_format($summary['total_sales'] ?? 0) ?></div>
        </div>
        <div class="summary-card">
            <div class="icon-wrap icon-purple"><i class="fa fa-percentage"></i></div>
            <div class="label">Total Commission Earned</div>
            <div class="value" style="color:#7c3aed">Rs. <?= number_format($summary['total_commission'] ?? 0) ?></div>
        </div>
        <div class="summary-card">
            <div class="icon-wrap icon-orange"><i class="fa fa-clock"></i></div>
            <div class="label">Pending Collection</div>
            <div class="value orange">Rs. <?= number_format($summary['pending_commission'] ?? 0) ?></div>
        </div>
        <div class="summary-card">
            <div class="icon-wrap icon-green"><i class="fa fa-check-circle"></i></div>
            <div class="label">Total Settled</div>
            <div class="value green">Rs. <?= number_format($summary['settled_commission'] ?? 0) ?></div>
        </div>
        <div class="summary-card">
            <div class="icon-wrap" style="background:#f0fdf4;color:#16a34a"><i class="fa fa-handshake"></i></div>
            <div class="label">Seller Payouts</div>
            <div class="value" style="color:#16a34a">Rs. <?= number_format($summary['total_payouts'] ?? 0) ?></div>
        </div>
        <div class="summary-card">
            <div class="icon-wrap" style="background:#eff6ff;color:#1d4ed8"><i class="fa fa-file-invoice"></i></div>
            <div class="label">Total Records</div>
            <div class="value blue"><?= number_format($summary['total_records'] ?? 0) ?></div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <div class="btn-group" id="filterGroup">
            <button class="active" onclick="filterStatus('', this)">All</button>
            <button onclick="filterStatus('pending', this)">Pending</button>
            <button onclick="filterStatus('settled', this)">Settled</button>
            <button onclick="filterStatus('waived', this)">Waived</button>
        </div>
        <button class="btn-settle-all" onclick="settleAll()">
            <i class="fa fa-check-double mr-1"></i> Settle All Pending
        </button>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-card-header">
            <h3>Commission Records</h3>
            <span style="font-size:12px;color:#94a3b8;font-weight:700"><?= ($summary['total_records'] ?? 0) ?> total records</span>
        </div>
        <div class="table-wrap">
            <table id="commTable" class="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Seller</th>
                        <th>Sale Total</th>
                        <th>Rate</th>
                        <th>Commission</th>
                        <th>Payout</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>

<!-- Toast -->
<div id="toast"></div>

<script>
var currentStatus = '';

var table = $('#commTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '<?= base_url('commission_engine/ajax_list') ?>',
        type: 'POST',
        data: function(d) { d.status = currentStatus; }
    },
    columns: [
        {data:0},{data:1},{data:2},{data:3},{data:4},{data:5},{data:6},
        {data:7},{data:8},{data:9,orderable:false}
    ],
    pageLength: 25,
    order: [[0,'desc']],
    dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-5'i><'col-sm-7'p>>",
    language: { processing: '<div style="padding:30px;text-align:center;color:#94a3b8;font-weight:700">Loading...</div>' }
});

function filterStatus(status, btn) {
    currentStatus = status;
    document.querySelectorAll('#filterGroup button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    table.ajax.reload();
}

function settleCommission(id) {
    fetch('<?= base_url('commission_engine/settle') ?>', {
        method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + id
    }).then(r=>r.json()).then(d => {
        showToast(d.status === 'Success' ? '✅ Commission settled!' : '❌ Failed.');
        if (d.status === 'Success') table.ajax.reload();
    });
}

function waiveCommission(id) {
    if (!confirm('Waive this commission? This cannot be undone.')) return;
    fetch('<?= base_url('commission_engine/waive') ?>', {
        method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + id
    }).then(r=>r.json()).then(d => {
        showToast(d.status === 'Success' ? '✅ Commission waived.' : '❌ Failed.');
        if (d.status === 'Success') table.ajax.reload();
    });
}

function settleAll() {
    if (!confirm('Settle ALL pending commissions at once?')) return;
    fetch('<?= base_url('commission_engine/settle_all') ?>', { method: 'POST' })
        .then(r=>r.json())
        .then(d => {
            showToast('✅ ' + (d.count || 0) + ' commissions settled!');
            table.ajax.reload();
            setTimeout(() => location.reload(), 1500);
        });
}

function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3500);
}
</script>
</body>
</html>
