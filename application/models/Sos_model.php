<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_check_tables();
    }

    private function _check_tables()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('geopos_sos_alerts')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'user_id' => array('type' => 'INT', 'constraint' => 11),
                'lat' => array('type' => 'DECIMAL', 'constraint' => '10,8', 'null' => TRUE),
                'lng' => array('type' => 'DECIMAL', 'constraint' => '11,8', 'null' => TRUE),
                'status' => array('type' => 'ENUM("active", "resolved")', 'default' => 'active'),
                'resolved_by' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE),
                'created_at' => array('type' => 'DATETIME'),
                'resolved_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_sos_alerts', TRUE);
            $this->db->query("ALTER TABLE `geopos_sos_alerts` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        }
    }

    public function trigger_sos($user_id, $lat, $lng)
    {
        $data = [
            'user_id' => $user_id,
            'lat' => $lat,
            'lng' => $lng,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('geopos_sos_alerts', $data);
    }

    public function get_active_alerts()
    {
        $this->db->select('s.*, emp.name as user_name, emp.phone');
        $this->db->from('geopos_sos_alerts s');
        $this->db->join('geopos_employees emp', 's.user_id = emp.id', 'left');
        $this->db->where('s.status', 'active');
        $this->db->order_by('s.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function resolve_alert($alert_id, $resolved_by)
    {
        $this->db->where('id', $alert_id);
        return $this->db->update('geopos_sos_alerts', [
            'status' => 'resolved',
            'resolved_by' => $resolved_by,
            'resolved_at' => date('Y-m-d H:i:s')
        ]);
    }
}
