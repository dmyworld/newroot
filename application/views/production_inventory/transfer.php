<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5>Move Stock</h5>
        <hr>
        <form id="transfer_form">
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Product</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="product_name" id="product_search" placeholder="Type to search product...">
                    <input type="hidden" name="product_id" id="product_id" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">From Location</label>
                <div class="col-sm-6">
                    <select name="from_location_id" class="form-control">
                        <option value="0">-- External / Supplier (Initial Stock) --</option>
                        <?php foreach($locations as $loc) { ?>
                            <option value="<?php echo $loc['id']; ?>"><?php echo $loc['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">To Location</label>
                <div class="col-sm-6">
                    <select name="to_location_id" class="form-control">
                        <?php foreach($locations as $loc) { ?>
                            <option value="<?php echo $loc['id']; ?>"><?php echo $loc['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Quantity</label>
                <div class="col-sm-2">
                    <input type="number" step="0.01" class="form-control required" name="qty" placeholder="0.00">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Note</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="note" placeholder="Reason for move">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <button type="button" id="submit_transfer" class="btn btn-primary margin-bottom">Transfer Stock</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    // Simple autocomplete for product
    $("#product_search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?php echo site_url('production_inventory/product_search')?>",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.product_name,
                            value: item.product_name,
                            id: item.pid
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $('#product_id').val(ui.item.id);
        }
    });

    $('#submit_transfer').click(function(e){
        e.preventDefault();
        $.ajax({
            url: "<?php echo site_url('production_inventory/save_transfer')?>",
            type: 'POST',
            data: $('#transfer_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(data) {
                if (data.status == 'Success') {
                   $('#notify').show();
                   $('.message').text(data.message);
                   setTimeout(function(){ window.location.href = data.redirect; }, 1000);
                } else {
                   $('#notify').show().removeClass('alert-success').addClass('alert-danger');
                   $('.message').text(data.message);
                }
            }
        });
    });
</script>
