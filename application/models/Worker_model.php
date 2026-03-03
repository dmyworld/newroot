<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Worker_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_check_fields();
    }

    private function _check_fields()
    {
        if (!$this->db->field_exists('pay_type', 'geopos_worker_profiles')) {
            $this->load->dbforge();
            $this->dbforge->add_column('geopos_worker_profiles', array(
                'pay_type' => array('type' => 'ENUM("hourly", "daily", "monthly", "project")', 'default' => 'hourly'),
                'pay_rate' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00')
            ));
        }
    }

    /**
     * Create a new worker profile
     */
    public function create_profile($user_id, $data)
    {
        // Check if profile already exists
        $this->db->where('user_id', $user_id);
        $existing = $this->db->get('geopos_worker_profiles')->row_array();
        
        if ($existing) {
            return array('status' => 'Error', 'message' => 'Worker profile already exists. Please edit instead.');
        }

        $pay_type = $data['pay_type'] ?? 'hourly';
        $pay_rate = (float)($data['pay_rate'] ?? 0);
        
        // Calculate hourly_rate for internal use/sorting
        $hourly_rate = $pay_rate;
        if($pay_type === 'daily') $hourly_rate = $pay_rate / 8;
        if($pay_type === 'monthly') $hourly_rate = $pay_rate / 160;
        
        $profile = array(
            'user_id' => $user_id,
            'display_name' => $data['display_name'],
            'category_id' => $data['category_id'],
            'experience_years' => $data['experience_years'] ?? 0,
            'skills' => json_encode($data['skills'] ?? []),
            'hourly_rate' => $hourly_rate,
            'pay_type' => $pay_type,
            'pay_rate' => $pay_rate,
            'bio' => $data['bio'] ?? '',
            'phone' => $data['phone'] ?? '',
            'location' => $data['location'] ?? '',
            'availability' => 'available',
            'status' => 'active'
        );

        if ($this->db->insert('geopos_worker_profiles', $profile)) {
            return array('status' => 'Success', 'message' => 'Worker profile created successfully!', 'id' => $this->db->insert_id());
        }
        
        return array('status' => 'Error', 'message' => 'Failed to create worker profile.');
    }

    /**
     * Update worker profile
     */
    public function update_profile($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        $existing = $this->db->get('geopos_worker_profiles')->row_array();
        
        if (!$existing) {
            return array('status' => 'Error', 'message' => 'Worker profile does not exist.');
        }

        $pay_type = $data['pay_type'] ?? ($existing['pay_type'] ?? 'hourly');
        $pay_rate = (float)($data['pay_rate'] ?? ($existing['pay_rate'] ?? 0));
        
        // Calculate hourly_rate for internal use/sorting
        $hourly_rate = $pay_rate;
        if($pay_type === 'daily') $hourly_rate = $pay_rate / 8;
        if($pay_type === 'monthly') $hourly_rate = $pay_rate / 160;

        $update = array(
            'display_name' => $data['display_name'],
            'category_id' => $data['category_id'],
            'experience_years' => $data['experience_years'] ?? 0,
            'skills' => json_encode($data['skills'] ?? []),
            'hourly_rate' => $hourly_rate,
            'pay_type' => $pay_type,
            'pay_rate' => $pay_rate,
            'bio' => $data['bio'] ?? '',
            'phone' => $data['phone'] ?? '',
            'location' => $data['location'] ?? ''
        );

        $this->db->where('user_id', $user_id);
        if ($this->db->update('geopos_worker_profiles', $update)) {
            return array('status' => 'Success', 'message' => 'Profile updated successfully!');
        }
        
        return array('status' => 'Error', 'message' => 'Failed to update profile.');
    }

    /**
     * Get active workers (optionally filtered by category)
     */
    public function get_active_workers($category = null, $location = null)
    {
        $this->db->select('w.*, u.username, h.val1 as category_name');
        $this->db->from('geopos_worker_profiles w');
        $this->db->join('geopos_users u', 'w.user_id = u.id');
        $this->db->join('geopos_hrm h', 'w.category_id = h.id', 'left');
        $this->db->where('w.status', 'active');
        $this->db->where('w.availability', 'available');

        if ($category) {
            $this->db->where('w.category_id', $category);
        }

        if ($location) {
            $this->db->like('w.location', $location);
        }

        $this->db->order_by('w.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get worker profile by ID
     */
    public function get_worker_profile($id)
    {
        $this->db->select('w.*, u.username, u.email, h.val1 as category_name');
        $this->db->from('geopos_worker_profiles w');
        $this->db->join('geopos_users u', 'w.user_id = u.id');
        $this->db->join('geopos_hrm h', 'w.category_id = h.id', 'left');
        $this->db->where('w.id', $id);
        $worker = $this->db->get()->row_array();
        
        if ($worker) {
            $worker['badges'] = $this->get_skill_badges($id);
        }
        
        return $worker;
    }

    /**
     * Get worker profile by user ID
     */
    public function get_profile_by_user($user_id)
    {
        $this->db->select('w.*, h.val1 as category_name');
        $this->db->from('geopos_worker_profiles w');
        $this->db->join('geopos_hrm h', 'w.category_id = h.id', 'left');
        $this->db->where('w.user_id', $user_id);
        return $this->db->get()->row_array();
    }

    /**
     * Update availability status
     */
    public function update_availability($id, $status)
    {
        $allowed = array('available', 'busy', 'unavailable');
        if (!in_array($status, $allowed)) {
            return array('status' => 'Error', 'message' => 'Invalid availability status.');
        }

        $this->db->where('id', $id);
        if ($this->db->update('geopos_worker_profiles', array('availability' => $status))) {
            return array('status' => 'Success', 'message' => 'Availability updated.');
        }
        
        return array('status' => 'Error', 'message' => 'Failed to update availability.');
    }

    /**
     * Get categories for worker registration
     */
    public function get_worker_categories()
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('typ', 3); // Department type
        $this->db->order_by('val1', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Upload worker photo
     */
    public function upload_photo($user_id, $photo_path)
    {
        $this->db->where('user_id', $user_id);
        if ($this->db->update('geopos_worker_profiles', array('photo' => $photo_path))) {
            return array('status' => 'Success', 'message' => 'Photo uploaded successfully!');
        }
        return array('status' => 'Error', 'message' => 'Failed to upload photo.');
    }

    /**
     * Add rating for a worker
     */
    public function add_rating($worker_id, $buyer_id, $rating, $review = '')
    {
        // Check if buyer already rated this worker
        $this->db->where('worker_id', $worker_id);
        $this->db->where('buyer_id', $buyer_id);
        $existing = $this->db->get('geopos_worker_ratings')->row_array();

        if ($existing) {
            // Update existing rating
            $this->db->where('id', $existing['id']);
            $this->db->update('geopos_worker_ratings', array('rating' => $rating, 'review' => $review));
        } else {
            // Insert new rating
            $data = array(
                'worker_id' => $worker_id,
                'buyer_id' => $buyer_id,
                'rating' => $rating,
                'review' => $review
            );
            $this->db->insert('geopos_worker_ratings', $data);
        }

        // Update average rating
        $this->update_worker_rating($worker_id);
        
        return array('status' => 'Success', 'message' => 'Rating submitted successfully!');
    }

    /**
     * Update worker average rating
     */
    private function update_worker_rating($worker_id)
    {
        $this->db->select('AVG(rating) as avg_rating, COUNT(*) as total');
        $this->db->from('geopos_worker_ratings');
        $this->db->where('worker_id', $worker_id);
        $result = $this->db->get()->row_array();

        $this->db->where('id', $worker_id);
        $this->db->update('geopos_worker_profiles', array(
            'average_rating' => round($result['avg_rating'], 2),
            'total_ratings' => $result['total']
        ));
    }

    /**
     * Get worker ratings
     */
    public function get_worker_ratings($worker_id, $limit = 10)
    {
        $this->db->select('r.*, u.username as buyer_name');
        $this->db->from('geopos_worker_ratings r');
        $this->db->join('geopos_users u', 'r.buyer_id = u.id');
        $this->db->where('r.worker_id', $worker_id);
        $this->db->order_by('r.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    /**
     * Get automated skill badges for a worker
     */
    public function get_skill_badges($worker_id)
    {
        $this->db->select('average_rating, total_ratings, experience_years, skills');
        $this->db->where('id', $worker_id);
        $worker = $this->db->get('geopos_worker_profiles')->row_array();
        
        if (!$worker) return [];

        $badges = [];
        if ($worker['average_rating'] >= 4.5 && $worker['total_ratings'] >= 5) {
            $badges[] = array('name' => 'Top Rated', 'icon' => 'star', 'color' => 'gold');
        }
        if ($worker['total_ratings'] >= 20) {
            $badges[] = array('name' => 'Reliable', 'icon' => 'shield', 'color' => 'blue');
        }
        if ($worker['experience_years'] >= 10) {
            $badges[] = array('name' => 'Expert', 'icon' => 'award', 'color' => 'green');
        }
        
        $skills = json_decode($worker['skills'], true);
        if (is_array($skills)) {
            foreach ($skills as $skill) {
                if (stripos($skill, 'Certified') !== false) {
                    $badges[] = array('name' => $skill, 'icon' => 'check-circle', 'color' => 'info');
                }
            }
        }

        return $badges;
    }

    /* ------------------------------------------------------------------
     * Enterprise Services & Professionals (Job Board & Workforce)
     * ------------------------------------------------------------------ */

    public function get_job_requests($loc = 0)
    {
        if ($loc > 0) $this->db->where('loc', $loc);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('geopos_job_requests')->result_array();
    }

    public function get_profiles($loc = 0)
    {
        $this->db->select('p.*, u.username, u.email');
        $this->db->from('geopos_worker_profiles p');
        $this->db->join('geopos_users u', 'u.id = p.user_id', 'left');
        if ($loc > 0) $this->db->where('u.loc', $loc);
        $this->db->order_by('p.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_attendance($loc = 0)
    {
        $today = date('Y-m-d');
        $this->db->select('e.id, e.name, e.loc, e.salary, p.username, a.tfrom, a.tto, a.adate');
        $this->db->from('geopos_employees e');
        $this->db->join('geopos_users p', 'p.id = e.id', 'left');
        $this->db->join('geopos_attendance a', "a.emp = e.id AND a.adate = '$today'", 'left');
        if ($loc > 0) $this->db->where('e.loc', $loc);
        $this->db->order_by('a.tfrom', 'DESC');
        return $this->db->get()->result_array();
    }

    public function log_attendance($user_id, $action, $note = '')
    {
        $today = date('Y-m-d');
        $now = date('H:i:s');
        
        if ($action == 'clock_in') {
            $data = array(
                'emp' => $user_id,
                'adate' => $today,
                'tfrom' => $now,
                'tto' => '',
                'note' => $note,
                'created' => date('Y-m-d H:i:s')
            );
            return $this->db->insert('geopos_attendance', $data);
        } else if ($action == 'clock_out') {
            $this->db->set('tto', $now);
            $this->db->where('emp', $user_id);
            $this->db->where('adate', $today);
            $this->db->where('tto', ''); 
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            return $this->db->update('geopos_attendance');
        }
        return false;
    }

    public function get_clock_status($user_id)
    {
        $today = date('Y-m-d');
        $this->db->where('emp', $user_id);
        $this->db->where('adate', $today);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('geopos_attendance');
        return $query->row_array();
    }

    public function get_attendance_history($user_id, $limit = 10)
    {
        $this->db->where('emp', $user_id);
        $this->db->order_by('adate', 'DESC');
        $this->db->order_by('tfrom', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('geopos_attendance')->result_array();
    }

    public function calculate_earnings($user_id, $start_date, $end_date)
    {
        $this->db->where('emp', $user_id);
        $this->db->where('adate >=', $start_date);
        $this->db->where('adate <=', $end_date);
        $this->db->where('tto !=', '');
        $query = $this->db->get('geopos_attendance');
        $logs = $query->result_array();

        $total_seconds = 0;
        foreach ($logs as $log) {
            $from = strtotime($log['tfrom']);
            $to = strtotime($log['tto']);
            if ($to > $from) {
                $total_seconds += ($to - $from);
            }
        }

        $total_hours = $total_seconds / 3600;
        
        $this->db->select('hourly_rate');
        $this->db->from('geopos_worker_profiles');
        $this->db->where('user_id', $user_id);
        $worker = $this->db->get()->row_array();
        $rate = $worker['hourly_rate'] ?? 0;

        return array(
            'total_hours' => round($total_hours, 2),
            'hourly_rate' => $rate,
            'total_earnings' => round($total_hours * $rate, 2),
            'logs_count' => count($logs)
        );
    }
}
