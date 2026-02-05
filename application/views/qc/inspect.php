<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
        <h3>Inspection Form: WO-<?php echo $wo['id']; ?></h3>
        <p><strong>Batch:</strong> <?php echo $wo['batch_name']; ?> | <strong>Stage:</strong> <?php echo $wo['stage_name']; ?></p>
        <p><strong>Worker:</strong> <?php echo $wo['employee_name']; ?> | <strong>Machine:</strong> <?php echo $wo['machine_name']; ?></p>
        <div class="alert alert-info">
            <strong>Qty Completed by Worker:</strong> <?php echo $wo['qty_completed']; ?>
        </div>
        
        <hr>
        
        <form id="inspect_form">
            <input type="hidden" name="wo_id" value="<?php echo $wo['id']; ?>">
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Qty to Inspect</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control required" name="qty_checked" value="<?php echo $wo['qty_completed']; ?>" readonly>
                    <small>Inspecting full batch</small>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label text-success">PASSED (Good)</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control required" name="qty_passed" id="qty_passed" value="<?php echo $wo['qty_completed']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label text-warning">REWORK (Repairable)</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="qty_rework" id="qty_rework" value="0">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label text-danger">MORTALITY/SCRAP</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="qty_scraped" id="qty_scraped" value="0">
                </div>
            </div>
            
            <div class="form-group row">
                 <label class="col-sm-2 col-form-label">Defect Type (if any)</label>
                 <div class="col-sm-4">
                     <select name="defect_type" class="form-control">
                         <option value="">-- None --</option>
                         <option value="Dimensions Incorrect">Dimensions Incorrect</option>
                         <option value="Surface Cracks">Surface Cracks</option>
                         <option value="Knot Defects">Knot Defects</option>
                         <option value="Finishing Issue">Finishing Issue</option>
                         <option value="Moisture Content">Moisture Content</option>
                     </select>
                 </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Inspector Comments</label>
                <div class="col-sm-8">
                     <textarea class="form-control" name="comments" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <button type="button" id="save_inspection" class="btn btn-primary btn-lg margin-bottom">Submit Result</button>
                    <p id="total_check_msg" class="text-muted mt-1"></p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#save_inspection').click(function(e) {
        e.preventDefault();
        
        var total = parseInt($('#qty_passed').val()) + parseInt($('#qty_rework').val()) + parseInt($('#qty_scraped').val());
        var checked = parseInt($('input[name="qty_checked"]').val());
        
        if(total !== checked) {
            alert('Sum of Pass + Rework + Scrap (' + total + ') must equal Qty Checked (' + checked + ')');
            return;
        }

        $.ajax({
            url: "<?php echo site_url('quality_control/save_inspection')?>",
            type: 'POST',
            data: $('#inspect_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(data) {
                if (data.status == 'Success') {
                    $('#notify').show().text(data.message);
                    setTimeout(function(){
                        if(data.redirect) window.location.href = data.redirect;
                    }, 1000);
                } else {
                     $('#notify').show().removeClass('alert-success').addClass('alert-danger').text(data.message);
                }
            }
        });
    });
</script>
