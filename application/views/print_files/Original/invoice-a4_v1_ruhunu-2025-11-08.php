<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
<title>Print Invoice #<?php echo $invoice['tid']; ?></title>
    <style>




  
  
  
 


        .invoice-box {
            width: 210mm;
            line-height: 15pt;
            margin: auto;
            padding: 2mm;
            border: 0;
            font-size: 6pt;
             
            color: #000;
        }

        table {
            width: 100%;
            line-height: 20pt;
            text-align: left;
            border-collapse: collapse;
        }

       .plist tr td {
            line-height: 13pt;
            padding: 5pt 2pt 2pt 5pt;
            text-align: left;
        }
        
        
        .t_center {
            line-height: 1pt
             padding: 2pt 2pt 2pt 2pt;
        }

        .subtotal {
            page-break-inside: avoid;
          
        }

        .subtotal tr td {
	line-height: 7pt;
	padding: 2pt 2pt 2pt 2pt;
	border: 1px none #ddd;
        }

        

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 15pt;
        }

   /*     .terms {
            font-size: 16pt;
            line-height: 16pt;
            margin-right: 2pt;
        }

          .invoice-box table td {
           padding: 10pt 4pt 8pt 4pt;
            vertical-align: top;
        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 6pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 2pt;
        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 2pt;
        }

         table tr.heading td {
             
            color: #515151;
            padding: 8pt;
            
        }

        table tr.details td {
            padding-bottom: 2pt;
        }

        .invoice-box table tr.item td {
            border: 1px solid #ddd;
        }

        table tr.b_class td {
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td {
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

       

        .myco2 {
           padding: 2pt 2pt 2pt 2pt;
        }

       

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        

        .party {
            border: #ccc 1px solid;

        }*/
      
.daashan {
	font-size: 11px;
	font-family: Verdana, Geneva, sans-serif;
	line-height: 9pt;
}


.daashanxxx {
	font-size: 10px;
	font-family: Verdana, Geneva, sans-serif;
	  line-height: 9pt;
}

      
      .daashanabc {
	font-size: 12px;
	font-family: Verdana, Geneva, sans-serif;
	  line-height: 9pt;
}


      .daashanabcxx {
	font-size: 9px;
	font-family: Verdana, Geneva, sans-serif;
	  line-height: 9pt;
	  color:#999;
}


xxxx. {
    border: 1px solid #CCC;
    border-collapse: collapse;
}

td {
    border: none;
}


        .top_logo {
            max-height: 55px;
            max-width: 90px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
        }

    </style>
</head>
<body dir="<?= LTR ?>">
 
