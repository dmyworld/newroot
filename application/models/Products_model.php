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

class Products_model extends CI_Model
{
    var $table = 'geopos_products';
    var $column_order = array(null, 'geopos_products.product_name', 'geopos_products.qty', 'geopos_products.product_code', 'geopos_product_cat.title', 'geopos_products.product_price', null); //set column field database for datatable orderable
    var $column_search = array('geopos_products.product_name', 'geopos_products.product_code', 'geopos_product_cat.title', 'geopos_warehouse.title'); //set column field database for datatable searchable
    var $order = array('geopos_products.pid' => 'desc'); // default order

    var $stock_transfer_table = 'geopos_stock_transfer';
    var $stock_transfer_column_order = array(null, 'geopos_stock_transfer.tid', 'geopos_stock_transfer.invoicedate', 'geopos_stock_transfer.from_warehouse', 'geopos_stock_transfer.to_warehouse', null);
    var $stock_transfer_column_search = array('geopos_stock_transfer.tid', 'geopos_stock_transfer.invoicedate', 'geopos_stock_transfer.from_warehouse','geopos_stock_transfer.to_warehouse');
    var $stock_transfer_order = array('geopos_stock_transfer.tid' => 'desc');  
    

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
     function woodcut_updatee($pid, $pcutsizeid, $cutblancelengthid, $cutblancelengthstock, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $available_product_qty, $pcutsizestock, $available_product_qty_cut, $cutblancelengthwastage,$cutblancelengthwastagestock){





      if ($cutblancelengthwastage == 'full_wastage') {
        $this->db->select('qty');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pcutsizeid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        
                    
       
    

   
       
              $data = array(
                             array(
                               'pid' => $pid ,
                               'qty' => $available_product_qty - $available_product_qty_cut
                             ),
                            
                             );

          


   

                if ($this->db->update_batch('geopos_products', $data, 'pid')){


        
                    $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pcutsizeid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED')));

                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
    
    
    
    
    
    
    
    
    
    
    
     } elseif($cutblancelengthwastage == 'blance_wastage'){
      
                         




        $this->db->select('qty');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pcutsizeid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        
                    
       
    

   
       
              $data = array(
                             array(
                               'pid' => $pid ,
                               'qty' => $available_product_qty - $available_product_qty_cut
                             ),
                             array(
                               'pid' => $pcutsizeid ,
                               'qty' => $pcutsizestock + $available_product_qty_cut,
                             ),
                             array(
                               'pid' => $cutblancelengthid ,
                               'wastage' => $cutblancelengthwastagestock + $available_product_qty_cut,
                             )
                             );

          


   

                if ($this->db->update_batch('geopos_products', $data, 'pid')){


        
                    $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pcutsizeid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED')));

                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }



                           












                   }else{

   
       $this->db->select('qty');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pcutsizeid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        
                    
       
        if($pcutsizeid == $cutblancelengthid){
                $qty_2 = (2*$available_product_qty_cut);
       
        $data = array(
                        array(
                          'pid' => $pid ,
                          'qty' => $available_product_qty - $available_product_qty_cut
                        ),
                        array(
                          'pid' => $pcutsizeid ,
                          'qty' => $pcutsizestock + $qty_2,
                        )
                    );

      }else{

   
       
              $data = array(
                             array(
                               'pid' => $pid ,
                               'qty' => $available_product_qty - $available_product_qty_cut
                             ),
                             array(
                               'pid' => $pcutsizeid ,
                               'qty' => $pcutsizestock + $available_product_qty_cut,
                             ),
                             array(
                               'pid' => $cutblancelengthid ,
                               'qty' => $cutblancelengthstock + $available_product_qty_cut,
                             )
                             );

             }


   

                if ($this->db->update_batch('geopos_products', $data, 'pid')){
        
                    $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pcutsizeid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED')));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
 

          }



        

            

     
         
        
  }
 






    
    
  public function category_listd()
    {
        
        
        
        $out = '';
       
        
        
        $qw = '';
        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND ";
        }
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND ';
        }
        $bar = '';

        
        $query = "SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (geopos_products.qty>0) LIMIT 16";
        $query = $this->db->query($query);
        
        
        return $query->result_array();
        
        
        
        
    }




    
    
    
    










    
// Add these to your Products_model class

private $stock_transfer_column_search2 = array('geopos_stock_transfer.tid', 'geopos_stock_transfer.from_warehouse', 'geopos_stock_transfer.to_warehouse', 'geopos_stock_transfer.refer');
private $stock_transfer_column_order2 = array('geopos_stock_transfer.id', 'geopos_stock_transfer.tid', 'geopos_stock_transfer.from_warehouse', 'geopos_stock_transfer.to_warehouse', 'geopos_stock_transfer.invoicedate', 'geopos_stock_transfer.items', 'geopos_stock_transfer.refer', 'geopos_stock_transfer.status');
private $stock_transfer_order2 = array('geopos_stock_transfer.id' => 'desc');

private function _manage_transfer_get_datatables_query2($opt = '')
{
    $this->db->select('geopos_stock_transfer.*');
    $this->db->from($this->stock_transfer_table);
    
    if ($opt) {
        $this->db->where('geopos_stock_transfer.eid', $opt);
    }
    
    if ($this->aauth->get_user()->loc) {
        $this->db->where('geopos_stock_transfer.loc', $this->aauth->get_user()->loc);
    } elseif(!BDATA) { 
        $this->db->where('geopos_stock_transfer.loc', 0); 
    }
    
    // Date filtering
    if ($this->input->post('start_date') && $this->input->post('end_date')) {
        $this->db->where('DATE(geopos_stock_transfer.invoicedate) >=', date('Y-m-d', strtotime($this->input->post('start_date'))));
        $this->db->where('DATE(geopos_stock_transfer.invoicedate) <=', date('Y-m-d', strtotime($this->input->post('end_date'))));
    }

    $i = 0;

    foreach ($this->stock_transfer_column_search2 as $item) {
        if ($this->input->post('search') && $this->input->post('search')['value']) {
            if ($i === 0) {
                $this->db->group_start();
                $this->db->like($item, $this->input->post('search')['value']);
            } else {
                $this->db->or_like($item, $this->input->post('search')['value']);
            }

            if (count($this->stock_transfer_column_search2) - 1 == $i) {
                $this->db->group_end();
            }
            $i++;
        }
    }

    if ($this->input->post('order') && isset($this->stock_transfer_column_order2[$this->input->post('order')[0]['column']])) {
        $this->db->order_by(
            $this->stock_transfer_column_order2[$this->input->post('order')[0]['column']], 
            $this->input->post('order')[0]['dir']
        );
    } else if (isset($this->stock_transfer_order2)) {
        foreach ($this->stock_transfer_order2 as $key => $order) {
            $this->db->order_by($key, $order);
        }
    }
}

function manage_transfer_get_datatables2($opt = '')
{
    $this->_manage_transfer_get_datatables_query2($opt);
    
    if ($this->input->post('length') && $this->input->post('length') != -1) {
        $this->db->limit($this->input->post('length'), $this->input->post('start'));
    }
    
    $query = $this->db->get();
    return $query->result();
}

function manage_transfer_count_filtered2($opt = '')
{
    $this->_manage_transfer_get_datatables_query2($opt);
    $query = $this->db->get();
    return $query->num_rows();
}

public function manage_transfer_count_all2($opt = '')
{
    $this->db->from($this->stock_transfer_table);
    
    if ($opt) {
        $this->db->where('eid', $opt);
    }
    
    if ($this->aauth->get_user()->loc) {
        $this->db->where('loc', $this->aauth->get_user()->loc);
    } elseif(!BDATA) { 
        $this->db->where('loc', 0); 
    }
    
    return $this->db->count_all_results();
}

public function get_transfer_items_count($transfer_id)
{
    // Get the tid from transfer
    $this->db->select('tid');
    $this->db->where('id', $transfer_id);
    $this->db->from('geopos_stock_transfer');
    $transfer_query = $this->db->get();
    
    if ($transfer_query->num_rows() == 0) {
        return 0;
    }
    
    $transfer = $transfer_query->row();
    $tid = $transfer->tid;
    
    // Count items using tid
    $this->db->where('tid', $tid);
    $this->db->from('geopos_stock_transfer_items');
    return $this->db->count_all_results();
}

public function manage_transfer_details2($id, $eid = '')
{
    $this->db->select('*');
    $this->db->from('geopos_stock_transfer');
    $this->db->where('id', $id);
    
    if ($eid) {
        $this->db->where('eid', $eid);
    }
    
    $query = $this->db->get();
    return $query->row_array();
}

public function manage_transfer_products2($id)
{
    // Get the tid from transfer
    $this->db->select('tid');
    $this->db->from('geopos_stock_transfer');
    $this->db->where('id', $id);
    $transfer_query = $this->db->get();
    
    if ($transfer_query->num_rows() == 0) {
        return array();
    }
    
    $transfer = $transfer_query->row_array();
    $tid = $transfer['tid'];
    
    // Get items by tid
    $this->db->select('*');
    $this->db->from('geopos_stock_transfer_items');
    $this->db->where('tid', $tid);
    $query = $this->db->get();
    return $query->result_array();
}

public function get_transfers_for_export($start_date = null, $end_date = null)
{
    $this->db->select('t.*');
    $this->db->from('geopos_stock_transfer t');
    
    if ($start_date && $end_date) {
        $this->db->where('DATE(t.invoicedate) >=', date('Y-m-d', strtotime($start_date)));
        $this->db->where('DATE(t.invoicedate) <=', date('Y-m-d', strtotime($end_date)));
    }
    
    if ($this->aauth->get_user()->loc) {
        $this->db->where('t.loc', $this->aauth->get_user()->loc);
    } elseif(!BDATA) { 
        $this->db->where('t.loc', 0); 
    }
    
    $this->db->order_by('t.id', 'desc');
    
    $query = $this->db->get();
    $transfers = $query->result_array();
    
    foreach ($transfers as &$transfer) {
        $transfer['items_count'] = $this->get_transfer_items_count($transfer['id']);
    }
    
    return $transfers;
}

// New method to get items by transfer number (tid)
public function get_transfer_items_by_tid($tid)
{
    $this->db->select('*');
    $this->db->from('geopos_stock_transfer_items');
    $this->db->where('tid', $tid);
    $query = $this->db->get();
    return $query->result_array();
}
















    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

private function _manage_transfer_get_datatables_query($opt = '')
{
    $this->db->select('geopos_stock_transfer.*');
    $this->db->from($this->stock_transfer_table);
    
    if ($opt) {
        $this->db->where('geopos_stock_transfer.eid', $opt);
    }
    
    if ($this->aauth->get_user()->loc) {
        $this->db->where('geopos_stock_transfer.loc', $this->aauth->get_user()->loc);
    } elseif(!BDATA) { 
        $this->db->where('geopos_stock_transfer.loc', 0); 
    }
    
    if ($this->input->post('start_date') && $this->input->post('end_date')) {
        $this->db->where('DATE(geopos_stock_transfer.invoicedate) >=', datefordatabase($this->input->post('start_date')));
        $this->db->where('DATE(geopos_stock_transfer.invoicedate) <=', datefordatabase($this->input->post('end_date')));
    }

    $i = 0;

    foreach ($this->stock_transfer_column_search as $item) {
        if ($this->input->post('search')['value']) {
            if ($i === 0) {
                $this->db->group_start();
                $this->db->like($item, $this->input->post('search')['value']);
            } else {
                $this->db->or_like($item, $this->input->post('search')['value']);
            }

            if (count($this->stock_transfer_column_search) - 1 == $i) {
                $this->db->group_end();
            }
            $i++;
        }
    }

    if (isset($_POST['order'])) {
        $this->db->order_by($this->stock_transfer_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->stock_transfer_order)) {
        $order = $this->stock_transfer_order;
        $this->db->order_by(key($order), $order[key($order)]);
    }
}

function manage_transfer_get_datatables($opt = '')
{
    $this->_manage_transfer_get_datatables_query($opt);
    
    if ($_POST['length'] != -1) {
        $this->db->limit($_POST['length'], $_POST['start']);
    }
    
    $query = $this->db->get();
    return $query->result();
}

function manage_transfer_count_filtered($opt = '')
{
    $this->_manage_transfer_get_datatables_query($opt);
    $query = $this->db->get();
    return $query->num_rows();
}

public function manage_transfer_count_all($opt = '')
{
    $this->db->from($this->stock_transfer_table);
    
    if ($opt) {
        $this->db->where('eid', $opt);
    }
    
    if ($this->aauth->get_user()->loc) {
        $this->db->where('loc', $this->aauth->get_user()->loc);
    } elseif(!BDATA) { 
        $this->db->where('loc', 0); 
    }
    
    return $this->db->count_all_results();
}




public function manage_transfer_details($id, $eid = '')
{
    $this->db->select('*');
    $this->db->from('geopos_stock_transfer'); // CORRECT: Use the stock transfer table
    $this->db->where('id', $id);
    
    if ($eid) {
        $this->db->where('eid', $eid);
    }
    
    if ($this->aauth->get_user()->loc) {
        $this->db->where('loc', $this->aauth->get_user()->loc);
    } elseif (!BDATA) {
        $this->db->where('loc', 0);
    }
    
    $query = $this->db->get();
    return $query->row_array();
}
    
    
    public function manage_transfer_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_stock_transfer_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
            // ==================== ALERT SYSTEM METHODS ====================

