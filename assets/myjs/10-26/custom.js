var billtype = $('#billtype').val();
var d_csrf = crsf_token + '=' + crsf_hash;


$('#addproduct3').on('click', function () {
    var cvalue = parseInt($('#ganak3').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak3').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row3 div').length;
    //product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name2[]" placeholder="Enter Product name or Code" id="productname3-' + cvalue + '"><br><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input planing2" name="planing_check[]" id="planing2-' + cvalue + '" value="1" onchange="rowTotal(' + functionNum + '), billUpyog()"><label class="custom-control-label" for="planing2-' + cvalue + '">Planing</label></div> <span class="planingText" id="planingText-' + cvalue + '">0.00</span>></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td>                                                  <td><input type="text" class="form-control req prc" name="product_r[]" id="r-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuick(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" disabled></td><td><input type="text" class="form-control req prc" name="product_l[]" id="l-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuick(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" disabled></td>           <td><span class="currenty">ft&#179; :</span> <strong><span class=\'ttlText\' name="result" id="result3-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total2-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="product_description[]" id="dpid-' + cvalue + '" value=""><input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value=""><input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value=""><input type="hidden" name="product_quick[]" id="totalquick-' + cvalue + '" value=""><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value="">  <input type="hidden" name="pquick[]" id="pquick-' + cvalue + '" value="">    <input type="hidden" name="tpquick[]" id="tpquick-' + cvalue + '" value=""> <input type="hidden" name="result[]" id="result33-' + cvalue + '" value="0">   </tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname3-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#product_pwith-' + id[1]).val(ui.item.data[9]);
            $('#product_thicknes-' + id[1]).val(ui.item.data[10]);
            $('#pquick-' + id[1]).val(ui.item.data[10]);
            $('#product_quick_code-' + id[1]).val(ui.item.data[12]);
            $('#result2-' + id[1]).val(ui.item.data[13]);

            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});





$('#addproduct2').on('click', function () {
    var cvalue = parseInt($('#ganak2').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak2').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row2 div').length;
    //product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name2[]" placeholder="Enter Product name or Code" id="productname2-' + cvalue + '"><br><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input planing2" name="planing_check[]" id="planing2-' + cvalue + '" value="1" onchange="rowTotal(' + functionNum + '), billUpyog()"><label class="custom-control-label" for="planing2-' + cvalue + '">Planing</label></div> <span class="planingText" id="planingText-' + cvalue + '">0.00</span>></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td>                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td>                   <td><input type="text" class="form-control req prc" name="product_r[]" id="r-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuick(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td><input type="text" class="form-control req prc" name="product_l[]" id="l-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuick(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td>           <td><span class="currenty">' + currency + ':</span> <strong><span class=\'ttlTextt\' id="result1-' + cvalue + '">0</span></strong><br><span class="currenty">ft&#179; :</span> <strong><span class=\'ttlText\' id="result2-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total2-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="product_description[]" id="dpid-' + cvalue + '" value=""><input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value=""><input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value=""><input type="hidden" name="product_quick[]" id="totalquick-' + cvalue + '" value=""><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value=""></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname2-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#product_pwith-' + id[1]).val(ui.item.data[9]);
            $('#product_thicknes-' + id[1]).val(ui.item.data[10]);
            $('#pquick-' + id[1]).val(ui.item.data[11]);
            $('#product_quick_code-' + id[1]).val(ui.item.data[12]);
            $('#result2-' + id[1]).val(ui.item.data[13]);

            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});








// Function to calculate product subtotal and cubic feet for a specific row
function calculateQuick(rowNumber) {
    var product_round_inches = parseFloat($('#r-' + rowNumber).val()) || 0;
    var product_long_feet = parseFloat($('#l-' + rowNumber).val()) || 0;
    var amount = parseFloat($('#amount-' + rowNumber).val()) || 0;
    var price = parseFloat($('#price-' + rowNumber).val()) || 0;

    var pquick = parseFloat($('#pquick-' + rowNumber).val()) || 0;
    var productpquick = pquick * amount;

    var radiusInches = product_round_inches / 4;  // Quarter of diameter as an estimation
    var cubicFeet = (Math.pow(radiusInches, 2) * product_long_feet) / 144;
    var productInFeet = amount * cubicFeet;


    var result3 = productpquick; // cubic feet
    var result2 = productInFeet; // cubic feet
    var productSubtotal = result2 * price; // updated subtotal calculation

    $('#result22-' + rowNumber).val(productInFeet.toFixed(2));
    $('#result2-' + rowNumber).text(productInFeet.toFixed(2));

    $('#result1-' + rowNumber).text(productSubtotal.toFixed(2));

    $('#result3-' + rowNumber).text(productpquick.toFixed(2));
    $('#result33-' + rowNumber).val(productpquick.toFixed(2));

    // Update the hidden input with the product subtotal
    $('#total2-' + rowNumber).val(productSubtotal.toFixed(2));
    $('#totalquick-' + rowNumber).val(productInFeet.toFixed(2));
    $('#tpquick-' + rowNumber).val(productpquick.toFixed(2));
    $('#tpquick2-' + rowNumber).val(productpquick.toFixed(2));

    // Update the overall totals
    updateOverallCubicFeetTotal();
    updatewoodOverallCubicFeetTotal();
    updateTotalWastage();
    updateGrandTotal();
}










