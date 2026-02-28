<style>
/* ---- SHOP GLOBAL STYLES ---- */
.container{max-width:1240px;margin:0 auto;padding:0 24px}
.section{padding:48px 0}

/* hero */
.hero{
  background:linear-gradient(135deg,var(--green-dark) 0%,var(--green) 50%,#268a42 100%);
  color:#fff;padding:72px 24px 56px;text-align:center;position:relative;overflow:hidden;
}
.hero::before{
  content:'';position:absolute;inset:0;
  background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.hero-inner{max-width:800px;margin:0 auto;position:relative}
.hero h1{font-family:'Libre Baskerville',serif;font-size:2.5rem;font-weight:700;margin-bottom:12px;line-height:1.2}
.hero p{font-size:1.1rem;opacity:.88;margin-bottom:32px}
.hero-badges{display:flex;justify-content:center;gap:12px;flex-wrap:wrap}
.badge{
  background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
  color:#fff;padding:6px 16px;border-radius:100px;font-size:.8rem;font-weight:500;
  backdrop-filter:blur(4px)
}

/* search bar */
.search-bar{
  max-width:700px;margin:-28px auto 0;position:relative;z-index:2;
  display:flex;gap:0;background:#fff;border-radius:12px;
  box-shadow:0 8px 32px rgba(0,0,0,.18);overflow:hidden;
}
.search-bar input{
  flex:1;border:none;padding:16px 20px;font-size:1rem;outline:none;
  font-family:'Inter',sans-serif;
}
.search-bar select{
  border:none;border-left:1px solid var(--border);padding:0 16px;
  font-size:.875rem;color:var(--text-muted);background:#fff;cursor:pointer;outline:none;
}
.search-bar button{
  background:var(--green);color:#fff;border:none;padding:0 28px;
  font-size:1rem;cursor:pointer;transition:.15s;font-weight:600;
}
.search-bar button:hover{background:var(--green-dark)}

/* market banner strip */
.market-strip{
  background:#fff;border-bottom:1px solid var(--border);
  padding:10px 0;overflow:hidden;
}
.strip-inner{display:flex;gap:32px;align-items:center;animation:scroll 30s linear infinite}
@keyframes scroll{from{transform:translateX(0)}to{transform:translateX(-50%)}}
.strip-item{white-space:nowrap;font-size:.8rem;color:var(--text-muted);
  display:flex;align-items:center;gap:6px}
.strip-item strong{color:var(--text)}
.strip-item .up{color:#16a34a}.strip-item .down{color:#dc2626}

/* section title */
.section-title{font-family:'Libre Baskerville',serif;font-size:1.5rem;font-weight:700;color:var(--text);margin-bottom:4px}
.section-subtitle{color:var(--text-muted);font-size:.9rem;margin-bottom:24px}

/* filter pills */
.filter-bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px;align-items:center}
.filter-pill{
  padding:6px 16px;border:1px solid var(--border);border-radius:100px;
  background:#fff;font-size:.8rem;font-weight:500;cursor:pointer;
  text-decoration:none;color:var(--text-muted);transition:.15s;
}
.filter-pill:hover,.filter-pill.active{
  background:var(--green-light);color:var(--green-dark);border-color:var(--green);
}
.filter-pill i{margin-right:4px}

/* Lot card */
.lots-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px}
.lot-card{
  background:var(--card);border-radius:var(--radius);overflow:hidden;
  box-shadow:var(--shadow);transition:.2s;border:1px solid var(--border);
}
.lot-card:hover{box-shadow:var(--shadow-hover);transform:translateY(-2px)}
.lot-img{
  height:180px;background:linear-gradient(135deg,#e8f0e4,#c9d9c1);
  display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;
}
.lot-img img{width:100%;height:100%;object-fit:cover}
.lot-img .no-img{font-size:3rem;color:#a0b899}
.lot-type-badge{
  position:absolute;top:10px;left:10px;
  background:rgba(0,0,0,.6);color:#fff;padding:3px 10px;
  border-radius:100px;font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;
}
.verified-badge{
  position:absolute;top:10px;right:10px;
  background:#16a34a;color:#fff;padding:3px 10px;
  border-radius:100px;font-size:.72rem;
}
.lot-body{padding:16px}
.lot-species{font-size:1.05rem;font-weight:700;margin-bottom:4px}
.lot-meta{font-size:.8rem;color:var(--text-muted);margin-bottom:12px;
  display:flex;gap:12px;flex-wrap:wrap}
.lot-meta span{display:flex;align-items:center;gap:4px}
.lot-price{
  font-size:1.2rem;font-weight:700;color:var(--green-dark);margin-bottom:12px
}
.lot-price small{font-weight:400;color:var(--text-muted);font-size:.78rem}
.lot-actions{display:flex;gap:8px}
.btn{
  padding:8px 16px;border-radius:8px;border:none;cursor:pointer;
  font-size:.85rem;font-weight:600;text-decoration:none;text-align:center;transition:.15s;
  display:inline-flex;align-items:center;gap:6px;
}
.btn-green{background:var(--green);color:#fff}.btn-green:hover{background:var(--green-dark)}
.btn-outline{background:#fff;color:var(--green);border:1px solid var(--green)}.btn-outline:hover{background:var(--green-light)}
.btn-gold{background:var(--gold);color:#fff}.btn-gold:hover{background:#b8870f}
.btn-sm{padding:6px 12px;font-size:.8rem}
.btn-lg{padding:12px 24px;font-size:1rem}
.btn-block{width:100%;justify-content:center}

/* Empty state */
.empty-state{text-align:center;padding:64px 24px;color:var(--text-muted)}
.empty-state .icon{font-size:3rem;margin-bottom:16px;color:#d1d5db}
.empty-state h3{font-size:1.1rem;font-weight:600;margin-bottom:8px;color:var(--text)}

/* Stats row */
.stats-row{display:flex;gap:16px;margin-bottom:32px;flex-wrap:wrap}
.stat-pill{
  flex:1;min-width:140px;background:#fff;border:1px solid var(--border);
  border-radius:var(--radius-sm);padding:16px;display:flex;gap:12px;align-items:center;
  box-shadow:var(--shadow);
}
.stat-pill .icon{
  width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;flex-shrink:0;
}
.stat-pill .num{font-size:1.3rem;font-weight:700}
.stat-pill .label{font-size:.78rem;color:var(--text-muted)}

/* Toast */
.toast{
  position:fixed;bottom:24px;right:24px;z-index:9999;
  padding:14px 20px;background:#1f2937;color:#fff;border-radius:10px;
  box-shadow:0 6px 24px rgba(0,0,0,.25);display:flex;align-items:center;gap:10px;
  transform:translateY(80px);opacity:0;transition:.3s;font-size:.875rem;pointer-events:none;
}
.toast.show{transform:translateY(0);opacity:1}
.toast.success{border-left:4px solid #16a34a}
.toast.error{border-left:4px solid #dc2626}
</style>
