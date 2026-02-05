<?php
// Test what data is being submitted from the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>POST Data Received:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    echo "<h3>Analysis:</h3>";
    
    if(isset($_POST['employee_ids'])) {
        echo "<p style='color: green;'><strong>✓ employee_ids found:</strong> " . count($_POST['employee_ids']) . " employees</p>";
        echo "<pre>" . print_r($_POST['employee_ids'], true) . "</pre>";
    } else {
        echo "<p style='color: red;'><strong>✗ employee_ids NOT found in POST data!</strong></p>";
    }
    
    if(isset($_POST['gross'])) {
        echo "<p style='color: green;'><strong>✓ gross data found:</strong> " . count($_POST['gross']) . " entries</p>";
    } else {
        echo "<p style='color: red;'><strong>✗ gross data NOT found!</strong></p>";
    }
    
    if(isset($_POST['start']) && isset($_POST['end'])) {
        echo "<p style='color: green;'><strong>✓ Dates found:</strong> {$_POST['start']} to {$_POST['end']}</p>";
    } else {
        echo "<p style='color: red;'><strong>✗ Dates NOT found!</strong></p>";
    }
    
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Finalize Form Submit</title>
</head>
<body>
    <h1>Test Form Submission</h1>
    <p>This simulates what your finalize form should send:</p>
    
    <form method="POST" action="">
        <h3>Dates:</h3>
        <input type="text" name="start" value="2026-01-01"><br>
        <input type="text" name="end" value="2026-01-31"><br>
        
        <h3>Employees (simulating 2 employees):</h3>
        <input type="checkbox" name="employee_ids[]" value="1" checked> Employee 1<br>
        <input type="checkbox" name="employee_ids[]" value="2" checked> Employee 2<br>
        
        <h3>Sample Payroll Data:</h3>
        Hours[1]: <input type="number" name="hours[1]" value="160"><br>
        Gross[1]: <input type="number" name="gross[1]" value="50000"><br>
        Tax[1]: <input type="number" name="tax[1]" value="0"><br>
        Deductions[1]: <input type="number" name="deductions[1]" value="5000"><br>
        Advance[1]: <input type="number" name="advance[1]" value="0"><br>
        Net[1]: <input type="number" name="net_pay[1]" value="45000"><br>
        
        <br>
        <button type="submit">Submit Test Data</button>
    </form>
</body>
</html>
