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

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('products_model', 'products');
        $this->load->model('categories_model');
        $this->load->library("Custom");
        $this->li_a = 'stock';

    }
    
    
    
    
    
    
    
    
    
    
    
     public function woodcut()
    {
        if (!$this->aauth->premission(2, 'view')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $data['warehouse'] = $this->categories_model->warehouse_list();
          //$data['cat1'] = $this->products_model->category_list1();
      $data['resultd'] = $this->products->category_listd();
       $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        
       
        $cutblancelength = $this->input->get('cutblancelength');
        $this->db->select('*');
        $this->db->from('geopos_products');
       // $this->db->where('pid', 13);
        $this->db->where('product_des',$length);
        $query = $this->db->get();
        $data['cutblancelengthinfo'] = $query->row_array();
       
      // $query = "SELECT geopos_products.* FROM geopos_products $join WHERE (geopos_products.pcat='$cid') AND (geopos_products.product_des<" . $length . " ) LIMIT 16";
         
        
     
      


          
        $pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $data['product'] = $query->row_array();
        
         


       
                 
       
      
        $head['title'] = "WoodCut Ssystem";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/wood-cut', $data);
        $this->load->view('fixed/footer');

    }




    public function woodcut_update()

     {
        if (!$this->aauth->premission(2, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

     $pid = $this->input->post('pid');
        $pcutsizeid = $this->input->post('pcutsizeid', true);
        $cutblancelengthid = $this->input->post('cutblancelengthid', true);

        $cutblancelengthwastage = $this->input->post('wastage');
        $cutblancelengthwastagestock = $this->input->post('wastagestock');

        $cutblancelengthstock = $this->input->post('cutblancelengthstock');
        $product_code = $this->input->post('product_code');
        $product_price = $this->input->post('product_price');
        $factoryprice = $this->input->post('fproduct_price');
        $taxrate = $this->input->post('product_tax');
        $disrate = $this->input->post('product_disc');
        $product_qty = $this->input->post('product_qty');
        $product_qty_alert = $this->input->post('product_qty_alert');
        $product_desc = $this->input->post('product_desc', true);
        $image = $this->input->post('image');
        $unit = $this->input->post('unit');
        $barcode = $this->input->post('barcode');
        $code_type = $this->input->post('code_type');
        $available_product_qty_cut = $this->input->post('available_product_qty_cut');
        
    $available_product_qty = $this->input->post('available_product_qty');
    $pcutsizestock = $this->input->post('pcutsizestock');

        if ($pid) {
            $this->products->woodcut_updatee($pid, $pcutsizeid, $cutblancelengthid, $cutblancelengthstock, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $available_product_qty, $pcutsizestock, $available_product_qty_cut, $cutblancelengthwastage,$cutblancelengthwastagestock);
        }



    

    }




      public function cutblancelengthinfo()
    {
       
       

        $out = '';
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $cutblancelength = $this->input->post('cutblancelength', true);
        $pcutsizeid = $this->input->post('pcutsizeid', true);
        $pcutsizename = $this->input->post('pcutsizename', true);
         $length = $this->input->post('length', true);

        

        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $productid);
        $query = $this->db->get();
        $data['product22'] = $query->row_array();
        
        
        $qw = '';
        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND ";
        }
        if ($cid > 0) {
            $qw .= "(geopos_products.sub_id='$cid') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND ';
        }
        $bar = '';

        
        $query = "SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . "  (geopos_products.product_des='$cutblancelength') LIMIT 1";
       // , geopos_products.product_des>$length
        $query = $this->db->query($query);
        $result = $query->result_array();
       
       
                
   
        
        foreach ($result as $row) {

           $out .= '






                      <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name">Blance Size</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Name"
                               class="form-control margin-bottom  required" name="product_name"
                               value="' .$row['product_name']. '" disabled>

                               
                    </div>
                </div>
                
                
                


                     <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"></label>

                    <div class="col-sm-6">
                        <div class="input-group">

                            
                            
                            <span class="input-group-addon">
                               <b>Wastage Options</b>
                            </span>
                            <div class="form-control h-auto p-2 custom-radio-group">
                                <label class="radio-inline mr-2">
                                    <input type="radio" name="wastage" value="no_wastage" checked>
                                    <span class="checkmark"></span> No Wastage
                                </label>
                                
                                <label class="radio-inline mr-2">
                                    <input type="radio" name="wastage" value="blance_wastage">
                                    <span class="checkmark"></span> Balance Wastage
                                </label>
                                
                                <label class="radio-inline">
                                    <input type="radio" name="wastage" value="full_wastage">
                                    <span class="checkmark"></span> Full Wastage
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


               






















           <input type="hidden" id="cutblancelengthid" name="cutblancelengthid" value="' .$row['pid']. '"> <input type="hidden" id="cutblancelengthstock" name="cutblancelengthstock" value="' .$row['qty']. '"><input type="hidden" id="cutblancelength" name="cutblancelength" value="' .$row['product_des']. '"><input type="hidden" id="cutblancelengthname" name="cutblancelengthname" value="' .$row['product_name']. '"><input type="hidden" id="wastagestock" name="wastagestock" value="' .$row['wastage']. '">';

        //  echo  $name = array($row['product_name'],$row['fproduct_price'],$row['pid'],$row['taxrate'],$row['disrate'],$row['product_des'] , $row_num);
            
           
           
            
        }
               
        echo $out;

    }














    

    public function woodcut_size()
    {
        if (!$this->aauth->premission(2, 'view')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $productid = $this->input->post('productid', true);
        $length = $this->input->post('length', true);

        // Permissions and Loc check
        $qw = '';
        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND ";
        }
        if ($cid > 0) {
            $qw .= "(geopos_products.sub_id='$cid') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND ';
        }

        // Fetch matching products
        $query_str = "SELECT geopos_products.* FROM geopos_products $join WHERE  " . $qw . " (geopos_products.sub_id='$cid') AND (geopos_products.product_des<" . $length . " ) ";
        $query = $this->db->query($query_str);
        
        $data['result'] = $query->result_array();
        $data['productid'] = $productid;

        // Load the new table view
        $this->load->view('products/wood_cut_table', $data);
    }


















    public function index()
    {
        $head['title'] = "Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/products');
        $this->load->view('fixed/footer');
    }

    public function cat()
    {
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/cat_productlist');
        $this->load->view('fixed/footer');

    }


    public function add()
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $data['cat'] = $this->categories_model->category_list();
        $data['units'] = $this->products->units();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $data['custom_fields'] = $this->custom->add_fields(4);
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $head['title'] = "Add Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-add', $data);
        $this->load->view('fixed/footer');
    }


    public function product_list()
    {
        $catid = $this->input->get('id');
        $sub = $this->input->get('sub');
        $wid = $this->input->post('wid');

        if ($catid > 0) {
            $list = $this->products->get_datatables($catid, $wid, $sub);
        } else {
            $list = $this->products->get_datatables('', $wid, '',);
        }
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->pid;
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object"><span class="avatar-lg align-baseline"><img src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span>&nbsp;' . $prd->product_name . '</a>';
            $row[] = +$prd->qty;
            $row[] = +$prd->qty2;
            $row[] = $prd->product_code;
            $row[] = $prd->c_title;
            $row[] = $prd->title;
            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a>
<div class="btn-group">
                                    <button type="button" class="btn btn-indigo dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i>  ' . $this->lang->line('Print') . '</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a><div class="dropdown-divider"></div> <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a> <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $pid . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a><div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $pid . '" target="_blank"> Label - Compact</a></div></div><a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $pid . '" target="_blank"> <span class="fa fa-pie-chart"></span> ' . $this->lang->line('Sales') . '</a><div class="btn-group">
                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                                    <div class="dropdown-menu">
&nbsp;<a href="' . base_url() . 'products/edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                                    </div>
                                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->products->count_all($catid, $wid, $sub),
            "recordsFiltered" => $this->products->count_filtered($catid, $wid, $sub),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addproduct()
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $product_name = $this->input->post('product_name', true);
        $catid = $this->input->post('product_cat');
        $warehouse = $this->input->post('product_warehouse');
        $product_code = $this->input->post('product_code');
        $product_price = numberClean($this->input->post('product_price'));
        $factoryprice = numberClean($this->input->post('fproduct_price'));
        $taxrate = numberClean($this->input->post('product_tax', true));
        $disrate = numberClean($this->input->post('product_disc', true));
        $product_qty = numberClean($this->input->post('product_qty', true));
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $product_desc = $this->input->post('product_desc', true);
         $product_width = $this->input->post('product_width', true);
         $product_thickness = $this->input->post('product_thickness', true);
         
         $product_quick_code = $this->input->post('product_quick_code', true);
         $new_fproduct_cost = $this->input->post('new_fproduct_cost', true);
         
        $image = $this->input->post('image');
        $unit = $this->input->post('unit', true);
        $barcode = $this->input->post('barcode');
        $v_type = $this->input->post('v_type');
        $v_stock = $this->input->post('v_stock');
        $v_alert = $this->input->post('v_alert');
        $w_type = $this->input->post('w_type');
        $w_stock = $this->input->post('w_stock');
        $w_alert = $this->input->post('w_alert');
        $wdate = datefordatabase($this->input->post('wdate'));
        $code_type = $this->input->post('code_type');
        $sub_cat = $this->input->post('sub_cat');
        $brand = $this->input->post('brand');


              // Convert inches to feet
            $widthfeet = $product_width / 12;
            $heightfeet = $product_thickness / 12;

            // Calculate cubic feet
            $product_quick = $product_desc * $widthfeet * $heightfeet;

         //$product_quick = 12*12*12;

        if ($catid) {
            $this->products->addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type, $w_stock, $w_alert, $sub_cat, $brand,$product_width,$product_thickness,$product_quick,$product_quick_code,$new_fproduct_cost);
        }
    }

    public function delete_i()
    {
        if (!$this->aauth->premission(2, 'delete')) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
            exit;
        }
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_products', array('pid' => $id));
            $this->db->delete('geopos_products', array('sub' => $id, 'merge' => 1));
            $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $id));
            $this->db->set('merge', 0);
            $this->db->where('sub', $id);
            $this->db->update('geopos_products');
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function edit()
    {
        if (!$this->aauth->premission(2, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $data['product'] = $query->row_array();
        $data['units'] = $this->products->units();
        $data['cat_ware'] = $this->categories_model->cat_ware($pid);
        $data['cat_sub'] = $this->categories_model->sub_cat($data['product']['pcat']);
        $data['cat_sub_list'] = $this->categories_model->sub_cat_list($data['product']['pcat']);
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $data['cat'] = $this->categories_model->category_list();
        $data['custom_fields'] = $this->custom->view_edit_fields($pid, 4);
        $head['title'] = "Edit Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editproduct()
    {
        if (!$this->aauth->premission(2, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $pid = $this->input->post('pid');
        $product_name = $this->input->post('product_name', true);
        $catid = $this->input->post('product_cat');
        $warehouse = $this->input->post('product_warehouse');
        $product_code = $this->input->post('product_code');
        $product_price = numberClean($this->input->post('product_price'));
        $factoryprice = numberClean($this->input->post('fproduct_price'));
        $taxrate = numberClean($this->input->post('product_tax'));
        $disrate = numberClean($this->input->post('product_disc'));
        $product_qty = numberClean($this->input->post('product_qty'));
        $product_qty2 = numberClean($this->input->post('product_qty2'));
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $product_desc = $this->input->post('product_desc', true);
         $product_width = $this->input->post('product_width', true);
         $product_thickness = $this->input->post('product_thickness', true);
         //$product_quick = $this->input->post('product_quick', true);
         $product_quick_code = $this->input->post('product_quick_code', true);
         $new_fproduct_cost = $this->input->post('new_fproduct_cost', true);
        $image = $this->input->post('image');
        $unit = $this->input->post('unit');
        $barcode = $this->input->post('barcode');
        $code_type = $this->input->post('code_type');
        $sub_cat = $this->input->post('sub_cat');
        if (!$sub_cat) $sub_cat = 0;
        $brand = $this->input->post('brand');
        $local_imported = $this->input->post('local_imported');
        
        
              // Convert inches to feet
            $widthfeet = $product_width / 12;
            $heightfeet = $product_thickness / 12;

            // Calculate cubic feet
            $product_quick = $product_desc * $widthfeet * $heightfeet;

         //$product_quick = 12*12*12;
        
        if ($pid) {
            $this->products->edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty2, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat, $brand,$product_width,$product_thickness,$product_quick,$product_quick_code,$new_fproduct_cost, $local_imported);
        }
    }
    public function warehouseproduct_list()
    {
        $catid = $this->input->get('id');
        $list = $this->products->get_datatables($catid, true);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->pid;
            $row[] = $prd->product_name;
            $row[] = +$prd->qty;
            $row[] = $prd->product_code;
            $row[] = $prd->c_title;
            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->products->count_all($catid, true),
            "recordsFiltered" => $this->products->count_filtered($catid, true),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function prd_stats()
    {
        $this->products->prd_stats();
    }

//    public function warehouseproduct_list()
//    {
//        $catid = $this->input->get('id');
//        $list = $this->products->get_datatables($catid, true);
//        $data = array();
//        $no = $this->input->post('start');
//        foreach ($list as $prd) {
//            $no++;
//            $row = array();
//            $row[] = $no;
//            $pid = $prd->pid;
//            $row[] = $prd->product_name;
//            $row[] = +$prd->qty;
//            $row[] = $prd->product_code;
//            $row[] = $prd->c_title;
//            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);
//            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span> ' . $this->lang->line('Delete') . '</a>';
//            $data[] = $row;
//        }
//        $output = array(
//            "draw" => $this->input->post('draw'),
//            "recordsTotal" => $this->products->count_all($catid, true),
//            "recordsFiltered" => $this->products->count_filtered($catid, true),
//            "data" => $data,
//        );
//        echo json_encode($output);
//    }
//
//    public function prd_stats()
//    {
//        $this->products->prd_stats();
//    }

//    public function stock_transfer_products()
//    {
//        $wid = $this->input->get('wid');
//        $customer = $this->input->post('product');
//        $terms = @$customer['term'];
//        $result = $this->products->products_list($wid, $terms);
//        echo json_encode($result);
//    }
    
    public function stock_transfer_products()
{
    // Get parameters
    $search = $this->input->post('search') ?: $this->input->post('product')['term'];
    $warehouse_id = $this->input->post('warehouse_id') ?: $this->input->get('wid');
    
    // Debug logging
    error_log("Search term: " . $search);
    error_log("Warehouse ID: " . $warehouse_id);
    
    if (!$warehouse_id || $warehouse_id == '0') {
        echo json_encode([]);
        return;
    }
    
    // Build query - only products from the selected warehouse
    $this->db->select('pid, product_name, product_code, qty, warehouse');
    $this->db->from('geopos_products');
    $this->db->where('warehouse', $warehouse_id);
    $this->db->where('qty >', 0); // Only show products with stock
    
    if (!empty($search)) {
        $search_clean = $this->db->escape_like_str($search);
        $this->db->group_start();
        $this->db->like('product_name', $search_clean);
        $this->db->or_like('product_code', $search_clean);
        $this->db->or_like('pid', $search_clean);
        $this->db->group_end();
    }
    
    $this->db->order_by('product_name', 'ASC');
    $this->db->limit(50); // Limit results for performance
    
    $query = $this->db->get();
    $results = $query->result_array();
    
    // Debug logging
    error_log("Found " . count($results) . " products");
    
    // Return JSON
    header('Content-Type: application/json');
    echo json_encode($results);
}

    public function sub_cat()
    {
        $wid = $this->input->get('id');
        $result = $this->categories_model->category_list(1, $wid);
        echo json_encode($result);
    }

    public function get_sub_categories_by_cat()
    {
        $wid = $this->input->post('id');
        $result = $this->categories_model->category_list(1, $wid);
        echo '<option value="0">' . $this->lang->line('All') . '</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
        }
    }

    public function stock_transfer()
    {
        if (!$this->aauth->premission(2, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post()) {
            
            
            
            
            
            
          
            
        
 // In your controller method (likely stock_transfer or similar)
$invocieno = $this->input->post('invocieno');
$invoicedate = $this->input->post('invoicedate');
$products_l = $this->input->post('products_l');
$from_warehouse = $this->input->post('from_warehouse');
$to_warehouse = $this->input->post('to_warehouse');
$qty = $this->input->post('products_qty');

// Get warehouse names
$this->db->select('title');
$this->db->from('geopos_warehouse');
$this->db->where('id', $from_warehouse);
$query = $this->db->get();
$row = $query->row_array();
$from_warehouse_name = $row['title'];

$this->db->select('title');
$this->db->from('geopos_warehouse');
$this->db->where('id', $to_warehouse);
$query = $this->db->get();
$row = $query->row_array();
$to_warehouse_name = $row['title'];

// Debug: Check what data is coming
error_log("Products_l: " . print_r($products_l, true));
error_log("Qty: " . print_r($qty, true));

// Call the model
$result = $this->products->transfer(
    $from_warehouse, 
    $products_l, 
    $to_warehouse, 
    $qty, 
    $invocieno, 
    $invoicedate, 
    $from_warehouse_name, 
    $to_warehouse_name
);

// Send proper JSON response
header('Content-Type: application/json');
echo json_encode($result);
exit;       
            
            
            
            
            
        } else {
            
            
            
            
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
              //$data['lastinvoice'] = $this->invocies->lastinvoice();
              $data['lasttransfer'] = $this->products->lasttransfer();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/stock_transfer', $data);
            $this->load->view('fixed/footer');
        }
    }
    
    
     //transfer list
 
     public function manage_transfer()
    {
        $head['title'] = "Manage Transfer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/manage_transfer');
        $this->load->view('fixed/footer');
    }
   

    
   
    
    
    
    
    
  
    
    
    
    
    
    
    
    
    
    
 // ... [Your existing methods remain here] ...
    
    public function manage_alert()
    {
        $this->load->model('products_model', 'products');
        
        // Get warehouses for filter
        $data['warehouses'] = $this->categories_model->warehouse_list();
        
        $head['title'] = "Advanced Alert Management";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/manage_alert', $data);
        $this->load->view('fixed/footer');
    }
    
    public function get_alerts_paginated()
    {
        $page = $this->input->post('page', true) ?: 1;
        $items_per_page = 100; // Fixed 100 items per page
        $level = $this->input->post('level', true) ?: 'all';
        $type = $this->input->post('type', true) ?: 'all';
        $warehouse = $this->input->post('warehouse', true) ?: 'all';
        
        $this->load->model('products_model', 'products');
        
        // Get total count
        $total_items = $this->products->get_filtered_alerts_count($level, $type, $warehouse);
        
        // Get paginated alerts
        $alerts = $this->products->get_filtered_alerts_paginated(
            $page, 
            $items_per_page, 
            $level, 
            $type, 
            $warehouse
        );
        
        echo json_encode(array(
            'alerts' => $alerts,
            'total_items' => $total_items,
            'current_page' => $page,
            'items_per_page' => $items_per_page,
            'total_pages' => ceil($total_items / $items_per_page)
        ));
    }
    
    public function get_alert_statistics_ajax()
    {
        $level = $this->input->post('level', true) ?: 'all';
        $type = $this->input->post('type', true) ?: 'all';
        $warehouse = $this->input->post('warehouse', true) ?: 'all';
        
        $this->load->model('products_model', 'products');
        $stats = $this->products->get_filtered_alert_statistics($level, $type, $warehouse);
        
        echo json_encode($stats);
    }
    
    public function get_warehouse_distribution_ajax()
    {
        $level = $this->input->post('level', true) ?: 'all';
        $type = $this->input->post('type', true) ?: 'all';
        $warehouse = $this->input->post('warehouse', true) ?: 'all';
        
        $this->load->model('products_model', 'products');
        
        $stats = $this->products->get_filtered_alert_statistics($level, $type, $warehouse);
        $warehouses = $this->products->get_filtered_warehouse_distribution($level, $type, $warehouse);
        
        echo json_encode(array(
            'stats' => $stats,
            'warehouses' => $warehouses
        ));
    }
    
    public function get_product_alert_details()
    {
        $product_id = $this->input->post('product_id');
        
        $this->db->select('p.*, w.title as warehouse_name, pc.title as category_name');
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->join('geopos_product_cat pc', 'pc.id = p.pcat', 'left');
        $this->db->where('p.pid', $product_id);
        $product = $this->db->get()->row_array();
        
        if ($product) {
            $current_qty = $product['qty'];
            $alert_level = 'normal';
            $alert_class = 'success';
            
            if ($current_qty <= 10) {
                $alert_level = 'Critical';
                $alert_class = 'danger';
            } elseif ($current_qty <= 20) {
                $alert_level = 'Warning';
                $alert_class = 'warning';
            } elseif ($current_qty <= 30) {
                $alert_level = 'Info';
                $alert_class = 'info';
            }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <h6>Product Information</h6>
                    <table class="table table-sm">
                        <tr>
                            <th>Product Name:</th>
                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Product Code:</th>
                            <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Warehouse:</th>
                            <td><?php echo htmlspecialchars($product['warehouse_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Unit:</th>
                            <td><?php echo htmlspecialchars($product['unit']); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Stock Information</h6>
                    <table class="table table-sm">
                        <tr>
                            <th>Current Stock:</th>
                            <td>
                                <span class="font-weight-bold text-<?php echo $alert_class; ?>">
                                    <?php echo number_format($current_qty, 2); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Alert Threshold:</th>
                            <td><?php echo $product['alert']; ?></td>
                        </tr>
                        <tr>
                            <th>Alert Level:</th>
                            <td>
                                <span class="badge badge-<?php echo $alert_class; ?>">
                                    <?php echo $alert_level; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Width:</th>
                            <td><?php echo $product['pwith'] ? $product['pwith'] . ' inches' : 'N/A'; ?></td>
                        </tr>
                        <tr>
                            <th>Thickness:</th>
                            <td><?php echo $product['pthickness'] ? $product['pthickness'] . ' inches' : 'N/A'; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <h6>Quick Calculations</h6>
                    <table class="table table-sm">
                        <tr>
                            <th>Quick Code:</th>
                            <td><?php echo $product['pquick_code'] ?: 'N/A'; ?></td>
                        </tr>
                        <tr>
                            <th>Quick Calculation:</th>
                            <td><?php echo $product['pquick'] ? number_format($product['pquick'], 2) : 'N/A'; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php
        }
    }
    
    public function update_alert_level()
    {
        $product_id = $this->input->post('product_id');
        $new_alert_level = $this->input->post('new_alert_level');
        $reason = $this->input->post('alert_reason');
        
        $this->db->where('pid', $product_id);
        $this->db->update('geopos_products', array('alert' => $new_alert_level));
        
        // Log the change
        $this->aauth->applog("[Alert Level Updated] Product ID: $product_id, New Level: $new_alert_level, Reason: $reason", 
                            $this->aauth->get_user()->username);
        
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Alert level updated successfully!'
        ));
    }
    
    public function export_alerts()
    {
        $level = $this->input->get('level') ?: 'all';
        $type = $this->input->get('type') ?: 'all';
        $warehouse = $this->input->get('warehouse') ?: 'all';
        
        $this->load->model('products_model', 'products');
        $alerts = $this->products->get_all_alerts_for_export($level, $type, $warehouse);
        
        // Create CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=alerts_' . date('Y-m-d_H-i-s') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fwrite($output, "\xEF\xBB\xBF");
        
        // Headers
        fputcsv($output, array(
            'Product Name', 'Product Code', 'Current Stock', 'Alert Threshold', 
            'Alert Level', 'Unit Type', 'Warehouse', 'Status', 'Width', 'Thickness',
            'Quick Code', 'Quick Calculation', 'Category'
        ));
        
        foreach ($alerts as $alert) {
            $current_qty = $alert['qty'];
            $alert_level = 'Normal';
            
            if ($current_qty <= 20) $alert_level = 'Critical';
            elseif ($current_qty <= 30) $alert_level = 'Warning';
            elseif ($current_qty <= 50) $alert_level = 'Info';
            
            fputcsv($output, array(
                $alert['product_name'],
                $alert['product_code'],
                $current_qty,
                $alert['alert'],
                $alert_level,
                $alert['unit_type_display'],
                $alert['warehouse_name'],
                $current_qty <= $alert['alert'] ? 'Below Threshold' : 'Above Threshold',
                $alert['pwith'] ?: 'N/A',
                $alert['pthickness'] ?: 'N/A',
                $alert['pquick_code'] ?: 'N/A',
                $alert['pquick'] ?: 'N/A',
                $alert['category_name'] ?: 'N/A'
            ));
        }
        
        fclose($output);
        exit;
    }
    
    public function send_alert_notifications()
    {
        // Get critical alerts
        $critical_alerts = $this->products->filter_alerts('critical', 'all', 'all');
        
        if (!empty($critical_alerts)) {
            // Here you can implement email/SMS notification logic
            // For now, we'll just log it
            
            $this->aauth->applog("[Alert Notifications Sent] " . count($critical_alerts) . " critical alerts", 
                                $this->aauth->get_user()->username);
            
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Alert notifications sent successfully! ' . count($critical_alerts) . ' critical alerts processed.'
            ));
        } else {
            echo json_encode(array(
                'status' => 'info',
                'message' => 'No critical alerts to notify.'
            ));
        }
    }
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


    
public function manage_transfer2()
{
    $head['title'] = "Manage Stock Transfers";
    $head['usernm'] = $this->aauth->get_user()->username;
    $this->load->view('fixed/header', $head);
    $this->load->view('products/manage_transfer_1');
    $this->load->view('fixed/footer');
}

public function manage_transfer_ajax_list2()
{
    $this->load->model('Products_model');
    
    $start = $this->input->post('start', true) ?: 0;
    $length = $this->input->post('length', true) ?: 10;
    $draw = $this->input->post('draw', true) ?: 1;
    
    $recordsTotal = $this->Products_model->manage_transfer_count_all2($this->limited);
    $recordsFiltered = $this->Products_model->manage_transfer_count_filtered2($this->limited);
    
    $list = $this->Products_model->manage_transfer_get_datatables2($this->limited);
    $data = array();
    
    foreach ($list as $transfer) {
        $items_count = $this->Products_model->get_transfer_items_count($transfer->id);
        
        $row = array();
        $row['id'] = (int)$transfer->id;
        $row['tid'] = (int)$transfer->tid;
        $row['from_warehouse'] = $transfer->from_warehouse;
        $row['to_warehouse'] = $transfer->to_warehouse;
        $row['invoicedate'] = $transfer->invoicedate;
        $row['items_count'] = (int)$items_count;
        $row['items'] = $transfer->items;
        $row['refer'] = $transfer->refer;
        $row['status'] = $transfer->status ? $transfer->status : 'Pending';
        
        $data[] = $row;
    } 

    $output = array(
        "draw" => (int)$draw,
        "recordsTotal" => (int)$recordsTotal,
        "recordsFiltered" => (int)$recordsFiltered,
        "data" => $data,
    );

    echo json_encode($output);
}

public function get_transfer_items($id)
{
    // Clear any previous output
    ob_clean();
    header('Content-Type: application/json');
    
    $this->load->model('Products_model');
    
    $transfer = $this->Products_model->manage_transfer_details2($id);
    
    if (!$transfer) {
        echo json_encode([
            'success' => false, 
            'message' => 'Transfer not found',
            'items' => []
        ]);
        return;
    }
    
    // Get items using the transfer number (tid)
    $items = $this->Products_model->manage_transfer_products2($id);
    
    // Debug log
    error_log('Transfer ID: ' . $id . ', Transfer TID: ' . $transfer['tid'] . ', Items found: ' . count($items));
    
    echo json_encode([
        'success' => true,
        'transfer' => $transfer,
        'items' => $items ?: []
    ]);
}

public function export_transfers_with_items()
{
    // Get parameters
    $start_date = $this->input->post('start_date') ?: date('Y-m-d', strtotime('-30 days'));
    $end_date = $this->input->post('end_date') ?: date('Y-m-d');
    
    // Build query
    $this->db->select("
        t.id as 'Transfer_ID',
        t.tid as 'Transfer_No',
        t.from_warehouse as 'From_Warehouse',
        t.to_warehouse as 'To_Warehouse',
        DATE(t.invoicedate) as 'Date',
        (SELECT COUNT(*) FROM geopos_stock_transfer_items WHERE tid = t.tid) as 'Items_Count',
        t.items as 'Total_Qty',
        t.refer as 'Created_By',
        COALESCE(t.status, 'Pending') as 'Status',
        i.product as 'Product_Name',
        i.code as 'Product_Code',
        i.qty as 'Quantity',
        i.product_des as 'Description',
        i.unit as 'Unit',
        i.pwith as 'Width',
        i.pthickness as 'Thickness',
        i.pquick as 'Quick_Calc',
        i.pquick_code as 'Quick_Code'
    ");
    
    $this->db->from('geopos_stock_transfer t');
    $this->db->join('geopos_stock_transfer_items i', 't.tid = i.tid', 'left');
    
    // Apply date filter
    if ($start_date && $end_date) {
        $this->db->where('DATE(t.invoicedate) >=', $start_date);
        $this->db->where('DATE(t.invoicedate) <=', $end_date);
    }
    
    // Apply location filter
    if ($this->aauth->get_user()->loc) {
        $this->db->where('t.loc', $this->aauth->get_user()->loc);
    } elseif(!BDATA) { 
        $this->db->where('t.loc', 0); 
    }
    
    $this->db->order_by('t.id', 'desc');
    $this->db->order_by('i.id', 'asc');
    
    $query = $this->db->get();
    
    if ($query->num_rows() == 0) {
        die('No data found for the selected date range.');
    }
    
    // Generate CSV
    $filename = 'stock_transfers_with_items_' . date('Y-m-d_H-i-s') . '.csv';
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Add BOM for UTF-8
    fwrite($output, "\xEF\xBB\xBF");
    
    // Get column names
    $fields = $query->list_fields();
    fputcsv($output, $fields);
    
    // Add data rows
    foreach ($query->result_array() as $row) {
        // Convert all values to strings and handle NULLs
        foreach ($row as $key => $value) {
            if ($value === null) {
                $row[$key] = '';
            }
        }
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}

public function export_single_transfer()
{
    $transfer_id = $this->input->post('transfer_id');
    
    $this->load->model('Products_model');
    $transfer = $this->Products_model->manage_transfer_details2($transfer_id);
    
    if (!$transfer) {
        die('Transfer not found');
    }
    
    $items = $this->Products_model->manage_transfer_products2($transfer_id);
    
    $filename = 'transfer_' . $transfer['tid'] . '_' . date('Y-m-d') . '.csv';
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    fwrite($output, "\xEF\xBB\xBF");
    
    // Headers
    $headers = [
        'Transfer ID', 'Transfer #', 'From Warehouse', 'To Warehouse', 
        'Date', 'Created By', 'Status',
        'Product Name', 'Product Code', 'Quantity', 
        'Description', 'Unit', 'Width', 'Thickness',
        'Quick Calc', 'Quick Code'
    ]; 
    fputcsv($output, $headers);
    
    // Transfer info + items
    foreach ($items as $item) {
        $row = [
            $transfer['id'],
            $transfer['tid'],
            $transfer['from_warehouse'],
            $transfer['to_warehouse'],
            $transfer['invoicedate'],
            $transfer['refer'],
            $transfer['status'] ?: 'Pending',
            $item['product'],
            $item['code'],
            $item['qty'],
            $item['product_des'],
            $item['unit'],
            $item['pwith'],
            $item['pthickness'],
            $item['pquick'],
            $item['pquick_code']
        ];
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}

public function delete_transfer()
{
    $id = $this->input->post('id');
    
    if (!$this->aauth->is_admin()) {
        echo json_encode(['success' => false, 'message' => 'Permission denied']);
        return;
    }
    
    // First get the tid
    $this->db->select('tid');
    $this->db->where('id', $id);
    $transfer_query = $this->db->get('geopos_stock_transfer');
    
    if ($transfer_query->num_rows() == 0) {
        echo json_encode(['success' => false, 'message' => 'Transfer not found']);
        return;
    }
    
    $transfer = $transfer_query->row();
    $tid = $transfer->tid;
    
    // Delete the items using tid
    $this->db->where('tid', $tid);
    $this->db->delete('geopos_stock_transfer_items');
    
    // Then delete the transfer
    $this->db->where('id', $id);
    $delete = $this->db->delete('geopos_stock_transfer');
    
    if ($delete) {
        echo json_encode(['success' => true, 'message' => 'Transfer deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting transfer']);
    }
}

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    



public function export_transfers_excel() {
    // Create a simple Excel export
    $this->load->dbutil();
    $this->load->helper('file');
    $this->load->helper('download');
    
    $query = $this->db->query("
        SELECT 
            st.tid as 'Transfer ID',
            st.from_warehouse as 'From Warehouse',
            st.to_warehouse as 'To Warehouse',
            st.invoicedate as 'Date',
            st.items as 'Total Items',
            GROUP_CONCAT(CONCAT(sti.product, ' (', sti.qty, ')') SEPARATOR ', ') as 'Items List'
        FROM geopos_stock_transfer st
        LEFT JOIN geopos_stock_transfer_items sti ON st.tid = sti.tid
        GROUP BY st.id
        ORDER BY st.invoicedate DESC, st.tid DESC
    ");
    
    $delimiter = ",";
    $newline = "\r\n";
    $enclosure = '"';
    
    $data = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
    
    force_download('stock_transfers_' . date('Y-m-d') . '.csv', $data);
}
    
    
    



 public function transfer_view()
{
    $tid = $this->input->get('id');
    
    if (!$tid) {
        show_404();
    }

    $data['id'] = $tid;
    $data['invoice'] = $this->products->manage_transfer_details($tid, $this->limited);
    
    if (!$data['invoice']) {
        show_404();
    }
    
    // Get employee details for signature
    $employee_id = $data['invoice']['eid'];
    $this->db->where('id', $employee_id);
    $employee_query = $this->db->get('geopos_employees');
    $data['employee'] = $employee_query->row_array();
    
    $data['title'] = "Delivery Note #" . $data['invoice']['tid'];
    $data['products'] = $this->products->manage_transfer_products($data['invoice']['tid']);

    // Check if location function exists
    if (!function_exists('location')) {
        // Load helper if needed
        $this->load->helper('common');
    }
    
    // Get location data
    $data['loc'] = location($this->aauth->get_user()->loc);

    ini_set('memory_limit', '64M');

    $html = $this->load->view('products/del_note', $data, true);

    //PDF Rendering
    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
    $pdf->WriteHTML($html);

    if ($this->input->get('d')) {
        $pdf->Output('DO_#' . $data['invoice']['tid'] . '.pdf', 'D');
    } else {
        $pdf->Output('DO_#' . $data['invoice']['tid'] . '.pdf', 'I');
    }
}




    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            if ($this->products->meta_delete($name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'
            ));
        }
    }

    public function barcode()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,barcode,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $data['name'] = $resultz['product_name'];
            $data['code'] = $resultz['barcode'];
            $data['ctype'] = $resultz['code_type'];
            $html = $this->load->view('barcode/view', $data, true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');

        }
    }

    public function posbarcode()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,barcode,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $data['name'] = $resultz['product_name'];
            $data['code'] = $resultz['barcode'];
            $data['ctype'] = $resultz['code_type'];
            $html = $this->load->view('barcode/posbarcode', $data, true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_thermal();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');

        }
    }

    public function view_over()
    {
        $pid = $this->input->post('id');
        $this->db->select('geopos_products.*, geopos_warehouse.title as warehouse_title, c.title as category_title, sc.title as subcategory_title');
        $this->db->from('geopos_products');
        $this->db->where('geopos_products.pid', $pid);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');
        $this->db->join('geopos_product_cat as c', 'c.id = geopos_products.pcat', 'left');
        $this->db->join('geopos_product_cat as sc', 'sc.id = geopos_products.sub_id', 'left');

        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }

        $query = $this->db->get();
        $data['product'] = $query->row_array();

        $this->db->select('geopos_products.*,geopos_warehouse.title');
        $this->db->from('geopos_products');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('geopos_products.merge', 1);
        $this->db->where('geopos_products.sub', $pid);
        $query = $this->db->get();
        $data['product_variations'] = $query->result_array();

        $this->db->select('geopos_products.*,geopos_warehouse.title');
        $this->db->from('geopos_products');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('geopos_products.sub', $pid);
        $this->db->where('geopos_products.merge', 2);
        $query = $this->db->get();
        $data['product_warehouse'] = $query->result_array();


        $this->load->view('products/view-over', $data);


    }


    public function label()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,product_price,product_code,barcode,expiry,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();

            $html = $this->load->view('barcode/label', array('lab' => $resultz), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');

        }
    }


    public function poslabel()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,product_price,product_code,barcode,expiry,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $html = $this->load->view('barcode/poslabel', array('lab' => $resultz), true);
            ini_set('memory_limit', '64M');
            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_thermal();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }

    public function report_product()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));

        if ($pid && $r_type) {


            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid WHERE geopos_invoice_items.pid='$pid' AND geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid WHERE geopos_purchase_items.pid='$pid' AND geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT rid2 AS qty, DATE(d_time) AS  invoicedate,note FROM geopos_movers  WHERE geopos_movers.d_type='1' AND rid1='$pid'  AND (DATE(d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }

            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $cat_ware = $this->categories_model->cat_ware($pid, $this->aauth->get_user()->loc);

//if(!$cat_ware) exit();
            $html = $this->load->view('products/statementpdf-ltr', array('report' => $result, 'product' => $product, 'cat_ware' => $cat_ware, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $product = $query->row_array();
            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/statement', array('id' => $pid, 'product' => $product));
            $this->load->view('fixed/footer');
        }
    }

    public function custom_label()
    {
        if ($this->input->post()) {
            $width = $this->input->post('width');
            $height = $this->input->post('height');
            $padding = $this->input->post('padding');
            $store_name = $this->input->post('store_name');
            $warehouse_name = $this->input->post('warehouse_name');
            $product_price = $this->input->post('product_price');
            $product_code = $this->input->post('product_code');
            $bar_height = $this->input->post('bar_height');
            $total_rows = $this->input->post('total_rows');
            $items_per_rows = $this->input->post('items_per_row');
            $products = array();


            foreach ($this->input->post('products_l') as $row) {
                $this->db->select('geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.barcode,geopos_products.expiry,geopos_products.code_type,geopos_warehouse.title,geopos_warehouse.loc');
                $this->db->from('geopos_products');
                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');

                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

                //  $this->db->where('warehouse', $warehouse);
                $this->db->where('geopos_products.pid', $row);
                $query = $this->db->get();
                $resultz = $query->row_array();

                $products[] = $resultz;

            }


            $loc = location($resultz['loc']);

            $design = array('store' => $loc['cname'], 'warehouse' => $resultz['title'], 'width' => $width, 'height' => $height, 'padding' => $padding, 'store_name' => $store_name, 'warehouse_name' => $warehouse_name, 'product_price' => $product_price, 'product_code' => $product_code, 'bar_height' => $bar_height, 'total_rows' => $total_rows, 'items_per_row' => $items_per_rows);

            $html = $this->load->view('barcode/custom_label', array('products' => $products, 'style' => $design), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');


        } else {
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/custom_label', $data);
            $this->load->view('fixed/footer');
        }
    }


}
