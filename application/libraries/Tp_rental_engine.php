<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tp_rental_engine {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Calculate rental price for a given range
     * @param float $daily_rate
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function calculate_rental_quote($daily_rate, $start_date, $end_date) {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = $start->diff($end);
        $days = $interval->days + 1;

        $base_price = $days * $daily_rate;
        
        // Rental Psychology: Price Chunking / Discounts
        $discount = 0;
        if ($days >= 30) {
            $discount = 0.20; // 20% off for monthly
        } elseif ($days >= 7) {
            $discount = 0.10; // 10% off for weekly
        }

        $total_price = $base_price * (1 - $discount);

        return [
            'days' => $days,
            'base_price' => $base_price,
            'discount' => $base_price * $discount,
            'total_price' => $total_price,
            'daily_effective_rate' => $total_price / $days
        ];
    }

    /**
     * Calculate security deposit
     * @param float $product_value
     * @param bool $has_insurance
     * @return float
     */
    public function calculate_deposit($product_value, $has_insurance = false) {
        $base_deposit_pc = 0.30; // 30% of value
        if ($has_insurance) {
            $base_deposit_pc = 0.15; // 15% if insured (Loss Aversion)
        }
        return $product_value * $base_deposit_pc;
    }

    /**
     * Check EMI Eligibility based on history
     * @param int $customer_id
     * @return bool
     */
    public function check_emi_eligibility($customer_id) {
        // Simple logic: If customer has > 2 successful orders, they are eligible
        $this->CI->db->where('customer_id', $customer_id);
        $this->CI->db->where('status', 'paid');
        $count = $this->CI->db->count_all_results('geopos_invoices');
        return $count >= 1; 
    }
}
