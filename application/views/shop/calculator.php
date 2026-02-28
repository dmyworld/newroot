<?php $this->load->view('shop/styles') ?>
<div class="container section">
  <div style="max-width:900px;margin:0 auto">
    <div class="section-title">🧮 Timber Calculator</div>
    <div class="section-subtitle">Free professional timber measurement tool — Hoppus, Sawn, Wastage & Price</div>

    <!-- Tab nav -->
    <div style="display:flex;gap:4px;background:#f3f4f6;padding:4px;border-radius:10px;margin-bottom:28px">
      <?php foreach (['log_volume'=>'Log Volume (Hoppus)','sawn_volume'=>'Sawn Timber','wastage'=>'Wastage & Yield','price'=>'Price Estimate'] as $tab=>$label): ?>
        <button onclick="switchTab('<?= $tab ?>')" id="tab-<?= $tab ?>"
          class="btn" style="flex:1;border-radius:8px;background:<?= $tab==='log_volume'?'#fff':'transparent' ?>;
          color:<?= $tab==='log_volume'?'var(--green-dark)':'var(--text-muted)' ?>;
          box-shadow:<?= $tab==='log_volume'?'var(--shadow)':'' ?>;font-size:.8rem;padding:8px 4px">
          <?= $label ?>
        </button>
      <?php endforeach ?>
    </div>

    <!-- LOG VOLUME -->
    <div id="panel-log_volume" class="calc-panel">
      <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border)">
        <h3 style="font-size:1.1rem;margin-bottom:4px"><i class="fa-solid fa-circle-dot" style="color:var(--green)"></i> Hoppus Rule — Log Volume</h3>
        <p style="color:var(--text-muted);font-size:.85rem;margin-bottom:20px">Formula: <strong>V = (G÷4)² × L ÷ 144</strong></p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
          <div>
            <label class="f-label">Girth (Inches)</label>
            <input id="log-girth" type="number" step="0.1" class="f-input" placeholder="e.g. 48">
          </div>
          <div>
            <label class="f-label">Length (Feet)</label>
            <input id="log-length" type="number" step="0.1" class="f-input" placeholder="e.g. 12">
          </div>
          <div>
            <label class="f-label">Species (optional)</label>
            <input id="log-species" type="text" class="f-input" placeholder="e.g. Teak">
          </div>
          <div>
            <label class="f-label">Price /cu.ft (LKR)</label>
            <input id="log-price" type="number" step="100" class="f-input" placeholder="e.g. 15000">
          </div>
        </div>
        <button onclick="calcLog()" class="btn btn-green btn-lg" style="margin-top:20px;width:100%">
          <i class="fa-solid fa-calculator"></i> Calculate Volume
        </button>
        <div id="log-result" class="calc-result"></div>
      </div>
    </div>

    <!-- SAWN VOLUME -->
    <div id="panel-sawn_volume" class="calc-panel" style="display:none">
      <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border)">
        <h3 style="font-size:1.1rem;margin-bottom:4px"><i class="fa-solid fa-layer-group" style="color:#2563eb"></i> Sawn Timber Volume</h3>
        <p style="color:var(--text-muted);font-size:.85rem;margin-bottom:20px">Formula: <strong>V = (T × W × L) ÷ 144 × Qty</strong></p>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
          <div>
            <label class="f-label">Thickness (Inches)</label>
            <input id="s-thick" type="number" step="0.25" class="f-input" placeholder="e.g. 2">
          </div>
          <div>
            <label class="f-label">Width (Inches)</label>
            <input id="s-width" type="number" step="0.25" class="f-input" placeholder="e.g. 8">
          </div>
          <div>
            <label class="f-label">Length (Feet)</label>
            <input id="s-length" type="number" step="0.5" class="f-input" placeholder="e.g. 10">
          </div>
          <div>
            <label class="f-label">Quantity (Pieces)</label>
            <input id="s-qty" type="number" class="f-input" placeholder="e.g. 100" value="1">
          </div>
          <div>
            <label class="f-label">Species</label>
            <input id="s-species" type="text" class="f-input" placeholder="Teak, Kos...">
          </div>
          <div>
            <label class="f-label">Price /cu.ft (LKR)</label>
            <input id="s-price" type="number" class="f-input" placeholder="8000">
          </div>
        </div>
        <button onclick="calcSawn()" class="btn btn-green btn-lg" style="margin-top:20px;width:100%">
          <i class="fa-solid fa-calculator"></i> Calculate
        </button>
        <div id="sawn-result" class="calc-result"></div>
      </div>
    </div>

    <!-- WASTAGE -->
    <div id="panel-wastage" class="calc-panel" style="display:none">
      <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border)">
        <h3 style="font-size:1.1rem;margin-bottom:4px"><i class="fa-solid fa-chart-pie" style="color:#d97706"></i> Wastage & Yield</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:20px">
          <div>
            <label class="f-label">Log Volume (cu.ft)</label>
            <input id="w-log" type="number" step="0.01" class="f-input" placeholder="e.g. 50">
          </div>
          <div>
            <label class="f-label">Expected Output (cu.ft)</label>
            <input id="w-out" type="number" step="0.01" class="f-input" placeholder="e.g. 30">
          </div>
        </div>
        <button onclick="calcWastage()" class="btn btn-green btn-lg" style="margin-top:20px;width:100%">
          <i class="fa-solid fa-calculator"></i> Calculate Wastage
        </button>
        <div id="wastage-result" class="calc-result"></div>
      </div>
    </div>

    <!-- PRICE ESTIMATE -->
    <div id="panel-price" class="calc-panel" style="display:none">
      <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border)">
        <h3 style="font-size:1.1rem;margin-bottom:4px"><i class="fa-solid fa-tag" style="color:#7c3aed"></i> Price Estimate</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:20px">
          <div>
            <label class="f-label">Species</label>
            <select id="p-species" class="f-input">
              <option value="">-- Select --</option>
              <?php foreach ($wood_types as $wt): ?>
                <option value="<?= htmlspecialchars($wt['name'] ?? $wt['wood_name'] ?? '') ?>">
                  <?= htmlspecialchars($wt['name'] ?? $wt['wood_name'] ?? '') ?>
                </option>
              <?php endforeach ?>
              <option value="Teak">Teak</option>
              <option value="Kos">Kos</option>
              <option value="Mahogany">Mahogany</option>
              <option value="Nadun">Nadun</option>
            </select>
          </div>
          <div>
            <label class="f-label">Grade</label>
            <select id="p-grade" class="f-input">
              <option value="">Standard</option>
              <option value="A">Grade A</option>
              <option value="B">Grade B</option>
              <option value="C">Grade C</option>
            </select>
          </div>
          <div>
            <label class="f-label">Volume</label>
            <input id="p-vol" type="number" step="0.01" class="f-input" placeholder="e.g. 25">
          </div>
          <div>
            <label class="f-label">Unit</label>
            <select id="p-unit" class="f-input">
              <option value="cubic_ft">Cubic Feet</option>
              <option value="sq_ft">Square Feet</option>
              <option value="running_ft">Running Feet</option>
            </select>
          </div>
        </div>
        <button onclick="calcPrice()" class="btn btn-green btn-lg" style="margin-top:20px;width:100%">
          <i class="fa-solid fa-calculator"></i> Estimate Price
        </button>
        <div id="price-result" class="calc-result"></div>
      </div>
    </div>

  </div><!-- /max-width -->
