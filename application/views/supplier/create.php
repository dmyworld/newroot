<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add New supplier Details') ?></h5>

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="card bg-light border-light mb-3">
                <div class="card-header font-weight-bold" data-toggle="collapse" href="#helpGuide" role="button" aria-expanded="false" aria-controls="helpGuide" style="cursor: pointer;">
                    <i class="fa fa-book"></i> User Guide / උපදෙස් / பயனர் வழிகாட்டி <i class="fa fa-angle-down float-right"></i>
                </div>
                <div class="collapse" id="helpGuide">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="guideTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="eng-tab" data-toggle="tab" href="#eng" role="tab">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sin-tab" data-toggle="tab" href="#sin" role="tab">සිංහල</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tam-tab" data-toggle="tab" href="#tam" role="tab">தமிழ்</a>
                            </li>
                        </ul>
                        <div class="tab-content border-left border-right border-bottom p-3 bg-white" id="guideTabContent">
                            <div class="tab-pane fade show active" id="eng" role="tabpanel">
                                <h6 class="text-primary mt-2">How to Add a Supplier</h6>
                                <ol>
                                    <li><strong>Basic Details:</strong> Enter Name, Company Name, and Contact Info.</li>
                                    <li><strong>Address:</strong> Provide full billing/shipping address.</li>
                                    <li><strong>Tax Info:</strong> Enter Tax ID for tax calculations.</li>
                                    <li><strong>Purpose:</strong> Required for creating Purchase Orders and tracking stock sources.</li>
                                </ol>
                                <p class="text-muted"><small><strong>Note:</strong> Supplier details are required for Purchase Orders. Accurate currency settings help in foreign exchange calculations.</small></p>
                            </div>
                            <div class="tab-pane fade" id="sin" role="tabpanel">
                                <h6 class="text-primary mt-2">සැපයුම්කරුවෙකු (Supplier) එකතු කරන ආකාරය</h6>
                                <ol>
                                    <li><strong>මූලික විස්තර:</strong> නම, සමාගමේ නම සහ සම්බන්ධතා තොරතුරු ඇතුළත් කරන්න.</li>
                                    <li><strong>ලිපිනය:</strong> සම්පූර්ණ බිල්පත්/නැව්ගත කිරීමේ ලිපිනය සපයන්න.</li>
                                    <li><strong>බදු තොරතුරු:</strong> බදු ගණනය කිරීම් සඳහා බදු හැඳුනුම්පත (Tax ID) ඇතුළත් කරන්න.</li>
                                    <li><strong>අරමුණ:</strong> මිලදී ගැනීමේ ඇණවුම් (Purchase Orders) නිර්මාණය කිරීමට සහ තොග මූලාශ්‍ර නිරීක්ෂණය කිරීමට අවශ්‍ය වේ.</li>
                                </ol>
                                <p class="text-muted"><small><strong>සටහන:</strong> මිලදී ගැනීමේ ඇණවුම් සඳහා සැපයුම්කරුගේ විස්තර අවශ්‍ය වේ.</small></p>
                            </div>
                            <div class="tab-pane fade" id="tam" role="tabpanel">
                                <h6 class="text-primary mt-2">சப்ளையரை எவ்வாறு சேர்ப்பது</h6>
                                <ol>
                                    <li><strong>அடிப்படை விவரங்கள்:</strong> பெயர், நிறுவனத்தின் பெயர் மற்றும் தொடர்புத் தகவலை உள்ளிடவும்.</li>
                                    <li><strong>முகவரி:</strong> முழு பில்லிங்/ஷிப்பிங் முகவரியை வழங்கவும்.</li>
                                    <li><strong>வரி தகவல்:</strong> வரி கணக்கீடுகளுக்கு வரி அடையாளத்தை (Tax ID) உள்ளிடவும்.</li>
                                    <li><strong>நோக்கம்:</strong> கொள்முதல் ஆர்டர்களை உருவாக்குவதற்கும் பங்கு மூலங்களைக் கண்காணிப்பதற்கும் தேவை.</li>
                                </ol>
                                <p class="text-muted"><small><strong>குறிப்பு:</strong> கொள்முதல் ஆர்டர்களுக்கு சப்ளையர் விவரங்கள் தேவை.</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" id="data_form" class="form-horizontal">
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Name"
                               class="form-control margin-bottom required" name="name">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Company') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Company"
                               class="form-control margin-bottom" name="company">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="phone"><?php echo $this->lang->line('Phone') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="phone"
                               class="form-control margin-bottom  required" name="phone">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="email"><?php echo $this->lang->line('Email') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="email"
                               class="form-control margin-bottom required" name="email">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="address"><?php echo $this->lang->line('Address') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="address"
                               class="form-control margin-bottom" name="address">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="city"><?php echo $this->lang->line('City') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="city"
                               class="form-control margin-bottom" name="city">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="region"><?php echo $this->lang->line('Region') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Region"
                               class="form-control margin-bottom" name="region">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="country"><?php echo $this->lang->line('Country') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Country"
                               class="form-control margin-bottom" name="country">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="PostBox"
                               class="form-control margin-bottom" name="postbox">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('TAX') ?> ID</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="TAX"
                               class="form-control margin-bottom" name="taxid">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="supplier/addsupplier" id="action-url">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

