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

class Purchase_model extends CI_Model
{
    var $table = 'geopos_purchase';
    var $table_logs = 'geopos_purchase_logs';
    var $table_wood = 'geopos_purchase_wood';
    var $column_search_wood = array('geopos_purchase_wood.tid', 'geopos_supplier.name', 'geopos_purchase_wood.invoicedate', 'geopos_purchase_wood.total','geopos_purchase_wood.status');
    var $column_order_wood = array(null, 'geopos_purchase_wood.tid', 'geopos_supplier.name', 'geopos_purchase_wood.invoicedate', 'geopos_purchase_wood.total', 'geopos_purchase_wood.status', null);
    var $order_wood = array('geopos_purchase_wood.tid' => 'desc');
    
    var $column_order = array(null, 'geopos_purchase.tid', 'geopos_supplier.name', 'geopos_purchase.invoicedate', 'geopos_purchase.total', 'geopos_purchase.status', null);
    var $column_search = array('geopos_purchase.tid', 'geopos_supplier.name', 'geopos_purchase.invoicedate', 'geopos_purchase.total','geopos_purchase.status');
    var $order = array('geopos_purchase.tid' => 'desc');

    var $column_search_logs = array('geopos_purchase_logs.tid', 'geopos_supplier.name', 'geopos_purchase_logs.invoicedate', 'geopos_purchase_logs.total','geopos_purchase_logs.status');
    var $column_order_logs = array(null, 'geopos_purchase_logs.tid', 'geopos_supplier.name', 'geopos_purchase_logs.invoicedate', 'geopos_purchase_logs.total', 'geopos_purchase_logs.status', null);
    var $order_logs = array('geopos_purchase_logs.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
        if ($this->db->table_exists('geopos_purchase_logs')) {
            if (!$this->db->field_exists('district', 'geopos_purchase_logs')) {
                $this->dbforge->add_column('geopos_purchase_logs', [
                    'district' => ['type' => 'VARCHAR', 'constraint' => '50', 'default' => '']
                ]);
            }
            if (!$this->db->field_exists('location_gps', 'geopos_purchase_logs')) {
                $this->dbforge->add_column('geopos_purchase_logs', [
                    'location_gps' => ['type' => 'VARCHAR', 'constraint' => '100', 'default' => '']
                ]);
            }
        }
    }

