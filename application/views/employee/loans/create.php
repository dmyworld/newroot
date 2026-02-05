<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Issue New Loan</h4>
        </div>
        <div class="card-body">
            <form id="issue_loan_form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Employee</label>
                            <select class="form-control" name="employee_id" required>
                                <option value="">Select Employee...</option>
                                <?php foreach($employees as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>Source Account (Company Funds)</label>
                            <select class="form-control" name="account_id" required>
                                <option value="">Select Account...</option>
                                <?php foreach($accounts as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['holder']; ?> (<?php echo $row['acn']; ?>)</option>
                                <?php } ?>
                            </select>
                            <small>Funds will be debited from this account.</small>
                        </div>
                    </div>
                </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Loan Amount</label>
                            <input type="number" class="form-control" name="amount" required placeholder="0.00">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                             <label>Monthly Installment (Deduction)</label>
                             <input type="number" class="form-control" name="installment" required placeholder="0.00">
                             <small>Amount deducted automatically per payroll run.</small>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Interest Rate (%)</label>
                            <input type="number" class="form-control" name="interest_rate" placeholder="0.00" value="0.00">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>Loan Type</label>
                            <select class="form-control" name="type">
                                <option value="Personal">Personal Loan</option>
                                <option value="Housing">Housing Loan</option>
                                <option value="Vehicle">Vehicle Loan</option>
                                <option value="Education">Education Loan</option>
                                <option value="Emergency">Emergency Advance</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Guarantor (Optional)</label>
                            <input type="text" class="form-control" name="guarantor" placeholder="Name or Employee ID">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Note / Reason</label>
                    <textarea class="form-control" name="note" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="button" id="submit_loan" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane"></i> Issue Loan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $('#submit_loan').click(function() {
        var btn = $(this);
        var form = $('#issue_loan_form');
        
        if(!form[0].checkValidity()) {
            form[0].reportValidity();
            return;
        }

        if(!confirm('This will create an Accounting Transaction (Expense) and issue funds. Proceed?')) return;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: baseurl + 'employeeloans/save',
            type: 'POST',
            data: form.serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function(data) {
                if(data.status == 'Success') {
                    alert(data.message);
                    window.location.href = baseurl + 'employeeloans';
                } else {
                    alert('Error: ' + data.message);
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Issue Loan');
                }
            },
            error: function() {
                alert('System Error');
                btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Issue Loan');
            }
        });
    });
</script>
