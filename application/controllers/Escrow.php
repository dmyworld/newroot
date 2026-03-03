<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Escrow Vault Controller
 * Blueprint: Secure payment holding — No-Delete Policy enforced
 */
class Escrow extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        if (!$this->aauth->is_loggedin()) { redirect('user/login'); }
        $this->load->model('Escrow_model');
        $this->user_id = $this->aauth->get_user()->id;
        $this->loc     = $this->session->userdata('loc') ?: 0;
    }

    // Escrow vault list
    public function index()
    {
        $data['title']        = 'Escrow Vault';
        $data['page_heading'] = 'Escrow Vault';
        $data['held']         = $this->Escrow_model->get_held($this->loc);
        $data['summary']      = $this->Escrow_model->get_summary($this->loc);
        $this->load->view('fixed/header-va', $data);
        $this->load->view('escrow/index', $data);
        $this->load->view('fixed/footer', $data);
    }

    // View single escrow entry
    public function view($id = null)
    {
        if (!$id) { redirect('escrow'); }
        $data['escrow']         = $this->Escrow_model->get_by_id($id);
        $data['transactions']   = $this->Escrow_model->get_transactions($id);
        $data['title']          = 'Escrow Detail';
        $data['page_heading']   = 'Escrow Detail';
        $this->load->view('fixed/header-va', $data);
        $this->load->view('escrow/view', $data);
        $this->load->view('fixed/footer', $data);
    }

    // POST: Release funds to payee
    public function release($escrow_id = null)
    {
        if (!$escrow_id) { redirect('escrow'); }
        $ok = $this->Escrow_model->release($escrow_id, $this->user_id);
        if ($ok) {
            $this->session->set_flashdata('success', 'Escrow funds released to payee.');
        } else {
            $this->session->set_flashdata('error', 'Release failed — check escrow status.');
        }
        redirect('escrow/view/' . $escrow_id);
    }

    // POST: Refund funds to payer
    public function refund($escrow_id = null)
    {
        if (!$escrow_id) { redirect('escrow'); }
        $ok = $this->Escrow_model->refund($escrow_id, $this->user_id);
        if ($ok) {
            $this->session->set_flashdata('success', 'Escrow funds refunded to payer.');
        } else {
            $this->session->set_flashdata('error', 'Refund failed — check escrow status.');
        }
        redirect('escrow/view/' . $escrow_id);
    }

    // Create new escrow hold (called internally or via AJAX from Ring/Bids)
    public function hold()
    {
        if ($this->input->method() !== 'post') { redirect('escrow'); }
        $data = [
            'payer_user_id' => $this->input->post('payer_user_id'),
            'payee_user_id' => $this->input->post('payee_user_id'),
            'amount'        => $this->input->post('amount'),
            'purpose'       => $this->input->post('purpose'),
            'linked_id'     => $this->input->post('linked_id'),
            'linked_type'   => $this->input->post('linked_type'),
            'loc'           => $this->loc,
        ];
        $escrow_id = $this->Escrow_model->create_hold($data, $this->user_id);
        if ($this->input->is_ajax_request()) {
            echo json_encode(['ok' => (bool)$escrow_id, 'escrow_id' => $escrow_id]);
        } else {
            $this->session->set_flashdata('success', 'Escrow hold created.');
            redirect('escrow/view/' . $escrow_id);
        }
    }
}
