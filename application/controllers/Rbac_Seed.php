<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rbac_Seed extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("Aauth");
    }

    public function index() {
        echo "<pre>";
        echo "Starting RBAC Seeding...\n";

        $data = [
            'Sales' => [
                'icon' => 'fa-shopping-cart',
                'pages' => [
                    'Manage Invoices' => 'invoices',
                    'New Invoice' => 'invoices/create',
                    'Manage POS Invoices' => 'pos_invoices',
                    'New POS Invoice' => 'pos_invoices/create',
                    'Manage Quotes' => 'quotes',
                    'New Quote' => 'quotes/create',
                    'Sales Reports' => 'reports/sales'
                ]
            ],
            'Stock' => [
                'icon' => 'fa-cubes',
                'pages' => [
                    'Manage Products' => 'products',
                    'Add Product' => 'products/add',
                    'Stock Transfer' => 'products/stock_transfer',
                    'Product Categories' => 'productcategory',
                    'Warehouses' => 'productcategory/warehouse',
                    'Stock Reports' => 'reports/stock'
                ]
            ],
            'CRM' => [
                'icon' => 'fa-users',
                'pages' => [
                    'Manage Customers' => 'customers',
                    'Add Customer' => 'customers/create',
                    'Client Groups' => 'clientgroup',
                    'Support Tickets' => 'tickets',
                    'Customer Reports' => 'reports/customer'
                ]
            ],
            'Project Management' => [
                'icon' => 'fa-tasks',
                'pages' => [
                    'Manage Projects' => 'projects',
                    'Add Project' => 'projects/addproject',
                    'Tasks' => 'tasks'
                ]
            ],
            'Accounts' => [
                'icon' => 'fa-bank',
                'pages' => [
                    'Manage Accounts' => 'accounts',
                    'Ledger / Transactions' => 'transactions',
                    'Add Transaction' => 'transactions/add',
                    'Transfer' => 'transactions/transfer',
                    'Profit & Loss' => 'financial/profit_loss',
                    'Balance Sheet' => 'financial/balance_sheet'
                ]
            ],
            'Data & Reports' => [
                'icon' => 'fa-bar-chart',
                'pages' => [
                    'System Reports' => 'reports',
                    'Data Export' => 'export/crm',
                    'Database Backup' => 'export/dbexport',
                    'Activity Log' => 'settings/logdata'
                ]
            ],
            'Project Worker' => [
                'icon' => 'fa-wrench',
                'pages' => [
                    'Active Rings' => 'ring',
                    'Worker Portfolios' => 'worker/portfolios',
                    'SOS Monitor' => 'sos',
                    'Job Requests' => 'worker/job_requests'
                ]
            ],
            'Services' => [
                'icon' => 'fa-magic',
                'pages' => [
                    'Manage Services' => 'services',
                    'AI Video Showcase' => 'marketing/ai_videos',
                    'Marketing Campaigns' => 'marketing/campaigns'
                ]
            ],
            'HRM' => [
                'icon' => 'fa-user',
                'pages' => [
                    'Manage Employees' => 'employee',
                    'Add Employee' => 'employee/add',
                    'Roles & Permissions' => 'employee/roles',
                    'Payroll' => 'payroll',
                    'Attendance' => 'employee/attendance'
                ]
            ],
            'Settings' => [
                'icon' => 'fa-cogs',
                'pages' => [
                    'Global Settings' => 'settings',
                    'Branch Management' => 'locations',
                    'Payment Settings' => 'paymentgateways',
                    'Tax Settings' => 'settings/tax',
                    'Email Templates' => 'templates/email'
                ]
            ]
        ];

        foreach ($data as $module_title => $m_info) {
            $m_code = url_title(strtolower($module_title), '_', TRUE);
            
            // Upsert Module
            $q = $this->db->get_where('rbac_modules', ['code' => $m_code]);
            if ($q->num_rows() == 0) {
                $this->db->insert('rbac_modules', [
                    'title' => $module_title,
                    'code' => $m_code,
                    'icon' => $m_info['icon']
                ]);
                $module_id = $this->db->insert_id();
            } else {
                $module_id = $q->row()->id;
            }

            foreach ($m_info['pages'] as $page_title => $page_url) {
                $p_code = url_title(strtolower($page_title), '_', TRUE);
                
                // Upsert Page
                $qp = $this->db->get_where('rbac_pages', ['code' => $p_code]);
                if ($qp->num_rows() == 0) {
                    $this->db->insert('rbac_pages', [
                        'module_id' => $module_id,
                        'title' => $page_title,
                        'code' => $p_code,
                        'url' => $page_url
                    ]);
                    $page_id = $this->db->insert_id();
                } else {
                    $page_id = $qp->row()->id;
                }

                // Create default Permissions for this page (View, Add, Edit, Delete)
                $actions = $this->db->get('rbac_actions')->result_array();
                foreach ($actions as $action) {
                    $perm_key = $p_code . '_' . $action['code'];
                    $qe = $this->db->get_where('rbac_permissions', ['perm_key' => $perm_key]);
                    if ($qe->num_rows() == 0) {
                        $this->db->insert('rbac_permissions', [
                            'page_id' => $page_id,
                            'action_id' => $action['id'],
                            'perm_key' => $perm_key
                        ]);
                    }
                }
            }
        }

        echo "Seeding Finished!\n";
        echo "</pre>";
    }
}
