<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timber_grades extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('timber_grades_model', 'timber_grades');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 4) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }

    public function index()
    {
        $head['title'] = "Timber Grades";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('timber_grades/index');
        $this->load->view('fixed/footer');
    }

    public function get_list()
    {
        $list = $this->timber_grades->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $grade) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $grade->grade_name;
            $row[] = $grade->qc_threshold_min . '%';
            $row[] = $grade->qc_threshold_max . '%';
            $row[] = $grade->rejection_rule_desc;
            $row[] = '<a href="' . site_url('timber_grades/edit?id=' . $grade->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $grade->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->timber_grades->count_all(),
            "recordsFiltered" => $this->timber_grades->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function create()
    {
        if ($this->input->post()) {
            $grade_name = $this->input->post('grade_name', true);
            $qc_min = $this->input->post('qc_min', true);
            $qc_max = $this->input->post('qc_max', true);
            $rejection_desc = $this->input->post('rejection_desc', true);

            if ($this->timber_grades->create($grade_name, $qc_min, $qc_max, $rejection_desc)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Timber Grade Added Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Adding Timber Grade'));
            }
        } else {
            $head['title'] = "Add Timber Grade";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('timber_grades/create');
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $grade_name = $this->input->post('grade_name', true);
            $qc_min = $this->input->post('qc_min', true);
            $qc_max = $this->input->post('qc_max', true);
            $rejection_desc = $this->input->post('rejection_desc', true);

            if ($this->timber_grades->edit($id, $grade_name, $qc_min, $qc_max, $rejection_desc)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Timber Grade Updated Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Updating Timber Grade'));
            }
        } else {
            $head['title'] = "Edit Timber Grade";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['grade'] = $this->timber_grades->get_details($this->input->get('id'));
            
            $this->load->view('fixed/header', $head);
            $this->load->view('timber_grades/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->timber_grades->delete($id);
            echo json_encode(array('status' => 'Success', 'message' => 'Timber Grade Deleted Successfully'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting Timber Grade'));
        }
    }
}
