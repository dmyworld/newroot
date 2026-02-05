<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Machine Status Board</h4>
            </div>
            <div class="card-body">
                <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #dc3545;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideMaint" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideMaint" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_maint">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_maint">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_maint">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_maint" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Machine Maintenance</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Status:</strong> Monitor machines (Green = Active, Red = Down).</li>
                                        <li><strong>Report:</strong> Use 'Report Issue' to log breakdowns immediately.</li>
                                        <li><strong>Resolve:</strong> Click 'Resolve / Online' when a machine is fixed.</li>
                                    </ol>
                                </div>
                                <div id="sin_maint" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">යන්ත්‍ර නඩත්තුව</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>තත්වය:</strong> යන්ත්‍ර නිරීක්ෂණය කරන්න (කොළ = සක්‍රීය, රතු = අක්‍රීය).</li>
                                        <li><strong>වාර්තා කිරීම:</strong> බිඳවැටීම් වාර්තා කිරීමට 'Report Issue' භාවිතා කරන්න.</li>
                                        <li><strong>විසඳීම:</strong> යන්ත්‍රය අලුත්වැඩියා කළ පසු 'Resolve / Online' ක්ලික් කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_maint" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">இயந்திர பராமரிப்பு</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>நிலை:</strong> இயந்திரங்களைக் கண்காணிக்கவும் (பச்சை = செயலில், சிவப்பு = கீழே).</li>
                                        <li><strong>புகாரளி:</strong> முறிவுகளைப் பதிவு செய்ய 'Report Issue' ஐப் பயன்படுத்தவும்.</li>
                                        <li><strong>தீர்க்க:</strong> இயந்திரம் சரிசெய்யப்பட்டதும் 'Resolve / Online' ஐ கிளிக் செய்யவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <div class="row">
                    <?php foreach($machines as $m) { 
                        $status_class = $m['is_down'] ? 'bg-danger text-white' : 'bg-success text-white';
                        $status_text = $m['is_down'] ? 'DOWN' : 'ACTIVE';
                        $icon = $m['is_down'] ? 'fa-warning' : 'fa-check-circle';
                    ?>
                    <div class="col-md-4 mb-2">
                        <div class="card <?php echo $status_class; ?>">
                            <div class="card-body text-center">
                                <h1><i class="fa <?php echo $icon; ?>"></i></h1>
                                <h5 class="text-white"><?php echo $m['name']; ?></h5>
                                <p class="text-white"><?php echo $status_text; ?></p>
                                
                                <?php if($m['is_down']) { ?>
                                    <p class="small text-white">Reason: <?php echo $m['down_reason']; ?></p>
                                    <button class="btn btn-light btn-sm btn-block resolve-btn" data-id="<?php echo $m['down_id']; ?>">Resolve / Online</button>
                                <?php } else { ?>
                                    <button class="btn btn-outline-light btn-sm btn-block report-btn" data-id="<?php echo $m['id']; ?>" data-name="<?php echo $m['name']; ?>">Report Issue</button>
                                    <button class="btn btn-outline-light btn-sm btn-block schedule-btn mt-1" data-id="<?php echo $m['id']; ?>" data-name="<?php echo $m['name']; ?>">Schedule Service</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Upcoming Maintenance</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach($maintenance as $task) { ?>
                    <li class="list-group-item">
                        <strong><?php echo $task['scheduled_date']; ?></strong>
                        <span class="badge badge-info float-right"><?php echo $task['machine_name']; ?></span>
                        <p class="mb-0 text-muted small"><?php echo $task['description']; ?></p>
                    </li>
                    <?php } ?>
                    <?php if(empty($maintenance)) { ?>
                        <li class="list-group-item text-muted">No scheduled maintenance.</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div id="reportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Report Machine Issue</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    <input type="hidden" name="machine_id" id="report_machine_id">
                    <div class="form-group">
                        <label>Reason / Error</label>
                        <select name="reason" class="form-control">
                            <option value="Mechanical Failure">Mechanical Failure</option>
                            <option value="Electrical Issue">Electrical Issue</option>
                            <option value="Jamming">Jamming</option>
                            <option value="Overheating">Overheating</option>
                            <option value="Routine Check">Routine Check</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="comments" class="form-control"></textarea>
                    </div>
                    <button type="button" id="submit_report" class="btn btn-danger btn-block">Confirm Down Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Schedule Maintenance</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                 <form id="scheduleForm">
                    <input type="hidden" name="machine_id" id="schedule_machine_id">
                    <div class="form-group">
                        <label>Scheduled Date</label>
                        <input type="date" name="date" class="form-control required">
                    </div>
                    <div class="form-group">
                        <label>Description (Task)</label>
                        <input type="text" name="description" class="form-control" placeholder="e.g. Oil Change, Belt Replacement">
                    </div>
                    <button type="button" id="submit_schedule" class="btn btn-primary btn-block">Schedule</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('.report-btn').click(function(){
        $('#report_machine_id').val($(this).data('id'));
        $('#reportModal').modal('show');
    });

    $('.schedule-btn').click(function(){
        $('#schedule_machine_id').val($(this).data('id'));
        $('#scheduleModal').modal('show');
    });

    $('#submit_report').click(function(){
        $.ajax({
            url: "<?php echo site_url('production_maintenance/log_issue')?>",
            type: 'POST',
            data: $('#reportForm').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(data){
                alert(data.message);
                location.reload();
            }
        });
    });

    $('.resolve-btn').click(function(){
        if(confirm('Confirm that this machine is fixed and back online?')) {
            $.ajax({
                url: "<?php echo site_url('production_maintenance/resolve_issue')?>",
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(data){
                    alert(data.message);
                    location.reload();
                }
            });
        }
    });

    $('#submit_schedule').click(function(){
         $.ajax({
            url: "<?php echo site_url('production_maintenance/schedule')?>",
            type: 'POST',
            data: $('#scheduleForm').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(data){
                alert(data.message);
                location.reload();
            }
        });
    });
</script>
