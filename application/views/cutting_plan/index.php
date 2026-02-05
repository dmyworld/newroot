<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #fd7e14;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideCut" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideCut" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_cut">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_cut">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_cut">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_cut" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Cutting Optimization</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>New Plan:</strong> Click 'New Plan' to generate a cutting list from stock.</li>
                                <li><strong>Efficiency:</strong> Check 'Waste %' to see material usage efficiency.</li>
                                <li><strong>Print:</strong> Click 'Print' to give the cutting diagram to the sawyer.</li>
                            </ol>
                        </div>
                        <div id="sin_cut" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">කැපුම් ප්‍රශස්තකරණය (Calculations)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>නව සැලසුමක්:</strong> කැපුම් ලැයිස්තුවක් සෑදීමට 'New Plan' ක්ලික් කරන්න.</li>
                                <li><strong>කාර්යක්ෂමතාව:</strong> ද්‍රව්‍ය භාවිතය බැලීමට 'Waste %' පරීක්ෂා කරන්න.</li>
                                <li><strong>මුද්‍රණය:</strong> ලැයිස්තුව මුද්‍රණය කිරීමට 'Print' බොත්තම භාවිතා කරන්න.</li>
                            </ol>
                        </div>
                        <div id="tam_cut" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">வெட்டு உகப்பாக்கம்</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>புதிய திட்டம்:</strong> வெட்டுப் பட்டியலை உருவாக்க 'New Plan' ஐ கிளிக் செய்யவும்.</li>
                                <li><strong>செயல்திறன்:</strong> பொருள் பயன்பாட்டைக் காண 'Waste %' ஐச் சரிபார்க்கவும்.</li>
                                <li><strong>அச்சிடு:</strong> பட்டியலை அச்சிட 'Print' ஐப் பயன்படுத்தவும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> Cutting Plans History <a href="<?php echo base_url('cutting_plan/create') ?>" class="btn btn-primary btn-sm rounded">New Plan</a></h5>
        <hr>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Batch</th>
                    <th>Raw Dim (Inches)</th>
                    <th>Target Dim (Inches)</th>
                    <th>Planks</th>
                    <th>Waste %</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($plans as $plan) { ?>
                <tr>
                    <td><?php echo $plan['id']; ?></td>
                    <td><?php echo $plan['batch_name'] ? $plan['batch_name'] : '-'; ?></td>
                    <td><?php echo $plan['raw_timber_dim']; ?></td>
                    <td><?php echo $plan['plank_dim']; ?></td>
                    <td><?php echo $plan['planks_count']; ?></td>
                    <td><?php echo $plan['waste_percentage']; ?>%</td>
                    <td><?php echo $plan['created_at']; ?></td>
                    <td>
                        <a href="<?php echo site_url('cutting_plan/print_plan?id='.$plan['id']); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i> Print</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
