<div class="content-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="title mb-0">
                 Edit Role Permissions: <span class="text-primary"><?php echo $role['name'] ?></span>
            </h5>
            <div>
                <button type="button" id="global-select-all" class="btn btn-success btn-sm shadow-sm mr-1"><i class="fa fa-check-square-o"></i> Select All Globally</button>
                <button type="button" id="global-deselect-all" class="btn btn-warning btn-sm shadow-sm"><i class="fa fa-square-o"></i> Deselect All</button>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <input type="hidden" name="id" value="<?php echo $role['id'] ?>">
                    <input type="hidden" value="employee/role_edit" id="action-url">
                    
                    <div class="permissions-container mt-2">
                        <table id="permissionsTable" class="table table-striped table-bordered table-hover zero-configuration" cellspacing="0" width="100%">
                            <thead class="bg-blue-grey bg-lighten-5">
                                <tr>
                                    <th>ModuleCode_Hidden</th>
                                    <th style="width: 30%">Page / Resource</th>
                                    <th>Granular Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($consolidated as $m): ?>
                                    <?php if ($m['legacy_id']): ?>
                                        <?php 
                                            // Check parent perms for this module if not Super Admin
                                            $p_l = isset($parent_legacy_perms[$m['legacy_id']]) ? $parent_legacy_perms[$m['legacy_id']] : null;
                                            $can_v = ($is_super_admin || (isset($p_l['can_view']) && $p_l['can_view'])) ? '' : 'disabled';
                                            $can_a = ($is_super_admin || (isset($p_l['can_add']) && $p_l['can_add'])) ? '' : 'disabled';
                                            $can_e = ($is_super_admin || (isset($p_l['can_edit']) && $p_l['can_edit'])) ? '' : 'disabled';
                                            $can_d = ($is_super_admin || (isset($p_l['can_delete']) && $p_l['can_delete'])) ? '' : 'disabled';
                                        ?>
                                        <tr>
                                            <td><?php echo $m['title']; ?></td>
                                            <td class="align-middle text-muted"><em>Legacy Module Levels</em></td>
                                            <td>
                                                <div class="d-flex flex-wrap py-1">
                                                    <div class="mx-1 my-1 custom-control custom-checkbox border rounded p-1 bg-white shadow-sm" style="min-width: 110px;">
                                                        <input type="checkbox" name="p[<?php echo $m['legacy_id']; ?>][view]" value="1" id="lv_<?php echo $m['legacy_id']; ?>" class="custom-control-input" <?php echo (isset($m['legacy_perms']['can_view']) && $m['legacy_perms']['can_view']) ? 'checked' : ''; ?> <?php echo $can_v; ?>>
                                                        <label class="custom-control-label font-small-2 font-weight-bold text-primary" for="lv_<?php echo $m['legacy_id']; ?>">VIEW MODULE</label>
                                                    </div>
                                                    <div class="mx-1 my-1 custom-control custom-checkbox border rounded p-1 bg-white shadow-sm" style="min-width: 110px;">
                                                        <input type="checkbox" name="p[<?php echo $m['legacy_id']; ?>][add]" value="1" id="la_<?php echo $m['legacy_id']; ?>" class="custom-control-input" <?php echo (isset($m['legacy_perms']['can_add']) && $m['legacy_perms']['can_add']) ? 'checked' : ''; ?> <?php echo $can_a; ?>>
                                                        <label class="custom-control-label font-small-2 font-weight-bold text-success" for="la_<?php echo $m['legacy_id']; ?>">ADD MODULE</label>
                                                    </div>
                                                    <div class="mx-1 my-1 custom-control custom-checkbox border rounded p-1 bg-white shadow-sm" style="min-width: 110px;">
                                                        <input type="checkbox" name="p[<?php echo $m['legacy_id']; ?>][edit]" value="1" id="le_<?php echo $m['legacy_id']; ?>" class="custom-control-input" <?php echo (isset($m['legacy_perms']['can_edit']) && $m['legacy_perms']['can_edit']) ? 'checked' : ''; ?> <?php echo $can_e; ?>>
                                                        <label class="custom-control-label font-small-2 font-weight-bold text-warning" for="le_<?php echo $m['legacy_id']; ?>">EDIT MODULE</label>
                                                    </div>
                                                    <div class="mx-1 my-1 custom-control custom-checkbox border rounded p-1 bg-white shadow-sm" style="min-width: 110px;">
                                                        <input type="checkbox" name="p[<?php echo $m['legacy_id']; ?>][delete]" value="1" id="ld_<?php echo $m['legacy_id']; ?>" class="custom-control-input" <?php echo (isset($m['legacy_perms']['can_delete']) && $m['legacy_perms']['can_delete']) ? 'checked' : ''; ?> <?php echo $can_d; ?>>
                                                        <label class="custom-control-label font-small-2 font-weight-bold text-danger" for="ld_<?php echo $m['legacy_id']; ?>">DELETE MODULE</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    
                                    <?php foreach ($m['pages'] as $p): ?>
                                        <tr>
                                            <td><?php echo $m['title']; ?></td>
                                            <td class="align-middle">
                                                <span class="font-weight-bold text-dark font-small-3"><i class="fa fa-file-text-o text-muted mr-1"></i> <?php echo $p['title']; ?></span><br>
                                                <small class="text-muted"><i class="fa fa-link mr-1"></i><?php echo $p['page_url']; ?></small>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap py-1">
                                                    <?php foreach ($p['permissions'] as $perm): ?>
                                                        <?php 
                                                            $checked = in_array($perm['id'], $current_gp) ? 'checked' : ''; 
                                                            $disabled = ($is_super_admin || in_array($perm['id'], $parent_granular_perms)) ? '' : 'disabled';
                                                        ?>
                                                        <div class="mx-1 my-1 custom-control custom-checkbox border rounded p-1 bg-white shadow-sm" style="min-width: 110px;">
                                                            <input type="checkbox" name="gp[<?php echo $perm['id']; ?>]" value="1" id="p_<?php echo $perm['id']; ?>" class="custom-control-input" <?php echo $checked; ?> <?php echo $disabled; ?>>
                                                            <label class="custom-control-label font-small-2 text-uppercase text-dark" for="p_<?php echo $perm['id']; ?>"><?php echo $perm['action_title']; ?></label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-group row mt-3 pb-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" id="submit-role-permissions" class="btn btn-primary shadow-lg btn-lg"><i class="fa fa-floppy-o mr-1"></i> <?php echo $this->lang->line('Update') ?> Permissions</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Initialize DataTable with custom Row Grouping via drawCallback for UI aesthetics
        var pTable = $('#permissionsTable').DataTable({
            "pageLength": 50,
            "responsive": true,
            "order": [], // Preserves original group chunk ordering 
            "columnDefs": [
                { "visible": false, "targets": 0 } // Hide the raw module text name
            ],
            "language": {
                "search": "Filter Pages:"
            },
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                
                // Group rows by Module string in Column 0
                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group" style="background-color: #f4f5fa;"><td colspan="2" class="p-1"><div class="d-flex justify-content-between align-items-center"><span class="font-weight-bold text-info font-medium-3 text-uppercase"><i class="fa fa-cube mr-1 text-primary"></i> ' + group + '</span> <button type="button" class="btn btn-sm btn-info select-module-btn shadow-sm" data-module="'+group+'"><i class="fa fa-check-square-o"></i> Select All in Module</button></div></td></tr>'
                        );
                        last = group;
                    }
                } );
            }
        });

        // Global Select All action
        $('#global-select-all').on('click', function() {
            pTable.$('input[type="checkbox"]').prop('checked', true);
        });
        
        // Global Deselect All action
        $('#global-deselect-all').on('click', function() {
            pTable.$('input[type="checkbox"]').prop('checked', false);
        });

        // Module-Level Select All action
        $('#permissionsTable tbody').on('click', '.select-module-btn', function() {
            var moduleName = $(this).data('module');
            pTable.rows().every(function() {
                var data = this.data();
                if (data[0] === moduleName) { // Check if this hidden row's column 0 matches the module
                    $(this.node()).find('input[type="checkbox"]').prop('checked', true);
                }
            });
        });

        // Submit listener ensuring perfectly serialized payloads across pagination DOM boundaries
        $("#submit-role-permissions").on("click", function (e) {
            e.preventDefault();
            
            var form_base = $('#data_form').find('input[type="hidden"]').serialize();
            var table_data = pTable.$('input[type="checkbox"]').serialize();
            var o_data = form_base + (table_data ? '&' + table_data : '');
            var action_url = $('#action-url').val();
            
            $.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: o_data + '&' + crsf_token + '=' + crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>Error</strong>: Server Error. Please contact admin.");
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        });
    });
</script>
