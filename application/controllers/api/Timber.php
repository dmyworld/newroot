<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Api_base.php';

/**
 * Timber Marketplace API
 *
 * GET  /api/timber/listings       - Browse all listings (filters)
 * GET  /api/timber/lot/{id}/{type}- Single lot detail
 * POST /api/timber/add_listing    - Seller adds a timber lot
 * POST /api/timber/bid            - Buyer places a bid
 * POST /api/timber/buy_now        - Instant purchase
 * GET  /api/timber/my_listings    - Seller's own listings
 * GET  /api/timber/my_bids        - Buyer's bids
 * GET  /api/inventory/branch      - Branch-wise stock summary
 */
class Timber extends Api_base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Marketplace_model', 'mp');
        $this->load->model('TimberPro_model', 'timberpro');
        $this->load->model('Wood_types_model', 'wood');
    }

    /* ---------------------------------------------------------------
     * GET /api/timber/listings
     * ?species=Teak&grade=A&min_price=&max_price=&loc_id=&type=logs|sawn|standing
     * --------------------------------------------------------------- */
    public function listings_get()
    {
        $filters = [
            'species'   => $this->get('species'),
            'grade'     => $this->get('grade'),
            'type'      => $this->get('type'),
            'min_price' => $this->get('min_price'),
            'max_price' => $this->get('max_price'),
            'loc_id'    => $this->get('loc_id'),
            'lat'       => $this->get('lat'),
            'lon'       => $this->get('lon'),
            'radius_km' => $this->get('radius_km') ?: 100,
            'verified'  => $this->get('verified'),  // 1 = verified lots only
        ];

        $page     = max(1, (int)($this->get('page') ?: 1));
        $per_page = min(50, (int)($this->get('per_page') ?: 20));
        $offset   = ($page - 1) * $per_page;

        $lots = $this->mp->get_all_active_lots();

        // Apply filters
        $lots = array_filter($lots, function($lot) use ($filters) {
            if ($filters['species'] && stripos($lot['species'] ?? '', $filters['species']) === false) return false;
            if ($filters['grade']   && ($lot['grade'] ?? '') !== $filters['grade']) return false;
            if ($filters['type'] === 'logs'     && ($lot['lot_type'] ?? '') !== 'logs') return false;
            if ($filters['type'] === 'sawn'     && ($lot['lot_type'] ?? '') !== 'sawn') return false;
            if ($filters['type'] === 'standing' && ($lot['lot_type'] ?? '') !== 'standing') return false;
            if ($filters['verified'] == '1' && empty($lot['permit_verified'])) return false;
            return true;
        });

        $total = count($lots);
        $lots  = array_slice(array_values($lots), $offset, $per_page);

        // Add computed fields
        foreach ($lots as &$lot) {
            $lot['thumbnail']    = !empty($lot['photos']) ? json_decode($lot['photos'], true)[0] ?? null : null;
            $lot['is_verified']  = !empty($lot['permit_verified']);
        }

        $this->_paginated($lots, $total, $page, $per_page);
    }

    /* ---------------------------------------------------------------
     * GET /api/timber/lot/{id}/{type}
     * --------------------------------------------------------------- */
    public function lot_get()
    {
        $id   = (int)  $this->get('id');
        $type = (string) ($this->get('type') ?: 'logs');

        if (!$id) { $this->_fail('Lot ID required'); return; }

        $lot = $this->mp->get_lot_details($id, $type);
        if (!$lot) { $this->_fail('Lot not found', 404); return; }

        // Attach latest bid
        $lot['latest_bid'] = $this->mp->get_latest_bid($id, $type);

        // Photos
        if (!empty($lot['photos'])) {
            $lot['photos'] = json_decode($lot['photos'], true);
        }

        $this->_success($lot);
    }

    /* ---------------------------------------------------------------
     * POST /api/timber/add_listing
     * Body: { lot_name, type: logs|sawn|standing, warehouse_id,
     *          location_gps, species, grade, dimensions{}, quantity,
     *          selling_price }
     * Requires auth
     * --------------------------------------------------------------- */
    public function add_listing_post()
    {
        if (!$this->_authenticate()) return;

        $type       = $this->post('type') ?: 'logs';
        $lot_name   = trim($this->post('lot_name'));
        $warehouse  = (int)$this->post('warehouse_id');
        $gps        = $this->post('location_gps') ?: '';
        $species    = $this->post('species') ?: '';
        $grade      = $this->post('grade') ?: 'Standard';

        if (!$lot_name || !$warehouse) {
            $this->_fail('lot_name and warehouse_id are required');
            return;
        }

        $lot_id = null;

        if ($type === 'logs') {
            $logs = [[
                'wood_type_id'     => (int)$this->post('wood_type_id'),
                'girth_inches'     => (float)$this->post('girth_inches'),
                'length_ft'        => (float)$this->post('length_ft'),
                'grade'            => $grade,
                'moisture_content' => (float)($this->post('moisture_content') ?: 0),
                'selling_price'    => (float)$this->post('selling_price'),
                'quantity'         => max(1,(int)$this->post('quantity')),
            ]];
            $lot_id = $this->timberpro->save_logs($lot_name, $warehouse, $logs, $gps);
        } elseif ($type === 'sawn') {
            $items = [[
                'wood_type_id'     => (int)$this->post('wood_type_id'),
                'thickness_inches' => (float)$this->post('thickness_inches'),
                'width_inches'     => (float)$this->post('width_inches'),
                'length_ft'        => (float)$this->post('length_ft'),
                'grade'            => $grade,
                'quantity'         => max(1,(int)$this->post('quantity')),
                'selling_price'    => (float)$this->post('selling_price'),
            ]];
            $lot_id = $this->timberpro->save_sawn($lot_name, $warehouse, $gps, $items);
        } elseif ($type === 'standing') {
            $items = [[
                'wood_type_id'     => (int)$this->post('wood_type_id'),
                'species'          => $species,
                'estimated_volume' => (float)$this->post('estimated_volume'),
                'quantity'         => max(1,(int)$this->post('quantity')),
                'selling_price'    => (float)$this->post('selling_price'),
            ]];
            $lot_id = $this->timberpro->save_standing($lot_name, $warehouse, $gps, $items);
        } else {
            $this->_fail("type must be 'logs', 'sawn' or 'standing'");
            return;
        }

        $this->_log_action('ADD_LISTING', 'timber_' . $type, $lot_id, [
            'lot_name' => $lot_name, 'species' => $species, 'grade' => $grade
        ]);

        $this->_success(['lot_id' => $lot_id, 'type' => $type], 'Listing added successfully', 201);
    }

    /* ---------------------------------------------------------------
     * POST /api/timber/bid
     * Body: { lot_id, lot_type, amount }
     * --------------------------------------------------------------- */
    public function bid_post()
    {
        if (!$this->_authenticate()) return;

        $lot_id   = (int)$this->post('lot_id');
        $lot_type = $this->post('lot_type') ?: 'logs';
        $amount   = (float)$this->post('amount');

        if (!$lot_id || $amount <= 0) {
            $this->_fail('lot_id and amount are required');
            return;
        }

        $bid_id = $this->mp->place_bid($lot_id, $lot_type, $this->current_user_id, $amount);

        $this->_log_action('PLACE_BID', 'marketplace_bids', $bid_id, [
            'lot_id' => $lot_id, 'amount' => $amount
        ]);

        $this->_success(['bid_id' => $bid_id], 'Bid placed successfully');
    }

    /* ---------------------------------------------------------------
     * POST /api/timber/buy_now
     * Body: { lot_id, lot_type }
     * --------------------------------------------------------------- */
    public function buy_now_post()
    {
        if (!$this->_authenticate()) return;

        $lot_id   = (int)$this->post('lot_id');
        $lot_type = $this->post('lot_type') ?: 'logs';

        if (!$lot_id) { $this->_fail('lot_id is required'); return; }

        $result = $this->mp->buy_now($lot_id, $lot_type, $this->current_user_id);

        $this->_log_action('BUY_NOW', 'timber_' . $lot_type, $lot_id);
        $this->_success($result, 'Purchase completed');
    }

    /* ---------------------------------------------------------------
     * GET /api/timber/my_listings
     * --------------------------------------------------------------- */
    public function my_listings_get()
    {
        if (!$this->_authenticate()) return;

        // Gather lots from all timber tables owned by this user
        $out = [];
        foreach (['timber_logs_lots', 'timber_sawn_lots', 'timber_standing_lots'] as $tbl) {
            if ($this->db->table_exists($tbl)) {
                $this->db->where('added_by', $this->current_user_id);
                $this->db->order_by('created_at', 'DESC');
                $rows = $this->db->get($tbl)->result_array();
                foreach ($rows as $r) {
                    $r['table'] = $tbl;
                    $out[] = $r;
                }
            }
        }

        $this->_success($out);
    }

    /* ---------------------------------------------------------------
     * GET /api/timber/my_bids
     * --------------------------------------------------------------- */
    public function my_bids_get()
    {
        if (!$this->_authenticate()) return;

        $bids = $this->mp->get_my_bids($this->current_user_id);
        $this->_success($bids);
    }

    /* ---------------------------------------------------------------
     * GET /api/inventory/branch
     * ?branch_id=
     * --------------------------------------------------------------- */
    public function branch_stock_get()
    {
        if (!$this->_authenticate()) return;

        $branch_id = (int)($this->get('branch_id') ?: 0);
        $summary   = [];

        $tables = [
            'logs'     => 'timber_logs_lots',
            'sawn'     => 'timber_sawn_lots',
            'standing' => 'timber_standing_lots',
        ];

        foreach ($tables as $key => $tbl) {
            if ($this->db->table_exists($tbl)) {
                $this->db->select('COUNT(*) as lot_count, SUM(total_volume) as total_volume');
                $this->db->where('status', 'available');
                if ($branch_id > 0) $this->db->where('warehouse_id', $branch_id);
                $row = $this->db->get($tbl)->row_array();
                $summary[$key] = [
                    'lot_count'    => (int) ($row['lot_count'] ?? 0),
                    'total_volume' => round((float) ($row['total_volume'] ?? 0), 2),
                ];
            } else {
                $summary[$key] = ['lot_count' => 0, 'total_volume' => 0];
            }
        }

        $this->_success(['branch_id' => $branch_id, 'stock' => $summary]);
    }
}
