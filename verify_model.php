<?php
define('BASEPATH', '1');
define('ENVIRONMENT', 'development');
require_once 'index.php';
$CI =& get_instance();
$CI->load->model('Intelligence_model');

header('Content-Type: text/plain');

$branch_id = 0; // Test for Global

echo "--- Intelligence_model Verification ---\n";
echo "Total Cash In Hand: " . $CI->Intelligence_model->get_total_cash_in_hand($branch_id) . "\n";
echo "Total Bank Balance: " . $CI->Intelligence_model->get_total_bank_balance($branch_id) . "\n";
echo "Total Receivables: " . $CI->Intelligence_model->get_total_receivables($branch_id) . "\n";
echo "Total Payables: " . $CI->Intelligence_model->get_total_payables($branch_id) . "\n";
echo "Today Sales: " . $CI->Intelligence_model->get_today_total_sales($branch_id) . "\n";

$fin_pos = $CI->Intelligence_model->get_detailed_financial_position($branch_id);
echo "\n--- Financial Position ---\n";
echo "Assets: " . $fin_pos['assets'] . "\n";
echo "Liabilities: " . $fin_pos['liabilities'] . "\n";
echo "Equity: " . $fin_pos['equity'] . "\n";

$metrics = $CI->Intelligence_model->get_detailed_financial_metrics($branch_id, date('Y-m-01'), date('Y-m-d'));
echo "\n--- Financial Metrics (Month) ---\n";
echo "Income Total: " . $metrics['income']['Total'] . "\n";
echo "Expense Total: " . $metrics['expense']['Total'] . "\n";

echo "\n--- Account List (Quick Check) ---\n";
$CI->db->select('id, holder, lastbal, account_type');
$query = $CI->db->get('geopos_accounts');
foreach ($query->result() as $row) {
    echo "ID: {$row->id} | {$row->holder} | Type: {$row->account_type} | Bal: {$row->lastbal}\n";
}
