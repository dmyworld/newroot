<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>
    <div class="card card-block ">
        <form method="post" id="data_form" class="card-body">
            <!-- User Guide -->
            <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #20c997;">
                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideGrade" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                    <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                </div>
                <div id="guideGrade" class="collapse">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_grade">🇬🇧 English</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_grade">🇱🇰 Sinhala</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_grade">IN Tamil</a></li>
                        </ul>
                        <div class="tab-content border p-2 bg-white">
                            <div id="eng_grade" class="tab-pane active">
                                <h6 class="text-primary mt-1 small">Grade Definition</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>Standards:</strong> Set QC Thresholds (Min/Max %) for quality checks.</li>
                                    <li><strong>Rules:</strong> Define 'Rejection Rules' for inspectors.</li>
                                    <li><strong>Usage:</strong> This grade will be applied to timber stock.</li>
                                </ol>
                            </div>
                            <div id="sin_grade" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">ශ්‍රේණි අර්ථ දැක්වීම</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>ප්‍රමිති:</strong> තත්ත්ව පරීක්ෂා සඳහා QC සීමාවන් සකසන්න.</li>
                                    <li><strong>නීති:</strong> පරීක්ෂකයන් සඳහා ප්‍රතික්ෂේප කිරීමේ නීති (Rejection Rules) අර්ථ දක්වන්න.</li>
                                    <li><strong>භාවිතය:</strong> මෙම ශ්‍රේණිය දැව තොග සඳහා යොදනු ලැබේ.</li>
                                </ol>
                            </div>
                            <div id="tam_grade" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">தர வரையறை</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>தரநிலைகள்:</strong> தர சோதனைகளுக்கு QC வரம்புகளை அமைக்கவும்.</li>
                                    <li><strong>விதிகள்:</strong> நிராகரிப்பு விதிகளை (Rejection Rules) வரையறுக்கவும்.</li>
                                    <li><strong>பயன்பாடு:</strong> இந்த தரம் மர இருப்புகளுக்கு பயன்படுத்தப்படும்.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End User Guide -->
            <h5>Add Timber Grade</h5>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="grade_name">Grade Name</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Grade Name"
                           class="form-control margin-bottom round required" name="grade_name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="qc_min">QC Threshold Min (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Min"
                           class="form-control margin-bottom round required" name="qc_min">
                </div>
                <label class="col-sm-2 col-form-label" for="qc_max">QC Threshold Max (%)</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Max"
                           class="form-control margin-bottom round required" name="qc_max">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="rejection_desc">Rejection Rules</label>
                <div class="col-sm-6">
                    <textarea placeholder="Describe rejection criteria..."
                           class="form-control margin-bottom round" name="rejection_desc" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Add Grade" data-loading-text="Adding...">
                    <input type="hidden" value="timber_grades/create" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
