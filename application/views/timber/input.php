<div class="content-body">
    <!-- Premium Header -->
    <div class="command-center-hud p-3 mb-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white; border-radius: 12px; box-shadow: 0 10px 20px rgba(30, 58, 138, 0.2);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-lighten-4 rounded-circle p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa fa-tree text-primary font-large-1"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-white font-weight-bold">TIMBERPRO INPUT</h4>
                        <span class="small" style="opacity: 0.8;">MOBILE-READY PRECISION DATA ENTRY v3.0</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right d-none d-md-block">
                <div class="badge badge-pill badge-success px-2 py-1">LOCATION-AWARE + GRID ENABLED</div>
            </div>
        </div>
    </div>

    <!-- Global Location Selection -->
    <div class="premium-input-card mb-4" style="border-left: 5px solid var(--psy-blue);">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label class="text-uppercase small font-weight-bold text-muted"><i class="fa fa-building mr-1"></i> Business Location / Warehouse</label>
                <select id="global-warehouse" class="form-control-premium select2">
                    <?php foreach ($warehouse as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-8">
                <p class="small text-muted mb-0 mt-2 mt-md-0"><i class="fa fa-info-circle mr-1"></i> Select the warehouse where this batch will be received or located. This applies to all timber models below.</p>
            </div>
        </div>
    </div>

    <!-- Mobile-First Model Selector -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="model-scroll-container d-flex flex-nowrap overflow-auto pb-2 px-1">
                <div class="model-nav-item active" onclick="switchModel('standing')" id="nav-standing">
                    <i class="fa fa-leaf"></i>
                    <span>STANDING</span>
                </div>
                <div class="model-nav-item" onclick="switchModel('logged')" id="nav-logged">
                    <i class="fa fa-cubes"></i>
                    <span>LOGS</span>
                </div>
                <div class="model-nav-item" onclick="switchModel('sawn')" id="nav-sawn">
                    <i class="fa fa-th-large"></i>
                    <span>SAWN</span>
                </div>
                <div class="model-nav-item" onclick="switchModel('machinery')" id="nav-machinery">
                    <i class="fa fa-cog"></i>
                    <span>MACHINERY</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Forms Container -->
    <div class="row">
        <div class="col-12">
            <!-- Model A: Standing Trees (GRID) -->
            <div id="model-standing" class="premium-input-card model-section">
                <div class="card-title-bar d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-leaf text-success mr-2"></i> Model A: Standing Trees Grid</span>
                    <span class="badge badge-primary">MANUAL ADD ROW</span>
                </div>
                <form id="form-standing" enctype="multipart/form-data">
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group-premium">
                                <label>Lot Identification Name</label>
                                <input type="text" name="lot_name" class="form-control-premium" placeholder="e.g. FOREST_BATCH_A">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-premium">
                                <label>Source District</label>
                                <select name="district" class="form-control-premium select2">
                                    <option value="">Select District</option>
                                    <?php 
                                    $districts = ["Ampara", "Anuradhapura", "Badulla", "Batticaloa", "Colombo", "Galle", "Gampaha", "Hambantota", "Jaffna", "Kalutara", "Kandy", "Kegalle", "Kilinochchi", "Kurunegala", "Mannar", "Matale", "Matara", "Moneragala", "Mullaitivu", "Nuwara Eliya", "Polonnaruwa", "Puttalam", "Ratnapura", "Trincomalee", "Vavuniya"];
                                    foreach($districts as $d) echo "<option value='$d'>$d</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-premium">
                                <label>Total Lot Value (LKR)</label>
                                <input type="number" step="0.01" name="total_price" id="standing-total-price" class="form-control-premium" placeholder="0.00" readonly>
                                <input type="hidden" name="selling_price" id="standing-unit-price" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group-premium">
                                <label>GPS Location</label>
                                <div class="input-group">
                                    <input type="text" name="location_gps" id="standing-gps" class="form-control-premium" placeholder="Auto-detecting...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" onclick="getGPS('standing-gps')"><i class="fa fa-map-marker"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="log-table-wrapper mt-3">
                        <table class="premium-log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CATEGORY</th>
                                    <th>COUNT</th>
                                    <th>GIRTH (in)</th>
                                    <th>HEIGHT (ft)</th>
                                    <th>UNIT PRICE</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="standing-rows">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-link btn-sm text-success" onclick="addStandingRow()"><i class="fa fa-plus-circle"></i> Add Tree Row</button>
                    </div>
                    
                    <div class="photo-upload-container mt-3">
                        <label class="d-block mb-2"><i class="fa fa-camera mr-1"></i> Capture Evidence Photos</label>
                        <div class="photo-grid" id="standing-photo-grid">
                            <div class="photo-add-box" onclick="$('#standing-photos').click()">
                                <i class="fa fa-plus-circle"></i>
                                <span>ADD PHOTO</span>
                            </div>
                        </div>
                        <input type="file" name="photos[]" id="standing-photos" multiple style="display:none;" onchange="previewPhotos(this, 'standing-photo-grid')">
                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-save-premium" onclick="initiateShare('standing')">
                            <i class="fa fa-share-alt mr-1"></i> REVIEW & BROADCAST TO LIST
                        </button>
                    </div>
                </form>
            </div>

            <!-- Model B: Log Matrix Grid (DYNAMIC GROW) -->
            <div id="model-logged" class="premium-input-card model-section" style="display:none;">
                <div class="card-title-bar d-flex justify-content-between align-items-center text-warning">
                    <span><i class="fa fa-cubes text-warning mr-2"></i> Model B: Log Matrix</span>
                    <button type="button" class="btn btn-scan-premium btn-sm" onclick="$('#log-photo-input').click()">
                        <i class="fa fa-magic"></i> AI SMART SCAN
                    </button>
                </div>
                <input type="file" id="log-photo-input" style="display:none;" onchange="handleOCR(this)">
                
                <form id="form-logs">
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group-premium">
                                <label>Lot Identification Name</label>
                                <input type="text" name="lot_name" class="form-control-premium" placeholder="e.g. ESTATE_LOT_01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-premium">
                                <label>Source District</label>
                                <select name="district" class="form-control-premium select2">
                                    <option value="">Select District</option>
                                    <?php 
                                    foreach($districts as $d) echo "<option value='$d'>$d</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group-premium">
                                <label>Total Value (LKR)</label>
                                <input type="number" step="0.01" name="total_price" id="log-total-price" class="form-control-premium" placeholder="0.00" readonly>
                                <input type="hidden" name="selling_price" id="log-unit-price" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                             <div class="form-group-premium">
                                <label>GPS Location</label>
                                <div class="input-group">
                                    <input type="text" name="location_gps" id="log-gps" class="form-control-premium" placeholder="Click icon ->">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" onclick="getGPS('log-gps')"><i class="fa fa-map-marker"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="log-table-wrapper mt-3">
                        <table class="premium-log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>L (ft)</th>
                                    <th>G (in)</th>
                                    <th>VOLUME (ft³)</th>
                                    <th>UNIT PRICE</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="log-rows">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-link btn-sm text-primary" onclick="addLogRow()"><i class="fa fa-plus"></i> Manual Add Row</button>
                    </div>

                    <div class="row mt-3 align-items-center">
                        <div class="col-md-6">
                            <div class="photo-upload-container">
                                <div class="photo-grid" id="log-photo-grid">
                                    <div class="photo-add-box" onclick="$('#log-photos').click()">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>
                                <input type="file" name="photos[]" id="log-photos" multiple style="display:none;" onchange="previewPhotos(this, 'log-photo-grid')">
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="cubic-badge mb-2">
                                <small>TOTAL ACCUMULATED VOLUME</small>
                                <h2 class="mb-0" id="total-cf">0.0000 <span class="small font-weight-normal">ft³</span></h2>
                            </div>
                            <button type="button" class="btn btn-save-premium" onclick="initiateShare('logs')">
                                <i class="fa fa-share-alt mr-1"></i> REVIEW & BROADCAST TO LIST
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Model C: Sawn Timber (GRID) -->
            <div id="model-sawn" class="premium-input-card model-section" style="display:none;">
                <div class="card-title-bar d-flex justify-content-between align-items-center text-primary">
                    <span><i class="fa fa-th-large text-primary mr-2"></i> Model C: Sawn Timber Grid</span>
                    <span class="badge badge-primary">MANUAL ADD ROW</span>
                </div>
                <form id="form-sawn">
                    <div class="row mt-3">
                        <div class="col-md-3">
                             <div class="form-group-premium">
                                <label>Lot Identification Name</label>
                                <input type="text" name="lot_name" class="form-control-premium" placeholder="e.g. MILL_BATCH_X">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-premium">
                                <label>Source District</label>
                                <select name="district" class="form-control-premium select2">
                                    <option value="">Select District</option>
                                    <?php 
                                    foreach($districts as $d) echo "<option value='$d'>$d</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-premium">
                                <label>Pricing Unit</label>
                                <select name="unit_type" id="sawn-unit-type" class="form-control-premium" onchange="updateSawnTotalPricing()">
                                    <option value="cubic_ft">Cubic Feet (ft³)</option>
                                    <option value="linear_ft">Linear Feet (දික්කඩි)</option>
                                    <option value="square_ft">Square Feet (වර්ග අඩි)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                             <div class="form-group-premium">
                                <label>Total Lot Value (LKR)</label>
                                <input type="number" step="0.01" name="total_price" id="sawn-total-price" class="form-control-premium" placeholder="0.00" readonly>
                                <input type="hidden" name="selling_price" id="sawn-unit-price" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                             <div class="form-group-premium">
                                <label>GPS Location</label>
                                <div class="input-group">
                                    <input type="text" name="location_gps" id="sawn-gps" class="form-control-premium" placeholder="Tap icon to detect location ->">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" onclick="getGPS('sawn-gps')"><i class="fa fa-map-marker"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="log-table-wrapper mt-3">
                        <table class="premium-log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SPECIES</th>
                                    <th>W×T (in)</th>
                                    <th>L (ft)</th>
                                    <th>PCS</th>
                                    <th>UNIT PRICE</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="sawn-rows">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-link btn-sm text-primary" onclick="addSawnRow()"><i class="fa fa-plus-circle"></i> Add Sawn Row</button>
                    </div>
                    
                    <div class="row mt-4 align-items-center">
                        <div class="col-md-6">
                            <div class="photo-upload-container">
                                <div class="photo-grid" id="sawn-photo-grid">
                                    <div class="photo-add-box" onclick="$('#sawn-photos').click()">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>
                                <input type="file" name="photos[]" id="sawn-photos" multiple style="display:none;" onchange="previewPhotos(this, 'sawn-photo-grid')">
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="cubic-badge mb-2 bg-info" style="border-color: #0ea5e9;">
                                <small>TOTAL SAWN VOLUME</small>
                                <h2 class="mb-0 text-white" id="sawn-cf">0.0000 <span>ft³</span></h2>
                            </div>
                            <button type="button" class="btn btn-save-premium" style="background: #0ea5e9;" onclick="initiateShare('sawn')">
                                <i class="fa fa-share-alt mr-1"></i> REVIEW & BROADCAST TO LIST
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Model D: Machinery (Persisted now) -->
            <div id="model-machinery" class="premium-input-card model-section" style="display:none;">
                <div class="card-title-bar text-danger">
                    <i class="fa fa-cog text-danger mr-2"></i> Model D: Machinery & Specialized Creations
                </div>
                <form id="form-machinery">
                    <div class="row mt-3">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label>Asset/Creation Name</label>
                                        <input type="text" name="item_name" class="form-control-premium" placeholder="e.g. Custom Oak Bench v2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label>Source District</label>
                                        <select name="district" class="form-control-premium select2">
                                            <option value="">Select District</option>
                                            <?php 
                                            foreach($districts as $d) echo "<option value='$d'>$d</option>";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-premium">
                                        <label>Quantity (කෑලි ප්රමාණය)</label>
                                        <input type="number" name="qty" id="mach-qty" class="form-control-premium" value="1" oninput="updateMachTotalPricing()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-premium">
                                        <label>Price per Piece</label>
                                        <input type="number" step="0.01" name="selling_price" id="mach-unit-price" class="form-control-premium" placeholder="0.00" oninput="updateMachTotalPricing()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-premium">
                                        <label>Total Value (LKR)</label>
                                        <input type="number" step="0.01" name="total_price" id="mach-total-price" class="form-control-premium" placeholder="0.00" readonly>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group-premium">
                                <label>GPS Location</label>
                                <div class="input-group">
                                    <input type="text" name="location_gps" id="mach-gps" class="form-control-premium" placeholder="Location of asset...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" onclick="getGPS('mach-gps')"><i class="fa fa-map-marker"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-premium">
                                <label>Detailed Specifications</label>
                                <textarea name="specs" class="form-control-premium" rows="5" placeholder="Dimensions, Wood source, Finishing details..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="d-block mb-2"><i class="fa fa-image mr-1"></i> Showcase Gallery (High-Res)</label>
                            <div class="photo-grid" id="machinery-photo-grid" style="grid-template-columns: repeat(2, 1fr);">
                                <div class="photo-add-box" style="height: 120px;" onclick="$('#mach-photos').click()">
                                    <i class="fa fa-cloud-upload fa-2x"></i>
                                    <span>UPLOAD GALLERY</span>
                                </div>
                            </div>
                            <input type="file" name="photos[]" id="mach-photos" multiple style="display:none;" onchange="previewPhotos(this, 'machinery-photo-grid')">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-save-premium" style="background: #ef4444;" onclick="initiateShare('machinery')">
                            <i class="fa fa-share-alt mr-1"></i> REVIEW & BROADCAST TO LIST
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Share Modal with Auto-Broadcast -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-dark text-white p-3">
                <h5 class="modal-title font-weight-bold"><i class="fa fa-share-alt mr-2"></i> BROADCAST AD GENERATOR</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <p class="text-uppercase small font-weight-bold text-muted mb-3">Live Ad Preview</p>
                        <div id="poster-preview-container" class="text-center bg-white p-2 rounded shadow-sm" style="min-height: 300px; display: flex; align-items: center; justify-content: center;">
                            <div id="preview-placeholder">
                                <i class="fa fa-image fa-4x text-light mb-2"></i>
                                <p class="small text-muted">Awaiting Data...</p>
                            </div>
                            <img id="modal-live-poster" src="" class="img-fluid rounded shadow-sm" style="display:none;" alt="Ad Preview">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="power-share-hub bg-dark p-3 rounded mb-3 text-left">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small font-weight-bold text-white"><i class="fa fa-wifi mr-1"></i> NETWORK STATUS</span>
                                <span class="badge badge-success px-2">ONLINE</span>
                            </div>
                            <div class="group-list" style="max-height: 120px; overflow-y: auto;">
                                <div class="group-item d-flex align-items-center mb-2 bg-secondary rounded p-2">
                                    <i class="fa fa-feed text-warning mr-2"></i>
                                    <div class="d-flex flex-column">
                                        <span class="small text-white font-weight-bold">My Wall / Feed</span>
                                        <span class="text-white-50" style="font-size:10px;">Public Listing</span>
                                    </div>
                                    <i class="fa fa-check-circle text-success ml-auto"></i>
                                </div>
                                <div class="group-item d-flex align-items-center mb-2 bg-secondary rounded p-2">
                                    <i class="fa fa-users text-info mr-2"></i>
                                    <div class="d-flex flex-column">
                                        <span class="small text-white font-weight-bold">Timber Trading Hub</span>
                                        <span class="text-white-50" style="font-size:10px;">Automated Post</span>
                                    </div>
                                    <i class="fa fa-check-circle text-success ml-auto"></i>
                                </div>
                                <div class="group-item d-flex align-items-center mb-1 bg-secondary rounded p-1 px-2">
                                    <i class="fa fa-globe text-primary mr-2"></i>
                                    <div class="d-flex flex-column">
                                        <span class="small text-white font-weight-bold">Wood Market Global</span>
                                        <span class="text-white-50" style="font-size:10px;">Automated Post</span>
                                    </div>
                                    <i class="fa fa-check-circle text-success ml-auto"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-white rounded border">
                            <p class="small text-muted mb-3"><i class="fa fa-bolt text-warning"></i> Auto-Broadcasting enabled. Your ad will be instantly pushed to all connected networks.</p>
                            <button type="button" id="btn-broadcast-all" class="btn btn-success btn-block py-2 font-weight-bold shadow-sm" onclick="executeRealBroadcast()">
                                <i class="fa fa-rocket mr-1"></i> LAUNCH AUTO-BROADCAST
                            </button>
                        </div>
                        <div id="broadcast-confirm" class="mt-2 p-2 rounded bg-success text-white small" style="display:none; font-weight: 600;">
                            <i class="fa fa-check-circle"></i> NETWORK BROADCAST COMPLETE!
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top p-3 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">DISCARD AD</button>
                <button type="button" id="confirm-final-save" class="btn btn-primary px-4 font-weight-bold disabled" disabled onclick="executeFinalSave()">
                    FINALIZE & LIST ITEM <i class="fa fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --psy-blue: #1e3a8a;
        --psy-green: #16a34a;
        --psy-bg: #f8fafc;
        --psy-border: #bfdbfe;
        --psy-text: #1e293b;
    }

    body { background-color: var(--psy-bg) !important; color: var(--psy-text); }

    .premium-input-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--psy-border);
        margin-bottom: 24px;
    }

    .card-title-bar {
        font-size: 1.1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--psy-bg);
        padding-bottom: 12px;
    }

    .form-group-premium { margin-bottom: 16px; }
    .form-group-premium label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 6px;
    }

    .form-control-premium {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #fdfdfd;
        transition: all 0.2s;
        font-weight: 500;
    }

    .form-control-premium:focus {
        border-color: var(--psy-blue);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        outline: none;
        background: white;
    }

    .model-nav-item {
        flex: 1;
        min-width: 100px;
        background: white;
        padding: 12px;
        border-radius: 12px;
        margin-right: 12px;
        border: 1px solid var(--psy-border);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .model-nav-item i { font-size: 1.4rem; color: #94a3b8; margin-bottom: 4px; }
    .model-nav-item span { font-size: 0.7rem; font-weight: 700; color: #64748b; }

    .model-nav-item.active {
        background: var(--psy-blue);
        transform: scale(1.05);
        box-shadow: 0 10px 15px -3px rgba(30, 58, 138, 0.3);
        border-color: var(--psy-blue);
    }
    .model-nav-item.active i, .model-nav-item.active span { color: white; }

    .premium-log-table { width: 100%; border-collapse: collapse; }
    .premium-log-table th { background: var(--psy-bg); padding: 10px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; border-bottom: 2px solid #ddd; }
    .premium-log-table td { padding: 8px; border-bottom: 1px solid #f1f5f9; }
    .premium-log-table input, .premium-log-table select { 
        width: 100%; padding: 6px; border: 1px solid #e2e8f0; border-radius: 4px; font-weight: 600; text-align: center;
    }

    .cubic-badge {
        background: var(--psy-blue);
        color: white;
        padding: 12px;
        border-radius: 12px;
        display: inline-block;
        border-left: 5px solid #1e40af;
    }
    .cubic-badge small { display: block; font-weight: 600; opacity: 0.8; letter-spacing: 1px; }

    .btn-save-premium {
        background: var(--psy-green);
        color: white;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(22, 163, 74, 0.4);
        transition: all 0.2s;
        width: 100%;
    }
    .btn-save-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(22, 163, 74, 0.4); }

    .btn-scan-premium {
        background: #f1f5f9;
        color: var(--psy-blue);
        border: 1px solid var(--psy-border);
        font-weight: 700;
        border-radius: 8px;
    }

    /* Photo Upload UI */
    .photo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; }
    .photo-add-box {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 80px;
        cursor: pointer;
        color: #94a3b8;
        background: #f8fafc;
        transition: all 0.2s;
    }
    .photo-add-box:hover { border-color: var(--psy-blue); color: var(--psy-blue); background: #eff6ff; }
    .photo-add-box span { font-size: 0.6rem; font-weight: 700; margin-top: 4px; }
    .preview-img { width: 100%; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #ddd; }

    /* Share Options */
    .share-option-box {
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .share-option-box:hover {
        background: #f8fafc;
        border-color: var(--psy-blue);
        transform: translateY(-5px);
    }
    .share-option-box.active {
        border-color: var(--psy-green);
        background: #f0fdf4;
    }

    /* Scroll fix for mobile nav */
    .model-scroll-container::-webkit-scrollbar { display: none; }
</style>

<script>
    let activeModelType = 'standing';
    let logRowCount = 0;
    let standingRowCount = 0;
    let sawnRowCount = 0;
    let isShared = false;

    function switchModel(model) {
        activeModelType = model;
        $('.model-section').hide();
        $('.model-nav-item').removeClass('active');
        $('#model-' + model).fadeIn();
        $(`#nav-${model}`).addClass('active');
    }

    function addStandingRow() {
        standingRowCount++;
        const row = `
            <tr class="standing-row-item" data-row="${standingRowCount}">
                <td>${standingRowCount}</td>
                <td>
                    <select class="p-id-in">
                        <?php foreach($cat as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" class="t-count-in" placeholder="Qty" oninput="calculateStandingRow(${standingRowCount})"></td>
                <td><input type="number" step="0.1" class="girth-in" placeholder="in" oninput="calculateStandingRow(${standingRowCount})"></td>
                <td><input type="number" step="0.1" class="height-in" placeholder="ft" oninput="calculateStandingRow(${standingRowCount})"></td>
                <td><input type="number" step="0.01" class="u-price-in" placeholder="LKR" oninput="calculateStandingRow(${standingRowCount})"></td>
                <td><span id="standing-sub-${standingRowCount}" class="standing-sub-out text-muted" style="font-weight:700;">0.00</span></td>
            </tr>
        `;
        $('#standing-rows').append(row);
    }

    function addLogRow() {
        logRowCount++;
        const row = `
            <tr id="row-${logRowCount}">
                <td>${logRowCount}</td>
                <td><input type="number" step="0.1" class="log-matrix-input length-in" data-row="${logRowCount}" oninput="handleLogChange(${logRowCount})"></td>
                <td><input type="number" step="0.1" class="log-matrix-input girth-in" data-row="${logRowCount}" oninput="handleLogChange(${logRowCount})"></td>
                <td><span id="cf-${logRowCount}" class="cf-out text-muted" style="font-weight:700;">0.00</span></td>
                <td><input type="number" step="0.01" class="log-u-price-in" data-row="${logRowCount}" placeholder="LKR" oninput="handleLogChange(${logRowCount})"></td>
                <td><span id="log-sub-${logRowCount}" class="log-sub-out text-muted" style="font-weight:700;">0.00</span></td>
            </tr>
        `;
        $('#log-rows').append(row);
    }

    function addSawnRow() {
        sawnRowCount++;
        const row = `
            <tr class="sawn-row-item" data-row="${sawnRowCount}">
                <td>${sawnRowCount}</td>
                <td>
                    <select class="s-id-in">
                        <option value="1">Kempas</option>
                        <option value="2">Red Balau</option>
                        <option value="3">Teak</option>
                        <option value="4">Mahogany</option>
                    </select>
                </td>
                <td>
                    <div class="d-flex">
                        <input type="number" step="0.1" class="w-in" placeholder="W" oninput="calculateSawnVolume(${sawnRowCount})">
                        <input type="number" step="0.1" class="t-in ml-1" placeholder="T" oninput="calculateSawnVolume(${sawnRowCount})">
                    </div>
                </td>
                <td><input type="number" step="0.1" class="l-in" placeholder="L" oninput="calculateSawnVolume(${sawnRowCount})"></td>
                <td><input type="number" class="q-in" placeholder="Qty" value="1" oninput="calculateSawnVolume(${sawnRowCount})"></td>
                <td><input type="number" step="0.01" class="sawn-u-price-in" placeholder="LKR" oninput="calculateSawnVolume(${sawnRowCount})"></td>
                <td><span id="sawn-sub-${sawnRowCount}" class="sawn-sub-out text-muted" style="font-weight:700;">0.00</span></td>
            </tr>
        `;
        $('#sawn-rows').append(row);
    }

    function handleLogChange(rowId) {
        // Calculate volume
        const length = parseFloat($(`.length-in[data-row="${rowId}"]`).val()) || 0;
        const girth = parseFloat($(`.girth-in[data-row="${rowId}"]`).val()) || 0;
        let cf = 0;
        if(length > 0 && girth > 0) {
            cf = Math.pow((girth / 4), 2) * length / 144;
        }
        $(`#cf-${rowId}`).text(cf.toFixed(4)).removeClass('text-muted').addClass('text-primary');
        
        // Update Total
        let total = 0;
        $('.cf-out').each(function() { total += parseFloat($(this).text()) || 0; });
        $('#total-cf').html(total.toFixed(4) + ' <span class="small font-weight-normal">ft³</span>');

        // Dynamic Growth
        if(rowId === logRowCount && (length > 0 || girth > 0)) {
            addLogRow();
        }
    }

    function calculateSawnVolume(rowId) {
        const w = parseFloat($(`.sawn-row-item[data-row="${rowId}"] .w-in`).val()) || 0;
        const t = parseFloat($(`.sawn-row-item[data-row="${rowId}"] .t-in`).val()) || 0;
        const l = parseFloat($(`.sawn-row-item[data-row="${rowId}"] .l-in`).val()) || 0;
        const q = parseInt($(`.sawn-row-item[data-row="${rowId}"] .q-in`).val()) || 0;
        const cf = (w * t * l) / 12 * q;
        $(`#sawn-cf-${rowId}`).text(cf.toFixed(4)).removeClass('text-muted').addClass('text-primary');

        let total = 0;
        $('.sawn-cf-out').each(function() { total += parseFloat($(this).text()) || 0; });
        $('#sawn-cf').html(total.toFixed(4) + ' <span>ft³</span>');
    }

    function previewPhotos(input, gridId) {
        const grid = $('#' + gridId);
        grid.find('.preview-img').remove();
        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    grid.prepend(`<img src="${e.target.result}" class="preview-img">`);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    function getGPS(inputId) {
        if ("geolocation" in navigator) {
            $(`#${inputId}`).val('Locating...');
            navigator.geolocation.getCurrentPosition(function(position) {
                $(`#${inputId}`).val(position.coords.latitude.toFixed(6) + ', ' + position.coords.longitude.toFixed(6));
            }, function() {
                $(`#${inputId}`).val('6.9271, 79.8612'); 
                alert('GPS permission denied.');
            });
        }
    }

    let currentLotId = 0;
    let currentLotType = '';

    function initiateShare(type) {
        activeModelType = type;
        currentLotType = type;
        
        // 1. Submit form as draft/initial save first to get ID
        const form = $(`#form-${activeModelType}`);
        const btn = form.find('.btn-save-premium');
        const originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> PREPARING AD...').prop('disabled', true);

        let formData = new FormData(form[0]);
        formData.append(crsf_token, crsf_hash);
        formData.append('warehouse_id', $('#global-warehouse').val());
        formData.append('broadcast_mode', 'pending'); // Signal for draft/pending status

        // (Grid data appending logic is same as main submit, we'll refactor slightly)
        prepareGridData(formData, activeModelType);

        $.ajax({
            url: baseurl + 'TimberPro/save_' + activeModelType,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                btn.html(originalText).prop('disabled', false);
                if(data.status == 'Success') {
                    currentLotId = data.lot_id;
                    loadAdPreview(currentLotId, activeModelType);
                    $('#shareModal').modal('show');
                } else {
                    alert('Error: ' + data.message);
                }
            },
            error: function() {
                btn.html(originalText).prop('disabled', false);
                alert('Communication failure.');
            }
        });
    }

    function loadAdPreview(id, type) {
        const url = baseurl + 'Marketing/generate_poster?id=' + id + '&type=' + type;
        $('#preview-placeholder').hide();
        $('#modal-live-poster').hide();
        $('#preview-placeholder').after('<div id="render-spinner-modal" class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="small">RENDERING...</p></div>');
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#render-spinner-modal').remove();
                if(data.status == 'Success') {
                    $('#modal-live-poster').attr('src', data.poster_url).fadeIn();
                } else {
                    alert('Preview Error: ' + data.message);
                    $('#preview-placeholder').show();
                }
            },
            error: function() {
                $('#render-spinner-modal').remove();
                alert('Connection failure loading preview.');
                $('#preview-placeholder').show();
            }
        });

        $('#broadcast-confirm').hide();
        $('#confirm-final-save').addClass('disabled').attr('disabled', true);
        $('#btn-broadcast-all').prop('disabled', false).html('<i class="fa fa-paper-plane mr-1"></i> BROADCAST TO ALL NOW');
    }

    function executeRealBroadcast() {
        const btn = $('#btn-broadcast-all');
        
        // Auto-select all standard networks for the logic
        const autoGroups = ['Timber Trading Hub', 'Wood Market Global', 'My Wall / Feed'];

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> SYNCING NETWORK...');

        $.ajax({
            url: baseurl + 'Marketing/broadcast',
            type: 'POST',
            data: { id: currentLotId, type: currentLotType, groups: autoGroups, [crsf_token]: crsf_hash },
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    btn.html('<i class="fa fa-check"></i> NETWORK SYNC COMPLETE');
                    $('#broadcast-confirm').html('<i class="fa fa-wifi"></i> ' + data.message).fadeIn();
                    $('#confirm-final-save').removeClass('disabled').removeAttr('disabled');
                    
                    // Native Share / Web Intent with RICH TEXT
                    const shareUrl = baseurl + 'Marketplace/view/' + currentLotType + '/' + currentLotId;
                    if (navigator.share) {
                        navigator.share({
                            title: 'TimberPro Lot Offer',
                            text: data.caption || `Check out this ${currentLotType} lot on TimberPro ERP.`,
                            url: shareUrl
                        }).catch((error) => console.log('Share dismissed', error));
                    }
                } else {
                    alert(data.message);
                    btn.prop('disabled', false).html('<i class="fa fa-rocket mr-1"></i> LAUNCH AUTO-BROADCAST');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-rocket mr-1"></i> LAUNCH AUTO-BROADCAST');
                alert('Broadcast failed. Please try again.');
            }
        });
    }

    function handleMockShare(platform) {
        $(`.share-option-box:contains(${platform.toUpperCase()})`).addClass('active');
        $('#share-status').fadeIn();
        $('#confirm-final-save').removeClass('disabled').removeAttr('disabled');
        isShared = true;
    }

    function executeFinalSave() {
        alert('LISTED: Ad broadcasted and lot is now live in Marketplace!');
        location.reload();
    }

    function prepareGridData(formData, type) {
        if(type === 'standing') {
            $('.standing-row-item').each(function(idx) {
                const tree_count = $(this).find('.t-count-in').val();
                if(tree_count) {
                    formData.append(`items[${idx}][product_id]`, $(this).find('.p-id-in').val());
                    formData.append(`items[${idx}][tree_count]`, tree_count);
                    formData.append(`items[${idx}][circumference_avg]`, $(this).find('.girth-in').val() || 0);
                    formData.append(`items[${idx}][height_avg]`, $(this).find('.height-in').val() || 0);
                    formData.append(`items[${idx}][unit_price]`, $(this).find('.u-price-in').val() || 0);
                    formData.append(`items[${idx}][subtotal]`, parseFloat($(this).find('.standing-sub-out').text().replace(/,/g, '')) || 0);
                }
            });
        }
        if(type === 'logs') {
            $('.length-in').each(function(idx) {
                const rowId = $(this).data('row');
                const length = $(this).val();
                const girth = $(`.girth-in[data-row="${rowId}"]`).val();
                if(length && girth) {
                    formData.append(`logs[${idx}][length]`, length);
                    formData.append(`logs[${idx}][girth]`, girth);
                    formData.append(`logs[${idx}][unit_price]`, $(`.log-u-price-in[data-row="${rowId}"]`).val() || 0);
                    formData.append(`logs[${idx}][subtotal]`, parseFloat($(`#log-sub-${rowId}`).text().replace(/,/g, '')) || 0);
                }
            });
        }
        if(type === 'sawn') {
            $('.sawn-row-item').each(function(idx) {
                const qty = $(this).find('.q-in').val();
                if(qty) {
                    formData.append(`items[${idx}][wood_type_id]`, $(this).find('.s-id-in').val());
                    formData.append(`items[${idx}][width]`, $(this).find('.w-in').val() || 0);
                    formData.append(`items[${idx}][thickness]`, $(this).find('.t-in').val() || 0);
                    formData.append(`items[${idx}][length]`, $(this).find('.l-in').val() || 0);
                    formData.append(`items[${idx}][quantity]`, qty);
                    formData.append(`items[${idx}][unit_price]`, $(this).find('.sawn-u-price-in').val() || 0);
                    formData.append(`items[${idx}][subtotal]`, parseFloat($(this).find('.sawn-sub-out').text().replace(/,/g, '')) || 0);
                }
            });
        }
    }

    $(document).ready(function() {
        // Init rows
        for(let i=0; i<3; i++) { 
            addStandingRow();
            addLogRow(); 
            addSawnRow();
        }

        // AJAX Form Submissions
        $('form').submit(function(e) {
            if ($(this).attr('id') === 'form-photo-upload') return; // Handled elsewhere
            e.preventDefault();
            const form = $(this);
            const btn = form.find('.btn-save-premium');
            const originalText = btn.html();
            
            btn.html('<i class="fa fa-spinner fa-spin"></i> FINALIZING...').prop('disabled', true);

            let formData = new FormData(this);
            formData.append(crsf_token, crsf_hash);
            formData.append('warehouse_id', $('#global-warehouse').val());

            // Determine active model from form ID
            const type = form.attr('id').replace('form-', '');
            prepareGridData(formData, type);

            $.ajax({
                url: baseurl + 'TimberPro/save_' + type,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    btn.html(originalText).prop('disabled', false);
                    if(data.status == 'Success') {
                        alert('LISTED: ' + data.message);
                        if(data.lot_id && type === 'logs') {
                            window.location.href = baseurl + 'TimberPro/export_excel/' + data.lot_id;
                        } else {
                            location.reload();
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function() {
                    btn.html(originalText).prop('disabled', false);
                    alert('Communication failure.');
                }
            });
        });
    });

    function handleOCR(input) {
        if (!input.files || !input.files[0]) return;
        let formData = new FormData();
        formData.append('log_photo', input.files[0]);
        formData.append(crsf_token, crsf_hash);
        const btn = $('.btn-scan-premium');
        btn.html('<i class="fa fa-spinner fa-spin"></i> SCANNING...').prop('disabled', true);
        $.ajax({
            url: baseurl + 'TimberPro/ocr_scan',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                btn.html('<i class="fa fa-magic"></i> AI SMART SCAN').prop('disabled', false);
                if(data.status == 'Success') {
                    let targetRow = logRowCount;
                    $('.length-in').each(function() {
                        if(!$(this).val()) { targetRow = $(this).data('row'); return false; }
                    });
                    $(`.length-in[data-row="${targetRow}"]`).val(data.length);
                    $(`.girth-in[data-row="${targetRow}"]`).val(data.girth).trigger('input');
                }
            }
        });
    }

    function toggleAllGroups() {
        const checked = $('#select-all-groups').is(':checked');
        $('.group-check').prop('checked', checked);
    }

    // Phase 20: Granular Pricing Calculations
    function calculateStandingRow(rowId) {
        const row = $(`.standing-row-item[data-row="${rowId}"]`);
        const count = parseFloat(row.find('.t-count-in').val()) || 0;
        const girth = parseFloat(row.find('.girth-in').val()) || 0;
        const height = parseFloat(row.find('.height-in').val()) || 0;
        const uPrice = parseFloat(row.find('.u-price-in').val()) || 0;
        
        let subtotal = 0;
        if (count > 0 && girth > 0 && height > 0) {
            const vol = Math.pow(girth / 4, 2) * height / 144 * count;
            subtotal = vol * uPrice;
        }
        
        $(`#standing-sub-${rowId}`).text(subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}))
            .removeClass('text-muted').addClass('text-success');
        
        updateStandingGlobalTotal();
    }

    function updateStandingGlobalTotal() {
        let total = 0;
        $('.standing-sub-out').each(function() {
            total += parseFloat($(this).text().replace(/,/g, '')) || 0;
        });
        $('#standing-total-price').val(total.toFixed(2));
    }

    function handleLogChange(rowId) {
        const length = parseFloat($(`.length-in[data-row="${rowId}"]`).val()) || 0;
        const girth = parseFloat($(`.girth-in[data-row="${rowId}"]`).val()) || 0;
        const uPrice = parseFloat($(`.log-u-price-in[data-row="${rowId}"]`).val()) || 0;
        
        let cf = 0;
        if(length > 0 && girth > 0) {
            cf = Math.pow((girth / 4), 2) * length / 144;
        }
        $(`#cf-${rowId}`).text(cf.toFixed(4)).removeClass('text-muted').addClass('text-primary');
        
        const subtotal = cf * uPrice;
        $(`#log-sub-${rowId}`).text(subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}))
            .removeClass('text-muted').addClass('text-success');

        // Update Total Volume
        let totalVol = 0;
        $('.cf-out').each(function() { totalVol += parseFloat($(this).text()) || 0; });
        $('#total-cf').html(totalVol.toFixed(4) + ' <span class="small font-weight-normal">ft³</span>');

        // Update Total Price
        let totalPrice = 0;
        $('.log-sub-out').each(function() { totalPrice += parseFloat($(this).text().replace(/,/g, '')) || 0; });
        $('#log-total-price').val(totalPrice.toFixed(2));

        // Dynamic Growth
        if(rowId === logRowCount && (length > 0 || girth > 0)) {
            addLogRow();
        }
    }

    function calculateSawnVolume(rowId) {
        const row = $(`.sawn-row-item[data-row="${rowId}"]`);
        const w = parseFloat(row.find('.w-in').val()) || 0;
        const t = parseFloat(row.find('.t-in').val()) || 0;
        const l = parseFloat(row.find('.l-in').val()) || 0;
        const q = parseInt(row.find('.q-in').val()) || 0;
        const uPrice = parseFloat(row.find('.sawn-u-price-in').val()) || 0;
        const unitType = $('#sawn-unit-type').val();
        
        let metric = 0;
        if (unitType === 'cubic_ft') {
            metric = (w * t * l) / 144 * q;
        } else if (unitType === 'linear_ft') {
            metric = l * q;
        } else if (unitType === 'square_ft') {
            metric = (w * l / 12) * q;
        }
        
        const subtotal = metric * uPrice;
        $(`#sawn-sub-${rowId}`).text(subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}))
            .removeClass('text-muted').addClass('text-success');

        // Update Volume Badge (Always Cubic for the badge display)
        let totalVolCf = 0;
        $('.sawn-row-item').each(function() {
            const sw = parseFloat($(this).find('.w-in').val()) || 0;
            const st = parseFloat($(this).find('.t-in').val()) || 0;
            const sl = parseFloat($(this).find('.l-in').val()) || 0;
            const sq = parseInt($(this).find('.q-in').val()) || 0;
            totalVolCf += (sw * st * sl) / 144 * sq;
        });
        $('#sawn-cf').html(totalVolCf.toFixed(4) + ' <span>ft³</span>');

        // Update Total Price
        let totalPrice = 0;
        $('.sawn-sub-out').each(function() { totalPrice += parseFloat($(this).text().replace(/,/g, '')) || 0; });
        $('#sawn-total-price').val(totalPrice.toFixed(2));
    }

    function updateMachTotalPricing() {
        const qty = parseFloat($('#mach-qty').val()) || 1;
        const unitPrice = parseFloat($('#mach-unit-price').val()) || 0;
        $('#mach-total-price').val((qty * unitPrice).toFixed(2));
    }

    // Bindings for global sawn unit type change
    $(document).on('change', '#sawn-unit-type', function() {
        $('.sawn-row-item').each(function() {
            const rid = $(this).data('row');
            calculateSawnVolume(rid);
        });
    });
</script>
