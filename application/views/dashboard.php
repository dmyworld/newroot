<script type="text/javascript">
    var dataVisits = [
        <?php $tt_inc = 0;foreach ($incomechart as $row) {
        $tt_inc += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . "},";
    }
        ?>
    ];
    var dataVisits2 = [
        <?php $tt_exp = 0; foreach ($expensechart as $row) {
        $tt_exp += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . "},";
    }
        ?>];

</script>

<div class="row">

     <!-- User Guide -->
    <div class="col-12">
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #28a745;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideDash" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideDash" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_dash">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_dash">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_dash">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_dash" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Dashboard Overview</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Stats:</strong> View daily income, expenses, and profit at a glance.</li>
                                <li><strong>Charts:</strong> Analyze sales and product performance trends over the last 30 days.</li>
                                <li><strong>Tasks:</strong> Keep track of your pending tasks and deadlines.</li>
                            </ol>
                        </div>
                        <div id="sin_dash" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">උ시කරණ පුවරුව (Dashboard)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>සංඛ්‍යාලේඛන:</strong> දෛනික ආදායම, වියදම් සහ ලාභය එක බැල්මකින් බලන්න.</li>
                                <li><strong>ප්‍රස්ථාර:</strong> පසුගිය දින 30 තුළ විකුණුම් සහ නිෂ්පාදන කාර්ය සාධන ප්‍රවණතා විශ්ලේෂණය කරන්න.</li>
                                <li><strong>කාර්යයන්:</strong> ඔබගේ විභාග වෙමින් පවතින කාර්යයන් සහ නියමිත දින නිරීක්ෂණය කරන්න.</li>
                            </ol>
                        </div>
                        <div id="tam_dash" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">டாஷ்போர்டு கண்ணோட்டம்</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>புள்ளிவிவரங்கள்:</strong> தினசரி வருமானம், செலவுகள் மற்றும் லாபத்தை ஒரே பார்வையில் பார்க்கலாம்.</li>
                                <li><strong>வரைபடங்கள்:</strong> கடந்த 30 நாட்களில் விற்பனை மற்றும் தயாரிப்பு செயல்திறன் போக்குகளைப் பகுப்பாய்வு செய்யுங்கள்.</li>
                                <li><strong>பணிகள்:</strong> உங்கள் நிலுவையில் உள்ள பணிகள் மற்றும் காலக்கெடுவைக் கண்காணிக்கவும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Guide -->

    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-primary bg-darken-2">
                        <i class="fa fa-file-text-o text-bold-200  font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-primary white media-body">
                        <h5><?php echo $this->lang->line('today') . $this->lang->line('invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> <?= $todayin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-secondary bg-darken-2">
                        <i class="icon-notebook font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-secondary white media-body">
                        <h5><?= $this->lang->line('this') . $this->lang->line('month') . $this->lang->line('invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?= $monthin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-accent bg-darken-2">
                        <i class="icon-basket-loaded font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-accent white media-body">
                        <h5><?= $this->lang->line('today') . $this->lang->line('sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i><?= amountExchange($todaysales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-timber-dark bg-darken-2">
                        <i class="icon-wallet font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-timber-dark white media-body">
                        <h5><?php echo $this->lang->line('this') . $this->lang->line('month') . $this->lang->line('sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i> <?= amountExchange($monthsales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('in_last _30') ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="products-sales" class="height-300"></div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-primary"><?= amountExchange($todayinexp['credit'], 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today') . $this->lang->line('income') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-primary" role="progressbar" style="width: 100%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-secondary"><?= amountExchange($todayinexp['debit'], 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today') . $this->lang->line('expenses') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-secondary" role="progressbar" style="width: 40%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-accent"><?= amountExchange($todayprofit, 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today') . $this->lang->line('Profit') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-accent" role="progressbar" style="width: 60%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="text-timber-accent"><?= amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('revenue') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-timber-accent" role="progressbar" style="width: 35%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Buyers</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content px-1">
                <div id="recent-buyers" class="media-list height-450  mt-1 position-relative">
                    <?php
                    if (isset($recent_buy[0]['csd'])) {

                        foreach ($recent_buy as $item) {

                            echo '       <a href="' . base_url('customers/view?id=' . $item['csd']) . '" class="media border-0">
                        <div class="media-left pr-1">
                            <span class="avatar avatar-md avatar-online"><img class="media-object rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $item['picture'] . '">
                            <i></i>
                            </span>
                        </div>
                        <div class="media-body w-100">
                            <h6 class="list-group-item-heading">' . $item['name'] . ' <span class="font-medium-4 float-right pt-1">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</span></h6>
                            <p class="list-group-item-text mb-0"><span class="badge  st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></p>
                        </div>
                    </a>';

                        }
                    } elseif ($recent_buy == 'sql') {
                        echo ' <div class="media-body w-100">  <h5 class="list-group-item-heading bg-danger white">Critical SQL Strict Mode Error: </h5>Please Disable Strict SQL Mode for in database  settings.</div>';
                    }

                    ?>


                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent_invoices') ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <p><span class="float-right"> <a
                                    href="<?php echo base_url() ?>invoices/create"
                                    class="btn btn-timber-primary btn-sm rounded"><?php echo $this->lang->line('Add Sale') ?></a>
                                <a
                                        href="<?php echo base_url() ?>invoices"
                                        class="btn btn-timber-secondary btn-sm rounded"><?php echo $this->lang->line('Manage Invoices') ?></a>
                                <a
                                        href="<?php echo base_url() ?>pos_invoices"
                                        class="btn btn-timber-accent btn-sm rounded"><?php echo $this->lang->line('POS') ?></a></span>
                    </p>
                </div>
            </div>
            <div class="card-content">

                <div class="">
                    <table id="recent-orders" class="table table-hover mb-1">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Invoices') ?>#</th>
                            <th><?php echo $this->lang->line('Customer') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                            <th><?php echo $this->lang->line('Due') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($recent as $item) {
                            $page = 'subscriptions';
                            $t = 'Sub ';
                            if ($item['i_class'] == 0) {
                                $page = 'invoices';
                                $t = '';
                            } elseif ($item['i_class'] == 1) {
                                $page = 'pos_invoices';
                                $t = 'POS ';
                            }
                            echo '    <tr>
                                <td class="text-truncate"><a href="' . base_url() . $page . '/view?id=' . $item['id'] . '">' . $t . '#' . $item['tid'] . '</a></td>
                             
                                <td class="text-truncate"> ' . $item['name'] . '</td>
                                <td class="text-truncate"><span class="badge  st-' . $item['status'] . ' st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></td><td class="text-truncate">' . dateformat($item['invoicedate']) . '</td>
                                <td class="text-truncate">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</td>
                            </tr>';
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   

   <div class="col-xl-4 col-lg-12">
        <div class="card">
             <div class="card-header">
                <h4 class="card-title">Quick Actions</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <a href="<?php echo base_url('invoices/create') ?>" class="btn btn-timber-primary btn-block mb-1"><i class="ft-file-plus"></i> New Invoice</a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url('quote/create') ?>" class="btn btn-timber-secondary btn-block mb-1"><i class="ft-file-text"></i> New Quote</a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url('products/add') ?>" class="btn btn-timber-accent btn-block mb-1"><i class="ft-box"></i> Add Product</a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url('customers/create') ?>" class="btn btn-timber-dark btn-block mb-1"><i class="ft-user-plus"></i> Add Client</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- STAFF PERFORMANCE SCOREBOARD (Game Changer Feature) -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-timber-primary">
                <h4 class="card-title text-white"><i class="ft-users"></i> STAFF PERFORMANCE SCOREBOARD</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Staff</th>
                                <th>Sales</th>
                                <th>Errors</th>
                                <th>Returns</th>
                                <th class="text-center">Trust Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Load Intelligence Model if not loaded
                            if(!isset($this->intelligence_model)) {
                                $this->load->model('intelligence_model');
                            }
                            $staff_list = $this->intelligence_model->get_top_staff_trust(10);  
                            
                            if(!empty($staff_list)): 
                                foreach($staff_list as $staff): 
                                    $trust_color = ($staff['trust_score'] > 80) ? 'success' : (($staff['trust_score'] > 50) ? 'warning' : 'danger');
                                    $trust_icon = ($staff['trust_score'] > 80) ? '🟢' : (($staff['trust_score'] > 50) ? '🟡' : '🔴');
                            ?>
                            <tr>
                                <td class="font-weight-bold"><?= esc($staff['username']) ?></td>
                                <td>
                                    <span class="text-timber-primary font-weight-bold">
                                        <?= amountExchange($staff['sales'], 0, $this->aauth->get_user()->loc) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= ($staff['errors'] > 3) ? 'text-danger' : 'text-muted' ?>">
                                        <?= $staff['errors'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= ($staff['returns'] > 2) ? 'text-warning' : 'text-muted' ?>">
                                        <?= $staff['returns'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-<?= $trust_color ?> badge-pill font-medium-1">
                                        <?= $trust_icon ?> <?= $staff['trust_score'] ?>%
                                    </span>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted p-3">
                                    <i class="ft-info"></i> No staff activity recorded today. Run daily trust calculation.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">
                        👉 Owner emotionally attached to dashboard • High performer visibility drives competition
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-12">
        <div class="card-group">
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-primary"><?php $ipt = sprintf("%0.0f", ($tt_inc * 100) / $goals['income']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class=" font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('income') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($tt_inc, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['income'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-money primary font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-primary" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-secondary"><?php $ipt = sprintf("%0.0f", ($tt_exp * 100) / $goals['expense']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('expenses') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($tt_exp, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['expense'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-external-link red font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-secondary" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-accent"><?php $ipt = sprintf("%0.0f", ($monthsales * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('sales') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($monthsales, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['sales'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-flag blue font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-accent" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="text-timber-dark"><?php $ipt = sprintf("%0.0f", (($tt_inc - $tt_exp) * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . date('F') . ' ' . $this->lang->line('net_income') . '</span>'; ?>
                                <span class="font-medium-1"><?= amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['netincome'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-inbox purple font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-timber-dark" role="progressbar" style="width: <?= $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card" id="transactions">

            <div class="card-body">
                <h4><?php echo $this->lang->line('cashflow') ?></h4>
                <p><?php echo $this->lang->line('graphical_presentation') ?></p>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                           href="#sales"
                           aria-expanded="true"><?php echo $this->lang->line('income') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                           href="#transactions1"
                           aria-expanded="false"><?php echo $this->lang->line('expenses') ?></a>
                    </li>


                </ul>
                <div class="tab-content pt-1">
                    <div role="tabpanel" class="tab-pane active" id="sales" aria-expanded="true"
                         data-toggle="tab">
                        <div id="dashboard-income-chart"></div>

                    </div>
                    <div class="tab-pane" id="transactions1" data-toggle="tab" aria-expanded="false">
                        <div id="dashboard-expense-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 



    <div class="col-xl-4 col-lg-12">
        <div class="card">
             <div class="card-header">
                <h4 class="card-title">My Pending Tasks</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php if (isset($tasks) && is_array($tasks)): ?>
                        <?php foreach ($tasks as $task): ?>
                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="ft-check-square text-timber-primary"></i> 
                                    <?= $task['name'] ?>
                                </span>
                                <span class="badge bg-timber-secondary badge-pill"><?= date('M d', strtotime($task['duedate'])) ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-muted">No pending tasks.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>





</div>
<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent') ?> <a
                            href="<?php echo base_url() ?>transactions"
                            class="btn btn-timber-primary btn-sm rounded"><?php echo $this->lang->line('Transactions') ?></a>
                </h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover mb-1">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?>#</th>
                            <th><?php echo $this->lang->line('Account') ?></th>
                            <th><?php echo $this->lang->line('Debit') ?></th>
                            <th><?php echo $this->lang->line('Credit') ?></th>

                            <th><?php echo $this->lang->line('Method') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($recent_payments as $item) {

                            echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'transactions/view?id=' . $item['id'] . '">' . dateformat($item['date']) . '</a></td>
                                <td class="text-truncate"> ' . $item['account'] . '</td>
                                <td class="text-truncate">' . amountExchange($item['debit'], 0, $this->aauth->get_user()->loc) . '</td>
                                <td class="text-truncate">' . amountExchange($item['credit'], 0, $this->aauth->get_user()->loc) . '</td>                    
                                <td class="text-truncate">' . $this->lang->line($item['method']) . '</td>
                            </tr>';

                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
      <div class="col-xl-4 col-lg-12">
        <div class="card">
             <div class="card-header">
                <h4 class="card-title">Advanced Timber Calculator</h4>
                <ul class="nav nav-pills mt-2 nav-justified" id="timberCalcTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-log-ft" data-toggle="pill" href="#mode-log-ft" role="tab" aria-selected="true" onclick="setCalcMode('log-ft')">Log (ft³)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-plank-ft" data-toggle="pill" href="#mode-plank-ft" role="tab" aria-selected="false" onclick="setCalcMode('plank-ft')">Plank (ft³)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-log-m" data-toggle="pill" href="#mode-log-m" role="tab" aria-selected="false" onclick="setCalcMode('log-m')">Log (m³)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-plank-m" data-toggle="pill" href="#mode-plank-m" role="tab" aria-selected="false" onclick="setCalcMode('plank-m')">Plank (m³)</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form id="timber-calc-form">
                    <div class="tab-content">
                        <!-- Mode 1: Log Cubic Feet -->
                        <div class="tab-pane fade show active" id="mode-log-ft" role="tabpanel">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-ft-d" placeholder="Mid Diameter (in)">
                                    <small class="form-text text-muted">Mid-Diameter (in)</small>
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-ft-l" placeholder="Length (ft)">
                                    <small class="form-text text-muted">Length (ft)</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mode 2: Plank Cubic Feet -->
                        <div class="tab-pane fade" id="mode-plank-ft" role="tabpanel">
                             <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-ft-t" placeholder="T (in)">
                                    <small class="form-text text-muted">Thick (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-ft-w" placeholder="W (in)">
                                    <small class="form-text text-muted">Width (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-ft-l" placeholder="L (ft)">
                                    <small class="form-text text-muted">Length (ft)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Mode 3: Log Cubic Meter -->
                        <div class="tab-pane fade" id="mode-log-m" role="tabpanel">
                             <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-m-d" placeholder="Mid Diameter (cm)">
                                    <small class="form-text text-muted">Mid-Diameter (cm)</small>
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" id="log-m-l" placeholder="Length (m)">
                                    <small class="form-text text-muted">Length (m)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Mode 4: Plank Cubic Meter -->
                        <div class="tab-pane fade" id="mode-plank-m" role="tabpanel">
                             <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-m-t" placeholder="T (in)">
                                    <small class="form-text text-muted">Thick (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-m-w" placeholder="W (in)">
                                    <small class="form-text text-muted">Width (in)</small>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control form-control-sm" id="plank-m-l" placeholder="L (m)">
                                    <small class="form-text text-muted">Length (m)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-timber-primary btn-block" onclick="calculateTimber()">Calculate Volume</button>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12 text-center">
                            <h4 id="calc-result" class="text-timber-primary font-weight-bold mt-1">-</h4>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var currentMode = 'log-ft';

        function setCalcMode(mode) {
            currentMode = mode;
            document.getElementById('calc-result').innerText = "-";
        }

        function calculateTimber() {
            var result = 0;
            var unit = "";

            if (currentMode === 'log-ft') {
                // Log Cubic Feet: V = (π * (D/24)^2) * L
                var d = parseFloat(document.getElementById('log-ft-d').value) || 0;
                var l = parseFloat(document.getElementById('log-ft-l').value) || 0;
                if(d > 0 && l > 0) {
                     // D is in inches, L is in feet. Radius in feet = (d/12)/2 = d/24
                    var r_ft = d / 24.0;
                    result = Math.PI * Math.pow(r_ft, 2) * l;
                    unit = "ft³ (Logs)";
                }
            } else if (currentMode === 'plank-ft') {
                // Plank Cubic Feet: (T_in * W_in * L_ft) / 144
                var t = parseFloat(document.getElementById('plank-ft-t').value) || 0;
                var w = parseFloat(document.getElementById('plank-ft-w').value) || 0;
                var l = parseFloat(document.getElementById('plank-ft-l').value) || 0;
                if(t > 0 && w > 0 && l > 0) {
                    result = (t * w * l) / 144.0;
                    unit = "ft³ (Planks)";
                }
            } else if (currentMode === 'log-m') {
                // Log Cubic Meters: V = (π * (D_cm/200)^2) * L_m
                var d = parseFloat(document.getElementById('log-m-d').value) || 0; // cm
                var l = parseFloat(document.getElementById('log-m-l').value) || 0; // m
                if(d > 0 && l > 0) {
                    // Radius in meters = (d/100)/2 = d/200
                    var r_m = d / 200.0;
                    result = Math.PI * Math.pow(r_m, 2) * l;
                    unit = "m³ (Logs)";
                }
            } else if (currentMode === 'plank-m') {
                // Plank Cubic Meters: (T_in * W_in * L_m) converted
                var t = parseFloat(document.getElementById('plank-m-t').value) || 0; // in
                var w = parseFloat(document.getElementById('plank-m-w').value) || 0; // in
                var l = parseFloat(document.getElementById('plank-m-l').value) || 0; // m
                if(t > 0 && w > 0 && l > 0) {
                    // Convert inches to meters: * 0.0254
                    var t_m = t * 0.0254;
                    var w_m = w * 0.0254;
                    result = t_m * w_m * l;
                    unit = "m³ (Planks)";
                }
            }

            if (result > 0) {
                document.getElementById('calc-result').innerText = result.toFixed(3) + " " + unit;
            } else {
                 document.getElementById('calc-result').innerText = "Invalid Input";
            }
        }
    </script>
  

















</div>
<script type="text/javascript">
    $(window).on("load", function () {
        $('#recent-buyers').perfectScrollbar({
            wheelPropagation: true
        });
        /********************************************
         *               PRODUCTS SALES              *
         ********************************************/
        var sales_data = [
            <?php foreach ($countmonthlychart as $row) {
            echo "{ y: '" . $row['date'] . "', sales: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . ", invoices: " . intval($row['ttlid']) . "},";
        } ?>
        ];
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        Morris.Area({
            element: 'products-sales',
            data: sales_data,
            xkey: 'y',
            ykeys: ['sales', 'invoices'],
            labels: ['sales', 'invoices'],
            behaveLikeLine: true,
            xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                var day = x.getDate();
                var month = months[x.getMonth()];
                return day + ' ' + month;
            },
            resize: true,
            pointSize: 0,
            pointStrokeColors: ['#2E7D32', '#795548', '#FFC107'],
            smooth: true,
            gridLineColor: '#E4E7ED',
            numLines: 6,
            gridtextSize: 14,
            lineWidth: 0,
            fillOpacity: 0.9,
            hideHover: 'auto',
            lineColors: ['#2E7D32', '#795548']
        });


    });
</script>
<script type="text/javascript">
    function drawIncomeChart(dataVisits) {
        $('#dashboard-income-chart').empty();
        Morris.Area({
            element: 'dashboard-income-chart',
            data: dataVisits,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 40',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#2E7D32',
            ],
            pointFillColors: [
                '#2E7D32',
            ],
            fillOpacity: 0.4,
        });
    }

    function drawExpenseChart(dataVisits2) {

        $('#dashboard-expense-chart').empty();
        Morris.Area({
            element: 'dashboard-expense-chart',
            data: dataVisits2,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 0',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#795548',
            ],
            pointFillColors: [
                '#8D6E63',
            ]
        });
    }

    drawIncomeChart(dataVisits);
    drawExpenseChart(dataVisits2);
    $('#dashboard-sales-breakdown-chart').empty();
    Morris.Donut({
        element: 'dashboard-sales-breakdown-chart',
        data: [{
            label: "<?php echo $this->lang->line('Income') ?>",
            value: <?= intval(amountExchange_s($tt_inc, 0, $this->aauth->get_user()->loc)); ?> },
            {
                label: "<?php echo $this->lang->line('Expenses') ?>",
                value: <?= intval(amountExchange_s($tt_exp, 0, $this->aauth->get_user()->loc)); ?> }
        ],
        resize: true,
        colors: ['#2E7D32', '#795548'],
        gridTextSize: 6,
        gridTextWeight: 400
    });
    $('a[data-toggle=tab').on('shown.bs.tab', function (e) {
        window.dispatchEvent(new Event('resize'));
    });
</script>