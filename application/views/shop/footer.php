<footer style="background:#1a1a1a;color:#9ca3af;padding:48px 0 24px;margin-top:48px">
  <div class="container">
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:32px;flex-wrap:wrap">
      <div>
        <div style="font-family:'Libre Baskerville',serif;font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:12px">
          🌿 TimberPro Shop
        </div>
        <p style="font-size:.85rem;line-height:1.6">
          Sri Lanka's trusted timber marketplace. Buy verified logs, sawn timber and standing timber directly from certified suppliers.
        </p>
        <div style="display:flex;gap:12px;margin-top:16px">
          <a href="#" style="color:#4b5563;font-size:1.2rem;text-decoration:none"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" style="color:#4b5563;font-size:1.2rem;text-decoration:none"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
      </div>
      <div>
        <div style="font-size:.8rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">Browse</div>
        <?php foreach (['?type=logs'=>'Round Logs','?type=sawn'=>'Sawn Timber','?type=standing'=>'Standing Timber','?grade=A'=>'Grade A Premium'] as $href=>$label): ?>
          <a href="/newroot/shop/<?= $href ?>" style="display:block;color:#9ca3af;text-decoration:none;font-size:.875rem;margin-bottom:8px;transition:.15s"
             onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#9ca3af'"><?= $label ?></a>
        <?php endforeach ?>
      </div>
      <div>
        <div style="font-size:.8rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">Tools</div>
        <?php foreach (['/newroot/shop/calculator'=>'Volume Calculator','/newroot/shop/request_quote'=>'Get Quote','/newroot/shop/track'=>'Track Order','/newroot/dashboard'=>'Seller Dashboard'] as $href=>$label): ?>
          <a href="<?= $href ?>" style="display:block;color:#9ca3af;text-decoration:none;font-size:.875rem;margin-bottom:8px;transition:.15s"
             onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#9ca3af'"><?= $label ?></a>
        <?php endforeach ?>
      </div>
      <div>
        <div style="font-size:.8rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">Contact</div>
        <a href="tel:0712345678" style="display:flex;gap:8px;color:#9ca3af;text-decoration:none;font-size:.875rem;margin-bottom:8px;align-items:center">
          <i class="fa-solid fa-phone"></i> 071 234 5678
        </a>
        <a href="https://wa.me/94712345678" style="display:flex;gap:8px;color:#9ca3af;text-decoration:none;font-size:.875rem;margin-bottom:8px;align-items:center">
          <i class="fa-brands fa-whatsapp"></i> WhatsApp Chat
        </a>
        <div style="display:flex;gap:8px;font-size:.875rem;margin-top:12px;align-items:center">
          <i class="fa-solid fa-clock"></i> Mon–Sat 8AM–6PM
        </div>
      </div>
    </div>
    <div style="border-top:1px solid #374151;padding-top:20px;text-align:center;font-size:.8rem">
      © <?= date('Y') ?> TimberPro. All rights reserved. •
      <a href="/newroot/dashboard" style="color:#4b5563;text-decoration:none">Staff Login</a>
    </div>
  </div>
</footer>

<div class="toast" id="global-toast"><span id="toast-msg"></span></div>

<script>
function showToast(msg, type='success') {
  const t = document.getElementById('global-toast');
  document.getElementById('toast-msg').textContent = msg;
  t.className = 'toast show ' + type;
  setTimeout(() => t.className = 'toast', 3500);
}
</script>
</body></html>
