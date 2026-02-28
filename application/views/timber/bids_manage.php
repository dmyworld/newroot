<div class="content-body">
    <div class="premium-input-card mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; border-radius: 12px;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="mb-0 text-white font-weight-bold"><i class="fa fa-briefcase mr-2"></i> SALES MANAGEMENT DASHBOARD</h4>
                <span class="small text-uppercase" style="opacity: 0.8;">Review purchase requests and finalize deals</span>
            </div>
            <div class="col-md-4 text-right">
                <div class="badge badge-pill badge-success px-3 py-1 font-weight-bold">DIRECT SALES</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="premium-input-card">
                <div class="card-title-bar mb-3">
                    <i class="fa fa-list-ul mr-2 text-primary"></i> INCOMING BUY REQUESTS
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>LOT / ITEM</th>
                                <th>BUYER</th>
                                <th>OFFER / PRICE</th>
                                <th>STATUS</th>
                                <th>CONTACT INFO</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($bids)): ?>
                                <tr><td colspan="6" class="text-center text-muted p-4">No active buy requests received yet.</td></tr>
                            <?php else: ?>
                                <?php foreach($bids as $row): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $row['lot_name'] ?></strong>
                                            <?php if($row['buyer_remarks']): ?>
                                                <br><small class="text-muted"><i class="fa fa-comment-o"></i> <?= $row['buyer_remarks'] ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge badge-light"><?= $row['buyer_name'] ?></span></td>
                                        <td><h5 class="mb-0 text-primary font-weight-bold"><?= amountExchange($row['bid_amount'], 0, $this->aauth->get_user()->loc) ?></h5></td>
                                        <td>
                                            <?php 
                                            $badge = 'secondary';
                                            $status_text = ucfirst($row['status']);
                                            if($row['status'] == 'pending') { $badge = 'warning'; $status_text = 'Pending Approval'; }
                                            if($row['status'] == 'approved') { $badge = 'info'; $status_text = 'Awaiting Inspection'; }
                                            if($row['status'] == 'measured') { $badge = 'primary'; $status_text = 'Measurements Added'; }
                                            if($row['status'] == 'sold') { $badge = 'success'; $status_text = 'Sold'; }
                                            ?>
                                            <span class="badge badge-<?= $badge ?> text-uppercase"><?= $status_text ?></span>
                                        </td>
                                        <td>
                                            <?php if($row['buyer_phone_visible'] == 'yes'): ?>
                                                <div class="small">
                                                    <a href="tel:<?= $row['buyer_phone'] ?>" class="text-dark"><i class="fa fa-phone text-success"></i> <?= $row['buyer_phone'] ?></a><br>
                                                    <a href="mailto:<?= $row['buyer_email'] ?>" class="text-muted"><i class="fa fa-envelope-o"></i> <?= $row['buyer_email'] ?></a>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted small"><i class="fa fa-lock"></i> Hidden</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($row['status'] == 'pending'): ?>
                                                <button class="btn btn-sm btn-outline-primary font-weight-bold" onclick="approveRequest(<?= $row['id'] ?>)">
                                                    <i class="fa fa-check"></i> APPROVE & REVEAL CONTACT
                                                </button>
                                            <?php elseif($row['status'] == 'measured'): ?>
                                                <button class="btn btn-sm btn-info" onclick='reviewMeasurements(<?= $row['id'] ?>, <?= json_encode($row['buyer_measurements']) ?>, <?= $row['bid_amount'] ?>)'>
                                                    REVIEW & FINALIZE
                                                </button>
                                            <?php elseif($row['status'] == 'sold'): ?>
                                                <span class="text-success font-weight-bold"><i class="fa fa-check-circle"></i> DEAL CLOSED</span>
                                            <?php else: ?>
                                                <span class="text-muted small">In Progress...</span>
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

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">FINALIZE DEAL TERMS</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-4">Review the buyer's field measurements and add any final adjustments (e.g., transport costs) to close the deal.</p>
                
                <div id="measurements-display" class="table-responsive mb-4">
                    <!-- Dynamic Table -->
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Base Item Price</label>
                            <input type="text" class="form-control" id="baseItemPrice" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Add Transport / Logistics Cost</label>
                            <input type="number" class="form-control" id="transportCost" value="0.00" oninput="calcFinalTotal()">
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded border mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">FINAL TOTAL AMOUNT</h5>
                        <h3 class="mb-0 text-success font-weight-bold" id="finalTotalDisplay">0.00</h3>
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="sellerAgreeCheck">
                        <label class="custom-control-label font-weight-bold" for="sellerAgreeCheck">I confirm the measurements and price are correct. Proceed to generate Invoice/PO.</label>
                    </div>
                </div>
            </div>
            <input type="hidden" id="active-bid-id">
             <input type="hidden" id="raw-base-price">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-success font-weight-bold" onclick="submitFinalize()">FINALIZE & CLOSE DEAL</button>
            </div>
        </div>
    </div>
