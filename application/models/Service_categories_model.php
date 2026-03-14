<?php
/**
 * Service Categories Model
 * Handle logic for tp_service_categories
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_categories_model extends CI_Model
{
    var $table = 'tp_service_categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_main_categories()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('c_type', 0);
        $this->db->where('status', 1);
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_sub_categories($rel_id = 0)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('c_type', 1);
        if ($rel_id > 0) {
            $this->db->where('rel_id', $rel_id);
        }
        $this->db->where('status', 1);
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addnew($title, $extra, $icon, $c_type = 0, $rel_id = 0)
    {
        $data = array(
            'title' => $title,
            'extra' => $extra,
            'icon' => $icon,
            'c_type' => $c_type,
            'rel_id' => $rel_id,
            'requested_by' => $this->aauth->get_user()->id
        );

        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id, $title, $extra, $icon, $c_type = 0, $rel_id = 0)
    {
        $data = array(
            'title' => $title,
            'extra' => $extra,
            'icon' => $icon,
            'c_type' => $c_type,
            'rel_id' => $rel_id
        );

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update($this->table)) {
            return true;
        } else {
            return false;
        }
    }

    public function details($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_i($id)
    {
        // Check if it's a main category with subs
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('rel_id', $id);
        $query = $this->db->get();
        $subs = $query->result_array();

        if (count($subs) > 0) {
            return array('status' => 'Error', 'message' => 'Please delete sub-categories first!');
        }

        // Delete the category
        $this->db->delete($this->table, array('id' => $id));
        return array('status' => 'Success', 'message' => 'Category deleted successfully!');
    }
}
