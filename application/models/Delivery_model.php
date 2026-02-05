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

class Delivery_model extends CI_Model
{ //geopos_stock_transfer_items
    var $table = 'geopos_stock_transfer';
    var $column_order = array(null, 'geopos_stock_transfer.tid', 'geopos_customers.name', 'geopos_stock_transfer.invoicedate', 'geopos_stock_transfer.total', 'geopos_stock_transfer.status', null);
    var $column_search = array('geopos_stock_transfer.tid', 'geopos_customers.name', 'geopos_stock_transfer.invoicedate', 'geopos_stock_transfer.total','geopos_stock_transfer.status');
    var $order = array('geopos_stock_transfer.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastinvoice()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        //$this->db->where('i_class', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }



 



    public function invoice_details($id, $eid = '')
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('geopos_stock_transfer.tid', $id);
        if ($eid) {
           $this->db->where('geopos_stock_transfer.eid', $eid);
        }
           //   if ($this->aauth->get_user()->loc) {
         //   $this->db->where('geopos_stock_transfer.from_warehouse', $this->aauth->get_user()->loc);
       // } elseif (!BDATA) {
       //     $this->db->where('geopos_stock_transfer.from_warehouse', 1);
       // }
       // $this->db->join('geopos_customers', 'geopos_stock_transfer.csd = geopos_customers.id', 'left');
       // $this->db->join('geopos_terms', 'geopos_terms.id = geopos_stock_transfer.term', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_stock_transfer_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }

    

  

     

      






















    private function _get_datatables_query($opt = '')
    {
        $this->db->select('geopos_stock_transfer.id,geopos_stock_transfer.tid,geopos_stock_transfer.invoicedate,geopos_stock_transfer.status,geopos_stock_transfer.items,geopos_stock_transfer.refer,geopos_stock_transfer.from_warehouse,geopos_stock_transfer.to_warehouse');
        $this->db->from($this->table);
        //$this->db->where('geopos_invoices.i_class', 1);
       // if ($opt) {
       //     $this->db->where('geopos_stock_transfer.eid', $opt);
       // }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_transfer.from_warehouse', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_stock_transfer.from_warehouse', 1); }
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_stock_transfer.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_stock_transfer.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
      //  $this->db->where('geopos_invoices.i_class', 1);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_transfer.from_warehouse', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_stock_transfer.from_warehouse', 1); }

        return $query->result();
    }

    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
        //if ($opt) {
       //     $this->db->where('eid', $opt);
      //  }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_transfer.from_warehouse', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_stock_transfer.from_warehouse', 1); }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '')
    {
        $this->db->select('geopos_stock_transfer.id');
        $this->db->from($this->table);
      //  $this->db->where('geopos_invoices.i_class', 1);
      //  if ($opt) {
      //      $this->db->where('geopos_stock_transfer.eid', $opt);
//
      //  }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_stock_transfer.from_warehouse', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_stock_transfer.from_warehouse', 1); }
        return $this->db->count_all_results();
    }


    public function employee($id)
    {
        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }






















    
}