</div>

<script>
    function approveRequest(bid_id) {
        if(!confirm('Approve this buy request? Both parties will see contact details.')) return;
        $.ajax({
            url: baseurl + 'Shop/approve_request_buy',
            type: 'POST',
            data: {bid_id: bid_id, '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'},
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    alert(data.message);
                    location.reload();
                }
            }
        });
    }

    function reviewMeasurements(bid_id, measurements, basePrice) {
        // Handle measurements display
        let data = []; 
        try { data = typeof measurements === 'string' ? JSON.parse(measurements) : measurements; } catch(e) {}
        
        let html = '<table class="table table-bordered table-sm text-center"><thead><tr class="bg-light"><th>LENGTH (ft)</th><th>GIRTH (in)</th><th>TOTAL CF</th></tr></thead><tbody>';
        let totalVol = 0;
        if(data && data.length > 0) {
            data.forEach(m => {
                html += `<tr><td>${m.length}</td><td>${m.girth}</td><td>${m.cf}</td></tr>`;
                totalVol += parseFloat(m.cf);
            });
        } else {
             html += `<tr><td colspan="3" class="text-muted">No specific measurements recorded.</td></tr>`;
        }
        html += `<tr class="bg-light font-weight-bold"><td colspan="2">TOTAL VOLUME</td><td>${totalVol.toFixed(4)} ft³</td></tr></tbody></table>`;
        
        $('#measurements-display').html(html);
        $('#active-bid-id').val(bid_id);
        $('#raw-base-price').val(basePrice);
        $('#baseItemPrice').val(basePrice);
        calcFinalTotal();
        
        $('#reviewModal').modal('show');
    }

    function calcFinalTotal() {
        const base = parseFloat($('#raw-base-price').val()) || 0;
        const transport = parseFloat($('#transportCost').val()) || 0;
        const total = base + transport;
        $('#finalTotalDisplay').text(total.toFixed(2));
    }

    function submitFinalize() {
        if(!$('#sellerAgreeCheck').is(':checked')) return alert('Please check the confirmation box.');
        
        const bid_id = $('#active-bid-id').val();
         const transport = parseFloat($('#transportCost').val()) || 0;
         const final_total = parseFloat($('#finalTotalDisplay').text()) || 0;

        $.ajax({
            url: baseurl + 'Shop/finalize_deal',
            type: 'POST',
            data: {
                bid_id: bid_id, 
                transport_cost: transport,
                final_total: final_total,
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                location.reload();
            }
        });
    }
