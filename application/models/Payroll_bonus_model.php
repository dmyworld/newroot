<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_bonus_model extends CI_Model
{
    var $table = 'geopos_payroll_bonuses';
    var $column_order = array(null, 'geopos_employees.name', 'geopos_payroll_bonuses.amount', 'geopos_payroll_bonuses.type', 'geopos_payroll_bonuses.date_effective', 'geopos_payroll_bonuses.status');
    var $column_search = array('geopos_employees.name', 'geopos_payroll_bonuses.type', 'geopos_payroll_bonuses.status');
    var $order = array('geopos_payroll_bonuses.id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('geopos_payroll_bonuses.*, geopos_employees.name as employee_name');
        $this->db->from($this->table);
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_payroll_bonuses.employee_id', 'left');

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
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
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

    public function add_bonus($employee_id, $amount, $type, $date, $note)
    {
        $data = array(
            'employee_id' => $employee_id,
            'amount' => $amount,
            'type' => $type,
            'date_effective' => $date,
            'note' => $note,
            'status' => 'Pending'
        );
        return $this->db->insert('geopos_payroll_bonuses', $data);
    }
    
    public function get_pending_bonuses($eid, $start, $end) {
        $this->db->where('employee_id', $eid);
        $this->db->where('status', 'Pending');
        $this->db->where('date_effective >=', $start);
        $this->db->where('date_effective <=', $end);
        return $this->db->get('geopos_payroll_bonuses')->result_array();
    }
    
    public function mark_bonuses_paid($bonus_ids) {
        if(empty($bonus_ids)) return true;
        $this->db->where_in('id', $bonus_ids);
        return $this->db->update('geopos_payroll_bonuses', array('status' => 'Paid'));
    }

    public function delete_bonus($id)
    {
        return $this->db->delete('geopos_payroll_bonuses', array('id' => $id));
    }
}
