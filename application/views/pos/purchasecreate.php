<style>
/* POS Product Card Design */
.pos-product-card {
    border: none;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 250px;
    margin-bottom: 10px;
}
.pos-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
}
.pos-card-img-container {
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #eee;
}
.pos-card-img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s;
}
.pos-product-card:hover .pos-card-img {
    transform: scale(1.05);
}
.pos-card-body {
    padding: 12px;
    text-align: center;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.pos-card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    line-height: 1.3;
    min-height: 2.6em; /* 2 lines */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.pos-card-price {
    font-weight: 700;
    color: #28a745;
    font-size: 1.1rem;
}
.pos-card-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.2s;
}
.pos-product-card:hover .pos-card-actions {
    opacity: 1;
}
.pos-action-btn {
    background: #fff;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    color: #555;
    font-size: 12px;
    text-decoration: none !important;
}
.pos-action-btn:hover {
    color: #007bff;
    background: #f0f0f0;
}

/* POS Items Table Design */
.bg-gradient-directional-purple {
    background-image: linear-gradient(45deg, #6f42c1, #a88be2);
    color: white;
}


/* POS Items Table Design */
.bg-gradient-directional-purple {
    background-image: linear-gradient(45deg, #6f42c1, #a88be2);
    color: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

#pos_list {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.02);
}

#pos_items tr {
    transition: background-color 0.2s;
    border-bottom: 1px solid #f0f0f0;
}

#pos_items tr:hover {
    background-color: #fcfcfc;
}

#pos_items td {
    vertical-align: middle !important;
    padding: 8px 4px !important;
}

#pos_items input.form-control {
    border: 1px solid transparent; /* Cleaner look, show border on hover/focus */
    background-color: transparent;
    border-radius: 6px;
    padding: 6px 8px;
    font-size: 14px;
    height: 38px;
    transition: all 0.2s;
    text-align: center; /* Center text for rate, qty, etc. */
}

#pos_items input.product-name-input {
    text-align: left !important;
    font-weight: 500;
    color: #333;
}

#pos_items input.form-control:hover {
    border-color: #e0e0e0;
    background-color: #f9f9f9;
}

#pos_items input.form-control:focus {
    border-color: #8f7ae2; /* Match theme */
    box-shadow: 0 0 0 0.2rem rgba(143, 122, 226, 0.15);
    background-color: #fff;
}

/* Product Name Input Specifics */
#pos_items input[name="product_name[]"] {
    font-weight: 600;
    color: #495057;
}

/* Totals and Text */
.ttlText {
    color: #2e7d32;
    font-weight: 700;
    font-size: 14px;
    display: inline-block;
}

.currenty {
    font-size: 12px;
    color: #777;
    margin-right: 2px;
}

.planingText {
    color: #1976d2;
    font-size: 11px;
    display: block;
    margin-top: 2px;
}

/* Remove Button */
#pos_items .removeItem {
    border-radius: 50%;
    width: 28px;
    height: 28px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #ffebee; /* Softer red bg */
    border: 1px solid #ffcdd2;
    color: #e53935;
    transition: all 0.2s;
    box-shadow: none;
}

#pos_items .removeItem:hover {
    background-color: #e53935;
    border-color: #e53935;
    color: #fff;
    transform: scale(1.1);
    box-shadow: 0 2px 4px rgba(229, 57, 53, 0.3);
}

/* Fixed Table Height */
.table-responsive.tfr {
    height: calc(100vh - 420px);
    overflow-y: auto;
    min-height: 350px;
    border: 1px solid #f0f0f0; /* Subtle border */
    border-radius: 0 0 8px 8px;
}

/* Custom Scrollbar for sleekness */
.table-responsive.tfr::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.table-responsive.tfr::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.table-responsive.tfr::-webkit-scrollbar-thumb {
    background: #d1d1d1;
    border-radius: 4px;
}
.table-responsive.tfr::-webkit-scrollbar-thumb:hover {
    background: #b0b0b0;
}

/* Header Adjustments */
.item_header th {
    padding: 12px 6px !important;
    font-weight: 600;
    font-size: 13px;
    border: none;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    font-size: 11px; /* Smaller, cleaner header text */
}

/* Product Search Area Fixed Height */
#pos_item {
    height: calc(100vh - 200px);
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 5px;
}

