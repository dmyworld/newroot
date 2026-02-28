<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Api_base.php';

/**
 * Calculator API
 * All timber measurement calculations (Hoppus, Sawn, Wastage, Price)
 *
 * POST /api/calculator/log_volume      - Hoppus Rule
 * POST /api/calculator/sawn_volume     - Sawn timber (cubic / sq ft / running ft)
 * POST /api/calculator/wastage         - Wastage & yield
 * POST /api/calculator/price_estimate  - Market price estimate
 * GET  /api/calculator/history         - User's past calculations
 */
class Calculator extends Api_base
{
    const TABLE_CALC = 'timber_calculations';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Timber_Calculator_model', 'timber_calc');
        $this->_ensure_calc_table();
    }

    private function _ensure_calc_table(): void
    {
        if (!$this->db->table_exists(self::TABLE_CALC)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `" . self::TABLE_CALC . "` (
                  `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `user_id`        INT UNSIGNED DEFAULT 0,
                  `calc_type`      VARCHAR(50)  NOT NULL,
                  `input_params`   TEXT,
                  `result_value`   DECIMAL(15,4) DEFAULT 0,
                  `result_detail`  TEXT,
                  `unit`           VARCHAR(30),
                  `price_estimate` DECIMAL(15,2) DEFAULT 0,
                  `species`        VARCHAR(100),
                  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  INDEX(`user_id`),
                  INDEX(`calc_type`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }
    }

    /* ----------------------------------------------------------------
     * POST /api/calculator/log_volume
     * Hoppus Rule: V = (G/4)^2 × L / 144
     * Input: { girth_inches, length_ft, species?, price_per_cuft? }
     * ---------------------------------------------------------------- */
    public function log_volume_post()
    {
        $girth  = (float) $this->post('girth_inches');
        $length = (float) $this->post('length_ft');
        $price  = (float) ($this->post('price_per_cuft') ?: 0);
        $species = $this->post('species') ?: '';

        if ($girth <= 0 || $length <= 0) {
            $this->_fail('girth_inches and length_ft must be positive numbers');
            return;
        }

        // Use Model for calculation
        $volume = $this->timber_calc->calculate_hoppus($girth, $length);
        
        if ($price <= 0) {
            $estimate_data = $this->timber_calc->estimate_market_price($volume, $species, 'cubic_ft');
            $estimate = $estimate_data['estimate'];
            $price = $estimate_data['price_per_unit'];
        } else {
            $estimate = round($volume * $price, 2);
        }

        $result = [
            'formula'        => 'V = (G/4)² × L / 144',
            'input'          => ['girth_inches' => $girth, 'length_ft' => $length],
            'volume_cuft'    => round($volume, 4),
            'price_per_cuft' => $price,
            'price_estimate' => $estimate,
            'species'        => $species,
        ];

        $this->_save_calc('hoppus', $result, $volume, 'cu.ft', $estimate, $species);
        $this->_success($result, 'Log volume calculated (Hoppus Rule)');
    }

    /* ----------------------------------------------------------------
     * POST /api/calculator/sawn_volume
     * Input: { thickness_inches, width_inches, length_ft, quantity?,
     *          unit_type: cubic|sqft|running, price_per_unit? }
     * ---------------------------------------------------------------- */
    public function sawn_volume_post()
    {
        $thickness = (float) $this->post('thickness_inches');
        $width     = (float) $this->post('width_inches');
        $length    = (float) $this->post('length_ft');
        $quantity  = max(1, (int) ($this->post('quantity') ?: 1));
        $price     = (float) ($this->post('price_per_unit') ?: 0);
        $species   = $this->post('species') ?: '';

        if ($thickness <= 0 || $width <= 0 || $length <= 0) {
            $this->_fail('thickness_inches, width_inches and length_ft must be positive');
            return;
        }

        // Use Model for calculations
        $cubic_total   = $this->timber_calc->calculate_sawn_volume($width, $thickness, $length, $quantity);
        $sq_total      = $this->timber_calc->calculate_square_feet($width, $length, $quantity);
        $running_total = $this->timber_calc->calculate_running_feet($length, $quantity);

        if ($price <= 0) {
            $estimate_data = $this->timber_calc->estimate_market_price($cubic_total, $species, 'cubic_ft');
            $estimate = $estimate_data['estimate'];
            $price = $estimate_data['price_per_unit'];
        } else {
            $estimate = round($cubic_total * $price, 2);
        }

        $result = [
            'per_piece' => [
                'cubic_ft'    => round($cubic_total / $quantity, 4),
                'sq_ft'       => round($sq_total / $quantity, 4),
                'running_ft'  => round($running_total / $quantity, 2),
            ],
            'total' => [
                'cubic_ft'    => round($cubic_total, 4),
                'sq_ft'       => round($sq_total, 4),
                'running_ft'  => round($running_total, 2),
            ],
            'quantity'   => $quantity,
            'input'      => [
                'thickness_inches' => $thickness,
                'width_inches'     => $width,
                'length_ft'        => $length,
            ],
            'price_per_unit' => $price,
            'price_estimate' => $estimate,
            'species'        => $species,
        ];

        $this->_save_calc('sawn_volume', $result, $cubic_total, 'cu.ft', $estimate, $species);
        $this->_success($result, 'Sawn timber volume calculated');
    }

    /* ----------------------------------------------------------------
     * POST /api/calculator/wastage
     * Input: { log_volume_cuft, expected_output_cuft }
     * ---------------------------------------------------------------- */
    public function wastage_post()
    {
        $log_vol    = (float) $this->post('log_volume_cuft');
        $output_vol = (float) $this->post('expected_output_cuft');

        if ($log_vol <= 0) {
            $this->_fail('log_volume_cuft must be a positive number');
            return;
        }
        if ($output_vol > $log_vol) {
            $this->_fail('Output volume cannot exceed log volume');
            return;
        }

        // Use model for complex wastage calculation
        $data = $this->timber_calc->calculate_wastage_complex($log_vol, $output_vol);

        $result = [
            'log_volume_cuft'    => $log_vol,
            'output_volume_cuft' => $output_vol,
            'wastage_cuft'       => round($data['wastage_vol'], 4),
            'wastage_percent'    => $data['wastage_pct'],
            'yield_percent'      => $data['yield_pct'],
            'tip'                => $data['tip'],
        ];

        $this->_save_calc('wastage', $result, $data['wastage_vol'], 'cu.ft', 0, '');
        $this->_success($result, 'Wastage and yield calculated');
    }

    /* ----------------------------------------------------------------
     * POST /api/calculator/price_estimate
     * Input: { species, grade, volume, unit: cubic_ft|sq_ft|running_ft }
     * ---------------------------------------------------------------- */
    public function price_estimate_post()
    {
        $species = $this->post('species') ?: '';
        $grade   = $this->post('grade')   ?: '';
        $volume  = (float) $this->post('volume');
        $unit    = $this->post('unit') ?: 'cubic_ft';

        if ($volume <= 0) {
            $this->_fail('Volume must be a positive number');
            return;
        }

        // 1. Try Live Tracker Lookup
        $price_row = null;
        if ($this->db->table_exists('market_price_tracker')) {
            $this->db->where('unit', $unit);
            if ($species) $this->db->where('species', $species);
            if ($grade)   $this->db->where('grade', $grade);
            $this->db->order_by('recorded_at', 'DESC');
            $this->db->limit(1);
            $price_row = $this->db->get('market_price_tracker')->row_array();
        }

        if ($price_row) {
            $price_per_unit = (float) $price_row['price_per_unit'];
            $estimate = round($volume * $price_per_unit, 2);
            $source = 'market_tracker';
        } else {
            // 2. Fallback to standardized model defaults
            $data = $this->timber_calc->estimate_market_price($volume, $species, $unit);
            $estimate = $data['estimate'];
            $price_per_unit = $data['price_per_unit'];
            $source = $data['source'];
        }

        $result = [
            'species'        => $species ?: 'General',
            'grade'          => $grade ?: 'Standard',
            'volume'         => $volume,
            'unit'           => $unit,
            'price_per_unit' => $price_per_unit,
            'total_estimate' => $estimate,
            'currency'       => 'LKR',
            'price_source'   => $source,
            'note'           => 'Estimate only — actual price may vary by negotiation',
        ];

        $this->_success($result, 'Price estimated');
    }

    /* ----------------------------------------------------------------
     * GET /api/calculator/history
     * Returns authenticated user's last 20 calculations
     * ---------------------------------------------------------------- */
    public function history_get()
    {
        if (!$this->_authenticate()) return;

        $limit = (int) ($this->get('limit') ?: 20);
        $this->db->where('user_id', $this->current_user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $rows = $this->db->get(self::TABLE_CALC)->result_array();

        foreach ($rows as &$row) {
            $row['input_params']  = json_decode($row['input_params'], true);
            $row['result_detail'] = json_decode($row['result_detail'], true);
        }

        $this->_success($rows);
    }

    /* ----------------------------------------------------------------
     * Private helper — save calculation to history
     * ---------------------------------------------------------------- */
    private function _save_calc(string $type, array $details, float $result, string $unit, float $estimate, string $species): void
    {
        $uid = $this->current_user_id ?: 0;
        $this->db->insert(self::TABLE_CALC, [
            'user_id'        => $uid,
            'calc_type'      => $type,
            'input_params'   => json_encode($details['input'] ?? $details),
            'result_value'   => $result,
            'result_detail'  => json_encode($details),
            'unit'           => $unit,
            'price_estimate' => $estimate,
            'species'        => $species,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }
}
