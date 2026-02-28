<?php $this->load->view('shop/styles') ?>
<div class="container section">
  <div style="max-width:640px;margin:0 auto">
    <div class="section-title">📦 Track Your Order</div>
    <div class="section-subtitle">Enter your order number to see the latest status</div>

    <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border);margin-top:20px">
      <form method="GET" action="/newroot/shop/track" style="display:flex;gap:8px">
        <input name="order_number" value="<?= htmlspecialchars($order_number) ?>"
          class="f-input" placeholder="Enter Order Number e.g. TPS-202601-AB12" required>
        <button type="submit" class="btn btn-green" style="white-space:nowrap">
          <i class="fa-solid fa-magnifying-glass"></i> Track
        </button>
      </form>
    </div>

    <?php if ($order_number && !$order): ?>
      <div class="empty-state" style="margin-top:24px">
        <div class="icon"><i class="fa-solid fa-box-open"></i></div>
        <h3>Order Not Found</h3>
        <p>Check your order number and try again.</p>
      </div>

    <?php elseif ($order): ?>
      <?php
        $statuses = ['quote','confirmed','processing','ready','delivered'];
        $current  = array_search($order['status'], $statuses);
        $status_colors = [
          'quote'      => ['#6b7280','#f3f4f6'],
          'confirmed'  => ['#2563eb','#dbeafe'],
          'processing' => ['#d97706','#fef3c7'],
          'ready'      => ['#16a34a','#d1fae5'],
          'delivered'  => ['#059669','#d1fae5'],
          'cancelled'  => ['#dc2626','#fee2e2'],
        ];
        $s = $order['status'] ?? 'quote';
        [$sc, $sbg] = $status_colors[$s] ?? ['#6b7280','#f3f4f6'];
      ?>
      <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border);margin-top:20px">
        <!-- Status headline -->
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
          <div>
            <div style="font-size:.8rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px">Order</div>
            <div style="font-size:1.2rem;font-weight:700"><?= htmlspecialchars($order['order_number']) ?></div>
          </div>
          <div style="background:<?= $sbg ?>;color:<?= $sc ?>;padding:8px 18px;border-radius:100px;font-weight:700;font-size:.9rem;text-transform:uppercase">
            <?= htmlspecialchars($order['status']) ?>
          </div>
        </div>

        <!-- Progress bar -->
        <?php if ($order['status'] !== 'cancelled'): ?>
        <div style="margin-bottom:24px">
          <div style="display:flex;justify-content:space-between;margin-bottom:8px">
            <?php foreach ($statuses as $i => $st): ?>
              <div style="text-align:center;flex:1">
                <div style="width:28px;height:28px;border-radius:50%;margin:0 auto 4px;
                  background:<?= $i <= ($current!==false?$current:-1) ? 'var(--green)' : '#e5e7eb' ?>;
                  display:flex;align-items:center;justify-content:center;
                  color:<?= $i <= ($current!==false?$current:-1) ? '#fff' : '#9ca3af' ?>;font-size:.7rem">
                  <i class="fa-solid fa-check"></i>
                </div>
                <div style="font-size:.68rem;color:<?= $i <= ($current!==false?$current:-1) ? 'var(--green-dark)' : 'var(--text-light)' ?>;font-weight:<?= $i === ($current!==false?$current:-1) ? '700' : '400' ?>">
                  <?= ucfirst($st) ?>
                </div>
              </div>
              <?php if ($i < count($statuses)-1): ?>
                <div style="height:2px;background:<?= $i < ($current!==false?$current:0) ? 'var(--green)':'#e5e7eb' ?>;flex:1;margin-top:14px"></div>
              <?php endif ?>
            <?php endforeach ?>
          </div>
        </div>
        <?php endif ?>

        <!-- Order details -->
        <div style="border:1px solid var(--border);border-radius:8px;overflow:hidden">
          <?php
            $rows = [
              'Customer'  => $order['customer_name'],
              'Phone'     => $order['customer_phone'],
              'Species'   => $order['species'] ?: '—',
              'Qty / Unit'=> $order['quantity'].' '.$order['unit'],
              'Delivery'  => $order['delivery_required'] ? '✅ Yes — '.$order['delivery_address'] : 'No',
              'Placed On' => date('d M Y, g:i A', strtotime($order['created_at'])),
            ];
            if ($order['seller_note']): $rows['Staff Note'] = $order['seller_note']; endif;
          ?>
          <?php foreach ($rows as $k => $v): ?>
            <div style="display:flex;padding:10px 16px;border-bottom:1px solid var(--border);font-size:.88rem">
              <div style="color:var(--text-muted);width:110px;flex-shrink:0"><?= $k ?></div>
              <div style="font-weight:500"><?= htmlspecialchars((string)$v) ?></div>
            </div>
          <?php endforeach ?>
        </div>

        <div style="margin-top:20px;display:flex;gap:8px;flex-wrap:wrap">
          <a href="/newroot/shop" class="btn btn-outline">← Back to Shop</a>
          <a href="/newroot/shop/request_quote" class="btn btn-green">
            <i class="fa-solid fa-file-pen"></i> New Quote Request
          </a>
        </div>
      </div>
    <?php endif ?>
  </div>
</div>
<style>
.f-label{display:block;font-size:.8rem;font-weight:600;color:var(--text-muted);margin-bottom:6px;text-transform:uppercase}
.f-input{flex:1;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-size:.95rem;outline:none;font-family:inherit}
.f-input:focus{border-color:var(--green)}
</style>