#pos_item::-webkit-scrollbar {
    width: 6px;
}
#pos_item::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

/* Full Page Layout Fixes */
body {
    overflow: hidden; /* Ensure body doesn't scroll */
}
.content-wrapper {
    height: 100vh;
    overflow: hidden;
}
.row.match-height {
    height: calc(100vh - 70px); /* Adjust for header */
}
.col-md-6.card {
     height: calc(100vh - 100px); /* Fill vertical space */
     display: flex;
     flex-direction: column;
     overflow: hidden; /* Prevent card itself from scrolling */
     margin-bottom: 0 !important;
}

/* Left Side (Cart) Container */
#saman-row-pos {
    flex-grow: 1;
    overflow: hidden; /* Prevent container scroll */
    display: flex;
    flex-direction: column;
    padding-right: 5px;
}
#saman-row-pos .col {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
}

/* New Wrapper for Table Scrolling */
#pos-table-scroll {
    flex-grow: 1;
    overflow-y: auto;
    min-height: 0;
    margin-bottom: 10px;
}
/* Footer stays fixed */
#pos-footer-fixed {
    flex-shrink: 0;
    overflow-y: auto;
    max-height: 60vh; /* Allow footer to take more space if needed, as it has the card */
    padding-bottom: 10px;
}

/* Right Side (Product Grid) */
#pos_item {
    flex-grow: 1;
    height: calc(100vh - 220px) !important; /* Fixed height for scrolling */
    overflow-y: auto; 
    padding-right: 5px;
    padding-bottom: 50px;
}
/* Custom Scrollbar for pos_item */
#pos_item::-webkit-scrollbar {
    width: 6px;
}
#pos_item::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 4px;
}

