<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_sites_model extends CI_Model
{
    var $table = 'geopos_job_sites';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_sites($customer_id = 0)
    {
        if ($customer_id > 0) {
            $this->db->where('customer_id', $customer_id);
        }
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function add_site($customer_id, $name, $address, $city, $region, $country, $postbox)
    {
        $data = array(
            'customer_id' => $customer_id,
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox
        );

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function delete_site($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
