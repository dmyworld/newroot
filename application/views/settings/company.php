<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Company Details') ?></h5>
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
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #607D8B;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideSet" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideSet" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_set">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_set">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_set">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_set" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Company Settings</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Details:</strong> Update company name, address, and contact info (appears on invoices).</li>
                                        <li><strong>Logo:</strong> Upload a new company logo (recommended 500x200px).</li>
                                        <li><strong>Data Share:</strong> Enable product data sharing between locations if needed.</li>
                                    </ol>
                                </div>
                                <div id="sin_set" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">සමාගමේ සැකසුම්</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>විස්තර:</strong> සමාගමේ නම, ලිපිනය සහ සම්බන්ධතා තොරතුරු යාවත්කාලීන කරන්න (ඉන්වොයිසිවල දිස්වේ).</li>
                                        <li><strong>ලාංඡනය:</strong> නව සමාගම් ලාංඡනයක් උඩුගත කරන්න (නිර්දේශිත 500x200px).</li>
                                        <li><strong>දත්ත හුවමාරුව:</strong> අවශ්‍ය නම් ස්ථාන අතර නිෂ්පාදන දත්ත හුවමාරුව සක්‍රීය කරන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_set" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">நிறுவன அமைப்புகள்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>விவரங்கள்:</strong> நிறுவனத்தின் பெயர், முகவரி மற்றும் தொடர்புத் தகவலைப் புதுப்பிக்கவும்.</li>
                                        <li><strong>லೋಗோ:</strong> புதிய நிறுவன லோகோவை பதிவேற்றவும் (பரிந்துரைக்கப்பட்டது 500x200px).</li>
                                        <li><strong>தரவு பகிர்வு:</strong> தேவைப்பட்டால் இருப்பிடங்களுக்கு இடையே தயாரிப்பு தரவு பகிர்வை இயக்கவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <div class="row">

                    <div class="col-6 border-right-blue">
                        <form method="post" id="product_action" class="form-horizontal">


                            <input type="hidden" name="id" value="<?php echo $company['id'] ?>">


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Company Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom  required" name="name"
                                           value="<?php echo $company['cname'] ?>">
                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="address"
                                           class="form-control margin-bottom  required" name="address"
                                           value="<?php echo $company['address'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="city"><?php echo $this->lang->line('City') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="city"
                                           class="form-control margin-bottom  required" name="city"
                                           value="<?php echo $company['city'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="city"><?php echo $this->lang->line('Region') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="city"
                                           class="form-control margin-bottom  required" name="region"
                                           value="<?php echo $company['region'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="country"><?php echo $this->lang->line('Country') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Country"
                                           class="form-control margin-bottom  required" name="country"
                                           value="<?php echo $company['country'] ?>">
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="PostBox"
                                           class="form-control margin-bottom  required" name="postbox"
                                           value="<?php echo $company['postbox'] ?>">
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="phone"
                                           class="form-control margin-bottom  required" name="phone"
                                           value="<?php echo $company['phone'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="email"
                                           class="form-control margin-bottom  required" name="email"
                                           value="<?php echo $company['email'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Tax') ?> ID </label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="TAX ID"
                                           class="form-control margin-bottom" name="taxid"
                                           value="<?php echo $company['taxid'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-12"><label class=" col-form-label"
                                                              for="data_share">Product Data Sharing with Other
                                        Locations</label><select name="data_share" class="form-control">

                                        <?php switch (BDATA) {
                                            case '1' :
                                                echo '<option value="1">** Yes **</option>';
                                                break;
                                            case '0' :
                                                echo '<option value="0">** No **</option>';
                                                break;

                                        } ?>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>


                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" id="company_update" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Update Company') ?>"
                                           data-loading-text="Updating...">
                                </div>
                            </div>


                        </form>

                    </div>
                    <div class="col-6">
                        <div class="card card-block">
                            <div id="notify" class="alert alert-success" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>

                                <div class="message"></div>
                            </div>
                            <form method="post" id="product_action" class="form-horizontal">
                                <div class="grid_3 grid_4">

                                    <h5><?php echo $this->lang->line('Company Logo') ?></h5>
                                    <hr>


                                    <input type="hidden" name="id" value="<?php echo $company['id'] ?>">
                                    <div class="ibox-content no-padding border-left-right">
                                        <img alt="image" id="dpic" class="col"
                                             src="<?php echo base_url('userfiles/company/') . $company['logo'] . '?t=' . rand(5, 99); ?>">
                                    </div>

                                    <hr>
                                    <p>
                                        <label for="fileupload"><?php echo $this->lang->line('Change Company Logo') ?></label><input
                                                id="fileupload" type="file"
                                                name="files[]"></p>
                                    <pre>Recommended logo size is 500x200px.</pre>
                                    <div id="progress" class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%"
                                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#company_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/company';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(function () {
        'use strict';
        var url = '<?php echo base_url() ?>settings/companylogo?id=<?php echo $company['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/company/' + data.result + '?' + new Date().getTime());


            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

</script>