</style>
<form method="post" id="data_form">
    <div class="row ">
        <div class="col-md-6 card  order-sm-first  order-md-2 border-amber bg-lighten-1 bg-faded round pt-1">
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
            <div id="saman-row-pos" class="rqw mt-1">
                <div class="col p-mobile">
                    <div id="pos-table-scroll">
                    <table id="pos_list" class="table-responsive tfr pos_stripe">
                        <thead>
                        <tr class="item_header bg-gradient-directional-purple white">
                            <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                            <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                            <th width="10%" class="text-center">
                                <?php echo $this->lang->line('Amount') ?>
                            </th>
                            <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                        </thead>
                        <tbody id="pos_items">
                        </tbody>
                        <tfoot class="bg-white">
                            <!-- Helper Inputs Row -->
                            <tr class="border-top">
                                <td colspan="7" class="p-1">
                                    <div class="row no-gutters align-items-center">
                                         <div class="col-md-3 pr-1">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text small font-weight-bold" style="font-size: 9px;">CUTTING</span></div>
                                                <input type="text" class="form-control form-control-sm cuttingsawingVal font-weight-bold" name="cuttingsawing" placeholder="0" onkeypress="return isNumber(event)" onkeyup="billUpyog()" value="0">
                                            </div>
                                         </div>
                                         <div class="col-md-3 pr-1">
                                             <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text small font-weight-bold" style="font-size: 9px;">PLANING</span></div>
                                                <input type="text" class="form-control form-control-sm planingVal font-weight-bold" name="planing_rate" placeholder="0" onkeypress="return isNumber(event)" onkeyup="billUpyog()" value="0">
                                            </div>
                                         </div>
                                         <div class="col-md-3 pr-1">
                                             <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text small font-weight-bold" style="font-size: 9px;">LOADING</span></div>
                                                <input type="text" class="form-control form-control-sm loadingunloadingVal font-weight-bold" name="loadingunloading" placeholder="0" onkeypress="return isNumber(event)" onkeyup="billUpyog()" value="0">
                                            </div>
                                         </div>
                                         <div class="col-md-3">
                                             <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text small font-weight-bold" style="font-size: 9px;">TRANS</span></div>
                                                <input type="text" class="form-control form-control-sm shipVal font-weight-bold" name="shipping" placeholder="0" onkeypress="return isNumber(event)" onkeyup="billUpyog()" value="0">
                                            </div>
                                         </div>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Totals & Payment Row -->
                            <tr class="bg-lighten-5 border-top">
                                <td colspan="4" class="text-right align-middle p-1">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <span class="mr-3 text-muted"><small>TAX:</small> <span id="taxr" class="font-weight-bold text-dark">0.00</span></span>
                                        <span class="mr-3 text-muted"><small>DISC:</small> <span id="discs" class="font-weight-bold text-dark">0.00</span></span>
                                        <span class="font-weight-bold text-success" style="font-size: 14px;">TOTAL: <span id="bigtotal">0.00</span></span>
                                        <!-- Hidden Inputs Re-added here to ensure JS finds them -->
                                        <input type="hidden" name="total" id="invoiceyoghtml" value="0.00">
                                        <?php $id = $_GET['id'] ?? null;
                                         if ($id == 'v2'): ?>
                                              <input type="hidden" value="2" name="i_class">
                                         <?php else: ?>
                                               <input type="hidden" value="1" name="i_class">
                                         <?php endif; ?>
                                    </div>
                                </td>
                                <td colspan="3" class="p-1">
                                         <input type="submit" class="btn btn-success btn-block shadow-sm font-weight-bold possubmit3 py-1"
                                                                     value="<?php echo $this->lang->line('Generate Order') ?>"
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    <div id="pos-footer-fixed">
                    <br>
                    <hr>

                    <!-- Hidden Fields for Calculation -->
                    <input type="hidden" value="0" id="subttlform" name="subtotal"> 
                    <input type="hidden" value="0" id="custom_discount">
                    <input type="hidden" id="invoiceyoghtmlplaning" name="planing">


                <hr class="my-1">
                <ul class="nav nav-tabs" role="tablist" style="font-size: 11px;">
               
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary btn-sm mr-1 mb-1 py-0 px-2" id="base-tab2" data-toggle="tab"
                           aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i
                                    class="icon-handbag"></i>
                            <?php echo $this->lang->line('Settings') ?></a>
                    </li>
           
                    <li class="nav-item">
                        <a class="btn btn-outline-success btn-sm mb-1 py-0 px-2" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                           href="#tab4" role="tab" aria-selected="false"><i class="fa fa-cogs"></i>
                            <?php echo $this->lang->line('Properties') ?></a>
                    </li>
                </ul>
                <div class="tab-content px-1 pt-1">
           
                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                        <div class="row no-gutters">
                            <div class="col-4 blue text-xs-center px-1">
                                <span style="font-size: 10px;"><?php echo $this->lang->line('Warehouse') ?></span>
                                <select
                                        id="warehouses"
                                        class="selectpicker form-control form-control-sm round teal" style="font-size: 11px;">
                                    <?php echo $this->common->default_warehouse();
                                    echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>

                                </select></div>

                                       
                            <div class="col-4 blue text-xs-center px-1">
                                <span style="font-size: 10px;"><?php echo $this->lang->line('Update Stock') ?></span>
                                <select name="update_stock" class="form-control form-control-sm round teal" style="font-size: 11px;">
                                    <option value="yes"><?php echo $this->lang->line('Yes') ?></option>
                                    <option value="no"><?php echo $this->lang->line('No') ?></option>
                                </select></div>

                            <div class="col-4 blue text-xs-center px-1">
                                <span style="font-size: 10px;"><?php echo $this->lang->line('Tax') ?></span>
                                <select class="form-control form-control-sm round"
                                        onchange="changeTaxFormat(this.value)"
                                        id="taxformat" style="font-size: 11px;">
                                    <?php echo $taxlist; ?>
                                </select></div>
                            <div class="col-4 blue text-xs-center px-1">
                                <span style="font-size: 10px;"><?php echo $this->lang->line('Discount') ?></span>
                                <select class="form-control form-control-sm round teal"
                                        onchange="changeDiscountFormat(this.value)"
                                        id="discountFormat" style="font-size: 11px;">

                                    <?php echo $this->common->disclist() ?>
                                </select>

                            </div>
                        </div>
                    </div>
            
                    <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="invocieno"
                                                         class="caption">Purchase Number </label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-file-text-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                  <input type="text" class="form-control" placeholder="Invoice #"
       name="invocieno" id="invocieno"
       value="<?php
