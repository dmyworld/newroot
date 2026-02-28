<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| TimberPro Configuration
|--------------------------------------------------------------------------
*/

// Google Vision API Key for AI OCR
$config['google_vision_api_key'] = 'YOUR_GOOGLE_VISION_API_KEY_HERE';

// Government Transit Permit Templates
$config['permit_template_path'] = FCPATH . 'userfiles/templates/transit_permit_template.xlsx';

// OCR Confidence Threshold
$config['ocr_min_confidence'] = 0.5;
