<div class="content-body">
    <div class="page-header-glass">
        <div class="page-title">
            <h2>Edit Labor Category</h2>
        </div>
        <div class="header-actions">
            <a href="<?php echo base_url('master_products/labor_categories') ?>" class="btn-premium">
                 <i class="fa fa-list"></i> Labor Categories
            </a>
        </div>
    </div>

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="premium-card">
        <form method="post" id="data_form">
            <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
            <h5 class="mb-3 text-psy-primary font-weight-bold"><i class="fa fa-briefcase mr-2"></i> Category Details</h5>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="title"><?php echo $this->lang->line('Title') ?> *</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Category Title" class="form-control required" name="title" value="<?php echo $category['title'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-6">
                    <textarea placeholder="Description of services" class="form-control" name="description" rows="3"><?php echo $category['description'] ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="commission_rate">Commission Rate (%) *</label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" name="commission_rate" class="form-control required" placeholder="0.00" onkeypress="return isNumber(event)" value="<?php echo $category['commission_rate'] ?>">
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-4">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-premium btn-success-glass btn-lg" value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="master_products/edit_labor_category" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
