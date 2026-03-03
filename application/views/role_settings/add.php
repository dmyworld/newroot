<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Add New Role Setting</h5>
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
            <form method="post" action="<?php echo base_url('role_settings/add') ?>" class="form-horizontal">
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="setting_key">Setting Key</label>
                    <div class="col-sm-6">
                        <input type="text" placeholder="e.g. max_withdrawal_limit" class="form-control margin-bottom" name="setting_key" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="setting_value">Setting Value</label>
                    <div class="col-sm-6">
                        <textarea class="form-control margin-bottom" name="setting_value" rows="4" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="access_level">Access Level</label>
                    <div class="col-sm-6">
                        <select name="access_level" id="access_level" class="form-control" onchange="toggleRoles()">
                            <option value="public">Public (Visible to everyone)</option>
                            <option value="super_admin_only">Super Admin Only (Highly Secretive)</option>
                            <option value="role_specific">Role Specific (Limit to specific roles)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="roles_div" style="display: none;">
                    <label class="col-sm-2 col-form-label" for="allowed_roles">Allowed Roles</label>
                    <div class="col-sm-6">
                        <select name="allowed_roles[]" class="form-control select-box" multiple="multiple">
                            <option value="1">Super Admin (1)</option>
                            <option value="2">Admin/Owner (2)</option>
                            <option value="3">Manager (3)</option>
                            <option value="4">Sales/Provider (4)</option>
                            <option value="5">Employee/Serviceman (5)</option>
                            <option value="6">Customer (6)</option>
                        </select>
                        <small>Select multiple roles by holding Ctrl/Cmd. These roles will be able to access this setting.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4">
                        <input type="submit" class="btn btn-success margin-bottom" value="Save Setting">
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
