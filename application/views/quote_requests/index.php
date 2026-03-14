<?php
// Public listing of all active geo-fenced quote requests
// Shown in Shop "Bidding" tab
$quote_requests = $quote_requests ?? [];
?>

<style>
.qr-card {
    background: #fff;
    border: 1.5px solid #f1f5f9;
    border-radius: 24px;
    padding: 28px;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
    animation: fadeInUp 0.45s ease backwards;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.qr-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3b82f6, #6366f1);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.qr-card:hover { box-shadow: 0 20px 50px rgba(0,0,0,.08); transform: translateY(-4px); border-color: #e0e7ff; }
.qr-card:hover::before { transform: scaleX(1); }
.status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 10px; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; padding: 5px 12px;
    border-radius: 999px;
}
.status-open { background: #ecfdf5; color: #059669; }
.status-bids_received { background: #eff6ff; color: #2563eb; }
.status-accepted { background: #faf5ff; color: #7c3aed; }
@keyframes fadeInUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
<?php for($i=1;$i<=20;$i++): ?>.qr-card:nth-child(<?= $i ?>){animation-delay:<?= $i*0.055 ?>s}<?php endfor; ?>
</style>

<div class="max-w-7xl mx-auto px-4 py-10">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Open Quotation Board</h1>
            <p class="text-slate-500 mt-1 text-sm">Buyers are looking for suppliers. Submit your best bid to win the deal.</p>
        </div>
        <?php if($is_logged_in): ?>
        <button onclick="openPostModal()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-black px-6 py-3 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
            <i class="fa fa-plus"></i> Post a Request
        </button>
        <?php else: ?>
        <a href="<?= base_url('user') ?>" class="flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white font-black px-6 py-3 rounded-2xl transition-all">
            <i class="fa fa-sign-in-alt"></i> Login to Post
        </a>
        <?php endif; ?>
    </div>

    <!-- Request Grid -->
    <?php if(empty($quote_requests)): ?>
    <div class="text-center py-24 bg-slate-50 rounded-3xl border border-slate-100">
        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-5 shadow-md">
            <i class="fa fa-clipboard-list text-3xl text-slate-300"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-700">No open requests yet</h3>
        <p class="text-slate-400 mt-2">Be the first to post a procurement request!</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php foreach($quote_requests as $i => $q): ?>
        <div class="qr-card" style="animation-delay:<?= $i * 0.055 ?>s" onclick="viewRequest(<?= $q['id'] ?>)">
            <!-- Status -->
            <div class="flex items-start justify-between mb-5">
                <span class="status-badge status-<?= $q['status'] ?>">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    <?= str_replace('_', ' ', ucfirst($q['status'])) ?>
                </span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">#RFQ<?= $q['id'] ?></span>
            </div>

            <!-- Product -->
            <h3 class="text-lg font-black text-slate-900 mb-1"><?= htmlspecialchars($q['product_name']) ?></h3>
            <p class="text-sm text-slate-500 line-clamp-2 mb-4"><?= htmlspecialchars($q['description']) ?></p>

            <!-- Meta -->
            <div class="flex flex-wrap gap-3 mb-5">
                <span class="flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <i class="fa fa-box text-blue-500"></i> Qty: <?= htmlspecialchars($q['quantity'] ?? 'N/A') ?>
                </span>
                <?php if($q['district']): ?>
                <span class="flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <i class="fa fa-map-marker-alt text-red-400"></i> <?= htmlspecialchars($q['district']) ?>
                </span>
                <?php endif; ?>
                <span class="flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <i class="fa fa-gavel text-purple-400"></i> <?= $q['bid_count'] ?> bid<?= $q['bid_count'] != 1 ? 's' : '' ?>
                </span>
            </div>

            <!-- Budget -->
            <?php if($q['budget_min'] > 0 || $q['budget_max'] > 0): ?>
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-4 mb-5 border border-blue-100">
                <span class="block text-[10px] text-blue-400 font-black uppercase tracking-widest mb-0.5">Budget Range</span>
                <span class="text-lg font-black text-slate-900">
                    Rs. <?= number_format($q['budget_min']) ?> – <?= number_format($q['budget_max']) ?>
                </span>
            </div>
            <?php endif; ?>

            <!-- Footer -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-[10px] font-black">
                        <?= strtoupper(substr($q['username'] ?? 'U', 0, 2)) ?>
                    </div>
                    <span class="text-xs text-slate-500 font-bold"><?= htmlspecialchars($q['username'] ?? 'Anonymous') ?></span>
                </div>
                <button onclick="event.stopPropagation(); submitBid(<?= $q['id'] ?>)" class="text-[10px] font-black uppercase tracking-wider bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    Bid Now
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Post Request Modal -->
<div id="postRequestModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative animate-in">
        <button onclick="closePostModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-2xl w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-100 transition-colors">&times;</button>
        <h3 class="text-2xl font-black text-slate-900 mb-2">Post a Quote Request</h3>
        <p class="text-slate-500 text-sm mb-6">Let nearby suppliers know what you need. They'll submit their best bids.</p>

        <form id="postRequestForm" class="space-y-4">
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Product / Material Needed *</label>
                <input type="text" name="product_name" required placeholder="e.g. Teak Logs, 5mm Steel Pipe..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Description</label>
                <textarea name="description" rows="2" placeholder="Describe grade, specifications, delivery needs..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30 resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Quantity</label>
                    <input type="text" name="quantity" placeholder="e.g. 200 cuft" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Radius (km)</label>
                    <input type="number" name="radius_km" value="50" min="10" max="300" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Budget Min (Rs.)</label>
                    <input type="number" name="budget_min" placeholder="0" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Budget Max (Rs.)</label>
                    <input type="number" name="budget_max" placeholder="0" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Province</label>
                    <select name="province" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                        <option value="">Any Province</option>
                        <?php foreach(['Western','Central','Southern','Northern','Eastern','North Western','North Central','Uva','Sabaragamuwa'] as $p): ?>
                        <option><?= $p ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">District</label>
                    <input type="text" name="district" placeholder="e.g. Colombo" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
                </div>
            </div>
            <input type="hidden" name="lat" id="qrLat">
            <input type="hidden" name="lng" id="qrLng">
            <div id="postRequestNotify" class="hidden text-sm font-bold p-3 rounded-xl"></div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
                Broadcast Request
            </button>
        </form>
    </div>
</div>

<!-- Bid Submission Modal -->
<div id="bidModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative">
        <button onclick="closeBidModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-2xl w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-100 transition-colors">&times;</button>
        <h3 class="text-2xl font-black text-slate-900 mb-2">Submit Your Bid</h3>
        <p class="text-slate-500 text-sm mb-6">Provide your best price. The buyer will review all bids.</p>
        <form id="bidForm" class="space-y-4">
            <input type="hidden" name="request_id" id="bidRequestId">
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Your Price (Rs.) *</label>
                <input type="number" name="amount" required placeholder="e.g. 150000" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Delivery (Days)</label>
                <input type="number" name="delivery_days" value="7" min="1" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Notes</label>
                <textarea name="notes" rows="2" placeholder="Include any terms, quality details..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/30 resize-none"></textarea>
            </div>
            <div id="bidNotify" class="hidden text-sm font-bold p-3 rounded-xl"></div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl transition-all">
                Submit Bid
            </button>
        </form>
    </div>
</div>

<script>
function openPostModal() {
    document.getElementById('postRequestModal').classList.remove('hidden');
    // Try to get GPS
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            document.getElementById('qrLat').value = pos.coords.latitude;
            document.getElementById('qrLng').value = pos.coords.longitude;
        });
    }
}
function closePostModal() { document.getElementById('postRequestModal').classList.add('hidden'); }
function submitBid(requestId) {
    document.getElementById('bidRequestId').value = requestId;
    document.getElementById('bidModal').classList.remove('hidden');
}
function closeBidModal() { document.getElementById('bidModal').classList.add('hidden'); }
function viewRequest(id) { window.location.href = '<?= base_url('quote_requests/view/') ?>' + id; }

// Post Request Form
document.getElementById('postRequestForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const notify = document.getElementById('postRequestNotify');
    const fd = new FormData(this);
    fetch('<?= base_url('quote_requests/post_request') ?>', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            notify.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'bg-red-50', 'text-red-700');
            if (d.status === 'Success') {
                notify.classList.add('bg-green-50', 'text-green-700');
                notify.textContent = d.message;
                setTimeout(() => { closePostModal(); location.reload(); }, 1500);
            } else {
                notify.classList.add('bg-red-50', 'text-red-700');
                notify.textContent = d.message;
            }
        });
});

// Bid Form
document.getElementById('bidForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const notify = document.getElementById('bidNotify');
    const fd = new FormData(this);
    fetch('<?= base_url('quote_requests/submit_bid') ?>', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            notify.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'bg-red-50', 'text-red-700');
            if (d.status === 'Success') {
                notify.classList.add('bg-green-50', 'text-green-700');
                notify.textContent = d.message;
                setTimeout(() => { closeBidModal(); location.reload(); }, 1500);
            } else {
                notify.classList.add('bg-red-50', 'text-red-700');
                notify.textContent = d.message;
            }
        });
});
</script>
