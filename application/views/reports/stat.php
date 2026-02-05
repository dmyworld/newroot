<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Company Statistics') ?> <a class="btn btn-purple"
                                                                                            href="<?php echo base_url() ?>reports/refresh_data"><i
                            class="fa fa-refresh"></i></a></h4>
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

                 <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #FF5722;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideStat" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideStat" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_stat">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_stat">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_stat">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_stat" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Company Statistics</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Trends:</strong> Visualize sales and product movement over the last 12 months.</li>
                                        <li><strong>Details:</strong> View a detailed table of income, expenses, and invoices by month.</li>
                                        <li><strong>Refresh:</strong> Use the refresh button to update data with the latest transactions.</li>
                                    </ol>
                                </div>
                                <div id="sin_stat" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">සමාගම් සංඛ්‍යාලේඛන</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>ප්‍රවණතා:</strong> පසුගිය මාස 12 තුළ විකුණුම් සහ භාණ්ඩ චලනය දෘශ්‍යමාන කරන්න.</li>
                                        <li><strong>විස්තර:</strong> මාසය අනුව ආදායම්, වියදම් සහ ඉන්වොයිසිවල සවිස්තරාත්මක වගුවක් බලන්න.</li>
                                        <li><strong>යාවත්කාලීන කිරීම:</strong> නවතම ගනුදෙනු සමඟ දත්ත යාවත්කාලීන කිරීමට refresh බොත්තම භාවිතා කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_stat" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">நிறுவனத்தின் புள்ளிவிவரங்கள்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>போக்குகள்:</strong> கடந்த 12 மாதங்களில் விற்பனை மற்றும் தயாரிப்பு நகர்வுகளைக் காட்சிப்படுத்துங்கள்.</li>
                                        <li><strong>விவரங்கள்:</strong> மாதம் வாரியாக வருமானம், செலவுகள் மற்றும் விலைப்பட்டியல்களின் விரிவான அட்டவணையைப் பார்க்கவும்.</li>
                                        <li><strong>புதுப்பித்தல்:</strong> சமீபத்திய பரிவர்த்தனைகளுடன் தரவைப் புதுப்பிக்க refresh பொத்தானைப் பயன்படுத்தவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->

                <!--/ stats -->
                <!--/ project charts -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header no-border">
                                <h6 class="card-title"><?php echo $this->lang->line('Sales in last 12 months') ?></h6>

                            </div>

                            <div class="card-body">


                                <div id="invoices-sales-chart"></div>

                            </div>

                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header no-border">
                                <h6 class="card-title"><?php echo $this->lang->line('Products in last 12 months') ?></h6>

                            </div>

                            <div class="card-body">


                                <div id="invoices-products-chart"></div>

                            </div>

                        </div>
                    </div>

                </div>
                <hr>
                <!--/ project charts -->
                <!-- Recent invoice with Statistics -->
                <div class="row match-height">

                    <div class="col-xl-12 col-lg-12 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo $this->lang->line('All Time Detailed Statistics') ?></h4>
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
                                            <th><?php echo $this->lang->line('Month') ?></th>
                                            <th><?php echo $this->lang->line('Income') ?></th>
                                            <th><?php echo $this->lang->line('Expenses') ?></th>
                                            <th><?php echo $this->lang->line('Sales') ?></th>
                                            <th><?php echo $this->lang->line('Invoices') ?></th>
                                            <th><?php echo $this->lang->line('sold') . $this->lang->line('products') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        foreach ($stat as $item) {
                                            // $month=date("F", $item['month']);


                                            $dateObj = DateTime::createFromFormat('!m', $item['month']);
                                            $month = $dateObj->format('F');
                                            echo '<tr>
                                <td class="text-truncate">' . $month . ', ' . $item['year'] . '</td>
                                <td class="text-truncate"> ' . $item['income'] . '</td>
                            
                                <td class="text-truncate">' . $item['expense'] . '</td>
                                 <td class="text-truncate">' . $item['sales'] . '</td>
                                  <td class="text-truncate">' . $item['invoices'] . '</td>
                                   <td class="text-truncate">' . $item['items'] . '</td>
                               
                            </tr>';
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent invoice with Statistics -->


            </div>
        </div>
    </div>
</div>
<script type="text/javascript">


    $('#invoices-sales-chart').empty();

    Morris.Bar({
        element: 'invoices-sales-chart',
        data: [
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if ($i > 11) exit;
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['income']) . ", z: " . intval($row['expense']) . "},";
            $i++;
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Income', 'expense'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#34cea7', '#ff6e40'],
    });


    $('#invoices-products-chart').empty();

    Morris.Line({
        element: 'invoices-products-chart',
        data: [
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if ($i > 11) exit;
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['items']) . ", z: " . intval($row['invoices']) . "},";
            $i++;
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Products', 'Invoices'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40'],
    });


</script>