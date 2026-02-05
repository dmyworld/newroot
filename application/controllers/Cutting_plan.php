<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cutting_plan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['title'] = "Cutting Plans History";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $this->db->select('cp.*, b.name as batch_name');
        $this->db->from('geopos_cutting_plans cp');
        $this->db->join('geopos_production_batches b', 'cp.batch_id = b.id', 'left');
        $this->db->order_by('cp.id', 'DESC');
        $this->db->limit(50);
        $data['plans'] = $this->db->get()->result_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('cutting_plan/index', $data); // We need to create this view
        $this->load->view('fixed/footer');
    }


    public function create()
    {
        if ($this->input->post()) {
            // Input: Raw Log Dimensions
            $raw_length = floatval($this->input->post('raw_l'));
            $raw_width = floatval($this->input->post('raw_w'));
            $raw_height = floatval($this->input->post('raw_h'));
            
            // Input: Arrays for Targets (Cut List)
            $t_lengths = $this->input->post('target_l'); // Array
            $t_widths = $this->input->post('target_w'); // Array
            $t_heights = $this->input->post('target_h'); // Array
            $t_qties = $this->input->post('target_qty'); // Array
            
            $batch_id = $this->input->post('batch_id');

            // Validation basics
            if ($raw_length <= 0) { // Main constraint is length usually for linear cutting
                 echo json_encode(array('status' => 'Error', 'message' => 'Invalid Raw Dimensions'));
                 return;
            }

            // --- ALGORITHM PREP ---
            // Flatten the request into a list of single pieces needed
            // For 1D Bin Packing (Length optimization), we assume W & H must fit within Raw W/H.
            // If Raw W/H < Target W/H, it's impossible.
            
            $pieces_to_cut = array();
            $impossible = false;

            for($i=0; $i<count($t_lengths); $i++) {
                $l = floatval($t_lengths[$i]);
                $w = floatval($t_widths[$i]);
                $h = floatval($t_heights[$i]);
                $qty = intval($t_qties[$i]);
                
                if($l > $raw_length || $w > $raw_width || $h > $raw_height) {
                    $impossible = true; break;
                }
                
                for($q=0; $q<$qty; $q++) {
                    $pieces_to_cut[] = array('l'=>$l, 'w'=>$w, 'h'=>$h, 'index'=>$i);
                }
            }
            
            if($impossible) {
                echo json_encode(array('status' => 'Error', 'message' => 'One or more pieces are larger than raw material!'));
                return;
            }
            
            // --- 1D BIN PACKING (Best Fit Decreasing) ---
            // 1. Sort pieces DESC by Length
            usort($pieces_to_cut, function($a, $b) {
                return $b['l'] <=> $a['l'];
            });

            $logs = array(); // Array of logs, each has 'remaining_len' and 'cuts' array
            $total_raw_vol = 0;
            $items_vol = 0;

            foreach($pieces_to_cut as $piece) {
                $placed = false;
                $items_vol += ($piece['l'] * $piece['w'] * $piece['h']);

                // Try to find a log that fits this piece
                foreach($logs as &$log) {
                    if($log['remaining_len'] >= $piece['l']) {
                        $log['remaining_len'] -= $piece['l'];
                        $log['cuts'][] = $piece; // Track what's cut
                        $placed = true;
                        break;
                    }
                }
                
                // If not placed, start a new log
                if(!$placed) {
                    $logs[] = array(
                        'remaining_len' => $raw_length - $piece['l'],
                        'cuts' => array($piece)
                    );
                }
            }

            $total_logs = count($logs);
            $total_raw_vol = $total_logs * ($raw_length * $raw_width * $raw_height);
            $waste_vol = $total_raw_vol - $items_vol;
            $waste_percentage = ($total_raw_vol > 0) ? ($waste_vol / $total_raw_vol) * 100 : 0;
            
            // --- SAVE TO DB ---
            $data = array(
                'batch_id' => $batch_id ? $batch_id : NULL,
                'raw_timber_dim' => "$raw_length x $raw_width x $raw_height",
                'plank_dim' => "Multiple (See Details)", // Changed from static
                'planks_count' => count($pieces_to_cut),
                'waste_percentage' => number_format($waste_percentage, 2),
                'total_logs_used' => $total_logs
            );
            $this->db->insert('geopos_cutting_plans', $data);
            $plan_id = $this->db->insert_id();

            // Save Items
            for($i=0; $i<count($t_lengths); $i++) {
                 if(intval($t_qties[$i]) > 0) {
                     $this->db->insert('geopos_cutting_plan_items', array(
                         'plan_id' => $plan_id,
                         'target_length' => $t_lengths[$i],
                         'target_width' => $t_widths[$i],
                         'target_height' => $t_heights[$i],
                         'quantity_required' => $t_qties[$i]
                     ));
                 }
            }

            // Determine Result String (Logs details) (Simplified for JSON response)
            $log_details = "";
            foreach($logs as $k => $log) {
                $log_num = $k + 1;
                $cuts_count = count($log['cuts']);
                $log_details .= "Log #$log_num: Cut $cuts_count pieces. Rem: " . $log['remaining_len'] . "in.<br>";
            }

            if ($plan_id) {
                echo json_encode(array(
                    'status' => 'Success', 
                    'message' => 'Optimization Complete',
                    'result' => array(
                        'planks' => count($pieces_to_cut),
                        'waste' => number_format($waste_percentage, 2) . '%',
                        'raw_vol' => number_format($total_raw_vol, 2) . ' in3',
                        'used_vol' => number_format($items_vol, 2) . ' in3',
                        'logs_needed' => $total_logs,
                        'details' => $log_details
                    )
                ));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error Saving Plan'));
            }

        } else {
            $head['title'] = "Cutting Plan Generator";
            $head['usernm'] = $this->aauth->get_user()->username;
            
            // Fetch batches for dropdown
            $this->load->model('production_schedule_model');
            $data['batches'] = $this->production_schedule_model->get_pending_batches();

            $this->load->view('fixed/header', $head);
            $this->load->view('cutting_plan/create', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function print_plan()
    {
        $id = $this->input->get('id');
        // Fetch Plan (Join with Batch for info)
        $this->db->select('cp.*, b.name as batch_name, b.priority');
        $this->db->from('geopos_cutting_plans cp');
        $this->db->join('geopos_production_batches b', 'cp.batch_id = b.id', 'left');
        $this->db->where('cp.id', $id);
        $data['plan'] = $this->db->get()->row_array();

        if ($data['plan']) {
            $this->load->view('cutting_plan/print', $data);
        } else {
            echo "Plan not found.";
        }
    }
}

