<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h2><?php echo $this->lang->line('Add New Master Product') ?></h2>
        </div>
        <div class="header-actions">
            <a href="<?php echo base_url('master_products') ?>" class="btn-premium">
                 <i class="fa fa-list"></i> Master List
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="premium-card">
        <form method="post" id="data_form">
            <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-box mr-2"></i> Basic Details</h5>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="product_name"><?php echo $this->lang->line('Product Name') ?> *</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Product Name" class="form-control required" name="product_name">
                </div>
                <label class="col-sm-2 col-form-label" for="product_code"><?php echo $this->lang->line('Product Code') ?> *</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Product Code" class="form-control required" name="product_code">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="product_cat"><?php echo $this->lang->line('Product Category') ?> *</label>
                <div class="col-sm-4">
                    <select name="product_cat" class="form-control">
                        <?php
                        foreach ($cat as $row) {
                            $cid = $row['id'];
                            $title = $row['title'];
                            echo "<option value='$cid'>$title</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-money-bill-wave mr-2"></i> Global Pricing</h5>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="product_price"><?php echo $this->lang->line('Product Retail Price') ?>*</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                        <input type="text" name="product_price" class="form-control required" placeholder="0.00" onkeypress="return isNumber(event)">
                    </div>
                </div>
                <label class="col-sm-2 col-form-label">Default Purchase Price</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                        <input type="text" name="fproduct_price" class="form-control" placeholder="0.00" onkeypress="return isNumber(event)">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Global Product Cost</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                        <input type="text" name="fproduct_cost" class="form-control" placeholder="0.00" onkeypress="return isNumber(event)">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea placeholder="Description" class="form-control" name="product_desc" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group row mt-4">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-premium btn-success-glass btn-lg" value="<?php echo $this->lang->line('Add product') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="master_products/add" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
