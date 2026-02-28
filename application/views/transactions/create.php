<div class="content-body">
    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; overflow: hidden;">
        
        <!-- Artistic Header with Tabs -->
        <div class="card-header p-0" id="main_header" style="background: linear-gradient(135deg, #1a1412 0%, #2B2000 100%); transition: all 0.5s;">
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
                <small class="text-white-50 font-italic" id="type_hint">Select transaction type to proceed</small>
            </div>
        </div>

        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

            <div class="card-body p-4">
                <form method="post" id="data_form">
                    
                    <!-- Hidden Pay Type Field (Controlled by Tabs) -->
                    <input type="hidden" name="pay_type" id="pay_type" value="Income">
                    <input type="hidden" name="act" value="add_product">

                    <!-- Person Selection Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="font-weight-bold text-uppercase text-muted small mb-2">Transaction Party</label>
                            <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                <label class="btn btn-outline-secondary active btn-sm" onclick="$('#trans-box').val(''); $('#customer_id').val('0');">
                                    <input type="radio" name="ty_p" id="customRadio1" value="0" checked> <?php echo $this->lang->line('Customer') ?>
                                </label>
                                <label class="btn btn-outline-secondary btn-sm" onclick="$('#trans-box').val(''); $('#customer_id').val('0');">
                                    <input type="radio" name="ty_p" id="customRadio2" value="1"> <?php echo $this->lang->line('Supplier') ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                             <label class="font-weight-bold text-uppercase text-muted small mb-2">Search Party</label>
                             <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text bg-white border-right-0"><i class="fa fa-search text-muted"></i></span>
                                  </div>
                                  <input type="text" class="form-control border-left-0" name="cst" id="trans-box"
                                        placeholder="Enter Name or Mobile to identify the party (Optional)"
                                        autocomplete="off">
                             </div>
                             <div id="trans-box-result" class="sbox-result" style="position: absolute; z-index: 1000; width: 95%; background: white; border: 1px solid #ddd; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                         <div class="col-sm-3">
                            <label for="customer_name" class="font-weight-bold"><?php echo $this->lang->line('C/o') ?></label>
                            <input type="hidden" name="payer_id" id="customer_id" value="0">
                            <input type="text" class="form-control" name="payer_name" id="customer_name" placeholder="Party Name">
                        </div>
                        <div class="col-sm-3">
                            <label class="font-weight-bold" for="date"><?php echo $this->lang->line('Date') ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control required" name="date" data-toggle="datepicker" autocomplete="false" value="<?php echo date('d-m-Y') ?>">
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <label class="font-weight-bold" for="amount"><?php echo $this->lang->line('Amount') ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $this->config->item('currency'); ?></span>
                                </div>
                                <input type="text" placeholder="0.00" class="form-control required" name="amount" id="main_amount" value="0" onkeypress="return isNumber(event)" style="font-size: 1.2rem; font-weight: bold;">
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <label class="font-weight-bold" for="paymethod"><?php echo $this->lang->line('Method') ?> </label>
                            <select name="paymethod" id="paymethod_trans" class="form-control custom-select">
                                <option value="Bank" selected><?php echo $this->lang->line('Bank') ?></option>
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Cheque"><?php echo $this->lang->line('Cheque') ?></option>
                                <option value="Other"><?php echo $this->lang->line('Other') ?></option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4" style="border-top: 1px dashed #ddd;">

                    <!-- Balanced Entry Logic -->
                    <div class="row">
                        <!-- Debit Side -->
                        <div class="col-md-6">
                            <div class="card shadow-sm entry-side" id="debit_card" style="border-left: 5px solid #28a745; background: #f8fff9;">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <h5 class="text-success font-weight-bold"><i class="fa fa-plus-circle"></i> DEBIT (IN)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0" id="debit_selector_container">
                                        <!-- Will be swapped by JS -->
                                        <label class="small text-muted font-weight-bold" id="debit_label">Receiving Account</label>
                                        <div id="debit_field_placeholder"></div>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <span class="badge badge-success px-3 py-1" id="debit_amount_display" style="font-size: 1rem;">$ 0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Credit Side -->
                        <div class="col-md-6">
                            <div class="card shadow-sm entry-side" id="credit_card" style="border-left: 5px solid #dc3545; background: #fff8f8;">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <h5 class="text-danger font-weight-bold"><i class="fa fa-minus-circle"></i> CREDIT (OUT)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0" id="credit_selector_container">
                                         <!-- Will be swapped by JS -->
                                         <label class="small text-muted font-weight-bold" id="credit_label">Source Category</label>
                                         <div id="credit_field_placeholder"></div>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <span class="badge badge-danger px-3 py-1" id="credit_amount_display" style="font-size: 1rem;">$ 0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="row mt-4">
                        <div class="col-md-6" id="cheque_number_row_trans" style="display: none;">
                             <label class="font-weight-bold" for="cheque_number"><?php echo $this->lang->line('Cheque Number') ?></label>
                             <input type="text" class="form-control border-warning" name="cheque_number" id="cheque_number_trans" placeholder="Ex: CHQ-882299">
                        </div>
                        <div class="col-md-12 mt-2">
                             <label class="font-weight-bold"><?php echo $this->lang->line('Note') ?></label>
                            <textarea placeholder="Enter detailed transaction notes here..." class="form-control" name="note" rows="2" style="border-radius: 8px;"></textarea>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                             <button type="submit" id="submit-data" class="btn btn-primary btn-lg btn-block shadow-lg py-3" style="border-radius: 12px; font-weight: 800; letter-spacing: 1px; transition: all 0.3s;">
                                 <i class="fa fa-save mr-2"></i> POST TRANSACTION
                             </button>
                             <input type="hidden" value="transactions/save_trans" id="action-url">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Templates for JS to Swap -->
