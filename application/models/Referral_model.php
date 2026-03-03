<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral_model extends CI_Model
{
    const T_PROGRAM = 'tp_referral_program';
    const T_LOGS    = 'tp_referral_logs';
    const T_USERS   = 'geopos_users';

    public function get_active_program()
    {
        return $this->db->where('is_active', 1)
                        ->order_by('id', 'DESC')
                        ->get(self::T_PROGRAM)->row_array();
    }

    public function get_or_create_code($user_id)
    {
        $row = $this->db->where('id', $user_id)->get(self::T_USERS)->row_array();
        if (!empty($row['referral_code'])) return $row['referral_code'];
        return $this->generate_code($user_id);
    }

    public function generate_code($user_id)
    {
        $code = 'TP' . strtoupper(substr(md5($user_id . time()), 0, 6));
        // Ensure uniqueness
        while ($this->db->where('referral_code', $code)->count_all_results(self::T_USERS) > 0) {
            $code = 'TP' . strtoupper(substr(md5(uniqid()), 0, 6));
        }
        $this->db->where('id', $user_id)->update(self::T_USERS, ['referral_code' => $code]);
        return $code;
    }

    public function get_my_referrals($user_id)
    {
        return $this->db->where('referrer_user_id', $user_id)
                        ->order_by('created_at', 'DESC')
                        ->get(self::T_LOGS)->result_array();
    }

    public function get_stats($user_id)
    {
        $total     = $this->db->where('referrer_user_id', $user_id)->count_all_results(self::T_LOGS);
        $qualified = $this->db->where('referrer_user_id', $user_id)
                              ->where_in('status', ['qualified', 'rewarded'])
                              ->count_all_results(self::T_LOGS);
        $rewarded  = $this->db->where('referrer_user_id', $user_id)
                              ->where('referrer_rewarded', 1)
                              ->count_all_results(self::T_LOGS);
        return compact('total', 'qualified', 'rewarded');
    }

    public function get_all_referrals()
    {
        return $this->db->order_by('created_at', 'DESC')->get(self::T_LOGS)->result_array();
    }

    public function claim_reward($log_id, $user_id)
    {
        $log = $this->db->where('id', $log_id)
                        ->where('referrer_user_id', $user_id)
                        ->where('status', 'qualified')
                        ->where('referrer_rewarded', 0)
                        ->get(self::T_LOGS)->row_array();
        if (!$log) return false;
        $this->db->where('id', $log_id)->update(self::T_LOGS, [
            'status'           => 'rewarded',
            'referrer_rewarded'=> 1,
        ]);
        return true;
    }
}
