<style>
    :root {
        --premium-blue: #1e3c72;
        --premium-green: #10b981;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --text-main: #1e293b;
        --text-sub: #64748b;
    }

    .product-detail-container {
        padding: 40px;
        max-width: 1400px;
        margin: 0 auto;
        font-family: 'Inter', sans-serif;
    }

    .glass-panel-premium {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 32px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-bottom: 40px;
    }

    .product-hero-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 60px;
    }

    /* Gallery Styling */
    .gallery-wrapper {
        position: relative;
    }

    .main-stage {
        width: 100%;
        height: 550px;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    .main-stage img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .main-stage:hover img {
        transform: scale(1.05);
    }

    .thumb-strip {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 15px;
        margin-top: 25px;
    }

    .thumb-item {
        height: 80px;
        border-radius: 14px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s;
        opacity: 0.6;
    }

    .thumb-item.active {
        border-color: var(--premium-blue);
        opacity: 1;
        transform: translateY(-5px);
    }

    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Info Styling */
    .product-info-hub {
        display: flex;
        flex-direction: column;
    }

    .badge-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .premium-badge {
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .badge-model { background: rgba(30, 60, 114, 0.1); color: var(--premium-blue); }
    .badge-verified { background: rgba(16, 185, 129, 0.1); color: var(--premium-green); }

    .hero-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 900;
        color: var(--text-main);
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .hero-location {
        font-size: 1.1rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 30px;
    }

    /* Dual Pricing Component */
    .anchoring-note {
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--premium-green);
        background: rgba(16, 185, 129, 0.1);
        padding: 4px 12px;
        border-radius: 100px;
        display: inline-block;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .pricing-engine {
        background: #f8fafc;
        padding: 30px;
        border-radius: 24px;
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.03);
    }

    /* Decoy Tabs */
    .choice-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        background: #f1f5f9;
        padding: 6px;
        border-radius: 18px;
    }

    .choice-tab {
        flex: 1;
        padding: 12px;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 800;
        color: var(--text-sub);
        cursor: pointer;
        border-radius: 14px;
        transition: all 0.3s;
    }

    .choice-tab.active {
        background: white;
        color: var(--premium-blue);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .choice-content {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .choice-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .price-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-sub);
        text-transform: uppercase;
    }

    .price-value-main {
        font-size: 2.8rem;
        font-weight: 900;
        color: var(--premium-blue);
        line-height: 1;
    }

    .unit-price-row {
        display: flex;
        justify-content: space-between;
        padding-top: 15px;
        border-top: 1px dashed #e2e8f0;
    }

    .unit-price-val {
        font-weight: 700;
        color: var(--premium-green);
        font-size: 1.2rem;
    }

    /* Stats Grid */
    .stats-card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card-premium {
        background: white;
        padding: 20px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        background: rgba(30, 60, 114, 0.05);
        color: var(--premium-blue);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .stat-meta .label { font-size: 0.65rem; color: var(--text-sub); font-weight: 700; text-transform: uppercase; display: block; }
    .stat-meta .value { font-size: 1.1rem; font-weight: 800; color: var(--text-main); }

    /* Action Buttons */
    .btn-buy-now {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border: none;
        padding: 20px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.3s;
        box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
    }

    .btn-buy-now:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(30, 60, 114, 0.4);
    }

    .secondary-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 15px;
    }

    .btn-outline-premium {
        background: white;
        border: 2px solid #e2e8f0;
        padding: 15px;
        border-radius: 18px;
        font-weight: 700;
        color: var(--text-main);
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-outline-premium:hover {
        border-color: var(--premium-blue);
        color: var(--premium-blue);
    }

    /* Detail Tabs */
    .detail-section-header {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .premium-table-wrapper {
        background: white;
        border-radius: 24px;
        padding: 10px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .premium-table {
        width: 100%;
        border-collapse: collapse;
    }

    .premium-table th {
        background: #f8fafc;
        padding: 18px;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--text-sub);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .premium-table td {
        padding: 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.95rem;
        color: var(--text-main);
        font-weight: 500;
    }

    .species-label {
        font-weight: 800;
        color: var(--premium-blue);
    }

    /* Installment Calculator */
    .installment-card {
        background: white;
        border: 2px solid var(--premium-green);
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);
    }
    .calc-slider {
        @apply w-full h-2 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-emerald-500 mb-4;
    }
    .monthly-badge {
        background: var(--premium-green);
        color: white;
        padding: 15px;
        border-radius: 16px;
        text-align: center;
        margin-top: 15px;
    }
</style>

<div class="product-detail-container">
    <div class="glass-panel-premium">
        <div class="product-hero-grid">
            <!-- Left: Gallery -->
            <div class="gallery-wrapper">
                <div class="main-stage">
                    <img id="mainImage" src="<?= !empty($lot['photos'][0]) ? base_url($lot['photos'][0]) : 'https://images.unsplash.com/photo-1550537687-c91072c4792d?w=1000' ?>" alt="Timber Product">
                </div>
                
                <?php if(count($lot['photos'] ?? []) > 1): ?>
                <div class="thumb-strip">
                    <?php foreach($lot['photos'] as $idx => $photo): ?>
                    <div class="thumb-item <?= $idx === 0 ? 'active' : '' ?>" onclick="updateMainImage('<?= base_url($photo) ?>', this)">
                        <img src="<?= base_url($photo) ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right: Critical Info -->
            <div class="product-info-hub">
                <div class="badge-bar">
                    <span class="premium-badge badge-model"><?= strtoupper($type) ?></span>
                    <?php if(!empty($lot['permit_verified'])): ?>
                        <span class="premium-badge badge-verified"><i class="fa fa-shield-check"></i> VERIFIED PERMIT</span>
                    <?php endif; ?>
                </div>

                <h1 class="hero-title"><?= htmlspecialchars($lot['name'] ?? $lot['species'] ?? 'Premium Timber Lot') ?></h1>
                <div class="hero-location">
                    <i class="fa fa-map-pin"></i> <?= htmlspecialchars($lot['location'] ?? 'Location unavailable') ?> • Sri Lanka
                </div>

                <!-- Psychological Anchoring -->
                <div class="anchoring-row">
                    <span class="anchoring-note">
                        <i class="fa fa-tag"></i> OR RENT FOR AS LOW AS LKR <?= number_format(($lot['product_rent'] > 0 ? $lot['product_rent'] : 500)) ?>/DAY
                    </span>
                </div>

                <!-- Dual Pricing Display -->
                <div class="pricing-engine">
                    <div class="total-price-row flex justify-between items-end mb-4">
                        <span class="price-label">Instant Buy Price</span>
                        <div class="price-value-main">LKR <?= number_format($lot['total_price'] ?? ($lot['price'] ?? 0)) ?></div>
                    </div>
                </div>

                <!-- Choice Tabs (Decoy Effect) -->
                <div class="choice-tabs">
                    <div class="choice-tab active" onclick="switchChoice('buy')">BUY NOW</div>
                    <div class="choice-tab" onclick="switchChoice('rent')">RENTAL</div>
                    <div class="choice-tab" onclick="switchChoice('emi')">INSTALLMENTS</div>
                </div>

                <!-- BUY MODULE -->
                <div id="buy-module" class="choice-content active">
                    <div class="master-action-box">
                        <?php if($is_logged_in): ?>
                            <button class="btn-buy-now mb-4" onclick="buyNow()">
                                <i class="fa fa-cart-shopping"></i> PROCEED TO SECURE BUY
                            </button>
                            <div class="secondary-actions">
                                <button class="btn-outline-premium" onclick="openOfferModal()">
                                    <i class="fa fa-hand-holding-dollar"></i> PLACE BID
                                </button>
                                <button class="btn-outline-premium" onclick="contactSeller()">
                                    <i class="fa fa-message"></i> INQUIRE
                                </button>
                            </div>
                        <?php else: ?>
                            <button class="btn-buy-now" onclick="window.location.href='<?= base_url('user') ?>'">
                                LOGIN TO TRANSACT
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- RENTAL MODULE -->
                <div id="rent-module" class="choice-content">
                    <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 mb-6">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                             <i class="fa fa-calendar-days text-premium-blue"></i> Select Rental Period
                        </h4>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 block mb-1">START DATE</label>
                                <input type="date" id="rent-start" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-500 transition-all" value="<?= date('Y-m-d') ?>" onchange="updateRentQuote()">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 block mb-1">END DATE</label>
                                <input type="date" id="rent-end" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-emerald-500 transition-all" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" onchange="updateRentQuote()">
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl mb-4">
                            <input type="checkbox" id="insurance-check" class="w-5 h-5 accent-emerald-500" onchange="updateRentQuote()">
                            <div>
                                <div class="text-[11px] font-black text-slate-900">DAMAGE PROTECTION (INSURANCE)</div>
                                <div class="text-[9px] text-slate-500">Reduces security deposit by 50% for only LKR 500 extra.</div>
                            </div>
                        </div>

                        <div id="rental-summary-area">
                             <p class="text-[11px] text-slate-400 italic text-center">Select dates to view pricing breakdown.</p>
                        </div>

                        <button class="btn-buy-now mt-6 bg-emerald-600 shadow-emerald-200" onclick="bookRent()">
                             <i class="fa fa-key"></i> CONFIRM BOOKING
                        </button>
                    </div>
                </div>

                <!-- EMI MODULE -->
                <div id="emi-module" class="choice-content">
                    <div class="bg-white p-6 rounded-3xl border-2 border-emerald-100 mb-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-emerald-100 text-emerald-600 text-[9px] font-black px-4 py-1 rounded-bl-xl">LOWEST INTEREST</div>
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                             <i class="fa fa-id-card-clip text-emerald-500"></i> EMI Eligibility Checker
                        </h4>

                        <div class="space-y-5">
                            <div>
                                <div class="flex justify-between text-[11px] font-bold text-slate-400 mb-2 uppercase">
                                    <span>Down Payment</span>
                                    <span class="text-emerald-500" id="emi-down-label">LKR 0</span>
                                </div>
                                <input type="range" id="emi-down-slider" min="0" max="<?= ($lot['total_price'] ?? 0) * 0.8 ?>" step="5000" value="0" class="calc-slider w-full" oninput="updateEmiCalc()">
                            </div>

                            <div>
                                <div class="flex justify-between text-[11px] font-bold text-slate-400 mb-2 uppercase">
                                    <span>Tenure (Months)</span>
                                    <span class="text-emerald-500" id="emi-months-label">12 Months</span>
                                </div>
                                <input type="range" id="emi-months-slider" min="3" max="36" step="3" value="12" class="calc-slider w-full" oninput="updateEmiCalc()">
                            </div>

                            <div class="bg-emerald-50 p-4 rounded-2xl flex justify-between items-center">
                                <div>
                                    <div class="text-[10px] font-black text-emerald-600 uppercase">Monthly Installment</div>
                                    <div class="text-xl font-black text-slate-900" id="emi-monthly-val">LKR 0</div>
                                </div>
                                <button class="bg-emerald-500 text-white text-[10px] font-black px-4 py-3 rounded-xl shadow-lg" onclick="checkEmiEligibility()">
                                    CHECK ELIGIBILITY
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-card-grid">
                    <div class="stat-card-premium">
                        <div class="stat-icon"><i class="fa fa-tree"></i></div>
                        <div class="stat-meta">
                            <span class="label">Species</span>
                            <span class="value"><?= htmlspecialchars($lot['species'] ?? 'Hardwood') ?></span>
                        </div>
                    </div>
                    <div class="stat-card-premium">
                        <div class="stat-icon"><i class="fa fa-expand-arrows-alt"></i></div>
                        <div class="stat-meta">
                            <span class="label">Total Quantity</span>
                            <span class="value">
                                <?php 
                                    if($type == 'machinery') echo ($lot['qty'] ?? 1) . ' Pcs';
                                    else echo number_format($lot['total_cubic_feet'] ?? 0, 2) . ' ' . ($lot['unit_type'] ?? 'ft³');
                                ?>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- AI BUNDLING SUGGESTIONS -->
    <?php if(!empty($suggestions)): ?>
    <div class="glass-panel-premium">
        <div class="detail-section-header">
            <i class="fa fa-wand-magic-sparkles text-purple-500"></i> AI Smart Bundling: Recommended Services
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($suggestions as $s): ?>
            <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-3xl border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="bg-purple-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter"><?= $s['category'] ?></span>
                    <i class="fa fa-info-circle text-purple-300"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-800 mb-2"><?= $s['reason'] ?></h3>
                
                <div class="space-y-4 mt-6">
                    <?php foreach($s['providers'] as $p): ?>
                    <div class="flex items-center justify-between p-3 bg-white rounded-2xl border border-slate-100 hover:border-purple-300 transition-all cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                                <i class="fa fa-user text-slate-400"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-black text-slate-900"><?= $p['name'] ?></div>
                                <div class="flex items-center text-[10px] text-yellow-500 font-bold">
                                    <i class="fa fa-star mr-1"></i> <?= $p['rating'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer hover:bg-blue-50 transition-colors">
                                <input type="checkbox" name="insurance" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 mr-4">
                                <div class="flex-1">
                                    <span class="block font-bold text-slate-900 text-sm">Damage Protection</span>
                                    <span class="block text-[10px] text-slate-400 uppercase font-bold">Covers accidental damage during rental</span>
                                </div>
                                <span class="font-black text-slate-900 text-sm">Rs. 500</span>
                            </label>

                            <label class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer hover:bg-blue-50 transition-colors">
                                <input type="checkbox" name="bundle_unloading" id="bundle_unloading" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 mr-4">
                                <div class="flex-1">
                                    <span class="block font-bold text-slate-900 text-sm">Add Unloading Assistance</span>
                                    <span class="block text-[10px] text-slate-400 uppercase font-bold">2 Workers will arrive to unload your timber</span>
                                </div>
                                <span class="font-black text-blue-600 text-sm">Bundle Deal</span>
                            </label>
                        </div>
                        <div class="text-[11px] font-bold text-slate-400">
                            LKR <?= number_format($p['hourly_rate']) ?>/hr
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- piece detail table -->
    <div class="glass-panel-premium">
        <div class="detail-section-header">
            <i class="fa fa-list-check text-primary"></i> Detailed Inventory Breakdown
        </div>
        
        <div class="premium-table-wrapper">
             <table class="premium-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SPECIES</th>
                        <?php if($type == 'logs' || $type == 'standing'): ?>
                            <th>LENGTH (ft)</th>
                            <th>GIRTH (in)</th>
                            <th>VOLUME (ft³)</th>
                        <?php elseif($type == 'sawn'): ?>
                            <th>DIMENSIONS (W×T×L)</th>
                            <th>PCS</th>
                            <th>VOLUME (<?= $lot['unit_type'] ?? 'ft³' ?>)</th>
                        <?php else: ?>
                            <th>SPECIFICATIONS</th>
                            <th>QTY</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($lot['items'])): foreach($lot['items'] as $idx => $item): ?>
                    <tr>
                        <td><?= $idx + 1 ?></td>
                        <td class="species-label"><?= htmlspecialchars($lot['species']) ?></td>
                        <?php if($type == 'logs' || $type == 'standing'): ?>
                            <td><?= $item['length'] ?? $item['height_avg'] ?? '--' ?></td>
                            <td><?= $item['girth'] ?? $item['circumference_avg'] ?? '--' ?></td>
                            <td><?= number_format($item['cubic_feet'] ?? 0, 3) ?></td>
                        <?php elseif($type == 'sawn'): ?>
                            <td><?= ($item['width'] ?? '--') ?>" × <?= ($item['thickness'] ?? '--') ?>" × <?= ($item['length'] ?? '--') ?>'</td>
                            <td><?= $item['quantity'] ?? 0 ?></td>
                            <td><?= number_format($item['cubic_feet'] ?? 0, 3) ?></td>
                        <?php else: ?>
                            <td><?= htmlspecialchars($lot['specs'] ?? '--') ?></td>
                            <td><?= $lot['qty'] ?? 1 ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa fa-info-circle mb-2 d-block" style="font-size: 2rem;"></i>
                            Detailed piece measurements are available upon request for this lot.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function updateMainImage(src, thumb) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }

    function switchChoice(choice) {
        document.querySelectorAll('.choice-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.choice-content').forEach(c => c.classList.remove('active'));
        
        event.currentTarget.classList.add('active');
        document.getElementById(choice + '-module').classList.add('active');
    }

    // --- RENTAL LOGIC ---
    function updateRentQuote() {
        const start = document.getElementById('rent-start').value;
        const end = document.getElementById('rent-end').value;
        const insurance = document.getElementById('insurance-check').checked;

        if(!start || !end) return;

        $.ajax({
            url: '<?= base_url("shop/init_rent") ?>',
            type: 'POST',
            data: {
                id: '<?= $lot['id'] ?>',
                type: '<?= $type ?>',
                start_date: start,
                end_date: end,
                insurance: insurance
            },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'Success') {
                    document.getElementById('rental-summary-area').innerHTML = res.summary_html;
                } else {
                    alert(res.message);
                }
            }
        });
    }

    function bookRent() {
        alert('Proceeding to rental agreement and security deposit payment...');
        // Final booking logic here
    }

    // --- EMI LOGIC ---
    function updateEmiCalc() {
        const totalVal = <?= $lot['total_price'] ?? ($lot['price'] ?? 0) ?>;
        const down = parseFloat(document.getElementById('emi-down-slider').value) || 0;
        const months = parseInt(document.getElementById('emi-months-slider').value);

        document.getElementById('emi-down-label').textContent = 'LKR ' + down.toLocaleString();
        document.getElementById('emi-months-label').textContent = months + ' Months';

        const remaining = Math.max(0, totalVal - down);
        const interest = 0.08;
        const monthly = (remaining * (1 + interest)) / months;

        document.getElementById('emi-monthly-val').textContent = 'LKR ' + Math.ceil(monthly).toLocaleString();
    }

    function checkEmiEligibility() {
        const down = document.getElementById('emi-down-slider').value;
        const months = document.getElementById('emi-months-slider').value;

        $.ajax({
            url: '<?= base_url("shop/init_emi") ?>',
            type: 'POST',
            data: {
                id: '<?= $lot['id'] ?>',
                type: '<?= $type ?>',
                down_payment: down,
                months: months
            },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'Success') {
                    alert('Congratulations! You are eligible. Monthly Payment: LKR ' + res.monthly);
                } else {
                    alert(res.message);
                }
            }
        });
    }

    function buyNow() {
        if(!confirm('Confirm instant purchase of this lot?')) return;
        let url = '<?= base_url("shop/checkout/{$lot['id']}/{$type}") ?>';
        <?php if(!empty($project_id)): ?>
            url += '?project_id=<?= $project_id ?>';
        <?php endif; ?>
        window.location.href = url;
    }

    // Initial runs
    document.addEventListener('DOMContentLoaded', () => {
        updateRentQuote();
        updateEmiCalc();
    });
</script>