if (($_GET['id'] ?? null) == 'v2') {
    echo $lastinvoice_v2_new + 1;
} else {
    echo $lastinvoice + 1;
}
?>">
                              
                                           
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
                                                         class="caption">Purchase Date</label>

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
                                                         class="caption">Purchase Due Date</label>

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
                                       class="caption">Purchase Note</label>
                                <textarea class="form-control" name="notes" rows="2"></textarea>
                            </div>
                        </div>


                    </div>
                </div>
                </div>


            </div>

        </div>



    </div>


        <div class="col-md-6 card  order-sm-first  order-md-2 border-amber bg-lighten-1 bg-faded round pt-1">


            <div class="row border-bottom-grey-blue  border-bottom-lighten-4">


                <div class="col-md-6 pb-1">
                    <input type="text" class="form-control text-center round mousetrap"
                           name="product_barcode"
                           placeholder="Enter Product name, scan barcode " id="search_bar"
                           autocomplete="off" autofocus="autofocus">
                </div>
                <div class="col-md-3  grey text-xs-center">
                    <select id="categories" class="form-control round teal">
                        <option value="0"><?php echo $this->lang->line('All') ?></option><?php
                        foreach ($cat as $row) {
                            $cid = $row['id'];
                            $title = $row['title'];
                            echo "<option value='$cid'>$title</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Sub Category added -->
                 <div class="col-md-3  grey text-xs-center">
                    <select id="sub_categories" class="form-control round teal">
                        <option value="0"><?php echo $this->lang->line('All') ?></option>
                    </select>
                </div>

            </div>


            <div class="row">
                <div class="col-md-12 pt-0" id="pos_item">
                    <!-- pos items -->
                </div>
            </div>
        </div>




    </div>
    <input type="hidden" value="purchase/action" id="action-url">
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

<div id="shortkeyboard" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">ShortCuts</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Alt+X</td>
                        <td>Focus to products search</td>
                    </tr>
                    <tr>
                        <td>Alt+C</td>
                        <td>Focus to customer search</td>
                    </tr>

                    <tr>
                        <td>Alt+S (twice)</td>
                        <td>PayNow + Thermal Print</td>
                    </tr>
                    <tr>
                        <td>Alt+Z</td>
                        <td>Make Card Payment</td>
                    </tr>
                    <tr>
                        <td>Alt+Q</td>
                        <td>Select First product</td>
                    </tr>
                    <tr>
                        <td>Alt+N</td>
                        <td>Create New Invoice</td>
                    </tr>


                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="Pos_addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-info white">

                    <h4 class="modal-title" id="myModalLabel"><i
                                class="icon-user-plus"></i> <?php echo $this->lang->line('Add Customer') ?></h4>
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

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control">
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


                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/ >
                </div>
            </form>
        </div>
    </div>
</div>
<!--card-->
<div class="modal fade" id="cardPay" role="dialog">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>

            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p id="statusMsg"></p>

                <form role="form" id="card_data">

                    <div class="row">
                        <div class="col-6">
                            <div class="card-title mb-3">
                                <label for="cardNumber"><?php echo $this->lang->line('Payment Gateways') ?></label>
                                <select class="form-control" name="gateway"><?php


                                    $surcharge_t = false;
                                    foreach ($gateway as $row) {
                                        $cid = $row['id'];
                                        $title = $row['name'];
                                        if ($row['surcharge'] > 0) {
                                            $surcharge_t = true;
                                            $fee = '(<span class="gate_total"></span>+' . amountFormat_s($row['surcharge']) . ' %)';
                                        } else {
                                            $fee = '';
                                        }
                                        echo "<option value='$cid'>$title $fee</option>";
                                    }
                                    ?>
                                </select></div>
                        </div>
                        <div class="col-6"><br><img class="img-responsive pull-right"
                                                    src="<?php echo assets_url('assets/images/accepted_c22e0.png') ?>">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-success btn-lg btn-block"
                                    type="submit"
                                    id="pos_card_pay"
                                    data-type="2"><?php echo $this->lang->line('Paynow') ?></button>
                        </div>
                    </div>
                    <div class="form-group">

                        <?php if ($surcharge_t) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?>

                    </div>
                    <div class="row" style="display:none;">
                        <div class="col-xs-12">
                            <p class="payment-errors"></p>
                        </div>
                    </div>

                    <input type="hidden" value="purchase/action" id="pos_action-url">
                </form>


            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="basicPay" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="basicpay_data" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p>

                    <div class="text-center"><h1 id="b_total"></h1></div>
                    <div class="row">


                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber"><?php echo $this->lang->line('Amount') ?></label>
                                <div class="input-group">
                                    <input
                                            type="text"
                                            class="form-control  text-bold-600 blue-grey"
                                            name="p_amount"
                                            placeholder="Amount" onkeypress="return isNumber(event)"
                                            id="p_amount" onkeyup="update_pay_pos()"
                                    />
                                    <span class="input-group-addon"><i
                                                class="icon icon-cash"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber"><?php echo $this->lang->line('Payment Method') ?></label>
                                <select class="form-control" name="p_method" id="p_method">
                                    <option value='Cash'><?php echo $this->lang->line('Cash') ?></option>
                                    <option value='Card Swipe'><?php echo $this->lang->line('Card Swipe') ?></option>
                                    <option value='Bank'><?php echo $this->lang->line('Bank') ?></option>

                                </select></div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group  text-bold-600 red">
                                <label for="amount"><?php echo $this->lang->line('Balance Due') ?>
                                </label>
                                <input type="text" class="form-control red" name="amount" id="balance1"
                                       onkeypress="return isNumber(event)"
                                       value="0.00"
                                       required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group text-bold-600 text-g">
                                <label for="b_change"><?php echo $this->lang->line('Change') ?></label>
                                <input
                                        type="text"
                                        class="form-control green"
                                        name="b_change" id="change_p" value="0">
                            </div>
                        </div>
                    </div>
                                    <?php if(PAC) { ?>
                      <div class="col"> <div class="form-group text-bold-600 text-g">
                    <label for="account_p"><?php echo $this->lang->line('Account') ?></label>

                            <select name="p_account" id="p_account" class="form-control">
                                <?php foreach ($acc_list as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select></div></div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-success btn-lg btn-block mb-1"
                                    type="submit"
                                    id="pos_basic_pay" data-type="4"><i
                                        class="fa fa-arrow-circle-o-right"></i> <?php echo $this->lang->line('Paynow') ?>
                            </button>
                            <button class="btn btn-info btn-lg btn-block"
                                    type="submit"
                                    id="pos_basic_print" data-type="4"><i
                                        class="fa fa-print"></i> <?php echo $this->lang->line('Paynow') ?>
                                + <?php echo $this->lang->line('Print') ?></button>
                        </div>
                    </div>

                    <div class="row" style="display:none;">
                        <div class="col-xs-12">
                            <p class="payment-errors"></p>
                        </div>
                    </div>


                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Your Register') ?></h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>

            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="text-center m-1"><?php echo $this->lang->line('Active') ?> - <span id="r_date"></span></div>


                <div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 green">
                            <label for="amount"><?php echo $this->lang->line('Cash') ?>
                                (<?= $this->config->item('currency'); ?>)
                            </label>
                            <input type="number" class="form-control green" id="r_cash"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 blue">
                            <label for="b_change blue"><?php echo $this->lang->line('Card') ?></label>
                            <input
                                    type="number"
                                    class="form-control blue"
                                    id="r_card" value="0" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 indigo">
                            <label for="amount"><?php echo $this->lang->line('Bank') ?>
                            </label>
                            <input type="number" class="form-control indigo" id="r_bank"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 red">
                            <label for="b_change"><?php echo $this->lang->line('Change') ?>(-)</label>
                            <input
                                    type="number"
                                    class="form-control red"
                                    id="r_change" value="0" readonly>
                        </div>
                    </div>
                </div>


                <div class="row" style="display:none;">
                    <div class="col-xs-12">
                        <p class="payment-errors"></p>
                    </div>
                </div>


                <!-- shipping -->


            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="close_register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Close') ?><?php echo $this->lang->line('Your Register') ?></h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <a href="<?= base_url() ?>/register/close" class="btn btn-danger btn-lg btn-block"
                           type="submit"
                        ><i class="icon icon-arrow-circle-o-right"></i> <?php echo $this->lang->line('Yes') ?></a>
                    </div>
                    <div class="col-4"></div>
                </div>

            </div>
            <!-- Modal Footer -->
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
<script>
    $(document).ready(function () {
        // Trigger initial product load
        setTimeout(function(){
            $('#categories').trigger('change');
        }, 500);
    });
</script>