<div class="content-body">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Project Setup Wizard</h4>
            <div class="heading-elements">
                <div class="btn-group">
                    <button type="button" class="btn btn-info" id="btn-help"><i class="fa fa-question-circle"></i> How to Use</button>
                    <select id="help-lang" class="form-control" style="width: 100px; display: inline-block; margin-left: 5px;">
                        <option value="en">EN</option>
                        <option value="si">සිංහල</option>
                        <option value="ta">தமிழ்</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <!-- Wizard Progress -->
                <div class="row mb-3">
                    <div class="col-12">
                        <ul class="nav nav-pills nav-justified" id="wizard-steps">
                            <li class="nav-item">
                                <a class="nav-link active" id="step1-tab" data-toggle="pill" href="#step1">1. Project Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" id="step2-tab" data-toggle="pill" href="#step2">2. Team Allocation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" id="step3-tab" data-toggle="pill" href="#step3">3. Tasks & Materials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" id="step4-tab" data-toggle="pill" href="#step4">4. Finance Preview</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <!-- Step 1: Project Details -->
                    <div class="tab-pane fade show active" id="step1">
                        <form id="form-step1">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Project Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" placeholder="e.g. Modern Villa Teak Fittings" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Location / Branch</label>
                                <div class="col-sm-4">
                                    <select name="location" class="form-control">
                                        <?php foreach($locations as $loc) { echo "<option value='{$loc['id']}'>{$loc['cname']}</option>"; } ?>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Customer</label>
                                <div class="col-sm-4">
                                    <select name="customer" class="form-control select2">
                                        <?php foreach($customers as $cust) { echo "<option value='{$cust['id']}'>{$cust['name']} ({$cust['phone']})</option>"; } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Start Date</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control datepicker" name="sdate" required>
                                </div>
                                <label class="col-sm-2 col-form-label">End Date</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control datepicker" name="edate" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Total Budget (LKR)</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="budget" placeholder="0.00">
                                </div>
                            </div>
                            <div class="float-right">
                                <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next: Team Allocation <i class="fa fa-chevron-right"></i></button>
                            </div>
                        </form>
                    </div>

                    <!-- Step 2: Team Allocation -->
                    <div class="tab-pane fade" id="step2">
                        <h5>Employee Utilization Tracking</h5>
                        <p class="text-muted">Ensure employees are not assigned more than 8 hours/day across all active projects.</p>
                        <div id="utilization-container" class="mb-3">
                            <!-- Utilization bars will be loaded here via AJAX -->
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(2)"><i class="fa fa-chevron-left"></i> Previous</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next: Tasks & Materials <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <!-- Step 3: Tasks & Materials -->
                    <div class="tab-pane fade" id="step3">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Add Project Task</h5>
                                <form id="form-task">
                                    <div class="form-group">
                                        <label>Task Description</label>
                                        <input type="text" class="form-control" name="task_name" placeholder="e.g. Frame cutting" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Assign To</label>
                                        <select name="employee_id" class="form-control">
                                            <?php foreach($employees as $emp) { echo "<option value='{$emp['id']}'>{$emp['name']}</option>"; } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Estimated Hours</label>
                                        <input type="number" class="form-control" name="hours" placeholder="4" required>
                                    </div>
                                    <button type="button" class="btn btn-info" id="add-task-btn">Add Task</button>
                                </form>
                                
                                <div class="mt-3">
                                    <h6>Project Tasks</h6>
                                    <table class="table table-sm table-bordered" id="task-list">
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Assigned To</th>
                                                <th>Hours</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 border-left">
                                <h5>Material Reservation (Inventory Hook)</h5>
                                <p class="text-small text-muted">Items selected here will be marked as 'Pending Issue'.</p>
                                
                                <!-- Product Search -->
                                <div class="form-group">
                                    <label>Search Product</label>
                                    <select id="product-search" class="form-control select2" style="width: 100%;">
                                        <option value="">Type to search products...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" id="material-qty" class="form-control" placeholder="0" min="1">
                                </div>
                                <button type="button" class="btn btn-warning" id="add-material-btn"><i class="fa fa-plus"></i> Reserve Material</button>
                                
                                <div class="mt-3">
                                    <h6>Reserved Materials</h6>
                                    <table class="table table-sm table-bordered" id="material-list">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="float-right mt-3">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(3)"><i class="fa fa-chevron-left"></i> Previous</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next: Financial Preview <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <!-- Step 4: Finance Preview -->
                    <div class="tab-pane fade" id="step4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Project Financial Summary</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Estimated Sales (Contract Value)</td>
                                                <td class="text-right" id="summary-budget">LKR 0.00</td>
                                            </tr>
                                            <tr>
                                                <td>Estimated Labor Cost</td>
                                                <td class="text-right text-danger" id="summary-labor">LKR 0.00</td>
                                            </tr>
                                            <tr>
                                                <td>Estimated Material Cost</td>
                                                <td class="text-right text-danger" id="summary-material">LKR 0.00</td>
                                            </tr>
                                            <tr class="border-top">
                                                <td><strong>Projected Net Profit</strong></td>
                                                <td class="text-right text-success"><strong id="summary-profit">LKR 0.00</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Once confirmed, double-entry logs for WIP will be initialized.
                                </div>
                                <button type="button" class="btn btn-success btn-lg btn-block" id="finish-btn">Confirm & Finalize Project</button>
                            </div>
                        </div>
                        <div class="float-right mt-2">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(4)"><i class="fa fa-chevron-left"></i> Previous</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Slide-out Panel -->
