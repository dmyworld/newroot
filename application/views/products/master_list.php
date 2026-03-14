<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        <div class="card-body">
            <h5 class="title">
                <?php echo $this->lang->line('Products') ?> Master List (One-Click Warehouse)
            </h5>
            <hr>
            <table id="master_table" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('Warehouse') ?></th>
                    <th><?php echo $this->lang->line('Qty') ?></th>
                    <th><?php echo $this->lang->line('Action') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; foreach ($products as $row) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_code']; ?></td>
                        <td><?php echo $row['warehouse_name']; ?></td>
                        <td>
                            <?php
                            $qty = +$row['qty'];
                            $alert = +$row['alert'];
                            $color = 'success';
                            if ($qty <= $alert) {
                                $color = 'danger';
                            } elseif ($qty <= $alert * 2) {
                                $color = 'warning';
                            }
                            ?>
                            <span class="badge badge-<?php echo $color; ?> px-2" style="font-size:1rem; border-radius:12px;"><?php echo $qty; ?></span>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm import-btn" 
                                    data-pid="<?php echo $row['pid']; ?>" 
                                    data-name="<?php echo $row['product_name']; ?>">
                                <i class="fa fa-download"></i> Import
                            </button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</article>

<div id="importModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Product to Warehouse</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p id="pname"></p>
                <form id="import_form">
                    <input type="hidden" name="pid" id="import_pid">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="warehouse">Target Warehouse</label>
                        <div class="col-sm-8">
                            <select name="warehouse" class="form-control">
                                <?php foreach ($warehouse as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="qty">Initial Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="qty" value="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirm_import">Import Now</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#master_table').DataTable();

        $('.import-btn').click(function() {
            var pid = $(this).data('pid');
            var name = $(this).data('name');
            $('#import_pid').val(pid);
            $('#pname').text('Cloning: ' + name);
            $('#importModal').modal('show');
        });

        $('#confirm_import').click(function() {
            $.ajax({
                url: "<?php echo base_url('products/add_from_master') ?>",
                type: 'POST',
                data: $('#import_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#importModal').modal('hide');
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                    }
                }
            });
        });
    });
</script>
