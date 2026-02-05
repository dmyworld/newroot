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

class Productcategory Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categories_model', 'products_cat');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->li_a = 'stock';
    }

    public function index()
    {
        $data['cat'] = $this->products_cat->category_stock();
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category', $data);
        $this->load->view('fixed/footer');
    }

    public function warehouse()
    {
        $data['cat'] = $this->products_cat->warehouse();
        $head['title'] = "Product Warehouse";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        $data['id'] = $this->input->get('id');
        $data['sub'] = $this->input->get('sub');
        $data['cat'] = $this->products_cat->category_sub_stock($data['id']);
        $data['warehouse'] = $this->products_cat->warehouse_list();
        $head['title'] = "View Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_view', $data);
        $this->load->view('fixed/footer');
    }

    public function viewwarehouse()
    {
        $data['cat'] = $this->products_cat->warehouse();
        $head['title'] = "View Product Warehouses";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse_view', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $data['cat'] = $this->products_cat->category_list();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_add', $data);
        $this->load->view('fixed/footer');
    }

    public function add_sub()
    {
        $data['cat'] = $this->products_cat->category_list();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_add_sub', $data);
        $this->load->view('fixed/footer');
    }

    public function category_products_add()
    {
        $data['cat'] = $this->products_cat->category_list();
        $data['warehouse'] = $this->products_cat->warehouse_list();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        
        // Initialize default empty values for view compatibility (view is shared/copied from edit)
        $data['product_row'] = array(
            'product_des' => 0,
            'product_code' => '',
            'rate' => 0,
            'fproduct_price' => 0,
            'fproduct_cost' => 0,
            'local_imported' => '',
            'unit' => '',
            'sub_id' => 0,
            'pcat' => 0
        );
        $data['productcat'] = array(
            'title' => '',
            'c_type' => 0,
            'rel_id' => 0
        );

        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_products_add', $data);
        $this->load->view('fixed/footer');
    }

        public function category_products_add_post()
    {
        $cid = $this->input->post('catid');
        $product_cat_name = $this->input->post('product_cat_name');
        $product_cat_desc = $this->input->post('product_cat_desc');
		$warehouseid = $this->input->post('warehouseid');
        $lengtharray = $this->input->post('lengtharray');
        $rate = $this->input->post('new_product_price');
        $extra = $this->input->post('extra');

        if($lengtharray) {
            $lengtharray = explode(',', $lengtharray);
        } else {
            $lengtharray = array();
        }
        $locationid = $this->input->post('locationid');


        if ($product_cat_name) {
            $this->products_cat->category_products_add_post_model($cid,$rate,$extra, $product_cat_name, $product_cat_desc, $locationid,$warehouseid,$lengtharray);
        }
    }

    public function addwarehouse()
    {
        if ($this->input->post()) {
            $cat_name = $this->input->post('product_catname');
            $cat_desc = $this->input->post('product_catdesc');
            $lid = $this->input->post('lid');
            if ($this->aauth->get_user()->loc) {
                if ($lid == 0 OR $this->aauth->get_user()->loc == $lid) {

                } else {
                    exit();
                }
            }

            if ($cat_name) {

                $this->products_cat->addwarehouse($cat_name, $cat_desc, $lid);
            }
        } else {
            $this->load->model('locations_model');
            $data['locations'] = $this->locations_model->locations_list2();
            $data['cat'] = $this->products_cat->category_list();
            $head['title'] = "Add Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/warehouse_add', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function addcat()
    {
        $cat_name = $this->input->post('product_catname', true);
        $cat_desc = $this->input->post('product_catdesc', true);
        $cat_type = $this->input->post('cat_type', true);
        $cat_rel = $this->input->post('cat_rel', true);
        if ($cat_name) {
            $this->products_cat->addnew($cat_name, $cat_desc, $cat_type, $cat_rel);
        }
    }


    public function delete_i()
    {
        $id = intval($this->input->post('deleteid'));
        if ($id) {

            $query = $this->db->query("DELETE geopos_movers FROM geopos_movers LEFT JOIN geopos_products ON  geopos_movers.rid1=geopos_products.pid LEFT JOIN geopos_product_cat ON  geopos_products.pcat=geopos_product_cat.id WHERE geopos_product_cat.id='$id' AND  geopos_movers.d_type='1'");

            $this->db->delete('geopos_products', array('pcat' => $id));
            $this->db->delete('geopos_product_cat', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function delete_i_sub()
    {
        $id = intval($this->input->post('deleteid'));
        if ($id) {

            $query = $this->db->query("DELETE geopos_movers FROM geopos_movers LEFT JOIN geopos_products ON  geopos_movers.rid1=geopos_products.pid LEFT JOIN geopos_product_cat ON  geopos_products.sub_id=geopos_product_cat.id WHERE geopos_product_cat.id='$id' AND  geopos_movers.d_type='1'");

            $this->db->delete('geopos_products', array('sub_id' => $id));
            $this->db->delete('geopos_product_cat', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function delete_warehouse()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_products', array('pcat' => $id));
            $this->db->delete('geopos_warehouse', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Warehouse with products')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

//view for edit
// In your controller
public function edit()
{
    if ($this->input->post()) {
        // Handle form submission
        $this->edit_category();
        return;
    }
    
    // Rest of your existing edit view code...
    $sub_id = $this->input->get('id');
    
    $this->db->select('*');
    $this->db->from('geopos_products');
    $this->db->where('pcat', $sub_id);
    $queryy_pcat = $this->db->get();
    $data['product_row_pcat'] = $queryy_pcat->row_array();
    $data['product_row_array_pcat'] = $this->products_cat->product_list_pcat($sub_id);
    
    $this->db->select('*');
    $this->db->from('geopos_products');
    $this->db->where('sub_id', $sub_id);
    $queryy = $this->db->get();
    $data['product_row'] = $queryy->row_array();
    $data['product_row_array'] = $this->products_cat->product_list($sub_id);
    
    $catid = $this->input->get('id');
    $this->db->select('*');
    $this->db->from('geopos_product_cat');
    $this->db->where('id', $catid);
    $query = $this->db->get();    
    $data['productcat'] = $query->row_array();    
    $data['cat'] = $this->products_cat->category_list();
    
    // Get all sub-categories for this main category
    $this->db->select('*');
    $this->db->from('geopos_product_cat');
    $this->db->where('rel_id', $catid);
    $sub_cats_query = $this->db->get();
    $data['sub_categories'] = $sub_cats_query->result_array();
    
    $head['title'] = "Edit Product Category";
    $head['usernm'] = $this->aauth->get_user()->username;
    
    $this->load->view('fixed/header', $head);
    $this->load->view('products/product-cat-edit', $data);
    $this->load->view('fixed/footer');
}

private function edit_category()
{
    $catid = $this->input->post('catid');
    $product_cat_name = $this->input->post('product_cat_name');
    $product_cat_desc = $this->input->post('product_cat_desc');
    $cat_type = $this->input->post('cat_type');
    $cat_rel = $this->input->post('cat_rel');
    $old_cat_type = $this->input->post('old_cat_type');
    
    // Call the model function
    $this->products_cat->edit($catid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type);
    
    // The model already outputs JSON, so we don't need to do anything here
    // Just make sure the model is called properly
}



    public function editwarehouse()
    {
        if ($this->input->post()) {
            $cid = $this->input->post('catid');
            $cat_name = $this->input->post('product_cat_name', true);
            $cat_desc = $this->input->post('product_cat_desc', true);
            $lid = $this->input->post('lid');

            if ($this->aauth->get_user()->loc) {
                if ($lid == 0 OR $this->aauth->get_user()->loc == $lid) {

                } else {
                    exit();
                }
            }


            if ($cat_name) {

                $this->products_cat->editwarehouse($cid, $cat_name, $cat_desc, $lid);
            }
        } else {
            $catid = $this->input->get('id');
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $catid);
            $query = $this->db->get();
            $data['warehouse'] = $query->row_array();
            $this->load->model('locations_model');
            $data['locations'] = $this->locations_model->locations_list2();
            $head['title'] = "Edit Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/product-warehouse-edit', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function editcat()
    {
        $cid = $this->input->post('catid');
	
		
        $product_cat_name = $this->input->post('product_cat_name');
        $product_cat_desc = $this->input->post('product_cat_desc');

		$warehouseid = $this->input->post('warehouseid');
        $locationid = $this->input->post('locationid');
		
		 
		
        $cat_type = $this->input->post('cat_type', true);
        $cat_rel = $this->input->post('cat_rel', true);
        $old_cat_type = $this->input->post('old_cat_type', true);
	
		
	
		
                                       
		
		
		
		
		
        if ($cid) {
            $this->products_cat->edit_mane($cid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type,$locationid,$warehouseid);
        }
    }


    public function report_product()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));
        $sub_date = $this->input->post('sub');
        $filter = 'pcat';
        if ($sub_date) $filter = 'sub_id';

        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }


            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.product,geopos_invoice_items.product_des,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pid  LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.$filter  $qj WHERE geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.$filter='$pid' $wr");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.product,geopos_purchase_items.product_des,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid  LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.$filter  WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.$filter='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,geopos_products.product_price AS price,geopos_products.product_name   FROM geopos_movers LEFT JOIN geopos_products ON geopos_products.pid=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND geopos_products.$filter='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }
            $this->db->select('*');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/cat_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $sub = $this->input->get('sub');
            $this->db->select('*');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/cat_statement', array('id' => $pid, 'product' => $product, 'sub' => $sub));
            $this->load->view('fixed/footer');
        }
    }

    public function warehouse_report()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));

        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }

            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pid $qj WHERE geopos_invoices.status!='canceled'  AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.warehouse='$pid' $wr");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid  LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.pcat  WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.pcat='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,geopos_products.product_price AS price,geopos_products.product_name  FROM geopos_movers LEFT JOIN geopos_products ON geopos_products.pid=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND geopos_products.warehouse='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }


            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/ware_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');


            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/ware_statement', array('id' => $pid, 'product' => $product));
            $this->load->view('fixed/footer');
        }
    }


}
