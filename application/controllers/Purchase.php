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

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model', 'purchase');
        $this->load->model('locations_model', 'locations');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'stock';

    }

    //create invoice
    public function create()
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Purchase";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $data['taxdetails'] = $this->common->taxdetail();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/newinvoice', $data);
        $this->load->view('fixed/footer');
    }
    
    //create createlogs
    public function createlogs()
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase_logs();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Purchase";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $data['taxdetails'] = $this->common->taxdetail();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/newinvoice_logs', $data);
        $this->load->view('fixed/footer');
    }

    public function log_purchasing()
    {
        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $head['title'] = "Raw Log Purchasing";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['locations'] = $this->locations->locations_list2();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/log_purchasing', $data);
        $this->load->view('fixed/footer');
    }

    public function logs_inventory()
    {
        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $head['title'] = "Logs Inventory (Location Aware)";
        $head['usernm'] = $this->aauth->get_user()->username;
        $loc = $this->aauth->get_user()->loc;
        $this->load->model('TimberPro_model', 'timberpro');
        $data['locations'] = $this->locations->locations_list2();
        $data['logs'] = $this->timberpro->get_logs_at_location($loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/logs_inventory', $data);
        $this->load->view('fixed/footer');
    }
    
    
    //create newprocessing
    public function newprocessing($pid = 0, $pcode = '')
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $data['pre_pid'] = $pid;
        $data['pre_pcode'] = $pcode;
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase_wood();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Processing";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $data['taxdetails'] = $this->common->taxdetail();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/newprocessing', $data);
        $this->load->view('fixed/footer');
    }
    
    

    //edit invoice
    public function edit()
    {
        if (!$this->aauth->premission(2, 'edit')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "Purchase Order $tid";
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->purchase->billingterms();
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);;
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/edit', $data);
        $this->load->view('fixed/footer');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['status'] = $this->input->get('status');
        $data['branch_id'] = $this->input->get('branch_id');
        $data['start_date'] = $this->input->get('start_date');
        $data['end_date'] = $this->input->get('end_date');
        $data['locations'] = $this->locations->locations_list2();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/invoices', $data);
        $this->load->view('fixed/footer');
    }
    //invoices list
    public function list()
    {
        $head['title'] = "Manage Timber Logs Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['status'] = $this->input->get('status');
        $data['branch_id'] = $this->input->get('branch_id');
        $data['start_date'] = $this->input->get('start_date');
        $data['end_date'] = $this->input->get('end_date');
        $data['locations'] = $this->locations->locations_list2();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/invoices_list', $data);
        $this->load->view('fixed/footer');
    }
    
    
    //Manage Processing Orders
    public function manageprocessing()
    {
        $head['title'] = "Manage Processing Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/manageprocessing');
        $data['locations'] = $this->locations->locations_list2();
        $this->load->view('fixed/footer');
    }
    
    
    //action
    public function action()
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        $ship_taxtype = $this->input->post('ship_taxtype');
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;
        }
        $this->db->trans_start();
        //products
        $transok = true;
        //Invoice Data
        $bill_date = datefordatabase($invoicedate . ' ' . date('H:i:s'));
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'loc' => $this->aauth->get_user()->loc, 'multi' => $currency);


        if ($this->db->insert('geopos_purchase', $data)) {
            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $flag = false;
            $product_id = $this->input->post('pid');
            $product_name1 = $this->input->post('product_name', true);
            $product_qty = $this->input->post('product_qty');
            $product_price = $this->input->post('product_price');
            $product_tax = $this->input->post('product_tax');
            $product_discount = $this->input->post('product_discount');
            $product_subtotal = $this->input->post('product_subtotal');
            $ptotal_tax = $this->input->post('taxa');
            $ptotal_disc = $this->input->post('disca');
            $product_des = $this->input->post('product_description', true);
            $product_unit = $this->input->post('unit');
            $product_hsn = $this->input->post('hsn');
            $product_alert = $this->input->post('alert');
            $product_pwith = $this->input->post('product_pwith');
            $product_thicknes = $this->input->post('product_thicknes');
            $pquick = $this->input->post('pquick');
            $product_quick_code = $this->input->post('product_quick_code');
            $o_pquick = $this->input->post('o_pquick');
            $local_imported = $this->input->post('local_imported'); 
            $group_id = $this->input->post('group_id'); 
            $product_sqft = $this->input->post('product_sqft');
            $product_rate = $this->input->post('product_rate');
            $product_qty2 = $this->input->post('qty2');


            $profit_rates = $this->input->post('profit_rates');
            $product_costs = $this->input->post('product_cost');
                           
                                
                                
                                
            
            foreach ($pid as $key => $value) {
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key],
                            'pwith' => $product_pwith[$key],
        'pthickness' => $product_thicknes[$key],
        'pquick' => numberClean($pquick[$key]),
        'pquick_code' => $product_quick_code[$key],
        'local_imported' => $local_imported[$key],
        'o_pquick' => $o_pquick[$key], 
        'group_id' => $group_id[$key],
        'sqft' => $product_sqft[$key],
        'alert' => $product_alert[$key],
        'rate' => $product_rate[$key],
        'qty2' => $product_qty2[$key] 
                        
                );

                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);
                $amt2 = numberClean($pquick[$key]);
                $profit_rate = numberClean($profit_rates[$key]);
                $product_cost = numberClean($product_costs[$key]);
                

                if ($product_id[$key] > 0) {
                    if ($this->input->post('update_stock') == 'yes') {

                                                                 
   
// Calculate values safely
$base_price = $product_price[$key] * $product_des[$key];


//// Calculate prices

$profit_rate_calc = $base_price/100*$profit_rate;
$cost_rate_calc   = $base_price/100*$product_cost;
//
//
$product_new_price = $base_price + $profit_rate_calc;
$fproduct_new_cost = $base_price + $cost_rate_calc;

                                                                                   

$this->db->set('product_price', "$product_new_price", FALSE); // Raw SQL for qty
$this->db->set('fproduct_price', "$base_price", FALSE); // Raw SQL for qty
$this->db->set('fproduct_cost', "$fproduct_new_cost", FALSE); // Raw SQL for qty
$this->db->set('qty', "qty+$amt", FALSE); // Raw SQL for qty
$this->db->where('pid', $product_id[$key]);
$this->db->update('geopos_products');
                        
                        $this->db->set('qty2', "qty2+$amt2", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                        
                          //  if (!empty($product_quick_code[$key])) {
                          //          $this->db->set('qty', "qty+$amt2", FALSE);
                           //         $this->db->where('product_code', $product_quick_code[$key]);
                           //         $this->db->update('geopos_products');  
                          //  }                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                    }
                    $itc += $amt;
                }

            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_purchase_items', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_purchase');

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }


            
            echo json_encode(array(
    'status' => 'Success',
    'message' => $this->lang->line('Purchase order success') . 
        " <a href='" . base_url("purchase/view?id=$invocieno") . "' class='btn btn-info btn-lg'>
            <span class='fa fa-eye' aria-hidden='true'></span> " . 
            $this->lang->line('View') . 
        " </a>"
));
            
             } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }


    }
    


     //action2
    public function action2()
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        
        $overall_cubic_feet_total = $this->input->post('overall_cubic_feet_total');        
        
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal2'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        $ship_taxtype = $this->input->post('ship_taxtype');
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;
        }
        $this->db->trans_start();
        //products
        $transok = true;
        //Invoice Data
        $bill_date = datefordatabase($invoicedate . ' ' . date('H:i:s'));
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'loc' => $this->aauth->get_user()->loc, 'multi' => $currency, 'pquick' => $overall_cubic_feet_total);


        if ($this->db->insert('geopos_purchase_logs', $data)) {
            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $flag = false;
            $product_id = $this->input->post('pid');
            $product_name1 = $this->input->post('product_name2', true);
            $product_qty = $this->input->post('product_qty');
            
            $product_price = $this->input->post('product_price');
            
            
            $product_tax = $this->input->post('product_tax');
            $product_discount = $this->input->post('product_discount');
            $product_subtotal = $this->input->post('product_subtotal');
          //  $ptotal_tax = $this->input->post('taxa');
          //  $ptotal_disc = $this->input->post('disca');
          //  $product_des = $this->input->post('product_description', true);
            $product_unit = $this->input->post('unit');
            $product_hsn = $this->input->post('hsn');
            $product_pwith = $this->input->post('product_r');
            $product_pthickness = $this->input->post('product_l');
            $product_pquick = $this->input->post('product_quick');
            $product_pquick_code = $this->input->post('hsn');
            
            
            


            foreach ($pid as $key => $value) {
              //  $total_discount += numberClean(@$ptotal_disc[$key]);
              //  $total_tax += numberClean($ptotal_tax[$key]);


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    //'tax' => numberClean($product_tax[$key]),
                    //'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                   // 'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    //'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    //'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key],
                    'pwith' => $product_pwith[$key],
                    'pthickness' => $product_pthickness[$key],
                    'pquick' => $product_pquick[$key],
                    'pquick_code' => $product_pquick_code[$key]
                );

                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
       
                
                 
                $amt2 = numberClean($product_pquick[$key]);
                $itemCount = count($product_qty);  // Count the number of items in the list

                $amt = numberClean($product_qty[$key]);

                
                
                
                if ($product_id[$key] > 0) {
                   // if ($this->input->post('update_stock') == 'yes') {

                        $this->db->set('qty2', "qty2+$amt2", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');

                        $this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                    //}
                    // Assuming $items is being updated in a loop
                $itc += numberClean($product_qty[$key]);



                }                
                
                
                
                
                
     

            }
            
            
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_purchase_items_logs', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_purchase_logs');

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success') . "<a href='view2?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>" . $this->lang->line('View2') . " </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR') . ' ' . $this->db->error()['message']));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }


    }   
    
