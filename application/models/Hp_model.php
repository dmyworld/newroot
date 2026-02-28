<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hp_model extends CI_Model
{
    public function add_contract($data, $installments, $guarantor)
    {
        $this->db->trans_start();
        
        $this->db->insert('geopos_hp_contracts', $data);
        $contract_id = $this->db->insert_id();
        
        foreach ($installments as $ins) {
            $ins['contract_id'] = $contract_id;
            $this->db->insert('geopos_hp_installments', $ins);
        }
        
        if (!empty($guarantor)) {
            $guarantor['contract_id'] = $contract_id;
            $this->db->insert('geopos_hp_guarantors', $guarantor);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status() ? $contract_id : false;
    }

    public function get_contract_datatables($loc = 0)
    {
        $this->_get_contract_datatables_query($loc);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_contract_datatables_query($loc = 0)
    {
        $this->db->select('c.*, cust.name');
        $this->db->from('geopos_hp_contracts c');
        $this->db->join('geopos_customers cust', 'c.customer_id = cust.id', 'left');
        if ($loc) {
            $this->db->where('c.loc', $loc);
        }
        
        $i = 0;
        foreach (['c.id', 'cust.name', 'c.total_amount', 'c.num_installments', 'c.status'] as $item) {
            if ($this->input->post('search')['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count(['c.id', 'cust.name', 'c.total_amount', 'c.num_installments', 'c.status']) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
    }

    public function count_filtered_contracts($loc = 0)
    {
        $this->_get_contract_datatables_query($loc);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_contracts($loc = 0)
    {
        $this->db->from('geopos_hp_contracts');
        if($loc) $this->db->where('loc', $loc);
        return $this->db->count_all_results();
    }

    public function get_contract($id, $loc = 0)
    {
        $this->db->select('c.*, cust.name, cust.phone');
        $this->db->from('geopos_hp_contracts c');
        $this->db->join('geopos_customers cust', 'c.customer_id = cust.id', 'left');
        $this->db->where('c.id', $id);
        if ($loc) $this->db->where('c.loc', $loc);
        return $this->db->get()->row();
    }

    public function get_installments($contract_id)
    {
        $this->db->where('contract_id', $contract_id);
        return $this->db->get('geopos_hp_installments')->result();
    }

    public function get_guarantor($contract_id)
    {
        $this->db->where('contract_id', $contract_id);
        return $this->db->get('geopos_hp_guarantors')->row();
    }

    public function pay_installment($id, $amount, $account_id)
    {
        $this->db->trans_start();
        
        // Update installment
        $this->db->where('id', $id);
        $ins = $this->db->get('geopos_hp_installments')->row();
        $this->db->where('id', $id);
        $this->db->update('geopos_hp_installments', array('status' => 'paid', 'paid_amount' => $amount, 'payment_date' => date('Y-m-d')));

        // Get contract and customer info
        $this->db->where('id', $ins->contract_id);
        $contract = $this->db->get('geopos_hp_contracts')->row();

        // Add transaction for accounting
        $trans_data = array(
            'payerid' => $contract->customer_id,
            'payer' => 'HP Customer',
            'acid' => $account_id,
            'account' => 'HP Collection', // Simple placeholder
            'date' => date('Y-m-d'),
            'debit' => 0,
            'credit' => $amount,
            'type' => 'Income',
            'cat' => 'HP Payment',
            'method' => 'Cash',
            'note' => 'HP Installment payment for contract #' . $ins->contract_id,
            'loc' => $contract->loc
        );
        $this->db->insert('geopos_transactions', $trans_data);
        
        // Update account balance
        $this->db->set('lastbal', "lastbal+$amount", FALSE);
        $this->db->where('id', $account_id);
        $this->db->update('geopos_accounts');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_stats($loc = 0)
    {
        $this->db->select('COUNT(*) as total_contracts');
        if($loc) $this->db->where('loc', $loc);
        $data['total_contracts'] = $this->db->get('geopos_hp_contracts')->row()->total_contracts;

        $this->db->select('COUNT(*) as active_contracts');
        $this->db->where('status', 'active');
        if($loc) $this->db->where('loc', $loc);
        $data['active_contracts'] = $this->db->get('geopos_hp_contracts')->row()->active_contracts;

        $this->db->select('COUNT(*) as completed_contracts');
        $this->db->where('status', 'completed');
        if($loc) $this->db->where('loc', $loc);
        $data['completed_contracts'] = $this->db->get('geopos_hp_contracts')->row()->completed_contracts;

        // Due installments (count unpaid where due_date <= today)
        $this->db->select('COUNT(*) as due_installments');
        $this->db->from('geopos_hp_installments i');
        $this->db->join('geopos_hp_contracts c', 'i.contract_id = c.id');
        $this->db->where('i.status', 'unpaid');
        $this->db->where('i.due_date <=', date('Y-m-d'));
        if($loc) $this->db->where('c.loc', $loc);
        $data['due_installments'] = $this->db->get()->row()->due_installments;

        return $data;
    }
}
