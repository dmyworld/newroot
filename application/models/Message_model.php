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

class Message_model extends CI_Model
{


    public function send_message($sender_id, $receiver_id, $subject, $message)
    {
        $data = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'title' => $subject,
            'content' => $message,
            'date_sent' => date('Y-m-d H:i:s'),
            'status' => 0 // Unread
        );
        return $this->db->insert('geopos_pms', $data);
    }

    public function get_messages($user_id, $type = 'inbox')
    {
        $this->db->select('p.*, u.username as other_user');
        $this->db->from('geopos_pms p');
        if ($type == 'inbox') {
            $this->db->join('geopos_users u', 'p.sender_id = u.id');
            $this->db->where('p.receiver_id', $user_id);
        } else {
            $this->db->join('geopos_users u', 'p.receiver_id = u.id');
            $this->db->where('p.sender_id', $user_id);
        }
        $this->db->order_by('p.date_sent', 'DESC');
        return $this->db->get()->result_array();
    }

    public function employee_details($id)
    {
        $this->db->select('geopos_employees.*');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_pms.id', $id);
        $this->db->join('geopos_pms', 'geopos_employees.id = geopos_pms.sender_id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }
}
