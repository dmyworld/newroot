<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters">
                <div class="col-md-12 text-center pt-4 pb-2">
                    <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('BalanceSheet') ?></h2>
                    <p class="text-white-50 mb-0">Financial Snapshot & Account Balances</p>
                </div>
            </div>
            
            <!-- Artistic Navigation Tabs -->
            <ul class="nav nav-tabs nav-justified border-0 mt-3" id="balanceTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active py-3" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-selected="true" style="border:none; border-bottom: 4px solid #FFC107; color: #fff; background: rgba(255,255,255,0.1);">
                        <i class="fa fa-pie-chart mr-1"></i> Summary
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-selected="false" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-university mr-1"></i> <?php echo $this->lang->line('Basic') ?>
                    </a>
                </li>
                <li class="nav-item">
                     <a class="nav-link py-3" id="assets-tab" data-toggle="tab" href="#assets" role="tab" aria-selected="false" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-briefcase mr-1"></i> <?php echo $this->lang->line('Assets') ?>
                    </a>
                </li>
                <li class="nav-item">
                     <a class="nav-link py-3" id="income-tab" data-toggle="tab" href="#income" role="tab" aria-selected="false" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-money mr-1"></i> <?php echo $this->lang->line('Income') ?>
                    </a>
                </li>
                <li class="nav-item">
                     <a class="nav-link py-3" id="expense-tab" data-toggle="tab" href="#expenses" role="tab" aria-selected="false" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-credit-card mr-1"></i> <?php echo $this->lang->line('Expenses') ?>
                    </a>
                </li>
                 <li class="nav-item">
                     <a class="nav-link py-3" id="liab-tab" data-toggle="tab" href="#liabilities" role="tab" aria-selected="false" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-balance-scale mr-1"></i> <?php echo $this->lang->line('Liabilities') ?>
                    </a>
                </li>
                 <li class="nav-item">
                     <a class="nav-link py-3" id="equity-tab" data-toggle="tab" href="#equity" role="tab" aria-selected="false" style="border:none; color: rgba(255,255,255,0.7);">
                        <i class="fa fa-line-chart mr-1"></i> <?php echo $this->lang->line('Equity') ?>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="balanceTabContent">
                
                <!-- SUMMARY TAB -->
                <div class="tab-pane fade show active" id="summary" role="tabpanel">
                    <div class="row">
                         <?php
                            $types = ['Basic', 'Assets', 'Income', 'Expenses', 'Liabilities', 'Equity'];
                            $totals = ['Basic'=>0, 'Assets'=>0, 'Income'=>0, 'Expenses'=>0, 'Liabilities'=>0, 'Equity'=>0];
                            
                            // Pre-calculate totals
                            foreach ($accounts as $row) {
                                if (in_array($row['account_type'], $types)) {
                                    $totals[$row['account_type']] += $row['lastbal'];
                                }
                            }
                            
                            $colors = [
                                'Basic' => 'info',
                                'Assets' => 'purple',
                                'Income' => 'success',
                                'Expenses' => 'danger',
                                'Liabilities' => 'warning',
                                'Equity' => 'primary'
                            ];
                            
                            foreach($types as $type) {
                         ?>
                        <div class="col-xl-4 col-md-6 col-12 mb-3">
                             <div class="card shadow-sm border-0" style="border-left: 5px solid #<?php echo ($type=='Expenses'?'ff4b4b': ($type=='Income' ? '13ec5b' : 'ccc')); ?> !important;">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                <i class="icon-bulb text-<?php echo $colors[$type]; ?> font-large-2 float-left"></i>
                                            </div>
                                            <div class="media-body text-right">
                                                <h3 class="text-<?php echo $colors[$type]; ?>"><?php echo amountExchange($totals[$type], 0, $this->aauth->get_user()->loc) ?></h3>
                                                <span><?php echo $this->lang->line($type) ?> Total</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- DYNAMIC ACCOUNT TABS -->
                <?php 
                    foreach($types as $type) {
                        $tabId = strtolower($type);
                ?>
                <div class="tab-pane fade" id="<?php echo $tabId; ?>" role="tabpanel">
                    <h4 class="mb-3 text-<?php echo $colors[$type]; ?> font-weight-bold text-uppercase"><?php echo $this->lang->line($type) ?> <?php echo $this->lang->line('Accounts') ?></h4>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0"><?php echo $this->lang->line('Name') ?></th>
                                    <th class="border-top-0"><?php echo $this->lang->line('Account') ?></th>
                                    <th class="border-top-0 text-right"><?php echo $this->lang->line('Balance') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $subtotal = 0;
                                foreach ($accounts as $row) {
                                    if ($row['account_type'] == $type) {
                                        $balance = $row['lastbal'];
                                        $subtotal += $balance;
                                        echo "<tr>
                                            <td class='text-muted'>$i</td>
                                            <td class='font-weight-bold'>" . $row['holder'] . "</td>
                                            <td>" . $row['acn'] . "</td>
                                            <td class='text-right font-medium-1 " . ($type == 'Expenses' ? 'text-danger' : 'text-success') . "'>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                                        </tr>";
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bold">TOTAL <?php echo strtoupper($this->lang->line($type)); ?></td>
                                    <td class="text-right font-weight-bold text-dark h5"><?php echo amountExchange($subtotal, 0, $this->aauth->get_user()->loc); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                     <?php if($i == 1) { echo '<div class="text-center p-5 text-muted">No accounts found in this category.</div>'; } ?>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<style>
/* Custom Tab Styling */
.nav-tabs .nav-link:hover {
    border: none;
    color: #fff !important;
    background: rgba(255,255,255,0.2);
}
.nav-tabs .nav-link.active {
    background: transparent;
    color: #FFC107 !important;
    border-bottom: 4px solid #FFC107 !important;
}
.table td, .table th {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}
</style>

<script>
    // Tab Activation Logic to style text color on switch
    $('.nav-link').on('shown.bs.tab', function (e) {
      $('.nav-link').removeClass('active');
      $(this).addClass('active');
    })
</script>