<?php
// Debug what's being saved to payroll items
define('BASEPATH', 'test');
define('ENVIRONMENT', 'development');
include('application/config/database.php');
$config = $db['default'];

$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

echo "<h2>Recent Payroll Items Debug</h2>";

// Get the most recent run
$run_result = $mysqli->query("SELECT * FROM geopos_payroll_runs ORDER BY id DESC LIMIT 1");
$run = $run_result->fetch_assoc();

if($run) {
    echo "<h3>Most Recent Run: #{$run['id']}</h3>";
    echo "<p>Period: {$run['start_date']} to {$run['end_date']}</p>";
    echo "<p>Status: {$run['status']}</p>";
    
    // Get items
    $items_result = $mysqli->query("SELECT * FROM geopos_payroll_items WHERE run_id = {$run['id']}");
    
    if($items_result->num_rows > 0) {
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>Employee ID</th><th>Basic Salary</th><th>COLA</th><th>Overtime</th><th>Bonus</th>";
        echo "<th>Gross</th><th>EPF Emp</th><th>EPF Empr</th><th>ETF</th><th>Loan Ded</th><th>Other Ded</th><th>Net Pay</th>";
        echo "</tr>";
        
        while($item = $items_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$item['employee_id']}</td>";
            echo "<td>" . number_format($item['basic_salary'], 2) . "</td>";
            echo "<td>" . number_format($item['cola_amount'], 2) . "</td>";
            echo "<td>" . number_format($item['overtime_pay'], 2) . "</td>";
            echo "<td>" . number_format($item['bonus_amount'], 2) . "</td>";
            echo "<td><strong>" . number_format($item['gross_pay'], 2) . "</strong></td>";
            echo "<td>" . number_format($item['epf_employee'], 2) . "</td>";
            echo "<td>" . number_format($item['epf_employer'], 2) . "</td>";
            echo "<td>" . number_format($item['etf_employer'], 2) . "</td>";
            echo "<td>" . number_format($item['loan_deduction'], 2) . "</td>";
            echo "<td>" . number_format($item['other_deductions'], 2) . "</td>";
            echo "<td><strong>" . number_format($item['net_pay'], 2) . "</strong></td>";
            echo "</tr>";
            
            // Show deduction details
            if($item['deduction_details']) {
                $details = json_decode($item['deduction_details'], true);
                echo "<tr><td colspan='12' style='background: #f9f9f9; padding: 10px;'>";
                echo "<strong>Deduction Breakdown:</strong><br>";
                if($details && is_array($details)) {
                    echo "<ul>";
                    foreach($details as $d) {
                        echo "<li>{$d['name']}: " . number_format($d['amount'], 2) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "No breakdown available";
                }
                echo "</td></tr>";
            }
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'><strong>No items found for this run!</strong></p>";
        echo "<p>This means the finalization didn't save any employee data.</p>";
    }
} else {
    echo "<p>No payroll runs found</p>";
}

$mysqli->close();
?>
