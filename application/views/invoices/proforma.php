<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Proforma #<?php echo $invoice['tid'] ?></title>
    <style>
     body {
            color: #2B2000;
            font-family: 'Helvetica';
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 2mm;
            border: 0;
            font-size: 6pt;
             
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

       .plist tr td {
            line-height: 1pt;
            padding: 5pt 0pt 0pt 5pt;
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
             border: 1px solid #ddd;
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
            margin-right: 115pt;
        }

        .terms {
            font-size: 16pt;
            line-height: 16pt;
            margin-right: 20pt;
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
            padding-bottom: 20pt;
        }

         table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;
             text-align: center;
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

        }
      
.daashan {
	font-size: 10px;
	font-family: Verdana, Geneva, sans-serif;
	  line-height: 9pt;
}
      
      .daashanabc {
	font-size: 12px;
	font-family: Verdana, Geneva, sans-serif;
	  line-height: 9pt;
}



    </style>
</head>

<body <?php if (LTR == 'rtl') echo 'dir="rtl"'; ?>>

<div class="invoice-box">
    
    
    
    
    
     
    
    <table width="100%" border="0" >
  <tr>
    <th colspan="3" align="center" scope="row"><h1><strong><?php $loc = location($invoice['loc']);
                    echo $loc['cname']; ?></strong></h1></th>
  </tr>
 
  <tr>
    <th class="daashan" width="33%" align="left" valign="top" scope="row">
    
    
    
    <?php echo '<strong>' . $invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                echo $invoice['address'] . '<br>' . $invoice['city'] . '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '<br>' . $this->lang->line('Email') . ' : ' . $invoice['email'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                ?>
            </td>
        </tr><?php if ($invoice['name_s']) { ?>

            <tr>

                <td>
                    <?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
                    echo $invoice['name_s'] . '<br>';

                    echo $invoice['address_s'] . '<br>' . $invoice['city_s'] . '<br> ' . $this->lang->line('Phone') . ': ' . $invoice['phone_s'] . '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email_s'];

                    ?>
                </td>
            </tr>
        <?php } ?>
        
        
        
        </th>
    <th class="daashanabc" width="33%" align="center" valign="top" scope="row">
        
        
        
        <strong><?php $loc = location($invoice['loc']);?></strong> 
                <?php echo
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
                if ($loc['taxid']) ?><br>F/D Reg NO: TD/3066/A</th>
                
    <th class="daashan" width="33%" align="right"  valign="top" scope="row">
        
        
        
        
              <?php echo $this->lang->line('Proforma Invoice') ?> <br>
                        <?php echo $this->config->item('prefix') . '_P#' . $invoice['tid'] ?> <br>
                        
                        
                        
                    <?php echo $this->lang->line('Invoice Date') ?>
                      <?php echo $invoice['invoicedate'] ?><br>
                      
                      
                    <?php echo $this->lang->line('Due Date') ?>
                    <?php echo $invoice['invoiceduedate'] ?><br>
                        
                        
                    
                    
                    <?php if ($invoice['refer']) { ?>
                        <?php echo $this->lang->line('Reference') ?>
                            <?php echo $invoice['refer'] ?><br>
                    <?php } ?>
                    
                    
                    
                     
                
                
                
              
  </tr>
