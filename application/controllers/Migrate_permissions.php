<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate_permissions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }

    public function index()
    {
        $this->load->dbforge();
        echo "<h1>Starting Migration...</h1>";

        // 1. Create geopos_roles table
        echo "Creating geopos_roles table...<br>";
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'all_access' => array(
                 'type' => 'INT',
                 'constraint' => 1,
                 'default' => 0
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_roles', TRUE);

        // 2. Create geopos_modules table
        echo "Creating geopos_modules table...<br>";
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_modules', TRUE);
        
        // 3. Create geopos_role_permissions table
        echo "Creating geopos_role_permissions table...<br>";
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
             'module_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'can_view' => array(
                 'type' => 'INT',
                 'constraint' => 1,
                 'default' => 0
            ),
            'can_add' => array(
                 'type' => 'INT',
                 'constraint' => 1,
                 'default' => 0
            ),
            'can_edit' => array(
                 'type' => 'INT',
                 'constraint' => 1,
                 'default' => 0
            ),
             'can_delete' => array(
                 'type' => 'INT',
                 'constraint' => 1,
                 'default' => 0
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geopos_role_permissions', TRUE);


        // 4. Populate Roles
        echo "Populating Roles...<br>";
        // Based on existing system role IDs appear to be:
        // 1=Inventory Manager, 2=Sales Person, 3=Sales Manager, 4=Business Manager, 5=Business Owner, 6=Project Manager
        // -1 might also be used for Project Manager in some logical checks? But Database shows r_6 as Project Manager in view
        // Let's create them explicitly with IDs matching typical flow or just auto-increment and map.
        // Actually, let's look at geopos_users.roleid mapping.
        // Typically: 5=Owner, 4=BizManager, 3=SalesManager, 2=SalesPerson, 1=Inventory.
        
        $roles = [
            1 => 'Inventory Manager',
            2 => 'Sales Person',
            3 => 'Sales Manager',
            4 => 'Business Manager',
            5 => 'Business Owner',
            6 => 'Project Manager'
        ];

        foreach($roles as $id => $name) {
             // Check if exists
             $q = $this->db->get_where('geopos_roles', array('id' => $id));
             if($q->num_rows() == 0) {
                 $data = array('id' => $id, 'name' => $name);
                 if($id == 5) $data['all_access'] = 1;
                 $this->db->insert('geopos_roles', $data);
             }
        }

        // 5. Migrate Modules and Permissions
        echo "Migrating Permissions...<br>";
        
        $old_perms = $this->db->get('geopos_premissions')->result_array();
        
        // Map old role columns to role IDs
        // The view shows:
        // r_1 => Inventory Manager (Role ID 1?)
        // r_2 => Sales Person (Role ID 2?)
        // r_3 => Sales Manager (Role ID 3?)
        // r_4 => Business Manager (Role ID 4?)
        // r_5 => Business Owner (Role ID 5?)
        // r_6 => Project Manager (Role ID 6?)
        
        // Wait, let's verify column mapping from application/views/employee/permissions.php
        /*
            <th>Inventory Manager</th>
            <th>Sales Person</th>
            <th>Sales Manager</th>
            <th>Business Manager</th>
            <th>Business Owner</th>
            <th>Project Manager</th>
            
            ...
             <td><input type="checkbox" name="r_<?= $i ?>_1" ... ></td>  (Col 1: Inventory Manager)
             <td><input type="checkbox" name="r_<?= $i ?>_2" ... ></td>  (Col 2: Sales Person)
             ...
        */
        // So r_X_1 corresponds to Role 1, r_X_2 to Role 2, etc. Perfect.
        
        foreach ($old_perms as $row) {
            $module_id = $row['id'];
            $module_name = $row['module'];
            
            // Insert Module if not exists
            $q = $this->db->get_where('geopos_modules', array('id' => $module_id));
            if($q->num_rows() == 0) {
                 $this->db->insert('geopos_modules', array(
                     'id' => $module_id, 
                     'name' => $module_name,
                     'code' => url_title(strtolower($module_name), '_', TRUE) 
                 ));
            }
            
            // Migrate Role Permissions
            for($r=1; $r<=6; $r++) {
                $col_name = 'r_' . $r; // e.g., r_1 
                
                // In the old table, columns are named r_1, r_2, etc. ?
                // Let's check the schema dump... actually I couldn't run the dump.
                // But in Employee.php lines 538+, it constructs names: $name1 = 'r_' . $i . '_1'; 
                // Wait, that's the POST name.
                // The DB update code: $data = array('r_1' => $val1, ...);
                // So the DB columns are r_1, r_2, r_3, r_4, r_5, r_6.
                
                if (isset($row[$col_name]) && $row[$col_name] == 1) {
                    // Check if already exists to avoid duplicates if run multiple times
                    $exists = $this->db->get_where('geopos_role_permissions', array('role_id' => $r, 'module_id' => $module_id));
                    if($exists->num_rows() == 0) {
                        $this->db->insert('geopos_role_permissions', array(
                            'role_id' => $r,
                            'module_id' => $module_id,
                            'can_view' => 1,
                            'can_add' => 1,
                            'can_edit' => 1,
                            'can_delete' => 1
                        ));
                    }
                }
            }
        }
        
        echo "<h1>Migration Completed Successfully!</h1>";
        echo "<p>Next steps: Update Aauth library to use the new tables.</p>";
    }
}