$('#addproduct4').on('click', function () {
    var cvalue = parseInt($('#ganak4').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak4').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row4 div').length;
    //product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"><br><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input planing2" name="planing_check[]" id="planing2-' + cvalue + '" value="1" onchange="rowTotal(' + functionNum + '), billUpyog()"><label class="custom-control-label" for="planing2-' + cvalue + '">Planing</label></div> <span class="planingText" id="planingText-' + cvalue + '">0.00</span>></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" > </td>                                                  <td><input type="text" class="form-control req prc" name="product_t[]" id="t-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" disabled></td><td><input type="text" class="form-control req prc" name="product_w[]" id="w-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" disabled></td>     <td><input type="text" class="form-control req prc" name="product_l[]" id="l-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" disabled></td>      <td><span class="currenty">ft&#179; :</span> <strong><span class=\'ttlText\' name="result" id="result3-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total2-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="product_description[]" id="dpid-' + cvalue + '" value=""><input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value=""><input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value=""><input type="hidden" name="product_quick[]" id="totalquick-' + cvalue + '" value=""><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value="">   </tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#product_pwith-' + id[1]).val(ui.item.data[9]);
            $('#product_thicknes-' + id[1]).val(ui.item.data[10]);
            $('#pquick-' + id[1]).val(ui.item.data[11]);
            $('#product_quick_code-' + id[1]).val(ui.item.data[12]);

            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});






$('#addproduct5').on('click', function () {
    var cvalue = parseInt($('#ganak5').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak5').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row5 div').length;
    //product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"><br><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input planing2" name="planing_check[]" id="planing2-' + cvalue + '" value="1" onchange="rowTotal(' + functionNum + '), billUpyog()"><label class="custom-control-label" for="planing2-' + cvalue + '">Planing</label></div> <span class="planingText" id="planingText-' + cvalue + '">0.00</span>></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment(' + cvalue + '), rowTotal(' + functionNum + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" > <input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td>                                                 <td><input type="text" class="form-control req prc" name="product_t[]" id="t-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td><input type="text" class="form-control req prc" name="product_w[]" id="w-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td>     <td><input type="text" class="form-control req prc" name="product_l[]" id="l-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="calculateQuicktreatment(' + cvalue + '), rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td>      <td><span class="currenty">' + currency + ':</span> <strong><span class=\'ttttlText\' id="resultttr-' + cvalue + '">0</span></strong><br><span class="currenty">ft&#179; :</span> <strong><span class=\'ttlText\' id="resultttc-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="totaltt1-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="product_description[]" id="dpid-' + cvalue + '" value=""><input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value=""><input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value=""><input type="hidden" name="product_quick[]" id="totalquick-' + cvalue + '" value=""><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value="">   </tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#product_pwith-' + id[1]).val(ui.item.data[9]);
            $('#product_thicknes-' + id[1]).val(ui.item.data[10]);
            $('#pquick-' + id[1]).val(ui.item.data[11]);
            $('#product_quick_code-' + id[1]).val(ui.item.data[12]);

            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});


// Function to calculate product subtotal and cubic feet for a specific row
function calculateQuicktreatment(rowNumber) {
    var product_t_inches = parseFloat($('#t-' + rowNumber).val()) || 0;
    var product_w_inches = parseFloat($('#w-' + rowNumber).val()) || 0;
    var product_l_inches = parseFloat($('#l-' + rowNumber).val()) || 0;


    var amount = parseFloat($('#amount-' + rowNumber).val()) || 0;
    var price = parseFloat($('#price-' + rowNumber).val()) || 0;





    //var cubicFeet = (product_w_inches * product_t_inches * product_l_feet) / 144;
    var cubicFeet = (product_w_inches * product_t_inches * product_l_inches) / 1728;
    var productInFeet = amount * cubicFeet;




    var productSubtotal = productInFeet * price; // updated subtotal calculation


    $('#resultttc-' + rowNumber).text(productInFeet.toFixed(2));

    $('#resultttr-' + rowNumber).text(productSubtotal.toFixed(2));



    // Update the hidden input with the product subtotal
    $('#totaltt1-' + rowNumber).val(productSubtotal.toFixed(2));
    $('#totalquick-' + rowNumber).val(productInFeet.toFixed(2));


    // Update the overall totals

    updateOverallCubicFeetTotal();
    updatewoodOverallCubicFeetTotal();
    updateTotalWastage();
    updateGrandTotal();
}







// Function to sum up cubic feet values from all rows and update the overall total display
function updateOverallCubicFeetTotal() {
    var totalCubicFeet = 0;
    $('[id^="result2-"]').each(function () {
        totalCubicFeet += parseFloat($(this).text()) || 0;
    });

    $('#overall_cubic_feet_total').val(totalCubicFeet.toFixed(2));
}
// Function to sum up cubic feet values from all rows and update the overall total display
function updatewoodOverallCubicFeetTotal() {
    var totalwoodCubicFeet = 0;
    $('[id^="result3-"]').each(function () {
        totalwoodCubicFeet += parseFloat($(this).text()) || 0;
    });

    $('#wood_overall_cubic_feet_total').val(totalwoodCubicFeet.toFixed(2));
}
//// Function to calculate and update total wastage
//function updateTotalWastage() {
//    // Get both totals (this will recalculate them each time)
//    var totalCubicFeet = updateOverallCubicFeetTotal();
//    var totalWoodCubicFeet = updatewoodOverallCubicFeetTotal();
//    
//    var totalWastageCubicFeet = totalWoodCubicFeet + totalCubicFeet;
//    $('#cubic_feet_total_wastage').val(totalWastageCubicFeet.toFixed(2));
//}

// Function to calculate and update total wastage
function updateTotalWastage() {
    // Get values from the input fields (assuming they've been calculated already)
    var totalCubicFeet = parseFloat($('#overall_cubic_feet_total').val()) || 0;
    var totalWoodCubicFeet = parseFloat($('#wood_overall_cubic_feet_total').val()) || 0;

    var totalWastageCubicFeet = totalCubicFeet - totalWoodCubicFeet;
    $('#cubic_feet_total_wastage').val(totalWastageCubicFeet.toFixed(2));
}



