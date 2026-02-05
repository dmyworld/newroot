<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Payroll Run Items: <?php echo dateformat($run['start_date']) . ' to ' . dateformat($run['end_date']); ?></h5>
            <a href="<?php echo base_url('payrollreport/export_run?id=' . $run['id']); ?>" class="btn btn-warning btn-sm float-right">Export CSV</a>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Gross Pay</th>
                            <th>Tax</th>
                            <th>Deductions</th>
                            <th>Net Pay</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $row) { ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo amountFormat($row['gross_pay']); ?></td>
                                <td><?php echo amountFormat($row['tax']); ?></td>
                                <td><?php echo amountFormat($row['total_deductions']); ?></td>
                                <td><?php echo amountFormat($row['net_pay']); ?></td>
                                <td>
                                    <a href="<?php echo base_url('payrollreport/view_payslip?id=' . $row['id']); ?>" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-print"></i> Payslip</a>
                                    <button class="btn btn-info btn-sm btn-email" data-id="<?php echo $row['id']; ?>"><i class="fa fa-envelope"></i> Email</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-email').on('click', function() {
            var btn = $(this);
            var id = btn.data('id');
            
            if(!confirm('Send Payslip via Email?')) return;
            
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
            
            $.ajax({
                url: "<?php echo base_url('payrollreport/send_payslip'); ?>",
                type: 'POST',
                data: {
                    id: id,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'Success') {
                        alert(data.message);
                        btn.html('<i class="fa fa-check"></i> Sent');
                    } else {
                        alert('Error: ' + data.message);
                        btn.prop('disabled', false).html('<i class="fa fa-envelope"></i> Email');
                    }
                },
                error: function() {
                    alert('System Error sending email.');
                    btn.prop('disabled', false).html('<i class="fa fa-envelope"></i> Email');
                }
            });
        });
    });
</script>