<div id="help-panel" class="card" style="position: fixed; top: 0; right: -400px; width: 400px; height: 100%; z-index: 9999; box-shadow: -5px 0 15px rgba(0,0,0,0.1); transition: 0.3s; margin-bottom:0;">
    <div class="card-header bg-primary white">
        <h5 class="white"><i class="fa fa-info-circle"></i> User Guide</h5>
        <button type="button" class="close white" id="help-close">&times;</button>
    </div>
    <div class="card-body" id="help-content">
        <!-- Content loaded via AJAX -->
        <p>Select a section to see instructions.</p>
    </div>
</div>

<script type="text/javascript">
    var currentProjectId = null;

    $(document).ready(function () {
        $('.datepicker').datepicker({autoHide: true, format: 'dd-mm-yyyy'});
        $('.select2').select2();

        // Global CSRF token for all AJAX calls
        $.ajaxSetup({
            data: { [crsf_token]: crsf_hash }
        });

        // Help Panel Logic
        $('#btn-help').click(function() {
            loadHelp();
            $('#help-panel').css('right', '0');
        });
        $('#help-close').click(function() {
            $('#help-panel').css('right', '-400px');
        });
        $('#help-lang').change(loadHelp);

        // Initialize Product Search with Select2 AJAX
        $('#product-search').select2({
            placeholder: 'Type to search products...',
            ajax: {
                url: baseurl + 'project_command/product_search',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.product_name + ' (' + item.product_code + ')',
                                id: item.pid,
                                name: item.product_name
                            }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        // Add Task Logic
        $('#add-task-btn').click(function() {
            if(!currentProjectId) { alert('Please complete Step 1 first'); return; }
            var formData = $('#form-task').serialize() + '&project_id=' + currentProjectId;
            $.ajax({
                url: baseurl + 'project_command/save_task',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'Success') {
                        $('#form-task')[0].reset();
                        loadTasks(); // Reload task list
                    } else {
                        alert(data.message);
                    }
                }
            });
        });

        // Add Material Logic
        $('#add-material-btn').click(function() {
            if(!currentProjectId) { alert('Please complete Step 1 first'); return; }
            var selData = $('#product-search').select2('data');
            if(!selData || !selData.length) {
                alert('Please select a product');
                return;
            }
            var productId = selData[0].id;
            var qty = $('#material-qty').val();

            if(!productId || !qty) {
                alert('Please select a product and enter quantity');
                return;
            }

            $.ajax({
                url: baseurl + 'project_command/save_reservation',
                type: 'POST',
                data: {project_id: currentProjectId, product_id: productId, qty: qty},
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'Success') {
                        $('#product-search').val(null).trigger('change');
                        $('#material-qty').val('');
                        loadMaterials(); // Reload material list
                    } else {
                        alert(data.message);
                    }
                }
            });
        });

        // Finish Logic
        $('#finish-btn').click(function() {
            if(!currentProjectId) return;
            $.ajax({
                url: baseurl + 'project_command/finalise_project',
                type: 'POST',
                data: {project_id: currentProjectId},
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'Success') {
                        alert(data.message);
                        window.location.href = baseurl + 'project_command';
                    }
                }
            });
        });
    });

    function nextStep(step) {
        if(step == 1) {
            // Validate and save project basic details
            $.ajax({
                url: baseurl + 'project_command/save_project',
                type: 'POST',
                data: $('#form-step1').serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'Success') {
                        currentProjectId = data.project_id;
                        loadUtilization();
                        switchToTab(2);
                        $('#summary-budget').text('LKR ' + $('input[name="budget"]').val());
                    } else {
                        alert(data.message);
                    }
                }
            });
        } else if(step == 2) {
            loadTasks();
            loadMaterials();
            switchToTab(3);
        } else if(step == 3) {
            loadProjectSummary();
            switchToTab(4);
        }
    }

    function prevStep(step) {
        switchToTab(step - 1);
    }

    function switchToTab(step) {
        $('.nav-link').addClass('disabled').removeClass('active');
        $('#step' + step + '-tab').removeClass('disabled').addClass('active');
        $('.tab-pane').removeClass('show active');
        $('#step' + step).addClass('show active');
    }

    function loadHelp() {
        var lang = $('#help-lang').val();
        $.get(baseurl + 'project_command/get_help_content?lang=' + lang, function(data) {
            var raw = JSON.parse(data);
            var html = '<h6>' + raw.step1_title + '</h6><p>' + raw.step1_desc + '</p>';
            html += '<hr><h6>Helpful Tips</h6><ul><li>' + raw.location_help + '</li><li>' + raw.budget_help + '</li><li>' + raw.material_help + '</li></ul>';
            $('#help-content').html(html);
        });
    }

    function loadUtilization() {
        $.get(baseurl + 'project_command/get_utilization', function(data) {
            var emps = JSON.parse(data);
            var html = '';
            emps.forEach(function(e) {
                var pct = (e.hours / e.limit) * 100;
                var color = pct > 100 ? 'bg-danger' : (pct > 80 ? 'bg-warning' : 'bg-success');
                html += '<div class="mb-1"><strong>' + e.name + '</strong> (' + e.hours + 'h / ' + e.limit + 'h)';
                html += '<div class="progress mt-1" style="height: 10px;">';
                html += '<div class="progress-bar ' + color + '" role="progressbar" style="width: ' + pct + '%"></div>';
                html += '</div></div>';
            });
            $('#utilization-container').html(html);
        });
    }

    function loadTasks() {
        if(!currentProjectId) return;
        $.get(baseurl + 'project_command/get_tasks?project_id=' + currentProjectId, function(data) {
            var tasks = JSON.parse(data);
            var html = '';
            tasks.forEach(function(task) {
                html += '<tr>';
                html += '<td>' + task.task_name + '</td>';
                html += '<td>' + task.employee_name + '</td>';
                html += '<td>' + task.estimated_hours + '</td>';
                html += '<td><button class="btn btn-sm btn-danger" onclick="deleteTask(' + task.id + ')"><i class="fa fa-trash"></i></button></td>';
                html += '</tr>';
            });
            $('#task-list tbody').html(html);
        });
    }

    function loadMaterials() {
        if(!currentProjectId) return;
        $.get(baseurl + 'project_command/get_reservations?project_id=' + currentProjectId, function(data) {
            var materials = JSON.parse(data);
            var html = '';
            materials.forEach(function(mat) {
                html += '<tr>';
                html += '<td>' + mat.product_name + '</td>';
                html += '<td>' + mat.qty + '</td>';
                html += '<td><button class="btn btn-sm btn-danger" onclick="deleteMaterial(' + mat.id + ')"><i class="fa fa-trash"></i></button></td>';
                html += '</tr>';
            });
            $('#material-list tbody').html(html);
        });
    }

    function deleteTask(taskId) {
        if(!confirm('Delete this task?')) return;
        $.post(baseurl + 'project_command/delete_task', {id: taskId}, function(data) {
            var res = JSON.parse(data);
            if(res.status == 'Success') {
                loadTasks();
            }
        });
    }

    function deleteMaterial(matId) {
        if(!confirm('Remove this material reservation?')) return;
        $.post(baseurl + 'project_command/delete_reservation', {id: matId}, function(data) {
            var res = JSON.parse(data);
            if(res.status == 'Success') {
                loadMaterials();
            }
        });
    }

    function loadProjectSummary() {
        if(!currentProjectId) return;
        $.get(baseurl + 'project_command/get_project_summary?project_id=' + currentProjectId, function(data) {
            var summary = JSON.parse(data);
            var budget = parseFloat($('input[name="budget"]').val()) || 0;
            var laborCost = parseFloat(summary.labor_cost) || 0;
            var materialCost = parseFloat(summary.material_cost) || 0;
            var profit = budget - laborCost - materialCost;

            $('#summary-budget').text('LKR ' + budget.toFixed(2));
            $('#summary-labor').text('LKR ' + laborCost.toFixed(2));
            $('#summary-material').text('- LKR ' + materialCost.toFixed(2));
            $('#summary-profit').text('LKR ' + profit.toFixed(2));

            // Color profit based on positive/negative
            if(profit < 0) {
                $('#summary-profit').removeClass('text-success').addClass('text-danger');
            } else {
                $('#summary-profit').removeClass('text-danger').addClass('text-success');
            }
        });
    }
</script>

<style>
    .nav-pills .nav-link.active { background-color: #28d094; }
    .nav-pills .nav-link { color: #555; font-weight: 500; border: 1px solid #ddd; margin: 0 5px; }
    .nav-pills .nav-link.disabled { background-color: #f8f9fa; color: #ccc; }
    .tab-pane { padding: 20px 0; }
</style>
