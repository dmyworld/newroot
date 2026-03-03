<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WhatsApp_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plugins_model', 'plugins');
    }

    /**
     * Send a plain text WhatsApp message.
     * 
     * @param string $to Number with country code.
     * @param string $message The message content.
     * @return array Status and Response.
     */
    public function send_message($to, $message)
    {
        // Fetch WhatsApp Gateway settings from geopos_plugins (ID 10 for WhatsApp)
        $whatsapp_service = $this->plugins->universal_api(10);

        if (!$whatsapp_service['active']) {
            return array('status' => 'Error', 'message' => 'WhatsApp Service is Disabled');
        }

        $api_url = $whatsapp_service['url'];
        $api_key = $whatsapp_service['key1'];
        $instance_id = $whatsapp_service['key2'];

        // Preparing data for a generic HTTP-based WhatsApp Gateway (e.g., UltraMsg, Wati, etc.)
        $data = array(
            'token' => $api_key,
            'to' => $to,
            'body' => $message
        );

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return array('status' => 'Error', 'message' => 'CURL Error: ' . $err);
        }

        return array('status' => 'Success', 'response' => json_decode($response, true));
    }

    /**
     * Send a template-based message.
     * 
     * @param string $to Number with country code.
     * @param int $template_id Template ID from geopos_templates.
     * @param array $template_data Data for parser.
     */
    public function send_template($to, $template_id, $template_data)
    {
        $this->load->model('templates_model', 'templates');
        $this->load->library('parser');

        $template = $this->templates->template_info($template_id);
        if (!$template) return false;

        $message = $this->parser->parse_string($template['other'], $template_data, TRUE);
        return $this->send_message($to, $message);
    }
}
