<div class="content-body">
    <div class="row">
        <!-- Lot Details -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= $lot['lot_name'] ?> - Lot Details</h4>
                    <span class="badge badge-warning text-dark">ID: #<?= $lot['id'] ?></span>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-sm-4 border-right">
                            <h2 class="text-primary mb-0"><?= number_format($lot['total_cubic_feet'], 2) ?></h2>
                            <small class="text-muted uppercase">Total ft³</small>
                        </div>
                        <div class="col-sm-4 border-right">
                            <h2 class="text-success mb-0">
                                <?= ($lot['direct_price'] > 0) ? amountExchange($lot['direct_price'], 0, $this->aauth->get_user()->loc) : 'Negotiable' ?>
                            </h2>
                            <small class="text-muted uppercase">Listed Price</small>
                        </div>
                        <div class="col-sm-4">
                            <h2 class="text-info mb-0"><?= isset($lot['items']) ? count($lot['items']) : 'N/A' ?></h2>
                            <small class="text-muted uppercase">Total Pieces</small>
                        </div>
                    </div>

                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab">Specifications</a>
                        </li>
                    </ul>
                    <div class="tab-content border-left border-right border-bottom p-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="details" role="tabpanel">
                            <table class="table table-sm pb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <!-- Checkbox removed for now as partial buy is complex -->
                                        <th>#</th>
                                        <th>Length (ft)</th>
                                        <th>Girth (in)</th>
                                        <th class="text-right">Volume (ft³)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($lot['items'])) { 
                                        foreach($lot['items'] as $index => $item) { ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $item['length'] ?></td>
                                            <td><?= $item['girth'] ?></td>
                                            <td class="text-right"><?= number_format($item['cubic_feet'], 4) ?></td>
                                        </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Tools -->
        <div class="col-md-4">
            <!-- Buy Request Panel -->
            <div class="card shadow-sm border-0 mb-3 bg-white">
                <div class="card-body">
                    <h5 class="font-weight-bold text-success"><i class="fa fa-shopping-cart"></i> Purchase Request</h5>
                    <p class="text-muted small">Interested in this lot? Send a request to the seller to reveal contact details and arrange an inspection.</p>
                    
                    <div class="form-group">
                        <label class="small font-weight-bold">Your Offer / Remarks</label>
                        <textarea id="buy-remarks" class="form-control" rows="3" placeholder="E.g. I am interested in this lot. Can I inspect it tomorrow?"></textarea>
                    </div>

                    <!-- Hidden price input if we want to support counter-offers -->
                    <div class="input-group mb-3">
                         <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" id="offer-price" class="form-control" placeholder="Offer Amount (Optional)" value="<?= ($lot['direct_price'] > 0) ? $lot['direct_price'] : '' ?>">
                    </div>

                    <button class="btn btn-success btn-lg btn-block shadow-sm" onclick="sendBuyRequest()">
                        <i class="fa fa-paper-plane mr-2"></i> SEND BUY REQUEST
                    </button>
                    
                    <small class="text-center d-block mt-3 text-muted">
                        <i class="fa fa-lock"></i> Secure Transaction. Contact details revealed upon seller approval.
                    </small>
                </div>
            </div>

            <!-- Logistics Calculator -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Logistics Estimator</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Target Latitude</label>
                        <input type="text" id="target-lat" class="form-control form-control-sm" value="6.9271">
                    </div>
                    <div class="form-group">
                        <label>Target Longitude</label>
                        <input type="text" id="target-lng" class="form-control form-control-sm" value="79.8612">
                    </div>
                    <div class="bg-light p-2 rounded mb-2 text-center border">
                        <small>ESTIMATED TRANSPORT COST</small>
                        <h4 class="mb-0 text-primary" id="logistics-result">$0.00</h4>
                        <small id="distance-result">0.00 km</small>
                    </div>
                    <button class="btn btn-outline-primary btn-sm btn-block" onclick="calculateLogistics()">
                        <i class="fa fa-truck"></i> Refresh Estimate
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const lotId = '<?= $id ?>';
    const lotType = '<?= $type ?>';

    function sendBuyRequest() {
        const remarks = $('#buy-remarks').val();
        const price = $('#offer-price').val();
        
        if(!confirm('Send a purchase request to the seller?')) return;
        
        $.ajax({
            url: baseurl + 'marketplace/request_buy',
            type: 'POST',
            data: { 
                id: lotId, 
                type: lotType, 
                price: price, 
                remarks: remarks,
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>' 
            },
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    alert(data.message);
                    window.location.href = baseurl + 'marketplace/my_deals';
                } else {
                    alert(data.message);
                    if(data.redirect) window.location.href = data.redirect;
                }
            }
        });
    }

    function calculateLogistics() {
        $.ajax({
            url: baseurl + 'marketplace/calculate_logistics',
            type: 'POST',
            data: { 
                lat1: '6.0535', 
                lng1: '80.2210', 
                lat2: $('#target-lat').val(),
                lng2: $('#target-lng').val(),
                rate: 15, // $15 per KM
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>' 
            },
            dataType: 'json',
            success: function(data) {
                $('#logistics-result').text('$' + data.cost);
                $('#distance-result').text(data.distance + ' km');
            }
        });
    }
