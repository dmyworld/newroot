<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <h5>Cutting Plan Generator (Multi-Size Optimization)</h5>
            <hr>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="batch_id">Link to Batch (Optional)</label>
                <div class="col-sm-6">
                    <select name="batch_id" class="form-control margin-bottom round">
                        <option value="">-- Select Batch --</option>
                        <?php foreach($batches as $batch) { ?>
                            <option value="<?php echo $batch['id'] ?>"><?php echo $batch['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <h6 class="text-muted">Raw Log / Timber Dimensions (inches)</h6>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>Length</label>
                    <input type="number" step="0.01" class="form-control required" name="raw_l" placeholder="Length (L)">
                </div>
                <div class="col-sm-3">
                    <label>Width</label>
                    <input type="number" step="0.01" class="form-control required" name="raw_w" placeholder="Width (W)">
                </div>
                <div class="col-sm-3">
                    <label>Thickness</label>
                    <input type="number" step="0.01" class="form-control required" name="raw_h" placeholder="Thickness (H)">
                </div>
            </div>

            <hr>
            <h6 class="text-muted">Target Cut List <button type="button" class="btn btn-sm btn-success" id="add_row"><i class="fa fa-plus"></i></button></h6>
            <div id="target_rows">
                <div class="form-group row target-row">
                    <div class="col-sm-3">
                        <label>Length</label>
                        <input type="number" step="0.01" class="form-control required" name="target_l[]" placeholder="L">
                    </div>
                    <div class="col-sm-2">
                        <label>Width</label>
                        <input type="number" step="0.01" class="form-control required" name="target_w[]" placeholder="W">
                    </div>
                    <div class="col-sm-2">
                        <label>Thickness</label>
                        <input type="number" step="0.01" class="form-control required" name="target_h[]" placeholder="H">
                    </div>
                    <div class="col-sm-2">
                         <label>Qty</label>
                        <input type="number" step="1" class="form-control required" name="target_qty[]" placeholder="Qty" value="1">
                    </div>
                    <div class="col-sm-1">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-2">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <button type="button" id="calculate_plan" class="btn btn-primary margin-bottom">Calculate Plan</button>
                </div>
            </div>
            
            <!-- Result Area -->
            <div id="result_area" style="display:none;" class="alert alert-info">
                <h4>Calculation Result:</h4>
                <p><strong>Total Logs Needed:</strong> <span id="res_logs" style="font-size: 1.2em; font-weight: bold;">0</span></p>
                <p><strong>Total Pieces:</strong> <span id="res_planks">0</span></p>
                <p><strong>Total Waste:</strong> <span id="res_waste">0%</span></p>
                <div id="res_details" style="background: rgba(255,255,255,0.5); padding: 10px; margin-top: 10px;"></div>
                <hr>
                <small>Raw Vol: <span id="res_raw_vol"></span> | Used Vol: <span id="res_used_vol"></span></small>
            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        
        // Add Row
        $('#add_row').click(function() {
            var html = '<div class="form-group row target-row">' +
                    '<div class="col-sm-3"><input type="number" step="0.01" class="form-control required" name="target_l[]" placeholder="L"></div>' +
                    '<div class="col-sm-2"><input type="number" step="0.01" class="form-control required" name="target_w[]" placeholder="W"></div>' +
                    '<div class="col-sm-2"><input type="number" step="0.01" class="form-control required" name="target_h[]" placeholder="H"></div>' +
                    '<div class="col-sm-2"><input type="number" step="1" class="form-control required" name="target_qty[]" placeholder="Qty" value="1"></div>' +
                    '<div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-minus"></i></button></div>' +
                '</div>';
            $('#target_rows').append(html);
        });

        // Remove Row
        $(document).on('click', '.remove-row', function() {
            // Need at least one row
            if($('.target-row').length > 1) {
                $(this).closest('.target-row').remove();
            } else {
                alert('You must have at least one target item.');
            }
        });

        $('#calculate_plan').click(function(e) {
            e.preventDefault();
            var form = $('#data_form');
            var url = "<?php echo site_url('cutting_plan/create') ?>"; 
            
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
                dataType: "json",
                success: function (data) {
                    if (data.status == 'Success') {
                        $('#result_area').show();
                        $('#res_planks').text(data.result.planks);
                        $('#res_waste').text(data.result.waste);
                        $('#res_raw_vol').text(data.result.raw_vol);
                        $('#res_used_vol').text(data.result.used_vol);
                        $('#res_logs').text(data.result.logs_needed);
                        $('#res_details').html(data.result.details);
                        
                        $('#notify').show().removeClass('alert-danger').addClass('alert-success');
                        $('.message').text(data.message);
                    } else {
                         $('#result_area').hide();
                         $('#notify').show().removeClass('alert-success').addClass('alert-danger');
                         $('.message').text(data.message);
                    }
                }
            });
        });
    });
</script>
