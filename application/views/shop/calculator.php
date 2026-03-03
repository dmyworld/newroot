<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-4">Timber Volume Calculator</h2>
        <p class="text-slate-500 max-w-2xl mx-auto">Free professional timber measurement tool. Calculate Hoppus volume, sawn timber needs, and get instant price estimates.</p>
    </div>

    <!-- Tab Navigation -->
    <div class="flex p-1.5 bg-slate-100 rounded-3xl mb-8 space-x-1">
        <?php foreach (['log_volume'=>'Log Volume','sawn_volume'=>'Sawn Timber','wastage'=>'Wastage','price'=>'Price Map'] as $tab => $label): ?>
            <button onclick="switchTab('<?= $tab ?>')" id="tab-<?= $tab ?>"
                class="calc-tab-btn <?= $tab === 'log_volume' ? 'active' : '' ?>">
                <?= $label ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- LOG VOLUME -->
    <div id="panel-log_volume" class="calc-panel space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                    <i class="fa-solid fa-circle-dot"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">Hoppus Rule Calculator</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Formula: (G÷4)² × L ÷ 144</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="custom-label">Girth (Inches)</label>
                    <input id="log-girth" type="number" step="0.1" class="custom-input" placeholder="e.g. 48">
                </div>
                <div>
                    <label class="custom-label">Length (Feet)</label>
                    <input id="log-length" type="number" step="0.1" class="custom-input" placeholder="e.g. 12">
                </div>
                <div>
                    <label class="custom-label">Species (optional)</label>
                    <input id="log-species" type="text" class="custom-input" placeholder="e.g. Teak">
                </div>
                <div>
                    <label class="custom-label">Price / cu.ft (LKR)</label>
                    <input id="log-price" type="number" step="100" class="custom-input" placeholder="e.g. 15000">
                </div>
            </div>

            <button onclick="calcLog()" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-2xl transition-all shadow-lg hover:-translate-y-0.5">
                Calculate Log Volume
            </button>

            <div id="log-result" class="mt-8 hidden overflow-hidden rounded-2xl border border-green-100"></div>
        </div>
    </div>

    <!-- SAWN VOLUME -->
    <div id="panel-sawn_volume" class="calc-panel hidden space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">Sawn Timber Volume</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Formula: (T × W × L) ÷ 144 × Qty</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="custom-label">Thickness (in)</label>
                    <input id="s-thick" type="number" step="0.25" class="custom-input" placeholder="2">
                </div>
                <div>
                    <label class="custom-label">Width (in)</label>
                    <input id="s-width" type="number" step="0.25" class="custom-input" placeholder="8">
                </div>
                <div>
                    <label class="custom-label">Length (ft)</label>
                    <input id="s-length" type="number" step="0.5" class="custom-input" placeholder="10">
                </div>
                <div>
                    <label class="custom-label">Quantity</label>
                    <input id="s-qty" type="number" class="custom-input" value="1">
                </div>
                <div class="col-span-2">
                    <label class="custom-label">Price / cu.ft (optional)</label>
                    <input id="s-price" type="number" class="custom-input" placeholder="8000">
                </div>
            </div>

            <button onclick="calcSawn()" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-2xl transition-all shadow-lg hover:-translate-y-0.5">
                Calculate Sawn Volume
            </button>

            <div id="sawn-result" class="mt-8 hidden overflow-hidden rounded-2xl border border-blue-100"></div>
        </div>
    </div>

    <!-- WASTAGE -->
    <div id="panel-wastage" class="calc-panel hidden space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center">
             <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mx-auto mb-6">
                <i class="fa-solid fa-chart-pie text-2xl"></i>
            </div>
            <h3 class="font-bold text-slate-900 mb-6">Wastage & Yield Analysis</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 max-w-md mx-auto">
                <div>
                    <label class="custom-label">Input Log Vol (cu.ft)</label>
                    <input id="w-log" type="number" step="0.1" class="custom-input" placeholder="50">
                </div>
                <div>
                    <label class="custom-label">Output Sawn Vol (cu.ft)</label>
                    <input id="w-out" type="number" step="0.1" class="custom-input" placeholder="30">
                </div>
            </div>
            <button onclick="calcWastage()" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-12 rounded-2xl transition-all">
                Analyze Efficiency
            </button>
            <div id="wastage-result" class="mt-8 hidden overflow-hidden rounded-2xl border border-amber-100"></div>
        </div>
    </div>

</div>

<!-- REFINED STYLES -->
<style>
    .calc-tab-btn {
        @apply flex-1 py-3.5 rounded-2xl text-sm font-bold text-slate-500 transition-all duration-300;
    }
    .calc-tab-btn.active {
        @apply bg-white text-blue-600 shadow-sm;
    }
    .custom-label {
        @apply block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1;
    }
    .custom-input {
        @apply w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 transition-all;
    }
    .result-row {
        @apply flex justify-between items-center p-4 border-b border-slate-50 last:border-none;
    }
    .result-label { @apply text-xs font-bold text-slate-400 uppercase tracking-wide; }
    .result-value { @apply font-black text-slate-900; }
    .result-total { @apply bg-slate-900 text-white; }
    .result-total .result-label { @apply text-slate-400; }
    .result-total .result-value { @apply text-blue-400; }
</style>

<script>
    function switchTab(id) {
        document.querySelectorAll('.calc-panel').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.calc-tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('panel-' + id).classList.remove('hidden');
        document.getElementById('tab-' + id).classList.add('active');
    }

    function showResult(id, rows) {
        const el = document.getElementById(id);
        el.classList.remove('hidden');
        el.innerHTML = rows.map((r, i) => `
            <div class="result-row ${i === rows.length - 1 ? 'result-total' : ''}">
                <span class="result-label">${r[0]}</span>
                <span class="result-value">${r[1]}</span>
            </div>
        `).join('');
    }

    function calcLog() {
        const g = parseFloat(document.getElementById('log-girth').value),
              l = parseFloat(document.getElementById('log-length').value),
              price = parseFloat(document.getElementById('log-price').value) || 0;
        if (!g || !l) return alert('Enter girth and length');
        const v = (g/4)*(g/4)*l/144;
        showResult('log-result', [
            ['Quarter Girth', (g/4).toFixed(2) + '"'],
            ['Calculated Volume', v.toFixed(4) + ' cu.ft'],
            ['Est. Total Value', 'Rs. ' + (v * price).toLocaleString()]
        ]);
    }

    function calcSawn() {
        const t = parseFloat(document.getElementById('s-thick').value),
              w = parseFloat(document.getElementById('s-width').value),
              l = parseFloat(document.getElementById('s-length').value),
              q = parseInt(document.getElementById('s-qty').value) || 1,
              price = parseFloat(document.getElementById('s-price').value) || 0;
        if (!t || !w || !l) return alert('Fill dimensions');
        const v = (t*w*l)/144 * q;
        showResult('sawn-result', [
            ['Total Quantity', q + ' Pcs'],
            ['Total Volume', v.toFixed(4) + ' cu.ft'],
            ['Total Estimate', 'Rs. ' + (v * price).toLocaleString()]
        ]);
    }

    function calcWastage() {
        const log = parseFloat(document.getElementById('w-log').value),
              out = parseFloat(document.getElementById('w-out').value);
        if(!log || !out) return;
        const waste = log - out;
        const wpct = ((waste/log)*100).toFixed(1);
        showResult('wastage-result', [
            ['Timber Output', (100 - wpct) + '%'],
            ['Waste Material', wpct + '%'],
            ['Waste Volume', waste.toFixed(2) + ' cu.ft']
        ]);
    }
</script>
