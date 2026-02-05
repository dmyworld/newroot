<div class="content-body">
    <div class="card">
        <div class="card-header bg-gradient-x-warning-amber white">
            <h5 class="white">Pending Payroll Approvals</h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
             <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="alert alert-info">
                     <i class="fa fa-info-circle"></i> Approving a payroll run will trigger automatic <strong>Loan Repayment Deductions</strong> and update accounting transactions.
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Period</th>
                                <th>Total Amount</th>
                                <th>Total Tax</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_runs as $row) { ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td><span class="font-weight-bold"><?php echo dateformat($row['start_date']) . ' <i class="fa fa-arrow-right small"></i> ' . dateformat($row['end_date']); ?></span></td>
                                    <td><h5 class="success mb-0"><?php echo amountFormat($row['total_amount']); ?></h5></td>
                                    <td><?php echo amountFormat($row['total_tax']); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('payrollreport/payslips?id=' . $row['id']); ?>" class="btn btn-sm btn-outline-info" target="_blank" title="Review Payslips"><i class="fa fa-eye"></i></a>
                                            <button class="btn btn-sm btn-success" onclick="approveRun(<?php echo $row['id']; ?>)" title="Approve"><i class="fa fa-check"></i></button>
                                            <button class="btn btn-sm btn-danger" onclick="rejectRun(<?php echo $row['id']; ?>)" title="Reject"><i class="fa fa-times"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveRun(id) {
    if(confirm('Are you sure you want to approve this payroll run? This action is irreversible.')) {
        console.log('Approving run #' + id);
        
        $.post('<?php echo base_url("payrollworkflow/approve"); ?>', {
            run_id: id, 
            comments: 'Approved via Dashboard',
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }, function(data) {
            console.log('Response received:', data);
            try {
                var res = JSON.parse(data);
                alert(res.message);
                location.reload();
            } catch(e) {
                console.error('Parse error:', e);
                alert('Error: Invalid response format');
                console.log('Raw response:', data);
            }
        }).fail(function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error('Response:', xhr.responseText);
            alert('Request failed: ' + error);
        });
    }
}

function rejectRun(id) {
    var comments = prompt('Please enter reason for rejection:');
    if(comments) {
        $.post('<?php echo base_url("payrollworkflow/reject"); ?>', {
            run_id: id, 
            comments: comments,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }, function(data) {
             var res = JSON.parse(data);
             alert(res.message);
             location.reload();
        });
    }
}
</script>

