<div class="content-body">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Payroll Configuration</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" aria-controls="general" role="tab">General & Overtime</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="deductions-tab" data-toggle="tab" href="#deductions" aria-controls="deductions" role="tab">Statutory & Deductions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="jobcodes-tab" data-toggle="tab" href="#jobcodes" aria-controls="jobcodes" role="tab">Job Codes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="accounts-tab" data-toggle="tab" href="#accounts" aria-controls="accounts" role="tab">Accounts Integration</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <!-- GENERAL & OVERTIME -->
                            <div class="tab-pane active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h5>Overtime Rules</h5>
                                        <button class="btn btn-sm btn-primary mb-1" data-toggle="modal" data-target="#addOvertimeModal">Add Rule</button>
                                        <table class="table table-bordered">
                                            <thead><tr><th>Name</th><th>Type</th><th>Threshold</th><th>Multiplier</th><th>Action</th></tr></thead>
                                            <tbody>
                                            <?php foreach ($overtime_rules as $rule) { ?>
                                                <tr>
                                                    <td><?php echo $rule['name'] ?></td>
                                                    <td><?php echo ucfirst($rule['type']) ?></td>
                                                    <td><?php echo $rule['threshold_hours'] ?> hrs</td>
                                                    <td><?php echo $rule['rate_multiplier'] ?>x</td>
                                                    <td><a href="#" data-object-id="<?php echo $rule['id']; ?>" data-action-url="payrollsettings/delete_overtime_rule" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                     <div class="col-md-5">
                                        <h5>Global Settings</h5>
                                        <form id="config_form">
                                            <div class="form-group">
                                                <label>Pay Frequency</label>
                                                <select class="form-control" name="pay_frequency">
                                                    <option value="Weekly" <?php if($pay_frequency == 'Weekly') echo 'selected' ?>>Weekly</option>
                                                    <option value="Bi-Weekly" <?php if($pay_frequency == 'Bi-Weekly') echo 'selected' ?>>Bi-Weekly</option>
                                                    <option value="Monthly" <?php if($pay_frequency == 'Monthly') echo 'selected' ?>>Monthly</option>
                                                </select>
                                            </div>
                                             <button class="btn btn-success" id="save_config_btn">Save Config</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- DEDUCTIONS -->
                            <div class="tab-pane" id="deductions" role="tabpanel" aria-labelledby="deductions-tab">
                                 <button class="btn btn-sm btn-primary mb-1" data-toggle="modal" data-target="#addDeductionModal">Add Deduction Type</button>
                                 <table class="table table-striped">
                                    <thead><tr><th>Name</th><th>Category</th><th>Statutory</th><th>Calculation</th><th>Employee % / Val</th><th>Employer %</th><th>Action</th></tr></thead>
                                    <tbody>
                                    <?php foreach ($deduction_types as $ded) { ?>
                                        <tr>
                                            <td><?php echo $ded['name'] ?></td>
                                            <td><?php echo $ded['category'] ?></td>
                                            <td><?php echo $ded['statutory_type'] != 'None' ? $ded['statutory_type'] : '-'; ?></td>
                                            <td><?php echo $ded['calculation_type'] ?></td>
                                            <td><?php echo $ded['default_value'] ?></td>
                                            <td><?php echo $ded['employer_match_percent'] ?>%</td>
                                            <td><a href="#" data-object-id="<?php echo $ded['id']; ?>" data-action-url="payrollsettings/delete_deduction_type" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- JOB CODES -->
                            <div class="tab-pane" id="jobcodes" role="tabpanel" aria-labelledby="jobcodes-tab">
                                 <button class="btn btn-sm btn-primary mb-1" data-toggle="modal" data-target="#addJobCodeModal">Add Job Code</button>
                                 <table class="table table-striped">
                                    <thead><tr><th>Code</th><th>Title</th><th>Rate</th><th>Action</th></tr></thead>
                                    <tbody>
                                     <?php foreach ($job_codes as $job) { ?>
                                        <tr>
                                            <td><?php echo $job['code'] ?></td>
                                            <td><?php echo $job['title'] ?></td>
                                            <td><?php echo $job['hourly_rate'] ?></td>
                                            <td><a href="#" data-object-id="<?php echo $job['id']; ?>" data-action-url="payrollsettings/delete_job_code" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- ACCOUNTS INTEGRATION -->
                            <div class="tab-pane" id="accounts" role="tabpanel" aria-labelledby="accounts-tab">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> <strong>Accounts Integration:</strong> Map payroll components to your chart of accounts. Journal entries will be created automatically when payroll runs are approved.
                                        </div>
                                        
                                        <form id="accounts_config_form">
                                            <h5>Account Mappings</h5>
                                            
                                            <div class="form-group">
                                                <label>Salary Expense Account</label>
                                                <select class="form-control" name="payroll_salary_expense_account">
                                                    <option value="0">-- Select Account --</option>
                                                    <?php foreach ($accounts as $acc) { ?>
                                                        <option value="<?php echo $acc['id']; ?>" <?php if($payroll_salary_expense_account == $acc['id']) echo 'selected'; ?>>
                                                            <?php echo $acc['acn'] . ' - ' . $acc['holder']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-muted">Debit: Salary expense when payroll is approved</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>EPF Payable Account</label>
                                                <select class="form-control" name="payroll_epf_payable_account">
                                                    <option value="0">-- Select Account --</option>
                                                    <?php foreach ($accounts as $acc) { ?>
                                                        <option value="<?php echo $acc['id']; ?>" <?php if($payroll_epf_payable_account == $acc['id']) echo 'selected'; ?>>
                                                            <?php echo $acc['acn'] . ' - ' . $acc['holder']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-muted">Credit: Total EPF liability (Employee 8% + Employer 12%)</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>ETF Payable Account</label>
                                                <select class="form-control" name="payroll_etf_payable_account">
                                                    <option value="0">-- Select Account --</option>
                                                    <?php foreach ($accounts as $acc) { ?>
                                                        <option value="<?php echo $acc['id']; ?>" <?php if($payroll_etf_payable_account == $acc['id']) echo 'selected'; ?>>
                                                            <?php echo $acc['acn'] . ' - ' . $acc['holder']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-muted">Credit: ETF liability (Employer 3%)</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Salary Payable Account</label>
                                                <select class="form-control" name="payroll_salary_payable_account">
                                                    <option value="0">-- Select Account --</option>
                                                    <?php foreach ($accounts as $acc) { ?>
                                                        <option value="<?php echo $acc['id']; ?>" <?php if($payroll_salary_payable_account == $acc['id']) echo 'selected'; ?>>
                                                            <?php echo $acc['acn'] . ' - ' . $acc['holder']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-muted">Credit: Net salary payable to employees</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Default Payment Account (Bank/Cash)</label>
                                                <select class="form-control" name="payroll_payment_account">
                                                    <option value="0">-- Select Account --</option>
                                                    <?php foreach ($accounts as $acc) { ?>
                                                        <option value="<?php echo $acc['id']; ?>" <?php if($payroll_payment_account == $acc['id']) echo 'selected'; ?>>
                                                            <?php echo $acc['acn'] . ' - ' . $acc['holder']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-muted">Credit: Account used for salary payments</small>
                                            </div>
                                            
                                            <button type="button" class="btn btn-success" id="save_accounts_config_btn">
                                                <i class="fa fa-save"></i> Save Account Mappings
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h5>Journal Entry Preview</h5>
                                        <div class="card">
                                            <div class="card-body">
                                                <small class="text-muted">When payroll is approved:</small>
                                                <table class="table table-sm mt-2">
                                                    <thead><tr><th>Account</th><th>Dr</th><th>Cr</th></tr></thead>
                                                    <tbody>
                                                        <tr><td>Salary Expense</td><td>XXX</td><td>-</td></tr>
                                                        <tr><td>Salary Payable</td><td>-</td><td>XXX</td></tr>
                                                        <tr><td colspan="3"><hr></td></tr>
                                                        <tr><td>EPF Expense</td><td>XX</td><td>-</td></tr>
                                                        <tr><td>EPF Payable</td><td>-</td><td>XX</td></tr>
                                                        <tr><td colspan="3"><hr></td></tr>
                                                        <tr><td>ETF Expense</td><td>XX</td><td>-</td></tr>
                                                        <tr><td>ETF Payable</td><td>-</td><td>XX</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Overtime Modal -->
<div id="addOvertimeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Overtime Rule</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add_overtime_form">
                    <div class="form-group">
                        <label>Rule Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type">
                            <option value="weekly">Weekly (> 40 hrs)</option>
                            <option value="daily">Daily (> 8 hrs)</option>
                            <option value="weekend">Weekend Work</option>
                            <option value="holiday">Holiday Work</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Threshold Hours</label>
                        <input type="number" step="0.5" class="form-control" name="threshold" value="40.00">
                    </div>
                    <div class="form-group">
                        <label>Rate Multiplier (e.g., 1.5, 2.0)</label>
                        <input type="number" step="0.1" class="form-control" name="multiplier" value="1.5">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_overtime">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Deduction Modal -->
<div id="addDeductionModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Deduction Type</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add_deduction_form">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category">
                            <option value="Tax">Tax</option>
                            <option value="Social Security">Social Security</option>
                            <option value="Medicare">Medicare</option>
                            <option value="Insurance">Insurance</option>
                            <option value="Retirement">Retirement</option>
                            <option value="Advance">Advance</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Statutory Type</label>
                        <select class="form-control" name="statutory_type">
                            <option value="None">None (Voluntary)</option>
                            <option value="EPF">EPF (Provident Fund)</option>
                            <option value="ETF">ETF (Trust Fund)</option>
                            <option value="PAYE">PAYE (Tax)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Calculation Type</label>
                         <select class="form-control" name="calc_type">
                            <option value="Percentage">Percentage of Gross</option>
                            <option value="Fixed Amount">Fixed Amount</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Employee Contribution (Value or %)</label>
                        <input type="number" step="0.01" class="form-control" name="default_val" value="0.00">
                    </div>
                     <div class="form-group">
                        <label>Employer Contribution % (EPF/ETF)</label>
                        <input type="number" step="0.01" class="form-control" name="match_percent" value="0.00">
                    </div>
                     <div class="form-group">
                        <label>Salary Ceiling (Max Amount for Calculation)</label>
                        <input type="number" step="0.01" class="form-control" name="salary_ceiling" value="0.00">
                        <small>Leave 0.00 for no limit</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_deduction">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Job Code Modal -->
<div id="addJobCodeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Job Code</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add_jobcode_form">
                    <div class="form-group">
                        <label>Code (Unique)</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                     <div class="form-group">
                        <label>Hourly Rate</label>
                        <input type="number" step="0.01" class="form-control" name="rate" value="0.00">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_jobcode">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Job Code Modal -->
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete_this_confirm') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="payrollsettings/delete_job_code">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    // --- GENERIC AJAX SAVE ---
    function saveObject(form_id, action_url) {
        var form = $(form_id);
        var data = form.serialize();
        // Append CSRF manually if not in form? Ideally form should have it or we access via global
        // CI3 usually handles it if form_open used, but here standard HTML forms.
        // We will append it to data string if not present
        data += '&' + crsf_token + '=' + crsf_hash;

        $.ajax({
            url: action_url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $('#notify .message').html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({ scrollTop: $('#notify').offset().top }, 1000);
                    // Close Modals
                    $('.modal').modal('hide');
                    // Reload to show new data (simplest way without complex DOM manipulation)
                     setTimeout(function(){ location.reload(); }, 2000); 
                } else {
                    $('#notify .message').html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                }
            },
            error: function (data) {
               $('#notify .message').html("<strong>Error</strong>: Server Error");
               $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            }
        });
    }

    // --- EVENT LISTENERS ---

    // Overtime
    $(document).on('click', "#save_overtime", function (e) {
        e.preventDefault();
        saveObject('#add_overtime_form', baseurl + 'payrollsettings/add_overtime_rule');
    });

    // Deduction
    $(document).on('click', "#save_deduction", function (e) {
        e.preventDefault();
        saveObject('#add_deduction_form', baseurl + 'payrollsettings/add_deduction_type');
    });

    // Job Code
    $(document).on('click', "#save_jobcode", function (e) {
        e.preventDefault();
        saveObject('#add_jobcode_form', baseurl + 'payrollsettings/add_job_code');
    });
    
    // Config Save
    $(document).on('click', "#save_config_btn", function(e) {
        e.preventDefault();
        saveObject('#config_form', baseurl + 'payrollsettings/update_config');
    });

    // Generic Delete Handler
    $(document).on('click', ".delete-object", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-object-id');
        var url = $(this).attr('data-action-url');
        $('#object-id').val(id);
        $('#action-url').val(url); // Store in hidden field or usage variable
        $('#delete_model').modal('show');
    });

    $(document).on('click', "#delete-confirm", function(e) {
        var id = $('#object-id').val();
        var url = $('#action-url').val();
         $.post(baseurl + url, {deleteid: id, [crsf_token]: crsf_hash}, function(data){
             if(data.status == 'Success') {
                  location.reload();
             } else {
                 alert('Error deleting');
             }
         }, 'json');
    });
    
    // Save Accounts Configuration
    $('#save_accounts_config_btn').click(function() {
        var formData = $('#accounts_config_form').serialize();
        $.ajax({
            url: baseurl + 'payrollsettings/save_accounts_config',
            type: 'POST',
            data: formData + '&' + crsf_token + '=' + crsf_hash,
            success: function(res) {
                var data = JSON.parse(res);
                alert(data.message);
                if(data.status == 'Success') {
                    location.reload();
                }
            }
        });
    });

</script>
