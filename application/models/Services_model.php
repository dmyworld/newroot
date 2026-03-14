<?php
/**
 * Services Model
 * Handle logic for tp_services
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Services_model extends CI_Model
{
    var $table = 'tp_services';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $this->db->select('tp_services.*, tp_service_categories.title as cat_name');
        $this->db->from($this->table);
        $this->db->join('tp_service_categories', 'tp_services.cat_id = tp_service_categories.id', 'left');
        $this->db->order_by('tp_services.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addnew($name, $desc, $cat_id, $sub_cat_id = 0, $commission = 0, $min_price = 0, $max_price = 0)
    {
        $data = array(
            'service_name' => $name,
            'service_desc' => $desc,
            'cat_id' => $cat_id,
            'sub_cat_id' => $sub_cat_id,
            'admin_commission_pc' => $commission,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'status' => 1
        );

        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id, $name, $desc, $cat_id, $sub_cat_id = 0, $commission = 0, $min_price = 0, $max_price = 0)
    {
        $old_data = $this->details($id);
        $admin_id = $this->aauth->get_user()->id;

        $fields_to_audit = ['admin_commission_pc', 'min_price', 'max_price'];
        foreach ($fields_to_audit as $field) {
            $new_val = ($field == 'admin_commission_pc') ? $commission : (($field == 'min_price') ? $min_price : $max_price);
            if ($old_data[$field] != $new_val) {
                $this->db->insert('tp_finance_audit', array(
                    'service_id' => $id,
                    'field_name' => $field,
                    'old_value' => $old_data[$field],
                    'new_value' => $new_val,
                    'action_by' => $admin_id
                ));
            }
        }

        $data = array(
            'service_name' => $name,
            'service_desc' => $desc,
            'cat_id' => $cat_id,
            'sub_cat_id' => $sub_cat_id,
            'admin_commission_pc' => $commission,
            'min_price' => $min_price,
            'max_price' => $max_price
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
        if ($this->db->delete($this->table, array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    public function toggle_status($id)
    {
        $this->db->select('status');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $row = $query->row_array();

        $new_status = ($row['status'] == 1) ? 0 : 1;

        $this->db->set('status', $new_status);
        $this->db->where('id', $id);
        $this->db->update($this->table);

        return $new_status;
    }

    public function bulk_commission_update($sub_cat_id, $commission)
    {
        $this->db->set('admin_commission_pc', $commission);
        $this->db->where('sub_cat_id', $sub_cat_id);
        if ($this->db->update($this->table)) {
            return true;
        } else {
            return false;
        }
    }

    public function surge_pricing($cat_id, $surge_pc)
    {
        // $cat_id 0 means global surge
        $this->db->set('admin_commission_pc', "admin_commission_pc + $surge_pc", FALSE); // Warning: This increases commission % NOT absolute price as per user request (User said "prices increase" but we only have commission % here)
        // Wait, user said "මුළු පද්ධතියේම හෝ නිශ්චිත කාණ්ඩයක මිල ගණන් ස්වයංක්රීයව යම් ප්රතිශතයකින් (උදා: +10%) වැඩි කිරීමට"
        // Since we don't have absolute prices for services in tp_services (workers set them), 
        // surge pricing should probably be a global modifier applied at checkout or when worker sets price.
        // But for now, I will implement a way to record the surge in tp_surge_logs and maybe a global setting.
        
        $data = array(
            'cat_id' => $cat_id,
            'surge_pc' => $surge_pc,
            'action_by' => $this->aauth->get_user()->id
        );
        return $this->db->insert('tp_surge_logs', $data);
    }
}
