<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Bonus') ?></h5>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="employee_id"><?php echo $this->lang->line('Employee') ?></label>
                        <div class="col-sm-6">
                            <select name="employee_id" class="form-control select-box">
                                <?php foreach($employees as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="amount"><?php echo $this->lang->line('Amount') ?></label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Amount"
                                   class="form-control margin-bottom required" name="amount" onkeypress="return isNumber(event)">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="type"><?php echo $this->lang->line('Type') ?></label>
                        <div class="col-sm-6">
                            <select name="type" class="form-control">
                                <option value="Performance">Performance</option>
                                <option value="Annual">Annual</option>
                                <option value="Spot">Spot</option>
                                <option value="Commission">Commission</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="date_effective"><?php echo $this->lang->line('Effective Date') ?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required"
                                   placeholder="Billing Date" name="date_effective"
                                   data-toggle="datepicker"
                                   autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="note"><?php echo $this->lang->line('Note') ?></label>
                        <div class="col-sm-6">
                             <input type="text" placeholder="Short Note"
                                   class="form-control margin-bottom" name="note">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="payrollbonus/save_bonus" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.select-box').select2();
    });
</script>
