<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">


                    <div class="row">

                        <div class="col-sm-4">

                        </div>

                        <div class="col-sm-3"></div>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-3">

                        </div>

                    </div>

                    <div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            Trunks Processing From  <a href='#'
                                                                                            class="btn btn-primary btn-sm rounded"
                                                                                            data-toggle="modal"
                                                                                            data-target="#addCustomer">
                                                 Add Worker
                                            </a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst"
                                                                            class="caption"> Search Worker</label>
                                        <input type="text" class="form-control" name="cst" id="supplier-box"
                                               placeholder="Enter Worker Name or Mobile Number to search"
                                               autocomplete="off"/>

                                        <div id="supplier-box-result"></div>
                                    </div>

                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                        Worker Details 
                                        <hr>
                                        <input type="hidden" name="customer_id" id="customer_id" value="0">
                                        <div id="customer_name"></div>
                                    </div>
                                    <div class="clientinfo">

                                        <div id="customer_address1"></div>
                                    </div>

                                    <div class="clientinfo">

                                        <div type="text" id="customer_phone"></div>
                                    </div>
                                    <hr><?php echo $this->lang->line('Warehouse') ?> <select id="s_warehouses"
                                                                                             class="selectpicker form-control">
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
                                                class="title">Trunks Processing </h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption">Trunks Processing Number  </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Invoice #"
                                                   name="invocieno"
                                                   value="<?php echo $lastinvoice + 1 ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?> </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Reference #"
                                                   name="refer">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="invociedate"
                                                                 class="caption">Trunks Processing Date  </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="invoicedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieduedate"
                                                                 class="caption">Trunks Processing Due Date  </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required" id="tsn_due"
                                                   name="invocieduedate"
                                                   placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo"
                                               class="caption">Trunks Processing Note </label>
                                        <textarea class="form-control" name="notes" rows="2"></textarea></div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div id="saman-row3">
                        <table class="table-responsive tfr my_stripe">
                            <thead>

                            <tr class="item_header bg-gradient-directional-amber">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                              
                                <th width="8%" class="text-center">Raund</th>
                                <th width="10%" class="text-center">Lenth</th>
                               
                                <th width="10%" class="text-center">
                                    <?php echo $this->lang->line('Amount') ?>
                                    (<?php echo $this->config->item('currency'); ?>)
                                </th>
                                <th width="5%" class="text-center">.........<?php echo $this->lang->line('Action') ?>.........</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="product_name2[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='productname-0'>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="calculateQuick('0'), rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="1"></td>
                                
                                <td><input type="text" class="form-control req prc" name="product_r[]" id="r-0" onkeypress="return isNumber(event)" onkeyup="calculateQuick('0'), rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                <td><input type="text" class="form-control req prc" name="product_l[]" id="l-0" onkeypress="return isNumber(event)" onkeyup="calculateQuick('0'), rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                
                                
                                <td>
                                    <span class="currenty">ft&#179; :</span>
                                    <strong><span class='ttlTextt' name="result" id="result2-0">0</span></strong>
                                    <br>
                                    <span class="currenty">Total Cubic :</span>
                                    <strong><span class='woodttlText' name="result" id="result3wood-0">0</span></strong>
                                </td>
                                <td class="text-center">

                                </td>
                                <input type="hidden" name="result[]" id="result22-0" value="0">
                                <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                <input type="hidden" name="disca[]" id="disca-0" value="0">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total2-0" value="0">
                                
                                <input type="hidden" class="ttInput" name="product_quick[]" id="tpquick2-0" value="0">
                                <input type="hidden" name="pquick[]" id="pquick-0" value="">
                                
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                <input type="hidden" name="unit[]" id="unit-0" value="">
                                <input type="hidden" name="hsn[]" id="hsn-0" value="">
                                <input type="hidden" name="product_description[]" id="product_description-0" value="">
                                <input type="hidden" name="product_quick_code[]" id="product_quick_code-0" value="">
                            </tr>
 

                            <tr class="last-item-row">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addproduct_secondary">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="5"></td>
                            </tr>
 
                         

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong>Worker Salary</strong></td>
                                <td align="left" colspan="2">
 <input type="text" class="form-control " name="shipping" id="shipval2" onkeypress="return isNumber(event)" onkeyup="updateGrandTotal()" autocomplete="off">                                   
                                    
                                 
                                </td>
                            </tr>
                            
                            
                            
                            
                                  <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong>Trunks Cubic Feet Total:</strong></td>
                                <td align="left" colspan="2">
    <input type="text" name="overall_cubic_feet_total" class="form-control" id="overall_cubic_feet_total" readonly="">
</td>
                            </tr>
                            

                                  <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong>Wood Cubic Feet Total:</strong></td>
                                <td align="left" colspan="2">
    <input type="text" name="wood_overall_cubic_feet_total" class="form-control" id="wood_overall_cubic_feet_total" readonly="">
</td>
                            </tr>                            

                            
                                                              <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong>Cubic Feet Total Wastage:</strong></td>
                                <td align="left" colspan="2">
    <input type="text" name="cubic_feet_total_wastage" class="form-control" id="cubic_feet_total_wastage" readonly="">
</td>
                            </tr>  
                            
                            
             
                                
                          
                            
                            
                            
                            
                           
                            
                            
                            
                            
                            
                            
                            
                            
                            <tr class="sub_c" style="display: table-row;">
                                
                                
                                <td align="right" colspan="4"><input type="submit" class="btn btn-success sub-btn"
                                                                     value="<?php echo $this->lang->line('Generate Order') ?>"
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>

                    <input type="hidden" value="purchase/action_woodprocessing" id="action-url">
                    <input type="hidden" value="puchase_search2" id="billtype">
                    <input type="hidden" value="search_logs_wood" id="billtype2"> 
                    <input type="hidden" value="0" name="counter" id="ganak3">
                    <input type="hidden" value="0" name="wood_overall_cubic_feet_total" id="wood_overall_cubic_feet_total">
                    
                    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
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

                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-success white">

                    <h4 class="modal-title" id="myModalLabel">Add Worker</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">


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

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-10">
                            <input type="email" placeholder="Email"
                                   class="form-control margin-bottom crequired" name="email" id="mcustomer_email">
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


                        <div class="col-sm-4">
                            <input type="text" placeholder="City"
                                   class="form-control margin-bottom" name="city" id="mcustomer_city">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country" id="mcustomer_country">
                        </div>

                    </div>

                    <div class="form-group row">


                        <div class="col-sm-6">
                            <input type="text" placeholder="PostBox"
                                   class="form-control margin-bottom" name="postbox">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="TAX ID"
                                   class="form-control margin-bottom" name="taxid" id="tax_id">
                        </div>
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
