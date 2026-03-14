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

class Search_products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('search_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if (!$this->aauth->premission(1) && !$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }



//search product in invoice
    public function search_logs_wood()
    {
  $result = array();
    $out = array();
    $row_num = $this->input->post('row_num', true);
    $name = $this->input->post('name_startsWith', true);

    $name = trim($name);

    $wid = $this->input->post('wid', true);
    $product_quick_code = $this->input->post('product_quick_code', true);

    // Start building the query
    $this->db->select('geopos_products.pid, geopos_products.product_name, geopos_products.product_code, geopos_products.fproduct_price, geopos_products.taxrate, geopos_products.disrate, geopos_products.product_des, geopos_products.unit, geopos_products.pwith, geopos_products.pthickness, geopos_products.pquick, geopos_products.pquick_code');
    $this->db->from('geopos_products');

    // Add joins if necessary
    if ($this->aauth->get_user()->loc || !BDATA) {
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');
    }

    // Add warehouse filter if provided
    if ($wid > 0) {
        $this->db->where('geopos_products.warehouse', $wid);
    }

    // Add location filter based on user's location
    if ($this->aauth->get_user()->loc) {
        $loc = $this->aauth->get_user()->loc;
        if (BDATA) {
            $this->db->group_start(); // Open group for OR condition
            $this->db->where('geopos_warehouse.loc', $loc);
            $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end(); // Close group
        } else {
            $this->db->where('geopos_warehouse.loc', $loc);
        }
    } elseif (!BDATA) {
        $this->db->where('geopos_warehouse.loc', 0);
    }

    // Add search condition for name or product code
    if ($name) {
        $this->db->group_start(); // Open group for OR condition
  
        $this->db->like('UPPER(geopos_products.product_name)', strtoupper($name));
        $this->db->or_like('UPPER(geopos_products.product_code)', strtoupper($name));
        $this->db->or_like('UPPER(geopos_products.pquick_code)', strtoupper($name));

        $this->db->group_end(); // Close group
    }

    // Exclude products with empty pquick_code
    $this->db->where('geopos_products.pquick_code IS NOT NULL');
    $this->db->where('geopos_products.pquick_code <>', '');
    if ($product_quick_code != '') {
        $this->db->where('geopos_products.pquick_code', $product_quick_code);
    }

    // Limit the results to 6
    $this->db->limit(60);

    // Execute the query
    $query = $this->db->get();
    $result = $query->result_array();

    // Prepare the output
    foreach ($result as $row) {
        $name = array(
            $row['product_name'],
            amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc),
            $row['pid'],
            amountFormat_general($row['taxrate']),
            amountFormat_general($row['disrate']),
            $row['product_des'],
            $row['unit'],
            $row['product_code'],
            $row_num,
            $row['pwith'],
            $row['pthickness'],
            $row['pquick'],
            $row['pquick_code'],
            0 // Placeholder for result2 (cubic feet calculation happens in JS)
        );
        array_push($out, $name);
    }

    // Output the result as JSON
    echo json_encode($out);

    }




//search product in invoice
    public function search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(geopos_products.warehouse='$wid') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
$query = $this->db->query("SELECT geopos_products.rate,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit,geopos_products.pwith,geopos_products.pthickness,geopos_products.pquick,geopos_products.pquick_code  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%') LIMIT 6");

            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'],  $row['product_code'], amountFormat_general($row['qty']),$row['pwith'],$row['pthickness'],$row['pquick'],$row['pquick_code'], $row_num);
                array_push($out, $name);
            }
            echo json_encode($out);
        }

    }
    
    
