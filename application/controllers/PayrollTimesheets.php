<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollTimesheets extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('payroll_rules_model', 'rules');
        $this->load->model('employee_model', 'employee');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        
        // Check permissions for payroll access
        if (!$this->aauth->premission(14)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        
        $this->li_a = 'payroll'; // Highlight Payroll menu
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Payroll Timesheets';
        
        // Get all job codes for dropdown
        $data['job_codes'] = $this->rules->get_job_codes();
        
        // Load employees
        $data['employees'] = $this->employee->list_employee();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('payroll/timesheets/index', $data);
        $this->load->view('fixed/footer');
    }

    // LIST DATA for DataTable
    public function get_list()
    {
        $this->load->database();
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $eid = $this->input->get('employee_id');
        $status = $this->input->get('status');

        $this->db->select('t.id, t.employee_id, t.clock_in, t.clock_out, t.total_hours, t.status, t.note, j.code as job_code, j.title as job_title, e.name as employee_name');
        $this->db->from('geopos_timesheets t');
        $this->db->join('geopos_job_codes j', 'j.id = t.job_code_id', 'left');
        $this->db->join('geopos_employees e', 'e.id = t.employee_id', 'left');
        
        // Filters
        if($start) $this->db->where('DATE(t.clock_in) >=', $start);
        if($end) $this->db->where('DATE(t.clock_in) <=', $end);
        if($eid) $this->db->where('t.employee_id', $eid);
        if($status) $this->db->where('t.status', $status);
        
        $this->db->order_by('t.clock_in', 'DESC');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        $data = array();
        foreach($result as $r) {
            $start_dt = new DateTime($r['clock_in']);
            $end_dt = new DateTime($r['clock_out']);
            
            $data[] = array(
                'id' => $r['id'],
                'employee_name' => $r['employee_name'],
                'date' => $start_dt->format('Y-m-d'),
                'job' => $r['job_code'] ? $r['job_code'].' - '.$r['job_title'] : 'General',
                'clock_in' => $start_dt->format('H:i'),
                'clock_out' => $end_dt->format('H:i'),
                'total_hours' => number_format($r['total_hours'], 2),
                'status' => '<span class="label label-'.($r['status']=='Approved'?'success':($r['status']=='Rejected'?'danger':'warning')).'">'.$r['status'].'</span>'
            );
        }
        
        echo json_encode(array('data' => $data));
    }
    
    public function get_details() {
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_timesheets');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $row = $query->row_array();
        
        if($row) {
             $start_dt = new DateTime($row['clock_in']);
             $end_dt = new DateTime($row['clock_out']);
             
             $row['date_only'] = $start_dt->format('Y-m-d');
             $row['start_time_only'] = $start_dt->format('H:i');
             $row['end_time_only'] = $end_dt->format('H:i');
             
             echo json_encode($row);
        } else {
            echo json_encode(array());
        }
    }

    // SAVE
    public function save()
    {
        $id = $this->input->post('id');
        
        $date = $this->input->post('date');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $total_hours = $this->input->post('total_hours');

        $clock_in = $date . ' ' . $start_time . ':00';
        $clock_out = $date . ' ' . $end_time . ':00';

        $data = array(
            'employee_id' => $this->input->post('employee_id'),
            'job_code_id' => $this->input->post('job_code'),
            'clock_in' => $clock_in,
            'clock_out' => $clock_out,
            'total_hours' => $total_hours,
            'note' => $this->input->post('note'),
            'is_overtime' => $this->input->post('is_overtime') ? 1 : 0,
            'status' => 'Pending'
        );

        if ($id) {
             $this->db->where('id', $id);
             $this->db->update('geopos_timesheets', $data);
             echo json_encode(array('status' => 'Success', 'message' => 'Timesheet Updated'));
        } else {
             $this->db->insert('geopos_timesheets', $data);
             echo json_encode(array('status' => 'Success', 'message' => 'Timesheet Added'));
        }
    }
    
    // Approve/Reject Timesheet
    public function update_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status'); // Approved or Rejected
        
        if ($id && in_array($status, ['Approved', 'Rejected'])) {
            $this->db->where('id', $id);
            $this->db->update('geopos_timesheets', array(
                'status' => $status,
                'approved_by' => $this->aauth->get_user()->id,
                'approved_date' => date('Y-m-d H:i:s')
            ));
            echo json_encode(array('status' => 'Success', 'message' => 'Timesheet '.$status));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Invalid request'));
        }
    }
    
    // DELETE
    public function delete()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_timesheets', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => 'Entry Deleted'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error'));
        }
    }
}
