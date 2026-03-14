<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        $this->load->model('Marketing_model', 'marketing');
    }

    public function index()
    {
        $head['title'] = "Marketing Engine";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['fb_config'] = $this->marketing->get_fb_config();
        $data['wa_config'] = $this->marketing->get_wa_config();
        $data['revid_config'] = $this->marketing->get_revid_config();
        $data['active_lots'] = $this->marketing->get_active_lots();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/marketing', $data);
        $this->load->view('fixed/footer');
    }

    public function save_wa_link()
    {
        $number = $this->input->post('wa_number');
        $this->marketing->save_wa_config($number);
        echo json_encode(array('status' => 'Success', 'message' => 'WhatsApp link updated!'));
    }

    public function generate_poster()
    {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        
        if (!$id || !$type) {
             echo json_encode(array('status' => 'Error', 'message' => 'Missing ID or Type'));
             return;
        }

        $result = $this->marketing->generate_lot_poster($id, $type);
        echo json_encode($result);
    }

    public function share_modal($type, $id)
    {
        $this->load->model('Marketplace_model', 'marketplace');
        $data['lot'] = $this->marketplace->get_lot_details($id, $type);
        $data['type'] = $type;
        $data['id'] = $id;

        // Ensure poster is generated
        $res = $this->marketing->generate_lot_poster($id, $type);
        $data['poster_url'] = ($res['status'] == 'Success') ? $res['poster_url'] : '';
        $this->load->view('timber/share_modal', $data);
    }

    public function save_fb_link()
    {
        $id = $this->input->post('fb_id');
        $token = $this->input->post('token');
        $this->marketing->save_fb_config($id, $token);
        echo json_encode(array('status' => 'Success', 'message' => 'Facebook link updated!'));
    }

    public function broadcast()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $groups = $this->input->post('groups');
        $result = $this->marketing->broadcast_lot($id, $type, $groups);
        echo json_encode($result);
    }

    public function save_revid_link()
    {
        $id = $this->input->post('revid_id');
        $token = $this->input->post('token');
        $this->marketing->save_revid_config($id, $token);
        echo json_encode(array('status' => 'Success', 'message' => 'Revid AI link updated!'));
    }

    public function generate_ai_video()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        if (!$id || !$type) {
            echo json_encode(array('status' => 'Error', 'message' => 'Missing ID or Type'));
            return;
        }
        $result = $this->marketing->generate_ai_video($id, $type);
        echo json_encode($result);
    }

    public function revid_webhook()
    {
        // Handle Revid AI Webhook for completed renders
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        
        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);

        error_log("REVID WEBHOOK: Lot $id ($type) - Status: " . @$data['status']);

        if ($id && $type && isset($data['status']) && $data['status'] == 'completed' && isset($data['url'])) {
            $table = '';
            switch ($type) {
                case 'logs': $table = 'geopos_timber_logs'; break;
                case 'standing': $table = 'geopos_timber_standing'; break;
                case 'sawn': $table = 'geopos_timber_sawn'; break;
                case 'machinery': $table = 'geopos_timber_machinery'; break;
            }

            if ($table) {
                $this->db->where('id', $id);
                $this->db->update($table, array('revid_video_url' => $data['url']));
                error_log("REVID WEBHOOK: Updated $table ID $id with video URL.");
            }
        }
        
        http_response_code(200);
    }
}
