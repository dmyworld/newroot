<?php
// Debug Payslip ID 8
// Access: http://localhost/newroot/debug_payslip.php?id=8

define('BASEPATH', 'TRUE'); // Fake CI constant
date_default_timezone_set('UTC');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$id = isset($_GET['id']) ? intval($_GET['id']) : 8;

echo "<h1>Debug Payslip ID: $id</h1>";

// 1. Check if Item Exists
$sql = "SELECT * FROM geopos_payroll_items WHERE id = $id";
$res = $conn->query($sql);
if($res->num_rows > 0) {
    echo "✅ Item found in geopos_payroll_items.<br>";
    $item = $res->fetch_assoc();
    echo "<pre>"; print_r($item); echo "</pre>";
    
    // 2. Check Joins (Model Logic)
    echo "<h3>Testing Joins</h3>";
    $sql_join = "SELECT 
                    geopos_payroll_items.*, 
                    geopos_employees.name, 
                    geopos_employees.address, 
                    geopos_employees.city, 
                    geopos_employees.email, 
                    geopos_payroll_runs.start_date, 
                    geopos_payroll_runs.end_date
                FROM geopos_payroll_items
                JOIN geopos_employees ON geopos_employees.id = geopos_payroll_items.employee_id
                JOIN geopos_payroll_runs ON geopos_payroll_runs.id = geopos_payroll_items.run_id
                WHERE geopos_payroll_items.id = $id";
    
    $res2 = $conn->query($sql_join);
    if($res2 && $res2->num_rows > 0) {
        echo "✅ Join Successful. Data for View:<br>";
        $data = $res2->fetch_assoc();
        echo "<pre>"; print_r($data); echo "</pre>";
        
        // 3. Test JSON Decode
        $details = json_decode($data['deduction_details'], true);
        echo "<h3>Deduction Details (JSON Decode)</h3>";
        if(json_last_error() === JSON_ERROR_NONE) {
            echo "<pre>"; print_r($details); echo "</pre>";
        } else {
             echo "❌ JSON Decode Error: " . json_last_error_msg() . "<br>";
        }
        
    } else {
        echo "❌ Join Failed! Check if Employee or Run exists.<br>";
        echo "Employee ID: " . $item['employee_id'] . "<br>";
        echo "Run ID: " . $item['run_id'] . "<br>";
        
        // Check Employee
        $e_res = $conn->query("SELECT * FROM geopos_employees WHERE id = " . $item['employee_id']);
        echo "Employee Exists? " . ($e_res->num_rows > 0 ? "Yes" : "NO") . "<br>";
        
        // Check Run
        $r_res = $conn->query("SELECT * FROM geopos_payroll_runs WHERE id = " . $item['run_id']);
        echo "Run Exists? " . ($r_res->num_rows > 0 ? "Yes" : "NO") . "<br>";
    }

} else {
    echo "❌ Item NOT found in geopos_payroll_items.<br>";
}

$conn->close();
?>
