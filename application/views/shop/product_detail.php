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
        font-size: 3rem;
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
    .pricing-engine {
        background: #f8fafc;
        padding: 30px;
        border-radius: 24px;
        margin-bottom: 40px;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .total-price-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 15px;
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

                <!-- Dual Pricing Display -->
                <div class="pricing-engine">
                    <div class="total-price-row">
                        <span class="price-label">Total Lot Value</span>
                        <div class="price-value-main">LKR <?= number_format($lot['total_price'] ?? ($lot['price'] ?? 0)) ?></div>
                    </div>
                    <?php if(!empty($lot['selling_price']) && $lot['selling_price'] > 0): ?>
                    <div class="unit-price-row">
                        <span class="price-label">Price per Unit</span>
                        <div class="unit-price-val">LKR <?= number_format($lot['selling_price']) ?> / <?= $lot['unit_type'] ?? 'ft³' ?></div>
                    </div>
                    <?php endif; ?>
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

                <!-- Actions -->
                <div class="master-action-box">
                    <?php if($is_logged_in): ?>
                        <button class="btn-buy-now" onclick="buyNow()">
                            <i class="fa fa-bolt"></i> INSTANT PURCHASE
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
        </div>
    </div>

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

    function buyNow() {
        if(!confirm('Confirm instant purchase of this lot?')) return;
        // Logic for buy now
    }

    function openOfferModal() {
        const amount = prompt("Enter your offer amount (LKR):");
        if(amount) {
            // Logic for bid
        }
    }
</script>
