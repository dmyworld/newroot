<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <h5>Create Production Batch</h5>
            <hr>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Batch Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Batch Name (e.g. Order #123 Table Legs)"
                           class="form-control margin-bottom round required" name="name">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="wood_id">Wood Type</label>
                <div class="col-sm-6">
                    <select name="wood_id" class="form-control margin-bottom round">
                        <?php foreach($wood_types as $wood) { ?>
                            <option value="<?php echo $wood->id ?>"><?php echo $wood->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="qty">Quantity</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control margin-bottom round required" name="qty" placeholder="0.00">
                </div>
                <div class="col-sm-2">
                     <select name="unit" class="form-control margin-bottom round">
                        <option value="CFT">CFT</option>
                        <option value="SFT">SFT</option>
                        <option value="RFT">RFT</option>
                        <option value="Pcs">Pieces</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="priority">Priority</label>
                <div class="col-sm-6">
                    <select name="priority" class="form-control margin-bottom round">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="due_date">Due Date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control result-date required" name="due_date" 
                           data-toggle="datepicker" autocomplete="false" placeholder="Date">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Create Batch" data-loading-text="Creating...">
                    <input type="hidden" value="production_schedule/create_batch" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
