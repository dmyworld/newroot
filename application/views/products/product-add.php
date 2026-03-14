```html
<style>
    /* ============================================
       BLUE & LIFE GREEN - PSYCHOLOGICAL THEME
       Based on Owner Dashboard (Style 9)
    ============================================ */
    
    :root {
        /* Blue & Green Palette */
        --psy-bg-page: #eff6ff; /* Alice Blue (Page BG) */
        --psy-bg-card: #ffffff;
        --psy-text-primary: #1e3a8a; /* Navy Blue 900 */
        --psy-text-secondary: #334155; /* Slate 700 (Neutral) */
        --psy-accent-primary: #2563eb; /* Royal Blue */
        --psy-accent-success: #16a34a; /* Life Green */
        --psy-accent-danger: #ef4444; /* Red (Standard Danger) */
        --psy-accent-warning: #f59e0b; /* Amber */
        --psy-border: #bfdbfe; /* Blue 200 */
        --psy-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.1), 0 2px 4px -1px rgba(30, 58, 138, 0.06);
        --psy-glass: rgba(255, 255, 255, 0.95);
        
        --radius-std: 8px;
        --radius-lg: 12px;
    }

    /* Force overrides for Global Dark Mode leaks */
    html, body, .app-content, .content-wrapper, .content-body {
        background-color: var(--psy-bg-page) !important;
        color: var(--psy-text-primary) !important;
        font-family: 'Montserrat', sans-serif;
    }

    .content-body {
        padding: 2rem;
    }

    /* GLASSMORPHIC HEADER match Dashboard */
    .page-header-glass {
        background: #ffffff;
        border: 1px solid var(--psy-border);
        box-shadow: var(--psy-shadow);
        border-radius: var(--radius-lg);
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .page-header-glass::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, var(--psy-accent-primary), var(--psy-accent-success));
    }

    .page-title h2 {
        color: var(--psy-text-primary);
        font-weight: 800;
        letter-spacing: -0.5px;
        margin: 0;
        font-size: 1.8rem;
        text-transform: uppercase;
    }

    /* PREMIUM BUTTONS MATCHING DASHBOARD */
    .btn-premium {
        background: white;
        color: var(--psy-accent-primary);
        border: 1px solid var(--psy-border);
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        background: var(--psy-bg-page);
        border-color: var(--psy-accent-primary);
        color: var(--psy-accent-primary);
        box-shadow: var(--psy-shadow);
    }
    
    .btn-premium.btn-success-glass {
        color: var(--psy-accent-success);
        border-color: #bbf7d0; /* Green 200 */
        background: #f0fdf4; /* Green 50 */
    }
    .btn-premium.btn-success-glass:hover {
        background: #dcfce7;
        border-color: var(--psy-accent-success);
    }

    /* PREMIUM CARDS */
    .premium-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--psy-border);
        box-shadow: var(--psy-shadow);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        padding: 2rem;
    }
</style>

<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h2><?php echo $this->lang->line('Add New Product') ?></h2>
        </div>
        <div class="header-actions">
            <button type="button" class="btn-premium btn-success-glass" data-toggle="modal" data-target="#masterProductModal">
                 <i class="fa fa-magic"></i> Select from Master List
            </button>
            <a href="<?php echo base_url('products') ?>" class="btn-premium">
                 <i class="fa fa-list"></i> Products List
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <!-- User Guide -->
    <div class="premium-card mb-4" style="border-left: 4px solid var(--psy-accent-success); padding: 0;">
        <div class="card-header p-3 pointer" data-toggle="collapse" data-target="#guideCat" aria-expanded="false" style="cursor: pointer; background: white; border-bottom: none;">
            <h6 class="mb-0 text-psy-primary font-weight-bold"><i class="fa fa-info-circle mr-2 text-success"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
        </div>
        <div id="guideCat" class="collapse">
            <div class="card-body p-3 pt-0">
                <ul class="nav nav-tabs" role="tablist" style="border-bottom: 2px solid var(--psy-border);">
                    <li class="nav-item"><a class="nav-link active small p-2 font-weight-bold text-primary" data-toggle="tab" href="#eng">🇬🇧 English</a></li>
                    <li class="nav-item"><a class="nav-link small p-2 font-weight-bold text-primary" data-toggle="tab" href="#sin">🇱🇰 Sinhala</a></li>
                    <li class="nav-item"><a class="nav-link small p-2 font-weight-bold text-primary" data-toggle="tab" href="#tam">IN Tamil</a></li>
                </ul>
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" id="eng" role="tabpanel">
                        <h6 class="text-primary mt-2 small font-weight-bold">How to Add a Product</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>Product Details:</strong> Enter Name, Code (unique), and select Category/Warehouse.</li>
                            <li><strong>Pricing & Stock:</strong> Set Retail/Factory Price, Tax, Discount, and Initial Stock Quantity.</li>
                            <li><strong>Alerts:</strong> Set 'Alert Quantity' to receive low-stock notifications.</li>
                            <li><strong>Dimensions:</strong> For wood/timber, enter Width and Thickness to auto-calculate Cubic Feet.</li>
                        </ol>
                    </div>
                    <div class="tab-pane fade" id="sin" role="tabpanel">
                        <h6 class="text-primary mt-2 small font-weight-bold">නිෂ්පාදනයක් එකතු කරන ආකාරය</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>නිෂ්පාදන විස්තර:</strong> නම, කේතය (අනන්‍ය විය යුතුය), සහ වර්ගය/ගබඩාව තෝරන්න.</li>
                            <li><strong>මිල සහ තොග:</strong> සිල්ලර/කර්මාන්තශාලා මිල, බදු, වට්ටම් සහ ආරම්භක තොග ප්‍රමාණය ඇතුළත් කරන්න.</li>
                            <li><strong>දැනුම්දීම්:</strong> අඩු තොග පිළිබඳ දැනුම්දීම් ලබා ගැනීමට 'Alert Quantity' සකසන්න.</li>
                            <li><strong>මානයන්:</strong> දැව සඳහා, ඝන අඩි (Cubic Feet) ස්වයංක්‍රීයව ගණනය කිරීමට පළල සහ ඝනකම ඇතුළත් කරන්න.</li>
                        </ol>
                    </div>
                    <div class="tab-pane fade" id="tam" role="tabpanel">
                        <h6 class="text-primary mt-2 small font-weight-bold">தயாரிப்பை எவ்வாறு சேர்ப்பது</h6>
                        <ol class="small pl-3 mb-0 text-muted">
                            <li><strong>தயாரிப்பு விவரங்கள்:</strong> பெயர், குறியீடு (தனித்துவமானது) ஆகியவற்றை உள்ளிட்டு வகை/கிடங்கைத் தேர்ந்தெடுக்கவும்.</li>
                            <li><strong>விலை மற்றும் இருப்பு:</strong> சில்லறை/தொழிற்சாலை விலை, வரி, தள்ளுபடி மற்றும் ஆரம்ப இருப்பு அளவு ஆகியவற்றை அமைக்கவும்.</li>
                            <li><strong>விழிப்பூட்டல்கள்:</strong> குறைந்த இருப்பு அறிவிப்புகளைப் பெற 'Alert Quantity' ஐ அமைக்கவும்.</li>
                            <li><strong>பரிமாணங்கள்:</strong> மரத்திற்கு, கன அடியைத் தானாகக் கணக்கிட அகலம் மற்றும் தடிமன் ஆகியவற்றை உள்ளிடவும்.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Guide -->

    <div class="premium-card">
            <form method="post" id="data_form">


                <input type="hidden" name="act" value="add_product">


                <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-box mr-2"></i> Basic Details</h5>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="product_name"><?php echo $this->lang->line('Product Name') ?> *</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Product Name" class="form-control required" name="product_name">
                    </div>
                    <label class="col-sm-2 col-form-label" for="product_code"><?php echo $this->lang->line('Product Code') ?></label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Product Code" class="form-control" name="product_code">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="product_cat"><?php echo $this->lang->line('Product Category') ?> *</label>
                    <div class="col-sm-4">
                        <select name="product_cat" id="product_cat" class="form-control">
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label" for="sub_cat"><?php echo $this->lang->line('Sub') ?><?php echo $this->lang->line('Category') ?></label>
                    <div class="col-sm-4">
                        <select id="sub_cat" name="sub_cat" class="form-control required select-box">
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse') ?>*</label>
                    <div class="col-sm-4">
                        <select name="product_warehouse" class="form-control">
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Special Category</label>
                    <div class="col-sm-4">
                        <select name="special_category" class="form-control">
                            <option value="">-- None --</option>
                            <option value="uncut_tree">Uncut Tree (කපපු නැති ගහක්)</option>
                            <option value="log">Log (කපපු කඳක්)</option>
                            <option value="sawn_timber">Sawn Timber / Rafters (ඉරණම ලද ලෑලි / පරාල)</option>
                            <option value="hardware_item">Hardware Item (දෘඩාංග භාණ්ඩයක්)</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-money-bill-wave mr-2"></i> Pricing & Stock</h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="product_price"><?php echo $this->lang->line('Product Retail Price') ?>*</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_price" class="form-control required" placeholder="0.00" aria-describedby="sizing-addon" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Purchase Price</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="fproduct_price" class="form-control" placeholder="0.00" aria-describedby="sizing-addon1" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Cost</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="new_fproduct_cost" class="form-control" placeholder="0.00" aria-describedby="sizing-addon1" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Default TAX Rate</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="product_tax" class="form-control" placeholder="0.00" onkeypress="return isNumber(event)">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Default Discount Rate</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="product_disc" class="form-control" placeholder="0.00" onkeypress="return isNumber(event)">
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Measurement Unit') ?>*</label>
                    <div class="col-sm-4">
                        <select name="unit" class="form-control">
                            <option value=''>None</option>
                            <?php
                            foreach ($units as $row) {
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title - $cid</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Stock Units*</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="<?php echo $this->lang->line('Stock Units') ?>" class="form-control required" name="product_qty" onkeypress="return isNumber(event)">
                    </div>
                    <label class="col-sm-2 col-form-label">Alert Quantity</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>" class="form-control" name="product_qty_alert" onkeypress="return isNumber(event)">
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-barcode mr-2"></i> Identifiers & Options</h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">BarCode</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="code_type">
                            <option value="EAN13">EAN13 - Default</option>
                            <option value="UPCA">UPC</option>
                            <option value="EAN8">EAN8</option>
                            <option value="ISSN">ISSN</option>
                            <option value="ISBN">ISBN</option>
                            <option value="C128A">C128A</option>
                            <option value="C39">C39</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" placeholder="BarCode Numeric Digit 123112345671" class="form-control" name="barcode" id="barcode_input" onkeypress="return isNumber(event)">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="startScanner('barcode_input')">
                                    <i class="fa fa-qrcode"></i> Scan
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Leave blank for auto generated EAN13.</small>
                    </div>
                    <label class="col-sm-2 col-form-label">Product Quick Code</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Quick Code" class="form-control required" name="product_quick_code">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Available for</label>
                    <div class="col-sm-10 pt-2">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" name="is_sale" value="1" id="is_sale" class="custom-control-input" checked>
                            <label class="custom-control-label" for="is_sale">Sale</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" name="is_rent" value="1" id="is_rent" class="custom-control-input">
                            <label class="custom-control-label" for="is_rent">Rent</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" name="is_installment" value="1" id="is_installment" class="custom-control-input">
                            <label class="custom-control-label" for="is_installment">Installment</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row" id="rent_price_div" style="display:none;">
                    <label class="col-sm-2 col-form-label" for="product_rent">Rent Price (Monthly) *</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_rent" id="product_rent" class="form-control" placeholder="0.00" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>

                <div class="form-group row" id="installment_price_div" style="display:none;">
                    <label class="col-sm-2 col-form-label" for="product_installment">Installment Price (Total) *</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_installment" id="product_installment" class="form-control" placeholder="0.00" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="master_pid" id="master_pid" value="0">

                <hr class="my-4">
                <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-ruler-combined mr-2"></i> Dimensions</h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Length (Feet)</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Length" class="form-control required" name="product_desc">
                    </div>
                    <label class="col-sm-2 col-form-label">Width (Inches)</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Width" class="form-control required" name="product_width">
                    </div>
                    <label class="col-sm-2 col-form-label">Thickness (Inches)</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Thickness" class="form-control required" name="product_thickness">
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-calendar-alt mr-2"></i> Expiry Settings</h5>
                <div class="form-group row">
                    <label class="col-sm-2 control-label" for="edate"><?php echo $this->lang->line('Valid') . ' (' . $this->lang->line('To Date') ?>)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control required" placeholder="Expiry Date" name="wdate" data-toggle="datepicker" autocomplete="false">
                        <small class="text-muted">Do not change if not applicable</small>
                    </div>
                </div>
                <?php
                foreach ($custom_fields as $row) {
                    if ($row['f_type'] == 'text') { ?>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="custom"><?= $row['name'] ?></label>

                            <div class="col-sm-8">
                                <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                       class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                       name="custom[<?= $row['id'] ?>]">
                            </div>
                        </div>


                    <?php }
                }
                ?>
                <hr>
                <div class="form-group row"><label
                            class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                    <div class="col-sm-6">
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <table id="files" class="files"></table>
                        <br>
                        <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]">
    </span>
                        <br>
                        <pre>Allowed: gif, jpeg, png (Use light small weight images for fast loading - 200x200)</pre>
                        <br>
                        <!-- The global progress bar -->

                    </div>
                </div>
                <div class="form-group row mt-4">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-premium btn-success-glass btn-lg margin-bottom"
                               value="<?php echo $this->lang->line('Add product') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="products/addproduct" id="action-url">
                    </div>
                </div>
                <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">

                    <div id="coupon4" class="card-header">
                        <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion41"
                           aria-expanded="true" aria-controls="accordion41"
                           class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                            <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?></a>
                    </div>
                    <div id="accordion41" role="tabpanel" aria-labelledby="coupon4"
                         class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="row p-1">
                            <div class="col">
                                <button class="btn btn-blue tr_clone_add">Add Row</button>
                                <hr>
                                <table class="table" id="v_var">
                                    <tr>
                                        <td><select name="v_type[]" class="form-control">
                                                <?php
                                                foreach ($variables as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['name'];
                                                    $title = $row['name'];
                                                    $variation = $row['variation'];
                                                    echo "<option value='$cid'>$variation - $title </option>";
                                                }
                                                ?>
                                            </select></td>
                                        <td><input value="" class="form-control" name="v_stock[]"
                                                   placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                        </td>
                                        <td><input value="" class="form-control" name="v_alert[]"
                                                   placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                        </td>
                                        <td>
                                            <button class="btn btn-red tr_delete">Delete</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="accordionWrapa2" role="tablist" aria-multiselectable="true">

                    <div id="coupon5" class="card-header">
                        <a data-toggle="collapse" data-parent="#accordionWrapa2" href="#accordion42"
                           aria-expanded="true" aria-controls="accordion41"
                           class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                            <?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Warehouse') ?>
                        </a>
                    </div>
                    <div id="accordion42" role="tabpanel" aria-labelledby="coupon5"
                         class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="row p-1">
                            <div class="col">
                                <button class="btn btn-blue tr_clone_add_w">Add Row</button>
                                <hr>
                                <table class="table" id="w_var">
                                    <tr>
                                        <td>
                                            <select name="w_type[]" class="form-control">
                                                <?php
                                                foreach ($warehouse as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['title'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select></td>
                                        <td><input value="" class="form-control" name="w_stock[]"
                                                   placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                        </td>
                                        <td><input value="" class="form-control" name="w_alert[]"
                                                   placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                        </td>
                                        <td>
                                            <button class="btn btn-red tr_delete">Delete</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


                <input type="hidden" name="image" id="image" value="default.png">

            </form>
        </div>

        <!-- Master Product Modal -->
        <div class="modal fade" id="masterProductModal" tabindex="-1" role="dialog" aria-labelledby="masterProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-directional-blue white">
                        <h5 class="modal-title" id="masterProductModalLabel"><i class="fa fa-magic"></i> Select from Master Product List</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="master_products_table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $master_products = $this->products->get_master_products();
                                if ($master_products) {
                                    $i = 1;
                                    foreach ($master_products as $m_row) {
                                        echo '<tr>
                                                <td>' . $i++ . '</td>
                                                <td><img src="' . base_url() . 'userfiles/product/' . $m_row['image'] . '" height="50"></td>
                                                <td><b>' . $m_row['product_name'] . '</b></td>
                                                <td>' . $m_row['product_code'] . '</td>
                                                <td>' . $m_row['pcat'] . '</td>
                                                <td>' . amountExchange($m_row['product_price'], 0, $this->aauth->get_user()->loc) . '</td>
                                                <td><button type="button" class="btn btn-success btn-sm select-master" 
                                                    data-id="' . $m_row['id'] . '" 
                                                    data-name="' . htmlspecialchars($m_row['product_name']) . '" 
                                                    data-code="' . htmlspecialchars($m_row['product_code']) . '" 
                                                    data-price="' . $m_row['product_price'] . '" 
                                                    data-rent="' . $m_row['product_rent'] . '" 
                                                    data-installment="' . $m_row['product_installment'] . '" 
                                                    data-image="' . $m_row['image'] . '" 
                                                    data-unit="' . $m_row['unit'] . '" 
                                                    data-desc="' . htmlspecialchars($m_row['product_des']) . '"
                                                    data-pwith="' . $m_row['pwith'] . '"
                                                    data-pthickness="' . $m_row['pthickness'] . '"
                                                    data-pquick="' . $m_row['pquick'] . '"
                                                    data-pquick_code="' . $m_row['pquick_code'] . '"
                                                    data-cat="' . $m_row['pcat'] . '"
                                                    >Select</button></td>
                                              </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center">No master products found.</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });


    $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
    $(document).on('click', ".tr_clone_add_w", function (e) {
        e.preventDefault();
        var n_row = $('#w_var').find('tbody').find("tr:last").clone();

        $('#w_var').find('tbody').find("tr:last").after(n_row);

    });

    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    // Triple-Mode Toggles
    $('#is_rent').change(function() {
        if($(this).is(":checked")) {
            $('#rent_price_div').fadeIn();
        } else {
            $('#rent_price_div').fadeOut();
        }
    });

    $('#is_installment').change(function() {
        if($(this).is(":checked")) {
            $('#installment_price_div').fadeIn();
        } else {
            $('#installment_price_div').fadeOut();
        }
    });

    // Master Product Selection
    $(document).on('click', '.select-master', function() {
        var data = $(this).data();
        
        // Populate fields
        $('input[name="product_name"]').val(data.name);
        $('input[name="product_code"]').val(data.code);
        $('input[name="product_price"]').val(data.price);
        $('input[name="product_rent"]').val(data.rent);
        $('input[name="product_installment"]').val(data.installment);
        $('input[name="product_desc"]').val(data.desc); // This is Length in this UI
        $('input[name="product_width"]').val(data.pwith);
        $('input[name="product_thickness"]').val(data.pthickness);
        $('input[name="product_quick_code"]').val(data.pquick_code);
        $('#master_pid').val(data.id);
        $('#product_cat').val(data.cat).trigger('change');
        $('select[name="unit"]').val(data.unit);
        
        // Handle Toggles
        if(parseFloat(data.rent) > 0) {
            $('#is_rent').prop('checked', true).trigger('change');
        }
        if(parseFloat(data.installment) > 0) {
            $('#is_installment').prop('checked', true).trigger('change');
        }

        // Handle Image
        if(data.image) {
            $('#files').html('<tr><td><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + data.image + '"></td></tr>');
            $('#image').val(data.image);
        }

        // Close Modal
        $('#masterProductModal').modal('hide');
        
        // Notify
        Swal.fire({
            icon: 'success',
            title: 'Product Details Imported!',
            text: 'Master details for ' + data.name + ' have been loaded.',
            timer: 2000,
            showConfirmButton: false
        });
    });


    $("#sub_cat").select2();
    $("#product_cat").on('change', function () {
        $("#sub_cat").val('').trigger('change');
        var tips = $('#product_cat').val();
        $("#sub_cat").select2({

            ajax: {
                url: baseurl + 'products/sub_cat?id=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {
                    return {
                        product: product,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.title,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    });
</script>
<?php $this->load->view('fixed/scanner_modal'); ?>
