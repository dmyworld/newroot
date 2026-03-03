<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hp Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hp_model', 'hp');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->li_a = 'hp';
    }

    public function index()
    {
        $head['title'] = "Hire Purchase Dashboard";
        $data['stats'] = $this->hp->get_stats($this->aauth->get_user()->loc);
        $this->load->view('fixed/header-va', $head);
        $this->load->view('hp/index', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $head['title'] = "New HP Contract";
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
        $data['customers'] = $this->customers->get_fetchall();
        $this->load->view('fixed/header-va', $head);
        $this->load->view('hp/create', $data);
        $this->load->view('fixed/footer');
    }

    public function save()
    {
        $customer_id = $this->input->post('customer_id');
        $total_amount = $this->input->post('total_amount');
        $down_payment = $this->input->post('down_payment');
        $interest_rate = $this->input->post('interest_rate');
        $num_installments = $this->input->post('num_installments');
        $frequency = $this->input->post('frequency');
        $start_date = $this->input->post('start_date');
        $notes = $this->input->post('notes');

        $principal = $total_amount - $down_payment;
        $interest_amount = ($principal * $interest_rate / 100); // Simple flat interest for example
        $total_with_interest = $principal + $interest_amount;
        $installment_amount = $total_with_interest / $num_installments;

        $contract_data = array(
            'customer_id' => $customer_id,
            'total_amount' => $total_amount,
            'down_payment' => $down_payment,
            'interest_rate' => $interest_rate,
            'interest_amount' => $interest_amount,
            'installment_amount' => $installment_amount,
            'num_installments' => $num_installments,
            'frequency' => $frequency,
            'start_date' => date('Y-m-d', strtotime($start_date)),
            'status' => 'active',
            'notes' => $notes,
            'loc' => $this->aauth->get_user()->loc
        );

        $installments = array();
        for ($i = 1; $i <= $num_installments; $i++) {
            $due_date = date('Y-m-d', strtotime($start_date . " + " . ($i - 1) . " " . $frequency));
            $installments[] = array(
                'installment_num' => $i,
                'due_date' => $due_date,
                'amount' => $installment_amount,
                'status' => 'unpaid'
            );
        }

        $guarantor = array(
            'name' => $this->input->post('g_name'),
            'nic' => $this->input->post('g_nic'),
            'phone' => $this->input->post('g_phone'),
            'address' => $this->input->post('g_address')
        );

        if ($this->hp->add_contract($contract_data, $installments, $guarantor)) {
            echo json_encode(array('status' => 'Success', 'message' => 'HP Contract Created Successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to Create Contract'));
        }
    }

    public function manage()
    {
        $head['title'] = "Manage HP Contracts";
        $this->load->view('fixed/header-va', $head);
        $this->load->view('hp/manage');
        $this->load->view('fixed/footer');
    }

    public function contract_list()
    {
        $loc = $this->aauth->get_user()->loc;
        $list = $this->hp->get_contract_datatables($loc);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $contract) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $contract->name;
            $row[] = amountExchange($contract->total_amount, 0, $loc);
            $row[] = $contract->num_installments;
            $row[] = $contract->status;
            $row[] = '<a href="' . base_url('hp/view?id=' . $contract->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->hp->count_all_contracts($loc),
            "recordsFiltered" => $this->hp->count_filtered_contracts($loc),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function view()
    {
        $id = $this->input->get('id');
        $loc = $this->aauth->get_user()->loc;
        $data['contract'] = $this->hp->get_contract($id, $loc);
        if (!$data['contract']) {
            exit('Contract not found');
        }
        $data['installments'] = $this->hp->get_installments($id);
        $data['guarantor'] = $this->hp->get_guarantor($id);
        $head['title'] = "View HP Contract #" . $id;
        $this->load->view('fixed/header-va', $head);
        $this->load->view('hp/view', $data);
        $this->load->view('fixed/footer');
    }

    public function pay_installment()
    {
        $id = $this->input->post('installment_id');
        $amount = $this->input->post('amount');
        $account = $this->input->post('account_id');

        if ($this->hp->pay_installment($id, $amount, $account)) {
            // === WhatsApp Confirmation ===
            try {
                $this->load->model('WhatsApp_model', 'whatsapp');
                $this->load->model('Hp_model', 'hp_m');
                // Fetch installment + contract + customer details
                $this->db->select('i.amount, i.contract_id, i.installment_num, c.customer_id');
                $this->db->from('geopos_hp_installments i');
                $this->db->join('geopos_hp_contracts c', 'c.id = i.contract_id', 'left');
                $this->db->where('i.id', $id);
                $ins = $this->db->get()->row_array();
                if ($ins) {
                    $this->db->select('name, phone');
                    $this->db->where('id', $ins['customer_id']);
                    $customer = $this->db->get('geopos_customers')->row_array();
                    if (!empty($customer['phone'])) {
                        $template_data = [
                            'Name'           => $customer['name'],
                            'Amount'         => number_format($amount, 2),
                            'InstallmentNum' => $ins['installment_num'],
                            'ContractID'     => $ins['contract_id'],
                        ];
                        $this->whatsapp->send_template($customer['phone'], 41, $template_data);
                    }
                }
            } catch (Exception $e) { /* Silently fail - WhatsApp is non-critical */ }
            echo json_encode(array('status' => 'Success', 'message' => 'Payment Recorded Successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to Record Payment'));
        }
    }

    public function performance()
    {
        $head['title'] = "Hire Purchase Performance";
        $data['stats'] = $this->hp->get_stats($this->aauth->get_user()->loc);
        // Additional performance metrics could be added here
        $this->load->view('fixed/header-va', $head);
        $this->load->view('hp/performance', $data);
        $this->load->view('fixed/footer');
    }
}
