<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Hire Purchase Contracts 
                <a href="<?php echo base_url('hp/create') ?>" class="btn btn-primary btn-sm rounded">Add New Contract</a>
            </h4>
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
                <table id="hptable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Installment</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Settings</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($contracts as $row) {
                        $status = '<span class="badge badge-warning">'.$row['status'].'</span>';
                        if($row['status'] == 'active') $status = '<span class="badge badge-success">Active</span>';
                        if($row['status'] == 'completed') $status = '<span class="badge badge-info">Completed</span>';
                        
                        echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['customer_name'] . "<br><small>" . $row['customer_phone'] . "</small></td>
                            <td>" . amountExchange($row['total_amount'], 0, $this->aauth->get_user()->loc) . "</td>
                            <td>" . amountExchange($row['installment_amount'], 0, $this->aauth->get_user()->loc) . " / " . $row['frequency'] . "</td>
                            <td>" . $row['start_date'] . "</td>
                            <td>" . $status . "</td>
                            <td><a href='" . base_url("hp/view?id=" . $row['id']) . "' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> View</a></td>
                        </tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#hptable').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ],
        });
    });
</script>
