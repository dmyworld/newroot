<?php
// Standalone debugger for Strategic Indicators
// Bypasses CI Auth and Controller logic

// 1. Get DB Credentials
define('BASEPATH', 'system/'); // Fake BASEPATH to load config if needed, or just parse it
$db_config_file = 'application/config/database.php';

if (!file_exists($db_config_file)) {
    die("Database config not found.");
}

include($db_config_file);
$host = $db['default']['hostname'];
$user = $db['default']['username'];
$pass = $db['default']['password'];
$dbname = $db['default']['database'];

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>Strategic Indicators Debugger</h1>";

// 2. Define Date Range (Current Month)
$start_date = date('Y-m-01');
$end_date = date('Y-m-d');
echo "<p>Date Range: <strong>$start_date</strong> to <strong>$end_date</strong></p>";

// 3. Check Sales (geopos_invoices)
$sql_sales = "SELECT SUM(total) as total_sales, COUNT(id) as invoice_count FROM geopos_invoices 
              WHERE DATE(invoicedate) BETWEEN '$start_date' AND '$end_date'";
$res_sales = $conn->query($sql_sales);
$row_sales = $res_sales->fetch_assoc();
$total_sales = $row_sales['total_sales'] ?? 0;
$invoice_count = $row_sales['invoice_count'] ?? 0;

echo "<h2>1. Sales & Invoices</h2>";
echo "Total Sales: " . number_format($total_sales, 2) . "<br>";
echo "Invoice Count: " . $invoice_count . "<br>";

// 4. Check Profit (geopos_metadata)
// type 9 is typically used for profit metadata
$sql_profit = "SELECT SUM(geopos_metadata.col1) as total_profit 
               FROM geopos_metadata 
               LEFT JOIN geopos_invoices ON geopos_metadata.rid=geopos_invoices.id
               WHERE DATE(geopos_metadata.d_date) BETWEEN '$start_date' AND '$end_date'
               AND geopos_metadata.type = 9";

$res_profit = $conn->query($sql_profit);
$row_profit = $res_profit->fetch_assoc();
$total_profit = $row_profit['total_profit'] ?? 0;

echo "<h2>2. Profit</h2>";
echo "Total Profit: " . number_format($total_profit, 2) . "<br>";
if ($total_profit == 0) {
    echo "<span style='color:red'>Profit is 0. Checking if any profit metadata exists...</span><br>";
    $check_meta = $conn->query("SELECT * FROM geopos_metadata WHERE type=9 LIMIT 5");
    if ($check_meta->num_rows > 0) {
        echo "Found some profit metadata entries (type 9):<br>";
        while($m = $check_meta->fetch_assoc()) {
            echo "ID: {$m['id']}, Date: {$m['d_date']}, Val: {$m['col1']}<br>";
        }
    } else {
        echo "No entries found in geopos_metadata with type=9.<br>";
    }
}

// 5. Check Financial Position (Assets, Liabilities, Equity)
echo "<h2>3. Financial Position (Fallback Logic)</h2>";

function get_balance($conn, $type, $keywords) {
    // 1. Strict Type
    $sql = "SELECT SUM(lastbal) as bal FROM geopos_accounts WHERE account_type = '$type'";
    $res = $conn->query($sql);
    $bal = $res->fetch_assoc()['bal'] ?? 0;
    
    if ($bal == 0) {
        // 2. Fallback
        $likes = [];
        foreach ($keywords as $k) {
            $likes[] = "holder LIKE '%$k%'";
        }
        $like_str = implode(' OR ', $likes);
        
        $sql = "SELECT SUM(lastbal) as bal FROM geopos_accounts 
                WHERE (account_type = '' OR account_type IS NULL) 
                AND ($like_str)";
        
        $res = $conn->query($sql);
        $bal = $res->fetch_assoc()['bal'] ?? 0;
        return "$bal (Fallback)";
    }
    return "$bal (Strict)";
}

$assets = get_balance($conn, 'Assets', ['Cash', 'Bank', 'Inventory', 'Asset']);
$liabilities = get_balance($conn, 'Liabilities', ['Payable', 'Liability', 'Tax', 'Loan']);
$equity = get_balance($conn, 'Equity', ['Equity', 'Capital', 'Share']);

echo "Total Assets: $assets<br>";
echo "Total Liabilities: $liabilities<br>";
echo "Total Equity: $equity<br>";

// 6. Calculated Ratios
echo "<h2>4. Calculated Ratios</h2>";

// AOV
$aov = ($invoice_count > 0) ? ($total_sales / $invoice_count) : 0;
echo "Avg Order Value (Sales/Count): " . number_format($aov, 2) . "<br>";

// Net Profit Margin
$margin = ($total_sales > 0) ? ($total_profit / $total_sales) * 100 : 0;
echo "Net Profit Margin (Profit/Sales): " . number_format($margin, 2) . "%<br>";

// Liquidity
// Parsing "123 (Fallback)" to number
$assets_val = floatval($assets);
$liabilities_val = floatval($liabilities);
$liquidity = ($liabilities_val > 0) ? ($assets_val / $liabilities_val) : ($assets_val > 0 ? "Infinite" : 0);
echo "Liquidity Ratio (Assets/Liab): $liquidity<br>";

// ROE
$equity_val = floatval($equity);
$roe = ($equity_val > 0) ? ($total_profit / $equity_val) * 100 : 0;
echo "ROE (Profit/Equity): " . number_format($roe, 2) . "%<br>";


$conn->close();
?>