//action woodprocessing
    public function action_woodprocessing()
    {
        if (!$this->aauth->premission(2, 'add')) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $subtotal = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        $ship_taxtype = $this->input->post('ship_taxtype');
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        
        $overall_cubic_feet_total = $this->input->post('overall_cubic_feet_total');
        $wood_overall_cubic_feet_total = $this->input->post('wood_overall_cubic_feet_total');
        $cubic_feet_total_wastage = $this->input->post('cubic_feet_total_wastage');
        
        
       // $product_r = $this->input->post('product_r');
       // $product_l = $this->input->post('product_l');
        
        
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;
        }
        $this->db->trans_start();
        //products
        $transok = true;
        //Invoice Data
        $bill_date = datefordatabase($invoicedate . ' ' . date('H:i:s'));
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'pamnt' => 0, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'loc' => $this->aauth->get_user()->loc, 'multi' => $currency, 'pquick' => $overall_cubic_feet_total, 'wquick' => $wood_overall_cubic_feet_total, 'quickwastage' => $cubic_feet_total_wastage);


        if ($this->db->insert('geopos_purchase_wood', $data)) {
            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $flag = false;
            $product_id = $this->input->post('pid');
            $product_name2 = $this->input->post('product_name2', true);
            $product_qty = $this->input->post('product_qty');
            $product_price = $this->input->post('product_price');
            $product_tax = $this->input->post('product_tax');
            $product_discount = $this->input->post('product_discount');
            $product_subtotal = $this->input->post('product_subtotal');
            $ptotal_tax = $this->input->post('taxa');
            $ptotal_disc = $this->input->post('disca');
            $product_des = $this->input->post('product_description', true);
            $product_unit = $this->input->post('unit');
            $product_pwith = $this->input->post('product_r');
            $product_pthickness = $this->input->post('product_l');
            $product_hsn = $this->input->post('hsn');
            $product_quick_code = $this->input->post('product_quick_code'); 
           
            $result = $this->input->post('result');
            

            			$profit_rates = $this->input->post('profit_rates');
                                $product_costs = $this->input->post('product_cost');
                         
                                
              
            foreach ($pid as $key => $value) {
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name2[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key],
                    'pwith' => $product_pwith[$key],
                    'pthickness' => $product_pthickness[$key],
                    'pquick' => $result[$key],
                    'pquick_code' => $product_quick_code[$key]
                        
                );

                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);
                $profit_rate = numberClean($profit_rates[$key]);
                $product_cost = numberClean($product_costs[$key]);
                

                if ($product_id[$key] > 0) {
                    


                                                                                   
//if ($product_unit[$key] == "Qbic") {
//$this->db->set('product_price', "$product_new_price", FALSE); // Raw SQL for qty
//$this->db->set('fproduct_price', "$base_price", FALSE); // Raw SQL for qty
//$this->db->set('fproduct_cost', "$fproduct_new_cost", FALSE); // Raw SQL for qty
//$this->db->set('qty', "qty+$amt", FALSE); // Raw SQL for qty
//$this->db->where('pid', $product_id[$key]);
//$this->db->update('geopos_products');
//
//                }

                 
                $itemCount = count($product_qty);  // Count the number of items in the list

                
                
                
               if ($product_unit[$key] !== "Qbic") {
                   

                        $this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                    
                    // Assuming $items is being updated in a loop
                $itc += numberClean($product_qty[$key]);
                                      
               }   
                           
                }
            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_purchase_items_wood', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_purchase_wood');
                
                
                
                                    $this->db->set('qty2', "qty2-$overall_cubic_feet_total", FALSE); // Log Volume Decreases
                                    $this->db->where('product_code', $product_quick_code[$key]);
                                    $this->db->update('geopos_products');
                                    
                                    $this->db->set('qty2', "qty2+$wood_overall_cubic_feet_total", FALSE); // Wood Volume Increases
                                    $this->db->set('qty', "qty+$itc", FALSE); // Wood Piece Count Increases
                                    $this->db->where('product_code', $product_quick_code[$key]);
                                    $this->db->update('geopos_products');                                     
                            
                            

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }


            echo json_encode(array(
    'status'  => 'Success',
    'message' => $this->lang->line('Purchase order success') . 
                 "<a href='" . base_url('purchase/view_wood?id=' . $invocieno) . 
                 "' class='btn btn-info btn-lg'>
                     <span class='fa fa-eye' aria-hidden='true'></span> " . 
                     $this->lang->line('View') . 
                 "</a>"
));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }


    }
    
    
    
    public function ajax_list2()
    {

        $list = $this->purchase->get_datatables_logs();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat_time($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view2?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice2?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all_logs(),
            "recordsFiltered" => $this->purchase->count_filtered_logs(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view2()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details_logs($tid);
        $data['products'] = $this->purchase->purchase_products_logs($tid);
        $data['activity'] = $this->purchase->purchase_transactions($tid);
        $data['attach'] = $this->purchase->attach($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $this->load->model('plugins_model', 'plugins');
        $data['default_account'] = $this->plugins->universal_api(65);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['tid']) $this->load->view('purchase/view2', $data);
        $this->load->view('fixed/footer');

    }


    
    
        public function ajax_list_wood()
    {

        $list = $this->purchase->get_datatables_wood();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat_time($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view_wood?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all_wood(),
            "recordsFiltered" => $this->purchase->count_filtered_wood(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view_wood()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details_wood($tid);
        $data['products'] = $this->purchase->purchase_products_wood($tid);
        $data['activity'] = $this->purchase->purchase_transactions($tid);
        $data['attach'] = $this->purchase->attach($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['tid']) $this->load->view('purchase/view_wood', $data);
        $this->load->view('fixed/footer');

    }
    
    
    
    
    
    public function ajax_list()
    {

        $list = $this->purchase->get_datatables();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat_time($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all(),
            "recordsFiltered" => $this->purchase->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);
        $data['activity'] = $this->purchase->purchase_transactions($tid);
        $data['attach'] = $this->purchase->attach($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $this->load->model('plugins_model', 'plugins');
        $data['default_account'] = $this->plugins->universal_api(65);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['tid']) $this->load->view('purchase/view', $data);
        $this->load->view('fixed/footer');

    }

    public function printinvoice2()
    {
        $this->load->library("Custom");
        $this->load->model('locations_model', 'locations');
        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details_logs($tid);
        $data['products'] = $this->purchase->purchase_products_logs($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['activity'] = $this->purchase->purchase_transactions($tid);
        if (CUSTOM) $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);
        $data['invoice']['multi'] = 0;

        $data['general'] = array('title' => $this->lang->line('Purchase Order'), 'person' => $this->lang->line('Supplier'), 'prefix' => prefix(2), 't_type' => 0);


        ini_set('memory_limit', '64M');

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/invoice-a4-logs_v' . INVV, $data, true);
        } else {
            $html = $this->load->view('print_files/invoice-a4-logs_v' . INVV, $data, true);
        }

        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }


    public function printinvoice()
    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['invoice']['multi'] = 0;

        $data['general'] = array('title' => $this->lang->line('Purchase Order'), 'person' => $this->lang->line('Supplier'), 'prefix' => prefix(2), 't_type' => 0);


        ini_set('memory_limit', '64M');

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/invoice-a4-gst_v' . INVV, $data, true);
        } else {
            $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
        }

        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 40));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->purchase->purchase_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Purchase Order #$id has been deleted successfully!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "There is an error! Purchase has not deleted."));
        }

    }
    
    public function delete_i_wood()
    {
        $id = $this->input->post('deleteid');

        if ($this->purchase->purchase_delete_wood($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Purchase Order #$id has been deleted successfully!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "There is an error! Purchase has not deleted."));
        }

    }

    
    public function delete_i2()
    {
        $id = $this->input->post('deleteid');

        if ($this->purchase->purchase_delete2($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Purchase Order #$id has been deleted successfully!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "There is an error! Purchase has not deleted."));
        }

    }

    public function editaction()
    {
        // Get basic form inputs
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('iid');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $refer = $this->input->post('refer', true);
        $currency = $this->input->post('mcurrency');
        $i_class = $this->input->post('i_class', true) ?: 0;
        
        // Get charge fields
        $loadingunloading = rev_amountExchange_s($this->input->post('loadingunloading') ?: 0, $currency, $this->aauth->get_user()->loc);
        $cuttingsawing = rev_amountExchange_s($this->input->post('cuttingsawing') ?: 0, $currency, $this->aauth->get_user()->loc);
        $planing = rev_amountExchange_s($this->input->post('planing') ?: 0, $currency, $this->aauth->get_user()->loc);
        
        // Tax and discount settings
        $tax = $this->input->post('tax_handle') ?: 'no';
        $discountFormat = $this->input->post('discountFormat') ?: '%';
        $pterms = $this->input->post('pterms') ?: 0;
        
        // Shipping
        $ship_taxtype = $this->input->post('ship_taxtype') ?: 'off';
        $shipping = rev_amountExchange_s($this->input->post('shipping') ?: 0, $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax') ?: 0, $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') {
            $shipping = $shipping - $shipping_tax;
        }
        
        // Totals
        $subtotal = rev_amountExchange_s($this->input->post('subtotal') ?: 0, $currency, $this->aauth->get_user()->loc);
        $total = rev_amountExchange_s($this->input->post('total') ?: 0, $currency, $this->aauth->get_user()->loc);
        
        // Validation
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please add a supplier!'));
            exit();
        }
        
        $discstatus = ($discountFormat == '0') ? 0 : 1;
        
        // Start transaction
        $this->db->trans_start();
        $transok = true;
        
        // Format dates
        $bill_date = datefordatabase($invoicedate . ' ' . date('H:i:s'));
        $bill_due_date = datefordatabase($invocieduedate);
        
        // Handle stock reversal for removed items before deleting
        if ($this->input->post('restock')) {
            foreach ($this->input->post('restock') as $value) {
                $myArray = explode('-', $value);
                $prid = $myArray[0];
                $dqty = numberClean($myArray[1]);
                if (!empty($prid) && $dqty > 0) {
                    $this->db->set('qty', "qty-$dqty", FALSE);
                    $this->db->where('pid', $prid);
                    $this->db->update('geopos_products');
                }
            }
        }
        
        if ($this->input->post('restock_cubic_3')) {
            foreach ($this->input->post('restock_cubic_3') as $value) {
                $myArray = explode('-', $value);
                $prid = $myArray[0];
                $pdinpquick = numberClean($myArray[1]);
                if (!empty($prid) && $pdinpquick > 0) {
                    $this->db->set('qty2', "qty2-$pdinpquick", FALSE);
                    $this->db->where('pid', $prid);
                    $this->db->update('geopos_products');
                }
            }
        }
        
        if ($this->input->post('restock_cubic')) {
            foreach ($this->input->post('restock_cubic') as $value) {
                $myArray = explode('-', $value);
                $pidqcode = $myArray[0];
                $pdinpquick = numberClean($myArray[1]);
                if (!empty($pidqcode) && $pdinpquick > 0) {
                  //  $this->db->set('qty', "qty-$pdinpquick", FALSE);
                  //  $this->db->where('product_code', $pidqcode);
                  //  $this->db->update('geopos_products');
                }
            }
        }
        
        // Delete old items
        $this->db->delete('geopos_purchase_items', array('tid' => $invocieno));
        
        // Product Data Arrays
        $product_id = $this->input->post('pid');
        $product_name1 = $this->input->post('product_name', true);
        $product_qty = $this->input->post('product_qty');
        $old_product_qty = $this->input->post('old_product_qty');
        $product_price = $this->input->post('product_price');
        $product_rate = $this->input->post('product_rate');
        $product_tax = $this->input->post('product_tax');
        $product_discount = $this->input->post('product_discount');
        $product_subtotal = $this->input->post('product_subtotal');
        $ptotal_tax = $this->input->post('taxa');
        $ptotal_disc = $this->input->post('disca');
        $product_des = $this->input->post('product_description', true);
        $product_unit = $this->input->post('unit');
        $product_hsn = $this->input->post('hsn');
        $product_pwith = $this->input->post('product_pwith');
        $product_thicknes = $this->input->post('product_thicknes');
        $pquick = $this->input->post('pquick');
        $old_product_pquick = $this->input->post('old_product_pquick');
        $product_quick_code = $this->input->post('product_quick_code');
        $local_imported = $this->input->post('local_imported');
        $product_sqft = $this->input->post('product_sqft');
        $product_alert = $this->input->post('alert');
        $product_qty2 = $this->input->post('qty2');
        $o_pquick = $this->input->post('o_pquick');
        $group_id = $this->input->post('group_id');
        
        // Initialize totals
        $total_tax = 0;
        $total_discount = 0;
        $total_items = 0;
        $l_subtotal = 0;
        $i_subtotal = 0;
        
        $productlist = array();
        $prodindex = 0;
        
        // Process each product
        foreach ($product_id as $key => $value) {
            $total_discount += numberClean(@$ptotal_disc[$key]);
            $total_tax += numberClean($ptotal_tax[$key]);
            
            $current_qty = numberClean($product_qty[$key]);
            $current_qty2 = numberClean($product_qty2[$key]);
            $current_pquick = numberClean($pquick[$key]);
            
            // Build product item data matching database schema
            $data = array(
                'tid' => $invocieno,
                'pid' => $product_id[$key],
                'product' => $product_name1[$key],
                'code' => $product_hsn[$key],
                'qty' => $current_qty,
                'qty2' => $current_qty2,
                'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                'rate' => rev_amountExchange_s($product_rate[$key], $currency, $this->aauth->get_user()->loc),
                'tax' => numberClean($product_tax[$key]),
                'discount' => numberClean($product_discount[$key]),
                'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                'product_des' => numberClean($product_des[$key]),
                'i_class' => $i_class,
                'unit' => $product_unit[$key],
                'pwith' => numberClean($product_pwith[$key]),
                'pthickness' => numberClean($product_thicknes[$key]),
                'pquick' => $current_pquick,
                'pquick_code' => $product_quick_code[$key],
                'local_imported' => $local_imported[$key],
                'o_pquick' => numberClean($o_pquick[$key]),
                'sqft' => numberClean($product_sqft[$key]),
                'alert' => numberClean($product_alert[$key]),
                'group_id' => $group_id[$key] ?? 0
            );
            
            $productlist[$prodindex] = $data;
            $prodindex++;
            
            // Calculate local/imported totals
            if ($local_imported[$key] == 'l') {
                $l_subtotal += rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc);
            } elseif ($local_imported[$key] == 'i') {
                $i_subtotal += rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc);
            }
            
            // Update stock if product exists and stock should be updated
            if ($product_id[$key] > 0 && $this->input->post('update_stock') == 'yes') {
                // Update qty (pieces)
                $old_qty = numberClean(@$old_product_qty[$key]);
                $amt = $current_qty - $old_qty;
                if ($amt != 0) {
                    $this->db->set('qty', "qty+$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('geopos_products');
                }
                
                // Update qty2 (cubic feet for specific product)
                $old_pquick = numberClean(@$old_product_pquick[$key]);
                $amt2 = $current_pquick - $old_pquick;
                if ($amt2 != 0) {
                    $this->db->set('qty2', "qty2+$amt2", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('geopos_products');
                }
                
                // Update raw material stock (by product_code)
                if ($current_pquick > 0 && !empty($product_quick_code[$key])) {
                    if ($amt2 != 0) {
                    //    $this->db->set('qty', "qty+$amt2", FALSE);
                    //    $this->db->where('product_code', $product_quick_code[$key]);
                    //    $this->db->update('geopos_products');
                    }
                }
            }
            
            $total_items += $current_qty;
        }
        
        // Check if we have products
        if ($prodindex == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please add at least one product in purchase order!'));
            $this->db->trans_rollback();
            return;
        }
        
        // Insert new items
        $this->db->insert_batch('geopos_purchase_items', $productlist);
        
        // Update main purchase record with all fields matching database schema
        $purchase_data = array(
            'invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'ship_tax' => $shipping_tax,
            'ship_tax_type' => $ship_taxtype,
            'planing' => $planing,
            'planing_tax' => 0,
            'planing_taxtype' => 'off',
            'cuttingsawing' => $cuttingsawing,
            'cuttingsawing_tax' => 0,
            'cuttingsawing_taxtype' => 'off',
            'loadingunloading' => $loadingunloading,
            'loadingunloading_tax' => 0,
            'loadingunloading_taxtype' => 'off',
            'discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc),
            'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc),
            'total' => $total,
            'localtotal' => $l_subtotal,
            'importedtotal' => $i_subtotal,
            'notes' => $notes,
            'csd' => $customer_id,
            'items' => $total_items,
            'taxstatus' => $tax,
            'discstatus' => $discstatus,
            'format_discount' => $discountFormat,
            'refer' => $refer,
            'term' => $pterms,
            'multi' => $currency,
            'i_class' => $i_class
        );
        
        $this->db->where('id', $invocieno);
        if ($this->db->update('geopos_purchase', $purchase_data)) {
            echo json_encode(array(
                'status' => 'Success',
                'message' => "Purchase order has been updated successfully! <a href='" . base_url() . "purchase/view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye'></span> View</a>"
            ));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to update purchase order!'));
            $transok = false;
        }
        
        // Complete or rollback transaction
        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
    }



    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_purchase');

        echo json_encode(array('status' => 'Success', 'message' =>
            'Purchase Order Status updated successfully!', 'pstatus' => $status));
    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->purchase->meta_delete($invoice, 4, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->purchase->meta_insert($id, 4, $files);
            }
        }
    }
}
