<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">New Sawing Job (Log to Sawn Conversion)</h4>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form id="sawing_form">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>1. Select Source Log Lot</h5>
                            <div class="form-group mt-1">
                                <label for="source_lot">Available Log Lots (at current location)</label>
                                <select id="source_lot" name="source_lot_id" class="form-control select2">
                                    <option value="">-- Select Lot --</option>
                                </select>
                            </div>
                            <div id="lot_details" class="alert alert-info" style="display:none;">
                                <strong>Lot Name:</strong> <span id="det_name"></span><br>
                                <strong>Available Volume:</strong> <span id="det_vol"></span> cuft
                            </div>
                        </div>
                        <div class="col-md-6 border-left">
                            <h5>2. New Sawn Lot Details</h5>
                            <div class="form-group mt-1">
                                <label for="lot_name">Target Lot Name (Sawn Timber)</label>
                                <input type="text" class="form-control" name="lot_name" id="lot_name" placeholder="E.g. SAWN-BATCH-001" required>
                            </div>
                            <div class="form-group">
                                <label for="warehouse_id">Target Warehouse</label>
                                <select name="warehouse_id" class="form-control" required>
                                    <?php foreach ($warehouse as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>3. Sawn Timber Output (Dimensions)</h5>
                    <table class="table table-bordered mt-2" id="sawn_table">
                        <thead>
                            <tr class="bg-blue-grey bg-lighten-4">
                                <th>Wood Type</th>
                                <th>Thickness (in)</th>
                                <th>Width (in)</th>
                                <th>Length (ft)</th>
                                <th>Quantity (pcs)</th>
                                <th>Volume (cuft)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="sawn_rows">
                            <tr>
                                <td>
                                    <select name="items[0][wood_type_id]" class="form-control wood-select" required>
                                        <?php foreach ($wood_types as $wt) {
                                            echo '<option value="' . $wt['id'] . '">' . $wt['name'] . '</option>';
                                        } ?>
                                    </select>
                                </td>
                                <td><input type="number" step="0.01" name="items[0][thickness]" class="form-control thickness" required></td>
                                <td><input type="number" step="0.01" name="items[0][width]" class="form-control width" required></td>
                                <td><input type="number" step="0.01" name="items[0][length]" class="form-control length" required></td>
                                <td><input type="number" name="items[0][quantity]" class="form-control quantity" required></td>
                                <td><input type="text" class="form-control row-vol" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="add_row" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Dimension</button>

                    <div class="row mt-3">
                        <div class="col-md-4 offset-md-8">
                            <table class="table table-bordered bg-lighten-5">
                                <tr>
                                    <th>Total Input (Logs)</th>
                                    <td><input type="text" name="input_qty" id="total_input" class="form-control" readonly> CF</td>
                                </tr>
                                <tr>
                                    <th>Total Output (Sawn)</th>
                                    <td><input type="text" name="output_qty" id="total_output" class="form-control" readonly> CF</td>
                                </tr>
                                <tr>
                                    <th>Slab Output (Slabs/Offcuts)</th>
                                    <td><input type="number" step="0.01" name="slabs_qty" id="slabs_qty" class="form-control" value="0"> CF</td>
                                </tr>
                                <tr class="bg-warning bg-lighten-4">
                                    <th>Wastage (%)</th>
                                    <td><input type="text" name="wastage" id="wastage_pc" class="form-control" readonly> %</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-right mt-2">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> Save Sawing Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    // Load Logs initially
    $.ajax({
        url: "<?php echo site_url('sawmill/ajax_get_logs') ?>",
        type: 'POST',
        dataType: 'json',
        data: {'<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash()?>'},
        success: function(data) {
            data.forEach(function(item) {
                $('#source_lot').append('<option value="'+item.id+'" data-name="'+item.lot_name+'" data-vol="'+item.total_cubic_feet+'">'+item.lot_name+' ('+item.total_cubic_feet+' CF)</option>');
            });
        }
    });

    $('#source_lot').on('change', function() {
        var opt = $(this).find(':selected');
        if (opt.val()) {
            $('#det_name').text(opt.data('name'));
            $('#det_vol').text(opt.data('vol'));
            $('#total_input').val(opt.data('vol'));
            $('#lot_details').show();
            calculateTotals();
        } else {
            $('#lot_details').hide();
            $('#total_input').val(0);
        }
    });

    var rowCount = 1;
    $('#add_row').on('click', function() {
        var newRow = `<tr>
            <td>
                <select name="items[${rowCount}][wood_type_id]" class="form-control wood-select" required>
                    <?php foreach ($wood_types as $wt) { echo '<option value="'.$wt['id'].'">'.$wt['name'].'</option>'; } ?>
                </select>
            </td>
            <td><input type="number" step="0.01" name="items[${rowCount}][thickness]" class="form-control thickness" required></td>
            <td><input type="number" step="0.01" name="items[${rowCount}][width]" class="form-control width" required></td>
            <td><input type="number" step="0.01" name="items[${rowCount}][length]" class="form-control length" required></td>
            <td><input type="number" name="items[${rowCount}][quantity]" class="form-control quantity" required></td>
            <td><input type="text" class="form-control row-vol" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button></td>
        </tr>`;
        $('#sawn_rows').append(newRow);
        rowCount++;
    });

    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        calculateTotals();
    });

    $(document).on('input', '.thickness, .width, .length, .quantity', function() {
        var row = $(this).closest('tr');
        var t = parseFloat(row.find('.thickness').val()) || 0;
        var w = parseFloat(row.find('.width').val()) || 0;
        var l = parseFloat(row.find('.length').val()) || 0;
        var q = parseFloat(row.find('.quantity').val()) || 0;
        
        // Formula: (T * W * L) / 12 * Q
        var vol = (t * w * l / 12) * q;
        row.find('.row-vol').val(vol.toFixed(4));
        calculateTotals();
    });

    function calculateTotals() {
        var totalOutput = 0;
        $('.row-vol').each(function() {
            totalOutput += parseFloat($(this).val()) || 0;
        });
        $('#total_output').val(totalOutput.toFixed(4));

        var slabs = parseFloat($('#slabs_qty').val()) || 0;
        var input = parseFloat($('#total_input').val()) || 0;
        if (input > 0) {
            var wastage = ((input - (totalOutput + slabs)) / input) * 100;
            $('#wastage_pc').val(wastage.toFixed(2));
        } else {
            $('#wastage_pc').val(0);
        }
    }

    $(document).on('input', '#slabs_qty', function() {
        calculateTotals();
    });

    $("#sawing_form").submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash()?>';

        $.ajax({
            url: "<?php echo site_url('sawmill/save_job') ?>",
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    setTimeout(function() { window.location.href = "<?php echo site_url('sawmill/processing') ?>"; }, 2000);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            }
        });
    });
});
</script>
