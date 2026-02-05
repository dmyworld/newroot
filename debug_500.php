<?php
// Debug 500 Error (Fixed)
// Access: http://localhost/newroot/debug_500.php?id=8

error_reporting(-1);
ini_set('display_errors', 1);

define('BASEPATH', 'TRUE'); // Fake CI constant

// ---------------- MOCKS ----------------

function &get_instance()
{
    global $CI;
    return $CI;
}

class MockConfig {
    public function item($item) { 
        if($item == 'ctitle') return "Test Company (Debug)";
        return "Config Item: $item"; 
    }
}

class MockLoader {
    public $config;
    
    public function __construct() {
        $this->config = new MockConfig();
    }

    public function view($view, $data = []) {
        echo "<h3>Loading View: $view</h3>";
        if(is_array($data)) {
            extract($data);
        }
        
        $view_file = ApplicationViewsPath . $view . ".php";
        if(file_exists($view_file)) {
            include($view_file);
        } else {
            echo "❌ View file not found: $view_file";
        }
    }
}

class MockDB {
    public $conn;
    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "newroot");
        if ($this->conn->connect_error) { die("Connection failed: " . $this->conn->connect_error); }
    }
}

class CI_Controller {
    public $db;
    public $config;
    public $load;
    
    public function __construct() {
        $this->db = new MockDB();
        $this->config = new MockConfig();
        $this->load = new MockLoader();
    }
}

// ---------------- MAIN ----------------
$id = isset($_GET['id']) ? intval($_GET['id']) : 8;
echo "<h1>Debugging 500 Error for ID: $id</h1>";

define('ApplicationViewsPath', __DIR__ . '/application/views/');

// 1. Fetch Data
$conn = new mysqli("localhost", "root", "", "newroot");
$sql = "SELECT 
            geopos_payroll_items.*, 
            geopos_employees.name, 
            geopos_employees.address, 
            geopos_employees.city, 
            geopos_employees.email, 
            geopos_payroll_runs.start_date, 
            geopos_payroll_runs.end_date
        FROM geopos_payroll_items
        LEFT JOIN geopos_employees ON geopos_employees.id = geopos_payroll_items.employee_id
        LEFT JOIN geopos_payroll_runs ON geopos_payroll_runs.id = geopos_payroll_items.run_id
        WHERE geopos_payroll_items.id = $id";

$res = $conn->query($sql);
$payslip = $res->fetch_assoc();

if(!$payslip) {
    die("❌ SQL returned no data. Check ID.");
}

$data['payslip'] = $payslip;
$data['details'] = json_decode($payslip['deduction_details'], true);

// 2. Setup CI Global
$CI = new CI_Controller();

// 3. Render
echo "<hr>";
try {
    // We use the MockLoader to load the view, which will include it.
    // Inside the view, $this will refer to $CI->load (the MockLoader instance).
    // MockLoader has $config, so $this->config->item() should work.
    $CI->load->view('payroll/report/payslip_view', $data);
    
} catch (Throwable $e) {
    echo "<h2 style='color:red'>FATAL ERROR: " . $e->getMessage() . "</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr><h3>End of Script</h3>";
?>
