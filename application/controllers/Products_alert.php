<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_alert extends CI_Controller
{
    private $alert_thresholds = [
        'critical' => 10,
        'warning' => 20,
        'info' => 30
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('url');
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->model('Products_model_alert', 'products_alert');
        $this->load->model('categories_model');
        $this->li_a = 'stock';
    }

    public function manage_alert2()
    {
        // Load initial data
        $warehouses = $this->categories_model->warehouse_list();
        $data['warehouse'] = $warehouses;
        $data['categories'] = $this->categories_model->category_list();

        // Get alert statistics
        $data['stats'] = $this->products_alert->get_alert_statistics();

        // Get low stock alerts (for dashboard cards)
        $data['critical_alerts'] = $this->products_alert->get_low_stock_alerts('critical', 5);
        $data['warning_alerts'] = $this->products_alert->get_low_stock_alerts('warning', 5);

        // Use the same warehouse list for filter
        $data['warehouses'] = $warehouses;
        
        // Load units for filter
        $this->load->model('units_model');
        $data['units'] = $this->units_model->units_list();

        $head['title'] = "Manage Stock Alerts";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/manage_alert2', $data);
        $this->load->view('fixed/footer');
    }

    public function manage_alert_ajax_list()
    {
        // Get filter parameters
        $start = $this->input->post('start', true) ?: 0;
        $length = $this->input->post('length', true) ?: 100; // 100 items per page
        $draw = $this->input->post('draw', true) ?: 1;
        
        $search = $this->input->post('search')['value'] ?? '';
        $warehouse = $this->input->post('warehouse', true);
        $category = $this->input->post('category', true);
        $subcategory = $this->input->post('subcategory', true);
        $alert_level = $this->input->post('alert_level', true);
        $minus_qty = $this->input->post('minus_qty', true);
        $unit = $this->input->post('unit', true);
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        
        $recordsTotal = $this->products_alert->count_all_alerts();
        $recordsFiltered = $this->products_alert->count_filtered_alerts($search, $warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit, $start_date, $end_date);
        
        $list = $this->products_alert->get_alert_datatables($start, $length, $search, $warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit, $start_date, $end_date);
        
        $data = array();
        foreach ($list as $product) {
            // Calculate alert level
            $alert_level = $this->calculate_alert_level($product['qty'], $product['alert']);
            
            $row = array();
            $row['pid'] = (int)$product['pid'];
            $row['product_name'] = $product['product_name'];
            $row['product_code'] = $product['product_code'] ?? '';
            $row['warehouse'] = $product['warehouse_name'] ?? 'N/A';
            $row['category'] = $product['category_name'] ?? 'N/A';
            $row['subcategory'] = $product['subcategory_name'] ?? 'N/A';
            $row['current_qty'] = (float)$product['qty'];
            $row['alert_qty'] = (float)$product['alert'];
            $row['difference'] = (float)$product['qty'] - (float)$product['alert'];
            $row['alert_level'] = $alert_level;
            $row['status'] = $this->get_status_html($alert_level, $product['qty'], $product['alert']);
            $row['actions'] = $this->get_action_buttons($product['pid'], $product['pcat'], $product['sub_id']);
            
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

    public function get_alert_statistics()
    {
        $warehouse = $this->input->post('warehouse', true);
        $category = $this->input->post('category', true);
        $subcategory = $this->input->post('subcategory', true);
        $alert_level = $this->input->post('alert_level', true);
        $minus_qty = $this->input->post('minus_qty', true);
        $unit = $this->input->post('unit', true);

        $data = $this->products_alert->get_alert_statistics($warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit);
        echo json_encode($data);
    }

    public function get_chart_data()
    {
        $warehouse = $this->input->post('warehouse', true);
        $category = $this->input->post('category', true);
        $unit = $this->input->post('unit', true);
        
        $data = $this->products_alert->get_chart_data($warehouse, $category, $unit);
        echo json_encode($data);
    }

    public function update_alert_qty()
    {
        $pid = $this->input->post('pid', true);
        $alert_qty = $this->input->post('alert_qty', true);
        $reason = $this->input->post('reason', true);
        
        if (!$pid || !$alert_qty) {
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
            return;
        }
        
        $result = $this->products_alert->update_alert_quantity($pid, $alert_qty, $reason);
        
        if ($result) {
            // Log the action
            $this->aauth->applog("[Alert Updated] Product ID: $pid, New Alert Qty: $alert_qty, Reason: $reason", 
                                $this->aauth->get_user()->username);
            
            echo json_encode(['success' => true, 'message' => 'Alert quantity updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update alert quantity']);
        }
    }

    public function get_product_details()
    {
        $pid = $this->input->post('pid', true);
        if (!$pid) {
            echo json_encode(['success' => false, 'message' => 'Invalid Product ID']);
            return;
        }
        $product = $this->products_alert->get_product_details($pid);
        
        if ($product) {
            $alert_level = $this->calculate_alert_level($product['qty'], $product['alert']);
            $product['alert_status'] = ucfirst($alert_level);
            $product['status_class'] = ($alert_level == 'critical' ? 'danger' : ($alert_level == 'warning' ? 'warning' : ($alert_level == 'info' ? 'info' : 'success')));
            
            echo json_encode(['success' => true, 'data' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
    }

    public function export_alerts_csv()
    {
        // Get filter parameters
        $warehouse = $this->input->post('warehouse', true);
        $category = $this->input->post('category', true);
        $subcategory = $this->input->post('subcategory', true);
        $alert_level = $this->input->post('alert_level', true);
        $minus_qty = $this->input->post('minus_qty', true);
        $unit = $this->input->post('unit', true);
        
        $alerts = $this->products_alert->get_alerts_for_export($warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit);
        
        $filename = 'stock_alerts_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF"); // UTF-8 BOM
        
        // Headers
        $headers = [
            'Product ID', 'Product Name', 'Product Code', 'Warehouse',
            'Category', 'Subcategory', 'Current Quantity', 'Alert Quantity',
            'Difference', 'Alert Level', 'Status', 'Last Updated'
        ];
        fputcsv($output, $headers);
        
        // Data rows
        foreach ($alerts as $alert) {
            $alert_level = $this->calculate_alert_level($alert['qty'], $alert['alert']);
            
            $row = [
                $alert['pid'],
                $alert['product_name'],
                $alert['product_code'] ?? '',
                $alert['warehouse_name'] ?? 'N/A',
                $alert['category_name'] ?? 'N/A',
                $alert['subcategory_name'] ?? 'N/A',
                (float)$alert['qty'],
                (float)$alert['alert'],
                (float)$alert['qty'] - (float)$alert['alert'],
                $alert_level,
                $this->get_status_text($alert_level, $alert['qty'], $alert['alert']),
                $alert['updated_at'] ?? date('Y-m-d H:i:s')
            ];
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }

    public function test_alerts()
    {
        $head['title'] = "Test Alert System";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $this->load->view('fixed/header', $head);
        $this->load->view('products/test_alerts');
        $this->load->view('fixed/footer');
    }

    public function run_alert_test()
    {
        $test_type = $this->input->post('test_type', true);
        
        switch ($test_type) {
            case 'critical':
                $result = $this->products_alert->test_critical_alerts();
                break;
            case 'warning':
                $result = $this->products_alert->test_warning_alerts();
                break;
            case 'all':
                $result = $this->products_alert->test_all_alerts();
                break;
            default:
                $result = ['success' => false, 'message' => 'Invalid test type'];
        }
        
        echo json_encode($result);
    }

    private function calculate_alert_level($current_qty, $alert_qty)
    {
        if ($current_qty < $this->alert_thresholds['critical']) {
            return 'critical';
        } elseif ($current_qty < $this->alert_thresholds['warning']) {
            return 'warning';
        } elseif ($current_qty < $this->alert_thresholds['info']) {
            return 'info';
        } else {
            return 'normal';
        }
    }

    private function get_status_html($alert_level, $current_qty, $alert_qty)
    {
        switch ($alert_level) {
            case 'critical':
                $color = 'danger';
                $text = 'Critical';
                $icon = 'ft-alert-triangle';
                $progress = ($current_qty < 0) ? 0 : ($current_qty / 10) * 100;
                break;
            case 'warning':
                $color = 'warning';
                $text = 'Warning';
                $icon = 'ft-alert-circle';
                $progress = (($current_qty - 10) / 10) * 100;
                break;
            case 'info':
                $color = 'info';
                $text = 'Low';
                $icon = 'ft-info';
                $progress = (($current_qty - 20) / 10) * 100;
                break;
            default:
                $color = 'success';
                $text = 'Normal';
                $icon = 'ft-check-circle';
                $progress = 100;
        }
        
        $progress = min(100, max(0, $progress));
        
        return '
        <div class="alert-status">
            <span class="badge badge-' . $color . '">
                <i class="' . $icon . '"></i> ' . $text . '
            </span>
            <div class="progress mt-1" style="height: 5px;">
                <div class="progress-bar bg-' . $color . '" 
                     role="progressbar" 
                     style="width: ' . $progress . '%" 
                     aria-valuenow="' . $progress . '" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>
        </div>';
    }

    private function get_status_text($alert_level, $current_qty, $alert_qty)
    {
        switch ($alert_level) {
            case 'critical': return 'Critical (<10)';
            case 'warning': return 'Warning (10-20)';
            case 'info': return 'Low (20-30)';
            default: return 'Normal (>30)';
        }
    }

    private function get_action_buttons($pid, $pcat, $sub_id)
    {
        return '
        <div class="btn-group">
            <a target="_blank" href="' . site_url('products/edit?id=' . $pid) . '"
               class="btn-action bg-primary-soft text-primary"
               style="width: 28px; height: 28px; background: rgba(255,255,255,0.9);"
               title="Product Editing">
                <i class="ft-edit"></i>
            </a>
            <a target="_blank" href="' . site_url('products/woodcut?id=' . $pid . '&pcat=' . $pcat . '&pcat_sub_id=' . $sub_id) . '"
                class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center"
                style="width: 28px; height: 28px; background: rgba(255,255,255,0.9);"
                title="Wood Cuting" onclick="event.stopPropagation();">
                <i class="icon-pencil text-dark" style="font-size: 12px;"></i>
            </a>
                <a target="_blank" href="' . site_url('productcategory/edit?id=' . $sub_id) . '"
                class="btn btn-sm btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center"
                style="width: 28px; height: 28px; background: rgba(250, 250, 250, 0.9);"
                title="Product Price Editing" onclick="event.stopPropagation();">
                <i class="icon-pencil text-dark" style="font-size: 12px;"></i>
            </a>
            <button type="button"
                    class="btn-action bg-warning-soft text-warning edit-alert"
                    data-pid="' . $pid . '"
                    title="Update Alert">
                <i class="ft-bell"></i>
            </button>
            <button type="button"
                    class="btn-action bg-info-soft text-info view-details"
                    data-pid="' . $pid . '"
                    title="Details">
                <i class="ft-maximize"></i>
            </button>
        </div>';
    }

    public function fix_unit_typo()
    {
        $this->db->where('unit', 'cubi');
        $this->db->update('geopos_products', ['unit' => 'cubic']);
        echo "Updated " . $this->db->affected_rows() . " products.";
    }
}
