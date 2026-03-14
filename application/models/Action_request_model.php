<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_request_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Fcm_lib');
        $this->load->model('Wallet_model', 'wallets');
        $this->load->model('Commission_model', 'commission');
    }

    /**
     * Create a new action request (single item) and initial ring queue.
     *
     * @param int    $customer_id
     * @param int    $category_id
     * @param int|null $item_id
     * @param string $type       Product|Service
     * @param float  $lat
     * @param float  $lng
     * @param float  $radius_km
     * @param string $group_id   UUID for grouping project splits
     * @return int   request_id
     */
    public function create_request($customer_id, $category_id, $item_id, $type, $lat, $lng, $radius_km, $group_id)
    {
        $data = [
            'group_id'       => $group_id,
            'customer_id'    => (int)$customer_id,
            'category_id'    => (int)$category_id,
            'item_id'        => $item_id ? (int)$item_id : null,
            'request_type'   => $type === 'Product' ? 'Product' : 'Service',
            'customer_lat'   => $lat,
            'customer_long'  => $lng,
            'radius_km'      => $radius_km,
            'status'         => 'searching',
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('tp_action_requests', $data);
        $request_id = $this->db->insert_id();

        $providers = $this->find_nearby_providers($category_id, $item_id, $type, $lat, $lng, $radius_km);
        foreach ($providers as $p) {
            $this->db->insert('tp_action_request_rings', [
                'request_id'  => $request_id,
                'provider_id' => (int)$p['user_id'],
                'distance_km' => (float)$p['distance_km'],
                'status'      => 'pending',
            ]);
        }

        $this->notify_next_provider($request_id);
        return $request_id;
    }

    /**
     * Haversine search for nearby providers matching category/item/type.
     */
    public function find_nearby_providers($category_id, $item_id, $type, $lat, $lng, $radius_km)
    {
        $params = [
            'cust_lat'   => $lat,
            'cust_lng'   => $lng,
            'radius_km'  => $radius_km,
            'category'   => (int)$category_id,
            'type'       => $type === 'Product' ? 'Product' : 'Service',
        ];

        $sql = "
            SELECT 
                vp.user_id,
                (6371 * ACOS(
                    COS(RADIANS(:cust_lat)) * COS(RADIANS(vp.last_lat)) *
                    COS(RADIANS(vp.last_long) - RADIANS(:cust_lng)) +
                    SIN(RADIANS(:cust_lat)) * SIN(RADIANS(vp.last_lat))
                )) AS distance_km
            FROM tp_vendor_profiles vp
            JOIN tp_vendor_services vs
                ON vs.user_id = vp.user_id
               AND vs.status = 1
               AND vs.category_id = :category
               AND vs.type = :type
        ";

        if ($item_id) {
            $sql .= " AND (vs.item_id = :item_id OR vs.item_id IS NULL)";
            $params['item_id'] = (int)$item_id;
        }

        $sql .= "
            WHERE vp.is_online = 1
              AND vp.is_available = 1
              AND vp.last_lat IS NOT NULL
              AND vp.last_long IS NOT NULL
              AND vp.last_seen_at >= (NOW() - INTERVAL 15 MINUTE)
            HAVING distance_km <= :radius_km
            ORDER BY distance_km ASC
            LIMIT 50
        ";

        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    /**
     * Notify the next pending provider in the ring list.
     *
     * @param int $request_id
     */
    public function notify_next_provider($request_id)
    {
        // Ensure request still open
        $req = $this->db->where('id', (int)$request_id)
            ->where_in('status', ['pending','searching'])
            ->get('tp_action_requests')
            ->row_array();
        if (!$req) {
            return;
        }

        $provider = $this->db->where('request_id', (int)$request_id)
            ->where('status', 'pending')
            ->order_by('distance_km', 'ASC')
            ->limit(1)
            ->get('tp_action_request_rings')
            ->row_array();

        if (!$provider) {
            // no more providers
            $this->db->where('id', (int)$request_id)
                ->update('tp_action_requests', ['status' => 'no_provider']);
            return;
        }

        $expires_at = date('Y-m-d H:i:s', time() + 45);

        $this->db->where('id', (int)$provider['id'])
            ->update('tp_action_request_rings', [
                'status'      => 'notified',
                'notified_at' => date('Y-m-d H:i:s'),
                'expires_at'  => $expires_at,
            ]);

        $payload = [
            'request_id' => (int)$request_id,
            'ring_id'    => (int)$provider['id'],
            'action'     => 'job_offer',
            'expires_at' => $expires_at,
            'type'       => $req['request_type'],
            'category_id'=> (int)$req['category_id'],
            'item_id'    => $req['item_id'] ? (int)$req['item_id'] : null,
        ];

        $this->fcm_lib->send_to_user(
            (int)$provider['provider_id'],
            'New nearby job',
            'You have a new job request near you',
            $payload
        );
    }

    /**
     * Provider accepts a ring.
     */
    public function accept($request_id, $provider_id)
    {
        $this->db->trans_start();

        // Lock ring row
        $ring = $this->db->where('request_id', (int)$request_id)
            ->where('provider_id', (int)$provider_id)
            ->where('status', 'notified')
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->get('tp_action_request_rings')
            ->row_array();

        if (!$ring) {
            $this->db->trans_complete();
            return false;
        }

        // Check request still open
        $req = $this->db->where('id', (int)$request_id)
            ->where_in('status', ['pending','searching'])
            ->get('tp_action_requests')
            ->row_array();
        if (!$req) {
            $this->db->trans_complete();
            return false;
        }

        // Mark accepted
        $this->db->where('id', (int)$ring['id'])
            ->update('tp_action_request_rings', ['status' => 'accepted']);

        $this->db->where('request_id', (int)$request_id)
            ->where('id !=', (int)$ring['id'])
            ->where_in('status', ['pending','notified'])
            ->update('tp_action_request_rings', ['status' => 'skipped']);

        $this->db->where('id', (int)$request_id)
            ->update('tp_action_requests', [
                'status'             => 'accepted',
                'chosen_provider_id' => (int)$provider_id,
                'accepted_at'        => date('Y-m-d H:i:s'),
            ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Provider declines a ring.
     */
    public function decline($request_id, $provider_id)
    {
        $this->db->where('request_id', (int)$request_id)
            ->where('provider_id', (int)$provider_id)
            ->where_in('status', ['pending','notified'])
            ->update('tp_action_request_rings', ['status' => 'declined']);

        $this->notify_next_provider($request_id);
    }

    /**
     * Mark all expired notified rings as timeout and move to next provider.
     */
    public function process_timeouts()
    {
        $rows = $this->db->where('status', 'notified')
            ->where('expires_at <', date('Y-m-d H:i:s'))
            ->get('tp_action_request_rings')
            ->result_array();

        foreach ($rows as $row) {
            $this->db->where('id', (int)$row['id'])
                ->update('tp_action_request_rings', ['status' => 'timeout']);
            $this->notify_next_provider((int)$row['request_id']);
        }
    }

    public function get_request_with_rings($request_id)
    {
        $req = $this->db->where('id', (int)$request_id)
            ->get('tp_action_requests')
            ->row_array();
        if (!$req) return null;

        $rings = $this->db->where('request_id', (int)$request_id)
            ->order_by('id', 'ASC')
            ->get('tp_action_request_rings')
            ->result_array();

        $req['rings'] = $rings;
        return $req;
    }

    /**
     * Mark request as completed and settle wallet + commission.
     *
     * @param int   $request_id
     * @param float $amount_gross  Total amount customer paid for this request
     * @return array|false
     */
    public function complete_with_wallet(int $request_id, float $amount_gross)
    {
        if ($amount_gross <= 0) {
            return false;
        }

        $req = $this->db->where('id', $request_id)->get('tp_action_requests')->row_array();
        if (!$req || $req['status'] !== 'accepted' || empty($req['chosen_provider_id'])) {
            return false;
        }

        $provider_id = (int)$req['chosen_provider_id'];

        $rate = $this->commission->get_rate($provider_id);
        $commission_amt = round($amount_gross * ($rate / 100), 2);
        $net_payout     = round($amount_gross - $commission_amt, 2);

        $meta_wallet = [
            'request_id' => $request_id,
            'gross'      => $amount_gross,
            'commission' => $commission_amt,
            'rate'       => $rate,
        ];

        $this->db->trans_start();

        // 1) Credit provider wallet with net amount
        if ($net_payout > 0) {
            $this->wallets->credit($provider_id, $net_payout, 'service', $request_id, $meta_wallet);
        }

        // 2) Record platform commission in geopos_commissions (invoice_id used as request_id)
        if ($commission_amt > 0) {
            $this->commission->record_commission(
                $request_id,        // invoice_id surrogate
                $amount_gross,      // total
                $provider_id,       // seller_id
                0,                  // loc
                0,                  // business_id
                'action_request'    // category
            );
        }

        // 3) Mark request as completed
        $this->db->where('id', $request_id)
            ->update('tp_action_requests', [
                'status'     => 'completed',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            return false;
        }

        return [
            'provider_id'    => $provider_id,
            'amount_gross'   => $amount_gross,
            'commission_amt' => $commission_amt,
            'net_payout'     => $net_payout,
            'rate'           => $rate,
        ];
    }
}

