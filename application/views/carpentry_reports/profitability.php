<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Project Profitability Report</h5>
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
            <div class="card-body">
                <table id="profit_table" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Customer</th>
                        <th>Budget</th>
                        <th>Invoiced Revenue</th>
                        <th>Material Cost</th>
                        <th>Labor Cost</th>
                        <th>Total Cost</th>
                        <th>Profit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($report as $row) { ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['customer']; ?></td>
                             <td><?php echo amountExchange($row['budget'], 0, $this->aauth->get_user()->loc) ?></td>
                            <td><?php echo amountExchange($row['revenue'], 0, $this->aauth->get_user()->loc) ?></td>
                             <td><?php echo amountExchange($row['material_cost'], 0, $this->aauth->get_user()->loc) ?></td>
                            <td><?php echo amountExchange($row['labor_cost'], 0, $this->aauth->get_user()->loc) ?></td>
                            <td><?php echo amountExchange($row['total_cost'], 0, $this->aauth->get_user()->loc) ?></td>
                            <td class="<?php echo ($row['profit'] >= 0) ? 'text-success' : 'text-danger'; ?>">
                                <strong><?php echo amountExchange($row['profit'], 0, $this->aauth->get_user()->loc) ?></strong>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                             <th></th>
                            <th></th>
                            <th></th>
                             <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#profit_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
