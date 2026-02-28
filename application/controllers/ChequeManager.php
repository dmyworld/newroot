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
        $this->load->library("session");
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
        $this->db->select('geopos_cheques.*, geopos_customers.name as customer_name, geopos_supplier.name as supplier_name, geopos_locations.cname as location_name');
        $this->db->from('geopos_cheques');
        $this->db->join('geopos_customers', 'geopos_customers.id = geopos_cheques.party_id AND geopos_cheques.type = "Incoming"', 'left');
        $this->db->join('geopos_supplier', 'geopos_supplier.id = geopos_cheques.party_id AND geopos_cheques.type = "Outgoing"', 'left');
        $this->db->join('geopos_locations', 'geopos_locations.id = geopos_cheques.branch_id', 'left');
        
        // Apply filters
        if ($filter_type && $filter_type != 'all') {
            $this->db->where('LOWER(geopos_cheques.type)', strtolower($filter_type));
        }
        if ($filter_status && $filter_status != 'all') {
            $this->db->where('geopos_cheques.status', $filter_status);
        }
        if ($branch_id > 0) {
            $this->db->where('geopos_cheques.branch_id', $branch_id);
        }
        
        $this->db->order_by('geopos_cheques.issue_date', 'DESC');
        $query = $this->db->get();
        $data['cheques'] = $query ? $query->result_array() : array();
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
            $this->db->from('geopos_customers');
            $query = $this->db->get();
            $data['customers'] = $query ? $query->result_array() : array();
            
            $this->db->select('id, name');
            $this->db->from('geopos_supplier');
            $query = $this->db->get();
            $data['suppliers'] = $query ? $query->result_array() : array();
            
            // Get branch list
            $this->load->model('locations_model');
            $data['branches'] = $this->locations_model->locations_list();
            
            $this->load->view('fixed/header', $head);
            $this->load->view('cheques/form', $data);
            $this->load->view('fixed/footer');
        } else {
            // Save cheque
            $type = ucfirst(strtolower($this->input->post('type')));
            $party_id = $this->input->post('party_id');
            $payee_name = '';

            // Get payee name for legacy 'payee' column
            if ($type == 'Incoming') {
                $this->db->select('name');
                $this->db->from('geopos_customers');
                $this->db->where('id', $party_id);
                $res = $this->db->get()->row_array();
                $payee_name = $res ? $res['name'] : 'Unknown Customer';
                $party_type = 'Customer';
            } else {
                $this->db->select('name');
                $this->db->from('geopos_supplier');
                $this->db->where('id', $party_id);
                $res = $this->db->get()->row_array();
                $payee_name = $res ? $res['name'] : 'Unknown Supplier';
                $party_type = 'Supplier';
            }

            $insert_data = array(
                'type' => $type,
                'cheque_number' => $this->input->post('cheque_number'),
                'amount' => $this->input->post('amount'),
                'issue_date' => $this->input->post('issue_date'),
                'clear_date' => $this->input->post('clear_date'),
                'date' => $this->input->post('issue_date'), // Legacy mapping
                'payee' => $payee_name, // Legacy mapping
                'status' => 'Pending',
                'party_id' => $party_id,
                'party_type' => $party_type,
                'bank' => $this->input->post('bank'),
                'branch_id' => $this->input->post('branch_id') ?: 0,
                'note' => $this->input->post('note'),
                'doc_id' => $this->input->post('doc_id') ?: 0,
                'doc_type' => $this->input->post('doc_type') ?: '',
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('geopos_cheques', $insert_data);
            
            $this->session->set_flashdata('message', 'Cheque added successfully!');
            redirect('ChequeManager');
        }
    }
    
    public function edit()
    {
        $id = $this->input->get('id');
        $this->load->database();
        
        // Build query with joins to get party names
        $this->db->select('geopos_cheques.*, geopos_customers.name as customer_name, geopos_supplier.name as supplier_name');
        $this->db->from('geopos_cheques');
        $this->db->join('geopos_customers', 'geopos_customers.id = geopos_cheques.party_id AND geopos_cheques.type = "Incoming"', 'left');
        $this->db->join('geopos_supplier', 'geopos_supplier.id = geopos_cheques.party_id AND geopos_cheques.type = "Outgoing"', 'left');
        $this->db->where('geopos_cheques.id', $id);
        $data['cheque'] = $this->db->get()->row_array();
        
        $head['title'] = "Edit/Approve Cheque";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('cheques/edit', $data);
        $this->load->view('fixed/footer');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $status = strtolower($this->input->post('status')); // Standardize to lowercase
        $note = $this->input->post('note');
        $date = $this->input->post('date');
        
        $this->load->database();

        // Ensure doc_id and doc_type columns exist for rollback tracking
        if (!$this->db->field_exists('doc_id', 'geopos_cheques')) {
            $this->load->dbforge();
            $this->dbforge->add_column('geopos_cheques', array('doc_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0)));
        }
        if (!$this->db->field_exists('doc_type', 'geopos_cheques')) {
            $this->load->dbforge();
            $this->dbforge->add_column('geopos_cheques', array('doc_type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => '')));
        }
        
        // Get old cheque data
        $this->db->where('id', $id);
        $old_cheque = $this->db->get('geopos_cheques')->row_array();
        
        // Standardize status to match DB schema enums (Capitalized)
        $status_map = array(
            'pdc' => 'Pending',
            'pending' => 'Pending',
            'cleared' => 'Cleared',
            'returned' => 'Bounced',
            'bounced' => 'Bounced',
            'cancelled' => 'Cancelled'
        );
        $final_status = isset($status_map[strtolower($status)]) ? $status_map[strtolower($status)] : 'Pending';

        $data = array(
            'status' => $final_status,
            'note' => $note,
            'clear_date' => datefordatabase($date) // Update clear_date as release date
        );
        
        $this->db->where('id', $id);
        $this->db->update('geopos_cheques', $data);
        
        // REFRESH record after update to ensure we have any newly migrated doc_id/doc_type
        $this->db->where('id', $id);
        $latest_cheque = $this->db->get('geopos_cheques')->row_array();
        
        // SYNC & ROLLBACK LOGIC
        $current_tid = $latest_cheque['tid'];

        if (strtolower($final_status) == 'cleared') {
            // Ensure transaction exists and is correct
            if ($current_tid > 0) {
                // Update existing transaction metadata
                $this->db->set('date', datefordatabase($date));
                $this->db->set('note', $note . ' (Ref: Cheque #' . $latest_cheque['cheque_number'] . ')');
                $this->db->where('id', $current_tid);
                $this->db->update('geopos_transactions');
            } else {
                // Create New Transaction if none exists (e.g. manually added cheque now clearing)
                $this->_create_transaction($id);
            }
        } elseif (in_array(strtolower($final_status), ['bounced', 'void', 'cancelled', 'returned'])) {
             // ROLLBACK ACTION: Status is Bounced/Void -> Reverse Payment
             if ($current_tid > 0) {
                // Fetch transaction to reverse account balance before deletion
                $this->db->where('id', $current_tid);
                $trans = $this->db->get('geopos_transactions')->row_array();
                if ($trans) {
                    // Reverse account balance logic
                    // If Income (Credit), subtract from balance (Debit behavior)
                    // If Expense (Debit), add back to balance (Credit behavior)
                    $rev_amount = $trans['credit'] - $trans['debit']; // +ve for Income, -ve for Expense
                    
                    $this->db->set('lastbal', "lastbal-$rev_amount", FALSE);
                    $this->db->where('id', $trans['acid']);
                    $this->db->update('geopos_accounts');
                    
                    // Delete the transaction
                    $this->db->delete('geopos_transactions', array('id' => $current_tid));
                }

                // Reset TID in cheque table
                $this->db->set('tid', 0);
                $this->db->where('id', $id);
                $this->db->update('geopos_cheques');
            }

            // REVERT SOURCE DOCUMENT (Invoice/Purchase)
            if ($latest_cheque['doc_id'] > 0 && !empty($latest_cheque['doc_type'])) {
                $table = '';
                switch (strtolower($latest_cheque['doc_type'])) {
                    case 'invoice': $table = 'geopos_invoices'; break;
                    case 'purchase': $table = 'geopos_purchase'; break;
                    case 'purchase_logs': $table = 'geopos_purchase_logs'; break;
                    case 'purchase_wood': $table = 'geopos_purchase_wood'; break;
                }
                
                if ($table) {
                    $c_amount = $latest_cheque['amount'];
                    // Decrement paid amount in source doc
                    $this->db->set('pamnt', "pamnt-$c_amount", FALSE);
                    $this->db->set('status', 'partial'); // Set to partial temporarily
                    $this->db->where('id', $latest_cheque['doc_id']);
                    $this->db->update($table);
                    
                    // Correct status to 'due' if paid amount reaches 0 or less
                    $this->db->select('pamnt, total');
                    $this->db->where('id', $latest_cheque['doc_id']);
                    $doc_check = $this->db->get($table)->row_array();
                    
                    // Use tolerance for float comparison
                    if ($doc_check && $doc_check['pamnt'] <= 0.01) {
                         $this->db->set('status', 'due');
                         // Ensure pamnt is exactly 0 if it dipped below due to float errors
                         if ($doc_check['pamnt'] < 0) $this->db->set('pamnt', 0.00);
                         
                         $this->db->where('id', $latest_cheque['doc_id']);
                         $this->db->update($table);
                    }
                }
            }
        } 
        // NOTE: if Status is 'Pending' or 'Signed' or 'Issued', we DO NOT touch the transaction.
        // It remains as is (if it exists). 
        // If it doesn't exist, we don't create it yet (wait for Cleared).
        
        redirect('ChequeManager');
    }

    private function _create_transaction($cheque_id)
    {
        $this->db->where('id', $cheque_id);
        $cheque = $this->db->get('geopos_cheques')->row_array();
        
        // Get account info (prefer bank account)
        $this->db->where('id', 1); // Default Bank Account
        $account = $this->db->get('geopos_accounts')->row_array();

        $t_data = [
            'acid' => $account['id'] ?: 1,
            'account' => $account['holder'] ?: 'Business Bank',
            'cat' => (strtolower($cheque['type']) == 'incoming') ? 'Sales' : 'Purchase', 
            'payer' => 'Cheque Ref: ' . $cheque['cheque_number'],
            'payerid' => $cheque['party_id'],
            'method' => 'Cheque',
            'date' => $cheque['clear_date'], // Use clear_date as transaction date
            'eid' => $this->aauth->get_user()->id,
            'note' => $cheque['note'] . ' (Ref: Cheque #' . $cheque['cheque_number'] . ')',
            'loc' => $cheque['branch_id']
        ];

        if (strtolower($cheque['type']) == 'incoming') {
            $t_data['credit'] = $cheque['amount'];
            $t_data['debit'] = 0.00;
            $t_data['type'] = 'Income';
        } else {
            $t_data['credit'] = 0.00;
            $t_data['debit'] = $cheque['amount'];
            $t_data['type'] = 'Expense';
        }

        $this->db->insert('geopos_transactions', $t_data);
        $new_tid = $this->db->insert_id();
        
        // Link backwards
        $this->db->set('tid', $new_tid);
        $this->db->where('id', $cheque_id);
        $this->db->update('geopos_cheques');
    }
    
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
        
        if (!$this->db->table_exists('geopos_cheques')) return $stats;

        // PDC In (Receivable)
        $this->db->select('COUNT(*) as count, SUM(amount) as total');
        $this->db->from('geopos_cheques');
        $this->db->where('LOWER(type)', 'incoming');
        $this->db->where('LOWER(status)', 'pending');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        $result = $query ? $query->row_array() : null;
        if ($result) {
            $stats['total_pdc_in'] = $result['count'];
            $stats['amount_pdc_in'] = $result['total'] ?: 0;
        }
        
        // PDC Out (Payable)
        $this->db->select('COUNT(*) as count, SUM(amount) as total');
        $this->db->from('geopos_cheques');
        $this->db->where('LOWER(type)', 'outgoing');
        $this->db->where('LOWER(status)', 'pending');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        $result = $query ? $query->row_array() : null;
        if ($result) {
            $stats['total_pdc_out'] = $result['count'];
            $stats['amount_pdc_out'] = $result['total'] ?: 0;
        }
        
        // Cleared
        $this->db->select('COUNT(*) as count');
        $this->db->from('geopos_cheques');
        $this->db->where('LOWER(status)', 'cleared');
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        $stats['total_cleared'] = ($query && $query->row()) ? $query->row()->count : 0;
        
        // Returned
        $this->db->select('COUNT(*) as count');
        $this->db->from('geopos_cheques');
        $this->db->where_in('LOWER(status)', array('returned', 'bounced'));
        if ($branch_id > 0) $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        $stats['total_returned'] = ($query && $query->row()) ? $query->row()->count : 0;
        
        return $stats;
    }
}
