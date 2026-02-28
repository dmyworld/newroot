<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_Portal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_ensure_tables();
    }

    private function _ensure_tables()
    {
        $this->load->dbforge();
        
        // geopos_jobs
        if (!$this->db->table_exists('geopos_jobs')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'title' => array('type' => 'VARCHAR', 'constraint' => 255),
                'description' => array('type' => 'TEXT'),
                'dept_id' => array('type' => 'INT', 'constraint' => 11),
                'hourly_rate_min' => array('type' => 'DECIMAL', 'constraint' => '16,2', 'default' => 0),
                'hourly_rate_max' => array('type' => 'DECIMAL', 'constraint' => '16,2', 'default' => 0),
                'location' => array('type' => 'VARCHAR', 'constraint' => 255),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'status' => array('type' => 'ENUM("open", "closed", "filled")', 'default' => 'open'),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_jobs');
        }

        // geopos_job_applications
        if (!$this->db->table_exists('geopos_job_applications')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'job_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
                'worker_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
                'status' => array('type' => 'ENUM("pending", "shortlisted", "rejected", "hired")', 'default' => 'pending'),
                'applied_at' => array('type' => 'DATETIME', 'null' => TRUE),
                'resume_path' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
                'cover_letter' => array('type' => 'TEXT', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_job_applications');
        }
    }

    public function post_job($data)
    {
        $job = array(
            'title' => $data['title'],
            'description' => $data['description'],
            'dept_id' => $data['dept_id'],
            'hourly_rate_min' => $data['hourly_rate_min'] ?? 0,
            'hourly_rate_max' => $data['hourly_rate_max'] ?? 0,
            'location' => $data['location'] ?? '',
            'loc' => $data['loc'] ?? 0,
            'status' => 'open',
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('geopos_jobs', $job)) {
            return array('status' => 'Success', 'message' => 'Job posted successfully!', 'id' => $this->db->insert_id());
        }
        return array('status' => 'Error', 'message' => 'Failed to post job.');
    }

    public function get_jobs($loc = null, $status = 'open')
    {
        $this->db->select('j.*, d.val1 as dept_name');
        $this->db->from('geopos_jobs j');
        $this->db->join('geopos_hrm d', 'j.dept_id = d.id', 'left');
        if ($loc) $this->db->where('j.loc', $loc);
        if ($status) $this->db->where('j.status', $status);
        $this->db->order_by('j.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function apply_job($job_id, $worker_id, $data = array())
    {
        // Check if already applied
        $this->db->where('job_id', $job_id);
        $this->db->where('worker_id', $worker_id);
        if ($this->db->get('geopos_job_applications')->row()) {
            return array('status' => 'Error', 'message' => 'You have already applied for this job.');
        }

        $app = array(
            'job_id' => $job_id,
            'worker_id' => $worker_id,
            'status' => 'pending',
            'applied_at' => date('Y-m-d H:i:s'),
            'resume_path' => $data['resume_path'] ?? null,
            'cover_letter' => $data['cover_letter'] ?? null
        );

        if ($this->db->insert('geopos_job_applications', $app)) {
            return array('status' => 'Success', 'message' => 'Application submitted.');
        }
        return array('status' => 'Error', 'message' => 'Failed to apply.');
    }

    public function get_applications($job_id)
    {
        $this->db->select('a.*, w.display_name, w.experience_years, w.average_rating');
        $this->db->from('geopos_job_applications a');
        $this->db->join('geopos_worker_profiles w', 'a.worker_id = w.id');
        $this->db->where('a.job_id', $job_id);
        return $this->db->get()->result_array();
    }

    public function hire_candidate($app_id)
    {
        $this->db->trans_start();

        // Get application and job details
        $this->db->select('a.*, j.title, j.dept_id, j.loc, w.user_id, w.display_name, w.hourly_rate, w.phone');
        $this->db->from('geopos_job_applications a');
        $this->db->join('geopos_jobs j', 'a.job_id = j.id');
        $this->db->join('geopos_worker_profiles w', 'a.worker_id = w.id');
        $this->db->where('a.id', $app_id);
        $candidate = $this->db->get()->row_array();

        if (!$candidate) return array('status' => 'Error', 'message' => 'Candidate not found.');

        // 1. Create Employee Record
        $employee = array(
            'id' => $candidate['user_id'],
            'username' => 'worker_' . $candidate['user_id'],
            'name' => $candidate['display_name'],
            'phone' => $candidate['phone'],
            'salary' => $candidate['hourly_rate'] * 160, // Basic monthly estimate
            'c_rate' => 0,
            'dept' => $candidate['dept_id'],
            'joindate' => date('Y-m-d')
        );
        $this->db->insert('geopos_employees', $employee);

        // 2. Update User Role and Location
        $this->db->where('id', $candidate['user_id']);
        $this->db->update('geopos_users', array(
            'roleid' => 3, // Employee role
            'loc' => $candidate['loc'] // Assign to the branch where the job was posted
        ));

        // 3. Update Application Status
        $this->db->where('id', $app_id);
        $this->db->update('geopos_job_applications', array('status' => 'hired'));

        // 4. Mark Job as Filled
        $this->db->where('id', $candidate['job_id']);
        $this->db->update('geopos_jobs', array('status' => 'filled'));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return array('status' => 'Error', 'message' => 'Failed to hire candidate.');
        }
        return array('status' => 'Success', 'message' => 'Candidate hired as employee and assigned to branch #' . $candidate['loc']);
    }
}
