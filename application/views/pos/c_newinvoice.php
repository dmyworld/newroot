<form method="post" id="data_form">
    <div class="row ">
        <div class="col-md-6 card p-mobile">
            <div class="input-group mt-1">
                <a href='#'
                   class="btn btn-primary  round "
                   data-toggle="modal"
                   data-target="#Pos_addCustomer">
                    <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add') ?>
                </a>
               <input type="text" class="form-control" name="cst" id="supplier-box"
                                               placeholder="Enter Supplier Name or Mobile Number to search"
                                               autocomplete="off"/>

                                        
            </div>
           
  
            <div class="row ml-3">
                <div id="supplier-box-result" class="col-md-12"></div>
                <div id="customer" class="col-md-12 ml-3">
                    <div class="clientinfo">
                                        
                                        
                                        <input type="hidden" name="customer_id" id="customer_id" value="0">
                                        <div id="customer_name"></div>
                                    </div>
                </div>
            </div>
            <div id="saman-row-purchase" class="rqw mt-1">
                <div class="col p-mobile">
                    <table id="pos_list" class="table-responsive tfr pos_stripe">
                        <thead>
                        <tr class="item_header bg-gradient-directional-purple white">
                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                            <th width="20%"
                                class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('TAX') ?></th>
                            <th width="10%"
                                class="text-center">Product Cost</th>
                            <th width="10%"
                                class="text-center">Profit Rate</th>
                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                            <th width="10%" class="text-center">
                                <?php echo $this->lang->line('Amount') ?>
                            </th>
                            <th width="5%"
                                class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                        </thead>
                        <tbody id="purchase_items">
                        </tbody>
                    </table>
                    <br>
                    <hr> 
