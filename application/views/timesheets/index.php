<div class="content-body">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-white shadow-sm">
                <div class="card-header border-bottom-0 pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title text-primary"><i class="fa fa-clock-o"></i> Timesheet Management</h4>
                            <p class="text-muted mb-0">Track employee hours, overtime, and job allocations.</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary active" id="btn-view-calendar" onclick="switchView('calendar')"><i class="fa fa-calendar"></i> Calendar</button>
                                <button type="button" class="btn btn-outline-primary" id="btn-view-list" onclick="switchView('list')"><i class="fa fa-list"></i> List</button>
                            </div>
                            <button class="btn btn-success ml-2" data-toggle="modal" data-target="#addTimesheetModal"><i class="fa fa-plus-circle"></i> Log Time</button>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="card-body pt-0">
                    
                     <!-- User Guide -->
                    <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #FF9800;">
                        <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideTime" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                            <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                        </div>
                        <div id="guideTime" class="collapse">
                            <div class="card-body p-2">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_time">🇬🇧 English</a></li>
                                    <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_time">🇱🇰 Sinhala</a></li>
                                    <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_time">IN Tamil</a></li>
                                </ul>
                                <div class="tab-content border p-2 bg-white">
                                    <div id="eng_time" class="tab-pane active">
                                        <h6 class="text-primary mt-1 small">Timesheets</h6>
                                        <ol class="small pl-3 mb-0">
                                            <li><strong>Log Time:</strong> Click 'Log Time' to record work hours/ot.</li>
                                            <li><strong>Views:</strong> Switch between List and Calendar views for easier tracking.</li>
                                            <li><strong>Approval:</strong> Supervisors can approve or reject submitted timesheets.</li>
                                        </ol>
                                    </div>
                                    <div id="sin_time" class="tab-pane fade">
                                        <h6 class="text-primary mt-1 small">කාල සටහන් (Timesheets)</h6>
                                        <ol class="small pl-3 mb-0">
                                            <li><strong>වේලාවන්:</strong> වැඩ කරන පැය/අතිකාල සටහන් කිරීමට 'Log Time' ක්ලික් කරන්න.</li>
                                            <li><strong>දසුන්:</strong> පහසුවෙන් බැලීම සඳහා List සහ Calendar දසුන් අතර මාරු වන්න.</li>
                                            <li><strong>අනුමැතිය:</strong> අධීක්ෂකවරුන්ට ඉදිරිපත් කළ කාලසටහන් අනුමත හෝ ප්‍රතික්ෂේප කළ හැකිය.</li>
                                        </ol>
                                    </div>
                                    <div id="tam_time" class="tab-pane fade">
                                        <h6 class="text-primary mt-1 small">நேரத்தாள்கள்</h6>
                                        <ol class="small pl-3 mb-0">
                                            <li><strong>நேரம் பதிவு:</strong> வேலை நேரங்களை பதிவு செய்ய 'Log Time' ஐ கிளிக் செய்யவும்.</li>
                                            <li><strong>பார்வைகள்:</strong> எளிதாகக் கண்காணிக்க List மற்றும் Calendar காட்சிகளுக்கு இடையில் மாறவும்.</li>
                                            <li><strong>ஒப்புதல்:</strong> சமர்ப்பிக்கப்பட்ட பணித்தாள்களை மேற்பார்வையாளர்கள் அங்கீகரிக்கலாம்.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End User Guide -->
                    
                    <!-- Debug Info (Hidden unless needed) -->
                    <div id="sys_debug" class="alert alert-warning" style="display:none;"></div>

                    <!-- Filter Section -->
                    <div class="row mb-3 p-2 bg-light rounded align-items-center">
                        <div class="col-md-3">
                            <label class="small font-weight-bold text-muted">Employee</label>
                            <select class="form-control form-control-sm" id="filter_employee">
                                <option value="">All Employees</option>
                                <?php foreach($employees as $e) { ?>
                                    <option value="<?php echo $e['id'] ?>"><?php echo $e['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                             <label class="small font-weight-bold text-muted">Status</label>
                             <select class="form-control form-control-sm" id="filter_status">
                                 <option value="">All Status</option>
                                 <option value="Pending">Pending</option>
                                 <option value="Approved">Approved</option>
                                 <option value="Rejected">Rejected</option>
                             </select>
                        </div>
                        <div class="col-md-2 mt-4">
                            <button class="btn btn-primary btn-sm btn-block" id="refresh_btn"><i class="fa fa-filter"></i> Apply</button>
                        </div>
                    </div>

                    <!-- Calendar View -->
                    <div id="view_calendar">
                        <div id="calendar"></div>
                    </div>

                    <!-- List View -->
                    <div id="view_list" style="display:none;">
                        <table class="table table-hover table-striped" id="timesheet_table" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Employee</th>
                                    <th>Job Code</th>
                                    <th>Time</th>
                                    <th>Hours</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ts_body">
                                <!-- AJAX -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="addTimesheetModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title" id="modal_title"><i class="fa fa-pencil"></i> Log Time Entry</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="timesheet_form">
                    <input type="hidden" name="id" id="ts_id">
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Employee <span class="text-danger">*</span></label>
                        <select class="form-control" name="employee_id" id="ts_employee_id" required>
                             <?php foreach($employees as $e) { ?>
                                 <option value="<?php echo $e['id'] ?>"><?php echo $e['name'] ?></option>
                             <?php } ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="date" id="ts_date" data-toggle="datepicker" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Job Code</label>
                                <select class="form-control" name="job_code" id="ts_job_code">
                                     <option value="">None (General)</option>
                                     <?php foreach($job_codes as $j) { ?>
                                         <option value="<?php echo $j['id'] ?>"><?php echo $j['code'] ?> - <?php echo $j['title'] ?></option>
                                     <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="ts_start_time">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">End Time</label>
                                <input type="time" class="form-control" name="end_time" id="ts_end_time">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Total Hours <span class="text-danger">*</span></label>
                        <input type="number" step="0.25" class="form-control" name="total_hours" id="ts_total_hours" required placeholder="e.g. 8.00">
                        <small class="text-muted">Auto-calculated if start/end times provided.</small>
                    </div>

                    <div class="form-group">
                         <div class="custom-control custom-checkbox">
                             <input type="checkbox" class="custom-control-input" name="is_overtime" id="is_overtime">
                             <label class="custom-control-label" for="is_overtime">Mark as Overtime (Manual Override)</label>
                         </div>
                    </div>

                    <div class="form-group">
                        <label>Note / Description</label>
                        <textarea class="form-control" name="note" id="ts_note" rows="2"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_timesheet"><i class="fa fa-save"></i> Save Entry</button>
            </div>
        </div>
    </div>
</div>

<!-- Dependencies - CDN with Local Fallback if needed in future (for now CDN) -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>

<script>
    var calendarInitialized = false;

    $(document).ready(function() {
        console.log('Timesheets Initializing...');

        // SELF-DIAGNOSIS
        var missing = [];
        if(typeof moment === 'undefined') missing.push('Moment.js');
        if(typeof $.fn.fullCalendar === 'undefined') missing.push('FullCalendar');
        if(missing.length > 0) {
            $('#sys_debug').html('<strong>Warning:</strong> The following components failed to load: ' + missing.join(', ') + '. Switching to Safe Mode (List View only).').show();
            // Force safe mode
            switchView('list');
            $('#btn-view-calendar').addClass('disabled').attr('onclick', '').attr('title', 'Not available');
        }

        // 1. Bind Save Listener IMMEDIATELY
        $('#save_timesheet').click(function(e) {
            e.preventDefault();
            
            var actionurl = baseurl + 'timesheets/save';
            var btn = $(this);
            var dateVal = $('#ts_date').val();
            var hoursVal = $('#ts_total_hours').val();
            
            // Basic validation
            if(!dateVal) { alert('Please select a date'); return; }
            if(!hoursVal) { alert('Please enter total hours'); return; }
            
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            
            $.ajax({
                url: actionurl,
                type: 'POST',
                data: $('#timesheet_form').serialize() + '&' + crsf_token + '=' + crsf_hash,
                dataType: 'json',
                success: function(data) {
                    btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Entry');
                    if(data.status == 'Success') {
                        $('#addTimesheetModal').modal('hide');
                        $('#timesheet_form')[0].reset();
                        
                        try { $('#ts_date').datepicker('reset'); } catch(e){}
                        
                        if(calendarInitialized) {
                            try { $('#calendar').fullCalendar('refetchEvents'); } catch(e){}
                        }
                        
                        load_list();
                        alert('Entry Saved Successfully!');
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Entry');
                    console.error('Save Error:', xhr.responseText);
                    alert('System Error: ' + status + ' - Check console for details');
                }
            });
        });

        // 2. Initialize Datepicker
        if($.fn.datepicker) {
             $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: 'yyyy-mm-dd'
            });
        }
        
        // 3. Initialize Calendar (Safe)
        if(missing.length === 0) {
            try {
                load_calendar();
            } catch(e) {
                console.error('Calendar Init Crash:', e);
            }
        }

        // 4. Bind View Switcher
        $('#refresh_btn').click(function() {
            if($('#view_calendar').is(':visible')) {
               if(calendarInitialized) $('#calendar').fullCalendar('refetchEvents');
            } else {
                load_list();
            }
        });

        // 5. Auto-calculate hours
        $('#ts_end_time, #ts_start_time').change(function() {
            var start = $('#ts_start_time').val();
            var end = $('#ts_end_time').val();
            if(start && end && typeof moment !== 'undefined') {
                var s = moment(start, 'HH:mm');
                var e = moment(end, 'HH:mm');
                // Cross-day check?
                if (e.isBefore(s)) {
                    e.add(1, 'day'); // Assume next day if end < start
                }
                var duration = moment.duration(e.diff(s));
                var hours = duration.asHours();
                if(hours > 0) {
                    $('#ts_total_hours').val(hours.toFixed(2));
                }
            }
        });
    });

    function switchView(view) {
        if(view == 'calendar') {
            $('#view_list').hide();
            $('#view_calendar').show();
            $('#btn-view-list').removeClass('active');
            $('#btn-view-calendar').addClass('active');
            if(calendarInitialized) $('#calendar').fullCalendar('render');
        } else {
            $('#view_calendar').hide();
            $('#view_list').show();
            $('#btn-view-calendar').removeClass('active');
            $('#btn-view-list').addClass('active');
            load_list();
        }
    }

    function load_calendar() {
        if(calendarInitialized) return;
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            navLinks: true,
            editable: true,
            eventLimit: true,
            events: {
                url: baseurl + 'timesheets/get_list',
                type: 'GET',
                data: function() {
                    return {
                        employee_id: $('#filter_employee').val(),
                        status: $('#filter_status').val()
                    };
                },
                error: function() {
                    console.error('Error fetching events');
                    $('#sys_debug').text('Error fetching calendar data from server.').show();
                }
            },
            eventClick: function(event) {
                edit_ts(event.id);
            }
        });
        calendarInitialized = true;
    }

    function load_list() {
        var eid = $('#filter_employee').val();
        var status = $('#filter_status').val();
        
        $.ajax({
            url: baseurl + 'timesheets/get_list?list_mode=1&employee_id=' + eid + '&status=' + status,
            dataType: 'json',
            success: function(data) {
                var html = '';
                if(data.length == 0) {
                    html = '<tr><td colspan="7" class="text-center">No entries found</td></tr>';
                }
                $.each(data, function(i, item) {
                    var status_badge = '<span class="badge badge-warning">Pending</span>';
                    if(item.status == 'Approved') status_badge = '<span class="badge badge-success">Approved</span>';
                    if(item.status == 'Rejected') status_badge = '<span class="badge badge-danger">Rejected</span>';
                    
                    html += '<tr>';
                    html += '<td>'+item.start+'</td>';
                    html += '<td>'+item.employee_name+'</td>';
                    html += '<td>'+(item.title ? item.title : '-')+'</td>';
                    html += '<td>'+(item.clock_in_time ? item.clock_in_time : '') + ' - ' + (item.clock_out_time ? item.clock_out_time : '')+'</td>';
                    html += '<td><b>'+item.total_hours+'</b></td>';
                    html += '<td>'+status_badge+'</td>';
                    html += '<td>';
                    html += '<button class="btn btn-sm btn-outline-primary mr-1" onclick="edit_ts('+item.id+')"><i class="fa fa-pencil"></i></button>';
                    html += '<button class="btn btn-sm btn-outline-danger" onclick="delete_ts('+item.id+')"><i class="fa fa-trash"></i></button>';
                    html += '</td>';
                    html += '</tr>';
                });
                $('#ts_body').html(html);
            }
        });
    }

    function edit_ts(id) {
         $.ajax({
            url: baseurl + 'timesheets/get_details?id=' + id,
            dataType: 'json',
            success: function(data) {
                $('#ts_id').val(data.id);
                $('#ts_employee_id').val(data.employee_id);
                $('#ts_date').datepicker('setDate', data.date_only);
                $('#ts_start_time').val(data.start_time_only);
                $('#ts_end_time').val(data.end_time_only);
                $('#ts_total_hours').val(data.total_hours);
                $('#ts_job_code').val(data.job_code_id);
                $('#ts_note').val(data.note);
                if(data.is_overtime == 1) $('#is_overtime').prop('checked', true);
                else $('#is_overtime').prop('checked', false);
                
                $('#modal_title').text('Edit Entry #' + id);
                $('#addTimesheetModal').modal('show');
            }
        });
    }

    function delete_ts(id) {
        if(confirm('Are you sure you want to delete this entry?')) {
             $.post(baseurl + 'timesheets/delete', {deleteid: id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}, function(data){
                 if(calendarInitialized) $('#calendar').fullCalendar('refetchEvents');
                 load_list();
             }, 'json');
        }
    }
</script>
