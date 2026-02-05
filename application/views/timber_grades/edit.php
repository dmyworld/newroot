<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <h5>Edit Timber Grade</h5>
            <hr>
            <input type="hidden" name="id" value="<?php echo $grade['id'] ?>">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="grade_name">Grade Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Grade Name"
                           class="form-control margin-bottom round required" name="grade_name" value="<?php echo $grade['grade_name'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="qc_min">QC Threshold Min (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Min"
                           class="form-control margin-bottom round required" name="qc_min" value="<?php echo $grade['qc_threshold_min'] ?>">
                </div>
                <label class="col-sm-2 col-form-label" for="qc_max">QC Threshold Max (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Max"
                           class="form-control margin-bottom round required" name="qc_max" value="<?php echo $grade['qc_threshold_max'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="rejection_desc">Rejection Rules</label>
                <div class="col-sm-6">
                    <textarea placeholder="Describe rejection criteria..."
                           class="form-control margin-bottom round" name="rejection_desc" rows="3"><?php echo $grade['rejection_rule_desc'] ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Update Grade" data-loading-text="Updating...">
                    <input type="hidden" value="timber_grades/edit" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
