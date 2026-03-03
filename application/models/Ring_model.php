<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ring_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new service request
     */
    public function create_request($data)
    {
        $this->db->insert('tp_service_requests', $data);
        return $this->db->insert_id();
    }

    /**
     * Find providers within a certain radius of a GPS point
     * This uses the Haversine formula for distance calculation in SQL
     */
    public function find_nearby_providers($lat, $lng, $radius_km, $exclude_user_id = 0)
    {
        // Query users who have provider_type set and are verified
        // We'll joined with location GPS if available, or just check user's last known location if we had one
        // For now, let's assume we search geopos_users or geopos_locations linked to users
        
        $sql = "SELECT u.id, u.username, u.email, u.provider_type, l.gps_lat, l.gps_lng,
                (6371 * acos(cos(radians(?)) * cos(radians(l.gps_lat)) * cos(radians(l.gps_lng) - radians(?)) + sin(radians(?)) * sin(radians(l.gps_lat)))) AS distance
                FROM geopos_users u
                JOIN geopos_locations l ON u.loc = l.id
                WHERE u.provider_type != 'none' 
                AND u.id != ?
                HAVING distance <= ?
                ORDER BY distance ASC";
        
        $query = $this->db->query($sql, [$lat, $lng, $lat, $exclude_user_id, $radius_km]);
        return $query->result_array();
    }

    /**
     * Log a ring broadcast for a provider
     */
    public function log_ring($request_id, $provider_id)
    {
        $data = [
            'request_id' => $request_id,
            'provider_user_id' => $provider_id,
            'notified_at' => date('Y-m-d H:i:s'),
            'action' => 'notified'
        ];
        return $this->db->insert('tp_ring_logs', $data);
    }

    /**
     * Accept a request (check for 30s timeout)
     */
    public function accept_request($request_id, $provider_id)
    {
        $this->db->trans_start();

        // 1. Check if request is still ringing and not expired
        $request = $this->db->get_where('tp_service_requests', ['id' => $request_id])->row();
        
        if (!$request || $request->status != 'ringing') {
            return ['status' => 'error', 'message' => 'Request is no longer available.'];
        }

        $now = strtotime(date('Y-m-d H:i:s'));
        $expiry = strtotime($request->ring_expires_at);

        if ($now > $expiry) {
            $this->db->where('id', $request_id)->update('tp_service_requests', ['status' => 'expired']);
            $this->db->trans_complete();
            return ['status' => 'error', 'message' => 'The 30-second window has expired.'];
        }

        // 2. Update request status
        $this->db->where('id', $request_id);
        $this->db->update('tp_service_requests', [
            'status' => 'accepted',
            'assigned_provider_id' => $provider_id,
            'accepted_at' => date('Y-m-d H:i:s')
        ]);

        // 3. Update ring log
        $this->db->where(['request_id' => $request_id, 'provider_user_id' => $provider_id]);
        $this->db->update('tp_ring_logs', [
            'action' => 'accepted',
            'action_at' => date('Y-m-d H:i:s'),
            'response_seconds' => $now - strtotime($request->ring_started_at)
        ]);

        $this->db->trans_complete();
        return ['status' => 'success', 'message' => 'Request accepted!'];
    }

    /**
     * Get request details with provider info
     */
    public function get_request($id)
    {
        $this->db->select('tp_service_requests.*, u.username as requester_name, p.username as provider_name');
        $this->db->from('tp_service_requests');
        $this->db->join('geopos_users u', 'tp_service_requests.requester_user_id = u.id', 'left');
        $this->db->join('geopos_users p', 'tp_service_requests.assigned_provider_id = p.id', 'left');
        $this->db->where('tp_service_requests.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Update provider live tracking
     */
    public function update_tracking($request_id, $user_id, $lat, $lng)
    {
        $data = [
            'request_id' => $request_id,
            'user_id' => $user_id,
            'gps_lat' => $lat,
            'gps_lng' => $lng,
            'recorded_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('tp_live_tracking', $data);
    }

    /**
     * Get last tracking for a request
     */
    public function get_last_tracking($request_id)
    {
        $this->db->where('request_id', $request_id);
        $this->db->order_by('recorded_at', 'DESC');
        return $this->db->get('tp_live_tracking', 1)->row();
    }
}
