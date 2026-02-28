<?php
// admin_orders.php — loaded in the existing fixed/header/footer layout
?>
<div class="page-wrapper">
<div class="container-fluid">

<div class="row page-titles">
  <div class="col-md-6 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Consumer Orders</h3>
    <ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active">Consumer Orders</li></ol>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <!-- Filter buttons -->
    <div class="card">
      <div class="card-body">
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;justify-content:space-between">
          <div style="display:flex;gap:6px;flex-wrap:wrap">
            <?php foreach ([''=>'All','quote'=>'Quote','confirmed'=>'Confirmed','processing'=>'Processing','ready'=>'Ready','delivered'=>'Delivered','cancelled'=>'Cancelled'] as $v=>$l): ?>
              <a href="?status=<?= $v ?>"
                class="btn <?= $status_filter===$v ? 'btn-primary':'btn-outline-secondary' ?> btn-sm">
                <?= $l ?>
              </a>
            <?php endforeach ?>
          </div>
          <input type="text" id="search-orders" class="form-control form-control-sm" style="width:220px" placeholder="Search name / phone...">
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0" id="orders-table">
          <thead class="thead-dark">
            <tr>
              <th>#Order</th><th>Customer</th><th>Phone</th>
              <th>Species</th><th>Qty</th><th>Delivery</th>
              <th>Status</th><th>Date</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($orders)): ?>
              <tr><td colspan="9" class="text-center py-4 text-muted">No orders found</td></tr>
            <?php else: ?>
              <?php
                $badge = [
                  'quote'=>'secondary','confirmed'=>'primary','processing'=>'warning',
                  'ready'=>'success','delivered'=>'success','cancelled'=>'danger',
                ];
              ?>
              <?php foreach ($orders as $o): ?>
                <tr>
                  <td><strong><?= htmlspecialchars($o['order_number']) ?></strong></td>
                  <td><?= htmlspecialchars($o['customer_name']) ?></td>
                  <td><a href="tel:<?= $o['customer_phone'] ?>"><?= htmlspecialchars($o['customer_phone']) ?></a></td>
                  <td><?= htmlspecialchars($o['species'] ?: '—') ?></td>
                  <td><?= $o['quantity'].' '.$o['unit'] ?></td>
                  <td><?= $o['delivery_required'] ? '<i class="fa fa-truck text-primary"></i>' : '—' ?></td>
                  <td>
                    <span class="badge badge-<?= $badge[$o['status']] ?? 'secondary' ?>">
                      <?= ucfirst($o['status']) ?>
                    </span>
                  </td>
                  <td><?= date('d M', strtotime($o['created_at'])) ?></td>
                  <td>
                    <button class="btn btn-xs btn-warning" onclick="updateStatus(<?= $o['id'] ?>,this)">
                      Update
                    </button>
                    <a href="/newroot/shop/track/<?= $o['order_number'] ?>" target="_blank"
                       class="btn btn-xs btn-info">Track</a>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div><!-- /row -->
</div><!-- /container -->
</div><!-- /page-wrapper -->

<!-- Update Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Update Order Status</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="modal-order-id">
        <div class="form-group">
          <label>New Status</label>
          <select class="form-control" id="modal-status">
            <option value="quote">Quote</option>
            <option value="confirmed">Confirmed</option>
            <option value="processing">Processing</option>
            <option value="ready">Ready for Collection</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <div class="form-group">
          <label>Note to Customer</label>
          <textarea class="form-control" id="modal-note" rows="3" placeholder="Optional seller note..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="saveStatus()">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<script>
function updateStatus(id, btn) {
  document.getElementById('modal-order-id').value = id;
  document.getElementById('modal-note').value = '';
  $('#statusModal').modal('show');
}

function saveStatus() {
  const id   = document.getElementById('modal-order-id').value;
  const st   = document.getElementById('modal-status').value;
  const note = document.getElementById('modal-note').value;
  fetch('<?= base_url('shop/update_order_status') ?>', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'order_id='+id+'&status='+st+'&seller_note='+encodeURIComponent(note)
  })
  .then(r=>r.json()).then(d=>{
    $('#statusModal').modal('hide');
    location.reload();
  });
}

// Live search
document.getElementById('search-orders').addEventListener('input', function() {
  const val = this.value.toLowerCase();
  document.querySelectorAll('#orders-table tbody tr').forEach(r => {
    r.style.display = r.textContent.toLowerCase().includes(val) ? '' : 'none';
  });
});
</script>
