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

class Myapp extends CI_Controller
{
    public function appset()
    {
        $ci =& get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT * FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        if ($query && $query->num_rows() > 0) {
            $row = $query->row_array();
            $ci->lang->load($row["lang"], $row["lang"]);
            $ci->config->set_item('ctitle', $row["cname"]);
            $ci->config->set_item('address', $row["address"]);
            $ci->config->set_item('city', $row["city"]);
            $ci->config->set_item('region', $row["region"]);
            $ci->config->set_item('country', $row["country"]);
            $ci->config->set_item('phone', $row["phone"]);
            $ci->config->set_item('email', $row["email"]);
            $ci->config->set_item('tax', $row["tax"]);
            $ci->config->set_item('taxno', $row["taxid"]);

            $ci->config->set_item('format_curr', $row["currency_format"]);
            $ci->config->set_item('prefix', $row["prefix"]);
            // $ci->config->set_item('date_f',$row["dfomat"]);
            $ci->config->set_item('tzone', $row["zone"]);
            $ci->config->set_item('logo', $row["logo"]);


            switch ($row['dformat']) {
                case 1:
                    $ci->config->set_item('date', date("d-m-Y"));
                    $ci->config->set_item('dformat', "d-m-Y");
                    $ci->config->set_item('dformat2', "dd-mm-yyyy");
                    break;
                case 2:
                    $ci->config->set_item('date', date("Y-m-d"));
                    $ci->config->set_item('dformat', "Y-m-d");
                    $ci->config->set_item('dformat2', "yyyy-mm-dd");
                    break;
                case 3:
                    $ci->config->set_item('date', date("m-d-Y"));
                    $ci->config->set_item('dformat', "m-d-Y");
                    $ci->config->set_item('dformat2', "mm-dd-yyyy");
                    break;
            }
            date_default_timezone_set($row["zone"]);
        }
    }

    public function subscription_check()
    {
        $ci =& get_instance();
        
        // Ensure Aauth is loaded. Many controllers load it, but we check here too.
        if (!isset($ci->aauth)) {
            $ci->load->library("Aauth");
        }
        
        if (isset($ci->aauth) && $ci->aauth->is_loggedin()) {
            $user_id = $ci->aauth->get_user()->id;
            
            // Check subscription status in geopos_users
            $query_sub = $ci->db->query("SELECT subscription_status FROM geopos_users WHERE id = $user_id LIMIT 1");
            $user_sub = $query_sub->row_array();
            
            $subscription_status = isset($user_sub['subscription_status']) ? $user_sub['subscription_status'] : 'active';

            $current_uri = $ci->uri->uri_string();
            $allowed_uris = array('user/logout', 'hub/pending', 'user/login');

            if ($subscription_status == 'pending' && !in_array($current_uri, $allowed_uris)) {
                // If the user is pending, only allow access to hub/ and user/logout
                if (strpos($current_uri, 'hub/') === false && strpos($current_uri, 'user/logout') === false) {
                    redirect('hub/pending');
                }
            }
        }
    }
}

?>
