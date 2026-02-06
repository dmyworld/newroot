<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header with Tabs -->
        <div class="card-header p-0" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%);">
            <div class="row no-gutters">
                <div class="col-md-12 text-center pt-3 pb-1">
                    <h2 class="text-white" style="font-family: 'Cinzel', serif; letter-spacing: 1px;"><?php echo $this->lang->line('Add New Transaction') ?></h2>
                </div>
            </div>
            
            <!-- Custom Artistic Tabs -->
            <div class="d-flex justify-content-center mt-2">
                <div class="btn-group btn-group-toggle" data-toggle="buttons" style="background: rgba(255,255,255,0.1); padding: 5px; border-radius: 30px;">
                    <label class="btn btn-outline-light active shadow-none px-5 py-2" id="tab-income" style="border-radius: 25px; border: none; font-weight: 600; transition: all 0.3s; position: relative; overflow: hidden;" onclick="setPayType('Income')">
                        <input type="radio" name="options"  autocomplete="off" checked> 
                        <i class="fa fa-arrow-down mr-2"></i> <?php echo $this->lang->line('Income') ?>
                    </label>
                    <label class="btn btn-outline-light shadow-none px-5 py-2" id="tab-expense" style="border-radius: 25px; border: none; font-weight: 600; transition: all 0.3s; position: relative; overflow: hidden;" onclick="setPayType('Expense')">
                        <input type="radio" name="options" autocomplete="off"> 
                        <i class="fa fa-arrow-up mr-2"></i> <?php echo $this->lang->line('Expense') ?>
                    </label>
                </div>
            </div>
            <div class="text-center pb-3 mt-2">
                <small class="text-white-50 font-italic">Select transaction type to proceed</small>
            </div>
        </div>

        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

            <div class="card-body p-4">
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
                                    <h6 class="text-primary mt-2">How to Add a Transaction</h6>
                                    <ol>
                                        <li><strong>Transaction Type:</strong> Select 'Income' (Deposit) or 'Expense' (Withdrawal).</li>
                                        <li><strong>Party:</strong> Select Customer (for payments) or Supplier (for bills).</li>
                                        <li><strong>Account:</strong> Choose the bank or cash account involved.</li>
                                        <li><strong>Category:</strong> Classify the transaction (e.g., Sales, Rent, Utility).</li>
                                        <li><strong>Dual Entry:</strong> Use for internal transfers between accounts.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>Note:</strong> Transactions directly impact Account Balances. Reconciled transactions may require administrative privileges to delete.</small></p>
                                </div>
                                <div class="tab-pane fade" id="sin" role="tabpanel">
                                    <h6 class="text-primary mt-2">ගනුදෙනුවක් (Transaction) එකතු කරන ආකාරය</h6>
                                    <ol>
                                        <li><strong>ගනුදෙනු වර්ගය:</strong> 'Income' (ආදායම්) හෝ 'Expense' (වියදම්) තෝරන්න.</li>
                                        <li><strong>පාර්ශවය:</strong> ගනුදෙනුකරු (ගෙවීම් සඳහා) හෝ සැපයුම්කරු (බිල්පත් සඳහා) තෝරන්න.</li>
                                        <li><strong>ගිණුම:</strong> අදාළ බැංකු හෝ මුදල් ගිණුම තෝරන්න.</li>
                                        <li><strong>වර්ගය (Category):</strong> ගනුදෙනුව වර්ග කරන්න (උදා: විකුණුම්, කුලී, බිල්පත්).</li>
                                        <li><strong>ද්විත්ව සටහන් (Dual Entry):</strong> ගිණුම් අතර මුදල් මාරු කිරීම සඳහා භාවිතා කරන්න.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>සටහන:</strong> ගනුදෙනු ගිණුම් ශේෂයන්ට (Account Balances) සෘජුවම බලපායි. සංහිඳියාව (Reconciled) කරන ලද ගනුදෙනු මකා දැමීමට පරිපාලක අවසර අවශ්‍ය විය හැක.</small></p>
                                </div>
                                <div class="tab-pane fade" id="tam" role="tabpanel">
                                    <h6 class="text-primary mt-2">பரிவர்த்தனையை எவ்வாறு சேர்ப்பது</h6>
                                    <ol>
                                        <li><strong>பரிவர்த்தனை வகை:</strong> 'Income' (வருமானம்) அல்லது 'Expense' (செலவு) என்பதைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>கட்சி (Party):</strong> வாடிக்கையாளர் (கட்டணங்களுக்கு) அல்லது சப்ளையரை (பில்களுக்கு) தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>கணக்கு:</strong> சம்பந்தப்பட்ட வங்கி அல்லது பணக் கணக்கைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>வகை (Category):</strong> பரிவர்த்தனையை வகைப்படுத்தவும் (எ.கா., விற்பனை, வாடகை, பயன்பாடு).</li>
                                        <li><strong>இரட்டை பதிவு (Dual Entry):</strong> கணக்குகளுக்கு இடையில் நிதியை மாற்ற இதைப் பயன்படுத்தவும்.</li>
                                    </ol>
                                    <p class="text-muted"><small><strong>குறிப்பு:</strong> பரிவர்த்தனைகள் கணக்கு இருப்புகளை நேரடியாகப் பாதிக்கும்.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" id="data_form">
                    
                    <!-- Hidden Pay Type Field (Controlled by Tabs) -->
                    <input type="hidden" name="pay_type" id="pay_type" value="Income">
                    <input type="hidden" name="act" value="add_product">

                    <!-- Person Selection Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="font-weight-bold text-uppercase text-muted small mb-2">Transaction Party</label>
                            <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                <label class="btn btn-outline-secondary active" onclick="$('#trans-box').val(''); $('#customer_id').val('0');">
                                    <input type="radio" name="ty_p" id="customRadio1" value="0" checked> <?php echo $this->lang->line('Customer') ?>
                                </label>
                                <label class="btn btn-outline-secondary" onclick="$('#trans-box').val(''); $('#customer_id').val('0');">
                                    <input type="radio" name="ty_p" id="customRadio2" value="1"> <?php echo $this->lang->line('Supplier') ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                             <label class="font-weight-bold text-uppercase text-muted small mb-2">Search Party</label>
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
                                 </div>
                                 <input type="text" class="form-control border-left-0" name="cst" id="trans-box"
                                       placeholder="Enter Person Name or Mobile Number to search (Optional)"
                                       autocomplete="off" style="box-shadow: none; border-color: #ced4da;">
                             </div>
                             <div id="trans-box-result" class="sbox-result" style="position: absolute; z-index: 1000; width: 95%; background: white; border: 1px solid #ddd; display: none;"></div>
                        </div>
                    </div>
                    
                    <hr class="my-4">

                    <!-- Main Transaction Details -->
                    <div id="customerpanel" class="p-3 mb-4 rounded" style="background-color: #f8f9fa; border-left: 5px solid #13ec5b;">
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <label for="customer_name" class="caption col-form-label font-weight-bold"><?php echo $this->lang->line('C/o') ?> <span class="text-danger">*</span></label>
                                <input type="hidden" name="payer_id" id="customer_id" value="0">
                                <input type="text" class="form-control required" name="payer_name" id="customer_name" placeholder="Name">
                            </div>

                             <div class="col-sm-4">
                                <label class="col-form-label font-weight-bold" for="pay_acc"><?php echo $this->lang->line('To') . ' ' . $this->lang->line('Account') ?></label>
                                <select name="pay_acc" class="form-control custom-select">
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

                            <div class="col-sm-4">
                                <label class="col-form-label font-weight-bold" for="amount"><?php echo $this->lang->line('Amount') ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $this->config->item('currency'); ?></span>
                                    </div>
                                    <input type="text" placeholder="0.00" class="form-control required" name="amount" value="0" onkeypress="return isNumber(event)">
                                </div>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" name="wallet_balance" id="wallet_balance" value="1">
                                    <label class="custom-control-label text-info" for="wallet_balance">Customer Wallet Balance ADD</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-4">
                            <label class="col-form-label font-weight-bold" for="date"><?php echo $this->lang->line('Date') ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control required" name="date" data-toggle="datepicker" autocomplete="false">
                            </div>
                        </div>

                         <div class="col-sm-4">
                            <label class="col-form-label font-weight-bold" for="pay_cat"><?php echo $this->lang->line('Category') ?></label>
                            <select name="pay_cat" class="form-control custom-select">
                                <?php
                                foreach ($cat as $row) {
                                    $title = $row['name'];
                                    echo "<option value='$title'>$title</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label class="col-form-label font-weight-bold" for="paymethod"><?php echo $this->lang->line('Method') ?> </label>
                            <select name="paymethod" id="paymethod_trans" class="form-control custom-select">
                                <option value="Cash" selected><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Cheque"><?php echo $this->lang->line('Cheque') ?></option>
                                <option value="Bank"><?php echo $this->lang->line('Bank') ?></option>
                                <option value="Other"><?php echo $this->lang->line('Other') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group" id="cheque_number_row_trans" style="display: none;">
                        <div class="col-sm-4">
                            <label class="col-form-label font-weight-bold" for="cheque_number"><?php echo $this->lang->line('Cheque Number') ?></label>
                            <input type="text" class="form-control" name="cheque_number" id="cheque_number_trans" placeholder="Cheque Number">
                        </div>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#paymethod_trans').on('change', function() {
                                if ($(this).val() == 'Bank' || $(this).val() == 'Cheque') {
                                    $('#cheque_number_row_trans').show();
                                } else {
                                    $('#cheque_number_row_trans').hide();
                                    $('#cheque_number_trans').val('');
                                }
                            });
                        });
                    </script>

                    <div class="row form-group mb-4">
                        <div class="col-sm-12">
                             <label class="col-form-label font-weight-bold"><?php echo $this->lang->line('Note') ?></label>
                            <textarea placeholder="Transaction Details / Note" class="form-control" name="note" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Dual Entry Section -->
                    <?php if ($dual['key1']) { ?>
                        <div class="card bg-light border-0 mb-4 shadow-sm">
                            <div class="card-header bg-transparent">
                                <h4 class="text-purple"><i class="fa fa-exchange"></i> <?php echo $this->lang->line('Dual Entry') ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label class="col-form-label font-weight-bold"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Account') ?></label>
                                        <select name="f_pay_acc" class="form-control custom-select">
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
                                    <div class="col-sm-4">
                                        <label class="col-form-label font-weight-bold"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Category') ?></label>
                                        <select name="f_pay_cat" class="form-control custom-select">
                                            <?php
                                            foreach ($cat as $row) {
                                                $title = $row['name'];
                                                echo "<option value='$title'>$title</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="col-form-label font-weight-bold"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Method') ?> </label>
                                        <select name="f_paymethod" class="form-control custom-select">
                                            <option value="Cash" selected><?php echo $this->lang->line('Cash') ?></option>
                                            <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                            <option value="Cheque"><?php echo $this->lang->line('Cheque') ?></option>
                                            <option value="Bank"><?php echo $this->lang->line('Bank') ?></option>
                                            <option value="Other"><?php echo $this->lang->line('Other') ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="col-form-label font-weight-bold"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Note') ?></label>
                                        <input type="text" placeholder="Dual Entry Note" class="form-control" name="f_note">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-sm-12 text-right">
                             <button type="submit" id="submit-data" class="btn btn-success btn-lg btn-block shadow-sm" data-loading-text="Adding...">
                                 <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add transaction') ?>
                             </button>
                             <input type="hidden" value="transactions/save_trans" id="action-url">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Tab Interaction Logic
    function setPayType(type) {
        // Set header value
        $('#pay_type').val(type);

        // Visual feedback
        if (type === 'Income') {
            $('#tab-income').addClass('active').addClass('btn-outline-light').removeClass('btn-outline-light-off');
            $('#tab-expense').removeClass('active').addClass('btn-outline-light-off');
            
            // Adjust form border theme
            $('#customerpanel').css('border-left', '5px solid #13ec5b');
            $('.card-header').css('background', 'linear-gradient(135deg, #1a1412 0%, #2e7d32 100%)'); // Green tint
            
            // Adjust Button
            $('#submit-data').removeClass('btn-danger').addClass('btn-success');
        } else {
            $('#tab-expense').addClass('active').addClass('btn-outline-light').removeClass('btn-outline-light-off');
            $('#tab-income').removeClass('active').addClass('btn-outline-light-off');
            
             // Adjust form border theme
            $('#customerpanel').css('border-left', '5px solid #ff4b4b');
            $('.card-header').css('background', 'linear-gradient(135deg, #1a1412 0%, #c62828 100%)'); // Red tint
            
             // Adjust Button
            $('#submit-data').removeClass('btn-success').addClass('btn-danger');
        }
    }

    // Default State
    $(document).ready(function() {
        setPayType('Income');
    });

    // Existing Search Logic
    $("#trans-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/party_search',
            data: 'keyword=' + $(this).val() + '&ty=' + $('input[name=ty_p]:checked').val(),
            beforeSend: function () {
                $("#trans-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 95%"); // Adjusted position
            },
            success: function (data) {
                $("#trans-box-result").show();
                $("#trans-box-result").html(data);
                $("#trans-box").css("background", "none");
            }
        });
    });
</script>

<style>
/* Additional Styles */
.btn-outline-light-off {
    color: rgba(255,255,255,0.6);
    border-color: transparent !important;
}
.btn-outline-light-off:hover {
    color: #fff;
    background: rgba(255,255,255,0.1);
}
.custom-select {
    height: calc(2.25rem + 2px);
}
</style>
