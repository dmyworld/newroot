<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Label'); ?></h5>
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
                <div class="card collapsed-card mb-2" style="border: 1px solid #ddd; border-left: 5px solid #6c757d;">
                    <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#guideLabel" aria-expanded="false" style="cursor: pointer; background-color: #f8f9fa;">
                        <h6 class="mb-0 text-dark"><i class="fa fa-info-circle mr-2"></i> <?php echo $this->lang->line('HelpGuide') ? $this->lang->line('HelpGuide') : "User Guide / උපදෙස් / பயனர் கையேடு" ?> <small class="text-muted float-right">(Click to view)</small></h6>
                    </div>
                    <div id="guideLabel" class="collapse">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active small p-1" data-toggle="tab" href="#eng_label">🇬🇧 English</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#sin_label">🇱🇰 Sinhala</a></li>
                                <li class="nav-item"><a class="nav-link small p-1" data-toggle="tab" href="#tam_label">IN Tamil</a></li>
                            </ul>
                            <div class="tab-content border p-2 bg-white">
                                <div id="eng_label" class="tab-pane active">
                                    <h6 class="text-primary mt-1 small">Label Printing Steps</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>Select Items:</strong> Choose 'Warehouse' and specifically select 'Products' to print labels for.</li>
                                        <li><strong>Dimensions:</strong> Adjust Width/Height (mm) and Padding (px) to match your label paper.</li>
                                        <li><strong>Content:</strong> Toggle 'Yes/No' for Info (Price, Code, Business Name).</li>
                                        <li><strong>Print:</strong> Click 'Print' to generate a PDF for printing.</li>
                                    </ol>
                                </div>
                                <div id="sin_label" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">ලේබල් මුද්‍රණය කිරීමේ පියවර</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>තෝරාගැනීම:</strong> 'ගබඩාව' (Warehouse) සහ අවශ්‍ය භාණ්ඩ (Products) තෝරන්න.</li>
                                        <li><strong>ප්‍රමාණයන්:</strong> ලේබල් කොළයට ගැලපෙන පරිදි උස/පළල (Width/Height) සකසන්න.</li>
                                        <li><strong>තොරතුරු:</strong> මිල, කේතය, හෝ ව්‍යාපාරයේ නම මුද්‍රණය කිරීමට 'Yes' තෝරන්න.</li>
                                        <li><strong>මුද්‍රණය:</strong> PDF ගොනුව ලබා ගැනීමට 'Print' බොත්තම ඔබන්න.</li>
                                    </ol>
                                </div>
                                <div id="tam_label" class="tab-pane fade">
                                    <h6 class="text-primary mt-1 small">லேபிள் அச்சிடுதல் படிகள்</h6>
                                    <ol class="small pl-3 mb-0">
                                        <li><strong>தேர்வு:</strong> கிடங்கு மற்றும் தயாரிப்புகளைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>அளவுகள்:</strong> உங்கள் லேபிள் தாளுக்கு ஏற்ப அகலம்/உயரத்தை சரிசெய்யவும்.</li>
                                        <li><strong>தகவல்:</strong> விலை, குறியீடு அல்லது வணிகப் பெயரை அச்சிட 'Yes' என்பதைத் தேர்ந்தெடுக்கவும்.</li>
                                        <li><strong>அச்சிடு:</strong> PDF ஐ உருவாக்க 'Print' ஐ அழுத்தவும்.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End User Guide -->
                <?php
                $attributes = array('class' => 'form-horizontal form-simple', 'id' => 'login_form');
                echo form_open('products/custom_label');
                ?>
                <input type="hidden" name="act" value="add_product">
                <div class="form-group row">


                    <div class="col-sm-4"><label class="col-form-label"
                                                 for="product_cat"><?php echo $this->lang->line('Warehouse') ?></label>
                        <select id="wfrom" name="from_warehouse" class="form-control">
                            <option value='0'>Select</option>
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>


                    <div class="col-sm-8"><label class="col-form-label"
                                                 for="pay_cat"><?php echo $this->lang->line('Products') ?></label>
                        <select id="products_l" name="products_l[]" class="form-control required select-box"
                                multiple="multiple">

                        </select>


                    </div>
                </div>
                <hr>
                <?php echo $this->lang->line('Print') ?> <?php echo $this->lang->line('Settings') ?>
                <hr>
                <div class="form-group row">


                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Width</label>
                        <input name="width" class="form-control required" type="number" value="100">
                        <small>in MM</small>

                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Height</label>
                        <input name="height" class="form-control required" type="number" value="70">
                        <small>in MM</small>

                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="padding">Padding</label>
                        <input name="padding" class="form-control required" type="number" value="10">
                        <small>in PX</small>

                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="store_name"><?php echo $this->lang->line('Business') . ' ' . $this->lang->line('Location'); ?></label>
                        <select class="form-control" name="store_name">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="store_name"><?php echo $this->lang->line('Warehouse') ?></label>
                        <select class="form-control" name="warehouse_name">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>

                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="product_price"><?php echo $this->lang->line('Price') ?></label>
                        <select class="form-control" name="product_price">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="product_code"><?php echo $this->lang->line('Product Code') ?></label>
                        <select class="form-control" name="product_code">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">BarCode height</label>
                        <select class="form-control" name="bar_height">
                            <option value=".5">50%</option>
                            <option value=".6" selected>60%</option>
                            <option value=".7">70%</option>
                            <option value=".8">80%</option>
                            <option value=".9">90%</option>
                            <option value="1">100%</option>
                        </select>
                    </div>


                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Total Rows</label>
                        <select class="form-control" name="total_rows">
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                            <option value="4">5</option>
                            <option value="5">6</option>
                            <option value="6">7</option>
                            <option value="7">8</option>
                            <option value="8">9</option>
                            <option value="9">10</option>
                            <option value="19">20</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><label class="col-form-label"
                                                 for="width">Total Cols</label>
                        <select class="form-control" name="items_per_row">
                            <option value="1">1</option>
                            <option value="3">3</option>

                        </select>
                    </div>
                </div>


                <div class="form-group row">


                    <div class="col-sm-4">
                        <input type="submit" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Print') ?>"
                               data-loading-text="Adding...">

                    </div>
                </div>
            </div>

            </form>
        </div>
    </div>

    <script type="text/javascript">
        $("#products_l").select2();
        $("#wfrom").on('change', function () {
            var tips = $('#wfrom').val();
            $("#products_l").select2({

                tags: [],
                ajax: {
                    url: baseurl + 'products/stock_transfer_products?wid=' + tips,
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 50,
                    data: function (product) {

                        return {
                            product: product,
                            '<?=$this->security->get_csrf_token_name()?>': crsf_hash

                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.product_name,
                                    id: item.pid
                                }
                            })
                        };
                    },
                }
            });
        });
    </script>

