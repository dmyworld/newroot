<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollBonus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_bonus_model', 'bonus');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(14)) { // Assuming permission ID 14 or generally HR
             exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        
        $this->li_a = 'payroll'; // Highlight Payroll menu
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bonus Management';
        $this->load->view('fixed/header', $head);
        $this->load->view('payroll/bonus/index');
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $this->load->model('employee_model', 'employee');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Bonus';
        $data['employees'] = $this->employee->list_employee();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('payroll/bonus/add', $data);
        $this->load->view('fixed/footer');
    }

    public function save_bonus() {
        $employee_id = $this->input->post('employee_id');
        $amount = numberClean($this->input->post('amount'));
        $type = $this->input->post('type');
        $date = datefordatabase($this->input->post('date_effective'));
        $note = $this->input->post('note');

        if($this->bonus->add_bonus($employee_id, $amount, $type, $date, $note)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Bonus Added Successfully'));
        } else {
             echo json_encode(array('status' => 'Error', 'message' => 'Error Adding Bonus'));
        }
    }

    public function delete() {
        $id = $this->input->post('deleteid');
        if($this->bonus->delete_bonus($id)) {
             echo json_encode(array('status' => 'Success', 'message' => 'Bonus Deleted Successfully'));
        } else {
             echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting Bonus'));
        }
    }

    public function ajax_list()
    {
        $list = $this->bonus->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $bonus) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bonus->employee_name;
            $row[] = amountFormat($bonus->amount);
            $row[] = $bonus->type;
            $row[] = dateformat($bonus->date_effective);
            $row[] = $bonus->note;
            
            // Status Badge
            $status_class = $bonus->status == 'Paid' ? 'success' : 'warning';
            $row[] = '<span class="label label-' . $status_class . '">' . $bonus->status . '</span>';
            
            // Actions with Mark as Paid button
            $actions = '<a href="#" data-object-id="' . $bonus->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a> ';
            
            if ($bonus->status == 'Pending') {
                $actions .= '<button class="btn btn-success btn-sm mark-paid" data-bonus-id="' . $bonus->id . '" title="Mark as Paid"><i class="fa fa-check"></i></button>';
            }
            
            $row[] = $actions;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->bonus->count_all(),
            "recordsFiltered" => $this->bonus->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    // Mark bonus as paid
    public function mark_as_paid() {
        $id = $this->input->post('bonus_id');
        if($id) {
            $this->db->where('id', $id);
            if($this->db->update('geopos_payroll_bonuses', array('status' => 'Paid'))) {
                echo json_encode(array('status' => 'Success', 'message' => 'Bonus marked as Paid'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Failed to update'));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Invalid ID'));
        }
    }
}
