<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_assets_loc_update extends CI_Controller
{
    public function index()
    {
        $this->load->dbforge();

        // Add loc column to geopos_assets
        $fields = array(
            'loc' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            )
        );
        $this->dbforge->add_column('geopos_assets', $fields);

        echo "Assets Table Updated with Location Column Successfully. You can delete this file now.";
    }
}
