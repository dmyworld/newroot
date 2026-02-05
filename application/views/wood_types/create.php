<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <!-- User Guide -->
            <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #795548;">
                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideWood" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                    <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                </div>
                <div id="guideWood" class="collapse">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_wood">🇬🇧 English</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_wood">🇱🇰 Sinhala</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_wood">IN Tamil</a></li>
                        </ul>
                        <div class="tab-content border p-2 bg-white">
                            <div id="eng_wood" class="tab-pane active">
                                <h6 class="text-primary mt-1 small">Wood Type Definition</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>Specs:</strong> Enter 'Density' (kg/m³) and 'Moisture' limits (Min/Max %).</li>
                                    <li><strong>Physics:</strong> Set 'Shrinkage Coeff' for production calculations.</li>
                                    <li><strong>Info:</strong> Add a description for reference.</li>
                                </ol>
                            </div>
                            <div id="sin_wood" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">ලී වර්ග අර්ථ දැක්වීම</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>පිරිවිතර:</strong> ඝනත්වය (Density) සහ තෙතමනය (Moisture) සීමා ඇතුලත් කරන්න.</li>
                                    <li><strong>භෞතික:</strong> නිෂ්පාදන ගණනය කිරීම් සඳහා හැකිලීමේ සංගුණකය (Shrinkage) සකසන්න.</li>
                                    <li><strong>විස්තර:</strong> අවශ්‍ය නම් විස්තරයක් එක් කරන්න.</li>
                                </ol>
                            </div>
                            <div id="tam_wood" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">மர வகை வரையறை</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>விவரக்குறிப்புகள்:</strong> அடர்த்தி மற்றும் ஈரப்பத வரம்புகளை உள்ளிடவும்.</li>
                                    <li><strong>இயற்பியல்:</strong> உற்பத்தி கணக்கீடுகளுக்கு சுருக்கக் குணகத்தை (Shrinkage) அமைக்கவும்.</li>
                                    <li><strong>தகவல்:</strong> குறிப்புக்கு ஒரு விளக்கத்தைச் சேர்க்கவும்.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End User Guide -->
            <h5>Add Wood Type</h5>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name">Wood Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom round required" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="density">Density (kg/m³)</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Density"
                           class="form-control margin-bottom round required" name="density">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="moisture_min">Moisture Min (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Min"
                           class="form-control margin-bottom round" name="moisture_min">
                </div>
                <label class="col-sm-2 col-form-label" for="moisture_max">Moisture Max (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Max"
                           class="form-control margin-bottom round" name="moisture_max">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="shrinkage">Shrinkage Coeff</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="0.0000"
                           class="form-control margin-bottom round" name="shrinkage">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-6">
                    <textarea placeholder="Description"
                           class="form-control margin-bottom round" name="description" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Add Wood Type" data-loading-text="Adding...">
                    <input type="hidden" value="wood_types/create" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
