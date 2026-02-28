<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Project: <?php echo $project['project_name']; ?></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form id="update_project">
                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Project Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $project['project_name']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="budget">Total Budget</label>
                                <input type="number" step="0.01" class="form-control" name="budget" value="<?php echo $project['total_budget']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sdate">Start Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar4" aria-hidden="true"></span></div>
                                    <input type="text" class="form-control datepicker" name="sdate" value="<?php echo ($project['start_date'] && $project['start_date'] != '0000-00-00') ? dateformat($project['start_date']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edate">End Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar4" aria-hidden="true"></span></div>
                                    <input type="text" class="form-control datepicker" name="edate" value="<?php echo ($project['end_date'] && $project['end_date'] != '0000-00-00') ? dateformat($project['end_date']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <select class="form-control" name="customer">
                                    <?php foreach($customers as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>" <?php if($project['customer_id'] == $row['id']) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <select class="form-control" name="location">
                                    <?php foreach($locations as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>" <?php if($project['location_id'] == $row['id']) echo 'selected'; ?>><?php echo $row['cname']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status">
                                    <option value="Planning" <?php if(isset($project['status']) && strcasecmp(trim($project['status']), 'Planning') == 0) echo 'selected'; ?>>Planning</option>
                                    <option value="In-Progress" <?php if(isset($project['status']) && strcasecmp(trim($project['status']), 'In-Progress') == 0) echo 'selected'; ?>>In-Progress</option>
                                    <option value="Finished" <?php if(isset($project['status']) && strcasecmp(trim($project['status']), 'Finished') == 0) echo 'selected'; ?>>Finished</option>
                                    <option value="Canceled" <?php if(isset($project['status']) && strcasecmp(trim($project['status']), 'Canceled') == 0) echo 'selected'; ?>>Canceled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" id="submit-update" class="btn btn-primary">Update Project</button>
                        <a href="<?php echo base_url('project_command/explore?id='.$project['id']); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
        
        $("#submit-update").click(function (e) {
            e.preventDefault();
            $.post("<?php echo base_url('project_command/update_project'); ?>", $("#update_project").serialize(), function(data){
                var result = JSON.parse(data);
                if(result.status == 'Success'){
                    alert('Project Updated Successfully');
                    window.location.href = "<?php echo base_url('project_command/explore?id='.$project['id']); ?>";
                } else {
                    alert(result.message);
                }
            });
        });
    });
</script>
