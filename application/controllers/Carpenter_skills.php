<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carpenter_skills extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('carpenter_skill_model', 'skills');
        $this->load->model('employee_model', 'employee'); // Updated to lower case 'employee' based on pattern, but file list said 'Employee_model.php'. CI is case insensitive mostly but good to match.
        // Actually, checking standard CI, loading 'employee_model' works for Employee_model.php. 
        
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "Carpenter Skill Matrix";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('carpenter_skills/index');
        $this->load->view('fixed/footer');
    }

    public function get_matrix()
    {
        $list = $this->skills->get_matrix_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $row_item) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $row_item->emp_name;
            $row[] = $row_item->skill_name;
            $row[] = $row_item->proficiency_level . ' / 5';
            $row[] = $row_item->productivity_score;
            $row[] = '<a href="#" data-object-id="' . $row_item->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->skills->count_matrix_all(),
            "recordsFiltered" => $this->skills->count_matrix_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    public function manage_skills() // To add new skills to DB
    {
         if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $description = $this->input->post('description', true);
            $this->skills->create_skill($name, $description);
            echo json_encode(array('status' => 'Success', 'message' => 'Skill Added'));
         }
    }

    public function assign()
    {
        if ($this->input->post()) {
            $emp_id = $this->input->post('employee_id');
            $skill_id = $this->input->post('skill_id');
            $proficiency = $this->input->post('proficiency');
            $score = $this->input->post('score');

            if ($this->skills->assign_skill($emp_id, $skill_id, $proficiency, $score)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Skill Assigned/Updated Successfully'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Assigning Skill'));
            }
        } else {
            $head['title'] = "Assign Skill";
            $head['usernm'] = $this->aauth->get_user()->username;
            
            $data['employees'] = $this->employee->list_employee();
            $data['skills'] = $this->skills->get_skills_list();
            
            $this->load->view('fixed/header', $head);
            $this->load->view('carpenter_skills/assign', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_assignment()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->skills->delete_assignment($id);
            echo json_encode(array('status' => 'Success', 'message' => 'Assignment Deleted'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error Deleting'));
        }
    }
}
