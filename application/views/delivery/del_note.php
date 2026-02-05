<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print DO #<?php echo $invoice['tid'] ?></title>
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
            padding: 12pt;
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
    <th colspan="3" align="center" scope="row"><h1><strong>හපුආරච්චි ලී මෝල ලී වෙළඳසැල</strong></h1></th>
  </tr>

  <tr>
    <th class="daashan" width="33%" align="left" valign="top" scope="row">
    
    
    
    <h2>From:</h2> <?php echo $invoice['from_warehouse'];?><br><br>
    
   
    <h2>To:</h2>  <?php echo $invoice['to_warehouse'] ;?>
    
    
    
        
        
        </th>
    <th class="daashanabc" width="33%" align="center" valign="top" scope="row">
        
        
        <strong> <?php $loc = location($invoice['loc']);?></strong> 
                <?php echo
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
                if ($loc['taxid']) ?><br>F/D Reg NO: TD/3066/A
                
                
                
                
                
                </th>
                
    <th class="daashan" width="33%" align="right"  valign="top" scope="row">
        
        
        
         <h2><?php echo $this->lang->line('Delivery Note') ?></h2>
                            <br><br>
                    

                         <?php echo $this->lang->line('Delivery Order') ?>: 
                        DO#<?php echo $invoice['tid'] ?> <br>
                    
                        <?php echo $this->lang->line('Invoice') ?> 
                         <?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] ?> <br>
                    
                         DO Date 
                        <?php echo dateformat(date('Y-m-d')) ?> <br>
                    

                  
              
                
                
              
  </tr>
</table>


    

    
    
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td width="1rem;">#</td>
            <td>
                <?php echo $this->lang->line('Description') ?>
            </td>


            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>


        </tr>

        <?php
        $fill = true;
        $sub_t = 0;
        $n = 1;
        foreach ($products as $row) {

            $cols = 1;

            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $sub_t += $row['price'] * $row['qty'];


            echo '<tr class="item' . $flag . '"> <td>' . $n . '</td> 
                            <td>' . $row['product'] . '</td>
							
                            <td style="width:15%;" >' .  $row['qty']  . '</td></tr>   ';


            if ($row['product_des']) {
                $cc = $cols + 1;
                echo '<tr class="item' . $flag . ' descr"> 
                          
							
                        </tr>';
            }
            $fill = !$fill;
            $n++;
        }

        if ($invoice['shipping'] > 0) {
            $cols++;
        }

        ?>


    </table>
    <br>
    <?php


    echo '<br><div class="sign">' . $this->lang->line('Authorized person') . '</div><div class="sign1"><img src="' . base_url('userfiles/employee_sign/' . $employee['sign']) . '" width="100" height="35" border="0" alt=""></div><div class="sign2">(' . $employee['name'] . ')</div><div class="signr">_____________________________<br>' . $this->lang->line('Received by') . ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div> ';

    
    ?></div>
</div>
</body>
</html>