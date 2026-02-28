<!-- Lot Card Partial -->
<?php
$lots_map = [
  'logs'     => ['icon'=>'fa-circle-dot',  'color'=>'#16a34a', 'bg'=>'#dcfce7'],
  'sawn'     => ['icon'=>'fa-layer-group', 'color'=>'#2563eb', 'bg'=>'#dbeafe'],
  'standing' => ['icon'=>'fa-tree',        'color'=>'#92400e', 'bg'=>'#fef3c7'],
];
$t = $lot['lot_type'] ?? 'logs';
$meta = $lots_map[$t] ?? $lots_map['logs'];
$thumb = $lot['thumbnail'] ?? null;
$species = $lot['species'] ?? 'Unknown Species';
$price   = (float)($lot['selling_price'] ?? 0);
$id      = $lot['id'] ?? 0;
$grade   = $lot['grade'] ?? '';
$vol     = (float)($lot['total_volume'] ?? 0);
?>
<div class="lot-card">
  <div class="lot-img">
    <?php if ($thumb): ?>
      <img src="<?= base_url('uploads/timber/'.$thumb) ?>" alt="<?= htmlspecialchars($species) ?>">
    <?php else: ?>
      <div class="no-img"><i class="fa-solid fa-tree"></i></div>
    <?php endif ?>
    <div class="lot-type-badge"><?= ucfirst($t) ?></div>
    <?php if (!empty($lot['is_verified'])): ?>
      <div class="verified-badge"><i class="fa-solid fa-check"></i> Verified</div>
    <?php endif ?>
  </div>
  <div class="lot-body">
    <div class="lot-species"><?= htmlspecialchars($species) ?></div>
    <div class="lot-meta">
      <?php if ($grade): ?><span><i class="fa-solid fa-medal" style="color:var(--gold)"></i> <?= htmlspecialchars($grade) ?></span><?php endif ?>
      <?php if ($vol > 0): ?><span><i class="fa-solid fa-cube" style="color:#6b7280"></i> <?= round($vol,2) ?> cu.ft</span><?php endif ?>
      <?php if (!empty($lot['lot_name'])): ?><span><i class="fa-solid fa-tag" style="color:#6b7280"></i> <?= htmlspecialchars($lot['lot_name']) ?></span><?php endif ?>
    </div>
    <?php if ($price > 0): ?>
      <div class="lot-price">
        LKR <?= number_format($price) ?> <small>/ <?= $t === 'logs' ? 'lot' : 'cu.ft' ?></small>
      </div>
    <?php else: ?>
      <div class="lot-price">Contact for Price</div>
    <?php endif ?>
    <div class="lot-actions">
      <a href="/newroot/shop/view/<?= $t ?>/<?= $id ?>" class="btn btn-outline btn-sm">
        <i class="fa-solid fa-eye"></i> View
      </a>
      <a href="/newroot/shop/request_quote?lot_id=<?= $id ?>&lot_type=<?= $t ?>" class="btn btn-green btn-sm">
        <i class="fa-solid fa-file-lines"></i> Quote
      </a>
    </div>
  </div>
</div>
