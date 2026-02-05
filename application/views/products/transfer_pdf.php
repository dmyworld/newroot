<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stock Transfer Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #333; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 8px; border: 1px solid #ddd; }
        .info-table .label { font-weight: bold; background-color: #f5f5f5; width: 30%; }
        .products-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .products-table th, .products-table td { border: 1px solid #333; padding: 10px; text-align: left; }
        .products-table th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #333; font-size: 12px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Stock Transfer Report</h2>
    </div>
    
    <table class="info-table">
        <tr>
            <td class="label">Transfer Date:</td>
            <td><?php echo $transfer_date; ?></td>
        </tr>
        <tr>
            <td class="label">From Warehouse:</td>
            <td><?php echo $from_warehouse; ?></td>
        </tr>
        <tr>
            <td class="label">To Warehouse:</td>
            <td><?php echo $to_warehouse; ?></td>
        </tr>
        <tr>
            <td class="label">Generated On:</td>
            <td><?php echo $generated_date; ?></td>
        </tr>
    </table>
    
    <h3>Transfer Items</h3>
    <table class="products-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Product Code</th>
                <th>Transfer Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_items = 0;
            if(isset($products) && is_array($products)): 
                foreach($products as $index => $product): 
                    $total_items += $product['quantity'];
            ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                <td><strong><?php echo $product['quantity']; ?></strong></td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total Items:</strong></td>
                <td><strong><?php echo $total_items; ?></strong></td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>This is an auto-generated stock transfer report.</p>
    </div>
</body>
</html>