</script>
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="mb-0 text-white font-weight-bold"><i class="fa fa-gavel mr-2"></i> SELLER BID CONTROL CENTER</h4>
                <span class="small text-uppercase" style="opacity: 0.8;">Manage incoming offers and finalize deals</span>
            </div>
            <div class="col-md-4 text-right">
                <div class="badge badge-pill badge-primary px-3 py-1">REAL-TIME OFFERS</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="premium-input-card">
                <div class="card-title-bar mb-3">
                    <i class="fa fa-list-ul mr-2 text-primary"></i> INCOMING BID QUEUE
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>LOT NAME</th>
                                <th>BUYER</th>
                                <th>BID AMOUNT</th>
                                <th>STATUS</th>
                                <th>MUTUAL AGREEMENT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($bids)): ?>
                                <tr><td colspan="6" class="text-center text-muted p-4">No active bids received yet.</td></tr>
                            <?php else: ?>
                                <?php foreach($bids as $row): ?>
                                    <tr>
                                        <td><strong><?= $row['lot_name'] ?></strong></td>
                                        <td><span class="badge badge-light"><?= $row['buyer_name'] ?></span></td>
                                        <td><h5 class="mb-0 text-primary font-weight-bold"><?= amountExchange($row['bid_amount'], 0, $this->aauth->get_user()->loc) ?></h5></td>
                                        <td>
                                            <?php 
                                            $badge = 'secondary';
                                            if($row['status'] == 'approved') $badge = 'info';
                                            if($row['status'] == 'measured') $badge = 'warning';
                                            if($row['status'] == 'sold') $badge = 'success';
                                            ?>
                                            <span class="badge badge-<?= $badge ?> text-uppercase"><?= $row['status'] ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-user mr-1 <?= $row['buyer_agreement'] ? 'text-success' : 'text-muted' ?>" title="Buyer Agreement"></i>
                                                <i class="fa fa-handshake-o mx-2 <?= ($row['buyer_agreement'] && $row['seller_agreement']) ? 'text-success' : 'text-muted' ?>"></i>
                                                <i class="fa fa-briefcase ml-1 <?= $row['seller_agreement'] ? 'text-success' : 'text-muted' ?>" title="Seller Agreement"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($row['status'] == 'pending'): ?>
                                                <button class="btn btn-sm btn-outline-primary font-weight-bold" onclick="updateStatus(<?= $row['id'] ?>, 'approved')">APPROVE BID</button>
                                            <?php elseif($row['status'] == 'measured'): ?>
                                                <button class="btn btn-sm btn-info" onclick="reviewMeasurements(<?= $row['id'] ?>, '<?= addslashes($row['buyer_measurements']) ?>')">REVIEW MEASUREMENTS</button>
                                            <?php elseif($row['status'] == 'sold'): ?>
                                                <span class="text-success font-weight-bold"><i class="fa fa-check-circle"></i> DEAL CLOSED</span>
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

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">BUYER FIELD MEASUREMENTS REVIEW</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-4">The buyer has recorded the following measurements at the field. Please verify if these match your records before providing final agreement.</p>
                <div id="measurements-display" class="table-responsive">
                    <!-- Dynamic Table -->
                </div>
                
                <div class="mt-4 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="sellerAgreeCheck">
                        <label class="custom-control-label font-weight-bold" for="sellerAgreeCheck">I confirm that these field measurements are accurate and I agree to close this deal.</label>
                    </div>
                </div>
            </div>
            <input type="hidden" id="active-bid-id">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-success font-weight-bold" onclick="submitAgreement()">SUBMIT FINAL AGREEMENT</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatus(bid_id, status) {
        if(!confirm('Are you sure you want to ' + status + ' this bid? This will hide the lot from the marketplace.')) return;
        $.ajax({
            url: baseurl + 'Shop/update_bid_status',
            type: 'POST',
            data: {bid_id: bid_id, status: status, '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'},
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    alert(data.message);
                    location.reload();
                }
            }
        });
    }

    function reviewMeasurements(bid_id, measurements) {
        const data = JSON.parse(measurements);
        let html = '<table class="table table-bordered table-sm text-center"><thead><tr class="bg-light"><th>LENGTH (ft)</th><th>GIRTH (in)</th><th>TOTAL CF</th></tr></thead><tbody>';
        let total = 0;
        data.forEach(m => {
            html += `<tr><td>${m.length}</td><td>${m.girth}</td><td>${m.cf}</td></tr>`;
            total += parseFloat(m.cf);
        });
        html += `<tr class="bg-light font-weight-bold"><td colspan="2">TOTAL ACCUMULATED VOLUME</td><td>${total.toFixed(4)} ft³</td></tr></tbody></table>`;
        $('#measurements-display').html(html);
        $('#active-bid-id').val(bid_id);
        $('#reviewModal').modal('show');
    }

    function submitAgreement() {
        if(!$('#sellerAgreeCheck').is(':checked')) return alert('Please check the agreement box first.');
        const bid_id = $('#active-bid-id').val();
        $.ajax({
            url: baseurl + 'Shop/set_agreement',
            type: 'POST',
            data: {bid_id: bid_id, role: 'seller', state: 1, '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'},
            dataType: 'json',
            success: function(data) {
                alert('Agreement recorded! If the buyer also agreed, the deal is now CLOSED.');
                location.reload();
            }
        });
    }
</script>