<div id="select_templates" style="display: none;">
    <!-- Main Account Select -->
    <select id="tpl_main_acc" name="pay_acc" class="form-control custom-select">
        <?php
        foreach ($accounts as $row) {
            $cid = $row['id'];
            $acn = $row['acn'];
            $holder = $row['holder'];
            echo "<option value='$cid'>$acn - $holder</option>";
        }
        ?>
    </select>

    <!-- Category Select with Data Attributes -->
    <select id="tpl_cat" name="pay_cat" class="form-control custom-select" onchange="handleCatChange(this)">
        <option value="0">-- Select Category --</option>
        <?php
        foreach ($cat as $row) {
            $id = $row['id'];
            $title = $row['name'];
            $dual_acid = $row['dual_acid'];
            echo "<option value='$id' data-dual='$dual_acid'>$title</option>";
        }
        ?>
    </select>

    <!-- Balanced Account Select (Secondary) -->
    <select id="tpl_dual_acc" name="f_pay_acc" class="form-control custom-select">
        <option value="0">-- Manual Selection --</option>
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

<script type="text/javascript">
    // Visual Logic
    function setPayType(type) {
        $('#pay_type').val(type);
        
        const main_acc = $('#tpl_main_acc').clone().removeAttr('id');
        const cat_select = $('#tpl_cat').clone().removeAttr('id');
        const dual_acc = $('#tpl_dual_acc').clone().removeAttr('id');

        if (type === 'Income') {
            // Header Styles
            $('#tab-income').addClass('active btn-outline-light');
            $('#tab-expense').removeClass('active btn-outline-light');
            $('#main_header').css('background', 'linear-gradient(135deg, #1a1412 0%, #1b5e20 100%)');
            $('#type_hint').text('Money going INTO your account');
            $('#submit-data').removeClass('btn-danger').addClass('btn-success').html('<i class="fa fa-save mr-2"></i> POST INCOME ENTRY');

            // DEBIT = Main Account (Money In)
            $('#debit_label').text('Revenue Target (Bank/Cash)');
            $('#debit_field_placeholder').html(main_acc);
            
            // CREDIT = Category/Offset (Source of Income)
            $('#credit_label').text('Income Source (Category)');
            
            // Create a wrapper for Category + Offset Account
            let credit_html = '<div class="row"><div class="col-md-6">' + cat_select.prop('outerHTML') + '</div>';
            credit_html += '<div class="col-md-6">' + dual_acc.prop('outerHTML') + '</div></div>';
            $('#credit_field_placeholder').html(credit_html);

            // Entry Side UI adjustments
            $('#debit_card').css({'border-left': '5px solid #28a745', 'background': '#f8fff9'});
            $('#credit_card').css({'border-left': '5px solid #6c757d', 'background': '#f8f9fa'}); // Grey for offset source

        } else {
            // Header Styles
            $('#tab-expense').addClass('active btn-outline-light');
            $('#tab-income').removeClass('active btn-outline-light');
            $('#main_header').css('background', 'linear-gradient(135deg, #1a1412 0%, #b71c1c 100%)');
            $('#type_hint').text('Money going OUT OF your account');
            $('#submit-data').removeClass('btn-success').addClass('btn-danger').html('<i class="fa fa-save mr-2"></i> POST EXPENSE ENTRY');

            // DEBIT = Category/Offset (Purpose of Expense)
            $('#debit_label').text('Expense Purpose (Category)');
            let debit_html = '<div class="row"><div class="col-md-6">' + cat_select.prop('outerHTML') + '</div>';
            debit_html += '<div class="col-md-6">' + dual_acc.prop('outerHTML') + '</div></div>';
            $('#debit_field_placeholder').html(debit_html);

            // CREDIT = Main Account (Money Out)
            $('#credit_label').text('Funding Source (Bank/Cash)');
            $('#credit_field_placeholder').html(main_acc);

            // Entry Side UI adjustments
            $('#credit_card').css({'border-left': '5px solid #dc3545', 'background': '#fff8f8'});
            $('#debit_card').css({'border-left': '5px solid #6c757d', 'background': '#f8f9fa'});
        }
        
        updateDisplays();
    }

    function handleCatChange(el) {
        const dual_id = $(el).find(':selected').data('dual');
        // Find the f_pay_acc in the same context
        const dual_select = $(el).closest('.row').find('select[name="f_pay_acc"]');
        if (dual_id > 0) {
            dual_select.val(dual_id).addClass('border-success shadow-sm');
            setTimeout(() => dual_select.removeClass('border-success shadow-sm'), 1000);
        } else {
            dual_select.val(0);
        }
    }

    function updateDisplays() {
        const amt = parseFloat($('#main_amount').val()) || 0;
        const formatted = amt.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $('#debit_amount_display').text('<?php echo $this->config->item('currency'); ?> ' + formatted);
        $('#credit_amount_display').text('<?php echo $this->config->item('currency'); ?> ' + formatted);
    }

    $(document).ready(function() {
        setPayType('Income');
        
        $('#main_amount').on('keyup change', function() {
            updateDisplays();
        });

        $('#paymethod_trans').on('change', function() {
            if ($(this).val() == 'Bank' || $(this).val() == 'Cheque') {
                $('#cheque_number_row_trans').slideDown();
            } else {
                $('#cheque_number_row_trans').slideUp();
                $('#cheque_number_trans').val('');
            }
        });

        // Search logic
        $("#trans-box").keyup(function () {
            $.ajax({
                type: "GET",
                url: baseurl + 'search_products/party_search',
                data: 'keyword=' + $(this).val() + '&ty=' + $('input[name=ty_p]:checked').val(),
                beforeSend: function () {
                    $("#trans-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 98%");
                },
                success: function (data) {
                    $("#trans-box-result").show();
                    $("#trans-box-result").html(data);
                    $("#trans-box").css("background", "none");
                }
            });
        });
    });
</script>

<style>
/* Modern Fine-tuning */
.entry-side {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 180px;
}
.entry-side:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.custom-select {
    height: 45px !important;
    border-radius: 8px !important;
}
.form-control {
    border-radius: 8px;
}
.badge-success { background-color: #28a745; }
.badge-danger { background-color: #dc3545; }
.btn-outline-light.active {
    background-color: rgba(255,255,255,0.2) !important;
    box-shadow: 0 0 15px rgba(255,255,255,0.3) !important;
}
</style>
