<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: white; border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters align-items-center">
                <div class="col-md-8 pl-4 py-4">
                    <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('Transaction Details') ?></h2>
                    <p class="text-white-50 mb-0">Record ID: #<?php echo prefix(5) . $trans['id'] ?> | Date: <?php echo dateformat($trans['date']) ?></p>
                </div>
                <div class="col-md-4 text-right pr-4 py-4">
                     <a href="<?php echo base_url() . 'transactions/print_t?id=' . $trans['id'] ?>" class="btn btn-outline-warning btn-sm rounded shadow-sm">
                        <i class="fa fa-print"></i> Print Receipt
                     </a>
                </div>
            </div>
        </div>

        <div class="card-body p-5">
            <div class="row mb-5">
                <div class="col-md-6 border-right">
                    <h6 class="text-muted text-uppercase font-weight-bold mb-3">Organization Details</h6>
                    <div class="media">
                        <div class="media-body">
                            <?php $loc = location($trans['loc']); ?>
                            <h4 class="font-weight-bold text-dark mb-1"><?php echo $loc['cname'] ?></h4>
                            <p class="text-muted mb-0">
                                <?php echo $loc['address'] ?><br>
                                <?php echo $loc['city'] . ', ' . $loc['region'] ?><br>
                                <?php echo $loc['country'] . ' -  ' . $loc['postbox'] ?>
                            </p>
                            <div class="mt-2 text-small">
                                <i class="fa fa-phone text-primary"></i> <?php echo $loc['phone'] ?> <br>
                                <i class="fa fa-envelope text-primary"></i> <?php echo $loc['email'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 text-right pl-4">
                     <h6 class="text-muted text-uppercase font-weight-bold mb-3"><?php echo $this->lang->line('Payer') ?> Details</h6>
                      <h4 class="font-weight-bold text-dark mb-1"><?php echo $trans['payer'] ?></h4>
                        <p class="text-muted mb-0">
                            <?php echo $cdata['address'] ?><br>
                            <?php echo $cdata['city'] ?>
                        </p>
                         <div class="mt-2 text-small">
                            <?php echo $this->lang->line('Phone') . ': ' . $cdata['phone'] ?><br>
                            <?php echo $this->lang->line('Email') . ': ' . $cdata['email'] ?>
                        </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                     <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase"><?php echo $this->lang->line('Type') ?></th>
                                    <th class="text-uppercase"><?php echo $this->lang->line('Category') ?></th>
                                    <th class="text-uppercase text-right"><?php echo $this->lang->line('Debit') ?></th>
                                    <th class="text-uppercase text-right"><?php echo $this->lang->line('Credit') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-<?php echo ($trans['type'] == 'Income' ? 'success' : ($trans['type'] == 'Expense' ? 'danger' : 'primary')); ?>"><?php echo $trans['type'] ?></span></td>
                                    <td><?php echo $trans['cat'] ?></td>
                                    <td class="text-right"><?php echo amountExchange($trans['debit'], 0, $this->aauth->get_user()->loc) ?></td>
                                    <td class="text-right font-weight-bold"><?php echo amountExchange($trans['credit'], 0, $this->aauth->get_user()->loc) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                 <div class="col-12">
                    <div class="alert alert-light border border-light shadow-sm p-4">
                        <h6 class="font-weight-bold text-dark"><i class="fa fa-sticky-note-o mr-2"></i><?php echo $this->lang->line('Note') ?></h6>
                        <p class="mb-0 text-muted"><?php echo $trans['note'] ?></p>
                    </div>
                 </div>
            </div>

        </div>
    </div>
</div>