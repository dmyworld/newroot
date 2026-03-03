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

class Categories_model extends CI_Model
{

    public function category_list($type = 0, $rel = 0)
    {
        $user = $this->aauth->get_user();
        $whr = "WHERE c_type='$type' AND rel_id='$rel'";
        if ($user->roleid != 1) { // Not Super Admin
            $whr .= " AND (status=1 OR requested_by='" . $user->id . "')";
        }
        $query = $this->db->query("SELECT * FROM geopos_product_cat $whr ORDER BY id DESC");
        return $query->result_array();
    }
	
	
	
	
	
	
	
	
	 public function product_list_pcat($sub_id)
    {
        $query = $this->db->query("SELECT *
FROM geopos_products WHERE pcat='$sub_id' 

ORDER BY sub_id DESC");
        return $query->result_array();
    }	
	
	
	
	 public function product_list($sub_id)
    {
        $query = $this->db->query("SELECT *
FROM geopos_products WHERE sub_id='$sub_id' 

ORDER BY sub_id DESC");
        return $query->result_array();
    }
	
	
	
	
	
	
	
	
	
	

    public function warehouse_list()
    {
        $where = '';


        if (!BDATA) $where = "WHERE  (loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }


        $query = $this->db->query("SELECT id,title
FROM geopos_warehouse $where 

ORDER BY id DESC");
        return $query->result_array();
    }

   public function category_stock()
{
    $whr = '';
    if (!BDATA) $whr = "WHERE (geopos_warehouse.loc=0)";
    if ($this->aauth->get_user()->loc) {
        $whr = "WHERE (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . ")";
        if (BDATA) $whr = "WHERE (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0)";
    }

    $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_product_cat AS c LEFT JOIN (SELECT geopos_products.pcat,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price * geopos_products.qty) AS salessum, SUM(geopos_products.fproduct_price * geopos_products.qty) AS worthsum,SUM(geopos_products.qty) AS qty FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse = geopos_warehouse.id $whr GROUP BY geopos_products.pcat) AS p ON c.id = p.pcat WHERE c.c_type = 0");
    return $query->result_array();
}

    public function category_sub_stock($id = 0)
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }

