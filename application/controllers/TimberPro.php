<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TimberPro extends CI_Controller
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
        $this->load->model('TimberPro_model', 'timberpro');
        $this->load->model('TimberPro_AI_model', 'timberpro_ai');
        $this->load->model('categories_model');
        $this->load->model('accounts_model');
        $this->load->model('transactions_model', 'transactions');
        $this->load->library("Custom");
        $this->li_a = 'stock';
        
        // Load PhpSpreadsheet via third_party vendor
        require_once APPPATH . 'third_party/vendor/autoload.php';
    }

    public function index()
    {
        $head['title'] = "TimberPro Dashboard";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $data['stats'] = $this->timberpro->get_dashboard_stats($this->aauth->get_user()->loc);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/index', $data);
        $this->load->view('fixed/footer');
    }

    public function input()
    {
        $data['cat'] = $this->categories_model->category_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        
        $head['title'] = "Timber Input";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/input', $data);
        $this->load->view('fixed/footer');
    }

    public function save_standing()
    {
        $lot_name = $this->input->post('lot_name');
        $warehouse_id = $this->input->post('warehouse_id');
        $location_gps = $this->input->post('location_gps');
        $district = $this->input->post('district');
        $items = $this->input->post('items'); 
        $selling_price = $this->input->post('selling_price');
        $total_price = $this->input->post('total_price');

        $status = ($this->input->post('broadcast_mode') == 'pending') ? 'broadcast_pending' : 'available';
        $result = $this->timberpro->save_standing($lot_name, $warehouse_id, $location_gps, $items, $status, array(), null, $selling_price, $total_price, $district);
        if ($result['status'] == 'Success') {
            $this->_save_photos($result['lot_id'], 'standing');
            if ($status == 'available') {
                $this->load->model('Marketing_model', 'marketing');
                $this->marketing->broadcast_lot($result['lot_id'], 'standing');
            }
        }
        echo json_encode($result);
    }

    public function save_logs()
    {
        $lot_name = $this->input->post('lot_name');
        $warehouse_id = $this->input->post('warehouse_id');
        $location_gps = $this->input->post('location_gps');
        $district = $this->input->post('district');
        $logs = $this->input->post('logs'); // Array of items
        $selling_price = $this->input->post('selling_price');
        $total_price = $this->input->post('total_price');

        $status = ($this->input->post('broadcast_mode') == 'pending') ? 'broadcast_pending' : 'available';
        $result = $this->timberpro->save_logs($lot_name, $warehouse_id, $logs, $location_gps, $status, array(), null, $selling_price, $total_price, $district);
        if ($result['status'] == 'Success') {
            $this->_save_photos($result['lot_id'], 'logs');
            if ($status == 'available') {
                $this->load->model('Marketing_model', 'marketing');
                $this->marketing->broadcast_lot($result['lot_id'], 'logs');
            }
        }
        echo json_encode($result);
    }

    public function save_sawn()
    {
        $lot_name = $this->input->post('lot_name');
        $warehouse_id = $this->input->post('warehouse_id');
        $location_gps = $this->input->post('location_gps');
        $district = $this->input->post('district');
        $items = $this->input->post('items');
        $unit_type = $this->input->post('unit_type');
        $selling_price = $this->input->post('selling_price');
        $total_price = $this->input->post('total_price');

        $status = ($this->input->post('broadcast_mode') == 'pending') ? 'broadcast_pending' : 'available';
        $result = $this->timberpro->save_sawn($lot_name, $warehouse_id, $location_gps, $items, $status, array(), null, $unit_type, $selling_price, $total_price, $district);
        if ($result['status'] == 'Success') {
            $this->_save_photos($result['lot_id'], 'sawn');
            if ($status == 'available') {
                $this->load->model('Marketing_model', 'marketing');
                $this->marketing->broadcast_lot($result['lot_id'], 'sawn');
            }
        }
        echo json_encode($result);
    }

    public function save_machinery()
    {
        $item_name = $this->input->post('item_name');
        $specs = $this->input->post('specs');
        $warehouse_id = $this->input->post('warehouse_id');
        $location_gps = $this->input->post('location_gps');
        $district = $this->input->post('district');
        $qty = $this->input->post('qty');
        $selling_price = $this->input->post('selling_price');
        $total_price = $this->input->post('total_price');

        $status = ($this->input->post('broadcast_mode') == 'pending') ? 'broadcast_pending' : 'available';
        $result = $this->timberpro->save_machinery($item_name, $specs, $warehouse_id, $location_gps, $status, array(), null, $qty, $selling_price, $total_price, $district);
        if ($result['status'] == 'Success') {
            $this->_save_photos($result['lot_id'], 'machinery');
            if ($status == 'available') {
                $this->load->model('Marketing_model', 'marketing');
                $this->marketing->broadcast_lot($result['lot_id'], 'machinery');
            }
        }
        echo json_encode($result);
    }

    private function _save_photos($lot_id, $lot_type)
    {
        error_log("Attempting to save photos for $lot_type ID: $lot_id");
        
        if (!empty($_FILES['photos']['name'][0])) {
            $filesCount = count($_FILES['photos']['name']);
            error_log("Found $filesCount photos to upload.");
            
            $uploaded_photos = array();
            
            // Load library once
            $config['upload_path']   = './userfiles/timber/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 10240; // 10MB
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->load->library('upload', $config);

            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['single_file']['name']     = $_FILES['photos']['name'][$i];
                $_FILES['single_file']['type']     = $_FILES['photos']['type'][$i];
                $_FILES['single_file']['tmp_name'] = $_FILES['photos']['tmp_name'][$i];
                $_FILES['single_file']['error']    = $_FILES['photos']['error'][$i];
                $_FILES['single_file']['size']     = $_FILES['photos']['size'][$i];

                $file_config = array();
                $file_config['upload_path'] = './userfiles/timber/';
                $file_config['allowed_types'] = 'gif|jpg|png|jpeg';
                $file_config['file_name'] = $lot_type . '_' . $lot_id . '_' . uniqid();
                
                $this->upload->initialize($file_config);

                if ($this->upload->do_upload('single_file')) {
                    $fileData = $this->upload->data();
                    $uploaded_photos[] = $fileData['file_name'];
                    error_log("Uploaded: " . $fileData['file_name']);
                } else {
                    error_log("Upload Error for file $i: " . $this->upload->display_errors());
                }
            }

            if (!empty($uploaded_photos)) {
                error_log("Saving " . count($uploaded_photos) . " photos to DB.");
                $this->timberpro->save_photos($lot_id, $lot_type, $uploaded_photos);
            } else {
                error_log("No photos were successfully uploaded.");
            }
        } else {
            error_log("No files found in _FILES['photos']['name'][0]");
        }
    }

    public function ocr_scan()
    {
        $config['upload_path']   = './userfiles/temp/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 10000;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('log_photo')) {
            echo json_encode(array('status' => 'Error', 'message' => $this->upload->display_errors()));
        } else {
            $data = $this->upload->data();
            $result = $this->timberpro_ai->scan_log_dimensions($data['full_path']);
            unlink($data['full_path']); // Cleanup
            echo json_encode($result);
        }
    }

    public function export_excel($id, $type = 'logs')
    {
        // Use PhpSpreadsheet to generate a permit
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'GOVERNMENT TRANSIT PERMIT (OFFICIAL)');
        $sheet->setCellValue('A3', 'Lot ID: ' . $id);
        
        if ($type == 'logs') {
            $log = $this->timberpro->get_log_details($id);
            $sheet->setCellValue('A4', 'Lot Name: ' . $log['header']['lot_name']);
            $sheet->setCellValue('A5', 'Total CF: ' . $log['header']['total_cubic_feet']);
            
            $i = 7;
            $sheet->setCellValue('A' . $i, '#');
            $sheet->setCellValue('B' . $i, 'Length (ft)');
            $sheet->setCellValue('C' . $i, 'Girth (in)');
            $sheet->setCellValue('D' . $i, 'Cubic Feet');
            
            foreach ($log['items'] as $index => $item) {
                $i++;
                $sheet->setCellValue('A' . $i, $index + 1);
                $sheet->setCellValue('B' . $i, $item['length']);
                $sheet->setCellValue('C' . $i, $item['girth']);
                $sheet->setCellValue('D' . $i, $item['cubic_feet']);
            }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $filename = "permit_" . $id . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

    public function financial_settings()
    {
        $head['title'] = "TimberPro Financial Settings";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $this->db->where('id', 70);
        $data['config'] = $this->db->get('univarsal_api')->row_array();
        $data['accounts'] = $this->accounts_model->accountslist();

        $this->load->view('fixed/header', $head);
        $this->load->view('timber/financial_settings', $data);
        $this->load->view('fixed/footer');
    }

    public function save_financials()
    {
        $inventory_acc = $this->input->post('inventory_acc');
        $purchase_acc = $this->input->post('purchase_acc');
        
        $data = array(
            'key1' => 'timberpro_financials',
            'key2' => $inventory_acc,
            'url' => $purchase_acc
        );

        $this->db->where('id', 70);
        if ($this->db->update('univarsal_api', $data)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Settings updated successfully.'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to update settings.'));
        }
    }

    public function bulk_upload()
    {
        if ($this->input->post()) {
            $type = $this->input->post('type'); // logs or sawn
            $warehouse_id = $this->input->post('warehouse_id');
            $lot_name = $this->input->post('lot_name');
            $loc = $this->input->post('loc') ?: $this->aauth->get_user()->loc;

            $config['upload_path'] = './userfiles/temp/';
            $config['allowed_types'] = 'csv|xlsx|xls';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                echo json_encode(array('status' => 'Error', 'message' => $this->upload->display_errors()));
            } else {
                $data = $this->upload->data();
                $inputFileName = $data['full_path'];
                
                try {
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();
                    
                    $items = array();
                    // Skip header
                    for ($i = 1; $i < count($rows); $i++) {
                        if (empty($rows[$i][0])) continue;
                        
                        if ($type == 'logs') {
                            $items[] = array(
                                'length' => (float)$rows[$i][0],
                                'girth' => (float)$rows[$i][1]
                            );
                        } else {
                            $items[] = array(
                                'wood_type_id' => (int)$rows[$i][0],
                                'width' => (float)$rows[$i][1],
                                'thickness' => (float)$rows[$i][2],
                                'length' => (float)$rows[$i][3],
                                'quantity' => (int)$rows[$i][4]
                            );
                        }
                    }

                    if ($type == 'logs') {
                        $result = $this->timberpro->bulk_save_logs($lot_name, $warehouse_id, $items, null, $loc);
                    } else {
                        $result = $this->timberpro->bulk_save_sawn($lot_name, $warehouse_id, $items, null, $loc);
                    }

                    unlink($inputFileName);
                    echo json_encode($result);
                } catch (Exception $e) {
                    echo json_encode(array('status' => 'Error', 'message' => $e->getMessage()));
                }
            }
        } else {
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Bulk Upload - TimberPro";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('timber/bulk_upload', $data);
            $this->load->view('fixed/footer');
        }
    }
}
