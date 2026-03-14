<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheets extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('payroll_rules_model', 'rules'); // Re-use this for job codes
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Timesheet Management';
        
        // Get all job codes for dropdown
        $data['job_codes'] = $this->rules->get_job_codes();
        
        // Load employees for Admin/Supervisor view
        $this->load->model('employee_model', 'employee');
        $data['employees'] = $this->employee->list_employee();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('timesheets/index', $data);
        $this->load->view('fixed/footer');
    }

    // LIST DATA for DataTable or Calendar
    public function get_list()
    {
        $this->load->database();
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $eid = $this->input->get('employee_id');
        $status = $this->input->get('status');
        $list_mode = $this->input->get('list_mode');

        $this->db->select('t.id, t.employee_id, t.clock_in, t.clock_out, t.total_hours, t.status, t.note, j.code as job_code, j.title as job_title, e.name as employee_name');
        $this->db->from('geopos_timesheets t');
        $this->db->join('geopos_job_codes j', 'j.id = t.job_code_id', 'left');
        $this->db->join('geopos_employees e', 'e.id = t.employee_id', 'left');
        
        // Filters
        // Calendar sends start/end automatically (e.g. 2026-01-26 to 2026-03-09)
        if($start) $this->db->where('t.clock_in >=', $start);
        if($end) $this->db->where('t.clock_in <=', $end);
        
        if($eid) $this->db->where('t.employee_id', $eid);
        if($status) $this->db->where('t.status', $status);
        
        $this->db->order_by('t.clock_in', 'DESC');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        $data = array();
        
        foreach($result as $r) {
            // Split DateTime for easier frontend handling
            $start_dt = new DateTime($r['clock_in']);
            $end_dt = new DateTime($r['clock_out']);
            
            if($list_mode) {
                // List View Format
                $data[] = array(
                    'id' => $r['id'],
                    'start' => $start_dt->format('Y-m-d'),
                    'employee_name' => $r['employee_name'],
                    'title' => $r['job_code'] ? $r['job_code'].' - '.$r['job_title'] : 'General',
                    'clock_in_time' => $start_dt->format('H:i'),
                    'clock_out_time' => $end_dt->format('H:i'),
                    'total_hours' => $r['total_hours'],
                    'status' => $r['status']
                );
            } else {
                // Full Calendar Format
                $color = '#3b82f6'; // Default Blue (Pending)
                if($r['status'] == 'Approved') $color = '#10b981'; // Green
                if($r['status'] == 'Rejected') $color = '#ef4444'; // Red

                $data[] = array(
                    'id' => $r['id'],
                    'title' => $r['employee_name'] . ' (' . $r['total_hours'] . 'h)',
                    'start' => $start_dt->format('Y-m-d\TH:i:s'), // ISO8601
                    'end' => $end_dt->format('Y-m-d\TH:i:s'),     // ISO8601
                    'color' => $color,
                    'allDay' => false
                );
            }
        }
        
        echo json_encode($data);
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
             
             $row['date_only'] = $start_dt->format('Y-m-d'); // For Datepicker
             $row['start_time_only'] = $start_dt->format('H:i');
             $row['end_time_only'] = $end_dt->format('H:i');
             
             echo json_encode($row);
        } else {
            echo json_encode(array());
        }
    }

    // ADD / EDIT
    public function save()
    {
        $id = $this->input->post('id');
        
        $start_time = $this->input->post('start_time'); // HH:mm:ss
        $end_time = $this->input->post('end_time');     // HH:mm:ss

        // Construct DateTime strings
        // We use standard DateTime to ensure we just get Y-m-d from the input date
        $d = new DateTime($this->input->post('date'));
        $date_only = $d->format('Y-m-d');
        
        // Handle cases where time might be empty (e.g. just hours entered)
        if(!$start_time) $start_time = '09:00'; 
        if(!$end_time) {
             // Calculate end time based on hours if provided
             $hours = $this->input->post('total_hours');
             $s = new DateTime($date_only . ' ' . $start_time);
             // handle fractional hours?
            if(strpos($hours, '.') !== false) {
                 $parts = explode('.', $hours);
                 $h = $parts[0];
                 $m = ($parts[1] / 100) * 60; // .50 = 30 mins
                 // simplified logic for now
                 $s->modify("+{$hours} hours");
            } else {
                 $s->modify("+{$hours} hours");
            }
             $end_time = $s->format('H:i');
        }

        $clock_in = $date_only . ' ' . $start_time;
        // Check if end time is next day? Not supporting overnight shifts yet for simplicity, assume same day.
        $clock_out = $date_only . ' ' . $end_time;

        $data = array(
            'employee_id' => $this->input->post('employee_id'),
            'job_code_id' => $this->input->post('job_code'),
            'clock_in' => $clock_in,
            'clock_out' => $clock_out,
            'total_hours' => $this->input->post('total_hours'),
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
?>
