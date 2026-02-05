<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Add New Customer') ?></h4>

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
                                <h6 class="text-primary mt-2">How to Add a Customer</h6>
                                <ol>
                                    <li><strong>Basic Details:</strong> Enter Name, Phone, and Email. Ensure email is unique for login.</li>
                                    <li><strong>Addresses:</strong> Provide Billing Address. If Shipping is different, uncheck 'Same As Billing'.</li>
                                    <li><strong>Tax & Group:</strong> Enter Tax ID if applicable. Assign to a Group for automatic discounts.</li>
                                    <li><strong>Login:</strong> Enable 'Customer Login' and set a password if they need portal access.</li>
                                </ol>
                                <p class="text-muted"><small><strong>Note:</strong> Assigning a Client Group will automatically apply associated Discount Rates to this customer's invoices.</small></p>
                            </div>
                            <div class="tab-pane fade" id="sin" role="tabpanel">
                                <h6 class="text-primary mt-2">පාරිභෝගිකයෙකු එකතු කරන ආකාරය</h6>
                                <ol>
                                    <li><strong>මූලික විස්තර:</strong> නම, දුරකථන අංකය සහ විද්‍යුත් තැපෑල ඇතුළත් කරන්න. ලොගින් වීම සඳහා ඊමේල් අද්විතීය විය යුතුය.</li>
                                    <li><strong>ලිපිනයන්:</strong> බිල්පත් ලිපිනය (Billing Address) ලබා දෙන්න. නැව්ගත කිරීමේ ලිපිනය වෙනස් නම්, 'Same As Billing' අක්‍රීය කරන්න.</li>
                                    <li><strong>බදු සහ කණ්ඩායම්:</strong> අදාළ නම් Tax ID ඇතුළත් කරන්න. වට්ටම් සඳහා පාරිභෝගික කණ්ඩායමකට (Group) ඇතුළත් කරන්න.</li>
                                    <li><strong>පිවිසුම:</strong> Portal පිවිසුම අවශ්‍ය නම් 'Customer Login' සක්‍රිය කර මුරපදයක් සකසන්න.</li>
                                </ol>
                                <p class="text-muted"><small><strong>සටහන:</strong> පාරිභෝගික කණ්ඩායමක් (Client Group) පැවරීමෙන් අදාළ වට්ටම් අනුපාත ස්වයංක්‍රීයව මෙම පාරිභෝගිකයාට හිමිවේ.</small></p>
                            </div>
                            <div class="tab-pane fade" id="tam" role="tabpanel">
                                <h6 class="text-primary mt-2">வாடிக்கையாளரை எவ்வாறு சேர்ப்பது</h6>
                                <ol>
                                    <li><strong>அடிப்படை விவரங்கள்:</strong> பெயர், தொலைபேசி மற்றும் மின்னஞ்சலை உள்ளிடவும். உள்நுழைவுக்கு மின்னஞ்சல் தனித்துவமாக இருப்பதை உறுதி செய்யவும்.</li>
                                    <li><strong>விலாசங்கள்:</strong> பில்லிங் முகவரியை வழங்கவும். ஷிப்பிங் வேறுபட்டால், 'Same As Billing' என்பதைத் தேர்வுநீக்கவும்.</li>
                                    <li><strong>வரி மற்றும் குழு:</strong> பொருந்தினால் Tax ID ஐ உள்ளிடவும். தானியங்கி தள்ளுபடிகளுக்கு ஒரு குழுவிற்கு (Group) ஒதுக்கவும்.</li>
                                    <li><strong>உள்நுழைவு:</strong> அவர்களுக்கு போர்டல் அணுகல் தேவைப்பட்டால் 'Customer Login' ஐ இயக்கி கடவுச்சொல்லை அமைக்கவும்.</li>
                                </ol>
                                <p class="text-muted"><small><strong>குறிப்பு:</strong> வாடிக்கையாளர் குழுவை (Client Group) ஒதுக்குவது, இந்த வாடிக்கையாளரின் இன்வாய்ஸ்களுக்கு தொடர்புடைய தள்ளுபடி விகிதங்களை தானாகவே பயன்படுத்தும்.</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" id="data_form" class="form-horizontal">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                       aria-controls="tab1" href="#tab1" role="tab"
                                       aria-selected="true"><?php echo $this->lang->line('Billing Address') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                       href="#tab2" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Shipping Address') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                       href="#tab3" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Settings') ?></a>
                                </li>

                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Name"
                                                   class="form-control margin-bottom b_input required" name="name"
                                                   id="mcustomer_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Company') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Company"
                                                   class="form-control margin-bottom b_input" name="company">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="phone"
                                                   class="form-control margin-bottom required b_input" name="phone"
                                                   id="mcustomer_phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="email"
                                                   class="form-control margin-bottom required b_input" name="email"
                                                   id="mcustomer_email">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="address"
                                                   class="form-control margin-bottom b_input" name="address"
                                                   id="mcustomer_address1">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="city"
                                                   class="form-control margin-bottom b_input" name="city"
                                                   id="mcustomer_city">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region"><?php echo $this->lang->line('Region') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Region"
                                                   class="form-control margin-bottom b_input" name="region"
                                                   id="region">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="country"><?php echo $this->lang->line('Country') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Country"
                                                   class="form-control margin-bottom b_input" name="country"
                                                   id="mcustomer_country">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox"
                                                   id="postbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                    <div class="form-group row">

                                        <div class="input-group mt-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="customer1"
                                                       id="copy_address">
                                                <label class="custom-control-label"
                                                       for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
                                            </div>

                                        </div>

                                        <div class="col-sm-10 text-info">
                                            <?php echo $this->lang->line("leave Shipping Address") ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name_s"><?php echo $this->lang->line('Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Name"
                                                   class="form-control margin-bottom b_input" name="name_s"
                                                   id="mcustomer_name_s">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="phone"
                                                   class="form-control margin-bottom b_input" name="phone_s"
                                                   id="mcustomer_phone_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email_s">Email</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="email"
                                                   class="form-control margin-bottom b_input" name="email_s"
                                                   id="mcustomer_email_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="address_s"
                                                   class="form-control margin-bottom b_input" name="address_s"
                                                   id="mcustomer_address1_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city_s"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="city"
                                                   class="form-control margin-bottom b_input" name="city_s"
                                                   id="mcustomer_city_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region_s"><?php echo $this->lang->line('Region') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Region"
                                                   class="form-control margin-bottom b_input" name="region_s"
                                                   id="region_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="country_s"><?php echo $this->lang->line('Country') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Country"
                                                   class="form-control margin-bottom b_input" name="country_s"
                                                   id="mcustomer_country_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_s"
                                                   id="postbox_s">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                    <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                                       for="Discount"><?php echo $this->lang->line('Discount') ?> </label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Custom Discount"
                                                   class="form-control margin-bottom b_input" name="discount">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="taxid"><?php echo $this->lang->line('TAX') ?> ID</label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="TAX ID"
                                                   class="form-control margin-bottom b_input" name="taxid">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="docid"><?php echo $this->lang->line('Document') ?> ID</label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Document ID"
                                                   class="form-control margin-bottom b_input" name="docid">
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                                       for="c_field"><?php echo $this->lang->line('Extra') ?> </label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Custom Field"
                                                   class="form-control margin-bottom b_input" name="c_field">
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($custom_fields as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="form-group row">

                                                <label class="col-sm-2 col-form-label"
                                                       for="docid"><?= $row['name'] ?></label>

                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                                           name="custom[<?= $row['id'] ?>]">
                                                </div>
                                            </div>


                                        <?php }
                                    }
                                    ?>


                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customergroup"><?php echo $this->lang->line('Customer group') ?></label>

                                        <div class="col-sm-6">
                                            <select name="customergroup" class="form-control b_input">
                                                <?php

                                                foreach ($customergrouplist as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['title'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select>


                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency">Language</label>

                                        <div class="col-sm-6">
                                            <select name="language" class="form-control b_input">

                                                <?php

                                                echo $langs;
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency"><?php echo $this->lang->line('customer_login') ?></label>

                                        <div class="col-sm-6">
                                            <select name="c_login" class="form-control b_input">

                                                <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                                <option value="0"><?php echo $this->lang->line('No') ?></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="password_c"><?php echo $this->lang->line('New Password') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Leave blank for auto generation"
                                                   class="form-control margin-bottom b_input" name="password_c"
                                                   id="password_c">
                                        </div>
                                    </div>


                                </div>
                                <div id="mybutton">
                                    <input type="submit" id="submit-data"
                                           class="btn btn-lg btn btn-primary margin-bottom round float-xs-right mr-2"
                                           value="<?php echo $this->lang->line('Add customer') ?>"
                                           data-loading-text="Adding...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <input type="hidden" value="customers/addcustomer" id="action-url">
            </form>
        </div>
    </div>
</div>