</script>
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= $lot['lot_name'] ?> - Lot Details</h4>
                    <span class="badge badge-warning text-dark">ID: #<?= $lot['id'] ?></span>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-sm-3 border-right">
                            <h2 class="text-primary mb-0"><?= number_format($lot['total_cubic_feet'], 2) ?></h2>
                            <small class="text-muted uppercase">Total ft³</small>
                        </div>
                        <div class="col-sm-3 border-right">
                            <h2 class="text-success mb-0" id="current-bid-display">
                                <?= isset($lot['latest_bid']) ? number_format($lot['latest_bid']['bid_amount'], 2) : 'No Bids' ?>
                            </h2>
                            <small class="text-muted uppercase">Highest Bid</small>
                        </div>
                        <div class="col-sm-3 border-right">
                            <h2 class="text-danger mb-0">
                                <?= ($lot['direct_price'] > 0) ? number_format($lot['direct_price'], 2) : 'N/A' ?>
                            </h2>
                            <small class="text-muted uppercase">Direct Price</small>
                        </div>
                        <div class="col-sm-3">
                            <h2 class="text-info mb-0"><?= isset($lot['items']) ? count($lot['items']) : 'N/A' ?></h2>
                            <small class="text-muted uppercase">Total Pieces</small>
                        </div>
                    </div>

                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab">Specifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bid-tab" data-toggle="tab" href="#bid-history" role="tab">Bid History</a>
                        </li>
                    </ul>
                    <div class="tab-content border-left border-right border-bottom p-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="details" role="tabpanel">
                            <table class="table table-sm pb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Length (ft)</th>
                                        <th>Girth (in)</th>
                                        <th class="text-right">Volume (ft³)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($lot['items'])) { 
                                        foreach($lot['items'] as $index => $item) { ?>
                                        <tr>
                                            <td><input type="checkbox" class="item-select" value="<?= $item['id'] ?>" data-vol="<?= $item['cubic_feet'] ?>"></td>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $item['length'] ?></td>
                                            <td><?= $item['girth'] ?></td>
                                            <td class="text-right"><?= number_format($item['cubic_feet'], 4) ?></td>
                                        </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="bid-history" role="tabpanel">
                            <p class="text-center text-muted py-4">Live bid history is synchronized every 10 seconds.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Tools -->
        <div class="col-md-4">
            <!-- Bid Input -->
            <div class="card shadow-sm border-0 mb-3 bg-light">
                <div class="card-body">
                    <h5>Place Your Bid</h5>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" id="bid-amount" class="form-control" placeholder="Enter amount">
                    </div>
                    <button class="btn btn-success btn-block" onclick="submitBid()">
                        <i class="fa fa-gavel"></i> Confirm Bid
                    </button>
                    
                    <?php if($lot['direct_price'] > 0): ?>
                    <button class="btn btn-danger btn-block mt-3 py-2 font-weight-bold" onclick="buyNow()">
                        <i class="fa fa-flash"></i> BUY IT NOW ($<?= number_format($lot['direct_price'], 2) ?>)
                    </button>
                    <?php endif; ?>

                    <div id="partial-panel" class="mt-3 p-3 bg-white border rounded shadow-sm" style="display:none;">
                        <h6 class="text-uppercase small font-weight-bold"><i class="fa fa-scissors"></i> Partial Purchase</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Selected Vol:</span>
                            <span id="selected-vol" class="font-weight-bold">0.0000 ft³</span>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                             <input type="number" id="partial-bid" class="form-control" placeholder="Your Offer $">
                        </div>
                        <button class="btn btn-warning btn-block btn-sm font-weight-bold" onclick="buyPartial()">
                            REQUEST PARTIAL
                        </button>
                    </div>

                    <small class="text-muted mt-2 d-block">By bidding, you agree to our Marketplace Terms of Service.</small>
                </div>
            </div>

            <!-- Yield recovery Calculator -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Yield Recovery Simulator</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Kerf / Waste Factor (%)</label>
                        <select id="kerf-factor" class="form-control" onchange="updateYield()">
                            <option value="0.2">20% (Optimized)</option>
                            <option value="0.3" selected>30% (Standard - Circular Saw)</option>
                            <option value="0.4">40% (Rough - Band Saw)</option>
                        </select>
                    </div>
                    <div class="bg-dark text-white p-2 rounded text-center">
                        <small>ESTIMATED RECOVERABLE SAWN VOLUME</small>
                        <h3 class="mb-0" id="yield-result">-- ft³</h3>
                    </div>
                </div>
            </div>

            <!-- Logistics Calculator -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Logistics Estimator</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Target Latitude</label>
                        <input type="text" id="target-lat" class="form-control form-control-sm" value="6.9271">
                    </div>
                    <div class="form-group">
                        <label>Target Longitude</label>
                        <input type="text" id="target-lng" class="form-control form-control-sm" value="79.8612">
                    </div>
                    <div class="bg-light p-2 rounded mb-2 text-center border">
                        <small>ESTIMATED TRANSPORT COST</small>
                        <h4 class="mb-0 text-primary" id="logistics-result">$0.00</h4>
                        <small id="distance-result">0.00 km</small>
                    </div>
                    <button class="btn btn-outline-primary btn-sm btn-block" onclick="calculateLogistics()">
                        <i class="fa fa-truck"></i> Refresh Estimate
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const lotId = '<?= $id ?>';
    const lotType = '<?= $type ?>';
    const baseVolume = <?= $lot['total_cubic_feet'] ?>;

    $(document).ready(function() {
        updateYield();
        setInterval(fetchLatestBid, 10000); // 10s AJAX Polling
    });

    function fetchLatestBid() {
        $.getJSON(baseurl + 'marketplace/get_latest_bid?id=' + lotId + '&type=' + lotType, function(data) {
            if(data && data.bid_amount) {
                $('#current-bid-display').text(parseFloat(data.bid_amount).toFixed(2));
            }
        });
    }

    function submitBid() {
        const amount = $('#bid-amount').val();
        if(!amount) return alert('Enter amount');
        
        $.ajax({
            url: baseurl + 'marketplace/place_bid',
            type: 'POST',
            data: { id: lotId, type: lotType, amount: amount, [crsf_token]: crsf_hash },
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                if(data.status == 'Success') {
                    fetchLatestBid();
                    $('#bid-amount').val('');
                }
            }
        });
    }

    function updateYield() {
        const kerf = $('#kerf-factor').val();
        const result = baseVolume * (1 - kerf);
        $('#yield-result').text(result.toFixed(2) + ' ft³');
    }

    function calculateLogistics() {
        $.ajax({
            url: baseurl + 'marketplace/calculate_logistics',
            type: 'POST',
            data: { 
                lat1: '6.0535', // Origin Lat (from TRD example)
                lng1: '80.2210', // Origin Lng
                lat2: $('#target-lat').val(),
                lng2: $('#target-lng').val(),
                rate: 15, // $15 per KM
                [crsf_token]: crsf_hash 
            },
            dataType: 'json',
            success: function(data) {
                $('#logistics-result').text('$' + data.cost);
                $('#distance-result').text(data.distance + ' km');
            }
        });
    }

    // Partial Logic
    $(document).on('change', '.item-select, #selectAll', function() {
        if($(this).attr('id') == 'selectAll') {
            $('.item-select').prop('checked', $(this).prop('checked'));
        }
        
        let checked = $('.item-select:checked');
        let vol = 0;
        checked.each(function() { vol += parseFloat($(this).data('vol')); });
        
        if(checked.length > 0 && checked.length < $('.item-select').length) {
            $('#partial-panel').fadeIn();
            $('#selected-vol').text(vol.toFixed(4) + ' ft³');
        } else {
            $('#partial-panel').fadeOut();
        }
    });

    function buyNow() {
        if(!confirm('Are you sure you want to buy this lot instantly?')) return;
        $.ajax({
            url: baseurl + 'marketplace/buy_now',
            type: 'POST',
            data: { id: lotId, type: lotType, [crsf_token]: crsf_hash },
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function buyPartial() {
        let items = [];
        $('.item-select:checked').each(function() { items.push($(this).val()); });
        const price = $('#partial-bid').val();
        if(!price) return alert('Please enter your offer price');

        if(!confirm('Submit partial purchase request?')) return;
        
        $.ajax({
            url: baseurl + 'marketplace/buy_partial',
            type: 'POST',
            data: { id: lotId, type: lotType, items: items, price: price, [crsf_token]: crsf_hash },
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    }
</script>
