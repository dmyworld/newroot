<div class="content-body">
    <div class="premium-input-card mb-4" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; border-radius: 12px;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="mb-0 text-white font-weight-bold"><i class="fa fa-shopping-cart mr-2"></i> MY PURCHASE REQUESTS</h4>
                <span class="small text-uppercase" style="opacity: 0.8;">Track your timber acquisitions and field verifications</span>
            </div>
            <div class="col-md-4 text-right">
                <div class="badge badge-pill badge-light text-primary px-3 py-1 font-weight-bold">BUYER DASHBOARD</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="premium-input-card">
                <div class="card-title-bar mb-3">
                    <i class="fa fa-briefcase mr-2 text-primary"></i> ACTIVE TRANSACTIONS
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: #f1f5f9;">
                            <tr>
                                <th>LOT / ITEMS</th>
                                <th>MY BID</th>
                                <th>STATUS</th>
                                <th>MUTUAL CONSENSUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($bids)): ?>
                                <tr><td colspan="5" class="text-center text-muted p-4">You have not placed any bids yet. Visit the <a href="<?= base_url('shop') ?>">Marketplace</a> to start.</td></tr>
                            <?php else: ?>
                                <?php foreach($bids as $row): ?>
                                    <tr>
                                        <td><strong><?= $row['lot_title'] ?></strong></td>
                                        <td><span class="text-success font-weight-bold"><?= amountExchange($row['bid_amount'], 0, $this->aauth->get_user()->loc) ?></span></td>
                                        <td>
                                            <?php 
                                            $badge = 'secondary';
                                            $text = $row['status'];
                                            if($row['status'] == 'approved') { $badge = 'primary'; $text = 'Ready for Measurement'; }
                                            if($row['status'] == 'measured') { $badge = 'warning'; $text = 'Awaiting Seller Agreement'; }
                                            if($row['status'] == 'sold') { $badge = 'success'; $text = 'Completed'; }
                                            ?>
                                            <span class="badge badge-<?= $badge ?> text-uppercase"><?= $text ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-user mr-1 <?= $row['buyer_agreement'] ? 'text-success' : 'text-muted' ?>" title="My Agreement"></i>
                                                <i class="fa fa-handshake-o mx-2 <?= ($row['buyer_agreement'] && $row['seller_agreement']) ? 'text-success' : 'text-muted' ?>"></i>
                                                <i class="fa fa-briefcase ml-1 <?= $row['seller_agreement'] ? 'text-success' : 'text-muted' ?>" title="Seller Agreement"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($row['status'] == 'approved'): ?>
                                                <button class="btn btn-sm btn-primary" onclick="openMeasurementGrid(<?= $row['id'] ?>)">RECORD FIELD DATA</button>
                                            <?php elseif($row['status'] == 'measured'): ?>
                                                <button class="btn btn-sm btn-outline-info" onclick="submitAgreement(<?= $row['id'] ?>)">AGREE TO DEAL</button>
                                            <?php elseif($row['status'] == 'sold'): ?>
                                                <button class="btn btn-sm btn-success" onclick="alert('Deal Closed. Transaction Recorded.')"><i class="fa fa-check"></i> SOLD</button>
                                                <?php if($row['lot_type'] == 'logs'): ?>
                                                    <a href="<?= base_url('purchase/newprocessing/0/' . $row['lot_type'] . '-' . $row['lot_id']) ?>" class="btn btn-sm btn-info"><i class="fa fa-cogs"></i> PROCESS</a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted small">Awaiting Approval</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Measurement Modal -->
<div class="modal fade" id="measureModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">FIELD MEASUREMENT RECORDING</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">Record the actual measurements as you inspect the logs in person. This data will be shared with the seller for final consensus.</p>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>LENGTH (ft)</th>
                                <th>GIRTH (in)</th>
                                <th>CF</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="measure-rows">
                            <!-- Rows -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-link text-primary btn-sm" onclick="addMeasureRow()"><i class="fa fa-plus"></i> Add Another Log</button>
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="d-block text-uppercase font-weight-bold text-muted">Field Calculated Volume</small>
                            <h3 class="mb-0 text-primary" id="modal-total-cf">0.0000 <span class="small font-weight-normal">ft³</span></h3>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-save-premium px-4" style="width: auto; background: var(--psy-blue);" onclick="saveFieldMeasurements()">SUBMIT MEASUREMENTS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let activeBidId = null;
    let measureCount = 0;

    function openMeasurementGrid(bid_id) {
        activeBidId = bid_id;
        $('#measure-rows').empty();
        measureCount = 0;
        for(let i=0; i<3; i++) addMeasureRow();
        $('#measureModal').modal('show');
    }

    function addMeasureRow() {
        measureCount++;
        const row = `
            <tr class="measure-row">
                <td>${measureCount}</td>
                <td><input type="number" step="0.1" class="form-control form-control-sm m-length" oninput="calcCF(this)"></td>
                <td><input type="number" step="0.1" class="form-control form-control-sm m-girth" oninput="calcCF(this)"></td>
                <td class="font-weight-bold text-muted m-cf">0.00</td>
                <td><i class="fa fa-times text-danger cursor-pointer" onclick="$(this).closest('tr').remove(); updateModalTotal();"></i></td>
            </tr>
        `;
        $('#measure-rows').append(row);
    }

    function calcCF(input) {
        const row = $(input).closest('tr');
        const l = parseFloat(row.find('.m-length').val()) || 0;
        const g = parseFloat(row.find('.m-girth').val()) || 0;
        let cf = 0;
        if(l > 0 && g > 0) {
            cf = Math.pow((g / 4), 2) * l / 144;
        }
        row.find('.m-cf').text(cf.toFixed(4)).removeClass('text-muted').addClass('text-primary');
        updateModalTotal();
    }

    function updateModalTotal() {
        let total = 0;
        $('.m-cf').each(function() { total += parseFloat($(this).text()) || 0; });
        $('#modal-total-cf').html(total.toFixed(4) + ' <span class="small font-weight-normal">ft³</span>');
    }

    function saveFieldMeasurements() {
        let data = [];
        $('.measure-row').each(function() {
            const l = $(this).find('.m-length').val();
            const g = $(this).find('.m-girth').val();
            const cf = $(this).find('.m-cf').text();
            if(l && g) data.push({length: l, girth: g, cf: cf});
        });

        if(data.length == 0) return alert('Please enter at least one measurement.');

        $.ajax({
            url: baseurl + 'Shop/record_measurements',
            type: 'POST',
            data: {bid_id: activeBidId, measurements: data, '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'},
            dataType: 'json',
            success: function(resp) {
                alert(resp.message);
                location.reload();
            }
        });
    }

    function submitAgreement(bid_id) {
        if(!confirm('By clicking OK, you agree that the field measurements are finalized and you are ready to complete this purchase.')) return;
        $.ajax({
            url: baseurl + 'Shop/set_agreement',
            type: 'POST',
            data: {bid_id: bid_id, role: 'buyer', state: 1, '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'},
            dataType: 'json',
            success: function(data) {
                alert('Agreement recorded! If the seller also agreed, the deal is now CLOSED.');
                location.reload();
            }
        });
    }
</script>

<style>
    .cursor-pointer { cursor: pointer; }
    .btn-save-premium {
        background: var(--psy-green);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 700;
        border: none;
        transition: all 0.2s;
    }
</style>