<table width="100%" border="0" >
  
 
 
  <tr>
    <th class="daashan" width="23%" align="left" valign="middle" scope="row">
    
               <?php echo '<strong>' . $invoice['name'] . '</strong><br>';
               
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                echo $invoice['address'] . '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '<br>';
                if ($invoice['taxid']) echo '<br> Customer Vat NO: ' . $invoice['taxid'];
               
                if (is_array($c_custom_fields)) {
                    echo '<br>';
                    foreach ($c_custom_fields as $row) {
                        echo $row['name'] . ': ' . $row['data'] . '<br>';
                    }
                }
                ?>
               
        <?php if (@$invoice['name_s']) { ?>
           
                 
                    <?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
                    echo $invoice['name_s'] . '<br>';
                    echo $invoice['address_s'] . '<br>' . $invoice['city_s'] . ', ' . $invoice['region_s'] . '<br>' . $invoice['country_s'] . '-' . $invoice['postbox_s'] . '<br> ' . $this->lang->line('Phone') . ': ' . $invoice['phone_s'] . '<br> ' ;
                    ?>
                
         
        <?php } ?></th>
        
        
    <th class="daashanabc" width="40%" align="center" valign="top" scope="row">
          <br><br><h1><strong>VICTORIA<br><br>TIMBER STORES</strong></h1>    <br>
         
         501 kankesanthurai Road, Tellipalai, Jaffna, Sri Lanka                                  <br>
    Phone :  094777860221 <br>Email  : ramzan1964lanka@gmail.com / abrlanka@yahoo.com
    

   
    
    
    
    
    </th>   
    
    
    
     <th class="daashanabc"  width="23%" align="left"  valign="middle" scope="row">
        
                     Bill Number:
                     <?= $general['prefix'] . ' ' . $invoice['tid'] ?> <br>
                     
                     Date:
                   <?php echo dateformat($invoice['invoicedate']) ?><br><br>
                    
                 
      
    
                     
     <?php 
                     
         $price_second_tex = $this->input->get('is', TRUE);                
                     
                     
  if ($price_second_tex == "") {

                                                          if ($invoice['tax'] > 0) {

                                   echo 'TAX INVOICE';
                                   echo '<br>Our Vat ID:6-7000';

                                                   }
                            //

                    }else{


                        

                                   echo 'TAX INVOICE';
                                   echo '<br>Our Vat ID:6-7000';

                                                    

                          
                    }     ?>             
                     
                     
                
                <?php if ($invoice['refer']) { ?><br>
                    <?php echo $this->lang->line('Reference') ?>
                        <?php echo $invoice['refer'] ?>
                    
                <?php } ?> 
              
  </tr>
</table>




<div class="invoice-box">
       






                 

                  
                 <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="daashan">
            <td width="3%" style="width:3%;">
                #
            </td>
            <td width="56%">
                <?php echo $this->lang->line('Description') ?>
            </td>
            <td width="11%">
               Pcs
            </td>
            
               
            <td width="6%">
            <?php echo $this->lang->line('Qty') ?>
            </td>           
            <td width="8%">
            <?php echo $this->lang->line('Price') ?>
            </td>
            <?php 
           // if ($invoice['tax'] > 0) echo '<td>' . $this->lang->line('Tax') . '</td>';
             if ($invoice['discount'] > 0) echo '<td>' . $this->lang->line('Discount') . '</td>'; 
            ?>
            <td width="15%" align="right">
              <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>
       
<?php
$fill = true;
$sub_t = 0;
$sub_t_col = 3;
$n = 1;

// Define size ranges for Feet and Sqft
$size_ranges = [
    '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', 
    '16', '17', '18', '19', '20', '21-22', '23-24', '25-26'
];

// Group products by group_id, unit, and size range
$grouped_products = [];
foreach ($products as $row) {
    $group_id = $row['group_id'];
    $unit = $row['unit'];
    
    // Determine size range based on product_des
    $product_des = $row['product_des'];
    $size_range = '';
    
    if ($unit === 'Feet' || $unit === 'Sqft') {
        if ($product_des >= 4 && $product_des <= 20) {
            $size_range = (string)$product_des;
        } elseif ($product_des >= 21 && $product_des <= 22) {
            $size_range = '21-22';
        } elseif ($product_des >= 23 && $product_des <= 24) {
            $size_range = '23-24';
        } elseif ($product_des >= 25 && $product_des <= 26) {
            $size_range = '25-26';
        } else {
            $size_range = 'Other';
        }
    } else {
        $size_range = 'N/A'; // For Qbic and other units
    }
    
    $key = $group_id . '_' . $unit . '_' . $size_range;
    
    if (!isset($grouped_products[$key])) {
        $grouped_products[$key] = [
            'group_id' => $group_id,
            'unit' => $unit,
            'size_range' => $size_range,
            'items' => [],
            'total_qty' => 0,
            'total_pcs' => 0,
            'total_subtotal' => 0,
            'total_row_qty_t' => 0,
            'total_row_qty' => 0,
            'first_item' => $row
        ];
    }
    
    // Add current row to the group
    $grouped_products[$key]['items'][] = $row;
    
    // Calculate metrics for current row
    $price_second = $this->input->get('is', TRUE);
    
    // Determine quantity display based on unit type and pricing
    if ($row['unit'] == "Qbic") {
        $row_qty_full_feet = $row['pquick'];
    } else {
        $row_qty_full_feet = $row['qty'] * $row['product_des'];
    }
    
    $row_qty_tt = $row['qty'];
    
    // Apply percentage discount if specified
    if ($price_second == "" || $invoice['tax'] > 0) {
        $row_qty = $row_qty_full_feet;
        $row_qty_t = $row['qty'];
        $row_subtotal = $row['subtotal'];
    } else {
        $row_qty = $row_qty_full_feet / 100 * $price_second;
        $row_qty_t = $row_qty_tt / 100 * $price_second;
        $row_subtotal = $row['subtotal'] / 100 * $price_second;
    }
    
    // Accumulate totals for the group
    $grouped_products[$key]['total_qty'] += $row['qty'];
    $grouped_products[$key]['total_pcs'] += $row['product_des'];
    $grouped_products[$key]['total_subtotal'] += $row_subtotal;
    $grouped_products[$key]['total_row_qty_t'] += $row_qty_t;
    $grouped_products[$key]['total_row_qty'] += $row_qty;
}

