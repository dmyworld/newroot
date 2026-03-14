<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriptions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        if (!$this->aauth->is_loggedin()) {
            redirect('user/login');
        }
        
        // Super Admin Check (Role 1 or specific permission)
        if ($this->aauth->get_user()->roleid != 1) {
            show_error('Access Denied', 403);
        }

        $this->load->model('Subscription_model', 'sub');
    }

    public function index()
    {
        $this->approvals();
    }

    public function approvals()
    {
        $data['title'] = "Subscription Approvals";
        $data['list'] = $this->sub->get_pending_approvals();
        
        $head['title'] = "Approvals";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('subscriptions/approvals', $data);
        $this->load->view('fixed/footer');
    }

    public function active_users()
    {
        $data['title'] = "Active Subscribers";
        $data['list'] = $this->sub->get_active_subscribers();
        echo "<!-- List Count: " . count($data['list']) . " -->"; // Hidden Trace
        
        $head['title'] = "Active Users";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('subscriptions/active_users', $data);
        $this->load->view('fixed/footer');
    }

    public function commissions()
    {
        $data['title'] = "Commission Tracker";
        $data['list'] = $this->sub->get_commission_summaries();
        
        $head['title'] = "Commissions";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('subscriptions/commissions', $data);
        $this->load->view('fixed/footer');
    }

    public function settle()
    {
        $user_id = $this->input->post('user_id');
        $amount = $this->input->post('amount');

        if ($this->sub->settle_payment($user_id, $amount)) {
            echo json_encode(['status' => 'Success', 'message' => 'Payment Settled Successfully!']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to settle payment.']);
        }
    }

    public function approve()
    {
        $id = $this->input->post('id');
        if ($this->sub->approve($id)) {
            echo json_encode(['status' => 'Success', 'message' => 'Subscription Approved!']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to approve.']);
        }
    }

    public function delete_subscription()
    {
        $id = $this->input->post('id');
        if ($this->sub->delete_subscription($id)) {
            echo json_encode(['status' => 'Success', 'message' => 'Subscription Deleted!']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to delete.']);
        }
    }

    public function change_plan()
    {
        $user_id = $this->input->post('user_id');
        $plan_id = $this->input->post('plan_id');
        if ($this->sub->update_plan($user_id, $plan_id)) {
            echo json_encode(['status' => 'Success', 'message' => 'Plan Updated!']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to update plan.']);
        }
    }

    public function delete_commission()
    {
        $id = $this->input->post('id');
        if ($this->sub->delete_commission($id)) {
            echo json_encode(['status' => 'Success', 'message' => 'Commission Log Deleted!']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to delete log.']);
        }
    }
}
