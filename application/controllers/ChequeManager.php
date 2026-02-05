<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChequeManager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        
        // Security check - only admin and above can access
        if ($this->aauth->get_user()->roleid < 5) {
            redirect('access-denied');
        }
        
        $this->load->library("Custom");
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->li_a = 'accounts';
    }

    public function index()
    {
        $head['title'] = "Cheque Registry";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        // Get filter parameters
        $filter_type = $this->input->get('type'); // incoming/outgoing/all
        $filter_status = $this->input->get('status'); // pdc/cleared/returned/all
        $branch_id = $this->input->get('branch_id') ?: 0;
        
        // Build query with joins to get party names
        $this->db->select('geopos_cheques.*, customers.name as customer_name, suppliers.name as supplier_name');
        $this->db->from('geopos_cheques');
        $this->db->join('customers', 'customers.id = geopos_cheques.party_id AND geopos_cheques.type = "incoming"', 'left');
        $this->db->join('suppliers', 'suppliers.id = geopos_cheques.party_id AND geopos_cheques.type = "outgoing"', 'left');
        
        // Apply filters
        if ($filter_type && $filter_type != 'all') {
            $this->db->where('geopos_cheques.type', $filter_type);
        }
        if ($filter_status && $filter_status != 'all') {
            $this->db->where('geopos_cheques.status', $filter_status);
        }
        if ($branch_id > 0) {
            $this->db->where('geopos_cheques->branch_id', $branch_id);
        }
        
        $this->db->order_by('geopos_cheques.issue_date', 'DESC');
        $query = $this->db->get();
        $data['cheques'] = $query->result_array();
        $data['filter_type'] = $filter_type;
        $data['filter_status'] = $filter_status;
        $data['branch_id'] = $branch_id;
        
        // Get branch list for filter
        $this->load->model('locations_model');
        $data['branches'] = $this->locations_model->locations_list();
        
        // Get summary statistics
        $data['stats'] = $this->get_cheque_statistics($branch_id);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('cheques/index', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Add new cheque
     */
    public function add()
    {
        $head['title'] = 'Add Cheque';
        $head['usernm'] = $this->aauth->get_user()->username;
        
        // Form validation
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[incoming,outgoing]');
        $this->form_validation->set_rules('cheque_number', 'Cheque Number', 'required|trim');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('issue_date', 'Issue Date', 'required');
        $this->form_validation->set_rules('clear_date', 'Clear Date', 'required');
        $this->form_validation->set_rules('bank', 'Bank', 'required|trim');
        $this->form_validation->set_rules('party_id', 'Party', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            // Load form
            $data['mode'] = 'add';
            
            // Get customers and suppliers for dropdown
            $this->db->select('id, name');
            $this->db->from('customers');
            $data['customers'] = $this->db->get()->result_array();
            
            $this->db->select('id, name');
            $this->db->from('suppliers');
            $data['suppliers'] = $this->db->get()->result_array();
            
            // Get branch list
            $this->load->model('locations_model');
            $data['branches'] = $this->locations_model->locations_list();
            
            $this->load->view('fixed/header', $head);
            $this->load->view('cheques/form', $data);
            $this->load->view('fixed/footer');
        } else {
            // Save cheque
            $insert_data = array(
                'type' => $this->input->post('type'),
                'cheque_number' => $this->input->post('cheque_number'),
                'amount' => $this->input->post('amount'),
                'issue_date' => $this->input->post('issue_date'),
                'clear_date' => $this->input->post('clear_date'),
                'status' => 'pdc', // Default status
                'party_id' => $this->input->post('party_id'),
                'bank' => $this->input->post('bank'),
                'branch_id' => $this->input->post('branch_id') ?: 0,
                'note' => $this->input->post('note'),
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('geopos_cheques', $insert_data);
            
            $this->session->set_flashdata('message', 'Cheque added successfully!');
            redirect('chequemanager');
        }
    }
    
    public function edit()
    {
        $id = $this->input->get('id');
        $this->load->database();
        $this->db->where('id', $id);
        $data['cheque'] = $this->db->get('geopos_cheques')->row_array();
        
        $head['title'] = "Edit Cheque";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('cheques/edit', $data);
        $this->load->view('fixed/footer');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $date = $this->input->post('date');
        
        $this->load->database();
        
        // Get old cheque data
        $this->db->where('id', $id);
        $old_cheque = $this->db->get('geopos_cheques')->row_array();
        
        $data = array(
            'status' => $status,
            'note' => $note,
            'date' => datefordatabase($date)
        );
        
        $this->db->where('id', $id);
        $this->db->update('geopos_cheques', $data);
        
        // FULL SYNC LOGIC
        // 1. Identify Desired State: Should there be a transaction?
        $should_hav_trans = false;
        if ( ($old_cheque['type'] == 'Outgoing' && $status == 'Issued') || 
             ($old_cheque['type'] == 'Incoming' && $status == 'Cleared') ) {
            $should_hav_trans = true;
        }

        // 2. Identify Current State: Do we have a linked TID?
        $current_tid = $old_cheque['tid'];

        // 3. Reconcile
        if ($should_hav_trans) {
            if ($current_tid > 0) {
                // Update existing transaction (keep it synced)
                // (Optional: Code to update Existing Transaction date/amount/note)
            } else {
                // Create New Transaction
                $this->_create_transaction($id);
            }
        } else {
            // Should NOT have transaction
            if ($current_tid > 0) {
                // Delete existing transaction (Void/Bounce/Pending reversal)
                 $this->db->delete('geopos_transactions', array('id' => $current_tid));
                 // Reset TID in cheque table
                 $this->db->set('tid', 0);
                 $this->db->where('id', $id);
                 $this->db->update('geopos_cheques');
            }
        }
        
        redirect('ChequeManager');
    }

    private function _create_transaction($cheque_id)
    {
        $this->db->where('id', $cheque_id);
        $cheque = $this->db->get('geopos_cheques')->row_array();
        
        $t_data = [
            'acid' => 1, // Default Bank
            'account' => 'Business Bank',
            'cat' => 'Sales', 
            'payer' => $cheque['payee'],
            'payerid' => 0,
            'method' => 'Cheque',
            'date' => $cheque['date'],
            'eid' => $this->aauth->get_user()->id,
            'note' => $cheque['note'] . ' (Ref: Cheque #' . $cheque['id'] . ')',
            'loc' => 0
        ];

        if ($cheque['type'] == 'Incoming') {
            $t_data['credit'] = $cheque['amount'];
            $t_data['debit'] = 0.00;
            $t_data['type'] = 'Income';
        } else {
            $t_data['credit'] = 0.00;
            $t_data['debit'] = $cheque['amount'];
            $t_data['type'] = 'Expense';
            $t_data['cat'] = 'Purchase';
        }

        $this->db->insert('geopos_transactions', $t_data);
        $new_tid = $this->db->insert_id();
        
        // Link backwards
        $this->db->set('tid', $new_tid);
        $this->db->where('id', $cheque_id);
        $this->db->update('geopos_cheques');
    }
    
    /**
     * Get cheque statistics for dashboard
     */
    private function get_cheque_statistics($branch_id = 0)
    {
        $stats = array(
            'total_pdc_in' => 0,
            'total_pdc_out' => 0,
            'total_cleared' => 0,
            'total_returned' => 0,
            'amount_pdc_in' => 0,
            'amount_pdc_out' => 0
        );
        
        // PDC In (Receivable)
        $this->db->select('COUNT(*) as count, SUM(amount) as total');
        $this->db->from('geopos_cheques');
        $this->db->where('type', 'incoming');
        $this->db->where('status', 'pdc');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $result = $this->db->get()->row_array();
        $stats['total_pdc_in'] = $result['count'];
        $stats['amount_pdc_in'] = $result['total'] ?: 0;
        
        // PDC Out (Payable)
        $this->db->select('COUNT(*) as count, SUM(amount) as total');
        $this->db->from('geopos_cheques');
        $this->db->where('type', 'outgoing');
        $this->db->where('status', 'pdc');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $result = $this->db->get()->row_array();
        $stats['total_pdc_out'] = $result['count'];
        $stats['amount_pdc_out'] = $result['total'] ?: 0;
        
        // Cleared
        $this->db->select('COUNT(*) as count');
        $this->db->from('geopos_cheques');
        $this->db->where('status', 'cleared');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $stats['total_cleared'] = $this->db->get()->row()->count;
        
        // Returned
        $this->db->select('COUNT(*) as count');
        $this->db->from('geopos_cheques');
        $this->db->where('status', 'returned');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $stats['total_returned'] = $this->db->get()->row()->count;
        
        return $stats;
    }
}
