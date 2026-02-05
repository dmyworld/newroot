<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transfer Summary #<?php echo $transfer['tid']; ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .company-name { font-size: 20px; font-weight: bold; }
        .document-title { font-size: 16px; margin: 10px 0; }
        .transfer-info { width: 100%; margin-bottom: 20px; }
        .transfer-info td { padding: 5px; vertical-align: top; }
        .products-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .products-table th, .products-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .products-table th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 30px; border-top: 1px solid #333; padding-top: 10px; }
        .signature-area { margin-top: 50px; }
        .signature-line { border-top: 1px solid #000; width: 200px; margin-top: 40px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Your Company Name</div>
        <div class="document-title">STOCK TRANSFER SUMMARY</div>
    </div>

    <table class="transfer-info">
        <tr>
            <td width="50%">
                <strong>Transfer ID:</strong> #<?php echo $transfer['tid']; ?><br>
                <strong>Transfer Date:</strong> <?php echo date('F j, Y', strtotime($transfer['invoicedate'])); ?><br>
                <strong>Status:</strong> <?php echo ucfirst($transfer['status']); ?>
            </td>
            <td width="50%">
                <strong>From Warehouse:</strong> <?php echo $from_warehouse_name; ?><br>
                <strong>To Warehouse:</strong> <?php echo $to_warehouse_name; ?><br>
                <strong>Total Items:</strong> <?php echo $transfer['items']; ?>
            </td>
        </tr>
    </table>

    <?php if (!empty($transfer['notes'])): ?>
    <div style="margin-bottom: 20px;">
        <strong>Notes:</strong> <?php echo $transfer['notes']; ?>
    </div>
    <?php endif; ?>

    <table class="products-table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="45%">Product Name</th>
                <th width="15%">Product Code</th>
                <th width="15%">Quantity</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $index => $product): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                    <td><?php echo number_format($product['qty'], 2); ?></td>
                    <td>Transferred</td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No products found for this transfer</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <table width="100%">
            <tr>
                <td width="50%">
                    <strong>Prepared By:</strong><br>
                    <?php if (isset($employee)): ?>
                        <?php echo htmlspecialchars($employee['name']); ?><br>
                        <?php echo htmlspecialchars($employee['email']); ?>
                    <?php else: ?>
                        System Administrator
                    <?php endif; ?>
                </td>
                <td width="50%" class="text-right">
                    <strong>Transfer Total:</strong><br>
                    <?php echo $transfer['items']; ?> Items<br>
                    Generated on: <?php echo date('F j, Y g:i A'); ?>
                </td>
            </tr>
        </table>
        
        <div class="signature-area">
            <table width="100%">
                <tr>
                    <td width="33%">
                        <div class="signature-line"></div>
                        <div>Source Warehouse Manager</div>
                    </td>
                    <td width="33%" class="text-center">
                        <div class="signature-line"></div>
                        <div>Transfer Coordinator</div>
                    </td>
                    <td width="33%" class="text-right">
                        <div class="signature-line"></div>
                        <div>Destination Warehouse Manager</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>