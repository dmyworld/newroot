<?php defined('BASEPATH') OR exit('No direct script access allowed');
$templates   = $templates ?? [];
$music_exists= $music_exists ?? false;
$msg         = $msg ?? '';
$slot_names  = [1=>'Direct Sales',2=>'Trust/Review',3=>'Location Focused',4=>'Urgency',5=>'Modern/Minimalist'];
$slot_descs  = [
    1=>'Large product image with prominent price badge.',
    2=>'Customer ratings and review-style overlay.',
    3=>'District-focused: "දැන් [location]ට [$species]"',
    4=>'Red urgency style: "සීමිත තොගයක්!"',
    5=>'Clean white minimalist professional design.',
];
$slot_colors = [1=>'primary',2=>'warning',3=>'success',4=>'danger',5=>'secondary'];

// Index by slot
$tpl_by_slot = [];
foreach ($templates as $t) $tpl_by_slot[$t['slot']] = $t;
?>
<div class="container-fluid p-4">
  <div class="page-header mb-4">
    <h2><i class="fa fa-image text-primary"></i> Poster Template Manager</h2>
    <p class="text-muted">Upload background images for each of the 5 design templates. These are used to generate social media posters.</p>
  </div>

  <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

  <div class="row g-4 mb-5">
  <?php for ($slot = 1; $slot <= 5; $slot++): ?>
  <?php $t = $tpl_by_slot[$slot] ?? null; ?>
  <div class="col-md-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-<?= $slot_colors[$slot] ?> text-white d-flex align-items-center">
        <span class="badge bg-white text-<?= $slot_colors[$slot] ?> me-2"><?= $slot ?></span>
        <strong><?= $slot_names[$slot] ?></strong>
      </div>
      <?php if ($t && !empty($t['file_path'])): ?>
      <img src="<?= base_url($t['file_path']) ?>" class="card-img-top" style="height:180px;object-fit:cover;" onerror="this.style.display='none'">
      <?php else: ?>
      <div style="height:180px;background:linear-gradient(135deg,#f8f9fa,#dee2e6);display:flex;align-items:center;justify-content:center;">
        <i class="fa fa-image fa-3x text-muted"></i>
      </div>
      <?php endif; ?>
      <div class="card-body">
        <p class="text-muted small mb-3"><?= $slot_descs[$slot] ?></p>
        <form method="POST" action="<?= base_url('social_growth/admin_templates') ?>" enctype="multipart/form-data">
          <input type="hidden" name="action" value="upload_template">
          <input type="hidden" name="slot" value="<?= $slot ?>">
          <input type="hidden" name="name" value="<?= $slot_names[$slot] ?>">
          <div class="mb-2">
            <input type="file" class="form-control form-control-sm" name="template_img" accept=".jpg,.jpeg,.png" required>
            <small class="text-muted">JPG/PNG, 1080×1080px recommended</small>
          </div>
          <button type="submit" class="btn btn-<?= $slot_colors[$slot] ?> btn-sm w-100">
            <i class="fa fa-upload me-1"></i> <?= $t ? 'Replace' : 'Upload' ?> Template <?= $slot ?>
          </button>
        </form>
        <?php if ($t): ?>
        <button class="btn btn-outline-danger btn-sm w-100 mt-2 delete-tpl-btn" data-id="<?= $t['id'] ?>" data-slot="<?= $slot ?>">
          <i class="fa fa-trash me-1"></i> Remove Template
        </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endfor; ?>
  </div>

  <!-- Background Music Upload -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
      <i class="fa fa-music me-2"></i> <strong>Background Music for Videos</strong>
      <?php if ($music_exists): ?>
        <span class="badge bg-success ms-2">✓ Music uploaded</span>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <form method="POST" action="<?= base_url('social_growth/admin_templates') ?>" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload_music">
        <div class="d-flex align-items-center gap-3">
          <input type="file" class="form-control" name="bg_music" accept=".mp3,.ogg,.wav" style="max-width:300px;" required>
          <button type="submit" class="btn btn-dark px-4"><i class="fa fa-upload me-2"></i>Upload Music</button>
          <?php if ($music_exists): ?>
          <audio controls style="max-width:250px;">
            <source src="<?= base_url('userfiles/social_templates/bg_music.mp3') ?>" type="audio/mpeg">
          </audio>
          <?php endif; ?>
        </div>
        <small class="text-muted d-block mt-2">Royalty-free background music MP3 for promo videos (max 10MB)</small>
      </form>
    </div>
  </div>

  <!-- Preview Section -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-light"><i class="fa fa-eye me-2"></i><strong>Template Design Overview</strong></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-dark">
            <tr><th>#</th><th>Template</th><th>Design Style</th><th>Status</th></tr>
          </thead>
          <tbody>
            <?php for ($s = 1; $s <= 5; $s++): ?>
            <tr>
              <td><span class="badge bg-<?= $slot_colors[$s] ?>"><?= $s ?></span></td>
              <td><strong><?= $slot_names[$s] ?></strong></td>
              <td><small class="text-muted"><?= $slot_descs[$s] ?></small></td>
              <td>
                <?php if (isset($tpl_by_slot[$s])): ?>
                  <span class="badge bg-success">✓ Ready</span>
                <?php else: ?>
                  <span class="badge bg-secondary">No Image (GD Fallback)</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endfor; ?>
          </tbody>
        </table>
      </div>
      <small class="text-info"><i class="fa fa-info-circle me-1"></i>If no template image is uploaded, the system uses an auto-generated color background from PHP GD.</small>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.delete-tpl-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        if (!confirm('Remove template ' + this.dataset.slot + '?')) return;
        fetch('<?= base_url('social_growth/admin_templates') ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=delete_template&id=' + this.dataset.id
        }).then(r => r.json()).then(d => {
            if (d.status === 'Success') location.reload();
        });
    });
});
</script>
