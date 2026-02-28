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

class Transactions_model extends CI_Model
{
    var $table = 'geopos_transactions';
    var $column_order = array('date', 'acid', 'debit', 'credit', 'payer', 'method');
    var $column_search = array('id', 'account', 'payer');
    var $order = array('id' => 'desc');
    var $opt = '';

    private function _get_datatables_query()
    {
        $this->db->select('geopos_transactions.*,geopos_transactions.id as id');
        $this->db->from($this->table);
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = 'all')
    {
        $this->opt = $opt;
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('geopos_transactions');
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }

        return $this->db->count_all_results();
    }

    public function categories()
    {
        $this->db->select('*');
        $this->db->from('geopos_trans_cat');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function acc_list()
    {
        $this->db->select('id,acn,holder');
        $this->db->from('geopos_accounts');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get a mapped account ID by setting key
     * 
     * @param string $key Setting key (e.g., 'sales_income_acc')
     * @return int Account ID or 0
     */
    public function get_mapped_account($key)
    {
        $this->db->select('val');
        $this->db->from('geopos_config');
        $this->db->where('type', 100); // System settings
        $this->db->where('key1', $key);
        $query = $this->db->get();
        $row = $query->row_array();
        return isset($row['val']) ? (int)$row['val'] : 0;
    }

    public function addcat($name)
    {
        $data = array(
            'name' => $name
        );

        return $this->db->insert('geopos_trans_cat', $data);
    }

    /**
     * Add a transaction entry
     * 
     * @param int $payer_id Payer ID
     * @param string $payer_name Payer name
     * @param int $pay_acc Account ID
     * @param string $date Transaction date (Y-m-d H:i:s format for full timestamp)
     * @param float $debit Debit amount
     * @param float $credit Credit amount
     * @param string $pay_type Transaction type (Income/Expense)
     * @param string $pay_cat Transaction category
     * @param string $paymethod Payment method
     * @param string $note Transaction note
     * @param int $eid Employee/User ID
     * @param int $loc Location ID
     * @param int $ty External type flag
     * @param int $wallet_balance Wallet balance flag
     * @param int $doc_id Document ID
     * @param string $doc_type Document type
     * @param int $link_id Link ID
     * @return mixed Insert result
     */
        public function addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $eid, $loc = 0, $ty = 0, $wallet_balance = 0, $doc_id = 0, $doc_type = '', $link_id = 0)
    {
        if (!$loc) $loc = $this->aauth->get_user()->loc;

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $pay_acc);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            $account = $query->row_array();
            
            
            
             
            
            
             if ($wallet_balance == 1) {
            
                    $this->db->set('balance', "balance+$credit", FALSE);
                           $this->db->where('id', $payer_id);

                           $this->db->update('geopos_customers');

                                             $data = array(
                                                 'type' => 21,
                                                 'rid' => $payer_id,
                                                 'col1' => $credit,
                                                 'col2' => date('Y-m-d H:i:s') . ' Account Recharge by ' . $this->aauth->get_user()->username
                                             );


                                              $this->db->insert('geopos_metadata', $data);
                                              $this->aauth->applog("[Client Wallet Recharge] Amt-$credit ID " . $payer_id, $this->aauth->get_user()->username);
                 
                 
             } 
        
        
        
        
        
           
                                                 
                                            


            if ($account) {
                $data = array(
                    'payerid' => $payer_id,
                    'payer' => $payer_name,
                    'acid' => $pay_acc,
                    'account' => $account['holder'],
                    'date' => $date,
                    'debit' => $debit,
                    'credit' => $credit,
                    'type' => $pay_type,
                    'cat' => $pay_cat,
                    'method' => $paymethod,
                    'eid' => $eid,
                    'note' => $note,
                    'ext' => $ty,
                    'loc' => $loc,
                    'link_id' => $link_id
                );
                $amount = $credit - $debit;
                $this->db->set('lastbal', "lastbal+$amount", FALSE);
                $this->db->where('id', $pay_acc);
                $this->db->update('geopos_accounts');

                $res = $this->db->insert('geopos_transactions', $data);
                $tid = $this->db->insert_id();

                // Cheque Manager Integration
                $cheque_number = $this->input->post('cheque_number', true);
                
                // FORCE 'Cheque' method if a cheque number is provided
                if (!empty($cheque_number) && $paymethod != 'Cheque') {
                    $paymethod = 'Cheque';
                    // Update the transaction data array before insertion if it hasn't been inserted yet
                     $data['method'] = 'Cheque';
                }

                // Case-insensitive check for Cheque/Bank
                if (strtolower($paymethod) == 'bank' || strtolower($paymethod) == 'cheque') {
                    $this->load->model('cheque_model');
                    
                    // Determine party type based on $pay_type (Income -> Customer, Expense -> Supplier)
                    $party_type = ($pay_type == 'Income') ? 'Customer' : 'Supplier';
                    
                    $cheque_data = array(
                        'amount' => ($pay_type == 'Income') ? $credit : $debit,
                        'party_id' => $payer_id,
                        'party_type' => $party_type,
                        'cheque_number' => $cheque_number,
                        'date' => $date,
                        'tid' => $tid,
                        'doc_id' => $doc_id,
                        'doc_type' => $doc_type,
                        'branch_id' => $this->aauth->get_user()->loc, // Save Location
                        'note' => $note
                    );
                    $this->cheque_model->create_from_payment($cheque_data);
                }

                return $res;
            }
        }
    }

    public function addtransfer($pay_acc, $pay_acc2, $amount, $eid, $loc = 0)
    {

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $pay_acc);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            $account = $query->row_array();
            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $pay_acc2);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            $account2 = $query->row_array();

            if ($account2) {
                $data = array(
                    'payerid' => '',
                    'payer' => '',
                    'acid' => $pay_acc2,
                    'account' => $account2['holder'],
                    'date' => date('Y-m-d'),
                    'debit' => 0,
                    'credit' => $amount,
                    'type' => 'Transfer',
                    'cat' => '',
                    'method' => '',
                    'eid' => $eid,
                    'note' => 'Transferred by ' . $account['holder'],
                    'ext' => 9,
                    'loc' => $loc
                );
                $this->db->insert('geopos_transactions', $data);


                $this->db->set('lastbal', "lastbal+$amount", FALSE);
                $this->db->where('id', $pay_acc2);
                $this->db->update('geopos_accounts');
                $datec = date('Y-m-d');

                $data = array(
                    'payerid' => '',
                    'payer' => '',
                    'acid' => $pay_acc,
                    'account' => $account['holder'],
                    'date' => $datec,
                    'debit' => $amount,
                    'credit' => 0,
                    'type' => 'Transfer',
                    'cat' => '',
                    'method' => '',
                    'eid' => $eid,
                    'note' => 'Transferred to ' . $account['holder'],
                    'ext' => 9,
                    'loc' => $loc
                );

                $this->db->set('lastbal', "lastbal-$amount", FALSE);
                $this->db->where('id', $pay_acc);
                $this->db->update('geopos_accounts');

                return $this->db->insert('geopos_transactions', $data);
            }
        }
    }


    public function delt($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $trans = $query->row_array();

        if (!$trans) {
            return array('status' => 'Error', 'message' => 'Transaction not found');
        }

        // --- FULL ROLLBACK LOGIC ---

        // 1. Check for Linked Transaction (Dual-Entry)
        if ($trans['link_id'] > 0) {
            $this->db->select('id');
            $this->db->from('geopos_transactions');
            $this->db->where('link_id', $trans['link_id']);
            $this->db->where('id !=', $id); // Find the counterpart
            $l_query = $this->db->get();
            $l_trans = $l_query->row_array();

            if ($l_trans) {
                // Recursively delete the counterpart (but clear link_id first to avoid infinite loop)
                $this->db->set('link_id', 0);
                $this->db->where('id', $l_trans['id']);
                $this->db->update('geopos_transactions');
                $this->delt($l_trans['id']);
            }
        }

        // 2. Reverse Account Balance
        $amt = $trans['credit'] - $trans['debit'];
        $this->db->set('lastbal', "lastbal-$amt", FALSE);
        $this->db->where('id', $trans['acid']);
        $this->db->update('geopos_accounts');

        // 3. Reverse Invoice Payment (if applicable)
        if ($trans['tid'] > 0 && $trans['ext'] == 0) {
            $crd = $trans['credit'];
            $this->db->set('pamnt', "pamnt-$crd", FALSE);
            $this->db->set('status', "partial");
            $this->db->where('id', $trans['tid']);
            $this->db->update('geopos_invoices');
        }

        // 4. Delete Associated Cheques
        $this->db->delete('geopos_cheques', array('tid' => $id));

        // 5. Delete the Transaction itself
        $this->db->delete('geopos_transactions', array('id' => $id));

        // 6. Logging/Alerts
        $alert = $this->custom->api_config(66);
        if ($alert['key2'] == 1) {
            $this->load->model('communication_model');
            $subject = $trans['payer'] . ' ' . $this->lang->line('DELETED');
            $body = $subject . '<br> ' . $this->lang->line('Credit') . ' ' . $this->lang->line('Amount') . ' ' . $trans['credit'] . '<br> ' . $this->lang->line('Debit') . ' ' . $this->lang->line('Amount') . ' ' . $trans['debit'] . '<br> ID# ' . $trans['id'];
            $this->communication_model->send_corn_email($alert['url'], $alert['url'], $subject, $body, false, '');
        }

        return array('status' => 'Success', 'message' => $this->lang->line('DELETED'));
    }

    public function view($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('id', $id);

        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function cview($id, $ext = 0)
    {

        if ($ext == 1) {
            $this->db->select('*');
            $this->db->from('geopos_supplier');
            $this->db->where('id', $id);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            return $query->row_array();
        } elseif ($ext == 4) {
            $this->db->select('geopos_employees.*,geopos_users.email');
            $this->db->from('geopos_employees');
            $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
            $this->db->where('geopos_employees.id', $id);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('geopos_customers');
            $this->db->where('id', $id);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            return $query->row_array();
        }

    }

    public function cat_details($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_trans_cat');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function cat_update($id, $cat_name)
    {

        $data = array(
            'name' => $cat_name

        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('geopos_trans_cat')) {
            return true;
        } else {
            return false;
        }
    }

    public function check_balance($id)
    {
        $this->db->select('balance');
        $this->db->from('geopos_customers');
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    
    
    
    
    
  
    
    
    
    


    public function category_totals($loc = 0, $s_date = '', $e_date = '')
    {
        $this->db->select('cat, SUM(debit) as total_debit, SUM(credit) as total_credit');
        $this->db->from('geopos_transactions');
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        }
        if ($s_date && $e_date) {
            $this->db->where('date >=', $s_date);
            $this->db->where('date <=', $e_date);
        }
        $this->db->group_by('cat');
        $query = $this->db->get();
        $result = $query->result_array();
        
        $totals = [];
        foreach ($result as $row) {
            $totals[$row['cat']] = $row;
        }
        return $totals;
    }

    /**
     * Generate a unique formatted transaction ID
     * Format: TRX-YYYY-NNNN (e.g., TRX-2026-0001)
     * 
     * @return string Unique transaction ID
     */
    public function get_unique_tid()
    {
        $year = date('Y');
        $prefix = "TRX-$year-";
        
        // Get the last transaction ID for this year
        $this->db->select('note');
        $this->db->from('geopos_transactions');
        $this->db->like('note', $prefix, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $last_note = $query->row()->note;
            // Extract the sequence number from the last TID
            if (preg_match('/TRX-\d{4}-(\d+)/', $last_note, $matches)) {
                $sequence = intval($matches[1]) + 1;
            } else {
                $sequence = 1;
            }
        } else {
            $sequence = 1;
        }
        
        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Add a double-entry journal entry (Debit and Credit)
     * This ensures balanced accounting entries
     * 
     * @param int $debit_acc Debit account ID
     * @param int $credit_acc Credit account ID
     * @param float $amount Transaction amount
     * @param string $note Transaction note/description
     * @param int $payer_id Payer/Party ID (customer/supplier)
     * @param string $payer_name Payer/Party name
     * @param string $category Transaction category
     * @param string $method Payment method
     * @param string $date Transaction date (datetime format)
     * @param int $loc Location/Branch ID
     * @param int $ext External flag (0=customer, 1=supplier)
     * @param int $link_id Link to source document (invoice, purchase, etc.)
     * @return bool Success status
     */
    public function add_double_entry($debit_acc, $credit_acc, $amount, $note, $payer_id = 0, $payer_name = '', 
                                     $category = '', $method = 'Journal', $date = '', $loc = 0, $ext = 0, $link_id = 0)
    {
        if (!$date) {
            $date = date('Y-m-d H:i:s');
        }
        
        if (!$loc) {
            $loc = $this->aauth->get_user()->loc;
        }
        
        $eid = $this->aauth->get_user()->id;
        
        // Resolve mapped accounts if keys are passed instead of IDs
        if (is_string($debit_acc)) $debit_acc = $this->get_mapped_account($debit_acc);
        if (is_string($credit_acc)) $credit_acc = $this->get_mapped_account($credit_acc);

        if (!$debit_acc || !$credit_acc) {
            return false; // Cannot record unbalanced entry or missing mapping
        }

        // Generate unique TID for audit trail
        $unique_tid = $this->get_unique_tid();
        $note_with_tid = $unique_tid . ' - ' . $note;
        
        $this->db->trans_start();
        
        // Debit Entry
        $debit_result = $this->addtrans(
            $payer_id,
            $payer_name,
            $debit_acc,
            $date,
            $amount,      // Debit
            0,            // Credit
            'Expense',    // Type (Debit increases expenses/assets)
            $category,
            $method,
            $note_with_tid,
            $eid,
            $loc,
            $ext,
            0,           // wallet_balance
            0,           // doc_id
            '',          // doc_type
            $link_id
        );
        
        // Credit Entry
        $credit_result = $this->addtrans(
            $payer_id,
            $payer_name,
            $credit_acc,
            $date,
            0,            // Debit
            $amount,      // Credit
            'Income',     // Type (Credit increases income/liabilities)
            $category,
            $method,
            $note_with_tid,
            $eid,
            $loc,
            $ext,
            0,           // wallet_balance
            0,           // doc_id
            '',          // doc_type
            $link_id
        );
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        
        // Log to audit trail
        $this->aauth->applog("[$unique_tid] Double Entry Recorded. Link: $link_id", $this->aauth->get_user()->username);
        
        return true;
    }
}
