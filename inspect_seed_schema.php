<?php
$mysqli = new mysqli('localhost', 'root', '', 'newroot');
$tables = ['geopos_locations', 'geopos_employees', 'geopos_workers', 'geopos_worker_profiles', 'geopos_config', 'aauth_groups'];
foreach($tables as $t) {
    echo "<h4>$t:</h4>";
    $r = $mysqli->query("DESCRIBE $t");
    if(!$r){echo "ERROR: ".$mysqli->error."<br>";continue;}
    while($row=$r->fetch_assoc()) echo $row['Field'].' - '.$row['Type'].'<br>';
}
