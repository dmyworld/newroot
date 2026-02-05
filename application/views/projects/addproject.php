<link rel="stylesheet" type="text/css"
      href="<?= assets_url() ?>app-assets/vendors/css/calendars/fullcalendar.min.css?v=<?= APPVER ?>">
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrapValidator.min.css?v=<?= APPVER ?>" rel="stylesheet"/>
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrap-colorpicker.min.css?v=<?= APPVER ?>"
      rel="stylesheet"/>
<!-- Custom css  -->
<link href="<?php echo assets_url(); ?>assets/c_portcss/custom.css?v=<?= APPVER ?>" rel="stylesheet"/>

<script src='<?php echo assets_url(); ?>assets/c_portjs/bootstrap-colorpicker.min.js?v=<?= APPVER ?>'></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/moment.min.js?v=<?= APPVER ?>"></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/fullcalendar.min.js?v=<?= APPVER ?>"></script>
<script src='<?php echo assets_url(); ?>assets/c_portjs/main.js?v=<?= APPVER ?>'></script>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Project') ?></h5>
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
                                    <h6 class="text-primary mt-2">How to Add a Project</h6>
                                    <ol>
                                        <li><strong>Project Details:</strong> Enter Title, Status, and Budget.</li>
                                        <li><strong>Customer:</strong> Assign to a client to enable their portal view (if 'Client View' is enabled).</li>
                                        <li><strong>Timeline:</strong> Set Start and End dates for scheduling.</li>
                                        <li><strong>Team:</strong> Assign employees to the project.</li>
                                        <li><strong>Tagging:</strong> Use tags for filtering.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>Note:</strong> Enabling 'Client View' allows the customer to track project progress and milestones via their portal.</small></p>
                                </div>
                                <div class="tab-pane fade" id="sin" role="tabpanel">
                                    <h6 class="text-primary mt-2">ව්‍යාපෘතියක් එකතු කරන ආකාරය</h6>
                                    <ol>
                                        <li><strong>ව්‍යාපෘති විස්තර:</strong> මාතෘකාව, තත්ත්වය සහ අයවැය ඇතුළත් කරන්න.</li>
                                        <li><strong>පාරිභෝගිකයා:</strong> පාරිභෝගිකයෙකුට පවරන්න (Client View සක්‍රීය නම් ඔවුන්ට මෙය දැකගත හැක).</li>
                                        <li><strong>කාලරාමුව:</strong> ආරම්භක සහ අවසන් දිනයන් සකසන්න.</li>
                                        <li><strong>කණ්ඩායම:</strong> සේවකයින් ව්‍යාපෘතියට අනුයුක්ත කරන්න.</li>
                                        <li><strong>Tagging:</strong> පෙරීම සඳහා ටැග් භාවිතා කරන්න.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>සටහන:</strong> 'Client View' සක්‍රිය කිරීමෙන් පාරිභෝගිකයාට ව්‍යාපෘතියේ ප්‍රගතිය ඔවුන්ගේ portal එක හරහා දැකගත හැක.</small></p>
                                </div>
                                <div class="tab-pane fade" id="tam" role="tabpanel">
                                    <h6 class="text-primary mt-2">திட்டத்தை எவ்வாறு சேர்ப்பது</h6>
                                    <ol>
                                        <li><strong>திட்ட விவரங்கள்:</strong> தலைப்பு, நிலை மற்றும் பட்ஜெட்டை உள்ளிடவும்.</li>
                                        <li><strong>வாடிக்கையாளர்:</strong> வாடிக்கையாளருக்கு ஒதுக்கவும் (Client View இயக்கப்பட்டிருந்தால் அவர்கள் இதைக் காணலாம்).</li>
                                        <li><strong>காலக்கெடு:</strong> தொடக்க மற்றும் முடிவு தேதிகளை அமைக்கவும்.</li>
                                        <li><strong>குழு:</strong> திட்டத்திற்கு ஊழியர்களை நியமிக்கவும்.</li>
                                        <li><strong>Tagging:</strong> வடிகட்டுவதற்கு குறிச்சொற்களைப் பயன்படுத்தவும்.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>குறிப்பு:</strong> 'Client View'-ஐ இயக்குவதன் மூலம் வாடிக்கையாளர் திட்டத்தின் முன்னேற்றத்தை அவர்களின் போர்டல் வழியாகக் கண்காணிக்க முடியும்.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="post" id="data_form" class="form-horizontal">

                    <div class="form-group row bg-purple bg-lighten-4 ">

                        <div class="col-md-10"><label class="col col-form-label"
                                                      for="name"><?php echo $this->lang->line('Title') ?></label>
                            <input type="text" placeholder="Project Title"
                                   class="form-control mb-1 required" name="name">
                        </div>
                    </div>

                    <div class="form-group row">


                        <div class="col-md-4 bg-blue bg-lighten-4 rounded"><label class="col col-form-label"
                                                                                  for="name"><?php echo $this->lang->line('Status') ?></label>
                            <select name="status" class="form-control mb-1">
                                <?php echo " <option value='Waiting'>" . $this->lang->line('Waiting') . "</option>
                            <option value='Pending'>" . $this->lang->line('Pending') . "</option>
                            <option value='Terminated'>" . $this->lang->line('Terminated') . "</option>
                            <option value='Finished'>" . $this->lang->line('Finished') . "</option>
                            <option value='Progress'>" . $this->lang->line('Progress') . "</option>"; ?>
                            </select>
                        </div>


                        <div class="col-md-4 border-blue-grey rounded"><label class="col col-form-label"
                                                                              for="progress"><?php echo $this->lang->line('Progress') ?>
                                (in %)</label>
                            <input type="range" min="0" max="100" value="0" class="slider" id="progress"
                                   name="progress">
                            <p><span id="prog"></span></p>

                        </div>


                        <div class="col-md-4 bg-blue bg-lighten-4 rounded"><label class="col col-form-label"
                                                                                  for="pay_cat"><?php echo $this->lang->line('Priority') ?></label>
                            <select name="priority" class="form-control mb-1">
                                <option value='Low'>Low</option>
                                <option value='Medium'>Medium</option>
                                <option value='High'>High</option>
                                <option value='Urgent'>Urgent</option>
                            </select>


                        </div>
                    </div>
                    <div class="form-group row">


                        <div class="col-md-4 border-blue-grey rounded"><label class="col col-form-label"
                                                                              for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>
                            <select name="customer" class="form-control mb-1" id="customer_statement">
                                <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                            </select>


                        </div>


                        <div class="col-md-4  rounded bg-blue bg-lighten-4"><label class="col col-form-label"
                                                                                   for="name"><?php echo $this->lang->line('Customer Can View') ?></label>
                            <select name="customerview" class="form-control mb-1">
                                <option value='true'>True</option>
                                <option value='false'>False</option>
                            </select>
                        </div>


                        <div class="col-md-4 border-blue rounded">
                            <label class="col col-form-label"
                                   for="name"><?php echo $this->lang->line('Customer Can Comment') ?></label>
                            <select name="customercomment" class="form-control mb-1">
                                <option value='true'>True</option>
                                <option value='false'>False</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">


                        <div class="col-md-4 rounded bg-blue bg-lighten-4"><label class="col col-form-label"
                                                                                  for="worth"><?php echo $this->lang->line('Budget') ?></label>
                            <input type="text" placeholder="Budget" onkeypress="return isNumber(event)"
                                   class="form-control mb-1  required" name="worth" value="0">
                        </div>

                        <div class="col-md-4 border-blue rounded"><label class="control-label"
                                                                         for="edate"><?php echo $this->lang->line('Start Date') ?></label>
                            <input type="text" class="form-control  required"
                                   placeholder="Start Date" name="sdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>


                        <div class="col-md-4 rounded bg-blue bg-lighten-4"><label class="control-label"
                                                                                  for="edate"><?php echo $this->lang->line('Due Date') ?></label>
                            <input type="text" id="pdate_2" class="form-control  required edate"
                                   placeholder="End Date" name="edate"
                                   autocomplete="false"
                                   value="<?php echo dateformat(date('Y-m-d', strtotime('+30 days', strtotime(date('Y-m-d'))))) ?>">
                        </div>


                    </div>


                    <div class="form-group row">


                        <div class="col-md-8 rounded bg-grey-blue bg-lighten-4"><label class="col col-form-label"
                                                                                       for="employee[]"><?php echo $this->lang->line('Assign to') ?></label>
                            <select name="employee[]" class="form-control mb-1 required select-box" multiple="multiple">
                                <?php
                                foreach ($emp as $row) {
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>


                        <div class="col-md-4   border-blue rounded "><label class="col-form-label"
                                                                            for="phase"><?php echo $this->lang->line('Phase') ?></label>
                            <input type="text" placeholder="Phase A,B,C"
                                   class="form-control mb-1  required" name="phase">
                        </div>
                    </div>

                    <div class="form-group row">


                        <div class="col-md-4 border-blue rounded"><label class="col col-form-label"
                                                                         for="name">Link to calendar</label>
                            <select name="link_to_cal" class="form-control mb-1" id="link_to_cal">
                                <option value='0'>No</option>
                                <option value='1'>Mark Deadline(End Date)</option>
                                <option value='2'>Mark Start to End Date</option>
                            </select>
                        </div>


                        <div class="col-md-8 rounded bg-blue bg-lighten-4"><label class="col col-form-label"
                                                                                  for="tags"><?php echo $this->lang->line('Tags') ?></label>
                            <input type="text" placeholder="Tags"
                                   class="form-control margin-bottom  required" name="tags">
                        </div>
                    </div>

                    <div id="hidden_div" class="row form-group" style="display: none">
                        <label class="col-md-2 control-label" for="color">Color</label>
                        <div class="col-md-4">
                            <input id="color" name="color" type="text" class="form-control input-md"
                                   readonly="readonly" value="#265872"/>
                            <span class="help-block">Click to pick a color</span>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="content"><?php echo $this->lang->line('Note') ?></label>

                        <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name">Task Communication</label>

                        <div class="col-sm-4">
                            <select name="ptype" class="form-control">
                                <option value='0'>No</option>
                                <option value='1'>Emails to team</option>
                                <option value='2'>Emails to team, customer</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="projects/addproject" id="action-url">

                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(function () {
            $('.select-box').select2();

            $('.summernote').summernote({
                height: 250,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen', ['fullscreen']],
                    ['codeview', ['codeview']]
                ]
            });
        });

        $("#customer_statement").select2({
            minimumInputLength: 4,
            tags: [],
            ajax: {
                url: baseurl + 'search/customer_select',
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (customer) {
                    return {
                        customer: customer,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });

        $('.edate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
        var slider = $('#progress');
        var textn = $('#prog');
        textn.text(slider.val() + '%');
        $(document).on('change', slider, function (e) {
            e.preventDefault();
            textn.text($('#progress').val() + '%');

        });
    </script>