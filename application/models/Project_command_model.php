<?php
/**
 * TimberPro Project Command Center Model
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_command_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get list of projects with location and customer details
     */
    public function get_projects($loc = 0)
    {
        $this->db->select('p.*, l.cname as location_name, c.name as customer_name');
        $this->db->from('tp_projects p');
        $this->db->join('geopos_locations l', 'p.location_id = l.id', 'left');
        $this->db->join('geopos_customers c', 'p.customer_id = c.id', 'left');
        
        if ($loc > 0) {
            $this->db->where('p.location_id', $loc);
        }
        
        $this->db->order_by('p.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Add new project
     */
    public function add_project($data)
    {
        return $this->db->insert('tp_projects', $data);
    }

    /**
     * Update project
     */
    public function update_project($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tp_projects', $data);
    }

    /**
     * Get tasks for a project
     */
    public function get_tasks($project_id)
    {
        $this->db->select('t.*, e.name as employee_name');
        $this->db->from('tp_project_tasks t');
        $this->db->join('geopos_employees e', 't.assigned_to = e.id', 'left');
        $this->db->where('t.project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Add task
     */
    public function add_task($data)
    {
        return $this->db->insert('tp_project_tasks', $data);
    }

    /**
     * Start timer for a task
     */
    public function start_timer($task_id, $worker_id)
    {
        $data = array(
            'task_id' => $task_id,
            'worker_id' => $worker_id,
            'start_time' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('tp_project_timesheets', $data);
    }

    /**
     * Stop timer and calculate duration
     */
    public function stop_timer($timesheet_id)
    {
        $this->db->where('id', $timesheet_id);
        $query = $this->db->get('tp_project_timesheets');
        $row = $query->row_array();

        if ($row) {
            $end_time = date('Y-m-d H:i:s');
            $start = new DateTime($row['start_time']);
            $end = new DateTime($end_time);
            $interval = $start->diff($end);
            $minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

            $this->db->where('id', $timesheet_id);
            return $this->db->update('tp_project_timesheets', array(
                'end_time' => $end_time,
                'duration_minutes' => $minutes
            ));
        }
        return false;
    }

    /**
     * Reserve material for a project (Pending Issue)
     */
    public function reserve_material($project_id, $product_id, $qty)
    {
        $data = array(
            'project_id' => $project_id,
            'product_id' => $product_id,
            'qty' => $qty,
            'status' => 'Pending'
        );
        return $this->db->insert('tp_inventory_reservations', $data);
    }

    /**
     * Get reserved materials for a project
     */
    public function get_reservations($project_id)
    {
        $this->db->select('r.*, p.product_name, p.product_code');
        $this->db->from('tp_inventory_reservations r');
        $this->db->join('geopos_products p', 'r.product_id = p.pid', 'left');
        $this->db->where('r.project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get financial logs for a project
     */
    public function get_finances($project_id)
    {
        $this->db->where('project_id', $project_id);
        $query = $this->db->get('tp_project_finances');
        return $query->result_array();
    }

    /**
     * Add financial log (Material/Labor/Overhead)
     */
    public function add_finance_log($data)
    {
        return $this->db->insert('tp_project_finances', $data);
    }

    /**
     * Automated double-entry log for project costs (WIP)
     * This should be called when material is issued or labor logged.
     */
    public function log_wip_entry($project_id, $amount, $type, $note)
    {
        $this->load->model('transactions_model', 'transactions');
        
        // Find WIP Account (Assuming searching by name if ID unknown)
        $this->db->where('holder', 'Work in Progress');
        $wip_acc = $this->db->get('geopos_accounts')->row_array();
        
        if ($wip_acc) {
            $data = array(
                'acid' => $wip_acc['id'],
                'account' => $wip_acc['holder'],
                'type' => 'Expense', // WIP is usually tracked as an asset but CI might use Expense/Income flow
                'cat' => 'Project Cost',
                'debit' => $amount,
                'credit' => 0,
                'payer' => 'Project: ' . $project_id,
                'note' => "[$type] $note",
                'date' => date('Y-m-d'),
                'eid' => $this->aauth->get_user()->id,
                'loc' => $this->aauth->get_user()->loc
            );
            $this->db->insert('geopos_transactions', $data);
            $last_id = $this->db->insert_id();
            
            // Link to project finances
            $this->add_finance_log(array(
                'project_id' => $project_id,
                'transaction_type' => $type,
                'ledger_entry_id' => $last_id,
                'amount' => $amount,
                'description' => $note
            ));
            return true;
        }
        return false;
    }
}