        $whr2 = '';

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty,p.sub_id FROM geopos_product_cat AS c LEFT JOIN ( SELECT geopos_products.sub_id,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price*geopos_products.qty) AS salessum, SUM(geopos_products.fproduct_price*geopos_products.qty) AS worthsum,SUM(geopos_products.qty) AS qty FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id  $whr GROUP BY geopos_products.sub_id ) AS p ON c.id=p.sub_id WHERE c.c_type=1 AND c.rel_id='$id'");
        return $query->result_array();
    }

    public function warehouse()
    {
        $where = '';
        if ($this->aauth->get_user()->loc) {
            $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc;

            if (BDATA) $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc . ' OR c.loc=0';
        } elseif (!BDATA) {
            $where = ' WHERE  c.loc=0';
        }
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_warehouse AS c LEFT JOIN ( SELECT warehouse,COUNT(pid) AS pc,SUM(product_price*qty) AS salessum, SUM(fproduct_price*qty) AS worthsum,SUM(qty) AS qty FROM  geopos_products GROUP BY warehouse ) AS p ON c.id=p.warehouse  $where");
        return $query->result_array();
    }

    public function cat_ware($id, $loc = 0)
    {
        $qj = '';
        if ($loc) $qj = "AND w.loc='$loc'";
        $query = $this->db->query("SELECT c.id AS cid, w.id AS wid,c.title AS catt,w.title AS watt FROM geopos_products AS p LEFT JOIN geopos_product_cat AS c ON p.pcat=c.id LEFT JOIN geopos_warehouse AS w ON p.warehouse=w.id WHERE
p.pid='$id' $qj ");
        return $query->row_array();
    }


    public function addnew($cat_name, $cat_desc, $cat_type = 0, $cat_rel = 0)
    {
        if (!$cat_type) $cat_type = 0;
        if (!$cat_rel) $cat_rel = 0;
        
        $user = $this->aauth->get_user();
        $status = ($user->roleid == 1) ? 1 : 0; // Super Admin auto-approves
        
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc,
            'c_type' => $cat_type,
            'rel_id' => $cat_rel,
            'status' => $status,
            'requested_by' => $user->id
        );

        if ($cat_type) {
            $url = "<a href='" . base_url('productcategory/add_sub') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory/view?id=' . $cat_rel) . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        } else {
            $url = "<a href='" . base_url('productcategory/add') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        }

        if ($this->db->insert('geopos_product_cat', $data)) {
            $this->aauth->applog("[Category Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            $msg = ($status == 1) ? $this->lang->line('ADDED') : "Requested. Awaiting Super Admin approval.";
            echo json_encode(array('status' => 'Success', 'message' => $msg . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function approve($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        return $this->db->update('geopos_product_cat');
    }

    public function addwarehouse($cat_name, $cat_desc, $lid)
    {
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc,
            'loc' => $lid
        );

        if ($this->db->insert('geopos_warehouse', $data)) {
            $this->aauth->applog("[WareHouse Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . "  <a href='addwarehouse' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
    
    



    public function category_products_add_post_model($cid,$rate,$extra, $product_cat_name, $product_cat_desc, $locationid, $warehouseid, $lengtharray)
    {


        // 1. Convert lengtharray to array if it is not already
        if (!is_array($lengtharray)) {
            $lengtharray = explode(',', $lengtharray);
        }
        
        // 2 Create Sub Category
        // Create a new sub-category for this batch of products
        // The sub-category name comes from the form input (e.g. "Kempas 1/2 X 4")
        $cat_data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc,
            'c_type' => 1,
            'rel_id' => $cid
        );

        if ($this->db->insert('geopos_product_cat', $cat_data)) {
            $sub_cat_id = $this->db->insert_id(); // This is the new sub_id for the products

             // 3. Prepare Common Data
             // Get standard inputs
             $new_product_price = $this->input->post('new_product_price');
             $new_fproduct_price = $this->input->post('new_fproduct_price'); // This is a percentage for Wholesale
             $new_fproduct_cost = $this->input->post('new_fproduct_cost');   // This is a percentage for Cost
             $local_imported = $this->input->post('local_imported');
             $wood_unit = $this->input->post('wood_unit');
             $new_product_code = $this->input->post('new_product_code');
             $warehouse = $this->input->post('product_warehouse'); 
             if(!$warehouse) $warehouse = 0;

             // 4. Parse Dimensions from Name
             // Extract Thickness and Width from the Name (e.g. "Kempas 1/2 X 4" -> Thickness: 0.5, Width: 4)
             $dim_thickness = '';
             $dim_thickness_second = 0; // Decimal thickness
             $dim_width = '';

             if (preg_match('/\(([\d\s\/]+)[xX](\d+)\)/', $product_cat_name, $matches)) {
                 // For Product Code (digits only)
                 $dim_thickness = preg_replace('/[^\d]/', '', $matches[1]);
                 $dim_width = $matches[2];

                 // Parse Thickness to Decimal for Calculation
                 $thick_str = trim($matches[1]);

                 if (strpos($thick_str, ' ') !== false) {
                     // Mixed fraction: "1 1/8"
                     $parts = explode(' ', $thick_str);
                     if (count($parts) >= 2) {
                         $frac = explode('/', $parts[1]);
                         if (count($frac) == 2) {
                             $dim_thickness_second = floatval($parts[0]) + (floatval($frac[0]) / floatval($frac[1]));
                         }
                     }
                 } elseif (strpos($thick_str, '/') !== false) {
                     // Simple fraction: "3/4"
                     $frac = explode('/', $thick_str);
                     if (count($frac) == 2) {
                         $dim_thickness_second = floatval($frac[0]) / floatval($frac[1]);
                     }
                 } else {
                     // Whole number or decimal: "2"
                     $dim_thickness_second = floatval($thick_str);
                 }
             }
             
             // 5. Loop through Lengths and Create Products
             if (is_array($lengtharray)) {
                 foreach ($lengtharray as $len) {
                     // Ensure length is valid
                     if($len > 0) {
                        
                        // A. Clean formatted Length for Name (e.g. 1.5 -> 1 1/2) 
                        // Note: For now using decimal as per request or standard logic. 
                        // If fraction conversion needed for Name, can add helper. 
                        // Using decimal for simplicity and consistency with previous logic unless specified.
                        
                        // B. Generate Name
                        // Format: "CategoryName - Length Feet"
                        // e.g. "Kempas 1/2 X 4 - 10 Feet"
                        // Adjusting logic to match typical Wood format: Name(Thich X Width) Length
                        // Based on user request "Kempas(1/2" X 4")" -> Name seems to include dims.
                        // Let's Append Length.
                        
                        // Cleaning up the name slightly to remove the "X Widths" part if present in instructions but user input might be clean.
                        // Assuming $product_cat_name is "Kempas(1/2 X 4)"
                        $product_name = $product_cat_name . " - " . $len;

                        // C. Generate Code
                        // Format: Code + Thickness + Width + Length
                        $product_code = $new_product_code . $dim_thickness . $dim_width . $len;

                        // D. Calculate Cubic Feet (P-Quick)
                        // Formula: (Thickness_inch * Width_inch * Length_ft) / 144
                        $pquick = 0;
                        if ($dim_thickness_second > 0 && $dim_width > 0 && $len > 0) {
                            $pquick = ($dim_thickness_second * $dim_width * $len) / 144;
                            $pquick = round($pquick, 4);
                        }
                        
                         // E. Calculate Prices
                         $wood_unit_sqft = 0;
                         
                         if ($wood_unit == 'Sqft') {
                             // Sqft Formula: (Width_inch / 12) * Length_ft
                             $wood_unit_sqft = ($dim_width / 12) * $len;
                             
                             $product_price = $wood_unit_sqft * $new_product_price;
                             $fproduct_price = ($new_product_price / 100) * $new_fproduct_price * $wood_unit_sqft;
                             $fproduct_cost = ($new_product_price / 100) * $new_fproduct_cost * $wood_unit_sqft;

                         } else {
                             // Feet
                             $product_price = $new_product_price * $len;
                             $fproduct_price = ($new_product_price / 100) * $new_fproduct_price * $len;
                             $fproduct_cost = ($new_product_price / 100) * $new_fproduct_cost * $len;
                         }

                        // F. Insert Product
                        // Using default values for missing fields as this is a new large batch insert
                        
                        $data = array(
                            'pcat' => $cid, // Main Category
                            'sub_id' => $sub_cat_id, // The NEW Sub Category we just created
                            'warehouse' => $warehouse,
                            'product_name' => $product_name,
                            'product_code' => $product_code,
                            'product_price' => $product_price,
                            'rate' => $rate,
                            'fproduct_price' => $fproduct_price,
                            'fproduct_cost' => $fproduct_cost,
                            'taxrate' => 0,
                            'disrate' => 0,
                            'qty' => 0,
                            'product_des' => $len, // Storing Length in product_des as per legacy
                            'alert' => 50,
                            'unit' => $wood_unit,
                            'code_type' => 'EAN13',
                            'pwith' => $dim_width,
                            'pthickness' => $dim_thickness_second,
                            'pquick' => $pquick, // Cubic feet
                            'local_imported' => $local_imported,
                            'sqft' => $wood_unit_sqft,
                            'pquick_code' => $extra,
                            'sub' => 0 // Ensuring it doesn't break anything, though legacy used 'sub'
                        );

                        $this->db->insert('geopos_products', $data);

                     }
                 }
             }

            $this->aauth->applog("[Category Created] $product_cat_name ID " . $sub_cat_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . " <a href='" . base_url('productcategory/category_products_add') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span> Add More Products</a>"));

        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
    


   public function edit_mane($catid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type,$locationid,$warehouseid)
    {
         if (!$cat_rel) $cat_rel = 0;
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc,
            'c_type' => $cat_type,
            'rel_id' => $cat_rel
        );
        $this->db->set($data);
        $this->db->where('id', $catid);
        if ($this->db->update('geopos_product_cat')) {
                $data = array('pcat' => $cat_rel);
                $this->db->set($data);
                $this->db->where('sub_id', $catid);
                $this->db->update('geopos_products');
				
				
				
				
				
       $this->db->select('*');
       $this->db->from('geopos_products');
       $this->db->where('sub_id', $catid);
       $queryy = $this->db->get();
       $data['product_row'] = $queryy->row_array();
       
               
                 
				$product_rate = $this->input->post('new_product_price');
				$new_product_price = $this->input->post('new_product_price');
				$new_fproduct_price = $this->input->post('new_fproduct_price');
                                $new_fproduct_cost = $this->input->post('new_fproduct_cost');
                                
                                $selected_product_ids = $this->input->post('products_l');
                                $local_imported = $this->input->post('local_imported');
                                
                                $wood_unit = $this->input->post('wood_unit');

                                $new_product_code = $this->input->post('new_product_code');
									   
									  
                                    $dim_thickness = '';
                                    $dim_thickness_second = 0;
                                    $dim_width = '';
                                    
                                    if (preg_match('/\(([\d\s\/]+)[xX](\d+)\)/', $product_cat_name, $matches)) {
                                        // For Product Code (digits only)
                                        $dim_thickness = preg_replace('/[^\d]/', '', $matches[1]);
                                        $dim_width = $matches[2];
                                        
                                        // Parse Thickness to Decimal for Calculation
                                        $thick_str = trim($matches[1]);
                                        
                                        if (strpos($thick_str, ' ') !== false) {
                                            // Mixed fraction: "1 1/8"
                                            $parts = explode(' ', $thick_str);
                                            if (count($parts) >= 2) {
                                                $frac = explode('/', $parts[1]);
                                                if (count($frac) == 2) {
                                                    $dim_thickness_second = floatval($parts[0]) + (floatval($frac[0]) / floatval($frac[1]));
                                                }
                                            }
                                        } elseif (strpos($thick_str, '/') !== false) {
                                            // Simple fraction: "3/4"
                                            $frac = explode('/', $thick_str);
                                            if (count($frac) == 2) {
                                                $dim_thickness_second = floatval($frac[0]) / floatval($frac[1]);
                                            }
                                        } else {
                                            // Whole number or decimal: "2"
                                            $dim_thickness_second = floatval($thick_str);
                                        }
                                    }

foreach ($selected_product_ids as $pid) {
										   
       $this->db->select('*');
       $this->db->from('geopos_products');
       $this->db->where('pid', $pid);
       $queryy = $this->db->get();
       $product = $queryy->row_array(); // Get product data if needed
       
       $this->db->select('*');
       $this->db->from('geopos_products');
       $this->db->where('sub', $pid);
       $queryy_w = $this->db->get();
       $product_w = $queryy_w->row_array(); // Get sub product data if needed       

                                           $product_name       =  $product_cat_name.$product['product_des'];
                                           $product_code       =  $new_product_code.$dim_thickness.$dim_width.$product['product_des'];
                                           
                                           // Calculate P-Quick (Cubic Feet)
                                           // Formula: (Thickness_inch * Width_inch * Length_ft) / 144
                                           $pquick = 0;
                                           if ($dim_thickness_second > 0 && $dim_width > 0 && $product['product_des'] > 0) {
                                                $pquick = ($dim_thickness_second * $dim_width * $product['product_des']) / 144;
                                                $pquick = round($pquick, 4);
                                           }

                                           $product_name_w       =  $product_cat_name.$product_w['product_des'];
                                           $product_code_w       =  $new_product_code.$dim_thickness.$dim_width.$product_w['product_des'];
                                           $wood_unit_sqft = ($dim_width / 12) * $product['product_des'];

if ($wood_unit == 'Sqft') {
                                           
                                           $product_new_price = $wood_unit_sqft * $new_product_price;
                                           $fproduct_new_price = ($new_product_price / 100) * $new_fproduct_price * $wood_unit_sqft;
                                           $fproduct_new_cost = ($new_product_price / 100) * $new_fproduct_cost * $wood_unit_sqft;

                                           $wood_unit_sqft_w = ($dim_width / 12) * $product_w['product_des'];
                                           $product_new_price_w = $wood_unit_sqft_w * $new_product_price;
                                           $fproduct_new_price_w = ($new_product_price / 100) * $new_fproduct_price * $wood_unit_sqft_w;
                                           $fproduct_new_cost_w = ($new_product_price / 100) * $new_fproduct_cost * $wood_unit_sqft_w;
                                    } else {
                                           $product_new_price =    $new_product_price * $product['product_des'];
                                           $fproduct_new_price =   $new_product_price / 100 * $new_fproduct_price * $product['product_des'];
                                           $fproduct_new_cost =    $new_product_price / 100 * $new_fproduct_cost * $product['product_des'];

                                           $product_new_price_w =  $new_product_price * $product_w['product_des'];
                                           $fproduct_new_price_w = $new_product_price / 100 * $new_fproduct_price * $product_w['product_des'];
                                           $fproduct_new_cost_w =  $new_product_price / 100 * $new_fproduct_cost * $product_w['product_des'];
                                    }                                                                     
                                                    
                                                                                   
                                                       
if (isset($_POST['products_stock'])) {
    // Checkbox is checked
    $data = array(
        'product_price' => $product_new_price,
        'rate' => $product_rate,
        'fproduct_price' => $fproduct_new_price,
        'product_name' => $product_name,
        'qty' => $products_stock,
        'qty2' => $products_stock,
        'fproduct_cost' => $fproduct_new_cost,
        'local_imported' => $local_imported,
        'unit' => $wood_unit,
        'pwith' => $dim_width,
        'pthickness' => $dim_thickness_second,
        'pquick' => $pquick,
        'sqft' => $wood_unit_sqft
    );
    
    // Add product_code only if not empty
    if (!empty($new_product_code)) {
        $data['product_code'] = $product_code;
    }
    
        // Checkbox is checked
    $data_w = array(
        'product_price' => $product_new_price_w,
        'rate' => $product_rate,
        'fproduct_price' => $fproduct_new_price_w,
        'product_name' => $product_name_w,
        'qty' => $products_stock,
        'qty2' => $products_stock,
        'fproduct_cost' => $fproduct_new_cost_w,
        'local_imported' => $local_imported,
        'unit' => $wood_unit,
        'pwith' => $dim_width,
        'pthickness' => $dim_thickness_second,
        'pquick' => $pquick,
        'sqft' => $wood_unit_sqft
    );
    
    // Add product_code only if not empty
    if (!empty($new_product_code_w)) {
        $data_w['product_code'] = $product_code_w;
    }
    
    
} else {
    // Checkbox is not checked
    $data = array(
        'product_price' => $product_new_price,
        'rate' => $product_rate,
        'fproduct_price' => $fproduct_new_price,
        'product_name' => $product_name,
        'fproduct_cost' => $fproduct_new_cost,
        'local_imported' => $local_imported,
        'unit' => $wood_unit,
        'pwith' => $dim_width,
        'pthickness' => $dim_thickness_second,
        'pquick' => $pquick,
        'sqft' => $wood_unit_sqft
    );
    
    // Add product_code only if not empty
    if (!empty($new_product_code)) {
        $data['product_code'] = $product_code;
    }
    
        // Checkbox is not checked
    $data_w = array(
        'product_price' => $product_new_price_w,
        'rate' => $product_rate,
        'fproduct_price' => $fproduct_new_price_w,
        'product_name' => $product_name_w,
        'fproduct_cost' => $fproduct_new_cost_w,
        'local_imported' => $local_imported,
        'unit' => $wood_unit,
        'pwith' => $dim_width,
        'pthickness' => $dim_thickness_second,
        'pquick' => $pquick,
        'sqft' => $wood_unit_sqft
    );
    
    // Add product_code only if not empty
    if (!empty($new_product_code_w)) {
        $data_w['product_code'] = $product_code_w;
    }

}
			 
$this->db->set($data);
$this->db->where('pid', $pid);
$this->db->update('geopos_products'); 
$this->db->set($data_w);
$this->db->where('sub', $pid);
$this->db->update('geopos_products'); 
 
}
				
				
				
				

            $this->aauth->applog("[Category Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }




    
public function edit($catid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type)
{
    if (!$cat_rel) $cat_rel = 0;
    $data = array(
        'title' => $product_cat_name,
        'extra' => $product_cat_desc,
        'c_type' => $cat_type,
        'rel_id' => $cat_rel
    );
    
    // Update category first
    $this->db->where('id', $catid);
    $result = $this->db->update('geopos_product_cat', $data);
    
    if ($result) {
        // Get form data
        $new_product_price = $this->input->post('new_product_price');
        $new_fproduct_price = $this->input->post('new_fproduct_price');
        $new_fproduct_cost = $this->input->post('new_fproduct_cost');
        $selected_product_ids = $this->input->post('products_l');
        $local_imported = $this->input->post('local_imported');
        $wood_unit = $this->input->post('wood_unit');
        $new_product_code = $this->input->post('new_product_code');
        $new_product_qubic_code = $this->input->post('new_product_qubic_code');
        $products_stock = $this->input->post('products_stock');
        
        // Handle case when no products are selected
        if (!$selected_product_ids) {
            $selected_product_ids = array();
        }
        
        // Convert to array if not already
        if (!is_array($selected_product_ids)) {
            $selected_product_ids = array($selected_product_ids);
        }
        
        error_log('Selected product IDs: ' . print_r($selected_product_ids, true));
        error_log('Category Name from form: ' . $product_cat_name);
        
        // Get all sub-categories under this main category
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('rel_id', $catid);
        $sub_categories_query = $this->db->get();
        $sub_categories = $sub_categories_query->result_array();
        
        // Process each sub-category
        foreach ($sub_categories as $sub_category) {
            $sub_cat_title = $sub_category['title'];
            $sub_cat_id = $sub_category['id'];
            
            error_log('Processing sub-category: ' . $sub_cat_title);
            
            // Extract ONLY dimensions from sub-category title (ignore HTML/wood type)
            $dimensions = $this->extractDimensionsFromTitle($sub_cat_title);
            
            if ($dimensions) {
                $thickness_str = $dimensions['thickness_str'];
                $width = $dimensions['width'];
                
                error_log('Extracted dimensions - Thickness: ' . $thickness_str . ', Width: ' . $width);
                
                // Parse thickness for calculations
                $thickness_decimal = $this->parseThicknessToDecimal($thickness_str);
                
                // Parse thickness for code generation
                $thickness_code_info = $this->parseThicknessForCode($thickness_str);
                $thickness_code_str = $thickness_code_info['thickness_code'];
                
                // Get products in this sub-category
                $this->db->select('*');
                $this->db->from('geopos_products');
                $this->db->where('sub_id', $sub_cat_id);
                
                if (!empty($selected_product_ids)) {
                    $this->db->where_in('pid', $selected_product_ids);
                }
                
                $products_query = $this->db->get();
                $products = $products_query->result_array();
                
                foreach ($products as $product) {
                    $pid = $product['pid'];
                    $length = $product['product_des'];
                    
                    // IMPORTANT: Use CATEGORY NAME FROM FORM + dimensions + length
                    $generated_product_name = $this->generateProductNameWithCategory($product_cat_name, $thickness_str, $width, $length);
                    
                    // Generate product code
                    $generated_product_code = $this->generateProductCodeWithThickness($new_product_code, $thickness_code_str, $width, $length);
                    
                    // Calculate cubic measurement
                    $pquick = $this->calculateCubicMeasurement($thickness_decimal, $width, $length);
                    
                    error_log("Generated product name: " . $generated_product_name);
                    
                    // Prepare update data
                    $update_data = array(
                        'product_name' => $generated_product_name,
                        'product_code' => $generated_product_code,
                        'pwith' => $width,
                        'pthickness' => $thickness_decimal,
                        'pquick' => $pquick,
                        'pquick_code' => $new_product_qubic_code,
                        'local_imported' => $local_imported,
                        'unit' => $wood_unit
                    );
                    
                    // Add pricing if needed
                    if ($cat_type == 1 && !empty($new_product_price) && is_numeric($new_product_price)) {
                        $product_new_price = $new_product_price * $length;
                        $fproduct_new_price = $new_product_price / 100 * $new_fproduct_price * $length;
                        $fproduct_new_cost = $new_product_price / 100 * $new_fproduct_cost * $length;
                        
                        $update_data['product_price'] = $product_new_price;
                        $update_data['fproduct_price'] = $fproduct_new_price;
                        $update_data['fproduct_cost'] = $fproduct_new_cost;
                    }
                    
                    // Handle stock
                    if ($products_stock) {
                        $update_data['qty'] = 0;
                    }
                    
                    // Update the product
                    $this->db->where('pid', $pid);
                    $this->db->update('geopos_products', $update_data);
                }
            }
        }
        
        $this->aauth->applog("[Category Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
    } else {
        echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
    }
}

// Extract dimensions from sub-category title (ignore HTML labels and wood type)
private function extractDimensionsFromTitle($title)
{
    $title = trim($title);
    
    // Pattern 1: Look for dimensions pattern anywhere in the string
    // This pattern looks for numbers, fractions, x/X, and more numbers
    if (preg_match('/([\d\s\.\/\-½¼¾⅓⅔⅛⅜⅝⅞"\' ]+\s*[xX]\s*\d+)/', $title, $matches)) {
        $dimension_str = trim($matches[1]);
        error_log("Found dimension string: $dimension_str in title: $title");
        return $this->parseDimensionString($dimension_str);
    }
    
    error_log("No dimensions found in title: $title");
    return false;
}

// Parse dimension string
private function parseDimensionString($dimension_str)
{
    $dimension_str = trim($dimension_str);
    
    // Clean the string
    $dimension_str = str_replace(['"', "'"], ' ', $dimension_str);
    $dimension_str = preg_replace('/\s*[xX]\s*/', ' ', $dimension_str);
    
    // Split by spaces
    $parts = preg_split('/\s+/', $dimension_str);
    
    if (count($parts) >= 2) {
        // All parts except last are thickness
        $thickness_parts = array_slice($parts, 0, -1);
        $thickness_str = implode(' ', $thickness_parts);
        $width = (int)end($parts);
        
        // Clean thickness - replace hyphen with space
        $thickness_str = str_replace('-', ' ', $thickness_str);
        $thickness_str = preg_replace('/[^\d½¼¾⅓⅔⅛⅜⅝⅞\.\/\s]/', '', $thickness_str);
        $thickness_str = trim($thickness_str);
        
        return [
            'thickness_str' => $thickness_str,
            'width' => $width
        ];
    }
    
    return false;
}

// Generate product name using CATEGORY NAME FROM FORM + dimensions + length
private function generateProductNameWithCategory($category_name, $thickness_str, $width, $length)
{
    // Clean inputs
    $category_name = trim($category_name);
    $thickness_str = trim($thickness_str);
    
    // Format: "CategoryName Thickness X Width - Length"
    return $category_name . ' ' . $thickness_str . ' X ' . $width . ' - ' . $length;
}

// Parse thickness to decimal
private function parseThicknessToDecimal($thickness_str)
{
    $thickness_str = str_replace('-', ' ', $thickness_str);
    
    // Handle Unicode fractions
    $unicode_fractions = [
        '½' => '1/2', '¼' => '1/4', '¾' => '3/4',
        '⅓' => '1/3', '⅔' => '2/3',
        '⅛' => '1/8', '⅜' => '3/8', '⅝' => '5/8', '⅞' => '7/8'
    ];
    
    $thickness_str = strtr($thickness_str, $unicode_fractions);
    $thickness_str = str_replace(['"', "'"], '', $thickness_str);
    $thickness_str = trim($thickness_str);
    
    if (strpos($thickness_str, '/') !== false) {
        if (strpos($thickness_str, ' ') !== false) {
            list($whole, $fraction) = explode(' ', $thickness_str);
            list($num, $den) = explode('/', $fraction);
            return (float)$whole + ($num / $den);
        } else {
            list($num, $den) = explode('/', $thickness_str);
            return $num / $den;
        }
    } else {
        return (float)$thickness_str;
    }
}

// Parse thickness for code generation
private function parseThicknessForCode($thickness_str)
{
    $thickness_str = str_replace(['"', "'"], '', $thickness_str);
    $thickness_str = str_replace('-', ' ', $thickness_str);
    $thickness_str = trim($thickness_str);
    
    // Handle Unicode fractions
    $unicode_fractions = [
        '½' => '1/2', '¼' => '1/4', '¾' => '3/4',
        '⅓' => '1/3', '⅔' => '2/3',
        '⅛' => '1/8', '⅜' => '3/8', '⅝' => '5/8', '⅞' => '7/8'
    ];
    
    $thickness_str = strtr($thickness_str, $unicode_fractions);
    
    $thickness_code = '';
    
    if (strpos($thickness_str, ' ') !== false && strpos($thickness_str, '/') !== false) {
        list($whole, $fraction) = explode(' ', $thickness_str);
        list($num, $den) = explode('/', $fraction);
        $thickness_code = $whole . $num . $den;
    } elseif (strpos($thickness_str, '/') !== false) {
        list($num, $den) = explode('/', $thickness_str);
        $thickness_code = $num . $den;
    } else {
        $thickness_code = $thickness_str;
    }
    
    return ['thickness_code' => $thickness_code];
}

// Generate product code
private function generateProductCodeWithThickness($base_code, $thickness_code_str, $width, $length)
{
    return $base_code . $thickness_code_str . $width . $length;
}

// Calculate cubic measurement
private function calculateCubicMeasurement($thickness_inches, $width_inches, $length_feet)
{
    $cubic_measurement = ($thickness_inches * $width_inches * $length_feet) / 1728;
    return round($cubic_measurement, 4);
}






    public function editwarehouse($catid, $product_cat_name, $product_cat_desc, $lid)
    {
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc,
            'loc' => $lid
        );


        $this->db->set($data);
        $this->db->where('id', $catid);

        if ($this->db->update('geopos_warehouse')) {
            $this->aauth->applog("[Warehouse Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function sub_cat($id = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('rel_id', $id);
        $this->db->where('c_type', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sub_cat_list($id = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('rel_id', $id);
        $this->db->where('c_type', 1);
        $query = $this->db->get();
        return $query->result_array();
    }


}
