<div class="card shadow-sm border-0 rounded-lg">
    <div class="card-header bg-white border-bottom-0 pb-0">
        <h4 class="card-title text-timber-primary"><i class="fa fa-pencil-square-o"></i> Add Products on this Category</h4>
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


            <form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url('productcategory/category_products_add_post'); ?>">


                <!-- Basic Information Section -->
                <h4 class="card-title mb-2 text-timber-primary"><i class="fa fa-info-circle"></i> Basic Information</h4>
                <hr>

                
                 <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600"><?php echo $this->lang->line('Category') ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-globe"></i></div>
                        <select name="catid" class="form-control">
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                $extra = isset($row['extra']) ? $row['extra'] : '';
                                echo "<option value='$cid' data-extra='$extra'>$title</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="extra" id="cat_extra">
                        <script>
                            $(document).ready(function() {
                                function updateExtra() {
                                    var extra = $('select[name="catid"] option:selected').data('extra');
                                    $('#cat_extra').val(extra);
                                }
                                // Init
                                updateExtra();
                                // Change
                                $('select[name="catid"]').change(updateExtra);
                            });
                        </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600"><?php echo $this->lang->line('Warehouse') ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-globe"></i></div>
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
                        </div>
                    </div>

                </div>
                
                

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-bold-600" for="product_cat_name">Category Name (Thicknesses X Widths)*</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                                <input type="text" class="form-control required" placeholder="kempas(1/2 , 3/4 , 7/8 , 1 , 1 1/8 , 1 1/4 , 1 3/8 , 1 1/2 , 1 5/8 , 1 3/4 , 1 7/8 , 2 , 3 , 4 , 5 X Widths)" name="product_cat_name" value="<?php echo $productcat['title'] ?>" diseb>
                            </div>
                        </div>
                    </div>

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



         
                <input type="hidden" value="<?= implode(',', array( 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 12.5, 13, 13.5, 14, 14.5, 15, 15.5, 16, 16.5, 17, 17.5, 18, 18.5, 19, 19.5, 20, 20.5, 21, 21.5, 22, 22.5, 23, 23.5, 24, 24.5, 25, 25.5, 26, 26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30)); ?>" name="lengtharray">
             
                
         

                <div class="row mt-2">
                    <div class="col-md-12 text-center">
                        <input type="submit" id="submit-data" class="btn btn-timber-primary btn-lg margin-bottom" value="Add Products On This Category" data-loading-text="Updating...">
                        <input type="hidden" value="productcategory/category_products_add_post" id="action-url">
                    </div>
                </div>


            </form>
        </div>

    </div>

   
