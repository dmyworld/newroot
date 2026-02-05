<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_orders_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_work_orders()
    {
        $this->db->select('wo.*, b.name as batch_name, e.username as employee_name, m.name as machine_name');
        $this->db->from('geopos_work_orders wo');
        $this->db->join('geopos_production_batches b', 'wo.batch_id = b.id', 'left');
        $this->db->join('geopos_employees e', 'wo.assigned_employee_id = e.id', 'left');
        $this->db->join('geopos_machines m', 'wo.machine_id = m.id', 'left');
        $this->db->order_by('wo.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_employee_tasks($employee_id)
    {
        $this->db->select('wo.*, b.name as batch_name, m.name as machine_name');
        $this->db->from('geopos_work_orders wo');
        $this->db->join('geopos_production_batches b', 'wo.batch_id = b.id', 'left');
        $this->db->join('geopos_machines m', 'wo.machine_id = m.id', 'left');
        $this->db->where('wo.assigned_employee_id', $employee_id);
        $this->db->where_in('wo.status', ['Pending', 'In Progress', 'Hold']);
        $this->db->order_by('wo.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function generate_from_batch($batch_id)
    {
        // 1. Get Batch Details
        $this->db->where('id', $batch_id);
        $batch = $this->db->get('geopos_production_batches')->row_array();
        if(!$batch) return false;

        // 2. Get Routes (Stages)
        $this->db->where('batch_id', $batch_id);
        $this->db->order_by('stage_order', 'ASC'); // Ensure order matters
        $routes = $this->db->get('geopos_production_routes')->result_array();

        if(empty($routes)) {
            // Create a default WO if no routes defined? Or error?
            // Let's create a generic "Production" WO
            $data = array(
                'batch_id' => $batch_id,
                'stage_name' => 'General Production',
                'qty_to_make' => $batch['items_qty'], // Assuming we have qty in batch later, but for now generic
                'status' => 'Pending'
            );
            $this->db->insert('geopos_work_orders', $data);
            return 1;
        }

        $count = 0;
        foreach($routes as $route) {
            // Check if WO already exists for this stage
            $exist = $this->db->where('batch_id', $batch_id)->where('stage_name', $route['stage_name'])->get('geopos_work_orders')->num_rows();
            if($exist == 0) {
                $data = array(
                    'batch_id' => $batch_id,
                    'stage_name' => $route['stage_name'],
                    'machine_id' => $route['machine_id'], // Auto-assign machine from route logic
                    // 'qty_to_make' => ... we might need to add qty to production_batches table or fetch from there
                    'status' => 'Pending'
                );
                $this->db->insert('geopos_work_orders', $data);
                $count++;
            }
        }
        return $count;
    }

    public function assign_employee($wo_id, $employee_id)
    {
        $this->db->set('assigned_employee_id', $employee_id);
        $this->db->where('id', $wo_id);
        return $this->db->update('geopos_work_orders');
    }

    public function update_status($wo_id, $status, $qty_completed = 0, $remarks = '')
    {
        $data = array(
            'status' => $status,
            'remarks' => $remarks
        );
        if($status == 'In Progress') {
            $data['start_time'] = date('Y-m-d H:i:s');
        } elseif($status == 'Completed') {
            $data['end_time'] = date('Y-m-d H:i:s');
            $data['qty_completed'] = $qty_completed;
        }

        $this->db->where('id', $wo_id);
        return $this->db->update('geopos_work_orders', $data);
    }
}
