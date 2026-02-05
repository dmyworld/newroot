<div class="card shadow-sm border-0 rounded-lg">
    <div class="card-header bg-white border-bottom-0 pb-0">
        <h4 class="card-title text-timber-primary"><i class="fa fa-pencil-square-o"></i> Update Product Category Price</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>


    <div class="card-content">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">×</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url('products/edit'); ?>">
                <!-- Make sure all these fields exist in your form -->
                <input type="hidden" name="catid" value="<?php echo $productcat['id'] ?>">
                <input type="hidden" name="product_cat_desc" value="<?php echo $productcat['extra'] ?>">
                <input type="hidden" name="cat_type" value="<?php echo $productcat['c_type'] ?>">
                <input type="hidden" name="old_cat_type" value="<?php echo $productcat['rel_id'] ?>">
                <input type="hidden" name="cat_rel" value="<?php echo $productcat['rel_id'] ?>">

                <!-- Basic Information Section -->
                <h4 class="card-title mb-2 text-timber-primary"><i class="fa fa-info-circle"></i> Basic Information</h4>
                <hr>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600" for="product_cat_name">Category Name</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                                <input type="text" class="form-control required" name="product_cat_name" value="<?php echo $productcat['title'] ?>" diseb>
                            </div>
                        </div>
                    </div>

                    <?php if (!$productcat['c_type']) { ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600">Product Category Code*</label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php
                                    if ($product_row_pcat['product_des'] == 1) {
                                        echo $product_row_pcat['product_code'];
                                    } else {
                                        echo '<i class="fa fa-barcode"></i>';
                                    }
                                ?></span>
                                <input type="text" name="new_product_code" class="form-control" aria-describedby="sizing-addon">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600">Product Category Qubic Code*</label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php
                                    if ($product_row_pcat['product_des'] == 1) {
                                        echo $product_row_pcat['pquick_code'];
                                    } else {
                                        echo '<i class="fa fa-cube"></i>';
                                    }
                                ?></span>
                                <input type="text" name="new_product_qubic_code" class="form-control" aria-describedby="sizing-addon">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600">Local Or Imported</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-globe"></i></div>
                                <select name="local_imported" class="form-control">
                                    <?php
                                    $options = [
                                        'i' => 'Imported',
                                        'l' => 'Local',
                                        '' => 'General Products'
                                    ];

                                    foreach ($options as $value => $label) {
                                        $selected = '';
                                        if (!empty($product_row_array_pcat) && is_array($product_row_array_pcat)) {
                                            $all_same = true;
                                            foreach ($product_row_array_pcat as $product) {
                                                if ($product['local_imported'] != $value) {
                                                    $all_same = false;
                                                    break;
                                                }
                                            }
                                            if ($all_same) {
                                                $selected = 'selected';
                                            }
                                        }
                                        echo "<option value=\"$value\" $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600" for="products_stock">Zero All Products Stock</label>
                            <div class="custom-control custom-checkbox mt-1">
                                <input type="checkbox" class="custom-control-input" id="products_stock" name="products_stock" value="0">
                                <label class="custom-control-label" for="products_stock">Yes, Zero Stock</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <h4 class="card-title mb-2 mt-2 text-timber-primary"><i class="fa fa-list"></i> Products Selection</h4>
                <hr>
                
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="text-bold-600">Products</label>
                            <div class="mb-1">
                                <button type="button" id="selectAllBtn" class="btn btn-timber-secondary btn-sm"><i class="fa fa-check-square"></i> Select All</button>
                            </div>
                            <select id="products_l" name="products_l[]" class="form-control round" multiple size="15">
                                <?php foreach ($product_row_array_pcat as $row): ?>
                                    <option value="<?php echo $row['pid']; ?>">
                                        <?php echo htmlspecialchars($row['product_name']); ?> - RS <?php echo $row['product_price']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle"></i> Hold Ctrl (Windows) or Command (Mac) to select multiple options
                            </small>
                        </div>
                    </div>
                </div>

                <?php } else { ?>

                    <!-- Variant Logic for Existing Products -->
                    <div class="col-md-6">
                         <div class="form-group">
                            <label class="text-bold-600">Product Category Code*</label><small class="text-muted pl-1">Only at English Letter</small>
                            <div class="input-group">
                                <span class="input-group-addon"><?php
                                    if ($product_row['product_des'] == 1) {
                                        echo $product_row['product_code'];
                                    } else {
                                        echo '<i class="fa fa-barcode"></i>';
                                    }
                                ?></span>
                                <input type="text" name="new_product_code" class="form-control" aria-describedby="sizing-addon">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Section -->
                <h4 class="card-title mb-2 mt-2 text-timber-primary"><i class="fa fa-money"></i> Pricing & Cost</h4>
                <hr>

                <div class="row mb-2">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label class="text-bold-600">Category Retail Rate*</label>
                            <div class="input-group">
                                <span class="input-group-addon">Rs</span>
                                <input type="text" name="new_product_price" class="form-control" placeholder="0.00" aria-describedby="sizing-addon" value="<?php
                                    if ($product_row['product_des'] == 1) {
                                        echo edit_amountExchange_s($product_row['rate'], 0, $this->aauth->get_user()->loc);
                                    }
                                ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600">Category Wholesale Price</label> <small class="text-muted pl-1">(Current: <?php echo edit_amountExchange_s($product_row['fproduct_price'], 0, $this->aauth->get_user()->loc); ?>)</small>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                                <select name="new_fproduct_price" class="form-control">
                                    <?php for ($i=95; $i>=75; $i--) { echo "<option value='$i'>".(100-$i)."%</option>"; } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600">Category Product Cost</label> <small class="text-muted pl-1">(Current: <?php echo edit_amountExchange_s($product_row['fproduct_cost'], 0, $this->aauth->get_user()->loc); ?>)</small>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                                <select name="new_fproduct_cost" class="form-control">
                                    <?php for ($i=95; $i>=70; $i--) { echo "<option value='$i'>".(100-$i)."%</option>"; } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Section -->
                 <h4 class="card-title mb-2 mt-2 text-timber-primary"><i class="fa fa-cogs"></i> Settings</h4>
                 <hr>

                 <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600">Local Or Imported</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-globe"></i></div>
                                <select name="local_imported" class="form-control">
                                    <?php
                                    $options = [
                                        'i' => 'Imported',
                                        'l' => 'Local',
                                        '' => 'General Products'
                                    ];
                                    foreach ($options as $value => $label) {
                                        $selected = ($product_row['local_imported'] == $value) ? 'selected' : '';
                                        echo "<option value=\"$value\" $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                         <div class="form-group">
                            <label class="text-bold-600">Unit</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-balance-scale"></i></div>
                                <select name="wood_unit" class="form-control">
                                    <?php
                                    $options = ['Feet' => 'Feet', 'Sqft' => 'Sqft', 'Qbic' => 'Qbic'];
                                    foreach ($options as $value => $label) {
                                        $selected = ($product_row['unit'] == $value) ? 'selected' : '';
                                        echo "<option value=\"$value\" $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600" for="products_stock_2">Zero All Products Stock</label>
                             <div class="custom-control custom-checkbox mt-1">
                                <input type="checkbox" class="custom-control-input" id="products_stock_2" name="products_stock" value="0">
                                <label class="custom-control-label" for="products_stock_2">Yes, Zero Stock</label>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" value="1" name="cat_type">
                <input type="hidden" value="<?= $product_row['sub_id'] ?>" name="sub_id">
                <input type="hidden" value="<?= $product_row['pcat'] ?>" name="cat_rel">

                <div class="row mb-2">
                    <div class="col-12">
                         <div class="form-group">
                            <label class="text-bold-600">Selected Category Products</label>
                            <div class="mb-1">
                                <button type="button" id="selectAllBtn" class="btn btn-timber-secondary btn-sm"><i class="fa fa-check-square"></i> Select All</button>
                            </div>
                            <select id="products_l" name="products_l[]" class="form-control round" multiple size="15">
                                <?php foreach ($product_row_array as $row): ?>
                                    <option value="<?php echo $row['pid']; ?>">
                                        <?php echo htmlspecialchars($row['product_name']); ?> - RS <?php echo $row['product_price']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle"></i> Hold Ctrl (Windows) or Command (Mac) to select multiple options
                            </small>
                         </div>
                    </div>
                </div>
                
                <?php } ?>
                
                <?php if ($productcat['c_type']) { ?>
                    <input type="hidden" value="1" name="cat_type">
                    <input type="hidden" value="<?= $productcat['rel_id'] ?>" name="old_cat_type">
                    <input type="hidden" value="<?= $productcat['rel_id'] ?>" name="cat_rel">
                    <div class="row mb-2">
                         <div class="col-md-6">
                             <div class="form-group">
                                <label class="text-bold-600">Related Category</label>
                                <select name="" class="form-control">
                                    <?php echo "<option value='" . $productcat['rel_id'] . "'>--" . $this->lang->line('Do not change') . "--</option>";
                                    foreach ($cat as $row) { echo "<option value=''>" . $row['title'] . "</option>"; } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php } else { ?><input type="hidden" value="0" name="cat_type"><?php } ?>

                <div class="row mt-2">
                    <div class="col-md-12 text-center">
                        <input type="submit" id="submit-data" class="btn btn-timber-primary btn-lg margin-bottom" value="Update Product Category" data-loading-text="Updating...">
                        <input type="hidden" value="productcategory/editcat" id="action-url">
                    </div>
                </div>


            </form>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#data_form').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '<?php echo base_url('productcategory/editcat'); ?>', // Changed to editcat match legacy behavior
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'Success') {
                            $('#notify .message').html(response.message);
                            $('#notify').removeClass('alert-danger').addClass('alert-success').fadeIn();
                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");
                        } else {
                            $('#notify .message').html(response.message);
                            $('#notify').removeClass('alert-success').addClass('alert-danger').fadeIn();
                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");
                        }
                    },
                    error: function() {
                        $('#notify .message').html('An error occurred. Please try again.');
                        $('#notify').removeClass('alert-success').addClass('alert-danger').fadeIn();
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#selectAllBtn').click(function() {
                $('#products_l option').prop('selected', true);
            });
        });
    </script>
