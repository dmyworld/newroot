<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <h5>Edit Wood Type</h5>
            <hr>
            <input type="hidden" name="id" value="<?php echo $wood['id'] ?>">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Wood Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom round required" name="name" value="<?php echo $wood['name'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="density">Density (kg/m³)</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Density"
                           class="form-control margin-bottom round required" name="density" value="<?php echo $wood['density'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="moisture_min">Moisture Min (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Min"
                           class="form-control margin-bottom round" name="moisture_min" value="<?php echo $wood['moisture_tolerance_min'] ?>">
                </div>
                <label class="col-sm-2 col-form-label" for="moisture_max">Moisture Max (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Max"
                           class="form-control margin-bottom round" name="moisture_max" value="<?php echo $wood['moisture_tolerance_max'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="shrinkage">Shrinkage Coeff</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="0.0000"
                           class="form-control margin-bottom round" name="shrinkage" value="<?php echo $wood['shrinkage_coeff'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-6">
                    <textarea placeholder="Description"
                           class="form-control margin-bottom round" name="description" rows="3"><?php echo $wood['description'] ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Update Wood Type" data-loading-text="Updating...">
                    <input type="hidden" value="wood_types/edit" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