</div><!-- /container -->

<style>
.f-label{display:block;font-size:.8rem;font-weight:600;color:var(--text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.f-input{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-size:.95rem;outline:none;font-family:inherit;transition:.15s}
.f-input:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(30,124,58,.1)}
.calc-result{margin-top:20px;padding:20px;background:var(--green-light);border-radius:10px;border:1px solid #bbf7d0;display:none}
.calc-result .row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #dcfce7;font-size:.9rem}
.calc-result .row:last-child{border-bottom:none;font-weight:700;font-size:1rem}
.calc-result .row .val{color:var(--green-dark);font-weight:600}
</style>

<script>
function switchTab(id) {
  document.querySelectorAll('.calc-panel').forEach(p => p.style.display = 'none');
  document.querySelectorAll('[id^="tab-"]').forEach(b => {
    b.style.background = 'transparent'; b.style.color = 'var(--text-muted)'; b.style.boxShadow = '';
  });
  document.getElementById('panel-' + id).style.display = '';
  const btn = document.getElementById('tab-' + id);
  btn.style.background = '#fff'; btn.style.color = 'var(--green-dark)'; btn.style.boxShadow = 'var(--shadow)';
}

function calcLog() {
  const g = parseFloat(document.getElementById('log-girth').value),
        l = parseFloat(document.getElementById('log-length').value),
        price = parseFloat(document.getElementById('log-price').value) || 0;
  if (!g || !l) return alert('Please enter girth and length');
  const v = (g/4)*(g/4)*l/144;
  const est = price > 0 ? v * price : 0;
  showResult('log-result', [
    ['Quarter Girth', (g/4).toFixed(2) + '"'],
    ['Volume (Hoppus)', v.toFixed(4) + ' cu.ft'],
    ['Price / cu.ft', price > 0 ? 'LKR ' + price.toLocaleString() : 'N/A'],
    ['💰 Price Estimate', price > 0 ? 'LKR ' + est.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') : 'Enter price above'],
  ]);
}

function calcSawn() {
  const t = parseFloat(document.getElementById('s-thick').value),
        w = parseFloat(document.getElementById('s-width').value),
        l = parseFloat(document.getElementById('s-length').value),
        q = parseInt(document.getElementById('s-qty').value) || 1,
        price = parseFloat(document.getElementById('s-price').value) || 0;
  if (!t||!w||!l) return alert('Enter thickness, width and length');
  const perPiece = (t*w*l)/144;
  const total = perPiece * q;
  const sqft = (w/12)*l*q;
  const est = price > 0 ? total * price : 0;
  showResult('sawn-result', [
    ['Volume / Piece', perPiece.toFixed(4) + ' cu.ft'],
    ['Total Volume', total.toFixed(4) + ' cu.ft'],
    ['Total Sq.Ft', sqft.toFixed(2) + ' sq.ft'],
    ['Total Running Ft', (l * q) + ' running.ft'],
    ['💰 Price Estimate', price > 0 ? 'LKR ' + est.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') : 'Enter price above'],
  ]);
}

function calcWastage() {
  const log = parseFloat(document.getElementById('w-log').value),
        out = parseFloat(document.getElementById('w-out').value);
  if (!log) return alert('Enter log volume');
  if (out > log) return alert('Output cannot exceed log volume');
  const waste = log - (out||0);
  const wpct  = ((waste/log)*100).toFixed(2);
  const ypct  = (100 - wpct).toFixed(2);
  showResult('wastage-result', [
    ['Log Volume', log + ' cu.ft'],
    ['Output Volume', (out||0) + ' cu.ft'],
    ['Wastage', waste.toFixed(4) + ' cu.ft'],
    ['Wastage %', wpct + '%'],
    ['✅ Yield %', ypct + '%'],
  ]);
}

function calcPrice() {
  const sp   = document.getElementById('p-species').value,
        vol  = parseFloat(document.getElementById('p-vol').value),
        unit = document.getElementById('p-unit').value;
  if (!vol) return alert('Enter volume');
  // Fetch from API
  fetch('/newroot/api/calculator/price_estimate', {
    method:'POST', headers:{'Content-Type':'application/json'},
    body: JSON.stringify({ species:sp, grade:document.getElementById('p-grade').value, volume:vol, unit })
  })
  .then(r=>r.json()).then(d=>{
    if (d.status==='success') {
      const r = d.data;
      showResult('price-result', [
        ['Species', r.species],
        ['Grade', r.grade],
        ['Volume', r.volume + ' ' + r.unit.replace('_',' ')],
        ['Price / Unit', 'LKR ' + r.price_per_unit.toLocaleString()],
        ['Source', r.price_source === 'market_tracker' ? '📊 Live Market' : '📋 Default Rates'],
        ['💰 Total Estimate', 'LKR ' + r.total_estimate.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')],
      ]);
    }
  })
  .catch(()=>{
    // Fallback offline calc
    const defaults = {Teak:18000,Kos:9000,Mahogany:15000,Nadun:12000};
    const ppu = defaults[sp] || 8000;
    const est = vol * ppu;
    showResult('price-result', [
      ['Species', sp || 'General'],
      ['Volume', vol + ' ' + unit.replace('_',' ')],
      ['Price / Unit', 'LKR ' + ppu.toLocaleString()],
      ['💰 Estimate', 'LKR ' + est.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')],
    ]);
  });
}

function showResult(id, rows) {
  const el = document.getElementById(id);
  el.style.display = 'block';
  el.innerHTML = rows.map((r,i) =>
    `<div class="row"><span>${r[0]}</span><span class="val">${r[1]}</span></div>`
  ).join('');
}
</script>
