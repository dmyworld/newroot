<?php
$db_hostname = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name     = 'newroot';

try {
    $dsn = "mysql:host=$db_hostname;dbname=$db_name;charset=utf8";
    $pdo = new PDO($dsn, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("DESCRIBE geopos_cheques");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($cols, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo $e->getMessage();
}
