<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_health_model extends CI_Model
{
    /**
     * Super Admin - Financial Integrity Check
     * Validates if sum(debit) == sum(credit) across all transactions
     */
    public function get_financial_mismatch()
    {
        $this->db->select('SUM(debit) as total_debit, SUM(credit) as total_credit');
        $this->db->from('geopos_transactions');
        $query = $this->db->get()->row_array();
        
        $debit = $query['total_debit'] ?: 0;
        $credit = $query['total_credit'] ?: 0;
        $diff = round($debit - $credit, 2);
        
        return [
            'total_debit' => $debit,
            'total_credit' => $credit,
            'mismatch' => $diff,
            'status' => ($diff == 0) ? 'Healthy' : 'Error'
        ];
    }

    /**
     * Business Owner - Cash Flow & Liquidity
     */
    public function get_liquidity_health($business_id = 0)
    {
        $this->db->select_sum('lastbal');
        $this->db->from('geopos_accounts');
        if ($business_id > 0) {
            $this->db->where('loc', $business_id); // Assuming business_id maps to loc 0/1/etc for now
        }
        $query = $this->db->get()->row_array();
        return $query['lastbal'] ?: 0;
    }

    /**
     * Inventory Alerts - Count of items below alert level
     */
    public function get_inventory_alerts($loc = 0)
    {
        $this->db->from('geopos_products');
        $this->db->where('qty <= alert');
        if ($loc > 0) {
            // Need to join with warehouse to filter by loc
            $this->db->join('geopos_warehouse', 'geopos_products.warehouse = geopos_warehouse.id');
            $this->db->where('geopos_warehouse.loc', $loc);
        }
        $amber = $this->db->where('qty > 0')->count_all_results('', FALSE);
        $red = $this->db->where('qty <= 0')->count_all_results('', FALSE);
        
        return ['amber' => $amber, 'red' => $red];
    }

    /**
     * Project Health - Budget Overruns
     */
    public function get_project_overruns($loc = 0)
    {
        $this->db->select('id, name, worth as budget');
        $this->db->from('geopos_projects');
        if ($loc > 0) $this->db->where('loc', $loc);
        $projects = $this->db->get()->result_array();
        
        $overruns = [];
        foreach ($projects as $p) {
            $this->db->select_sum('debit');
            $this->db->where('project_id', $p['id']);
            $this->db->where('type', 'Expense');
            $exp = $this->db->get('geopos_transactions')->row()->debit ?: 0;
            
            if ($p['budget'] > 0 && $exp > $p['budget']) {
                $p['expense'] = $exp;
                $p['excess'] = $exp - $p['budget'];
                $overruns[] = $p;
            }
        }
        return $overruns;
    }

    /**
     * System Performance Metrics
     */
    public function get_performance_stats()
    {
        // DB Size
        $db_name = $this->db->database;
        $query = $this->db->query("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size FROM information_schema.TABLES WHERE table_schema = '$db_name'");
        $db_size = $query->row()->size ?: 'N/A';

        // API Errors (from geopos_system_insights or risk_alerts)
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-24 hours')));
        $this->db->where('type', 'API_ERROR');
        $api_errors = $this->db->count_all_results('geopos_system_insights');

        // Risk Alerts High Severity
        $this->db->where('severity', 'High');
        $this->db->where('status', 'New');
        $risk_count = $this->db->count_all_results('geopos_risk_alerts');

        return [
            'db_size' => $db_size . ' MB',
            'api_errors_24h' => $api_errors,
            'risk_alerts' => $risk_count,
            'server_load' => function_exists('sys_getloadavg') ? (sys_getloadavg()[0] ?? '0.05') : '0.05',
            'revid_ai_status' => 'Online'
        ];
    }
}
