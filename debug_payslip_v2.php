<?php
// Debug Payslip V2 - Deep Dive
// Access: http://localhost/newroot/debug_payslip_v2.php?id=8

define('BASEPATH', 'TRUE'); // Fake CI constant
date_default_timezone_set('UTC');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$id = isset($_GET['id']) ? intval($_GET['id']) : 8;

echo "<h1>Debug Payslip V2: $id</h1>";

// 1. Raw Item
$item = $conn->query("SELECT * FROM geopos_payroll_items WHERE id = $id")->fetch_assoc();
echo "<h3>Raw Item</h3><pre>"; print_r($item); echo "</pre>";

$emp_id = $item['employee_id'];
$run_id = $item['run_id'];

// 2. Direct Query on Employee
echo "<h3>Employee Check (ID: $emp_id)</h3>";
$emp_res = $conn->query("SELECT * FROM geopos_employees WHERE id = '$emp_id'");
if($emp_res->num_rows > 0) {
    echo "✅ Employee Found (Row Count: {$emp_res->num_rows})<br>";
    $e = $emp_res->fetch_assoc();
    echo "ID Type: " . gettype($e['id']) . " Value: " . $e['id'] . "<br>"; 
} else {
    echo "❌ Employee NOT Found matching exact ID '$emp_id'<br>";
}

// 3. Direct Query on Run
echo "<h3>Run Check (ID: $run_id)</h3>";
$run_res = $conn->query("SELECT * FROM geopos_payroll_runs WHERE id = '$run_id'");
if($run_res->num_rows > 0) {
    echo "✅ Run Found (Row Count: {$run_res->num_rows})<br>";
    $r = $run_res->fetch_assoc();
    echo "ID Type: " . gettype($r['id']) . " Value: " . $r['id'] . "<br>";
} else {
    echo "❌ Run NOT Found matching exact ID '$run_id'<br>";
}

// 4. LEFT JOIN Test
echo "<h3>LEFT JOIN Test</h3>";
$sql = "SELECT 
            i.id as item_id,
            e.id as emp_id_joined,
            e.name as emp_name,
            r.id as run_id_joined,
            r.start_date
        FROM geopos_payroll_items i
        LEFT JOIN geopos_employees e ON e.id = i.employee_id
        LEFT JOIN geopos_payroll_runs r ON r.id = i.run_id
        WHERE i.id = $id";

$res = $conn->query($sql);
$row = $res->fetch_assoc();

echo "<table border=1>
<tr><th>Item ID</th><th>Joined Emp ID</th><th>Emp Name</th><th>Joined Run ID</th><th>Start Date</th></tr>
<tr>
    <td>{$row['item_id']}</td>
    <td>" . ($row['emp_id_joined'] ? $row['emp_id_joined'] : 'NULL (Join Failed)') . "</td>
    <td>{$row['emp_name']}</td>
    <td>" . ($row['run_id_joined'] ? $row['run_id_joined'] : 'NULL (Join Failed)') . "</td>
    <td>{$row['start_date']}</td>
</tr>
</table>";

$conn->close();
?>
