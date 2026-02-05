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

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Printer
{
    function __construct()
    {
          $this->PI = &get_instance();
    }

    function check($id=0)
    {
        $this->PI->db->where('type', 1);
        $this->PI->db->where('val4', $id);
        $this->PI->db->order_by('id', 'DESC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
