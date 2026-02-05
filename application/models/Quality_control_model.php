<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quality_control_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_pending_inspections()
    {
        // Logic: Get WOs that are 'Completed' but NOT yet inspected (or partially).
        // For simple flow: Get all 'Completed' WOs where ID is NOT in qc_inspections table.
        // (Assuming 1 inspection per WO for simplicity)
        
        $this->db->select('wo.*, b.name as batch_name, e.username as employee_name');
        $this->db->from('geopos_work_orders wo');
        $this->db->join('geopos_production_batches b', 'wo.batch_id = b.id', 'left');
        $this->db->join('geopos_employees e', 'wo.assigned_employee_id = e.id', 'left');
        $this->db->where('wo.status', 'Completed');
        
        // Exclude already inspected
        $subquery = $this->db->select('wo_id')->get_compiled_select('geopos_qc_inspections');
        $this->db->where("wo.id NOT IN ($subquery)", NULL, FALSE);
        
        $this->db->order_by('wo.end_time', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_wo_details($wo_id)
    {
        $this->db->select('wo.*, b.name as batch_name, e.username as employee_name, m.name as machine_name');
        $this->db->from('geopos_work_orders wo');
        $this->db->join('geopos_production_batches b', 'wo.batch_id = b.id', 'left');
        $this->db->join('geopos_employees e', 'wo.assigned_employee_id = e.id', 'left');
        $this->db->join('geopos_machines m', 'wo.machine_id = m.id', 'left');
        $this->db->where('wo.id', $wo_id);
        return $this->db->get()->row_array();
    }

    public function save_inspection($wo_id, $inspector_id, $qty_checked, $qty_passed, $qty_rework, $qty_scraped, $defect_type, $comments)
    {
        $this->db->trans_start();

        // 1. Insert Inspection Record
        $data = array(
            'wo_id' => $wo_id,
            'inspector_id' => $inspector_id,
            'inspection_date' => date('Y-m-d H:i:s'),
            'qty_checked' => $qty_checked,
            'qty_passed' => $qty_passed,
            'qty_rework' => $qty_rework,
            'qty_scraped' => $qty_scraped,
            'defect_type' => $defect_type,
            'comments' => $comments
        );
        $this->db->insert('geopos_qc_inspections', $data);

        // 2. Logic to update Work Order Status
        if ($qty_rework > 0) {
            // Send back to Rework
            $this->db->set('status', 'Rework');
            $this->db->set('qty_rejected', "qty_rejected + $qty_rework", FALSE); 
            // Note: Simplification. Ideally rework creates a new task or re-opens this one.
            // Resetting status to 'Rework' flags it for the Carpenter.
            $this->db->where('id', $wo_id);
            $this->db->update('geopos_work_orders');
        } else {
            // Passed (or Scraped, which creates waste but task is done)
            // No status change needed if it stays 'Completed', 
            // but maybe we track 'QC Verified' somewhere?
            // For now, leaving as Completed is fine (is_inspected logic handles hiding it).
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
