<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rbac_Seed_All extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("Aauth");
    }

    public function index() {
        echo "<pre>";
        echo "Starting RBAC Seeding for ALL Controllers...\n";

        // Read the JSON file we generated
        $json_file = FCPATH . 'controller_methods.json';
        if (!file_exists($json_file)) {
            die("Error: controller_methods.json not found!\n");
        }
        
        $data = json_decode(file_get_contents($json_file), true);

        // Standard actions
        $actions = $this->db->get('rbac_actions')->result_array();
        
        $count_modules = 0;
        $count_pages = 0;

        foreach ($data as $controller => $methods) {
            $m_code = url_title(strtolower($controller), '_', TRUE);
            $module_title = ucfirst($controller);
            
            // Upsert Module
            $q = $this->db->get_where('rbac_modules', ['code' => $m_code]);
            if ($q->num_rows() == 0) {
                $this->db->insert('rbac_modules', [
                    'title' => $module_title,
                    'code' => $m_code,
                    'icon' => 'fa-puzzle-piece' // Default icon
                ]);
                $module_id = $this->db->insert_id();
                $count_modules++;
            } else {
                $module_id = $q->row()->id;
            }

            foreach ($methods as $method) {
                $p_code = url_title(strtolower($controller . '_' . $method), '_', TRUE);
                $page_title = ucfirst($method);
                $page_url = strtolower($controller) . '/' . strtolower($method);
                
                // If the method is index, the url can just be the controller
                if (strtolower($method) === 'index') {
                    $page_url = strtolower($controller);
                }
                
                // Upsert Page
                $qp = $this->db->get_where('rbac_pages', ['code' => $p_code]);
                if ($qp->num_rows() == 0) {
                    $this->db->insert('rbac_pages', [
                        'module_id' => $module_id,
                        'title' => $page_title,
                        'code' => $p_code,
                        'url' => $page_url
                    ]);
                    $page_id = $this->db->insert_id();
                    $count_pages++;
                } else {
                    $page_id = $qp->row()->id;
                }

                // Create default Permissions for this page (View, Add, Edit, Delete)
                foreach ($actions as $action) {
                    $perm_key = $p_code . '_' . $action['code'];
                    $qe = $this->db->get_where('rbac_permissions', ['perm_key' => $perm_key]);
                    if ($qe->num_rows() == 0) {
                        $this->db->insert('rbac_permissions', [
                            'page_id' => $page_id,
                            'action_id' => $action['id'],
                            'perm_key' => $perm_key
                        ]);
                    }
                }
            }
        }

        echo "Seeding Finished!\n";
        echo "Newly Inserted Modules: $count_modules\n";
        echo "Newly Inserted Pages: $count_pages\n";
        echo "</pre>";
    }
}
