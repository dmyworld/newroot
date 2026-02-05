<div class="content-body">
    <div class="card">
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
                                    <h6 class="text-primary mt-2">How to Create an Invoice</h6>
                                    <ol>
                                        <li><strong>Customer:</strong> Select a customer. Walk-in customers are default.</li>
                                        <li><strong>Add Products:</strong> Search for products by name or scan barcode.</li>
                                        <li><strong>Billing Details:</strong> Enter quantities. Prices are fetched automatically but can be edited.</li>
                                        <li><strong>Extra Charges:</strong> Add Shipping, Planing, or Loading charges if applicable.</li>
                                        <li><strong>Payment:</strong> Click 'Payment' to record immediate payment, or 'Draft' to save without payment.</li>
                                        <li><strong>Stock:</strong> Creating an invoice reduces product stock (if enabled). Checks for low stock alerts.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>Note:</strong> Creating an Invoice will immediately deduct Stock and record a Transaction. Review settings for tax/discount application.</small></p>
                                </div>
                                <div class="tab-pane fade" id="sin" role="tabpanel">
                                    <h6 class="text-primary mt-2">ඉන්වොයිසියක් සකසන ආකාරය</h6>
                                    <ol>
                                        <li><strong>පාරිභෝගිකයා:</strong> පාරිභෝගිකයෙකු තෝරන්න. සාමාන්‍ය පාරිභෝගිකයින් (Walk-in) පෙරනිමිය වේ.</li>
                                        <li><strong>නිෂ්පාදන එකතු කිරීම:</strong> නම හෝ තීරු කේතය (barcode) මගින් නිෂ්පාදන සොයන්න.</li>
                                        <li><strong>බිල්පත් විස්තර:</strong> ප්‍රමාණ ඇතුළත් කරන්න. මිල ගණන් ස්වයංක්‍රීයව පැමිණෙන අතර අවශ්‍ය නම් වෙනස් කළ හැක.</li>
                                        <li><strong>අමතර ගාස්තු:</strong> අවශ්‍ය නම් ප්‍රවාහන, සැලසුම් හෝ පැටවීමේ ගාස්තු එකතු කරන්න.</li>
                                        <li><strong>ගෙවීම්:</strong> මුදල් ගෙවීම සඳහා 'Payment' ක්ලික් කරන්න, හෝ ගෙවීමකින් තොරව සුරැකීමට 'Draft' තෝරන්න.</li>
                                        <li><strong>තොග:</strong> ඉන්වොයිසියක් සෑදීමෙන් නිෂ්පාදන තොග අඩු වේ (මෙය සක්‍රිය කර ඇත්නම්). අඩු තොග ගැන අනතුරු අඟවයි.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>සටහන:</strong> ඉන්වොයිසියක් සෑදීමෙන් තොග (Stock) අඩු වන අතර ගනුදෙනුවක් වාර්තා වේ. බදු/වට්ටම් සැකසුම් පරීක්ෂා කරන්න.</small></p>
                                </div>
                                <div class="tab-pane fade" id="tam" role="tabpanel">
                                    <h6 class="text-primary mt-2">இன்வாய்ஸை உருவாக்குவது எப்படி</h6>
                                    <ol>
                                        <li><strong>வாடிக்கையாளர்:</strong> வாடிக்கையாளரைத் தேர்ந்தெடுக்கவும். Walk-in வாடிக்கையாளர்கள் இயல்புநிலை.</li>
                                        <li><strong>தயாரிப்புகளைச் சேர்த்தல்:</strong> பெயர் அல்லது பார்கோடு மூலம் தயாரிப்புகளைத் தேடவும்.</li>
                                        <li><strong>பில்லிங் விவரங்கள்:</strong> அளவுகளை உள்ளிடவும். விலைகள் தானாகவே வரும், ஆனால் திருத்தப்படலாம்.</li>
                                        <li><strong>கூடுதல் கட்டணங்கள்:</strong> பொருந்தினால் கப்பல் போக்குவரத்து, திட்டமிடல் அல்லது ஏற்றுதல் கட்டணங்களைச் சேர்க்கவும்.</li>
                                        <li><strong>கட்டணம்:</strong> உடனடிப் பணத்தைச் செலுத்த 'Payment' என்பதைக் கிளிக் செய்யவும் அல்லது பணம் செலுத்தாமல் சேமிக்க 'Draft' ஐத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>இருப்பு:</strong> இன்வாய்ஸை உருவாக்குவது தயாரிப்பு இருப்பைக் குறைக்கும் (இயக்கப்பட்டிருந்தால்). குறைந்த இருப்பு விழிப்பூட்டல்களைச் சரிபார்க்கிறது.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>குறிப்பு:</strong> இன்வாய்ஸை உருவாக்குவது உடனடியாக இருப்பைக் குறைத்து பரிவர்த்தனையைப் பதிவு செய்யும். வரி/தள்ளுபடி அமைப்புகளை மதிப்பாய்வு செய்யவும்.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" id="data_form">
                    <div class="row">
                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill To') ?> <a href='#'
                                                                                          class="btn btn-primary btn-sm round"
                                                                                          data-toggle="modal"
                                                                                          data-target="#addCustomer">
                                                <?php echo $this->lang->line('Add Client') ?>
                                            </a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst"
                                                                            class="caption"><?php echo $this->lang->line('Search Client'); ?></label>
                                        <input type="text" class="form-control round" name="cst" id="customer-box"
                                        <input type="text" class="form-control round" name="cst" id="customer-box"
                                               placeholder="Enter Customer Name or Mobile Number to search"
                                               autocomplete="off"/>
                                        <div id="customer-box-result"></div>
                                    </div>
                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                        <?php echo $this->lang->line('Client Details'); ?>
                                        <hr>
                                        <input type="hidden" name="customer_id" id="customer_id" value="0">
                                        <div id="customer_name"></div>
                                    </div>
                                    <div class="clientinfo">
                                        <div id="customer_address1"></div>
                                    </div>

                                    <div class="clientinfo">

                                        <div id="customer_phone"></div>
                                    </div>
                                    <hr>
                                    <div id="customer_pass"></div><?php echo $this->lang->line('Warehouse') ?> <select
                                            id="s_warehouses"
                                            class="form-control round">
                                        <?php echo $this->common->default_warehouse();
                                        echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">

                                    <div class="col-sm-12"><h3
                                                class="title"><?php echo $this->lang->line('Invoice Properties') ?></h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Invoice #"
                                                   name="invocieno"
                                                   value="<?php echo $lastinvoice + 1 ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Reference #"
                                                   name="refer">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="invociedate"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   placeholder="Billing Date" name="invoicedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieduedate"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   name="invocieduedate"
                                                   placeholder="Due Date" autocomplete="false"    data-toggle="datepicker">
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo"
                                               class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                        <textarea class="form-control round" name="notes" rows="2"></textarea></div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div id="saman-row5">
                        <table class="table-responsive tfr my_stripe">

                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                                                <th width="10%" class="text-center">
                                    <?php echo $this->lang->line('Amount') ?>
                                    (<?= currency($this->aauth->get_user()->loc); ?>)
                                </th>
                                <th width="10%" class="text-center">Thickness</th>
                                <th width="10%" class="text-center">Width</th>
                                <th width="7%" class="text-center">Length</th>

                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='productname-0'>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment('0'),rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="1"></td>
                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control req prc" name="product_t[]" id="t-0" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment('0'), rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                <td><input type="text" class="form-control req prc" name="product_w[]" id="w-0" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment('0'), rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                <td><input type="text" class="form-control req prc" name="product_l[]" id="l-0" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment('0'), rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                <td><span class="currenty"><?php echo $this->config->item('currency'); ?>:</span>
                                    <strong><span class='ttttlText'  id="resultttr-0">0</span></strong>
                                    <br>
                                    <span class="currenty">ft&#179; :</span>
                                    <strong><span class='ttlTextt' id="resultttc-0">0</span></strong>
                                </td>
                                <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                <input type="hidden" name="disca[]" id="disca-0" value="0">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="totaltt1-0" value="0">
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                <input type="hidden" name="unit[]" id="unit-0" value="">
                                <input type="hidden" name="hsn[]" id="hsn-0" value="">
                                <input type="hidden" name="serial[]" id="serial-0" value="">
                                <input type="hidden" name="product_quick[]" id="totalquick-0" value="">
                            </tr>


                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addproduct5">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>

                            

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
                                    <strong><?php echo $this->lang->line('Shipping') ?></strong></td>
                                <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                    onkeypress="return isNumber(event)"
                                                                    placeholder="Value"
                                                                    name="shipping" autocomplete="off"
                                                                    onkeyup="billUpyog()">
                                   
                                </td>
                            </tr>



                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="2"><?php if (isset($employee)){
                                       echo $this->lang->line('Employee')
                                ?><br>
                                    <select name="employee"
                                            class=" mt-1 col form-control form-control-sm">

                                        <?php foreach ($employee as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['name'] . ')</option>';
                                        } ?>

                                    </select><?php } ?><br><?php if ($exchange['active'] == 1){
                                    echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                    <select name="mcurrency"
                                            class="selectpicker form-control">
                                        <option value="0">Default</option>
                                        <?php foreach ($currency as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                        } ?>

                                    </select><?php } ?></td>
                                <td colspan="4" class="reverse_align"><strong><?php echo $this->lang->line('Grand Total') ?>
                                        (<span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                </td>
                                <td align="left" colspan="2"><input type="text" name="totaltt" class="form-control"
                                                                    id="invoiceyoghtmltimbert" readonly="">

                                </td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="2"><?php echo $this->lang->line('Payment Terms') ?> <select name="pterms"
                                                                                                         class="selectpicker form-control"><?php foreach ($terms as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select></td>
                                <td class="reverse_align" colspan="6"><input type="submit"
                                                                     class="btn btn-success sub-btn btn-lg"
                                                                     value="<?php echo $this->lang->line('Generate Invoice') ?> "
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>


                            </tbody>
                        </table>

                        <?php
                        if(is_array($custom_fields)){
                          echo'<div class="card">';
                                    foreach ($custom_fields as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="row mt-1">

                                                <label class="col-sm-8"
                                                       for="docid"><?= $row['name'] ?></label>

                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                                           name="custom[<?= $row['id'] ?>]">
                                                </div>
                                            </div>


                                        <?php }
                                    }
                                    echo'</div>';
                        }
                                    ?>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="invoices/action" id="action-url">
                    <input type="hidden" value="search5" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak5">
                    <input type="hidden" value="<?= currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>"
                           name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?= amountFormat_general($this->common->disc_status()['ship_rate']); ?>"
                           name="shipRate"
                           id="ship_rate">
                    <input type="hidden" value="<?= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
                           id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">

                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-purple white">

                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom crequired" name="email"
                                           id="mcustomer_email">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address" id="mcustomer_address1">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city" id="mcustomer_city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region"
                                           class="form-control margin-bottom" name="region">
                                </div>

                            </div>

                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="Country"
                                           class="form-control margin-bottom" name="country" id="mcustomer_country">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox"
                                           class="form-control margin-bottom" name="postbox">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Company"
                                           class="form-control margin-bottom" name="company">
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="TAX ID"
                                           class="form-control margin-bottom" name="taxid" id="mcustomer_city">
                                </div>


                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label  col-form-label-sm"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control form-control-sm">
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


                        </div>

                        <!-- shipping -->
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Shipping Address') ?></h5>
                            <div class="form-group row">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="customer1s"
                                           id="copy_address">
                                    <label class="custom-control-label"
                                           for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
                                </div>


                                <div class="col-sm-10">
                                    <?php echo $this->lang->line("leave Shipping Address") ?>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name_s"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name_s" name="name_s"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone_s" id="mcustomer_phone_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email_s"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom" name="email_s"
                                           id="mcustomer_email_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address_s"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address_s"
                                           id="mcustomer_address1_s">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city_s" id="mcustomer_city_s">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region_s"
                                           class="form-control margin-bottom" name="region_s">
                                </div>

                            </div>

                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="Country"
                                           class="form-control margin-bottom" name="country_s" id="mcustomer_country_s">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox_s"
                                           class="form-control margin-bottom" name="postbox_s">
                                </div>
                            </div>


                        </div>

                    </div>
                                   <?php
                                   if(is_array($custom_fields_c)){
                                    foreach ($custom_fields_c as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="form-group row">

                                                <label class="col-sm-2 col-form-label"
                                                       for="docid"><?= $row['name'] ?></label>

                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input"
                                                           name="custom[<?= $row['id'] ?>]">
                                                </div>
                                            </div>


                                        <?php }
                                    }
                                   }
                                    ?>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/>
                </div>
            </form>
        </div>
    </div>
</div>
