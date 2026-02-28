<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Api_base.php';

/**
 * Dashboard Real-time Stats API + Audit Trail API + Market Trends API
 *
 * GET  /api/dashboard/stats         - Real-time KPI summary
 * GET  /api/dashboard/charts        - Chart data (sales trend, stock, workers)
 * GET  /api/dashboard/timber_kpis   - Timber-specific KPIs
 *
 * GET  /api/audit/logs              - Audit trail with filters
 * GET  /api/audit/summary           - Audit summary stats
 *
 * GET  /api/market/trends           - Price trends by species/region
 * POST /api/market/record_price     - Record a new market price
 * GET  /api/market/species_prices   - Current prices for all species
 */
class Dashboard extends Api_base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model', 'dash');
        $this->load->model('Intelligence_model', 'intel');
        $this->load->model('Audit_model', 'audit');
        $this->_ensure_market_table();
    }

    private function _ensure_market_table(): void
    {
        if (!$this->db->table_exists('market_price_tracker')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `market_price_tracker` (
                  `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `species`       VARCHAR(100) NOT NULL,
                  `grade`         VARCHAR(50)  DEFAULT 'Standard',
                  `unit`          ENUM('cubic_ft','sq_ft','running_ft') DEFAULT 'cubic_ft',
                  `price_per_unit` DECIMAL(12,2) NOT NULL,
                  `location`      VARCHAR(100)  DEFAULT NULL,
                  `district`      VARCHAR(100)  DEFAULT NULL,
                  `recorded_by`   INT UNSIGNED  DEFAULT 0,
                  `recorded_at`   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  INDEX(`species`),
                  INDEX(`recorded_at`),
                  INDEX(`district`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }
    }

    /* ==============================================================
     *  DASHBOARD REAL-TIME STATS
     * ============================================================== */

    /**
     * GET /api/dashboard/stats
     * ?branch_id=0&start_date=Y-m-d&end_date=Y-m-d
     * Returns KPI summary for mobile/frontend dashboard
     */
    public function stats_get()
    {
        if (!$this->_authenticate()) return;

        $branch_id  = (int)($this->get('branch_id') ?: 0);
        $start_date = $this->get('start_date') ?: date('Y-m-01');
        $end_date   = $this->get('end_date')   ?: date('Y-m-d');
        $dash_loc   = ($branch_id == 0) ? -1 : $branch_id;

        $today_str = date('Y-m-d');
        $month     = date('m');
        $year      = date('Y');

        // Core financial KPIs
        $sales     = $this->dash->rangeSales($start_date, $end_date, $dash_loc);
        $income    = $this->dash->rangeInvoice($start_date, $end_date, $dash_loc);
        $expense   = $this->dash->rangeInexp($start_date, $end_date, $dash_loc);
        $profit    = $this->intel->get_dual_entry_profit($dash_loc, $start_date, $end_date);
        $cash      = $this->intel->get_total_cash_in_hand($dash_loc);
        $bank      = $this->intel->get_total_bank_balance($dash_loc);

        // Timber-specific KPIs
        $timber_stats = $this->_get_timber_kpis($branch_id);

        // Worker KPIs
        $worker_stats = $this->_get_worker_kpis();

        // Marketplace KPIs
        $market_stats = $this->_get_market_kpis($branch_id, $start_date, $end_date);

        $this->_success([
            'period'   => ['start' => $start_date, 'end' => $end_date],
            'branch'   => $branch_id,
            'finance'  => [
                'total_sales'   => (float)$sales,
                'total_income'  => (float)$income,
                'total_expense' => (float)$expense,
                'net_profit'    => (float)$profit,
                'cash_in_hand'  => (float)$cash,
                'bank_balance'  => (float)$bank,
            ],
            'timber'  => $timber_stats,
            'workers' => $worker_stats,
            'market'  => $market_stats,
            'alerts'  => $this->_get_system_alerts($dash_loc),
        ], 'Dashboard stats loaded');
    }

    /**
     * GET /api/dashboard/charts
     * ?branch_id=&period=monthly|weekly|daily
     */
    public function charts_get()
    {
        if (!$this->_authenticate()) return;

        $branch_id = (int)($this->get('branch_id') ?: 0);
        $dash_loc  = ($branch_id == 0) ? -1 : $branch_id;
        $period    = $this->get('period') ?: 'monthly';

        $today  = date('Y-m-d');
        $month  = date('m');
        $year   = date('Y');

        // 6-month income vs expense trend
        $income_chart  = $this->dash->incomeChart($today, $month, $year, $dash_loc);
        $expense_chart = $this->dash->expenseChart($today, $month, $year, $dash_loc);
        $monthly_count = $this->dash->countmonthlyChart($dash_loc);

        // Timber listing trend (by month)
        $timber_trend = $this->_get_timber_monthly_trend();

        // Market price trend (top 5 species)
        $price_trends = $this->_get_price_trends_chart();

        // Stock levels donut
        $stock_levels = $this->_get_stock_donut($branch_id);

        $this->_success([
            'income_chart'   => $income_chart,
            'expense_chart'  => $expense_chart,
            'monthly_count'  => $monthly_count,
            'timber_trend'   => $timber_trend,
            'price_trends'   => $price_trends,
            'stock_levels'   => $stock_levels,
        ]);
    }

    /* ==============================================================
     *  AUDIT TRAIL API
     * ============================================================== */

    /**
     * GET /api/audit/logs
     * ?user_id=&action=&entity=&date_from=&date_to=&page=&per_page=
     */
    public function audit_logs_get()
    {
        if (!$this->_authenticate()) return;

        // Only admin (role >= 5) can see all logs
        if ($this->current_user['role'] < 5) {
            // Regular users only see their own
            $filters['user_id'] = $this->current_user_id;
        } else {
            $filters = [
                'user_id'   => $this->get('user_id') ?: null,
                'action'    => $this->get('action')   ?: null,
                'entity'    => $this->get('entity')   ?: null,
                'date_from' => $this->get('date_from') ?: null,
                'date_to'   => $this->get('date_to')   ?: null,
                'keyword'   => $this->get('keyword')   ?: null,
            ];
        }

        $page     = max(1, (int)($this->get('page') ?: 1));
        $per_page = min(100, (int)($this->get('per_page') ?: 25));
        $offset   = ($page - 1) * $per_page;

        $data  = $this->audit->get_logs($filters, $per_page, $offset);
        $total = $this->audit->count_logs($filters);

        $this->_paginated($data, $total, $page, $per_page);
    }

    /**
     * GET /api/audit/summary
     */
    public function audit_summary_get()
    {
        if (!$this->_authenticate()) return;
        if ($this->current_user['role'] < 5) {
            $this->_fail('Admin access required', 403);
            return;
        }
        $this->_success($this->audit->get_summary());
    }

    /* ==============================================================
     *  MARKET TRENDS API
     * ============================================================== */

    /**
     * POST /api/market/record_price
     * Body: { species, grade, unit, price_per_unit, location, district }
     */
    public function record_price_post()
    {
        if (!$this->_authenticate()) return;

        $species       = trim($this->post('species'));
        $price_per_unit= (float)$this->post('price_per_unit');
        $unit          = $this->post('unit') ?: 'cubic_ft';
        $grade         = $this->post('grade') ?: 'Standard';
        $location      = $this->post('location') ?: '';
        $district      = $this->post('district') ?: '';

        if (!$species || $price_per_unit <= 0) {
            $this->_fail('species and price_per_unit are required');
            return;
        }

        if (!in_array($unit, ['cubic_ft', 'sq_ft', 'running_ft'])) {
            $this->_fail('unit must be: cubic_ft, sq_ft, or running_ft');
            return;
        }

        $id = $this->db->insert('market_price_tracker', [
            'species'        => $species,
            'grade'          => $grade,
            'unit'           => $unit,
            'price_per_unit' => $price_per_unit,
            'location'       => $location,
            'district'       => $district,
            'recorded_by'    => $this->current_user_id,
            'recorded_at'    => date('Y-m-d H:i:s'),
        ]);

        $this->_log_action('RECORD_PRICE', 'market_price_tracker', $this->db->insert_id(), [
            'species' => $species, 'price' => $price_per_unit, 'unit' => $unit
        ]);

        $this->_success(['id' => $this->db->insert_id()], 'Price recorded', 201);
    }

    /**
     * GET /api/market/trends
     * ?species=Teak&district=Kandy&months=6
     */
    public function trends_get()
    {
        $species  = $this->get('species');
        $district = $this->get('district');
        $months   = max(1, min(24, (int)($this->get('months') ?: 6)));
        $unit     = $this->get('unit') ?: 'cubic_ft';

        $since = date('Y-m-d', strtotime("-{$months} months"));

        $this->db->select("
            species, grade, unit, district,
            DATE_FORMAT(recorded_at, '%Y-%m') as month,
            AVG(price_per_unit) as avg_price,
            MIN(price_per_unit) as min_price,
            MAX(price_per_unit) as max_price,
            COUNT(*) as sample_count
        ");
        $this->db->from('market_price_tracker');
        $this->db->where('recorded_at >=', $since);
        $this->db->where('unit', $unit);
        if ($species)  $this->db->where('species', $species);
        if ($district) $this->db->where('district', $district);
        $this->db->group_by(['species', 'unit', 'district', "DATE_FORMAT(recorded_at, '%Y-%m')"]);
        $this->db->order_by('recorded_at', 'ASC');
        $rows = $this->db->get()->result_array();

        // Structure for charting
        $chart_data = [];
        foreach ($rows as $r) {
            $key = $r['species'] . '|' . ($r['district'] ?: 'All');
            if (!isset($chart_data[$key])) {
                $chart_data[$key] = [
                    'species'   => $r['species'],
                    'district'  => $r['district'] ?: 'All Districts',
                    'unit'      => $r['unit'],
                    'data'      => [],
                ];
            }
            $chart_data[$key]['data'][] = [
                'month'     => $r['month'],
                'avg_price' => round((float)$r['avg_price'], 2),
                'min_price' => round((float)$r['min_price'], 2),
                'max_price' => round((float)$r['max_price'], 2),
                'samples'   => (int)$r['sample_count'],
            ];
        }

        $this->_success([
            'unit'        => $unit,
            'period_from' => $since,
            'period_to'   => date('Y-m-d'),
            'series'      => array_values($chart_data),
        ]);
    }

    /**
     * GET /api/market/species_prices
     * Latest price per species (current snapshot)
     */
    public function species_prices_get()
    {
        $unit     = $this->get('unit') ?: 'cubic_ft';
        $district = $this->get('district');

        $this->db->query("SET @rank = 0, @prev = ''");
        $this->db->from('market_price_tracker');
        $this->db->select('species, grade, unit, price_per_unit, district, recorded_at');
        $this->db->where('unit', $unit);
        if ($district) $this->db->where('district', $district);
        $this->db->group_by(['species', 'grade']);
        $this->db->order_by('species ASC, recorded_at DESC');
        $rows = $this->db->get()->result_array();

        // Get latest per species using subquery approach
        $this->db->select('t.species, t.grade, t.unit, t.price_per_unit, t.district, t.recorded_at');
        $this->db->from('market_price_tracker t');
        $this->db->join(
            '(SELECT species, grade, MAX(recorded_at) as latest FROM market_price_tracker GROUP BY species, grade) m',
            'm.species = t.species AND m.grade = t.grade AND m.latest = t.recorded_at'
        );
        $this->db->where('t.unit', $unit);
        if ($district) $this->db->where('t.district', $district);
        $this->db->order_by('t.species', 'ASC');
        $latest = $this->db->get()->result_array();

        $this->_success([
            'unit'    => $unit,
            'prices'  => $latest,
            'updated' => date('c'),
        ]);
    }

    /* ==============================================================
     *  Workers API  (quick list)
     * ============================================================== */

    /**
     * GET /api/workers/list
     * ?category=&location=&available_only=1
     */
    public function workers_get()
    {
        $this->load->model('Worker_model', 'worker');

        $category  = $this->get('category');
        $location  = $this->get('location');
        $available = $this->get('available_only') == '1';

        $this->db->select('wp.*, wc.name as category_name');
        $this->db->from('worker_profiles wp');
        $this->db->join('worker_categories wc', 'wc.id = wp.category_id', 'left');
        if ($category) $this->db->where('wp.category_id', $category);
        if ($location) $this->db->like('wp.location', $location);
        if ($available) $this->db->where('wp.availability_status', 'available');
        $this->db->where('wp.status', 'active');
        $this->db->order_by('wp.experience_years', 'DESC');
        $rows = $this->db->get()->result_array();

        // Remove private fields
        foreach ($rows as &$r) {
            unset($r['user_id']);
            $r['skills']       = json_decode($r['skills'] ?? '[]', true);
            $r['skill_badges'] = json_decode($r['skill_badges'] ?? '[]', true);
        }

        $this->_success($rows);
    }

    /* ==============================================================
     *  Private helper methods
     * ============================================================== */

    private function _get_timber_kpis(int $branch_id): array
    {
        $kpis = [
            'active_listings' => 0,
            'total_volume_cuft' => 0,
            'deals_this_month' => 0,
            'pending_permits' => 0,
        ];

        foreach (['timber_logs_lots', 'timber_sawn_lots', 'timber_standing_lots'] as $tbl) {
            if ($this->db->table_exists($tbl)) {
                $this->db->where('status', 'available');
                if ($branch_id > 0) $this->db->where('warehouse_id', $branch_id);
                $kpis['active_listings'] += (int)$this->db->count_all_results($tbl);

                $this->db->select('COALESCE(SUM(total_volume),0) as vol');
                $this->db->where('status', 'available');
                if ($branch_id > 0) $this->db->where('warehouse_id', $branch_id);
                $row = $this->db->get($tbl)->row_array();
                $kpis['total_volume_cuft'] += (float)($row['vol'] ?? 0);
            }
        }

        // Marketplace deals this month
        if ($this->db->table_exists('marketplace_bids')) {
            $this->db->where('status', 'completed');
            $this->db->where("DATE_FORMAT(created_at,'%Y-%m')", date('Y-m'));
            $kpis['deals_this_month'] = (int)$this->db->count_all_results('marketplace_bids');
        }

        // Pending permits
        if ($this->db->table_exists('timber_permits')) {
            $this->db->where('status', 'pending');
            $kpis['pending_permits'] = (int)$this->db->count_all_results('timber_permits');
        }

        $kpis['total_volume_cuft'] = round($kpis['total_volume_cuft'], 2);
        return $kpis;
    }

    private function _get_worker_kpis(): array
    {
        $kpis = ['total' => 0, 'available' => 0, 'busy' => 0, 'open_jobs' => 0];

        if ($this->db->table_exists('worker_profiles')) {
            $kpis['total']     = (int)$this->db->count_all('worker_profiles');
            $this->db->where('availability_status', 'available');
            $kpis['available'] = (int)$this->db->count_all_results('worker_profiles');
            $this->db->where('availability_status', 'busy');
            $kpis['busy']      = (int)$this->db->count_all_results('worker_profiles');
        }

        if ($this->db->table_exists('jobs')) {
            $this->db->where('status', 'open');
            $kpis['open_jobs'] = (int)$this->db->count_all_results('jobs');
        }

        return $kpis;
    }

    private function _get_market_kpis(int $branch_id, string $s_date, string $e_date): array
    {
        $kpis = ['active_bids' => 0, 'completed_deals' => 0, 'total_deal_value' => 0];

        if (!$this->db->table_exists('marketplace_bids')) return $kpis;

        $this->db->where('status', 'pending');
        $kpis['active_bids'] = (int)$this->db->count_all_results('marketplace_bids');

        $this->db->select('COUNT(*) as cnt, COALESCE(SUM(amount),0) as val');
        $this->db->where('status', 'completed');
        $this->db->where('DATE(created_at) >=', $s_date);
        $this->db->where('DATE(created_at) <=', $e_date);
        $row = $this->db->get('marketplace_bids')->row_array();
        $kpis['completed_deals']  = (int)   ($row['cnt'] ?? 0);
        $kpis['total_deal_value'] = (float)  ($row['val'] ?? 0);

        return $kpis;
    }

    private function _get_system_alerts(int $branch_id): array
    {
        $alerts = [];

        if ($this->db->table_exists('timber_permits')) {
            // Expiring permits (within 30 days)
            $this->db->where('status', 'verified');
            $this->db->where('expiry_date <=', date('Y-m-d', strtotime('+30 days')));
            $this->db->where('expiry_date >=', date('Y-m-d'));
            $expiring = (int)$this->db->count_all_results('timber_permits');
            if ($expiring > 0) {
                $alerts[] = ['type' => 'warning', 'message' => "$expiring permit(s) expiring within 30 days"];
            }

            $this->db->where('status', 'pending');
            $pending = (int)$this->db->count_all_results('timber_permits');
            if ($pending > 0) {
                $alerts[] = ['type' => 'info', 'message' => "$pending permit(s) awaiting verification"];
            }
        }

        return $alerts;
    }

    private function _get_timber_monthly_trend(): array
    {
        $trend = [];
        foreach (['timber_logs_lots', 'timber_sawn_lots'] as $tbl) {
            if (!$this->db->table_exists($tbl)) continue;
            $this->db->select("DATE_FORMAT(created_at,'%Y-%m') as month, COUNT(*) as count");
            $this->db->where("created_at >=", date('Y-m-01', strtotime('-5 months')));
            $this->db->group_by("DATE_FORMAT(created_at,'%Y-%m')");
            $this->db->order_by('month', 'ASC');
            $rows = $this->db->get($tbl)->result_array();
            foreach ($rows as $r) {
                $m = $r['month'];
                if (!isset($trend[$m])) $trend[$m] = 0;
                $trend[$m] += (int)$r['count'];
            }
        }
        $out = [];
        foreach ($trend as $month => $count) {
            $out[] = ['month' => $month, 'listings' => $count];
        }
        return $out;
    }

    private function _get_price_trends_chart(): array
    {
        if (!$this->db->table_exists('market_price_tracker')) return [];

        $this->db->select("species, DATE_FORMAT(recorded_at,'%Y-%m') as month, AVG(price_per_unit) as avg_price");
        $this->db->from('market_price_tracker');
        $this->db->where('unit', 'cubic_ft');
        $this->db->where("recorded_at >=", date('Y-m-01', strtotime('-5 months')));
        $this->db->group_by(["species", "DATE_FORMAT(recorded_at,'%Y-%m')"]);
        $this->db->order_by('recorded_at', 'ASC');
        $rows = $this->db->get()->result_array();

        $series = [];
        foreach ($rows as $r) {
            $sp = $r['species'];
            if (!isset($series[$sp])) $series[$sp] = ['label' => $sp, 'data' => []];
            $series[$sp]['data'][] = ['month' => $r['month'], 'avg' => round((float)$r['avg_price'], 2)];
        }

        return array_values($series);
    }

    private function _get_stock_donut(int $branch_id): array
    {
        $data = [];
        $types = ['logs' => 'timber_logs_lots', 'sawn' => 'timber_sawn_lots', 'standing' => 'timber_standing_lots'];
        foreach ($types as $label => $tbl) {
            if ($this->db->table_exists($tbl)) {
                $this->db->where('status', 'available');
                if ($branch_id > 0) $this->db->where('warehouse_id', $branch_id);
                $data[] = ['type' => $label, 'count' => $this->db->count_all_results($tbl)];
            }
        }
        return $data;
    }
}
