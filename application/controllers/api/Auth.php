<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'controllers/api/Api_base.php';

/**
 * Auth API
 * POST /api/auth/login
 * POST /api/auth/register
 * POST /api/auth/refresh
 * GET  /api/auth/me
 */
class Auth extends Api_base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
    }

    /**
     * POST /api/auth/login
     * Body: { "email": "...", "password": "..." }
     */
    public function login_post()
    {
        $email    = trim($this->post('email'));
        $password = $this->post('password');

        if (empty($email) || empty($password)) {
            $this->_fail('Email and password are required');
            return;
        }

        // Use Aauth login
        if ($this->aauth->login($email, $password)) {
            $user = $this->aauth->get_user();
            $token = $this->_generate_jwt([
                'uid'      => $user->id,
                'email'    => $user->email,
                'username' => $user->username,
                'role'     => $user->roleid,
                'loc'      => $user->loc,
            ]);

            $this->_log_action('LOGIN', 'users', $user->id);

            $this->_success([
                'token' => $token,
                'user'  => [
                    'id'       => $user->id,
                    'email'    => $user->email,
                    'username' => $user->username,
                    'role'     => $user->roleid,
                    'loc'      => $user->loc,
                ],
            ], 'Login successful');
        } else {
            $errors = $this->aauth->get_errors_array();
            $this->_fail('Invalid credentials', 401, $errors);
        }
    }

    /**
     * POST /api/auth/register
     * Body: { "email", "username", "password", "role_type": "buyer|seller|worker" }
     */
    public function register_post()
    {
        $email    = trim($this->post('email'));
        $username = trim($this->post('username'));
        $password = $this->post('password');
        $role_type = $this->post('role_type') ?: 'buyer';

        if (empty($email) || empty($username) || empty($password)) {
            $this->_fail('Email, username and password are required');
            return;
        }

        // Map role_type to role ID
        $role_map = ['admin' => 5, 'seller' => 4, 'worker' => 3, 'buyer' => 2, 'vendor' => 2];
        $role_id  = $role_map[$role_type] ?? 2;

        $created = $this->aauth->create_user($email, $password, $username);
        if ($created) {
            // Set role group
            $this->aauth->add_member($created, $role_id);

            $this->_log_action('REGISTER', 'users', $created, ['role_type' => $role_type]);

            $this->_success(['user_id' => $created], 'Account created successfully', 201);
        } else {
            $errors = $this->aauth->get_errors_array();
            $this->_fail('Registration failed', 400, $errors);
        }
    }

    /**
     * GET /api/auth/me
     * Requires Bearer token
     */
    public function me_get()
    {
        if (!$this->_authenticate()) return;

        $this->db->where('id', $this->current_user_id);
        $user = $this->db->get('geopos_users')->row_array();

        if (!$user) {
            $this->_fail('User not found', 404);
            return;
        }

        unset($user['password']);
        $this->_success(['user' => $user]);
    }

    /**
     * PUT /api/auth/update
     * Requires Bearer token
     * Body: { "username", "phone", "address" }
     */
    public function update_put()
    {
        if (!$this->_authenticate()) return;

        $allowed = ['username', 'phone', 'address', 'city'];
        $data = [];
        foreach ($allowed as $field) {
            $val = $this->put($field);
            if ($val !== null) $data[$field] = $val;
        }

        if (empty($data)) {
            $this->_fail('No fields to update');
            return;
        }

        $this->db->where('id', $this->current_user_id);
        $this->db->update('geopos_users', $data);

        $this->_log_action('UPDATE_PROFILE', 'users', $this->current_user_id, $data);
        $this->_success([], 'Profile updated');
    }
}
