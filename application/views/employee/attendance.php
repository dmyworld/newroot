<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <div class="card card-block">
                 <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #E91E63;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideAtt" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideAtt" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_att">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_att">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_att">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_att" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Attendance Management</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Manual Entry:</strong> Add attendance records manually for employees.</li>
                                        <li><strong>Time:</strong> Specify Start and End times precisely.</li>
                                        <li><strong>Date:</strong> Select the date for the attendance record.</li>
                                    </ol>
                                </div>
                                <div id="sin_att" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">පැමිණීමේ කළමනාකරණය</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>ඇතුළත් කිරීම්:</strong> සේවකයින් සඳහා පැමිණීමේ වාර්තා අතින් එක් කරන්න.</li>
                                        <li><strong>වේලාව:</strong> ආරම්භක සහ අවසන් වේලාවන් නිශ්චිතව දක්වන්න.</li>
                                        <li><strong>දිනය:</strong> පැමිණීමේ වාර්තාව සඳහා දිනය තෝරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_att" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">வருகை மேலாண்மை</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>கையேடு நுழைவு:</strong> ஊழியர்களுக்கான வருகைப் பதிவுகளை கைமுறையாகச் சேர்க்கவும்.</li>
                                        <li><strong>நேரம்:</strong> தொடக்க மற்றும் முடிவு நேரங்களைக் குறிப்பிடவும்.</li>
                                        <li><strong>தேதி:</strong> வருகைப் பதிவுக்கான தேதியைத் தேர்ந்தெடுக்கவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->

                <h5><?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Attendance') ?></h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Employees') ?></label>

                    <div class="col-sm-6">
                        <select name="employee[]" class="form-control required select-box" multiple="multiple">
                            <?php
                            foreach ($emp as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="from"><?php echo $this->lang->line('Date') ?></label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control b_input required"
                               placeholder="Start Date" name="adate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="todate"><?php echo $this->lang->line('From') ?></label>

                    <div class="col-sm-2">
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input type="text" class="form-control input-small timepicker1" name="from">
                            <span class="input-group-addon"><i class="icon-clock"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="todate"><?php echo $this->lang->line('To') ?></label>

                    <div class="col-sm-2">
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input type="text" class="form-control input-small timepicker2" name="to">
                            <span class="input-group-addon"><i class="icon-clock"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-3 col-form-label" for="note"><?php echo $this->lang->line('Note') ?></label>

                    <div class="col-sm-8">
                        <input type="text" placeholder="Note"
                               class="form-control margin-bottom b_input" name="note">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="employee/attendance" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.timepicker1').timepicker('setTime', '09:00 AM');
    $('.timepicker2').timepicker('setTime', '05:00 PM');
    $('.select-box').select2();
</script>