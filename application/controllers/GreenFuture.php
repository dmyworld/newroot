<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Green Future Controller — Section 11: CSR Social Module
 *
 * Routes:
 *   greenfuture/                         Dashboard
 *   greenfuture/donate                   Manual donation form
 *   greenfuture/submit_donation          POST: manual donation
 *   greenfuture/plant                    Request planting (form)
 *   greenfuture/submit_planting          POST: submit planting request
 *   greenfuture/planting_list            Admin: all planting requests
 *   greenfuture/upload_certificate/{id}  POST: upload GN + Sabhapathi cert
 *   greenfuture/approve_planting/{id}    Admin: approve request
 *   greenfuture/maintenance              Admin: maintenance fund list
 *   greenfuture/apply_maintenance        Citizen: apply for monthly stipend
 *   greenfuture/submit_maintenance       POST: save application + photo
 *   greenfuture/verify_maintenance/{id}  Admin: mark verified
 *   greenfuture/pay_maintenance/{id}     Admin: mark paid
 *   greenfuture/payout/{id}             Admin: landowner payout
 *   greenfuture/invoice_settings         Admin: set % per invoice
 *   greenfuture/save_invoice_settings    POST: save %
 */
class GreenFuture extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        // Removed strict redirect for public access
        // if (!$this->aauth->is_loggedin()) { redirect('user/login'); }
        $this->load->model('GreenFuture_model', 'gf');
        $this->load->library('form_validation');
        $this->load->helper('url');
        
        $this->user_id = $this->aauth->is_loggedin() ? $this->aauth->get_user()->id : 0;
        $this->loc     = $this->session->userdata('loc') ?: 0;
        $this->is_admin = $this->aauth->is_loggedin() && ($this->aauth->get_user()->roleid >= 4);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DASHBOARD
    // ──────────────────────────────────────────────────────────────────────────
    public function index()
    {
        $data['title']        = 'Green Future — CSR';
        $data['page_heading'] = '🌳 Green Future — CSR Dashboard';
        $data['fund_balance'] = $this->gf->get_fund_balance();
        $data['breakdown']    = $this->gf->get_fund_balance_breakdown();
        $data['stats']        = $this->gf->get_stats();
        $data['recent_plants']= $this->gf->get_recent_planting(10);
        $data['recent_donors']= $this->gf->get_recent_donors(5);
        $data['inv_percent']  = $this->gf->get_invoice_donation_percent();
        $data['is_admin']     = $this->is_admin;
        $this->load->view('public/header', $data);
        $this->load->view('green_future/index', $data);
        $this->load->view('public/footer', $data);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DONATIONS
    // ──────────────────────────────────────────────────────────────────────────
    public function donate()
    {
        $data['title']        = 'Donate to Green Future';
        $data['page_heading'] = '💚 Make a Donation';
        $this->load->view('public/header', $data);
        $this->load->view('green_future/donate', $data);
        $this->load->view('public/footer', $data);
    }

    public function submit_donation()
    {
        if ($this->input->method() !== 'post') { redirect('greenfuture'); }
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' | '));
            redirect('greenfuture/donate');
        }
        $balance_before = $this->gf->get_fund_balance();
        $amount         = (float) $this->input->post('amount');
        $this->gf->add_donation([
            'donor_user_id'       => $this->user_id,
            'amount'              => $amount,
            'donation_type'       => 'manual',
            'fund_balance_before' => $balance_before,
            'fund_balance_after'  => $balance_before + $amount,
            'note'                => $this->input->post('note'),
            'created_at'          => date('Y-m-d H:i:s'),
        ]);
        $this->session->set_flashdata('success', 'ස්තූතියි! ඔබගේ Rs. ' . number_format($amount, 2) . ' දායකත්වය ලැබෙන ලදී. 🌱');
        redirect('greenfuture');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // TREE PLANTING REQUESTS
    // ──────────────────────────────────────────────────────────────────────────
    public function plant()
    {
        $data['title']        = 'ගස් රෝපණ ඉල්ලීම | Request Tree Planting';
        $data['page_heading'] = '🌱 New Tree Planting Request';
        $this->load->view('public/header', $data);
        $this->load->view('green_future/plant', $data);
        $this->load->view('public/footer', $data);
    }

    public function submit_planting()
    {
        if ($this->input->method() !== 'post') { redirect('greenfuture'); }
        $this->form_validation->set_rules('district',        'District',        'required');
        $this->form_validation->set_rules('trees_requested', 'Trees Requested', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('tree_species',    'Tree Species',    'required');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' | '));
            redirect('greenfuture/plant');
        }
        $trees      = (int)   $this->input->post('trees_requested');
        $cost_each  = (float) $this->input->post('cost_per_tree') ?: 150.00;
        $total_cost = $trees * $cost_each;
        $id = $this->gf->add_planting_request([
            'requested_by'        => $this->user_id,
            'district'            => $this->input->post('district'),
            'province'            => $this->input->post('province'),
            'tree_species'        => $this->input->post('tree_species'),
            'location_type'       => $this->input->post('location_type') ?: 'roadside',
            'trees_requested'     => $trees,
            'cost_per_tree'       => $cost_each,
            'total_cost'          => $total_cost,
            'funded_from_donation'=> 1,
            'status'              => 'pending',
            'created_at'          => date('Y-m-d H:i:s'),
        ]);
        $this->session->set_flashdata('success', "Planting request submitted for $trees tree(s) in {$this->input->post('district')}. Request ID: #$id");
        redirect('greenfuture/planting_list');
    }

    // Admin list of all planting requests
    public function planting_list()
    {
        $data['title']        = 'ගස් රෝපණ ඉල්ලීම් | Planting Requests';
        $data['page_heading'] = '🌳 Tree Planting — All Requests';
        $data['requests']     = $this->gf->get_all_planting([
            'status'   => $this->input->get('status'),
            'district' => $this->input->get('district'),
            'province' => $this->input->get('province'),
        ]);
        $data['is_admin']     = $this->is_admin;
        if ($this->is_admin) {
            $this->load->view('fixed/header-va', $data);
        } else {
            $this->load->view('public/header', $data);
        }
        $this->load->view('green_future/planting_list', $data);
        if ($this->is_admin) {
            $this->load->view('fixed/footer', $data);
        } else {
            $this->load->view('public/footer', $data);
        }
    }

    // Upload graama niladhari + sabhapathi certificates via AJAX/POST
    public function upload_certificate($planting_id = null)
    {
        if (!$planting_id) { echo json_encode(['status' => 'Error', 'message' => 'Invalid ID']); return; }
        $this->load->library('upload');
        $results = [];

        foreach (['grama_niladhari_cert', 'sabhapathi_cert'] as $field) {
            if (!empty($_FILES[$field]['name'])) {
                $cfg = [
                    'upload_path'   => FCPATH . 'userfiles/greenfuture/',
                    'allowed_types' => 'jpg|jpeg|png|pdf',
                    'max_size'      => 3072,
                    'file_name'     => 'cert_' . $planting_id . '_' . $field . '_' . time(),
                ];
                // Ensure directory exists
                if (!is_dir($cfg['upload_path'])) mkdir($cfg['upload_path'], 0755, true);
                $this->upload->initialize($cfg);
                if ($this->upload->do_upload($field)) {
                    $fname = $this->upload->data('file_name');
                    $this->gf->save_certificate($planting_id, $field, 'userfiles/greenfuture/' . $fname);
                    $results[$field] = 'success';
                } else {
                    $results[$field] = $this->upload->display_errors('', '');
                }
            }
        }
        $this->session->set_flashdata('success', 'සහතිකය(ය) සාර්ථකව උඩුගත කරන ලදී! | Certificate uploaded.');
        redirect('greenfuture/planting_list');
    }

    // Admin: approve a planting request
    public function approve_planting($id = null)
    {
        if (!$id || !$this->is_admin) { redirect('greenfuture/planting_list'); }
        $this->gf->update_planting($id, ['status' => 'approved', 'admin_note' => $this->input->post('note')]);
        $this->session->set_flashdata('success', 'Planting request #' . $id . ' approved.');
        redirect('greenfuture/planting_list');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // MAINTENANCE FUND
    // ──────────────────────────────────────────────────────────────────────────

    // Admin/User: list maintenance applications
    public function maintenance()
    {
        if (!$this->aauth->is_loggedin()) { redirect('user/login'); }
        $data['title']        = 'නඩත්තු අරමුදල | Maintenance Fund';
        $data['page_heading'] = '🌿 Maintenance Fund — Applications';
        
        // Non-admins see only their own applications
        if ($this->is_admin) {
            $data['applications'] = $this->gf->get_all_maintenance($this->input->get('status'));
        } else {
            $data['applications'] = $this->gf->get_all_maintenance($this->input->get('status'), $this->user_id);
        }
        
        $data['is_admin']     = $this->is_admin;
        
        if ($this->is_admin) {
            $this->load->view('fixed/header-va', $data);
        } else {
            $this->load->view('public/header', $data);
        }
        $this->load->view('green_future/maintenance', $data);
        if ($this->is_admin) {
            $this->load->view('fixed/footer', $data);
        } else {
            $this->load->view('public/footer', $data);
        }
    }

    // Citizen: view the application form
    public function apply_maintenance()
    {
        $data['title']        = 'නඩත්තු දීමනාව සඳහා අයදුම්පත';
        $data['page_heading'] = '🌱 Apply for Tree Maintenance Stipend';
        $this->load->view('public/header', $data);
        $this->load->view('green_future/apply_maintenance', $data);
        $this->load->view('public/footer', $data);
    }

    // POST: Save maintenance application + photo
    public function submit_maintenance()
    {
        if ($this->input->method() !== 'post') { redirect('greenfuture/apply_maintenance'); }
        $this->form_validation->set_rules('applicant_name', 'Name',     'required');
        $this->form_validation->set_rules('district',       'District', 'required');
        $this->form_validation->set_rules('tree_count',     'Trees',    'required|integer|greater_than[0]');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' | '));
            redirect('greenfuture/apply_maintenance');
        }

        $photo_path = null;
        if (!empty($_FILES['photo']['name'])) {
            $this->load->library('upload');
            $cfg = [
                'upload_path'   => FCPATH . 'userfiles/greenfuture/',
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 2048,
                'file_name'     => 'maint_' . $this->user_id . '_' . time(),
            ];
            if (!is_dir($cfg['upload_path'])) mkdir($cfg['upload_path'], 0755, true);
            $this->upload->initialize($cfg);
            if ($this->upload->do_upload('photo')) {
                $photo_path = 'userfiles/greenfuture/' . $this->upload->data('file_name');
            }
        }

        $this->gf->add_maintenance_request([
            'planting_request_id' => $this->input->post('planting_request_id') ?: null,
            'applicant_user_id'   => $this->user_id,
            'applicant_name'      => $this->input->post('applicant_name'),
            'applicant_phone'     => $this->input->post('applicant_phone'),
            'applicant_address'   => $this->input->post('applicant_address'),
            'province'            => $this->input->post('province'),
            'district'            => $this->input->post('district'),
            'location_description'=> $this->input->post('location_description'),
            'tree_count'          => (int) $this->input->post('tree_count'),
            'photo_path'          => $photo_path,
            'bank_name'           => $this->input->post('bank_name'),
            'bank_account_no'     => $this->input->post('bank_account_no'),
            'bank_branch'         => $this->input->post('bank_branch'),
            'monthly_amount'      => (float) $this->input->post('monthly_amount') ?: 1500.00,
            'status'              => 'pending',
            'created_at'          => date('Y-m-d H:i:s'),
        ]);
        $this->session->set_flashdata('success', 'ඔබගේ නඩත්තු දීමනා ඉල්ලීම ලැබෙන ලදී! | Maintenance application submitted.');
        redirect('greenfuture');
    }

    // Admin: verify (approve) maintenance application
    public function verify_maintenance($id = null)
    {
        if (!$id || !$this->is_admin) { redirect('greenfuture/maintenance'); }
        $amount = $this->input->post('monthly_amount');
        $this->gf->verify_maintenance($id, $this->user_id, $amount);
        $this->session->set_flashdata('success', "Application #$id verified. Monthly stipend activated.");
        redirect('greenfuture/maintenance');
    }

    // Admin: mark maintenance as paid
    public function pay_maintenance($id = null)
    {
        if (!$id || !$this->is_admin) { redirect('greenfuture/maintenance'); }
        $rec = $this->gf->get_maintenance($id);
        if ($rec) {
            $this->gf->pay_maintenance($id);
            $balance_before = $this->gf->get_fund_balance();
            // Deduct from fund
            $this->gf->add_donation([
                'donor_user_id'       => 0,
                'amount'              => -abs($rec['monthly_amount']),
                'donation_type'       => 'manual',
                'fund_balance_before' => $balance_before,
                'fund_balance_after'  => $balance_before - $rec['monthly_amount'],
                'note'                => 'Maintenance payout to ' . $rec['applicant_name'] . ' (App #' . $id . ')',
                'created_at'          => date('Y-m-d H:i:s'),
            ]);
        }
        $this->session->set_flashdata('success', "Maintenance payout #$id recorded.");
        redirect('greenfuture/maintenance');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // LANDOWNER PAYOUTS
    // ──────────────────────────────────────────────────────────────────────────
    public function payout($planting_id = null)
    {
        if (!$planting_id) { redirect('greenfuture/planting_list'); }
        if ($this->input->method() === 'post') {
            $this->gf->add_payout([
                'planting_request_id' => $planting_id,
                'landowner_user_id'   => $this->input->post('landowner_user_id'),
                'payout_type'         => $this->input->post('payout_type'),
                'amount'              => $this->input->post('amount'),
                'payment_method'      => $this->input->post('payment_method'),
                'status'              => 'paid',
                'paid_at'             => date('Y-m-d H:i:s'),
                'created_at'          => date('Y-m-d H:i:s'),
            ]);
            $this->session->set_flashdata('success', 'Payout recorded.');
            redirect('greenfuture/planting_list');
        }
        $data['planting']     = $this->gf->get_planting($planting_id);
        $data['payouts']      = $this->gf->get_payouts_for($planting_id);
        $data['title']        = 'Record Payout';
        $data['page_heading'] = 'Record Landowner Payout';
        $this->load->view('fixed/header-va', $data);
        $this->load->view('green_future/payout', $data);
        $this->load->view('fixed/footer', $data);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INVOICE DONATION SETTINGS
    // ──────────────────────────────────────────────────────────────────────────
    public function invoice_settings()
    {
        if (!$this->aauth->is_loggedin()) { redirect('user/login'); }
        $data['title']        = 'Invoice Donation Settings';
        $data['page_heading'] = '💰 Invoice Donation % Configuration';
        $data['current_pct']  = $this->gf->get_invoice_donation_percent();
        
        if ($this->is_admin) {
            $data['all_donors'] = $this->gf->get_all_donors(100);
        } else {
            $data['all_donors'] = $this->gf->get_all_donors_v2(100, $this->user_id);
        }
        
        $data['is_admin'] = $this->is_admin;
        
        if ($this->is_admin) {
            $this->load->view('fixed/header-va', $data);
        } else {
            $this->load->view('public/header', $data);
        }
        $this->load->view('green_future/invoice_settings', $data);
        if ($this->is_admin) {
            $this->load->view('fixed/footer', $data);
        } else {
            $this->load->view('public/footer', $data);
        }
    }

    public function save_invoice_settings()
    {
        if (!$this->is_admin || $this->input->method() !== 'post') { redirect('greenfuture/invoice_settings'); }
        $pct = (float) $this->input->post('percent');
        if ($pct < 0 || $pct > 10) {
            $this->session->set_flashdata('error', 'Percent must be between 0 and 10.');
            redirect('greenfuture/invoice_settings');
        }
        $this->gf->set_invoice_donation_percent($pct);
        $this->session->set_flashdata('success', "Invoice donation set to {$pct}% per bill.");
        redirect('greenfuture/invoice_settings');
    }
}
