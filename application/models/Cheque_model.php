<?php
/**
 * GekoPOS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dony. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@gekopos.com
 *  Website: https://www.gekopos.com
 *
 *  ************************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Cheque_model extends CI_Model
{
    /**
     * Create a cheque record automatically from a payment
     * 
     * @param array $data Contains amount, party_id, party_type, cheque_number, date, note, bank, etc.
     */
    public function create_from_payment($data)
    {
        // Determine type based on party_type
        // Invoices/POS (Customers) -> Incoming
        // Purchase/Expenses (Suppliers/Employees) -> Outgoing
        $type = 'Incoming';
        if ($data['party_type'] == 'Supplier' || $data['party_type'] == 'Employee') {
            $type = 'Outgoing';
        }

        $party_name = $this->get_party_name($data['party_id'], $data['party_type']);

        $insert_data = array(
            'type' => $type,
            'cheque_number' => $data['cheque_number'] ?? '',
            'amount' => $data['amount'],
            'issue_date' => $data['date'],
            'clear_date' => $data['date'], // Default to same day for automated entries
            'date' => $data['date'], // Legacy field
            'payee' => $party_name, // Legacy field
            'status' => 'Pending',
            'party_id' => $data['party_id'],
            'party_type' => $data['party_type'],
            'bank' => $data['bank'] ?? 'Unspecified',
            'branch_id' => $data['branch_id'] ?? 0,
            'note' => $data['note'] ?? '',
            'tid' => $data['tid'] ?? 0, // Transaction ID
            'doc_id' => $data['doc_id'] ?? 0, // Source Document ID (Invoice/Purchase)
            'doc_type' => $data['doc_type'] ?? '', // Source Document Type (e.g., 'invoice', 'purchase', 'purchase_wood')
            'created_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('geopos_cheques', $insert_data);
    }

    /**
     * Helper to get party name for legacy 'payee' field
     */
    private function get_party_name($id, $type)
    {
        if ($type == 'Customer') {
            $this->db->select('name');
            $this->db->from('geopos_customers');
            $this->db->where('id', $id);
            $res = $this->db->get()->row_array();
            return $res ? $res['name'] : 'Unknown Customer';
        } elseif ($type == 'Supplier') {
            $this->db->select('name');
            $this->db->from('geopos_supplier');
            $this->db->where('id', $id);
            $res = $this->db->get()->row_array();
            return $res ? $res['name'] : 'Unknown Supplier';
        } elseif ($type == 'Employee') {
            $this->db->select('name');
            $this->db->from('geopos_employees');
            $this->db->where('id', $id);
            $res = $this->db->get()->row_array();
            return $res ? $res['name'] : 'Unknown Employee';
        }
        return 'Unknown Party';
    }
}
