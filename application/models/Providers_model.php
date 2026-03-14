<?php
/**
 * Providers Model
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Providers_model extends CI_Model
{
    var $table = 'tp_service_providers';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_pending()
    {
        $this->db->select('tp_service_providers.*, geopos_users.username, geopos_users.email');
        $this->db->from($this->table);
        $this->db->join('geopos_users', 'tp_service_providers.user_id = geopos_users.id', 'left');
        $this->db->where('tp_service_providers.status', 0);
        return $this->db->get()->result_array();
    }

    public function get_all_active()
    {
        $this->db->select('tp_service_providers.*, geopos_users.username, geopos_users.email');
        $this->db->from($this->table);
        $this->db->join('geopos_users', 'tp_service_providers.user_id = geopos_users.id', 'left');
        $this->db->where('tp_service_providers.status', 1);
        return $this->db->get()->result_array();
    }

    public function details($id)
    {
        $this->db->select('tp_service_providers.*, geopos_users.username, geopos_users.email, geopos_users.phone');
        $this->db->from($this->table);
        $this->db->join('geopos_users', 'tp_service_providers.user_id = geopos_users.id', 'left');
        $this->db->where('tp_service_providers.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_skills($id)
    {
        $this->db->select('tp_provider_skills.*, tp_services.service_name');
        $this->db->from('tp_provider_skills');
        $this->db->join('tp_services', 'tp_provider_skills.service_id = tp_services.id', 'left');
        $this->db->where('tp_provider_skills.provider_id', $id);
        return $this->db->get()->result_array();
    }

    public function approve($id)
    {
        $admin_id = $this->aauth->get_user()->id;
        $this->db->where('id', $id);
        $provider = $this->db->get($this->table)->row_array();
        
        if ($provider) {
            // Update provider status and KYC info
            $this->db->set('status', 1);
            $this->db->set('is_verified', 1);
            $this->db->set('kyc_approved_at', date('Y-m-d H:i:s'));
            $this->db->set('kyc_approved_by', $admin_id);
            $this->db->where('id', $id);
            $this->db->update($this->table);

            // Log KYC action
            $this->db->insert('tp_kyc_logs', array(
                'provider_id' => $id,
                'admin_id' => $admin_id,
                'action' => 'approved',
                'comments' => 'Identity documents verified and approved.'
            ));

            // Assign aauth group (Role 4 for Service Provider)
            $this->aauth->add_member($provider['user_id'], 4);
            return true;
        }
        return false;
    }

    public function reject($id, $reason)
    {
        $this->db->set('status', 3);
        // Could also log the reason
        $this->db->where('id', $id);
        return $this->db->update($this->table);
    }

    public function suspend($id)
    {
        $this->db->set('status', 2);
        $this->db->where('id', $id);
        return $this->db->update($this->table);
    }

    public function get_online_locations()
    {
        $this->db->select('id, user_id, current_lat as lat, current_lng as lng, status, is_online');
        $this->db->from($this->table);
        $this->db->where('status', 1);
        return $this->db->get()->result_array();
    }

    public function get_provider_by_user($user_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row_array();
    }

    public function update_kyc($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function save_skills($provider_id, $skills)
    {
        // $skills is an array of ['service_id' => X, 'price' => Y]
        $this->db->trans_start();
        $this->db->delete('tp_provider_skills', array('provider_id' => $provider_id));
        foreach ($skills as $skill) {
            $this->db->insert('tp_provider_skills', array(
                'provider_id' => $provider_id,
                'service_id' => $skill['service_id'],
                'fixed_price' => $skill['price']
            ));
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
