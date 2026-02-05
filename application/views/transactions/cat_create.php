<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters">
                <div class="col-md-12 text-center pt-4 pb-4">
                    <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('New Transactions Category') ?></h2>
                    <p class="text-white-50 mb-0">Define Transaction Types</p>
                </div>
            </div>
        </div>

        <div class="card-body p-5">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

            <form method="post" id="data_form" class="form-horizontal">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                         <div class="form-group row mb-5">
                            <label class="col-sm-4 col-form-label text-right font-weight-bold" for="catname">
                                <?php echo $this->lang->line('Category Name') ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fa fa-tag"></i></span>
                                    </div>
                                    <input type="text" placeholder="e.g. Office Supplies" class="form-control required" name="catname" style="height: 45px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-4">
                                <input type="submit" id="submit-data" class="btn btn-primary btn-lg btn-block shadow-sm"
                                    value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                                <input type="hidden" value="transactions/save_createcat" id="action-url">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


