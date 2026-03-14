<?php
/**
 * Master Products Model
 * Handles global product master list and labor categories
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_Products_model extends CI_Model
{
    var $table = 'geopos_master_products';
    var $column_order = array(null, 'product_name', 'product_code', 'product_price', null);
    var $column_search = array('product_name', 'product_code');
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Master Products CRUD
    public function get_master_products($id = 0)
    {
        if ($id > 0) {
            $this->db->where('id', $id);
            return $this->db->get($this->table)->row_array();
        }
        return $this->db->get($this->table)->result_array();
    }

    public function add_master_product($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_master_product($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_master_product($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Labor Categories CRUD
    public function get_labor_categories($id = 0)
    {
        if ($id > 0) {
            $this->db->where('id', $id);
            return $this->db->get('geopos_labor_categories')->row_array();
        }
        return $this->db->get('geopos_labor_categories')->result_array();
    }

    public function add_labor_category($data)
    {
        return $this->db->insert('geopos_labor_categories', $data);
    }

    public function update_labor_category($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('geopos_labor_categories', $data);
    }

    public function delete_labor_category($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('geopos_labor_categories');
    }

    // DataTables implementation for Master Products
    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->input->post('search')['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
