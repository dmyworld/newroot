<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                 Edit Role Permissions: <?php echo $role['name'] ?>
            </h5>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <input type="hidden" name="id" value="<?php echo $role['id'] ?>">
                    
                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Module</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Add</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                            <th class="text-center text-danger">DEMO (20/mo)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        foreach ($modules as $row) {
                            $mid = $row['id'];
                            
                            $can_view = isset($p_map[$mid]['can_view']) && $p_map[$mid]['can_view'] ? 'checked' : '';
                            $can_add = isset($p_map[$mid]['can_add']) && $p_map[$mid]['can_add'] ? 'checked' : '';
                            $can_edit = isset($p_map[$mid]['can_edit']) && $p_map[$mid]['can_edit'] ? 'checked' : '';
                            $can_demo = isset($p_map[$mid]['can_demo']) && $p_map[$mid]['can_demo'] ? 'checked' : '';
                            
                            echo "<tr>
                                <td><strong>" . $row['title'] . "</strong></td>
                                <td class='text-center'><input type='checkbox' name='p[$mid][view]' value='1' $can_view></td>
                                <td class='text-center'><input type='checkbox' name='p[$mid][add]' value='1' $can_add></td>
                                <td class='text-center'><input type='checkbox' name='p[$mid][edit]' value='1' $can_edit></td>
                                <td class='text-center'><input type='checkbox' name='p[$mid][delete]' value='1' $can_delete></td>
                                <td class='text-center'><input type='checkbox' name='p[$mid][demo]' value='1' $can_demo></td>
                            </tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <input type="submit" id="submit-role-permissions" class="btn btn-success margin-bottom btn-lg"
                                   value="<?php echo $this->lang->line('Update') ?>"
                                   data-loading-text="Updating...">
                            <input type="hidden" value="employee/role_edit" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#submit-role-permissions").on("click", function (e) {
        e.preventDefault();
        var o_data = $("#data_form").serialize();
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
                    $("html, body").scrollTop($("body").offset().top);
                    // Do not remove form, maybe reload to show saved state or just stay
                    // location.reload(); 
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>Error</strong>: Server Error");
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    });
</script>
