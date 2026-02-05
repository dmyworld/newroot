<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Add Job Site</h5>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
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
                                    <h6 class="text-primary mt-2">How to Add a Job Site</h6>
                                    <ol>
                                        <li><strong>Select Customer:</strong> Choose the client for whom this job site is being created.</li>
                                        <li><strong>Site Name:</strong> Enter a unique name for the job site (e.g., "Main Warehouse").</li>
                                        <li><strong>Address Details:</strong> Fill in the full address, city, region, and country.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>Note:</strong> This site will be available for selection when creating Invoices or Quotes for this customer.</small></p>
                                </div>
                                <div class="tab-pane fade" id="sin" role="tabpanel">
                                    <h6 class="text-primary mt-2">Job Site එකක් එකතු කරන ආකාරය</h6>
                                    <ol>
                                        <li><strong>පාරිභෝගිකයා තෝරන්න:</strong> මෙම Job Site එක අදාළ වන පාරිභෝගිකයා තෝරන්න.</li>
                                        <li><strong>පරිශ්‍රයේ නම:</strong> Job Site එක සඳහා අනන්‍ය නමක් ඇතුළත් කරන්න (උදා: "ප්‍රධාන ගබඩාව").</li>
                                        <li><strong>ලිපිනය විස්තර:</strong> සම්පූර්ණ ලිපිනය, නගරය, පළාත සහ රට ඇතුළත් කරන්න.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>සටහන:</strong> මෙම පාරිභෝගිකයා සඳහා ඉන්වොයිස් හෝ මිල ගණන් (Quotes) සැකසීමේදී මෙම ස්ථානය තෝරා ගැනීමට හැකි වනු ඇත.</small></p>
                                </div>
                                <div class="tab-pane fade" id="tam" role="tabpanel">
                                    <h6 class="text-primary mt-2">Job Site-ஐ எவ்வாறு சேர்ப்பது</h6>
                                    <ol>
                                        <li><strong>வாடிக்கையாளரைத் தேர்ந்தெடுக்கவும்:</strong> இந்த Job Site உருவாக்கப்படும் வாடிக்கையாளரைத் தேர்வு செய்யவும்.</li>
                                        <li><strong>தளத்தின் பெயர்:</strong> தளத்திற்கான தனித்துவமான பெயரை உள்ளிடவும் (எ.கா: "தலைமை கிடங்கு").</li>
                                        <li><strong>முகவரி விவரங்கள்:</strong> முழு முகவரி, நகரம், பிராந்தியம் மற்றும் நாட்டை உள்ளிடவும்.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>குறிப்பு:</strong> இந்த வாடிக்கையாளருக்கான இன்வாய்ஸ்கள் அல்லது மேற்கோள்களை உருவாக்கும் போது இந்த இடத்தை தேர்ந்தெடுக்கலாம்.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" id="data_form" class="form-horizontal">
                    <input type="hidden" id="action-url" value="jobsites/create">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="customer_id">Customer</label>
                        <div class="col-sm-6">
                            <select name="customer_id" class="form-control select-box" id="customer_id">
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $customer) { ?>
                                    <option value="<?php echo $customer['id'] ?>"><?php echo $customer['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="name">Site Name</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Site Name"
                                   class="form-control margin-bottom" name="name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="address">Address</label>
                        <div class="col-sm-6">
                            <textarea placeholder="Address"
                                   class="form-control margin-bottom" name="address"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="city">City</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="City"
                                   class="form-control margin-bottom" name="city">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="region">Region</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="country">Country</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="postbox">Postbox</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Postbox"
                                   class="form-control margin-bottom" name="postbox">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Add Site" data-loading-text="Adding...">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        // Select2 or similar init if needed
    });
</script>
