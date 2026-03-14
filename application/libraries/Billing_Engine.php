<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_Engine
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Calculate a detailed breakdown of where the money goes.
     */
    public function get_breakdown($amount, $commission_pc)
    {
        $commission_amt = ($amount * $commission_pc) / 100;
        $net_amount = $amount - $commission_amt;

        return [
            'total' => $amount,
            'commission_percentage' => $commission_pc,
            'commission_amount' => $commission_amt,
            'net_payout' => $net_amount,
            'currency' => 'LKR' // For now
        ];
    }

    /**
     * Calculate "You Saved" amount based on list price vs. sale price.
     */
    public function calculate_savings($items)
    {
        $total_savings = 0;
        foreach ($items as $item) {
            // Placeholder: Check if item has 'list_price' or 'mrp'
            if (isset($item['list_price']) && $item['list_price'] > $item['price']) {
                $total_savings += ($item['list_price'] - $item['price']) * $item['qty'];
            }
        }
        return $total_savings;
    }

    /**
     * Generate a professional quote for a bundle.
     */
    public function generate_bundle_summary($base_total, $addons = [])
    {
        $total = $base_total;
        $summary = [
            ['label' => 'Base Items', 'amount' => $base_total]
        ];

        foreach ($addons as $addon) {
            $summary[] = ['label' => $addon['name'], 'amount' => $addon['price']];
            $total += $addon['price'];
        }

        return [
            'breakdown' => $summary,
            'grand_total' => $total
        ];
    }
}