<!--                    <div class="row mt-1">
                        <div class="col-3"><input type="hidden" value="0" id="subttlform"
                                                  name="subtotal"> <input type="hidden" value="0"
                                                                          id="custom_discount"><strong><?php// echo $this->lang->line('Total Tax') ?></strong>
                        </div>
                        <div class="col-6"><span
                                    class="currenty lightMode"><?php //echo $this->config->item('currency'); ?></span>
                            <span id="taxr" class="lightMode">0</span></div>
                    </div>-->
                    <div class="row mt-1">
                        <div class="col-3">
                            <strong><?php echo $this->lang->line('Total Discount') ?></strong></div>
                        <div class="col-6"><span
                                    class="currenty lightMode"><?php echo $this->config->item('currency');
                                if (isset($_GET['project'])) {
                                    echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                } ?></span>
                            <span id="discs" class="lightMode">0</span></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3">
                            <strong>Transport</strong></div>
                        <div class="col-6"><input type="text" class="form-control shipVal"
                                                  onkeypress="return isNumber(event)"
                                                  placeholder="Value"
                                                  name="shipping" autocomplete="off"
                                                  onkeyup="billUpyog()">
                            ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                            <span id="ship_final">0</span> )
                        </div>
                    </div>

                     
                               
                    
                   
                                
                     
     
                </div>
              

              
                <div class="row mt-1">
                    <div class="col-3"><strong><?php echo $this->lang->line('Grand Total') ?>
                            (<span
                                    class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                    </div>
                    <div class="col-6"><input type="text" name="total" class="form-control"
                                              id="invoiceyoghtml" readonly=""></div>


                </div>
                <div class="row mt-1">
                    <div class="col-3">
                        <strong> <?php echo $this->lang->line('Extra') . ' ' . $this->lang->line('Discount') ?></strong>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm discVal"
                               onkeypress="return isNumber(event)"
                               placeholder="Value"
                               name="disc_val" autocomplete="off" value="0"
                               onkeyup="billUpyog()">
                        <input type="hidden" value="0"
                               name="after_disc" id="after_disc">
                    </div>
                    <div class="col-3">
                        ( <?= $this->config->item('currency'); ?>
                        <span id="disc_final">0</span> )
                    </div>
                </div>
                <hr>

                <div class="row mt-1">
                    <div class="col-md-12 text-center">
                        
                                                      <td align="right" colspan="4"><input type="submit" class="btn btn-success sub-btn"
                                                                     value="<?php echo $this->lang->line('Generate Order') ?>"
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>

                    </div>
                </div>

                <hr>
                <ul class="nav nav-tabs" role="tablist">
                    
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary mr-1 mb-1" id="base-tab2" data-toggle="tab"
                           aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i
                                    class="icon-handbag"></i>
                          Purchase Settings</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="btn btn-outline-success mb-1" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                           href="#tab4" role="tab" aria-selected="false"><i class="fa fa-cogs"></i>
                            Purchase Properties</a>
                    </li>
                </ul>
                <div class="tab-content px-1 pt-1">
                    <div class="tab-pane" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                        <div class="input-group">

                            <input type="text" class="form-control"
                                   id="coupon" name="coupon"><input type="hidden"
                                                                    name="coupon_amount"
                                                                    id="coupon_amount"
                                                                    value="0"><span
                                    class="input-group-addon round"> <button
                                        class="apply_coupon btn btn-small btn-primary sub-btn"><?php echo $this->lang->line('Apply') ?></button></span>


                        </div>
                        <input type="hidden" class="text-info" name="i_coupon" id="i_coupon"
                               value="">
                        <span class="text-primary text-bold-600" id="r_coupon"></span>
                    </div>
                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                        <div class="row">
                            <div class="col-4 blue text-xs-center"><?php echo $this->lang->line('Warehouse') ?>
                                <select
                                        id="warehouses"
                                        class="selectpicker form-control round teal">
                                    <?php echo $this->common->default_warehouse();
                                    echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>

                                </select></div>
                            <div class="col-4 blue text-xs-center">Product Cost
                            <select class="form-control round" onchange="changeTaxFormat(this.value)" id="taxformat">
                                    <option value="yes" selected="">»On</option>
                                    <option value="off" data-tformat="yes">Off</option>
                            </select>
                            </div>
                            <div class="col-4 blue text-xs-center">  <?php echo $this->lang->line('Discount') ?>
                                <select class="form-control round teal"
                                        onchange="changeDiscountFormat(this.value)"
                                        id="discountFormat">
   
                                    <?php echo $this->common->disclist() ?>
                                </select>

                            </div>
                        </div>
                    </div> 
                    
                    <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="invocieno"
                                                         class="caption"> Order Number </label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-file-text-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                     <input type="text" class="form-control" placeholder="Order #"
                                                   name="invocieno"
                                                   value="<?php echo $lastinvoice + 1 ?>">
                                </div>
                            </div>
                            <div class="col-sm-3"><label for="invocieno"
                                                         class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control"
                                           placeholder="Reference #"
                                           name="refer">
                                </div>
                            </div>


                            <div class="col-sm-3"><label for="invociedate"
                                                         class="caption"><?php echo $this->lang->line('Order Date') ?> </label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar4"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control required"
                                           placeholder="Billing Date" name="invoicedate"
                                           data-toggle="datepicker"
                                           autocomplete="false">
                                </div>
                            </div>
                            <div class="col-sm-3"><label for="invocieduedate"
                                                         class="caption"><?php echo $this->lang->line('Order Due Date') ?> </label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control required" id="tsn_due"
                                           name="invocieduedate"
                                           placeholder="Due Date" data-toggle="datepicker"
                                           autocomplete="false">
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-6">
                                <?php echo $this->lang->line('Payment Terms') ?> <select
                                        name="pterms"
                                        class="selectpicker form-control"><?php foreach ($terms as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>

                                </select>
                                <?php if ($exchange['active'] == 1) {
                                    echo $this->lang->line('Payment Currency client') ?>
                                <?php } ?>
                                <?php if ($exchange['active'] == 1) {
                                    ?>
                                    <select name="mcurrency"
                                            class="selectpicker form-control">
                                    <option value="0">Default</option>
                                    <?php foreach ($currency as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                    } ?>

                                    </select><?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <label for="toAddInfo"
                                       class="caption"><?php echo $this->lang->line('Order Note') ?> </label>
                                <textarea class="form-control" name="notes" rows="2"></textarea>
                            </div>
                            
                            <td colspan="2">
                                    <div>
                                        <label><?php echo $this->lang->line('Update Stock') ?></label>
                                        <fieldset class="right-radio">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="update_stock"
                                                       id="customRadioRight1" value="yes" checked="">
                                                <label class="custom-control-label"
                                                       for="customRadioRight1"><?php echo $this->lang->line('Yes') ?></label>
                                            </div>
                                        </fieldset>
                                        <fieldset class="right-radio">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="update_stock"
                                                       id="customRadioRight2" value="no">
                                                <label class="custom-control-label"
                                                       for="customRadioRight2"><?php echo $this->lang->line('No') ?></label>
                                            </div>
                                        </fieldset>

                                    </div>
                                </td>
                        </div>


                    </div>
                </div>


            </div>

        </div>


        <div class="col-md-6 card  order-sm-first  order-md-2 border-amber bg-lighten-1 bg-faded round pt-1">


            <div class="row border-bottom-grey-blue  border-bottom-lighten-4">


                <div class="col-md-9 pb-1">
                    <input type="text" class="form-control text-center round mousetrap"
                           name="product_barcode"
                           placeholder="Enter Product name, scan barcode " id="search_bar"
                           autocomplete="off" autofocus="autofocus">
                </div>
                <div class="col-md-3  grey text-xs-center"><select
                            id="categories"
                            class="form-control round teal">
                        <option value="0"><?php echo $this->lang->line('All') ?></option><?php
                        foreach ($cat as $row) {
                            $cid = $row['id'];
                            $title = $row['title'];
                            echo "<option value='$cid'>$title</option>";
                        }
                        ?>
                    </select></div>


            </div>


            <div class="row">
                <div class="col-md-12 pt-0" id="pos_item">
                    <!-- pos items -->
                </div>
            </div>
        </div>
    </div>
    </div>
     <input type="hidden" value="pos_invoices/actionstockreturn" id="action-url">
    <input type="hidden" value="search" id="billtype">
    <input type="hidden" value="0" name="counter" id="ganak">
    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
    <input type="hidden" value="<?= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
    <input type="hidden" value="<?= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
    <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>" name="discountFormat"
           id="discount_format">
    <input type="hidden" value="<?= amountFormat_general($this->common->disc_status()['ship_rate']); ?>" name="shipRate"
           id="ship_rate">
    <input type="hidden" value="<?= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
           id="ship_taxtype">
    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
</form>

 



<div class="modal fade" id="Pos_addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-info white">

                    <h4 class="modal-title" id="myModalLabel"><i
                                class="icon-user-plus"></i> <?php echo $this->lang->line('Add Supplier') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-12">
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
                                               for="taxid"><?php echo $this->lang->line('TAX') ?> ID</label>

                                <div class="col-sm-10">
                                               
                                                <input type="text" placeholder="TAX ID"
                                                   class="form-control margin-bottom" name="taxid" id="mcustomer_taxid">
                                               
                                   
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

                            


                        </div>
                        
                        
                        
                        

                        <!-- shipping -->


                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="msupplier_add" class="btn btn-primary submitBtn"
                           value="<?php echo $this->lang->line('ADD') ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade" id="stock_alert" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Stock Alert') ?> !</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row p-1">
                    <div class="alert alert-danger mb-2" role="alert">
                        <strong>Oh snap!</strong> <?php echo $this->lang->line('order or edit the stock') ?>
                    </div>
                </div>

            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajax({
        url: baseurl + 'search_products/pos_search',
        dataType: 'html',
        method: 'POST',
        data: 'cid=' + $('#categories').val() + '&wid=' + $('#warehouses option:selected').val() + '&' + crsf_token + '=' + crsf_hash,
        success: function (data) {
            $('#pos_item').html(data);
        }
    });

    function update_register() {
        $.ajax({
            url: baseurl + 'register/status',
            dataType: 'json',
            success: function (data) {
                $('#r_cash').val(data.cash);
                $('#r_card').val(data.card);
                $('#r_bank').val(data.bank);
                $('#r_change').val(data.change);
                $('#r_date').text(data.date);
            }
        });
    }

    update_register();
    $(".possubmit").on("click", function (e) {
        e.preventDefault();
        var o_data = $("#data_form").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
    });
    $(".possubmit2").on("click", function (e) {
        e.preventDefault();
        $('#card_total').val(Number($('#invoiceyoghtml').val()));
    });
    $(".possubmit3").on("click", function (e) {
        e.preventDefault();
       var roundoff = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
    
    
        //var roundoff_ssc = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        //sscchargers_val = (roundoff_ssc / 100) * 2.5;
       // var roundoff =  parseFloat(roundoff_ssc + sscchargers_val).toFixed(2);
                      
							     
		   
        <?php
        $round_off = $this->custom->api_config(4);
        if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
            echo ' roundoff=Math.ceil(roundoff);';
        } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
            echo ' roundoff=Math.floor(roundoff);';
        }
        ?>
        $('#b_total').html(' <?= $this->config->item('currency'); ?> ' + accounting.formatNumber(roundoff));
        $('#p_amount').val(accounting.formatNumber(roundoff));
    });

    function update_pay_pos() {
        var am_pos = accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal);
        var ttl_pos = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
       // var ttl_pos_ssc = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        //sscchargers_val = (ttl_pos_ssc / 100) * 2.5;
       // var ttl_pos =  parseFloat(ttl_pos_ssc + sscchargers_val).toFixed(2);
    
    
    
        <?php
        $round_off = $this->custom->api_config(4);
        if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
            echo ' ttl_pos=Math.ceil(ttl_pos);';
        } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
            echo ' ttl_pos=Math.floor(ttl_pos);';
        }
        ?>
        var due = parseFloat(ttl_pos - am_pos).toFixed(2);
        if (due >= 0) {
            $('#balance1').val(accounting.formatNumber(due));
            $('#change_p').val(0);
        } else {
            due = due * (-1)
            $('#balance1').val(0);
            $('#change_p').val(accounting.formatNumber(due));
        }
    }

    $('#pos_card_pay').on("click", function (e) {
        e.preventDefault();
        $('#cardPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&' + $("#card_data").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        update_register();
    });
    $('#pos_basic_pay').on("click", function (e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal) + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type')+ '&account=' + $("#p_account option:selected").val();
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        setTimeout(
            function () {
                update_register();
            }, 3000);
    });
