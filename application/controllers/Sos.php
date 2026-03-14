<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('sos_model', 'sos');
        
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Not logged in']);
            exit;
        }
        if (!($this->aauth->get_user()->roleid == 1 || $this->aauth->premission(7))) {
            echo json_encode(['status' => 'Error', 'message' => 'Insufficient permissions']);
            exit;
        }
    }

    /**
     * Trigger SOS Alert
     */
    public function trigger()
    {
        $user_id = $this->aauth->get_user()->id;
        $lat = $this->input->post('lat', true);
        $lng = $this->input->post('lng', true);

        if (!$lat || !$lng) {
            echo json_encode(['status' => 'Error', 'message' => 'GPS coordinates required for SOS.']);
            return;
        }

        $res = $this->sos->trigger_sos($user_id, $lat, $lng);
        
        if ($res) {
            echo json_encode(['status' => 'Success', 'message' => 'SOS Alert broadcasted successfully.']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to broadcast SOS.']);
        }
    }

    /**
     * Resolve SOS Alert (Admin/Manager only)
     */
    public function resolve()
    {
        $user_id = $this->aauth->get_user()->id;
        $alert_id = $this->input->post('alert_id', true);

        if (!$alert_id) {
            echo json_encode(['status' => 'Error', 'message' => 'Missing alert ID.']);
            return;
        }

        $res = $this->sos->resolve_alert($alert_id, $user_id);
        
        if ($res) {
            echo json_encode(['status' => 'Success', 'message' => 'SOS Alert resolved.']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to resolve SOS.']);
        }
    }

    /**
     * Poll for active alerts (Admin dashboard)
     */
    public function poll_alerts()
    {
        $alerts = $this->sos->get_active_alerts();
        echo json_encode(['status' => 'Success', 'alerts' => $alerts]);
    }
}
