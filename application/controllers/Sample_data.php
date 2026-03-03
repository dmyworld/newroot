<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Timber Pro - Sample Data Seeder
 * Creates sample locations and role-based user accounts for demonstration
 * 
 * Usage:
 *   /sample_data          - Show status and credentials
 *   /sample_data/install  - Run seeder
 *   /sample_data/reset    - Delete sample data only
 */
class Sample_data extends CI_Controller
{
    // Demo password for all sample accounts
    const DEMO_PASSWORD = 'demo1234';

    // Role IDs (Mapping to Aauth/Blueprint roles)
    const ROLE_OWNER             = 9;
    const ROLE_GM                = 8;
    const ROLE_ACCOUNTANT        = 7;
    const ROLE_SALES_MANAGER     = 6;
    const ROLE_INVENTORY_MANAGER = 5;
    const ROLE_SAWMILL_MANAGER   = 4;
    const ROLE_LOGISTICS_COORD   = 3;
    const ROLE_SECURITY_CLERK    = 2;
    const ROLE_WORKER            = 1;
    const ROLE_CUSTOMER          = 0;

    // Sample user definitions [email, username, roleid, loc_key, role_label, provider_type]
    private $sample_users = [
        ['owner@timberpro.com',      'owner',            9,  'global',   'Global Owner',          'none'],
        ['gm@timberpro.com',         'gen_manager',      8,  'global',   'General Manager',       'none'],
        ['accountant@timberpro.com', 'accountant',       7,  'colombo',  'Chief Accountant',     'none'],
        ['sales@timberpro.com',      'sales_mgr',        6,  'colombo',  'Sales Manager',        'none'],
        ['inventory@timberpro.com',  'inv_mgr',          5,  'colombo',  'Inventory Manager',      'none'],
        ['mill_mgr@timberpro.com',   'sawmill_mgr',      4,  'kandy',    'Sawmill Manager',        'none'],
        ['fleet@timberpro.com',      'logistics_coord',  3,  'colombo',  'Logistics Coordinator',    'logistics'],
        ['clerk@timberpro.com',      'clerk',            2,  'galle',    'Security / Clerk',       'none'],
        ['worker@timberpro.com',     'worker',           1,  'kandy',    'Timber Worker',          'labour'],
        ['customer@demo.com',        'sample_customer',  0,  'colombo',  'Retail Customer',        'none'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        $this->db->db_debug = FALSE;
    }

    // ─────────────────────────────────────────────────
    // INDEX - Show credential table
    // ─────────────────────────────────────────────────
    public function index()
    {
        $this->_html_header('Timber Pro — Sample Data Manager');
        
        // Check if sample data exists
        $locs = $this->db->where_in('cname', ['Colombo Branch', 'Kandy Branch', 'Galle Branch'])
                         ->get('geopos_locations')->result_array();
        $users = $this->db->where_in('email', array_column($this->sample_users, 0))
                          ->get('geopos_users')->result_array();

        echo '<div class="tpro-card">';
        echo '<h2>📍 Sample Location Status</h2>';
        if (empty($locs)) {
            echo '<p class="warn">⚠️ No sample locations installed. <a href="' . base_url('sample_data/install') . '" class="btn">▶ Install Sample Data</a></p>';
        } else {
            echo '<table><tr><th>ID</th><th>Location</th><th>City</th><th>Province</th></tr>';
            foreach ($locs as $l) {
                echo "<tr><td>{$l['id']}</td><td>{$l['cname']}</td><td>{$l['city']}</td><td>{$l['region']}</td></tr>";
            }
            echo '</table>';
        }
        echo '</div>';

        echo '<div class="tpro-card">';
        echo '<h2>👥 Sample Account Status</h2>';
        if (empty($users)) {
            echo '<p class="warn">⚠️ No sample accounts found.</p>';
        } else {
            echo '<p class="ok">✅ ' . count($users) . ' sample accounts installed. All use password: <code>' . self::DEMO_PASSWORD . '</code></p>';
            echo '<table><tr><th>Role</th><th>Username</th><th>Email</th><th>Role ID</th><th>Location</th></tr>';
            foreach ($users as $u) {
                $loc_name = 'Global';
                if ($u['loc'] > 0) {
                    $loc_row = $this->db->get_where('geopos_locations', ['id' => $u['loc']])->row();
                    $loc_name = $loc_row ? $loc_row->cname : 'ID:'.$u['loc'];
                }
                foreach ($this->sample_users as $su) {
                    if ($su[0] == $u['email']) { $role_label = $su[4]; break; }
                }
                echo "<tr><td>{$role_label}</td><td><strong>{$u['username']}</strong></td><td>{$u['email']}</td><td>{$u['roleid']}</td><td>{$loc_name}</td></tr>";
            }
            echo '</table>';
        }
        echo '</div>';

        echo '<div class="actions">';
        echo '<a href="' . base_url('sample_data/install') . '" class="btn">▶ Install / Reinstall</a> ';
        echo '<a href="' . base_url('sample_data/reset') . '" class="btn danger" onclick="return confirm(\'Remove all sample accounts and locations?\')">🗑 Reset Sample Data</a> ';
        echo '<a href="' . base_url('user') . '" class="btn secondary">← Login Page</a>';
        echo '</div>';

        $this->_html_footer();
    }

    // ─────────────────────────────────────────────────
    // INSTALL - Seed all sample data
    // ─────────────────────────────────────────────────
    public function install()
    {
        set_time_limit(300);
        $this->_html_header('Installing Timber Pro Sample Data...');
        echo '<div class="tpro-card">';
        echo '<h2>🚀 Installing Sample Data</h2><ul class="log">';

        // Step 1: Locations
        $loc_ids = $this->_seed_locations();

        // Step 2: Warehouses for each location
        foreach ($loc_ids as $key => $loc_id) {
            $this->_seed_warehouse($loc_id, $key);
        }

        // Step 3: Users
        $this->_seed_users($loc_ids);

        // Step 4: Basic products per location
        foreach ($loc_ids as $key => $loc_id) {
            $wh = $this->db->get_where('geopos_warehouse', ['loc' => $loc_id])->row();
            $wh_id = $wh ? $wh->id : 1;
            $this->_seed_products($wh_id, $loc_id);
        }

        // Step 5: Seed customers per location
        foreach ($loc_ids as $key => $loc_id) {
            $this->_seed_customers($loc_id);
        }

        // Step 6: Seed Timber Lots (Logs, Sawn, Slabs)
        foreach ($loc_ids as $key => $loc_id) {
            $this->_seed_timber_lots($loc_id);
        }

        // Step 7: Seed Fleet & Dispatches
        foreach ($loc_ids as $key => $loc_id) {
            $this->_seed_fleet($loc_id);
            $this->_seed_transport_orders($loc_id);
        }

        echo '</ul></div>';
        echo '<div class="tpro-card">';
        echo '<h2>✅ Installation Complete!</h2>';
        echo '<p>All sample data has been created. Password for ALL accounts: <code class="pw">' . self::DEMO_PASSWORD . '</code></p>';

        // Summary table
        echo '<h3>🔑 Login Credentials</h3>';
        echo '<table>';
        echo '<tr><th>Role</th><th>Username</th><th>Email</th><th>Password</th><th>Location</th><th>Access Level</th></tr>';

        $role_map = [
            9 => 'Full System (Owner)', 
            8 => 'Operational Strategy (GM)', 
            7 => 'Finance & Audit', 
            6 => 'Commercial/Sales', 
            5 => 'Stock/Warehouse', 
            4 => 'Production Control', 
            3 => 'Transport/Logistics', 
            2 => 'Front Desk/POS', 
            1 => 'Floor Worker', 
            0 => 'Customer Portal'
        ];
        
        foreach ($this->sample_users as $su) {
            list($email, $username, $roleid, $loc_key, $label) = $su;
            $loc_name = $loc_key === 'global' ? 'All Locations' : ucfirst($loc_key) . ' Sawmill';
            $access = $role_map[$roleid] ?? 'Limited';
            $role_color = [
                '9' => '#002366', '8' => '#1e3a8a', '7' => '#1e40af', '6' => '#1d4ed8', 
                '5' => '#2563eb', '4' => '#3b82f6', '3' => '#60a5fa', '2' => '#93c5fd', 
                '1' => '#bfdbfe', '0' => '#795548'
            ];
            $clr = $role_color[$roleid] ?? '#64748b';
            echo "<tr>
                <td><span class='role-badge' style='background:{$clr}'>{$label}</span></td>
                <td><strong>{$username}</strong></td>
                <td>{$email}</td>
                <td><code>" . self::DEMO_PASSWORD . "</code></td>
                <td>{$loc_name}</td>
                <td>{$access}</td>
            </tr>";
        }
        echo '</table>';
        echo '</div>';
        echo '<div class="actions"><a href="' . base_url('user') . '" class="btn">→ Go to Login</a> <a href="' . base_url('sample_data') . '" class="btn secondary">← Back</a></div>';
        $this->_html_footer();
    }

    // ─────────────────────────────────────────────────
    // RESET - Remove all sample data
    // ─────────────────────────────────────────────────
    public function reset()
    {
        $this->db->db_debug = FALSE;
        $emails = array_column($this->sample_users, 0);
        
        // Get user IDs first
        $user_ids = array_column(
            $this->db->where_in('email', $emails)->get('geopos_users')->result_array(),
            'id'
        );
        
        if (!empty($user_ids)) {
            // Delete employee records
            $this->db->where_in('id', $user_ids)->delete('geopos_employees');
            // Delete users
            $this->db->where_in('email', $emails)->delete('geopos_users');
        }

        // Get location IDs
        $loc_names = ['Colombo Branch', 'Kandy Branch', 'Galle Branch'];
        $locs = $this->db->where_in('cname', $loc_names)->get('geopos_locations')->result_array();
        $loc_ids = array_column($locs, 'id');

        if (!empty($loc_ids)) {
            // Delete warehouses
            $this->db->where_in('loc', $loc_ids)->delete('geopos_warehouse');
            // Delete sample customers
            $this->db->where_in('loc', $loc_ids)
                     ->where('name', 'Walk In Client - Sample')
                     ->delete('geopos_customers');
            // Delete locations
            $this->db->where_in('id', $loc_ids)->delete('geopos_locations');
        }

        redirect('sample_data');
    }

    // ─────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────

    private function _seed_locations()
    {
        $locations = [
            'colombo' => [
                'cname'   => 'Colombo Sawmill & HQ',
                'address' => '142, Baseline Road, Maradana',
                'city'    => 'Colombo',
                'region'  => 'Western Province',
                'country' => 'Sri Lanka',
                'postbox' => '00800',
                'phone'   => '0112345678',
                'email'   => 'colombo@timberpro.lk',
                'taxid'   => 'VAT-COL-001',
                'logo'    => 'logo.png',
                'cur'     => 0,
                'gps_lat' => '6.927100',
                'gps_lng' => '79.861200'
            ],
            'kandy'   => [
                'cname'   => 'Kandy Processing Mill',
                'address' => '56, Peradeniya Road, Kandy',
                'city'    => 'Kandy',
                'region'  => 'Central Province',
                'country' => 'Sri Lanka',
                'postbox' => '20000',
                'phone'   => '0812345678',
                'email'   => 'kandy@timberpro.lk',
                'taxid'   => 'VAT-KDY-002',
                'logo'    => 'logo.png',
                'cur'     => 0,
                'gps_lat' => '7.290600',
                'gps_lng' => '80.633700'
            ],
            'galle'   => [
                'cname'   => 'Galle Logistics Hub',
                'address' => '12, Church Cross Street, Galle Fort',
                'city'    => 'Galle',
                'region'  => 'Southern Province',
                'country' => 'Sri Lanka',
                'postbox' => '80000',
                'phone'   => '0912345678',
                'email'   => 'galle@timberpro.lk',
                'taxid'   => 'VAT-GLL-003',
                'logo'    => 'logo.png',
                'cur'     => 0,
                'gps_lat' => '6.036700',
                'gps_lng' => '80.217000'
            ],
        ];

        $loc_ids = [];
        foreach ($locations as $key => $data) {
            // Check if already exists
            $existing = $this->db->get_where('geopos_locations', ['cname' => $data['cname']])->row();
            if ($existing) {
                $loc_ids[$key] = $existing->id;
                echo "<li>📍 Location already exists: <strong>{$data['cname']}</strong> (ID: {$existing->id})</li>";
            } else {
                $this->db->insert('geopos_locations', $data);
                $loc_ids[$key] = $this->db->insert_id();
                echo "<li>✅ Created location: <strong>{$data['cname']}</strong> (ID: {$loc_ids[$key]})</li>";
            }
        }
        return $loc_ids;
    }

    private function _seed_warehouse($loc_id, $loc_key)
    {
        $names = ['colombo' => 'Colombo Main Warehouse', 'kandy' => 'Kandy Warehouse', 'galle' => 'Galle Warehouse'];
        $name = $names[$loc_key] ?? 'Warehouse';
        $existing = $this->db->get_where('geopos_warehouse', ['loc' => $loc_id])->row();
        if (!$existing) {
            $this->db->insert('geopos_warehouse', ['title' => $name, 'loc' => $loc_id]);
            echo "<li>✅ Created warehouse: <strong>{$name}</strong></li>";
        } else {
            echo "<li>📦 Warehouse already exists for location ID {$loc_id}</li>";
        }
    }

    private function _seed_users(array $loc_ids)
    {
        foreach ($this->sample_users as $su) {
            list($email, $username, $roleid, $loc_key, $label, $provider_type) = $su;
            $loc_id = ($loc_key === 'global') ? 0 : ($loc_ids[$loc_key] ?? 0);

            // Check if user exists
            $existing = $this->db->get_where('geopos_users', ['email' => $email])->row();
            if ($existing) {
                // Update existing record
                $this->db->where('id', $existing->id)
                         ->update('geopos_users', ['roleid' => $roleid, 'loc' => $loc_id, 'banned' => 0, 'provider_type' => $provider_type]);
                $uid = $existing->id;
                echo "<li>🔄 Updated user: <strong>{$username}</strong> ({$label})</li>";
            } else {
                // Create user via Aauth
                $uid = $this->aauth->create_user($email, self::DEMO_PASSWORD, $username);
                if ($uid) {
                    // Update roleid, loc, provider_type
                    $this->db->where('id', $uid)->update('geopos_users', ['roleid' => $roleid, 'loc' => $loc_id, 'picture' => 'example.png', 'provider_type' => $provider_type]);
                    echo "<li>✅ Created user: <strong>{$username}</strong> ({$label}) → Loc: {$loc_id}, Role: {$roleid}</li>";
                } else {
                    // Fallback: direct insert with pre-hashed password
                    // SHA-256(password + user_id) — we'll do a temp insert first, then hash properly
                    $data = [
                        'email'        => $email,
                        'pass'         => hash('sha256', self::DEMO_PASSWORD . '0'), // placeholder
                        'username'     => $username,
                        'banned'       => 0,
                        'roleid'       => $roleid,
                        'loc'          => $loc_id,
                        'picture'      => 'example.png',
                        'date_created' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('geopos_users', $data);
                    $uid = $this->db->insert_id();
                    // Re-hash with real user_id
                    $correct_hash = hash('sha256', self::DEMO_PASSWORD . $uid);
                    $this->db->where('id', $uid)->update('geopos_users', ['pass' => $correct_hash]);
                    echo "<li>✅ Created user (direct): <strong>{$username}</strong> ({$label})</li>";
                }
            }

            // Ensure employee record exists
            $this->_ensure_employee($uid, $username, $label, $loc_id);
        }
    }

    private function _ensure_employee($uid, $username, $role_label, $loc_id)
    {
        $existing_emp = $this->db->get_where('geopos_employees', ['id' => $uid])->row();
        if (!$existing_emp) {
            $role_titles = [
                'superadmin'  => 'Super Administrator',
                'owner'       => 'Business Owner',
                'mgr_colombo' => 'Location Manager',
                'mgr_kandy'   => 'Location Manager',
                'storekeeper' => 'Store Keeper',
                'cashier'     => 'Cashier',
                'accountant'  => 'Accountant',
                'customer'    => 'Customer',
                'servicepro'  => 'Service Provider',
            ];
            $this->db->insert('geopos_employees', [
                'id'          => $uid,
                'username'    => $username,
                'name'        => $role_titles[$username] ?? $role_label,
                'address'     => 'Sample Address, Sri Lanka',
                'city'        => 'Colombo',
                'region'      => 'Western Province',
                'country'     => 'Sri Lanka',
                'dept'        => 1,
                'clock'       => 0,
                'salary'      => 0.00,
                'hourly_rate' => 0.00,
                'picture'     => 'example.png',
            ]);
        }
    }

    private function _seed_products($wh_id, $loc_id)
    {
        $products = [
            ['Teak Wood Plank (Grade A)',    'TW-TEAK-A-',  15000, 13000,  9500, 25],
            ['Rubber Wood Plank',             'TW-RUBR-B-',   6500,  5800,  3800, 60],
            ['Jak Wood Slab',                 'TW-JAK-C-',    8500,  7500,  5200, 40],
            ['Mahogany Beam',                 'TW-MAH-D-',   22000, 20000, 14000, 15],
            ['Pine Timber (Imported)',        'TW-PINE-E-',   9000,  8000,  5500, 30],
        ];

        foreach ($products as $p) {
            $code = $p[1] . $loc_id;
            $existing = $this->db->get_where('geopos_products', ['product_code' => $code])->row();
            if (!$existing) {
                $this->db->insert('geopos_products', [
                    'product_name'   => $p[0],
                    'product_code'   => $code,
                    'product_price'  => $p[2],
                    'fproduct_price' => $p[3],
                    'fproduct_cost'  => $p[4],
                    'qty'            => $p[5],
                    'qty2'           => $p[5],
                    'product_des'    => 'Sample timber product - ' . $p[0],
                    'warehouse'      => $wh_id,
                    'pcat'           => 1,
                    'merge'          => 0,
                    'sub'            => 0,
                    'vb'             => 0,
                    'wastage'        => 0,
                    'pthickness'     => 0,
                    'pquick'         => 0,
                    'sqft'           => 0,
                ]);
            }
        }
        echo "<li>✅ Seeded 5 timber products for location ID: {$loc_id}</li>";
    }

    private function _seed_customers($loc_id)
    {
        $customers = [
            ['Silva Constructions (Pvt) Ltd', '0112233445', 'Colombo 05', 'Western Province'],
            ['Perera Wood Works',              '0712233445', 'Kandy City', 'Central Province'],
            ['Galle Timber Traders',           '0912233445', 'Galle Fort', 'Southern Province'],
            ['Walk In Client',                 NULL,         NULL,         NULL],
        ];

        foreach ($customers as $c) {
            $existing = $this->db->get_where('geopos_customers', ['name' => $c[0], 'loc' => $loc_id])->row();
            if (!$existing) {
                $this->db->insert('geopos_customers', [
                    'name'    => $c[0],
                    'phone'   => $c[1],
                    'city'    => $c[2],
                    'region'  => $c[3],
                    'address' => $c[2],
                    'country' => 'Sri Lanka',
                    'loc'     => $loc_id,
                    'picture' => 'example.png',
                    'gid'     => 1,
                ]);
            }
        }
        echo "<li>✅ Seeded customers for location ID: {$loc_id}</li>";
    }

    private function _seed_timber_lots($loc_id)
    {
        // 1. Seed Logs
        $log_lots = [
            ['Teak Log (Large)', 'Teak', 'Ratnapura', 10, 85.5],
            ['Mahogany Log (Extra)', 'Mahogany', 'Matale', 5, 42.2],
            ['Rubber Log (Standard)', 'Rubber', 'Kalutara', 20, 110.0],
        ];

        foreach ($log_lots as $l) {
            $lot_name = $l[0] . ' - L' . $loc_id;
            $existing = $this->db->get_where('geopos_timber_logs', ['lot_name' => $lot_name, 'loc' => $loc_id])->row();
            if (!$existing) {
                $this->db->insert('geopos_timber_logs', [
                    'lot_name' => $lot_name,
                    'species' => $l[1],
                    'supplier_id' => 1,
                    'district' => $l[2],
                    'loc' => $loc_id,
                    'pieces' => $l[3],
                    'volume_cf' => $l[4],
                    'status' => 'available',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // 2. Seed Sawn Timber
        $sawn_lots = [
            ['Teak Planks 2x4', 'Teak', 100, 15.5],
            ['Mahogany Beams 4x4', 'Mahogany', 50, 22.0],
        ];

        foreach ($sawn_lots as $s) {
            $lot_name = $s[0] . ' - S' . $loc_id;
            $existing = $this->db->get_where('geopos_timber_sawn', ['lot_name' => $lot_name, 'loc' => $loc_id])->row();
            if (!$existing) {
                $this->db->insert('geopos_timber_sawn', [
                    'lot_name' => $lot_name,
                    'species' => $s[1],
                    'log_lot_id' => 1,
                    'pieces' => $s[2],
                    'volume_cf' => $s[3],
                    'loc' => $loc_id,
                    'status' => 'available',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // 3. Seed Slabs
        $existing_slabs = $this->db->get_where('geopos_timber_byproducts', ['loc' => $loc_id])->row();
        if (!$existing_slabs) {
            $this->db->insert('geopos_timber_byproducts', [
                'job_id' => 1,
                'lot_name' => 'Sample Slabs - L' . $loc_id,
                'pieces' => 20,
                'volume_cf' => 12.5,
                'loc' => $loc_id,
                'type' => 'slab',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        echo "<li>🪵 Seeded Timber Inventory (Logs/Sawn/Slabs) for location ID: {$loc_id}</li>";
    }

    private function _seed_fleet($loc_id)
    {
        $fleet = [
            ['WP-LB-1234', 'Prime Mover', 'Sumith Perera', '0771234567', 15.0],
            ['CP-GA-5678', 'Small Lorry', 'Nimal Silva', '0779876543', 3.5],
        ];

        foreach ($fleet as $v) {
            $existing = $this->db->get_where('geopos_logistics_fleet', ['vehicle_no' => $v[0], 'loc' => $loc_id])->row();
            if (!$existing) {
                $this->db->insert('geopos_logistics_fleet', [
                    'vehicle_no' => $v[0],
                    'vehicle_type' => $v[1],
                    'driver_name' => $v[2],
                    'driver_phone' => $v[3],
                    'capacity_tons' => $v[4],
                    'status' => 'available',
                    'loc' => $loc_id
                ]);
            }
        }
        echo "<li>🚛 Seeded Fleet for location ID: {$loc_id}</li>";
    }

    private function _seed_transport_orders($loc_id)
    {
        $orders = [
            ['Dispatch - Logs to Mill', 'Log Purchase #101', 'Forest Site A', 'Colombo Sawmill', 'pending'],
            ['Delivery - Sawn to Client', 'Invoice #202', 'Colombo Sawmill', 'Silva Const. site', 'dispatched'],
        ];

        foreach ($orders as $o) {
            $existing = $this->db->get_where('geopos_logistics_orders', ['order_ref' => $o[1], 'loc' => $loc_id])->row();
            if (!$existing) {
                $this->db->insert('geopos_logistics_orders', [
                    'order_title' => $o[0],
                    'order_ref' => $o[1],
                    'pickup_loc' => $o[2],
                    'delivery_loc' => $o[3],
                    'vehicle_id' => 1,
                    'status' => $o[4],
                    'created_at' => date('Y-m-d H:i:s'),
                    'loc' => $loc_id
                ]);
            }
        }
        echo "<li>📅 Seeded Transport Orders for location ID: {$loc_id}</li>";
    }

    // ─────────────────────────────────────────────────
    // HTML HELPERS
    // ─────────────────────────────────────────────────

    private function _html_header($title = 'Timber Pro Sample Data')
    {
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>' . $title . '</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root { --blue: #002366; --green: #4CAF50; --dark: #0f172a; --light: #f8fafc; }
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: Inter, sans-serif; background: var(--dark); color: var(--light); min-height: 100vh; padding: 2rem; }
            h1 { font-size: 1.8rem; font-weight: 700; color: var(--green); margin-bottom: 0.5rem; }
            h1 span { color: #888; font-size: 1rem; font-weight: 400; }
            h2 { font-size: 1.1rem; font-weight: 600; color: #60a5fa; margin-bottom: 1rem; }
            h3 { font-size: 1rem; font-weight: 600; color: var(--green); margin: 1.5rem 0 0.8rem; }
            .tpro-card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; }
            table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
            th { background: rgba(255,255,255,0.06); padding: 10px 14px; text-align: left; font-weight: 600; color: #94a3b8; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
            td { padding: 10px 14px; border-bottom: 1px solid rgba(255,255,255,0.05); }
            tr:last-child td { border-bottom: none; }
            tr:hover td { background: rgba(255,255,255,0.03); }
            code { background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px; font-family: monospace; color: #fde68a; }
            code.pw { font-size: 1.1rem; padding: 4px 12px; background: rgba(76,175,80,0.2); color: #4CAF50; }
            .btn { display: inline-block; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s; background: var(--blue); color: white; border: none; }
            .btn:hover { opacity: 0.85; transform: translateY(-1px); }
            .btn.danger { background: #dc2626; }
            .btn.secondary { background: rgba(255,255,255,0.1); }
            .actions { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem; }
            .warn { color: #fbbf24; margin-bottom: 1rem; }
            .ok { color: #4ade80; margin-bottom: 1rem; }
            ul.log { list-style: none; padding: 0; font-size: 0.875rem; line-height: 2; }
            ul.log li { padding: 4px 0; border-bottom: 1px solid rgba(255,255,255,0.04); }
            .role-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: white; }
            header { margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; gap: 1rem; }
            .logo-mark { font-size: 2rem; }
        </style>
        </head><body>
        <header>
            <div class="logo-mark">🌲</div>
            <div><h1>' . $title . ' <span>Timber Pro ERP</span></h1>
            <p style="color:#64748b;font-size:0.8rem;">This page is for development/demo use only. Do not expose in production.</p></div>
        </header>';
    }

    private function _html_footer()
    {
        echo '</body></html>';
    }
}
