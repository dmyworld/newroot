<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Add New Asset</h5>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #17a2b8;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideAsset" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideAsset" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_asset">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_asset">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_asset">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_asset" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Adding New Asset</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Details:</strong> Enter Asset Name and Serial Number.</li>
                                        <li><strong>Status:</strong> Set Value and Status (Available, In Use, Damaged).</li>
                                        <li><strong>Assign:</strong> Optionally assign to an employee for tracking.</li>
                                        <li><strong>Date:</strong> Select 'Date Acquired' and Save.</li>
                                    </ol>
                                </div>
                                <div id="sin_asset" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">නව වත්කමක් එක් කිරීම</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>විස්තර:</strong> වත්කමේ නම සහ අනුක්‍රමික අංකය (Serial) ඇතුලත් කරන්න.</li>
                                        <li><strong>තත්ත්වය:</strong> වටිනාකම සහ තත්ත්වය (Available/In Use) තෝරන්න.</li>
                                        <li><strong>පැවරීම:</strong> අවශ්‍ය නම් සේවකයෙකුට පැවරිය හැක (Assign).</li>
                                        <li><strong>සුරකින්න:</strong> ලබාගත් දිනය තෝරා 'Add Asset' ඔබන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_asset" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">புதிய சொத்தைச் சேர்த்தல்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>விவரங்கள்:</strong> சொத்தின் பெயர் மற்றும் வரிசை எண்ணை உள்ளிடவும்.</li>
                                        <li><strong>நிலை:</strong> மதிப்பு மற்றும் நிலையை (Available/In Use) அமைக்கவும்.</li>
                                        <li><strong>ஒதுக்கீடு:</strong> தேவைப்பட்டால் ஒரு பணியாளருக்கு ஒதுக்கலாம்.</li>
                                        <li><strong>சேமி:</strong> தேதியைத் தேர்ந்தெடுத்து சேமிக்கவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <form method="post" id="data_form" class="form-horizontal">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="name">Asset Name</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom b_input" name="name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="serial">Serial Number</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Serial Number"
                                   class="form-control margin-bottom" name="serial">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="qty">Quantity</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Quantity"
                                   class="form-control margin-bottom" name="qty" value="1">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="value">Value</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Value"
                                   class="form-control margin-bottom" name="value" value="0.00">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="status">Status</label>
                        <div class="col-sm-6">
                            <select name="status" class="form-control">
                                <option value="Available">Available</option>
                                <option value="In Use">In Use</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Lost">Lost</option>
                            </select>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="assigned_to">Assign To (Optional)</label>
                        <div class="col-sm-6">
                            <select name="assigned_to" class="form-control select-box">
                                <option value="">None</option>
                                <?php foreach ($employees as $emp) { ?>
                                    <option value="<?php echo $emp['id'] ?>"><?php echo $emp['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="date_acquired">Date Acquired</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="date_acquired"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="note">Note</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="note" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Add Asset" data-loading-text="Adding...">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#submit-data").on("click", function (e) {
        e.preventDefault();
        var o_data =  $("#data_form").serialize();
        var action_url = baseurl + 'assetmanager/add';
        addObject(o_data, action_url);
    });
</script>
