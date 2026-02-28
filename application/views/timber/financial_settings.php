<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <i class="fa fa-calculator text-primary"></i> TimberPro Financial Settings
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="inventory_acc">Default Inventory Account</label>
                        <div class="col-sm-9">
                            <select name="inventory_acc" class="form-control">
                                <?php foreach ($accounts as $row) {
                                    $s = ($config['key2'] == $row['id']) ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" ' . $s . '>' . $row['holder'] . ' (' . $row['acn'] . ')</option>';
                                } ?>
                            </select>
                            <small class="text-muted">This account will be debited (Inventory Increase) when new timber lots are acquired/recorded.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="purchase_acc">Default Purchase/Cash Account</label>
                        <div class="col-sm-9">
                            <select name="purchase_acc" class="form-control">
                                <?php foreach ($accounts as $row) {
                                    $s = ($config['url'] == $row['id']) ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" ' . $s . '>' . $row['holder'] . ' (' . $row['acn'] . ')</option>';
                                } ?>
                            </select>
                            <small class="text-muted">This account will be credited (Asset Decrease) to offset the inventory acquisition cost.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-lg text-white" style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); border: none; border-radius: 14px; font-weight: 700;" value="Update Financial Settings" data-loading-text="Updating...">
                            <input type="hidden" value="<?= site_url('TimberPro/save_financials') ?>" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#submit-data").on("click", function(e) {
        e.preventDefault();
        var o_data = $("#data_form").serialize();
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
    });
</script>
