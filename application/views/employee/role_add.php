<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Role') ?></h5>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Role Name" class="form-control margin-bottom" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="parent_id">Master Role</label>
                        <div class="col-sm-6">
                            <select name="parent_id" class="form-control" required>
                                <option value="" disabled selected>-- Select a Master Role --</option>
                                <?php foreach ($master_roles as $role): ?>
                                    <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">This sub-role will inherit the functional tree of this Master Role.</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="employee/role_add" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
