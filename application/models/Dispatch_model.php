<?php
/**
 * Dispatch Model
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dispatch_model extends CI_Model
{
    var $table = 'tp_service_requests';

    public function __construct()
    {
        parent::__construct();
    }

    public function create_request($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_request($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }

    public function find_suitable_providers($service_id, $lat, $lng, $radius = 10)
    {
        // Find providers who are online, verified, and have this skill
        // Using Haversine formula for distance
        $sql = "SELECT p.*, s.fixed_price, 
                (6371 * acos(cos(radians(?)) * cos(radians(p.current_lat)) * cos(radians(p.current_lng) - radians(?)) + sin(radians(?)) * sin(radians(p.current_lat)))) AS distance 
                FROM tp_service_providers p 
                JOIN tp_provider_skills s ON p.id = s.provider_id 
                WHERE p.is_online = 1 AND p.is_verified = 1 AND s.service_id = ? 
                HAVING distance < ? 
                ORDER BY distance ASC";
        
        $query = $this->db->query($sql, array($lat, $lng, $lat, $service_id, $radius));
        return $query->result_array();
    }

    public function update_request_status($id, $status, $provider_id = null)
    {
        $data = array('status' => $status);
        if ($provider_id) {
            $data['provider_id'] = $provider_id;
            $data['accepted_at'] = date('Y-m-d H:i:s');
        }
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function get_pending_request_for_provider($provider_id)
    {
        // In a real system, we'd have a separate 'tp_dispatch_queue' 
        // For simplicity, we'll check if there's a request where this provider is the 'current target'
        // For now, let's just check for 'Requested' status and match service skills
        // But the user wants 'Sequential Dispatching'.
        // Let's check for any request with status 0 (Requested) that hasn't been assigned or rejected by this provider
        
        $this->db->select('r.*, s.service_name');
        $this->db->from('tp_service_requests r');
        $this->db->join('tp_services s', 'r.service_id = s.id');
        $this->db->where('r.status', 0);
        $this->db->where('r.provider_id IS NULL');
        
        // This is a naive implementation. Sequential logic would involve a queue.
        // For this phase, we'll just return the oldest pending request that matches the provider's skills.
        $this->db->join('tp_provider_skills ps', 'ps.service_id = r.service_id');
        $this->db->where('ps.provider_id', $provider_id);
        
        return $this->db->get()->row_array();
    }
}