    /**
     * Get alert statistics with filters
     */
    public function get_alert_statistics($level = 'all', $type = 'all', $warehouse = 'all')
    {
        $this->db->select("
            COUNT(CASE WHEN p.qty <= 20 THEN 1 END) as critical,
            COUNT(CASE WHEN p.qty > 20 AND p.qty <= 30 THEN 1 END) as warning,
            COUNT(CASE WHEN p.qty > 30 AND p.qty <= 50 THEN 1 END) as info,
            COUNT(CASE WHEN p.qty > 50 THEN 1 END) as normal
        ");
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->where('p.qty IS NOT NULL');
        $this->db->where('p.alert IS NOT NULL');
        
        $this->apply_filters($level, $type, $warehouse);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Get filtered alerts count
     */
    public function get_filtered_alerts_count($level = 'all', $type = 'all', $warehouse = 'all')
    {
        $this->db->select('COUNT(p.pid) as total');
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->join('geopos_product_cat pc', 'pc.id = p.pcat', 'left');
        $this->db->where('p.qty IS NOT NULL');
        $this->db->where('p.alert IS NOT NULL');
        
        $this->apply_filters($level, $type, $warehouse);
        
        $query = $this->db->get();
        return $query->row()->total;
    }

    /**
     * Get paginated alerts
     */
    public function get_filtered_alerts_paginated($page = 1, $items_per_page = 100, $level = 'all', $type = 'all', $warehouse = 'all')
    {
        $offset = ($page - 1) * $items_per_page;
        
        $this->db->select("
            p.pid,
            p.product_name,
            p.product_code,
            p.qty,
            p.alert,
            p.unit,
            p.pwith,
            p.pthickness,
            p.pquick,
            p.pquick_code,
            pc.title as category_name,
            w.title as warehouse_name,
            w.id as warehouse_id,
            CASE 
                WHEN p.unit LIKE '%linear%' OR p.unit = 'LF' THEN 'linear'
                WHEN p.unit LIKE '%sqft%' OR p.unit LIKE '%square%' OR p.unit = 'SF' THEN 'sqft'
                WHEN p.unit LIKE '%cubic%' OR p.unit = 'CF' THEN 'cubic'
                ELSE 'other'
            END as unit_type,
            CASE 
                WHEN p.unit LIKE '%linear%' OR p.unit = 'LF' THEN 'Linear Feet'
                WHEN p.unit LIKE '%sqft%' OR p.unit LIKE '%square%' OR p.unit = 'SF' THEN 'Square Feet'
                WHEN p.unit LIKE '%cubic%' OR p.unit = 'CF' THEN 'Cubic Feet'
                ELSE p.unit
            END as unit_type_display
        ");
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->join('geopos_product_cat pc', 'pc.id = p.pcat', 'left');
        $this->db->where('p.qty IS NOT NULL');
        $this->db->where('p.alert IS NOT NULL');
        
        $this->apply_filters($level, $type, $warehouse);
        
        $this->db->order_by('p.qty', 'ASC');
        $this->db->limit($items_per_page, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get all alerts for export
     */
    public function get_all_alerts_for_export($level = 'all', $type = 'all', $warehouse = 'all')
    {
        $this->db->select("
            p.pid,
            p.product_name,
            p.product_code,
            p.qty,
            p.alert,
            p.unit,
            p.pwith,
            p.pthickness,
            p.pquick,
            p.pquick_code,
            pc.title as category_name,
            w.title as warehouse_name,
            w.id as warehouse_id,
            CASE 
                WHEN p.unit LIKE '%linear%' OR p.unit = 'LF' THEN 'linear'
                WHEN p.unit LIKE '%sqft%' OR p.unit LIKE '%square%' OR p.unit = 'SF' THEN 'sqft'
                WHEN p.unit LIKE '%cubic%' OR p.unit = 'CF' THEN 'cubic'
                ELSE 'other'
            END as unit_type,
            CASE 
                WHEN p.unit LIKE '%linear%' OR p.unit = 'LF' THEN 'Linear Feet'
                WHEN p.unit LIKE '%sqft%' OR p.unit LIKE '%square%' OR p.unit = 'SF' THEN 'Square Feet'
                WHEN p.unit LIKE '%cubic%' OR p.unit = 'CF' THEN 'Cubic Feet'
                ELSE p.unit
            END as unit_type_display
        ");
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->join('geopos_product_cat pc', 'pc.id = p.pcat', 'left');
        $this->db->where('p.qty IS NOT NULL');
        $this->db->where('p.alert IS NOT NULL');
        
        $this->apply_filters($level, $type, $warehouse);
        
        $this->db->order_by('p.qty', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get filtered warehouse distribution
     */
    public function get_filtered_warehouse_distribution($level = 'all', $type = 'all', $warehouse = 'all')
    {
        $this->db->select("
            w.id,
            w.title as warehouse_name,
            COUNT(CASE WHEN p.qty <= 20 THEN 1 END) as critical,
            COUNT(CASE WHEN p.qty > 20 AND p.qty <= 30 THEN 1 END) as warning,
            COUNT(CASE WHEN p.qty > 30 AND p.qty <= 50 THEN 1 END) as info,
            COUNT(p.pid) as total
        ");
        $this->db->from('geopos_warehouse w');
        $this->db->join('geopos_products p', 'p.warehouse = w.id', 'left');
        $this->db->where('p.qty IS NOT NULL');
        $this->db->where('p.alert IS NOT NULL');
        
        if ($warehouse != 'all') {
            $this->db->where('w.id', $warehouse);
        }
        
        // Apply level filter if not 'all'
        if ($level != 'all') {
            switch ($level) {
                case 'critical':
                    $this->db->where('p.qty <=', 20);
                    break;
                case 'warning':
                    $this->db->where('p.qty >', 20);
                    $this->db->where('p.qty <=', 30);
                    break;
                case 'info':
                    $this->db->where('p.qty >', 30);
                    $this->db->where('p.qty <=', 50);
                    break;
                case 'normal':
                    $this->db->where('p.qty >', 50);
                    break;
            }
        }
        
        // Apply type filter
        if ($type != 'all') {
            switch ($type) {
                case 'linear':
                    $this->db->group_start();
                    $this->db->like('p.unit', 'linear', 'both');
                    $this->db->or_where('p.unit', 'LF');
                    $this->db->group_end();
                    break;
                case 'sqft':
                    $this->db->group_start();
                    $this->db->like('p.unit', 'sqft', 'both');
                    $this->db->or_like('p.unit', 'square', 'both');
                    $this->db->or_where('p.unit', 'SF');
                    $this->db->group_end();
                    break;
                case 'cubic':
                    $this->db->group_start();
                    $this->db->like('p.unit', 'cubic', 'both');
                    $this->db->or_where('p.unit', 'CF');
                    $this->db->group_end();
                    break;
            }
        }
        
        if ($this->aauth->get_user()->loc) {
            $this->db->where('w.loc', $this->aauth->get_user()->loc);
        }
        
        $this->db->group_by('w.id, w.title');
        $this->db->order_by('w.title', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Apply filters to queries
     */
    private function apply_filters($level, $type, $warehouse)
    {
        // Apply level filter
        if ($level != 'all') {
            switch ($level) {
                case 'critical':
                    $this->db->where('p.qty <=', 20);
                    break;
                case 'warning':
                    $this->db->where('p.qty >', 20);
                    $this->db->where('p.qty <=', 30);
                    break;
                case 'info':
                    $this->db->where('p.qty >', 30);
                    $this->db->where('p.qty <=', 50);
                    break;
                case 'normal':
                    $this->db->where('p.qty >', 50);
                    break;
            }
        }
        
        // Apply type filter
        if ($type != 'all') {
            switch ($type) {
                case 'linear':
                    $this->db->group_start();
                    $this->db->like('p.unit', 'linear', 'both');
                    $this->db->or_where('p.unit', 'LF');
                    $this->db->group_end();
                    break;
                case 'sqft':
                    $this->db->group_start();
                    $this->db->like('p.unit', 'sqft', 'both');
                    $this->db->or_like('p.unit', 'square', 'both');
                    $this->db->or_where('p.unit', 'SF');
                    $this->db->group_end();
                    break;
                case 'cubic':
                    $this->db->group_start();
                    $this->db->like('p.unit', 'cubic', 'both');
                    $this->db->or_where('p.unit', 'CF');
                    $this->db->group_end();
                    break;
            }
        }
        
        // Apply warehouse filter
        if ($warehouse != 'all') {
            $this->db->where('p.warehouse', $warehouse);
        }
        
        // Apply location filter
        if ($this->aauth->get_user()->loc) {
            $this->db->where('w.loc', $this->aauth->get_user()->loc);
        }
    }

    // ==================== EXISTING METHODS (From your original file) ====================
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    private function _get_datatables_query($id = '', $w = '', $sub = '')
    {
        $this->db->select('geopos_products.*,geopos_product_cat.title AS c_title,geopos_warehouse.title');
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        
        if ($sub) {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.sub_id');
            $this->db->where('geopos_products.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("geopos_products.sub_id=$id");

            // Apply Warehouse Filter for Sub-category view
            if ($w > 0) {
                 $this->db->where("geopos_warehouse.id = $w");
            }

        } else {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat');

            if ($w > 0) {
                // Modified to support warehouse filter passed explicitly
                $this->db->where("geopos_warehouse.id = $w");
                
                if ($id > 0) {
                     // If category ID is present, filter by both
                     $this->db->where("geopos_product_cat.id = $id");
                     $this->db->where('geopos_products.sub_id', 0);
                }

                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

            } else {

                $this->db->where('geopos_products.merge', 0);
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }
                if ($id > 0) {
                    $this->db->where("geopos_product_cat.id = $id");
                    $this->db->where('geopos_products.sub_id', 0);
                }
            }
        }

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id = '', $w = '', $sub = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query($id, $w, $sub);
        } else {
            $this->_get_datatables_query('', $w, '');
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id, $w = '', $sub='')
    {
        if ($id > 0) {
            $this->_get_datatables_query($id, $w, $sub);
        } else {
            $this->_get_datatables_query('', $w, '');
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id = '', $w = '', $sub='')
    {
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        
        if ($w > 0) {
            $this->db->where('geopos_warehouse.id', $w);
        }

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        return $this->db->count_all_results();
    }

    public function addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type = '', $w_stock = '', $w_alert = '', $sub_cat = '', $b_id = '',$product_width, $product_thickness, $product_quick, $product_quick_code,$new_fproduct_cost, $is_sale = 1, $is_rent = 0, $is_installment = 0, $master_pid = 0, $special_category = '')
    {
        $ware_valid = $this->valid_warehouse($warehouse);
        if(!$sub_cat) $sub_cat=0;
        if(!$b_id) $b_id=0;
        $datetime1 = new DateTime(date('Y-m-d'));

        $datetime2 = new DateTime($wdate);

        $difference = $datetime1->diff($datetime2);
        if (!$difference->d > 0) {
            $wdate = null;
        }

        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'product_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'rate' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => $code_type,
                        'sub_id' => $sub_cat,
                        'b_id' => $b_id,
                        'pwith' => $product_width,
                       'pthickness' => $product_thickness,
                       'pquick' => $product_quick,
                        'pquick_code' => $product_quick_code,
                        'fproduct_cost' => $new_fproduct_cost,
                        'is_sale' => $is_sale,
                        'is_rent' => $is_rent,
                        'is_installment' => $is_installment,
                        'master_pid' => $master_pid,
                        'special_category' => $special_category
                    );

                } else {

                    $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);

                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'product_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'rate' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => 'EAN13',
                        'sub_id' => $sub_cat,
                        'b_id' => $b_id,
                        'pwith' => $product_width,
                       'pthickness' => $product_thickness,
                        'pquick' => $product_quick,
                       'pquick_code' => $product_quick_code,
                              'fproduct_cost' => $new_fproduct_cost,
                        'is_sale' => $is_sale,
                        'is_rent' => $is_rent,
                        'is_installment' => $is_installment,
                        'master_pid' => $master_pid,
                        'special_category' => $special_category
                    );
                }
                $this->db->trans_start();
                if ($this->db->insert('geopos_products', $data)) {
                    $pid = $this->db->insert_id();
                    $this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
                if ($v_type) {
                    foreach ($v_type as $key => $value) {
                        if ($v_type[$key] && numberClean($v_stock[$key]) > 0.00) {
                            $this->db->select('u.id,u.name,u2.name AS variation');
                            $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                            $this->db->where('u.id', $v_type[$key]);
                            $query = $this->db->get('geopos_units u');
                            $r_n = $query->row_array();
                            $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                            $data['qty'] = numberClean($v_stock[$key]);
                            $data['alert'] = numberClean($v_alert[$key]);
                            $data['merge'] = 1;
                            $data['sub'] = $pid;
                            $data['vb'] = $v_type[$key];
                            $this->db->insert('geopos_products', $data);
                            $pidv = $this->db->insert_id();
                            $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }
                if ($w_type) {
                    foreach ($w_type as $key => $value) {
                        if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                            $data['product_name'] = $product_name;
                            $data['warehouse'] = $w_type[$key];
                            $data['qty'] = numberClean($w_stock[$key]);
                            $data['alert'] = numberClean($w_alert[$key]);
                            $data['merge'] = 2;
                            $data['sub'] = $pid;
                            $data['vb'] = $w_type[$key];
                            $this->db->insert('geopos_products', $data);
                            $pidv = $this->db->insert_id();
                            $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }
                $this->db->trans_complete();
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'rate' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => $code_type,
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
                    'pwith' => $product_width,
                   'pthickness' => $product_thickness,
                 'pquick' => $product_quick,
                    'pquick_code' => $product_quick_code,
                      'fproduct_cost' => $new_fproduct_cost,
                    'is_sale' => $is_sale,
                    'is_rent' => $is_rent,
                    'is_installment' => $is_installment,
                    'master_pid' => $master_pid,
                    'special_category' => $special_category
                );
            } else {
                $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'rate' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => 'EAN13',
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
                    'pwith' => $product_width,
                    'pthickness' => $product_thickness,
                    'pquick' => $product_quick,
                    'pquick_code' => $product_quick_code,
                      'fproduct_cost' => $new_fproduct_cost,
                    'is_sale' => $is_sale,
                    'is_rent' => $is_rent,
                    'is_installment' => $is_installment,
                    'master_pid' => $master_pid,
                    'special_category' => $special_category
                );
            }
            $this->db->trans_start();
            if ($this->db->insert('geopos_products', $data)) {
                $pid = $this->db->insert_id();
                $this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
            if ($v_type) {
                foreach ($v_type as $key => $value) {
                    if ($v_type[$key] && numberClean($v_stock[$key]) > 0.00) {
                        $this->db->select('u.id,u.name,u2.name AS variation');
                        $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                        $this->db->where('u.id', $v_type[$key]);

                        $query = $this->db->get('geopos_units u');
                        $r_n = $query->row_array();
                        $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                        $data['qty'] = numberClean($v_stock[$key]);
                        $data['alert'] = numberClean($v_alert[$key]);
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        $this->db->insert('geopos_products', $data);
                        $pidv = $this->db->insert_id();
                        $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
            if ($w_type) {
                foreach ($w_type as $key => $value) {
                    if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {

                        $data['product_name'] = $product_name;
                        $data['warehouse'] = $w_type[$key];
                        $data['qty'] = numberClean($w_stock[$key]);
                        $data['alert'] = numberClean($w_alert[$key]);
                        $data['merge'] = 2;
                        $data['sub'] = $pid;
                        $data['vb'] = $w_type[$key];
                        $this->db->insert('geopos_products', $data);
                        $pidv = $this->db->insert_id();
                        $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
            $this->custom->save_fields_data($pid, 4);
            $this->db->trans_complete();

        }
    }

    public function edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty2, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat = '', $b_id = '',$product_width,   $product_thickness,   $product_quick,   $product_quick_code, $new_fproduct_cost, $local_imported = '', $is_sale = 1, $is_rent = 0, $is_installment = 0)
    {
        $this->db->select('qty,qty2');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        $ware_valid = $this->valid_warehouse($warehouse);


 
      
             



        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                $data = array(
                    //'pcat' => $catid,
                    //'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'rate' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'qty2' => $product_qty2,
                    //'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    //'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'code_type' => $code_type,
                   // 'sub_id' => $sub_cat,
                    //'b_id' => $b_id,
                    //'pwith' => $product_width,
                       // 'pwith' => $product_thicknes,
                      'pquick' => $product_quick,
                        'pquick_code' => $product_quick_code,
                      'fproduct_cost' => $new_fproduct_cost,
                      'local_imported' => $local_imported,
                    'is_sale' => $is_sale,
                    'is_rent' => $is_rent,
                    'is_installment' => $is_installment
                );

$this->db->where('pid', $pid);
if ($this->db->update('geopos_products', $data)) {
    
    $movements = array();
    
    // Track quantity changes
    if ($r_n['qty'] != $product_qty) {
        $m_product_qty = $product_qty - $r_n['qty'];
        $this->movers(1, $pid, $m_product_qty, 0, 'Stock Adjustment');
        $movements[] = "Qty: " . $m_product_qty;
    }
    
    if ($r_n['qty2'] != $product_qty2) {
        $m_product_qty2 = $product_qty2 - $r_n['qty2'];
        $this->movers(1, $pid, $m_product_qty2, 0, 'Stock Adjustment');
        $movements[] = "Qty2: " . $m_product_qty2;
    }
                    
                    
                    $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED') . " <a href='" . base_url('products/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            $data = array(
                //'pcat' => $catid,
                //'warehouse' => $warehouse,
                'product_name' => $product_name,
                'product_code' => $product_code,
                'product_price' => $product_price,
                'rate' => $product_price,
                'fproduct_price' => $factoryprice,
                'taxrate' => $taxrate,
                'disrate' => $disrate,
                'qty' => $product_qty,
                'qty2' => $product_qty2,
                //'product_des' => $product_desc,
                'alert' => $product_qty_alert,
                //'unit' => $unit,
                'image' => $image,
                'barcode' => $barcode,
                'code_type' => $code_type,
                //'sub_id' => $sub_cat,
                //'b_id' => $b_id,
                //'pwith' => $product_width,
                      //  'pthickness' => $product_thicknes,
                        'pquick' => $product_quick,
                        'pquick_code' => $product_quick_code,
                'fproduct_cost' => $new_fproduct_cost,






                'local_imported' => $local_imported,
                'is_sale' => $is_sale,
                'is_rent' => $is_rent,
                'is_installment' => $is_installment
            );

$this->db->where('pid', $pid);
if ($this->db->update('geopos_products', $data)) {
    
    $movements = array();
    
    // Track quantity changes
    if ($r_n['qty'] != $product_qty) {
        $m_product_qty = $product_qty - $r_n['qty'];
        $this->movers(1, $pid, $m_product_qty, 0, 'Stock Adjustment');
        $movements[] = "Qty: " . $m_product_qty;
    }
    
    if ($r_n['qty2'] != $product_qty2) {
        $m_product_qty2 = $product_qty2 - $r_n['qty2'];
        $this->movers(1, $pid, $m_product_qty2, 0, 'Stock Adjustment');
        $movements[] = "Qty2: " . $m_product_qty2;
    }
                
                
                $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED') . " <a href='" . base_url('products/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        }
        $this->custom->edit_save_fields_data($pid, 4);

    }

    public function prd_stats()
    {

        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
            if (BDATA) $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0 OR geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
        } elseif (!BDATA) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0';
        }
        $query = $this->db->query("SELECT
COUNT(IF( geopos_products.qty > 0, geopos_products.qty, NULL)) AS instock,
COUNT(IF( geopos_products.qty <= 0, geopos_products.qty, NULL)) AS outofstock,
COUNT(geopos_products.qty) AS total
FROM geopos_products $whr");
        echo json_encode($query->result_array());
    }

    public function products_list($id, $term = '')
    {
        $this->db->select('geopos_products.*');
        $this->db->from('geopos_products');
        $this->db->where('geopos_products.warehouse', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', 0);
        }
        if ($term) {
            $this->db->where("geopos_products.product_name LIKE '%$term%'");
            $this->db->or_where("geopos_products.product_code LIKE '$term%'");
        }
        $query = $this->db->get();
        return $query->result_array();

    }


    public function units()
    {
        $this->db->select('*');
        $this->db->from('geopos_units');
        $this->db->where('type', 0);
        $query = $this->db->get();
        return $query->result_array();

    }


//public function transfer($from_warehouse, $products_l, $to_warehouse, $qty, $invocieno, $invoicedate, $from_warehouse_name, $to_warehouse_name)
//{
//    // Start transaction
//    $this->db->trans_begin();
//    
//    try {
//        // Log input for debugging
//        $this->aauth->applog("[Transfer Start] Inv: $invocieno | From: $from_warehouse_name | To: $to_warehouse_name", 
//                            $this->aauth->get_user()->username);
//        
//        // Handle input formats
//        if (is_string($products_l) && strpos($products_l, ',') !== false) {
//            $products_l = explode(',', $products_l);
//        } elseif (!is_array($products_l)) {
//            $products_l = array($products_l);
//        }
//        
//        if (is_string($qty) && strpos($qty, ',') !== false) {
//            $qtyArray = explode(',', $qty);
//        } elseif (is_array($qty)) {
//            // If associative array [product_id => qty]
//            if (array_keys($qty) !== range(0, count($qty) - 1)) {
//                $newProducts = array();
//                $newQty = array();
//                foreach ($qty as $pid => $q) {
//                    $newProducts[] = $pid;
//                    $newQty[] = $q;
//                }
//                $products_l = $newProducts;
//                $qtyArray = $newQty;
//            } else {
//                $qtyArray = $qty;
//            }
//        } else {
//            $qtyArray = array($qty);
//        }
//        
//        // Validate arrays
//        if (count($products_l) != count($qtyArray)) {
//            throw new Exception('Products and quantities count mismatch');
//        }
//        
//        $updateArray = array();
//        $move = false;
//        $total_items = 0;
//        
//        // Process each product
//        foreach ($products_l as $index => $product_id) {
//            $transfer_qty = floatval($qtyArray[$index]);
//            
//            if ($transfer_qty <= 0) {
//                continue;
//            }
//            
//            // Get product details
//            $this->db->select('*');
//            $this->db->from('geopos_products');
//            $this->db->where('pid', $product_id);
//            $query = $this->db->get();
//            
//            if ($query->num_rows() == 0) {
//                throw new Exception("Product ID $product_id not found");
//            }
//            
//            $pr = $query->row_array();
//            $current_qty = $pr['qty'];
//            
//            // Check stock availability
//            if ($current_qty - $transfer_qty < 0) {
//                throw new Exception("Insufficient stock for: " . $pr['product_name'] . 
//                                  " (Available: $current_qty, Transfer: $transfer_qty)");
//            }
//            
//            // Insert transfer item (using your actual table structure)
//            $transfer_item_data = array(
//                'tid' => $invocieno,
//                'pid' => $product_id,
//                'qty' => $transfer_qty,
//                'product_name' => $pr['product_name'],
//                'product_code' => $pr['product_code']
//            );
//            
//            $this->db->insert('geopos_stock_transfer_items', $transfer_item_data);
//            $total_items++;
//            
//            // Case 1: Full transfer (all stock moved)
//            if ($current_qty - $transfer_qty == 0) {
//                $this->handleFullTransfer($product_id, $pr, $transfer_qty, $to_warehouse, $to_warehouse_name, $updateArray, $move);
//            } 
//            // Case 2: Partial transfer
//            else {
//                $this->handlePartialTransfer($product_id, $pr, $transfer_qty, $to_warehouse, $to_warehouse_name);
//            }
//            
//            // Reduce source stock
//            $this->db->set('qty', 'qty - ' . $transfer_qty, FALSE);
//            $this->db->where('pid', $product_id);
//            $this->db->update('geopos_products');
//            
//            // Log movement
//            $this->movers(1, $product_id, -$transfer_qty, 0, "Transferred to $to_warehouse_name");
//        }
//        
//        // Update moved products
//        if ($move && !empty($updateArray)) {
//            $this->db->update_batch('geopos_products', $updateArray, 'pid');
//        }
//        
//        // Insert main transfer record (using your actual table structure)
//        $transfer_data = array(
//            'tid' => $invocieno,
//            'invoicedate' => $invoicedate,
//            'from_warehouse' => $from_warehouse_name,
//            'to_warehouse' => $to_warehouse_name,
//            'items' => $total_items,
//            'refer' => $this->aauth->get_user()->username,
//            'status' => 'completed',
//            'eid' => $this->aauth->get_user()->id
//        );
//        
//        $this->db->insert('geopos_stock_transfer', $transfer_data);
//        
//        // Check transaction
//        if ($this->db->trans_status() === FALSE) {
//            throw new Exception('Transaction failed');
//        }
//        
//        // Commit transaction
//        $this->db->trans_commit();
//        
//        // Log success
//        $this->aauth->applog("[Transfer Success] #$invocieno Items: $total_items", 
//                            $this->aauth->get_user()->username);
//        
//        return array(
//            'status' => 'Success',
//            'message' => 'Transfer completed successfully',
//            'transfer_id' => $invocieno,
//            'items' => $total_items
//        );
//        
//    } catch (Exception $e) {
//        // Rollback on error
//        $this->db->trans_rollback();
//        
//        $this->aauth->applog("[Transfer Error] " . $e->getMessage(), 
//                            $this->aauth->get_user()->username);
//        
//        return array(
//            'status' => 'Error',
//            'message' => $e->getMessage()
//        );
//    }
//}
//
//private function handleFullTransfer($product_id, $product, $qty, $to_warehouse, $to_warehouse_name, &$updateArray, &$move)
//{
//    $product_name = $product['product_name'];
//    
//    // Check for merge logic
//    if ($product['merge'] == 2) {
//        $target_product = $this->findProductInWarehouse($product['sub'], $to_warehouse);
//    } else {
//        $target_product = $this->findMergedProductInWarehouse($product_id, $to_warehouse);
//    }
//    
//    if ($target_product) {
//        // Update existing product
//        $this->db->set('qty', 'qty + ' . $qty, FALSE);
//        $this->db->where('pid', $target_product['pid']);
//        $this->db->update('geopos_products');
//        
//        // Delete source product
//        $this->db->delete('geopos_products', array('pid' => $product_id));
//        $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $product_id));
//        
//        $this->movers(1, $target_product['pid'], $qty, 0, "Received from transfer");
//        $this->aauth->applog("[Full Transfer] Merged $product_name into existing product", 
//                            $this->aauth->get_user()->username);
//    } else {
//        // Move product to new warehouse
//        $updateArray[] = array(
//            'pid' => $product_id,
//            'warehouse' => $to_warehouse
//        );
//        $move = true;
//        
//        $this->movers(1, $product_id, $qty, 0, "Moved to $to_warehouse_name");
//        $this->aauth->applog("[Full Transfer] Moved $product_name to $to_warehouse_name", 
//                            $this->aauth->get_user()->username);
//    }
//}
//
//private function handlePartialTransfer($product_id, $product, $qty, $to_warehouse, $to_warehouse_name)
//{
//    $product_name = $product['product_name'];
//    
//    // Check merge logic
//    if ($product['merge'] == 2) {
//        $target_product = $this->findProductInWarehouse($product['sub'], $to_warehouse);
//    } else {
//        $target_product = $this->findMergedProductInWarehouse($product_id, $to_warehouse);
//    }
//    
//    if ($target_product) {
//        // Update existing product
//        $this->db->set('qty', 'qty + ' . $qty, FALSE);
//        $this->db->where('pid', $target_product['pid']);
//        $this->db->update('geopos_products');
//        
//        $this->movers(1, $target_product['pid'], $qty, 0, "Received partial transfer");
//        $this->aauth->applog("[Partial Transfer] Added to existing product: $product_name", 
//                            $this->aauth->get_user()->username);
//    } else {
//        // Create new product entry
//        $new_product = array(
//            'product_name' => $product['product_name'],
//            'pcat' => $product['pcat'],
//            'warehouse' => $to_warehouse,
//            'product_code' => $product['product_code'],
//            'product_price' => $product['product_price'],
//            'fproduct_price' => $product['fproduct_price'],
//            'taxrate' => $product['taxrate'],
//            'disrate' => $product['disrate'],
//            'qty' => $qty,
//            'product_des' => $product['product_des'],
//            'alert' => $product['alert'],
//            'unit' => $product['unit'],
//            'image' => $product['image'],
//            'barcode' => $product['barcode'],
//            'merge' => 2,
//            'sub' => $product_id,
//            'vb' => $to_warehouse,
//            'sub_id' => $product['sub_id'],
//            'pwith' => $product['pwith'],
//            'pthickness' => $product['pthickness'],
//            'pquick' => $product['pquick'],
//            'pquick_code' => $product['pquick_code']
//        );
//        
//        $this->db->insert('geopos_products', $new_product);
//        $new_pid = $this->db->insert_id();
//        
//        $this->movers(1, $new_pid, $qty, 0, "Created from transfer");
//        $this->aauth->applog("[Partial Transfer] Created new product: $product_name", 
//                            $this->aauth->get_user()->username);
//    }
//}
//
//private function findProductInWarehouse($product_id, $warehouse_id)
//{
//    $this->db->where('pid', $product_id);
//    $this->db->where('warehouse', $warehouse_id);
//    $query = $this->db->get('geopos_products');
//    return $query->row_array();
//}
//
//private function findMergedProductInWarehouse($source_product_id, $warehouse_id)
//{
//    $this->db->where('merge', 2);
//    $this->db->where('sub', $source_product_id);
//    $this->db->where('warehouse', $warehouse_id);
//    $query = $this->db->get('geopos_products');
//    return $query->row_array();
//}
//
//// Your existing movers method
//public function movers($type = 0, $rid1 = 0, $rid2 = 0, $rid3 = 0, $note = '')
//{
//    $data = array(
//        'd_type' => $type,
//        'rid1' => $rid1,
//        'rid2' => $rid2,
//        'rid3' => $rid3,
//        'note' => $note
//    );
//    $this->db->insert('geopos_movers', $data);
//}
//
//
//    
//    
//    
//        public function lasttransfer()
//    {
//        
//        
//        $order = array('geopos_stock_transfer.tid' => 'desc');
//        $this->db->select('tid');
//        $this->db->from('geopos_stock_transfer');
//        $this->db->order_by('id', 'DESC');
//        $this->db->limit(1);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->tid;
//        } else {
//            return 1000;
//        }
//    }
//    
//    
//    
public function transfer($from_warehouse, $products_l, $to_warehouse, $qty, $invocieno, $invoicedate, $from_warehouse_name, $to_warehouse_name)
{
    // Start transaction
    $this->db->trans_begin();
    
    try {
        // Log input for debugging
        $this->aauth->applog("[Transfer Start] Inv: $invocieno | From: $from_warehouse_name | To: $to_warehouse_name", 
                            $this->aauth->get_user()->username);
        
        // Parse input parameters
        if (is_string($products_l)) {
            $products_l = array_filter(explode(',', $products_l));
        } elseif (!is_array($products_l)) {
            $products_l = array($products_l);
        }
        
        if (is_string($qty)) {
            $qtyArray = array_filter(explode(',', $qty));
        } elseif (is_array($qty)) {
            // Handle associative array [product_id => qty]
            if (array_keys($qty) !== range(0, count($qty) - 1)) {
                $newProducts = array();
                $newQty = array();
                foreach ($qty as $pid => $q) {
                    $newProducts[] = $pid;
                    $newQty[] = $q;
                }
                $products_l = $newProducts;
                $qtyArray = $newQty;
            } else {
                $qtyArray = $qty;
            }
        } else {
            $qtyArray = array($qty);
        }
        
        // Validate arrays
        if (count($products_l) != count($qtyArray)) {
            throw new Exception('Products and quantities count mismatch');
        }
        
        $total_items = 0;
        
        // Process each product
        foreach ($products_l as $index => $product_id) {
            $transfer_qty = floatval($qtyArray[$index]);
            
            if ($transfer_qty <= 0) {
                continue;
            }
            
            // 1. Check if product exists in source warehouse
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('pid', $product_id);
            $this->db->where('warehouse', $from_warehouse);
            $query = $this->db->get();
            
            if ($query->num_rows() == 0) {
                throw new Exception("Product ID $product_id not found in source warehouse ($from_warehouse_name)");
            }
            
            $source_product = $query->row_array();
            
            // 2. Check stock availability
            if ($source_product['qty'] < $transfer_qty) {
                throw new Exception("Insufficient stock for: " . $source_product['product_name'] . 
                                  " (Available: " . $source_product['qty'] . ", Transfer: $transfer_qty)");
            }
            
            // 3. Insert transfer item record
            $transfer_item_data = array(
                'tid' => $invocieno,
                'pid' => $product_id,
                'product' => $source_product['product_name'],
                'code' => $source_product['product_code'],
                'qty' => $transfer_qty,
                'price' => $source_product['product_price']-$source_product['product_des'],
                'product_des' => $source_product['product_des'],
                'unit' => $source_product['unit'],
                'pwith' => $source_product['pwith'],
                'pthickness' => $source_product['pthickness'],
                'pquick' => $source_product['pquick'],
                'pquick_code' => $source_product['pquick_code']
            );
            
            $this->db->insert('geopos_stock_transfer_items', $transfer_item_data);
            $total_items++;
            
            // 4. Check if product exists in target warehouse
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('warehouse', $to_warehouse);
            $this->db->where('product_code', $source_product['product_code']);
            // Add additional matching criteria if needed
            $this->db->where('product_name', $source_product['product_name']);
            $target_query = $this->db->get();
            
            // 5. Update or create product in target warehouse
            if ($target_query->num_rows() > 0) {
                // Product exists in target warehouse - update quantity
                $target_product = $target_query->row_array();
                
                // Increase quantity in target warehouse
                $this->db->set('qty', 'qty + ' . $transfer_qty, FALSE);
                $this->db->where('pid', $target_product['pid']);
                $this->db->update('geopos_products');
                
                // Log movement for target
                $this->movers(1, $target_product['pid'], $transfer_qty, 0, 
                            "Transfer received from $from_warehouse_name - Invoice: $invocieno");
                
                $this->aauth->applog("[Transfer] Updated existing product in target: " . 
                                    $source_product['product_name'], $this->aauth->get_user()->username);
            } else {
                // Product doesn't exist in target warehouse - create copy with new PID
                $new_product_data = array(
                    'product_name' => $source_product['product_name'],
                    'product_code' => $source_product['product_code'],
                    'product_price' => $source_product['product_price'],
                    'rate' => isset($source_product['rate']) ? $source_product['rate'] : 0,
                    'fproduct_price' => $source_product['fproduct_price'],
                    'taxrate' => $source_product['taxrate'],
                    'disrate' => $source_product['disrate'],
                    'qty' => $transfer_qty,
                    'qty2' => isset($source_product['qty2']) ? $source_product['qty2'] : 0,
                    'product_des' => $source_product['product_des'],
                    'alert' => $source_product['alert'],
                    'unit' => $source_product['unit'],
                    'image' => $source_product['image'],
                    'barcode' => $source_product['barcode'],
                    'code_type' => isset($source_product['code_type']) ? $source_product['code_type'] : 'EAN13',
                    'warehouse' => $to_warehouse,
                    'pcat' => $source_product['pcat'],
                    'sub_id' => isset($source_product['sub_id']) ? $source_product['sub_id'] : 0,
                    'b_id' => isset($source_product['b_id']) ? $source_product['b_id'] : 0,
                    'wastage' => isset($source_product['wastage']) ? $source_product['wastage'] : 0,
                    'pwith' => $source_product['pwith'],
                    'pthickness' => $source_product['pthickness'],
                    'pquick' => $source_product['pquick'],
                    'pquick_code' => $source_product['pquick_code'],
                    'fproduct_cost' => $source_product['fproduct_cost'],
                    'local_imported' => isset($source_product['local_imported']) ? $source_product['local_imported'] : null,
                    'expiry' => isset($source_product['expiry']) ? $source_product['expiry'] : null,
                    // Track relationship if needed
                    'merge' => 2,
                    'sub' => $product_id,
                    'vb' => $to_warehouse,
                    'is_sale' => $source_product['is_sale'],
                    'is_rent' => $source_product['is_rent'],
                    'is_installment' => $source_product['is_installment'],
                    'master_pid' => $source_product['master_pid']
                );
                
                $this->db->insert('geopos_products', $new_product_data);
                $new_pid = $this->db->insert_id();
                
                // Log movement for new product
                $this->movers(1, $new_pid, $transfer_qty, 0, 
                            "Transfer created from $from_warehouse_name - Invoice: $invocieno");
                
                $this->aauth->applog("[Transfer] Created new product in target: " . 
                                    $source_product['product_name'], $this->aauth->get_user()->username);
            }
            
            // 6. Reduce quantity in source warehouse
            $this->db->set('qty', 'qty - ' . $transfer_qty, FALSE);
            $this->db->where('pid', $product_id);
            $this->db->update('geopos_products');
            
            // 7. Log movement for source
            $this->movers(1, $product_id, -$transfer_qty, 0, 
                        "Transfer to $to_warehouse_name - Invoice: $invocieno");
        }
        
        // 8. Insert main transfer record
        $transfer_data = array(
            'tid' => $invocieno,
            'invoicedate' => $invoicedate,
            'from_warehouse' => $from_warehouse_name,
            'to_warehouse' => $to_warehouse_name,
            'items' => $total_items,
            'refer' => $this->aauth->get_user()->username,
            'status' => 'completed',
            'eid' => $this->aauth->get_user()->id
        );
        
        $this->db->insert('geopos_stock_transfer', $transfer_data);
        
        // Check transaction
        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Transaction failed');
        }
        
        // Commit transaction
        $this->db->trans_commit();
        
        // Log success
        $this->aauth->applog("[Transfer Success] #$invocieno Items: $total_items", 
                            $this->aauth->get_user()->username);
        
        return array(
            'status' => 'Success',
            'message' => 'Transfer completed successfully',
            'transfer_id' => $invocieno,
            'items' => $total_items
        );
        
    } catch (Exception $e) {
        // Rollback on error
        $this->db->trans_rollback();
        
        $this->aauth->applog("[Transfer Error] " . $e->getMessage(), 
                            $this->aauth->get_user()->username);
        
        return array(
            'status' => 'Error',
            'message' => $e->getMessage()
        );
    }
}

private function handleFullTransfer($product_id, $product, $qty, $to_warehouse, $to_warehouse_name, &$updateArray, &$move)
{
    $product_name = $product['product_name'];
    
    // Check for merge logic
    if ($product['merge'] == 2) {
        $target_product = $this->findProductInWarehouse($product['sub'], $to_warehouse);
    } else {
        $target_product = $this->findMergedProductInWarehouse($product_id, $to_warehouse);
    }
    
    if ($target_product) {
        // Update existing product
        $this->db->set('qty', 'qty + ' . $qty, FALSE);
        $this->db->where('pid', $target_product['pid']);
        $this->db->update('geopos_products');
        
        // Delete source product
        $this->db->delete('geopos_products', array('pid' => $product_id));
        $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $product_id));
        
        $this->movers(1, $target_product['pid'], $qty, 0, "Received from transfer");
        $this->aauth->applog("[Full Transfer] Merged $product_name into existing product", 
                            $this->aauth->get_user()->username);
    } else {
        // Move product to new warehouse
        $updateArray[] = array(
            'pid' => $product_id,
            'warehouse' => $to_warehouse
        );
        $move = true;
        
        $this->movers(1, $product_id, $qty, 0, "Moved to $to_warehouse_name");
        $this->aauth->applog("[Full Transfer] Moved $product_name to $to_warehouse_name", 
                            $this->aauth->get_user()->username);
    }
}

private function handlePartialTransfer($product_id, $product, $qty, $to_warehouse, $to_warehouse_name)
{
    $product_name = $product['product_name'];
    
    // Check merge logic
    if ($product['merge'] == 2) {
        $target_product = $this->findProductInWarehouse($product['sub'], $to_warehouse);
    } else {
        $target_product = $this->findMergedProductInWarehouse($product_id, $to_warehouse);
    }
    
    if ($target_product) {
        // Update existing product
        $this->db->set('qty', 'qty + ' . $qty, FALSE);
        $this->db->where('pid', $target_product['pid']);
        $this->db->update('geopos_products');
        
        $this->movers(1, $target_product['pid'], $qty, 0, "Received partial transfer");
        $this->aauth->applog("[Partial Transfer] Added to existing product: $product_name", 
                            $this->aauth->get_user()->username);
    } else {
        // Create new product entry
        $new_product = array(
            'product_name' => $product['product_name'],
            'pcat' => $product['pcat'],
            'warehouse' => $to_warehouse,
            'product_code' => $product['product_code'],
            'product_price' => $product['product_price'],
            'fproduct_price' => $product['fproduct_price'],
            'taxrate' => $product['taxrate'],
            'disrate' => $product['disrate'],
            'qty' => $qty,
            'product_des' => $product['product_des'],
            'alert' => $product['alert'],
            'unit' => $product['unit'],
            'image' => $product['image'],
            'barcode' => $product['barcode'],
            'merge' => 2,
            'sub' => $product_id,
            'vb' => $to_warehouse,
            'sub_id' => $product['sub_id'],
            'pwith' => $product['pwith'],
            'pthickness' => $product['pthickness'],
            'pquick' => $product['pquick'],
            'pquick_code' => $product['pquick_code'],
            'fproduct_cost' => $product['fproduct_cost'],
            'is_sale' => $product['is_sale'],
            'is_rent' => $product['is_rent'],
            'is_installment' => $product['is_installment'],
            'master_pid' => $product['master_pid']
        );
        
        $this->db->insert('geopos_products', $new_product);
        $new_pid = $this->db->insert_id();
        
        $this->movers(1, $new_pid, $qty, 0, "Created from transfer");
        $this->aauth->applog("[Partial Transfer] Created new product: $product_name", 
                            $this->aauth->get_user()->username);
    }
}

private function findProductInWarehouse($product_id, $warehouse_id)
{
    $this->db->where('pid', $product_id);
    $this->db->where('warehouse', $warehouse_id);
    $query = $this->db->get('geopos_products');
    return $query->row_array();
}

private function findMergedProductInWarehouse($source_product_id, $warehouse_id)
{
    $this->db->where('merge', 2);
    $this->db->where('sub', $source_product_id);
    $this->db->where('warehouse', $warehouse_id);
    $query = $this->db->get('geopos_products');
    return $query->row_array();
}

// Your existing movers method
public function movers($type = 0, $rid1 = 0, $rid2 = 0, $rid3 = 0, $note = '')
{
    $data = array(
        'd_type' => $type,
        'rid1' => $rid1,
        'rid2' => $rid2,
        'rid3' => $rid3,
        'note' => $note
    );
    $this->db->insert('geopos_movers', $data);
}


    
    
    
        public function lasttransfer()
    {
        
        
        $order = array('geopos_stock_transfer.tid' => 'desc');
        $this->db->select('tid');
        $this->db->from('geopos_stock_transfer');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    
    }
    
    

    public function meta_delete($name)
    {
        if (@unlink(FCPATH . 'userfiles/product/' . $name)) {
            return true;
        }
    }

    public function valid_warehouse($warehouse)
    {
        $this->db->select('id,title,loc');
        $this->db->from('geopos_warehouse');
        $this->db->where('id', $warehouse);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_master_products()
    {
        $this->db->select('p.*, w.title as warehouse_name');
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'p.warehouse = w.id', 'left');
        $this->db->where('w.loc', 0); // Master location
        $query = $this->db->get();
        return $query->result_array();
    }

    public function clone_to_warehouse($pid, $target_warehouse, $qty = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $product = $query->row_array();

        if ($product) {
            unset($product['pid']);
            $product['warehouse'] = $target_warehouse;
            $product['qty'] = $qty;
            $product['master_pid'] = $pid;
            return $this->db->insert('geopos_products', $product);
        }
        return false;
    }


}
