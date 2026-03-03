<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">New Transport Order / Dispatch</h4>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form id="order_form">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>1. Link Order / Shipment</h5>
                            <div class="form-group mt-1">
                                <label for="order_type">Reference Type</label>
                                <select id="order_type" class="form-control">
                                    <option value="invoice">Sales Invoice (Delivery)</option>
                                    <option value="purchase">Purchase Order (Pickup)</option>
                                    <option value="custom">Custom Logistics</option>
                                </select>
                            </div>
                            <div class="form-group" id="ref_select_div">
                                <label for="order_ref">Select Document</label>
                                <select name="order_ref" id="order_ref" class="form-control select2">
                                    <option value="">-- Select --</option>
                                    <?php foreach ($invoices as $inv): ?>
                                        <option value="<?= $inv['id'] ?>" data-type="invoice">INV #<?= $inv['tid'] ?> (<?= amountExchange($inv['total'], 0, $this->aauth->get_user()->loc) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group" id="custom_ref_div" style="display:none;">
                                <label for="custom_ref">Custom Reference #</label>
                                <input type="text" name="order_ref_custom" id="order_ref_custom" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 border-left">
                            <h5>2. Assign Vehicle & Driver</h5>
                            <div class="form-group mt-1">
                                <label for="vehicle_id">Select Available Fleet</label>
                                <select name="vehicle_id" id="vehicle_id" class="form-control" required>
                                    <option value="">-- Select Vehicle --</option>
                                    <?php foreach ($fleet as $v): ?>
                                        <option value="<?= $v['id'] ?>"><?= $v['vehicle_no'] ?> - <?= $v['driver_name'] ?> (<?= $v['vehicle_type'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>3. Route Information</h5>
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pickup_loc">Pickup Location / Address</label>
                                <input type="text" name="pickup_loc" class="form-control" placeholder="E.g. Main Warehouse" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_loc">Delivery Location / Destination</label>
                                <input type="text" name="delivery_loc" class="form-control" placeholder="E.g. Client Site B" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-2">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane"></i> Dispatch Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#order_type').on('change', function() {
        var type = $(this).val();
        if (type === 'custom') {
            $('#ref_select_div').hide();
            $('#custom_ref_div').show();
        } else {
            $('#custom_ref_div').hide();
            $('#ref_select_div').show();
            // In a real app, we'd AJAX fetch the correct documents here
            // But for now we just show/hide if needed
        }
    });

    $("#order_form").submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash()?>';

        $.ajax({
            url: "<?php echo site_url('logistics/save_order') ?>",
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    setTimeout(function() { window.location.href = "<?php echo site_url('logistics/orders') ?>"; }, 2000);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                }
            }
        });
    });
});
</script>
