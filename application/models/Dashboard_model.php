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

class Dashboard_model extends CI_Model
{
    
    public function todayInvoice($today, $loc = 0)
    {
        $where = "DATE(invoicedate) ='$today'";
        $this->db->where($where);
        $this->db->from('geopos_invoices');
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
            // Show all
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        return $this->db->count_all_results();
    }

    public function todaySales($today, $loc = 0)
    {
        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where($where);
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
            // Show all
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function todayInexp($today, $loc = 0)
    {
        $this->db->select_sum('debit');
        $this->db->select_sum('credit');
        $this->db->where("DATE(date) ='$today'");
        $this->db->where("type!='Transfer'");
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
             // Show all - no filter
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->from('geopos_transactions');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recent_payments($loc = 0)
    {
        $this->db->limit(13);
        $this->db->order_by('id', 'DESC');
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
            // Show all
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->from('geopos_transactions');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function stock($loc = 0)
    {
        $query = $this->db->query("SELECT * FROM geopos_products WHERE qty<=alert ORDER BY product_name ASC");
        return $query->result_array();
    }

    public function stock1()
    {
        $whr = '';
                if ($this->aauth->get_user()->loc) {
         $whr = ' AND (geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
         $whr = ' AND (geopos_warehouse.loc=0)';
        }

        $query = $this->db->query("SELECT geopos_products.*,geopos_warehouse.title FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id  WHERE (geopos_products.qty<geopos_products.alert and geopos_products.unit='Sqft') $whr ORDER BY geopos_products.product_name ASC LIMIT 100");
        
        return $query->result_array();
    }


    public function stock2()
    {
        $whr = '';
                if ($this->aauth->get_user()->loc) {
         $whr = ' AND (geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
         $whr = ' AND (geopos_warehouse.loc=0)';
        }

        $query = $this->db->query("SELECT geopos_products.*,geopos_warehouse.title FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id  WHERE (geopos_products.qty<geopos_products.alert and geopos_products.unit='Qbic') $whr ORDER BY geopos_products.product_name ASC LIMIT 100");
        
        return $query->result_array();
    }




    public function todayItems($today)
    {
        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('items');
        $this->db->from('geopos_invoices');
              if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->items;
    }

    public function todayProfit($today, $loc = 0)
    {
        $where = "DATE(geopos_metadata.d_date) ='$today'";
        $this->db->select_sum('geopos_metadata.col1');
        $this->db->from('geopos_metadata');
        $this->db->join('geopos_invoices', 'geopos_metadata.rid=geopos_invoices.id', 'left');
        $this->db->where($where);
        $this->db->where('geopos_metadata.type', 9);
        if ($loc > 0) {
            $this->db->where('geopos_invoices.loc', $loc);
        } elseif ($loc == -1) {
            // Show all
        } elseif (!BDATA) {
            $this->db->where('geopos_invoices.loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->col1 ?? 0;
    }

    public function incomeChart($today, $month, $year, $loc = 0)
    {
        $whr = '';
        if ($loc > 0) {
            $whr = ' AND (loc=' . $loc . ')';
        } elseif ($loc == -1) {
            $whr = '';
        } elseif ($this->aauth->get_user()->loc) {
            $whr = ' AND (loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
            $whr = ' AND (loc=0)';
        }
        $query = $this->db->query("SELECT SUM(credit) AS total,date FROM geopos_transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND '$today') AND type='Income')  $whr GROUP BY date ORDER BY date DESC");
        return $query->result_array();
    }

    public function expenseChart($today, $month, $year, $loc = 0)
    {
        $whr = '';
        if ($loc > 0) {
            $whr = ' AND (loc=' . $loc . ')';
        } elseif ($loc == -1) {
             $whr = '';
        } elseif ($this->aauth->get_user()->loc) {
            $whr = ' AND (loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
            $whr = ' AND (loc=0)';
        }
        $query = $this->db->query("SELECT SUM(debit) AS total,date FROM geopos_transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND '$today') AND type='Expense')  $whr GROUP BY date ORDER BY date DESC");
        return $query->result_array();
    }

    public function countmonthlyChart($loc = 0)
    {
        $today = date('Y-m-d');
        $whr = '';
        if ($loc > 0) {
            $whr = ' AND (loc=' . $loc . ')';
        } elseif ($loc == -1) {
            $whr = '';
        } elseif ($this->aauth->get_user()->loc) {
            $whr = ' AND (loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
            $whr = ' AND (loc=0)';
        }
        $query = $this->db->query("SELECT COUNT(id) AS ttlid,SUM(total) AS total,DATE(invoicedate) as date FROM geopos_invoices WHERE (DATE(invoicedate) BETWEEN '$today' - INTERVAL 30 DAY AND '$today')  $whr GROUP BY DATE(invoicedate) ORDER BY date DESC");
        return $query->result_array();
    }


    public function monthlyInvoice($month, $year, $loc = 0)
    {
        $where = "DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->where($where);
        $this->db->from('geopos_invoices');
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
             // Show all
        } elseif ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        return $this->db->count_all_results();
    }

    public function monthlySales($month, $year, $loc = 0)
    {
        $where = "DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where($where);
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
            // Show all
        } elseif ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->total;
    }


    public function recentInvoices($loc = 0)
    {
        $whr = '';
        if ($loc > 0) {
            $whr = ' WHERE (i.loc=' . $loc . ') ';
        } elseif ($loc == -1) {
             $whr = '';
        } elseif ($this->aauth->get_user()->loc) {
            $whr = ' WHERE (i.loc=' . $this->aauth->get_user()->loc . ') ';
        } elseif (!BDATA) {
            $whr = ' WHERE (i.loc=0) ';
        }
        $query = $this->db->query("SELECT i.id,i.tid,i.invoicedate,i.total,i.status,i.i_class,c.name,c.picture,i.csd FROM geopos_invoices AS i LEFT JOIN geopos_customers AS c ON i.csd=c.id $whr ORDER BY i.id DESC LIMIT 10");
        return $query->result_array();

    }

    public function todayNewCustomers($today, $loc = 0)
    {
        $this->db->where("DATE(reg_date) ='$today'");
        if ($loc) {
            $this->db->where('loc', $loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->from('geopos_customers');
        return $this->db->count_all_results();
    }

    // === DATE RANGE METHODS FOR FLEXIBLE FILTERING ===
    
    public function rangeInvoice($start_date, $end_date, $loc = 0)
    {
        $this->db->where("DATE(invoicedate) BETWEEN '$start_date' AND '$end_date'");
        $this->db->from('geopos_invoices');
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
            // Show all
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        return $this->db->count_all_results();
    }

    public function rangeSales($start_date, $end_date, $loc = 0)
    {
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where("DATE(invoicedate) BETWEEN '$start_date' AND '$end_date'");
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
             // Show all
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->total ?? 0;
    }

    public function rangeInexp($start_date, $end_date, $loc = 0)
    {
        $this->db->select_sum('debit');
        $this->db->select_sum('credit');
        $this->db->where("DATE(date) BETWEEN '$start_date' AND '$end_date'");
        $this->db->where("type!='Transfer'");
        // Exclude Dual Entry Contra Transactions (Expense on Sales, Income on Purchase)
        $this->db->where("NOT (type='Expense' AND cat='Sales')");
        $this->db->where("NOT (type='Income' AND cat='Purchase')");
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
             // Show all
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->from('geopos_transactions');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function rangeProfit($start_date, $end_date, $loc = 0)
    {
        $this->db->select_sum('geopos_metadata.col1');
        $this->db->from('geopos_metadata');
        $this->db->join('geopos_invoices', 'geopos_metadata.rid=geopos_invoices.id', 'left');
        $this->db->where("DATE(geopos_metadata.d_date) BETWEEN '$start_date' AND '$end_date'");
        $this->db->where('geopos_metadata.type', 9);
        if ($loc > 0) {
            $this->db->where('geopos_invoices.loc', $loc);
        } elseif ($loc == -1) {
            // Show all
        } elseif (!BDATA) {
            $this->db->where('geopos_invoices.loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->col1 ?? 0;
    }

    public function rangeNewCustomers($start_date, $end_date, $loc = 0)
    {
        $this->db->where("DATE(reg_date) BETWEEN '$start_date' AND '$end_date'");
        if ($loc > 0) {
            $this->db->where('loc', $loc);
        } elseif ($loc == -1) {
             // Show all
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->from('geopos_customers');
        return $this->db->count_all_results();
    }

    public function recentBuyers($loc = 0)
    {
        $this->db->trans_start();
        $whr = '';
        if ($loc > 0) {
            $whr = ' WHERE (i.loc=' . $loc . ') ';
        } elseif ($loc == -1) {
            $whr = '';
        } elseif (!BDATA) {
            $whr = ' WHERE (i.loc=0) ';
        }
        $query = $this->db->query("SELECT MAX(i.id) AS iid,i.csd,SUM(i.total) AS total, c.cid,MAX(c.picture) as picture ,MAX(c.name) as name,MAX(i.status) as status FROM geopos_invoices AS i LEFT JOIN (SELECT geopos_customers.id AS cid, geopos_customers.picture AS picture, geopos_customers.name AS name FROM geopos_customers) AS c ON c.cid=i.csd $whr GROUP BY i.csd ORDER BY iid DESC LIMIT 10;");
        $result = $query->result_array();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return 'sql';
        } else {
            return $result;
        }

    }

    public function tasks($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_todolist');
        $this->db->where('eid', $id);
        $this->db->limit(10);
        $this->db->order_by('DATE(duedate)', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function clockin($id)
    {
        $this->db->select('clock');
        $this->db->where('id', $id);
        $this->db->from('geopos_employees');
        $query = $this->db->get();
        $emp = $query->row_array();
        if (!$emp['clock']) {
            $data = array(
                'clock' => 1,
                'clockin' => time(),
                'clockout' => 0
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('geopos_employees');
            $this->aauth->applog("[Employee ClockIn]  ID $id", $this->aauth->get_user()->username);
        }
        return true;
    }

    public function clockout($id)
    {

        $this->db->select('clock,clockin');
        $this->db->where('id', $id);
        $this->db->from('geopos_employees');
        $query = $this->db->get();
        $emp = $query->row_array();

        if ($emp['clock']) {

            $data = array(
                'clock' => 0,
                'clockin' => 0,
                'clockout' => time()
            );

            $total_time = time() - $emp['clockin'];


            $this->db->set($data);
            $this->db->where('id', $id);

            $this->db->update('geopos_employees');
            $this->aauth->applog("[Employee ClockOut]  ID $id", $this->aauth->get_user()->username);

            $today = date('Y-m-d');

            $this->db->select('id,adate');
            $this->db->where('emp', $id);
            $this->db->where('DATE(adate)', date('Y-m-d'));
            $this->db->from('geopos_attendance');
            $query = $this->db->get();
            $edate = $query->row_array();
            if ($edate['adate']) {


                $this->db->set('actual_hours', "actual_hours+$total_time", FALSE);
                $this->db->set('tto', date('H:i:s'));
                $this->db->where('id', $edate['id']);
                $this->db->update('geopos_attendance');


            } else {
                $data = array(
                    'emp' => $id,
                    'adate' => date('Y-m-d'),
                    'tfrom' => gmdate("H:i:s", $emp['clockin']),
                    'tto' => date('H:i:s'),
                    'note' => 'Self Attendance',
                    'actual_hours' => $total_time
                );


                $this->db->insert('geopos_attendance', $data);
            }

        }
        return true;
    }


}
