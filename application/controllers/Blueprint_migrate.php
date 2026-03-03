<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blueprint Migration Runner
 * URL: /blueprint_migrate  or  /blueprint_migrate/run
 *
 * Reads blueprint_migration.sql from project root and executes
 * each statement, reporting success/failure for each step.
 */
class Blueprint_migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        // Only allow logged-in users (admin)
        if (!$this->aauth->is_loggedin()) {
            redirect('user/login');
        }
    }

    // -------------------------------------------------------
    //  index() — Show the migration landing page
    // -------------------------------------------------------
    public function index()
    {
        $data['title']        = 'Blueprint Migration Runner';
        $data['page_heading'] = 'Timber Pro Blueprint Migration';
        $data['subtitle']     = 'Run the Blueprint database migration to add new tables and columns.';

        $this->load->view('fixed/header-va', $data);
        $this->load->view('blueprint_migrate/index', $data);
        $this->load->view('fixed/footer', $data);
    }

    // -------------------------------------------------------
    //  run() — Execute the SQL migration and return results
    // -------------------------------------------------------
    public function run()
    {
        // Locate the SQL file (project root, one level above application/)
        $sql_file = FCPATH . 'blueprint_migration.sql';

        $results  = [];
        $success  = 0;
        $skipped  = 0;
        $errors   = 0;

        if (!file_exists($sql_file)) {
            $results[] = ['type' => 'error', 'msg' => 'Migration file not found: ' . $sql_file];
            $this->_render_results($results, $success, $skipped, $errors);
            return;
        }

        $sql_raw = file_get_contents($sql_file);

        // Strip SQL comments (-- style and /* */ style)
        $sql_raw = preg_replace('/^--.*$/m', '', $sql_raw);
        $sql_raw = preg_replace('/\/\*.*?\*\//s', '', $sql_raw);

        // Split into individual statements
        $statements = array_filter(
            array_map('trim', explode(';', $sql_raw)),
            function ($s) { return strlen($s) > 5; }
        );

        foreach ($statements as $sql) {
            // Detect what kind of statement this is for a nicer label
            $label  = $this->_get_label($sql);
            $is_alter = (stripos($sql, 'ALTER TABLE') === 0);

            // For ALTER TABLE ... ADD COLUMN IF NOT EXISTS — MySQL 8.0+ supports this natively.
            // For older MySQL, catch the "Duplicate column" error and treat as skip.
            $result = $this->db->query($sql);
            $err    = $this->db->error();

            if ($result) {
                $results[] = [
                    'type' => 'success',
                    'msg'  => '✅ ' . $label,
                ];
                $success++;
            } elseif (!empty($err['message'])) {
                $msg = $err['message'];
                // Detect common "already exists" errors for tables and columns
                if (stripos($msg, 'Duplicate column name') !== false
                    || stripos($msg, "already exists") !== false
                    || stripos($msg, "Duplicate key name") !== false) {
                    $results[] = [
                        'type' => 'info',
                        'msg'  => '⏭️ SKIPPED (already exists): ' . $label,
                    ];
                    $skipped++;
                } else {
                    $results[] = [
                        'type' => 'error',
                        'msg'  => '❌ ERROR — ' . $label . ' → ' . $msg,
                    ];
                    $errors++;
                }
            }
        }

        $data = [
            'title'    => 'Migration Results',
            'results'  => $results,
            'success'  => $success,
            'skipped'  => $skipped,
            'errors'   => $errors,
            'total'    => count($statements),
        ];

        $this->load->view('fixed/header-va', $data);
        $this->load->view('blueprint_migrate/results', $data);
        $this->load->view('fixed/footer', $data);
    }

    // -------------------------------------------------------
    //  verify() — Quick verification: check if new tables exist
    // -------------------------------------------------------
    public function verify()
    {
        $expected_tables = [
            'tp_service_requests',
            'tp_ring_logs',
            'tp_live_tracking',
            'tp_escrow_vault',
            'tp_escrow_transactions',
            'tp_subscription_packages',
            'tp_business_subscriptions',
            'tp_ai_ad_logs',
            'tp_donation_fund',
            'tp_tree_planting_requests',
            'tp_tree_maintenance_payouts',
            'tp_referral_program',
            'tp_referral_logs',
            'tp_provider_insurance',
            'tp_provider_insurance_claims',
        ];

        $expected_columns = [
            'geopos_users'    => ['is_verified', 'kyc_status', 'provider_type', 'referral_code', 'green_points'],
            'geopos_locations'=> ['gps_lat', 'gps_lng', 'district', 'province'],
            'geopos_products' => ['sale_mode', 'rent_price_day'],
            'geopos_invoices' => ['escrow_id', 'contract_ref'],
        ];

        $checks = [];

        // Check new tables
        foreach ($expected_tables as $table) {
            $exists = $this->db->table_exists($table);
            $checks[] = [
                'type'  => $exists ? 'success' : 'error',
                'label' => 'Table: ' . $table,
                'ok'    => $exists,
            ];
        }

        // Check columns in existing tables
        foreach ($expected_columns as $table => $cols) {
            foreach ($cols as $col) {
                $exists = $this->db->field_exists($col, $table);
                $checks[] = [
                    'type'  => $exists ? 'success' : 'error',
                    'label' => "Column: {$table}.{$col}",
                    'ok'    => $exists,
                ];
            }
        }

        $data = [
            'title'  => 'Migration Verification',
            'checks' => $checks,
            'passed' => count(array_filter($checks, fn($c) => $c['ok'])),
            'failed' => count(array_filter($checks, fn($c) => !$c['ok'])),
        ];

        $this->load->view('fixed/header-va', $data);
        $this->load->view('blueprint_migrate/verify', $data);
        $this->load->view('fixed/footer', $data);
    }

    // -------------------------------------------------------
    //  Helper: Generate a short label from a SQL statement
    // -------------------------------------------------------
    private function _get_label($sql)
    {
        $sql = preg_replace('/\s+/', ' ', substr($sql, 0, 120));
        return htmlspecialchars($sql);
    }
}
