<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #17a2b8;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideSeas" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideSeas" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_seas">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_seas">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_seas">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_seas" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Timber Seasoning</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Start:</strong> Click 'Start New Batch' to register timber for drying.</li>
                                <li><strong>Monitor:</strong> Valid 'Current MC' (Moisture Content) vs 'Target MC'.</li>
                                <li><strong>Action:</strong> Use 'View/Log' to update MC readings and track progress.</li>
                            </ol>
                        </div>
                        <div id="sin_seas" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">දැව පදම් කිරීම (Seasoning)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>ආරම්භය:</strong> වේලීම සඳහා දැව ලියාපදිංචි කිරීමට 'Start New Batch' ක්ලික් කරන්න.</li>
                                <li><strong>පරීක්ෂාව:</strong> වත්මන් තෙතමනය (Current MC) සහ ඉලක්කගත තෙතමනය (Target MC) බලන්න.</li>
                                <li><strong>යාවත්කාලීන කිරීම:</strong> තෙතමනය අගයන් ඇතුලත් කිරීමට 'View/Log' භාවිතා කරන්න.</li>
                            </ol>
                        </div>
                        <div id="tam_seas" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">மர பதப்படுத்துதல்</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>தொடக்கம்:</strong> மரத்தைப் பதிவு செய்ய 'Start New Batch' ஐ கிளிக் செய்யவும்.</li>
                                <li><strong>கண்காணிப்பு:</strong> தற்போதைய ஈரப்பதம் (Current MC) மற்றும் இலக்கு ஈரப்பதத்தை (Target MC) சரிபார்க்கவும்.</li>
                                <li><strong>புதுப்பிப்பு:</strong> ஈரப்பத மதிப்புகளைப் பதிவு செய்ய 'View/Log' ஐப் பயன்படுத்தவும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> Seasoning Batches <a href="<?php echo base_url('seasoning/create') ?>" class="btn btn-primary btn-sm rounded">Start New Batch</a></h5>
        <hr>
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>Batch Name</th>
                    <th>Method</th>
                    <th>Location</th>
                    <th>Start Date</th>
                    <th>Initial MC</th>
                    <th>Current MC</th>
                    <th>Target MC</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($batches as $batch) { 
                    // Calculate basic progress
                    $total_drop = $batch['initial_mc'] - $batch['target_mc'];
                    $current_drop = $batch['initial_mc'] - $batch['current_mc'];
                    $percent = ($total_drop > 0) ? ($current_drop / $total_drop) * 100 : 0;
                    if($percent > 100) $percent = 100;
                    if($percent < 0) $percent = 0;
                ?>
                <tr>
                    <td><strong><?php echo $batch['batch_name']; ?></strong></td>
                    <td><?php echo $batch['method']; ?></td>
                    <td><?php echo $batch['location']; ?></td>
                    <td><?php echo $batch['start_date']; ?></td>
                    <td><?php echo $batch['initial_mc']; ?>%</td>
                    <td><span class="badge badge-info"><?php echo $batch['current_mc']; ?>%</span></td>
                    <td><?php echo $batch['target_mc']; ?>%</td>
                    <td><?php echo $batch['status']; ?></td>
                    <td>
                        <a href="<?php echo site_url('seasoning/view?id='.$batch['id']); ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View/Log</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="padding: 0; border-top: none;">
                        <div class="progress" style="height: 5px; margin-bottom: 0;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