</script>
<!-- Vendor libraries -->
<script type="text/javascript">
    var $form = $('#payment-form');
    $form.on('submit', payWithCard);

    /* If you're using Stripe for payments */
    function payWithCard(e) {
        e.preventDefault();
        /* Visual feedback */
        $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>')
            .prop('disabled', true);
        jQuery.ajax({
            url: '<?php echo base_url('billing/process_card') ?>',
            type: 'POST',
            data: $('#payment-form').serialize(),
            dataType: 'json',
            success: function (data) {
                $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
            },
            error: function () {
                $form.find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                /* Show Stripe errors on the form */
                $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                $form.find('.payment-errors').closest('.row').show();
                $form.find('[type=submit]').html('Error! <i class="fa fa-exclamation-circle"></i>')
                    .prop('disabled', true);
                $("#notify .message").html("<strong>Error</strong>: Please try again!");
            }
        });
    }

    $(document).ready(function () {
        Mousetrap.bind('alt+x', function () {
            $('#search_bar').focus();
        });
        Mousetrap.bind('alt+c', function () {
            $('#pos-customer-box').focus();
        });
        Mousetrap.bind('alt+z', function () {
            $('.possubmit2').click();
        });
        Mousetrap.bind('alt+n', function () {
            window.location.href = "<?=base_url('pos_invoices/create') ?>";
        });
        Mousetrap.bind('alt+q', function () {
            $('#posp0').click();
            $('#search_bar').val('');
        });
        Mousetrap.bind('alt+s', function () {
            if ($('#basicPay').hasClass('in')) {
                $('#pos_basic_print').click();
            } else {
                $('.possubmit3').click();
            }
        });
        $('#search_bar').keypress(function (event) {
            if (event.keyCode == 13) {
                setTimeout(
                    function () {
                        $('#posp0').click();
                        $('#search_bar').val('');
                    }, 700);

            }
        });
    });
</script>