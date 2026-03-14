<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");
$tables = ['geopos_products', 'geopos_invoices', 'geopos_transactions', 'geopos_users', 'geopos_employees', 'geopos_customers', 'geopos_supplier', 'geopos_stock_transfer', 'geopos_purchase', 'geopos_quotes', 'geopos_project', 'geopos_register'];
$result_arr = [];
foreach($tables as $table) {
    
    $result = $mysqli->query("SHOW COLUMNS FROM $table LIKE 'business_id'");
    if ($result && $result->num_rows > 0) {
        $result_arr[$table] = true;
    } else {
        $result_arr[$table] = false;
    }
}
$mysqli->close();
file_put_contents('test_schema.json', json_encode($result_arr));
echo "Done";
