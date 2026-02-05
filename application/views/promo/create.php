<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Promo') ?></h5>
            <hr>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <!-- User Guide -->
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #ffc107;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guidePromo" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guidePromo" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_promo">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_promo">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_promo">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_promo" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Creating Promo Codes</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Code:</strong> Enter a unique code or keep the auto-generated one.</li>
                                        <li><strong>Value:</strong> Set discount 'Amount' and 'Qty' (number of times usable).</li>
                                        <li><strong>Tracking:</strong> 'Link to Account' to track usage in a specific ledger account.</li>
                                        <li><strong>Expiry:</strong> Set the 'Valid' date for expiration.</li>
                                    </ol>
                                </div>
                                <div id="sin_promo" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">ප්‍රවර්ධන කේත (Promo Codes) සැකසීම</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>කේතය:</strong> නව කේතයක් ඇතුලත් කරන්න හෝ තිබෙන එක භාවිතා කරන්න.</li>
                                        <li><strong>වටිනාකම:</strong> වට්ටම් මුදල (Amount) සහ ප්‍රමාණය (Qty) සකසන්න.</li>
                                        <li><strong>ගිණුම්:</strong> ගිණුමකට සම්බන්ධ කිරීමට 'Link to Account' හි 'Yes' තෝරන්න.</li>
                                        <li><strong>කල් ඉකුත්වීම:</strong> වලංගු දිනය (Valid) තෝරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_promo" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">விளம்பரக் குறியீடுகளை உருவாக்குதல்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>குறியீடு:</strong> குறியீட்டை உள்ளிடவும் அல்லது தானாக உருவானதைப் பயன்படுத்தவும்.</li>
                                        <li><strong>மதிப்பு:</strong> தள்ளுபடித் தொகை மற்றும் அளவை (Qty) அமைக்கவும்.</li>
                                        <li><strong>இணைப்பு:</strong> கணக்குடன் இணைக்க 'Link to Account'-இல் 'Yes' ஐத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>காலாவதி:</strong> செல்லுபடியாகும் தேதியை (Valid) அமைக்கவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <form method="post" id="data_form" class="form-horizontal">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="code"><?php echo $this->lang->line('Code') ?></label>

                        <div class="col-sm-4">
                            <input type="text" placeholder="Code"
                                   class="form-control margin-bottom  required" name="code"
                                   value="<?php echo $this->coupon->generate(8) ?>">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="amount"><?php echo $this->lang->line('Amount') ?></label>

                        <div class="col-sm-4">
                            <input type="text" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="amount" value="0"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="qty"><?php echo $this->lang->line('Qty') ?></label>

                        <div class="col-sm-2">
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="qty" value="1">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="valid"><?php echo $this->lang->line('Valid') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required"
                                   placeholder="Start Date" name="valid"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                       for="link_ac"><?php echo $this->lang->line('Link to account') ?></label>
                        <div class="col-sm-6">
                            <fieldset>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="link_ac" id="customRadio1"
                                           value="yes" checked="">
                                    <label class="custom-control-label"
                                           for="customRadio1"><?php echo $this->lang->line('Yes') ?> &nbsp;</label>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="link_ac" id="customRadio2"
                                           value="no">
                                    <label class="custom-control-label"
                                           for="customRadio2"><?php echo $this->lang->line('No') ?></label>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_acc"><?php echo $this->lang->line('Account') ?></label>

                        <div class="col-sm-4">
                            <select name="pay_acc" class="form-control">
                                <?php
                                foreach ($accounts as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['acn'];
                                    $holder = $row['holder'];
                                    echo "<option value='$cid'>$acn - $holder</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="note"><?php echo $this->lang->line('Note') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Short Note"
                                   class="form-control margin-bottom" name="note">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="promo/create" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>