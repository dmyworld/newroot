<?php
$db = new PDO('mysql:host=localhost;dbname=newroot', 'root', '');
$stmt = $db->query('SELECT * FROM geopos_roles');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