// Function to calculate and display the grand total and update the subtotal hidden input
function updateGrandTotal() {
    var grandTotal = 0;

    // Sum up all product subtotals
    $('[id^="total2-"]').each(function () {
        var productSubtotal = parseFloat($(this).val()) || 0;
        grandTotal += productSubtotal;
    });

    // Log subtotal
    console.log("Subtotal before shipping:", grandTotal);

    // Retrieve the shipping value from the input field
    var shippingValue = parseFloat($('#shipval2').val()) || 0;

    console.log("Shipping Value:", shippingValue);

    grandTotal += shippingValue;

    // Log the final grand total
    console.log("Grand Total:", grandTotal);

    // Update the grand total in the respective fields
    $('#subttlform2').val(grandTotal.toFixed(2));
    $('#invoiceyoghtml2').val(grandTotal.toFixed(2));
}


// Function to handle row deletion
function deleteRow(rowNumber) {
    $('#row-' + rowNumber).remove();
    updateOverallCubicFeetTotal();
    updatewoodOverallCubicFeetTotal();
    updateTotalWastage();
    updateGrandTotal();
}

$(document).ready(function () {
    // Keyup event for all input fields to trigger the calculateQuick function
    $('body').on('keyup', 'input', function () {
        var rowNumber = $(this).attr('id').split('-').pop();
        calculateQuick(rowNumber);
    });

    $('body').on('keyup', 'input', function () {
        var rowNumber = $(this).attr('id').split('-').pop();
        calculateQuicktreatment(rowNumber);
    });


    //$(document).ready(function () {
    //    // Keyup event for all input fields to trigger the calculateQuick function
    //    $('body').on('keyup', 'input', function() {
    //        var rowNumber = $(this).attr('id').split('-').pop();
    //        calculateQuicktreatment(rowNumber);
    //    });
    // Keyup event for shipping input to update the grand total
    $('body').on('keyup', '#shipVal2', function () {
        updateGrandTotal();
    });

    // Click event for the delete button to trigger the deleteRow function
    $('body').on('click', '.delete-row', function () {
        var rowNumber = $(this).attr('data-row');
        deleteRow(rowNumber);
    });

    // Click event for the removeProd class to trigger custom row deletion logic
    $('#saman-row5').on('click', '.removeProd', function () {
        var pidd = $(this).closest('tr').find('.pdIn').val();
        var pqty = $(this).closest('tr').find('.amnt').val();
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            id: 'restock',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
        $(this).closest('tr').remove();
        $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();

        $('.amnt').each(function (index) {
            rowTotal(index);
            billUpyog();
        });

        // Recalculate the overall cubic feet total and grand total
        updateOverallCubicFeetTotal();
        updatewoodOverallCubicFeetTotal();
        updateTotalWastage();
        updateGrandTotal();

        return false;
    });


    // Click event for the removeProd class to trigger custom row deletion logic
    $('#saman-row2').on('click', '.removeProd', function () {
        var pidd = $(this).closest('tr').find('.pdIn').val();
        var pqty = $(this).closest('tr').find('.amnt').val();
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            id: 'restock',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
        $(this).closest('tr').remove();
        $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();

        $('.amnt').each(function (index) {
            rowTotal(index);
            billUpyog();
        });

        // Recalculate the overall cubic feet total and grand total
        updateOverallCubicFeetTotal();
        updatewoodOverallCubicFeetTotal();
        updateTotalWastage();
        updateGrandTotal();

        return false;
    });
    // Click event for the removeProd class to trigger custom row deletion logic
    $('#saman-row3').on('click', '.removeProd', function () {
        var pidd = $(this).closest('tr').find('.pdIn').val();
        var pqty = $(this).closest('tr').find('.amnt').val();
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            id: 'restock',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
        $(this).closest('tr').remove();
        $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();

        $('.amnt').each(function (index) {
            rowTotal(index);
            billUpyog();
        });

        // Recalculate the overall cubic feet total and grand total
        updateOverallCubicFeetTotal();
        updatewoodOverallCubicFeetTotal();
        updateTotalWastage();
        updateGrandTotal();

        return false;
    });


    // Initial calculation on page load
    updateOverallCubicFeetTotal();
    updatewoodOverallCubicFeetTotal();
    updateTotalWastage();
    updateGrandTotal();
});













$('#addproduct').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
    //product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" class="form-control description" name="product_description[]" id="product_description-' + cvalue + '" value=""><input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value=""><input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value=""><input type="hidden" name="pquick[]" id="pquick-' + cvalue + '" value=""><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value=""></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            // Calculate price based on your logic
            var basePrice = ui.item.data[1]; // Assuming this is the base price
            var productDescription = ui.item.data[5]; // This might be your divisor

            // If productDescription is numeric, use it as divisor
            var calculatedPrice = basePrice;
            if (!isNaN(parseFloat(productDescription)) && isFinite(productDescription)) {
                calculatedPrice = basePrice / parseFloat(productDescription);
            }

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(calculatedPrice);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#product_description-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#product_pwith-' + id[1]).val(ui.item.data[9]);
            $('#product_thicknes-' + id[1]).val(ui.item.data[10]);
            $('#pquick-' + id[1]).val(ui.item.data[11]);
            $('#product_quick_code-' + id[1]).val(ui.item.data[12]);

            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});

