<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $title; ?> </h5>
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
                    <p class="mb-2">Map your system actions to specific accounts for automatic Double-Entry Accounting.</p>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="sales_income_acc">Sales Income Account</label>
                        <div class="col-sm-6">
                            <select name="sales_income_acc" class="form-control">
                                <option value="0">-- Select Account --</option>
                                <?php foreach ($accounts as $row) {
                                    $selected = ($mappings['sales_income_acc'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['acn'] . " - " . $row['holder'] . "</option>";
                                } ?>
                            </select>
                            <small class="text-muted">Account to credit when a sale is made.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="inventory_asset_acc">Inventory Asset Account</label>
                        <div class="col-sm-6">
                            <select name="inventory_asset_acc" class="form-control">
                                <option value="0">-- Select Account --</option>
                                <?php foreach ($accounts as $row) {
                                    $selected = ($mappings['inventory_asset_acc'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['acn'] . " - " . $row['holder'] . "</option>";
                                } ?>
                            </select>
                            <small class="text-muted">Account to debit when purchasing stock (Asset).</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="cogs_acc">Cost of Goods Sold (COGS)</label>
                        <div class="col-sm-6">
                            <select name="cogs_acc" class="form-control">
                                <option value="0">-- Select Account --</option>
                                <?php foreach ($accounts as $row) {
                                    $selected = ($mappings['cogs_acc'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['acn'] . " - " . $row['holder'] . "</option>";
                                } ?>
                            </select>
                            <small class="text-muted">Expense account for COGS.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="tax_liability_acc">Tax Liability Account</label>
                        <div class="col-sm-6">
                            <select name="tax_liability_acc" class="form-control">
                                <option value="0">-- Select Account --</option>
                                <?php foreach ($accounts as $row) {
                                    $selected = ($mappings['tax_liability_acc'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['acn'] . " - " . $row['holder'] . "</option>";
                                } ?>
                            </select>
                            <small class="text-muted">Liability account to credit when collecting tax.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="bank_acc">Default Bank/Cash Account</label>
                        <div class="col-sm-6">
                            <select name="bank_acc" class="form-control">
                                <option value="0">-- Select Account --</option>
                                <?php foreach ($accounts as $row) {
                                    $selected = ($mappings['bank_acc'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['acn'] . " - " . $row['holder'] . "</option>";
                                } ?>
                            </select>
                            <small class="text-muted">Default account for receiving payments.</small>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="accounts_receivable_acc">Accounts Receivable (Debtors)</label>
                        <div class="col-sm-6">
                            <select name="accounts_receivable_acc" class="form-control">
                                <option value="0">-- Select Account --</option>
                                <?php foreach ($accounts as $row) {
                                    $selected = ($mappings['accounts_receivable_acc'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['acn'] . " - " . $row['holder'] . "</option>";
                                } ?>
                            </select>
                             <small class="text-muted">Asset Account for Unpaid Invoices.</small>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="accounts_payable_acc">Accounts Payable (Creditors)</label>
                        <div class="col-sm-6">
                            <select name="accounts_payable_acc" class="form-control">
                                <option value="0">-- Select Account --</option>
                                <?php foreach ($accounts as $row) {
                                    $selected = ($mappings['accounts_payable_acc'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['acn'] . " - " . $row['holder'] . "</option>";
                                } ?>
                            </select>
                             <small class="text-muted">Liability Account for Unpaid Purchases.</small>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-6">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Update Mappings" data-loading-text="Updating...">
                            <input type="hidden" value="financial_settings/update_mappings" id="action-url">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Optional: Add logging or extra JS logic
    });
</script>
