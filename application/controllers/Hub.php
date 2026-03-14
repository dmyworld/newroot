<?php
/**
 * Timber Pro Hub Controller
 * Handles Registration, Login, and Subscription Logic for the new ecosystem.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Hub extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->library("Captcha_u");
        $this->load->library("form_validation");
        $this->load->model('employee_model', 'employee'); // Load Model
        $this->load->model('tenant_model', 'tenant');
        $this->load->model('locations_model', 'locations');
        
        $captchaHeader = $this->captcha_u->public_key();
        $this->captcha = isset($captchaHeader->captcha) ? $captchaHeader->captcha : false;
    }

    // Main Hub Login Page (since User/index is now Landing Page)
    public function login()
    {
        if ($this->aauth->is_loggedin()) {
            redirect('/dashboard/', 'refresh');
        }

        $data['response'] = '';
        $data['captcha_on'] = $this->captcha;
        $captchaHeader = $this->captcha_u->public_key();
        $data['captcha'] = isset($captchaHeader->recaptcha_p) ? $captchaHeader->recaptcha_p : false;

        if ($this->input->get('e')) {
            $data['response'] = 'Invalid username or password!';
        }

        // Reuse the existing User/Index view for login, but served via Hub/login
        $this->load->view('user/index', $data);
    }

    public function register()
    {
        if ($this->aauth->is_loggedin()) {
            redirect('/dashboard/', 'refresh');
        }

        if ($this->input->post()) {
            $this->handle_unified_registration();
        } else {
            $data['type'] = 'User';
            $this->load->view('hub/register_wizard', $data);
        }
    }

    public function demo_login($type)
    {
        $credentials = [
            'customer' => ['username' => 'demo_customer', 'pass' => 'demo123'],
            'owner'    => ['username' => 'demo_owner', 'pass' => 'demo123'],
            'provider' => ['username' => 'demo_provider', 'pass' => 'demo123']
        ];

        if (isset($credentials[$type])) {
            $this->aauth->login($credentials[$type]['username'], $credentials[$type]['pass'], false, null, false);
            redirect('/dashboard/', 'refresh');
        } else {
            redirect('hub/register');
        }
    }

    private function handle_unified_registration()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['response'] = validation_errors();
            $this->load->view('hub/register_wizard', $data);
        } else {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $mobile = $this->input->post('mobile');
            $role_name = $this->input->post('role'); // Customer, Business Owner, Service Provider
            $plan = $this->input->post('plan');

            // Create user
            $user_id = $this->aauth->create_user($email, $password, $username);

            if ($user_id) {
                // Set user status to 1 to allow login, subscription_status will control access
                $this->db->where('id', $user_id)->update('aauth_users', ['status' => 1]);

                // Map role name to ID
                $role_id = 13; // Default to Customer
                if ($role_name === 'Business Owner') $role_id = 5;
                if ($role_name === 'Service Provider') $role_id = 12;
                
                // Subscription Logic
                $plan_id = intval($plan);
                $sub_status = ($plan_id == 1) ? 'active' : 'pending';
                
                // Initialize Tenant for Business Owners
                $loc_id = 1;
                if ($role_id == 5) {
                    $loc_id = $this->tenant->initialize_tenant($user_id, $username);
                }

                // Add to geopos_users
                $this->db->set([
                    'id' => $user_id,
                    'username' => $username,
                    'email' => $email,
                    'roleid' => $role_id,
                    'loc' => $loc_id,
                    'subscription_status' => $sub_status
                ]);
                $this->db->insert('geopos_users');

                // Add to tp_subscriptions
                $this->db->insert('tp_subscriptions', [
                    'user_id' => $user_id,
                    'plan_id' => $plan_id,
                    'status' => $sub_status,
                    'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days'))
                ]);

                // Add Employee Record
                ob_start();
                $this->employee->add_employee($user_id, $username, $username, $role_id, $mobile, '', '', '', '', '', $loc_id);
                ob_end_clean();

                // Show Success Message
                $data['success'] = true;
                $data['username'] = $username;
                $this->load->view('hub/register_wizard', $data);
                
                // Auto login
                $this->aauth->login($username, $password, false, null, false);
            } else {
                $data['response'] = "Registration failed. Email or Username might be taken.";
                $this->load->view('hub/register_wizard', $data);
            }
        }
    }

    public function register_buyer() { redirect('hub/register'); }
    public function register_seller() { redirect('hub/register'); }

    private function handle_registration($type)
    {
        // Relaxed validation as requested: removed min/max length and is_unique
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['type'] = ucfirst($type);
            $data['response'] = validation_errors();
            $this->load->view('hub/register', $data);
        } else {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $mobile = $this->input->post('mobile');
            $company = ''; // Optional/Removed from form

            // Try to create user
            $user_id = $this->aauth->create_user($email, $password, $username);

            // If creation failed, check if it's an "Orphaned" user (exists in users but not employees)
            if (!$user_id) {
                 // Check by email
                 $query = $this->db->get_where('geopos_users', ['email' => $email]);
                 $existing_user = $query->row();
                 
                 // If not found by email, check by username
                 if (!$existing_user) {
                     $query = $this->db->get_where('geopos_users', ['username' => $username]);
                     $existing_user = $query->row();
                 }

                 if ($existing_user) {
                     // Check if employee record exists
                     $emp_query = $this->db->get_where('geopos_employees', ['id' => $existing_user->id]);
                     if ($emp_query->num_rows() == 0) {
                         // ORPHAN DETECTED! Resume registration with this ID.
                         $user_id = $existing_user->id;
                         
                         // Optional: Update password to match new input if desired? 
                         // For now, we assume they are retrying and just want to finish.
                     }
                 }
            }

            if ($user_id) {
                // Determine Role ID dynamically from geopos_roles
                $role_id = 5; // Default fallback (standard user)
                
                // Try to find role by name (Buyer/Seller)
                $role_query = $this->db->get_where('geopos_roles', ['name' => ucfirst($type)]);
                if ($role_query->num_rows() == 0) {
                     $role_query = $this->db->get_where('geopos_roles', ['name' => $type]);
                }
                
                if ($role_query->num_rows() > 0) {
                    $role_id = $role_query->row()->id;
                }

                // Create Employee Profile (Required for System Logic)
                $name = $username;
                
                 // Check if employee already exists (double check)
                $emp_check = $this->db->get_where('geopos_employees', ['id' => $user_id]);
                if ($emp_check->num_rows() == 0) {
                    
                    // Initialize Multi-Tenant Environment
                    $loc_id = $this->tenant->initialize_tenant($user_id, $username);
                    if(!$loc_id) $loc_id = 1; // Fallback to default if init fails

                    // Add Employee Record with Output Buffering to suppress JSON echo
                    ob_start();
                    $this->employee->add_employee(
                        $user_id, 
                        $username, 
                        $name, 
                        $role_id, // Dynamically determined Role ID
                        $mobile, 
                        '', '', '', '', '', // Address fields
                        $loc_id // Assigned Tenant Location
                    );
                    ob_end_clean();
                }

                // Auto-Login
                $this->aauth->login($email, $password, false, null, false);
                redirect('/dashboard/', 'refresh');

            } else {
                $data['type'] = ucfirst($type);
                $data['response'] = "Account creation failed. Email or Username might be taken.";
                $this->load->view('hub/register', $data);
            }
        }
    }


}