//caculations
var precentCalc = function (total, percentageVal) {
    var pr = (total / 100) * percentageVal;
    return parseFloat(pr);
};
//format
var deciFormat = function (minput) {
    if (!minput) minput = 0;
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + '-' + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var coupon = function () {
    var cp = 0;
    if ($('#coupon_amount').val()) {
        cp = accounting.unformat($('#coupon_amount').val(), accounting.settings.number.decimal);
    }
    return cp;
};
var shipTot = function () {
    var ship_val = accounting.unformat($('.shipVal').val(), accounting.settings.number.decimal);
    var ship_p = 0;
    if ($("#taxformat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxformat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'excl') {
        ship_p = (ship_val * ship_rate) / 100;
        ship_val = ship_val + ship_p;
    } else if (tax_status == 'incl') {
        ship_p = (ship_val * ship_rate) / (100 + ship_rate);
    }
    $('#ship_tax').val(accounting.formatNumber(ship_p));
    $('#ship_final').html(accounting.formatNumber(ship_p));
    return ship_val;
};








//planing calculation

var planingTot = function (calculatedTotal) {
    var planing_val = calculatedTotal || 0;
    var planing_p = 0;
    if ($("#taxformat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxformat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'excl') {
        planing_p = (planing_val * ship_rate) / 100;
        planing_val = planing_val + planing_p;
    } else if (tax_status == 'incl') {
        planing_p = (planing_val * ship_rate) / (100 + ship_rate);
    }
    $('#planing_tax').val(accounting.formatNumber(planing_p));
    $('#planing_final').html(accounting.formatNumber(planing_p));
    return planing_val;
};


//Loading / Unloading Chargers calculation

var loadingunloadingTot = function () {
    var loadingunloading_val = accounting.unformat($('.loadingunloadingVal').val(), accounting.settings.number.decimal);
    var loadingunloading_p = 0;
    if ($("#taxformat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxformat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'excl') {
        loadingunloading_p = (loadingunloading_val * ship_rate) / 100;
        loadingunloading_val = loadingunloading_val + loadingunloading_p;
    } else if (tax_status == 'incl') {
        loadingunloading_p = (loadingunloading_val * ship_rate) / (100 + ship_rate);
    }
    $('#loadingunloading_tax').val(accounting.formatNumber(loadingunloading_p));
    $('#loadingunloading_final').html(accounting.formatNumber(loadingunloading_p));
    return loadingunloading_val;
};

//Cutting / Sawing Chargers calculation

var cuttingsawingTot = function () {
    var cuttingsawing_val = accounting.unformat($('.cuttingsawingVal').val(), accounting.settings.number.decimal);
    var cuttingsawing_p = 0;
    if ($("#taxformat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxformat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'excl') {
        cuttingsawing_p = (cuttingsawing_val * ship_rate) / 100;
        cuttingsawing_val = cuttingsawing_val + cuttingsawing_p;
    } else if (tax_status == 'incl') {
        cuttingsawing_p = (cuttingsawing_val * ship_rate) / (100 + ship_rate);
    }
    $('#cuttingsawing_tax').val(accounting.formatNumber(cuttingsawing_p));
    $('#cuttingsawing_final').html(accounting.formatNumber(cuttingsawing_p));
    return cuttingsawing_val;
};






//product total
var samanYog = function () {
    var itempriceList = [];
    var idList = [];
    var r = 0;
    $('.ttInput').each(function () {
        var vv = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var vid = $(this).attr('id');
        vid = vid.split("-");
        itempriceList.push(vv);
        idList.push(vid[1]);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;
    for (var z = 0; z < idList.length; z++) {
        var x = idList[z];
        if (itempriceList[z] > 0) {
            sum += itempriceList[z];
        }
        var t1 = accounting.unformat($("#taxa-" + x).val(), accounting.settings.number.decimal);
        var d1 = accounting.unformat($("#disca-" + x).val(), accounting.settings.number.decimal);
        if (t1 > 0) {
            taxc += t1;
        }
        if (d1 > 0) {
            discs += d1;
        }
    }

    $("#discs").html(accounting.formatNumber(discs));
    $("#taxr").html(accounting.formatNumber(taxc));
    return accounting.unformat(sum, accounting.settings.number.decimal);
};

//actions
var deleteRow = function (num) {
    var totalSelector = $("#subttlform");
    var prodttl = accounting.unformat($("#total-" + num).val(), accounting.settings.number.decimal);
    var subttl = accounting.unformat(totalSelector.val(), accounting.settings.number.decimal);
    var totalSubVal = subttl - prodttl;
    totalSelector.val(totalSubVal);
    $("#subttlid").html(accounting.formatNumber(totalSubVal));
    var totalBillVal = (totalSubVal + shipTot + planingTot) - coupon;
    //final total
    var clean = accounting.formatNumber(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#invoiceyoghtmltimbert").val(clean);
    $("#bigtotal").html(clean);
};



// Debounce function to delay the execution
function debounce(func, delay) {
    let timeout;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

// Bill calculation function (updated to include product total)
function billUpyog() {
    // Calculate the product total (this should include all products)
    var localproductTotal = 0;
    $('.lttlText').each(function () {
        localproductTotal += accounting.unformat($(this).text(), accounting.settings.number.decimal);
    });
    var importedproductTotal = 0;
    $('.ittlText').each(function () {
        importedproductTotal += accounting.unformat($(this).text(), accounting.settings.number.decimal);
    });

    var productTotal = 0;
    $('.ttlText').each(function () {
        productTotal += accounting.unformat($(this).text(), accounting.settings.number.decimal);
    });



    //    var planingTotal = 0;
    //    $('.planing2:checked').each(function() {
    //    
    //        $('.planingText').each(function() {
    //        planingTotal += accounting.unformat($(this).text(), accounting.settings.number.decimal);
    //        });
    //    
    //    
    //    });

    var planingTotal = 0;
    $('.planing2:checked').each(function () {
        // Find the corresponding planingText for this checked item
        var $planingText = $(this).closest('tr').find('.planingText');
        planingTotal += accounting.unformat($planingText.text(), accounting.settings.number.decimal);
    });





    var productTotaltt = 0;
    $('.ttttlText').each(function () {
        productTotaltt += accounting.unformat($(this).text(), accounting.settings.number.decimal);
    });


    // If there's a discount, calculate it
    var out = 0;
    var disc_val = accounting.unformat($('.discVal').val(), accounting.settings.number.decimal);
    if (disc_val) {
        $("#subttlform").val(accounting.formatNumber(productTotal));
        var disc_rate = $('#discountFormat').val();

        switch (disc_rate) {
            case '%':
                out = precentCalc(accounting.unformat($('#subttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'b_p':
                out = precentCalc(accounting.unformat($('#subttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'flat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
            case 'bflat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
        }
        out = parseFloat(out).toFixed(two_fixed);

        $('#disc_final').html(accounting.formatNumber(out));
        $('#after_disc').val(accounting.formatNumber(out));
    } else {
        $('#disc_final').html(0);
    }
    // If there's a discount, calculate it
    var out = 0;
    var disc_val = accounting.unformat($('.discVal').val(), accounting.settings.number.decimal);
    if (disc_val) {
        $("#localsubttlform").val(accounting.formatNumber(localproductTotal));
        var disc_rate = $('#discountFormat').val();

        switch (disc_rate) {
            case '%':
                out = precentCalc(accounting.unformat($('#localsubttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'b_p':
                out = precentCalc(accounting.unformat($('#localsubttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'flat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
            case 'bflat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
        }
        out = parseFloat(out).toFixed(two_fixed);

        $('#disc_final').html(accounting.formatNumber(out));
        $('#after_disc').val(accounting.formatNumber(out));
    } else {
        $('#disc_final').html(0);
    }
    // If there's a discount, calculate it
    var out = 0;
    var disc_val = accounting.unformat($('.discVal').val(), accounting.settings.number.decimal);
    if (disc_val) {
        $("#importedsubttlform").val(accounting.formatNumber(importedproductTotal));
        var disc_rate = $('#discountFormat').val();

        switch (disc_rate) {
            case '%':
                out = precentCalc(accounting.unformat($('#importedsubttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'b_p':
                out = precentCalc(accounting.unformat($('#importedsubttlform').val(), accounting.settings.number.decimal), disc_val);
                break;
            case 'flat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
            case 'bflat':
                out = accounting.unformat(disc_val, accounting.settings.number.decimal);
                break;
        }
        out = parseFloat(out).toFixed(two_fixed);

        $('#disc_final').html(accounting.formatNumber(out));
        $('#after_disc').val(accounting.formatNumber(out));
    } else {
        $('#disc_final').html(0);
    }


    // Calculate additional charges
    var shippingTotal = shipTot();
    var planningTotal = planingTot(planingTotal);
    var cuttingSawingTotal = cuttingsawingTot();
    var loadingUnloadingTotal = loadingunloadingTot();

    // Grand total = product total + additional charges - discount
    //var grandTotal = productTotal + shippingTotal + planningTotal + cuttingSawingTotal + loadingUnloadingTotal - out;
    var grandTotal = productTotal + shippingTotal + planingTotal + cuttingSawingTotal + loadingUnloadingTotal - out;

    var grandTotaltimbert = productTotaltt + shippingTotal + planningTotal + cuttingSawingTotal + loadingUnloadingTotal - out;

    var grandTotall = localproductTotal + shippingTotal + planningTotal + cuttingSawingTotal + loadingUnloadingTotal - out;
    var grandTotali = importedproductTotal + shippingTotal + planningTotal + cuttingSawingTotal + loadingUnloadingTotal - out;

    // Update the UI with the grand total
    var formattedTotal = accounting.formatNumber(grandTotal);
    var formattedTotaltimbert = accounting.formatNumber(grandTotaltimbert);

    var formattedTotall = accounting.formatNumber(grandTotall);
    var formattedTotali = accounting.formatNumber(grandTotali);

    $("#mahayog").html(formattedTotal);
    $("#subttlform").val(accounting.formatNumber(productTotal));

    $("#localsubttlform").val(accounting.formatNumber(localproductTotal));
    $("#importedsubttlform").val(accounting.formatNumber(importedproductTotal));

    $("#invoiceyoghtmlplaning").val(planingTotal);

    $("#invoiceyoghtml").val(formattedTotal);
    $("#invoiceyoghtmltimbert").val(formattedTotaltimbert);

    $("#invoiceyoghtmllocal").val(formattedTotall);
    $("#invoiceyoghtmlimported").val(formattedTotali);

    $("#bigtotal").html(formattedTotal);
}

// Attach debounced event handlers
const debouncedBillUpyog = debounce(billUpyog, 300); // 300ms delay

// Input fields to monitor
$('#amount-0, #price-0, .shipVal, .planingVal, .cuttingsawingVal, .loadingunloadingVal').on('keyup', debouncedBillUpyog);


var o_rowTotal = function (numb) {
    //most res
    var result;
    // var resultPlaning2;
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var planing2Val = formInputGet("#product_description", numb);

    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);

    //resultPlaning2 =  parseFloat(amountVal) + parseFloat(planing2Val);

    if (discountVal == '') {
        $("#discount-" + numb).val(0);
        discountVal = 0;
    }
    var vatVal = formInputGet("#vat", numb);
    if (vatVal == '') {
        $("#vat-" + numb).val(0);
        vatVal = 0;
    }
    var taxo = 0;
    var disco = 0;
    var totalPrice = (parseFloat(amountVal).toFixed(2)) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();

    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
            //before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            //var Inpercentage = (+totalPrice * +vatVal) / (100 - +vatVal);
            var Inpercentage = (totalPrice / 100) * vatVal;

            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
            //before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            //  var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            var Inpercentage = (totalPrice / 100) * vatVal;

            totalValue = parseFloat(totalValue);
            taxo = deciFormat(Inpercentage);


        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //  totalValue = deciFormat(totalPrice);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
            //before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }
        }
    }
    $("#result-" + numb).html(deciFormat(totalValue));
    // $("#resultplaning2-" + numb).html(deciFormat(resultPlaning2));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};
var rowTotal = function (numb) {
    //most res
    var result;
    var resultPlaning2;
    var page = '';
    var totalValue = 0;


    var dpidVal = accounting.unformat($("#product_description-" + numb).val(), accounting.settings.number.decimal);

    var planing_val = accounting.unformat($('.planingVal').val(), accounting.settings.number.decimal);

    var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);

    // Planing Calculation
    var planingRate = accounting.unformat($('.planingVal').val(), accounting.settings.number.decimal);

    // Check hidden input first (if toggled via button), then checkbox (legacy/fallback)
    var isPlaning = false;
    if ($('#planing2-' + numb).is(':checkbox')) {
        isPlaning = $('#planing2-' + numb).is(':checked');
    } else {
        // If input type is hidden/text (due to toggle button), value 1=active
        isPlaning = ($('#planing2-' + numb).val() == 1);
    }

    var planAmount = 0;
    var l_val = parseFloat($('#l-' + numb).val()) || 0;
    var d_val = parseFloat($('#dpid-' + numb).val()) || 0;

    // If dpid/l is missing, try generic product_description hidden input
    if (d_val === 0 && l_val === 0) {
        d_val = parseFloat($('#product_description-' + numb).val()) || 0;
    }

    var length_val = l_val > 0 ? l_val : d_val;

    if (isPlaning) {
        var qty = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
        // If length is 0 (e.g. standard item), just qty * rate? Or 0?
        // Assuming length 1 for standard items if length is 0? No, usually planing is for timber.
        if (length_val == 0) length_val = 1;

        planAmount = qty * length_val * planingRate;
    }
    // Update span. ID might be resultplaning2- or just planingText-
    if ($('#resultplaning2-' + numb).length) {
        $('#resultplaning2-' + numb).text("Planing: " + accounting.formatNumber(planAmount));
    } else {
        $('#planingText-' + numb).text(accounting.formatNumber(planAmount));
    }

    var priceVal = accounting.unformat($("#rate-" + numb).val(), accounting.settings.number.decimal);
    var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
    var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
    var unitVal = $('#unit-' + numb).val();
    var pwith = parseFloat($('#product_pwith-' + numb).val()) || 0;
    var taxo = 0;
    var disco = 0;

    var totalPrice = 0;

    if (unitVal == 'Sqft') {
        // Sqft = (width_inches / 12) * length_feet
        var width_ft = pwith / 12;
        var sqftVal = width_ft * length_val;
        totalPrice = amountVal.toFixed(two_fixed) * priceVal * sqftVal;

    } else if (unitVal == 'Feet') {
        totalPrice = amountVal.toFixed(two_fixed) * priceVal * length_val;
    } else {
        // Standard: Price * Qty * Length (if length > 0, else Price * Qty)
        if (length_val > 0) {
            totalPrice = amountVal.toFixed(two_fixed) * priceVal * length_val;
        } else {
            totalPrice = amountVal.toFixed(two_fixed) * priceVal;
        }
    }

    // Update resultPlaning2 for legacy planing calc if needed (often same as planAmount but logic varies)
    var resultPlaning2 = planAmount; // Sync with new calculation


    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
        var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
        if (alertVal <= +amountVal) {
            var aqt = alertVal - amountVal;
            alert('Low Stock! ' + accounting.formatNumber(aqt));
        }
    }
    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
            //before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            //var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            var Inpercentage = (totalPrice / 100) * vatVal;

            totalValue = totalPrice;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
            //before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalValue;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
            //before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }
    $("#result-" + numb).html(accounting.formatNumber(totalValue));
    $("#resultplaning2-" + numb).html(accounting.formatNumber(resultPlaning2));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
};
var changeTaxFormat = function (getSelectv) {

    if (getSelectv == 'yes') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('%');
    } else if (getSelectv == 'inclusive') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('incl');

    } else {
        $("#tax_status").val('no');
        $("#tax_format").val('off');

    }
    var discount_handle = $("#discountFormat").val();
    var tax_handle = $("#tax_format").val();
    formatRest(tax_handle, discount_handle, trate);
}

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != '0') {
        $(".disCol").show();
        $("#discount_handle").val('yes');
        $("#discount_format").val(getSelectv);
    } else {
        $("#discount_format").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val('no');
    }
    var tax_status = $("#tax_format").val();
    formatRest(tax_status, getSelectv);
}

function formatRest(taxFormat, disFormat, trate = '') {
    var amntArray = [];
    // var planing2Array = [];
    var idArray = [];
    $('.amnt').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
        amntArray.push(v);
    });
    //     $('.description').each(function () {
    //     var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
    //    planing2Array.push(v);
    // });
    var prcArray = [];
    $('.prc').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        prcArray.push(v);
    });
    var vatArray = [];
    $('.vat').each(function () {
        if (trate) {
            var v = accounting.unformat(trate, accounting.settings.number.decimal);
            $(this).val(v);
        } else {
            var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        }
        vatArray.push(v);
    });

    // Toggle Planing Handler (Matches edit.php & newinvoice_v2.php structure)
    $('#pos_items').on('click', '.toggle-planing', function () {
        var rowid = $(this).data('rowid');
        var checkbox = $('#planing2-' + rowid);

        // Toggle the checkbox/input state
        if (checkbox.is(':checkbox')) {
            checkbox.prop('checked', !checkbox.prop('checked'));
        } else {
            // Handle if input is hidden/text (fallback)
            var val = checkbox.val();
            checkbox.val(val == 1 ? 0 : 1);
        }

        // Trigger recalculation (rowTotal checks the state we just toggled)
        rowTotal(rowid);
        billUpyog();
    });

    var discountArray = [];
    $('.discount').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        discountArray.push(v);
    });

    var taxr = 0;
    var discsr = 0;
    for (var i = 0; i < idArray.length; i++) {
        var x = idArray[i];
        amtVal = amntArray[i];
        // planing2Val = planing2Array[i];

        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        // var resultplaning2 = amtVal * planing2Val;

        if (vatVal == '') {
            vatVal = 0;
        }
        if (discountVal == '') {
            discountVal = 0;
        }
        if (taxFormat == '%') {
            if (disFormat == '%' || disFormat == 'flat') {
                var Inpercentage = precentCalc(result, vatVal);
                var result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = precentCalc(result, vatVal);
                result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else if (taxFormat == 'incl') {

            if (disFormat == '%' || disFormat == 'flat') {


                //var Inpercentage = (result * vatVal) / (100 + vatVal);

                var Inpercentage = (result / 100) * vatVal;

                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = (result * vatVal) / (100 + vatVal);
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else {

            if (disFormat == '%' || disFormat == 'flat') {

                var result = accounting.unformat($("#amount-" + x).val(), accounting.settings.number.decimal) * accounting.unformat($("#price-" + x).val(), accounting.settings.number.decimal);
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    var result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;
            }
        }

        $("#total-" + x).val(accounting.formatNumber(result));
        $("#result-" + x).html(accounting.formatNumber(result));
        // $("#resultplaning2-" + x).html(accounting.formatNumber(resultplaning2));


    }
    var sum = accounting.formatNumber(samanYog());
    $("#subttlid").html(sum);
    $("#taxr").html(accounting.formatNumber(taxr));
    $("#discs").html(accounting.formatNumber(discsr));
    billUpyog();
}

//remove productrow


$('#saman-row').on('click', '.removeProd', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
        billUpyog();
    });

    return false;
});
$('#productname-0').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) {
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#amount-0').val(1);
        $('#price-0').val(ui.item.data[1]);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#product_pwith-0').val(ui.item.data[9]);
        $('#product_thicknes-0').val(ui.item.data[10]);
        $('#pquick-0').val(ui.item.data[11]);
        $('#product_quick_code-0').val(ui.item.data[12]);
        $('#group_id-0').val(ui.item.data[13]);

        rowTotal(0);

        billUpyog();


    }
});
$(document).on('click', ".select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);
    var flag = true;
    var discount = $(this).attr('data-discount');
    var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
    if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);

    $('.pdIn').each(function () {
        if (pid == $(this).val()) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

            // if (stotal <= stock) {
            //    $('#amount-' + pi).val(accounting.formatNumber(stotal));
            //     $('#search_bar').val('').focus();
            //  } else {
            //     $('#stock_alert').modal('toggle');
            //  }
            rowTotal(pi);
            billUpyog();
            $('#amount-' + pi).focus();
            flag = false;
        }
    });
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {

        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;
        var data = '<tr id="ppid-' + cvalue + '" class="mb-1">' +
            '<td class="p-1">' +
            '<input type="text" class="form-control text-left p-mobile product-name-input" style="font-weight: 600; color: #333;" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + $(this).attr('data-pcode') + '-' + $(this).attr('data-name') + '">' +
            '<input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '" name="alert[]">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control p-mobile req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control p-mobile req prc" name="product_rate[]" id="rate-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="' + $(this).attr('data-rate') + '">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control p-mobile vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="' + t_r + '">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control p-mobile discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="' + discount + '">' +
            '</td>' +
            '<td>' +
            '<span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong><br>' +
            '<span class=\'planingText\' id="resultplaning2-' + cvalue + '">Planing: 0</span>' +
            '<input class="planing2" type="checkbox" id="planing2-' + cvalue + '" name="planing2" style="display:none;">' +
            '</td>' +
            '<td class="text-center">' +
            '<div class="btn-group btn-group-sm" role="group">' +
            '<button type="button" class="btn btn-danger removeItem" data-rowid="' + cvalue + '" title="Remove"> <i class="fa fa-trash"></i> </button>' +
            '<button type="button" class="btn btn-warning toggle-planing" data-rowid="' + cvalue + '" title="Toggle Planing"> <i class="fa fa-layers"></i> </button>' +
            '</div>' +
            '</td>' +
            '<input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0">' +
            '<input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0">' +
            '<input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '">' +
            '<input type="hidden" class="pdInqcode" name="pdInqcode[]" id="pdInqcode-' + cvalue + '" value="' + $(this).attr('data-product_quick_code') + '">' +
            '<input type="hidden" class="pdInpquick" name="pquick[]" id="pquick-' + cvalue + '" value="' + $(this).attr('data-pquick') + '">' +
            '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '">' +
            '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '">' +
            '<input type="hidden" class="form-control description" name="product_description[]" id="product_description-' + cvalue + '" value="' + $(this).attr('data-product_description') + '">' +
            '<input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value="' + $(this).attr('data-product_pwith') + '">' +
            '<input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value="' + $(this).attr('data-product_thicknes') + '">' +
            '<input type="hidden" name="pquick[]" id="pquick-' + cvalue + '" value="' + $(this).attr('data-pquick') + '">' +
            '<input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value="' + $(this).attr('data-product_quick_code') + '">' +
            '<input type="hidden" name="local_imported[]" id="local_imported-' + cvalue + '" value="' + $(this).attr('data-local_imported') + '">' +
            '<input type="hidden" name="o_pquick[]" id="o_pquick-' + cvalue + '" value="' + $(this).attr('data-pquick') + '">' +
            '<input type="hidden" name="product_sqft[]" id="sqft-' + cvalue + '" value="' + $(this).attr('data-sqft') + '">' +
            '<input type="hidden" name="group_id[]" id="group_id-' + cvalue + '" value="' + $(this).attr('data-group_id') + '">' +
            '</tr>';

        //ajax request
        // $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();

    }
});



$(document).on('click', ".toggle-planing", function () {
    var rowid = $(this).data('rowid');
    var checkbox = $('#planing2-' + rowid);
    var isChecked = !checkbox.prop('checked');

    checkbox.prop('checked', isChecked);

    // Toggle button style
    if (isChecked) {
        $(this).removeClass('btn-warning').addClass('btn-success');
    } else {
        $(this).removeClass('btn-success').addClass('btn-warning');
    }

    // Trigger calculation
    rowTotal(rowid);
    billUpyog();
});
$(document).on('click', ".v2_select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

    var discount = $(this).attr('data-discount');
    var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
    if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
    var flag = true;
    $('#v2_search_bar').val('');
    $('.pdIn').each(function () {

        if (pid == $(this).val()) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

            // if (stotal <= stock) {
            //     $('#amount-' + pi).val(accounting.formatNumber(stotal));
            //     $('#search_bar').val('').focus();
            //  } else {
            //     $('#stock_alert').modal('toggle');
            //  }
            rowTotal(pi);
            billUpyog();

            flag = false;
        }
    });
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {

        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    var sound = document.getElementById("beep");
    sound.play();
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;
        var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') / $(this).attr('data-product_description') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-pcode') + '-' + $(this).attr('data-name') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') / $(this).attr('data-product_description') + '"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"><input type="hidden" name="product_description[]" id="product_description-' + cvalue + '" value="' + $(this).attr('data-product_description') + '"><input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value="' + $(this).attr('data-product_pwith') + '"><input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value="' + $(this).attr('data-product_thicknes') + '"><input type="hidden" name="pquick[]" id="pquick-' + cvalue + '" value="' + $(this).attr('data-pquick') + '"><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value="' + $(this).attr('data-product_quick_code') + '"><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value="' + $(this).attr('data-product_quick_code') + '"></tr></tr>';
        //ajax request
        // $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();
    }
});

$('#saman-pos2').on('click', '.removeItem', function () {
    var pidd = $(this).attr('data-rowid');
    var pqty = accounting.unformat($('#amount-' + pidd).val(), accounting.settings.number.decimal);
    var old_amnt = $('#amount_old-' + pidd).val();
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $('#ppid-' + pidd).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
    });
    billUpyog();
    return false;
});


