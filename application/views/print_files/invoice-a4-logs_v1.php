<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
<title>Print Invoice #<?php echo $invoice['tid']; ?></title>
<style>
    body {
        font-family: 'Roboto', Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #000;
        font-size: 12px;
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
        font-size: 10px;
        font-family: 'Roboto', Arial, sans-serif;
        line-height: 1.2;
        font-weight: 400;
    }

 .dashan_s {
    font-size: 10px;
    font-family: 'Roboto', Arial, sans-serif;
    line-height: 1.2;
    font-weight: bold; /* Using the bold keyword */
}

    .daashanxxx {
        font-size: 10px;
        font-family: 'Roboto', Arial, sans-serif;
        line-height: 1.2;
        font-weight: 300;
    }

    .daashanabc {
        font-size: 14px;
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
                 

                  
                     <table width="95%" style="width:95%;" cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td width="3%" style="width:3%;">
                #
            </td>
            <td width="30%" style="width:30%;">
                <?php echo $this->lang->line('Description') ?>
            </td>
            <td width="5%" style="width:5%;">
               Pcs
            </td>
            
               
            <td width="7%" style="width:7%;">
            <?php echo $this->lang->line('Qty') ?>
            </td> 
             <td width="8%" style="width:8%;">
            Round
            </td>
             <td width="8%" style="width:8%;">
            Length
            </td>
             <td width="10%" style="width:10%;">
            Quick (Cubic)
            </td> 
            <td width="12%" style="width:12%;">
            <?php echo $this->lang->line('Price') ?>
            </td>
            <?php 
           // if ($invoice['tax'] > 0) echo '<td>' . $this->lang->line('Tax') . '</td>';
             if ($invoice['discount'] > 0) echo '<td>' . $this->lang->line('Discount') . '</td>'; 
            ?>
            <td width="17%" align="left" style="width:17%;">
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
            
            echo '<tr class="dashan' . $flag . '">  <td>' . $n . '</td>
                  <td>' . $row['product'] .'</td>
                  <td>' . round($row['qty'],1) .'</td>
                  <td>' . amountFormat_s($row['qty']) . ' <small>' . $row['unit'] .'</small></td>
                  <td>' . amountFormat_s($row['pwith']) . '</td>
                  <td>' . amountFormat_s($row['pthickness']) . '</td>
                  <td>' . amountFormat_s($row['pquick']) . '</td>
                  <td>'. amountExchange($row['price'], $invoice['multi'], $invoice['loc']) .'</td>';
							
            if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="width:15%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
            }
            
             echo '<td align="right">' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td></tr>';
							     
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
                 echo 'Balance : <br>';
                 
                 
                   }else{
                       
                       
                   }
                  
                           }
                           
                             
             } 
             
             
                          
                      }
              ?>
      
    </td>
    <td align="right" valign="top">
         <?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']); ?><br>
        
                         <?php if (!$general['t_type']) {
                        
                           foreach ($activity as $row) {
                          
                           if($row['type'] == 'Income'){
                               
                               if($row['method'] == 'Balance'){
                               
                  echo amountExchange($row['credit'], $invoice['multi'], $invoice['loc']);  
                  echo '<br>';
                   echo amountExchange($row['debit'], $invoice['multi'], $invoice['loc']); 
                   
                   }else{
                       
                       
                   }
                  
                           }
                           
                             
             } 
             
             
                          
                      }
              ?>
        
    </td>
    <td> </td>
  </tr>
</table>

            
            
            
            
           
            </td>
            
            
            
            
       
            <td class="annot">  Qubic Feet: </td> <td class="annot"> <?php echo $invoice['pquick'] ?> </td>
        </tr> 
      
        <?php 
       
       
        if ($invoice['shipping'] > 0) {
            echo '<tr> <td class="annot">' . $this->lang->line('Shipping') . '</td><td class="annot">' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</td></tr>';
        }

        if ($invoice['discount'] > 0) {
            echo '<tr> <td class="annot">' . $this->lang->line('Discount') . '</td><td class="annot">' . amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) . '</td></tr>';
        }

        if ($invoice['tax'] > 0) {
            echo '<tr> <td class="annot">' . $this->lang->line('Tax') . '</td><td class="annot">' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</td></tr>';
        }

     
        ?>
        
    </table>
    
    <br>
    
   <?php
        if ($invoice['notes']) echo '<div class="invoice-details"> ' . $this->lang->line('Note') . ': ' . $invoice['notes'] . '</div>';
    ?>
    <div class="footer">
        <table>
            <tr>
            <td class="daashan" width="40%">
            Items Received in Good Condition.<br><br><br>
            .....................................<br>
       (Received by)
            
            </td>
            
            <td class="daashan" style="text-align:right" width="60%">
            
             For <span class="dashan_s"> <?php $loc = location($invoice['loc']);
                    echo $loc['cname']; ?></span> <br><br><br>
            .....................................<br>
         (Authorized Signature)
            
            </td>
            
            </tr>
        </table>
        
        
     
    </div>

</div>
</body>
</html>
