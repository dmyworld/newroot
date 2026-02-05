<article class="">
    <div class="">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>

        <div class="">
            <h4 class=""><?php echo $this->lang->line('Wood Cuter') ?></h4>
            
        </div>

        <div class="card-body">
            <form method="post" id="data_form" class="form-horizontal">
                
                <?php  
                    // Logic from original file to handle balance calculation
                    $pcutsizeid = $this->input->get('pcutsizeid', TRUE);
                    $pcutsizename = $this->input->get('pcutsizename', TRUE);
                    $pcutsizestock = $this->input->get('pcutsizestock', TRUE);
                    $pcutsizelength = $this->input->get('pcutsizelength', TRUE);
                    $cutblance = $this->input->get('cutblance', TRUE);

                    if($cutblance=='ok'){
                        $cutblancelength =  $product['product_des'] - $pcutsizelength;
                        echo '<input type="hidden" id="cutblancelength" name="cutblancelength" value="' . $cutblancelength . '">';
                    }               
                ?>

                <!-- Hidden Inputs -->
                <input type="hidden" id="pid" name="pid" value="<?php echo $product['pid'] ?>">
                <input type="hidden" id="length" name="length" value="<?php echo $product['product_des'] ?>">
                <input type="hidden" id="available_product_qty" name="available_product_qty" value="<?php echo $product['qty'] ?>">
                <input type="hidden" id="v2_categories" name="v2_categories" value="<?php echo $product['sub_id'] ?>">
                <input type="hidden" id="v2_warehouses" name="v2_warehouses" value="<?php echo $product['warehouse'] ?>"> 
                <input type="hidden" id="pcutsizeid" name="pcutsizeid" value="<?php echo $pcutsizeid ?>">
                <input type="hidden" id="pcutsizename" name="pcutsizename" value="<?php echo $pcutsizename ?>">
                <input type="hidden" id="pcutsizestock" name="pcutsizestock" value="<?php echo $pcutsizestock ?>">
                <input type="hidden" id="pcutsizelength" name="pcutsizelength" value="<?php echo $pcutsizelength ?>">

                <div class="row justify-content-center">
                    
                    <div class="col-md-10">
                        <!-- Product Info Card -->
                        <div class="card border-timber-primary mb-3" style="border-top: 4px solid #4caf50; box-shadow: 0 4px 20px 0 rgba(0,0,0,.05);">
                            <div class="card-header bg-white">
                                <h4 class="card-title text-success"><i class="fa fa-tree"></i> <?php echo $this->lang->line('Product Details') ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-bold-600" for="product_name"><?php echo $this->lang->line('Product Name') ?></label>
                                            <input type="text" class="form-control" value="<?php echo $product['product_name'] ?>" disabled style="background-color: #f0f3f5;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-bold-600">Available Stock</label>
                                            <div class="input-group">
                                                <input type="text" name="available_product_qty_cut" id="available_product_qty_cut" class="form-control required" placeholder="Quantity to Cut">
                                                <span class="input-group-addon bg-success white text-bold-600"><?php echo $product['qty'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cut Size Selection Card -->
                         <div class="card border-timber-secondary mb-3" style="border-top: 4px solid #795548; box-shadow: 0 4px 20px 0 rgba(0,0,0,.05);">
                            <div class="card-header bg-white">
                                <h4 class="card-title text-timber-secondary"><i class="fa fa-ruler"></i> <?php echo $this->lang->line('Select Cut Size') ?></h4>
                            </div>
                            <div class="card-body">
                                <!-- AJAX Table Container -->
                                <div id="woodcut_size" class="text-center">
                                    <div class="p-3"><i class="fa fa-spinner fa-spin fa-2x text-muted"></i> <br>Loading sizes...</div>
                                </div>
                            </div>
                        </div>

                        <!-- Calculation & Actions -->
                        <div class="card" style="box-shadow: 0 4px 20px 0 rgba(0,0,0,.05);">
                             <div class="card-body">
                                <h4 class="card-title text-muted mb-2">Calculation & Balance</h4>
                                <div id="cutblancelengthinfo">
                                    <!-- cut blance length info loads here -->
                                </div>
                                
                                <?php if($pcutsizestock): ?>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-3 col-form-label text-bold-600">Selected Size Stock</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                                            <input type="text" class="form-control" value="<?php echo $pcutsizestock; ?>" disabled>
                                            <span class="input-group-addon bg-light"><?php echo isset($cutblancelengthinfo['product_name']) ? $cutblancelengthinfo['product_name'] : ''; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <hr>
                                <div class="row mt-3">
                                    <div class="col-md-4 offset-md-4">
                                        <button type="submit" id="submit-data" class="btn btn-success btn-glow btn-lg btn-block shadow-z-2 font-weight-bold" data-loading-text="Updating...">
                                            <i class="fa fa-check-circle"></i> <?php echo $this->lang->line('Update') ?>
                                        </button>
                                        <input type="hidden" value="products/woodcut_update" id="action-url">
                                    </div>
                                     <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-warning btn-block" onClick="window.location.reload()">
                                            <i class="fa fa-refresh"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <style>
                    /* Custom Radio Styles for the AJAX content */
                    .custom-radio-group .radio-inline {
                        position: relative;
                        padding-left: 35px;
                        margin-right: 20px;
                        cursor: pointer;
                        font-size: 16px;
                    }
                    .custom-radio-group input[type="radio"] {
                        position: absolute;
                        opacity: 0;
                        cursor: pointer;
                    }
                    .checkmark {
                        position: absolute;
                        top: 0;
                        left: 0;
                        height: 25px;
                        width: 25px;
                        background-color: #eee;
                        border-radius: 50%;
                    }
                    .custom-radio-group:hover input ~ .checkmark {
                        background-color: #ccc;
                    }
                    .custom-radio-group input:checked ~ .checkmark {
                        background-color: #4caf50;
                    }
                    .checkmark:after {
                        content: "";
                        position: absolute;
                        display: none;
                    }
                    .custom-radio-group input:checked ~ .checkmark:after {
                        display: block;
                    }
                    .custom-radio-group .checkmark:after {
                        top: 9px;
                        left: 9px;
                        width: 8px;
                        height: 8px;
                        border-radius: 50%;
                        background: white;
                    }
                </style>

            </form>
        </div>
    </div>
</article>

<script type="text/javascript">

    $.ajax({
        url: baseurl + 'products/woodcut_size',
        dataType: 'html',
        method: 'POST',                                  
        data: 'cid=' + $('#v2_categories').val() + '&wid=' + $('#v2_warehouses').val() + '&productid=' + $('#pid').val() + '&pcutsizeid=' + $('#pcutsizeid').val() + '&pcutsizename=' + $('#pcutsizename').val() + '&cutblancelength=' + $('#cutblancelength').val() + '&length=' + $('#length').val() + '&' + crsf_token + '=' + crsf_hash,
        success: function (data) {
            $('#woodcut_size').html(data);
        }
    });

    $.ajax({
        url: baseurl + 'products/cutblancelengthinfo',
        dataType: 'html',
        method: 'POST',                                  
        data: 'cid=' + $('#v2_categories').val() + '&wid=' + $('#v2_warehouses').val() + '&productid=' + $('#pid').val() + '&pcutsizeid=' + $('#pcutsizeid').val() + '&pcutsizename=' + $('#pcutsizename').val() + '&cutblancelength=' + $('#cutblancelength').val() + '&length=' + $('#length').val() + '&' + crsf_token + '=' + crsf_hash,
        success: function (data) {
            $('#cutblancelengthinfo').html(data);
        }
    }); 
</script>
