<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TimberPro_AI_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->config->load('timberpro');
    }

    /**
     * Scan an image for timber log dimensions using Google Vision API
     * @param string $image_path Local path to the uploaded image
     * @return array Extracted dimensions (length, girth)
     */
    public function scan_log_dimensions($image_path)
    {
        $api_key = $this->config->item('google_vision_api_key');
        if ($api_key == 'YOUR_GOOGLE_VISION_API_KEY_HERE') {
            return array('status' => 'Error', 'message' => 'Google Vision API Key not configured.');
        }

        $image_data = base64_encode(file_get_contents($image_path));
        
        $payload = array(
            'requests' => array(
                array(
                    'image' => array('content' => $image_data),
                    'features' => array(
                        array('type' => 'TEXT_DETECTION')
                    )
                )
            )
        );

        $url = 'https://vision.googleapis.com/v1/images:annotate?key=' . $api_key;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return array('status' => 'Error', 'message' => 'CURL Error: ' . $error);
        }

        $result = json_decode($response, true);
        if (isset($result['responses'][0]['textAnnotations'])) {
            $full_text = $result['responses'][0]['textAnnotations'][0]['description'];
            return $this->parse_dimensions($full_text);
        }

        return array('status' => 'Error', 'message' => 'No text detected in image.');
    }

    /**
     * Parse raw OCR text to identify dimensions
     * Simple heuristic: find numbers that look like L x G or just a list of numbers
     */
    private function parse_dimensions($text)
    {
        // Find all numbers with decimals
        preg_match_all('/\d+(\.\d+)?/', $text, $matches);
        $numbers = $matches[0];

        if (count($numbers) >= 2) {
            return array(
                'status' => 'Success',
                'length' => $numbers[0],
                'girth' => $numbers[1],
                'raw_text' => $text
            );
        }

        return array('status' => 'Partial', 'raw_text' => $text, 'message' => 'Could not reliably identify dimensions.');
    }
}
