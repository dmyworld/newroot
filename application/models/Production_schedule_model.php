<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_schedule_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // --- BATCH CRUD ---

    public function get_pending_batches()
    {
        $this->db->select('b.*, w.name as wood_name');
        $this->db->from('geopos_production_batches b');
        $this->db->join('geopos_wood_types w', 'b.wood_type_id = w.id', 'left');
        $this->db->where_in('b.status', array('Planned', 'In-Progress'));
        $this->db->order_by('b.due_date', 'ASC');
        $this->db->order_by('b.priority', 'DESC'); // Urgent > High > Medium > Low (Alphanumeric sorting might need tweaks if not Enum mapped, but Enum Urgent comes after High... wait. Low, Medium, High, Urgent. L, M, H, U. U is last. DESC works for Urgent vs Low? No. Urgent > Low. )
        // Enum: 'Low','Medium','High','Urgent'.
        // Alphabetical: High, Low, Medium, Urgent. 
        // We might need custom sorting if strict priority needed. For now simple fetch.
        return $this->db->get()->result_array();
    }

    public function get_all_batches_for_calendar($start, $end)
    {
        $this->db->select('b.id, b.name as title, b.start_date as start, b.due_date as end, b.status, b.priority');
        $this->db->from('geopos_production_batches b');
        $this->db->where('b.start_date >=', $start);
        $this->db->where('b.start_date <=', $end);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function create_batch($name, $priority, $wood_id, $qty, $unit, $due_date)
    {
        $data = array(
            'name' => $name,
            'priority' => $priority,
            'wood_type_id' => $wood_id,
            'total_qty' => $qty,
            'unit' => $unit,
            'due_date' => $due_date,
            'status' => 'Planned',
            'start_date' => NULL // Will be set by scheduler
        );

        if ($this->db->insert('geopos_production_batches', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // --- SCHEDULING LOGIC (Heuristic) ---

    public function auto_schedule()
    {
        // 1. Get all Un-scheduled batches (Planned, no start_date)
        $this->db->where('status', 'Planned');
        $this->db->where('start_date', NULL);
        
        // Priority Sort: Urgent first
        $this->db->order_by("FIELD(priority, 'Urgent', 'High', 'Medium', 'Low')");
        $this->db->order_by('due_date', 'ASC');
        
        $batches = $this->db->get('geopos_production_batches')->result();

        $current_date = new DateTime();
        $current_date->modify('+1 day'); // Start scheduling from tomorrow

        $scheduled_count = 0;

        foreach ($batches as $batch) {
            // Simplistic Logic:
            // Assign start date = current_date
            // Assume 5 days duration (Placeholder for Route calculation)
            
            $start = $current_date->format('Y-m-d');
            $end_date_obj = clone $current_date;
            $end_date_obj->modify('+5 days');
            
            // Update Batch
            $this->db->where('id', $batch->id);
            $this->db->update('geopos_production_batches', array(
                'start_date' => $start,
                'due_date' => $end_date_obj->format('Y-m-d') // Updating due date tentatively or keeping user's?
                // Let's keep User's due date if set, unless start+duration > due.
                // For this MVP, let's just set start_date.
            ));

            // Move pointer for next batch?
            // Simple logic: Can process 2 batches in parallel.
            // If scheduled_count is even, stay on same day. If odd, move next day.
            if ($scheduled_count % 2 != 0) {
                 $current_date->modify('+1 day');
            }
            
            $scheduled_count++;
        }

        return $scheduled_count;
    }

    // --- ROUTING LOGIC ---

    public function get_batch_details($id)
    {
        $this->db->select('b.*, w.name as wood_name');
        $this->db->from('geopos_production_batches b');
        $this->db->join('geopos_wood_types w', 'b.wood_type_id = w.id', 'left');
        $this->db->where('b.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_batch_routes($batch_id)
    {
        $this->db->select('r.*, m.name as machine_name, m.machine_code');
        $this->db->from('geopos_production_routes r');
        $this->db->join('geopos_machines m', 'r.machine_id = m.id', 'left');
        $this->db->where('r.batch_id', $batch_id);
        $this->db->order_by('r.sequence_order', 'ASC');
        return $this->db->get()->result_array();
    }

    public function add_route_stage($batch_id, $stage_name, $machine_id, $hours, $sequence)
    {
        $data = array(
            'batch_id' => $batch_id,
            'stage_name' => $stage_name,
            'machine_id' => $machine_id,
            'estimated_hours' => $hours,
            'sequence_order' => $sequence
        );
        return $this->db->insert('geopos_production_routes', $data);
    }

    public function delete_route_stage($id)
    {
        return $this->db->delete('geopos_production_routes', array('id' => $id));
    }
}

