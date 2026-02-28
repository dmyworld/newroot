<?php $this->load->view('shop/styles') ?>
<div class="container section">
  <div style="max-width:720px;margin:0 auto">
    <div class="section-title">📄 Request a Quote</div>
    <div class="section-subtitle">Fill in your requirements — we'll respond within 24 hours</div>

    <div style="background:#fff;border-radius:var(--radius);padding:32px;box-shadow:var(--shadow);border:1px solid var(--border);margin-top:20px">
      <form id="quote-form">
        <?php if ($lot): ?>
          <div style="background:var(--green-light);border:1px solid #bbf7d0;border-radius:8px;padding:14px 16px;margin-bottom:20px;display:flex;gap:12px;align-items:center">
            <i class="fa-solid fa-tree" style="color:var(--green);font-size:1.3rem"></i>
            <div>
              <div style="font-weight:700;font-size:.95rem"><?= htmlspecialchars($lot['species'] ?? 'Selected Lot') ?></div>
              <div style="font-size:.8rem;color:var(--text-muted)"><?= ucfirst($lot_type) ?> • <?= htmlspecialchars($lot['lot_name'] ?? '') ?></div>
            </div>
          </div>
        <?php endif ?>

        <input type="hidden" name="lot_id"   value="<?= isset($lot) ? ($lot['id']??0) : '' ?>">
        <input type="hidden" name="lot_type" value="<?= htmlspecialchars($lot_type) ?>">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
          <div>
            <label class="f-label">Your Name *</label>
            <input name="customer_name" class="f-input" required placeholder="Full name">
          </div>
          <div>
            <label class="f-label">Phone / WhatsApp *</label>
            <input name="customer_phone" class="f-input" required type="tel" placeholder="07XXXXXXXX">
          </div>
          <div>
            <label class="f-label">Email</label>
            <input name="customer_email" class="f-input" type="email" placeholder="you@email.com">
          </div>
          <div>
            <label class="f-label">Address / Location</label>
            <input name="customer_address" class="f-input" placeholder="City or Address">
          </div>
        </div>

        <hr style="margin:20px 0;border-color:var(--border)">
        <div style="font-weight:600;font-size:.95rem;margin-bottom:14px">🪵 Timber Requirements</div>

        <?php if (!$lot): ?>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
          <div>
            <label class="f-label">Species *</label>
            <select name="species" class="f-input" required>
              <option value="">-- Select Species --</option>
              <?php foreach ($wood_types as $wt): ?>
                <option><?= htmlspecialchars($wt['name'] ?? $wt['wood_name'] ?? '') ?></option>
              <?php endforeach ?>
              <option value="Teak">Teak</option>
              <option value="Kos">Kos</option>
              <option value="Mahogany">Mahogany</option>
              <option value="Nadun">Nadun</option>
              <option value="Other">Other (describe below)</option>
            </select>
          </div>
          <div>
            <label class="f-label">Type</label>
            <select name="lot_type" class="f-input">
              <option value="logs">Round Logs</option>
              <option value="sawn">Sawn Timber</option>
              <option value="standing">Standing Timber</option>
            </select>
          </div>
        </div>
        <?php else: ?>
          <input type="hidden" name="species" value="<?= htmlspecialchars($lot['species'] ?? '') ?>">
        <?php endif ?>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px">
          <div>
            <label class="f-label">Thickness (Inches)</label>
            <input name="thickness_inches" class="f-input" type="number" step="0.25" placeholder="e.g. 2">
          </div>
          <div>
            <label class="f-label">Width (Inches)</label>
            <input name="width_inches" class="f-input" type="number" step="0.25" placeholder="e.g. 8">
          </div>
          <div>
            <label class="f-label">Length (Feet)</label>
            <input name="length_ft" class="f-input" type="number" step="0.5" placeholder="e.g. 10">
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
          <div>
            <label class="f-label">Quantity</label>
            <input name="quantity" class="f-input" type="number" value="1" min="1">
          </div>
          <div>
            <label class="f-label">Unit</label>
            <select name="unit" class="f-input">
              <option value="pieces">Pieces</option>
              <option value="cubic_ft">Cubic Feet</option>
              <option value="sq_ft">Square Feet</option>
              <option value="loads">Loads</option>
            </select>
          </div>
        </div>

        <div>
          <label class="f-label">Special Requirements</label>
          <textarea name="custom_size_note" class="f-input" rows="3" style="resize:vertical" placeholder="Any custom dimensions, grade requirements, delivery needs..."></textarea>
        </div>

        <hr style="margin:20px 0;border-color:var(--border)">
        <div style="display:flex;gap:16px;align-items:center;margin-bottom:16px;flex-wrap:wrap">
          <div style="flex:1">
            <label class="f-label">Payment Method</label>
            <select name="payment_method" class="f-input">
              <option value="cash">Cash</option>
              <option value="bank_transfer">Bank Transfer</option>
            </select>
          </div>
          <div style="flex:1">
            <label class="f-label" style="margin-bottom:12px">Delivery Required?</label>
            <div style="display:flex;gap:12px">
              <label style="display:flex;gap:6px;align-items:center;cursor:pointer">
                <input type="checkbox" name="delivery_required" value="1" id="need-delivery" onchange="toggleDelivery(this)"> Yes, I need delivery
              </label>
            </div>
          </div>
        </div>

        <div id="delivery-address" style="display:none;margin-bottom:16px">
          <label class="f-label">Delivery Address</label>
          <textarea name="delivery_address" class="f-input" rows="2" placeholder="Full delivery address..."></textarea>
        </div>

        <textarea name="customer_note" class="f-input" rows="2" placeholder="Any other notes..." style="margin-bottom:16px"></textarea>

        <button type="submit" class="btn btn-green btn-lg btn-block">
          <i class="fa-solid fa-paper-plane"></i> Submit Quote Request
        </button>
        <p style="text-align:center;color:var(--text-muted);font-size:.8rem;margin-top:12px">
          <i class="fa-solid fa-lock"></i> Your information is secure. We respond within 24 hours.
        </p>
      </form>
    </div>

    <!-- Success message -->
    <div id="quote-success" style="display:none;background:#f0fdf4;border:1px solid #86efac;border-radius:var(--radius);padding:32px;text-align:center;margin-top:20px">
      <div style="font-size:3rem;margin-bottom:12px">✅</div>
      <h3 style="font-size:1.2rem;margin-bottom:8px;color:var(--green-dark)">Quote Request Sent!</h3>
      <p style="color:var(--text-muted);margin-bottom:16px">Your order number: <strong id="order-num" style="color:var(--green-dark)"></strong></p>
      <a href="#" id="track-link" class="btn btn-green">
        <i class="fa-solid fa-location-dot"></i> Track Order
      </a>
      <a href="/newroot/shop" class="btn btn-outline" style="margin-left:8px">Continue Browsing</a>
    </div>
  </div>
</div>

<style>
.f-label{display:block;font-size:.8rem;font-weight:600;color:var(--text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.f-input{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-size:.95rem;outline:none;font-family:inherit;transition:.15s}
.f-input:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(30,124,58,.1)}
</style>

<script>
function toggleDelivery(cb) {
  document.getElementById('delivery-address').style.display = cb.checked ? '' : 'none';
}

document.getElementById('quote-form').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  const btn = this.querySelector('button[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';

  fetch('/newroot/shop/submit_quote', { method:'POST', body:fd })
    .then(r=>r.json())
    .then(d => {
      if (d.status === 'Success') {
        document.getElementById('quote-form').style.display = 'none';
        document.getElementById('quote-success').style.display = '';
        document.getElementById('order-num').textContent = d.order_number;
        document.getElementById('track-link').href = '/newroot/shop/track/' + d.order_number;
      } else {
        alert('Error: ' + (d.message || 'Something went wrong'));
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit Quote Request';
      }
    });
});
</script>
