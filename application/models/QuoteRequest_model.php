<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * QuoteRequest_model
 * Stores and retrieves peer-to-peer geo-fenced quotation requests.
 * Uses the geopos_quote_requests and geopos_quote_bids tables.
 */
class QuoteRequest_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_ensure_tables();
    }

    // ─────────────────────────────────────────────
    // SCHEMA BOOTSTRAPPING
    // ─────────────────────────────────────────────

    private function _ensure_tables()
    {
        // Quote Requests table
        if (!$this->db->table_exists('geopos_quote_requests')) {
            $this->db->query("CREATE TABLE `geopos_quote_requests` (
                `id`           INT(11) NOT NULL AUTO_INCREMENT,
                `user_id`      INT(11) NOT NULL,
                `product_name` VARCHAR(255) NOT NULL,
                `description`  TEXT,
                `quantity`     VARCHAR(50) DEFAULT NULL,
                `budget_min`   DECIMAL(15,2) NOT NULL DEFAULT '0.00',
                `budget_max`   DECIMAL(15,2) NOT NULL DEFAULT '0.00',
                `province`     VARCHAR(100) DEFAULT NULL,
                `district`     VARCHAR(100) DEFAULT NULL,
                `lat`          DECIMAL(10,7) NOT NULL DEFAULT '0.0000000',
                `lng`          DECIMAL(10,7) NOT NULL DEFAULT '0.0000000',
                `radius_km`    INT(11) NOT NULL DEFAULT '50',
                `status`       ENUM('open','bids_received','accepted','completed','cancelled') NOT NULL DEFAULT 'open',
                `expires_at`   DATE DEFAULT NULL,
                `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`),
                KEY `status` (`status`),
                KEY `district` (`district`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }

        // Bids on those requests
        if (!$this->db->table_exists('geopos_quote_bids')) {
            $this->db->query("CREATE TABLE `geopos_quote_bids` (
                `id`            INT(11) NOT NULL AUTO_INCREMENT,
                `request_id`    INT(11) NOT NULL,
                `seller_id`     INT(11) NOT NULL,
                `amount`        DECIMAL(15,2) NOT NULL,
                `notes`         TEXT,
                `delivery_days` INT(11) NOT NULL DEFAULT '7',
                `status`        ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
                `submitted_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `request_id` (`request_id`),
                KEY `seller_id` (`seller_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }
    }

    // ─────────────────────────────────────────────
    // REQUEST CRUD
    // ─────────────────────────────────────────────

    public function create_request($data)
    {
        $this->db->insert('geopos_quote_requests', $data);
        return $this->db->insert_id();
    }

    public function get_active_requests($limit = 20)
    {
        $this->db->select('r.*, u.username, u.email, 
                          (SELECT COUNT(*) FROM geopos_quote_bids WHERE request_id = r.id) as bid_count');
        $this->db->from('geopos_quote_requests r');
        $this->db->join('geopos_users u', 'u.id = r.user_id', 'left');
        $this->db->where('r.status', 'open');
        $this->db->where('(r.expires_at IS NULL OR r.expires_at >= CURDATE())');
        $this->db->order_by('r.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_my_requests($user_id)
    {
        $this->db->select('r.*, (SELECT COUNT(*) FROM geopos_quote_bids WHERE request_id = r.id) as bid_count');
        $this->db->from('geopos_quote_requests r');
        $this->db->where('r.user_id', $user_id);
        $this->db->order_by('r.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_request($id)
    {
        $this->db->select('r.*, u.username, u.email');
        $this->db->from('geopos_quote_requests r');
        $this->db->join('geopos_users u', 'u.id = r.user_id', 'left');
        $this->db->where('r.id', $id);
        return $this->db->get()->row_array();
    }

    public function update_request_status($request_id, $status, $user_id)
    {
        $this->db->where('id', $request_id);
        $this->db->where('user_id', $user_id); // Only owner can update
        $this->db->set('status', $status);
        $this->db->update('geopos_quote_requests');
        return $this->db->affected_rows() > 0;
    }

    // ─────────────────────────────────────────────
    // GEO-FENCING: Haversine radius search
    // ─────────────────────────────────────────────

    /**
     * Returns open requests whose origin is within $radius_km of a given point.
     */
    public function get_nearby_requests($lat, $lng, $radius_km = 50)
    {
        // Haversine formula inline in SQL for performance
        $sql = "SELECT r.*, u.username,
                    (SELECT COUNT(*) FROM geopos_quote_bids WHERE request_id = r.id) as bid_count,
                    (6371 * ACOS(
                        COS(RADIANS(?)) * COS(RADIANS(r.lat)) *
                        COS(RADIANS(r.lng) - RADIANS(?)) +
                        SIN(RADIANS(?)) * SIN(RADIANS(r.lat))
                    )) AS distance_km
                FROM geopos_quote_requests r
                LEFT JOIN geopos_users u ON u.id = r.user_id
                WHERE r.status = 'open'
                  AND (r.expires_at IS NULL OR r.expires_at >= CURDATE())
                HAVING distance_km < ?
                ORDER BY distance_km ASC
                LIMIT 50";

        return $this->db->query($sql, [(float)$lat, (float)$lng, (float)$lat, (float)$radius_km])->result_array();
    }

    /**
     * Returns open requests matching a district or province string (fallback when no GPS).
     */
    public function get_requests_by_location($province = null, $district = null, $limit = 20)
    {
        $this->db->select('r.*, u.username, (SELECT COUNT(*) FROM geopos_quote_bids WHERE request_id = r.id) as bid_count');
        $this->db->from('geopos_quote_requests r');
        $this->db->join('geopos_users u', 'u.id = r.user_id', 'left');
        $this->db->where('r.status', 'open');
        if ($district) $this->db->where('r.district', $district);
        elseif ($province) $this->db->where('r.province', $province);
        $this->db->order_by('r.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    // ─────────────────────────────────────────────
    // BIDS CRUD
    // ─────────────────────────────────────────────

    public function create_bid($data)
    {
        // First, update request status to indicate bids have arrived
        $this->db->where('id', $data['request_id']);
        $this->db->where('status', 'open');
        $this->db->set('status', 'bids_received');
        $this->db->update('geopos_quote_requests');

        // Insert the bid
        $this->db->insert('geopos_quote_bids', $data);
        return $this->db->insert_id();
    }

    public function get_bids_for_request($request_id)
    {
        $this->db->select('b.*, u.username, u.email, e.phone');
        $this->db->from('geopos_quote_bids b');
        $this->db->join('geopos_users u', 'u.id = b.seller_id', 'left');
        $this->db->join('geopos_employees e', 'e.id = b.seller_id', 'left');
        $this->db->where('b.request_id', $request_id);
        $this->db->order_by('b.amount', 'ASC');
        return $this->db->get()->result_array();
    }

    public function accept_bid($bid_id, $request_id, $user_id)
    {
        // Verify the request belongs to this user
        $req = $this->get_request($request_id);
        if (!$req || $req['user_id'] != $user_id) return false;

        // Reject all other bids
        $this->db->where('request_id', $request_id);
        $this->db->where('id !=', $bid_id);
        $this->db->set('status', 'rejected');
        $this->db->update('geopos_quote_bids');

        // Accept the chosen bid
        $this->db->where('id', $bid_id);
        $this->db->set('status', 'accepted');
        $this->db->update('geopos_quote_bids');

        // Mark request as accepted
        $this->db->where('id', $request_id);
        $this->db->set('status', 'accepted');
        $this->db->update('geopos_quote_requests');

        return $this->db->affected_rows() > 0;
    }
}
