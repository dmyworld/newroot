<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                 <h5 class="title"> Batch: <strong><?php echo $batch['name']; ?></strong></h5>
            </div>
             <div class="col-md-6 text-xs-right">
                <a href="<?php echo base_url('production_schedule') ?>" class="btn btn-primary btn-sm rounded">Back to Schedule</a>
            </div>
        </div>
        <hr>
        
        <!-- Batch Details -->
         <div class="row mb-2">
            <div class="col-md-3"><strong>Wood Type:</strong> <?php echo $batch['wood_name']; ?></div>
            <div class="col-md-3"><strong>Qty:</strong> <?php echo $batch['total_qty'] . ' ' . $batch['unit']; ?></div>
            <div class="col-md-3"><strong>Priority:</strong> <span class="badge badge-<?php echo ($batch['priority']=='Urgent'?'danger':'warning') ?>"><?php echo $batch['priority']; ?></span></div>
            <div class="col-md-3"><strong>Status:</strong> <?php echo $batch['status']; ?></div>
        </div>
        <div class="row mb-2">
             <div class="col-md-3"><strong>Start Date:</strong> <?php echo $batch['start_date'] ? $batch['start_date'] : 'Not Scheduled'; ?></div>
             <div class="col-md-3"><strong>Due Date:</strong> <?php echo $batch['due_date']; ?></div>
        </div>
        
        <hr>
        
        <!-- Routing Section -->
        <h4>Production Stages / Routing <button class="btn btn-success btn-sm rounded" data-toggle="modal" data-target="#addStageModal"><i class="fa fa-plus"></i> Add Stage</button></h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Seq #</th>
                    <th>Stage Name</th>
                    <th>Machine Assignment</th>
                    <th>Est. Hours</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="route_list">
                <?php foreach($routes as $route) { ?>
                <tr>
                    <td><?php echo $route['sequence_order']; ?></td>
                    <td><?php echo $route['stage_name']; ?></td>
                    <td><?php echo $route['machine_name'] ? $route['machine_name'] : 'Manual / Bench' ?></td>
                    <td><?php echo $route['estimated_hours']; ?> hrs</td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-stage" data-id="<?php echo $route['id']; ?>"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <?php } ?>
                <?php if(empty($routes)) { ?>
                    <tr><td colspan="5" class="text-center">No stages defined.</td></tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<!-- Add Stage Modal -->
<div id="addStageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Production Stage</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="stage_form">
                    <input type="hidden" name="batch_id" value="<?php echo $batch['id']; ?>">
                    <div class="form-group">
                        <label>Stage Name</label>
                        <select name="stage_name" class="form-control">
                            <option value="Cutting">Cutting</option>
                            <option value="Planing">Planing</option>
                            <option value="Sanding">Sanding</option>
                            <option value="Assembly">Assembly</option>
                            <option value="Finishing">Finishing / Polishing</option>
                            <option value="QC">Quality Check</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Machine</label>
                        <select name="machine_id" class="form-control">
                            <option value="">No Machine (Manual)</option>
                            <?php foreach($machines as $machine) { ?>
                                <option value="<?php echo $machine->id; ?>"><?php echo $machine->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group row">
                         <div class="col-md-6">
                            <label>Est. Hours</label>
                            <input type="number" step="0.5" name="hours" class="form-control" value="1.0">
                         </div>
                         <div class="col-md-6">
                             <label>Sequence</label>
                             <input type="number" name="sequence" class="form-control" value="<?php echo count($routes)+1; ?>">
                         </div>
                    </div>
                    
                    <button type="button" id="save_stage" class="btn btn-success">Add Stage</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#save_stage').click(function() {
            $.ajax({
                url: "<?php echo site_url('production_routes/add')?>",
                type: 'POST',
                data: $('#stage_form').serialize() + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
                dataType: 'json',
                success: function(data) {
                     $('#addStageModal').modal('hide');
                     location.reload(); 
                }
            });
        });

        $('.delete-stage').click(function() {
            if(confirm('Delete this stage?')) {
                var id = $(this).data('id');
                $.ajax({
                    url: "<?php echo site_url('production_routes/delete')?>",
                    type: 'POST',
                    data: {'id': id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                    dataType: 'json',
                    success: function(data) {
                         location.reload(); 
                    }
                });
            }
        });
    });
</script>
