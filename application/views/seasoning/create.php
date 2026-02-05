<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5 class="title"> Start Seasoning Batch </h5>
        <hr>
        <form method="post" id="data_form">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Batch Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Batch Name (e.g. Kiln A - Oak Load)"
                           class="form-control margin-bottom round required" name="name">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="method">Drying Method</label>
                <div class="col-sm-6">
                    <select name="method" class="form-control margin-bottom round">
                         <option value="Kiln">Kiln Drying</option>
                         <option value="Air Drying">Air Drying</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="location">Location / Kiln ID</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="e.g. Kiln #1 or Shed B"
                           class="form-control margin-bottom round" name="location">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="start_date">Start Date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control required" name="start_date" data-toggle="datepicker" autocomplete="false">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="initial_mc">Initial Moisture %</label>
                <div class="col-sm-2">
                    <input type="number" step="0.1" class="form-control required" name="initial_mc" placeholder="e.g. 30">
                </div>
                <label class="col-sm-2 col-form-label" for="target_mc">Target Moisture %</label>
                <div class="col-sm-2">
                     <input type="number" step="0.1" class="form-control required" name="target_mc" placeholder="e.g. 10">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Start Batch" data-loading-text="Creating...">
                    <input type="hidden" value="seasoning/create" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
