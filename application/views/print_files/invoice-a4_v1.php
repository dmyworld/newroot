<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
<title>Print Invoice #<?php echo $invoice['tid']; ?></title>
<style>

    
    /* Header text classes */
    .daashanabc {
        
        font-size: 12px;
        font-weight: var(--fw-normal);
        color: var(--text-dark);
        line-height: 1.6;
    }
    
    .dashan_s {
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: var(--fw-semibold);
        color: var(--text-dark);
    }
    

    
    /* ====== DASHAN CLASS STYLES (Legacy Support) ====== */
    .daashan {
        
        font-size: var(--text-sm);
        font-weight: var(--fw-normal);
        line-height: 1.6;
        color: var(--text-medium);
    }
    
    .daashanxxx {
        
        font-size: var(--text-sm);
        font-weight: var(--fw-light);
        color: var(--text-light);
    }
    
    .daashanabcxx {
       
        font-size: var(--text-xs);
        font-weight: var(--fw-light);
        color: var(--text-muted);
    }
    

</style>

</head>
<body dir="<?= LTR ?>">
 
<table width="100%" border="0" >
  
 
 
  <tr>
    <th class="daashanabc" width="18%" align="left" valign="middle" scope="row">
    
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
    
    
    
     <th class="daashanabc"  width="20%" align="left"  valign="middle" scope="row">
        
                     Bill Number:
                     <?=  $invoice['tid'] ?> <br><br>
                     
                     Date:
                   <?php echo dateformat($invoice['invoicedate']) ?><br><br>
                    
                 
      
    
                     
     <?php 
                     
         $price_second_tex = $this->input->get('is', TRUE);                
                     
                     
  if ($price_second_tex == "") {

                                                          if ($invoice['tax'] > 0) {

                                   echo 'TAX INVOICE';
                                   echo '<br>Our Vat ID:662941794-7000';

                                                   }
                            //

                    }else{


                        

                                   echo 'TAX INVOICE';
                                   echo '<br>Our Vat ID:662941794-7000';

                                                    

                          
                    }     ?>             
                     
                     
                
                <?php if ($invoice['refer']) { ?><br>
                    <?php echo $this->lang->line('Reference') ?>
                        <?php echo $invoice['refer'] ?>
                    
                <?php } ?> 
              
  </tr>
</table>




<div class="invoice-box">
       





    <br>
                 

                  
                     <table width="95%" style="width:95%;" cellpadding="3" cellspacing="0" align="center">
        <tr>
            <td width="3%" style="width:3%;">
                #
            </td>
            <td width="52%">
                <?php echo $this->lang->line('Description') ?>
            </td>
            <td width="5%">
               Pcs
            </td>
            
               
            <td width="16%">
            <?php echo $this->lang->line('Qty') ?>
            </td>           
            <td width="8%" align="left">
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
                <tr>
            
            <td align="center">
                 <br>
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
                
                 if ($row['unit'] == "Cubic") {
                     
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

                   
                                            
                                                                $sub_qty = $row['product_des'] * $row['qty'];
                                            $sub_qty2 = $row['pwith']/12*$row['product_des'] * $row['qty'];
                                            $unit=$row['unit'];                        
                                            
                                            
                                            

            echo '<tr class="dashan' . $flag . '">  <td>' . $n . '</td>
                  <td>' . $row['product'] .'</td>
							

<td style="width:6%;" >' . round($row_qty_t,1) .'</td>

<td style="width:6%;" >' . amountFormat_s(($unit === 'Feet' ? $sub_qty : ($unit === 'Cubic' ? $row['pquick'] : $sub_qty2))) . ' <small>' . $row['unit'] .'</small></td>
 
 


 
<td style="width:16%;" align="left">';
							
							
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
							                 
							                 
                                                  echo   amountExchange($row['rate'], $invoice['multi'], $invoice['loc']) ;                                                
                                               
											   
							elseif ( $unit === 'Sqft' ) :
							                 
							                 
                                                  echo   amountExchange($row['rate'], $invoice['multi'], $invoice['loc']) ;
                             
                             elseif ( $unit === 'Cubic' ) :
							                 
							                 
                                                  echo   amountExchange($row['price'], $invoice['multi'], $invoice['loc']) ;
                             
												  
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
							     
							     
							     echo '<td align="right">' . amountExchange($row_subtotal, $invoice['multi'], $invoice['loc']) . '</td></tr>';
							     
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
    <td width="28%" align="right"><p><?php echo '<strong>' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p>'; ?></td>
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
					   
                        echo '' . amountExchange($invoice_total, $invoice['multi'], $invoice['loc']) . '<br>';
 
                        
                        
                           foreach ($activity as $row) {
                          
                           if($row['type'] == 'Income'){
                               
                               if($row['method'] == 'Balance'){
                               
                                    
                        echo '' . amountExchange($row_credit, $invoice['multi'], $invoice['loc']) . '<br>';
                               
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
             echo 'S.S.C.L 2.5% <br>';
            // echo 'Local S.S.C 2.5% <br>';
             } ?>          

            

              <?php   if ($price_second > 0) {
                          if ($invoice['tax'] > 0) {
                         //
                   }else{
             echo  'Total Invoice Value <br>';
             echo  'V.A.T 18% <br>';
             echo 'S.S.C.L 2.5% <br>';
             //echo 'Local S.S.C 2.5% <br>';
                }    
         } ?>   
              
              
              
              
               
               
            <td align="right">
             
             
             
             
             
             
             
           
             
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
        
    <br><br><br><br>
        
    
    <table width="100%" border="0" >
  
  <tr>
    <th colspan="3" align="center" scope="row">  භාණ්ඩ රැගෙන ගොස් දින 14 පසු කරනු ලබන පැමිණිලි භාරගනු නොලැබේ.  </tr>
  <tr>
       <th class="dashan_s" width="33%" align="left" valign="top" scope="row">
    
              
              ....................... <br><br>  <?php echo $this->lang->line('Authorized person') ?>
              
              </th>
              
              
              
       
              
    <th class="dashan_s" width="33%" align="center" valign="top" scope="row">
        
     <?php    echo '<br> D My World <br>The Best Timber Business Management <br> Solution in Sri Lanka<br> 077 83 87 500 ' ; ?>        
      



</th>
 
 
 
                
    <th class="dashan_s" width="33%" align="right"  valign="top" scope="row">
        
                ....................... <br><br> <?php echo $this->lang->line('Authorized person') ?>
        </th>      
  </tr>
</table>
    
</div>
</body>
</html>  