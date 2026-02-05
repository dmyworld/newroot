<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Employee Loans</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a href="<?php echo base_url('employeeloans/create'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Issue New Loan</a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="loans_table" class="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Amount</th>
                                <th>Balance</th>
                                <th>Installment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($loans as $row) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['emp_name']; ?></td>
                                <td><?php echo amountFormat($row['amount']); ?></td>
                                <td class="font-weight-bold text-danger"><?php echo amountFormat($row['balance']); ?></td>
                                <td><?php echo amountFormat($row['installment']); ?>/mo</td>
                                <td><span class="badge badge-<?php echo ($row['status']=='Paid'?'success':'warning'); ?>"><?php echo $row['status']; ?></span></td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="delete_loan(<?php echo $row['id']; ?>)"><i class="fa fa-trash"></i></button>
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
    $(document).ready(function() {
        $('#loans_table').DataTable();
    });

    function delete_loan(id) {
        if(confirm('Are you sure you want to delete this loan record? This will NOT reverse the accounting transaction.')) {
            $.post(baseurl + 'employeeloans/delete', {deleteid: id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(data){
                location.reload();
            }, 'json');
        }
    }
</script>
