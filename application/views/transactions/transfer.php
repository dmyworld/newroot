<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters">
                <div class="col-md-12 text-center pt-4 pb-4">
                    <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('Add New Transfer') ?></h2>
                    <p class="text-white-50 mb-0">Internal Fund Transfers</p>
                </div>
            </div>
        </div>

        <div class="card-body p-5">
             <!-- User Guide -->
            <div class="card collapsed-card mb-4" style="border: 1px solid #ddd; border-left: 5px solid #FFC107;">
                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideTransfer" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                    <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                </div>
                <div id="guideTransfer" class="collapse">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_trans">🇬🇧 English</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_trans">🇱🇰 Sinhala</a></li>
                            <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_trans">IN Tamil</a></li>
                        </ul>
                        <div class="tab-content border p-2 bg-white">
                            <div id="eng_trans" class="tab-pane active">
                                <h6 class="text-primary mt-1 small">Fund Transfer Steps</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>Source:</strong> Select the 'From Account' (Account to deduct funds from).</li>
                                    <li><strong>Destination:</strong> Select the 'To Account' (Account to receive funds).</li>
                                    <li><strong>Amount:</strong> Enter the exact amount to transfer.</li>
                                    <li><strong>Confirm:</strong> Click 'Add transaction' to process.</li>
                                </ol>
                            </div>
                            <div id="sin_trans" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">මුදල් හුවමාරු කිරීම</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>යවන ගිණුම:</strong> මුදල් අඩු විය යුතු ගිණුම (From Account) තෝරන්න.</li>
                                    <li><strong>ලැබෙන ගිණුම:</strong> මුදල් බැර විය යුතු ගිණුම (To Account) තෝරන්න.</li>
                                    <li><strong>මුදල:</strong> මාරු කළ යුතු මුදල නිවැරදිව ඇතුලත් කරන්න.</li>
                                    <li><strong>තහවුරු කිරීම:</strong> 'Add transaction' ක්ලික් කරන්න.</li>
                                </ol>
                            </div>
                            <div id="tam_trans" class="tab-pane fade">
                                <h6 class="text-primary mt-1 small">நிதி பரிமாற்ற படிகள்</h6>
                                <ol class="small pl-3 mb-0">
                                    <li><strong>அனுப்புநர்:</strong> பணத்தை எடுக்கும் கணக்கை (From Account) தேர்ந்தெடுக்கவும்.</li>
                                    <li><strong>பெறுநர்:</strong> பணத்தைப் பெறும் கணக்கை (To Account) தேர்ந்தெடுக்கவும்.</li>
                                    <li><strong>தொகை:</strong> மாற்ற வேண்டிய தொகையை உள்ளிடவும்.</li>
                                    <li><strong>உறுதிப்படுத்தல்:</strong> 'Add transaction'-ஐ கிளிக் செய்யவும்.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End User Guide -->
            <form method="post" id="data_form" class="form-horizontal">

                <div class="row">
                    <div class="col-md-8 offset-md-2">
                         <div class="alert alert-light border-0 shadow-sm mb-4" role="alert" style="background: #fdfdfd; border-left: 4px solid #FFC107 !important;">
                            <i class="fa fa-info-circle text-warning mr-2"></i> Transfer funds between your business accounts securely.
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-sm-4 col-form-label text-right font-weight-bold" for="pay_acc">
                                <?php echo $this->lang->line('From Account') ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fa fa-sign-out text-danger"></i></span>
                                    </div>
                                    <select name="pay_acc" class="form-control" style="height: 45px;">
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
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-sm-4 col-form-label text-right font-weight-bold" for="pay_acc2">
                                <?php echo $this->lang->line('To Account') ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fa fa-sign-in text-success"></i></span>
                                    </div>
                                    <select name="pay_acc2" class="form-control" style="height: 45px;">
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
                        </div>


                        <div class="form-group row mb-5">
                            <label class="col-sm-4 col-form-label text-right font-weight-bold" for="amount">
                                <?php echo $this->lang->line('Amount') ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                     <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fa fa-money"></i></span>
                                    </div>
                                    <input type="text" placeholder="0.00" class="form-control required" name="amount" style="height: 45px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-4">
                                <input type="submit" id="submit-data" class="btn btn-primary btn-lg btn-block shadow-sm"
                                    value="<?php echo $this->lang->line('Add transaction') ?>"
                                    data-loading-text="Adding...">
                                <input type="hidden" value="transactions/save_transfer" id="action-url">
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

