<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="card-title">Trial Balance</h4>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="<?php echo base_url('reports/trial_balance') ?>" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Location (Branch)</label>
                            <select name="loc" class="form-control">
                                <option value="0">All Locations</option>
                                <?php foreach ($locations as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['cname'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mt-2">Filter Branch</button>
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-hover table-bordered">
                    <thead class="bg-primary white">
                    <tr>
                        <th>Account</th>
                        <th>Type</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Credit</th>
                        <th class="text-right">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $total_debit = 0;
                    $total_credit = 0;
                    foreach ($accounts as $row) {
                        $bal = $row['lastbal'];
                        $debit = $bal < 0 ? abs($bal) : 0;
                        $credit = $bal >= 0 ? $bal : 0;
                        $total_debit += $debit;
                        $total_credit += $credit;
                        
                        echo '<tr>
                            <td>' . $row['holder'] . '</td>
                            <td>' . $row['account_type'] . '</td>
                            <td class="text-right">' . amountExchange_s($debit, 0, $this->aauth->get_user()->loc) . '</td>
                            <td class="text-right">' . amountExchange_s($credit, 0, $this->aauth->get_user()->loc) . '</td>
                            <td class="text-right"><strong>' . amountExchange_s($bal, 0, $this->aauth->get_user()->loc) . '</strong></td>
                        </tr>';
                    } ?>
                    </tbody>
                    <tfoot>
                    <tr class="bg-light font-weight-bold">
                        <td colspan="2">TOTAL</td>
                        <td class="text-right"><?php echo amountExchange_s($total_debit, 0, $this->aauth->get_user()->loc) ?></td>
                        <td class="text-right"><?php echo amountExchange_s($total_credit, 0, $this->aauth->get_user()->loc) ?></td>
                        <td class="text-right"><?php echo amountExchange_s($total_credit - $total_debit, 0, $this->aauth->get_user()->loc) ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
