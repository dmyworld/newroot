<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Job_Portal_model', 'job_portal');
        $this->load->model('Worker_model', 'worker');
        $this->li_a = 'jobs';
    }

    /**
     * Public Job Board
     */
    public function index()
    {
        $data['jobs'] = $this->job_portal->get_jobs($this->aauth->get_user()->loc);
        $data['is_logged_in'] = $this->aauth->is_loggedin();

        $head['title'] = "Timber Industry Job Portal";
        $this->load->view('fixed/header', $head);
        $this->load->view('jobs/index', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Post a new Job (Employee/Admin action)
     */
    public function post()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 3) {
            exit('<h3>Unauthorized</h3>');
        }

        $this->db->select('id, val1');
        $this->db->from('geopos_hrm');
        $this->db->where('type', 0); // Departments
        $data['departments'] = $this->db->get()->result_array();

        $head['title'] = "Post a New Job";
        $this->load->view('fixed/header', $head);
        $this->load->view('jobs/post', $data);
        $this->load->view('fixed/footer');
    }

    public function submit()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Unauthorized'));
            return;
        }

        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'dept_id' => $this->input->post('dept_id'),
            'hourly_rate_min' => $this->input->post('hourly_rate_min'),
            'hourly_rate_max' => $this->input->post('hourly_rate_max'),
            'location' => $this->input->post('location'),
            'loc' => $this->aauth->get_user()->loc
        );

        $result = $this->job_portal->post_job($data);
        echo json_encode($result);
    }

    /**
     * Manage Jobs and Applications (For Employers)
     */
    public function manage()
    {
        if (!$this->aauth->is_loggedin() || $this->aauth->get_user()->roleid < 3) {
            redirect('/dashboard/', 'refresh');
        }

        $data['jobs'] = $this->job_portal->get_jobs($this->aauth->get_user()->loc, null); // All statuses

        $head['title'] = "Manage Recruitment";
        $this->load->view('fixed/header', $head);
        $this->load->view('jobs/manage', $data);
        $this->load->view('fixed/footer');
    }

    public function applications($job_id)
    {
        if (!$this->aauth->is_loggedin() || $this->aauth->get_user()->roleid < 3) {
            redirect('/dashboard/', 'refresh');
        }

        $data['applications'] = $this->job_portal->get_applications($job_id);
        
        $head['title'] = "Job Applications";
        $this->load->view('fixed/header', $head);
        $this->load->view('jobs/applications', $data);
        $this->load->view('fixed/footer');
    }

    public function hire()
    {
        if (!$this->aauth->is_loggedin() || $this->aauth->get_user()->roleid < 3) {
            echo json_encode(array('status' => 'Error', 'message' => 'Unauthorized'));
            return;
        }

        $app_id = $this->input->post('app_id');
        $result = $this->job_portal->hire_candidate($app_id);
        echo json_encode($result);
    }
}
