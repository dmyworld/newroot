<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rbac_Migration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->dbforge();
        // Temporarily disabled for initial migration via CURL
        /*
        if (!$this->input->is_cli_request() && (!$this->aauth->is_loggedin() || $this->aauth->get_user()->roleid != 5)) {
            exit('Unauthorized');
        }
        */
    }

    public function index() {
        echo "<pre>";
        echo "Starting RBAC Migration...\n";

        // 1. rbac_modules
        echo "Creating rbac_modules...\n";
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'title' => ['type' => 'VARCHAR', 'constraint' => 100],
            'code' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => TRUE],
            'icon' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE],
            'sort_order' => ['type' => 'INT', 'constraint' => 5, 'default' => 0]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('rbac_modules', TRUE);

        // 2. rbac_pages
        echo "Creating rbac_pages...\n";
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'module_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'title' => ['type' => 'VARCHAR', 'constraint' => 100],
            'code' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => TRUE],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'sort_order' => ['type' => 'INT', 'constraint' => 5, 'default' => 0]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('rbac_pages', TRUE);

        // 3. rbac_actions
        echo "Creating rbac_actions...\n";
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'name' => ['type' => 'VARCHAR', 'constraint' => 50], // View, Add, Edit, Delete
            'code' => ['type' => 'VARCHAR', 'constraint' => 20]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('rbac_actions', TRUE);

        // 4. rbac_permissions
        echo "Creating rbac_permissions...\n";
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'page_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'action_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'perm_key' => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('rbac_permissions', TRUE);

        // 5. rbac_role_permissions
        echo "Creating rbac_role_permissions...\n";
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'role_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'permission_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('rbac_role_permissions', TRUE);

        echo "Seeding basic actions...\n";
        $actions = [
            ['name' => 'View', 'code' => 'view'],
            ['name' => 'Add', 'code' => 'add'],
            ['name' => 'Edit', 'code' => 'edit'],
            ['name' => 'Delete', 'code' => 'delete']
        ];
        foreach ($actions as $action) {
            $q = $this->db->get_where('rbac_actions', ['code' => $action['code']]);
            if ($q->num_rows() == 0) $this->db->insert('rbac_actions', $action);
        }

        echo "Migration Finished!\n";
        echo "</pre>";
    }
}
