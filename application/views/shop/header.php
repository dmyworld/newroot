<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $title ?? 'TimberPro Shop' ?></title>

<!-- Open Graph / Facebook / WhatsApp -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $og_url ?? current_url() ?>">
<meta property="og:title" content="<?= $og_title ?? ($title ?? 'TimberPro Shop') ?>">
<meta property="og:description" content="<?= $og_description ?? 'The leading timber marketplace in Sri Lanka. Connect with verified sellers and buyers.' ?>">
<meta property="og:image" content="<?= $og_image ?? base_url('assets/images/og-default.jpg') ?>">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?= $og_url ?? current_url() ?>">
<meta property="twitter:title" content="<?= $og_title ?? ($title ?? 'TimberPro Shop') ?>">
<meta property="twitter:description" content="<?= $og_description ?? 'The leading timber marketplace in Sri Lanka. Connect with verified sellers and buyers.' ?>">
<meta property="twitter:image" content="<?= $og_image ?? base_url('assets/images/og-default.jpg') ?>">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Libre+Baskerville:wght@400;700&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{
  --green:#1e7c3a;--green-dark:#155c2b;--green-light:#e8f5ec;
  --brown:#7b4a1e;--brown-light:#fdf0e0;
  --gold:#d4a017;--gold-light:#fdf4d7;
  --text:#1a1a1a;--text-muted:#6b7280;--text-light:#9ca3af;
  --bg:#f9f9f7;--card:#fff;--border:#e5e7eb;
  --shadow:0 1px 3px rgba(0,0,0,.08),0 4px 16px rgba(0,0,0,.04);
  --shadow-hover:0 4px 24px rgba(0,0,0,.12);
  --radius:12px;--radius-sm:8px;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh}

/* ---- NAV ---- */
.shop-nav{
  background:#fff;border-bottom:1px solid var(--border);
  position:sticky;top:0;z-index:100;padding:0 24px;
}
.nav-inner{
  max-width:1240px;margin:0 auto;
  display:flex;align-items:center;justify-content:space-between;height:64px;
}
.nav-logo{
  display:flex;align-items:center;gap:10px;text-decoration:none;
  font-family:'Libre Baskerville',serif;font-weight:700;font-size:1.3rem;color:var(--green-dark);
}
.nav-logo .icon{width:36px;height:36px;background:var(--green);border-radius:8px;
  display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px}
.nav-links{display:flex;align-items:center;gap:4px}
.nav-link{
  padding:8px 14px;border-radius:8px;text-decoration:none;
  color:var(--text-muted);font-size:.875rem;font-weight:500;transition:.15s;
}
.nav-link:hover,.nav-link.active{background:var(--green-light);color:var(--green-dark)}
.nav-cta{
  padding:8px 20px;background:var(--green);color:#fff;border-radius:8px;
  text-decoration:none;font-size:.875rem;font-weight:600;transition:.15s;
}
.nav-cta:hover{background:var(--green-dark)}
</style>
</head>
<body>
<nav class="shop-nav">
  <div class="nav-inner">
    <a href="/newroot/shop" class="nav-logo">
      <div class="icon"><i class="fa-solid fa-tree"></i></div>
      TimberPro
    </a>
    <div class="nav-links">
      <a href="/newroot/shop" class="nav-link <?= (uri_string() === 'shop') ? 'active' : '' ?>">
        <i class="fa-solid fa-shop"></i> Browse
      </a>
      <a href="/newroot/shop?tab=workers" class="nav-link">
        <i class="fa-solid fa-hard-hat"></i> Professionals
      </a>
      <a href="/newroot/shop/calculator" class="nav-link <?= (strpos(uri_string(),'calculator')!==false) ? 'active' : '' ?>">
        <i class="fa-solid fa-calculator"></i> Calculator
      </a>
      <a href="/newroot/shop/request_quote" class="nav-link">
        <i class="fa-regular fa-file-lines"></i> Get Quote
      </a>
      <?php if(isset($is_logged_in) && $is_logged_in): ?>
      <a href="/newroot/shop/my_orders" class="nav-link">
        <i class="fa-solid fa-box"></i> My Orders
      </a>
      <?php endif; ?>
    </div>
    <div style="display:flex;gap:8px;align-items:center">
      <a href="/newroot/shop/track" class="nav-link">
        <i class="fa-solid fa-location-dot"></i> Track
      </a>
      <a href="/newroot/shop/request_quote" class="nav-cta">
        Request Quote
      </a>
    </div>
  </div>
</nav>