</table>











    
    
    
    
 
    
    

    
    <br/>
     <?php
                 $id2 = $this->input->get('id2');
                 
                   $admin2019 =    $this->aauth->get_user()->id;

              if($admin2019==10){
                  
                  
                  
                  
                  
                  
                  
                 
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                   $percentage = 70;
                                 
                                 
                   $invoice_tota_oklk     =      $invoice['total'];

                    $invoice_tota_oklk_2 = ($percentage / 100) * $invoice_tota_oklk;
                  
                  ?>
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 1rem;">
                #
            </td>
            <td>
                <?php echo $this->lang->line('Description') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>
            <td>
                Unit
            </td>
            <?php if ($invoice['tax'] > 0) echo '<td>' . $this->lang->line('Tax') . '</td>';
            if ($invoice['discount'] > 0) echo '<td>' . $this->lang->line('Discount') . '</td>'; ?>
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>
        <?php
        $fill = true;
        $sub_t = 0;
        $sub_t_col = 3;
        $n = 1;
        foreach ($products as $row) {
            $cols = 4;
            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $sub_t += $row['price'] * $row['qty'];
            $totl_qty = $row['product_des'] * $row['qty'];
            
            
            
            
            
            
            
            
                                               $subtotal_items_oklk     =      $row['subtotal'];
                                               $subtotal_items_oklk_2 = ($percentage / 100) * $subtotal_items_oklk;
   
                                              $sub_qty_oklk   = $row['product_des'] * $row['qty'];
                                              $sub_qty_oklk_2 = ($percentage / 100) * $sub_qty_oklk;
            
            
                                            
                                            $sub_qty2 = $row['pwith']/12*$row['product_des'] * $row['qty'];
                                            $sub_qty22 = ($percentage / 100) * $sub_qty2;
                                              
                                            $unit=$row['unit'];
                                            
                                            
                                            
                                            
                                            
                                            

            echo '<tr class="item' . $flag . '">  <td>' . $n . '</td>
                            <td>' . $row['product'] . '</td>
							<td style="width:18%;">' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
                            <td style="width:15%;" >';
                            
                            
                            
                            
                            
                                               if ( $unit === 'Feet' ) :
                                                  echo   $sub_qty_oklk_2 .'&nbsp;'. $row['unit']    ;
                                               else :
         
                                                   echo $sub_qty22 .'&nbsp;'. $row['unit']  ;
                                               endif;
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            echo'</td>  <td style="width:6%;" >' . +$row['qty'] .'</td>  ';
            if ($invoice['tax'] > 0) {
                $cols++;
                echo '<td style="width:16%;">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . ' <span class="tax">(' . amountFormat_s($row['tax']) . '%)</span></td>';
            }
            if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="width:15%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
            }
            echo '<td class="t_center">' . amountExchange($subtotal_items_oklk_2, $invoice['multi'], $invoice['loc']) . '</td></tr>';

         
            if (CUSTOM) {
                $p_custom_fields = $this->custom->view_fields_data($row['pid'], 4, 1);

                if (is_array($p_custom_fields[0])) {
                    $z_custom_fields = '';

                    foreach ($p_custom_fields as $row) {
                        $z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
                    }

                    echo '<tr class="item' . $flag . ' descr">  <td> </td>
                            <td colspan="' . $cc . '">' . $z_custom_fields . '&nbsp;</td>
							
                        </tr>';
                }
            }
            $fill = !$fill;
            $n++;
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




 <?php
                                              $invoice_total_oklk     =      $invoice['total'];
                                               $subtotal_items_oklk_2 = ($percentage / 100) * $invoice_total_oklk;

                                                        
                                               $subtotal_items_sub_t_2 = ($percentage / 100) * $sub_t; ?>






        <tr>
            <td class="myco2" rowspan="<?php echo $cols ?>"><br><br><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p><br><p>' . $this->lang->line('Total Amount') . ': ' . amountExchange($subtotal_items_oklk_2, $invoice['multi']) . '</p><br><p>' . $this->lang->line('Paid Amount') . ': ' . amountExchange($subtotal_items_oklk_2, $invoice['multi']); ?></p>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr class="f_summary">


            <td><?php echo $this->lang->line('SubTotal') ?>:</td>

            <td><?php echo amountExchange($subtotal_items_sub_t_2, $invoice['multi']); ?></td>
        </tr>
        <?php if ($invoice['tax'] > 0) {
            echo '<tr>        

            <td> ' . $this->lang->line('Total Tax') . ' :</td>

            <td>' . amountExchange($invoice['tax'], $invoice['multi']) . '</td>
        </tr>';
        }
        if ($invoice['discount'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Total Discount') . ':</td>

            <td>' . amountExchange($invoice['discount'], $invoice['multi']) . '</td>
        </tr>';

        }
        if ($invoice['shipping'] > 0) {
             $shipping_oklk_2 = ($percentage / 100) * $invoice['shipping'];
            echo '<tr>


            <td>' . $this->lang->line('Shipping') . ':</td>

            <td>' . amountExchange($shipping_oklk_2, $invoice['multi']) . '</td>
        </tr>';

        }
        ?>
        <tr>


            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td><strong><?php
            
          $rming_oklk_2 = ($percentage / 100) * $rming;  
            
    //$rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming_oklk_2 < 0) {
        $rming_oklk_2 = 0;

    }
    echo amountExchange($rming_oklk_2, $invoice['multi']);
    echo '</strong></td>
		</tr>
		</table>';

  
    ?></div>
</div>
</body>
</html>
    
 <?php
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
              }else{
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                   ?><table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 1rem;">
                #
            </td>
            <td>
                <?php echo $this->lang->line('Description') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>
            <td>
                Unit
            </td>
            <?php if ($invoice['tax'] > 0) echo '<td>' . $this->lang->line('Tax') . '</td>';
            if ($invoice['discount'] > 0) echo '<td>' . $this->lang->line('Discount') . '</td>'; ?>
            <td>
                 SubTotal 
            </td>
        </tr>
        <?php
        $fill = true;
        $sub_t = 0;
        $sub_t_col = 3;
        $n = 1;
        foreach ($products as $row) {
            $cols = 4;
            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $sub_t += $row['price'] * $row['qty'];
            $totl_qty = $row['product_des'] * $row['qty'];
            
            
            
            
                                                $sqft_total = $row['pwith']/12*$row['product_des'];
                                                $feet_rate = $row['price'] / $row['product_des'];
                                                $sqft_rate = $row['price'] / $sqft_total;
            
            
                                           
             
            
            
            
            
            
            
            
            
            
            
                                            $sub_qty = $row['product_des'] * $row['qty'];
                                            $sub_qty2 = $row['pwith']/12*$row['product_des'] * $row['qty'];
                                            $unit=$row['unit'];
                                            
                                            
                                            
                                            
                                            
                                            

            echo '<tr class="item' . $flag . '">  <td>' . $n . '</td>
                            <td>' . $row['product'] . '</td>
							<td style="width:18%;">';
							
							
							  if ( $unit === 'Feet' ) :
                                                  echo   amountExchange($feet_rate, $invoice['multi'], $invoice['loc']) ;
                                               else :
         
                                                   echo amountExchange($sqft_rate, $invoice['multi'], $invoice['loc']) ;
                                               endif;
							
							
							
							echo '</td>
                            <td style="width:15%;" >';
                            
                            
                            
                            
                            
                                               if ( $unit === 'Feet' ) :
                                                  echo    $sub_qty .'&nbsp;'. $row['unit']    ;
                                               else :
         
                                                   echo  $sub_qty2 .'&nbsp;'. $row['unit']  ;
                                               endif;
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            echo'</td>  <td style="width:6%;" >' . +$row['qty'] .'</td>  ';
            if ($invoice['tax'] > 0) {
                $cols++;
                echo '<td style="width:16%;">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . ' <span class="tax">(' . amountFormat_s($row['tax']) . '%)</span></td>';
            }
            if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="width:15%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
            }
            echo '<td>' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td></tr>';

         
            if (CUSTOM) {
                $p_custom_fields = $this->custom->view_fields_data($row['pid'], 4, 1);

                if (is_array($p_custom_fields[0])) {
                    $z_custom_fields = '';

                    foreach ($p_custom_fields as $row) {
                        $z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
                    }

                    echo '<tr class="item' . $flag . ' descr">  <td> </td>
                            <td colspan="' . $cc . '">' . $z_custom_fields . '&nbsp;</td>
							
                        </tr>';
                }
            }
            $fill = !$fill;
            $n++;
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
            <td class="myco2" rowspan="<?php echo $cols ?>"><br><br><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p><br><p>' . $this->lang->line('Total Amount') . ': ' . amountExchange($invoice['total'], $invoice['multi']) . '</p><br><p>' . $this->lang->line('Paid Amount') . ': ' . amountExchange($invoice['pamnt'], $invoice['multi']); ?></p>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr class="f_summary">


            <td><?php echo $this->lang->line('SubTotal') ?>:</td>

            <td><?php echo amountExchange($sub_t, $invoice['multi']); ?></td>
        </tr>
        <?php if ($invoice['tax'] > 0) {
            echo '<tr>        

            <td> ' . $this->lang->line('Total Tax') . ' :</td>

            <td>' . amountExchange($invoice['tax'], $invoice['multi']) . '</td>
        </tr>';
        }
        if ($invoice['discount'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Total Discount') . ':</td>

            <td>' . amountExchange($invoice['discount'], $invoice['multi']) . '</td>
        </tr>';

        }
        if ($invoice['shipping'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Shipping') . ':</td>

            <td>' . amountExchange($invoice['shipping'], $invoice['multi']) . '</td>
        </tr>';

        }
        ?>
        <tr>


            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td><strong><?php
    $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;

    }
    echo amountExchange($rming, $invoice['multi']);
    echo '</strong></td>
		</tr>
		</table>';

  
    ?></div>
</div>
</body>
</html>
		
		
		<?php
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
              }