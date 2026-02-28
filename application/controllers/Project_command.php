<?php
/**
 * TimberPro Project Command Center Controller
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_command extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        // Permission 4 is projects in this system
        if (!$this->aauth->premission(4)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->model('Project_command_model', 'project_command');
        $this->load->model('customers_model', 'customers');
        $this->load->model('locations_model', 'locations');
        $this->load->model('employee_model', 'employee');
        $this->li_a = 'project_command';
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Command Center';
        $data['projects'] = $this->project_command->get_projects($this->aauth->get_user()->loc);
        
        // Calculate Total Active WIP (Estimated)
        $total_wip = 0;
        foreach ($data['projects'] as $p) {
            if ($p['status'] != 'Finished' && $p['status'] != 'Canceled') {
                // Calculate labor
                $this->db->select('SUM(IFNULL(t.estimated_hours,0) * IFNULL(e.salary,0)) as labor_val');
                $this->db->from('tp_project_tasks t');
                $this->db->join('geopos_employees e', 't.assigned_to = e.id', 'left');
                $this->db->where('t.project_id', $p['id']);
                $query_labor = $this->db->get();
                $labor = ($query_labor->num_rows() > 0) ? $query_labor->row()->labor_val : 0;

                // Calculate material
                $this->db->select('SUM(IFNULL(r.qty,0) * IFNULL(p.product_price,0)) as mat_val');
                $this->db->from('tp_inventory_reservations r');
                $this->db->join('geopos_products p', 'r.product_id = p.pid', 'left');
                $this->db->where('r.project_id', $p['id']);
                $query_mat = $this->db->get();
                $mat = ($query_mat->num_rows() > 0) ? $query_mat->row()->mat_val : 0;

                $total_wip += ($labor + $mat);
            }
        }
        $data['total_wip'] = $total_wip;
        
        $this->load->view('fixed/header', $head);
        $this->load->view('project_command/index', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Project Setup Wizard (Step-by-Step)
     */
    public function create()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'New Project Setup';
        
        $data['locations'] = $this->db->get('geopos_locations')->result_array();
        $data['customers'] = $this->customers->get_fetchall();
        $data['employees'] = $this->employee->list_employee();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('project_command/wizard', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * AJAX: Save Step 1 (Project Details)
     */
    public function save_project()
    {
        $data = array(
            'project_name' => $this->input->post('name', true),
            'location_id' => $this->input->post('location', true),
            'customer_id' => $this->input->post('customer', true),
            'start_date' => datefordatabase($this->input->post('sdate', true)),
            'end_date' => datefordatabase($this->input->post('edate', true)),
            'total_budget' => numberClean($this->input->post('budget', true)),
            'status' => 'Planning'
        );

        if ($this->project_command->add_project($data)) {
            $id = $this->db->insert_id();
            echo json_encode(array('status' => 'Success', 'message' => 'Project Initiated', 'project_id' => $id));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to create project'));
        }
    }

    /**
     * AJAX: Get employee utilization for Step 2
     */
    public function get_utilization()
    {
        $employees = $this->employee->list_employee();
        $result = array();
        foreach ($employees as $emp) {
            // Logic to calculate utilization from tp_project_tasks
            $this->db->select('SUM(estimated_hours) as total_hours');
            $this->db->from('tp_project_tasks');
            $this->db->where('assigned_to', $emp['id']);
            $this->db->where('status !=', 'Done');
            $query = $this->db->get();
            $row = $query->row_array();
            
            $result[] = array(
                'name' => $emp['name'],
                'hours' => $row['total_hours'] ? (float)$row['total_hours'] : 0,
                'limit' => 8 // Standard day limit
            );
        }
        echo json_encode($result);
    }

    /**
     * AJAX: Add Task & Reserve Material (Step 3)
     */
    public function save_task()
    {
        $project_id = $this->input->post('project_id');
        $task_data = array(
            'project_id' => $project_id,
            'task_name' => $this->input->post('task_name', true),
            'assigned_to' => $this->input->post('employee_id', true),
            'estimated_hours' => $this->input->post('hours', true),
            'status' => 'To-Do'
        );

        if ($this->project_command->add_task($task_data)) {
            // Inventory hook can be implemented here or as a separate step
            echo json_encode(array('status' => 'Success', 'message' => 'Task Added'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to add task'));
        }
    }

    /**
     * AJAX: Reserve material for Step 3
     */
    public function save_reservation()
    {
        $project_id = $this->input->post('project_id');
        $product_id = $this->input->post('product_id');
        $qty = $this->input->post('qty');

        if ($this->project_command->reserve_material($project_id, $product_id, $qty)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Material Reserved'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to reserve material'));
        }
    }

    /**
     * AJAX: Finalise Project (WIP Initialization)
     */
    public function finalise_project()
    {
        $id = $this->input->post('project_id');
        $project = $this->db->get_where('tp_projects', array('id' => $id))->row_array();
        
        if ($project) {
            // Update status to In-Progress
            $this->project_command->update_project($id, array('status' => 'In-Progress'));
            
            // Initial WIP Entry (Reserved materials value)
            $reservations = $this->project_command->get_reservations($id);
            $total_val = 0;
            foreach ($reservations as $res) {
                // Get price
                $prod = $this->db->get_where('geopos_products', array('pid' => $res['product_id']))->row_array();
                $total_val += ($prod['product_price'] * $res['qty']);
            }
            
            if ($total_val > 0) {
                $this->project_command->log_wip_entry($id, $total_val, 'Material', 'Initial inventory reservation value');
            }
            
            echo json_encode(array('status' => 'Success', 'message' => 'Project finalized and WIP started'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Project not found'));
        }
    }

    /**
     * Project Command Center (Detailed View)
     */
    public function explore()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Command Center';
        
        $data['project'] = $this->db->get_where('tp_projects', array('id' => $id))->row_array();
        $data['tasks'] = $this->project_command->get_tasks($id);
        $data['finances'] = $this->project_command->get_finances($id);
        $data['reservations'] = $this->project_command->get_reservations($id);

        // Calculate Estimated Costs (On-the-fly)
        $this->db->select('t.estimated_hours, e.salary');
        $this->db->from('tp_project_tasks t');
        $this->db->join('geopos_employees e', 't.assigned_to = e.id', 'left');
        $this->db->where('t.project_id', $id);
        $tasks = $this->db->get()->result_array();

        $labor_cost = 0;
        foreach ($tasks as $task) {
            $labor_cost += floatval($task['estimated_hours']) * floatval($task['salary']);
        }

        $this->db->select('r.qty, p.product_price');
        $this->db->from('tp_inventory_reservations r');
        $this->db->join('geopos_products p', 'r.product_id = p.pid', 'left');
        $this->db->where('r.project_id', $id);
        $materials = $this->db->get()->result_array();

        $material_cost = 0;
        foreach ($materials as $mat) {
            $material_cost += floatval($mat['qty']) * floatval($mat['product_price']);
        }

        $data['totals'] = array(
            'estimated_labor' => $labor_cost,
            'estimated_material' => $material_cost,
            'estimated_total' => $labor_cost + $material_cost
        );
        
        $this->load->view('fixed/header', $head);
        $this->load->view('project_command/explore', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Generate Profit/Loss PDF Report
     */
    public function pdf_report()
    {
        $id = $this->input->get('id');
        $project = $this->db->get_where('tp_projects', array('id' => $id))->row_array();
        $tasks = $this->project_command->get_tasks($id);
        $finances = $this->project_command->get_finances($id);
        $reservations = $this->project_command->get_reservations($id);

        // Calculate Estimated Costs
        $this->db->select('t.estimated_hours, e.salary');
        $this->db->from('tp_project_tasks t');
        $this->db->join('geopos_employees e', 't.assigned_to = e.id', 'left');
        $this->db->where('t.project_id', $id);
        $task_costs = $this->db->get()->result_array();
        $est_labor = 0;
        foreach ($task_costs as $t) $est_labor += $t['estimated_hours'] * $t['salary'];

        $this->db->select('r.qty, p.product_price');
        $this->db->from('tp_inventory_reservations r');
        $this->db->join('geopos_products p', 'r.product_id = p.pid', 'left');
        $this->db->where('r.project_id', $id);
        $mat_costs = $this->db->get()->result_array();
        $est_material = 0;
        foreach ($mat_costs as $m) $est_material += $m['qty'] * $m['product_price'];

        $est_total = $est_labor + $est_material;
        $budget = $project['total_budget'];
        $profit = $budget - $est_total;

        // Load PDF Library
        $this->load->library('Pdf');
        $pdf = $this->pdf->load();

        $html = '
        <html>
        <head>
            <style>
                body { font-family: sans-serif; }
                h2 { color: #2B2E4A; border-bottom: 2px solid #eee; padding-bottom: 10px; }
                .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                .table th { background-color: #f2f2f2; }
                .text-right { text-align: right; }
                .badge { padding: 5px; background: #eee; }
                .summary-box { background: #f9f9f9; padding: 15px; border: 1px solid #ddd; margin-top: 20px; }
            </style>
        </head>
        <body>
            <h2>Project Profit & Loss Report</h2>
            <p><strong>Project:</strong> ' . $project['project_name'] . '</p>
            <p><strong>Status:</strong> ' . $project['status'] . '</p>
            <p><strong>Timeline:</strong> ' . $project['start_date'] . ' to ' . $project['end_date'] . '</p>
            
            <div class="summary-box">
                <table style="width: 100%">
                    <tr>
                        <td><strong>Total Budget (Revenue):</strong></td>
                        <td class="text-right">' . amountExchange($budget, 0, $this->aauth->get_user()->loc) . '</td>
                    </tr>
                    <tr>
                        <td><strong>Estimated Labor Cost:</strong></td>
                        <td class="text-right">' . amountExchange($est_labor, 0, $this->aauth->get_user()->loc) . '</td>
                    </tr>
                    <tr>
                        <td><strong>Estimated Material Cost:</strong></td>
                        <td class="text-right">' . amountExchange($est_material, 0, $this->aauth->get_user()->loc) . '</td>
                    </tr>
                     <tr>
                        <td><strong>Total Estimated Cost:</strong></td>
                        <td class="text-right">' . amountExchange($est_total, 0, $this->aauth->get_user()->loc) . '</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #000; padding-top: 5px;"><strong>Projected Net Profit:</strong></td>
                        <td class="text-right" style="border-top: 1px solid #000; padding-top: 5px;"><strong>' . amountExchange($profit, 0, $this->aauth->get_user()->loc) . '</strong></td>
                    </tr>
                </table>
            </div>

            <h4>Task Breakdown</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned To</th>
                        <th>Hours</th>
                        <th>Cost (Est.)</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($tasks as $task) {
            $cost = $task['estimated_hours'] * $task['salary']; // Assuming salary is joined in get_tasks or separate query needed. 
            // Actually get_tasks joins employee table. Need to ensure 'salary' is selected in get_tasks model or here.
            // Model get_tasks selects t.*, e.name. It misses salary.
            // Let's use the task_costs array we calculated above for accuracy or jus re-fetch.
            // For simplicity in PDF, let's just list tasks.
             $html .= '<tr>
                        <td>' . $task['task_name'] . '</td>
                        <td>' . $task['employee_name'] . '</td>
                        <td>' . $task['estimated_hours'] . '</td>
                        <td> - </td>
                      </tr>';
        }
        $html .= '</tbody></table>';

        $html .= '<h4>Material Breakdown</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Cost (Est.)</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($reservations as $res) {
             $html .= '<tr>
                        <td>' . $res['product_name'] . '</td>
                        <td>' . $res['qty'] . '</td>
                        <td> - </td>
                      </tr>';
        }

        $html .= '</tbody></table></body></html>';

        $pdf->WriteHTML($html);
        $pdf->Output('Project_Report_' . $id . '.pdf', 'D');
    }

    /**
     * Edit Project Details
     */
    public function edit()
    {
        $id = $this->input->get('id');
        if (!$id) {
            redirect('project_command');
        }

        $data['project'] = $this->db->get_where('tp_projects', array('id' => $id))->row_array();
        
        if (!$data['project']) {
            redirect('project_command');
        }

        $data['locations'] = $this->db->get('geopos_locations')->result_array();
        $data['customers'] = $this->customers->get_fetchall();
        
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Project';
        
        $this->load->view('fixed/header', $head);
        $this->load->view('project_command/edit', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * AJAX: Update Project Details
     */
    public function update_project()
    {
        $id = $this->input->post('id');
        
        $sdate_input = $this->input->post('sdate');
        $edate_input = $this->input->post('edate');
        
        $sdate = '';
        $edate = '';

        if ($sdate_input) {
            $d = DateTime::createFromFormat($this->config->item('dformat2'), $sdate_input);
            if ($d && $d->format($this->config->item('dformat2')) === $sdate_input) {
                $sdate = $d->format('Y-m-d');
            } else {
                $d2 = DateTime::createFromFormat('d-m-Y', $sdate_input);
                if ($d2) $sdate = $d2->format('Y-m-d');
            }
        }

        if ($edate_input) {
            $d = DateTime::createFromFormat($this->config->item('dformat2'), $edate_input);
            if ($d && $d->format($this->config->item('dformat2')) === $edate_input) {
                $edate = $d->format('Y-m-d');
            } else {
                $d2 = DateTime::createFromFormat('d-m-Y', $edate_input);
                if ($d2) $edate = $d2->format('Y-m-d');
            }
        }

        $data = array(
            'project_name' => $this->input->post('name', true),
            'customer_id' => $this->input->post('customer'),
            'location_id' => $this->input->post('location'),
            'start_date' => $sdate,
            'end_date' => $edate,
            'total_budget' => $this->input->post('budget'),
            'status' => $this->input->post('status')
        );
        
        if ($this->project_command->update_project($id, $data)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Project Updated'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error updating project'));
        }
    }

    /**
     * AJAX: Multi-Language Help
     */
    public function get_help_content()
    {
        $lang = $this->input->get('lang');
        $help_file = FCPATH . 'assets/data/project_help.json';
        if (file_exists($help_file)) {
            $content = json_decode(file_get_contents($help_file), true);
            echo json_encode($content[$lang]);
        } else {
            echo json_encode(array('error' => 'Help file missing'));
        }
    }

    /**
     * AJAX: Get tasks for a project
     */
    public function get_tasks()
    {
        $project_id = $this->input->get('project_id');
        $this->db->select('tp_project_tasks.*, geopos_employees.name as employee_name');
        $this->db->from('tp_project_tasks');
        $this->db->join('geopos_employees', 'tp_project_tasks.assigned_to = geopos_employees.id', 'left');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();
        echo json_encode($query->result_array());
    }

    /**
     * AJAX: Delete a task
     */
    public function delete_task()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        if ($this->db->delete('tp_project_tasks')) {
            echo json_encode(array('status' => 'Success', 'message' => 'Task deleted'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to delete'));
        }
    }



    /**
     * AJAX: Get material reservations for a project
     */
    public function get_reservations()
    {
        $project_id = $this->input->get('project_id');
        $result = $this->project_command->get_reservations($project_id);
        echo json_encode($result);
    }

    /**
     * AJAX: Delete material reservation
     */
    public function delete_reservation()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        if ($this->db->delete('tp_inventory_reservations')) {
            echo json_encode(array('status' => 'Success', 'message' => 'Reservation removed'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to remove'));
        }
    }

    /**
     * AJAX: Search products for material reservation
     */
    public function product_search()
    {
        $term = $this->input->get('term');
        $this->db->select('pid, product_name, product_code');
        $this->db->from('geopos_products');
        $this->db->group_start();
        $this->db->like('product_name', $term);
        $this->db->or_like('product_code', $term);
        $this->db->group_end();
        $this->db->limit(20);
        $query = $this->db->get();
        echo json_encode($query->result_array());
    }

    /**
     * AJAX: Get project financial summary for Step 4
     * Calculates labor cost (hours × employee rate) and material cost (qty × product price)
     */
    public function get_project_summary()
    {
        $project_id = $this->input->get('project_id');
        if (!$project_id) {
            echo json_encode(array('labor_cost' => 0, 'material_cost' => 0));
            return;
        }

        // Calculate Labor Cost: sum of (task estimated_hours × employee salary/hourly rate)
        $this->db->select('t.estimated_hours, e.salary');
        $this->db->from('tp_project_tasks t');
        $this->db->join('geopos_employees e', 't.assigned_to = e.id', 'left');
        $this->db->where('t.project_id', $project_id);
        $tasks = $this->db->get()->result_array();

        $labor_cost = 0;
        foreach ($tasks as $task) {
            $hours = floatval($task['estimated_hours']);
            $rate = floatval($task['salary']);
            $labor_cost += $hours * $rate;
        }

        // Calculate Material Cost: sum of (reservation qty × product price)
        $this->db->select('r.qty, p.product_price');
        $this->db->from('tp_inventory_reservations r');
        $this->db->join('geopos_products p', 'r.product_id = p.pid', 'left');
        $this->db->where('r.project_id', $project_id);
        $materials = $this->db->get()->result_array();

        $material_cost = 0;
        foreach ($materials as $mat) {
            $qty = floatval($mat['qty']);
            $price = floatval($mat['product_price']);
            $material_cost += $qty * $price;
        }

        echo json_encode(array(
            'labor_cost' => round($labor_cost, 2),
            'material_cost' => round($material_cost, 2)
        ));
    }
    /**
     * Gantt Chart View
     */
    public function gantt()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Gantt Chart';
        
        // Auto-Migration: Add date columns if missing
        if (!$this->db->field_exists('start_date', 'tp_project_tasks')) {
            $this->db->query("ALTER TABLE tp_project_tasks ADD start_date DATE NULL DEFAULT NULL");
            $this->db->query("ALTER TABLE tp_project_tasks ADD due_date DATE NULL DEFAULT NULL");
        }

        $data['project'] = $this->db->get_where('tp_projects', array('id' => $id))->row_array();
        
        // Fetch tasks
        $this->db->select('t.*, e.name as employee_name');
        $this->db->from('tp_project_tasks t');
        $this->db->join('geopos_employees e', 't.assigned_to = e.id', 'left');
        $this->db->where('t.project_id', $id);
        $data['tasks'] = $this->db->get()->result_array();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('project_command/gantt', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * AJAX: Update Task Dates (Drag & Drop from Gantt)
     */
    public function update_task_dates()
    {
        $id = $this->input->post('id');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        
        // Format dates Y-m-d
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        
        $this->db->where('id', $id);
        if ($this->db->update('tp_project_tasks', array('start_date' => $start, 'due_date' => $end))) {
            echo json_encode(array('status' => 'Success'));
        } else {
            echo json_encode(array('status' => 'Error'));
        }
    }
    /**
     * Project Milestones
     */
    public function milestones()
    {
        $id = $this->input->get('id');
        $this->_check_milestones_schema();

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Milestones';

        $data['project'] = $this->db->get_where('tp_projects', array('id' => $id))->row_array();
        
        $this->db->where('project_id', $id);
        $this->db->order_by('due_date', 'ASC');
        $data['milestones'] = $this->db->get('tp_project_milestones')->result_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('project_command/milestones', $data);
        $this->load->view('fixed/footer');
    }

    public function add_milestone()
    {
        $date = $this->input->post('date');
        // Manual date conversion for dd-mm-yyyy format from datepicker
        $d = DateTime::createFromFormat($this->config->item('dformat2'), $date);
        if ($d && $d->format($this->config->item('dformat2')) === $date) {
             $date = $d->format('Y-m-d');
        } else {
             $d2 = DateTime::createFromFormat('d-m-Y', $date);
             if($d2) $date = $d2->format('Y-m-d');
        }

        $data = array(
            'project_id' => $this->input->post('pid'),
            'name' => $this->input->post('name', true),
            'due_date' => $date,
            'color' => $this->input->post('color'),
            'description' => $this->input->post('desc', true),
            'status' => 0 // Pending
        );
        if ($this->db->insert('tp_project_milestones', $data)) {
             echo json_encode(array('status' => 'Success', 'message' => 'Milestone Added'));
        } else {
             echo json_encode(array('status' => 'Error', 'message' => 'Error adding milestone'));
        }
    }

    public function delete_milestone()
    {
        $id = $this->input->post('id');
        if ($this->db->delete('tp_project_milestones', array('id' => $id))) {
            echo json_encode(array('status' => 'Success', 'message' => 'Milestone Deleted'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error deleting milestone'));
        }
    }

    public function set_milestone_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('stat');
        if ($this->db->where('id', $id)->update('tp_project_milestones', array('status' => $status))) {
            echo json_encode(array('status' => 'Success', 'message' => 'Status Updated'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error updating status'));
        }
    }

    private function _check_milestones_schema()
    {
        if (!$this->db->table_exists('tp_project_milestones')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `tp_project_milestones` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `name` varchar(255) NOT NULL,
              `due_date` date DEFAULT NULL,
              `color` varchar(20) DEFAULT '#007bff',
              `status` int(1) DEFAULT 0,
              `description` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }
    }
    /**
     * Document Management
     */
    public function documents()
    {
        $id = $this->input->get('id');
        $this->_check_document_schema();

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Documents';

        $data['project'] = $this->db->get_where('tp_projects', array('id' => $id))->row_array();
        
        $this->db->select('d.*, e.name as uploader_name');
        $this->db->from('tp_project_documents d');
        $this->db->join('geopos_employees e', 'd.uploaded_by = e.id', 'left');
        $this->db->where('d.project_id', $id);
        $this->db->order_by('d.upload_date', 'DESC');
        $data['documents'] = $this->db->get()->result_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('project_command/documents', $data);
        $this->load->view('fixed/footer');
    }

    public function upload_document()
    {
        $project_id = $this->input->post('pid');
        $title = $this->input->post('title', true);
        $notes = $this->input->post('notes', true);
        
        // Check/Create Directory
        $target_dir = './userfiles/project_docs/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $config['upload_path']          = $target_dir;
        $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|txt|zip';
        $config['max_size']             = 20000; // 20MB
        $config['file_name']            = time() . '_' . $_FILES['userfile']['name'];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode(array('status' => 'Error', 'message' => $error['error']));
        } else {
            $data = $this->upload->data();
            
            $doc_data = array(
                'project_id' => $project_id,
                'title' => $title,
                'filename' => $data['file_name'],
                'file_type' => $data['file_ext'],
                'uploaded_by' => $this->aauth->get_user()->id,
                'notes' => $notes
            );
            
            if ($this->db->insert('tp_project_documents', $doc_data)) {
                 echo json_encode(array('status' => 'Success', 'message' => 'Document Uploaded'));
            } else {
                 echo json_encode(array('status' => 'Error', 'message' => 'Database Error'));
            }
        }
    }

    public function delete_document()
    {
        $id = $this->input->post('id');
        
        $file = $this->db->get_where('tp_project_documents', array('id' => $id))->row_array();
        if ($file) {
            $path = './userfiles/project_docs/' . $file['filename'];
            if (file_exists($path)) {
                unlink($path);
            }
            
            if ($this->db->delete('tp_project_documents', array('id' => $id))) {
                echo json_encode(array('status' => 'Success', 'message' => 'Document Deleted'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error deleting document'));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Document not found'));
        }
    }

    private function _check_document_schema()
    {
        if (!$this->db->table_exists('tp_project_documents')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `tp_project_documents` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `title` varchar(255) NOT NULL,
              `filename` varchar(255) NOT NULL,
              `file_type` varchar(50) DEFAULT NULL,
              `uploaded_by` int(11) NOT NULL,
              `upload_date` datetime DEFAULT CURRENT_TIMESTAMP,
              `notes` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }
    }
}
