<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
<title>Print Invoice #<?php echo $invoice['tid']; ?></title>
<style>
    /* Import Google Font */
  
@import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Yaldevi:wght@200..700&display=swap');

    
    body {
        font-family: 'Roboto', Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #000;
        font-size: 10px;
        line-height: 1.3;
        font-weight: 400;
    }

    .invoice-box {
        width: 210mm;
        margin: 0 auto;
        padding: 5mm;
        font-family: 'Roboto', Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .header-table td {
        vertical-align: top;
        padding: 2mm;
    }

    .company-info {
        text-align: center;
        font-weight: 500;
    }

    .company-name {
        font-size: 16px;
        margin-bottom: 3mm;
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 700;
    }

    .invoice-details {
        text-align: right;
    }

    .customer-info {
        margin-bottom: 5mm;
    }

    .plist {
        margin: 3mm 0;
    }

    .plist th, .plist td {
        padding: 1.5mm;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .plist th {
        background-color: #f5f5f5;
        font-weight: 500;
    }

    .summary-table {
        margin-top: 5mm;
    }

    .summary-table td {
        padding: 1mm;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .amount-column {
        text-align: right;
    }

    .footer {
        margin-top: 10mm;
        text-align: center;
        font-size: 9px;
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 300;
    }

    .authorized-sign {
        text-align: right;
        margin-top: 10mm;
        font-family: 'Roboto', Arial, sans-serif;
    }

    .mfill {
        background-color: #f9f9f9;
    }

    .daashan {
        font-size: 8px;
        font-family: 'Roboto', Arial, sans-serif;
        line-height: 1.2;
        font-weight: 400;
    }

    .daashanxxx {
        font-size: 10px;
        font-family: 'Roboto', Arial, sans-serif;
        line-height: 1.2;
        font-weight: 300;
    }

    .daashanabc {
        font-size: 12px;
        font-family: 'Roboto', Arial, sans-serif;
        line-height: 1.2;
        font-weight: 500;
    }

    .daashanabcxx {
        font-size: 9px;
        font-family: 'Roboto', Arial, sans-serif;
        line-height: 1.2;
        color: #999;
        font-weight: 300;
    }

    .top_logo {
        max-height: 55px;
        max-width: 90px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', Arial, sans-serif;
        }
        
        .invoice-box {
            width: 100%;
            padding: 0;
        }
    }
</style>
</head>
<body dir="<?= LTR ?>">
 
<table width="100%" border="0" >
  
 
 
  <tr>
    <th class="daashanabc" width="23%" align="left" valign="middle" scope="row">
    
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
          <br><h1><strong><?php $loc = location($invoice['loc']);
                    echo $loc['cname']; ?></strong></h1>    <br>
         
      
        
        
        <strong> <?php $loc = location($invoice['loc']);?></strong> 
                <?php echo
                    $loc['address'] . ',' . $loc['city'] . ', ' . $loc['region'] . ',' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . ', ' . $this->lang->line('Email') . ': ' . $loc['email'];
                if ($loc['taxid']) ?><br>
                
                
                
                
                
                

   
    
    
    
    
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
       






    <br>

                   <table width="92%" style="width:92%;" cellpadding="0" cellspacing="0">
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
            <td width="15%" align="left">
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
            $sub_t += $row['subtotal'] ;
            $totl_qty = $row['product_des'] * $row['qty'];
            
            
            
            
                                                $sqft_total = $row['pwith']/12*$row['product_des'];
                                                $feet_rate = $row['price'];
                                                
                                                
                                                $quick_rate = $row['price'];
                                                $sqft_rate = $row['price'];
                                                
                                                $sqft_rate2 = $row['price'] / $sqft_total;
                                             // $sqft_rate2 = $row['price'] / $sqft_total;
            
            
                                           
             
            
            
            
            
            
            
            
            
            
            
                                            $sub_qty = $row['product_des'] * $row['qty'];
                                            $sub_qty2 = $row['pwith']/12*$row['product_des'] * $row['qty'];
                                            $unit=$row['unit'];
            
        
                $price_second = $this->input->get('is', TRUE);
                
                 if ($row['unit'] == "Qbic") {
                     
                   $row_qty_full_feet = $row['pquick'];
                 }else{
                   $row_qty_full_feet = $row['qty'] * $row['product_des'];   
                     
                 }
                 
                 $row_qty_tt = $row['qty'];
                 if ($price_second == "") {


                            $row_qty = $row_qty_full_feet;
                            $row_qty_t = $row['qty'];
                            $row_subtotal = $row['subtotal'];


                    }else{


                           if ($invoice['tax'] > 0) {

                                  $row_qty = $row_qty_full_feet;
                                  $row_qty_t = $row['qty'];
                                  $row_subtotal = $row['subtotal'];

                            }else{

                                  $row_qty = $row_qty_full_feet/100*$price_second;
                                  $row_qty_t = $row_qty_tt/100*$price_second;
                                  $row_subtotal = $row['subtotal'] /100*$price_second;
                            }  

                          
                    } 

                   
                                            
                                            
                                            
                                            
                                            

            echo '<tr class="daashan' . $flag . '">  <td>' . $n . '</td>
                  <td>' . $row['product'] .' (s/q)~'. round($sqft_total, 2) .')</td>
							

<td style="width:6%;" >' . round($row_qty_t,1) .'</td>

<td style="width:6%;" >' . +$row_qty .'</td>
 
 


 
<td style="width:16%;">';
							
							
						//  ~( Rs:'. round($sqft_rate2, 2) .'   if ($price_second == "") {

                          // if ($invoice['tax'] > 0) { }
                          //

                 //   }else{


                     //    if ($invoice['tax'] > 0) { }  

                          
                 //   } 			 
                  
        
        if ($invoice['tax'] > 0) {
							     
							      $feet_rate_tex = ($feet_rate);
							      $sqft_rate_tex = ($feet_rate);
							     
							     if ( $unit === 'Feet' ) :
							                 
							                 
                                                  echo   amountExchange($feet_rate_tex, $invoice['multi'], $invoice['loc']) ;
                                               else :
         
                                                   echo amountExchange($sqft_rate_tex, $invoice['multi'], $invoice['loc']) ;
                                               endif;
							     
							 }
							 else
							 {
							     
							   
							  if ( $unit === 'Feet' ) :
							                 
							                 
                                                  echo   amountExchange($feet_rate, $invoice['multi'], $invoice['loc']) ;                                                
                                               
											   
							elseif ( $unit === 'Sqft' ) :
							                 
							                 
                                                  echo   amountExchange($sqft_rate, $invoice['multi'], $invoice['loc']) ;
                             
                             elseif ( $unit === 'Qbic' ) :
							                 
							                 
                                                  echo   amountExchange($quick_rate, $invoice['multi'], $invoice['loc']) ;
                             
												  
							elseif ( $unit === '' ) :

							                     echo   amountExchange($row['price'], $invoice['multi'], $invoice['loc']) ;
												 
												 
                                               endif;
          
							 
							
							 }
							 
							 
							echo '</td>';
							echo '</td>';
           // if ($invoice['tax'] > 0) {
            //    $cols++;
            //    echo '<td style="width:20%;">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . '</span></td>';
           // }
            if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="width:15%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
            }
            
            
            
            //if ($invoice['tax'] > 0) {
							     
							     
							      //$subtotal_tex = ($row_subtotal - $row['totaltax'] );
							      
							      // echo '<td align="right">' . amountExchange($subtotal_tex, $invoice['multi'], $invoice['loc']) . '</td></tr>';
							      
                                 //  }else{
							     
							     
							     echo '<td align="left">' . amountExchange($row_subtotal, $invoice['multi'], $invoice['loc']) . '</td></tr>';
							     
						          //  	 }            
            
            
            

         
            if (CUSTOM) {
                $p_custom_fields = $this->custom->view_fields_data($row['pid'], 4, 1);

                if (is_array($p_custom_fields[0])) {
                    $z_custom_fields = '';

                    foreach ($p_custom_fields as $row) {
                        $z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
                    }

                    echo '<tr class="item' . $flag . ' descr">  <td> </td>
                            <td colspan="' . $cc . '">' . $z_custom_fields . ' </td>
							
                        </tr>';
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
        Total :<br>
                      
                      
                      
                      <?php if (!$general['t_type']) {
                        
                        
                        
                        
                        
                        
                           foreach ($activity as $row) {
                          
                           if($row['type'] == 'Income'){
                               
                               if($row['method'] == 'Balance'){
                               
                                    
                 echo 'Advance : <br>';
                               
                                      }
                                     }
                               }
                        
                        
                        
                        
                       

        
                    }?>
                      Paid   : <br>
                      
                      
                      
                      
                      
                      
                        Balance Due:
                         
                 
               </td>
    <td align="left" valign="top"><?php 
                        
                        
                        
                        
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
					   
                        echo '' . amountExchange($invoice_total, $invoice['multi'], $invoice['loc']) . '<br>';
 
                        
                        
                           foreach ($activity as $row) {
                          
                           if($row['type'] == 'Income'){
                               
                               if($row['method'] == 'Balance'){
                               
                                    
                        echo '' . amountExchange($row_credit, $invoice['multi'], $invoice['loc']) . '';
                               
                                      }
                                     }
                               }
                        
                        
                        

                        
                        if (@$round_off['other']) {
                            $final_amount = round($invoice_total, $round_off['active'], constant($round_off['other']));
                            echo '<p>' . $this->lang->line('Round Off') . ' ' . $this->lang->line('Amount') . ': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br><p>';
                        }

                        echo '' . amountExchange($invoice_pamnt, $invoice['multi'], $invoice['loc']) . '<br>';
						
						
						$rming = $invoice_total - $invoice_pamnt;
    if ($rming < 0) {
        $rming = 0;
    }
    if (@$round_off['other']) {
        $rming = round($rming, $round_off['active'], constant($round_off['other']));
    }
						
						
						echo '' . amountExchange($rming, $invoice['multi'], $invoice['loc']);
						
						
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
              $invoice_ssc_imported_local      =   $invoice_ssc_imported + $invoice_ssc_local;     
                           
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
							      
							       echo '<td align="left">' . amountExchange($sub_t_tex, $invoice['multi'], $invoice['loc']) . '</td>';
							      
                                   }else{
							      
							             if ($price_second > 0) {
                                         
                                                                //$price_second_tax = $totalinvoicevalue + ($sub_t_aaa - $invoice['tax'] );   
                                         
                                                                
                                                                //$invoice_tax_edit = $sub_t_aaa/118*100;
                                                                $sub_t_tex = $sub_t_aaa / 118*100;
                                                               
                                                                $invoice_tax   =   $invoice_total - $total_invoice_value_price_second ;
                                         
                                                               
                                                               echo '<td align="left">' . amountExchange($sub_t_tex, $invoice['multi'], $invoice['loc']) . '</td>';
							                  
                                                               }else{
                                         
                                                               echo '<td align="left">' . amountExchange($sub_t_aaa, $invoice['multi'], $invoice['loc']) . '</td>';
                                         
                                                                }
                    
                    
                                    
							     
						            	 }            
            ?>
    
          
    
    
    
    
                </tr>
            
            <tr><td>
            
        
             
             
             <?php  if ($invoice['discount'] > 0) {
            echo $this->lang->line('Total Discount') . '<br>';
             } ?>             
             
             
             <?php  if ($invoice['shipping'] > 0) {
            echo 'Transport <br>';
             } ?>
             
             <?php  if ($invoice['planing'] > 0) {
            echo 'Planing <br>';
             } ?>
             
             
             <?php  if ($invoice['cuttingsawing'] > 0) {
            echo 'Cutting / Sawing <br>';
             } ?>
             
             <?php  if ($invoice['loadingunloading'] > 0) {
            echo 'Loading / Unloading <br>';
             } ?>
          
             
             

             <?php  if ($invoice['tax'] > 0) {
            echo 'Total Invoice Value <br>';
            echo 'V.A.T 18% <br>';
             echo 'S.S.C 2.5% <br>';
            // echo 'Local S.S.C 2.5% <br>';
             } ?>          

            

              <?php   if ($price_second > 0) {
                          if ($invoice['tax'] > 0) {
                         //
                   }else{
             echo  'Total Invoice Value <br>';
             echo  'V.A.T 18% <br>';
             echo 'S.S.C 2.5% <br>';
             //echo 'Local S.S.C 2.5% <br>';
                }    
         } ?>   
              
              
              
              
               
               
            <td align="left">
             
             
             
             
             
             
             
           
             
               <?php  if ($invoice['discount'] > 0) {
             echo  amountExchange($invoice_discount, $invoice['multi'], $invoice['loc']) . '<br>';
             } ?> 
             
               <?php  if ($invoice['shipping'] > 0) {
             echo  amountExchange($invoice_shipping, $invoice['multi'], $invoice['loc']) . '<br>';
             } ?>              
             
               <?php  if ($invoice['planing'] > 0) {
             echo  amountExchange($invoice_planing, $invoice['multi'], $invoice['loc']) . '<br>';
             } ?>                     
            
               <?php  if ($invoice['cuttingsawing'] > 0) {
             echo  amountExchange($invoice_cuttingsawing, $invoice['multi'], $invoice['loc']) . '<br>';
             } ?> 
               
               <?php  if ($invoice['loadingunloading'] > 0) {
             echo  amountExchange($invoice_loadingunloading, $invoice['multi'], $invoice['loc']) . '<br>';
             } ?>                

               
            
               
               <?php  if ($invoice['tax'] > 0) {
             echo  amountExchange($total_invoice_value, $invoice['multi'], $invoice['loc']) . '<br>';
             echo  amountExchange($invoice_tax_aaa, $invoice['multi'], $invoice['loc']) . '<br>'; 
             echo  amountExchange($invoice['imported'] + $invoice['local'], $invoice['multi'], $invoice['loc']) . '<br>';
             //echo  amountExchange($invoice['local'], $invoice['multi'], $invoice['loc']) . '<br>';
             } ?> 
                                  
                                  
               <?php   if ($price_second > 0) {
                          if ($invoice['tax'] > 0) {
                         //
                   }else{
             echo  amountExchange($total_invoice_value_price_second, $invoice['multi'], $invoice['loc']) . '<br>';
             echo  amountExchange($invoice_tax, $invoice['multi'], $invoice['loc']) . '<br>';  
             echo  amountExchange($invoice_ssc_imported_local, $invoice['multi'], $invoice['loc']) . '<br>';
             //echo  amountExchange($invoice_ssc_local, $invoice['multi'], $invoice['loc']) . '<br>';             
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