<?php
/**
 * Service Reports Model
 * Aggregation logic for Phase 4 Analytics
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_reports_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get commission summary for a date range
     */
    public function get_commission_summary($start_date, $end_date)
    {
        // This assumes we have a table to track completed jobs/transfers.
        // For now, I will use a mock query structure based on the accounting model's logic.
        $this->db->select('DATE(date) as day, SUM(credit) as total_commission');
        $this->db->from('geopos_transactions'); 
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->group_by('day');
        return $this->db->get()->result_array();
    }

    /**
     * Get provider payout report
     */
    public function get_provider_payouts()
    {
        $this->db->select('tp_service_providers.id, geopos_users.username, tp_service_providers.total_earnings, tp_service_providers.total_jobs');
        $this->db->from('tp_service_providers');
        $this->db->join('geopos_users', 'tp_service_providers.user_id = geopos_users.id', 'left');
        $this->db->order_by('total_earnings', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Provider Rating Leaderboard
     */
    public function get_rating_leaderboard()
    {
        $this->db->select('geopos_users.username, tp_service_providers.rating_avg, tp_service_providers.total_jobs');
        $this->db->from('tp_service_providers');
        $this->db->join('geopos_users', 'tp_service_providers.user_id = geopos_users.id', 'left');
        $this->db->where('tp_service_providers.status', 1);
        $this->db->order_by('rating_avg', 'DESC');
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }

    /**
     * Revenue by Category
     */
    public function get_category_revenue()
    {
        $this->db->select('tp_service_categories.title, SUM(tp_service_providers.total_earnings) as revenue');
        $this->db->from('tp_service_providers');
        // This is simplified; ideally we join with job logs and service categories
        $this->db->join('tp_provider_skills', 'tp_service_providers.id = tp_provider_skills.provider_id', 'left');
        $this->db->join('tp_services', 'tp_provider_skills.service_id = tp_services.id', 'left');
        $this->db->join('tp_service_categories', 'tp_services.cat_id = tp_service_categories.id', 'left');
        $this->db->group_by('tp_service_categories.id');
        return $this->db->get()->result_array();
    }
}
