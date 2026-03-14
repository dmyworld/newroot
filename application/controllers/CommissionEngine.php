<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CommissionEngine Controller
 * Super-admin panel for viewing, settling, and configuring commission splits.
 */
class CommissionEngine extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        if (!$this->aauth->is_loggedin()) { redirect('user'); return; }
        // Only Super Admins (role 1) can access
        if (!$this->aauth->has_perm('super_admin') && $this->aauth->get_user()->roleid != 1) {
            show_error('Access denied.', 403);
        }
        $this->load->model('Commission_model', 'cm');
    }

    /**
     * Main dashboard – summary cards + DataTable of commission records.
     */
    public function index()
    {
        $data['summary']    = $this->cm->get_summary();
        $data['records']    = $this->cm->get_all(50);
        $data['title']      = 'Commission Engine';
        $this->load->view('superadmin/commission/index', $data);
    }

    /**
     * AJAX DataTables endpoint.
     */
    public function ajax_list()
    {
        $status = $this->input->get('status');
        $records = $this->cm->datatables_data($status);
        $total   = $this->cm->datatables_count($status);

        $out = [];
        foreach ($records as $r) {
            $s = $r['status'] ?? 'pending';
            if ($s === 'settled') {
                $status_badge = '<span class="badge badge-success">Settled</span>';
            } elseif ($s === 'waived') {
                $status_badge = '<span class="badge badge-secondary">Waived</span>';
            } else {
                $status_badge = '<span class="badge badge-warning">Pending</span>';
            }
            $actions = '';
            if ($r['status'] === 'pending') {
                $actions = '<button onclick="settleCommission(' . $r['id'] . ')" class="btn btn-xs btn-success mr-1"><i class="fa fa-check"></i> Settle</button>'
                         . '<button onclick="waiveCommission('  . $r['id'] . ')" class="btn btn-xs btn-secondary"><i class="fa fa-ban"></i> Waive</button>';
            }
            $out[] = [
                $r['id'],
                '#' . $r['invoice_no'],
                htmlspecialchars($r['seller_name'] ?? '-'),
                'Rs. ' . number_format($r['invoice_total'], 2),
                $r['rate'] . '%',
                '<strong>Rs. ' . number_format($r['commission_amt'], 2) . '</strong>',
                'Rs. ' . number_format($r['seller_payout'], 2),
                $status_badge,
                date('M j, Y', strtotime($r['created_at'])),
                $actions,
            ];
        }

        echo json_encode([
            'draw'            => (int)($this->input->post('draw') ?? 1),
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $out,
        ]);
    }

    /**
     * AJAX: Settle a single commission record.
     */
    public function settle()
    {
        $id = $this->input->post('id');
        echo json_encode(['status' => $this->cm->settle($id) ? 'Success' : 'Error']);
    }

    /**
     * AJAX: Waive a single commission record.
     */
    public function waive()
    {
        $id = $this->input->post('id');
        echo json_encode(['status' => $this->cm->waive($id) ? 'Success' : 'Error']);
    }

    /**
     * AJAX: Settle all pending commissions in bulk.
     */
    public function settle_all()
    {
        $count = $this->cm->settle_all_pending();
        echo json_encode(['status' => 'Success', 'count' => $count]);
    }

    /**
     * AJAX: Set a custom commission rate override for a specific business/user.
     */
    public function set_rate()
    {
        $user_id = $this->input->post('user_id');
        $rate    = (float)$this->input->post('rate');
        if ($rate < 0 || $rate > 100) {
            echo json_encode(['status' => 'Error', 'message' => 'Rate must be between 0 and 100.']);
            return;
        }
        $result = $this->cm->set_business_rate($user_id, $rate);
        echo json_encode(['status' => $result ? 'Success' : 'Error']);
    }
}
