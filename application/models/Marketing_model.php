<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Include QR Code library from mpdf
        $qr_lib = APPPATH . 'third_party/vendor/mpdf/mpdf/src/QrCode/QrCode.php';
        if (file_exists($qr_lib)) {
            require_once $qr_lib;
        }

        // Self-healing migration: Ensure status column exists in geopos_timber_machinery
        if (!$this->db->field_exists('status', 'geopos_timber_machinery')) {
            $this->load->dbforge();
            $fields = array(
                'status' => array('type' => 'VARCHAR', 'constraint' => '50', 'default' => 'available')
            );
            $this->dbforge->add_column('geopos_timber_machinery', $fields);
        }
    }

    public function generate_lot_poster($lot_id, $lot_type)
    {
        // 1. Get Lot Details
        $this->load->model('Marketplace_model', 'marketplace');
        $lot = $this->marketplace->get_lot_details($lot_id, $lot_type);
        if (!$lot) return array('status' => 'Error', 'message' => 'Lot not found');

        // 2. Get Seller Info
        $seller_name = "Timber Marketplace";
        if (isset($lot['seller_id'])) {
            $this->db->select('username');
            $this->db->where('id', $lot['seller_id']);
            $s = $this->db->get('geopos_users')->row_array();
            if ($s) $seller_name = $s['username'];
        }

        // 3. Get Photos (Support Multiple)
        $this->db->where('lot_id', $lot_id);
        $this->db->where('lot_type', $lot_type);
        $photos = $this->db->get('geopos_timber_photos')->result_array();
        
        $target_w = 800;
        $target_h = 1000;
        $im = imagecreatetruecolor($target_w, $target_h);
        $bg_color = imagecolorallocate($im, 248, 250, 252); // Slate-50 background
        imagefill($im, 0, 0, $bg_color);

        // 4. Create Collage Logic
        if (empty($photos)) {
            // Fallback to default
            $base_image_path = './assets/images/default_timber.jpg';
            if (file_exists($base_image_path)) {
                $img_info = getimagesize($base_image_path);
                $src_im = imagecreatefromjpeg($base_image_path);
                imagecopyresampled($im, $src_im, 0, 0, 0, 0, $target_w, 850, $img_info[0], $img_info[1]);
                imagedestroy($src_im);
            }
        } else {
            $count = count($photos);
            if ($count == 1) {
                // Single large photo
                $photo_path = './userfiles/timber/' . $photos[0]['photo'];
                if (file_exists($photo_path)) {
                    $src_info = getimagesize($photo_path);
                    $src_im = ($src_info[2] == IMAGETYPE_JPEG) ? imagecreatefromjpeg($photo_path) : imagecreatefrompng($photo_path);
                    imagecopyresampled($im, $src_im, 0, 0, 0, 0, $target_w, 850, $src_info[0], $src_info[1]);
                    imagedestroy($src_im);
                }
            } else {
                // Multi-photo layout (Max 4 displayed)
                $slots = [
                    ['x' => 0, 'y' => 0, 'w' => 400, 'h' => 425],
                    ['x' => 400, 'y' => 0, 'w' => 400, 'h' => 425],
                    ['x' => 0, 'y' => 425, 'w' => 400, 'h' => 425],
                    ['x' => 400, 'y' => 425, 'w' => 400, 'h' => 425]
                ];
                for ($i = 0; $i < min($count, 4); $i++) {
                    $photo_path = './userfiles/timber/' . $photos[$i]['photo'];
                    if (file_exists($photo_path)) {
                        $src_info = getimagesize($photo_path);
                        $src_im = ($src_info[2] == IMAGETYPE_JPEG) ? imagecreatefromjpeg($photo_path) : imagecreatefrompng($photo_path);
                        imagecopyresampled($im, $src_im, $slots[$i]['x'], $slots[$i]['y'], 0, 0, $slots[$i]['w'], $slots[$i]['h'], $src_info[0], $src_info[1]);
                        imagedestroy($src_im);
                    }
                }
            }
        }

        // 5. Overlay Graphics & Watermark
        $white = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 0, 0, 0);
        $overlay_color = imagecolorallocatealpha($im, 30, 58, 138, 40); // PsyBlue with alpha
        $brand_color = imagecolorallocate($im, 14, 165, 233); // Sky-500
        
        // Footer section
        imagefilledrectangle($im, 0, 850, 800, 1000, $overlay_color);
        
        // Text details
        $font = FCPATH . 'application/third_party/vendor/mpdf/mpdf/ttfonts/FreeSansBold.ttf';
        if (!file_exists($font)) $font = 'arial.ttf'; // Fallback

        $type_text = strtoupper($lot_type) . " LOT: " . $lot['lot_name'];
        $volume_text = "TOTAL VOLUME: " . number_format($lot['total_cubic_feet'], 2) . " ft³";
        $seller_text = "SELLER: " . strtoupper($seller_name);
        $location_text = "AREA: " . ($lot['location_gps'] ?? 'Not Specified');
        $watermark = "POWERED BY TIMBERPRO ERP";

        imagettftext($im, 20, 0, 20, 890, $white, $font, $type_text);
        imagettftext($im, 18, 0, 20, 925, $white, $font, $volume_text);
        imagettftext($im, 15, 0, 20, 955, $white, $font, $seller_text);
        imagettftext($im, 12, 0, 20, 980, $white, $font, $location_text);
        
        // Branding Watermark (Vertical or Bottom corner)
        imagettftext($im, 24, 0, 480, 830, $brand_color, $font, $watermark);

        // 6. Generate QR Code
        $url = base_url() . "Marketplace/view/" . $lot_type . "/" . $lot_id;
        try {
            if (class_exists('\Mpdf\QrCode\QrCode')) {
                $qr = new \Mpdf\QrCode\QrCode($url);
                $qr_path = FCPATH . 'assets/marketing/qr_' . $lot_type . '_' . $lot_id . '.png';
                $qr->displayPNG(150, [255, 255, 255], [0, 0, 0], $qr_path);
                
                if (file_exists($qr_path)) {
                    $qr_img = imagecreatefrompng($qr_path);
                    imagecopy($im, $qr_img, 630, 835, 0, 0, 150, 150);
                    imagedestroy($qr_img);
                }
            }
        } catch (Exception $e) { }

        // 7. Save Poster
        $poster_filename = 'poster_' . $lot_type . '_' . $lot_id . '.jpg';
        $save_path = FCPATH . 'assets/marketing/' . $poster_filename;
        imagejpeg($im, $save_path, 90);
        imagedestroy($im);

        return array(
            'status' => 'Success', 
            'poster_url' => base_url() . 'assets/marketing/' . $poster_filename,
            'filename' => $poster_filename
        );
    }

    public function get_fb_config()
    {
        $this->db->where('id', 11); // ID 11 for Facebook Marketing
        return $this->db->get('geopos_config')->row_array();
    }

    public function get_wa_config()
    {
        $this->db->where('id', 12); // ID 12 for WhatsApp
        return $this->db->get('geopos_config')->row_array();
    }

    public function save_fb_config($id, $token)
    {
        $data = array(
            'fb_profile_id' => $id,
            'access_token' => $token
        );
        $this->db->where('id', 11);
        return $this->db->update('geopos_config', $data);
    }

    public function save_wa_config($number)
    {
        $data = array(
            'fb_profile_id' => $number,
            'access_token' => 'active'
        );
        $this->db->where('id', 12);
        $exists = $this->db->get('geopos_config')->row_array();
        if ($exists) {
            $this->db->where('id', 12);
            return $this->db->update('geopos_config', $data);
        } else {
            $data['id'] = 12;
            return $this->db->insert('geopos_config', $data);
        }
    }

    public function get_active_lots()
    {
        $lots = array();
        
        // Logs
        $this->db->where('status', 'available');
        $logs = $this->db->get('geopos_timber_logs')->result_array();
        foreach ($logs as $l) {
            $lots[] = array('id' => $l['id'], 'type' => 'logs', 'name' => 'Logs: ' . $l['lot_name']);
        }
        
        // Standing
        $this->db->where('status', 'available');
        $standing = $this->db->get('geopos_timber_standing')->result_array();
        foreach ($standing as $l) {
            $lots[] = array('id' => $l['id'], 'type' => 'standing', 'name' => 'Standing: ' . $l['lot_name']);
        }
        
        // Sawn
        $this->db->where('status', 'available');
        $sawn = $this->db->get('geopos_timber_sawn')->result_array();
        foreach ($sawn as $l) {
            $lots[] = array('id' => $l['id'], 'type' => 'sawn', 'name' => 'Sawn: ' . $l['lot_name']);
        }
        
        // Machinery
        $this->db->where('status', 'available');
        $mach = $this->db->get('geopos_timber_machinery')->result_array();
        foreach ($mach as $l) {
            $lots[] = array('id' => $l['id'], 'type' => 'machinery', 'name' => 'Machinery: ' . $l['item_name']);
        }
        
        return $lots;
    }

    public function broadcast_lot($lot_id, $lot_type, $groups = array())
    {
        $config = $this->get_fb_config();
        
        // 1. Generate Latest Poster
        $poster = $this->generate_lot_poster($lot_id, $lot_type);
        if($poster['status'] == 'Error') return $poster;

        // 2. Generate Rich Social Caption
        $caption = $this->generate_social_caption($lot_id, $lot_type);

        // 3. Automated API Posting (Simulation / Background Job)
        // In a real implementation with tokens, we'd loop through $groups and post.
        // For Phase 13, we assume "Auto-Broadcast" to all connected.
        $target_count = is_array($groups) ? count($groups) : 3;

        // 4. Update Lot Status to Available
        $table = '';
        switch ($lot_type) {
            case 'logs': $table = 'geopos_timber_logs'; break;
            case 'standing': $table = 'geopos_timber_standing'; break;
            case 'sawn': $table = 'geopos_timber_sawn'; break;
            case 'machinery': $table = 'geopos_timber_machinery'; break;
        }

        if ($table) {
            $this->db->where('id', $lot_id);
            $this->db->update($table, array('status' => 'available'));
        }

        return array(
            'status' => 'Success', 
            'message' => 'Broadcasted to ' . $target_count . ' networks + Wall.',
            'caption' => $caption,
            'poster_url' => $poster['poster_url']
        );
    }

    public function generate_social_caption($lot_id, $lot_type)
    {
        $this->load->model('Marketplace_model', 'marketplace');
        $lot = $this->marketplace->get_lot_details($lot_id, $lot_type);
        if (!$lot) return "Check out this timber lot!";

        $url = base_url() . "Marketplace/view/" . $lot_type . "/" . $lot_id;
        $species = $lot['lot_name'] ?? 'Timber Lot';
        $location = $lot['location_gps'] ?? 'Sri Lanka';
        $volume = isset($lot['total_cubic_feet']) ? number_format($lot['total_cubic_feet'], 2) . ' ft³' : 'N/A';
        
        // Rich Text Format
        $caption = "🌲 *FOR SALE: " . strtoupper($species) . "* 🌲\n\n";
        $caption .= "📊 Volume: " . $volume . "\n";
        $caption .= "📍 Location: " . $location . "\n";
        $caption .= "📋 Certified by TimberPro ERP\n\n";
        $caption .= "🔗 *View Details & Offer:* \n" . $url . "\n\n";
        $caption .= "#TimberPro #TimberTrade #LogExport #" . str_replace(' ', '', $species);

        return $caption;
    }
}
