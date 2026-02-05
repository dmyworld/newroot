<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Run Payroll</h4>
             <div class="heading-elements">
                <a href="<?php echo base_url('payrollsettings'); ?>" class="btn btn-outline-secondary btn-sm"><i class="fa fa-cog"></i> Configuration</a>
                <a href="<?php echo base_url('employeeloans'); ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-money"></i> Manage Loans</a>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">

                 <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #673AB7;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guidePay" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guidePay" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_pay">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_pay">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_pay">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_pay" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Payroll Processing</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Period:</strong> Select Pay Period Start and End dates (usually monthly).</li>
                                        <li><strong>Select:</strong> Choose employees to include in this payroll run.</li>
                                        <li><strong>Generate:</strong> Click 'Generate Preview' to calculate earnings and deductions.</li>
                                    </ol>
                                </div>
                                <div id="sin_pay" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">වැටුප් සැකසීම</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>කාල සීමාව:</strong> වැටුප් ඇරඹුම් සහ අවසන් දින තෝරන්න (සාමාන්‍යයෙන් මාසිකව).</li>
                                        <li><strong>තෝරාගැනීම:</strong> මෙම වැටුප් ගෙවීමට ඇතුළත් කළ යුතු සේවකයින් තෝරන්න.</li>
                                        <li><strong>උත්පාදනය:</strong> ඉපැයීම් සහ අඩු කිරීම් ගණනය කිරීමට 'Generate Preview' ක්ලික් කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_pay" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">சம்பள செயலாக்கம்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>காலம்:</strong> சம்பளக் காலத்தின் தொடக்க மற்றும் முடிவு தேதிகளைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>தேர்வு:</strong> இந்தச் சம்பளப்பட்டியலில் சேர்க்க வேண்டிய ஊழியர்களைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>உருவாக்கு:</strong> வருவாய் மற்றும் பிடித்தங்களைக் கணக்கிட 'Generate Preview' ஐ கிளிக் செய்யவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <form id="payroll_run_form">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_date">Pay Period Start</label>
                                <input type="text" class="form-control" name="start" id="start_date" data-toggle="datepicker" autocomplete="false" required value="2026-01-01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_date">Pay Period End</label>
                                <input type="text" class="form-control" name="end" id="end_date" data-toggle="datepicker" autocomplete="false" required value="2026-01-31">
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label>Department (Optional)</label>
                                <select class="form-control" id="dept_filter">
                                    <option value="">ALL</option>
                                    <!-- Populate if needed -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Select Employees</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="employee_list_table">
                            <thead>
                                <tr>
                                    <th width="10"><input type="checkbox" id="select_all"></th>
                                    <th>Employee Name</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group mt-2 text-right">
                        <button type="button" id="btn_generate_preview" class="btn btn-primary btn-lg"><i class="fa fa-calculator"></i> Generate Preview</button>
                    </div>

                    <div id="preview_area" style="display:none; margin-top: 30px;">
                        <!-- Preview Table Loaded via AJAX -->
                        <div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading Preview...</div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Datepicker init
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: 'yyyy-mm-dd'
        });

        // DataTable Init
        var table = $('#employee_list_table').DataTable({
            "ajax": baseurl + "payrollprocessing/get_employees",
            "columns": [
                { 
                    "data": "id",
                    "render": function(data, type, row) {
                        return '<input type="checkbox" name="employee_ids[]" value="' + data + '" class="emp-checkbox">';
                    },
                    "orderable": false
                },
                { "data": "name" },
                { "data": "role" },
                { "data": "dept" }
            ],
            "order": [[1, 'asc']]
        });

        // Select All (Handles current page primarily, but logic can be extended)
        $('#select_all').change(function() {
            var checked = $(this).prop('checked');
            // Select only visible rows on current page with this method
            // To select ALL in dataset, we'd need to manipulate the internal data or handle submission differently
            $('.emp-checkbox').prop('checked', checked);
        });

        // Generate Preview
        $('#btn_generate_preview').click(function() {
            var form = $('#payroll_run_form');
            if(!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }

            // Manually get checked boxes from the table (handles pagination if we use API)
            // Ideally we serialize the table. For now, serialize form works for current page.
            // If user wants multi-page select, we need: table.$('input[type="checkbox"]').serialize()
            
            // Checking if any selected
            if(table.$('.emp-checkbox:checked').length == 0) {
                alert('Please select at least one employee.');
                return;
            }

            $('#preview_area').show().html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i><br><h3>Calculating Payroll...</h3></div>');
            
            // Scroll to preview
            $('html, body').animate({
                scrollTop: $("#preview_area").offset().top
            }, 1000);

            // Serialization trick for DataTables to include all pages
            var data = table.$('input, select').serialize();
            var date_data = "start=" + $('#start_date').val() + "&end=" + $('#end_date').val();

            $.ajax({
                url: baseurl + 'payrollprocessing/preview',
                type: 'POST',
                data: data + '&' + date_data + '&' + crsf_token + '=' + crsf_hash,
                success: function(data) {
                    $('#preview_area').html(data);
                },
                error: function() {
                    $('#preview_area').html('<div class="alert alert-danger">Error calculating payroll. Please try again.</div>');
                }
            });
        });
    });
</script>
