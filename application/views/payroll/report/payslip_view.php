<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 13px; color: #333; }
        .payslip-container { width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header-table { width: 100%; border-bottom: 2px solid #444; margin-bottom: 20px; }
        .logo-cell { width: 150px; text-align: left; vertical-align: top; }
        .company-cell { text-align: center; vertical-align: top; }
        .company-name { font-size: 24px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .company-address { font-size: 12px; margin-top: 5px; }
        
        .section-title { font-weight: bold; background-color: #f4f4f4; padding: 5px; margin-top: 15px; border-bottom: 1px solid #ddd; }
        
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 140px; }

        .earnings-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .earnings-table th { background-color: #eee; border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 12px; }
        .earnings-table td { border: 1px solid #ccc; padding: 8px; font-size: 12px; }
        .text-right { text-align: right; }
        
        .net-pay-box { border: 2px solid #333; padding: 10px; text-align: right; background-color: #f9f9f9; margin-top: 20px; font-size: 16px; font-weight: bold; }

        .footer { margin-top: 40px; font-size: 11px; text-align: center; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="payslip-container">
        
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <?php 
                        $logo_path = FCPATH . 'userfiles/company/logo.png';
                        if(file_exists($logo_path)) {
                            echo '<img src="' . $logo_path . '" style="max-height: 60px;">';
                        }
                    ?>
                </td>
                <td class="company-cell">
                    <h1 class="company-name"><?php echo $this->config->item('ctitle'); ?></h1>
                    <div class="company-address">
                        <?php echo $this->config->item('address'); ?><br>
                        <?php echo $this->config->item('city') . ', ' . $this->config->item('country'); ?>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Employee & Period -->
        <div class="section-title">Payslip Details</div>
        <table class="info-table">
            <tr>
                <td class="label">Employee Name:</td>
                <td><?php echo $payslip['name']; ?></td>
                <td class="label">Pay Period:</td>
                <td><?php echo date('F Y', strtotime($payslip['start_date'])); ?> (<?php echo date('d/m', strtotime($payslip['start_date'])); ?> - <?php echo date('d/m', strtotime($payslip['end_date'])); ?>)</td>
            </tr>
            <tr>
                <td class="label">Employee ID:</td>
                <td><?php echo $payslip['employee_id']; ?></td>
                <td class="label">Printed On:</td>
                <td><?php echo date('Y-m-d H:i:s'); ?></td>
            </tr>
            <tr>
                <td class="label">Bank Account:</td>
                <td><?php echo (isset($payslip['bank_name']) && $payslip['bank_name']) ? $payslip['bank_name'] . ' - ' . $payslip['bank_ac'] : 'N/A'; ?></td>
                <td class="label"></td>
                <td></td>
            </tr>
        </table>

        <!-- Earnings & Deductions -->
        <table class="earnings-table">
            <thead>
                <tr>
                    <th width="50%">Earnings</th>
                    <th width="15%" class="text-right">Amount</th>
                    <th width="20%">Deductions</th>
                    <th width="15%" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                     <td style="vertical-align: top;">
                         <table width="100%" style="border:none;">
                            <tr>
                                <td style="border:none;"><strong>Basic / General</strong></td>
                                <td style="border:none;" class="text-right"></td>
                            </tr>
                             <tr>
                                <td style="border:none; padding-left: 10px;">Regular Hours: <?php echo isset($stats['regular_hours']) ? $stats['regular_hours'] : 0; ?></td>
                                <td style="border:none;" class="text-right"></td>
                            </tr>
                            <?php if(isset($stats['ot_hours']) && $stats['ot_hours'] > 0) { ?>
                            <tr>
                                <td style="border:none;"><strong>Overtime</strong></td>
                                <td style="border:none;" class="text-right"></td>
                            </tr>
                             <tr>
                                <td style="border:none; padding-left: 10px;">OT Hours: <?php echo $stats['ot_hours']; ?></td>
                                <td style="border:none;" class="text-right"></td>
                            </tr>
                            <?php } ?>
                            
                            <!-- Spacing -->
                            <tr><td style="border:none; height: 10px;"></td><td></td></tr>
                            
                            <?php if(isset($stats['jobs']) && count($stats['jobs']) > 0) { ?>
                            <tr>
                                <td style="border:none;" colspan="2"><strong>Job Code Summary</strong></td>
                            </tr>
                            <?php foreach($stats['jobs'] as $job) { ?>
                             <tr>
                                <td style="border:none; padding-left: 10px; font-size: 11px;">
                                    <?php echo $job['title']; ?> (<?php echo $job['hours']; ?> Hrs)
                                </td>
                                <td style="border:none;" class="text-right"></td>
                            </tr>
                            <?php } } ?>

                         </table>
                     </td>
                     <td></td> 
                     
                     <td style="vertical-align: top;">
                         <table width="100%" style="border:none;">
                            <tr>
                                <td style="border:none;">Basic Pay / Salary</td>
                                <td style="border:none;" class="text-right"><?php echo amountFormat($payslip['gross'] - $payslip['hours']*$payslip['hourly_rate']); ?></td> <!-- Approximate for now, or just show Total Gross? Payslip needs breakdown. -->
                            </tr>
                            <!-- Breakdown Logic: Model sends TOTAL Gross. Need to separate components if possible. 
                                 For now, we will list Bonuses as "Additions" and simplify Basic Logic.
                            -->
                            <?php 
                            $bonus_items = array();
                            $employer_contribs = array();
                            $deduction_items = array();
                            
                            if(isset($details) && is_array($details)) {
                                foreach($details as $d) {
                                    if(isset($d['type'])) {
                                        if($d['type'] == 'Bonus') {
                                            $bonus_items[] = $d;
                                            continue;
                                        } 
                                        if($d['type'] == 'Employer_Contribution') {
                                            $employer_contribs[] = $d;
                                            continue;
                                        }
                                    }
                                    $deduction_items[] = $d;
                                }
                            }
                            
                            foreach($bonus_items as $b) {
                                echo '<tr><td style="border:none; color:green;">' . $b['name'] . '</td><td style="border:none;" class="text-right">' . amountFormat($b['amount']) . '</td></tr>';
                            }
                            ?>
                             <tr>
                                <td style="border:none; border-top: 1px solid #eee;"><strong>Total Earnings</strong></td>
                                <td style="border:none; border-top: 1px solid #eee;" class="text-right"><strong><?php echo amountFormat($payslip['gross_pay']); ?></strong></td>
                            </tr>
                         </table>
                     </td>
                     <td style="vertical-align: top; border-left: 1px solid #ccc;" colspan="2">
                         <table width="100%" style="border:none;">
                            <?php 
                                foreach($deduction_items as $d) { 
                                    echo '<tr><td style="border:none;">' . $d['name'] . '</td><td style="border:none;" class="text-right">' . amountFormat($d['amount']) . '</td></tr>';
                                }
                            ?>
                             <tr>
                                <td style="border:none; border-top: 1px solid #eee;"><strong>Total Deductions</strong></td>
                                <td style="border:none; border-top: 1px solid #eee;" class="text-right"><strong><?php echo amountFormat($payslip['total_deductions']); ?></strong></td>
                            </tr>
                         </table>
                         
                         <?php if(!empty($employer_contribs)) { ?>
                         <div style="margin-top: 20px; border-top: 1px dashed #ccc; padding-top: 5px;">
                             <strong>Employer Contributions (EPF/ETF)</strong>
                             <table width="100%" style="border:none; font-size: 10px; color: #555;">
                                 <?php foreach($employer_contribs as $ec) { ?>
                                 <tr>
                                     <td style="border:none;"><?php echo $ec['name']; ?></td>
                                     <td style="border:none;" class="text-right"><?php echo amountFormat($ec['amount']); ?></td>
                                 </tr>
                                 <?php } ?>
                             </table>
                         </div>
                         <?php } ?>
                     </td>
                </tr>
                 <!-- Totals Row -->
                 <tr>
                     <td class="text-right"><strong>Gross Pay (Total)</strong></td>
                     <td class="text-right"><strong><?php echo amountFormat($payslip['gross_pay']); ?></strong></td>
                     <td colspan="2"></td>
                 </tr>
            </tbody>
        </table>

        <!-- Net Pay -->
        <div class="net-pay-box">
            Net Pay: <?php echo amountFormat($payslip['net_pay']); ?>
        </div>
        
        <div class="footer">
            <p>This is a system generated payslip.</p>
            <p><?php echo $this->config->item('ctitle'); ?> | <?php echo $this->config->item('address'); ?></p>
        </div>

    </div>
</body>
</html>