//search product in invoice
    public function search5()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = "tt";//$this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(geopos_products.warehouse='$wid') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_products.rate,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit,geopos_products.pwith,geopos_products.pthickness,geopos_products.pquick,geopos_products.pquick_code  FROM geopos_products $join WHERE " . $qw . "(geopos_products.product_code = 'td' OR geopos_products.product_code = 'tdvpt' OR geopos_products.product_code = 'tvp') LIMIT 6");

            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'],  $row['product_code'], amountFormat_general($row['qty']),$row['pwith'],$row['pthickness'],$row['pquick'],$row['pquick_code'], $row_num);
                array_push($out, $name);
            }
            echo json_encode($out);
        }

    }
    
    
    
    
    

    public function puchase_search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(geopos_products.warehouse='$wid' ) AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_code,geopos_products.fproduct_price,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.unit,geopos_products.pwith,geopos_products.pquick FROM geopos_products $join WHERE " . $qw . "UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%' LIMIT 6");

            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'], $row_num, $row['pwith'], $row['pquick']);
                array_push($out, $name);
            }

            echo json_encode($out);
        }

    }
    
    public function puchase_search2()
{
    $result = array();
    $out = array();
    $row_num = $this->input->post('row_num', true);
    $name = $this->input->post('name_startsWith', true);

    if (strpos($name, ' ') === false) {
        echo json_encode(array());
        exit;
    }
    $name = trim($name);

    $wid = $this->input->post('wid', true);

    // Start building the query
    $this->db->select('geopos_products.pid, geopos_products.product_name, geopos_products.product_code, geopos_products.fproduct_price, geopos_products.taxrate, geopos_products.disrate, geopos_products.product_des, geopos_products.unit, geopos_products.pwith, geopos_products.pthickness, geopos_products.pquick, geopos_products.pquick_code');
    $this->db->from('geopos_products');

    // Add joins if necessary
    if ($this->aauth->get_user()->loc || !BDATA) {
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');
    }

    // Add warehouse filter if provided
    if ($wid > 0) {
        $this->db->where('geopos_products.warehouse', $wid);
    }

    // Add location filter based on user's location
    if ($this->aauth->get_user()->loc) {
        $loc = $this->aauth->get_user()->loc;
        if (BDATA) {
            $this->db->group_start(); // Open group for OR condition
            $this->db->where('geopos_warehouse.loc', $loc);
            $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end(); // Close group
        } else {
            $this->db->where('geopos_warehouse.loc', $loc);
        }
    } elseif (!BDATA) {
        $this->db->where('geopos_warehouse.loc', 0);
    }

    // Add search condition for name or product code
    if ($name) {
        $this->db->group_start(); // Open group for OR condition
       // $this->db->like('UPPER(geopos_products.product_name)', strtoupper($name));
        $this->db->like('UPPER(geopos_products.product_code)', strtoupper($name), 'after');
        $this->db->or_like('UPPER(geopos_products.pquick_code)', strtoupper($name), 'after');
        $this->db->group_end(); // Close group
    }

    // Exclude products with empty pquick_code
    $this->db->where('geopos_products.pquick_code IS NOT NULL');
    $this->db->where('geopos_products.pquick_code <>', '');
    $this->db->where('geopos_products.product_code = geopos_products.pquick_code');

    // Limit the results to 6
    $this->db->limit(20);

    // Execute the query
    $query = $this->db->get();
    $result = $query->result_array();

    // Prepare the output
    foreach ($result as $row) {
        $name = array(
            $row['product_name'],
            amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc),
            $row['pid'],
            amountFormat_general($row['taxrate']),
            amountFormat_general($row['disrate']),
            $row['product_des'],
            $row['unit'],
            $row['product_code'],
            $row_num,
            $row['pwith'],
            $row['pthickness'],
            $row['pquick'],
            $row['pquick_code'],
            0 // Placeholder for result2 (cubic feet calculation happens in JS)
        );
        array_push($out, $name);
    }

    // Output the result as JSON
    echo json_encode($out);
}

    public function csearch()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "','" . amountFormat_general($row['discount_c']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function party_search()
    {
        $result = array();
        $out = array();
        $tbl = 'geopos_customers';
        $name = $this->input->get('keyword', true);

        $ty = $this->input->get('ty', true);
        if ($ty) $tbl = 'geopos_supplier';
        $whr = '';


        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }


        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM $tbl  WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function pos_c_search()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }

        if ($name) {
            $query = $this->db->query("SELECT id,name,phone,discount_c FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"PselectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . amountFormat_general($row['discount_c']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }


    public function supplier()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);

        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM geopos_supplier WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"selectSupplier('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function pos_search()
    {

        $out = '';
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $sub_id = $this->input->post('sub_id', true);
        $qw = '';
        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND ";
        }
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND ";
        }
        if ($sub_id > 0) {
            $qw .= "(geopos_products.sub_id='$sub_id') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse LEFT JOIN geopos_product_cat ON geopos_product_cat.id = geopos_products.pcat';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse LEFT JOIN geopos_product_cat ON geopos_product_cat.id = geopos_products.pcat';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        } else {
            $join = 'LEFT JOIN geopos_product_cat ON geopos_product_cat.id = geopos_products.pcat';
        }
        $bar = '';
        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }

            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
        }
        $query = "SELECT geopos_products.*, geopos_product_cat.title AS category_name, geopos_products.rate FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%')  ORDER BY geopos_products.product_name LIMIT 60";


        $query = $this->db->query($query);
        $result = $query->result_array();
        $i = 0;
        
        $out .= '<div class="row p-1">'; // Add padding wrapper
        
        foreach ($result as $row) {
            $qty = $row['qty'];
            if ($qty >= 10) {
                $badge_class = 'badge-success';
            } elseif ($qty > 0) {
                $badge_class = 'badge-warning';
            } else {
                $badge_class = 'badge-danger';
            }

            $out .= '

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-3 px-2"> <!-- Spacing optimized -->
                <div class="card h-100 border-0 shadow-sm select_pos_item pos-product-card overflow-hidden" 
                     id="posp' . $i . '" 
                     data-name="' . $row['product_name'] . '"  
                     data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  
                     data-rate="' . amountExchange_s($row['rate'], 0, $this->aauth->get_user()->loc) . '"  
                     data-sqft="' . $row['sqft'] . '"  
                     data-tax="' . amountFormat_general($row['taxrate']) . '"  
                     data-discount="' . amountFormat_general($row['disrate']) . '"   
                     data-pcode="' . $row['product_code'] . '"   
                     data-pid="' . $row['pid'] . '"  
                     data-stock="' . amountFormat_general($row['qty']) . '" 
                     data-unit="' . $row['unit'] . '" 
                     data-product_description="' . $row['product_des'] . '" 
                     data-product_pwith="' . $row['pwith'] . '" 
                     data-product_thicknes="' . $row['pthickness'] . '" 
                     data-pquick="' . $row['pquick'] . '" 
                     data-product_quick_code="' . $row['pquick_code']  . '" 
                     data-local_imported="' . $row['local_imported']  . '" 
                     data-group_id="' . $row['sub_id'] . '"
                     style="cursor: pointer; transition: all 0.2s ease-in-out; border-radius: 12px; background: #fff;">
                     
                    <div class="position-relative">
                         <div class="badge ' . $badge_class . ' shadow-sm" style="position: absolute; top: 0px; left: 0px; z-index: 2; font-size: 11px; padding: 4px 8px; border-radius: 20px;">' . number_format($row['qty'], 0) . ' in Stock ';
                         
                         if($row['unit'] == 'Sqft'){
                              $out .= '<br><hr class="m-0 p-0">' . number_format(($row['sqft'] ?? 0) * ($row['qty'] ?? 0), 2) . '  SQFT';
                         } elseif($row['unit'] == 'Feet'){
                              $out .= '<br><hr class="m-0 p-0">' . number_format(($row['product_des'] ?? 0) * ($row['qty'] ?? 0), 2) . ' FT';
                         }
                        
                         $out .= '</div>
                         


                         <div class="badge badge-info shadow-sm" style="position: absolute; bottom: 0px; right: 0px; z-index: 2; font-size: 10px; padding: 4px 8px; border-radius: 20px;">' . number_format($row['qty2'] ?? 0, 2) . ' CF</div>
                         <div style="height: 140px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                             <img src="' . base_url('userfiles/product/' . $row['image']) . '" alt="' . $row['product_name'] . '" style="max-height: 100%; max-width: 100%; object-fit: contain; padding: 15px;">
                         </div>

                         <!-- Action Buttons Overlay -->
                         <div style="position: absolute; top: 8px; right: 8px; display: flex; flex-direction: column; gap: 6px; z-index: 2;">
                            <a target="_blank" href="' . base_url() . 'products/woodcut?id=' . $row['pid'] . '&pcat=' .$row['pcat']. '&pcat_sub_id=' .$row['sub_id']. '" 
                               class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" 
                               style="width: 28px; height: 28px; background: rgba(255,255,255,0.9);" 
                               title="Wood Cuting" onclick="event.stopPropagation();">
                                <i class="icon-pencil text-dark" style="font-size: 12px;"></i>
                            </a>
                            <a target="_blank" href="' . base_url() . 'products/edit?id=' . $row['pid'] . '" 
                               class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" 
                               style="width: 28px; height: 28px; background: rgba(255, 255, 255, 0.9);" 
                               title="Product Editing" onclick="event.stopPropagation();">
                                <i class="icon-settings text-dark" style="font-size: 12px;"></i>
                            </a>
                            <a target="_blank" href="' . base_url() . 'productcategory/edit?id=' . $row['sub_id'] . '" 
                               class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" 
                               style="width: 28px; height: 28px; background: rgba(255, 255, 255, 0.9);" 
                               title="Product Price Editing" onclick="event.stopPropagation();">
                                <i class="icon-settings text-dark" style="font-size: 12px;"></i>
                            </a>
                         </div>
                    </div>

            <div class="card-body p-2 text-center">
    <small class="text-muted d-block text-uppercase font-weight-bold mb-1" style="font-size: 9px; letter-spacing: 0.0px;">' . (!empty($row['category_name']) ? $row['category_name'] : 'Product') . '</small>
    <h6 class="mb-1 text-dark mx-auto" style="font-size: 12px; font-weight: 600; font-family: \'Inter\', sans-serif; line-height: 1.3; height: 32px; overflow: hidden; max-width: 90%;" title="' . $row['product_name'] . '">' . $row['product_name'] . '</h6>
    <div class="d-flex justify-content-center align-items-center">
        <span class="font-weight-bold text-success" style="font-size: 14px;">' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '</span>
        <span class="text-muted ml-2" style="font-size: 10px;">' . $row['unit'] . '</span>
    </div>
</div>

                </div>
            </div>';

            $i++;
        }
        $out .= '</div>'; // Close row

        echo $out;
    }

    public function v2_pos_search()
    {

        $out = '';
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $sub_id = $this->input->post('sub_id', true);
        $qw = '';
        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND ";
        }
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND ";
        }
        if ($sub_id > 0) {
            $qw .= "(geopos_products.sub_id='$sub_id') AND ";
        }
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse LEFT JOIN geopos_product_cat ON geopos_product_cat.id = geopos_products.pcat';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse LEFT JOIN geopos_product_cat ON geopos_product_cat.id = geopos_products.pcat';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        } else {
            $join = 'LEFT JOIN geopos_product_cat ON geopos_product_cat.id = geopos_products.pcat';
        }
        $bar = '';

        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }
            //    echo(substr($barcode, 0, -1));
            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
            //  $query = "SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . " $bar AND (geopos_products.qty>0) LIMIT 16";
        }
        $query = "SELECT geopos_products.*, geopos_product_cat.title AS category_name, geopos_products.rate FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%')  ORDER BY geopos_products.product_name LIMIT 60";

        $query = $this->db->query($query);
        $result = $query->result_array();
        $i = 0;
        
        $out .= '<div class="row p-1">'; // Add padding wrapper
        
        foreach ($result as $row) {
            $qty = $row['qty'];
            if ($qty >= 10) {
                $badge_class = 'badge-success';
            } elseif ($qty > 0) {
                $badge_class = 'badge-warning';
            } else {
                $badge_class = 'badge-danger';
            }

            $out .= '
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-3 px-2"> <!-- Spacing optimized -->
                <div class="card h-100 border-0 shadow-sm select_pos_item pos-product-card overflow-hidden" 
                     id="posp' . $i . '" 
                     data-name="' . $row['product_name'] . '"  
                     data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  
                     data-rate="' . amountExchange_s($row['rate'], 0, $this->aauth->get_user()->loc) . '"  
                     data-sqft="' . $row['sqft'] . '"  
                     data-tax="' . amountFormat_general($row['taxrate']) . '"  
                     data-discount="' . amountFormat_general($row['disrate']) . '"   
                     data-pcode="' . $row['product_code'] . '"   
                     data-pid="' . $row['pid'] . '"  
                     data-stock="' . amountFormat_general($row['qty']) . '" 
                     data-unit="' . $row['unit'] . '" 
                     data-product_description="' . $row['product_des'] . '" 
                     data-product_pwith="' . $row['pwith'] . '" 
                     data-product_thicknes="' . $row['pthickness'] . '" 
                     data-pquick="' . $row['pquick'] . '" 
                     data-product_quick_code="' . $row['pquick_code']  . '" 
                     data-local_imported="' . $row['local_imported']  . '" 
                     data-group_id="' . $row['sub_id'] . '"
                     style="cursor: pointer; transition: all 0.2s ease-in-out; border-radius: 12px; background: #fff;">
                     
                    <div class="position-relative">
                         <div class="badge ' . $badge_class . ' shadow-sm" style="position: absolute; top: 10px; left: 10px; z-index: 2; font-size: 10px; padding: 4px 8px; border-radius: 20px;">' . number_format($row['qty'], 0) . ' in Stock</div>
                         <div class="badge badge-info shadow-sm" style="position: absolute; bottom: 28px; right: 5px; z-index: 2; font-size: 10px; padding: 4px 8px; border-radius: 20px;">' . number_format($row['qty2'] ?? 0, 2) . ' CFT</div>
                         <div class="badge badge-primary shadow-sm" style="position: absolute; bottom: 5px; right: 5px; z-index: 2; font-size: 10px; padding: 4px 8px; border-radius: 20px;">' . number_format($row['sqft'] * $row['qty'] ?? 0, 2) . ' SQFT</div>
                         
                         <div style="height: 140px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                             <img src="' . base_url('userfiles/product/' . $row['image']) . '" alt="' . $row['product_name'] . '" style="max-height: 100%; max-width: 100%; object-fit: contain; padding: 15px;">
                         </div>

                         <!-- Action Buttons Overlay -->
                         <div style="position: absolute; top: 8px; right: 8px; display: flex; flex-direction: column; gap: 6px; z-index: 2;">
                            <a target="_blank" href="' . base_url() . 'products/woodcut?id=' . $row['pid'] . '&pcat=' .$row['pcat']. '&pcat_sub_id=' .$row['sub_id']. '" 
                               class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" 
                               style="width: 28px; height: 28px; background: rgba(255,255,255,0.9);" 
                               title="Wood Cut" onclick="event.stopPropagation();">
                                <i class="icon-pencil text-dark" style="font-size: 12px;"></i>
                            </a>
                            <a target="_blank" href="' . base_url() . 'products/edit?id=' . $row['pid'] . '" 
                               class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" 
                               style="width: 28px; height: 28px; background: rgba(255, 255, 255, 0.9);" 
                               title="Product Edit" onclick="event.stopPropagation();">
                                <i class="icon-settings text-dark" style="font-size: 12px;"></i>
                            </a>
                            <a target="_blank" href="' . base_url() . 'productcategory/edit?id=' . $row['sub_id'] . '" 
                               class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" 
                               style="width: 28px; height: 28px; background: rgba(255, 255, 255, 0.9);" 
                               title="Product Price Edit" onclick="event.stopPropagation();">
                                <i class="icon-settings text-dark" style="font-size: 12px;"></i>
                            </a>
                         </div>
                    </div>

                    <div class="card-body p-2 text-left">
                        <small class="text-muted d-block text-uppercase font-weight-bold mb-1" style="font-size: 9px; letter-spacing: 0.5px;">' . (!empty($row['category_name']) ? $row['category_name'] : 'Product') . '</small>
                        <h6 class="mb-1 text-dark" style="font-size: 12px; font-weight: 600; font-family: \'Inter\', sans-serif; line-height: 1.3; height: 32px; overflow: hidden;" title="' . $row['product_name'] . '">' . $row['product_name'] . '</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold text-success" style="font-size: 14px;">' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '</span>
                            <span class="text-muted" style="font-size: 10px;">' . $row['unit'] . '</span>
                        </div>
                    </div>

                </div>
            </div>';

            $i++;
        }
        $out .= '</div>'; // Close row

        echo $out;
    }

    public function get_sub_categories()
    {
        $this->load->model('categories_model');
        $wid = $this->input->post('id');
        $result = $this->categories_model->category_list(1, $wid);
        echo '<option value="0">' . $this->lang->line('All') . '</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
        }
    }
}