    public function lastpurchase()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }

    public function lastpurchase_logs()
    {
        $this->db->select('tid');
        $this->db->from($this->table_logs);
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }

        public function lastpurchase_wood()
    {
        $this->db->select('tid');
        $this->db->from($this->table_wood);
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }
    
    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        if ($this->aauth->get_user()->roleid != 1) {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
        }
        $query = $this->db->get();
        return $query->result_array();

    }

    public function purchase_details($id)
    {

        $this->db->select('geopos_purchase.*,geopos_purchase.id AS iid,SUM(geopos_purchase.shipping + geopos_purchase.ship_tax) AS shipping,geopos_supplier.*,geopos_supplier.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('geopos_purchase.id', $id);
        if ($this->aauth->get_user()->roleid != 1) {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_purchase.loc', 0);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase.loc', 0);
            }
        }
        $this->db->join('geopos_supplier', 'geopos_purchase.csd = geopos_supplier.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_purchase.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function purchase_details_logs($id)
    {

        $this->db->select('geopos_purchase_logs.*,geopos_purchase_logs.id AS iid,SUM(geopos_purchase_logs.shipping + geopos_purchase_logs.ship_tax) AS shipping,geopos_supplier.*,geopos_supplier.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table_logs);
        $this->db->where('geopos_purchase_logs.id', $id);
        if ($this->aauth->get_user()->roleid != 1) {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase_logs.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_purchase_logs.loc', 0);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase_logs.loc', 0);
            }
        }
        $this->db->join('geopos_supplier', 'geopos_purchase_logs.csd = geopos_supplier.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_purchase_logs.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function purchase_details_wood($id)
    {

        $this->db->select('geopos_purchase_wood.*,geopos_purchase_wood.id AS iid,SUM(geopos_purchase_wood.shipping + geopos_purchase_wood.ship_tax) AS shipping,geopos_supplier.*,geopos_supplier.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table_wood);
        $this->db->where('geopos_purchase_wood.id', $id);
        if ($this->aauth->get_user()->roleid != 1) {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase_wood.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_purchase_wood.loc', 0);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase_wood.loc', 0);
            }
        }
        $this->db->join('geopos_supplier', 'geopos_purchase_wood.csd = geopos_supplier.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_purchase_wood.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }
    
    
    
     public function purchase_products_wood($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_purchase_items_wood');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function purchase_products($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_purchase_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function purchase_products_logs($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_purchase_items_logs');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function purchase_transactions($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('tid', $id);
        $this->db->where('ext', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    
    
     
              
                
    public function purchase_delete2($id)
    {
        $this->db->trans_start();
        $this->db->select('pid,qty,pquick');
        $this->db->from('geopos_purchase_items_logs');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        $prevresult = $query->result_array();
        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $amt2 = $prd['pquick'];
            
            $this->db->set('qty', "qty-$amt", FALSE);
            $this->db->set('qty2', "qty2-$amt2", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->update('geopos_products');
        }
        $whr = array('id' => $id);
        if ($this->aauth->get_user()->roleid != 1) {
            if ($this->aauth->get_user()->loc) {
                $whr = array('id' => $id, 'loc' => $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $whr = array('id' => $id, 'loc' => 0);
            }
        }
        $this->db->delete('geopos_purchase_logs', $whr);
        if ($this->db->affected_rows()) $this->db->delete('geopos_purchase_items_logs', array('tid' => $id));
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }

    public function purchase_delete($id)
    {
        $this->db->trans_start();
        $this->db->select('pid,qty');
        $this->db->from('geopos_purchase_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        $prevresult = $query->result_array();
        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $this->db->set('qty', "qty-$amt", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->update('geopos_products');
        }
        $whr = array('id' => $id);
        if ($this->aauth->get_user()->roleid != 1) {
            if ($this->aauth->get_user()->loc) {
                $whr = array('id' => $id, 'loc' => $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $whr = array('id' => $id, 'loc' => 0);
            }
        }
        $this->db->delete('geopos_purchase', $whr);
        if ($this->db->affected_rows()) $this->db->delete('geopos_purchase_items', array('tid' => $id));
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function invoice_delete($id, $eid = '')
    {

        $this->db->trans_start();

        $this->db->select('status');
        $this->db->from('geopos_invoices');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();

     
        $affect = $this->db->affected_rows();
        if ($res) {
            if ($result['status'] != 'canceled') {
                $this->db->select('pid,qty,pquick,pquick_code');
                $this->db->from('geopos_invoice_items');
                $this->db->where('tid', $id);
                $query = $this->db->get();
                $prevresult = $query->result_array();

                foreach ($prevresult as $prd) {
                    $amt = $prd['qty'];
                    $this->db->set('qty', "qty+$amt", FALSE);
                    $this->db->where('pid', $prd['pid']);
                    $this->db->update('geopos_products');

                    $amt3 = $prd['pquick'];
                    $this->db->set('qty2', "qty2+$amt3", FALSE);
                    $this->db->where('pid', $prd['pid']);
                    $this->db->update('geopos_products');
                    
                  //  $amt2 = $prd['pquick'];
                 //   $this->db->set('qty', "qty+$amt2", FALSE);
                 //   $this->db->where('pquick_code', $prd['pquick_code']);
                 //   $this->db->where('(sub_id = 0 OR sub_id IS NULL)'); // Custom condition
                 //   $this->db->update('geopos_products');
                }
            }
            if ($affect) $this->db->delete('geopos_invoice_items', array('tid' => $id));
            $data = array('type' => 9, 'rid' => $id);
            $this->db->delete('geopos_metadata', $data);
            if ($this->db->trans_complete()) {
                return true;
            } else {
                return false;
            }
        }
    }
    




    
        public function purchase_delete_wood($id)
    {
          
       
            
            $this->db->trans_start();
    // Get purchase items
            $this->db->select('pid, qty, unit, pquick');
            $this->db->from('geopos_purchase_items_wood');
            $this->db->where('tid', $id);
            $query = $this->db->get();
            $prevresult = $query->result_array();
            
//    // Get only Feet/Sqft purchase items from the database
//            $this->db->select('pid, qty, unit, pquick');
//            $this->db->from('geopos_purchase_items_wood');
//            $this->db->where('tid', $id);
//            $this->db->where_in('unit', ['Feet', 'Sqft']); // Filter at database level
//            $queryw = $this->db->get();
//            $prevresultw = $queryw->result_array();           
  
   // Get only Feet/Sqft purchase items
$this->db->select('pquick');
$this->db->from('geopos_purchase_items_wood');
$this->db->where('tid', $id);
$this->db->where_in('unit', ['Feet', 'Sqft']);
$queryw = $this->db->get();
$pquick_array = $queryw->result_array();

// Extract just the pquick values into a simple array
$pquick_values = array_column($pquick_array, 'pquick');

// If you want to use a default value when array is empty
if (empty($pquick_values)) {
    $pquick_values = [0.06]; // Default value as array
}           
    
            
            foreach ($prevresult as $prd) {
                
                
//            $pquick3 = 0.06; // Initialize with default value   
//            foreach ($prevresultw as $prdw) {
//            $pquick3 = $prdw['pquick'];
//            }
        // Update Qbic units
           // Use the pquick values array as needed
    // For example, use the first value or process all values
    //$pquick_value = $pquick_values[0]; // Using first value
    // Process each pquick value for this product
    foreach ($pquick_values as $pquick_value) {
        // Your update logic for each pquick value
       // $amt3 = $prd['pquick'];
        $this->db->set('qty', "qty - $pquick_value", FALSE);         
       // $this->db->set('qty2', "qty2 + $amt3", FALSE);
        $this->db->where('pid', $prd['pid']);
        $this->db->where('unit', 'Qbic');
        $this->db->update('geopos_products');
    }
              
                 $amt3 = $prd['pquick'];
       // $this->db->set('qty', "qty - $pquick_value", FALSE);         
       $this->db->set('qty2', "qty2 + $amt3", FALSE);
        $this->db->where('pid', $prd['pid']);
        $this->db->where('unit', 'Qbic');
        $this->db->update('geopos_products');
        
        
        // Update Feet/Sqft units if pquick_code is empty
            $amt = $prd['qty'];
                    $this->db->set('qty', "qty - $amt", FALSE);
                    $this->db->where('pid', $prd['pid']);
            $this->db->where_in('unit', ['Feet', 'Sqft']);
                    $this->db->update('geopos_products');
                
            }

        
        
        
        
        $whr = array('id' => $id);
        if ($this->aauth->get_user()->roleid != 1) {
            if ($this->aauth->get_user()->loc) {
                $whr = array('id' => $id, 'loc' => $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $whr = array('id' => $id, 'loc' => 0);
            }
        }
        $this->db->delete('geopos_purchase_wood', $whr);
        if ($this->db->affected_rows()) $this->db->delete('geopos_purchase_items_wood', array('tid' => $id));
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }

    
    private function _get_datatables_query()
    {
        $this->db->select('geopos_purchase.id,geopos_purchase.tid,geopos_purchase.invoicedate,geopos_purchase.invoiceduedate,geopos_purchase.total,geopos_purchase.status,geopos_supplier.name');
        $this->db->from($this->table);
        $this->db->join('geopos_supplier', 'geopos_purchase.csd=geopos_supplier.id', 'left');
        
        // Branch Filter Secure Logic
        $loc = $this->input->post('loc');
        if($this->aauth->get_user()->roleid == 1) {
            if ($loc !== null && $loc !== '' && $loc > 0) {
                $this->db->where('geopos_purchase.loc', $loc);
            }
        } else {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase.loc', 0);
            }
        }

        // Status Filter
        $status = $this->input->post('status');
        if($status) {
            if($status == 'due') {
                $this->db->group_start();
                $this->db->where_in('geopos_purchase.status', array('due', 'partial', 'Due', 'Partial'));
                $this->db->group_end();
            } else {
                $this->db->where('geopos_purchase.status', $status);
            }
        }
                    if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_purchase.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_purchase.invoicedate) <=', datefordatabase($this->input->post('end_date')));
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
    
    
    
    
    
    private function _get_datatables_query_wood()
    {
        $this->db->select('geopos_purchase_wood.id, geopos_purchase_wood.tid, geopos_purchase_wood.invoicedate, geopos_purchase_wood.invoiceduedate, geopos_purchase_wood.total, geopos_purchase_wood.status, geopos_supplier.name');
        $this->db->from($this->table_wood);
        $this->db->join('geopos_supplier', 'geopos_purchase_wood.csd = geopos_supplier.id', 'left');

        // Branch Filter Secure Logic
        $loc = $this->input->post('loc');
        if($this->aauth->get_user()->roleid == 1) {
            if ($loc !== null && $loc !== '' && $loc > 0) {
                $this->db->where('geopos_purchase_wood.loc', $loc);
            }
        } else {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase_wood.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase_wood.loc', 0);
            }
        }

        // Status Filter
        $status = $this->input->post('status');
        if($status) {
            if($status == 'due') {
                $this->db->group_start();
                $this->db->where_in('geopos_purchase_wood.status', array('due', 'partial', 'Due', 'Partial'));
                $this->db->group_end();
            } else {
                $this->db->where('geopos_purchase_wood.status', $status);
            }
        }
                    if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_purchase_wood.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_purchase_wood.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        $i = 0;
        foreach ($this->column_search_wood as $item) // loop column
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

                if (count($this->column_search_wood) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_wood[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_wood)) {
            $order = $this->order_wood;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_datatables_query_logs()
    {
        $this->db->select('geopos_purchase_logs.id, geopos_purchase_logs.tid, geopos_purchase_logs.invoicedate, geopos_purchase_logs.invoiceduedate, geopos_purchase_logs.total, geopos_purchase_logs.status, geopos_purchase_logs.pquick, geopos_supplier.name');
        $this->db->from($this->table_logs);
        $this->db->join('geopos_supplier', 'geopos_purchase_logs.csd = geopos_supplier.id', 'left');

        // Branch Filter Secure Logic
        $loc = $this->input->post('loc');
        if($this->aauth->get_user()->roleid == 1) {
            if ($loc !== null && $loc !== '' && $loc > 0) {
                $this->db->where('geopos_purchase_logs.loc', $loc);
            }
        } else {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase_logs.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase_logs.loc', 0);
            }
        }

        // Status Filter
        $status = $this->input->post('status');
        if($status) {
            if($status == 'due') {
                $this->db->group_start();
                $this->db->where_in('geopos_purchase_logs.status', array('due', 'partial', 'Due', 'Partial'));
                $this->db->group_end();
            } else {
                $this->db->where('geopos_purchase_logs.status', $status);
            }
        }
        
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_purchase_logs.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_purchase_logs.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        
        $i = 0;
        foreach ($this->column_search_logs as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search_logs) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_logs[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_logs)) {
            $order = $this->order_logs;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_logs()
    {
        $this->_get_datatables_query_logs();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_logs()
    {
        $this->_get_datatables_query_logs();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_logs()
    {
        $this->db->from($this->table_logs);
        
        // Branch Filter
        $loc = $this->input->post('loc');
        if($loc !== null && $loc !== '') {
            if($loc > 0) $this->db->where('geopos_purchase_logs.loc', $loc);
        } else {
            if ($this->aauth->get_user()->roleid != 1) {
                if ($this->aauth->get_user()->loc) {
                    $this->db->where('geopos_purchase_logs.loc', $this->aauth->get_user()->loc);
                } elseif (!BDATA) {
                    $this->db->where('geopos_purchase_logs.loc', 0);
                }
            }
        }
        return $this->db->count_all_results();
    }
    
private function _get_datatables_query2()
{
    $this->db->select('geopos_purchase.id, geopos_purchase.tid, geopos_purchase.invoicedate, geopos_purchase.invoiceduedate, geopos_purchase.total, geopos_purchase.status, geopos_supplier.name');
    $this->db->from($this->table);
    $this->db->join('geopos_supplier', 'geopos_purchase.csd = geopos_supplier.id', 'left');

    $user_loc = $this->aauth->get_user()->loc;

    // Apply location-based filtering if applicable
    if ($this->aauth->get_user()->roleid != 1) {
        if ($user_loc) {
            $this->db->group_start();
            $this->db->where('geopos_purchase.pquick IS NOT NULL');
            $this->db->where('geopos_purchase.pquick !=', '');
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->group_start();
            $this->db->where('geopos_purchase.pquick IS NOT NULL');
            $this->db->where('geopos_purchase.pquick !=', '');
            $this->db->group_end();
        }
    }

    // Date range filtering
    if ($this->input->post('start_date') && $this->input->post('end_date')) {
        $this->db->where('DATE(geopos_purchase.invoicedate) >=', datefordatabase($this->input->post('start_date')));
        $this->db->where('DATE(geopos_purchase.invoicedate) <=', datefordatabase($this->input->post('end_date')));
    }

    // Search functionality
    $i = 0;
    foreach ($this->column_search as $item) {
        if ($this->input->post('search')['value']) {
            if ($i === 0) {
                $this->db->group_start(); 
                $this->db->like($item, $this->input->post('search')['value']);
            } else {
                $this->db->or_like($item, $this->input->post('search')['value']);
            }

            if (count($this->column_search) - 1 == $i)
                $this->db->group_end();
        }
        $i++;
    }

    // Ordering
    if (isset($_POST['order'])) {
        $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
    }
}

function get_datatables2()
{
    $this->_get_datatables_query2();
    
    // Apply pagination
    if ($_POST['length'] != -1) {
        $this->db->limit($_POST['length'], $_POST['start']);
    }

    $query = $this->db->get();
    return $query->result();
}
    
    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }    

    
        function get_datatables_wood()
    {
        $this->_get_datatables_query_wood();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    } 
    
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    
        function count_filtered_wood()
    {
        $this->_get_datatables_query_wood();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        
        // Branch Filter Secure Logic
        $loc = $this->input->post('loc');
        if($this->aauth->get_user()->roleid == 1) {
            if ($loc !== null && $loc !== '' && $loc > 0) {
                $this->db->where('geopos_purchase.loc', $loc);
            }
        } else {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase.loc', 0);
            }
        }
        return $this->db->count_all_results();
    }

        public function count_all_wood()
    {
        $this->db->from($this->table_wood);
        
        // Branch Filter Secure Logic
        $loc = $this->input->post('loc');
        if($this->aauth->get_user()->roleid == 1) {
            if ($loc !== null && $loc !== '' && $loc > 0) {
                $this->db->where('geopos_purchase_wood.loc', $loc);
            }
        } else {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_purchase_wood.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_purchase_wood.loc', 0);
            }
        }
        return $this->db->count_all_results();
    }

    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('type', 4);
        $this->db->or_where('type', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
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

    public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('geopos_metadata', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('geopos_metadata.*');
        $this->db->from('geopos_metadata');
        $this->db->where('geopos_metadata.type', 4);
        $this->db->where('geopos_metadata.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id, $type, $name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }

}