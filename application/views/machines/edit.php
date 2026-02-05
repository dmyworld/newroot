<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <h5>Edit Machine</h5>
            <hr>
            <input type="hidden" name="id" value="<?php echo $machine['id'] ?>">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Machine Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom round required" name="name" value="<?php echo $machine['name'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="code">Code</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Code (e.g. MCH-001)"
                           class="form-control margin-bottom round required" name="code" value="<?php echo $machine['machine_code'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="capacity">Capacity (per Hour)</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Capacity"
                           class="form-control margin-bottom round" name="capacity" value="<?php echo $machine['capacity_per_hour'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="cycle">Maint. Cycle (Days)</label>
                <div class="col-sm-2">
                    <input type="number" placeholder="Days"
                           class="form-control margin-bottom round required" name="cycle" value="<?php echo $machine['maintenance_cycle_days'] ?>">
                </div>
                <label class="col-sm-2 col-form-label" for="last_maint">Last Maint. Date</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control result-date required" name="last_maint" 
                           data-toggle="datepicker" autocomplete="false" placeholder="Date" value="<?php echo $machine['last_maintenance_date'] ?>">
                </div>
            </div>
             <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" class="form-control margin-bottom round">
                         <option value="Active" <?php if($machine['status']=='Active') echo 'selected' ?>>Active</option>
                         <option value="Inactive" <?php if($machine['status']=='Inactive') echo 'selected' ?>>Inactive</option>
                         <option value="Maintenance" <?php if($machine['status']=='Maintenance') echo 'selected' ?>>Under Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Update Machine" data-loading-text="Updating...">
                    <input type="hidden" value="machines/edit" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
