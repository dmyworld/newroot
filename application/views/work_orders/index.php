<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card-body">
         <!-- User Guide -->
        <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #007bff;">
            <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideWO" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
            </div>
            <div id="guideWO" class="collapse">
                <div class="card-body p-2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_wo">🇬🇧 English</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_wo">🇱🇰 Sinhala</a></li>
                        <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_wo">IN Tamil</a></li>
                    </ul>
                    <div class="tab-content border p-2 bg-white">
                        <div id="eng_wo" class="tab-pane active">
                            <h6 class="text-primary mt-1 small">Work Order Management</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>Generate:</strong> Use 'Generate from Batch' to create tasks from a production batch.</li>
                                <li><strong>Assign:</strong> Click 'Assign' to allocate a task to a specific employee.</li>
                                <li><strong>Status:</strong> Track progress (Pending -> In Progress -> Completed).</li>
                            </ol>
                        </div>
                        <div id="sin_wo" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">වැඩ ඇණවුම් (Work Orders)</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>උත්පාදනය:</strong> නිෂ්පාදන කාණ්ඩයකින් කාර්යයන් සෑදීමට 'Generate from Batch' භාවිතා කරන්න.</li>
                                <li><strong>පවරා දීම:</strong> සේවකයෙකුට වැඩ පැවරීමට 'Assign' බොත්තම ක්ලික් කරන්න.</li>
                                <li><strong>තත්වය:</strong> ප්‍රගතිය නිරීක්ෂණය කරන්න (Pending -> In Progress -> Completed).</li>
                            </ol>
                        </div>
                        <div id="tam_wo" class="tab-pane fade">
                            <h6 class="text-primary mt-1 small">பணி ஆணை மேலாண்மை</h6>
                            <ol class="small pl-3 mb-0">
                                <li><strong>உருவாக்கு:</strong> தொகுதியிலிருந்து பணிகளை உருவாக்க 'Generate from Batch' ஐப் பயன்படுத்தவும்.</li>
                                <li><strong>ஒதுக்க:</strong> பணியாளருக்கு வேலையை ஒதுக்க 'Assign' ஐ கிளிக் செய்யவும்.</li>
                                <li><strong>நிலை:</strong> முன்னேற்றத்தைக் கண்காணிக்கவும்.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Guide -->
        <h5 class="title"> Work Orders (Production Tasks) 
            <button class="btn btn-primary btn-sm rounded" data-toggle="modal" data-target="#generateModal">
                Generate from Batch
            </button>
        </h5>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>WO ID</th>
                        <th>Batch</th>
                        <th>Stage / Task</th>
                        <th>Machine</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $wo) { ?>
                    <tr>
                        <td>WO-<?php echo $wo['id']; ?></td>
                        <td><?php echo $wo['batch_name']; ?></td>
                        <td><?php echo $wo['stage_name']; ?></td>
                        <td><?php echo $wo['machine_name']; ?></td>
                        <td>
                            <?php if($wo['employee_name']) { 
                                echo '<span class="badge badge-info">'.$wo['employee_name'].'</span>';
                            } else { ?>
                                <button class="btn btn-warning btn-sm assign-btn" data-id="<?php echo $wo['id']; ?>" data-toggle="modal" data-target="#assignModal">Assign</button>
                            <?php } ?>
                        </td>
                        <td><span class="badge badge-<?php 
                            if($wo['status']=='Pending') echo 'secondary';
                            elseif($wo['status']=='In Progress') echo 'primary';
                            elseif($wo['status']=='Completed') echo 'success';
                            else echo 'danger';
                        ?>"><?php echo $wo['status']; ?></span></td>
                        <td>
                             <!-- Actions could go here (Edit, Delete) -->
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Generate -->
<div id="generateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Generate Work Orders</h4>
            </div>
            <div class="modal-body">
                <form id="generate_form">
                    <div class="form-group">
                        <label>Select Production Batch</label>
                        <!-- In a real app, populate this via AJAX or pass all batches to view -->
                        <!-- For MVP, we will assume user knows Batch ID or we pass a simple list -->
                         <input type="number" name="batch_id" class="form-control" placeholder="Batch ID">
                         <small>Enter the ID of the Batch created in Scheduler</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="do_generate">Generate</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Assign -->
<div id="assignModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Task</h4>
            </div>
            <div class="modal-body">
                <form id="assign_form">
                    <input type="hidden" name="wo_id" id="assign_wo_id">
                    <div class="form-group">
                        <label>Select Employee</label>
                        <select name="employee_id" class="form-control">
                            <?php foreach($employees as $emp) { ?>
                                <option value="<?php echo $emp['id']; ?>"><?php echo $emp['username']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="do_assign">Assign</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Assign Modal Pass ID
    $('.assign-btn').click(function(){
        $('#assign_wo_id').val($(this).data('id'));
    });

    // Generate Action
    $('#do_generate').click(function(){
        $.ajax({
            url: "<?php echo site_url('work_orders/generate')?>",
            type: 'POST',
            data: $('#generate_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(data){
                if(data.status=='Success'){
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });

    // Assign Action
    $('#do_assign').click(function(){
        $.ajax({
            url: "<?php echo site_url('work_orders/assign')?>",
            type: 'POST',
            data: $('#assign_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(data){
                if(data.status=='Success'){
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
});
</script>
