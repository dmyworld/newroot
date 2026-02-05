<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_maintenance_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_machine_status()
    {
        // Get all machines
        // Check if they have an unresolved downtime record
        
        $sql = "
            SELECT m.*, 
            (SELECT COUNT(*) FROM geopos_machine_downtime d WHERE d.machine_id = m.id AND d.is_resolved = 0) as is_down,
            (SELECT reason FROM geopos_machine_downtime d WHERE d.machine_id = m.id AND d.is_resolved = 0 ORDER BY d.start_time DESC LIMIT 1) as down_reason,
            (SELECT id FROM geopos_machine_downtime d WHERE d.machine_id = m.id AND d.is_resolved = 0 ORDER BY d.start_time DESC LIMIT 1) as down_id
            FROM geopos_machines m
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_upcoming_maintenance()
    {
        $this->db->select('mm.*, m.name as machine_name');
        $this->db->from('geopos_machine_maintenance mm');
        $this->db->join('geopos_machines m', 'mm.machine_id = m.id');
        $this->db->where('mm.is_completed', 0);
        $this->db->order_by('mm.scheduled_date', 'ASC');
        return $this->db->get()->result_array();
    }

    public function log_downtime($machine_id, $reason, $comments, $user_id)
    {
        $data = array(
            'machine_id' => $machine_id,
            'start_time' => date('Y-m-d H:i:s'),
            'reason' => $reason,
            'reported_by' => $user_id,
            'comments' => $comments,
            'is_resolved' => 0
        );
        return $this->db->insert('geopos_machine_downtime', $data);
    }

    public function resolve_downtime($id)
    {
        $data = array(
            'end_time' => date('Y-m-d H:i:s'),
            'is_resolved' => 1
        );
        $this->db->where('id', $id);
        return $this->db->update('geopos_machine_downtime', $data);
    }

    public function schedule_service($machine_id, $date, $description)
    {
        $data = array(
            'machine_id' => $machine_id,
            'scheduled_date' => $date,
            'description' => $description,
            'is_completed' => 0
        );
        return $this->db->insert('geopos_machine_maintenance', $data);
    }
}
