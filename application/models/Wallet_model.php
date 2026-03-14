<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ensure wallet row exists for given user and return it.
     */
    public function get_or_create_wallet(int $user_id): array
    {
        $row = $this->db->where('user_id', $user_id)
            ->get('tp_wallets')
            ->row_array();

        if ($row) {
            return $row;
        }

        // Default currency from system
        $currency_row = $this->db->select('currency')
            ->from('geopos_system')
            ->where('id', 1)
            ->get()
            ->row_array();
        $currency = $currency_row && !empty($currency_row['currency']) ? $currency_row['currency'] : 'LKR';

        $data = [
            'user_id'  => $user_id,
            'balance'  => 0.00,
            'currency' => $currency,
            'status'   => 1,
        ];
        $this->db->insert('tp_wallets', $data);
        $data['id'] = $this->db->insert_id();
        return $data;
    }

    /**
     * Credit wallet (increase balance).
     */
    public function credit(int $user_id, float $amount, string $ref_type, int $ref_id = null, array $meta = []): array
    {
        if ($amount <= 0) {
            return ['status' => 'skipped', 'reason' => 'non_positive_amount'];
        }

        $wallet = $this->get_or_create_wallet($user_id);

        $this->db->trans_start();

        $this->db->set('balance', 'balance + ' . $amount, false)
            ->where('id', (int)$wallet['id'])
            ->update('tp_wallets');

        $this->db->insert('tp_wallet_transactions', [
            'wallet_id' => (int)$wallet['id'],
            'ref_type'  => $ref_type,
            'ref_id'    => $ref_id,
            'direction' => 'credit',
            'amount'    => $amount,
            'meta'      => !empty($meta) ? json_encode($meta) : null,
        ]);

        $this->db->trans_complete();

        return [
            'status'  => $this->db->trans_status() ? 'success' : 'error',
            'wallet_id' => (int)$wallet['id'],
        ];
    }

    /**
     * Debit wallet (decrease balance).
     */
    public function debit(int $user_id, float $amount, string $ref_type, int $ref_id = null, array $meta = []): array
    {
        if ($amount <= 0) {
            return ['status' => 'skipped', 'reason' => 'non_positive_amount'];
        }

        $wallet = $this->get_or_create_wallet($user_id);

        $this->db->trans_start();

        $this->db->set('balance', 'balance - ' . $amount, false)
            ->where('id', (int)$wallet['id'])
            ->update('tp_wallets');

        $this->db->insert('tp_wallet_transactions', [
            'wallet_id' => (int)$wallet['id'],
            'ref_type'  => $ref_type,
            'ref_id'    => $ref_id,
            'direction' => 'debit',
            'amount'    => $amount,
            'meta'      => !empty($meta) ? json_encode($meta) : null,
        ]);

        $this->db->trans_complete();

        return [
            'status'  => $this->db->trans_status() ? 'success' : 'error',
            'wallet_id' => (int)$wallet['id'],
        ];
    }
}

