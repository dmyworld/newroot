<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_helper
{
    private $CI;
    private $debug_log = [];
    private $error_log = [];
    private $start_time;
    private $user_info = [];
    
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->start_time = microtime(true);
        $this->initDebug();
    }
    
    /**
     * Initialize debug session
     */
    private function initDebug(): void
    {
        // Create debug directory if not exists
        $debug_dir = APPPATH . 'logs/debug/';
        if (!is_dir($debug_dir)) {
            mkdir($debug_dir, 0755, true);
        }
        
        // Start session log
        $this->debug_log['session'] = [
            'start_time' => date('Y-m-d H:i:s'),
            'session_id' => session_id(),
            'uri' => $this->CI->uri->uri_string(),
            'method' => $this->CI->input->method()
        ];
    }
    
    /**
     * Comprehensive user information debug
     */
    public function debugUser(): array
    {
        $user_data = [];
        
        // Basic user info
        if (method_exists($this->CI->aauth, 'get_user')) {
            $user = $this->CI->aauth->get_user();
            $user_data = [
                'id' => $user->id ?? 'N/A',
                'username' => $user->username ?? 'N/A',
                'email' => $user->email ?? 'N/A',
                'roleid' => $user->roleid ?? 'N/A',
                'loc' => $user->loc ?? 'N/A',
                'is_loggedin' => $this->CI->aauth->is_loggedin() ? 'YES' : 'NO',
                'is_admin' => $this->CI->aauth->is_admin() ? 'YES' : 'NO',
                'is_manager' => $this->CI->aauth->is_member('Manager') ? 'YES' : 'NO',
                'user_groups' => $this->CI->aauth->get_user_groups() ?? [],
                'permissions' => $this->CI->aauth->get_user_permissions() ?? []
            ];
        }
        
        // Session data
        $user_data['session_data'] = $this->CI->session->all_userdata();
        
        $this->debug_log['user_info'] = $user_data;
        $this->logToFile('USER_DEBUG', $user_data);
        
        return $user_data;
    }
    
    /**
     * Debug location field issues
     */
    public function debugLocation(): array
    {
        $location_data = [];
        
        // Check user location
        $user = $this->CI->aauth->get_user();
        $user_loc = $user->loc ?? null;
        
        $location_data['user_location'] = [
            'raw_value' => $user_loc,
            'is_empty' => empty($user_loc),
            'is_zero' => ($user_loc === '0' || $user_loc === 0),
            'is_valid' => !empty($user_loc) && $user_loc !== '0',
            'data_type' => gettype($user_loc)
        ];
        
        // Check database for location data
        $this->CI->db->select('loc, COUNT(*) as total')
                     ->from('geopos_users')
                     ->where('id', $user->id)
                     ->group_by('loc');
        $db_location = $this->CI->db->get()->row();
        
        $location_data['database_location'] = [
            'stored_loc' => $db_location->loc ?? 'NOT FOUND',
            'user_count' => $db_location->total ?? 0
        ];
        
        // Check invoices table location field
        $this->CI->db->select('loc, COUNT(*) as invoice_count')
                     ->from('geopos_invoices')
                     ->where('eid', $user->id)
                     ->group_by('loc');
        $invoice_locations = $this->CI->db->get()->result();
        
        $location_data['invoice_locations'] = $invoice_locations;
        
        // Check if location exists in locations table
        $this->CI->db->select('id, title, cname')
                     ->from('geopos_locations')
                     ->where('id', $user_loc);
        $location_info = $this->CI->db->get()->row();
        
        $location_data['location_info'] = $location_info ?: 'Location not found in locations table';
        
        $this->debug_log['location_debug'] = $location_data;
        $this->logToFile('LOCATION_DEBUG', $location_data);
        
        return $location_data;
    }
    
    /**
     * Debug permission checks
     */
    public function debugPermissions(): array
    {
        $permission_data = [];
        
        // Load models
        $this->CI->load->model('permission_model', 'perms');
        
        $user_id = $this->CI->aauth->get_user()->id;
        $user_role = $this->CI->aauth->get_user()->roleid;
        
        // Check specific permissions
        $permissions_to_check = [
            'create_invoice',
            'edit_invoice', 
            'view_invoice',
            'delete_invoice',
            'update_stock',
            'manage_customers'
        ];
        
        foreach ($permissions_to_check as $perm) {
            $permission_data[$perm] = [
                'has_permission' => $this->CI->perms->hasPermission($user_id, $perm),
                'role_has_permission' => $this->CI->perms->roleHasPermission($user_role, $perm),
                'direct_check' => $this->CI->aauth->is_allowed($perm)
            ];
        }
        
        // Check role permissions from database
        $this->CI->db->select('r.id as role_id, r.name as role_name, p.permission, rp.permission_id')
                     ->from('geopos_roles r')
                     ->join('geopos_roles_perms rp', 'r.id = rp.role_id', 'left')
                     ->join('geopos_permissions p', 'p.id = rp.permission_id', 'left')
                     ->where('r.id', $user_role);
        $role_perms = $this->CI->db->get()->result();
        
        $permission_data['role_permissions'] = $role_perms;
        
        // Check user specific permissions
        $this->CI->db->select('p.permission, up.permission_id')
                     ->from('geopos_user_perms up')
                     ->join('geopos_permissions p', 'p.id = up.permission_id', 'left')
                     ->where('up.user_id', $user_id);
        $user_perms = $this->CI->db->get()->result();
        
        $permission_data['user_permissions'] = $user_perms;
        
        $this->debug_log['permission_debug'] = $permission_data;
        $this->logToFile('PERMISSION_DEBUG', $permission_data);
        
        return $permission_data;
    }
    
    /**
     * Debug transaction issues
     */
    public function debugTransaction(): array
    {
        $transaction_data = [];
        
        // Check database transaction status
        $transaction_data['transaction_status'] = [
            'in_transaction' => $this->CI->db->trans_status(),
            'trans_started' => method_exists($this->CI->db, 'trans_started') ? $this->CI->db->trans_started() : 'N/A',
            'trans_off' => $this->CI->db->trans_off(),
            'trans_strict' => $this->CI->db->trans_strict
        ];
        
        // Check last query
        $transaction_data['last_query'] = $this->CI->db->last_query();
        
        // Check last error
        $transaction_data['last_error'] = $this->CI->db->error();
        
        // Check affected rows
        $transaction_data['affected_rows'] = $this->CI->db->affected_rows();
        
        $this->debug_log['transaction_debug'] = $transaction_data;
        $this->logToFile('TRANSACTION_DEBUG', $transaction_data);
        
        return $transaction_data;
    }
    
    /**
     * Debug input validation
     */
    public function debugInputs(): array
    {
        $input_data = [];
        
        // Get all POST data
        $post_data = $this->CI->input->post();
        $input_data['raw_post'] = $post_data;
        
        // Check required fields for invoice
        $required_fields = ['customer_id', 'invocieno', 'pid', 'product_qty', 'product_price'];
        $missing_fields = [];
        
        foreach ($required_fields as $field) {
            if (empty($post_data[$field])) {
                $missing_fields[] = $field;
            }
        }
        
        $input_data['validation'] = [
            'missing_required_fields' => $missing_fields,
            'has_required_fields' => empty($missing_fields),
            'customer_id_valid' => isset($post_data['customer_id']) && $post_data['customer_id'] > 0,
            'product_count' => is_array($post_data['pid'] ?? null) ? count($post_data['pid']) : 0
        ];
        
        // Check array lengths consistency
        $array_fields = ['pid', 'product_qty', 'product_price', 'product_name'];
        $array_lengths = [];
        
        foreach ($array_fields as $field) {
            if (isset($post_data[$field]) && is_array($post_data[$field])) {
                $array_lengths[$field] = count($post_data[$field]);
            }
        }
        
        $input_data['array_consistency'] = [
            'lengths' => $array_lengths,
            'consistent' => count(array_unique($array_lengths)) === 1
        ];
        
        $this->debug_log['input_debug'] = $input_data;
        $this->logToFile('INPUT_DEBUG', $input_data);
        
        return $input_data;
    }
    
    /**
     * Debug stock update permissions
     */
    public function debugStockPermissions(): array
    {
        $stock_data = [];
        
        $user_id = $this->CI->aauth->get_user()->id;
        
        // Check if user can update stock
        $can_update_stock = $this->CI->aauth->is_allowed('update_stock');
        
        // Check inventory permissions
        $this->CI->db->select('id, permission')
                     ->from('geopos_permissions')
                     ->like('permission', 'stock')
                     ->or_like('permission', 'inventory')
                     ->or_like('permission', 'product');
        $stock_permissions = $this->CI->db->get()->result();
        
        $stock_data['permissions'] = [
            'can_update_stock' => $can_update_stock,
            'available_stock_permissions' => $stock_permissions,
            'has_stock_management' => $this->CI->aauth->is_allowed('manage_products')
        ];
        
        // Check recent stock updates by user
        $this->CI->db->select('pid, qty, created_at')
                     ->from('geopos_stock_log')
                     ->where('user_id', $user_id)
                     ->order_by('created_at', 'DESC')
                     ->limit(10);
        $recent_updates = $this->CI->db->get()->result();
        
        $stock_data['recent_updates'] = $recent_updates;
        
        // Check product table permissions
        $stock_data['table_permissions'] = [
            'can_insert_products' => $this->checkTablePermission('geopos_products', 'INSERT'),
            'can_update_products' => $this->checkTablePermission('geopos_products', 'UPDATE'),
            'can_delete_products' => $this->checkTablePermission('geopos_products', 'DELETE')
        ];
        
        $this->debug_log['stock_permission_debug'] = $stock_data;
        $this->logToFile('STOCK_PERMISSION_DEBUG', $stock_data);
        
        return $stock_data;
    }
    
    /**
     * Check database table permissions (MySQL specific)
     */
    private function checkTablePermission(string $table, string $privilege): bool
    {
        $this->CI->db->query("SHOW GRANTS FOR CURRENT_USER()");
        $grants = $this->CI->db->result_array();
        
        $pattern = "/GRANT.*ON.*`{$table}`.*TO/";
        foreach ($grants as $grant) {
            if (preg_match($pattern, $grant[0])) {
                if (strpos($grant[0], "ALL PRIVILEGES") !== false || 
                    strpos($grant[0], $privilege) !== false) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Log to file
     */
    private function logToFile(string $type, $data): void
    {
        $log_file = APPPATH . 'logs/debug/debug_' . date('Y-m-d') . '.log';
        
        $log_entry = "[" . date('Y-m-d H:i:s') . "] [{$type}] " . print_r($data, true) . "\n";
        $log_entry .= str_repeat("-", 80) . "\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND);
    }
    
    /**
     * Get all debug information
     */
    public function getAllDebug(): array
    {
        $all_debug = [
            'user' => $this->debugUser(),
            'location' => $this->debugLocation(),
            'permissions' => $this->debugPermissions(),
            'transaction' => $this->debugTransaction(),
            'inputs' => $this->debugInputs(),
            'stock' => $this->debugStockPermissions(),
            'performance' => [
                'execution_time' => round(microtime(true) - $this->start_time, 4) . ' seconds',
                'memory_usage' => round(memory_get_usage() / 1024 / 1024, 2) . ' MB',
                'peak_memory' => round(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB',
                'database_queries' => count($this->CI->db->queries)
            ],
            'environment' => [
                'php_version' => PHP_VERSION,
                'codeigniter_version' => CI_VERSION,
                'database_driver' => $this->CI->db->platform(),
                'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'
            ]
        ];
        
        // Log complete debug
        $this->logToFile('COMPLETE_DEBUG', $all_debug);
        
        return $all_debug;
    }
    
    /**
     * Display debug information in browser
     */
    public function displayDebug(): string
    {
        $debug_info = $this->getAllDebug();
        
        $output = "<div style='background: #f5f5f5; padding: 20px; border: 2px solid #d9534f; margin: 20px;'>";
        $output .= "<h2 style='color: #d9534f;'>DEBUG INFORMATION</h2>";
        
        foreach ($debug_info as $section => $data) {
            $output .= "<h3 style='color: #337ab7;'>" . strtoupper($section) . "</h3>";
            $output .= "<pre style='background: white; padding: 10px; border: 1px solid #ddd;'>";
            $output .= print_r($data, true);
            $output .= "</pre>";
        }
        
        $output .= "</div>";
        
        return $output;
    }
    
    /**
     * Log error with context
     */
    public function logError(string $message, array $context = []): void
    {
        $error_data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'message' => $message,
            'context' => $context,
            'user_id' => $this->CI->aauth->get_user()->id ?? 'unknown',
            'uri' => $this->CI->uri->uri_string(),
            'ip' => $this->CI->input->ip_address()
        ];
        
        $this->error_log[] = $error_data;
        $this->logToFile('ERROR', $error_data);
        
        // Also log to CI error log
        log_message('error', "DEBUG HELPER: " . $message . " - " . json_encode($context));
    }
    
    /**
     * Get all errors
     */
    public function getErrors(): array
    {
        return $this->error_log;
    }
    
    /**
     * Clear debug data
     */
    public function clearDebug(): void
    {
        $this->debug_log = [];
        $this->error_log = [];
    }
}