// Sort grouped products by unit and size range
uasort($grouped_products, function($a, $b) use ($size_ranges) {
    // First sort by unit
    $unit_order = ['Feet' => 1, 'Sqft' => 2, 'Qbic' => 3, 'Other' => 4];
    $a_unit_order = $unit_order[$a['unit']] ?? 5;
    $b_unit_order = $unit_order[$b['unit']] ?? 5;
    
    if ($a_unit_order !== $b_unit_order) {
        return $a_unit_order - $b_unit_order;
    }
    
    // Then sort by size range according to predefined order
    if ($a['unit'] === 'Feet' || $a['unit'] === 'Sqft') {
        $a_index = array_search($a['size_range'], $size_ranges);
        $b_index = array_search($b['size_range'], $size_ranges);
        
        if ($a_index !== false && $b_index !== false) {
            return $a_index - $b_index;
        }
    }
    
    return 0;
});

// Display grouped products
foreach ($grouped_products as $key => $group) {
    $cols = 4;
    $flag = $fill ? ' mfill' : '';
    $row = $group['first_item'];
    
    $sub_t += $group['total_subtotal'];
    
    // Calculate metrics using first item's data for display
    $sqft_total = $row['pwith']/12 * $row['product_des'];
    $feet_rate = $row['price'];
    $quick_rate = $row['price'];
    $sqft_rate = $row['price'];
    $unit = $row['unit'];
    
    echo '<tr class="daashan' . $flag . '">';
    echo '<td>' . $n . '</td>';
    
    // Display product with unit and size range info
    $item_count = count($group['items']);
    $display_text = $row['product'];
    
    if ($group['unit'] === 'Feet' || $group['unit'] === 'Sqft') {
        $display_text .= ' <strong>[' . $group['unit'] . ' - Size: ' . $group['size_range'] . ']</strong>';
    } else {
        $display_text .= ' <strong>[' . $group['unit'] . ']</strong>';
    }
    
    if ($item_count > 1) {
        $display_text .= ' <span style="color:#666;">(' . $item_count . ' items combined)</span>';
    }
    
    echo '<td>' . $display_text . '</td>';
    
    // Display grouped quantities
    echo '<td style="width:6%;"><strong>' . round($group['total_row_qty_t'], 1) . '</strong></td>';
    echo '<td style="width:6%;"><strong>' . round($group['total_row_qty'], 2) . '</strong></td>';
    echo '<td style="width:16%;">';
    
    // Display price based on tax and unit type
    if ($invoice['tax'] > 0) {
        $feet_rate_tex = $feet_rate;
        $sqft_rate_tex = $feet_rate;
        
        if ($unit === 'Feet') {
            echo amountExchange($feet_rate_tex, $invoice['multi'], $invoice['loc']);
        } else {
            echo amountExchange($sqft_rate_tex, $invoice['multi'], $invoice['loc']);
        }
    } else {
        switch ($unit) {
            case 'Feet':
                echo amountExchange($feet_rate, $invoice['multi'], $invoice['loc']);
                break;
            case 'Sqft':
                echo amountExchange($sqft_rate, $invoice['multi'], $invoice['loc']);
                break;
            case 'Qbic':
                echo amountExchange($quick_rate, $invoice['multi'], $invoice['loc']);
                break;
            case '':
                echo amountExchange($row['price'], $invoice['multi'], $invoice['loc']);
                break;
        }
    }
    
    echo '</td>';
    
    // Display discount if applicable
    if ($invoice['discount'] > 0) {
        $cols++;
        echo '<td style="width:15%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
    }
    
    // Display grouped subtotal
    echo '<td align="right"><strong>' . amountExchange($group['total_subtotal'], $invoice['multi'], $invoice['loc']) . '</strong></td>';
    echo '</tr>';
    
    // Optional: Show individual items in the group
    if ($item_count > 1) {
        echo '<tr class="group-details' . $flag . '" style="display: none; background: #f9f9f9;">';
        echo '<td colspan="' . ($cols + 2) . '">';
        echo '<div style="padding: 10px; border: 1px solid #ddd; margin: 5px 0;">';
        echo '<strong>Group Details (' . $group['unit'];
        if ($group['size_range'] !== 'N/A') {
            echo ' - Size: ' . $group['size_range'];
        }
        echo '):</strong><br>';
        
        foreach ($group['items'] as $index => $detail_row) {
            echo ($index + 1) . '. ' . $detail_row['product'] . 
                 ' - Qty: ' . $detail_row['qty'] . 
                 ', Pcs: ' . $detail_row['product_des'] . 
                 ', Unit: ' . $detail_row['unit'] . '<br>';
        }
        
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
    
    // Handle custom fields
    if (CUSTOM) {
        $p_custom_fields = $this->custom->view_fields_data($row['pid'], 4, 1);
        
        if (is_array($p_custom_fields[0])) {
            $z_custom_fields = '';
            
            foreach ($p_custom_fields as $custom_row) {
                $z_custom_fields .= $custom_row['name'] . ': ' . $custom_row['data'] . '<br>';
            }
            
            echo '<tr class="item' . $flag . ' descr">';
            echo '<td></td>';
            echo '<td colspan="' . $cols . '">' . $z_custom_fields . '</td>';
            echo '</tr>';
        }
    }
    
    $fill = !$fill;
    $n++;
}


        if ($invoice['planing'] > 0) {

            $sub_t_col++;
        }
        if ($invoice['cuttingsawing'] > 0) {

            $sub_t_col++;
        }
        if ($invoice['loadingunloading'] > 0) {

            $sub_t_col++;
        }
        if ($invoice['shipping'] > 0) {

            $sub_t_col++;
        }
        if ($invoice['tax'] > 0) {
            $sub_t_col++;
        }
        if ($invoice['discount'] > 0) {
            $sub_t_col++;
        }
        ?>


    </table>
    <br>
    <table class="subtotal">


        <tr> 
            <td width="63%" rowspan="<?php echo $sub_t_col ?>" class="">
            
            
            
            
            
            <table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td width="21%"><p><?php echo '<strong>' . $this->lang->line('Status') . ': </strong></p>'; ?></td>
    <td width="28%"><p><?php echo '<strong>' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p>'; ?></td>
    <td width="51%"> </td>
  </tr>
  <tr>
    <td align="left" valign="top">
               <br>Total :<br>
                      
                      
                      
                      <?php if (!$general['t_type']) {
                        
                        
                        
                        
                        
                        
                           foreach ($activity as $row) {
                          
                           if($row['type'] == 'Income'){
                               
                               if($row['method'] == 'Balance'){
                               
                                    
                 echo '<br>Advance : <br>';
                               
                                      }
                                     }
                               }
                        
                        
                        
                        
                       

        
                    }?>
                     <br> Paid   : <br>
                      
                      
                      
                      
                      
                      
                        <br>Balance Due:<br>
                         
                 
               </td>
    <td align="right" valign="top"><?php 
                        
                        
                        
                        
           if ($price_second == "") {


                            $invoice_total = $invoice['total'];
                            $row_credit = $row['credit'];
                            $invoice_pamnt = $invoice['pamnt'];

                    }else{


                           if ($invoice['tax'] > 0) {

                                  $invoice_total = $invoice['total'];
                                  $row_credit = $row['credit'];
                                  $invoice_pamnt = $invoice['pamnt'];

                            }else{

                                  $invoice_total = $invoice['total'] /100*$price_second;
                                  $row_credit = $row['credit']/100*$price_second;
                                  $invoice_pamnt = $invoice['pamnt']/100*$price_second;

                            }  

                          
                    } 



                   
				   if (!$general['t_type']) {
					   
                        echo '<br>' . amountExchange($invoice_total, $invoice['multi'], $invoice['loc']) . '<br>';
 
                        
                        
                           foreach ($activity as $row) {
                          
                           if($row['type'] == 'Income'){
                               
                               if($row['method'] == 'Balance'){
                               
                                    
                        echo '<br>' . amountExchange($row_credit, $invoice['multi'], $invoice['loc']) . '<br>';
                               
                                      }
                                     }
                               }
                        
                        
                        

                        
                        if (@$round_off['other']) {
                            $final_amount = round($invoice_total, $round_off['active'], constant($round_off['other']));
                            echo '<p>' . $this->lang->line('Round Off') . ' ' . $this->lang->line('Amount') . ': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br><p>';
                        }

                        echo '<br>' . amountExchange($invoice_pamnt, $invoice['multi'], $invoice['loc']) . '<br>';
						
						
						$rming = $invoice_total - $invoice_pamnt;
    if ($rming < 0) {
        $rming = 0;
    }
    if (@$round_off['other']) {
        $rming = round($rming, $round_off['active'], constant($round_off['other']));
    }
						
						
						echo '<br>' . amountExchange($rming, $invoice['multi'], $invoice['loc']);
						
						
                    }
                    
                    
                    
                    
                    
                    
                  

                   
                    
                    
                    
                    

                    if ($general['t_type']) {
                        echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
                    }
                    ?></td>
    <td> </td>
  </tr>
 
            </table>

					
					
            </td>
			

          <td width="22%"><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
          <td width="19%"> </td>
      </tr>
		
		
		
        <tr>
          <td><?php echo $this->lang->line('SubTotal') ?>:</td>
    
    
    <?php  
     

                    
                    
  if ($price_second == "") {
                            
  
                           if ($invoice['tax'] > 0) {

                                  $sub_t_aaa = $sub_t;
                                //  $sscl =   $invoice['total']/100*2.5;
                                                              
                            $invoice_discount =   $invoice['discount'];
                            $invoice_shipping =  $invoice['shipping']/118*100;
                            $invoice_planing =   $invoice['planing']/118*100;
                            $invoice_cuttingsawing =   $invoice['cuttingsawing']/118*100;
                            $invoice_loadingunloading =   $invoice['loadingunloading']/118*100;

                    }else{

                                 $sub_t_aaa = $sub_t;
                            //$sscl =   $invoice['total']/100*2.5;
  
                            $invoice_discount =   $invoice['discount'];
                            $invoice_shipping =   $invoice['shipping'];
                            $invoice_planing =   $invoice['planing'];
                            $invoice_cuttingsawing =   $invoice['cuttingsawing'];
                            $invoice_loadingunloading =   $invoice['loadingunloading'];

                            }  

                            

                    }else{


                           if ($invoice['tax'] > 0) {

                                  $sub_t_aaa = $sub_t;
                                  //$sscl =   $invoice['total']/100*2.5;
                                                              
                            $invoice_discount =   $invoice['discount'];
                            $invoice_shipping =   $invoice['shipping']/118*100;
                            $invoice_planing =   $invoice['planing']/118*100;
                            $invoice_cuttingsawing =   $invoice['cuttingsawing']/118*100;
                            $invoice_loadingunloading =   $invoice['loadingunloading']/118*100;

                    }else{

                                  $sub_t_aaa = $sub_t/100*$price_second;
                                  //$sscl_second =   $invoice['total']/100*2.5;
                                 // $sscl =   $sscl_second/100*$price_second;
                           
                            $invoice_ssc_imported =   $invoice['imported']/100*$price_second;
                            $invoice_ssc_local =   $invoice['local']/100*$price_second;
                           
                           
                            $invoice_discount =   $invoice['discount']/100*$price_second;
                            $invoice_shipping =   $invoice['shipping']/100*$price_second/118*100;
                            $invoice_planing =   $invoice['planing']/100*$price_second/118*100;
                            $invoice_cuttingsawing =   $invoice['cuttingsawing']/100*$price_second/118*100;
                            $invoice_loadingunloading =   $invoice['loadingunloading']/100*$price_second/118*100;

                            }  

                          
                    } 

  $totalinvoicevalue = $invoice_shipping+$invoice_planing+$invoice_cuttingsawing+$invoice_loadingunloading;
  $total_invoice_value = $totalinvoicevalue + ($sub_t_aaa /118*100 );                  
  $invoice_tax_aaa   =   $invoice['total'] -$total_invoice_value ;

  

  $total_invoice_value_price = $sub_t_aaa /118*100;
  $total_invoice_value_price_second = $totalinvoicevalue + $total_invoice_value_price;
                    
                    if ($invoice['tax'] > 0) {
							     
							     
							      //$sub_t_tex = ($sub_t_aaa - $invoice['tax'] );
                                  $sub_t_tex = ($sub_t_aaa /118*100 );
							      
							       echo '<td align="right">' . amountExchange($sub_t_tex, $invoice['multi'], $invoice['loc']) . '</td>';
							      
                                   }else{
							      
							             if ($price_second > 0) {
                                         
                                                                //$price_second_tax = $totalinvoicevalue + ($sub_t_aaa - $invoice['tax'] );   
                                         
                                                                
                                                                //$invoice_tax_edit = $sub_t_aaa/118*100;
                                                                $sub_t_tex = $sub_t_aaa / 118*100;
                                                               
                                                                $invoice_tax   =   $invoice_total - $total_invoice_value_price_second ;
                                         
                                                               
                                                               echo '<td align="right">' . amountExchange($sub_t_tex, $invoice['multi'], $invoice['loc']) . '</td>';
							                  
                                                               }else{
                                         
                                                               echo '<td align="right">' . amountExchange($sub_t_aaa, $invoice['multi'], $invoice['loc']) . '</td>';
                                         
                                                                }
                    
                    
                                    
							     
						            	 }            
            ?>
    
          
    
    
    
    
                </tr>
            
            <tr><td>
            
        
             
             
             <?php  if ($invoice['discount'] > 0) {
            echo $this->lang->line('Total Discount') . '<br><br>';
             } ?>             
             
             
             <?php  if ($invoice['shipping'] > 0) {
            echo 'Transport <br><br>';
             } ?>
             
             <?php  if ($invoice['planing'] > 0) {
            echo 'Planing <br><br>';
             } ?>
             
             
             <?php  if ($invoice['cuttingsawing'] > 0) {
            echo 'Cutting / Sawing <br><br>';
             } ?>
             
             <?php  if ($invoice['loadingunloading'] > 0) {
            echo 'Loading / Unloading <br><br>';
             } ?>
          
             
             

             <?php  if ($invoice['tax'] > 0) {
            echo 'Total Invoice Value <br><br>';
            echo 'V.A.T 18% <br><br>';
             echo 'Imported S.S.C 2.5% <br><br>';
             echo 'Local S.S.C 2.5% <br><br>';
             } ?>          

            

              <?php   if ($price_second > 0) {
                          if ($invoice['tax'] > 0) {
                         //
                   }else{
             echo  'Total Invoice Value <br><br>';
             echo  'V.A.T 18% <br><br>';
             echo 'Imported S.S.C 2.5% <br><br>';
             echo 'Local S.S.C 2.5% <br><br>';
                }    
         } ?>   
              
              
              
              
               
               
            <td align="right">
             
             
             
             
             
             
             
           
             
               <?php  if ($invoice['discount'] > 0) {
             echo  amountExchange($invoice_discount, $invoice['multi'], $invoice['loc']) . '<br><br>';
             } ?> 
             
               <?php  if ($invoice['shipping'] > 0) {
             echo  amountExchange($invoice_shipping, $invoice['multi'], $invoice['loc']) . '<br><br>';
             } ?>              
             
               <?php  if ($invoice['planing'] > 0) {
             echo  amountExchange($invoice_planing, $invoice['multi'], $invoice['loc']) . '<br><br>';
             } ?>                     
            
               <?php  if ($invoice['cuttingsawing'] > 0) {
             echo  amountExchange($invoice_cuttingsawing, $invoice['multi'], $invoice['loc']) . '<br><br>';
             } ?> 
               
               <?php  if ($invoice['loadingunloading'] > 0) {
             echo  amountExchange($invoice_loadingunloading, $invoice['multi'], $invoice['loc']) . '<br><br>';
             } ?>                

               
            
               
               <?php  if ($invoice['tax'] > 0) {
             echo  amountExchange($total_invoice_value, $invoice['multi'], $invoice['loc']) . '<br><br>';
             echo  amountExchange($invoice_tax_aaa, $invoice['multi'], $invoice['loc']) . '<br><br>'; 
             echo  amountExchange($invoice['imported'], $invoice['multi'], $invoice['loc']) . '<br><br>';
             echo  amountExchange($invoice['local'], $invoice['multi'], $invoice['loc']) . '<br><br>';
             } ?> 
                                  
                                  
               <?php   if ($price_second > 0) {
                          if ($invoice['tax'] > 0) {
                         //
                   }else{
             echo  amountExchange($total_invoice_value_price_second, $invoice['multi'], $invoice['loc']) . '<br><br>';
             echo  amountExchange($invoice_tax, $invoice['multi'], $invoice['loc']) . '<br><br>';  
             echo  amountExchange($invoice_ssc_imported, $invoice['multi'], $invoice['loc']) . '<br><br>';
             echo  amountExchange($invoice_ssc_local, $invoice['multi'], $invoice['loc']) . '<br><br>';             
                }    
         } ?>
               
               
                                  
            
            </td></tr>

        
  </table>
        
        
        
    
    <table width="100%" border="0" >
  
  <tr>
    <th colspan="3" align="center" scope="row">  භාණ්ඩ රැගෙන ගොස් දින 14 පසු කරනු ලබන පැමිණිලි භාරගනු නොලැබේ.  </tr>
  <tr>
    <th class="daashan" width="33%" align="left" valign="top" scope="row">
    
              
              
              
              </th>
              
              
              
       
              
    <th class="daashan" width="33%" align="center" valign="top" scope="row">
        
     <?php    echo ' D My World <br>The Best Timber Business Management Solution in Sri Lanka<br> 077 83 87 500 ' ; ?>        
      



</th>
 
 
 
                
    <th class="daashan" width="33%" align="right"  valign="top" scope="row">
        
                ....................... <br> <?php echo $this->lang->line('Authorized person') ?>
        </th>      
  </tr>
</table>
    
</div>
</body>
</html>  