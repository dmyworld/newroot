<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Marketing_model', 'marketing');
    }

    public function index()
    {
        $head['title'] = "Marketing Engine";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['fb_config'] = $this->marketing->get_fb_config();
        $data['wa_config'] = $this->marketing->get_wa_config();
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
}
