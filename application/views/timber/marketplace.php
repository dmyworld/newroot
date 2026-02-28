<div class="content-body">
    <div class="timber-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
        <h1><i class="fa fa-shopping-cart"></i> Timber Marketplace</h1>
        <p>Browse premium timber lots and place your bids in real-time.</p>
    </div>

    <div class="row mt-4">
        <?php if(empty($lots)) { ?>
            <div class="col-12 text-center">
                <div class="card p-5">
                    <i class="fa fa-search fa-4x text-muted mb-3"></i>
                    <h3>No Active Lots Found</h3>
                    <p>Check back later for new exclusive timber opportunities.</p>
                </div>
            </div>
        <?php } else { ?>
            <?php foreach($lots as $lot) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card lot-card shadow-sm border-0 h-100 overflow-hidden">
                        <div class="lot-badge bg-warning text-dark px-2 py-1 position-absolute" style="top:10px; right:10px; border-radius:3px; font-weight:bold; font-size:12px;">
                            ACTIVE AUCTION
                        </div>
                        <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center" style="height:150px; background-image: url('<?= base_url() ?>app-assets/images/backgrounds/wood-texture.jpg'); background-size: cover;">
                            <h3 class="mb-0 text-shadow"><?= $lot['lot_name'] ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fa fa-cube"></i> Total Volume</span>
                                <span class="badge badge-info"><?= number_format($lot['total_cubic_feet'], 2) ?> ft³</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fa fa-calendar"></i> Posted On</span>
                                <span><?= date('M d, Y', strtotime($lot['created_at'])) ?></span>
                            </div>
                            <hr>
                            <a href="<?= base_url('marketplace/view/logs/' . $lot['id']) ?>" class="btn btn-primary btn-block">
                                <i class="fa fa-eye"></i> View & Bid
                            </a>
                            <button onclick="openShareModal('logs', <?= $lot['id'] ?>)" class="btn btn-outline-success btn-block mt-2">
                                <i class="fa fa-share-alt"></i> Broadcast Ad
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<div id="modalContainer"></div>

<script>
    function openShareModal(type, id) {
        $('#modalContainer').load('<?= base_url('Marketing/share_modal/') ?>' + type + '/' + id, function() {
            $('#marketingShareModal').modal('show');
        });
    }
</script>

<style>
    .lot-card { transition: transform 0.3s ease; }
    .lot-card:hover { transform: translateY(-5px); }
    .text-shadow { text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
</style>
