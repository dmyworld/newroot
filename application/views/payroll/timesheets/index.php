<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Payroll Timesheets</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#timesheetModal" onclick="resetForm()">
                    <i class="ft-plus"></i> Add Timesheet
                </button>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Employee</label>
                        <select id="filter_employee" class="form-control">
                            <option value="">All Employees</option>
                            <?php foreach($employees as $emp): ?>
                                <option value="<?= $emp['id'] ?>"><?= $emp['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Status</label>
                        <select id="filter_status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" id="filter_start" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" id="filter_end" class="form-control">
                    </div>
                </div>

                <!-- DataTable -->
                <table id="timesheets_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Job</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Hours</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Timesheet Modal -->
<div class="modal fade" id="timesheetModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add/Edit Timesheet</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="timesheetForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="timesheet_id">
                    
                    <div class="form-group">
                        <label>Employee *</label>
                        <select name="employee_id" id="employee_id" class="form-control" required>
                            <option value="">Select Employee</option>
                            <?php foreach($employees as $emp): ?>
                                <option value="<?= $emp['id'] ?>"><?= $emp['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date *</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Time *</label>
                                <input type="time" name="start_time" id="start_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Time *</label>
                                <input type="time" name="end_time" id="end_time" class="form-control" required onchange="calculateHours()">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Total Hours *</label>
                        <input type="number" step="0.25" name="total_hours" id="total_hours" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Job Code</label>
                        <select name="job_code" id="job_code" class="form-control">
                            <option value="">General</option>
                            <?php foreach($job_codes as $job): ?>
                                <option value="<?= $job['id'] ?>"><?= $job['code'] ?> - <?= $job['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_overtime" id="is_overtime" value="1">
                            Is Overtime
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Timesheet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var timesheets_table;

$(document).ready(function() {
    // Initialize DataTable
    timesheets_table = $('#timesheets_table').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "<?= base_url('payrolltimesheets/get_list') ?>",
            "data": function(d) {
                d.employee_id = $('#filter_employee').val();
                d.status = $('#filter_status').val();
                d.start = $('#filter_start').val();
                d.end = $('#filter_end').val();
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "employee_name" },
            { "data": "date" },
            { "data": "job" },
            { "data": "clock_in" },
            { "data": "clock_out" },
            { "data": "total_hours" },
            { "data": "status" },
            { 
                "data": null,
                "render": function(data, type, row) {
                    var actions = '<button class="btn btn-sm btn-info" onclick="editTimesheet('+row.id+')"><i class="ft-edit"></i></button> ';
                    
                    if(row.status.includes('Pending')) {
                        actions += '<button class="btn btn-sm btn-success" onclick="approveTimesheet('+row.id+')"><i class="ft-check"></i></button> ';
                        actions += '<button class="btn btn-sm btn-warning" onclick="rejectTimesheet('+row.id+')"><i class="ft-x"></i></button> ';
                    }
                    
                    actions += '<button class="btn btn-sm btn-danger delete-object" data-object-id="'+row.id+'"><i class="ft-trash"></i></button>';
                    return actions;
                }
            }
        ],
        "order": [[2, "desc"]]
    });

    // Filter change handlers
    $('#filter_employee, #filter_status, #filter_start, #filter_end').on('change', function() {
        timesheets_table.ajax.reload();
    });

    // Form submission
    $('#timesheetForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url("payrolltimesheets/save") ?>',
            method: 'POST',
            data: $(this).serialize() + '&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function(response) {
                if(response.status === 'Success') {
                    $('#timesheetModal').modal('hide');
                    timesheets_table.ajax.reload();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Delete handler
    $(document).on('click', '.delete-object', function() {
        if(confirm('Are you sure you want to delete this timesheet?')) {
            var id = $(this).data('object-id');
            $.ajax({
                url: '<?= base_url("payrolltimesheets/delete") ?>',
                method: 'POST',
                data: { 
                    deleteid: id,
                    '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'Success') {
                        timesheets_table.ajax.reload();
                        alert(response.message);
                    }
                }
            });
        }
    });
});

function resetForm() {
    $('#timesheetForm')[0].reset();
    $('#timesheet_id').val('');
}

function editTimesheet(id) {
    $.ajax({
        url: '<?= base_url("payrolltimesheets/get_details") ?>?id=' + id,
        dataType: 'json',
        success: function(data) {
            $('#timesheet_id').val(data.id);
            $('#employee_id').val(data.employee_id);
            $('#date').val(data.date_only);
            $('#start_time').val(data.start_time_only);
            $('#end_time').val(data.end_time_only);
            $('#total_hours').val(data.total_hours);
            $('#job_code').val(data.job_code_id);
            $('#is_overtime').prop('checked', data.is_overtime == 1);
            $('#note').val(data.note);
            $('#timesheetModal').modal('show');
        }
    });
}

function calculateHours() {
    var start = $('#start_time').val();
    var end = $('#end_time').val();
    
    if(start && end) {
        var startTime = new Date('2000-01-01 ' + start);
        var endTime = new Date('2000-01-01 ' + end);
        var diff = (endTime - startTime) / (1000 * 60 * 60); // Convert to hours
        
        if(diff > 0) {
            $('#total_hours').val(diff.toFixed(2));
        }
    }
}

function approveTimesheet(id) {
    if(confirm('Approve this timesheet?')) {
        updateStatus(id, 'Approved');
    }
}

function rejectTimesheet(id) {
    if(confirm('Reject this timesheet?')) {
        updateStatus(id, 'Rejected');
    }
}

function updateStatus(id, status) {
    $.ajax({
        url: '<?= base_url("payrolltimesheets/update_status") ?>',
        method: 'POST',
        data: { 
            id: id,
            status: status,
            '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'
        },
        dataType: 'json',
        success: function(response) {
            if(response.status === 'Success') {
                timesheets_table.ajax.reload();
                alert(response.message);
            }
        }
    });
}
</script>