$('#saman-row-pos').on('click', '.removeItem', function () {


    var pidqcode = $(this).closest('tr').find('.pdInqcode').val();
    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = accounting.unformat($(this).closest('tr').find('.amnt').val(), accounting.settings.number.decimal);
    var pdinpquick = accounting.unformat($(this).closest('tr').find('.pdInpquick').val(), accounting.settings.number.decimal);
    var old_amnt = accounting.unformat($(this).closest('tr').find('.old_amnt').val(), accounting.settings.number.decimal);

    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        pdinpquick = pidqcode + '-' + pdinpquick;

        $('<input>').attr({
            type: 'hidden',
            name: 'reqstock[]',
            value: pdinpquick
        }).appendTo('form');

        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('#p' + $(this).closest('tr').find('.pdIn').attr('id')).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);

    });
    billUpyog();

    return false;

});



$(document).on('click', ".select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);
    var flag = true;
    var discount = $(this).attr('data-discount');
    var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
    if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);

    $('.pdIn').each(function () {
        if (pid == $(this).val()) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

            // if (stotal <= stock) {
            //  $('#amount-' + pi).val(accounting.formatNumber(stotal));
            //   $('#search_bar').val('').focus();
            //  } else {
            //    $('#stock_alert').modal('toggle');
            // }
            rowTotal(pi);
            billUpyog();
            $('#amount-' + pi).focus();
            flag = false;
        }
    });
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {

        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row-purchase div').length;
        var data = '<tr id="ppid-' + cvalue + '" class="mb-1"><td colspan="7" ><input type="text" class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + $(this).attr('data-pcode') + '-' + $(this).attr('data-name') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"></td></tr><tr><td><input type="text" class="form-control p-mobile req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ></td> <td><input type="text" class="form-control p-mobile req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') / $(this).attr('data-product_description') + '"></td><td> <input type="text" class="form-control p-mobile vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"></td>                 <td> <input type="text" class="form-control p-mobile vat" name="product_cost[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"></td>     <td> <input type="text" class="form-control p-mobile vat" name="profit_rates[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"></td>                              <td><input type="text" class="form-control p-mobile discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td>  <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0">   <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"><input type="hidden" name="product_description[]" id="product_description-' + cvalue + '" value="' + $(this).attr('data-product_description') + '"><input type="hidden" name="product_pwith[]" id="product_pwith-' + cvalue + '" value="' + $(this).attr('data-product_pwith') + '"><input type="hidden" name="product_thicknes[]" id="product_thicknes-' + cvalue + '" value="' + $(this).attr('data-product_thicknes') + '"><input type="hidden" name="pquick[]" id="pquick-' + cvalue + '" value="' + $(this).attr('data-pquick') + '"><input type="hidden" name="product_quick_code[]" id="product_quick_code-' + cvalue + '" value="' + $(this).attr('data-product_quick_code') + '"></tr></tr>';

        //ajax request
        // $('#saman-row').append(data);
        $('#purchase_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();

    }
});



$('#saman-row-purchase').on('click', '.removeItem', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = accounting.unformat($(this).closest('tr').find('.amnt').val(), accounting.settings.number.decimal);
    var old_amnt = accounting.unformat($(this).closest('tr').find('.old_amnt').val(), accounting.settings.number.decimal);
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('#p' + $(this).closest('tr').find('.pdIn').attr('id')).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);

    });
    billUpyog();

    return false;

});





$(document).on('click', ".quantity-up", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);

    var newVal = oldValue + 1;
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});

$(document).on('click', ".quantity-down", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);
    var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue - 1;
    }
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});



