<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h3><?php echo $title . ': ' . $project['project_name']; ?></h3>
            <a href="<?php echo base_url('project_command/explore?id=' . $project['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back to Project</a>
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addMilestoneModal"><i class="fa fa-plus"></i> Add Milestone</button>
        </div>
        <div class="card-body">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Description</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($milestones as $m) { ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="m-status" data-id="<?php echo $m['id']; ?>" <?php if($m['status']) echo 'checked'; ?>>
                        </td>
                        <td><?php echo $m['name']; ?></td>
                        <td><?php echo dateformat($m['due_date']); ?></td>
                        <td><?php echo $m['description']; ?></td>
                        <td><span class="badge" style="background-color:<?php echo $m['color']; ?>;">&nbsp;&nbsp;</span></td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-milestone" data-id="<?php echo $m['id']; ?>"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Milestone Modal -->
<div id="addMilestoneModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Milestone</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add_milestone_form">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="pid" value="<?php echo $project['id']; ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="date" class="form-control" id="mdate" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Color</label>
                        <div class="col-sm-10">
                            <input type="color" name="color" class="form-control" value="#007bff">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea name="desc" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="save_milestone">Add Milestone</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
        
        $('#save_milestone').click(function(){
            $.post("<?php echo base_url('project_command/add_milestone'); ?>", $("#add_milestone_form").serialize(), function(data){
                var result = JSON.parse(data);
                if(result.status == 'Success'){
                    location.reload();
                } else {
                    alert(result.message);
                }
            });
        });

        $('.delete-milestone').click(function(){
            if(confirm('Delete Milestone?')){
                var id = $(this).data('id');
                $.post("<?php echo base_url('project_command/delete_milestone'); ?>", {id: id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(data){
                     location.reload();
                });
            }
        });

        $('.m-status').change(function(){
             var id = $(this).data('id');
             var stat = $(this).is(':checked') ? 1 : 0;
             $.post("<?php echo base_url('project_command/set_milestone_status'); ?>", {id: id, stat: stat, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(data){
                 // notification
             });
        });
    });
</script>
