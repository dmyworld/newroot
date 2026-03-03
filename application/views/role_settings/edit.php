<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Edit Role Setting</h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url('role_settings/edit') ?>" class="form-horizontal">
                
                <input type="hidden" name="id" value="<?php echo $setting['id']; ?>">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="setting_key">Setting Key</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control margin-bottom" name="setting_key" value="<?php echo htmlspecialchars($setting['setting_key']); ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="setting_value">Setting Value</label>
                    <div class="col-sm-6">
                        <textarea class="form-control margin-bottom" name="setting_value" rows="4" required><?php echo htmlspecialchars($setting['setting_value']); ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="access_level">Access Level</label>
                    <div class="col-sm-6">
                        <select name="access_level" id="access_level" class="form-control" onchange="toggleRoles()">
                            <option value="public" <?php if($setting['access_level'] == 'public') echo 'selected'; ?>>Public (Visible to everyone)</option>
                            <option value="super_admin_only" <?php if($setting['access_level'] == 'super_admin_only') echo 'selected'; ?>>Super Admin Only (Highly Secretive)</option>
                            <option value="role_specific" <?php if($setting['access_level'] == 'role_specific') echo 'selected'; ?>>Role Specific (Limit to specific roles)</option>
                        </select>
                    </div>
                </div>

                <?php 
                   $allowed = [];
                   if($setting['allowed_roles']) {
                       $allowed = json_decode($setting['allowed_roles'], true) ?? [];
                   }
                ?>

                <div class="form-group row" id="roles_div" style="display: <?php echo ($setting['access_level'] == 'role_specific') ? 'flex' : 'none'; ?>;">
                    <label class="col-sm-2 col-form-label" for="allowed_roles">Allowed Roles</label>
                    <div class="col-sm-6">
                        <select name="allowed_roles[]" class="form-control select-box" multiple="multiple">
                            <option value="1" <?php if(in_array("1", $allowed)) echo 'selected'; ?>>Super Admin (1)</option>
                            <option value="2" <?php if(in_array("2", $allowed)) echo 'selected'; ?>>Admin/Owner (2)</option>
                            <option value="3" <?php if(in_array("3", $allowed)) echo 'selected'; ?>>Manager (3)</option>
                            <option value="4" <?php if(in_array("4", $allowed)) echo 'selected'; ?>>Sales/Provider (4)</option>
                            <option value="5" <?php if(in_array("5", $allowed)) echo 'selected'; ?>>Employee/Serviceman (5)</option>
                            <option value="6" <?php if(in_array("6", $allowed)) echo 'selected'; ?>>Customer (6)</option>
                        </select>
                        <small>Select multiple roles by holding Ctrl/Cmd. These roles will be able to access this setting.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4">
                        <input type="submit" class="btn btn-success margin-bottom" value="Update Setting">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function toggleRoles() {
        var al = document.getElementById("access_level").value;
        if(al === 'role_specific') {
            document.getElementById("roles_div").style.display = 'flex';
        } else {
            document.getElementById("roles_div").style.display = 'none';
        }
    }
</script>
