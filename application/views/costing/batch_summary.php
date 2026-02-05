<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Production Cost Sheet</h3>
                <p class="text-center">Batch: <strong><?php echo $batch['name']; ?></strong> | Qty: <?php echo $batch['items_qty']; ?></p>
                <hr>
                
                <h5>1. Material Cost</h5>
                <table class="table table-sm">
                    <thead><tr><th>Item</th><th>Qty</th><th>Unit Cost</th><th>Total</th></tr></thead>
                    <tbody>
                        <?php foreach($costing['materials'] as $mat) { ?>
                        <tr>
                            <td><?php echo $mat['product_name']; ?></td>
                            <td><?php echo $mat['qty']; ?></td>
                            <td><?php echo number_format($mat['product_price'], 2); ?></td>
                            <td><?php echo number_format($mat['qty'] * $mat['product_price'], 2); ?></td>
                        </tr>
                        <?php } ?>
                        <tr class="font-weight-bold bg-light">
                            <td colspan="3" class="text-right">Total Material:</td>
                            <td><?php echo number_format($costing['material_total'], 2); ?></td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="mt-2">2. Labor Cost</h5>
                 <table class="table table-sm">
                    <thead><tr><th>Task</th><th>Employee</th><th>Hours</th><th>Rate/Hr</th><th>Total</th></tr></thead>
                    <tbody>
                        <?php foreach($costing['labor'] as $lab) { ?>
                        <tr>
                            <td><?php echo $lab['stage_name']; ?></td>
                            <td><?php echo $lab['username']; ?></td>
                            <td><?php echo $lab['hours']; ?></td>
                            <td><?php echo number_format($lab['hourly_rate'], 2); ?></td>
                            <td><?php echo number_format($lab['cost'], 2); ?></td>
                        </tr>
                        <?php } ?>
                         <tr class="font-weight-bold bg-light">
                            <td colspan="4" class="text-right">Total Labor:</td>
                            <td><?php echo number_format($costing['labor_total'], 2); ?></td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="mt-2">3. Machine Cost</h5>
                 <table class="table table-sm">
                    <thead><tr><th>Machine</th><th>Hours</th><th>Rate/Hr</th><th>Total</th></tr></thead>
                    <tbody>
                        <?php foreach($costing['machines'] as $mac) { ?>
                        <tr>
                            <td><?php echo $mac['machine_name']; ?></td>
                            <td><?php echo $mac['hours']; ?></td>
                            <td><?php echo number_format($mac['operating_cost_per_hour'], 2); ?></td>
                            <td><?php echo number_format($mac['cost'], 2); ?></td>
                        </tr>
                        <?php } ?>
                         <tr class="font-weight-bold bg-light">
                            <td colspan="3" class="text-right">Total Machine:</td>
                            <td><?php echo number_format($costing['machine_total'], 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                
                <hr>
                <h2 class="text-right text-danger">Grand Total: <?php echo number_format($costing['grand_total'], 2); ?></h2>
                <h4 class="text-right text-info">Cost Per Unit: <?php echo ($batch['items_qty'] > 0) ? number_format($costing['grand_total'] / $batch['items_qty'], 2) : 0; ?></h4>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Add Material Consumption</h5>
                <hr>
                <form id="consumption_form">
                    <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                    
                    <div class="form-group">
                        <label>Product</label>
                        <input type="text" class="form-control" id="product_search" placeholder="Search...">
                        <input type="hidden" name="product_id" id="product_id">
                    </div>

                    <div class="form-group">
                         <label>Qty Consumed</label>
                         <input type="number" step="0.01" name="qty" class="form-control required">
                    </div>

                    <button type="button" id="add_consumption" class="btn btn-warning btn-block">Record Consumption</button>
                </form>
                <div id="notify" class="alert mt-1" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Reuse inventory search
    $("#product_search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?php echo site_url('production_inventory/product_search')?>",
                dataType: "json",
                data: { term: request.term },
                success: function(data) {
                    response($.map(data, function(item) {
                        return { label: item.product_name, value: item.product_name, id: item.pid };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) { $('#product_id').val(ui.item.id); }
    });

    $('#add_consumption').click(function(){
        $.ajax({
            url: "<?php echo site_url('production_costing/add_consumption')?>",
            type: 'POST',
            data: $('#consumption_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(data){
                if(data.status == 'Success') {
                    location.reload();
                } else {
                    alert('Error');
                }
            }
        });
    });
</script>
