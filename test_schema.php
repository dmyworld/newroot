<?php
header('Content-Type: text/plain');
$mysqli = new mysqli("localhost", "root", "", "newroot");
$tables = ['geopos_products', 'geopos_invoices', 'geopos_transactions', 'geopos_users', 'geopos_employees', 'geopos_customers', 'geopos_supplier', 'geopos_stock_transfer', 'geopos_purchase', 'geopos_quotes', 'geopos_project'];

foreach($tables as $table) {
    echo "TABLE: $table\n";
    $result = $mysqli->query("SHOW COLUMNS FROM $table LIKE 'business_id'");
    if ($result && $result->num_rows > 0) {
        echo " - Has business_id\n";
    } else {
        echo " - MISSING business_id\n";
    }
}
$mysqli->close();
