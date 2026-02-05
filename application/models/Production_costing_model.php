<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_costing_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_batch_costing($batch_id)
    {
        // 1. Material Cost (Consumption)
        // Join stock_movements with products using 'ref_id' as batch_id (assuming consumption is logged with ref_id = batch_id)
        // OR ref_id could be WO_ID. Let's assume for consumption we use Batch ID directly for simplicity in Phase 8.
        
        $this->db->select('sm.qty, sm.move_date, p.product_name, p.product_price'); // Assuming product_price is purchase cost
        $this->db->from('geopos_stock_movements sm');
        $this->db->join('geopos_products p', 'sm.product_id = p.pid');
        $this->db->where('sm.ref_id', $batch_id);
        $this->db->where('sm.type', 'Consumption');
        $materials = $this->db->get()->result_array();

        $material_total = 0;
        foreach($materials as $m) {
            $material_total += ($m['qty'] * $m['product_price']);
        }

        // 2. Labor Cost
        // Get all Work Orders for this batch
        $this->db->select('wo.id, wo.stage_name, wo.start_time, wo.end_time, e.username, e.hourly_rate');
        $this->db->from('geopos_work_orders wo');
        $this->db->join('geopos_employees e', 'wo.assigned_employee_id = e.id', 'left');
        $this->db->where('wo.batch_id', $batch_id);
        $this->db->where('wo.status', 'Completed'); // Only completed tasks
        $labor = $this->db->get()->result_array();

        $labor_total = 0;
        foreach($labor as &$l) {
            if($l['start_time'] && $l['end_time']) {
                $start = new DateTime($l['start_time']);
                $end = new DateTime($l['end_time']);
                $diff = $start->diff($end);
                $hours = $diff->h + ($diff->i / 60);
                $l['hours'] = round($hours, 2);
            } else {
                $l['hours'] = 0;
            }
            $rate = isset($l['hourly_rate']) ? $l['hourly_rate'] : 0;
            $l['cost'] = $l['hours'] * $rate;
            $labor_total += $l['cost'];
        }

        // 3. Machine Cost (Simplified: Machine Hour * Machine Rate)
        // Access via Work Orders
        $this->db->select('wo.id, wo.stage_name, wo.start_time, wo.end_time, m.name as machine_name, m.operating_cost_per_hour');
        $this->db->from('geopos_work_orders wo');
        $this->db->join('geopos_machines m', 'wo.machine_id = m.id', 'left');
        $this->db->where('wo.batch_id', $batch_id);
        $this->db->where('wo.status', 'Completed');
        $this->db->where('wo.machine_id !=', NULL);
        $machines = $this->db->get()->result_array();

        $machine_total = 0;
        foreach($machines as &$m) {
            if($m['start_time'] && $m['end_time']) {
                $start = new DateTime($m['start_time']);
                $end = new DateTime($m['end_time']);
                $diff = $start->diff($end);
                $hours = $diff->h + ($diff->i / 60);
                $m['hours'] = round($hours, 2);
            } else {
                $m['hours'] = 0;
            }
            $rate = isset($m['operating_cost_per_hour']) ? $m['operating_cost_per_hour'] : 0;
            $m['cost'] = $m['hours'] * $rate;
            $machine_total += $m['cost'];
        }

        return array(
            'materials' => $materials,
            'material_total' => $material_total,
            'labor' => $labor,
            'labor_total' => $labor_total,
            'machines' => $machines,
            'machine_total' => $machine_total,
            'grand_total' => $material_total + $labor_total + $machine_total
        );
    }
}
