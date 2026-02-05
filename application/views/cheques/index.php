<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Cheque Registry <a href="#" class="btn btn-primary btn-sm rounded ml-2"> <i class="fa fa-plus-circle"></i> Add New Cheque</a></h4>
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
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Payee</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($cheques)): ?>
                                <tr><td colspan="7" class="text-center text-muted">No Cheques Found</td></tr>
                            <?php else: ?>
                                <?php foreach($cheques as $cheque): ?>
                                <tr>
                                    <td><?php echo dateformat($cheque['date']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo ($cheque['type']=='Incoming')?'success':'danger'; ?>">
                                            <?php echo $cheque['type']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $cheque['payee']; ?></td>
                                    <td><?php echo amountExchange($cheque['amount'], 0, $this->aauth->get_user()->loc); ?></td>
                                    <td>
                                        <span class="badge badge-<?php 
                                            switch($cheque['status']) {
                                                case 'Cleared': echo 'success'; break;
                                                case 'Bounced': echo 'danger'; break;
                                                case 'Issued': echo 'info'; break;
                                                default: echo 'warning';
                                            }
                                        ?>">
                                            <?php echo $cheque['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $cheque['note']; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('ChequeManager/edit?id=' . $cheque['id']); ?>" class="btn btn-sm btn-info" title="Edit / Approve"><i class="fa fa-pencil"></i> Edit</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
