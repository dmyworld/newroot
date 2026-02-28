<?php defined('BASEPATH') OR exit('No direct script access allowed');
$logs = $logs ?? [];
?>
<div class="container-fluid p-4">
  <div class="page-header mb-4">
    <h2><i class="fa fa-chart-bar text-info"></i> Social Growth Logs</h2>
    <p class="text-muted">Usage and share activity across all users and platforms.</p>
  </div>

  <!-- Summary Cards -->
  <?php
    $total      = count($logs);
    $success    = count(array_filter($logs, fn($l) => $l['status'] === 'success'));
    $failed     = count(array_filter($logs, fn($l) => $l['status'] === 'failed'));
    $platforms  = array_unique(array_column($logs, 'platform'));
  ?>
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card border-0 bg-primary text-white shadow-sm">
        <div class="card-body text-center">
          <div class="fs-1 fw-bold"><?= $total ?></div>
          <div>Total Share Events</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 bg-success text-white shadow-sm">
        <div class="card-body text-center">
          <div class="fs-1 fw-bold"><?= $success ?></div>
          <div>Successful Shares</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 bg-danger text-white shadow-sm">
        <div class="card-body text-center">
          <div class="fs-1 fw-bold"><?= $failed ?></div>
          <div>Failed Attempts</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 bg-info text-white shadow-sm">
        <div class="card-body text-center">
          <div class="fs-1 fw-bold"><?= count($platforms) ?></div>
          <div>Platforms Active</div>
        </div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <strong>Share Activity Log</strong>
      <input type="text" id="logSearch" class="form-control form-control-sm w-25" placeholder="Search...">
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0" id="sgLogsTable">
          <thead class="table-dark">
            <tr>
              <th>User</th>
              <th>Ad ID</th>
              <th>Platform</th>
              <th>Status</th>
              <th>Referral Token</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($logs as $l): ?>
            <tr>
              <td><i class="fa fa-user me-1"></i><?= htmlspecialchars($l['username'] ?? 'User #' . $l['user_id']) ?></td>
              <td><a href="<?= base_url('shop/view/' . ($l['ad_type'] ?? 'logs') . '/' . $l['ad_id']) ?>" target="_blank">#<?= $l['ad_id'] ?></a></td>
              <td>
                <?php $icons = ['facebook'=>'fa-facebook text-primary','youtube'=>'fa-youtube text-danger','tiktok'=>'fa-tiktok','whatsapp'=>'fa-whatsapp text-success','system_reminder'=>'fa-bell text-warning']; ?>
                <i class="fa <?= $icons[$l['platform']] ?? 'fa-share' ?> me-1"></i>
                <?= ucfirst($l['platform']) ?>
              </td>
              <td>
                <?php if ($l['status'] === 'success'): ?>
                  <span class="badge bg-success">✓ Success</span>
                <?php elseif ($l['status'] === 'failed'): ?>
                  <span class="badge bg-danger" title="<?= htmlspecialchars($l['error_msg'] ?? '') ?>">✗ Failed</span>
                <?php else: ?>
                  <span class="badge bg-secondary"><?= ucfirst($l['status']) ?></span>
                <?php endif; ?>
              </td>
              <td><code class="small"><?= htmlspecialchars(substr($l['referral_token'] ?? '', 0, 12)) ?>...</code></td>
              <td><small class="text-muted"><?= date('d M H:i', strtotime($l['created_at'])) ?></small></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($logs)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">No share logs yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('logSearch').addEventListener('keyup', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('#sgLogsTable tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
