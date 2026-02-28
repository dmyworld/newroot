<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HubApi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library("Aauth");
    }

    public function login() {
        // Accept JSON or POST
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);
        
        $email = $request->email ?? $this->input->post('email');
        $password = $request->password ?? $this->input->post('password');

        if ($this->aauth->login($email, $password, false)) {
             $user = $this->aauth->get_user();
             // Check group
             $groups = $this->aauth->get_user_groups($user->id);
             
             echo json_encode([
                 'status' => 'success', 
                 'user_id' => $user->id, 
                 'username' => $user->username, 
                 'role_id' => $user->roleid,
                 'groups' => $groups
             ]);
        } else {
             echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
        }
    }

    public function check_status() {
         if ($this->aauth->is_loggedin()) {
             $user = $this->aauth->get_user();
             echo json_encode(['status' => 'logged_in', 'user' => $user]);
         } else {
             echo json_encode(['status' => 'logged_out']);
         }
    }
    
    public function logout() {
        $this->aauth->logout();
        echo json_encode(['status' => 'success', 'message' => 'Logged out']);
    }
}
