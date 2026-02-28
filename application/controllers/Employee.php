<?php
/**
 * D Business Solutions  -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Dashan Korala Hewage. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@dmyworld.com
 *  Website: https://www.dmyworld.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from D My World, Please read the full License from
 *  * here- https://dmyworld.com/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model', 'employee');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(9)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'emp';

    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/list', $data);
        $this->load->view('fixed/footer');
    }

    public function salaries()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/salaries', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view', $data);
        $this->load->view('fixed/footer');

    }

    public function history()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';
        $data['employee'] = $this->employee->employee_details($id);
        $data['history'] = $this->employee->salary_history($data['employee']['id']);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/history', $data);
        $this->load->view('fixed/footer');

    }


    public function add()
    {
        if (!$this->aauth->premission(9, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Employee';
        $data['dept'] = $this->employee->department_list(0);

        $this->load->view('fixed/header', $head);
        $this->load->view('employee/add', $data);
        $this->load->view('fixed/footer');


    }

    public function submit_user()
    {
        if (!$this->aauth->premission(9, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->aauth->get_user()->roleid < 4) {
            redirect('/dashboard/', 'refresh');
        }

        $username = $this->input->post('username', true);

        $password = $this->input->post('password', true);
        $roleid = 3;
        if ($this->input->post('roleid')) {
            $roleid = $this->input->post('roleid');

        }

        if ($roleid > 3) {
            if ($this->aauth->get_user()->roleid < 5) {
                die('No! Permission');
            }
        }

        $location = $this->input->post('location', true);
        $name = $this->input->post('name', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $salary = numberClean($this->input->post('salary', true));
        $commission = $this->input->post('commission', true);
        $department = $this->input->post('department', true);


        $a = $this->aauth->create_user($email, $password, $username);

        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $nuid = (string)$this->aauth->get_user($a)->id;

            if ($nuid > 0) {


                $this->employee->add_employee($nuid, (string)$this->aauth->get_user($a)->username, $name, $roleid, $phone, $address, $city, $region, $country, $postbox, $location, $salary, $commission, $department);

            }

        } else {
            $error_message = 'There has been an error, please try again.';
            $aauth_errors = $this->aauth->get_errors_array();
            if (!empty($aauth_errors)) {
                $error_message = implode('<br>', $aauth_errors);
            }
            echo json_encode(array('status' => 'Error', 'message' => $error_message));
        }
    }

    public function invoices()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Invoices';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices_list()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->invoice_datatables($eid);
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            switch ($invoices->status) {
                case "paid" :
                    $out = '<span class="label label-success">Paid</span> ';
                    break;
                case "due" :
                    $out = '<span class="label label-danger">Due</span> ';
                    break;
                case "canceled" :
                    $out = '<span class="label label-warning">Canceled</span> ';
                    break;
                case "partial" :
                    $out = '<span class="label label-primary">Partial</span> ';
                    break;
                default :
                    $out = '<span class="label label-info">Pending</span> ';
                    break;
            }
            $row[] = $out;
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->invoicecount_all($eid),
            "recordsFiltered" => $this->employee->invoicecount_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function transactions()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function translist()
    {
        $eid = $this->input->post('eid');
        $list = $this->employee->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = $prd->account;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);

            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function disable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {

            $this->db->select('banned');
            $this->db->from('geopos_users');
            $this->db->where('id', $uid);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($result['banned'] == 0) {
                $this->aauth->ban_user($uid);
            } else {
                $this->aauth->unban_user($uid);
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile updated successfully!'));


        }
    }

    function enable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {


            $a = $this->aauth->unban_user($uid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile disabled successfully!'));


        }
    }

    function delete_user()
    {
        if (!$this->aauth->premission(9, 'delete')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('empid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not delete yourself!'));
        } else {

            $this->db->delete('geopos_employees', array('id' => $uid));

            $this->db->delete('geopos_users', array('id' => $uid));

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile deleted successfully! Please refresh the page!'));


        }
    }


    public function calc_income()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->money_details($eid)) {
            $details = $this->employee->money_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                '<br> Total Income: ' . amountExchange($details['credit'], 0, $this->aauth->get_user()->loc) . '<br> Total Expenses: ' . amountExchange($details['debit'], 0, $this->aauth->get_user()->loc)));

        }


    }

    public function calc_sales()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->sales_details($eid)) {
            $details = $this->employee->sales_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'Total Sales (Paid Payment):  ' . amountExchange($details['total'], 0, $this->aauth->get_user()->loc)));

        }


    }

    public function update()
    {
        if (!$this->aauth->premission(9, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');
        if ($this->input->post()) {
            $eid = $this->input->post('eid', true);
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $phonealt = $this->input->post('phonealt', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $location = $this->input->post('location', true);
            $salary = numberClean($this->input->post('salary', true));
            $department = $this->input->post('department', true);
            $commission = $this->input->post('commission', true);
            $roleid = $this->input->post('roleid', true);
            $this->employee->update_employee($eid, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $location, $salary, $department, $commission, $roleid);

        } else {
            $head['usernm'] = $this->aauth->get_user($id)->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['dept'] = $this->employee->department_list($id, $this->aauth->get_user()->loc);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edit', $data);
            $this->load->view('fixed/footer');
        }


    }


    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editpicture($id, $img);
        }


    }


    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }


    }


    public function updatepassword()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("form_validation");

        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');


        if ($this->input->post()) {
            $eid = $this->input->post('eid');
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {

                $newpassword = $this->input->post('newpassword');
                echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));
                $this->aauth->update_user($eid, false, $newpassword, false);
            }


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';
            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/password', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function roles()
    {
        if (!$this->aauth->premission(9, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Role Management';
        $data['roles'] = $this->aauth->get_roles();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/roles', $data);
        $this->load->view('fixed/footer');
    }

    public function role_add()
    {
        if (!$this->aauth->premission(9, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post()) {
             $name = $this->input->post('name', true);
             $this->db->insert('geopos_roles', array('name' => $name));
             echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . " <a href='roles' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
        } else {
             $head['usernm'] = $this->aauth->get_user()->username;
             $head['title'] = 'Add Role';
             $this->load->view('fixed/header', $head);
             $this->load->view('employee/role_add');
             $this->load->view('fixed/footer');
        }
    }

    public function role_edit()
    {
        if (!$this->aauth->premission(9, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $id = $this->input->get('id');
        
        if ($this->input->post()) {
             $id = $this->input->post('id');
             $permissions = $this->input->post('p'); // Array [module_id][action] = 1
             
             // Clear existing permissions for this role?
             // Or better, update. 
             // To simplify: Delete all for this role, then insert checks.
             
             $this->db->delete('geopos_role_permissions', array('role_id' => $id));
             
             // Get all modules to ensure we save 0s for unchecked modules
             $modules = $this->aauth->get_modules();
             $permissions_post = $this->input->post('p');
             
             foreach($modules as $row) {
                 $mod_id = $row['id'];
                 $actions = isset($permissions_post[$mod_id]) ? $permissions_post[$mod_id] : [];
                 
                 $data = array(
                     'role_id' => $id,
                     'module_id' => $mod_id,
                     'can_view' => isset($actions['view']) ? 1 : 0,
                     'can_add' => isset($actions['add']) ? 1 : 0,
                     'can_edit' => isset($actions['edit']) ? 1 : 0,
                     'can_delete' => isset($actions['delete']) ? 1 : 0,
                     'can_demo' => isset($actions['demo']) ? 1 : 0

                 );
                 
                 // Always insert/update to ensure permission state is explicit
                 $this->db->insert('geopos_role_permissions', $data);
             }
             
             echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
             
        } else {
             $head['usernm'] = $this->aauth->get_user()->username;
             $head['title'] = 'Edit Role Permissions';
             
             $data['role'] = $this->db->get_where('geopos_roles', array('id' => $id))->row_array();
             $data['modules'] = $this->aauth->get_modules();
             $data['permissions'] = $this->aauth->get_role_permissions($id);
             
             // Reformat permissions for easy view lookup
             $p_map = [];
             foreach($data['permissions'] as $p) {
                 $p_map[$p['module_id']] = $p;
             }
             $data['p_map'] = $p_map;
             
             $this->load->view('fixed/header', $head);
             $this->load->view('employee/role_edit', $data);
             $this->load->view('fixed/footer');
        }
    }


    public function holidays()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Holidays';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/holidays');
        $this->load->view('fixed/footer');

    }


    public function hday_list()
    {
        $list = $this->employee->holidays_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $obj) {
            $datetime1 = date_create($obj->val1);
            $datetime2 = date_create($obj->val2);
            $interval = date_diff($datetime1, $datetime2);
            $day = $interval->format('%a days');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->val1;
            $row[] = $obj->val2;
            $row[] = $day;
            $row[] = $obj->val3;
            $row[] = "<a href='" . base_url("employee/editholiday?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->holidays_count_all(),
            "recordsFiltered" => $this->employee->holidays_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_hday()
    {
        if (!$this->aauth->premission(9, 'delete')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteholidays($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function addhday()
    {
        if (!$this->aauth->premission(9, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        if ($this->input->post()) {

            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note', true);

            $date1 = new DateTime($from);
            $date2 = new DateTime($todate);
            if ($date1 <= $date2) {


                if ($this->employee->addholidays($this->aauth->get_user()->loc, $from, $todate, $note)) {
                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "   <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR') . '- Invalid'));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/addholyday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function editholiday()
    {
        if (!$this->aauth->premission(9, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        if ($this->input->post()) {


            $id = $this->input->post('did');
            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note', true);

            if ($this->employee->edithday($id, $this->aauth->get_user()->loc, $from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['hday'] = $this->employee->hday_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edithday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function departments()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department_list'] = $this->employee->department_list($this->aauth->get_user()->loc);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/departments', $data);
        $this->load->view('fixed/footer');

    }

    public function department()
    {

        $data['id'] = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
        $data['department_list'] = $this->employee->department_elist($data['id']);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/department', $data);
        $this->load->view('fixed/footer');

    }

    public function delete_dep()
    {
        if (!$this->aauth->premission(9, 'delete')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $id = $this->input->post('deleteid');


        if ($this->employee->deletedepartment($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function adddep()
    {
        if (!$this->aauth->premission(9, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        if ($this->input->post()) {

            $name = $this->input->post('name', true);


            if ($this->employee->adddepartment($this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/adddep');
            $this->load->view('fixed/footer');
        }

    }

    public function editdep()
    {
        if (!$this->aauth->premission(9, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        if ($this->input->post()) {

            $name = $this->input->post('name', true);
            $id = $this->input->post('did');

            if ($this->employee->editdepartment($id, $this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/editdep', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function payroll_create()
    {
        if (!$this->aauth->premission(9, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->library("Custom");
        $data['dual'] = $this->custom->api_config(65);
        $this->load->model('transactions_model', 'transactions');
        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_create', $data);
        $this->load->view('fixed/footer');

    }

    public function emp_search()
    {

        $name = $this->input->get('keyword', true);


        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (geopos_users.loc=' . $this->aauth->get_user()->loc . ') AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_employees.* ,geopos_users.email FROM geopos_employees  LEFT JOIN geopos_users ON geopos_users.id=geopos_employees.id  WHERE $whr (UPPER(geopos_employees.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_employees.phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectPay('" . $row['id'] . "','" . $row['name'] . " ','" . amountFormat_general($row['salary']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function payroll()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll');
        $this->load->view('fixed/footer');
    }

    public function payroll_emp()
    {

        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_employee', $data);
        $this->load->view('fixed/footer');
    }


    public function payrolllist()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->pay_get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;

            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;
            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span> View</a> <a  href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a> ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->pay_count_all($eid),
            "recordsFiltered" => $this->employee->pay_count_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function attendances()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Attendance';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/attendance_list');
        $this->load->view('fixed/footer');

    }

    public function attendance()
    {
        if ($this->input->post()) {
            $emp = $this->input->post('employee');
            $adate = datefordatabase($this->input->post('adate'));
            $from = timefordatabase($this->input->post('from'));
            $todate = timefordatabase($this->input->post('to'));
            $note = $this->input->post('note');

            if ($this->employee->addattendance($emp, $adate, $from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='attendance' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='attendances' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/attendance', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function auto_attendance()
    {
        if ($this->input->post()) {
            $auto_attand = $this->input->post('attend');

            if ($this->employee->autoattend($auto_attand)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $this->load->model('plugins_model', 'plugins');

            $data['auto'] = $this->plugins->universal_api(62);


            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/autoattend', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function att_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->employee->attendance_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = dateformat($obj->adate) . ' &nbsp; ' . $obj->tfrom . ' - ' . $obj->tto;
            $row[] = round((strtotime($obj->tto) - strtotime($obj->tfrom)) / 3600, 2);
            $row[] = round($obj->actual_hours / 3600, 2);
            $row[] = $obj->note;

            $row[] = '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->attendance_count_all($cid),
            "recordsFiltered" => $this->employee->attendance_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_attendance()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteattendance($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


}
