<?php
// Schema update script for geopos_cheques
$db_hostname = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name     = 'newroot';

try {
    $dsn = "mysql:host=$db_hostname;dbname=$db_name;charset=utf8";
    $pdo = new PDO($dsn, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h3>Updating geopos_cheques Schema...</h3>";

    // 1. Check existing columns
    $stmt = $pdo->query("DESCRIBE geopos_cheques");
    $db_cols = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 2. Add cheque_number if missing
    if (!in_array('cheque_number', $db_cols)) {
        $pdo->exec("ALTER TABLE geopos_cheques ADD COLUMN cheque_number VARCHAR(100) AFTER tid");
        echo "✓ Added column: cheque_number<br>";
    }

    // 3. Ensure party_type and other fields are correct
    if (!in_array('party_type', $db_cols)) {
        $pdo->exec("ALTER TABLE geopos_cheques ADD COLUMN party_type ENUM('Customer','Supplier') DEFAULT 'Customer' AFTER party_id");
        echo "✓ Added column: party_type<br>";
    }

    echo "<h3>✓ Schema Updated Successfully!</h3>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
