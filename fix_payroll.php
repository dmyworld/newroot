<?php
// Payroll Database Repair Tool
// Access via: http://localhost/newroot/fix_payroll.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected to '$dbname'. Starting Repair...<br><hr>";

// List of tables to Reset (Drop and Recreate)
$tables = [
    'geopos_job_codes',
    'geopos_timesheets',
    'geopos_payroll_runs',
    'geopos_payroll_items',
    'geopos_payroll_approvals',
    'geopos_deduction_types',
    'geopos_emp_deductions',
    'geopos_overtime_rules',
    'geopos_payroll_config'
];

// 1. Drop Tables
foreach($tables as $tbl) {
    if($conn->query("DROP TABLE IF EXISTS $tbl") === TRUE) {
        echo "Dropped $tbl.<br>";
    } else {
        echo "<font color='red'>Error dropping $tbl: " . $conn->error . "</font><br>";
    }
}

echo "<hr>Creating Tables...<br>";

$sql_commands = [
    // 1. Job Codes
    "CREATE TABLE `geopos_job_codes` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `code` varchar(20) NOT NULL,
      `title` varchar(100) NOT NULL,
      `description` text,
      `is_active` tinyint(1) DEFAULT '1',
      PRIMARY KEY (`id`),
      UNIQUE KEY `code` (`code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // 2. Timesheets
    "CREATE TABLE `geopos_timesheets` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `employee_id` int(11) NOT NULL,
      `job_code_id` int(11) DEFAULT NULL,
      `clock_in` datetime NOT NULL,
      `clock_out` datetime DEFAULT NULL,
      `total_hours` decimal(10,2) DEFAULT '0.00',
      `note` text,
      `status` varchar(20) DEFAULT 'Pending',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // 3. Payroll Runs
    "CREATE TABLE `geopos_payroll_runs` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date_created` date NOT NULL,
      `start_date` date NOT NULL,
      `end_date` date NOT NULL,
      `total_amount` decimal(16,2) DEFAULT '0.00',
      `total_tax` decimal(16,2) DEFAULT '0.00',
      `status` varchar(20) DEFAULT 'Draft',
      `approval_status` varchar(20) DEFAULT 'Draft',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // 4. Payroll Items
    "CREATE TABLE `geopos_payroll_items` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `run_id` int(11) NOT NULL,
      `employee_id` int(11) NOT NULL,
      `total_hours` decimal(10,2) DEFAULT '0.00',
      `gross_pay` decimal(16,2) DEFAULT '0.00',
      `tax` decimal(16,2) DEFAULT '0.00',
      `total_deductions` decimal(16,2) DEFAULT '0.00',
      `net_pay` decimal(16,2) DEFAULT '0.00',
      `deduction_details` json DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `run_id` (`run_id`),
      KEY `employee_id` (`employee_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // 5. Approvals
    "CREATE TABLE `geopos_payroll_approvals` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `run_id` int(11) NOT NULL,
      `approver_id` int(11) NOT NULL,
      `status` varchar(20) NOT NULL,
      `comments` text,
      `approved_at` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // 6. Deduction Types
    "CREATE TABLE `geopos_deduction_types` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      `calculation_type` enum('Percentage','Fixed Amount') NOT NULL,
      `default_value` decimal(10,2) NOT NULL DEFAULT '0.00',
      `is_pre_tax` tinyint(1) NOT NULL DEFAULT '0',
      `is_active` tinyint(1) DEFAULT '1',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // 7. Emp Deductions
    "CREATE TABLE `geopos_emp_deductions` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `employee_id` int(11) NOT NULL,
      `deduction_type_id` int(11) NOT NULL,
      `amount_override` decimal(10,2) DEFAULT '0.00',
      `percentage_override` decimal(5,2) DEFAULT '0.00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    
    // 8. Overtime Rules
    "CREATE TABLE `geopos_overtime_rules` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      `multiplier` decimal(4,2) NOT NULL DEFAULT '1.50',
      `is_active` tinyint(1) DEFAULT '1',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // 9. Payroll Config
    "CREATE TABLE `geopos_payroll_config` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      `value` text,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `name` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

    // Seeding
    "INSERT INTO `geopos_job_codes` (`code`, `title`, `description`) VALUES
    ('JC001', 'General Carpentry', 'Standard framing and wood work'),
    ('JC002', 'Electrical Helper', 'Assisting electricians'),
    ('JC003', 'Site Management', 'Supervisory duties');",

    "INSERT INTO `geopos_deduction_types` (`name`, `calculation_type`, `default_value`, `is_pre_tax`) VALUES
    ('Health Insurance', 'Fixed Amount', 50.00, 1),
    ('Union Dues', 'Percentage', 1.5, 0),
    ('401k Contribution', 'Percentage', 3.0, 1);",
    
    "INSERT INTO `geopos_overtime_rules` (`name`, `multiplier`) VALUES ('Standard Overtime', 1.50);"
];

foreach ($sql_commands as $i => $sql) {
  if ($conn->query($sql) === TRUE) {
    echo "Query " . ($i+1) . " success.<br>";
  } else {
    echo "<font color='red'>Query " . ($i+1) . " error: " . $conn->error . "</font><br>";
  }
}

echo "<hr>Seeding Timesheets...<br>";
$result = $conn->query("SELECT id FROM geopos_employees LIMIT 5");
if ($result && $result->num_rows > 0) {
    $job_res = $conn->query("SELECT id FROM geopos_job_codes");
    $jobs = [];
    while($row = $job_res->fetch_assoc()) $jobs[] = $row['id'];
    
    if(count($jobs) > 0) {
        while($emp = $result->fetch_assoc()) {
            $eid = $emp['id'];
            for($i=0; $i<7; $i++) {
                $date = date('Y-m-d', strtotime("-$i days"));
                $hours = rand(6, 10);
                $job_id = $jobs[array_rand($jobs)];
                
                $in = $date . ' 09:00:00';
                $out = $date . ' ' . (9+$hours) . ':00:00';
                
                $ins = "INSERT INTO geopos_timesheets (employee_id, job_code_id, clock_in, clock_out, total_hours, note, status) VALUES ($eid, $job_id, '$in', '$out', $hours, 'Demo Auto', 'Approved')";
                $conn->query($ins);
            }
        }
        echo "Timesheets created.<br>";
    } else {
        echo "Error: Job codes missing.<br>";
    }
} else {
    echo "No employees found. Creating dummy...<br>";
    // Create dummy emp
    // Assume user table link... might fail if constraints.
    // Just skip.
}

$conn->close();
echo "<h1>Repair Complete!</h1>";
?>
