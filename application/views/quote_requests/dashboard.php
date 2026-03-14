<?php
// Buyer's personal Kanban dashboard for managing their quote requests.
$my_requests = $my_requests ?? [];

// Group by status
$kanban_cols = [
    'open'           => ['label' => 'Open',          'icon' => 'fa-broadcast-tower', 'color' => 'emerald', 'items' => []],
    'bids_received'  => ['label' => 'Bids Received', 'icon' => 'fa-gavel',           'color' => 'blue',    'items' => []],
    'accepted'       => ['label' => 'Accepted',       'icon' => 'fa-handshake',       'color' => 'violet',  'items' => []],
    'completed'      => ['label' => 'Completed',      'icon' => 'fa-check-circle',    'color' => 'slate',   'items' => []],
];
foreach ($my_requests as $r) {
    $s = $r['status'] ?? 'open';
    if (isset($kanban_cols[$s])) $kanban_cols[$s]['items'][] = $r;
    else $kanban_cols['open']['items'][] = $r;
}
?>

<style>
:root { --card-radius: 20px; }
.kanban-col {
    min-height: 420px;
    border-radius: 24px;
    padding: 20px;
    border: 1.5px solid #f1f5f9;
    background: #fafbfc;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.kanban-card {
    background: #fff;
    border-radius: var(--card-radius);
    padding: 18px;
    border: 1.5px solid #f1f5f9;
    cursor: grab;
    transition: all .3s ease;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.kanban-card:hover { box-shadow: 0 12px 28px rgba(0,0,0,.09); transform: translateY(-2px); border-color: #e0e7ff; }
.kanban-card.dragging { opacity: .5; cursor: grabbing; }
.kanban-col.drag-over { background: #eff6ff; border-color: #93c5fd; }
.col-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em;
    padding: 4px 10px; border-radius: 999px;
}
.col-emerald .col-badge{ background:#ecfdf5; color:#059669; }
.col-blue    .col-badge{ background:#eff6ff; color:#2563eb; }
.col-violet  .col-badge{ background:#f5f3ff; color:#7c3aed; }
.col-slate   .col-badge{ background:#f8fafc; color:#475569; border:1px solid #e2e8f0; }
.bid-pill {
    display:inline-flex; align-items:center; gap:4px;
    background:#eff6ff; color:#1d4ed8; border-radius:999px; padding:3px 9px;
    font-size:10px; font-weight:800;
}
</style>

<div class="max-w-7xl mx-auto px-4 py-10">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Quote Board</h1>
            <p class="text-slate-500 mt-1 text-sm">Drag cards across columns to update their status.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= base_url('quote_requests') ?>" class="flex items-center gap-2 text-slate-600 hover:text-blue-600 font-bold text-sm px-4 py-2.5 rounded-xl border border-slate-200 hover:border-blue-200 transition-all bg-white">
                <i class="fa fa-list"></i> All Requests
            </a>
            <button onclick="document.getElementById('postRequestModal').classList.remove('hidden')" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-black px-5 py-2.5 rounded-xl shadow-md shadow-blue-200 transition-all">
                <i class="fa fa-plus"></i> New Request
            </button>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <?php foreach ($kanban_cols as $status => $col): ?>
        <div class="kanban-col col-<?= $col['color'] ?>" id="col-<?= $status ?>" data-status="<?= $status ?>" 
             ondragover="event.preventDefault(); this.classList.add('drag-over')"
             ondragleave="this.classList.remove('drag-over')"
             ondrop="handleDrop(event, '<?= $status ?>')">
            
            <!-- Column Header -->
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-500">
                        <i class="fa <?= $col['icon'] ?> text-xs"></i>
                    </div>
                    <span class="font-black text-slate-700 text-sm"><?= $col['label'] ?></span>
                </div>
                <span class="col-badge col-<?= $col['color'] ?>">
                    <?= count($col['items']) ?>
                </span>
            </div>

            <!-- Cards -->
            <?php if(empty($col['items'])): ?>
            <div class="flex flex-col items-center justify-center text-center py-10 opacity-40">
                <i class="fa fa-inbox text-2xl text-slate-300 mb-2"></i>
                <p class="text-xs font-bold text-slate-400">No items here</p>
            </div>
            <?php endif; ?>

            <?php foreach($col['items'] as $r): ?>
            <div class="kanban-card" draggable="true" id="card-<?= $r['id'] ?>"
                 ondragstart="handleDragStart(event, <?= $r['id'] ?>)">
                
                <div class="flex items-start justify-between mb-2">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">#RFQ<?= $r['id'] ?></span>
                    <?php if($r['bid_count'] > 0): ?>
                    <span class="bid-pill"><i class="fa fa-gavel"></i> <?= $r['bid_count'] ?> bid<?= $r['bid_count'] != 1 ? 's' : '' ?></span>
                    <?php endif; ?>
                </div>
                
                <h4 class="font-black text-slate-900 text-sm mb-1"><?= htmlspecialchars($r['product_name']) ?></h4>
                <p class="text-xs text-slate-400 font-medium line-clamp-2 mb-3"><?= htmlspecialchars($r['description']) ?></p>
                
                <?php if($r['district']): ?>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500 mb-3">
                    <i class="fa fa-map-marker-alt text-red-400"></i> <?= htmlspecialchars($r['district']) ?>
                    <?php if($r['province']): ?>, <?= htmlspecialchars($r['province']) ?><?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if($r['budget_max'] > 0): ?>
                <div class="text-xs font-black text-slate-600 mb-3">
                    Budget: <span class="text-blue-600">Rs. <?= number_format($r['budget_min']) ?> – <?= number_format($r['budget_max']) ?></span>
                </div>
                <?php endif; ?>

                <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                    <span class="text-[10px] text-slate-400 font-bold"><?= date('M j', strtotime($r['created_at'])) ?></span>
                    <?php if($r['bid_count'] > 0 && $status !== 'completed'): ?>
                    <button onclick="viewBids(<?= $r['id'] ?>)" class="text-[10px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-wider">
                        View Bids →
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bids Modal -->
<div id="bidsModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl p-8 relative max-h-[80vh] overflow-y-auto">
        <button onclick="document.getElementById('bidsModal').classList.add('hidden')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-2xl w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-100">&times;</button>
        <h3 class="text-xl font-black text-slate-900 mb-1">Received Bids</h3>
        <p class="text-slate-400 text-sm mb-6">Click "Accept" on your preferred bid to finalize this deal.</p>
        <div id="bidsContainer" class="space-y-4">
            <div class="text-center py-8 text-slate-400">Loading...</div>
        </div>
    </div>
</div>

<!-- Post Request Modal (inline) -->
<div id="postRequestModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative">
        <button onclick="document.getElementById('postRequestModal').classList.add('hidden')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-2xl w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-100">&times;</button>
        <h3 class="text-2xl font-black text-slate-900 mb-6">New Quote Request</h3>
        <form id="kdPostForm" class="space-y-4">
            <input type="text" name="product_name" required placeholder="Product / Material *" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
            <textarea name="description" rows="2" placeholder="Description / Specifications" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700 resize-none"></textarea>
            <div class="grid grid-cols-2 gap-3">
                <input type="text" name="quantity" placeholder="Quantity" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                <input type="text" name="district" placeholder="District" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                <input type="number" name="budget_min" placeholder="Budget Min (Rs.)" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                <input type="number" name="budget_max" placeholder="Budget Max (Rs.)" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
            </div>
            <div id="kdNotify" class="hidden text-sm font-bold p-3 rounded-xl"></div>
            <button type="submit" class="w-full bg-blue-600 text-white font-black py-3.5 rounded-2xl">Broadcast Request</button>
        </form>
    </div>
</div>

<script>
let draggedCardId = null;

function handleDragStart(e, id) {
    draggedCardId = id;
    e.dataTransfer.setData('text/plain', id);
    document.getElementById(`card-${id}`).classList.add('dragging');
}

function handleDrop(e, newStatus) {
    e.preventDefault();
    const col = document.getElementById(`col-${newStatus}`);
    col.classList.remove('drag-over');
    if (!draggedCardId) return;
    document.getElementById(`card-${draggedCardId}`).classList.remove('dragging');

    fetch('<?= base_url('quote_requests/update_status') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `request_id=${draggedCardId}&status=${newStatus}`
    })
    .then(r => r.json())
    .then(d => { if (d.status === 'Success') location.reload(); });
    draggedCardId = null;
}

function viewBids(requestId) {
    const modal = document.getElementById('bidsModal');
    modal.classList.remove('hidden');
    const container = document.getElementById('bidsContainer');
    container.innerHTML = '<div class="text-center py-8 text-slate-400"><i class="fa fa-spinner fa-spin text-2xl"></i></div>';

    fetch(`<?= base_url('quote_requests/get_bids') ?>?request_id=${requestId}`)
        .then(r => r.json())
        .then(bids => {
            if (!bids.length) {
                container.innerHTML = '<div class="text-center py-8 text-slate-400">No bids yet.</div>';
                return;
            }
            container.innerHTML = bids.map((b, i) => `
                <div class="p-5 rounded-2xl border-2 ${i===0 ? 'border-blue-200 bg-blue-50' : 'border-slate-100 bg-white'}">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">${i===0?'<span class="text-blue-600">★ Best Bid</span>':'Bid #'+(i+1)}</div>
                            <div class="text-2xl font-black text-slate-900">Rs. ${parseInt(b.amount).toLocaleString()}</div>
                        </div>
                        <button onclick="acceptBid(${b.id}, ${requestId})" class="bg-blue-600 text-white font-black text-xs px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">Accept</button>
                    </div>
                    <div class="text-sm text-slate-600 font-medium mb-2">${b.notes || 'No notes provided'}</div>
                    <div class="flex gap-3">
                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            <i class="fa fa-truck mr-1"></i> ${b.delivery_days} days delivery
                        </span>
                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            <i class="fa fa-user mr-1"></i> ${b.username || 'Seller'}
                        </span>
                    </div>
                </div>
            `).join('');
        });
}

function acceptBid(bidId, requestId) {
    if (!confirm('Accept this bid and finalize the deal?')) return;
    fetch('<?= base_url('quote_requests/accept_bid') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `bid_id=${bidId}&request_id=${requestId}`
    })
    .then(r => r.json())
    .then(d => {
        if (d.status === 'Success') {
            alert(d.message);
            location.reload();
        } else {
            alert(d.message);
        }
    });
}

// Quick post form
document.getElementById('kdPostForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const notify = document.getElementById('kdNotify');
    fetch('<?= base_url('quote_requests/post_request') ?>', { method: 'POST', body: new FormData(this) })
        .then(r => r.json())
        .then(d => {
            notify.classList.remove('hidden');
            notify.className = `text-sm font-bold p-3 rounded-xl ${d.status === 'Success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'}`;
            notify.textContent = d.message;
            if (d.status === 'Success') setTimeout(() => location.reload(), 1200);
        });
});
</script>
