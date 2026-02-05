<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Materials & Costing for Project: <?php echo $project['name'] ?></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                     <li><a href="<?php echo base_url('projects/explore?id=' . $pid) ?>" class="btn btn-warning btn-sm"><i class="fa fa-reply"></i> Back to Project</a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Add Material Used</h6>
                        <form id="add_material_form">
                            <input type="hidden" name="project_id" value="<?php echo $pid; ?>">
                            <div class="form-group">
                                <label for="product_name">Search Product</label>
                                <input type="text" class="form-control" id="product_search" placeholder="Type product name..." autocomplete="off">
                                <input type="hidden" name="product_id" id="product_id">
                                <div id="product_suggestions" class="list-group" style="position:absolute; z-index:1000; width:90%;"></div>
                            </div>
                            <div class="form-group">
                                <label for="price">Unit Cost</label>
                                <input type="text" class="form-control" name="price" id="price" required>
                            </div>
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input type="text" class="form-control" name="qty" id="qty" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit-material">Add Material</button>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <h6>Used Materials List</h6>
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($items as $item) { ?>
                                <tr>
                                    <td><?php echo $item['product_name']; ?></td>
                                    <td><?php echo $item['qty']; ?></td>
                                    <td><?php echo amountExchange($item['unit_cost'], 0, $this->aauth->get_user()->loc) ?></td>
                                    <td><?php echo amountExchange($item['total_cost'], 0, $this->aauth->get_user()->loc) ?></td>
                                    <td><a href="#" data-object-id="<?php echo $item['id']; ?>" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total Material Cost:</th>
                                    <th><?php echo amountExchange($total_cost, 0, $this->aauth->get_user()->loc) ?></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#product_search").on("keyup", function () {
        var keyword = $(this).val();
        if (keyword.length > 2) {
            $.ajax({
                type: "POST",
                url: baseurl + "project_materials/search_products",
                data: {keyword: keyword, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                success: function (data) {
                    var products = JSON.parse(data);
                    var html = '';
                    $.each(products, function (key, value) {
                        html += '<a href="#" class="list-group-item list-group-item-action product-select" data-pid="' + value.pid + '" data-price="' + value.product_price + '" data-name="' + value.product_name + '">' + value.product_name + '</a>';
                    });
                    $("#product_suggestions").html(html);
                }
            });
        } else {
             $("#product_suggestions").html('');
        }
    });

    $(document).on("click", ".product-select", function (e) {
        e.preventDefault();
        var pid = $(this).data('pid');
        var price = $(this).data('price');
        var name = $(this).data('name');
        $("#product_id").val(pid);
        $("#price").val(price);
        $("#product_search").val(name);
        $("#product_suggestions").html('');
    });

    $("#submit-material").on("click", function (e) {
        e.preventDefault();
        var o_data =  $("#add_material_form").serialize();
        var action_url = baseurl + 'project_materials/add';
        addObject(o_data, action_url);
    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete_this') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="project_materials/delete">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
