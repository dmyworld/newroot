<div>
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="row">
        <div class="col-md-4 ">
            <div class="card card-block card-body">
                <h5><?php echo $this->lang->line('Update Profile Picture') ?></h5>
                <hr>
                <div class="ibox-content no-padding border-left-right">
                    <img alt="profile picture" id="dpic" class="img-responsive col"
                         src="<?php echo base_url('userfiles/employee/') . $user['picture'] ?>">
                </div>
                <hr>
                <p><label for="fileupload"><?php echo $this->lang->line('Change Your Picture') ?></label><input
                            id="fileupload" type="file"
                            name="files[]"></p></div>
            <!-- signature -->

            <div class="card card-block card-body"><h5><?php echo $this->lang->line('Update Your Signature') ?></h5>
                <hr>
                <div class="ibox-content no-padding border-left-right">
                    <img alt="sign_pic" id="sign_pic" class="img-responsive col col"
                         src="<?php echo base_url('userfiles/employee_sign/') . $user['sign'] ?>">
                </div>
                <hr>
                <p>
                    <label for="sign_fileupload"><?php echo $this->lang->line('Change Your Signature') ?></label><input
                            id="sign_fileupload" type="file"
                            name="files[]"></p></div>


        </div>
        <div class="col-md-8">
            <div class="card card-block card-body">
                <form method="post" id="product_action" class="form-horizontal">
                    <div class="grid_3 grid_4">

                        <h5><?php echo $this->lang->line('Update Your Details') ?> (<?php echo $user['username'] ?>
                            )</h5>
                        <hr>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="name"><?php echo $this->lang->line('Name') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Name"
                                       class="form-control margin-bottom  required" name="name"
                                       value="<?php echo $user['name'] ?>">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="address"><?php echo $this->lang->line('Address') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="address"
                                       class="form-control margin-bottom" name="address"
                                       value="<?php echo $user['address'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="city"><?php echo $this->lang->line('City') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="city"
                                       class="form-control margin-bottom" name="city"
                                       value="<?php echo $user['city'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="country"><?php echo $this->lang->line('Country') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Country"
                                       class="form-control margin-bottom" name="country"
                                       value="<?php echo $user['country'] ?>">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="postbox"><?php echo $this->lang->line('Postbox') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Postbox"
                                       class="form-control margin-bottom" name="postbox"
                                       value="<?php echo $user['postbox'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="phone"><?php echo $this->lang->line('Phone') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="phone"
                                       class="form-control margin-bottom" name="phone"
                                       value="<?php echo $user['phone'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="phone"><?php echo $this->lang->line('Phone') ?> (Alt)</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="altphone"
                                       class="form-control margin-bottom" name="phonealt"
                                       value="<?php echo $user['phonealt'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="email"><?php echo $this->lang->line('Email') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="email"
                                       class="form-control margin-bottom  required" name="email"
                                       value="<?php echo $user['email'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="name"><?php echo $this->lang->line('Business Location') ?> (Primary)</label>

                            <div class="col-sm-5">
                                <select name="location" class="form-control margin-bottom">
                                    <option value="<?php echo $user['loc'] ?>"><?php echo $this->lang->line('Do not change') ?></option>
                                    <option value="0"><?php echo $this->lang->line('Default') ?></option>
                                    <?php $loc = locations();

                                    foreach ($loc as $row) {
                                        echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="locations">Assigned Branches</label>

                            <div class="col-sm-5">
                                <select name="locations[]" class="form-control margin-bottom select-box" multiple="multiple">
                                    <?php
                                    $saved_locs = isset($user['locations']) ? $user['locations'] : array();
                                    foreach ($loc as $row) {
                                        $selected = in_array($row['id'], $saved_locs) ? 'selected' : '';
                                        echo ' <option value="' . $row['id'] . '" ' . $selected . '> ' . $row['cname'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <small>Select additional branches for Business Owners and Service Providers.</small>
                            </div>
                        </div>
                        <?php if ($this->aauth->get_user()->roleid >= 0) { ?>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="roleid"><?php echo $this->lang->line('UserRole') ?></label>

                                <div class="col-sm-5">
                                    <select name="roleid" class="form-control margin-bottom">
                                        <?php
                                        foreach ($roles as $row) {
                                            $selected = ($row['id'] == $user['roleid']) ? 'selected' : '';
                                            echo ' <option value="' . $row['id'] . '" ' . $selected . '> ' . $row['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                        <?php } ?>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="name"><?php echo $this->lang->line('Department') ?></label>

                            <div class="col-sm-5">
                                <select name="department" class="form-control margin-bottom">
                                    <option value="<?php echo $user['dept'] ?>"><?php echo $this->lang->line('Do not change') ?></option>
                                    <option value="0"><?php echo $this->lang->line('Default') . ' - ' . $this->lang->line('No') ?></option>
                                    <?php

                                    foreach ($dept as $row) {
                                        echo ' <option value="' . $row['id'] . '"> ' . $row['val1'] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="phone"><?php echo $this->lang->line('Salary') ?></label>

                            <div class="col-sm-5">
                                <input type="text" placeholder="Salary" onkeypress="return isNumber(event)"
                                       class="form-control margin-bottom" name="salary"
                                       value="<?php echo amountFormat_general($user['salary']) ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="cola_amount">COLA Amount</label>
                            <div class="col-sm-5">
                                <input type="text" placeholder="Cost of Living Allowance" onkeypress="return isNumber(event)"
                                       class="form-control margin-bottom" name="cola_amount"
                                       value="<?php echo isset($user['cola_amount']) ? amountFormat_general($user['cola_amount']) : '0' ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="epf_no">EPF No</label>
                            <div class="col-sm-5">
                                <input type="text" placeholder="EPF Number"
                                       class="form-control margin-bottom" name="epf_no"
                                       value="<?php echo isset($user['epf_no']) ? $user['epf_no'] : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="city"><?php echo $this->lang->line('Commission') ?>%</label>

                            <div class="col-sm-2">
                                <input type="number" placeholder="Commission %"
                                       class="form-control margin-bottom" name="commission"
                                       value="<?php echo $user['c_rate'] ?>">
                            </div>
                            <small class="col">It will based on each invoice amount - inclusive all
                                taxes,shipping,discounts
                            </small>

                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="bank_name"><?php echo $this->lang->line('Bank Name') ?></label>

                            <div class="col-sm-5">
                                <input type="text" placeholder="Bank Name"
                                       class="form-control margin-bottom" name="bank_name"
                                       value="<?php echo isset($user['bank_name']) ? $user['bank_name'] : '' ?>">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="bank_ac"><?php echo $this->lang->line('Bank Account') ?></label>

                            <div class="col-sm-5">
                                <input type="text" placeholder="Account Number"
                                       class="form-control margin-bottom" name="bank_ac"
                                       value="<?php echo isset($user['bank_ac']) ? $user['bank_ac'] : '' ?>">
                            </div>
                        </div>
                        <input type="hidden"
                               name="eid"
                               value="<?php echo $user['id'] ?>">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <div class="col-sm-4">
                                <input type="submit" id="profile_update" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update') ?>"
                                       data-loading-text="Updating...">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#profile_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'employee/update';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>employee/displaypic?id=<?php echo $user['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');


                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/employee/' + data.result + '?' + new Date().getTime());

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


        // Sign
        var sign_url = '<?php echo base_url() ?>employee/user_sign?id=<?php echo $user['id'] ?>';
        $('#sign_fileupload').fileupload({
            url: sign_url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#sign_pic").attr('src', '<?php echo base_url() ?>userfiles/employee_sign/' + data.result + '?' + new Date().getTime());


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