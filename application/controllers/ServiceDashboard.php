<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        // role 5 = Service Provider / Worker (Example, need to verify)
        if (!($this->aauth->get_user()->roleid == 1 || $this->aauth->control(5))) {
             redirect('/dashboard/', 'refresh');
        }
        $this->load->model('worker_model', 'worker');
        $this->load->model('job_portal_model', 'job_portal');
    }

    public function index()
    {
        $head['title'] = 'Service Provider Dashboard';
        $user_id = $this->aauth->get_user()->id;

        $this->load->model('providers_model', 'providers');
        $this->load->model('services_model', 'services');

        // Get provider specific record
        $provider = $this->providers->get_provider_by_user($user_id);
        
        if (!$provider) {
            // Auto-create provider record if it doesn't exist for this user role
            $this->db->insert('tp_service_providers', array('user_id' => $user_id));
            $provider = $this->providers->get_provider_by_user($user_id);
        }

        $data['provider'] = $provider;
        $data['my_skills'] = $this->providers->get_skills($provider['id']);
        $data['master_services'] = $this->services->get_all();

        // Get current on-demand job (Accepted or Ongoing)
        $this->db->select('r.*, s.service_name, c.name as customer_name, c.phone as customer_phone');
        $this->db->from('tp_service_requests r');
        $this->db->join('tp_services s', 'r.service_id = s.id');
        $this->db->join('geopos_customers c', 'r.customer_id = c.id');
        $this->db->where('r.provider_id', $provider['id']);
        $this->db->where_in('r.status', array(2, 3)); // 2: Accepted, 3: Ongoing
        $data['current_job'] = $this->db->get()->row_array();

        // Get on-demand earnings
        $data['wallet'] = $this->worker->get_on_demand_earnings($provider['id']);

        // Get earnings summary
        $data['earnings'] = $this->worker->get_worker_earnings($user_id);
        
        // Get active jobs
        $data['active_jobs'] = $this->job_portal->get_worker_active_jobs($user_id);
        
        // Get available job requests in their area
        $loc = $this->aauth->get_user()->loc;
        $data['available_jobs'] = $this->job_portal->get_available_jobs_by_loc($loc);

        $this->load->view('fixed/header-va', $head);
        $this->load->view('dashboards/service_provider', $data);
        $this->load->view('fixed/footer');
    }

    public function update_onboarding()
    {
        $user_id = $this->aauth->get_user()->id;
        $this->load->model('providers_model', 'providers');
        $provider = $this->providers->get_provider_by_user($user_id);

        if ($this->input->post()) {
            $data = array();
            // KYC Upload Logic
            $config['upload_path'] = './userfiles/provider_docs/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
            $config['max_size'] = 5120; // 5MB
            $this->load->library('upload', $config);

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            if ($this->upload->do_upload('nic_doc')) {
                $data['nic_doc'] = $this->upload->data('file_name');
            }
            if ($this->upload->do_upload('license_doc')) {
                $data['license_doc'] = $this->upload->data('file_name');
            }

            if (!empty($data)) {
                $this->providers->update_kyc($provider['id'], $data);
            }

            // Skill Selection Logic
            $selected_services = $this->input->post('services');
            $prices = $this->input->post('prices');
            $skills_to_save = array();

            if (is_array($selected_services)) {
                foreach ($selected_services as $s_id) {
                    $skills_to_save[] = array(
                        'service_id' => $s_id,
                        'price' => isset($prices[$s_id]) ? $prices[$s_id] : 0
                    );
                }
            }
            $this->providers->save_skills($provider['id'], $skills_to_save);

            redirect('ServiceDashboard/index?msg=Profile Updated');
        }
    }

    public function toggle_status()
    {
        $user_id = $this->aauth->get_user()->id;
        $type = $this->input->post('type');
        $s_id = $this->input->post('s_id');
        $status = isset($s_id) ? $s_id : 1;
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');

        $this->load->model('providers_model', 'providers');
        $provider = $this->providers->get_provider_by_user($user_id);

        if ($provider) {
            $update_data = array(
                'is_online' => $status,
                'last_active' => date('Y-m-d H:i:s')
            );
            if ($status == 1 && $lat != 0) {
                $update_data['current_lat'] = $lat;
                $update_data['current_lng'] = $lng;
            }
            $this->providers->update_kyc($provider['id'], $update_data);
            
            // Log live tracking if online
            if ($status == 1) {
                $this->db->insert('tp_live_tracking', array(
                    'provider_id' => $provider['id'],
                    'lat' => $lat,
                    'lng' => $lng,
                    'recorded_at' => date('Y-m-d H:i:s')
                ));
            }

            echo json_encode(array('status' => 'Success'));
        }
    }

    public function request_payout()
    {
        $user_id = $this->aauth->get_user()->id;
        $amount = (float)$this->input->post('amount');
        $provider = $this->providers->get_provider_by_user($user_id);

        if ($provider && $amount >= 500) {
            $data = array(
                'provider_id' => $provider['id'],
                'amount' => $amount,
                'status' => 0, // Pending
                'requested_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('tp_withdrawal_requests', $data);
            $this->session->set_flashdata('message', 'Payout request submitted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Invalid amount or provider.');
        }
        redirect('ServiceDashboard');
    }
}
