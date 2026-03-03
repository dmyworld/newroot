<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Referral Controller
 * Blueprint: Referral codes, tracking, and reward distribution
 */
class Referral extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        if (!$this->aauth->is_loggedin()) { redirect('user/login'); }
        $this->load->model('Referral_model');
        $this->user_id = $this->aauth->get_user()->id;
    }

    // My referral dashboard
    public function index()
    {
        $data['title']          = 'Referral Program';
        $data['page_heading']   = 'My Referral Dashboard';
        $data['my_code']        = $this->Referral_model->get_or_create_code($this->user_id);
        $data['my_referrals']   = $this->Referral_model->get_my_referrals($this->user_id);
        $data['stats']          = $this->Referral_model->get_stats($this->user_id);
        $data['active_program'] = $this->Referral_model->get_active_program();
        $this->load->view('fixed/header-va', $data);
        $this->load->view('referral/index', $data);
        $this->load->view('fixed/footer', $data);
    }

    // POST: Generate / regenerate referral code
    public function generate_code()
    {
        $code = $this->Referral_model->generate_code($this->user_id);
        $this->session->set_flashdata('success', 'Your referral code: ' . $code);
        redirect('referral');
    }

    // POST: Claim a reward (after qualifying purchase)
    public function claim_reward($log_id = null)
    {
        if (!$log_id) { redirect('referral'); }
        $ok = $this->Referral_model->claim_reward($log_id, $this->user_id);
        if ($ok) {
            $this->session->set_flashdata('success', 'Reward claimed successfully!');
        } else {
            $this->session->set_flashdata('error', 'Reward not eligible or already claimed.');
        }
        redirect('referral');
    }

    // Admin: All referral logs
    public function all_referrals()
    {
        if (!$this->aauth->is_admin()) { redirect('dashboard'); }
        $data['title']        = 'All Referrals';
        $data['page_heading'] = 'All Referral Activity';
        $data['referrals']    = $this->Referral_model->get_all_referrals();
        $this->load->view('fixed/header-va', $data);
        $this->load->view('referral/all', $data);
        $this->load->view('fixed/footer', $data);
    }
}
