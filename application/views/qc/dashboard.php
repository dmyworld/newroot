<div class="card card-block">
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #28a745;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideQC" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideQC" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_qc">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_qc">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_qc">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_qc" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Quality Control (QC)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Pending:</strong> View list of completed tasks waiting for inspection.</li>
                                <li><strong>Inspect:</strong> Click 'Inspect' to grade the work (Pass/Fail/Rework).</li>
                                <li><strong>Validation:</strong> Only approved items move to the next stage or inventory.</li>
                            </ol>
                        </div>
                        <div id="sin_qc" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">තත්ත්ව පාලනය (QC)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>බලාපොරොත්තු වන:</strong> පරීක්ෂා කළ යුතු නිම කළ වැඩ ලැයිස්තුව බලන්න.</li>
                                <li><strong>පරීක්‍ෂා කිරීම:</strong> වැඩ පරීක්ෂා කිරීමට 'Inspect' ක්ලික් කරන්න (Pass/Fail).</li>
                                <li><strong>වලංගු කිරීම:</strong> අනුමත අයිතම පමණක් ඊළඟ පියවරට හෝ ගබඩාවට යයි.</li>
                            </ol>
                        </div>
                        <div id="tam_qc" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">தரக் கட்டுப்பாடு</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>நிலுவையில் உள்ளது:</strong> ஆய்விற்காக காத்திருக்கும் பணிகளைப் பார்க்கவும்.</li>
                                <li><strong>ஆய்வு:</strong> வேலையைத் தரம் பிரிக்க 'Inspect' ஐ கிளிக் செய்யவும்.</li>
                                <li><strong>சரிபார்ப்பு:</strong> அங்கீகரிக்கப்பட்ட பொருட்கள் மட்டுமே அடுத்த கட்டத்திற்குச் செல்லும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> Quality Control Dashboard <small class="text-muted">Pending Inspections</small></h5>
        <hr>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>WO ID</th>
                        <th>Batch</th>
                        <th>Stage</th>
                        <th>Worker</th>
                        <th>Date Completed</th>
                        <th>Qty Completed</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pending_list as $row) { ?>
                    <tr>
                        <td>WO-<?php echo $row['id']; ?></td>
                        <td><?php echo $row['batch_name']; ?></td>
                        <td><?php echo $row['stage_name']; ?></td>
                        <td><?php echo $row['employee_name']; ?></td>
                        <td><?php echo $row['end_time']; ?></td>
                        <td><span class="badge badge-success"><?php echo $row['qty_completed']; ?></span></td>
                        <td>
                            <a href="<?php echo site_url('quality_control/inspect?id='.$row['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-check-square-o"></i> Inspect</a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if(empty($pending_list)) { ?>
                        <tr><td colspan="7" class="text-center">No Completed Work Orders Pending Inspection.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
