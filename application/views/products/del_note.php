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
            padding: 4mm;
            border: 0;
            font-size: 9pt; /* Header info slightly larger */
            line-height: 1.2;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 1.2;
            text-align: left;
            border-collapse: collapse;
        }

        /* Compact Product List */
        .plist tr td {
            font-size: 7pt; /* Small font for items */
            line-height: 9pt;
            padding: 2pt 4pt; /* Minimize padding */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .heading td {
            background: #515151;
            color: #FFF;
            padding: 4pt;
            text-align: center;
            font-weight: bold;
            font-size: 8pt;
        }

        .title-header h1 {
            margin: 0;
            padding: 0;
            font-size: 20pt;
            color: #333;
        }

        .address-block {
            font-size: 10pt;
            line-height: 1.4;
        }

        .sign-area {
            margin-top: 50px;
            display: table;
            width: 100%;
        }

        .sign-box {
            display: table-cell;
            width: 33%;
            text-align: center;
            vertical-align: bottom;
        }

        .sign-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 10px auto 0;
            padding-top: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body <?php if (LTR == 'rtl') echo 'dir="rtl"'; ?>>

<div class="invoice-box">

    <!-- Header Section -->
    <table width="100%" border="0" style="margin-bottom: 20px;">
        <tr>
            <!-- Left: Supplier Details (From) -->
            <td width="35%" valign="top">
                <strong>FROM (Supplier):</strong><br>
                <div class="address-block">
                    <?php 
                        echo '<strong>' . $invoice['name'] . '</strong><br>';
                        if ($invoice['company']) echo $invoice['company'] . '<br>';
                        echo $invoice['address'] . '<br>' . $invoice['city'] . '<br>';
                        echo $this->lang->line('Phone') . ': ' . $invoice['phone'] . '<br>';
                        echo $this->lang->line('Email') . ': ' . $invoice['email'];
                        if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                    ?>
                </div>
            </td>

            <!-- Center: Our Company Details (To) -->
            <td width="30%" valign="top" align="center">
                <?php $loc = location($invoice['loc']); ?>
                <strong>TO (Warehouse/Location):</strong><br>
                <div class="address-block">
                    <strong><?php echo $loc['cname']; ?></strong><br>
                    <?php 
                        echo $loc['address'] . '<br>' . $loc['city'] . '<br>';
                        echo $this->lang->line('Phone') . ': ' . $loc['phone'];
                    ?>
                </div>
            </td>

            <!-- Right: Document Info -->
            <td width="35%" valign="top" align="right">
                <div class="title-header">
                    <h1><?php echo $this->lang->line('Delivery Note') ?></h1>
                </div>
                <table style="width: 100%; margin-top: 10px; text-align: right;">
                    <tr>
                        <td><strong>DO Number:</strong></td>
                        <td>#<?php echo $invoice['tid'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td><?php echo dateformat(date('Y-m-d')) ?></td>
                    </tr>
                    <?php if ($invoice['refer']) { ?>
                    <tr>
                        <td><strong>Ref:</strong></td>
                        <td><?php echo $invoice['refer'] ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>

    <!-- Product List -->
    <table class="plist" cellpadding="0" cellspacing="0" width="100%">
        <tr class="heading">
            <td width="10%" style="text-align: center;">#</td>
            <td width="60%" style="text-align: left;"><?php echo $this->lang->line('Description') ?></td>
            <td width="30%" style="text-align: center;">QUANTITY (PCS)</td>
        </tr>

        <?php
        $n = 1;
        foreach ($products as $row) {
            echo '<tr>
                <td style="text-align: center;">' . $n . '</td>
                <td style="text-align: left;">
                    <strong>' . $row['product'] . '</strong>';
       
            echo '</td>
                <td style="text-align: center; font-weight: bold;">' . number_format($row['qty'], 2) . '</td>
            </tr>';
            $n++;
        }
        ?>
    </table>

    <!-- Signature Section -->
    <div class="sign-area">
        <div class="sign-box">
            <?php if(isset($employee['sign'])) { ?>
                <img src="<?php echo base_url('userfiles/employee_sign/' . $employee['sign']); ?>" width="100" height="35" alt="Sign">
                <div class="sign-line"><?php echo $this->lang->line('Authorized person') ?></div>
                <div>(<?php echo $employee['name']; ?>)</div>
            <?php } else { ?>
                 <br><br><br>
                 <div class="sign-line"><?php echo $this->lang->line('Authorized person') ?></div>
            <?php } ?>
        </div>
        
        <div class="sign-box"></div> <!-- Spacer -->

        <div class="sign-box">
             <br><br><br>
            <div class="sign-line"><?php echo $this->lang->line('Received by') ?></div>
            <div>(Signature & Date)</div>
        </div>
    </div>

</div>

</body>
</html>