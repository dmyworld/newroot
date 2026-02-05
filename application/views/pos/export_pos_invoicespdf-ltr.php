<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Statement</title>

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

<body>
<div class="invoice-box">
   
    <table>
       
        <tbody>
            
        <tr>
            
        
            
            <td><h3><strong><?php $loc = location($invoice['loc']);
                    echo $loc['cname']; ?></strong></h3>

         <?php echo $loc['address'] . ',' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . ', ' . $this->lang->line('Email') . ': ' . $loc['email'];
                 ?>
    
    </td>

<?php 
$trackDate = ''; // Initialize variable
$firstRow = reset($report); // Get first row
if ($firstRow) {
    $trackDate = date('Y-F', strtotime($firstRow['invoicedate']));
}
?>

<td width="35%">
    <strong>TAX Monthly Summary</strong><br><br>
    <strong>Period: </strong><?php echo $trackDate; ?><br><br>
    <strong>V.A.T NO : </strong><?php if ($loc['taxid']) echo $this->lang->line('TaxID') . $loc['taxid']; ?>
</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <table class="plist" cellpadding="0" cellspacing="0">
       


            <tr>
                
                <td align="center"><strong>Date</strong></td>
                <td align="center"><strong>Customer Name</strong></td>
                <td align="center"><strong>Bill no</strong></td>

                <td align="center"><strong>Goods Value</strong></td>
                <td align="center"><strong>V.A.T 18%</strong></td>

                <th align="center"><strong>Imported S.S.C.L 2.5%</strong></th>
                <th align="center"><strong>Local S.S.C.L 2.5%</strong></th>
                <th align="center"><strong>Total S.S.C.L 2.5%</strong></th>
                <td align="center"><strong>Amount Without Tax</strong></td>

            </tr>

            <?php
            $fill = false;
            $price = 0;





            foreach ($report as $row) {
            
            $invoice_csd_id     =      $row['csd'];
            
         $this->db->select('name,taxid');
         $this->db->from('geopos_customers');
         $this->db->where('id', $invoice_csd_id);
         $query = $this->db->get();
         $roww = $query->row();   
            
        $customerName = $roww->name;
            
          
         //  if ($roww->taxid == "") {
         //  $customertaxid = 'TAX ID:' . $roww->taxid  ;
        //   } else{
            $customertaxid = 'TAX ID:' . $roww->taxid  ;
        //   }

            
            
            $invoicetax     =      $row['tax'];
                  if ($invoicetax > 0) {                  
                         $percentage = 100;    
                        }else{
                         $percentage = $price_second;
                        }
              
                    $invoice_tota_oklk     =      $row['total'];
                 
                    $invoice_tota_oklk_2 = ($percentage / 100) * $invoice_tota_oklk;
                    
                   // $total_due     =      $row['total'] - $row['pamnt'];
                   // $total_due_oklk_2 = ($percentage / 100) * $total_due;                                       
                   // $invoices_pamnt     =      $row['pamnt'];
                    $invoice_pamnt_oklk_2 = ($percentage / 100) * $invoices_pamnt;              
                                  
                    $invoices_tax = ($invoice_tota_oklk_2 /118*100);
                    
                    
                    $invoices_taxssc_imported = ($percentage / 100) * $row['imported'];
                    $invoices_taxssc_local = ($percentage / 100) * $row['local'];
                    
                    $invoices_without_tax  = ($invoice_tota_oklk_2 - $invoices_tax);  
                    
                     
              $invoices_ssc = $invoices_taxssc_local + $invoices_taxssc_imported;
              //$invoices_ssc = ($invoices_tax /100*2.5);
            
            
            
            
                $balance_total += $invoice_tota_oklk_2;
                $balance_total_tax += $invoices_without_tax;
                $balance_ssc += $invoices_ssc;
                $balance_ssc_imported += $invoices_taxssc_imported;
                $balance_ssc_local += $invoices_taxssc_local;
                $balance_without_tax += $invoices_tax;
                if ($fill == true) {
                    $flag = ' mfill';
                } else {
                    $flag = '';
                }

                echo '<tr class="item' . $flag . '"><td>' . $row['invoicedate'] . '</td><td>' . $customerName .'<br>'. $customertaxid. '</td><td>' . $row['tid'] . '</td><td align="right">' . amountFormat_general($invoice_tota_oklk_2) . '</td><td align="right">' . amountFormat_general($invoices_without_tax, 0, $this->aauth->get_user()->loc) . '</td><td align="right">' . amountFormat_general($invoices_taxssc_imported) . '</td><td align="right">' . amountFormat_general($invoices_taxssc_local) . '</td><td align="right">' . amountFormat_general($invoices_ssc) . '</td><td align="right">' . amountFormat_general($invoices_tax) . '</td></tr>';
                $fill = !$fill;
            }
       
        ?> </table>
<table class="subtotal" align="right">
    <thead>
    <tbody>
    <tr align="right">
        <td class="myco2" rowspan="8" align="right"><br><br><br>
        </td>
        <td align="right"><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
        <td align="right"></td>
    </tr>
<tr align="right">
    <td align="right"></td>
    <td align="right"></td>
</tr> <br>

    <tr align="right">
        <td align="right">GOODS VALUE TOTAL :</td>
        <td align="right"><?php echo amountExchange($balance_total); ?></td>
    </tr>
    
    <tr align="right">
        <td align="right">TOTAL V. A. T 18% :</td>
        <td align="right"><?php echo amountExchange($balance_total_tax); ?></td>
    </tr>
    
    <tr align="right">
        <td align="right">Imported TOTAL S. S. C. L 2.5% :</td>
        <td align="right"><?php echo amountExchange($balance_ssc_imported); ?></td>
    </tr>
    
    <tr align="right">
        <td align="right">Local TOTAL S. S. C. L 2.5% :</td>
        <td align="right"><?php echo amountExchange($balance_ssc_local); ?></td>
    </tr>

        <tr align="right">
        <td align="right">TOTAL S. S. C. L 2.5% :</td>
        <td align="right"><?php echo amountExchange($balance_ssc); ?></td>
    </tr>
    
    <tr align="right">
        <td align="right">TOTAL AMOUNT WITHOUT TAX :</td>
        <td align="right"><?php echo amountExchange($balance_without_tax); ?></td>
    </tr>
    </tbody>
</table>
    <br><br>
    <div align="right">Authorized person</div>
  
    <br>
    
</div>
</body>
</html>
