<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <!-- User Guide -->
            <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #6610f2;">
                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideMachine" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                    <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                </div>
                <div id="guideMachine" class="collapse">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_mach">🇬🇧 English</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_mach">🇱🇰 Sinhala</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_mach">IN Tamil</a></li>
                        </ul>
                        <div class="tab-content border p-2 bg-white">
                            <div id="eng_mach" class="tab-pane active">
                                <h6 class="text-primary mt-1 small">Machine Registration</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>Specs:</strong> Enter Machine Name and Code (e.g. MCH-001).</li>
                                    <li><strong>Production:</strong> Set 'Capacity/Hour' for scheduling.</li>
                                    <li><strong>Maintenance:</strong> Set 'Maint. Cycle' (Days) to auto-schedule maintenance.</li>
                                    <li><strong>Last:</strong> Record date of 'Last Maintenance'.</li>
                                </ol>
                            </div>
                            <div id="sin_mach" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">යන්ත්‍ර ලියාපදිංචිය</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>විස්තර:</strong> යන්ත්‍රයේ නම සහ කේතය (Code) ඇතුලත් කරන්න.</li>
                                    <li><strong>නිෂ්පාදනය:</strong> කාලසටහන් සඳහා පැයක ධාරිතාව (Capacity/Hour) සකසන්න.</li>
                                    <li><strong>නඩත්තු:</strong> නඩත්තු චක්‍රය (Maint. Cycle) දින වලින් සකසන්න.</li>
                                    <li><strong>අවසන්:</strong> අවසන් වරට නඩත්තු කළ දිනය ඇතුලත් කරන්න.</li>
                                </ol>
                            </div>
                            <div id="tam_mach" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">இயந்திர பதிவு</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>விவரங்கள்:</strong> இயந்திரத்தின் பெயர் மற்றும் குறியீட்டை உள்ளிடவும்.</li>
                                    <li><strong>உற்பத்தி:</strong> அட்டவணைப்படுத்தலுக்காக ஒரு மணி நேர திறனை (Capacity) அமைக்கவும்.</li>
                                    <li><strong>பராமரிப்பு:</strong> பராமரிப்பு சுழற்சியை (Maint. Cycle) நாட்களாக அமைக்கவும்.</li>
                                    <li><strong>கடைசி:</strong> கடைசியாக பராமரிக்கப்பட்ட தேதியை பதிவு செய்யவும்.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End User Guide -->
            <h5>Add Machine</h5>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Machine Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom round required" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="code">Code</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Code (e.g. MCH-001)"
                           class="form-control margin-bottom round required" name="code">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="capacity">Capacity (per Hour)</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Capacity"
                           class="form-control margin-bottom round" name="capacity" value="0.00">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="cycle">Maint. Cycle (Days)</label>
                <div class="col-sm-2">
                    <input type="number" placeholder="Days"
                           class="form-control margin-bottom round required" name="cycle" value="30">
                </div>
                <label class="col-sm-2 col-form-label" for="last_maint">Last Maint. Date</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control result-date required" name="last_maint" 
                           data-toggle="datepicker" autocomplete="false" placeholder="Date">
                </div>
            </div>
             <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" class="form-control margin-bottom round">
                         <option value="Active">Active</option>
                         <option value="Inactive">Inactive</option>
                         <option value="Maintenance">Under Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Add Machine" data-loading-text="Adding...">
                    <input type="hidden" value="machines/create" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
