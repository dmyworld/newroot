<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Worker extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Worker_model', 'worker');
        $this->load->model('Employee_model', 'employee');
        $this->li_a = 'worker';
    }

    /**
     * Browse available workers (Public view - no login required)
     */
    public function index()
    {
        $category = $this->input->get('category');
        $location = $this->input->get('location');

        $data['workers'] = $this->worker->get_active_workers($category, $location);
        $data['categories'] = $this->worker->get_worker_categories();
        $data['is_logged_in'] = $this->aauth->is_loggedin();

        // Public view
        $head['title'] = "Browse Workers";
        $this->load->view('landing_page/includes/header', $head);
        $this->load->view('landing_page/includes/nav');
        $this->load->view('worker/browse_public', $data);
        $this->load->view('landing_page/includes/footer');
    }

    /**
     * Worker registration form (Seller view)
     */
    public function register()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $user_id = $this->aauth->get_user()->id;
        $data['profile'] = $this->worker->get_profile_by_user($user_id);
        $data['categories'] = $this->worker->get_worker_categories();

        $head['title'] = "Worker Registration";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/register', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Submit worker profile
     */
    public function submit()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Unauthorized'));
            return;
        }

        $user_id = $this->aauth->get_user()->id;
        $skills_raw = $this->input->post('skills');
        $skills = is_array($skills_raw) ? $skills_raw : explode(',', $skills_raw);

        $data = array(
            'display_name' => $this->input->post('display_name'),
            'category_id' => $this->input->post('category_id'),
            'experience_years' => $this->input->post('experience_years'),
            'skills' => $skills,
            'pay_type' => $this->input->post('pay_type') ?? 'hourly',
            'pay_rate' => $this->input->post('pay_rate') ?? 0,
            'bio' => $this->input->post('bio'),
            'phone' => $this->input->post('phone'),
            'location' => $this->input->post('location')
        );

        // Handle photo upload
        if (!empty($_FILES['photo']['name'])) {
            $config['upload_path'] = './uploads/worker_photos/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = 'worker_' . $user_id . '_' . time();
            
            // Create directory if it doesn't exist
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }

            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('photo')) {
                $upload_data = $this->upload->data();
                $data['photo'] = 'uploads/worker_photos/' . $upload_data['file_name'];
            }
        }

        // Check if updating or creating
        $existing = $this->worker->get_profile_by_user($user_id);
        if ($existing) {
            $result = $this->worker->update_profile($user_id, $data);
        } else {
            $result = $this->worker->create_profile($user_id, $data);
        }

        echo json_encode($result);
    }

    /**
     * View single worker profile
     */
    public function view($id)
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $data['worker'] = $this->worker->get_worker_profile($id);
        if (!$data['worker']) {
            show_404();
        }

        $data['worker']['skills_array'] = json_decode($data['worker']['skills'], true);

        $head['title'] = "Worker Profile - " . $data['worker']['display_name'];
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/view', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Hire a worker (Buyer action)
     */
    public function hire()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Unauthorized'));
            return;
        }

        $worker_id = $this->input->post('worker_id');
        $salary = $this->input->post('salary');
        $commission = $this->input->post('commission') ?? 0;

        $worker = $this->worker->get_worker_profile($worker_id);
        if (!$worker) {
            echo json_encode(array('status' => 'Error', 'message' => 'Worker not found'));
            return;
        }

        $buyer_id = $this->aauth->get_user()->id;
        $buyer_loc = $this->aauth->get_user()->loc;

        // Create employee record using existing Employee_model
        $this->employee->add_employee(
            $worker['user_id'],           // User ID
            $worker['username'],           // Username
            $worker['display_name'],       // Name
            3,                             // Default role (Employee)
            $worker['phone'],              // Phone
            '',                            // Address
            '',                            // City
            '',                            // Region
            '',                            // Country
            '',                            // Postbox
            $buyer_loc,                    // Location (buyer's location)
            $salary,                       // Salary
            $commission,                   // Commission
            $worker['category_id']         // Department
        );

        // Update worker availability
        $this->worker->update_availability($worker_id, 'busy');

        echo json_encode(array(
            'status' => 'Success',
            'message' => $worker['display_name'] . ' has been hired and added to your employee roster!'
        ));
    }

    /* ------------------------------------------------------------------
     * Services & Professionals Hub (Enterprise Extensions)
     * ------------------------------------------------------------------ */

    public function job_requests()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "Job Request Hub";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['jobs'] = $this->worker->get_job_requests($loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/job_requests', $data);
        $this->load->view('fixed/footer');
    }

    public function profiles()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "Workforce Profiles";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['profiles'] = $this->worker->get_profiles($loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/profiles', $data);
        $this->load->view('fixed/footer');
    }

    public function attendance()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "Attendance & Payroll Tracking";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $data['attendance'] = $this->worker->get_attendance($loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/attendance', $data);
        $this->load->view('fixed/footer');
    }

    public function clock()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        
        $user_id = $this->aauth->get_user()->id;
        
        // Handle Clock Action
        if ($this->input->post('action')) {
            $action = $this->input->post('action');
            $note = $this->input->post('note') ?? '';
            $this->worker->log_attendance($user_id, $action, $note);
            redirect('worker/clock');
        }

        $data['status'] = $this->worker->get_clock_status($user_id);
        $data['history'] = $this->worker->get_attendance_history($user_id);
        
        $head['title'] = "Professional Attendance Clock";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/clock', $data);
        $this->load->view('fixed/footer');
    }

    public function payroll()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        
        $user_id = $this->aauth->get_user()->id;
        $month = $this->input->get('month') ?? date('m');
        $year = $this->input->get('year') ?? date('Y');
        
        $start_date = "$year-$month-01";
        $end_date = date('Y-m-t', strtotime($start_date));
        
        $data['earnings'] = $this->worker->calculate_earnings($user_id, $start_date, $end_date);
        $data['history'] = $this->worker->get_attendance_history($user_id, 30);
        $data['month'] = $month;
        $data['year'] = $year;
        
        $head['title'] = "Earnings & Payroll Dashboard";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/payroll', $data);
        $this->load->view('fixed/footer');
    }
}
