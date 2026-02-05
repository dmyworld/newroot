<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carpentry_reports_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_costing_model');
    }

    public function get_projects_profitability()
    {
        $this->db->select('geopos_projects.id, geopos_projects.name, geopos_projects.worth, geopos_customers.name as customer_name');
        $this->db->from('geopos_projects');
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        $query = $this->db->get();
        $projects = $query->result_array();

        $report_data = array();

        foreach ($projects as $project) {
            $pid = $project['id'];
            
            // 1. Calculate Revenue (Invoices)
            $this->db->select_sum('total');
            $this->db->from('geopos_project_meta');
            $this->db->join('geopos_invoices', 'geopos_project_meta.meta_data = geopos_invoices.id', 'left');
            $this->db->where('geopos_project_meta.pid', $pid);
            $this->db->where('geopos_project_meta.meta_key', 11);
            // Optional: Check invoice status (paid vs due), assuming 'total' is invoiced amount
            $inv_query = $this->db->get();
            $revenue = $inv_query->row()->total;

            // 2. Calculate Material Cost
            $material_cost = $this->project_costing_model->get_total_cost($pid);

            // 3. Labor Cost (Placeholder for future implementation)
            $labor_cost = 0;

            $total_cost = $material_cost + $labor_cost;
            $profit = $revenue - $total_cost;

            $report_data[] = array(
                'id' => $project['id'],
                'name' => $project['name'],
                'customer' => $project['customer_name'],
                'budget' => $project['worth'],
                'revenue' => $revenue ? $revenue : 0,
                'material_cost' => $material_cost ? $material_cost : 0,
                'labor_cost' => $labor_cost,
                'total_cost' => $total_cost,
                'profit' => $profit
            );
        }

        return $report_data;
    }
}
