<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seasoning_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_batches()
    {
        $this->db->select('*');
        $this->db->from('geopos_seasoning_batches');
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_batch_details($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_seasoning_batches');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }

    public function get_batch_logs($batch_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_seasoning_logs');
        $this->db->where('batch_id', $batch_id);
        $this->db->order_by('check_date', 'DESC');
        return $this->db->get()->result_array();
    }

    public function create_batch($name, $method, $start_date, $initial_mc, $target_mc, $location)
    {
        $data = array(
            'batch_name' => $name,
            'method' => $method,
            'start_date' => $start_date,
            'initial_mc' => $initial_mc,
            'target_mc' => $target_mc,
            'current_mc' => $initial_mc, // Start with initial
            'location' => $location,
            'status' => 'Active'
        );
        return $this->db->insert('geopos_seasoning_batches', $data);
    }

    public function add_log($batch_id, $date, $mc, $temp, $humidity, $noted_by)
    {
        $data = array(
            'batch_id' => $batch_id,
            'check_date' => $date,
            'moisture_content' => $mc,
            'temperature' => $temp,
            'humidity' => $humidity,
            'noted_by' => $noted_by
        );

        if($this->db->insert('geopos_seasoning_logs', $data)) {
            // Update current MC of the batch
            $this->db->set('current_mc', $mc);
            $this->db->where('id', $batch_id);
            $this->db->update('geopos_seasoning_batches');
            return true;
        }
        return false;
    }
}
