<?php defined('BASEPATH') OR exit('No direct script access allowed');
$settings = $settings ?? [];
$templates = $templates ?? [];
$platforms = [
    'facebook'   => ['label' => 'Facebook (Meta)', 'icon' => 'fa-facebook', 'color' => '#1877F2'],
    'youtube'    => ['label' => 'YouTube',          'icon' => 'fa-youtube',  'color' => '#FF0000'],
    'tiktok'     => ['label' => 'TikTok',           'icon' => 'fa-tiktok',   'color' => '#69C9D0'],
    'google_tts' => ['label' => 'Google Cloud TTS', 'icon' => 'fa-microphone','color' => '#4285F4'],
    'openai'     => ['label' => 'OpenAI (Captions)','icon' => 'fa-robot',    'color' => '#10A37F'],
];
?>
<div class="container-fluid p-4">
  <div class="page-header mb-4">
    <h2><i class="fa fa-share-alt" style="color: #10b981;"></i> Social Growth Settings</h2>
    <p class="text-muted">Configure API credentials for social media platforms.</p>
  </div>

  <div id="sg-alert" style="display:none;" class="alert alert-success"></div>

  <form id="sg-settings-form">
  <div class="row">
    <?php foreach ($platforms as $key => $p): ?>
    <?php $s = $settings[$key] ?? []; ?>
    <div class="col-md-6 mb-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header d-flex align-items-center" style="background: <?= $p['color'] ?>12; border-bottom: 2px solid <?= $p['color'] ?>;">
          <i class="fa <?= $p['icon'] ?> me-2" style="color:<?= $p['color'] ?>; font-size:1.4rem;"></i>
          <strong><?= $p['label'] ?></strong>
          <?php if (!empty($s['app_id']) || !empty($s['api_key'])): ?>
            <span class="badge bg-success ms-auto">✓ Configured</span>
          <?php else: ?>
            <span class="badge bg-secondary ms-auto">Not Set</span>
          <?php endif; ?>
        </div>
        <div class="card-body">
          <?php if (in_array($key, ['facebook','youtube','tiktok'])): ?>
          <div class="mb-3">
            <label class="form-label fw-semibold">App ID / Client ID</label>
            <input type="text" class="form-control" name="<?= $key ?>_app_id" placeholder="Enter App ID..."
                   value="<?= htmlspecialchars($s['app_id'] ?? '') ?>">
          </div>
          <div class="mb-2">
            <label class="form-label fw-semibold">App Secret / Client Secret</label>
            <input type="password" class="form-control" name="<?= $key ?>_app_secret" placeholder="Enter App Secret..."
                   value="<?= htmlspecialchars($s['app_secret'] ?? '') ?>">
          </div>
          <?php else: ?>
          <div class="mb-2">
            <label class="form-label fw-semibold">API Key</label>
            <input type="password" class="form-control" name="<?= $key ?>_api_key" placeholder="Enter API Key..."
                   value="<?= htmlspecialchars($s['api_key'] ?? '') ?>">
          </div>
          <?php if ($key === 'google_tts'): ?>
          <small class="text-muted">Used for Sinhala voice-over in generated videos (optional)</small>
          <?php elseif ($key === 'openai'): ?>
          <small class="text-muted">GPT-4o mini for AI caption generation (falls back to templates if not set)</small>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Media Storage -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light"><i class="fa fa-server me-2"></i><strong>Media Storage Settings</strong></div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Storage Provider</label>
          <select class="form-select" name="storage_extra" id="storageProvider">
            <option value="local" <?= ($settings['storage']['extra_data'] ?? 'local') === 'local' ? 'selected' : '' ?>>Local Server</option>
            <option value="s3" <?= ($settings['storage']['extra_data'] ?? '') === 's3' ? 'selected' : '' ?>>Amazon S3</option>
          </select>
        </div>
        <div class="col-md-8 s3-fields" id="s3Fields" style="display:none;">
          <div class="row">
            <div class="col-md-4"><input type="text" class="form-control" name="storage_app_id" placeholder="S3 Bucket Name" value="<?= htmlspecialchars($settings['storage']['app_id'] ?? '') ?>"></div>
            <div class="col-md-4"><input type="text" class="form-control" name="storage_app_secret" placeholder="AWS Access Key" value="<?= htmlspecialchars($settings['storage']['app_secret'] ?? '') ?>"></div>
            <div class="col-md-4"><input type="text" class="form-control" name="storage_api_key" placeholder="AWS Secret Key" value="<?= htmlspecialchars($settings['storage']['api_key'] ?? '') ?>"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-lg px-5 text-white" style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); border: none; border-radius: 14px; font-weight: 700;">
    <i class="fa fa-save me-2"></i> Save All Settings
  </button>
  </form>

  <!-- Quick Actions -->
  <div class="row mt-4">
    <div class="col-md-3">
      <a href="<?= base_url('social_growth/admin_templates') ?>" class="card card-body text-center text-decoration-none border-0 shadow-sm hover-lift">
        <i class="fa fa-image fa-2x text-purple mb-2"></i>
        <strong>Manage Templates</strong>
      </a>
    </div>
    <div class="col-md-3">
      <a href="<?= base_url('social_growth/admin_logs') ?>" class="card card-body text-center text-decoration-none border-0 shadow-sm hover-lift">
        <i class="fa fa-chart-bar fa-2x text-info mb-2"></i>
        <strong>View Logs</strong>
      </a>
    </div>
    <div class="col-md-3">
      <a href="<?= base_url('social_growth/admin_leaderboard') ?>" class="card card-body text-center text-decoration-none border-0 shadow-sm hover-lift">
        <i class="fa fa-trophy fa-2x text-warning mb-2"></i>
        <strong>Leaderboard</strong>
      </a>
    </div>
    <div class="col-md-3">
      <a href="<?= base_url('social_growth/run_migration') ?>" class="card card-body text-center text-decoration-none border-0 shadow-sm hover-lift" onclick="return confirm('Run DB migration?')">
        <i class="fa fa-database fa-2x text-secondary mb-2"></i>
        <strong>Run Migration</strong>
      </a>
    </div>
  </div>
</div>

<script>
document.getElementById('storageProvider').addEventListener('change', function(){
    document.getElementById('s3Fields').style.display = this.value === 's3' ? 'flex' : 'none';
});
if (document.getElementById('storageProvider').value === 's3') {
    document.getElementById('s3Fields').style.display = 'flex';
}

document.getElementById('sg-settings-form').addEventListener('submit', function(e){
    e.preventDefault();
    fetch('<?= base_url('social_growth/admin_settings') ?>', {
        method: 'POST',
        body: new FormData(this)
    }).then(r => r.json()).then(d => {
        const el = document.getElementById('sg-alert');
        el.className = 'alert ' + (d.status === 'Success' ? 'alert-success' : 'alert-danger');
        el.textContent = d.message;
        el.style.display = 'block';
        setTimeout(() => el.style.display = 'none', 3500);
    });
});
</script>
