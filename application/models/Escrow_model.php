<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escrow_model extends CI_Model
{
    const T_VAULT = 'tp_escrow_vault';
    const T_TX    = 'tp_escrow_transactions';

    public function get_held($loc)
    {
        return $this->db->where('loc', $loc)
                        ->where_in('status', ['pending', 'held', 'disputed'])
                        ->order_by('created_at', 'DESC')
                        ->get(self::T_VAULT)->result_array();
    }

    public function get_summary($loc)
    {
        $this->db->select('status, SUM(amount) as total_amount, COUNT(*) as cnt');
        $this->db->where('loc', $loc);
        $this->db->group_by('status');
        return $this->db->get(self::T_VAULT)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get(self::T_VAULT)->row_array();
    }

    public function get_transactions($escrow_id)
    {
        return $this->db->where('escrow_id', $escrow_id)
                        ->order_by('created_at', 'ASC')
                        ->get(self::T_TX)->result_array();
    }

    public function create_hold($data, $performed_by)
    {
        $fee    = round($data['amount'] * 0.02, 2); // 2% platform fee
        $net    = $data['amount'] - $fee;
        $ref    = 'ESC-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        $row    = array_merge($data, [
            'escrow_ref' => $ref,
            'fee'        => $fee,
            'net_amount' => $net,
            'currency'   => 'LKR',
            'status'     => 'held',
            'held_at'    => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $this->db->insert(self::T_VAULT, $row);
        $escrow_id = $this->db->insert_id();
        $this->_log($escrow_id, 'hold', $data['amount'], $performed_by, 'Escrow hold created');
        return $escrow_id;
    }

    public function release($escrow_id, $performed_by)
    {
        $e = $this->get_by_id($escrow_id);
        if (!$e || $e['status'] !== 'held') return false;
        $this->db->where('id', $escrow_id)->update(self::T_VAULT, [
            'status'      => 'released',
            'released_at' => date('Y-m-d H:i:s'),
        ]);
        $this->_log($escrow_id, 'release', $e['net_amount'], $performed_by, 'Funds released to payee');
        return true;
    }

    public function refund($escrow_id, $performed_by)
    {
        $e = $this->get_by_id($escrow_id);
        if (!$e || !in_array($e['status'], ['held', 'disputed'])) return false;
        $this->db->where('id', $escrow_id)->update(self::T_VAULT, [
            'status'      => 'refunded',
            'refunded_at' => date('Y-m-d H:i:s'),
        ]);
        $this->_log($escrow_id, 'refund', $e['amount'], $performed_by, 'Funds refunded to payer');
        return true;
    }

    // Append-only ledger entry — NO-DELETE POLICY
    private function _log($escrow_id, $action, $amount, $performed_by, $note = '')
    {
        $this->db->insert(self::T_TX, [
            'escrow_id'    => $escrow_id,
            'action'       => $action,
            'amount'       => $amount,
            'performed_by' => $performed_by,
            'note'         => $note,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }
}
